<?php
class topics_model extends CI_Model
{
	// return all the data from topics table
	function get_topics($start=0, $limit=10,$filters=null){
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
		global $arrtopics;
		$sql = "SELECT * FROM topics ".$where." LIMIT ".$start." , ".$limit;
		$resultsql = $this->db->query($sql)->result_array();
		foreach ($resultsql as $row) 
		{
			$arrtopics[] = array(
				'topic_id' => $row['topic_id'],
				'name_en' => $row['name_en'],
				'name_ar' => $row['name_ar']
				); 
		}
		return $arrtopics;
	}
	// return one topics according to the selected id
	function get_topic_id($id){
		global $arrtopic;
		$sql = "SELECT * FROM topics WHERE topic_id = ".$id;
		$resultsql = $this->db->query($sql)->result_array();
		foreach ($resultsql as $row) 
		{
			$arrtopic = array(
				'topic_id' => $row['topic_id'],
				'name_en' => $row['name_en'],
				'name_ar' => $row['name_ar']
				); 
		}
		return $arrtopic;
	}
	
	// return topic name according to the selected id
	function get_topic_name($id){
		global $name;
		$sql = "SELECT * FROM topics WHERE topic_id = ".$id;
		$resultsql = $this->db->query($sql)->result_array();
		foreach ($resultsql as $row) 
		{

				$name= $row['name_en'];

		}
		return $name;
		
	}
	
	
	// get the count of the returned topics
	function count_topics($filters=null){
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
		$sql = "SELECT * FROM topics ".$where;
		$query = $this->db->query($sql);
        return $query->num_rows();
	}
	// add new topics 
	function insert_topics($name_en='',$name_ar=''){
		$data = array(	'name_en' => $name_en,
						'name_ar' => $name_ar
						);
        $this->db->insert('topics', $data);
	}
	// update a fields data
	function update_topics($topic_id=0,$name_en='',$name_ar=''){
		$data = array(	'name_en' => $name_en,
						'name_ar' => $name_ar
						);
        $this->db->where('topic_id',$topic_id);
        $this->db->update('topics', $data);
	}
	// delete selected record
	function delete_topics($id){
		$this->db->where('topic_id',$id);
        $this->db->delete('topics');
	}
}
?>