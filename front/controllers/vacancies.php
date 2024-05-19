<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vacancies extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *

	 */
	public $language ='EN';
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
		$this->load->model('vacancies_model');
		$this->load->model('footer_model');
        $this->load->model('header_model');
		
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
		redirect(site_url("vacancies/listing")."/1/ASC", 'refresh');
	}
	
	public function listing($page=1,$sort="ASC"){
		if ($this->language == 'AR')
		{   
			$data['content'] = $this->vacancies_model->get_vacancies_list($page,$sort,"AR");
			$data['tot'] = ceil($this->vacancies_model->get_vacancies_count("AR")/5);
			$this->load->view('templates/header_ar',$data);
			$this->load->view('vacancies',$data);
			$this->load->view('templates/footer_ar');
		}
		else{
			$data['content'] = $this->vacancies_model->get_vacancies_list($page,$sort,"EN");
			$data['tot'] = ceil($this->vacancies_model->get_vacancies_count("EN")/5);
			$this->load->view('templates/header',$data);
			$this->load->view('vacancies',$data);
			$this->load->view('templates/footer');
		}
	}
	
	public function apply($vacancy_id){
		$action=$this->input->POST('action');
		
		switch ($action)
		{
			case "apply_vac":
				$this->apply_vac();
				break;
				
			default: 
				$data['vac_id'] = $vacancy_id;
				$this->load->view('templates/header');
				$this->load->view('apply_vac',$data);
				$this->load->view('templates/footer');
		}
	}
	
	public function apply_vac(){
		$vac_id = $this->input->POST('vac_id');
		$gender = $this->input->POST('value');
		$name = $this->input->POST('name');
		$email = $this->input->POST('email');
		$phone_number = $this->input->POST('phone_number');
		$experince = $this->input->POST('experince');
		$age = $this->input->POST('age');
		
		$application_id = $this->vacancies_model->apply_vac($vac_id,$gender,$name,$email,$phone_number,$experince,$age);
		
		$CV ="";
		$msg = "";
		
		if($this->upload->do_upload('cv')){
			$file0=$this->upload->data();
			$CV = $file0['file_name'];
			$msg="Done";
		}
		else 
			$msg = $this->upload->display_errors('<p>', '</p>');
		
		//editing to add files
		$this->vacancies_model->update_files($application_id,$CV);
		
		$subject = "Join US CV";
		$message = "Dear EBC admin., <br/> ".$name." has uploaded his/her CV to vacancies section <br/> Regards, <br/> EBC Team ";
		$this->vacancies_model->send_mail($name,$email,$subject,$message);
		
		echo '{"success":"true","msg":"done"}';
		
	}
	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */