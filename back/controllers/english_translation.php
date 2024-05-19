<?php
class english_translation extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
		$this->load->model('main_tab_model');
		
		session_start();
	}
	
    public function index(){ 
				$data['title']='English Language File';
				$this->load->view('templates/header',$data);
				$this->load->view('settings/settings_menu',$data);
				$this->load->view('settings/english_translation',$data);
				$this->load->view('templates/footer');
			
		}
	}
	
	

?>