<?php
    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class Product_categories extends MY_Controller {

        function __construct() {
            parent::__construct();
            check_user_login(TRUE);
            $this->load->model('product_categories_model', 'product_categories');
        }

        function index()
        {
            $data['meta_title']             = "Product Categories";
            $data['meta_description']       = "Product Categories";
            $data['meta_keywords']          = "Product Categories";
            $data['page_title']             = "Product Categories";
            $data['module']                 = "Product Categories";
            $data['menu']                   = "products";
            $data['submenu']                = "categories";
            $data['childmenu']              = "list";
            $data['loggedin']               = "yes";

            $this->breadcrumbs->push(1, 'Products', product_constants::products_url);
            $this->breadcrumbs->unshift(2, 'Product Categories', product_constants::product_categories_url);
            $this->breadcrumbs->unshift(3, 'List', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            $data['content']                = "products/categories/index";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function ajax_list()
        {
            $condition          = ['c.status !' => '-1'];
            $list               = $this->product_categories->get_data($condition, '', '', '');
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
                    $status     = '<a class="text-black" href="javascript:void(0);" onclick="change_status('.$value->id.', 0, this);" data-type="product category" data-function="'.base_url().product_constants::change_product_category_status_url.'"><span class="badge badge-success">Active</span></a>';
                }
                else if($value->status == 0)
                {
                    $status     = '<a class="text-black" href="javascript:void(0);" onclick="change_status('.$value->id.', 1, this);" data-type="product category" data-function="'.base_url().product_constants::change_product_category_status_url.'"><span class="badge badge-danger">In-Active</span></a>';
                }

                $action = '
                            <span class="dropdown action-dropdown d-flex justify-content-center">
                                <button id="btnSearchDrop'.$key.'" type="button" class="btn btn-sm btn-icon btn-pure font-medium-2" data-toggle="dropdown" aria-haspopup="true"
                                 aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <span aria-labelledby="btnSearchDrop'.$key.'" class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" title="Edit" href="'.base_url().product_constants::edit_product_category_url.'/'.$value->id.'">Edit</a>
                                    <a class="dropdown-item" title="Delete" href="javascript:void(0);" onclick="change_status('.$value->id.', -1, this);" data-type="product category" data-function="'.base_url().product_constants::change_product_category_status_url.'">Delete</a>
                                </span>
                            </span>
                        ';

                $view   = '<a class="" href="'.base_url().product_constants::edit_product_category_url.'/'.$value->id.'" title="Edit '.$value->name.'">'.$value->name.'</a>';

                $no++;
                $row                                            = [];
                $row['sr_no']                                   = $no;
                $row['id']                                      = $value->id;
                $row['name']                                    = $view;
                $row['description']                             = $value->description;
                $row['order']                                   = $value->order;
                $row['parent_category_name']                    = $value->parent_category_name;
                $row['status']                                  = $status;
                $row['created_on']                              = $created_on;
                $row['action']                                  = $action;
            
                $tabledata[]                                    = $row;
            }

            $output             = array(
                                        "total"      => $this->product_categories->get_data($condition, '', '', 'allcount'),
                                        "rows"       => $tabledata,
                                    );

            echo json_encode($output);
        }

        private function form_validation_rules($data=[])
        {
            $this->form_validation->set_rules('name', 'Category name', 'required|max_length[100]|trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('category_id', 'Parent Category', 'trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('description', 'Description', 'trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('thumbnail', 'Thumbnail', 'trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('status', 'Status', 'required');
        }

        function add()
        {
            $data['meta_title']             = "Add Product Category";
            $data['meta_description']       = "Add Product Category";
            $data['meta_keywords']          = "Add Product Category";
            $data['page_title']             = "Add Product Category";
            $data['module']                 = "Product Categories";
            $data['menu']                   = "products";
            $data['submenu']                = "categories";
            $data['childmenu']              = "add";
            $data['loggedin']               = "yes";
            $data['id']                     = "";
            $data['post_data']              = [];
            $data['post_data']['order']     = 0;
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
                    $response               = $this->product_categories->save('', $this->security->xss_clean($this->input->post()));
                    $this->session->set_flashdata('status', $response);
                    redirect(base_url().product_constants::product_categories_url);
                }
            }

            $this->breadcrumbs->push(1, 'Products', product_constants::products_url);
            $this->breadcrumbs->unshift(2, 'Product Categories', product_constants::product_categories_url);
            $this->breadcrumbs->unshift(3, 'Add', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            $data['content']                = "products/categories/form";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function edit($id='')
        {
            $response = ['error' => 1, 'message' => 'Access denied'];
            if(!empty($id))
            {
                $data['meta_title']         = "Edit Product Category";
                $data['meta_description']   = "Edit Product Category";
                $data['meta_keywords']      = "Edit Product Category";
                $data['page_title']         = "Edit Product Category";
                $data['module']             = "Product Categories";
                $data['menu']               = "products";
                $data['submenu']            = "categories";
                $data['childmenu']          = "add";
                $data['loggedin']           = "yes";
                $data['id']                 = $id;
                $data['post_data']          = [];
                $data['post_data']['order'] = 0;

                $this->form_validation_rules($data);

                if($this->form_validation->run($this) === TRUE)
                {
                    if($this->input->post())
                    {
                        $response           = $this->product_categories->save($id, $this->security->xss_clean($this->input->post()));
                        $this->session->set_flashdata('status', $response);
                        redirect(base_url().product_constants::product_categories_url);
                    }
                }

                if($this->input->post())
                {
                    $data['post_data']      = $this->input->post();
                }
                else
                {
                    $data['post_data']      = $this->product_categories->get_details($id);

                    if(empty($data['post_data']))
                    {
                        $this->session->set_flashdata('status', ['error' => 1, 'message' => 'Product category not found']);
                        redirect(base_url().product_constants::product_categories_url);
                    }
                    $data['post_data']['category_id'] = $data['post_data']['parent_id'];
                }

                $this->breadcrumbs->push(1, 'Products', product_constants::products_url);
                $this->breadcrumbs->unshift(2, 'Product Categories', product_constants::product_categories_url);
                $this->breadcrumbs->unshift(3, 'Edit', '#');
                $data['breadcrumb']             = $this->breadcrumbs->show();

                $data['content']                = "products/categories/form";
                echo Modules::run("templates/".$this->config->item('theme'), $data);
            }
            else
            {
                $this->session->set_flashdata('status', $response);
                redirect(base_url().product_constants::product_categories_url);
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

                $details    = $this->product_categories->get_details($id);

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

                    if($this->product_categories->change($id, $status))
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

        function get_parent_category()
        {
            return $this->product_categories->get_all_categories(['parent_id' => '']);
        }

        function get_category_options()
        {
            $categories      = $this->product_categories->get_all_categories($this->input->get());

            $options            = '<option value="">-- Select Product Category --</option>';
            foreach ($categories as $key => $value) {
                $selected       = '';
                if(isset($_GET['category_id']) && !empty($_GET['category_id']) && $_GET['category_id'] == $value['id'])
                {
                    $selected   = 'selected="selected"';
                }
                $options        .= '<option value="'.$value['id'].'" '.$selected.'>'.$value['name'].'</option>';
            }

            echo json_encode($options);
        }

        function get_categories_options()
        {
            $categories      = $this->product_categories->get_all_categories($this->input->get());
            // echo "<pre>";print_r($this->input->get());exit();
            $options            = '';
            foreach ($categories as $key => $value) {
                $selected       = '';
                if(isset($_GET['category_id']) && !empty($_GET['category_id']) && $_GET['category_id'] == $value['id'])
                {
                    $selected   = 'selected="selected"';
                }
                $options        .= '<option value="'.$value['id'].'" '.$selected.'>'.$value['name'].'</option>';
            }

            echo json_encode($options);
        }
        
        function get_multi_categories_options()
        {
            $categories      = $this->product_categories->get_all_categories($this->input->get());
            // echo "<pre>";print_r($this->input->get());exit();
            $options            = '';
            foreach ($categories as $key => $value) {
                $selected       = '';
                $category_id = explode(",",$_GET['category_id']);
                // print_r($category_id);
                if(isset($_GET['category_id']) && !empty($_GET['category_id']))
                {
                    if (in_array($value['id'], $category_id)){
                        $selected   = 'selected="selected"';
                    }
                }
                $options        .= '<option value="'.$value['id'].'" '.$selected.'>'.$value['name'].'</option>';
            }

            echo json_encode($options);
        }
    }