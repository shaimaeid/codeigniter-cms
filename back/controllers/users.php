<?php
class users extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
		$this->load->model('users_model');
		session_start();
	}
	
    public function index(){
		$action=$this->input->POST('action');

		switch ($action)
		{
			case "get":
				$this->get_users();
				break;
			
			case "insert":
				$this->insert_users();
				break;
		
			case "update":
				$this->update_users();
				break;
				
			case "delete":
				$this->delete_users();
				break;
			
			case "change_role":
				$this->change_role();
				break;
				
			case "block_user":
				$this->change_block_user();
				break;
			
			case "active_user":
				$this->active_user();
				break;
				
			case "validate_email":
				$this->validate_email();
				break;
				
			case "validate_username":
				$this->validate_username();
				break;
			
			case "reset_password":
				$this->reset_password();
				break;
				
			default:

			    $data['title']='Users';
				$this->load->view('templates/header',$data);
				$data['total_users'] = $this->users_model->all_users_count();
				$data['role']='all';
			    $this->load->view('users/users_menu',$data);
				$this->load->view('users',$data);
				$this->load->view('templates/footer');
			}
		}
		
	public function role($user_role){
		$action = $this->input->POST('action');

		switch ($action)
		{
			case "get":
				$this->get_users();
				break;
			
			case "insert":
				$this->insert_users();
				break;
		
			case "update":
				$this->update_users();
				break;
				
			case "delete":
				$this->delete_users();
				break;
			
			case "change_role":
				$this->change_role();
				break;
			
			case "block_user":
				$this->change_block_user();
				break;
				
			case "active_user":
				$this->active_user();
				break;
			
			case "validate_email":
				$this->validate_email();
				break;
				
			case "validate_username":
				$this->validate_username();
				break;
			
			case "reset_password":
				$this->reset_password();
				break;
				
			default:
				if ($user_role == 'user')
					$data['title']='Users';
				else 
					$data['title']='Admins';
				$this->load->view('templates/header',$data);
				$data['total_users'] = $this->users_model->all_users_count();
				$data['role']=$user_role;
			    $this->load->view('users/users_menu',$data);
				$this->load->view('users',$data);
				$this->load->view('templates/footer');
		}
	}
	public function profile(){
		$action = $this->input->POST('action');

		switch ($action)
		{
			case "load_form":
				$this->load_form();
				break;
				
			case "edit_profile":
				$this->edit_profile();
				break;
			case "validate_email":
				$this->validate_email();
				break;
				
			case "validate_username":
				$this->validate_username();
				break;
			
			case "reset_password":
				$this->reset_password();
				break;
				
			default:
				if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
					$data['title']=$_SESSION['username'].' Profile';
					$this->load->view('templates/header',$data);
					//$data['top_users'] = $this->users_model->top_adv_users();
					$data['total_users'] = $this->users_model->all_users_count();
					$this->load->view('users/users_menu',$data);
					$this->load->view('users/profile',$data);
					$this->load->view('templates/footer');
				}
		}
	}
	// USERS data Functions
	public function get_users(){
		$start = $this->input->post('start');
		$limit = $this->input->post('limit');
		$filters=null;
		if($this->input->post('id')){
			$filters['`users`.`user_id`']=$this->input->post('id');
		}
		if($this->input->post('username')){
			$filters['`users`.`username`']=$this->input->post('username');
		}
		if($this->input->post('phone_number')){
			$filters['`users`.`phone_number`']=$this->input->post('phone_number');
		}
		if($this->input->post('email')){
			$filters['`users`.`email`']=$this->input->post('email');
		}
		if($this->input->post('address')){
			$filters['`users`.`address`']=$this->input->post('address');
		}
		if ($this->input->post('user_role') && $this->input->post('user_role')!="all")
			$filters['`users`.`role`'] = $this->input->post('user_role');
		
		$data['users'] = $this->users_model->get_users($start, $limit, $filters);
		$total = $this->users_model->count_users($filters);
		echo '{"results":'.json_encode($data['users']).',"total":'.json_encode($total).'}'; 
	}
	public function insert_users(){
		$username = $this->input->post('username');
		$email = $this->input->post('email');
		$role = $this->input->post('user_role');
		$phone_number = $this->input->post('phone_number');
		$address= $this->input->post('address');
		$contact_person= $this->input->post('contact_person');
		$password=md5($this->input->POST('password'));
		$this->users_model->insert_users($username,$password,$email,$role,$phone_number,$address,$contact_person);
		
		echo '{"success":true,"msg":"done"}';
	}
	public function update_users(){
	    $user_id= $this->input->post('id');
	    $username = $this->input->post('username');
		$email = $this->input->post('email');
		$contact_person= $this->input->post('contact_person');
		$phone_number = $this->input->post('phone_number');
		$address= $this->input->post('address');
		
		$this->users_model->update_users($user_id,$username,$email,$contact_person,$phone_number,$address);
		
		echo '{"success":true,"msg":"done"}';
	}
	public function delete_users(){
		$id = $this->input->post('id');
		$IDs = explode(",", $id);
		foreach ($IDs as &$id)
		{
			$this->users_model->delete_users($id);
		}
		echo '{"success":true,"msg":"done"}';
	}
	public function change_role(){
		if ( $this->input->post('role')== 'admin')
			$this->downgrade_admin($this->input->post('id'));
		else 
			$this->upgrade_user($this->input->post('id'));
	}
	public function change_block_user(){
		if ($this->input->post('block')==0)
			$block = 1;
		else 
			$block = 0 ;
		$this->users_model->change_block_user($this->input->post('id'),$block);
		echo '{"success":true,"msg":"done"}';
	}
	public function active_user(){
		if ($this->input->post('active')==0)
			$active = 1;
		else 
			$active = 0 ;
		$this->users_model->active_user($this->input->post('id'),$active);
		echo '{"success":true,"msg":"done"}';
	}
	public function upgrade_user($id){
		$this->users_model->upgrade_user($id);
		echo '{"success":true,"msg":"done"}';
	}
	public function downgrade_admin($id){
		$this->users_model->downgrade_admin($id);
		echo '{"success":true,"msg":"done"}';
	}
	public function validate_email(){
		$email=$this->input->POST('email');
		$success=$this->users_model->validate_email($email);
		if($success){
			echo '{"success":true}';
			}
		else{
			echo '{"success":false}';
		}
	}
	public function validate_username()
	{
		$user=$this->input->POST('name');
		$success=$this->users_model->validate_username($user);
			if($success){
				echo '{"success":true}';
				}
			else{
				echo '{"success":false}';
			}
	}
	public function reset_password()
	{
		$this->users_model->reset_password($this->input->POST('id'));
		echo '{"success":true,"msg":"done"}';
	}
	public function load_form(){
		$id = $_SESSION['user_id'];
		$rows = $this->users_model->get_users_id($id);
		$row = $rows[0];
		$data = array(
				'user_id' => $row->user_id,
				'username' => $row->username,
				'email' => $row->email,
				'contact_person' => $row->contact_person,
				'address' => $row->address,
				'phone_number' => $row->phone_number				
			);
		echo '{"success":true,"data":'.json_encode($data).'}';
	}
	// editing the user profile data 
	public function edit_profile(){
		$user_id = $_SESSION['user_id'];
		$rows = $this->users_model->get_users_id($user_id);
		$row = $rows[0];
		
		if (md5($this->input->post('verify_password'))==$row->password)
		{
			$user_id = $_SESSION['user_id'];
			$rows = $this->users_model->get_users_id($user_id);
			$row = $rows[0];
			
			if (strlen($this->input->post('username'))>0)
				$username = $this->input->post('username');
			else 
				$username = $row->username ;
				
			if (strlen($this->input->post('email'))>0)
				$email = $this->input->post('email');
			else 
				$email = $row->email ;
				
			if (strlen($this->input->post('new_password'))>0)
				$password = md5($this->input->post('new_password'));
			else 
				$password = $row->password ;
				
			if (strlen($this->input->post('contact_person'))>0)
				$contact_persone = $this->input->post('contact_person');
			else 
				$contact_persone = $row->contact_person ;
			
			if (strlen($this->input->post('address'))>0)
				$address = $this->input->post('address');
			else 
				$address = $row->address ;
				
			if (strlen($this->input->post('phone_number'))>0)
				$phone_number = $this->input->post('phone_number');
			else 
				$phone_number = $row->phone_number ;
			
			$role = 'admin';
			
			$message = $this->users_model->update_user_profile($user_id,$username,$password,$email,$role,$contact_persone,$address,$phone_number);
		}
		else
			$message = "Wrong verifing password! Please retype the correct password to save your changes.";
		echo '{"success":true,"msg":"'.$message.'"}';
	}

}
?>