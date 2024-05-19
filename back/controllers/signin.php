<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class signin extends CI_Controller {

	/**
	Classifieds portal admin
	 */
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
		$this->load->model('users_model');
		session_start();
	}
	public function index()
	{
		$action=$this->input->POST('action');
		
		switch ($action)
		{
			case "authenticate":
				$this->authenticate();
				break;
			
			
			default:
				$data['title']='Admin panel';
				$this->load->view('templates/header_login',$data);
				$this->load->view('signin',$data);
				$this->load->view('templates/footer_login');
		}
	}
	public function authenticate()
	{
		$user=$this->input->POST('username');
		$pwd=md5($this->input->POST('password'));
		$success=$this->users_model->admin_login($user,$pwd);
		if($success=="true"){
			echo '{"success":true}';
		}
		else{
			echo '{"success":false,"error":"'.$success.'"}';
		}
	}
}

/* End of file */
