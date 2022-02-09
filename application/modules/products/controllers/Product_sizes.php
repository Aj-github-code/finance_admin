<?php
    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class Product_sizes extends MY_Controller {

        function __construct() {
            parent::__construct();
            check_user_login(TRUE);
            $this->load->model('product_sizes_model', 'product_sizes');
        }

        function index()
        {
            $data['meta_title']             = "Product Sizes";
            $data['meta_description']       = "Product Sizes";
            $data['meta_keywords']          = "Product Sizes";
            $data['page_title']             = "Product Sizes";
            $data['module']                 = "Product Sizes";
            $data['menu']                   = "products";
            $data['submenu']                = "sizes";
            $data['childmenu']              = "list";
            $data['loggedin']               = "yes";

            $this->breadcrumbs->push(1, 'Products', product_constants::products_url);
            $this->breadcrumbs->unshift(2, 'Product Sizes', product_constants::product_sizes_url);
            $this->breadcrumbs->unshift(3, 'List', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            $data['content']                = "products/sizes/index";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function ajax_list()
        {
            $condition          = ['s.status !' => '-1'];
            $list               = $this->product_sizes->get_data($condition, '', '', '');
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
                    $status     = '<a class="text-black" href="javascript:void(0);" onclick="change_status('.$value->id.', 0, this);" data-type="product size" data-function="'.base_url().product_constants::change_product_size_status_url.'"><span class="badge badge-success">Active</span></a>';
                }
                else if($value->status == 0)
                {
                    $status     = '<a class="text-black" href="javascript:void(0);" onclick="change_status('.$value->id.', 1, this);" data-type="product size" data-function="'.base_url().product_constants::change_product_size_status_url.'"><span class="badge badge-danger">In-Active</span></a>';
                }

                $action = '
                            <span class="dropdown action-dropdown d-flex justify-content-center">
                                <button id="btnSearchDrop'.$key.'" type="button" class="btn btn-sm btn-icon btn-pure font-medium-2" data-toggle="dropdown" aria-haspopup="true"
                                 aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <span aria-labelledby="btnSearchDrop'.$key.'" class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" title="Edit" href="'.base_url().product_constants::edit_product_size_url.'/'.$value->id.'">Edit</a>
                                    <a class="dropdown-item" title="Delete" href="javascript:void(0);" onclick="change_status('.$value->id.', -1, this);" data-type="product size" data-function="'.base_url().product_constants::change_product_size_status_url.'">Delete</a>
                                </span>
                            </span>
                        ';

                $view   = '<a class="" href="'.base_url().product_constants::edit_product_size_url.'/'.$value->id.'" title="Edit '.$value->name.'">'.$value->name.'</a>';

                $no++;
                $row                                            = [];
                $row['sr_no']                                   = $no;
                $row['id']                                      = $value->id;
                $row['name']                                    = $view;
                $row['size_tags']                               = $this->getSizeTags($value->id,'list_param');
                $row['status']                                  = $status;
                $row['created_on']                              = $created_on;
                $row['action']                                  = $action;

                $tabledata[]                                    = $row;
            }
            $output             = array(
                                        "total"      => $this->product_sizes->get_data($condition, '', '', 'allcount'),
                                        "rows"       => $tabledata,
                                    );

            echo json_encode($output);
        }

        private function form_validation_rules($data=[])
        {
            $this->form_validation->set_rules('name', 'Size name', 'required|max_length[100]|trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('status', 'Status', 'required|trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('tags', 'Tags', 'callback_non_empty_tags[tags]');
        }

        function add()
        {
            $data['meta_title']             = "Add Product Size";
            $data['meta_description']       = "Add Product Size";
            $data['meta_keywords']          = "Add Product Size";
            $data['page_title']             = "Add Product Size";
            $data['module']                 = "Product Sizes";
            $data['menu']                   = "products";
            $data['submenu']                = "sizes";
            $data['childmenu']              = "add";
            $data['loggedin']               = "yes";
            $data['id']                     = "";
            $data['post_data']              = [];
            $data['post_data']['status']    = 1;
            $data['tags']                   = [];

            $this->form_validation_rules($data);

            if($this->input->post())
            {
                $data['post_data']          = $this->input->post();
            }

            if($this->form_validation->run($this) === TRUE)
            {
                if($this->input->post())
                {
                    $response               = $this->product_sizes->save('', $this->security->xss_clean($this->input->post()));
                    $this->session->set_flashdata('status', $response);
                    redirect(base_url().product_constants::product_sizes_url);
                }
            }

            $this->breadcrumbs->push(1, 'Products', product_constants::products_url);
            $this->breadcrumbs->unshift(2, 'Product Sizes', product_constants::product_sizes_url);
            $this->breadcrumbs->unshift(3, 'Add', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            $data['content']                = "products/sizes/form";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function edit($id='')
        {
            $response = ['error' => 1, 'message' => 'Access denied'];
            if(!empty($id))
            {
                $data['meta_title']         = "Edit Product Size";
                $data['meta_description']   = "Edit Product Size";
                $data['meta_keywords']      = "Edit Product Size";
                $data['page_title']         = "Edit Product Size";
                $data['module']             = "Product Sizes";
                $data['menu']               = "products";
                $data['submenu']            = "sizes";
                $data['childmenu']          = "add";
                $data['loggedin']           = "yes";
                $data['id']                 = $id;
                $data['post_data']          = [];

                $this->form_validation_rules($data);

                if($this->form_validation->run($this) === TRUE)
                {
                    if($this->input->post())
                    {
                        $response           = $this->product_sizes->save($id, $this->security->xss_clean($this->input->post()));
                        $this->session->set_flashdata('status', $response);
                        redirect(base_url().product_constants::product_sizes_url);
                    }
                }

                if($this->input->post())
                {
                    $data['post_data']      = $this->input->post();
                }
                else
                {
                    $data['post_data']      = $this->product_sizes->get_details($id);
                    $data['tags']           = $this->getSizeTags($id);
                    if(empty($data['post_data']))
                    {
                        $this->session->set_flashdata('status', ['error' => 1, 'message' => 'Product size not found']);
                        redirect(base_url().product_constants::product_sizes_url);
                    }
                }

                $this->breadcrumbs->push(1, 'Products', product_constants::products_url);
                $this->breadcrumbs->unshift(2, 'Product Sizes', product_constants::product_sizes_url);
                $this->breadcrumbs->unshift(3, 'Edit', '#');
                $data['breadcrumb']         = $this->breadcrumbs->show();
                $data['content']            = "products/sizes/form";
                echo Modules::run("templates/".$this->config->item('theme'), $data);
            }
            else
            {
                $this->session->set_flashdata('status', $response);
                redirect(base_url().product_constants::product_sizes_url);
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

                $details    = $this->product_sizes->get_details($id);

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

                    if($this->product_sizes->change($id, $status))
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

        function non_empty_tags($str, $func){
            if(empty($this->input->post('tags_val'))){
                $this->form_validation->set_message('non_empty_tags', 'Enter atleast one tag');  
                return false; 
            }
            return;
        }

        function getSizeTags($size_id, $list =''){
            $size_tags = $this->product_sizes->get_all_size_tags($size_id);
            if(!empty($size_tags)){
                if($list == 'list_param'){
                    $tag_names = array_column($size_tags, 'size_tag_name');
                    $tags = implode(",", $tag_names);
                    return $tags;
                }
                else{
                    return $tag_names = array_column($size_tags, 'size_tag_name');
                }   
            }else{
                return;
            }
        }

        function get_size_options()
        {
            $sizes              = $this->product_sizes->get_all_sizes($this->input->get());

            $options            = '<option value="">-- Select Product Size --</option>';
            foreach ($sizes as $key => $value) {
                $selected       = '';
                if(isset($_GET['size_id']) && !empty($_GET['size_id']) && $_GET['size_id'] == $value['id'])
                {
                    $selected   = 'selected="selected"';
                }
                $options        .= '<option value="'.$value['id'].'" '.$selected.'>'.$value['name'].'</option>';
            }

            echo json_encode($options);
        }

        function get_size_tag_options()
        {
            $size_tags      = $this->product_sizes->get_all_sizes_tags($this->input->get());

            $options            = '<option value="">-- Select Product Size Tag --</option>';
            foreach ($size_tags as $key => $value) {
                $selected       = '';
                if(isset($_GET['size_tag_id']) && !empty($_GET['size_tag_id']) && $_GET['size_tag_id'] == $value['id'])
                {
                    $selected   = 'selected="selected"';
                }
                $options        .= '<option value="'.$value['id'].'" '.$selected.'>'.$value['size_tag_name'].'</option>';
            }

            echo json_encode($options);
        }
    }