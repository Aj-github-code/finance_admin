<?php
    if(!defined('BASEPATH')) exit('No direct script access allowed');

    class Products extends MY_Controller {

        function __construct() {
            parent::__construct();
            check_user_login(TRUE);
            $this->load->model('Products_model','products');
            $this->load->model('product_sizes_model', 'product_sizes');
            $this->load->model('product_colors_model', 'product_colors');
        }

        function index()
        {
            $data['meta_title']             = "Products";
            $data['meta_description']       = "Products";
            $data['meta_keywords']          = "Products";
            $data['page_title']             = "Products";
            $data['module']                 = "Products";
            $data['menu']                   = "products";
            $data['submenu']                = "products";
            $data['childmenu']              = "list";
            $data['loggedin']               = "yes";

            $this->breadcrumbs->push(1, 'Products', product_constants::products_url);
            $this->breadcrumbs->unshift(2, 'List', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            $data['content']                = "products/products/index";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function ajax_list()
        {
            $condition          = ['p.status !' => '-1'];
            $list               = $this->products->get_data($condition, '', '', '');
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
                    $status     = '<a class="text-black" href="javascript:void(0);" onclick="change_status('.$value->id.', 0, this);" data-type="product" data-function="'.base_url().product_constants::change_product_status_url.'"><span class="badge badge-success">Active</span></a>';
                }
                else if($value->status == 0)
                {
                    $status     = '<a class="text-black" href="javascript:void(0);" onclick="change_status('.$value->id.', 1, this);" data-type="product" data-function="'.base_url().product_constants::change_product_status_url.'"><span class="badge badge-danger">In-Active</span></a>';
                }

                $action = '
                            <span class="dropdown action-dropdown d-flex justify-content-center">
                                <button id="btnSearchDrop'.$key.'" type="button" class="btn btn-sm btn-icon btn-pure font-medium-2" data-toggle="dropdown" aria-haspopup="true"
                                 aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <span aria-labelledby="btnSearchDrop'.$key.'" class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" title="Edit" href="'.base_url().product_constants::edit_product_url.'/'.$value->id.'">Edit</a>
                                    <a class="dropdown-item" title="Delete" href="javascript:void(0);" onclick="change_status('.$value->id.', -1, this);" data-type="product" data-function="'.base_url().product_constants::change_product_status_url.'">Delete</a>
                                </span>
                            </span>
                        ';

                $view   = '<a class="" href="'.base_url().product_constants::edit_product_url.'/'.$value->id.'" title="Edit '.$value->name.'">'.$value->name.'</a>';

                $no++;
                $row                                            = [];
                $row['sr_no']                                   = $no;
                $row['id']                                      = $value->id;
                $row['name']                                    = $view;
                $row['product_code']                            = $value->product_code;
                $row['status']                                  = $status;
                $row['created_on']                              = $created_on;
                $row['action']                                  = $action;
            
                $tabledata[]                                    = $row;
            }

            $output             = array(
                                        "total"      => $this->products->get_data($condition, '', '', 'allcount'),
                                        "rows"       => $tabledata,
                                    );

            echo json_encode($output);
        }

        private function form_validation_rules($data=[])
        {
            $this->form_validation->set_rules('name', 'Product name', 'required|max_length[100]|trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('type', 'Type', 'required');
            $this->form_validation->set_rules('status', 'Status', 'required');
            $this->form_validation->set_rules('product_code', 'Product Code', 'required');
            $this->form_validation->set_rules('brand_id', 'Brand Id', 'required');
            $this->form_validation->set_rules('mrp_price', 'MRP Price', 'required');
            $this->form_validation->set_rules('selling_price', 'Selling Price', 'required');
            $this->form_validation->set_rules('product_intro', 'Product Intro', 'required');
            $this->form_validation->set_rules('category_id[]', 'Category', 'required');
            $this->form_validation->set_rules('subcategory_id[]', 'Subcategory', 'required');
            $this->form_validation->set_rules('description', 'Description', 'trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('specification', 'Specification', 'trim|xss_clean|strip_tags');
            $this->form_validation->set_rules('sku', 'SKU', 'required');
        }

        function add()
        {
            $data['meta_title']             = "Add Product";
            $data['meta_description']       = "Add Product";
            $data['meta_keywords']          = "Add Product";
            $data['page_title']             = "Add Product";
            $data['module']                 = "Products";
            $data['menu']                   = "products";
            $data['submenu']                = "products";
            $data['childmenu']              = "add";
            $data['loggedin']               = "yes";
            $data['id']                     = "";
            $data['post_data']              = [];
            $data['post_data']['type']      = 1;
            $data['post_data']['status']    = 1;
            $data['post_data']['availability'] = 1;

            $this->form_validation_rules($data);

            if($this->input->post())
            {
                $data['post_data']          = $this->input->post();
            }

            if($this->form_validation->run($this) === TRUE)
            {
                if($this->input->post())
                {
                    $response               = $this->products->save('', $this->security->xss_clean($this->input->post()));
                    $this->session->set_flashdata('status', $response);
                    redirect(base_url().product_constants::products_url);
                }
            }

            $this->breadcrumbs->push(1, 'Products', product_constants::products_url);
            $this->breadcrumbs->unshift(2, 'Add', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            $data['content']                = "products/products/form";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }

        function edit($id='')
        {
            $response = ['error' => 1, 'message' => 'Access denied'];
            if(!empty($id))
            {
                $data['meta_title']         = "Edit Product";
                $data['meta_description']   = "Edit Product";
                $data['meta_keywords']      = "Edit Product";
                $data['page_title']         = "Edit Product";
                $data['module']             = "Products";
                $data['menu']               = "products";
                $data['submenu']            = "products";
                $data['childmenu']          = "add";
                $data['loggedin']           = "yes";
                $data['id']                 = $id;
                $data['post_data']          = [];

                $this->form_validation_rules($data);

                if($this->form_validation->run($this) === TRUE)
                {
                    if($this->input->post())
                    {
                        // echo "<pre>";print_r($this->input->post());exit();
                        // $this->input->post('category_id') = implode(",",$this->input->post('category_id'));
                        $response           = $this->products->save($id, $this->security->xss_clean($this->input->post()));
                        $this->session->set_flashdata('status', $response);
                        redirect(base_url().product_constants::products_url);
                    }
                }

                if($this->input->post())
                {
                    $data['post_data']      = $this->input->post();
                }
                else
                {
                    $data['post_data']              = $this->products->get_details($id);
                    $data['image_data']             = $this->products->get_imageDetails($id);
                    $data['size_data']              = $this->products->get_sizeDetails($id);
                    $data['size_options']           = $this->product_sizes->get_all_sizes();
                    // echo "<pre>";print_r($data['size_data']);//exit();
                    // echo "<pre>";print_r($data['post_data']);exit();
                    foreach ($data['size_data'] as $key => $value) {
                        $data['product_size_id'] = $value['size_id'];
                        $data['size_tag_options'][$key]   = $this->product_sizes->get_all_sizes_tags($data);
                    }
                    $data['color_options']      = $this->product_colors->get_all_colors();
                    // $data['bulk_data']      = $this->products->get_bulkDetails($id);

                    if(empty($data['post_data']))
                    {
                        $this->session->set_flashdata('status', ['error' => 1, 'message' => 'Product not found']);
                        redirect(base_url().product_constants::products_url);
                    }
                }

                $this->breadcrumbs->push(1, 'Products', product_constants::products_url);
                $this->breadcrumbs->unshift(2, 'Edit', '#');
                $data['breadcrumb']         = $this->breadcrumbs->show();
                $data['content']            = "products/products/form";
                echo Modules::run("templates/".$this->config->item('theme'), $data);
            }
            else
            {
                $this->session->set_flashdata('status', $response);
                redirect(base_url().product_constants::products_url);
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

                $details    = $this->products->get_details($id);

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

                    if($this->products->change($id, $status))
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

        function check_unique_product_name()
        {
            if($this->input->post())
            {
                $result = $this->unique_product_name($this->input->post('name'), '');
                echo $result;exit;
            }
        }

        function unique_product_name($str, $func)
        {
            $id             = '';
            $conditions     = ['status !=' => '-1', 'name' => $str];

            if(isset($_POST['id']) && !empty($_POST['id']))
            {
                $conditions = ['status !=' => '-1', 'name' => $str, 'id !=' => $_POST['id']];
            }

            $this->form_validation->set_message('unique_name', 'Name already exist');
            $result         = $this->products->check_unique($conditions, []);
            return $result;
        }

        function check_unique_product_code()
        {
            if($this->input->post())
            {
                $result = $this->unique_product_code($this->input->post('product_code'), '');
                echo $result;exit;
            }
        }

        function unique_product_code($str, $func)
        {
            $id             = '';
            $conditions     = ['status !=' => '-1', 'product_code' => $str];

            if(isset($_POST['id']) && !empty($_POST['id']))
            {
                $conditions = ['status !=' => '-1', 'product_code' => $str, 'id !=' => $_POST['id']];
            }

            $this->form_validation->set_message('unique_product_code', 'Product code already exist');
            $result         = $this->products->check_unique($conditions, []);
            return $result;
        }

        function get_product_options()
        {
            $products      = $this->products->get_all_products($this->input->get());

            $options            = '<option value="">-- Select Product --</option>';
            foreach ($products as $key => $value) {
                $selected       = '';
                if(isset($_GET['product_id']) && !empty($_GET['product_id']) && $_GET['product_id'] == $value['id'])
                {
                    $selected   = 'selected="selected"';
                }
                $options        .= '<option value="'.$value['id'].'" '.$selected.'>'.$value['name'].'</option>';
            }

            echo json_encode($options);
        }

        function get_coupon_product_options()
        {
            $products      = $this->products->get_all_products($this->input->get());

            $options            = '';
            foreach ($products as $key => $value) {
                $selected       = '';
                if(isset($_GET['product_id']) && !empty($_GET['product_id']) && $_GET['product_id'] == $value['id'])
                {
                    $selected   = 'selected="selected"';
                }
                $options        .= '<option value="'.$value['id'].'" '.$selected.'>'.$value['name'].'</option>';
            }

            echo json_encode($options);
        }

        public function validate_amount($str, $decimal_places = FALSE)
        {
            $this->form_validation->set_message('validate_amount', 'Invalid amount');
            $return = true;
            if(!empty($str))
            {
                if(is_numeric($str))
                {
                    // echo "<pre>int ";print_r($str);//exit;
                    $return = (bool) preg_match('/[^0-9]/', $str);
                }
                else
                {
                    if($decimal_places === FALSE)
                    {
                        // echo "<pre>decimal ";print_r($str);//exit;
                        $return = (bool) preg_match('/^[\-+]?[0-9]+\.[0-9]+$/', $str);
                    }
                    else
                    {
                        // echo "<pre>decimal upto ";print_r($str);//exit;
                        $return = (bool) preg_match('/^[0-9]+(\.[0-9]{0,'.$decimal_places.'})?$/', $tr);
                    }
                }
            }
            return $return;
        }

        function update_pricing()
        {
            $products   = $this->products->get_product_list();

            $update     = [];
            foreach ($products as $key => $value) {
                $best_seller                    = 0;
                $product_of_the_week            = 0;
                $new                            = 0;
                $on_offer                       = 0;
                $essential                      = 0;
                $featured                       = 0;
                $mrp_price                      = $value['mrp_price'];
                $offer_price                    = 0;
                $special_discount_price         = 15;
                $selling_price                  = 0;
                $final_selling_price            = 0;
                $save                           = [];
                $product_filter                 = explode(',', $value['product_filter']);

                if(!empty($product_filter))
                {
                    if(in_array('bestseller', $product_filter))
                    {
                        $best_seller            = 1;
                    }
                    if(in_array('product_of_the_week', $product_filter))
                    {
                        $product_of_the_week    = 1;
                    }
                    if(in_array('new', $product_filter))
                    {
                        $new                    = 1;
                    }
                    if(in_array('on_offer', $product_filter))
                    {
                        $on_offer               = 1;
                    }
                    if(in_array('essential', $product_filter))
                    {
                        $essential              = 1;
                    }
                    if(in_array('featured', $product_filter))
                    {
                        $featured               = 1;
                    }
                }

                $selling_price                  = ($mrp_price) - ($mrp_price*$special_discount_price)/100;
                $final_selling_price            = $selling_price;

                $save['id']                     = $value['id'];
                $save['best_seller']            = $best_seller;
                $save['product_of_the_week']    = $product_of_the_week;
                $save['new']                    = $new;
                $save['on_offer']               = $on_offer;
                $save['essential']              = $essential;
                $save['featured']               = $featured;
                $save['mrp_price']              = $mrp_price;
                $save['discount_price']         = $mrp_price - $final_selling_price;
                $save['offer_price']            = $offer_price;
                $save['special_discount_price'] = $special_discount_price;
                $save['selling_price']          = $selling_price;
                $save['final_selling_price']    = $final_selling_price;
                $save['modified_on']            = date('Y-m-d H:i:s');
                $save['modified_by']            = $this->session->userdata('user_id');

                $response                       = $this->products->update_product_list($save);
                echo json_encode($response);echo "<br>";
            }
            echo "Success";
            exit;
        }
        function report()
        {
            $data['meta_title']             = "Products";
            $data['meta_description']       = "Products";
            $data['meta_keywords']          = "Products";
            $data['page_title']             = "Products";
            $data['module']                 = "Products";
            $data['menu']                   = "reports";
            $data['submenu']                = "sales";
            $data['childmenu']              = "productwise";
            $data['loggedin']               = "yes";

            $this->breadcrumbs->push(1, 'Products', product_constants::products_url);
            $this->breadcrumbs->unshift(2, 'Report', '#');
            $data['breadcrumb']             = $this->breadcrumbs->show();

            $data['content']                = "products/products/report";
            echo Modules::run("templates/".$this->config->item('theme'), $data);
        }
        function ajax_report()
        {
            $condition          = ['p.status !' => '-1'];
            $list               = $this->products->get_report($condition, '', '', '');
            $tabledata          = [];
            $no                 = isset($_GET['offset']) ? $_GET['offset'] : 0;
            // print_r($list);
            foreach ($list as $key => $value) {
                // echo "<pre>";
                // print_r($value);
                // echo "</pre>";
                if(isset($value->created_on) && !empty($value->created_on) && $value->created_on !== '0000-00-00 00:00:00')
                {
                    $created_on = date($this->config->item('default_date_time_format'), strtotime($value->created_on));
                }
                else
                {
                    $created_on = 'NA';
                }

               

                $view   = '<a class="" href="'.base_url().product_constants::edit_product_url.'/'.$value->id.'" title="Edit '.$value->name.'">'.$value->name.'</a>';
                $final_selling_price = 0;
                
                // $final_selling_price = $value->$final_selling_price?$value->$final_selling_price:"0";
                $no++;
                $row                                          = [];
                $row['sr_no']                                 = $no;
                $row['id']                                    = $value->id;
                $row['sold']                                  = $value->sold;
                $row['quantity']                              = $value->quantity;
                $row['name']                                  = $view;
                $row['category_name']                          = $value->category_name;
                $row['product_code']                          = $value->sku;
                $row['unit_price']                            = $value->final_selling_price;
                $row['sale_amount']                            = $value->sale_amount;
                $row['created_on']                            = $created_on;
                
                $tabledata[]                                  = $row;
            }

            $output             = array(
                                        "total"      => $this->products->get_report($condition, '', '', 'allcount'),
                                        "rows"       => $tabledata,
                                    );

            echo json_encode($output);
        }
    }