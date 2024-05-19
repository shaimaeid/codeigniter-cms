<?php
class articles extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
		$this->load->model('articles_model');
		$this->load->model('topics_model');
		session_start();
	}
	
    public function index(){ 
		$action=$this->input->POST('action');
		
		switch ($action)
		{
			case "get":
				$this->get_pages();
				break;
			
			case "insert":
				$this->insert_pages();
				break;
		
			case "update":
				$this->update_pages();
				break;
				
			case "delete":
				$this->delete_pages();
				break;
				
			case "get_topics":
				$this->get_topics();
				break;
			
			case "publish_all":
				$this->publish_all();
				break;
				
			case "change_publish":
				$this->change_publish();
				break;
				
			default:

				$data['title']='Articles';
				$data['sidebar']=$this->articles_model->get_side_bar();
				$this->load->view('templates/header',$data);
				$this->load->view('articles/pages_menu',$data);
				$this->load->view('articles/articles',$data);
				$this->load->view('templates/footer');
			
		}
	}
	    public function topic($id){ 
		$action=$this->input->POST('action');
		
		switch ($action)
		{
			case "get":
				$this->get_pages();
				break;
			
			case "insert":
				$this->insert_pages();
				break;
		
			case "update":
				$this->update_pages();
				break;
				
			case "delete":
				$this->delete_pages();
				break;
				
			case "get_topics":
				$this->get_topics();
				break;
				
			default:
				$data['topic_id']=$id;
				$data['topic'] = $this->topics_model->get_topic_name($id);
				$data['sidebar']=$this->articles_model->get_side_bar();
				$data['title']=$data['topic'].' '.'Articles';
				$this->load->view('templates/header',$data);
				$this->load->view('articles/pages_menu',$data);
				$this->load->view('articles/topic_pages',$data);
				$this->load->view('templates/footer');
			
		}
	}
	public function edit($name){ 
		$action=$this->input->POST('action');
		
		switch ($action)
		{
			case "get":
				$this->get_topic_pages();
				break;
			
			case "insert":
				$this->insert_pages();
				break;
		
			case "update":
				$this->update_pages();
				break;
				
			case "delete":
				$this->delete_pages();
				break;
				
			case "get_topics":
				$this->get_topics();
				break;
			
			case "load_form":
				$this->load_form();
				break;
				
			default:
                $data['page_name']=$name;
				$data['sidebar']=$this->articles_model->get_side_bar();
			    $data['pages_id'] = $this->articles_model->get_page_id($name);
				$data['title']= $data['page_name'];
				$this->load->view('templates/header',$data);
				$this->load->view('articles/pages_menu',$data);
				$this->load->view('articles/edit',$data);
				$this->load->view('templates/footer');
			
		}
	}
	public function get_pages(){
		$start = $this->input->post('start');
		$limit = $this->input->post('limit');

		$filters=null;
		if($this->input->post('id')){
			$filters['`pages`.`page_id`']=$this->input->post('id');
		}
		if($this->input->post('ar_title')){
			$filters['`pages`.`title_ar`']=$this->input->post('ar_title');
		}
		if($this->input->post('en_title')){
			$filters['`pages`.`title_en`']=$this->input->post('en_title');
		}
		if($this->input->post('topic_id')){
			$filters['`pages`.`topic_id`']=$this->input->post('topic_id');
		}
		$data['pages'] = $this->articles_model->get_pages($start, $limit, $filters);
		$total = $this->articles_model->count_pages($filters);
		echo '{"results":'.json_encode($data['pages']).',"total":'.json_encode($total).'}'; 
	}

	public function insert_pages(){
		$topic_id = $this->input->post('topic_id');
		$title_en = $this->input->post('title_en');
		$title_ar = $this->input->post('title_ar');
		$content_en = $this->input->post('content_en');
		$content_ar = $this->input->post('content_ar');
		$published=0;
		$is_published = $this->input->post('published');
		if($is_published == true){
		$published=1;
		}
		$page_name = $this->input->post('page_name');
		$this->articles_model->insert_pages($topic_id,$title_en,$title_ar,$content_en,$content_ar,$published,$page_name);
		
		echo '{"success":true,"msg":"done"}';
	}

	public function update_pages(){
	    $page_id= $this->input->post('id');
	    $topic_id = $this->input->post('topic_id');
		$title_en = $this->input->post('title_en');
		$title_ar = $this->input->post('title_ar');
		$content_en = $this->input->post('content_en');
		$content_ar = $this->input->post('content_ar');
		
		$published=0;
		$is_published = $this->input->post('published');
		if($is_published==true){
			$published=1;
		}
		$this->articles_model->update_pages($page_id,$topic_id,$title_en,$title_ar,$content_en,$content_ar,$published);
		
		echo '{"success":true,"msg":"done"}';
	}

	public function delete_pages(){
		$id = $this->input->post('id');
		$IDs = explode(",", $id);
		foreach ($IDs as &$id)
		{
			$this->articles_model->delete_pages($id);
		}
		echo '{"success":true,"msg":"done"}';
	}
	
	public function get_topics(){
		$data['topics'] = $this->articles_model->get_topics();
		echo '{"results":'.json_encode($data['topics']).'}';
	}
	
	public function load_form(){
		$page_id=$this->input->post('page_id');
		$rows = $this->articles_model->getpage_edit_data($page_id);
		$row=$rows[0];
		
		$data = array(
				'title_en' => $row->title_en,
				'title_ar' => $row->title_ar,
				'content_en' => $row->content_en,
				'content_ar' => $row->content_ar,
				'topic_id' => $row->topic_id,
				'published' => $row->published
			);
		echo '{"success":true,"data":'.json_encode($data).'}';
	}
	
	public function publish_all(){
		$this->articles_model->publish_all();
		echo '{"success":true,"msg":"done"}';
	}
	
	public function change_publish(){
		$page_id=$this->input->post('id');
		$publish=$this->input->post('publish');
		$publish_status = 0;
		if ($publish == 0)
			$publish_status = 1 ;
		
		$this->articles_model->change_publish($page_id,$publish_status);
		echo '{"success":true,"msg":"done"}';
	}
}
?>