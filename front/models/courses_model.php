<?php
class courses_model extends CI_Model
{
	
	function get_courses($page_name,$lang="AR"){
	if($lang=="AR")
	$caption="تصفح قائمة الدورات";
	else
	$caption="View Courses List";
	$sql = "SELECT course_category_id ".
			"FROM course_category ".
			"WHERE page_name ='".$page_name."'";
		$resultsql = $this->db->query($sql)->result_array();
		if ($resultsql)
			return '<a href="'.site_url('courses/listing/'.$resultsql[0]['course_category_id']).'">'.$caption.'</a>';
	}
	function get_course($id,$lang="AR"){
		if ($lang=="AR")
			$sql = "SELECT courses.course_id ,courses.course_category_id ,courses.name_ar AS course_name ,courses.description ,courses.course_date ,cities.name_ar AS city_name ,course_category.name_en AS course_category , ".
				"courses.duration ,courses.details_en AS details ,courses.city_id ,courses.upcoming ,courses.outlines_file,courses.details_ar ,courses.is_arabic ,courses.is_english ,courses.logo ".
				"FROM courses INNER JOIN course_category ON  courses.course_category_id = course_category.course_category_id ".
				"INNER JOIN cities ON courses.city_id = cities.city_id ".
				"WHERE course_id ='".$id."'";
				
		else 
			$sql = "SELECT courses.course_id ,courses.course_category_id ,courses.course_name AS course_name ,courses.description_ar as  description,courses.course_date ,cities.name AS city_name ,course_category.name_ar AS course_category , ".
				"courses.duration ,courses.details_ar AS details ,courses.city_id ,courses.upcoming ,courses.outlines_file ,courses.details_ar ,courses.is_arabic ,courses.is_english ,courses.logo ".
				"FROM courses INNER JOIN course_category ON  courses.course_category_id = course_category.course_category_id ".
				"INNER JOIN cities ON courses.city_id = cities.city_id ".
				"WHERE course_id ='".$id."'";
			
				
		
	      $resultsql = $this->db->query($sql)->result_array();

		  return $resultsql;
	     }
	
