<?php 
	class Model_cashback extends CI_model{
		function __construct() { 
			// Set table name 
			$this->table = 'deposit'; 
			// $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
		} 
		
		 
		function getCashback($params = array()){
			// print_r($params);
			
			$this->db->select('
			`konsumen`.`nama`,
			`konsumen`.`id`,
			`deposit`.`id_invoice`,
			SUM(`deposit`.`masuk`) AS `total_masuk`,
			SUM(`deposit`.`keluar`) AS `total_keluar`,
			`deposit`.`id_konsumen`');
			$this->db->from('konsumen');
			$this->db->join('deposit', '`konsumen`.`id` = `deposit`.`id_konsumen`');
			$this->db->group_by(array("`konsumen`.`nama`","`deposit`.`id_konsumen`"));
			if(array_key_exists("where", $params)){
				foreach($params['where'] as $key => $val){ 
					$this->db->where($key, $val); 
				} 
			}  
			
			if(array_key_exists("search", $params))
			{
				if(!empty($params['search']['user'])){ 
					$this->db->where('konsumen.nama', $params['search']['user']); 
				} 
			} 
			
			if(!empty($params['search']['sortBy'])){ 
				$this->db->order_by('`deposit`.`id`', $params['search']['sortBy']); 
			}
			
			if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
				$result = $this->db->count_all_results(); 
				}else{ 
				if(array_key_exists("id", $params) || (array_key_exists("returnType", $params) && $params['returnType'] == 'single')){ 
					
					$this->db->order_by('deposit.id', 'DESC'); 
					$query = $this->db->get(); 
					$result = ($query->num_rows() > 0)?$query->result_array():FALSE; 
					
					}else{
					
					$this->db->order_by('deposit.id', 'DESC'); 
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
		
	}																		