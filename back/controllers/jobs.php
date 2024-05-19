<?php
class jobs extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
		$this->load->model('jobs_model');
		session_start();
	}
	public function index(){
	
		$action = $this->input->post('action');
		
		switch ($action)
		{
			case "get":
				$this->get_applications();
				break;
			
			case "delete":
				$this->delete_applications();
				break;
			
			default:
				$data['title']='Job Application';
				$data['app_type']='all';
				$this->load->view('templates/header',$data);
				$data['total_applications'] = $this->jobs_model->count_all_apps();
				$this->load->view('jobs/jobs_menu',$data);
				$this->load->view('jobs/jobs_data',$data);
				$this->load->view('templates/footer');
		}
	}
	
	public function type($app_type){
		$action = $this->input->post('action');
		
		switch ($action)
		{
			case "get":
				$this->get_applications();
				break;
			
			case "delete":
				$this->delete_applications();
				break;
				
			default:
				if ($app_type == 'join')
					$data['title']='Job Application - Join Us';
				else 
					$data['title']='Job Application - Vacancies';
				$this->load->view('templates/header',$data);
				$data['total_applications'] = $this->jobs_model->count_all_apps();
				$data['app_type']=$app_type;
			    $this->load->view('jobs/jobs_menu',$data);
				$this->load->view('jobs/jobs_data',$data);
				$this->load->view('templates/footer');
		}
	}
	
	public function get_applications(){
		$start = $this->input->post('start');
		$limit = $this->input->post('limit');
		$filters=null;
		
		if ($this->input->post('app_type') && $this->input->post('app_type')!="all"){
			if ($this->input->post('app_type') == "join"){
				$filters['`job_applications`.`vacancy_id`'] = 0;
			}
			else{ 
				$filters['`job_applications`.`job_position_id`'] = 0;
			}
		}
				
		$data['applications'] = $this->jobs_model->get_applications($start,$limit,$filters);
		$total = $this->jobs_model->count_applications($filters);
		echo '{"results":'.json_encode($data['applications']).',"total":'.json_encode($total).'}'; 
	}
	
	public function delete_applications(){
		$id = $this->input->post('id');
		$IDs = explode(",", $id);
		foreach ($IDs as &$id)
		{
			$this->jobs_model->delete_applications($id);
		}
		echo '{"success":true,"msg":"done"}';
	}
}