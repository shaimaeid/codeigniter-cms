<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class home extends CI_Controller {

	/**
	Classifieds portal admin
	 */
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
		session_start();
	}
	public function index()
	{

		
		$data['title']='Home';
		$this->load->view('templates/header',$data);
		$this->load->view('templates/menu',$data);
		$this->load->view('home',$data);
		$this->load->view('templates/footer');
	}
}

/* End of file */
