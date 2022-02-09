<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Dashboard extends MY_Controller {
        function __construct() {
            parent::__construct();
            check_user_login(TRUE);
            $this->load->model('dashboard_model', 'dashboard');
        }

        function index() {
            $data['meta_title'] 		= "Dashboard";
    		$data['meta_description'] 	= "Dashboard";
    		$data['meta_keywords'] 		= "Dashboard";
            $data['page_title']         = "Dashboard";
            $data['module']             = "Dashboard";
            $data['menu']               = "dashboard";
            $data['submenu']            = "dashboard";
            $data['childmenu']          = "dashboard";
    		$data['loggedin'] 			= "yes";
            $data['franchise']          = [
                                            'active'    => $this->dashboard->get_count(
                                                                                        ['status' => 1],
                                                                                        franchise_table::sql_table_franchise
                                                                                    ),
                                            'inactive'  => $this->dashboard->get_count(
                                                                                        ['status' => 0],
                                                                                        franchise_table::sql_table_franchise
                                                                                    ),
                                        ];
            $data['products']           = [
                                            'active'    => $this->dashboard->get_count(
                                                                                        ['status' => 1],
                                                                                        franchise_products_table::sql_tbl_franchise_products
                                                                                    ),
                                            'inactive'  => $this->dashboard->get_count(
                                                                                        ['status' => 0],
                                                                                        franchise_products_table::sql_tbl_franchise_products
                                                                                    ),
                                        ];
            $data['orders']             = [
                                            'completed' => $this->dashboard->get_count(
                                                                                        ['status' => 1, 'order_status' => ['approved', 'delivered']],
                                                                                        orders_table::sql_tbl_franchise_orders
                                                                                    ),
                                            'pending'   => $this->dashboard->get_count(
                                                                                        ['status' => 1, 'order_status' => ['pending']],
                                                                                        orders_table::sql_tbl_franchise_orders
                                                                                    ),
                                        ];
            $data['order_summary']      = [
                                            'total_d_p' => $this->dashboard->get_sum(
                                                                                        ['status' => 1, 'order_status' => ['approved', 'delivered']],
                                                                                        orders_table::sql_tbl_franchise_orders,
                                                                                        'total_d_p'
                                                                                    ),
                                            'total_b_v' => $this->dashboard->get_sum(
                                                                                        ['status' => 1, 'order_status' => ['approved', 'delivered']],
                                                                                        orders_table::sql_tbl_franchise_orders,
                                                                                        'total_b_v'
                                                                                    ),
                                            'total_quantity' => $this->dashboard->get_sum(
                                                                                        ['status' => 1, 'order_status' => ['approved', 'delivered']],
                                                                                        orders_table::sql_tbl_franchise_orders,
                                                                                        'total_quantity'
                                                                                    ),
                                            'total_gst' => $this->dashboard->get_sum(
                                                                                        ['status' => 1, 'order_status' => ['approved', 'delivered']],
                                                                                        orders_table::sql_tbl_franchise_orders,
                                                                                        'total_gst'
                                                                                    ),
                                            'service_charge' => $this->dashboard->get_sum(
                                                                                        ['status' => 1, 'order_status' => ['approved', 'delivered']],
                                                                                        orders_table::sql_tbl_franchise_orders,
                                                                                        'service_charge'
                                                                                    ),
                                            'final_d_p' => $this->dashboard->get_sum(
                                                                                        ['status' => 1, 'order_status' => ['approved', 'delivered']],
                                                                                        orders_table::sql_tbl_franchise_orders,
                                                                                        'final_d_p'
                                                                                    ),
                                        ];
            $data['announcements']      = [
                                            'active'    => $this->dashboard->get_count(
                                                                                        ['status' => 1],
                                                                                        announcements_table::sql_tbl_announcements
                                                                                    ),
                                            'inactive'  => $this->dashboard->get_count(
                                                                                        ['status' => 0],
                                                                                        announcements_table::sql_tbl_announcements
                                                                                    ),
                                        ];
            $data['news']               = [
                                            'active'    => $this->dashboard->get_count(
                                                                                        ['status' => 1],
                                                                                        news_table::sql_tbl_news
                                                                                    ),
                                            'inactive'  => $this->dashboard->get_count(
                                                                                        ['status' => 0],
                                                                                        news_table::sql_tbl_news
                                                                                    ),
                                        ];

            $this->breadcrumbs->unshift(1, 'Dashboard', dashboard_constants::dashboard_url);
            $data['breadcrumb']         = $this->breadcrumbs->show();

    		$data['content']            = "dashboard/index";
    		echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function welcome()
        {
            $save                       = [];
            $save['franchise_name']     = 'ABC';
            $save['email']              = 'kiranj1992@gmail.com';
            $save['mobile']             = '8097905740';
            $save['password']           = 'Admin@123';
            $html                       = $this->load->view('emailers/welcome-franchise', $save, true);
            // echo $html;exit;

            $email_data                 = [
                                            'to'            => [
                                                                [
                                                                    'name'  => 'ABC',
                                                                    'email' => 'kiranj1992@gmail.com'
                                                                ]
                                                            ],
                                            'cc'            => [],
                                            'bcc'           => [],
                                            'subject'       => 'Welcome To Myheaven',
                                            'message'       => $html,
                                            'altbody'       => '',
                                            'attachments'   => [],
                                            'html'          => true,
                                        ];

            Modules::run("php_mailer/send", $email_data);
        }
    }