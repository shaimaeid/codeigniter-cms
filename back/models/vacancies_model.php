<?php
class vacancies_model extends CI_Model
{
	function get_vacancies($start, $limit, $filters){
		$where="";
		if($filters){
			$and=false;
			$where=" where ";
			foreach($filters as $key=>$value)
			{
				if($and)
				{
					$where.=" and ";
				}
				if(is_numeric($value))
				{
					$where.=" ".$key." = '".$value."' ";
				}
				else
				{
					$where.=" ".$key." like '%".$value."%' ";
				}
				$and=true;
			}
		}
		global $arrvacancies;
		$sql = "SELECT * FROM vacancies ".$where." LIMIT ".$start." , ".$limit;
		$resultsql = $this->db->query($sql)->result_array();
		foreach ($resultsql as $row) 
		{
			$arrvacancies[] = array(
				'vacancy_id' => $row['vacancy_id'],
				'title_en' => $row['title_en'],
				'title_ar' => $row['title_ar'],
				'description_en' => $row['description_en'],
				'description_ar' => $row['description_ar'],
				'open' => $row['open'],
				'_order' => $row['_order']
				); 
		}
		return $arrvacancies;
	}
	function getvacancy_Id($vacancy_id){
		$sql = "SELECT * FROM vacancies WHERE vacancy_id = '".$vacancy_id."'";
		$query = $this->db->query($sql);
		return $query->result();
	}
	function count_vacancies($filters){
		$where="";
		if($filters){
			$and=false;
			$where=" where ";
			foreach($filters as $key=>$value)
			{
				if($and)
				{
					$where.=" and ";
				}
				if(is_numeric($value))
				{
					$where.=" ".$key." = '".$value."' ";
				}
				else
				{
					$where.=" ".$key." like '%".$value."%' ";
				}
				$and=true;
			}
		}
		$sql = "SELECT * FROM vacancies ".$where;
		$query = $this->db->query($sql);
        return $query->num_rows();
	}
	function insert_vacancies($title_en,$title_ar,$description_en,$description_ar,$_order){
		$data = array(	'title_en' => $title_en, 
						'title_ar' => $title_ar,
						'description_en' => $description_en,
						'description_ar' => $description_ar,
						'_order' => $_order,
						'open' => 0);
        $this->db->insert('vacancies', $data);
	}
	function open_vacancy($id,$open){
		$data = array(	'open' => $open	);
        $this->db->where('vacancy_id',$id);
        $this->db->update('vacancies', $data);
	}
	function update_vacancies($vacancy_id,$title_en,$title_ar,$description_en,$description_ar,$_order){
		$data = array(	
						'title_en' => $title_en,
						'title_ar' => $title_ar,
						'description_en' => $description_en,
						'description_ar' => $description_ar,
						'_order' => $_order
					);
        $this->db->where('vacancy_id',$vacancy_id);
        $this->db->update('vacancies', $data);
	}
	function delete_vacancies($id){
		$this->db->where('vacancy_id',$id);
        $this->db->delete('vacancies');
	}
}