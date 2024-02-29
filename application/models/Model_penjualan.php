<?php 
	defined('BASEPATH') or exit('No direct script access allowed');
	
	use \VisualAppeal\AutoUpdate;
	use Curl\Curl;
	
	class Model_penjualan extends CI_model{
		
		
		function __construct()
		{
			parent::__construct();
			
		}
		//CEK PEMBAYARAN
		public function cek_total_bayar($id=0){
			$this->db->select('SUM(jml_bayar) AS `total`');
			$this->db->where('id_invoice',$id);
			$query = $this->db->get('bayar_invoice_detail');
			if($query->num_rows() > 0){
				return $query->row()->total;
				}else{
				return 0;
			}
		}
		//CEK TOTAL BAYAR DI INVOICE
		public function cek_total_invoice($id=0){
			$this->db->select('total_bayar');
			$this->db->where('id_invoice',$id);
			return $this->db->get('invoice')->row()->total_bayar;
		}
		//CEK SUM DETAIL INVOICE
		public function cek_total_detail($id=0){
			$this->db->select('SUM(jumlah * harga) AS `total`');
			$this->db->where('id_invoice',$id);
			return $this->db->get('invoice_detail')->row()->total;
		}
		
		public function get_harga_satuan($id_member=0, $id_bahan=0,$id_satuan=0,$type_harga=0,$jml=0,$harga_awal=0)
		{
			$sql = $this->db->query("select * from harga_satuan where id_bahan=$id_bahan AND  id_satuan=$id_satuan");
			if ($sql->num_rows() > 0 and $type_harga == 2) 
			{
				$data = ['status' => true, 'harga' => rp($sql->row()->harga_jual), 'satuan' => $id_satuan];
				} else {
				if ($type_harga == 1) 
				{
					$sql1 = $this->db->query("SELECT 
					`satuan`.`id` AS idsatuan,
					`satuan`.`satuan`,
					`satu_harga`.`id_satuan`,
					`satu_harga`.`harga_jual`,
					`bahan`.`title`
					FROM
					`bahan`
					INNER JOIN `satu_harga` ON (`bahan`.`id` = `satu_harga`.`id_bahan`)
					INNER JOIN `satuan` ON (`satu_harga`.`id_satuan` = `satuan`.`id`)
					WHERE
					`bahan`.`id` = $id_bahan");
					if ($sql1->num_rows() > 0) 
					{
						$harga_jual = $sql1->row()->harga_jual;
						$satuan = $sql1->row()->id_satuan;
						} else {
						$result = $this->harga_awal($id_bahan);
						$harga_jual = $result->harga_jual;
						$satuan = $result->id_satuan;
					}
					
					$data = [
					'status' => true, 
					'harga' => rp($harga_jual), 
					'satuan' => $satuan, 
					'type_harga' => $type_harga,
					'log'=>'Satu Harga'
					];
					
				} elseif ($type_harga == 2) 
				{
					$sql2 = $this->db->query("SELECT 
					`satuan`.`id` AS idsatuan,
					`satuan`.`satuan`,
					`harga_satuan`.`id_satuan`,
					`bahan`.`title`,
					`harga_satuan`.`harga_jual`,
					`harga_satuan`.`id_bahan`
					FROM
					`satuan`
					INNER JOIN `harga_satuan` ON (`satuan`.`id` = `harga_satuan`.`id_satuan`)
					INNER JOIN `bahan` ON (`harga_satuan`.`id_bahan` = `bahan`.`id`)
					WHERE
					`harga_satuan`.`id_satuan` = $id_satuan AND `harga_satuan`.`id_bahan` = $id_bahan");
					
					if ($sql2->num_rows() > 0) 
					{
						$harga_jual = $sql2->row()->harga_jual;
						$satuan = $sql2->row()->id_satuan;
						} else {
						$result = $this->harga_awal($id_bahan);
						$harga_jual = $result->harga_jual;
						$satuan = $result->id_satuan;
					}
					
					$data = [
					'status' => true, 
					'harga' => rp($harga_jual), 
					'satuan' => $satuan, 
					'type_harga' => $type_harga,
					'log'=>'Harga satuan'
					];
					
				} elseif ($type_harga == 3) 
				{
					
					$sql3 = $this->db->query("SELECT 
					`harga_member`.`id_bahan`,
					`harga_member`.`id_satuan`,
					`harga_member`.`id_member`,
					`harga_member`.`harga_jual`
					FROM
					`satuan`
					INNER JOIN `harga_member` ON (`satuan`.`id` = `harga_member`.`id_satuan`)
					INNER JOIN `bahan` ON (`harga_member`.`id_bahan` = `bahan`.`id`)
					INNER JOIN `konsumen` ON (`harga_member`.`id_member` = `konsumen`.`jenis_member`)
					WHERE
					`harga_member`.`id_member` = $id_member AND 
					`harga_member`.`id_bahan` = $id_bahan
					GROUP BY
					`harga_member`.`id_bahan`,
					`harga_member`.`id_satuan`,
					`harga_member`.`id_member`,
					`harga_member`.`harga_jual`");
					
					if ($sql3->num_rows() > 0) 
					{
						$harga_jual = $sql3->row()->harga_jual;
						$satuan = $sql3->row()->id_satuan;
						} else {
						$result = $this->harga_awal($id_bahan);
						$harga_jual = $result->harga_jual;
						$satuan = $result->id_satuan;
					}
					
					$data = [
					'status' => true, 
					'harga' => rp($harga_jual), 
					'satuan' => $satuan, 
					'type_harga' =>$type_harga,
					'log'=>'Berdasarkan Level'
					];
					
				} elseif ($type_harga == 4) 
				{
					
					$sql = $this->db->query("select id_satuan,harga_jual from range_harga where id_bahan=$id_bahan AND $jml between jumlah_minimal and jumlah_maksimal");
					if ($sql->num_rows() > 0) 
					{
						$harga_jual = $sql->row()->harga_jual;
						$satuan = $sql->row()->id_satuan;
						} else {
						$result = $this->harga_awal($id_bahan);
						$harga_jual = $result->harga_jual;
						$satuan = $result->id_satuan;
					}
					
					$data = [
					'status' => true, 
					'harga' => rp($harga_jual), 
					'satuan' => $satuan, 
					'type_harga' => $type_harga,
					'log'=>'Berdasarkan Jumlah'
					];
					
				} elseif ($type_harga == 5) 
				{
					
					$sql4 = $this->db->query("select id_satuan,harga_jual from harga_range_member where id_bahan=$id_bahan AND id_member='$id_member' AND $jml between jumlah_minimal and jumlah_maksimal");
					if ($sql4->num_rows() > 0) 
					{
						$harga_jual = $sql4->row()->harga_jual;
						$satuan = $sql4->row()->id_satuan;
						} else {
						$result = $this->harga_awal($id_bahan);
						$harga_jual = $result->harga_jual;
						$satuan = $result->id_satuan;
					}
					
					$data = [
					'status' => true, 
					'harga' => rp($harga_jual), 
					'satuan' => $satuan,
					'type_harga' => $type_harga,
					'log'=>'Berdasarkan Jumlah & Level'
					];
					
					} else {
					$result = $this->harga_awal($id_bahan);
					
					$data = [
					'status' => true, 
					'harga' => rp($result->harga_jual), 
					'satuan' => $result->id_satuan,
					'type_harga' => $type_harga,
					'log'=>'Default'
					];
				}
			}
			return $data;
		}
		
		public function get_harga_range($id_member=0, $id_bahan=0,$id_satuan=0,$type_harga=0,$jml=0,$harga_awal=0){
			if ($type_harga == 1) {
				$sql1 = $this->db->query("SELECT 
				`satuan`.`id` AS idsatuan,
				`satuan`.`satuan`,
				`satu_harga`.`id_satuan`,
				`satu_harga`.`harga_jual`,
				`bahan`.`title`
				FROM
				`bahan`
				INNER JOIN `satu_harga` ON (`bahan`.`id` = `satu_harga`.`id_bahan`)
				INNER JOIN `satuan` ON (`satu_harga`.`id_satuan` = `satuan`.`id`)
				WHERE
				`bahan`.`id` = $id_bahan");
				if ($sql1->num_rows() > 0) {
					$harga_jual = $sql1->row()->harga_jual;
					$satuan = $sql1->row()->id_satuan;
					} else {
					$sql = $this->db->query("select id,id_satuan,harga_modal from bahan where id=$id_bahan");
					$harga_jual = $sql->row()->harga_modal;
					$satuan = $sql->row()->id_satuan;
				}
				
				$data = ['status' => true, 'harga' => $harga_jual, 'satuan' => $satuan, 'type_harga' => $type_harga,'log'=>'Satu Harga'];
			}elseif ($type_harga == 2) 
			{
				$sql2 = $this->db->query("SELECT 
				`satuan`.`id` AS idsatuan,
				`satuan`.`satuan`,
				`harga_satuan`.`id_satuan`,
				`bahan`.`title`,
				`harga_satuan`.`harga_jual`,
				`harga_satuan`.`id_bahan`
				FROM
				`satuan`
				INNER JOIN `harga_satuan` ON (`satuan`.`id` = `harga_satuan`.`id_satuan`)
				INNER JOIN `bahan` ON (`harga_satuan`.`id_bahan` = `bahan`.`id`)
				WHERE
				`harga_satuan`.`id_satuan` = $id_satuan AND `harga_satuan`.`id_bahan` = $id_bahan");
				if ($sql2->num_rows() > 0) {
					$harga_jual = $sql2->row()->harga_jual;
					$satuan = $sql2->row()->id_satuan;
					} else {
					$sql = $this->db->query("select id,id_satuan,harga_modal from bahan where id=$id_bahan");
					$harga_jual = $sql->row()->harga_modal;
					$satuan = $sql->row()->id_satuan;
				}
				$data = ['status' => true, 'harga' => $harga_jual, 'satuan' => $satuan, 'type_harga' => $type_harga,'log'=>'Harga satuan'];
			}elseif ($type_harga == 3) 
			{
				$sql3 = $this->db->query("SELECT 
				`harga_member`.`id_bahan`,
				`harga_member`.`id_satuan`,
				`harga_member`.`id_member`,
				`harga_member`.`harga_jual`
				FROM
				`satuan`
				INNER JOIN `harga_member` ON (`satuan`.`id` = `harga_member`.`id_satuan`)
				INNER JOIN `bahan` ON (`harga_member`.`id_bahan` = `bahan`.`id`)
				INNER JOIN `konsumen` ON (`harga_member`.`id_member` = `konsumen`.`jenis_member`)
				WHERE
				`harga_member`.`id_member` = $id_member AND 
				`harga_member`.`id_bahan` = $id_bahan
				GROUP BY
				`harga_member`.`id_bahan`,
				`harga_member`.`id_satuan`,
				`harga_member`.`id_member`,
				`harga_member`.`harga_jual`");
				if ($sql3->num_rows() > 0) {
					$harga_jual = $sql3->row()->harga_jual;
					$satuan = $sql3->row()->id_satuan;
					} else {
					$result = $this->harga_awal($id_bahan);
					$harga_jual = $result->harga_jual;
					$satuan = $result->id_satuan;
				}
				$data = ['status' => true, 'harga' => $harga_jual, 'satuan' => $satuan, 'type_harga' => $type_harga,'log'=>'Harga level'];
			}elseif ($type_harga == 4) 
			{
				$sql = $this->db->query("select id_satuan,harga_jual from range_harga where id_bahan=$id_bahan AND $jml between jumlah_minimal and jumlah_maksimal");
				if ($sql->num_rows() > 0) 
				{
					$harga_jual = $sql->row()->harga_jual;
					$satuan = $sql->row()->id_satuan;
					}else{
					$result = $this->harga_awal($id_bahan);
					$harga_jual = $result->harga_jual;
					$satuan = $result->id_satuan;
				}
				
				$data = [
				'status' => true, 
				'harga' => $harga_jual, 
				'satuan' => $satuan, 
				'type_harga' => $type_harga,
				'log'=>'Harga jumlah'
				];
				
			}elseif ($type_harga == 5) 
			{
				$sql = $this->db->query("select id_satuan,harga_jual from harga_range_member where id_bahan=$id_bahan AND id_member='$id_member' AND $jml between jumlah_minimal and jumlah_maksimal");
				
				if ($sql->num_rows() > 0) 
				{
					$harga_jual = $sql->row()->harga_jual;
					$satuan =$sql->row()->id_satuan;
					}else{
					$result = $this->harga_awal($id_bahan);
					$harga_jual = $result->harga_jual;
					$satuan = $result->id_satuan;
				}
				
				$data = [
				'status' => true, 
				'harga' => $harga_jual, 
				'satuan' => $satuan, 
				'type_harga' => $type_harga,
				'log'=>'Harga jumlah & level'
				];
				
				}else{
				$result = $this->harga_awal($id_bahan);
				$harga_jual = $result->harga_jual;
				$satuan = $result->id_satuan;
				
				$data = [
				'status' => true, 
				'harga' => $harga_jual, 
				'satuan' => $satuan, 
				'id_member' => $id_member, 
				'type_harga' =>$type_harga,
				'log'=>'Default'
				];
				
			} 
			return $data;
		}
		
		private function harga_awal($id=0)
		{
			
			$this->db->select('id,id_satuan,harga_modal,harga_jual');
			$this->db->where('id',$id);
			$this->db->from('bahan');
			$query = $this->db->get();
			$row = $query->num_rows() > 0 ? $query->row() : false;
			$response = (object)['harga_jual'=>$row->harga_jual,'id_satuan'=>$row->id_satuan];
			
			return $response;
		}
		
	}																	