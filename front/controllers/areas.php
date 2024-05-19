<?php
class areas extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
		$this->load->model('areas_model');
		
		
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
			case "get":
				$this->get_areas();
				break;
			
			case "insert":
				$this->insert_areas();
				break;
		
			case "update":
				$this->update_areas();
				break;
				
			case "delete":
				$this->delete_areas();
				break;
				
			default:

				$data['title']='areas';
				$this->load->view('templates/header',$data);
				//$this->load->view('template/sidebar',$data);
				$this->load->view('areas',$data);
				$this->load->view('templates/footer');
			
		}
	}
	public function get_areas(){
		$start = $this->input->post('start');
		$limit = $this->input->post('limit');
		$filters=null;
		if($this->input->post('id')){
			$filters['`areas`.`areas_id`']=$this->input->post('id');
		}
		if($this->input->post('name')){
			$filters['`areas`.`areas_name`']=$this->input->post('name');
		}
		$data['areas'] = $this->areas_model->get_areas($start, $limit, $filters);
		$total = $this->areas_model->count_areas($filters);
		echo '{"results":'.json_encode($data['areas']).',"total":'.json_encode($total).'}'; 
	}

	public function insert_areas(){
		$area_name_en = $this->input->post('area_name_en');
		$area_name_ar = $this->input->post('area_name_ar');
		$map_id = $this->input->post('map_id');
		$this->areas_model->insert_areas($area_name_en,$area_name_ar,$map_id);
		echo '{"success":true,"msg":"done"}';
	}

	public function update_areas(){
		$area_id= $this->input->post('id');
		$area_name_en = $this->input->post('area_name_en');
		$area_name_ar = $this->input->post('area_name_ar');
		$map_id = $this->input->post('map_id');
		$this->areas_model->update_areas($area_id,$area_name_en,$area_name_ar,$map_id);
		echo '{"success":true,"msg":"done"}';
	}

	public function delete_areas(){
		$id = $this->input->post('id');
		$IDs = explode(",", $id);
		foreach ($IDs as &$id)
		{
			$this->areas_model->delete_areas($id);
		}
		echo '{"success":true,"msg":"done"}';
	}
}
?>