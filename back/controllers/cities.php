<?php
class cities extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
		$this->load->model('cities_model');
		$config['upload_path'] = '../images/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '2048';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$this->load->library('upload', $config);
		session_start();
	}
	
    public function index(){ 
		if ($this->input->POST('action')=='insert' && $this->input->POST('city_id')>0)
			$action = 'update';
		else
			$action = $this->input->POST('action');
		
		switch ($action)
		{
			case "get":
				$this->get_cities();
				break;
			
			case "insert":
				$this->insert_city();
				break;
		
			case "update":
				$this->update_city();
				break;
				
			case "delete":
				$this->delete_city();
				break;
				
			case "load_form":
				$this->load_form();
				break;
				
			default:
				$data['title']='cities';
				$this->load->view('templates/header',$data);
				$this->load->view('courses/courses_menu',$data);
				$this->load->view('cities/cities',$data);
				$this->load->view('templates/footer');
			
		}
	}
	public function get_cities(){
		$start = $this->input->post('start');
		$limit = $this->input->post('limit');
		$filters=null;
		if($this->input->post('id')){
			$filters['`cities`.`city_id`']=$this->input->post('id');
		}
		if($this->input->post('name')){
			$filters['`cities`.`name`']=$this->input->post('name');
		}
		if($this->input->post('name_ar')){
			$filters['`cities`.`name_ar`']=$this->input->post('name_ar');
		}
		
		$data['cities'] = $this->cities_model->get_cities($start, $limit, $filters);
		$total = $this->cities_model->count_cities($filters);
		echo '{"results":'.json_encode($data['cities']).',"total":'.json_encode($total).'}'; 
	}

	public function insert_city(){
		$name_en = $this->input->post('name');
		$name_ar = $this->input->post('name_ar');
		
		$city_id = $this->cities_model->insert_city($name_en,$name_ar);
		//adding files
		
		//mkdir($training_folder, 0745,true);
		$city_folder = "";
		//adding files
		$msg="Done ";
		//uploading logo_ar
		$logo_en ="";
		if($this->upload->do_upload('logo_en')){
			$file0=$this->upload->data();
			$logo_en = $file0['file_name'];
			
			$city_folder = "../images/cities_images";
			
			copy("../images/".$logo_en,$city_folder."/".$logo_en);
			unlink("../images/".$logo_en);
			
			$msg = "Done";
		}
		else {
			$msg = $this->upload->display_errors('<p>', '</p>');
		}
		//uploading logo_ar
		$logo_ar ="";
		if($this->upload->do_upload('logo_ar')){
			$file0=$this->upload->data();
			$logo_ar = $file0['file_name'];
			$city_folder = "../images/cities_images_ar";
			copy("../images/".$logo_ar,$city_folder."/".$logo_ar);
			unlink("../images/".$logo_ar);
			$msg = "Done";
		}
		else {
			$msg = $this->upload->display_errors('<p>', '</p>');
		}
		
		//editing to add files
		$this->cities_model->update_files($city_id,$logo_en,$logo_ar);
		
		
		echo '{"success":true,"msg":"'.$msg.'"}';
	}

	public function update_city(){
		
		$city_id= $this->input->post('city_id');
		$name_en = $this->input->post('name');
		$name_ar = $this->input->post('name_ar');
		$country_id = $this->input->post('country_id');
		$this->cities_model->update_city($city_id,$name_en,$name_ar);
		

		//mkdir($training_folder, 0745,true);
		$city_folder = "";
		//adding files
		$msg="Done ";
		//uploading logo_ar
		$logo_en ="";
		if($this->upload->do_upload('logo_en')){
			$file0=$this->upload->data();
			$logo_en = $file0['file_name'];
			
			$city_folder = "./images/cities_images";
			copy("./images/".$logo_en,$city_folder."/".$logo_en);
			unlink("./images/".$logo_en);
			
			$msg = "Done";
		}
		else {
			$msg = $this->upload->display_errors('<p>', '</p>');
		}
		//uploading logo_ar
		$logo_ar ="";
		if($this->upload->do_upload('logo_ar')){
			$file0=$this->upload->data();
			$logo_ar = $file0['file_name'];
			$city_folder = "./images/cities_images_ar";
			copy("./images/".$logo_ar,$city_folder."/".$logo_ar);
			unlink("./images/".$logo_ar);
			$msg = "Done";
		}
		else {
			$msg = $this->upload->display_errors('<p>', '</p>');
		}
		
		//editing to add files
		$this->cities_model->update_files($city_id,$logo_en,$logo_ar);
		
		
		echo '{"success":true,"msg":"'.$msg.'"}';
	}

	public function delete_city(){
		$id = $this->input->post('id');
		$IDs = explode(",", $id);
		foreach ($IDs as &$id)
		{
			$this->cities_model->delete_city($id);
		}
		echo '{"success":true,"msg":"done"}';
	}
	
	public function upload_files($file,$city_folder,$city_id){
		if($this->upload->do_upload($file)){
			$file0=$this->upload->data();
			$file = $file0['file_name'];
			copy("./images/".$file,$city_folder."/".$file);
			unlink("./images/".$file);
			return $file;
		}
	}
	
	public function load_form(){
		$city_id = $this->input->post('city_id');
		if ($city_id > 0){
			$rows = $this->cities_model->get_cities_id($city_id);
			$row=$rows[0];
			$data = array(
					'city_id' => $row->city_id,
					'name' => $row->name,
					'name_ar' => $row->name_ar,
					'logo_en' => $row->image,
					'logo_ar' => $row->image_ar
				);
			echo '{"success":true,"data":'.json_encode($data).'}';
		}
	}
}
?>