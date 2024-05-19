<?php
class vacancies_model extends CI_Model
{
	
	function get_vacancies_list($page,$sort="ASC",$lang="AR"){
		$date = date("Y-m-d");
		$limit=5;
		$start=($page-1)*$limit;
		if ($lang == "EN")
		$sql="SELECT vacancies.vacancy_id , vacancies.title_en as title ,vacancies.short_desc_en as description FROM `vacancies`  where vacancies.open='1'  ORDER BY _order ".$sort." limit ".$start." , ".$limit;
		
		else
		$sql = "SELECT vacancies.vacancy_id , vacancies.title_ar as title ,vacancies.short_desc_ar as description FROM `vacancies`  where vacancies.open='1'  ORDER BY _order ".$sort." limit ".$start." , ".$limit;
		
		$resultsql = $this->db->query($sql)->result_array();

		return $resultsql;
	}
	
	function get_vacancies_count($lang="AR"){
		if ($lang == "EN")
		$sql = "SELECT vacancies.title_en as title ,vacancies.description_en as description FROM `vacancies`  where vacancies.open='1'  ORDER BY _order ";
		else
		$sql = "SELECT vacancies.title_ar as title ,vacancies.description_ar as description FROM `vacancies`  where vacancies.open='1'  ORDER BY _order ";

		$query = $this->db->query($sql);
        return $query->num_rows();
	}
	
	function apply_vac($vac_id,$gender,$name,$email,$phone_number,$experince,$age){
		$data = array(	'vacancy_id' => $vac_id,
						'job_position_id' => 0,
						'gender' => $gender,
						'applicant_name' => $name,
						'age' => $age,
						'email' => $email,
						'mobile' => $phone_number,
						'experience_years' => $experince,
						'datetime' => date("Y-m-d H:i:s"));
        $this->db->insert('job_applications', $data);
		return $this->db->insert_id();
	}
	
	function update_files($application_id,$CV){
		if (strlen($CV)==0)
			$CV = 0;
		$data = array(	
				'cv_url' => $CV
				);
        $this->db->where('job_application_id',$application_id);
        $this->db->update('job_applications', $data);
	}
	
	function send_mail($name,$email,$subject,$message){
		self::emailer('omnia.mm@gmail.com',$email,$subject,$message);
	}
	//emailer
	function emailer($to,$sendermail,$title,$body)
	{
		$subject = $title;
		$message = $body;
		$headers = 'From: '.$sendermail . "\r\n" .
			'Reply-To: '.$to . "\r\n" .
			'MIME-Version: 1.0' . "\r\n".
			'Content-type: text/html; charset=utf-8' . "\r\n".
			'X-Mailer: PHP/' . phpversion();

		return mail($to, $subject, $message, $headers);

	}
}