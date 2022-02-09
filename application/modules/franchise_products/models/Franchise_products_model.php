<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Franchise_products_model extends CI_Model
    {
        private $table_franchise_products = franchise_products_table::sql_tbl_franchise_products;

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
                                    fp.name LIKE "%'.$term.'%" ESCAPE "!"
                                    OR fp.hsn_sac LIKE "%'.$term.'%" ESCAPE "!"
                                    OR fp.mrp LIKE "%'.$term.'%" ESCAPE "!"
                                    OR fp.opening_stock LIKE "%'.$term.'%" ESCAPE "!"
                                    OR fp.d_p LIKE "%'.$term.'%" ESCAPE "!"
                                    OR fp.b_v LIKE "%'.$term.'%" ESCAPE "!"
                                    OR fp.created_on LIKE "%'.$term.'%" ESCAPE "!"
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
                    $where      .= ' AND fp.created_on BETWEEN "'.$from_date.'" AND "'.$to_date.'"';
                }
                else if(!empty($from_date) && empty($to_date))
                {
                    $where      .= ' AND fp.created_on >= "'.$from_date.'"';
                }
                else if(empty($from_date) && !empty($to_date))
                {
                    $where      .= ' AND fp.created_on <= "'.$to_date.'"';
                }

                if($status != '')
                {
                    $where      .= ' AND fp.status IN ('.implode(',', $status).')';
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
                    $sort_by = 'fp.created_on';
                }
                else if($_GET['sort'] == 'name')
                {
                    $sort_by = 'fp.name';
                }
                else if($_GET['sort'] == 'hsn_sac')
                {
                    $sort_by = 'fp.hsn_sac';
                }
                else if($_GET['sort'] == 'mrp')
                {
                    $sort_by = 'fp.mrp';
                }
                else if($_GET['sort'] == 'opening_stock')
                {
                    $sort_by = 'fp.opening_stock';
                }
                else if($_GET['sort'] == 'd_p')
                {
                    $sort_by = 'fp.d_p';
                }
                else if($_GET['sort'] == 'b_v')
                {
                    $sort_by = 'fp.b_v';
                }
                else
                {
                    $sort_by = 'fp.id';
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
                $order       = 'fp.id DESC';
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

            $this->db->select('fp.*');
            $this->db->from($this->table_franchise_products.' fp');
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

        function get_details($id='')
        {
            $this->db->select('*');
            $this->db->from($this->table_franchise_products);
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
                $save                                   = [];
                $save['name']                           = $post_data['name'];
                $save['description']                    = $post_data['description'];
                $save['thumbnail']                      = $post_data['thumbnail'];
                $save['p_code']                         = $post_data['p_code'];
                $save['hsn_sac']                        = $post_data['hsn_sac'];
                $save['mrp']                            = htmlentities($post_data['mrp']);
                $save['opening_stock']                  = htmlentities($post_data['opening_stock']);
                $save['d_p']                            = htmlentities($post_data['d_p']);
                $save['b_v']                            = htmlentities($post_data['b_v']);
                $save['gst_type']                       = $post_data['gst_type'];
                $save['gst']                            = $post_data['gst'];
                $save['return']                         = (!empty($post_data['return']) ? htmlentities($post_data['return']) : 0);
                $save['replace']                        = (!empty($post_data['replace']) ? htmlentities($post_data['replace']) : 0);
                $save['cgst']                           = (!empty($post_data['cgst']) ? htmlentities($post_data['cgst']) : NULL);
                $save['sgst']                           = (!empty($post_data['sgst']) ? htmlentities($post_data['sgst']) : NULL);
                $save['igst']                           = (!empty($post_data['igst']) ? htmlentities($post_data['igst']) : NULL);
                $save['status']                         = htmlentities($post_data['status']);
                $save['modified_on']                    = date('Y-m-d H:i:s');
                $save['modified_by']                    = $this->session->userdata('user_id');

                $config = array(
                    'table'         => $this->table_franchise_products,
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
                    $this->db->update($this->table_franchise_products, $save);
                }
                else
                {
                    $save['slug']                       = $this->slug->create_uri(array('name' => $save['name']), '', '');
                    $save['created_on']                 = date('Y-m-d H:i:s');
                    $save['created_by']                 = $this->session->userdata('user_id');
                    $this->db->insert($this->table_franchise_products, $save);
                }

                if($this->db->affected_rows())
                {
                    $msg = ['error' => 0, 'message' => 'Product successfully saved'];
                }
                else
                {
                    $msg = ['error' => 1, 'message' => 'Unable to save product'];
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
            $this->db->update($this->table_franchise_products, $update);

            return $this->db->affected_rows();
        }
    }