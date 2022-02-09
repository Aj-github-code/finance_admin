<?php
    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class Directs extends MY_Controller {

        function __construct() {
            parent::__construct();
            check_user_login(TRUE);
            $this->load->model('directs_model', 'directs');
        }

        function index()
        {
            $data['meta_title']             = "Directs";
            $data['meta_description']       = "Directs";
            $data['meta_keywords']          = "Directs";
            $data['page_title']             = "Directs";
            $data['module']                 = "Directs";
            $data['menu']                   = "Directs";
            $data['submenu']                = "directs";
            $data['childmenu']              = "";
            $data['loggedin']               = "yes";

            $this->breadcrumbs->unshift(1, 'Directs', directs_constants::directs_url);
            $this->breadcrumbs->unshift(2, 'List', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            $data['content']                = "directs/index";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function ajax_list()
        {
            $list               = $this->directs->get_data('', '', '', '');
            $no                 = isset($_GET['offset']) ? $_GET['offset'] : 0;

            foreach ($list as $key => $value) {


                $no++;
                $row                                            = [];
                $row['sr_no']                                   = $no;
                $row['ownid']                                   = $value->ownid;
                $row['t_left']                                  = $value->totalleft;
                $row['t_right']                                 = $value->totalright;
                $row['t_unit_left']                             = $value->totalunitleft;
                $row['t_unit_right']                            = $value->totalunitright;
                $row['t_used_left']                             = $value->totalusedunitleft;
                $row['t_used_right']                            = $value->totalusedunitright;
                $row['name']                                    = $value->firstname.' '.$value->lastname;
                $row['total']                                   = $value->totalunitright+$value->totalunitleft;
                $row['avl_right']                               = $value->totalunitleft-$value->totalusedunitleft;
                $row['avl_left']                                = $value->totalunitright-$value->totalusedunitright;
            
                $tabledata[]                                    = $row;
            }

            $output             = array(
                                        "total"      => $this->directs->get_data('', '', '', 'allcount'),
                                        "rows"       => $tabledata,
                                    );

            echo json_encode($output);
        }

        
    }
?>