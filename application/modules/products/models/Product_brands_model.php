<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Product_brands_model extends CI_Model
    {
        private $table_product_brands = Product_table::sql_tbl_product_brands;

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
                                    b.name LIKE "%'.$term.'%" ESCAPE "!"
                                    OR b.description LIKE "%'.$term.'%" ESCAPE "!"
                                    OR b.created_on LIKE "%'.$term.'%" ESCAPE "!"
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
                    $where      .= ' AND b.created_on BETWEEN "'.$from_date.'" AND "'.$to_date.'"';
                }
                else if(!empty($from_date) && empty($to_date))
                {
                    $where      .= ' AND b.created_on >= "'.$from_date.'"';
                }
                else if(empty($from_date) && !empty($to_date))
                {
                    $where      .= ' AND b.created_on <= "'.$to_date.'"';
                }

                if($status != '')
                {
                    $where      .= ' AND b.status IN ('.implode(',', $status).')';
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
                    $sort_by = 'b.created_on';
                }
                else if($_GET['sort'] == 'name')
                {
                    $sort_by = 'b.name';
                }
                else if($_GET['sort'] == 'description')
                {
                    $sort_by = 'b.description';
                }
                else
                {
                    $sort_by = 'b.id';
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
                $order       = 'b.id DESC';
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

            $this->db->select('b.*');
            $this->db->from($this->table_product_brands.' b');
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

        function get_all_brands()
        {
            $this->db->select('*');
            $this->db->from($this->table_product_brands);
            $this->db->where('status !=', '-1');
            $query = $this->db->get();
            return $query->result_array();
        }

        function get_details($id='')
        {
            $this->db->select('*');
            $this->db->from($this->table_product_brands);
            $this->db->where('id', $id);
            $this->db->where('status !=', '-1');
            $query = $this->db->get();
            return $query->row_array();
        }

        function save($id='', $post_data=[])
        {
            $msg = ['error' => 1, 'message' => 'Invalid request'];

            if(!empty($post_data))
            {
                $save['name']                           = htmlentities($post_data['name']);
                $save['thumbnail']                      = htmlentities($post_data['thumbnail']);
                $save['description']                    = htmlentities($post_data['description']);
                $save['status']                         = htmlentities($post_data['status']);
                $save['modified_on']                    = date('Y-m-d H:i:s');
                $save['modified_by']                    = $this->session->userdata('user_id');

                $config = array(
                    'table'         => $this->table_product_brands,
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
                    $this->db->update($this->table_product_brands, $save);
                }
                else
                {
                    $save['slug']                       = $this->slug->create_uri(array('name' => $save['name']), '', '');
                    $save['created_on']                 = date('Y-m-d H:i:s');
                    $save['created_by']                 = $this->session->userdata('user_id');
                    $this->db->insert($this->table_product_brands, $save);
                }

                if($this->db->affected_rows())
                {
                    $msg = ['error' => 0, 'message' => 'Product brand successfully saved'];
                }
                else
                {
                    $msg = ['error' => 1, 'message' => 'Unable to save product brand'];
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
            $this->db->update($this->table_product_brands, $update);

            return $this->db->affected_rows();
        }
    }