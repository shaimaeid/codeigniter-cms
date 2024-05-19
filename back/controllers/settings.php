<?php
class settings extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
		$this->load->model('settings_model');
		$this->load->model('main_tab_model');
		
		session_start();
	}
	
    public function index(){ 
		$action=$this->input->POST('action');
		
		switch ($action)
		{
			case "get":
				$this->get_settings();
				break;
			
			case "insert":
				$this->insert_settings();
				break;
		
			case "update":
				$this->update_settings();
				break;
				
			case "delete":
				$this->delete_settings();
				break;
				
			default:
				$data['title']='settings';
				$this->load->view('templates/header',$data);
				$this->load->view('settings/settings_menu',$data);
				$this->load->view('settings/settings',$data);
				$this->load->view('templates/footer');
			
		}
	}
	public function get_settings(){
		$start = $this->input->post('start');
		$limit = $this->input->post('limit');
		$filters=null;
		if($this->input->post('id')){
			$filters['`settings`.`setting_id`']=$this->input->post('id');
		}
		if($this->input->post('key')){
			$filters['`settings`.`key`']=$this->input->post('key');
		}
		if($this->input->post('value')){
			$filters['`settings`.`value`']=$this->input->post('value');
		}
		
		$data['settings'] = $this->settings_model->get_settings($start, $limit, $filters);
		$total = $this->settings_model->count_settings($filters);
		echo '{"results":'.json_encode($data['settings']).',"total":'.json_encode($total).'}'; 
	}

	public function insert_settings(){
		$name = $this->input->post('name');
		$this->settings_model->insert_settings($name);
		echo '{"success":true,"msg":"done"}';
	}

	public function update_settings(){
		$id= $this->input->post('id');
		$key = $this->input->post('key');
		$value = $this->input->post('value');
		$this->settings_model->update_settings($id,$key,$value);
		echo '{"success":true,"msg":"done"}';
	}

	public function delete_settings(){
		$id = $this->input->post('id');
		$IDs = explode(",", $id);
		foreach ($IDs as &$id)
		{
			$this->settings_model->delete_settings($id);
		}
		echo '{"success":true,"msg":"done"}';
	}
}
?>