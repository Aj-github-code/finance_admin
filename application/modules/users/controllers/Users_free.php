<?php
    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class Users_free extends MY_Controller {

        function __construct() {
            parent::__construct();
            check_user_login(TRUE);
            $this->load->model('users_model', 'users');
        }

        function user_free()
        {
            $data['meta_title']             = "Users Free";
            $data['meta_description']       = "Users Free";
            $data['meta_keywords']          = "Users Free";
            $data['page_title']             = "Users Free";
            $data['module']                 = "Users Free";
            $data['menu']                   = "Users Free";
            $data['submenu']                = "users_free";
            $data['childmenu']              = "";
            $data['loggedin']               = "yes";

            $this->breadcrumbs->unshift(1, 'Users', users_constants::users_url);
            $this->breadcrumbs->unshift(2, 'User Free TopUp', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();


            if(!empty($_GET['userid']))
            {
                $userid                     = $_GET['userid'];
            }
            else{
                $userid                     = 'ROOT';
            }
            $list = $this->users->get_details($userid);
            $data['list'] = $list;
            $data['message'] = $this->packages($list);

            $data['content']                = "users/user_free";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function packages($list)
        {
            $pin = $list['pin'];

            if($pin!=500 || $pin!= 1000 || $pin!= 2000 || $pin != 5000 || $pin != 10000 || $pin != 20000 || $pin != 50000 || $pin != 100000 || $pin != 300000 || $pin != 500000)
            {
                if($this->input->post())
                {
                    $post_data = $this->input->post();
                    $useddate = date("Y-m-d H:i:s");
                    $ownid = htmlentities($post_data['ownid']);
                    $pinno = htmlentities($post_data['pin']);
                    if($pin!=500 || $pin!= 1000 || $pin!= 2000 || $pin != 5000 || $pin != 10000 || $pin != 20000 || $pin != 50000 || $pin != 100000 || $pin != 300000 || $pin != 500000)
                    {
                        $amount = ($pinno * 15) / 100;
                        $pin_data['ownid'] = $ownid;
                        $pin_data['pinno'] = $pinno;
                        $pin_data['type'] = $pinno;
                        $pin_data['value'] = $pinno;
                        $pin_data['generateddate'] = $useddate;
                        $pin_data['reason'] = '00';
                        $pin_data['usedid'] = '00';
                        
                        $pin_insert = $this->users->pin_table($pin_data);
                        $this->session->set_flashdata('status', $pin_insert);

                        $user_data['pin'] = $pinno;
                        $user_data['pin_date'] = $useddate;
                        $user_update = $this->users->update_user($ownid,$user_data);
                        $this->session->set_flashdata('status', $user_update);
                        $response   = ['error' => 0, 'message' => 'Package updated'];
                        $this->session->set_flashdata('status', $response);
                        redirect(base_url().users_constants::users_free_url);
                    }
                      
                    else{
                        $response   = ['error' => 1, 'message' => 'No user found'];
                        $this->session->set_flashdata('status', $response);
                    }

                }
            }
            else
            {
                $message = "Package Already Taken. Amount " . $pin;
                return $message;
            }
        }
    }
?>