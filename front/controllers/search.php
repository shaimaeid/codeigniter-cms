<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class search extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *

	 */
	public $language ='EN';
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
		$this->load->model('footer_model');
        $this->load->model('header_model');
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
		if ($this->language == 'AR')
		{   
			$data['image']="experts.png";
			$this->load->view('templates/header_inner_ar',$data);
			$this->load->view('search_ar');
			$this->load->view('templates/footer_ar');
		}
		else{
			    
                $data['image']="experts.png";   
				$this->load->view('templates/header-inner',$data);
				$this->load->view('search');
				$this->load->view('templates/footer');
		}
	}
	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */