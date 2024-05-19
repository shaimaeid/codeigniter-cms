<?php
class footer_model extends CI_Model
{
	function get_topic_name($topic_id,$lang='AR'){
		if ($lang == 'EN')
			$sql = "SELECT name_en AS topic_title FROM topics WHERE topic_id = ".$topic_id;
		else 
			$sql = "SELECT name_ar AS topic_title FROM topics WHERE topic_id = ".$topic_id;
			
		$resultsql = $this->db->query($sql)->result_array();
		return $resultsql[0]['topic_title'];
	}
	
	function get_pages($topic_id,$lang='AR'){
		global $arrpages;
		
		if ($lang == 'EN')
			$sql = "SELECT page_id , title_en AS page_title FROM pages WHERE topic_id = ".$topic_id;
		else 
			$sql = "SELECT page_id , title_ar AS page_title FROM pages WHERE topic_id = ".$topic_id;
			
		$resultsql = $this->db->query($sql)->result_array();
		foreach ($resultsql as $row) 
		{
			$arrpages[] = array(
				'page_id' => $row['page_id'],
				'page_title' => $row['page_title']
				); 
		}
		return $arrpages;
	}
	
	function get_pages_ul($topic_id,$lang='AR'){
		global $arrpages;
		
		if ($lang == 'EN')
			$sql = "SELECT page_id ,page_name, title_en AS page_title FROM pages WHERE published=1 and topic_id = ".$topic_id;
		else 
			$sql = "SELECT page_id ,page_name, title_ar AS page_title FROM pages WHERE published=1 and topic_id = ".$topic_id;
			
		$resultsql = $this->db->query($sql)->result_array();
		$str='<ul>';
		foreach ($resultsql as $row) 
		{
		
	
			if ($row['page_name']=="vacancies")
				$str.='<li><a href="'.site_url('vacancies').'">'.$row['page_title'].'</a></li>';
			elseif (($row['page_name']=="financial_management" || $row['page_name']=="leadership"|| $row['page_name']=="contracts_management" || $row['page_name']=="maintenance" || $row['page_name']=="office_management"|| $row['page_name']=="business_management " || $row['page_name']=="sales" || $row['page_name']=="hr")){$str.='<li><a href="'.site_url('home/training_services').'/'.$row['page_name'].'">'.$row['page_title'].'</a></li>';}
			else 
				$str.='<li><a href="'.site_url('home/page').'/'.$row['page_name'].'">'.$row['page_title'].'</a></li>';
		}
		$str.='</ul>';
		return $str;
	}
	
	function Read_Key($key){

		$sql = "SELECT * FROM `settings` WHERE `key` ='$key' ;" ;
		$resultsql = $this->db->query($sql)->result_array();

		foreach ($resultsql as $row) 
		{
		$str=$row['value'];
		}

		return $str;
	}

	function get_news($lang="AR"){
		global $news;
		
		if ($lang == 'EN')
			{$sql = "SELECT page_name , title_en as title , short_en as short FROM `pages` WHERE `topic_id` =8 ORDER BY `title_en`   DESC  LIMIT 2";
			$news="News";}
			else 
			{
			$sql = "SELECT page_name , title_ar as title , short_ar as short FROM `pages` WHERE `topic_id` =8 ORDER BY `title_ar`  DESC   LIMIT 2";
			$news="الاخبار";
			}
			
		     $resultsql = $this->db->query($sql)->result_array();
		     $news="<div id='news'><h1>".$news."</h1>";
		      foreach ($resultsql as $row) 
		    {
			
			$news.='<div class="news_item">
			
			
			<div id="newsdiv">
			<img src="'.ROOT_DIR.'images/Iso.jpg"/>
			</div>
			<div id="pdiv">
			<a class="new_title" href="'.site_url('home/page').'/'.$row['page_name'].'">'.$row['title'].'</a>
			<p>'.$row['short'].'</p>
			</div>
			<div class="clearfix"></div>
			<div id="learn">
			<a href="'.site_url('home/page').'/'.$row['page_name'].'"><img src="'.ROOT_DIR.'images/read-more.png"/></a>
			</div></div>';
		   }
		   $news.="</div>";
		
		   return $news;
		   }
		   
			
		
	function get_citiesimage($lang="AR"){
		if ($lang == "EN")
		{
				$sql = 'SELECT name as city , image as city_image from cities where image!="" || 0';
				$cityimages="cities_images";
		}
		else{
				$sql = 'SELECT name as city , image_ar as city_image from cities where image_ar!="" || 0';
				$cityimages="cities_images_ar";
		}
		$resultsql = $this->db->query($sql)->result_array();
		$images="";
		foreach ($resultsql as $row) 
		{
			$images.='<a href="'.site_url("courses/by_city/".$row['city']."/1/ASC").'"><img src="'.ROOT_DIR.'images/'.$cityimages.'/'.$row['city_image'].'" width="332" height="380"/></a>';
		}

		return $images;
	}
	//echo template parts
	function Read_Template_Part($key){

		$sql = "SELECT * FROM `template_part` WHERE `template_part_id` ='$key' ;" ;
		$resultsql = $this->db->query($sql)->result_array();

		foreach ($resultsql as $row) 
		{
		$str=$row['value'];
		}

		return $str;
	}

	//echo all clients from db as <li><img...
	function get_clients(){
		$sql = "SELECT * from clients";
		$resultsql = $this->db->query($sql)->result_array();
		$images="";
		foreach ($resultsql as $row) 
		{  
		
			$images.='<li><a href="'.$row['website'].'"  target="_blank"><img  src="'.ROOT_DIR.'images/clients/'.$row['logo'].'" /></a></li>';

		}
		return $images;
	}
	function get_Features(){
		$sql = "SELECT * from template_part where key='features' limit 0,3";
		$resultsql = $this->db->query($sql)->result_array();
		$images="";
		foreach ($resultsql as $row) 
		{  
		
			$images.='<li>';
			$images.='<div class="mbx-img"><img  src="'.ROOT_DIR.'images/features/'.$row['image'].'" /></div>';
			$images.='<p>'.$row['content'].'</p>';
			$images.='<a href="'.$row['url'].'"  class="magicmore">Learn more</a>';
			$images.='</li>';

		}
		return $images;
	}		
}