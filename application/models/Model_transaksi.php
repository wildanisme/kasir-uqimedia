<?php 
	class Model_transaksi extends CI_model{
		
		function getLaporanHarian($tanggal,$iduser=0){
			$this->db->select('`bayar_invoice_detail`.`tgl_bayar`,
			`bayar_invoice_detail`.`jml_bayar`,
			`bayar_invoice_detail`.`id_sub_bayar`,
			`invoice`.`id_konsumen`,
			`invoice`.`id_invoice` as noid`,
			`invoice`.`id_transaksi as id`,
			`tb_users`.`nama_lengkap` AS fo');
			$this->db->from('invoice');
			$this->db->join('bayar_invoice_detail', '`invoice`.`id_invoice` = `bayar_invoice_detail`.`id_invoice`');
			$this->db->join('tb_users', '`bayar_invoice_detail`.`id_user` = `tb_users`.`id_user`');
			if(!empty($iduser)){
				$this->db->where('invoice.id_user',$iduser);
			}
			$this->db->where('bayar_invoice_detail.tgl_bayar',$tanggal);
			$this->db->where('invoice.status','simpan');
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result_array();
				} else {
				return false;
			}
		}
		
		
		function getLaporanBulanan($bulan,$tahun,$iduser=0){
			$this->db->select('`bayar_invoice_detail`.`tgl_bayar`,
			`bayar_invoice_detail`.`jml_bayar`,
			`bayar_invoice_detail`.`id_sub_bayar`,
			`bayar_invoice_detail`.`id_bayar`,
			`invoice`.`id_konsumen`,
			`invoice`.`id_invoice` as noid`,
			`invoice`.`id_transaksi` as id,
			`tb_users`.`nama_lengkap` AS fo');
			$this->db->from('invoice');
			$this->db->join('bayar_invoice_detail', '`invoice`.`id_invoice` = `bayar_invoice_detail`.`id_invoice`');
			$this->db->join('tb_users', '`bayar_invoice_detail`.`id_user` = `tb_users`.`id_user`');
			if(!empty($iduser)){
				$this->db->where('invoice.id_user',$iduser);
			}
			$this->db->where('MONTH(bayar_invoice_detail.tgl_bayar)',$bulan);
			$this->db->where('YEAR(bayar_invoice_detail.tgl_bayar)',$tahun);
			$this->db->where('invoice.status','simpan');
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result_array();
				} else {
				return false;
			}
		}
		
		function getPengeluaranHarian($tanggal,$iduser=0){
			$this->db->select('`bayar_pengeluaran`.`tgl_bayar`,
			`bayar_pengeluaran`.`jml_bayar`,
			`bayar_pengeluaran`.`id_bayar`,
			`bayar_pengeluaran`.`id_sub_bayar`,
			`pengeluaran`.`id_pengeluaran` as id,
			`tb_users`.`nama_lengkap` AS `fo`');
			$this->db->from('pengeluaran');
			$this->db->join('bayar_pengeluaran', '`pengeluaran`.`id_pengeluaran` = `bayar_pengeluaran`.`id_pengeluaran`');
			$this->db->join('tb_users', '`bayar_pengeluaran`.`id_user` = `tb_users`.`id_user`');
			if(!empty($iduser)){
				$this->db->where('bayar_pengeluaran.id_user',$iduser);
			}
			$this->db->where('bayar_pengeluaran.tgl_bayar',$tanggal);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result_array();
				} else {
				return false;
			}
		}
		
		function getPengeluaranBulanan($bulan,$tahun,$iduser=0){
			$this->db->select('`bayar_pengeluaran`.`tgl_bayar`,
			`bayar_pengeluaran`.`jml_bayar`,
			`bayar_pengeluaran`.`id_bayar`,
			`bayar_pengeluaran`.`id_sub_bayar`,
			`pengeluaran`.`id_pengeluaran` as id,
			`tb_users`.`nama_lengkap` AS `fo`');
			$this->db->from('pengeluaran');
			$this->db->join('bayar_pengeluaran', '`pengeluaran`.`id_pengeluaran` = `bayar_pengeluaran`.`id_pengeluaran`');
			$this->db->join('tb_users', '`bayar_pengeluaran`.`id_user` = `tb_users`.`id_user`');
			if(!empty($iduser)){
				$this->db->where('bayar_pengeluaran.id_user',$iduser);
			}
			$this->db->where('MONTH(bayar_pengeluaran.tgl_bayar)',$bulan);
			$this->db->where('YEAR(bayar_pengeluaran.tgl_bayar)',$tahun);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result_array();
				} else {
				return false;
			}
		}
		
		function getPembelianHarian($tanggal,$iduser=0){
			$this->db->select('`bayar_pembelian`.`tgl_bayar`,
			`bayar_pembelian`.`jml_bayar`,
			`bayar_pembelian`.`id_bayar`,
			`bayar_pembelian`.`id_sub_bayar`,
			`pembelian`.`id_pembelian` as id,
			`tb_users`.`nama_lengkap` AS `fo`');
			$this->db->from('pembelian');
			$this->db->join('bayar_pembelian', '`pembelian`.`id_pembelian` = `bayar_pembelian`.`id_pembelian`');
			$this->db->join('tb_users', '`bayar_pembelian`.`id_user` = `tb_users`.`id_user`');
			if(!empty($iduser)){
				$this->db->where('bayar_pembelian.id_user',$iduser);
			}
			$this->db->where('bayar_pembelian.tgl_bayar',$tanggal);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result_array();
				} else {
				return false;
			}
		}
		
		function getPembelianBulanan($bulan,$tahun,$iduser=0){
			$this->db->select('`bayar_pembelian`.`tgl_bayar`,
			`bayar_pembelian`.`jml_bayar`,
			`bayar_pembelian`.`id_bayar`,
			`bayar_pembelian`.`id_sub_bayar`,
			`pembelian`.`id_pembelian` as id,
			`tb_users`.`nama_lengkap` AS `fo`');
			$this->db->from('pembelian');
			$this->db->join('bayar_pembelian', '`pembelian`.`id_pembelian` = `bayar_pembelian`.`id_pembelian`');
			$this->db->join('tb_users', '`bayar_pembelian`.`id_user` = `tb_users`.`id_user`');
			if(!empty($iduser)){
				$this->db->where('bayar_pembelian.id_user',$iduser);
			}
			$this->db->where('MONTH(bayar_pembelian.tgl_bayar)',$bulan);
			$this->db->where('YEAR(bayar_pembelian.tgl_bayar)',$tahun);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result_array();
				} else {
				return false;
			}
		}
		
		
	}
