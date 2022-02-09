<?php
    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class Franchise_products extends MY_Controller {

        function __construct() {
            parent::__construct();
            check_user_login(TRUE);
            $this->load->model('franchise_products_model', 'franchise_products');
        }

        function index()
        {
            $data['meta_title']             = "Franchise Products";
            $data['meta_description']       = "Franchise Products";
            $data['meta_keywords']          = "Franchise Products";
            $data['page_title']             = "Franchise Products";
            $data['module']                 = "Franchise Products";
            $data['menu']                   = "franchise_products";
            $data['submenu']                = "list";
            $data['childmenu']              = "";
            $data['loggedin']               = "yes";

            $this->breadcrumbs->push(1, 'Franchise Products', franchise_products_constants::franchise_products_url);
            $this->breadcrumbs->unshift(2, 'List', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            $data['content']                = "franchise_products/index";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function ajax_list()
        {
            $condition          = ['fp.status !' => '-1'];
            $list               = $this->franchise_products->get_data($condition, '', '', '');
            $tabledata          = [];
            $no                 = isset($_GET['offset']) ? $_GET['offset'] : 0;

            foreach ($list as $key => $value) {
                if(isset($value->created_on) && !empty($value->created_on) && $value->created_on !== '0000-00-00 00:00:00')
                {
                    $created_on = date($this->config->item('default_date_time_format'), strtotime($value->created_on));
                }
                else
                {
                    $created_on = 'NA';
                }

                $status         = '';
                if($value->status == 1)
                {
                    $status     = '<a class="text-black" href="javascript:void(0);" onclick="change_status('.$value->id.', 0, this);" data-type="product" data-function="'.base_url().franchise_products_constants::change_franchise_product_status_url.'"><span class="badge badge-success">Active</span></a>';
                }
                else if($value->status == 0)
                {
                    $status     = '<a class="text-black" href="javascript:void(0);" onclick="change_status('.$value->id.', 1, this);" data-type="product" data-function="'.base_url().franchise_products_constants::change_franchise_product_status_url.'"><span class="badge badge-danger">In-Active</span></a>';
                }

                $action         = '
                                    <span class="dropdown action-dropdown d-flex justify-content-center">
                                        <button id="btnSearchDrop'.$key.'" type="button" class="btn btn-sm btn-icon btn-pure font-medium-2" data-toggle="dropdown" aria-haspopup="true"
                                         aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <span aria-labelledby="btnSearchDrop'.$key.'" class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" title="Edit" href="'.base_url().franchise_products_constants::edit_franchise_product_url.'/'.$value->id.'">Edit</a>
                                            <a class="dropdown-item" title="Delete" href="javascript:void(0);" onclick="change_status('.$value->id.', -1, this);" data-type="product" data-function="'.base_url().franchise_products_constants::change_franchise_product_status_url.'">Delete</a>
                                        </span>
                                    </span>
                                ';

                $view           = '<a class="" href="'.base_url().franchise_products_constants::edit_franchise_product_url.'/'.$value->id.'" title="Edit '.$value->name.'">'.$value->name.'</a>';

                $no++;
                $row                                            = [];
                $row['sr_no']                                   = $no;
                $row['id']                                      = $value->id;
                $row['name']                                    = $view;
                $row['hsn_sac']                                 = $value->hsn_sac;
                $row['mrp']                                     = $value->mrp;
                $row['opening_stock']                           = $value->opening_stock;
                $row['d_p']                                     = $value->d_p;
                $row['b_v']                                     = $value->b_v;
                $row['status']                                  = $status;
                $row['created_on']                              = $created_on;
                $row['action']                                  = $action;
            
                $tabledata[]                                    = $row;
            }

            $output             = array(
                                        "total"      => $this->franchise_products->get_data($condition, '', '', 'allcount'),
                                        "rows"       => $tabledata,
                                    );

            echo json_encode($output);
        }

        private function form_validation_rules($data=[])
        {
            $this->form_validation->set_rules('name', 'Name', 'required|max_length[191]|trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('mrp', 'Mrp', 'required|numeric|greater_than[0.99]|regex_match[/^[0-9.]+$/]|trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('opening_stock', 'Opening Stock', 'required|numeric|regex_match[/^[0-9.]+$/]|trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('p_code', 'P. Code', 'trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('hsn_sac', 'HSN/SAC', 'trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('d_p', 'D. p.', 'trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('b_v', 'B. V.', 'trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('description', 'Description', 'trim|xss_clean|strip_tags');
            if(isset($_POST['cgst']) && !empty($_POST['cgst']))
            {
                $this->form_validation->set_rules('cgst', 'CGST', 'numeric|greater_than[0.99]|regex_match[/^[0-9.]+$/]|trim|xss_clean|strip_tags');
            }
            if(isset($_POST['sgst']) && !empty($_POST['sgst']))
            {
                $this->form_validation->set_rules('sgst', 'SGST', 'numeric|greater_than[0.99]|regex_match[/^[0-9.]+$/]|trim|xss_clean|strip_tags');
            }
            if(isset($_POST['igst']) && !empty($_POST['igst']))
            {
                $this->form_validation->set_rules('igst', 'IGST', 'numeric|greater_than[0.99]|regex_match[/^[0-9.]+$/]|trim|xss_clean|strip_tags');
            }
            $this->form_validation->set_rules('status', 'Status', 'required');
        }

        function add()
        {
            $data['meta_title']             = "Add Product";
            $data['meta_description']       = "Add Product";
            $data['meta_keywords']          = "Add Product";
            $data['page_title']             = "Add Product";
            $data['module']                 = "Franchise Products";
            $data['menu']                   = "franchise_products";
            $data['submenu']                = "add";
            $data['childmenu']              = "";
            $data['loggedin']               = "yes";
            $data['id']                     = "";
            $data['post_data']              = [];
            $data['post_data']['status']    = 1;

            $this->form_validation_rules($data);

            if($this->input->post())
            {
                $data['post_data']          = $this->input->post();
            }

            if($this->form_validation->run($this) === TRUE)
            {
                if($this->input->post())
                {
                    $response               = $this->franchise_products->save('', $this->security->xss_clean($this->input->post()));
                    $this->session->set_flashdata('status', $response);
                    redirect(base_url().franchise_products_constants::franchise_products_url);
                }
            }

            $this->breadcrumbs->push(1, 'Franchise Products', franchise_products_constants::franchise_products_url);
            $this->breadcrumbs->unshift(2, 'Add', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            $data['content']                = "franchise_products/form";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function edit($id='')
        {
            $response = ['error' => 1, 'message' => 'Invalid request'];
            if(!empty($id))
            {
                $data['meta_title']         = "Edit Product";
                $data['meta_description']   = "Edit Product";
                $data['meta_keywords']      = "Edit Product";
                $data['page_title']         = "Edit Product";
                $data['module']             = "Franchise Products";
                $data['menu']               = "franchise_products";
                $data['submenu']            = "list";
                $data['childmenu']          = "";
                $data['loggedin']           = "yes";
                $data['id']                 = $id;
                $data['post_data']          = [];

                $this->form_validation_rules($data);

                if($this->form_validation->run($this) === TRUE)
                {
                    if($this->input->post())
                    {
                        $response           = $this->franchise_products->save($id, $this->security->xss_clean($this->input->post()));
                        $this->session->set_flashdata('status', $response);
                        redirect(base_url().franchise_products_constants::franchise_products_url);
                    }
                }

                if($this->input->post())
                {
                    $data['post_data']      = $this->input->post();
                }
                else
                {
                    $data['post_data']      = $this->franchise_products->get_details($id);

                    if(empty($data['post_data']))
                    {
                        $this->session->set_flashdata('status', ['error' => 1, 'message' => 'Product not found']);
                        redirect(base_url().franchise_products_constants::franchise_products_url);
                    }
                }

                $this->breadcrumbs->push(1, 'Franchise Products', franchise_products_constants::franchise_products_url);
                $this->breadcrumbs->unshift(2, 'Edit', '#');
                $data['breadcrumb']          = $this->breadcrumbs->show();

                $data['content']             = "franchise_products/form";
                echo Modules::run("templates/".$this->config->item('theme'), $data);
            }
            else
            {
                $this->session->set_flashdata('status', $response);
                redirect(base_url().franchise_products_constants::franchise_products_url);
            }
        }

        function change()
        {
            $response       = ['error' => 1, 'message' => 'Access denied'];

            if(isset($_POST) && !empty($_POST))
            {
                $id         = isset($_POST['id']) ? $_POST['id'] : '';
                $type       = isset($_POST['type']) ? $_POST['type'] : '';
                $status     = isset($_POST['status']) ? $_POST['status'] : '';

                $details    = $this->franchise_products->get_details($id);

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

                    if($this->franchise_products->change($id, $status))
                    {
                        $response   = ['error' => 0, 'message' => ucfirst($type).' successfully '.$message];
                    }
                    else
                    {
                        $response   = ['error' => 1, 'message' => 'Unable to perform this action'];
                    }
                }
                else
                {
                    $response   = ['error' => 1, 'message' => 'No '.$type.' found'];
                }
            }
            echo json_encode($response);
        }
    }