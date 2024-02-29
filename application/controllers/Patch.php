<?php
	defined('BASEPATH') or exit('No direct script access allowed');
	
	class Patch extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			cek_session_login();
			$this->title = info()['title']; 
			$this->load->library('dummy');
			$this->load->library('update_v149',NULL,'updatedb');
		}
		
		public function index()
		{
			
			$data['title'] ="Patch | ".$this->title;
			
			$tipe ='update_database';
			$this->updatedb->invoice_two();
			$this->updatedb->invoice_one();
			$this->updatedb->satu_harga();
			$this->updatedb->harga_satuan();
			$this->updatedb->harga_member();
			$this->updatedb->range_harga();
			$this->updatedb->info_devtools();
			$this->updatedb->cols_printer();
			$this->updatedb->bahan();
			$this->updatedb->laporan_penerimaan();
			$this->updatedb->invoice_detail();
			$this->updatedb->satu_harga_C();
			
			$this->db->truncate('jenis_kas');
			$kas = $this->kas();
			$this->db->insert_batch('jenis_kas', $kas);
			
			if (!$this->db->table_exists('deposit')){
				$add_table_deposit = $this->updatedb->add_table_deposit();
				$this->load->dbforge();
				$this->dbforge->add_field($add_table_deposit);
				$this->dbforge->add_key('id', TRUE);
				$attributes = array('ENGINE' => 'MyISAM');
				$this->dbforge->create_table('deposit', FALSE, $attributes);
			}
			$alert = $this->updatedb->harga_range_member();
			
			// dump($alert);
			if($alert['status']==true){
				$data = ['status'=>$alert['status']];
				}else{
				$data = ['status'=>$alert['status']];
			}
			echo json_encode($data);
		}
		
		private function kas(){
			$this->db->truncate('jenis_kas');
			$jenis_kas = $this->dummy->jenis_kas();
			$counter = count($jenis_kas);
			$this->db->insert_batch('jenis_kas', $jenis_kas);
			$data = ['status'=>200,'counter'=>$counter,'msg'=>'sukses'];
			echo json_encode($data);
		}
		
		public function harga(){
			$query = $this->update_satu_harga();
			if($query['status']=='ok'){
				$data = ['status'=>true,'msg'=>'sukses'];
				}else{
				$data = ['status'=>false,'msg'=>'gagal'];
			}
			echo json_encode($data);
		}
		
		private function update_satu_harga(){
			$query = $this->db->select('id,id_bahan,harga_beli,harga_pokok,persen,harga_jual')
			->from('satu_harga')
			->get()->result();
			foreach($query AS $val)
			{
				if(!empty($val->persen)){
					if($val->harga_pokok > $val->harga_beli){
						$harga_jual = ($val->harga_pokok * $val->persen) /100;
						$harga_jual = $val->harga_pokok + $harga_jual;
					}
					if($val->harga_pokok < $val->harga_beli){
						$harga_jual = ($val->harga_beli * $val->persen) /100;
						$harga_jual = $val->harga_beli + $harga_jual;
					}
				}
				
				if(empty($val->persen)){
					if($val->harga_pokok > $val->harga_beli){
						$harga_jual = $val->harga_pokok;
					}
					if( $val->harga_beli > $val->harga_pokok){
						$harga_jual = $val->harga_beli;
					}
				}
				
				$this->model_app->update('satu_harga', ['harga_jual'=> $harga_jual], ['id' =>$val->id]);
				$query = $this->model_app->update('bahan', ['harga_jual'=> $harga_jual], ['id' =>$val->id_bahan]);
			}
			return $query;
		}
		 
		
	}																							