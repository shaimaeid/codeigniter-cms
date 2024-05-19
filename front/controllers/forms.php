<?php
class forms extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
		$this->load->model('forms_model');
		
		$config['upload_path'] ='./files/cv/';
		$config['allowed_types'] = 'docx|doc|pdf';
		$config['max_size']	= '2048';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$this->load->library('upload', $config);
		
		session_start();
		if(isset($_SESSION['user_lang'])){
		$this->language = $_SESSION['user_lang'];
		}
		else{
		$this->language = 'EN';
		}
		
		if ($this->language == 'AR')
			$this->lang->load('arabic', 'arabic');
		else 
			$this->lang->load('english', 'english');
			$this->load->helper('language');
	
	}
	
	 public function index(){ 
		$action=$this->input->POST('action');
		
		switch ($action)
		{
			case "join":
				$this->join_us();
				break;
				
			case "get_jobs":
				$this->get_jobs();
				break;
			
			case "send_mail":
				$this->send_mail();
				break;
				
			default:
				$this->load->view('templates/header',$data);
				$this->load->view('templates/footer');
		}
	}
	
	public function join_us(){
		$job = $this->input->POST('job_position_id');
		$gender = $this->input->POST('value');
		$name = $this->input->POST('name');
		$email = $this->input->POST('email');
		$phone_number = $this->input->POST('phone_number');
		$experince = $this->input->POST('experince');
		$age = $this->input->POST('age');
		$application_id = $this->forms_model->join_us($job,$gender,$name,$email,$phone_number,$experince,$age);
		
		$CV ="";
		$msg = "Done";
		
		if($this->upload->do_upload('cv')){
			$file0=$this->upload->data();
			$CV = $file0['file_name'];
			$msg="Done";
		}
		else 
			$msg = $this->upload->display_errors('<p>', '</p>');
		
		//editing to add files
		$this->forms_model->update_files($application_id,$CV);
		
		$subject = "Join US CV";
		$message = "Dear EBC admin., <br/> ".$name." has uploaded his/her CV to join us section <br/> Regards, <br/> EBC Team ";
		$this->forms_model->send_mail($name,$email,$subject,$message);
		
		echo '{"success":"true","msg":"'.$msg'"}';
	}
	
	public function get_jobs(){
		$data['jobs'] = $this->forms_model->get_jobs($this->language);
		echo '{"results":'.json_encode($data['jobs']).'}';
	}
	
	public function send_mail(){
		$name = $this->input->POST('name');
		$email = $this->input->POST('email');
		$subject = $this->input->POST('subject');
		$message = $this->input->POST('message');
		$this->forms_model->send_mail($name,$email,$subject,$message);
		
		echo '{"success":"true","msg":"Message Sent!"}';
	}
}