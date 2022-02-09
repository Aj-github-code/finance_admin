<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Signin extends MY_Controller {
    private $num_signin_attempts;
	private $ip_address;
	private $logged_in;
	
	function __construct() {
		parent::__construct();
		$this->load->model('signin_model', 'signin');
		$this->ip_address = $this->common_lib->get_client_ip();

		if($this->session->userdata('signin_'.$this->config->item('session_key')))
		{
			$this->logged_in = TRUE;
		}
		else
		{
			$this->logged_in = FALSE;
		}
	}

    function index() {
        if($this->logged_in === TRUE)
		{
			redirect(base_url() . dashboard_constants::dashboard_url);
		}
		else
		{
			$data['meta_title'] 		= "Sign In";
			$data['meta_description'] 	= "Sign In";
			$data['meta_keywords'] 		= "Sign In";
			$data['content']            = "signin/form";
			echo Modules::run("templates/".$this->config->item('theme'), $data);
		}
    }

    function ajax_signin()
    {
    	$response = ['error' => 1, 'message' => 'Access denied'];
    	if(strpos($this->input->post('mobile_or_email'), '@'))
		{
			$type = 'email';
			$this->form_validation->set_rules('mobile_or_email', 'E-mail id', 'required|max_length[50]|callback_custom_email[mobile_or_email]');
		}
		else
		{
			$type = 'mobile';
			$this->form_validation->set_rules('mobile_or_email', 'Mobile number', 'required|max_length[10]|callback_custom_mobile[mobile_or_email]');
		}
		if($this->input->post('signin_type') == 'password')
		{
			$this->form_validation->set_rules('password', 'Password', 'required');
		}

		if($this->form_validation->run($this) === TRUE)
		{
			$mobile_or_email= isset($_POST['mobile_or_email']) ? strtolower($_POST['mobile_or_email']) : '';
			$password 		= isset($_POST['password']) ? $_POST['password'] : '';
			$when 			= isset($_POST['when']) ? $_POST['when'] : '';
			$otp 			= isset($_POST['otp']) ? $_POST['otp'] : '';
			$signin_type 	= isset($_POST['signin_type']) ? $_POST['signin_type'] : 'password';
			$otp_type 		= $this->config->item('otp_types')['signin'];
			$response 		= $this->_validate_signin($mobile_or_email, $password, $type, $signin_type);
			$user_data 		= isset($response['user_data']) ? $response['user_data'] : [];

			if($response['error'] == 0)
			{
				if(!empty($user_data))
				{
					if($signin_type == 'password')
					{
						if($response['error'] == 0)
						{
							$this->set_user_session($user_data);
							$response = ['error' => 0, 'message' => 'You are successfully signed in, system will take you to dashboard. Please wait...'];
						}
					}
					
					if($when == 'otp')
					{
						$response = Modules::run('otp/otp/validate_otp', ['otp_type' => $otp_type, 'otp' => $otp, 'mobile_or_email' => $mobile_or_email]);

						if($response['error'] == 0)
						{
							$this->set_user_session($user_data);
							$response = ['error' => 0, 'message' => 'You are successfully signed in, system will take you to dashboard. Please wait...'];
						}
					}
				}
				else
				{
					$response = ['error' => 1, 'message' => 'User data not found'];
				}
			}
		}
		else
		{
			$errors 		= $this->form_validation->error_array();
			$response 		= ['error' => 2, 'message' => $errors];
		}
		echo json_encode($response);
    }

    private function _validate_signin($username, $password, $type, $signin_type) {
    	$response 	= ['error' => 1, 'message' => 'Invalid request'];
    	$user_signin = $this->signin->get_user_data($type, $username);

		if(count($user_signin) > 0)
		{
			$user_id 				= $user_signin['id'];
			$ownid					= $user_signin['ownid'];
			$status 				= $user_signin['status'];
			$hashed_pass 			= $user_signin['password'];

			if($status == 1)
			{
				$user_data = array(
								'id' 		=> $user_id,
								'status'	=> $status,
								'ownid'     => $ownid,
							);

				if($signin_type == 'password')
				{
					if(password_verify($password, $hashed_pass) === TRUE)
					{
						$response = ['error' => 0, 'message' => 'Success', 'user_data' => $user_data];
					}
					else
					{
						$response = ['error' => 1, 'message' => 'Invalid password'];
					}
				}
				else
				{
					$response = ['error' => 0, 'message' => 'Success', 'user_data' => $user_data];
				}
			}
			else
			{
				$response = ['error' => 1, 'message' => 'Your account is in-active state, please contact administrator'];
			}
		}
		else
		{
			$response = ['error' => 1, 'message' => 'Invalid mobile number/email id'];
		}
		return $response;
	}

	function set_user_session($user_data=[])
    {
    	if(!empty($user_data))
    	{
    		$session_data = array(
									'user_id' 			=> isset($user_data['id']) ? $user_data['id'] : '',
									'ownid'				=> isset($user_data['ownid']) ? $user_data['ownid'] : '',
									'status'			=> isset($user_data['status']) ? $user_data['status'] : '',
									'signin_'.$this->config->item('session_key') => TRUE,
									'last_activity' 	=> time(),
									'logged_in_since' 	=> time()
								);

			$this->session->set_userdata($session_data);
    	}
    	return true;
    }

	function logout() {
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('signin_'.$this->config->item('session_key'));
		$this->session->unset_userdata('logged_in_since');
		$this->session->unset_userdata('last_activity');
		$this->session->sess_destroy();
		redirect(base_url().signin_constants::signin_url);
	}

	public function custom_email($str, $func)
    {
        $this->form_validation->set_message('custom_email', 'Please enter valid e-mail id');
        return (!preg_match("".$this->config->item("email")."", $str)) ? FALSE : TRUE;
    }

    public function custom_mobile($str, $func)
    {
        $this->form_validation->set_message('custom_mobile', 'Please enter valid mobile number');
        return (!preg_match("".$this->config->item("mobile")."", $str)) ? FALSE : TRUE;
    }
}