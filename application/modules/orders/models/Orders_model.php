<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Orders_model extends CI_Model
    {
        private $table_franchise_orders             = orders_table::sql_tbl_franchise_orders;
        private $table_franchise_order_products     = orders_table::sql_tbl_franchise_order_products;
        private $table_franchise_purchased_products = orders_table::sql_tbl_franchise_purchased_products;
        private $table_products                     = franchise_products_table::sql_tbl_franchise_products;
        private $table_franchise                    = franchise_table::sql_table_franchise;

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
                                    fo.order_number LIKE "%'.$term.'%" ESCAPE "!"
                                    OR fo.total_d_p LIKE "%'.$term.'%" ESCAPE "!"
                                    OR fo.total_quantity LIKE "%'.$term.'%" ESCAPE "!"
                                    OR fo.gst_rate LIKE "%'.$term.'%" ESCAPE "!"
                                    OR fo.total_gst LIKE "%'.$term.'%" ESCAPE "!"
                                    OR fo.service_charge LIKE "%'.$term.'%" ESCAPE "!"
                                    OR fo.final_d_p LIKE "%'.$term.'%" ESCAPE "!"
                                    OR fo.order_status LIKE "%'.$term.'%" ESCAPE "!"
                                    OR fo.processed_on LIKE "%'.$term.'%" ESCAPE "!"
                                    OR fo.created_on LIKE "%'.$term.'%" ESCAPE "!"
                                    OR f.franchise_name LIKE "%'.$term.'%" ESCAPE "!"
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
                $order_status   = isset($_GET['custom_search']['order_status']) ? $_GET['custom_search']['order_status'] : '';

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
                    $where      .= ' AND fo.created_on BETWEEN "'.$from_date.'" AND "'.$to_date.'"';
                }
                else if(!empty($from_date) && empty($to_date))
                {
                    $where      .= ' AND fo.created_on >= "'.$from_date.'"';
                }
                else if(empty($from_date) && !empty($to_date))
                {
                    $where      .= ' AND fo.created_on <= "'.$to_date.'"';
                }

                if($order_status != '')
                {
                    $where      .= ' AND fo.order_status IN ("' .implode('", "', $order_status). '")';
                }

                if($status != '')
                {
                    $where      .= ' AND fo.status IN ('.implode(',', $status).')';
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
                    $sort_by = 'fo.created_on';
                }
                else if($_GET['sort'] == 'order_number')
                {
                    $sort_by = 'fo.order_number';
                }
                else if($_GET['sort'] == 'total_d_p')
                {
                    $sort_by = 'fo.total_d_p';
                }
                else if($_GET['sort'] == 'total_quantity')
                {
                    $sort_by = 'fo.total_quantity';
                }
                else if($_GET['sort'] == 'gst_rate')
                {
                    $sort_by = 'fo.gst_rate';
                }
                else if($_GET['sort'] == 'total_gst')
                {
                    $sort_by = 'fo.total_gst';
                }
                else if($_GET['sort'] == 'service_charge')
                {
                    $sort_by = 'fo.service_charge';
                }
                else if($_GET['sort'] == 'final_d_p')
                {
                    $sort_by = 'fo.final_d_p';
                }
                else if($_GET['sort'] == 'address')
                {
                    $sort_by = 'fo.address';
                }
                else if($_GET['sort'] == 'order_status')
                {
                    $sort_by = 'fo.order_status';
                }
                else if($_GET['sort'] == 'message')
                {
                    $sort_by = 'fo.message';
                }
                else if($_GET['sort'] == 'processed_on')
                {
                    $sort_by = 'fo.processed_on';
                }
                else if($_GET['sort'] == 'status')
                {
                    $sort_by = 'fo.status';
                }
                else if($_GET['sort'] == 'franchise_name')
                {
                    $sort_by = 'f.franchise_name';
                }
                else
                {
                    $sort_by = 'fo.id';
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
                $order       = 'fo.id DESC';
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

            $this->db->select('fo.*, f.franchise_name');
            $this->db->from($this->table_franchise_orders.' fo');
            $this->db->join($this->table_franchise.' f', 'fo.user_id=f.id', 'INNER');
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

        function get_details($order_number)
        {
            $this->db->select('*');
            $this->db->from($this->table_franchise_orders);
            $this->db->where('order_number', $order_number);
            $this->db->where('status', 1);
            $query = $this->db->get();
            // echo "<pre>";print_r($this->db->last_query());exit;
            return $query->row_array();
        }

        function get_order_products($order_id)
        {
            $this->db->select('fop.*, p.name, p.p_code, p.hsn_sac, p.slug, p.description, p.thumbnail, p.mrp, p.d_p, p.b_v, p.opening_stock');
            $this->db->from($this->table_franchise_order_products.' fop');
            $this->db->join($this->table_products.' p', 'fop.product_id=p.id', 'INNER');
            $this->db->where('fop.order_id', $order_id);
            $this->db->where('fop.status', 1);
            // $this->db->where('p.status', 1);
            $this->db->order_by('fop.id', 'ASC');
            $query = $this->db->get();
            return $query->result_array();
        }

        function get_product($product_id)
        {
            $this->db->select('*');
            $this->db->from($this->table_products);
            $this->db->where('id', $product_id);
            // $this->db->where('status', 1);
            $query = $this->db->get();
            return $query->row_array();
        }

        function change($order_number='', $status)
        {
            $update['status']           = $status;
            $update['modified_on']      = date('Y-m-d H:i:s');
            $update['modified_by']      = $this->session->userdata('user_id');

            $this->db->where('order_number', $order_number);
            $this->db->update($this->table_franchise_orders, $update);
            $affected_rows              = $this->db->affected_rows();

            return $affected_rows;
        }

        function process($franchise_id, $order_id, $order_number, $order_products, $order_request, $update, $order_gst_type='')
        {
            $response                   = ['error' => 1, 'message' => 'Unable to process order'];
            $this->db->where('id', $order_id);
            $this->db->update($this->table_franchise_orders, $update);
            if($this->db->affected_rows())
            {
                if(!empty($order_gst_type))
                {
                    $updateorderproduct = [
                                            'gst_type'      => $order_gst_type,
                                            'modified_on'   => date('Y-m-d H:i:s'),
                                            'modified_by'   => $this->session->userdata('user_id'),
                                        ];
                    $this->db->reset_query();
                    $this->db->where('order_id', $order_id);
                    $this->db->update($this->table_franchise_order_products, $updateorderproduct);
                }
                if($update['order_status'] == 'approved')
                {
                    foreach ($order_request as $key => $value) {
                        $product        = $value['product'];
                        $product_id     = $product['id'];
                        $order_quantity = $value['order_quantity'];
                        $amount         = $value['order_amount'];
                        $d_p            = $value['order_d_p'];
                        $b_v            = $value['order_b_v'];

                        $this->deduct_stock($product, $order_quantity);
                        $this->add_franchise_purchased_product($franchise_id, $product, $amount, $d_p, $b_v, $order_quantity);
                    }
                }
                $response               = ['error' => 0, 'message' => 'Order successfully processed'];
            }
            return $response;
        }

        function deduct_stock($product, $order_quantity)
        {
            $update                     = [];
            $update['opening_stock']    = $product['opening_stock'] - $order_quantity;
            $update['modified_on']      = date('Y-m-d H:i:s');
            $update['modified_by']      = $this->session->userdata('user_id');

            $this->db->reset_query();
            $this->db->where('id', $product['id']);
            $this->db->update($this->table_products, $update);
            return $this->db->affected_rows();
        }

        function add_franchise_purchased_product($franchise_id, $product, $amount, $d_p, $b_v, $order_quantity)
        {
            $product_id                     = $product['id'];
            $purchased_product              = $this->get_franchise_purchased_product($franchise_id, $product_id);
            if(!empty($purchased_product))
            {
                $update                     = [];
                $update['mrp']              = $amount;
                $update['d_p']              = $d_p;
                $update['b_v']              = $b_v;
                $update['opening_stock']    = $purchased_product['opening_stock'] + $order_quantity;
                $update['gst_type']         = $product['gst_type'];
                $update['gst']              = $product['gst'];
                $update['cgst']             = $product['cgst'];
                $update['sgst']             = $product['sgst'];
                $update['igst']             = $product['igst'];
                $update['return']           = $product['return'];
                $update['replace']          = $product['replace'];
                $update['modified_on']      = date('Y-m-d H:i:s');
                $update['modified_by']      = $this->session->userdata('user_id');

                $this->db->reset_query();
                $this->db->where('user_id', $franchise_id);
                $this->db->where('product_id', $product_id);
                $this->db->where('status', 1);
                $this->db->update($this->table_franchise_purchased_products, $update);
                return $this->db->affected_rows();
            }
            else
            {
                $save                       = [];
                $save['user_id']            = $franchise_id;
                $save['product_id']         = $product_id;
                $save['name']               = $product['name'];
                $save['slug']               = $product['slug'];
                $save['description']        = $product['description'];
                $save['thumbnail']          = $product['thumbnail'];
                $save['p_code']             = $product['p_code'];
                $save['hsn_sac']            = $product['hsn_sac'];
                $save['mrp']                = $amount;
                $save['d_p']                = $d_p;
                $save['b_v']                = $b_v;
                $save['opening_stock']      = $order_quantity;
                $save['gst_type']           = $product['gst_type'];
                $save['gst']                = $product['gst'];
                $save['cgst']               = $product['cgst'];
                $save['sgst']               = $product['sgst'];
                $save['igst']               = $product['igst'];
                $save['return']             = $product['return'];
                $save['replace']            = $product['replace'];
                $save['status']             = 1;
                $save['created_on']         = date('Y-m-d H:i:s');
                $save['created_by']         = $this->session->userdata('user_id');
                $this->db->insert($this->table_franchise_purchased_products, $save);
                return $this->db->affected_rows();
            }
        }

        function get_franchise_purchased_product($franchise_id, $product_id)
        {
            $this->db->reset_query();
            $this->db->select('*');
            $this->db->from($this->table_franchise_purchased_products);
            $this->db->where('user_id', $franchise_id);
            $this->db->where('product_id', $product_id);
            $this->db->where('status', 1);
            $query = $this->db->get();
            return $query->row_array();
        }

        function order_count($conditions=[])
        {
            $this->db->select('count(*) as order_count');
            $this->db->from($this->table_franchise_orders);
            if(!empty($conditions))
            {
                foreach ($conditions as $key => $value) {
                    if($key == 'order_status')
                    {
                        $this->db->where_in('order_status', $value);
                    }
                    else
                    {
                        $this->db->where($key, $value);
                    }
                }
            }
            $query = $this->db->get();
            // echo "<pre>";print_r($this->db->last_query());exit;
            $order = $query->row_array();
            if(isset($order['order_count']) && !empty($order['order_count']))
            {
                return $order['order_count'];
            }
            else
            {
                return 0;
            }
        }
    }