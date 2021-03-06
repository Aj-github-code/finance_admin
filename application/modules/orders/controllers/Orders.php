<?php
    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class Orders extends MY_Controller {

        function __construct() {
            parent::__construct();
            check_user_login(TRUE);
            $this->load->model('orders_model', 'orders');
            $this->load->model('franchise/franchise_model', 'franchise');
        }

        function index()
        {
            $data['meta_title']             = "Orders";
            $data['meta_description']       = "Orders";
            $data['meta_keywords']          = "Orders";
            $data['page_title']             = "Orders";
            $data['module']                 = "Orders";
            $data['menu']                   = "orders";
            $data['submenu']                = "list";
            $data['childmenu']              = "";
            $data['loggedin']               = "yes";

            $this->breadcrumbs->push(1, 'Orders', orders_constants::orders_url);
            $this->breadcrumbs->unshift(2, 'List', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            $data['content']                = "orders/index";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function ajax_list()
        {
            $condition              = ['fo.status !' => '-1', 'f.status' => 1];
            $list                   = $this->orders->get_data($condition, '', '', '');
            $tabledata              = [];
            $no                     = isset($_GET['offset']) ? $_GET['offset'] : 0;

            foreach ($list as $key => $value) {
                if(isset($value->created_on) && !empty($value->created_on) && $value->created_on !== '0000-00-00 00:00:00')
                {
                    $created_on     = date($this->config->item('default_date_time_format'), strtotime($value->created_on));
                }
                else
                {
                    $created_on     = 'NA';
                }
                if(isset($value->processed_on) && !empty($value->processed_on) && $value->processed_on !== '0000-00-00 00:00:00')
                {
                    $processed_on   = date($this->config->item('default_date_time_format'), strtotime($value->processed_on));
                }
                else
                {
                    $processed_on   = 'NA';
                }

                $order_delete       = '
                                        <a class="text-danger m-l-10" title="Delete" href="javascript:void(0);" onclick="change_status(`'.$value->order_number.'`, -1, this);" data-type="order" data-function="'.base_url().orders_constants::change_order_status_url.'"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    ';
                $order_status       = '';
                $order_print        = '
                                        <a class="text-warning m-l-10" title="Print" href="'.base_url().orders_constants::print_order_url.'/'.$value->order_number.'" target="_blank"><i class="fa fa-print" aria-hidden="true"></i></a>
                                    ';

                if($value->order_status == 'pending')
                {
                    $order_status   = '<span class="badge badge-info">Pending</span>';
                    $order_print    = '';
                }
                else if($value->order_status == 'approved')
                {
                    $order_delete   = '';
                    $order_status   = '<span class="badge badge-success">Approved</span>';
                }
                else if($value->order_status == 'rejected')
                {
                    $order_status   = '<span class="badge badge-danger">Rejected</span>';
                    $order_print    = '';
                    $order_print    = '';
                }
                else if($value->order_status == 'delivered')
                {
                    $order_delete   = '';
                    $order_status   = '<span class="badge badge-success">Delivered</span>';
                }

                $action = '
                            <span class="d-flex justify-content-center">
                                <a class="" title="View" href="'.base_url().orders_constants::view_order_url.'/'.$value->order_number.'"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                '.$order_delete.'
                                '.$order_print.'
                            </span>
                        ';

                $view               = '<a class="" href="'.base_url().orders_constants::view_order_url.'/'.$value->order_number.'" title="View '.$value->order_number.'">'.$value->order_number.'</a>';

                $no++;
                $row                                            = [];
                $row['sr_no']                                   = $no;
                $row['id']                                      = $value->id;
                $row['franchise_name']                          = $value->franchise_name;
                $row['order_number']                            = $view;
                $row['total_amount']                            = handle_number_format($value->total_amount);
                $row['total_d_p']                               = handle_number_format($value->total_d_p);
                $row['total_quantity']                          = $value->total_quantity;
                $row['gst_rate']                                = $value->gst_rate;
                $row['total_gst']                               = handle_number_format($value->total_gst);
                $row['service_charge']                          = handle_number_format($value->service_charge);
                $row['final_d_p']                               = handle_number_format($value->final_d_p);
                $row['address']                                 = $value->address;
                $row['order_status']                            = $order_status;
                $row['message']                                 = $value->message;
                $row['processed_on']                            = $processed_on;
                $row['created_on']                              = $created_on;
                $row['action']                                  = $action;
            
                $tabledata[]                                    = $row;
            }

            $output             = array(
                                        "total"      => $this->orders->get_data($condition, '', '', 'allcount'),
                                        "rows"       => $tabledata,
                                    );

            echo json_encode($output);
        }

        function view($order_number)
        {
            $response = ['error' => 1, 'message' => 'Invalid request'];
            if(!empty($order_number))
            {
                $data['meta_title']         = "View Order";
                $data['meta_description']   = "View Order";
                $data['meta_keywords']      = "View Order";
                $data['page_title']         = "View Order";
                $data['module']             = "Orders";
                $data['menu']               = "orders";
                $data['submenu']            = "list";
                $data['childmenu']          = "";
                $data['loggedin']           = "yes";
                $data['id']                 = '';

                $data['order']              = $this->orders->get_details($order_number);
                if(!empty($data['order']))
                {
                    $order_id               = $data['order']['id'];
                    $data['id']             = $order_id;
                    $data['order_products'] = $this->orders->get_order_products($order_id);
                    // echo "<pre>";print_r($data);exit;

                    $this->breadcrumbs->push(1, 'Orders', orders_constants::orders_url);
                    $this->breadcrumbs->unshift(2, 'View', '#');
                    $data['breadcrumb']     = $this->breadcrumbs->show();

                    $data['content']        = "orders/view";
                    echo Modules::run("templates/".$this->config->item('theme'), $data);
                }
                else
                {
                    $this->session->set_flashdata('status', ['error' => 1, 'message' => 'Order not found']);
                    redirect(base_url().orders_constants::orders_url);
                }
            }
            else
            {
                $this->session->set_flashdata('status', $response);
                redirect(base_url().orders_constants::orders_url);
            }
        }

        function process()
        {
            $response                       = ['error' => 1, 'message' => 'Invalid request'];
            if(isset($_POST['order_number']) && !empty($_POST['order_number']))
            {
                $order_id                   = $_POST['order_id'];
                $order_number               = $_POST['order_number'];
                $order_status               = $_POST['order_status'];
                $order_gst_type             = $_POST['order_gst_type'];
                $message                    = $_POST['message'];
                $gst_rate                   = (!empty($_POST['gst_rate']) ? $_POST['gst_rate'] : 0);
                $service_charge             = (!empty($_POST['service_charge']) ? $_POST['service_charge'] : 0);

                $order                      = $this->orders->get_details($order_number);

                if(!empty($order))
                {
                    $order_request          = [];
                    $order_products         = $this->orders->get_order_products($order_id);
                    
                    if($order_status == 'approved')
                    {
                        $order_errors       = [];
                        foreach ($order_products as $key => $value) {
                            $product_id     = $value['product_id'];
                            $quantity       = $value['quantity'];

                            $product        = $this->orders->get_product($product_id);
                            $mrp            = $product['mrp'];
                            $stock          = $product['opening_stock'];
                            $check_quantity = $stock - $quantity;

                            if($check_quantity < 0)
                            {
                                $order_errors[] = [
                                                    'product_id'        => $product_id,
                                                    'product_name'      => $product['name'],
                                                    'product_stock'     => $stock,
                                                    'order_quantity'    => $quantity,
                                                    'error'             => 'Product stock is low',
                                                ];
                            }
                            else
                            {
                                $order_request[] = [
                                                        'product'           => $product,
                                                        'order_product_id'  => $value['id'],
                                                        'order_quantity'    => $quantity,
                                                        'order_amount'      => $value['amount'],
                                                        'order_d_p'         => $value['d_p'],
                                                        'order_b_v'         => $value['b_v'],
                                                    ];
                            }
                        }

                        if(!empty($order_errors))
                        {
                            $this->session->set_flashdata('order_errors', $order_errors);
                            redirect(base_url().orders_constants::view_order_url.'/'.$order_number);
                        }
                    }

                    $total_d_p                  = $order['total_d_p'];
                    $total_gst                  = ($total_d_p*$gst_rate)/100;
                    $final_d_p                  = $order['final_d_p']+$service_charge;//$total_d_p+$total_gst+$service_charge;

                    $update                     = [];
                    // $update['gst_rate']         = $gst_rate;
                    // $update['total_gst']        = $total_gst;
                    $update['gst_type']         = $order_gst_type;
                    $update['service_charge']   = $service_charge;
                    $update['final_d_p']        = $final_d_p;
                    $update['order_status']     = $order_status;
                    $update['message']          = $message;
                    $update['processed_on']     = date('Y-m-d H:i:s');
                    $update['processed_by']     = $this->session->userdata('user_id');
                    $update['modified_on']      = date('Y-m-d H:i:s');
                    $update['modified_by']      = $this->session->userdata('user_id');

                    $response                   = $this->orders->process($order['user_id'], $order_id, $order_number, $order_products, $order_request, $update, $order_gst_type);
                    $this->session->set_flashdata('status', $response);
                    redirect(base_url().orders_constants::view_order_url.'/'.$order_number);
                }
                else
                {
                    $this->session->set_flashdata('status', ['error' => 1, 'message' => 'Order not found']);
                    redirect(base_url().orders_constants::orders_url);
                }
            }
            else
            {
                $this->session->set_flashdata('status', $response);
                redirect(base_url().orders_constants::orders_url);
            }
        }

        function print_pdf($order_number)
        {
            $response                       = ['error' => 1, 'message' => 'Invalid request'];
            if(!empty($order_number))
            {
                $data['meta_title']         = "Print Order";
                $data['meta_description']   = "Print Order";
                $data['meta_keywords']      = "Print Order";
                $data['page_title']         = "Print Order";
                $data['module']             = "Orders";
                $data['menu']               = "orders";
                $data['submenu']            = "list";
                $data['childmenu']          = "";
                $data['loggedin']           = "yes";
                $data['id']                 = '';

                $data['order']              = $this->orders->get_details($order_number);
                
                if(!empty($data['order']))
                {
                    $order_id               = $data['order']['id'];
                    $data['id']             = $order_id;
                    $data['franchise_data'] = $this->franchise->get_details($data['order']['user_id']);
                    $data['order_products'] = $this->orders->get_order_products($order_id);
                    // echo "<pre>";print_r($data);exit;

                    $this->load->library('pdf/pdf');
                    $pdf_data               = [
                                                'mode'      => 'view',
                                                'file_name' => $order_number.'.pdf',
                                                'html'      => $this->load->view("orders/pdf/invoice", $data, true),
                                                'file_path' => ['temp', 'user_'.$this->session->userdata('user_id'), 'invoices'],
                                            ];
                    return $this->pdf->process($pdf_data);
                }
                else
                {
                    $this->session->set_flashdata('status', ['error' => 1, 'message' => 'Order not found']);
                    redirect(base_url().orders_constants::orders_url);
                }
            }
            else
            {
                $this->session->set_flashdata('status', $response);
                redirect(base_url().top_up_constants::top_up_url);
            }
        }

        function change()
        {
            $response           = ['error' => 1, 'message' => 'Invalid request'];

            if(isset($_POST) && !empty($_POST))
            {
                $order_number   = isset($_POST['id']) ? $_POST['id'] : '';
                $type           = isset($_POST['type']) ? $_POST['type'] : '';
                $status         = isset($_POST['status']) ? $_POST['status'] : '';

                $details        = $this->orders->get_details($order_number);

                if(!empty($details))
                {
                    if($status == '-1')
                    {
                        $message = 'deleted';
                    }
                    else if($status == 1)
                    {
                        $message = 'activated';
                    }
                    else if($status == 0)
                    {
                        $message = 'in-activated';
                    }

                    if($this->orders->change($order_number, $status))
                    {
                        $response= ['error' => 0, 'message' => ucfirst($type).' successfully '.$message];
                    }
                    else
                    {
                        $response= ['error' => 1, 'message' => 'Unable to perform this action'];
                    }
                }
                else
                {
                    $response   = ['error' => 1, 'message' => 'No '.$type.' found'];
                }
            }
            echo json_encode($response);
        }

        function order_count()
        {
            $conditions                     = ['status' => 1];
            if(isset($_GET['order_status']) && !empty($_GET['order_status']))
            {
                $conditions['order_status'] = [$_GET['order_status']];
            }
            $response                       = ['error' => 0, 'message' => '', 'count' => $this->orders->order_count($conditions)];
            echo json_encode($response);
        }
    }