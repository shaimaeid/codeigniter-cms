<?php
class main_tab_model extends CI_Model
{
	function ads_count(){
		$sql = "SELECT * FROM ads ";
		$query = $this->db->query($sql);
        return $query->num_rows();
	}
	function pages_count(){
		$sql = "SELECT * FROM pages ";
		$query = $this->db->query($sql);
        return $query->num_rows();
	}
	function users_count(){
		$sql = "SELECT * FROM users ";
		$query = $this->db->query($sql);
        return $query->num_rows();
	}
	function categories_count(){
		$sql = "SELECT * FROM categories ";
		$query = $this->db->query($sql);
        return $query->num_rows();
	}
	function main_cat_count(){
		$sql = "SELECT * FROM main_cats ";
		$query = $this->db->query($sql);
        return $query->num_rows();
	}
	function cities_count(){
		$sql = "SELECT * FROM cities ";
		$query = $this->db->query($sql);
        return $query->num_rows();
	}
}