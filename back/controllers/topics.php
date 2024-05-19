<?php
class topics extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
		$this->load->model('topics_model');
		session_start();
	}
	
    public function index(){ 
		$action=$this->input->POST('action');
		
		switch ($action)
		{
			case "get":
				$this->get_topics();
				break;
			
			case "insert":
				$this->insert_topics();
				break;
		
			case "update":
				$this->update_topics();
				break;
				
			case "delete":
				$this->delete_topics();
				break;
				case "get_topic_name":
				$this->get_topic_name($name_en);
				break;
				
			
				
			default:

				$data['title']='topics';
				
				$this->load->view('templates/header',$data);
				$this->load->view('articles/pages_menu',$data);
				$this->load->view('topics',$data);
				$this->load->view('templates/footer');
			
		}
	}
	
   
	public function get_topics(){
		$start = $this->input->post('start');
		$limit = $this->input->post('limit');
		$filters=null;
		if($this->input->post('id')){
			$filters['`topics`.`topic_id`']=$this->input->post('id');
		}
		if($this->input->post('name_en')){
			$filters['`topics`.`name_en`']=$this->input->post('name_en');
		}
		if($this->input->post('name_ar')){
			$filters['`topics`.`name_ar`']=$this->input->post('name_ar');
		}
		
	
		$data['topics'] = $this->topics_model->get_topics($start, $limit, $filters);
		$total = $this->topics_model->count_topics($filters);
		echo '{"results":'.json_encode($data['topics']).',"total":'.json_encode($total).'}'; 
	}

	public function insert_topics(){
		$name_en = $this->input->post('name_en');
		$name_ar = $this->input->post('name_ar');
		
		$this->topics_model->insert_topics($name_en,$name_ar);
		echo '{"success":true,"msg":"done"}';
	}

	public function update_topics(){
		$topic_id= $this->input->post('id');
		$name_en = $this->input->post('name_en');
		$name_ar = $this->input->post('name_ar');
		
		$this->topics_model->update_topics($topic_id,$name_en,$name_ar);
		echo '{"success":true,"msg":"done"}';
	}

	public function delete_topics(){
		$id = $this->input->post('id');
		$IDs = explode(",", $id);
		foreach ($IDs as &$id)
		{
			$this->topics_model->delete_topics($id);
		}
		echo '{"success":true,"msg":"done"}';
	}
	
}
?>