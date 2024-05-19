<?php
class page_model extends CI_Model
{
	function get_page_content($page_name,$lang="AR"){
		if ($lang == "EN")
			$sql = "SELECT pages.content_en AS content ".
					"FROM pages ".
					"WHERE pages.page_name LIKE '%".$page_name."%'";
		else 
			$sql = "SELECT pages.content_ar AS content ".
					"FROM pages ".
					"WHERE pages.page_name LIKE '%".$page_name."%'";
		$resultsql = $this->db->query($sql)->result_array();
		if ($resultsql)
			return $resultsql[0]['content'];
	}
	function get_image($page_name){
		
			$sql = "SELECT pages.banner_image FROM pages
                     WHERE pages.page_name LIKE '%".$page_name."%'";
		$resultsql = $this->db->query($sql)->result_array();
		if ($resultsql)
			return $resultsql[0]['banner_image'];
	}
	function get_page_list($text,$page,$sort="ASC",$lang="AR"){

		$limit=5;
		$start=($page-1)*$limit;
		if ($lang == "EN")
		$sql="SELECT `page_id`, `page_name`, `topic_id`, `title_en` as title, `short_en` as short, `content_en` as content, `published`, `banner_image` FROM `pages`  WHERE MATCH (`content_en` , `content_ar` ) AGAINST ('$text' IN BOOLEAN MODE) ORDER BY `title_en` ".$sort." limit ".$start." , ".$limit;
		
		else
		$sql = "SELECT `page_id`, `page_name`, `topic_id`,  `title_ar` as title, `short_ar` as short,  `content_ar` as content, `published`, `banner_image` FROM `pages`   WHERE MATCH (`content_en` , `content_ar`) AGAINST ('$text' IN BOOLEAN MODE) ORDER BY `title_ar` ".$sort." limit ".$start." , ".$limit;
		
		$resultsql = $this->db->query($sql)->result_array();

		return $resultsql;
	}
	function get_page_count($text,$lang="AR"){

		if ($lang == "EN")
		$sql="SELECT `page_id`, `page_name`, `topic_id`, `title_en` as title, `short_en` as short, `content_en` as content, `published`, `banner_image` FROM `pages`  WHERE MATCH (`content_en` , `content_ar` ) AGAINST ('$text' IN BOOLEAN MODE) ";
		
		else
		$sql = "SELECT `page_id`, `page_name`, `topic_id`,  `title_ar` as title, `short_ar` as short,  `content_ar` as content, `published`, `banner_image` FROM `pages`   WHERE MATCH (`content_en` , `content_ar`) AGAINST ('$text' IN BOOLEAN MODE) ";
		
		$query = $this->db->query($sql);
        return $query->num_rows();
	}

}