	function get_course_list($id,$page,$sort="ASC",$lang="AR"){
		/*view:SELECT `courses` . * , `cities`.name AS city_en, `cities`.name_ar AS city_ar, course_category.name_ar AS course_category_ar, course_category.name_en AS course_category_en
		FROM `courses` , cities, course_category
		WHERE courses.city_id = cities.city_id
		AND courses.course_category_id = course_category.course_category_id
		LIMIT 0 , 30 */
		
		$date = date("Y-m-d");
		$limit=5;
		$start=($page-1)*$limit;
		if ($lang == "EN")
		$sql = "SELECT `courses`.* , `cities`.name as city FROM `courses` , cities WHERE courses.city_id = cities.city_id and is_english=1  and course_category_id=".$id." and course_date >= '$date' order by course_date ".$sort." limit ".$start." , ".$limit;
		else
		$sql = "SELECT `courses`.* , `cities`.name_ar as city FROM `courses` , cities WHERE courses.city_id = cities.city_id and is_arabic=1 and  course_category_id=".$id." and course_date >= '$date' order by course_date ".$sort." limit ".$start." , ".$limit;
		//echo $sql;
		$resultsql = $this->db->query($sql)->result_array();

		return $resultsql;
	}
	function list_by_city($city,$page,$sort="ASC",$lang="AR"){
		$date = date("Y-m-d");
		$limit=5;
		$start=($page-1)*$limit;
		if ($lang == "EN")
		$sql = "SELECT `course_id`, `course_category_id`, `course_name`, `description`, `course_date`, `duration`, `details_en` as details, `city_id`, `upcoming`, `outlines_file`, `logo`, `is_arabic`, `is_english`, `city_en` as city ,  `course_category_en` as course_category FROM `courses_list`  WHERE  city_en='$city' and course_date >= '$date' order by course_date ".$sort." limit ".$start." , ".$limit;
		else
		$sql = "SELECT `course_id`, `course_category_id`, `course_name`, `description`, `course_date`, `duration`, `details_ar` as details, `city_id`, `upcoming`, `outlines_file`, `logo`, `is_arabic`, `is_english`, `city_ar` as city ,  `course_category_ar` as course_category FROM `courses_list`  WHERE  city_en='$city' and course_date >= '$date' order by course_date ".$sort." limit ".$start." , ".$limit;
		//echo $sql;
		$resultsql = $this->db->query($sql)->result_array();

		return $resultsql;
	}
	function list_all($city,$id,$month,$page,$sort="ASC",$lang="AR"){
		$citywhr="";
		$mwhr="";
		$catwhr="";
		if($city!=""&&$city!="all")
		$citywhr=" and city_en='$city' ";
		if(intval($id)>0)
		$catwhr=" and course_category_id=".$id;
		if($month!=""&&$month!="all"){
		$m1 =date("Y-m-d",strtotime( '1 '.$month.' '.date("Y")));
		$m2 =date("Y-m-d",strtotime( '31 '.$month.' '.date("Y")));
		$mwhr=" and course_date>'".$m1."' and  course_date<='".$m2."'  ";
		}
		
		$date = date("Y-m-d");
		$limit=5;
		$start=($page-1)*$limit;
		if ($lang == "EN")
		$sql = "SELECT `course_id`, `course_category_id`, `course_name`, `description`, `course_date`, `duration`, `details_en` as details, `city_id`, `upcoming`, `outlines_file`, `logo`, `is_arabic`, `is_english`, `city_en` as city ,  `course_category_en` as course_category FROM `courses_list`   WHERE ( course_date >= '$date' ".$mwhr." ) ".$citywhr.$catwhr." order by course_date ".$sort." limit ".$start." , ".$limit;
		else
		$sql = "SELECT `course_id`, `course_category_id`, `course_name`, `description`, `course_date`, `duration`, `details_ar` as details, `city_id`, `upcoming`, `outlines_file`, `logo`, `is_arabic`, `is_english`, `city_ar` as city ,  `course_category_ar` as course_category FROM `courses_list`   WHERE ( course_date >= '$date' ".$mwhr." ) ".$citywhr.$catwhr." order by course_date ".$sort." limit ".$start." , ".$limit;
		//echo $sql;
		$resultsql = $this->db->query($sql)->result_array();

		return $resultsql;
	}
	function get_course_category($id,$lang="AR"){
		if ($lang == "EN")
			$sql = "SELECT name_en AS name ".
					"FROM course_category ".
					"WHERE  course_category_id=".$id;
		else 
			$sql = "SELECT name_ar AS name ".
					"FROM course_category ".
					"WHERE  course_category_id=".$id;
		$resultsql = $this->db->query($sql)->result_array();
		if ($resultsql)
			return $resultsql[0]['name'];
	}
	function get_courses_count($id,$lang="AR"){
		if ($lang == "EN")
		$sql = "SELECT `courses`.* , `cities`.name as city FROM `courses` , cities WHERE courses.city_id = cities.city_id and is_english=1  and course_category_id=".$id;
		else
		$sql = "SELECT `courses`.* , `cities`.name_ar as city FROM `courses` , cities WHERE courses.city_id = cities.city_id and is_arabic=1 and  course_category_id=".$id;

		$query = $this->db->query($sql);
        return $query->num_rows();
	}
	function count_by_city($city,$lang="AR"){
		$date = date("Y-m-d");
		if ($lang == "EN")
		$sql = "SELECT `course_id`, `course_category_id`, `course_name`, `description`, `course_date`, `duration`, `details_en` as details, `city_id`, `upcoming`, `outlines_file`, `logo`, `is_arabic`, `is_english`, `city_en` as city ,  `course_category_en` as course_category FROM `courses_list`  WHERE  city_en='$city' and course_date >= '$date' ";
		else
		$sql = "SELECT `course_id`, `course_category_id`, `course_name`, `description`, `course_date`, `duration`, `details_ar` as details, `city_id`, `upcoming`, `outlines_file`, `logo`, `is_arabic`, `is_english`, `city_ar` as city ,  `course_category_ar` as course_category FROM `courses_list`  WHERE  city_en='$city' and course_date >= '$date' ";
		//echo $sql;
		$query = $this->db->query($sql);
        return $query->num_rows();
	}
		function count_all($id,$month,$city,$lang="AR"){
		$date = date("Y-m-d");
		$citywhr="";
		$mwhr="";
		$catwhr="";
		if($city!=""&&$city!="all")
		$citywhr=" and city_en='$city' ";
		if(intval($id)>0)
		$catwhr=" and course_category_id=".$id;
		if($month!=""&&$month!="all"){
		$m1 =date("Y-m-d",strtotime( '1 '.$month.' '.date("Y")));
		$m2 =date("Y-m-d",strtotime( '31 '.$month.' '.date("Y")));
		$mwhr=" and course_date>'".$m1."' and  course_date<='".$m2."'  ";
		}
		
		

		if ($lang == "EN")
		$sql = "SELECT `course_id`, `course_category_id`, `course_name`, `description`, `course_date`, `duration`, `details_en` as details, `city_id`, `upcoming`, `outlines_file`, `logo`, `is_arabic`, `is_english`, `city_en` as city ,  `course_category_en` as course_category FROM `courses_list`  WHERE ( course_date >= '$date' ".$mwhr." ) ".$citywhr.$catwhr." order by course_date ";
		else
		$sql = "SELECT `course_id`, `course_category_id`, `course_name`, `description`, `course_date`, `duration`, `details_ar` as details, `city_id`, `upcoming`, `outlines_file`, `logo`, `is_arabic`, `is_english`, `city_ar` as city ,  `course_category_ar` as course_category FROM `courses_list`  WHERE  ( course_date >= '$date' " .$mwhr." ) ".$citywhr.$catwhr." order by course_date ";
		//echo $sql;
		$query = $this->db->query($sql);
        return $query->num_rows();
	}
}