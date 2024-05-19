<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contactus extends CI_Controller {

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

		$this->load->model('forms_model');
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
		if ($this->language == 'AR')
		{   
			$this->load->view('templates/header_ar');
			$this->load->view('contactus');
			$this->load->view('templates/compact_footer');
		}
		else{
		$this->load->view('templates/header_en');
			$this->load->view('contactus');
			$this->load->view('templates/compact_footer');
		}

	}
	public function send_mail(){

		$name = htmlspecialchars($_POST['txtName']);
		$email = htmlspecialchars($_POST['txtEmail']);;
		$subject = htmlspecialchars($_POST['txtSubject']);;
		$message = htmlspecialchars($_POST['txtText']);;

		$this->forms_model->send_mail($name,$email,$subject,$message);   
		echo '1';
	}
	
}

/* End of file contactus.php */
/* Location: ./application/controllers/contactus.php */