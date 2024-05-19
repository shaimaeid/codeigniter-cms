<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Courses extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *

	 */
	public $language ='EN';
	public $course_id = 0;
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
		$this->load->model('courses_model');
		$this->load->model('footer_model');
        $this->load->model('header_model');
		$this->load->model('forms_model');
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
	public function index()
	{
		

	}

	public function listing($id,$page=1,$sort="ASC"){
		if ($this->language == 'AR')
		{   
			$data['content'] = $this->courses_model->get_course_list($id,$page,$sort,"AR");
			$data['tot'] = ceil($this->courses_model->get_courses_count($id,"AR")/5);
			$data['title']=$this->courses_model->get_course_category($id,"AR");
			$this->load->view('templates/header_ar',$data);
			$this->load->view('list_courses_ar',$data);
			$this->load->view('templates/footer_ar');
		}
		else{
				$data['content'] = $this->courses_model->get_course_list($id,$page,$sort,"EN");
				$data['tot'] = ceil($this->courses_model->get_courses_count($id,"EN")/5);
				$data['title']=$this->courses_model->get_course_category($id,"EN");
				$this->load->view('templates/header',$data);
				$this->load->view('list_courses',$data);
				$this->load->view('templates/footer');
		}
	}
	public function list_courses($city,$id,$month,$page=1,$sort="ASC"){
	$city=str_replace ("%20"," ",$city);
	if ($this->language == 'AR')
		{   
			$data['content'] = $this->courses_model->list_all($city,$id,$month,$page,$sort,"AR");
			$data['tot'] = ceil($this->courses_model->count_all($id,$month,$city,"AR")/5);
			//$data['title']=$this->courses_model->get_course_city($id,"AR");
			$this->load->view('templates/header_ar',$data);
			$this->load->view('list_all',$data);
			$this->load->view('templates/footer_ar');
		}
		else{
				$data['content'] = $this->courses_model->list_all($city,$id,$month,$page,$sort,"EN");
				$data['tot'] = ceil($this->courses_model->count_all($id,$month,$city,"EN")/5);
				//$data['title']=$this->courses_model->get_course_city($id,"EN");
				$this->load->view('templates/header',$data);
				$this->load->view('list_all',$data);
				$this->load->view('templates/footer');
		}
	}
	public function by_city($id,$page=1,$sort="ASC"){
	$id=str_replace ("%20"," ",$id);
		if ($this->language == 'AR')
		{   
			$data['content'] = $this->courses_model->list_by_city($id,$page,$sort,"AR");
			$data['tot'] = ceil($this->courses_model->count_by_city($id,"AR")/5);
			//$data['title']=$this->courses_model->get_course_city($id,"AR");
			$this->load->view('templates/header_ar',$data);
			$this->load->view('list_by_city',$data);
			$this->load->view('templates/footer_ar');
		}
		else{
				$data['content'] = $this->courses_model->list_by_city($id,$page,$sort,"EN");
				$data['tot'] = ceil($this->courses_model->count_by_city($id,"EN")/5);
				//$data['title']=$this->courses_model->get_course_city($id,"EN");
				$this->load->view('templates/header',$data);
				$this->load->view('list_by_city',$data);
				$this->load->view('templates/footer');
		}
	}
	public function details($id){
		if ($this->language == 'AR')
		{   
			//$data['content'] = $this->courses_model->get_course_list($id,"AR");
			$data['course']=$this->courses_model->get_course($id,"AR");
			$this->load->view('templates/header_ar',$data);
			$this->load->view('course_details',$data);
			$this->load->view('templates/footer_ar');
		}
		else{
			$data['course'] = $this->courses_model->get_course($id,"EN");
			$this->load->view('templates/header',$data);
			$this->load->view('course_details',$data);
			$this->load->view('templates/footer');
		}
	}
	
	public function apply($course_id)
	{
		$this->course_id = $course_id;
		$action = $this->input->post('action');
		switch ($action)
		{
			case "apply":
				$this->apply_course();
				break;
		
			default:
				if ($this->language == 'AR')
				{   
					$data['course_id'] = $course_id;
					$this->load->view('templates/header_ar');
					$this->load->view('apply',$data);
					$this->load->view('templates/footer_ar');
				}
				else{
					$data['course_id'] = $course_id;
					$this->load->view('templates/header');
					$this->load->view('apply',$data);
					$this->load->view('templates/footer');
				}
		}
	}
	
	public function apply_course(){
		$name = $this->input->POST('name');
		$company = $this->input->POST('company');
		$job = $this->input->POST('job');
		$mobile = $this->input->POST('mobile');
		$phone = $this->input->POST('phone');
		$email = $this->input->POST('email');
		$special_requirments = $this->input->POST('special_requirments');
		
		$course_id = $this->input->POST('course_id');
		
		$this->forms_model->apply_course($name,$company,$job,$mobile,$phone,$email,$special_requirments,$course_id);
		
		echo '{"success":"true","msg":"done"}';
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */