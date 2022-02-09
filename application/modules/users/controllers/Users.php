<?php
    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class Users extends MY_Controller {

        function __construct() {
            parent::__construct();
            check_user_login(TRUE);
            $this->load->model('users_model', 'users');
        }

        function index()
        {
            $data['meta_title']             = "Users";
            $data['meta_description']       = "Users";
            $data['meta_keywords']          = "Users";
            $data['page_title']             = "Users";
            $data['module']                 = "Users";
            $data['menu']                   = "Users";
            $data['submenu']                = "users";
            $data['childmenu']              = "";
            $data['loggedin']               = "yes";

            $this->breadcrumbs->unshift(1, 'Users', users_constants::users_url);
            $this->breadcrumbs->unshift(2, 'List', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            $data['content']                = "users/index";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function ajax_list()
        {
            $list               = $this->users->get_data('', '', '', '');
            $no                 = isset($_GET['offset']) ? $_GET['offset'] : 0;

            foreach ($list as $key => $value) {
                
                if(isset($value->createddate) && !empty($value->createddate) && $value->createddate !== '0000-00-00 00:00:00')
                {
                    $created_date = date($this->config->item('default_date_time_format'), strtotime($value->createddate));
                }
                else
                {
                    $created_date = 'NA';
                }

                if($value->kyc == 0)
                {
                    $kyc     = '<a target="_blank" href="kyc_done.php?ownid=<?php echo $row2["ownid"];?>Click for  KYC</a>';
                }
                else
                {
                    $kyc     = 'Done KYC';
                }

                if(!empty($value->image) && !empty($value->pancard_image) && !empty($value->gst_image) && !empty($value->aadhar_image) && !empty($value->aadhar_image_back)){
                
                    $kycs    = '<a target="_blank" href="../ echo $row3["image"];" >Profile Picture</a><br>
                                <a target="_blank" href="../echo $row3["pancard_image"];" >Pancard Picture</a><br>
                                <a target="_blank" href="../echo $row3["gst_image"];" >Gst Picture</a><br> 
                                <a target="_blank" href="../echo $row3["aadhar_image"];" >Aadhar front Picture</a><br> 
                                <a target="_blank" href="../echo $row3["aadhar_image_back"];" >Aadhar Back Picture</a>';
                }
                else
                {
                    $kycs    = 'Not Upload';
                }
    
                $action = '
                            <span class="dropdown action-dropdown d-flex justify-content-center">
                                <button id="btnSearchDrop'.$key.'" type="button" class="btn btn-sm btn-icon btn-pure font-medium-2" data-toggle="dropdown" aria-haspopup="true"
                                 aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <span aria-labelledby="btnSearchDrop'.$key.'" class="dropdown-menu dropdown-menu-right">';
                                $action .= '<a class="dropdown-item" title="Package" href="'.base_url().users_constants::users_package_url.'?ownid='.base64_encode($value->ownid).'">Package</a>';
                                $action .= '<a class="dropdown-item" title="Genealogy List" href="'.base_url().genealogy_constants::my_directs_url.'?userid='. base64_encode($value->ownid).'">Genealogy List</a>';
                                $action .= '<a class="dropdown-item" title="Edit" href="'.base_url().profile_constants::profile_url.'">Edit</a>';
                                $action .= '</span>
                            </span>
                        ';

                $no++;
                $row                                            = [];
                $row['sr_no']                                   = $no;
                $row['ownid']                                   = $value->ownid;
                $row['kyc']                                     = $kyc;
                $row['pin']                                     = $value->pin;
                $row['name']                                    = $value->firstname.' '.$value->lastname;
                $row['kycs']                                    = $kycs;
                $row['mobile']                                  = $value->mobile;
                $row['pin_date']                                = $value->pin_date;
                $row['password']                                = $value->password;
                $row['sponsorid']                               = $value->sponsorid;
                $row['placementid']                             = $value->placementid;
                $row['createddate']                             = $created_date;
                $row['action']                                  = $action;
            
                $tabledata[]                                    = $row;
            }

            $output             = array(
                                        "total"      => $this->users->get_data('', '', '', 'allcount'),
                                        "rows"       => $tabledata,
                                    );

            echo json_encode($output);
        }

       
        function users_package()
        {
            $data['meta_title']             = "Users Package";
            $data['meta_description']       = "Users Package";
            $data['meta_keywords']          = "Users Package";
            $data['page_title']             = "Users Package";
            $data['module']                 = "Users Package";
            $data['menu']                   = "Users Package";
            $data['submenu']                = "package";
            $data['childmenu']              = "";
            $data['loggedin']               = "yes";

            $this->breadcrumbs->unshift(1, 'Users', users_constants::users_url);
            $this->breadcrumbs->unshift(2, 'Package', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            if(!empty($_GET['ownid']))
            {
                $user                       = $_GET['ownid'];
                $userid                     = base64_decode($user);
            }
            else{
                $userid                     = 'ROOT';
            }
            $list = $this->users->get_details($userid);
            $data['list'] = $list;
            $data['message'] = $this->packages($list);

            $data['content']                = "users/form";
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

                    $row = $this->users->get_detail($ownid);

                    // print_r(json_encode($row));exit();
                    if(!empty($row['placementid']))
                    {
                        $placementid = $row['placementid'];
                        $sponsorid = $row['sponsorid'];
                        $placement = $row['placement'];
                        $amtdirect = ($pinno * 10) / 100;

                        if ($amtdirect > 0 and $sponsorid != "") {
                            $direct_data['ownid'] = $sponsorid;
                            $direct_data['by_ownid'] = $ownid;
                            $direct_data['amount'] = $amtdirect ;
                            $direct_data['date'] = $useddate;
                            $direct_data['remark'] = 'Direct Income';
                            $direct = $this->users->direct_income($direct_data);
                            $this->session->set_flashdata('status', $direct);
                            
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
        
                                $pin_ = $this->users->pv($pinno);
                                $this->update_Units($ownid, $pin_['value'], $level_now=0, $ownid);
        
                                $user_data['pin'] = $pinno;
                                $user_data['pin_date'] = $useddate;
                                $user_update = $this->users->update_user($ownid,$user_data);
                                $this->session->set_flashdata('status', $user_update);
                                $message = "Package Update Successfully!! Amount " . $pinno;
                            }
                        }
                    }
                    else{
                        $response   = ['error' => 1, 'message' => 'No user found'];
                        $this->session->set_flashdata('status', $response);
                    }

                }
                $message = "";
            }
            else
            {
                $message = "Package Already Taken!! Amount " . $pin;
            }
           
            return $message;
        }
        function update_Units($ownid, $pinno, $level_now, $own_id)
        {
            $row = $this->users->get_details($ownid);
            if ($row['placementid'] != '') {
                if ($row['placement'] == 'leftmember') {
                    $columname = 'totalunitleft';
                } else {
                    $columname = 'totalunitright';
                }
                $datetime = date("Y-m-d H:i:s");

    
                $pin_update = $this->users->pin_reference($ownid,$columname,$pinno);
                $this->session->set_flashdata('status', $pin_update);

                $insert_data['ownid'] = $row['placementid'];
                $insert_data['side'] = $columname;
                $insert_data['amount'] = $pinno;
                $insert_data['datetime'] = $datetime;
                $insert_data['by_ownid'] = $own_id;
                $insert_data['level'] = $level_now;
                $insert_data['type'] = '0';
                $insert_data['user_type'] = '0';
                $insert_left_right = $this->users->left_right($insert_data);
                $this->session->set_flashdata('status', $insert_left_right);

                $this->update_Units($row['placementid'], $pinno, $level_now, $own_id);
            }
            
        }
    }
?>