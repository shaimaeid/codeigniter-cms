<?php
class jobs_model extends CI_Model
{
	function get_applications($start=0,$limit=20,$filters=null){
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
		
		global $arrapplications;
		
		$sql = "SELECT job_applications.*  ".
				"FROM job_applications ".
				$where." LIMIT ".$start." , ".$limit;

		$resultsql = $this->db->query($sql)->result_array();
		foreach ($resultsql as $row) 
		{
			if ($row['gender']==1)
				$gender = "Female";
			else 
				$gender = "Male";
				
			$datetime="";
            if(strlen($row['datetime']>0))
				$datetime=date("Y-m-d",strtotime($row['datetime']));
			
			$cv_url="";
			if (strlen($row['cv_url']>0) || $row['cv_url']!=NULL)
				$cv_url='<a href="'.FRONT.'files/cv/'.$row['cv_url'].'" target="_blank">Download CV</a>';
				
			$vacancy_title = "";
			$job_position_title = "";
			
			if ($row['vacancy_id']>0 || $row['vacancy_id'] != NULL){ 
				$sql = "SELECT title_en AS vacancy_title FROM vacancies WHERE vacancy_id = ".$row['vacancy_id'];
				$data=$this->db->query($sql)->result_array();
				if ($data)
					$vacancy_title = $data[0]['vacancy_title'];
			} 
			if ($row['job_position_id']>0 || $row['job_position_id'] != NULL){
				$sql = "SELECT job_position_title_en AS job_position_title FROM job_positions WHERE job_position_id = ".$row['job_position_id'];
				$data=$this->db->query($sql)->result_array();
				if ($data)
					$job_position_title = $data[0]['job_position_title'];
			}
			
			$arrapplications[] = array(
				'job_application_id' => $row['job_application_id'],
				'vacancy_id' => $row['vacancy_id'],
				'job_position_id' => $row['job_position_id'],
				'applicant_name' => $row['applicant_name'],
				'gender' => $gender,
				'age' => $row['age'],
				'email' => $row['email'],
				'mobile' => $row['mobile'],
				'experience_years' => $row['experience_years'],
				'cv_url' => $cv_url,
				'datetime' => $datetime,
				'vacancy_title' => $vacancy_title,
				'job_position_title' => $job_position_title
			); 
		}
		return $arrapplications;
	}
	
	function count_applications($filters){
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
		$sql = "SELECT * FROM job_applications ".$where;
		$query = $this->db->query($sql);
        return $query->num_rows();
	}
	
	function count_all_apps(){
		$sql = "SELECT * FROM job_applications ";
		$query = $this->db->query($sql);
        return $query->num_rows();
	}
	
	// delete selected record
	function delete_applications($id){
		$this->db->where('job_application_id',$id);
        $this->db->delete('job_applications');
	}
}