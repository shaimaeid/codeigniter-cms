<?php
class clients extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
		$this->load->model('clients_model');
		$config['upload_path'] = '../images/clients/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '2048';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$this->load->library('upload', $config);
		session_start();
		
	}
	
    public function index(){ 
		if ($this->input->POST('action')=='insert' && $this->input->POST('client_id')>0)
			$action = 'update';
		else
			$action=$this->input->POST('action');
		
		switch ($action)
		{
			case "get":
				$this->get_clients();
				break;
			
			case "insert":
				$this->insert_clients();
				break;
		
			case "update":
				$this->update_clients();
				break;
				
			case "delete":
				$this->delete_clients();
				break;
				
			case "load_form":
				$this->load_form();
				break;
			
			default:
				$data['title']='Clients';
				$this->load->view('templates/header',$data);
				$this->load->view('clients/clients_menu',$data);
				$this->load->view('clients/clients',$data);
				$this->load->view('templates/footer');
		}
	}
	public function get_clients(){
		$start = $this->input->post('start');
		$limit = $this->input->post('limit');
		$filters=null;
		if($this->input->post('id')){
			$filters['`clients`.`client_id`']=$this->input->post('id');
		}
		if($this->input->post('name')){
			$filters['`clients`.`name`']=$this->input->post('name');
		}
		if($this->input->post('website')){
			$filters['`clients`.`website`']=$this->input->post('website');
		}
		
		$data['clients'] = $this->clients_model->get_clients($start, $limit, $filters);
		$total = $this->clients_model->count_clients($filters);
		echo '{"results":'.json_encode($data['clients']).',"total":'.json_encode($total).'}'; 
	}

	public function insert_clients(){
		$name = $this->input->post('name');
		$website = $this->input->post('website');
		
		$home = $this->input->post('home');
		$is_home = 0 ;
		if ($home == 'yes')
			$is_home = 1 ;
			
		$client_id = $this->clients_model->insert_clients($name,$website,$is_home);
		
		$logo ="";
		$msg = "";
		
		if($this->upload->do_upload('logo')){
			$file0=$this->upload->data();
			$logo = $file0['file_name'];
			$msg="Done ";
		}
		else 
			$msg = $this->upload->display_errors('<p>', '</p>');
			
		$this->clients_model->update_files($client_id,$logo);	
		
		echo '{"success":true,"msg":"'.$msg.'"}';
	}

	public function update_clients(){
		$client_id = $this->input->post('client_id');
		
		$name = $this->input->post('name');
		$website = $this->input->post('website');
		
		$home = $this->input->post('home');
		$is_home = 0 ;
		if ($home == 'yes')
			$is_home = 1 ;
			
		$this->clients_model->update_clients($client_id,$name,$website,$is_home);
		
		
		$logo ="";
		$msg = "";
		
		if($this->upload->do_upload('logo')){
			$file0=$this->upload->data();
			$logo = $file0['file_name'];
			$msg="Done ";
		}
		else 
			$msg = $this->upload->display_errors('<p>', '</p>');
			
		$this->clients_model->update_files($client_id,$logo);	
		
		echo '{"success":true,"msg":"'.$msg.'"}';
	}

	public function delete_clients(){
		$id = $this->input->post('id');
		$IDs = explode(",", $id);
		foreach ($IDs as &$id)
		{
			$this->clients_model->delete_clients($id);
		}
		echo '{"success":true,"msg":"done"}';
	}
	
	public function load_form(){
		$client_id=$this->input->post('client_id');
		if ($client_id > 0){
			$rows = $this->clients_model->get_client_id($client_id);
			$row=$rows[0];
			$data = array(
					'name' => $row->name,
					'website' => $row->website,
					'home' => $row->home,
					'logo' => $row->logo
				);
			echo '{"success":true,"data":'.json_encode($data).'}';
		}
	}
	
}
?>