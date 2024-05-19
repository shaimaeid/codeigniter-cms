<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class training_plans extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *

	 */
	public $language ='EN';
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
		$this->load->model('training_plans_model');
		$this->load->model('page_model');

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
	public function index()
	{
		$data=null;
		
			

			if ($this->language == 'AR')
			{   $data['image']= $this->page_model->get_image('training_plans');
				$data['training_plans'] = $this->training_plans_model->get_plans();
					
				$this->load->view('templates/header_inner_ar',$data);
				$this->load->view('training_plans',$data);
				$this->load->view('templates/footer_ar');
			}
			else 
			{   $data['image']= $this->page_model->get_image('training_plans');
                $data['training_plans'] = $this->training_plans_model->get_plans();
				$this->load->view('templates/header-inner',$data);
				$this->load->view('training_plans',$data);
				$this->load->view('templates/footer');
			}


	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */