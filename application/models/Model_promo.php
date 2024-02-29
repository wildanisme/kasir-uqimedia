<?php 
	defined('BASEPATH') or exit('No direct script access allowed');
	
	
	class Model_promo extends CI_model{
		
		public  $versi;
		private $user;
		private $api_key;
		private $_table = 'template_promo';
		
		function __construct()
		{
			parent::__construct();
			
			$this->api_key     = info()['api_key'];
			$this->versi       = info()['version'];
			$this->pro         = info()['user_pass'];
			
			$this->user = info()['user_name'];
		}
		
		function getReport($params = array()){
			// print_r($params);
			
			$this->db->select('
			`report`.`message`,
			`report`.`id`,
			`report`.`id_kirim`,
			`report`.`id_konsumen`,
			`report`.`target`,
			`report`.`status`');
			$this->db->from('report');
		 
			if(array_key_exists("where", $params)){
				foreach($params['where'] as $key => $val){ 
					$this->db->where($key, $val); 
				} 
			}  
			
			if(array_key_exists("search", $params))
			{
				if(!empty($params['search']['keywords'])){ 
					$this->db->where('report.target', $params['search']['keywords']); 
					$this->db->like('report.message', $params['search']['keywords']); 
				} 
				
			} 
			if(!empty($params['search']['sortBy'])){ 
				$this->db->order_by('`report`.`id`', $params['search']['sortBy']); 
			}
			if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
				$result = $this->db->count_all_results(); 
				}else{ 
				if(array_key_exists("id", $params) || (array_key_exists("returnType", $params) && $params['returnType'] == 'single')){
					
					$this->db->order_by('report.id', 'DESC'); 
					$query = $this->db->get(); 
					$result = ($query->num_rows() > 0)?$query->row():FALSE; 
					
					}else{
					
					$this->db->order_by('report.id', 'DESC'); 
					if(array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
						
						$this->db->limit($params['limit'],$params['start']); 
						}elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){ 
						
						$this->db->limit($params['limit']); 
					}
					
					$query = $this->db->get(); 
					$result = ($query->num_rows() > 0)?$query->result():FALSE; 
				} 
			} 
			
			// Return fetched data 
			return $result; 
		}
		
		
		public function insert(array $data)
		{
			$query = $this->db->insert($this->_table, $data);
			
			if ($query == FALSE)
			return FALSE;
			else
			return TRUE;
		}
		
		public function insert_report(array $data)
		{
			$query = $this->db->insert('report', $data);
			
			if ($query == FALSE)
			return FALSE;
			else
			return TRUE;
		}
		
		public function update_device($data,$where)
		{
			$query = $this->db->where($where);
			$query = $this->db->update('device', $data);
			
			if ($query == FALSE)
			return FALSE;
			else
			return TRUE;
		}
		
		public function update_report($data,$where)
		{
			$query = $this->db->where($where);
			$query = $this->db->update('report', $data);
			
			if ($query == FALSE)
			return FALSE;
			else
			return TRUE;
		}
		
		public function update($key, $data)
		{
			$query = $this->db->where('id', $key);
			$query = $this->db->update($this->_table, $data);
			
			if ($query == FALSE)
			return FALSE;
			else
			return TRUE;
		}
		
		public function update_konsumen($data,$where)
		{
			$query = $this->db->where($where);
			$query = $this->db->update('konsumen', $data);
			
			if ($query == FALSE)
			return FALSE;
			else
			return TRUE;
		}
		
		
		public function delete($val = 0)
		{
			if ($this->cek_id($val) == 1) 
			{
				$this->db->where('id', $val)->delete($this->_table);
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		
		public function delete_report($val = 0, $valid = 0)
		{
			if ($this->cek_id_konsumen($valid) == 1) 
			{
				$query = $this->db->where('id',$valid);
				$query = $this->db->update('konsumen',['kunci'=>0]);
			}
			
			if ($this->cek_id_report($val) == 1) 
			{
				$this->db->where('id', $val)->delete('report');
				return TRUE;
			}
			else
			{
				return FALSE;
			}
			
		}
		
		
		public function get_data_edit($val_id)
		{
			$query = $this->db->where('id', $val_id);
			$query = $this->db->get($this->_table);
			$result = $query->row_array();
			return $result;
		}
		
		
		public function cek_nomor_bylabel($where)
		{
			$query = $this->db->select('id,nama,no_hp');
			$query = $this->db->where($where);
			$query = $this->db->order_by('nama', 'RANDOM');
			$query = $this->db->get('konsumen');
			$result = $query->row();
			return $result;
		}
		
		public function get_label()
		{
			$query = $this->db->select('panggilan');
			$query = $this->db->where('kunci',0);
			$query = $this->db->or_where('kunci',3);
			$query = $this->db->group_by('panggilan');
			$query = $this->db->order_by('panggilan', 'ASC');
			$query = $this->db->get('konsumen');
			$result = $query->result();
			return $result;
		}
		
		public function total_label($where)
		{
			$query = $this->db->select('*');
			$query = $this->db->where($where);
			$query = $this->db->get('konsumen');
			$result = $query->num_rows();
			return $result;
		}
		
		public function get_promo_byid($id =0)
		{
			$query = $this->db->select('id,title,deskripsi,jenis_pesan,url,filename,filetype');
			$query = $this->db->order_by('title', 'ASC');
			$query = $this->db->where('id',$id);
			$query = $this->db->get($this->_table);
			$result = $query->row();
			return $result;
		}
		
		public function get_promo()
		{
			$query = $this->db->select('id,title');
			$query = $this->db->order_by('title', 'ASC');
			$query = $this->db->get($this->_table);
			$result = $query->result();
			return $result;
		}
		
		public function cek_id($val = 0)
		{
			$query = $this->db->select('id');
			$query = $this->db->where('id', $val);
			$query = $this->db->get($this->_table);
			$query = $query->num_rows();
			$int = (int)$query;
			return $int;
		}
		
		public function cek_id_report($val = 0)
		{
			$query = $this->db->select('id');
			$query = $this->db->where('id', $val);
			$query = $this->db->get('report');
			$query = $query->num_rows();
			$int = (int)$query;
			return $int;
		}
		
		public function cek_id_konsumen($val = 0)
		{
			$query = $this->db->select('id');
			$query = $this->db->where('id', $val);
			$query = $this->db->get('konsumen');
			$query = $query->num_rows();
			$int = (int)$query;
			return $int;
		}
	}																																																		