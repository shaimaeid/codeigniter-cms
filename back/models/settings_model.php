<?php
class settings_model extends CI_Model
{
// return all the data from settings table
function get_settings($start=0,$limit=10,$filters=null){
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
		global $arrsettings;
		$sql = "SELECT * FROM settings ".$where." LIMIT ".$start." , ".$limit;
		$resultsql = $this->db->query($sql)->result_array();
		foreach ($resultsql as $row) 
		{
			$arrsettings[] = array(
				'setting_id' => $row['setting_id'],
				'key' => $row['key'],
				'value' => $row['value'],
				
				); 
		}
		return $arrsettings;
	}
	// return one setting according to the selected id
	function get_setting_id($id){
		global $arrsettings;
		$sql = "SELECT * FROM settings WHERE setting_id = ".$id;
		$resultsql = $this->db->query($sql)->result_array();
		foreach ($resultsql as $row) 
		{
			$arrsettings = array(
				'setting_id' => $row['setting_id'],
				'key' => $row['key'],
				'value' => $row['value']
				
				); 
		}
		return $arrsettings;
	}
	// get the count of the returned settings
	function count_settings($filters=null){
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
		$sql = "SELECT * FROM settings ".$where;
		$query = $this->db->query($sql);
        return $query->num_rows();
	}
	// update a setting data
	function update_settings($setting_id=0,$key='',$value=''){
		$data = array(	
						'key' => $key,
						'value' => $value,
						
						);
        $this->db->where('setting_id',$setting_id);
        $this->db->update('settings', $data);
	  }
	}	
?>