<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Directs_model extends CI_Model
    {
        private $table_pinreference = directs_table::sql_pinreference;
        private $table_userdetails  = directs_table::sql_userdetails;

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

            // $this->db->order_by('id','ASC');
            // $query = $this->db->get($this->table_cruds);
            // return $query->result();


            if(isset($_GET['search']) && !empty($_GET['search']) && $_GET['search'] != 'undefined')
            {
                $term       = $_GET['search'];
                $like_sql   = 'AND
                                (
                                    ud.firstname LIKE "%'.$term.'%" ESCAPE "!"
                                    OR ud.midname LIKE "%'.$term.'%" ESCAPE "!"
                                    OR ud.lastname LIKE "%'.$term.'%" ESCAPE "!"
                                    OR ud.ownid LIKE "%'.$term.'%" ESCAPE "!"

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

            if(!empty($like_sql))
            {
                $where          .= ' '.$like_sql;
            }

            if(isset($_GET['order']) && !empty($_GET['order']) && isset($_GET['sort']) && !empty($_GET['sort']))
            {
                if($_GET['sort'] == 'ownid')
                {
                    $sort_by = 'pt.ownid';
                }
                else if($_GET['sort'] == 't_left')
                {
                    $sort_by = 'pt.totalleft';
                }
                else if($_GET['sort'] == 't_right')
                {
                    $sort_by = 'pt.totalright';
                }
                else if($_GET['sort'] == 't_unit_left')
                {
                    $sort_by = 'pt.totalunitleft';
                }
                else if($_GET['sort'] == 't_unit_right')
                {
                    $sort_by = 'pt.totalunitright';
                }
                else if($_GET['sort'] == 't_used_left')
                {
                    $sort_by = 'pt.totalusedunitleft';
                }
                else if($_GET['sort'] == 't_used_right')
                {
                    $sort_by = 'pt.totalusedunitright';
                }
                else if($_GET['sort'] == 'address')
                {
                    $sort_by = 'address';
                }
                else
                {
                    $sort_by = 'pt.id';
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
                $order       = 'pt.id DESC';
            }

            if(empty($allcount))
            {
                if(isset($_GET['limit']) && $_GET['limit'] != -1)
                {
                    $offset = $_GET['offset'];
                    $limit  = $_GET['limit'];
                }
                else if($limit)
                {
                    $limit  = $limit;
                }
                $offset     = !empty($offset) ? $offset : 0;

                if($limit > 0)
                {
                    $limit_offset = !empty($limit) ? $limit.', '.$offset : '';
                }
            }



            $this->db->select('*');
            $this->db->from($this->table_userdetails.' ud');
            $this->db->join($this->table_pinreference.' pt', 'ud.ownid = pt.ownid', 'left');
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
            $this->db->from($this->table_cruds);
            // $this->db->where('user_id', $this->session->userdata('user_id'));
            $this->db->where('id', $id);
            $this->db->where('status !=', '-1');
            $query = $this->db->get();
            return $query->row_array();
        }

        function save($id='', $save_data=[])
        {
            $response         = ['error' => 1, 'message' => 'Invalid request'];

            if(!empty($save_data))
            {
                if(!empty($id))
                {
                    $this->db->where('id', $id);
                    $this->db->update($this->table_cruds, $save_data);
                }
                else
                {
                    $this->db->insert($this->table_cruds, $save_data);
                    $id       = $this->db->insert_id();
                }

                if($this->db->affected_rows())
                {
                    $response = ['error' => 0, 'message' => 'Customer successfully saved'];
                }
                else
                {
                    $response = ['error' => 1, 'message' => 'Unable to save a customer'];
                }
            }
            return $response;
        }


        function change($id='', $status)
        {
            $update['status']           = $status;
            // $update['modified_on']      = date('Y-m-d H:i:s');
            // $update['modified_by']      = $this->session->userdata('user_id');

            $this->db->where('id', $id);
            // $this->db->where('user_id', $this->session->userdata('user_id'));
            $this->db->update($this->table_cruds, $update);

            return $this->db->affected_rows();
        }

        function check_unique($conditions=[])
        {
            $this->db->select('*');
            $this->db->from($this->table_cruds);
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
?>