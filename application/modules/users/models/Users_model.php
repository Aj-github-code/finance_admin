<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Users_model extends CI_Model
    {
        private $table_useroption  = users_table::sql_useroption;
        private $table_userdetails = users_table::sql_userdetails;
        private $table_pintable    = users_table::sql_pintable;
        private $table_direct_comm = users_table::sql_direct_comm;
        private $table_pinreference = users_table::sql_pinreference;
        private $table_left_right   = users_table::sql_left_right;
        
        


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




            if(isset($_GET['search']) && !empty($_GET['search']) && $_GET['search'] != 'undefined')
            {
                $term       = $_GET['search'];
                $like_sql   = ' AND
                                (
                                    uo.ownid LIKE "%'.$term.'%" ESCAPE "!"
                                    OR uo.sponsorid LIKE "%'.$term.'%" ESCAPE "!"
                                    OR uo.placementid LIKE "%'.$term.'%" ESCAPE "!" 
                                )
                            ';
            }




            if(!empty($conditions))
            {
                foreach ($conditions as $key => $value) {
                    $where .= ' AND '.$key.'='.$value;
                }
            }
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
                    $where      .= ' AND uo.createddate BETWEEN "'.$from_date.'" AND "'.$to_date.'"';
                }
                else if(!empty($from_date) && empty($to_date))
                {
                    $where      .= ' AND uo.createddate >= "'.$from_date.'"';
                }
                else if(empty($from_date) && !empty($to_date))
                {
                    $where      .= ' AND uo.createddate <= "'.$to_date.'"';
                }

                if($status != '')
                {
                    $where      .= ' AND uo.status IN ('.implode(',', $status).')';
                }
            }

            if(!empty($like_sql))
            {
                $where          .= ' '.$like_sql;
            }

            if(isset($_GET['order']) && !empty($_GET['order']) && isset($_GET['sort']) && !empty($_GET['sort']))
            {
                if($_GET['sort'] == 'createddate')
                {
                    $sort_by = 'uo.createddate';
                }
                else if($_GET['sort'] == 'pin')
                {
                    $sort_by = 'uo.pin';
                }
                else if($_GET['sort'] == 'ownid')
                {
                    $sort_by = 'uo.ownid';
                }
                else if($_GET['sort'] == 'placementid')
                {
                    $sort_by = 'uo.placementid';
                }
                else if($_GET['sort'] == 'sponsorid')
                {
                    $sort_by = 'uo.sponsorid';
                }
                else if($_GET['sort'] == 'pin_date')
                {
                    $sort_by = 'uo.pin_date';
                }
                else
                {
                    $sort_by = 'uo.id';
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
                $order       = 'uo.id DESC';
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
            $this->db->from($this->table_useroption.' uo');
            $this->db->join($this->table_userdetails.' ud', 'ud.ownid = uo.ownid', 'left');
            $this->db->where($where);
            $this->db->where('uo.status !=', '-1');
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

        function get_details($ownid)
        {
            $this->db->select('ownid,pin,sponcer_count,sponsorid,placement,placementid');
            $this->db->from($this->table_useroption);
            $this->db->where('ownid', $ownid);
            $this->db->where('status !=', '-1');
            $query = $this->db->get();
            return $query->row_array();
        }
        function get_detail($ownid)
        {
            $this->db->select('sponsorid,placement,placementid');
            $this->db->from($this->table_useroption);
            $this->db->where('ownid', $ownid);
            $this->db->where('status !=', '-1');
            $query = $this->db->get();
            return $query->row_array();
        }
        function direct_income($save_data=[])
        {
            $response         = ['error' => 1, 'message' => 'Invalid request'];

            if(!empty($save_data))
            {
                $this->db->insert($this->table_direct_comm, $save_data);

                if($this->db->affected_rows())
                {
                    $response = ['error' => 0, 'message' => 'Direct Income successfully saved'];
                }
                else
                {
                    $response = ['error' => 1, 'message' => 'Unable  Direct'];
                }
            }
            return $response;
        }
        function pin_table($save_data=[])
        {
            $response         = ['error' => 1, 'message' => 'Invalid request'];

            if(!empty($save_data))
            {
                $this->db->insert($this->table_pintable, $save_data);

                if($this->db->affected_rows())
                {
                    $response = ['error' => 0, 'message' => 'Pintable successfully saved'];
                }
                else
                {
                    $response = ['error' => 1, 'message' => 'Unable to save a Pintable'];
                }
            }
            return $response;
        }
        function pin_reference($ownid,$columname,$pinno)
        {

            $response         = ['error' => 1, 'message' => 'Invalid request'];

            if(!empty($columname))
            {
                    $query = "update ".$this->table_pinreference." SET ".$columname ." = " .$columname." + ".$pinno." WHERE ownid = '".$ownid."'";
                    $this->db->query($query);
                if($this->db->affected_rows())
                {
                    $response = ['error' => 0, 'message' => 'pinreference successfully saved'];
                }
                else
                {
                    $response = ['error' => 1, 'message' => 'Unable to save a pinreference'];
                }
            }
            return $response;
        }
        function pv($pin)
        {
            $this->db->select('value');
            $this->db->from($this->table_pintable);
            $this->db->where('pinno',$pin);
            $query = $this->db->get();
            return $query->row_array();
        }

        function update_user($ownid,$user_data)
        {
            $response         = ['error' => 1, 'message' => 'Invalid request'];
            $this->db->where('ownid',$ownid);
            $this->db->update($this->table_useroption,$user_data);
            if($this->db->affected_rows())
            {
                $response = ['error' => 0, 'message' => 'user table successfully saved'];
            }
            else
            {
                $response = ['error' => 1, 'message' => 'Unable to save a user table'];
            }
            return $response;
        }
        function left_right($insert_data)
        {
            $response         = ['error' => 1, 'message' => 'Invalid request'];

            if(!empty($insert_data))
            {
                $this->db->insert($this->table_left_right, $insert_data);
                if($this->db->affected_rows())
                {
                    $response = ['error' => 0, 'message' => 'Pintable successfully saved'];
                }
                else
                {
                    $response = ['error' => 1, 'message' => 'Unable to save a Pintable'];
                }
            }
            return $response;   
        }
       
    }
?>