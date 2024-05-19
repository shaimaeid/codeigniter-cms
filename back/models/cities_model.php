<?php
class cities_model extends CI_Model
{
	// return all the data from cities table
	function get_cities($start=0,$limit=10,$filters=null){
		$where="";
		if($filters){
			$and=false;
			$where=" where ";
			foreach($filters as $key=>$value)
			{
				if($and)
				{
					$where.=" and ";
				}
				if(is_numeric($value))
				{
					$where.=" ".$key." = '".$value."' ";
				}
				else
				{
					$where.=" ".$key." like '%".$value."%' ";
				}
				$and=true;
			}
		}
		global $arrcities;
		$sql = "SELECT cities.* ".
			   "FROM cities ".
			   $where." LIMIT ".$start." , ".$limit;
		$resultsql = $this->db->query($sql)->result_array();
		foreach ($resultsql as $row) 
		{
			$arrcities[] = array(
				'city_id' => $row['city_id'],
				'name' => $row['name'],
				'name_ar' => $row['name_ar'],
				'logo_en' => $row['image'],
				'logo_ar' => $row['image_ar']
				); 
		}
		return $arrcities;
	}
	// return one city according to the selected id
	function get_cities_id($id){
		global $arrcity;
		$sql = "SELECT cities.* ".
			   "FROM cities ".
			   "WHERE city_id = ".$id;
		$query = $this->db->query($sql);
		return $query->result();
	}
	// get the count of the returned cities
	function count_cities($filters=null){
	$where="";
		if($filters){
			$and=false;
			$where=" where ";
			foreach($filters as $key=>$value)
			{
				if($and)
				{
					$where.=" and ";
				}
				if(is_numeric($value))
				{
					$where.=" ".$key." = '".$value."' ";
				}
				else
				{
					$where.=" ".$key." like '%".$value."%' ";
				}
				$and=true;
			}
		}
		$sql = "SELECT * FROM cities ".$where;
		$query = $this->db->query($sql);
        return $query->num_rows();
	}
	// add new city 
	function insert_city($name_en,$name_ar){
		$data = array(	'name' => $name_en,
						'name_ar' => $name_ar);
        $this->db->insert('cities', $data);
		return $this->db->insert_id();
	}
	// update a city data
	function update_city($city_id,$name_en,$name_ar){
		$data = array(	
						'name' => $name_en,
						'name_ar' => $name_ar
						);
        $this->db->where('city_id',$city_id);
        $this->db->update('cities', $data);
	}
	// update the images
	function update_files($city_id,$logo_en,$logo_ar){
		if (strlen($logo_en)==0)
			$logo_en = 0;
		if (strlen($logo_ar)==0)
			$logo_ar =0;
		$data = array(	
				'image' => $logo_en,
				'image_ar' => $logo_ar
				);
        $this->db->where('city_id',$city_id);
        $this->db->update('cities', $data);
	}
	// delete selected record
	function delete_city($id){
		$this->db->where('city_id',$id);
        $this->db->delete('cities');
	}
}
?>