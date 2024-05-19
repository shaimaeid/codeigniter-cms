<?php
class header_model extends CI_Model
{
	function get_user_menu(){
		$user_menu = '';
		if (strlen($_SESSION['username'])>0)
		{
			$user_menu = '<div id="leftlinksup">'.
							'<a href="#">Welcome'.$_SESSION['username'].'</a>'.
							'<a href="#">Help</a>'.
							'<a href="#">عربى</a>'.
						'</div>';
		}
		else 
		{
			$user_menu = '<div id="leftlinksup">'.
							'<a href="#">Sign up</a>'.
							'<a href="#">Register</a>'.
							'<a href="#">Help</a>'.
							'<a href="#">عربى</a>'.
						'</div>';
		}
		return $user_menu ;
	}
	function get_categories_ads(){
	$sql="SELECT `cat_id` , main_cats.title_en as title, sum( `ads_count` ) as count FROM `categories_ads` inner join main_cats on main_cats.main_cat_id=`categories_ads`.main_cat_id GROUP BY `categories_ads`.`main_cat_id` order by  sum( `ads_count` ) desc limit 0,3;"; 
	$resultsql = $this->db->query($sql)->result_array();
	$str="";
	$x=0;
		foreach ($resultsql as $row) 
		{
			if($x>0){$str.=",";}
			$str.="{ 'name': '".$row['title']."',   'data':".$row['count']." }";
			
			$x++;
		}
		return $str;
	
	}
	function get_locations_ads(){
	$sql="SELECT * FROM `locations_ads` order by ads_count desc limit 0,5;"; 
	$resultsql = $this->db->query($sql)->result_array();
	$str="";
	$x=0;
		foreach ($resultsql as $row) 
		{
			if($x>0){$str.=",";}
			$str.="{ 'name': '".$row['title_en']."',   'data':".$row['ads_count']." }";
			
			$x++;
		}
		return $str;
	
	}
}
?>