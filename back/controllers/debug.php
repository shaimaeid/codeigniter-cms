<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Debug extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *

	 */
public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
		$this->lang->load('arabic', 'arabic');
		
	}
	
	public function index()
	{
		$data['language']=array('return'=>$this->lang->line('return'));
		$data['return']="No Return Defind";
		$mod=$this->input->POST('model');
		$func=$this->input->POST('function');
		$params=$this->input->POST('params');
		if($mod&&$func){
		$model=$this->load->model($mod);
		if(!empty($params)){
		$data['return']=$this->$mod->$func($params);
		}
		else{
		$data['return']=$this->$mod->$func();
		}
		}
		$this->load->view('debug',$data);
		
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */