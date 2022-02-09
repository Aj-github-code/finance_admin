<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Signin_model extends CI_Model
    {
        private $table_users                = signin_table::sql_tbl_users;
        private $table_user_ip_blacklist    = signin_table::sql_tbl_user_ip_blacklist;

        public function __construct()
        {
            parent::__construct();
            $this->search = '';
        }

        function get_user_data($type, $paramvalue) {
            if($type == 'email')
            {
                $this->db->where('email', $paramvalue);
            }
            else
            {
                $this->db->where('mobile', $paramvalue);
            }
            $this->db->where('status !=', '-1');
            $query=$this->db->get($this->table_users);
            $row = $query->row_array();
            if(!empty($row))
            {
                return $row;
            }
            else
            {
                return [];
            }
        }

        function update_user_table($id, $data) {
            $this->db->where('id', $id);
            $this->db->update($this->table_users, $data);
        }

        function check_user_ip_blacklist($column, $value) {
            $this->db->where($column, $value);
            $query      = $this->db->get($this->table_user_ip_blacklist);
            $num_rows   = $query->num_rows();
            return $num_rows;
        }

        function get_ip_blacklist($col, $value) {
            $this->db->where($col, $value);
            $query = $this->db->get($this->table_user_ip_blacklist);
            return $query;
        }

        function update_user_ip_blacklist($id, $data) {
            $this->db->where('id', $id);
            $this->db->update($this->table_user_ip_blacklist, $data);
        }

        function insert_user_ip_blacklist($data) {
            $this->db->insert($this->table_user_ip_blacklist, $data);
        }

        function delete_user_ip_blacklist($column, $value) {
            $this->db->where($column, $value);
            $this->db->delete($this->table_user_ip_blacklist);
        }
    }