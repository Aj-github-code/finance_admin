<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Product_colors_model extends CI_Model
    {
        private $table_product_colors            = Product_table::sql_tbl_product_colors;

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
                                    pc.name LIKE "%'.$term.'%" ESCAPE "!"
                                    OR pc.created_on LIKE "%'.$term.'%" ESCAPE "!"
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
                    $where      .= ' AND pc.created_on BETWEEN "'.$from_date.'" AND "'.$to_date.'"';
                }
                else if(!empty($from_date) && empty($to_date))
                {
                    $where      .= ' AND pc.created_on >= "'.$from_date.'"';
                }
                else if(empty($from_date) && !empty($to_date))
                {
                    $where      .= ' AND pc.created_on <= "'.$to_date.'"';
                }

                if($status != '')
                {
                    $where      .= ' AND pc.status IN ('.implode(',', $status).')';
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
                    $sort_by = 'pc.created_on';
                }
                else if($_GET['sort'] == 'name')
                {
                    $sort_by = 'pc.name';
                }
                else
                {
                    $sort_by = 'pc.id';
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
                $order       = 'pc.id DESC';
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

            $this->db->select('pc.*');
            $this->db->from($this->table_product_colors.' pc');
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

        function get_all_colors()
        {
            $this->db->select('*');
            $this->db->from($this->table_product_colors);
            $this->db->where('status !=', '-1');
            $query = $this->db->get();
            return $query->result_array();
        }

        function get_details($id='')
        {
            $this->db->select('*');
            $this->db->from($this->table_product_colors);
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
                    $this->db->update($this->table_product_colors, $save);
                    
                }
                else
                {
                    $save['created_on']                 = date('Y-m-d H:i:s');
                    $save['created_by']                 = $this->session->userdata('user_id');
                    $this->db->insert($this->table_product_colors, $save);
                }

                if($this->db->affected_rows())
                {
                    $msg = ['error' => 0, 'message' => 'Product color successfully saved'];
                }
                else
                {
                    $msg = ['error' => 1, 'message' => 'Unable to save product color'];
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
            $this->db->update($this->table_product_colors, $update);

            return $this->db->affected_rows();
        }

        function check_unique($conditions=[], $organization=[])
        {
            $this->db->select('*');
            $this->db->from($this->table_product_colors);
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
    }