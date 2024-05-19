<?php
class template_part_model extends CI_Model
{

	function get_templates($start=0,$limit=10,$filters=null){
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
		global $arrtemplates;
		$sql = "SELECT * ".
			   "FROM template_part ".
			   $where." LIMIT ".$start." , ".$limit;
		$resultsql = $this->db->query($sql)->result_array();
		foreach ($resultsql as $row) 
		{	
			$update_time="";
            if(strlen($row['update_time']>0))
				$update_time=date("Y-m-d",strtotime($row['update_time']));
			
			$arrtemplates[] = array(
				'template_part_id' => $row['template_part_id'],
				'title' => $row['title'],
				'content' => $row['content'],
				'update_time' => $update_time,
				'image' =>$row['image']
				); 
		}
		return $arrtemplates;
	} 
	
	function get_template_id($id){
		$sql = "SELECT * FROM template_part WHERE template_part_id = ".$id;
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function count_templates($filters=null){
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
		$sql = "SELECT * FROM template_part ".$where;
		$query = $this->db->query($sql);
        return $query->num_rows();
	}
	
	function insert_template($title,$content,$update_time){
		$data = array(	'title' => $title,
						'content' => $content,
						'update_time' => $update_time);
        $this->db->insert('template_part', $data);
		return $this->db->insert_id();
	}
	
	function update_template($template_part_id,$title,$content,$update_time){
		$data = array(	'title' => $title,
						'content' => $content,
						'update_time' => $update_time);
        $this->db->where('template_part_id',$template_part_id);
        $this->db->update('template_part', $data);
	}
	
	function update_files($template_part_id,$image){
		$data = array(	'image' => $image  );
        $this->db->where('template_part_id',$template_part_id);
        $this->db->update('template_part', $data);
	}
	
	function delete_template($id){
		$this->db->where('template_part_id',$id);
        $this->db->delete('template_part');
	}
}
?>