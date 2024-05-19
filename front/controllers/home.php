<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *

	 */
	public $language ='EN';
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
		$this->load->model('page_model');
		$this->load->model('courses_model');
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
	public function index()
	{
		$data=null;
		$action=$this->input->POST('action');
		switch ($action)
		{
			case "setlang":
				$this->setlang();
				break;
			
			
			default:
			if ($this->language == 'AR')
			{  

		   
				//$data['content'] = $this->page_model->get_page_content("home",$this->language);

				$this->load->view('templates/header_ar',$data);
				$this->load->view('templates/menu');
				$this->load->view('index',$data);
				$this->load->view('templates/footer-ar');
			}
			else 
			{  

			   //$data['content'] = $this->page_model->get_page_content("home",$this->language);
				$this->load->view('templates/header',$data);
				//$this->load->view('templates/menu');
				//$this->load->view('templates/header_top');
				$this->load->view('index',$data);
				$this->load->view('templates/clients');
				$this->load->view('templates/footer');
			}
		}

	}
	public function setlang(){
	$lang=$this->input->POST('lang');
		if($lang=="0"){
			$_SESSION['user_lang']="EN";
		}
		else if($lang=="1"){
			$_SESSION['user_lang']="AR";
		}
		echo '{"success":true}';
	}
	public function load_upcomming(){

		echo '{"success":true}';
	}
	public function ebc(){
	}
	public function training_services($page_name){
		if ($this->language == 'AR')
		{   
     		$data['image']= $this->page_model->get_image($page_name); 
			$data['content'] = $this->page_model->get_page_content($page_name,$this->language);
			$data['courses_link'] = $this->courses_model->get_courses($page_name,$this->language);
			$this->load->view('templates/header_inner_ar',$data);
			$this->load->view('training_services',$data);
			$this->load->view('templates/footer_ar');
		}
		else{
		        
		        $data['image']= $this->page_model->get_image($page_name); 
				$data['content'] = $this->page_model->get_page_content($page_name,$this->language);
				$data['courses_link'] = $this->courses_model->get_courses($page_name,$this->language);
				$this->load->view('templates/header-inner',$data);
				$this->load->view('training_services',$data);
				$this->load->view('templates/footer');
		}
	}
	public function consultation_services(){
	}
	public function clients(){
	}
	public function careers(){
	}
	public function contacts(){
	}
	public function page($page_name){
		if ($this->language == 'AR')
		{   
		    
		    $data['image']= $this->page_model->get_image($page_name); 
			$data['content'] = $this->page_model->get_page_content($page_name,$this->language);
			$this->load->view('templates/header_inner_ar',$data);
			$this->load->view('page_content',$data);
			$this->load->view('templates/footer_ar');
		}
		else{
		        
			$data['image']= $this->page_model->get_image($page_name); 
			$data['content'] = $this->page_model->get_page_content($page_name,$this->language);
			$this->load->view('templates/header-inner',$data);
			$this->load->view('page_content',$data);
			$this->load->view('templates/footer');
		}
	}
	public function listing($text,$page,$sort="ASC"){
		if ($this->language == 'AR')
		{   
			$data['content'] = $this->page_model->get_page_list($text,$page,$sort,"AR");
			$data['tot'] = ceil($this->page_model->get_page_count($text,"AR")/5);
			$this->load->view('templates/header_ar',$data);
			$this->load->view('page_list',$data);
			$this->load->view('templates/footer_ar');
		}
		else{
			$data['content'] = $this->page_model->get_page_list($text,$page,$sort,"EN");
			$data['tot'] = ceil($this->page_model->get_page_count($text,"EN")/5);
			$this->load->view('templates/header',$data);
			$this->load->view('page_list',$data);
			$this->load->view('templates/footer');
		}

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */