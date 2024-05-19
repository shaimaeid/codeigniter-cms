<?php
class clients_model extends CI_Model
{
	// return all the data from cities table
	function get_clients($start=0,$limit=10,$filters=null){
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
		global $arrclients;
		$sql = "SELECT * ".
			   "FROM clients ".
			   $where." LIMIT ".$start." , ".$limit;
		$resultsql = $this->db->query($sql)->result_array();
		foreach ($resultsql as $row) 
		{
			$arrclients[] = array(
				'client_id' => $row['client_id'],
				'logo' => $row['logo'],
				'name' => $row['name'],
				'website' => '<a href="http://'.$row['website'].'" target="_blank" >'.$row['website'].'</a>',
				'home' => $row['home']
				); 
		}
		return $arrclients;
	}
	// return one city according to the selected id
	function get_client_id($id){
		$sql = "SELECT * FROM clients WHERE client_id = ".$id;
		$query = $this->db->query($sql);
		return $query->result();
	}
	// get the count of the returned cities
	function count_clients($filters=null){
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
		$sql = "SELECT * FROM clients ".$where;
		$query = $this->db->query($sql);
        return $query->num_rows();
	}
	// add new city 
	function insert_clients($name,$website,$is_home){
		$data = array(	'name' => $name,
						'website' => $website,
						'home' => $is_home);
        $this->db->insert('clients', $data);
		return $this->db->insert_id();
	}
	// update a city data
	function update_clients($client_id,$name,$website,$is_home){
		$data = array(	'name' => $name,
						'website' => $website,
						'home' => $is_home);
        $this->db->where('client_id',$client_id);
        $this->db->update('clients', $data);
	}
	// insert or update the images 
	function update_files($client_id,$logo){
		$data = array(	'logo' => $logo  );
        $this->db->where('client_id',$client_id);
        $this->db->update('clients', $data);
	}
	// delete selected record
	function delete_clients($id){
		$this->db->where('client_id',$id);
        $this->db->delete('clients');
	}
}
?>