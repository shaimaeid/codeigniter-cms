<?php
class articles_model extends CI_Model
{

	// return all the data from pages table
	function get_pages($start=0, $limit=10,$filters=null){
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
		global $arrpages;
		$sql = "SELECT pages.* , topics.name_en AS topic_name FROM pages ".
				"INNER JOIN topics ON pages.topic_id = topics.topic_id ".$where." LIMIT ".$start." , ".$limit;
		$resultsql = $this->db->query($sql)->result_array();
		foreach ($resultsql as $row) 
		{
			$arrpages[] = array(
				'page_id' => $row['page_id'],
				'topic_id' => $row['topic_id'],
				'title_en' => $row['title_en'],
				'title_ar' => $row['title_ar'],
				'published' => $row['published'],
				'topic_name' => $row['topic_name'],
				'page_name' => $row['page_name']
				); 
		}
		return $arrpages;
	}
	// return one pages according to the selected id
	function get_pages_id($id){
		global $arrpage;
		$sql = "SELECT * FROM pages WHERE page_id = ".$id;
		$resultsql = $this->db->query($sql)->result_array();
		foreach ($resultsql as $row) 
		{
			$arrpage = array(
				'page_id' => $row['page_id'],
				'topic_id' => $row['topic_id'],
				'title_en' => $row['title_en'],
				'title_ar' => $row['title_ar'],
				//'content' => $row['content'],
				'published' => $row['published']
				); 
		}
		return $arrpage;
	}
	//get page by name 
	function get_pages_name($id){
		global $arrpage;
		$sql = "SELECT * FROM pages WHERE page_id = '$id'";
		$resultsql = $this->db->query($sql)->result_array();
		foreach ($resultsql as $row) 
		{

				$name= $row['title_en'];

		}
		return $name;
		
	}
	//get page by id
	function get_page_id($name){
		global $arrpage;
		$sql = "SELECT * FROM pages WHERE page_name = '$name'";
		$resultsql = $this->db->query($sql)->result_array();
		foreach ($resultsql as $row) 
		{

				$id= $row['page_id'];

		}
		return $id;
		
	}
	//
	function get_pages_list(){
		$list="";
		$sql = "SELECT * FROM pages ";
		$resultsql = $this->db->query($sql)->result_array();
		foreach ($resultsql as $row) 
		{
			$list.="<li><a href='details/".$row['page_name']."'>".$row['title_en']."</a></li>";
		}
		return $list;
	}
	// get the count of the returned pages
	function count_pages($filters=null){
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
		$sql = "SELECT * FROM pages ".$where;
		$query = $this->db->query($sql);
        return $query->num_rows();
	}
	// add new pages 
	function insert_pages($topic_id=0,$title_en='',$title_ar='',$content_en='',$content_ar='',$published,$page_name){
		$data = array(	'topic_id' => $topic_id,
						'title_en' => $title_en,
						'title_ar' => $title_ar,
						'content_en' => $content_en,
						'content_ar' => $content_ar,
						'published' => $published,
						'page_name' => $page_name
						);
        $this->db->insert('pages', $data);
	}
	// update a pages data
	function update_pages($page_id=0,$topic_id=0,$title_en='',$title_ar='',$content_en='',$content_ar='',$published){
		$data = array(	'topic_id' => $topic_id,
						'title_en' => $title_en,
						'title_ar' => $title_ar,
						'content_en' => $content_en,
						'content_ar' => $content_ar,
						'published' => $published
						);
        $this->db->where('page_id',$page_id);
        $this->db->update('pages', $data);
	}
	// delete selected record
	function delete_pages($id){
		$this->db->where('page_id',$id);
        $this->db->delete('pages');
	}
	// combo functions 
	function get_topics(){
		$sql = "SELECT topic_id, CONCAT( name_en, ' / ', name_ar ) AS topic_name FROM topics ORDER BY topic_id ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	//Function to get the data filled in the form 
	function getpage_edit_data($page_id)
	{
		$sql = "SELECT * FROM pages WHERE page_id = ".$page_id;
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function publish_all()
	{
		$sql = "Update pages set published = 1  ";
		$this->db->query($sql);
	}
	
	function change_publish($page_id,$publish_status)
	{
		$data = array('published' => $publish_status);
        $this->db->where('page_id',$page_id);
        $this->db->update('pages', $data);
	}
	function get_side_bar(){
		$sql = "SELECT topic_id , name_en FROM topics ";
		$main_topics = "";
		$resultsql = $this->db->query($sql)->result_array();
		foreach ($resultsql as $row) 
		{
			$main_topics .= '<li><a title="" href=" '.site_url("articles/topic/".$row['topic_id'].'"');
			$main_topics .= '><span class="icos-books2"></span>'.$row['name_en'].'</a></li>';
		}
		return $main_topics ;
	}

}
?>