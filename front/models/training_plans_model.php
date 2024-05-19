<?php
class training_plans_model extends CI_Model
{
	function get_plans(){
		global $plans;
		
		
			$sql = "SELECT * FROM training_plans ORDER BY training_plan_name_en ASC";
		$resultsql = $this->db->query($sql)->result_array();
		$plans="<ul class='myul'>"; 
		foreach ($resultsql as $row) 
		{
			
			
			$plans.='<li><div id="plan_txt"><a href="'.ROOT_DIR.'files/training_plans/Training Plan 1.pdf'.'">'.$row['training_plan_name_en'].'</a></div><div id="plan_img"><a href="'.ROOT_DIR.'files/training_plans/Training Plan 1.pdf'.'"><img src="'.ROOT_DIR.'images/download.png" /></a></div></li>
			<li><div id="plan_txt"><a href="'.ROOT_DIR.'files/training_plans/Training Plan 1.pdf'.'">'.$row['training_plan_name_ar'].'</a></div><div id="plan_img"><a href="'.ROOT_DIR.'files/training_plans/Training Plan 1.pdf'.'"><img src="'.ROOT_DIR.'images/download.png" /></a></div></li>';
			
		}
		$plans.="</ul>";
		return $plans;
		
		
		// else 
			// $sql = "SELECT * FROM training_plans ORDER BY training_plan_name_ar ASC";
			
		// $resultsql = $this->db->query($sql)->result_array();
		// $plans="<ul class='myul'>"; 
		// foreach ($resultsql as $row) 
		// {
			
			// $plans.='<li><div id="plan_txt">'.$row['training_plan_name_ar'].'</div><div id="plan_img"><a href="'.ROOT_DIR.'files/training_plans/البرنامج التدريبى 1.pdf'.'"><img src="'.ROOT_DIR.'images/download.png" /></a></div></li>';
			
		// }
		// $plans.="</ul>";
		// return $plans;
	}



}
		
		
				
			