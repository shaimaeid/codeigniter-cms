<?php
class forms_model extends CI_Model
{
	function join_us($job,$gender,$name,$email,$phone_number,$experince,$age){
		$data = array(	'vacancy_id' => 0,
						'job_position_id' => $job,
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
	function get_jobs($lang="EN"){
		if($lang=="EN") 
			$sql = "SELECT job_position_title_en AS title, job_position_id FROM job_positions ";
		else 
			$sql = "SELECT job_position_title_ar AS title, job_position_id FROM job_positions ";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	function send_mail($name,$email,$subject,$message){
		$to_mail = "info@ebctraining.net";
		$sql = "SELECT value FROM settings WHERE settings.key = 'mail_st'";
		$data=$this->db->query($sql)->result_array();
		if ($data)
			$to_mail = $data[0]['value'];
		self::emailer($to_mail,$email,$subject,$message);
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
	
	function apply_course($name,$company,$job,$mobile,$phone,$email,$special_requirments,$course_id){
		$data = array(	'user_name' => $name,
						'company' => $company,
						'job_title' => $job,
						'mobile' => $mobile,
						'phone' => $phone,
						'email' => $email,
						'comments' => $special_requirments,
						'course_id' => $course_id,
						'register_date' => date("Y-m-d"));
        $this->db->insert('course_registrations', $data);
		
		$course_name = "";
		
		if ($course_id >0){
			$sql = "select course_name from courses where course_id = ".$course_id;
			$data=$this->db->query($sql)->result_array();
			if ($data)
				$course_name =  $data[0]['course_name'];
		}
		
		$subject = "Course Apply" ;
		$message = "New application : ".
					" <br/> Course Name : ".$course_name.
					" <br/> Name : ".$name.
					" <br/>Company : ".$company.
					" <br/>Job title : ".$job.
					" <br/>Mobile : ".$mobile.
					" <br/>Phone : ".$phone.
					" <br/>Email : ".$email.
					" <br/>Special Requirments : ".$special_requirments.
					" <br/> <br/> Regards, <br/> EBC Training Admin";
		
		$to_mail_st = "info@ebctraining.net";
		$sql = "SELECT value FROM settings WHERE settings.key = 'mail_st'";
		$data=$this->db->query($sql)->result_array();
		if ($data)
			$to_mail_st = $data[0]['value'];
			
		$to_mail_nd = "mhaggag@ebctraining.net";
		$sql_nd = "SELECT value FROM settings WHERE settings.key = 'mail_nd'";
		$data_nd=$this->db->query($sql_nd)->result_array();
		if ($data)
			$to_mail_nd = $data_nd[0]['value'];
		
		self::emailer($to_mail_st,'EBC site admin',$subject,$message);
		self::emailer($to_mail_nd,'EBC site admin',$subject,$message);
	}
}
