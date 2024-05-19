<?php
class categories extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
		$this->load->model('courses_model');
		session_start();
	}
	
	public function index(){
		$action=$this->input->POST('action');
		
		switch ($action)
		{
			case "get_categories":
				$this->get_course_categories();
				break;
			
			case "insert_categories":
				$this->insert_categories();
				break;
		
			case "update_categories":
				$this->update_categories();
				break;
				
			case "delete_categories":
				$this->delete_categories();
				break;
				
			default:
				$data['title']='Training Services';
				$data['main_course_cats'] = $this->courses_model->get_main_cats_side();
				$this->load->view('templates/header',$data);
				$this->load->view('courses/courses_menu',$data);
				$this->load->view('courses/courses_cat',$data);
				$this->load->view('templates/footer');
		}
	}
	
	public function get_course_categories(){
		$start = $this->input->post('start');
		$limit = $this->input->post('limit');
		$filters=null;
		if($this->input->post('id')){
			$filters['`course_category`.`course_category_id`']=$this->input->post('id');
		}
		if($this->input->post('name_en')){
			$filters['`course_category`.`name_en`']=$this->input->post('name_en');
		}
		if($this->input->post('name_ar')){
			$filters['`course_category`.`name_ar`']=$this->input->post('name_ar');
		}
		$data['categories'] = $this->courses_model->get_course_categories($start,$limit,$filters);
		$total = $this->courses_model->get_course_categories_count($filters);
		echo '{"results":'.json_encode($data['categories']).',"total":'.json_encode($total).'}'; 
	}
	public function insert_categories(){
		$name_en = $this->input->post('name_en');
		$name_ar = $this->input->post('name_ar');
		$order = $this->input->post('_order');
		
		$this->courses_model->insert_categories($name_en,$name_ar,$order);
		
		echo '{"success":true,"msg":"done"}';
	}
	public function update_categories(){
		$id = $this->input->post('id');
		$name_en = $this->input->post('name_en');
		$name_ar = $this->input->post('name_ar');
		$order = $this->input->post('order');
		
		$this->courses_model->update_categories($id,$name_en,$name_ar,$order);
		
		echo '{"success":true,"msg":"done"}';
	}
	public function delete_categories(){
		$id = $this->input->post('course_category_id');
		$IDs = explode(",", $id);
		foreach ($IDs as &$id)
		{
			$this->courses_model->delete_categories($id);
		}
		echo '{"success":true,"msg":"done"}';
	}
}