<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Product_sizes_model extends CI_Model
    {
        private $table_product_sizes            = Product_table::sql_tbl_product_sizes;
        private $table_product_size_tags        = Product_table::sql_tbl_product_size_tags;

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
                                    s.name LIKE "%'.$term.'%" ESCAPE "!"
                                    OR s.created_on LIKE "%'.$term.'%" ESCAPE "!"
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
                    $where      .= ' AND s.created_on BETWEEN "'.$from_date.'" AND "'.$to_date.'"';
                }
                else if(!empty($from_date) && empty($to_date))
                {
                    $where      .= ' AND s.created_on >= "'.$from_date.'"';
                }
                else if(empty($from_date) && !empty($to_date))
                {
                    $where      .= ' AND s.created_on <= "'.$to_date.'"';
                }

                if($status != '')
                {
                    $where      .= ' AND s.status IN ('.implode(',', $status).')';
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
                    $sort_by = 's.created_on';
                }
                else if($_GET['sort'] == 'name')
                {
                    $sort_by = 's.name';
                }
                else
                {
                    $sort_by = 's.id';
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
                $order       = 's.id DESC';
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

            $this->db->select('s.*');
            $this->db->from($this->table_product_sizes.' s');
            // $this->db->join($this->table_product_size_tags.' c','c.product_size_id = s.id','left');
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

        function get_all_sizes()
        {
            $this->db->select('*');
            $this->db->from($this->table_product_sizes);
            $this->db->where('status !=', '-1');
            $query = $this->db->get();
            return $query->result_array();
        }

        function get_all_sizes_tags($data)
        {
            $this->db->select('*');
            $this->db->from($this->table_product_size_tags);
            $this->db->where('status !=', '-1');
            $this->db->where('product_size_id ', $data['product_size_id']);
            $query = $this->db->get();
            return $query->result_array();
        }

        function get_details($id='')
        {
            $this->db->select('*');
            $this->db->from($this->table_product_sizes);
            $this->db->where('id', $id);
            $this->db->where('status !=', '-1');
            $query = $this->db->get();
            return $query->row_array();
        }

        function save($id='', $post_data=[])
        {
            $error = true;
            $msg = ['error' => 1, 'message' => 'Invalid request'];

            if(!empty($post_data))
            {
                $save['name']                           = htmlentities($post_data['name']);
                $save['status']                         = htmlentities($post_data['status']);
                $save['modified_on']                    = date('Y-m-d H:i:s');
                $save['modified_by']                    = $this->session->userdata('user_id');

                if(!empty($id))
                {
                    $this->db->where('id', $id);
                    $this->db->update($this->table_product_sizes, $save);
                    if($this->db->affected_rows()){
                        if(!empty($post_data['tags_val'])){
                            $this->db->where('product_size_id', $id);
                            $this->db->update($this->table_product_size_tags, array('status' => -1));
                            $tags = explode(",", $post_data['tags_val']);
                            if(!empty($tags)){
                                foreach ($tags as $key => $value) {
                                    $is_tag_size = $this->getSizeTagDetails($id,$value);
                                    if(!empty($is_tag_size)){
                                        $this->db->where('id', $is_tag_size['id']);
                                        $this->db->where('product_size_id', $id);
                                        $this->db->update($this->table_product_size_tags, array('status' => 1));
                                        if($this->db->affected_rows()){
                                            $error = false;
                                        }
                                    }else{
                                        $save_size_tags['product_size_id']    = $id;
                                        $save_size_tags['size_tag_name']      = $value;
                                        $save_size_tags['status']             = htmlentities($post_data['status']);
                                        $save_size_tags['created_on']         = date('Y-m-d H:i:s');
                                        $save_size_tags['created_by']         = $this->session->userdata('user_id');
                                        $save_size_tags['modified_on']        = date('Y-m-d H:i:s');
                                        $save_size_tags['modified_by']        = $this->session->userdata('user_id');
                                        $this->db->insert($this->table_product_size_tags, $save_size_tags);
                                        if($this->db->affected_rows()){
                                            $error = false;
                                        }
                                    }
                                }
                            }
                        }else{
                            $error = true;
                        }
                    }else{
                        $error = true;
                    }
                }
                else
                {
                    $save['created_on']                 = date('Y-m-d H:i:s');
                    $save['created_by']                 = $this->session->userdata('user_id');
                    $this->db->insert($this->table_product_sizes, $save);
                    $insert_id = $this->db->insert_id();
                    if($this->db->affected_rows()){
                        if(!empty($this->input->post('tags_val'))){
                            $tags = explode(",", $this->input->post('tags_val'));
                            $save_size_tags = array();
                            if(!empty($tags)){
                                foreach ($tags as $key => $value) {
                                    $save_size_tags[$key]['product_size_id']    = $insert_id;
                                    $save_size_tags[$key]['size_tag_name']      = $value;
                                    $save_size_tags[$key]['status']             = htmlentities($post_data['status']);
                                    $save_size_tags[$key]['created_on']         = date('Y-m-d H:i:s');
                                    $save_size_tags[$key]['created_by']         = $this->session->userdata('user_id');
                                    $save_size_tags[$key]['modified_on']        = date('Y-m-d H:i:s');
                                    $save_size_tags[$key]['modified_by']        = $this->session->userdata('user_id');
                                }
                                $this->db->insert_batch($this->table_product_size_tags, $save_size_tags);
                                if($this->db->affected_rows()){
                                    $error = false;
                                }else{
                                    $error = ture;
                                }
                            }else{
                               $error = true; 
                            }
                        }
                    }else{
                        $error = true;
                    }
                }

                if($error==false)
                {
                    $msg = ['error' => 0, 'message' => 'Product size successfully saved'];
                }
                else
                {
                    $msg = ['error' => 1, 'message' => 'Unable to save product size'];
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
            $this->db->update($this->table_product_sizes, $update);

            return $this->db->affected_rows();
        }

        function get_all_size_tags($size_id){
            $this->db->select('*');
            $this->db->from($this->table_product_size_tags);
            $this->db->where('product_size_id',$size_id);
            $this->db->where('status',1);
            return $this->db->get()->result_array();
        }

        function getSizeTagDetails($product_size_id, $size_tag_name){
            $this->db->select('*');
            $this->db->from($this->table_product_size_tags);
            $this->db->where('size_tag_name',trim($size_tag_name));
            $this->db->where('product_size_id',trim($product_size_id));
            return $this->db->get()->row_array();
        }
    }