<?php  class vacancies extends CI_Controller {
	/**
	Classifieds portal admin
	 */
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
		$this->load->model('vacancies_model');
		session_start();
	}
	 public function index(){ 
		if ($this->input->POST('action')=="insert" && $this->input->POST('vacancy_id')>0)
			$action = "update";
		else
			$action=$this->input->POST('action');
		
		switch ($action)
		{
			case "get":
				$this->get_vacancies();
				break;
			
			case "insert":
				$this->insert_vacancies();
				break;
		
			case "update":
				$this->update_vacancies();
				break;
				
			case "delete":
				$this->delete_vacancies();
				break;
			
			case "open_vacancy":
				$this->open_vacancy();
				break;
				
			case "load_form":
				$this->load_form();
				break;
				
			default:

				$data['title']='vacancies';
				$data['is_open'] = 'all' ;
				$this->load->view('templates/header',$data);
				$this->load->view('vacancies/vacancies_menu',$data);
				$this->load->view('vacancies/vacancies',$data);
				$this->load->view('templates/footer');
		}
	} 
	public function info($open){
		if ($this->input->POST('action')=="insert" && $this->input->POST('vacancy_id')>0)
			$action = "update";
		else
			$action=$this->input->POST('action');
		
		switch ($action)
		{
			case "get":
				$this->get_vacancies();
				break;
			
			case "insert":
				$this->insert_vacancies();
				break;
		
			case "update":
				$this->update_vacancies();
				break;
				
			case "delete":
				$this->delete_vacancies();
				break;
			
			case "open_vacancy":
				$this->open_vacancy();
				break;
				
			case "load_form":
				$this->load_form();
				break;
				
			default:
				if ($open == 1 )
					$data['title']='Open vacancies';
				else 
					$data['title']='Closed vacancies';
					
				$data['is_open'] = $open ;
				$this->load->view('templates/header',$data);
				$this->load->view('vacancies/vacancies_menu',$data);
				$this->load->view('vacancies/vacancies',$data);
				$this->load->view('templates/footer');
		}
	}
	
	public function get_vacancies(){
		$start = $this->input->post('start');
		$limit = $this->input->post('limit');
		$filters=null;
		if($this->input->post('id')){
			$filters['`vacancies`.`vacancy_id`']=$this->input->post('id');
		}
		if($this->input->post('title_en')){
			$filters['`vacancies`.`title_en`']=$this->input->post('title_en');
		}
		if($this->input->post('title_ar')){
			$filters['`vacancies`.`title_ar`']=$this->input->post('title_ar');
		}
		if ($this->input->post('is_open') && $this->input->post('is_open')!='all'){
			$filters['`vacancies`.`open`']=$this->input->post('is_open');
		}
		if ($this->input->post('is_open') == 0 && $this->input->post('is_open')!='all'){
			$filters['`vacancies`.`open`']=$this->input->post('is_open');
		}
		$data['vacancies'] = $this->vacancies_model->get_vacancies($start, $limit, $filters);
		$total = $this->vacancies_model->count_vacancies($filters);
		echo '{"results":'.json_encode($data['vacancies']).',"total":'.json_encode($total).'}'; 
	}
	public function insert_vacancies(){
		$title_en = $this->input->post('title_en');
		$title_ar = $this->input->post('title_ar');
		$description_en = $this->input->post('description_en');
		$description_ar = $this->input->post('description_ar');
		$_order = $this->input->post('_order');
		
		$this->vacancies_model->insert_vacancies($title_en,$title_ar,$description_en,$description_ar,$_order);
		echo '{"success":true,"msg":"done"}';
	}
	public function open_vacancy(){
		if ($this->input->post('open')==0)
			$open = 1;
		else 
			$open = 0 ;
		$this->vacancies_model->open_vacancy($this->input->post('id'),$open);
		echo '{"success":true,"msg":"done"}';
	}
	public function load_form(){
		$vacancy_id=$this->input->post('vacancy_id');
		if ($vacancy_id >0){			
			$rows = $this->vacancies_model->getvacancy_Id($vacancy_id);
			$row=$rows[0];
			$data = array(
						'vacancy_id' => $row->vacancy_id,
						'title_en' => $row->title_en,
						'title_ar' => $row->title_ar,
						'description_en' => $row->description_en,
						'description_ar' => $row->description_ar,
						'_order' => $row->_order
				);
			echo '{"success":true,"data":'.json_encode($data).'}';
		}
	}
	public function update_vacancies(){
		$vacancy_id=$this->input->post('vacancy_id');
		$title_en=$this->input->post('title_en');
		$title_ar=$this->input->post('title_ar');
		$description_en=$this->input->post('description_en');
		$description_ar=$this->input->post('description_ar');
		$_order=$this->input->post('_order');
		
		$this->vacancies_model->update_vacancies($vacancy_id,$title_en,$title_ar,$description_en,$description_ar,$_order);
		echo '{"success":true,"msg":"done"}';
	}
	public function delete_vacancies(){
		$id = $this->input->post('id');
		$IDs = explode(",", $id);
		foreach ($IDs as &$id)
		{
			$this->vacancies_model->delete_vacancies($id);
		}
		echo '{"success":true,"msg":"done"}';
	}
}