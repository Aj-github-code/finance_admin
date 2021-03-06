<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Dashboard_model extends CI_Model
    {
        public function __construct()
        {
            parent::__construct();
            $this->table_franchise 			= franchise_table::sql_table_franchise;
            $this->table_franchise_orders   = orders_table::sql_tbl_franchise_orders;
        }

        function get_count($conditions, $table)
        {
            $this->db->select('count(*) as count');
            $this->db->from($table);
            foreach ($conditions as $key => $value) {
            	if(is_array($value))
            	{
            		$this->db->where_in($key, $value);
            	}
            	else
            	{
            		$this->db->where($key, $value);
            	}
            }
            $query = $this->db->get();
            $count = $query->row_array()['count'];
            return $count;
        }

        function get_sum($conditions, $table, $column)
        {
        	$this->db->select_sum($column);
			$this->db->from($table);
            foreach ($conditions as $key => $value) {
            	if(is_array($value))
            	{
            		$this->db->where_in($key, $value);
            	}
            	else
            	{
            		$this->db->where($key, $value);
            	}
            }
			$query = $this->db->get();
            $sum = $query->row_array();
            return $sum[$column];
        }
    }