<?php
    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class Users_re extends MY_Controller {

        function __construct() {
            parent::__construct();
            check_user_login(TRUE);
            $this->load->model('users_model', 'users');
        }
        function users_retopup()
        {
            $data['meta_title']             = "Users Re-TopUp";
            $data['meta_description']       = "Users Re-TopUp";
            $data['meta_keywords']          = "Users Re-TopUp";
            $data['page_title']             = "Users Re-TopUp";
            $data['module']                 = "Users Re-TopUp";
            $data['menu']                   = "Users Re-TopUp";
            $data['submenu']                = "re_topup";
            $data['childmenu']              = "";
            $data['loggedin']               = "yes";

            $this->breadcrumbs->unshift(1, 'Users', users_constants::users_retopup_url);
            $this->breadcrumbs->unshift(2, 'Users Re-TopUp', '#');
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
            // print_r($list['pin']);exit();
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
                                $response   = ['error' => 0, 'message' => 'Package updated'];
                                $this->session->set_flashdata('status', $response);
                                redirect(base_url().users_constants::users_free_url);
                            }
                        }
                    }
                    else{
                        $response   = ['error' => 1, 'message' => 'No Sponsor found'];
                        $this->session->set_flashdata('status', $response);
                    }

                }
            }
            else
            {$message = "Package Already Taken. Amount " . $pin;
                return $message;
            }
           
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