<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Help extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *

	 */
	public $language ='EN';
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
		$this->load->model('main_cats_model');
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
		$data['title']='Mogeeb :: Classifieds Portal';
		$data['slogan']='Over <b id="num">4,570,490</b> Free Local Classifieds';
		$data['copyright']='Copyright © 2013 MOGEEB Classfieds EG.';
		$data['cats_list']=$this->main_cats_model->get_categories_list($this->language);
		$data['cats_drop']=$this->main_cats_model->get_categories_dropList($this->language);
		$data['areas_drop']=$this->main_cats_model->get_areas($this->language);
		if ($this->language == 'AR')
		{
		$this->load->view('templates/header_ar',$data);
		$this->load->view('help',$data);
		$this->load->view('templates/footer_ar');
		}
		else{
		$this->load->view('templates/header',$data);
		$this->load->view('help',$data);
		$this->load->view('templates/footer');
		}
		

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */