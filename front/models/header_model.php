<?php
class header_model extends CI_Model
{
	function auth_cookie(){
	if (!isset($_SESSION['username']) && isset($_COOKIE["user"]))
		{
			$sql = "SELECT * FROM users WHERE user_id = '{$_COOKIE["user"]}'";
			$resultsql = $this->db->query($sql)->result_array();
			if($resultsql){
				$pass=$resultsql[0]['password'];
				$user=$resultsql[0]['username'];
				//if($pwd==$pass){
					//session already started in controller constructor : session_start();
					setcookie("user", $resultsql[0]['user_id'], time()+3600*48);
					$_SESSION['username'] = $resultsql[0]['username'];
					$_SESSION['user_id'] = $resultsql[0]['user_id'];
					$_SESSION['email'] = $resultsql[0]['email'];
					$_SESSION['role'] = $resultsql[0]['role'];
					$_SESSION['block'] = $resultsql[0]['block'];
					$_SESSION['active'] = $resultsql[0]['active'];
				//}
			}
		}
	}
	
	//not used yet
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
	// get the main menu items 
	function get_menu_items($lang="EN"){
		$menu = '';
		
		if ($lang == "EN")
			$sql = "SELECT topic_id , name_en as topic_title FROM topics where menu=1 ORDER BY topic_id ASC";
		else 
			$sql = "SELECT topic_id , name_ar as topic_title FROM topics where menu=1 ORDER BY topic_id ASC";
		$resultsql = $this->db->query($sql)->result_array();
		foreach ($resultsql as $row) 
		{
			$menu .= '<li class="dropdown">'
				.'<a class="dropdown-toggle" data-toggle="dropdown" href="">'.$row['topic_title'] .'</a>'
				.'<ul class="dropdown-menu">'
				.'<!-- links -->';
				if ($lang == "EN")
					$sql_page = "SELECT title_en as title_name , page_name FROM pages WHERE topic_id = '".$row['topic_id']."'";
				else 
					$sql_page = "SELECT  title_ar as title_name , page_name FROM pages WHERE topic_id = '".$row['topic_id']."'";
				$resultsql_page = $this->db->query($sql_page)->result_array();
				
				if ($row['topic_title'] == 'Training Services'){
					foreach ($resultsql_page as $row_page) 
					{
						$menu .='<li class="item"><a href="'.site_url('home/training_services').'/'.$row_page['page_name'].'">'.$row_page['title_name'].'</a></li>';
					}
				}
				else if ($row['topic_title'] == 'Careers'){
					foreach ($resultsql_page as $row_page) 
					{
						if ($row_page['page_name']=="vacancies")
							$menu .='<li class="item"><a href="'.site_url('vacancies').'">'.$row_page['title_name'].'</a></li>';
						else
							$menu .='<li class="item"><a href="'.site_url('home/page').'/'.$row_page['page_name'].'">'.$row_page['title_name'].'</a></li>';
					}
				}
				else 
				{
					foreach ($resultsql_page as $row_page) 
					{
						$menu .='<li class="item"><a href="'.site_url('home/page').'/'.$row_page['page_name'].'">'.$row_page['title_name'].'</a></li>';
					}
				}
				
				$menu .='</ul></li>';
		}
		echo $menu ;
	}
	// get filters combo contents
    
    function get_city_combo($lang="AR"){
	  
	  if ($lang == 'EN')
	
		$sql = "SELECT name as name FROM `cities`  ORDER BY `name`   DESC  ";
		
	   else 
	   
		$sql = "SELECT name_ar as name FROM `cities`  ORDER BY `name_ar`   DESC  ";	
		     $resultsql = $this->db->query($sql)->result_array();
		     $cities='<select id="citycmb"><option value="all">'.lang('select_city').'</option>';
		      foreach ($resultsql as $row) 
		    {
			
			$cities.='<option value="'.$row['name'].'">'.$row['name'].'</option>';
		   }
		   
		  $cities.='</select>';
		   return $cities;
		   }
	
			
		     
    function get_fields_combo($lang="AR"){
	  
	  if ($lang == 'EN')
	
		$sql = "SELECT course_category_id,name_en as name FROM `course_category`  ORDER BY `name_en`   DESC  ";
		else 
	   
		$sql = "SELECT course_category_id,name_ar as name FROM `course_category`  ORDER BY `name_ar`   DESC  ";
		     $resultsql = $this->db->query($sql)->result_array();
		     $fields='<select  id="catcmb"><option value="all">'.lang('select_category').'</option>';
		      foreach ($resultsql as $row) 
		    {
			
			$fields.='<option value="'.$row['course_category_id'].'">'.$row['name'].'</option>';
		   }
		   
		  $fields.='</select>';
		   return $fields;
		   }
	
	   
			
		    

    
	
}
?>