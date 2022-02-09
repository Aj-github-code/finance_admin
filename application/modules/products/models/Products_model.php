<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Products_model extends CI_Model
    {
        private $table_products             = Product_table::sql_tbl_products;
        private $table_product_thumbnails   = Product_table::sql_tbl_product_thumbnails;
        private $table_product_quantity     = Product_table::sql_tbl_product_quantity;
        private $table_product_bulk_price   = Product_table::sql_tbl_product_bulk_price;
        private $table_product_stock        = Product_table::sql_tbl_product_stock;
        private $table_product_categories   = Product_table::sql_tbl_product_categories;

        public function __construct()
        {
            parent::__construct();
        }

        function get_data($conditions=[], $limit='', $offset=0, $allcount='')
        {
            $order          = '';
            $where          = '1=1';
            $like_sql       = '';
            $limit_offset   = '';

            // Like
            if(isset($_GET['search']) && !empty($_GET['search']) && $_GET['search'] != 'undefined')
            {
                $term       = $_GET['search'];
                $like_sql   = ' AND
                                (
                                    p.name LIKE "%'.$term.'%" ESCAPE "!"
                                    OR p.description LIKE "%'.$term.'%" ESCAPE "!"
                                    OR p.created_on LIKE "%'.$term.'%" ESCAPE "!"
                                )
                            ';
            }

            // Where
            if(!empty($conditions))
            {
                foreach ($conditions as $key => $value) {
                    $where .= ' AND '.$key.'='.$value;
                }
            }

            // Custom Filter
            if(isset($_GET['custom_search']) && !empty($_GET['custom_search']))
            {
                $from_date      = '';
                $to_date        = '';
                $parent_ids     = isset($_GET['custom_search']['parent_id']) ? $_GET['custom_search']['parent_id'] : '';
                $status         = isset($_GET['custom_search']['status']) ? $_GET['custom_search']['status'] : '';

                if(isset($_GET['custom_search']['from_date']) && !empty($_GET['custom_search']['from_date']))
                {
                    $from_date  = date("Y-m-d", strtotime($_GET['custom_search']['from_date'])).' 00:00:00';
                }

                if(isset($_GET['custom_search']['to_date']) && !empty($_GET['custom_search']['to_date']))
                {
                    $to_date    = date("Y-m-d", strtotime($_GET['custom_search']['to_date'])).' 23:59:59';
                }

                if(!empty($from_date) && !empty($to_date))
                {
                    $where      .= ' AND p.created_on BETWEEN "'.$from_date.'" AND "'.$to_date.'"';
                }
                else if(!empty($from_date) && empty($to_date))
                {
                    $where      .= ' AND p.created_on >= "'.$from_date.'"';
                }
                else if(empty($from_date) && !empty($to_date))
                {
                    $where      .= ' AND p.created_on <= "'.$to_date.'"';
                }

                if($parent_ids != '')
                {
                    $where      .= ' AND p.parent_id IN ('.implode(',', $parent_ids).')';
                }

                if($status != '')
                {
                    $where      .= ' AND p.status IN ('.implode(',', $status).')';
                }
            }

            if(!empty($like_sql))
            {
                $where          .= ' '.$like_sql;
            }

            // Order
            if(isset($_GET['order']) && !empty($_GET['order']) && isset($_GET['sort']) && !empty($_GET['sort']))
            {
                if($_GET['sort'] == 'created_on')
                {
                    $sort_by = 'p.created_on';
                }
                else if($_GET['sort'] == 'name')
                {
                    $sort_by = 'p.name';
                }
                else if($_GET['sort'] == 'product_code')
                {
                    $sort_by = 'p.product_code';
                }
                else
                {
                    $sort_by = 'p.id';
                }

                if(isset($_GET['order']) && !empty($_GET['order']))
                {
                    $by      = $_GET['order'];
                }
                else
                {
                    $by      = 'DESC';
                }
                $order       = $sort_by.' '.$by;
            } 
            else
            {
                $order       = 'p.id DESC';
            }

            // Limit
            if(empty($allcount))
            {
                if(isset($_GET['limit']) && $_GET['limit'] != -1)
                {
                    $offset = $_GET['offset'];
                    $limit = $_GET['limit'];
                }
                else if($limit)
                {
                    $limit = $limit;
                }
                $offset = !empty($offset) ? $offset : 0;

                if($limit > 0)
                {
                    $limit_offset = !empty($limit) ? $limit.', '.$offset : '';
                }
            }

            $this->db->select('p.*');
            $this->db->from($this->table_products.' p');
            $this->db->where($where);
            $this->db->order_by($order);
            if($allcount != 'allcount')
            {
                if($limit > 0 && $offset > 0)
                {
                    $this->db->limit($limit, $offset);
                }
                else
                {
                    if(!empty($limit))
                    {
                        $this->db->limit($limit);
                    }
                }
            }
            $query = $this->db->get();

            // echo "<pre>";print_r($this->db->last_query());exit;

            if($allcount == 'allcount')
            {
                return $query->num_rows();
            }
            else
            {
                return $query->result();
            }
        }

        function get_all_products($post_data='')
        {
            $this->db->select('*');
            $this->db->from($this->table_products);
            $this->db->where('status !=', '-1');
            if(isset($post_data['category_id']) && !empty($post_data['category_id'])){
                $this->db->where_in('category_id',$post_data['category_id']);
            }
            if(isset($post_data['subcategory_id']) && !empty($post_data['subcategory_id'])){
                $this->db->where_in('subcategory_id',$post_data['subcategory_id']);
            }
            $query = $this->db->get();
            return $query->result_array();
        }

        function get_details($id='')
        {
            $this->db->select('*');
            $this->db->from($this->table_products);
            $this->db->where('id', $id);
            $this->db->where('status !=', '-1');
            $query = $this->db->get();
            return $query->row_array();
        }

        function save($id='', $post_data=[])
        {
            $msg = ['error' => 1, 'message' => 'Invalid request'];
            // echo "<pre>";print_r($post_data);exit();
            if(!empty($post_data))
            {
                $best_seller                            = 0;
                $product_of_the_week                    = 0;
                $new                                    = 0;
                $on_offer                               = 0;
                $essential                              = 0;
                $featured                               = 0;

                if(isset($post_data['best_seller']) && !empty($post_data['best_seller']))
                {
                    $best_seller                        = 1;
                }
                if(isset($post_data['product_of_the_week']) && !empty($post_data['product_of_the_week']))
                {
                    $product_of_the_week                = 1;
                }
                if(isset($post_data['new']) && !empty($post_data['new']))
                {
                    $new                                = 1;
                }
                if(isset($post_data['on_offer']) && !empty($post_data['on_offer']))
                {
                    $on_offer                           = 1;
                }
                if(isset($post_data['essential']) && !empty($post_data['essential']))
                {
                    $essential                          = 1;
                }
                if(isset($post_data['featured']) && !empty($post_data['featured']))
                {
                    $featured                           = 1;
                }

                $special_discount_price                 = 0;
                $final_selling_price                    = $post_data['mrp_price'];
                if(isset($post_data['offer_price']) && !empty($post_data['offer_price']) && $post_data['offer_price'] > 0)
                {
                    $final_selling_price                = $post_data['offer_price'];
                    $special_discount_price             = (($post_data['mrp_price'] - $post_data['offer_price']) * 100) / $post_data['mrp_price'];
                }
                else if(isset($post_data['selling_price']) && !empty($post_data['selling_price']) && $post_data['selling_price'] > 0)
                {
                    $final_selling_price                = $post_data['selling_price'];
                    $special_discount_price             = (($post_data['mrp_price'] - $post_data['selling_price']) * 100) / $post_data['mrp_price'];
                }

                $save['type']                           = htmlentities($post_data['type']);
                $save['name']                           = $post_data['name'];
                $save['product_code']                   = htmlentities($post_data['product_code']);
                $save['mrp_price']                      = htmlentities(round($post_data['mrp_price'], 2));
                $save['discount_price']                 = $save['mrp_price'] - $final_selling_price;
                $save['offer_price']                    = htmlentities(round($post_data['offer_price'], 2));
                $save['special_discount_price']         = htmlentities(round($special_discount_price, 2));
                $save['selling_price']                  = htmlentities(round($post_data['selling_price'], 2));
                $save['final_selling_price']            = htmlentities(round($final_selling_price, 2));
                $save['product_intro']                  = htmlentities($post_data['product_intro']);
                $save['delivery_timeline']              = htmlentities($post_data['delivery_timeline']);
                $save['warranty']                       = htmlentities($post_data['warranty']);
                // $save['product_filter']                 = isset($post_data['product_filter']) ? htmlentities(implode(",",$post_data['product_filter'])) : '';

                $save['best_seller']                    = $best_seller;
                $save['product_of_the_week']            = $product_of_the_week;
                $save['new']                            = $new;
                $save['on_offer']                       = $on_offer;
                $save['essential']                      = $essential;
                $save['featured']                       = $featured;
                $save['hsn_code']                       = htmlentities($post_data['hsn_code']);
                $save['product_visibility']             = isset($post_data['product_visibility']) ? htmlentities($post_data['product_visibility']) : '';
                $save['offerable_product']              = isset($post_data['offerable_product']) ? htmlentities($post_data['offerable_product']) : '';
                $save['min_offer_amount']               = htmlentities($post_data['min_offer_amount']);
                $post_data['category_id'] = implode(",",$post_data['category_id']);
                $save['category_id']                    = htmlentities($post_data['category_id']);
                $post_data['subcategory_id'] = implode(",",$post_data['subcategory_id']);
                $save['subcategory_id']                 = htmlentities($post_data['subcategory_id']);
                $save['brand_id']                       = htmlentities($post_data['brand_id']);
                $save['color_id']                       = htmlentities($post_data['color_id']);
                $save['description']                    = $post_data['description'];
                $save['specification']                  = $post_data['specification'];
                $save['shipping']                       = $post_data['shipping'];
                $save['meta_title']                     = htmlentities($post_data['meta_title']);
                $save['meta_keyword']                   = htmlentities($post_data['meta_keyword']);
                $save['meta_description']               = htmlentities($post_data['meta_description']);
                $save['product_gst']                    = htmlentities($post_data['product_gst']);
                $save['sku']                            = htmlentities($post_data['sku']);
                $save['size_chart_image']               = htmlentities($post_data['size_chart_image']);
                $save['hover_thumbnail']                = htmlentities($post_data['hover_thumbnail']);
                $save['size_cart_desc']                 = htmlentities($post_data['size_cart_desc']);
                $save['availability']                   = htmlentities($post_data['availability']);
                $save['status']                         = htmlentities($post_data['status']);
                $save['modified_on']                    = date('Y-m-d H:i:s');
                $save['modified_by']                    = $this->session->userdata('user_id');

                $config = array(
                    'table'         => $this->table_products,
                    'id'            => 'id',
                    'field'         => 'slug',
                    'title'         => 'name',
                    'replacement'   => 'dash' // Either dash or underscore
                );
                $this->load->library('slug', $config);

                if(!empty($id))
                {
                    $save['slug']                       = $this->slug->create_uri(array('name' => $save['name']), $id, '');
                    $this->db->where('id', $id);
                    // print_r($save);
                    // print_r($post_data);
                    $this->db->update($this->table_products, $save);
                    // print_r($this->db->affected_rows());
                    $product_id = $id;
                    // exit();
                    if($this->db->affected_rows()){
                        $msg = ['error' => 0, 'message' => 'Product successfully saved'];
                        $this->db->where('product_id', $product_id);
                        $this->db->update($this->table_product_thumbnails, array('status' => -1));
                        $save_thumbnail    = array();
                        $update_thumbnail  = array();
                        foreach ($post_data['thumbnail'] as $key => $value) {
                            if(!empty($post_data['thumbnail'][$key])){
                                if(isset($post_data['thumbnail_id'][$key]) && !empty($post_data['thumbnail_id'][$key])){
                                    $update_thumbnail['product_id']     = $product_id;
                                    $update_thumbnail['thumbnail']      = $value;
                                    $update_thumbnail['thumbnail_slug'] = $post_data['thumbnail_slug'][$key];
                                    $update_thumbnail['zoom_thumbnail'] = $post_data['zoom_thumbnail'][$key];
                                    $update_thumbnail['status']         = $post_data['status'];
                                    $update_thumbnail['modified_on']    = date('Y-m-d H:i:s');
                                    $update_thumbnail['modified_by']    = $this->session->userdata('user_id');
                                    $this->db->where('id',$post_data['thumbnail_id'][$key]);
                                    $this->db->update($this->table_product_thumbnails, $update_thumbnail); 
                                }else{
                                    $save_thumbnail[$key]['product_id']     = $product_id;
                                    $save_thumbnail[$key]['thumbnail']      = $value;
                                    $save_thumbnail[$key]['thumbnail_slug'] = $post_data['thumbnail_slug'][$key];
                                    $save_thumbnail[$key]['zoom_thumbnail'] = $post_data['zoom_thumbnail'][$key];
                                    $save_thumbnail[$key]['status']         = $post_data['status'];
                                    $save_thumbnail[$key]['created_on']     = date('Y-m-d H:i:s');
                                    $save_thumbnail[$key]['created_by']     = $this->session->userdata('user_id');
                                    $save_thumbnail[$key]['modified_on']    = date('Y-m-d H:i:s');
                                    $save_thumbnail[$key]['modified_by']    = $this->session->userdata('user_id');
                                }
                            } 
                        } 
                        if(!empty($save_thumbnail)){
                            $this->db->insert_batch($this->table_product_thumbnails,$save_thumbnail);
                        }
                        // if($this->db->affected_rows()){
                            $this->db->where('product_id', $product_id);
                            $this->db->update($this->table_product_quantity, array('status' => -1));
                            $save_quantity    = array();
                            $update_quantity  = array();
                            foreach ($post_data['size_id'] as $key => $value) {
                                if(!empty($post_data['size_id'][$key])){
                                    if(isset($post_data['product_quantity_id'][$key]) && !empty($post_data['product_quantity_id'][$key])){
                                        $update_quantity['product_id']      = $product_id;
                                        $update_quantity['size_id']         = $value;
                                        $update_quantity['size_tag_id']     = $post_data['size_tag_id'][$key];
                                        $update_quantity['color_id']        = isset($post_data['color_id'][$key]) ? $post_data['color_id'][$key] : '';
                                        $update_quantity['quantity']        = $post_data['quantity'][$key];
                                        $update_quantity['status']          = $post_data['status'];
                                        $update_quantity['modified_on']     = date('Y-m-d H:i:s');
                                        $update_quantity['modified_by']     = $this->session->userdata('user_id');
                                        $this->db->where('id',$post_data['product_quantity_id'][$key]);
                                        $this->db->update($this->table_product_quantity, $update_quantity); 
                                    }else{
                                        $save_quantity[$key]['product_id']      = $product_id;
                                        $save_quantity[$key]['size_id']         = $value;
                                        $save_quantity[$key]['size_tag_id']     = $post_data['size_tag_id'][$key];
                                        $save_quantity[$key]['color_id']        = $post_data['color_id'][$key];
                                        $save_quantity[$key]['quantity']        = $post_data['quantity'][$key];
                                        $save_quantity[$key]['status']          = $post_data['status'];
                                        $save_quantity[$key]['created_on']      = date('Y-m-d H:i:s');
                                        $save_quantity[$key]['created_by']      = $this->session->userdata('user_id');
                                        $save_quantity[$key]['modified_on']     = date('Y-m-d H:i:s');
                                        $save_quantity[$key]['modified_by']     = $this->session->userdata('user_id');
                                    }
                                } 
                            }
                            if(!empty($save_quantity)){   
                                $this->db->insert_batch($this->table_product_quantity,$save_quantity); 
                            }
                    }else{
                        $msg = ['error' => 1, 'message' => 'Unable to save product'];
                    }
                }
                else
                {
                    $save['slug']                       = $this->slug->create_uri(array('name' => $save['name']), '', '');
                    $save['created_on']                 = date('Y-m-d H:i:s');
                    $save['created_by']                 = $this->session->userdata('user_id');
                    $this->db->insert($this->table_products, $save);
                    $product_id = $this->db->insert_id();
                    if($this->db->affected_rows()){
                        $save_thumbnail = array();
                        foreach ($post_data['thumbnail'] as $key => $value) {
                            if(!empty($post_data['thumbnail'][$key])){
                                $save_thumbnail[$key]['product_id']         = $product_id;
                                $save_thumbnail[$key]['thumbnail']          = $value;
                                $save_thumbnail[$key]['thumbnail_slug']     = $post_data['thumbnail_slug'][$key];
                                $save_thumbnail[$key]['zoom_thumbnail']     = $post_data['zoom_thumbnail'][$key];
                                $save_thumbnail[$key]['status']             = $post_data['status'];
                                $save_thumbnail[$key]['created_on']         = date('Y-m-d H:i:s');
                                $save_thumbnail[$key]['created_by']         = $this->session->userdata('user_id');
                                $save_thumbnail[$key]['modified_on']        = date('Y-m-d H:i:s');
                                $save_thumbnail[$key]['modified_by']        = $this->session->userdata('user_id');
                            }
                        } 
                        $this->db->insert_batch($this->table_product_thumbnails,$save_thumbnail); 
                        if($this->db->affected_rows()){
                            $save_quantity = array();
                            if(isset($post_data['size_id']) && !empty($post_data['size_id'])){
                                foreach ($post_data['size_id'] as $key => $value) {
                                    if(!empty($post_data['size_id'][$key])){
                                        $save_quantity[$key]['product_id']      = $product_id;
                                        $save_quantity[$key]['size_id']         = $value;
                                        $save_quantity[$key]['size_tag_id']     = $post_data['size_tag_id'][$key];
                                        $save_quantity[$key]['color_id']        = isset($post_data['color_id'][$key]) ? $post_data['color_id'][$key] : '';
                                        $save_quantity[$key]['quantity']        = $post_data['quantity'][$key];
                                        $save_quantity[$key]['status']          = $post_data['status'];
                                        $save_quantity[$key]['created_on']      = date('Y-m-d H:i:s');
                                        $save_quantity[$key]['created_by']      = $this->session->userdata('user_id');
                                        $save_quantity[$key]['modified_on']     = date('Y-m-d H:i:s');
                                        $save_quantity[$key]['modified_by']     = $this->session->userdata('user_id');
                                    }
                                }
                                if(!empty($save_quantity)){
                                    $this->db->insert_batch($this->table_product_quantity,$save_quantity); 
                                }
                                if($this->db->affected_rows()){
                                    $msg = ['error' => 0, 'message' => 'Product successfully saved'];
                                }else{
                                    $msg = ['error' => 1, 'message' => 'Unable to save product'];
                                }
                            }else{
                                $msg = ['error' => 1, 'message' => 'Unable to save product'];
                            }
                        }else{
                            $msg = ['error' => 1, 'message' => 'Unable to save product'];
                        }
                    }else{
                        $msg = ['error' => 1, 'message' => 'Unable to save product'];
                    }
                }
            }
            return $msg;
        }

        function change($id='', $status)
        {
            $update['status']           = $status;
            $update['modified_on']      = date('Y-m-d H:i:s');
            $update['modified_by']      = $this->session->userdata('user_id');

            $this->db->where('id', $id);
            $this->db->update($this->table_products, $update);
            return $this->db->affected_rows();
        }

        function check_unique($conditions=[], $organization=[])
        {
            $this->db->select('*');
            $this->db->from($this->table_products);
            if(!empty($conditions))
            {
                foreach ($conditions as $key => $value) {
                    $this->db->where($key, $value);
                }
            }
            $query = $this->db->get();
            $data  = $query->row_array();
            if(!empty($data))
            {
                return FALSE;
            }
            else
            {
                return TRUE;
            }
        }

        function get_sizeDetails($product_id){
            $this->db->select('*');
            $this->db->from($this->table_product_quantity);
            $this->db->where('status',1);
            $this->db->where('product_id',$product_id);
            return $this->db->get()->result_array();
        }

        function get_imageDetails($product_id){
            $this->db->select('*');
            $this->db->from($this->table_product_thumbnails);
            $this->db->where('status',1);
            $this->db->where('product_id',$product_id);
            return $this->db->get()->result_array();
        }

        function get_bulkDetails($product_id){
            $this->db->select('*');
            $this->db->from($this->table_product_bulk_price);
            $this->db->where('status',1);
            $this->db->where('product_id',$product_id);
            return $this->db->get()->result_array(); 
        }

        function get_product_list(){
            $this->db->select('*');
            $this->db->from($this->table_products);
            $this->db->where('status', 1);
            return $this->db->get()->result_array(); 
        }

        function update_product_list($update=[])
        {
            $product_id = $update['id'];
            unset($update['id']);
            $this->db->where('id', $product_id);
            $this->db->update($this->table_products, $update);

            if($this->db->affected_rows()){
                $msg = ['error' => 0, 'message' => 'Product updated'];
            }else{
                $msg = ['error' => 1, 'message' => 'Unable to update product'];
            }
            return $msg;
        }
    }