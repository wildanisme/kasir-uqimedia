<?php
	defined('BASEPATH') or exit('No direct script access allowed');
	
	class Kas extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			cek_session_login();
			$this->load->model('model_cashback', 'cashback');
			$this->perPage = 10;
			$this->iduser = $this->session->idu;
			$this->title = info()['title']; 
		}
		
		
		public function data()
		{
			cek_menu_akses();
			$data['title'] = 'Data Kas | '.$this->title;
			$data['tanggal'] = bulan_tahun(date('Y-m-d'));
			$this->template->load('main/themes','kas/pengaturan',$data);
		}
		
		public function mutasi()
		{
			cek_menu_akses();
			
			$data['title'] = 'Data Mutasi | '.$this->title;
			$this->template->load('main/themes','kas/mutasi',$data);
		}
		public function cariMutasi(){
			$page = $this->input->post('page'); 
			$dari = !empty($this->input->post('dari')) ? date_dmy($this->input->post('dari')) : date('Y-m-d');
			$sampai = !empty($this->input->post('sampai')) ? date_dmy($this->input->post('sampai')) : date('Y-m-d');
			
			if(!$page){ 
				$offset = 0; 
				}else{ 
				$offset = $page; 
			} 
			$conditions['where'] = array( 
            'id_jenis!=' => 0
			); 
			if(!empty($dari)){ 
				$conditions['search']['dari'] = $dari; 
			} 
			if(!empty($sampai)){ 
				$conditions['search']['sampai'] = $sampai; 
			} 
			
			$conditions['returnType'] = 'count'; 
			$totalRec = $this->model_data->getMutasi($conditions); 
			
			// Pagination configuration 
			$config['target']      = '#dataMutasi'; 
			$config['base_url']    = base_url('kas/cariMutasi'); 
			$config['total_rows']  = $totalRec; 
			$config['per_page']    = $this->perPage; 
			$config['link_func']   = 'search_Mutasi'; 
			// Initialize pagination library 
			$this->ajax_pagination->initialize($config); 
			// Get records 
			$conditions['start'] = $offset; 
			$conditions['limit'] = $this->perPage;
			
			$conditions['where'] = array( 
            'id_jenis!=' => 0
			); 
			if(!empty($dari)){ 
				$conditions['search']['dari'] = $dari; 
			} 
			if(!empty($sampai)){ 
				$conditions['search']['sampai'] = $sampai; 
			} 
			unset($conditions['returnType']); 
			$data['result'] = $this->model_data->getMutasi($conditions); 
			
			$this->load->view('kas/cari-mutasi',$data);
		}
		
		public function simpan_mutasi(){
			// print_r($_POST);exit;
			cek_nput_post('GET');
			simpan_demo("Simpan");
			//rekening dari
			$rekening_dari= $this->db->escape_str($this->input->post('rekening_dari'));
			//rekening tujuan
			$rekening= $this->db->escape_str($this->input->post('rekening'));
			
			// $id_bayar= $this->db->escape_str($this->input->post('id_bayar'));
			$dari_kas= $this->db->escape_str($this->input->post('dari_kas'));
			$tujuan= $this->db->escape_str($this->input->post('tujuan'));
			$jumlah= $this->db->escape_str($this->input->post('jumlah'));
			$catatan= $this->db->escape_str($this->input->post('catatan'));
			
			if(!empty($rekening_dari)){
				$rekening_dari = $rekening_dari;
			}
			
			if(!empty($rekening)){
				$rekening = $rekening;
			}
			
			$autoNumber = autoNumber('REF-','%05s','id_generate','kas_masuk');
			
			$pengeluaran = ['no_reff'=>$dari_kas,
			'id_jenis'=>$dari_kas,
			'id_sub_bayar'=>$rekening_dari,
			'id_user'=>$this->iduser,
			'id_generate'=>$autoNumber,
			'catatan'=>$catatan,
			'pengeluaran'=>convert_to_number($jumlah)];
			
			// print_r($pengeluaran);exit();
			$input = $this->model_app->input('kas_masuk',$pengeluaran);
			if($input['status']=='ok'){
				
				$auto_Number = autoNumber('REF-','%05s','id_generate','kas_masuk');
				
				$pemasukan = ['no_reff'=>$tujuan,
				'id_jenis'=>$tujuan,
				'id_parent'=>$dari_kas,
				'id_sub_bayar'=>$rekening,
				'id_user'=>$this->iduser,
				'id_generate'=>$auto_Number,
				'catatan'=>$catatan,
				'pemasukan'=>convert_to_number($jumlah)];
				
				$this->model_app->insert('kas_masuk',$pemasukan);
				
				$data = array('status'=>200,'msg'=>'Dimutasi Kredit berhasil ');
				}else{
				$data = array('status'=>400,'msg'=>'Dimutasi Kredit gagal');
			}
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		
		//19:16 07/17/2023
		public function simpan_withdraw(){
			
			cek_nput_post('GET');
			simpan_demo("Simpan");
			$id_konsumen= $this->db->escape_str($this->input->post('id_konsumen_withdraw'));
			$noin= $this->db->escape_str($this->input->post('id_invoice_withdraw'));
			//rekening dari
			$rekening_dari= $this->db->escape_str($this->input->post('rekening_dari'));
			//rekening tujuan
			$rekening= $this->db->escape_str($this->input->post('rekening'));
			
			// $id_bayar= $this->db->escape_str($this->input->post('id_bayar'));
			$dari_kas= $this->db->escape_str($this->input->post('dari_kas'));
			$tujuan= $this->db->escape_str($this->input->post('tujuan'));
			$jumlah= $this->db->escape_str($this->input->post('jumlah_withdraw'));
			
			$catatan= "WD No.".$id_konsumen;
			
			if(!empty($rekening_dari)){
				$rekening_dari = $rekening_dari;
			}
			
			if(!empty($rekening)){
				$rekening = $rekening;
			}
			// dump($_POST);
			$autoNumber = autoNumber('REF-','%05s','id_generate','kas_masuk');
			
			$pengeluaran = ['no_reff'=>$dari_kas,
			'id_jenis'=>$dari_kas,
			'id_sub_bayar'=>$rekening_dari,
			'id_user'=>$this->iduser,
			'id_generate'=>$autoNumber,
			'catatan'=>$catatan,
			'pengeluaran'=>convert_to_number($jumlah)];
			
			// print_r($pengeluaran);exit();
			$input = $this->model_app->input('kas_masuk',$pengeluaran);
			if($input['status']=='ok'){
				$ket_debet = "Cashback Penjualan No. " . $noin;
				$ket_kredit = "Kas Penjualan No. " . $noin;
				$_reffd = "C-$noin";
				
				$_reffk = "K-$noin";
				
				
				$this->model_jurnal->input_jurnal_debet(403,$_reffd,$jumlah,$ket_debet);
				$this->model_jurnal->input_jurnal_kredit(411,$_reffk,$jumlah,$ket_kredit);
				
				$input_deposit = [
				'id_user'=>$this->iduser,
				'id_konsumen'=>$id_konsumen,
				'id_konsumen'=>$noin,
				'keluar'=>$jumlah,
				'create_date'=>today(),
				'catatan'=>$catatan
				];
				
				$this->deposit($input_deposit);
				$data = array('status'=>200,'msg'=>'Withdraw berhasil');
				}else{
				$data = array('status'=>400,'msg'=>'Withdraw gagal');
			}
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		
		//19:24 07/17/2023
		private function deposit($data)
		{
			$this->model_app->input("deposit", $data);
		}
		//23:23 07/03/2023
		public function total_kas()
		{
			$idbayar= $this->db->escape_str($this->input->post('idbayar'));	
			$id= $this->db->escape_str($this->input->post('id'));	
			if($idbayar ==1){
				$noref = 'no_reff';
				}else{
				$noref = 'id_sub_bayar';
			}
			$pengeluaran = $this->model_app->sum_data('pengeluaran','kas_masuk',[$noref=>$id]);
			$pemasukan = $this->model_app->sum_data('pemasukan','kas_masuk',[$noref=>$id]);
			$data = $pemasukan - $pengeluaran;
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		
		public function kas_batal()
		{
			$id_via= $this->db->escape_str($this->input->post('id_via'));	
			$id_rek= $this->db->escape_str($this->input->post('id_rek'));	
			$id= $this->db->escape_str($this->input->post('id'));	
			
			if($id_via==1){
				$where = ['id_bayar'=>$id_via,'no_reff'=>$id];
				}else{
				$where = ['id_bayar'=>$id_via,'id_sub_bayar'=>$id_rek,'no_reff'=>$id];
			}
			
			$pengeluaran = $this->model_app->sum_data('pengeluaran','kas_masuk',$where);
			$pemasukan = $this->model_app->sum_data('pemasukan','kas_masuk',$where);
			$data = $pemasukan - $pengeluaran;
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		
		public function total_kas_batal()
		{
			$idbayar= $this->db->escape_str($this->input->post('idbayar'));	
			$rekening= $this->db->escape_str($this->input->post('rekening'));	
			$id= $this->db->escape_str($this->input->post('id'));	
			if($idbayar ==1){
				$noref = 'no_reff';
				$pengeluaran = $this->model_app->sum_data('pengeluaran','kas_masuk',[$noref=>$id]);
				$pemasukan = $this->model_app->sum_data('pemasukan','kas_masuk',[$noref=>$id]);
			}
			if($idbayar ==2){
				$pengeluaran = $this->model_app->sum_data('pengeluaran','kas_masuk',['id_sub_bayar'=>$rekening,'no_reff'=>$id]);
				$pemasukan = $this->model_app->sum_data('pemasukan','kas_masuk',['id_sub_bayar'=>$rekening,'no_reff'=>$id]);
			}
			$data = $pemasukan - $pengeluaran;
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		
		
		
		public function total_kas_kecil()
		{
			$pengeluaran = $this->model_app->sum_data('pengeluaran','kas_masuk',['no_reff'=>111]);
			$pemasukan = $this->model_app->sum_data('pemasukan','kas_masuk',['no_reff'=>111]);
			$data = $pemasukan - $pengeluaran;
			$data = rp($data);
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		public function total_kas_penjualan()
		{
			$pengeluaran = $this->model_app->sum_data('pengeluaran','kas_masuk',['no_reff'=>411]);
			$pemasukan = $this->model_app->sum_data('pemasukan','kas_masuk',['no_reff'=>411]);
			$data = $pemasukan - $pengeluaran;
			$data = rp($data);
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		public function total_kas_bank()
		{
			$pengeluaran = $this->model_app->sum_data('pengeluaran','kas_masuk',['no_reff'=>110]);
			$pemasukan = $this->model_app->sum_data('pemasukan','kas_masuk',['no_reff'=>110]);
			$data = $pemasukan - $pengeluaran;
			$result = rp($data);
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($result));
		}
		public function cek_saldo(){
			$id= $this->db->escape_str($this->input->post('idkas'));
			$rekening= $this->db->escape_str($this->input->post('rekening'));
			$where = ['no_reff'=>$id];
			if(!empty($rekening)){
				$where = ['no_reff'=>$id,'id_sub_bayar'=>$rekening];
			}
			// print_r($where);
			$pengeluaran = $this->model_app->sum_data('pengeluaran','kas_masuk',$where);
			$pemasukan = $this->model_app->sum_data('pemasukan','kas_masuk',$where);
			$total = $pemasukan - $pengeluaran;
			$data   = array("status"=>200,"saldo"=>$total);
			
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		
		public function jenis_kas_mutasi(){
			$result = $this->model_app->view_where('jenis_kas',array('kunci'=>0));
			$data = array();
			foreach ($result->result() as $row)
			{
				$data[] = array("id"=>$row->id_akun,"name"=>$row->title);
			}
			
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		public function tujuan_kas(){
			$id= $this->db->escape_str($this->input->post('id'));
			if(!empty($id)){
				$result = $this->model_app->view_where('jenis_kas',array('kunci'=>0));
				$data = array();
				foreach ($result->result() as $row)
				{
					$data[] = array("id"=>$row->id_akun,"name"=>$row->title);
				}
				}else{
				$data[] = array("id"=>0,"name"=>'Pilih','msg'=>'disabled');
			}
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		public function tujuan_kas_withdraw(){
			$id= $this->db->escape_str($this->input->post('id'));
			if(!empty($id)){
				$result = $this->model_app->view_where('jenis_kas',array('status'=>1));
				$data = array();
				foreach ($result->result() as $row)
				{
					$data[] = array("id"=>$row->id_akun,"name"=>$row->title);
				}
				}else{
				$data[] = array("id"=>0,"name"=>'Pilih','msg'=>'disabled');
			}
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		
		public function jenis_pembayaran(){
			$type =  $this->db->escape_str($this->input->post('type'));
			if($type=='mutasi'){
				$where = array('kunci'=>0,'publish'=>'Y');
				}else{
				$where = array('publish'=>'Y');
			}
			$result = $this->model_app->view_where('jenis_bayar',$where);
			$data = array();
			foreach ($result->result() as $row)
			{
				$data[] = array("id"=>$row->id,"name"=>$row->nama_bayar);
			}
			
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
			
		}
		
		public function rekening(){
			$id_dari =  $this->db->escape_str($this->input->post('dari'));
			$id =  $this->db->escape_str($this->input->post('id'));
			$where = array('publish'=>'Y');
			if(!empty($id_dari)){
				$where = array('id!='=>$id_dari,'publish'=>'Y');
			}
			
			$result = $this->model_app->view_where('rekening_bank',$where);
			$data = array();
			foreach ($result->result() as $row)
			{
				$data[] = array("id"=>$row->id,"name"=>$row->inisial);
			}
			
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
			
		}
		public function pengeluaran()
		{
			cek_menu_akses();
			$data['title'] = 'Pengeluaran | '.$this->title;
			
			$conditions['where'] = array( 
			'jenis_pengeluaran.kunci' => 0, 
			'jenis_pengeluaran.pub' => 'Y'
			); 
			
			$conditions['returnType'] = 'count'; 
			$totalRec = $this->model_data->getJenisPengeluaran($conditions); 
			
			// Pagination configuration 
			$config['target']      = '#dataJenisKas'; 
			$config['base_url']    = base_url('kas/cariJenis'); 
			$config['total_rows']  = $totalRec; 
			$config['per_page']    = 10; 
			$config['link_func']   = 'search_Jenis_Kas'; 
			// Initialize pagination library 
			$this->ajax_pagination->initialize($config); 
			
			// Get records 
			$conditions = array( 
			'limit' => 10 
			); 
			
			$conditions['where'] = array( 
			'jenis_pengeluaran.kunci' => 0, 
			'jenis_pengeluaran.pub' => 'Y'
			); 
			
			$data['akun'] = $this->model_app->view_where('akun',['kunci'=>0])->result(); 
			$data['result'] = $this->model_data->getJenisPengeluaran($conditions); 
			$this->template->load('main/themes','kas/jenis',$data);
		}
		public function edit_jenis(){
			$id= $this->db->escape_str($this->input->post('id'));
			if($id>0){
				$where = array('id_jenis' => $id);
				$row = $this->model_app->edit('jenis_pengeluaran',$where)->row_array();
				$data = array('id'=>$id,'judul'=>$row['title'],'grup'=>$row['id_akun'],'aktif'=>$row['pub'],'belanja'=>$row['status']);
				}else{
				$data = array('id'=>0,'judul'=>"","grup"=>"","aktif"=>"",'belanja'=>'');
			}
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		public function save_jenis()
		{
			simpan_demo("Simpan");
			$id= $this->db->escape_str($this->input->post('id'));
			$type= $this->db->escape_str($this->input->post('type'));
			$judul= change_case($this->db->escape_str($this->input->post('judul')));
			$grup= $this->db->escape_str($this->input->post('grup'));
			$aktif= $this->db->escape_str($this->input->post('aktif'));
			$belanja= $this->db->escape_str($this->input->post('belanja'));
			$_data = array('title'=>$judul,'id_akun'=>$grup,'pub'=>$aktif,'status'=>$belanja);
			if($id ==0 AND $type=='add'){
				///data baru
				$res= $this->model_app->input('jenis_pengeluaran',$_data);
				if($res['status']=='ok'){
					$data = array('status'=>200,'msg'=>'Data berhasil disimpan');
					}else{
					$data = array('status'=>400);
				}
				}else{
				///data update
				$res=  $this->model_app->update('jenis_pengeluaran',$_data,array('id_jenis'=>$id));
				if($res['status']=='ok'){
					$data = array('status'=>200,'msg'=>'Data berhasil update');
					}else{
					$data = array('status'=>400);
				}
			}
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		public function hapus_jenis()
		{
			simpan_demo('Hapus');
			$id = $this->db->escape_str($this->input->post('id'));
			$type = $this->db->escape_str($this->input->post('type'));
			if($id >0 AND $type=='hapus'){
				$cek2 = $this->model_app->view_where('pengeluaran_detail',array('id_biaya' => $id));
				if($cek2->num_rows() == 0){
					$where = array('id_jenis' => $id);
					$res=$this->model_app->hapus('jenis_pengeluaran',$where);
					if($res['status']=='ok'){
						$data = array('status'=>200,'msg'=>'Data berhasil dihapus');
						}else{
						$data = array('status'=>400,'msg'=>'Data gagal dihapus');
					}
					
					}else{
					$data = array('status'=>400,'msg'=>'Data tidak bisa dihapus');
				}
				}else{
				$data = array('status'=>400,'msg'=>'Bad request');
			}
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		public function cariJenis(){	
			$page = $this->input->post('page'); 
			if(!$page){ 
				$offset = 0; 
				}else{ 
				$offset = $page; 
			} 
			
			$limits = $this->input->post('limits'); 
			if(!empty($limits)){
				$limit = $limits; 
				}else{ 
				$limit = 10; 
			} 
			$sortBy = $this->input->post('sortBy'); 
			if(!empty($sortBy)){ 
				$conditions['search']['sortBy'] = $sortBy; 
			} 
			
			$keywords = $this->input->post('keywords'); 
			if(!empty($keywords)){ 
				$conditions['search']['keywords'] = $keywords; 
			} 
			
			$jenis = $this->input->post('jenis'); 
			if(!empty($jenis)){ 
				$conditions['where'] = array(
				'jenis_cetakan.id_jenis'=>$jenis
				); 
			} 
			$conditions['where'] = array( 
			'jenis_pengeluaran.kunci' => 0, 
			'jenis_pengeluaran.pub' => 'Y'
			); 
			
			// Get record count 
			$conditions['returnType'] = 'count'; 
			$totalRec = $this->model_data->getJenisPengeluaran($conditions); 
			
			// Pagination configuration 
			$config['target']      = '#dataJenisKas'; 
			$config['base_url']    = base_url('kas/cariJenis'); 
			$config['total_rows']  = $totalRec; 
			$config['per_page']    = $limit; 
			$config['link_func']   = 'search_Jenis_Kas'; 
			
			// Initialize pagination library 
			$this->ajax_pagination->initialize($config); 
			
			// Get records 
			$conditions['start'] = $offset; 
			$conditions['limit'] = $limit;
			$conditions['where'] = array( 
			'jenis_pengeluaran.kunci' => 0, 
			'jenis_pengeluaran.pub' => 'Y'
			); 
			unset($conditions['returnType']); 
			$data['result'] = $this->model_data->getJenisPengeluaran($conditions); 
			
			$conditions['offset'] = $offset; 
			// Load the data list view 
			$this->load->view('kas/cari-jenis', $data, false); 
		}
		
		public function jenis_kas()
		{
			$id = $this->input->post('id',TRUE);
			if($id==3){
				$id = 2;
				}else{
				$id = 1;
			}
			$result = $this->model_app->view_where_like('jenis_kas','id_akun',$id,'after')->result();
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($result));
		}
		public function load_jenis_kas(){
			$data = array();
			$result = $this->model_app->view_where('jenis_kas',array('id_akun'=>111));
			foreach ($result->result() as $row)
			{
				$data[] = array("id"=>$row->id_akun,"name"=>$row->title);
			}
			
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		public function detail_bayar()
		{
			$conditions[] ='';
			$data['result'] = $this->model_data->detailMerchant();
			$this->load->view('kas/detail_bayar', $data, false); 
		}
		
		
		public function cetak_laporan()
		{
			// print_r($_POST);
			$periode = $this->input->post('tanggal');
			// list($bulan,$tahun) = explode(' ',$periode);
			$data['info'] = info();
			$data['user'] = $this->model_app->view_where('tb_users', array('id_user' => $this->iduser))->row_array();
			$data['logo'] = FCPATH.'uploads/'.info()['logo'];
			$data['periode'] = $periode;
			
			$data['kas_kecil'] = $this->model_app->sum_data_math('SUM(`kas_masuk`.`pemasukan` - `kas_masuk`.`pengeluaran`) AS `total`','kas_masuk',['no_reff'=>111],'no_reff');
			
			$data['kas_penjualan'] = $this->model_app->sum_data_math('SUM(`kas_masuk`.`pemasukan` - `kas_masuk`.`pengeluaran`) AS `total`','kas_masuk',['no_reff'=>411],'no_reff');
			
			$data['kas_bank'] = $this->model_app->sum_data_math('SUM(`kas_masuk`.`pemasukan` - `kas_masuk`.`pengeluaran`) AS `total`','kas_masuk',['no_reff'=>110],'no_reff');
			
			$data['total'] = $data['kas_kecil'] + $data['kas_penjualan'] + $data['kas_bank'];
			
			$data['waicon'] 	= ['color'=>FCPATH.'assets/img/wa_icon.png','bw'=>FCPATH.'assets/img/wa_icon_bw.png'];
			$data['mail'] 		= ['color'=>FCPATH.'assets/img/gmail_icon.png','bw'=>FCPATH.'assets/img/gmail_icon_bw.png'];
			$data['fbicon'] 	= ['color'=>FCPATH.'assets/img/fb_icon.png','bw'=>FCPATH.'assets/img/fb_icon_bw.png'];
			$data['igicon'] 	= ['color'=>FCPATH.'assets/img/ig_icon.png','bw'=>FCPATH.'assets/img/ig_icon_bw.png'];
			
			$data['logo_blunas']	= FCPATH.'uploads/'.info()['logo_bw'];
			
			$this->load->library("pdf");
			$this->pdf->setPaper("A4", "portrait");
			$this->pdf->filename = "laporan_keuangan_" . $periode;
			$this->pdf->load_view("kas/cetak_laporan", $data);
			// $this->load->view('kas/cetak_laporan', $data, false); 
			
		}
		
		public function simpan_modal()
		{
			$no_reff = $this->input->post('akun');
			$jumlah = $this->input->post('jumlah');
			$keterangan = $this->input->post('keterangan');
			$this->db->trans_start();
			$autoNumber = autoNumber(NOMOR_REFF, DIGIT_REFF, 'id_generate', 'kas_masuk');
			$this->model_app->insert('kas_masuk', ['no_reff' => $no_reff, 'id_bayar' => 1, 'id_user' => $this->iduser, 'id_generate' => $autoNumber, 'catatan' => $keterangan, 'pemasukan' => $jumlah]);
			
			
			$jurnal_debet = ['id_user'=>$this->iduser,
			'no_reff'=>$no_reff,
			'tgl_input'=>today(),
			'tgl_transaksi'=>today(),
			'jenis_saldo'=>'debit',
			'saldo'=>$jumlah,
			'keterangan'=>$keterangan,
			];
			
			$jurnal_kredit = ['id_user'=>$this->iduser,
			'no_reff'=>311,
			'tgl_input'=>today(),
			'tgl_transaksi'=>today(),
			'jenis_saldo'=>'kredit',
			'saldo'=>$jumlah,
			'keterangan'=>$keterangan,
			];
			$this->model_app->jurnal_input($jurnal_debet);
			$this->model_app->jurnal_input($jurnal_kredit);
			$data = ['status'=>404,'msg'=>''];
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				$data = ['status'=>400,'msg'=>'Gagal'];
			}
			else
			{
				$this->db->trans_commit();
				$data = ['status'=>200,'msg'=>'Berhasil'];
			}
			echo json_encode($data);
		}
		
		private function cek_detail()
		{
			
			$arr1 = $this->db->select('*')->group_by('id_invoice')->get('invoice_detail')->result();
			foreach($arr1 AS $val1){
				$data1[] = $val1->id_invoice;
			}
			
			$arr2 = $this->model_app->view('invoice');
			foreach($arr2 AS $val2){
				$data2[] = $val2['id_invoice'];
			}
			
			$result=array_diff($data1,$data2);
			echo '<table class="table table-bordered table-hover">';
			if(!empty($result)){
				$jumlah =0;
				foreach($result  AS $key=>$val){
					
					$this->model_app->delete("invoice_detail", ['id_invoice'=>$val]);
					echo "<tr>";
					echo "<td>$val</td>";
					echo "</tr>";
				}
			}
			echo "</table>";
			echo "</div>";
			
		}
		
		public function reset_bayar()
		{
			$this->cek_detail();
			$arr1 = $this->db->select('*')->group_by('id_invoice')->get('bayar_invoice_detail')->result();
			foreach($arr1 AS $val1){
				$data1[] = $val1->id_invoice;
			}
			
			$arr2 = $this->model_app->view('invoice');
			foreach($arr2 AS $val2){
				$data2[] = $val2['id_invoice'];
			}
			
			$result=array_diff($data1,$data2);
			echo '<table class="table table-bordered table-hover">';
			if(!empty($result)){
				$jumlah =0;
				foreach($result  AS $key=>$val){
					// $cek_bayar = $this->model_app->view_where('bayar_invoice_detail',['id_invoice'=>$val])->row();
					// $jumlah += $cek_bayar->jml_bayar;
					$this->model_app->delete("bayar_invoice_detail", ['id_invoice'=>$val]);
					echo "<tr>";
					echo "<td>$val</td>";
					echo "</tr>";
				}
			}
			echo "</table>";
			echo "</div>";
			// dump($jumlah);
			$this->reset_kas();
		}
		
		private function cek_id_kas($id)
		{
			$cek = $this->model_app->pilih_where('id_kas','pengeluaran',['id_pengeluaran'=>$id]);
		}
		
		private function reset_kas()
		{
			$this->db->truncate('kas_masuk');
			$cek_bayar = $this->model_app->view('bayar_invoice_detail');
			// dump($cek_bayar);
			foreach($cek_bayar AS $val){
				
				if($val['id_bayar']==1)
				{
					$autoNumber = autoNumber(
					NOMOR_REFF,
					DIGIT_REFF,
					"id_generate",
					"kas_masuk"
					);
					
					$this->model_app->insert("kas_masuk", [
					"no_reff" => 411,
					"id_bayar" => $val['id_bayar'],
					"id_sub_bayar" => $val['id_sub_bayar'],
					"id_user" => $this->iduser,
					"id_generate" => $autoNumber,
					"pemasukan" => $val['jml_bayar'],
					"create_date" => $val['tgl_bayar'],
					"catatan" => "Pendapatan INVOICE NO.#" . $val['id_invoice'],
					]);
					
				}
				
				if($val['id_bayar']==2)
				{
					$autoNumber = autoNumber(
					NOMOR_REFF,
					DIGIT_REFF,
					"id_generate",
					"kas_masuk"
					);
					$this->model_app->insert("kas_masuk", [
					"no_reff" => 110,
					"id_bayar" => $val['id_bayar'],
					"id_sub_bayar" => $val['id_sub_bayar'],
					"id_user" => $this->iduser,
					"id_generate" => $autoNumber,
					"pemasukan" => $val['jml_bayar'],
					"create_date" => $val['tgl_bayar'],
					"catatan" => "Pendapatan INVOICE NO.#" . $val['id_invoice'],
					]);
				}
			}
			
			$cek_pengeluaran = $this->model_app->view('bayar_pengeluaran');
			// dump($cek_pengeluaran);
			foreach($cek_pengeluaran AS $val){
				$no_reff = $this->cek_id_kas($val['id_pengeluaran']);
				if($val['id_bayar']==1)
				{
					
					$autoNumber = autoNumber(
					NOMOR_REFF,
					DIGIT_REFF,
					"id_generate",
					"kas_masuk"
					);
					
					$this->model_app->insert("kas_masuk", [
					"no_reff" => $no_reff,
					"id_bayar" => $val['id_bayar'],
					"id_sub_bayar" => $val['id_sub_bayar'],
					"id_user" => $this->iduser,
					"id_generate" => $autoNumber,
					"pengeluaran" => $val['jml_bayar'],
					"create_date" => $val['tgl_bayar'],
					"catatan" => "Pengeluaran No.#" . $val['id_pengeluaran'],
					]);
					
				}
				
				if($val['id_bayar']==2)
				{
					// $where = ["no_reff"=>$no_reff,"id_sub_bayar"=>0,"catatan" => "Pengeluaran No.#" . $val['id_pengeluaran']];
					// $this->model_app->delete("kas_masuk", $where);
					$autoNumber = autoNumber(
					NOMOR_REFF,
					DIGIT_REFF,
					"id_generate",
					"kas_masuk"
					);
					
					$this->model_app->insert("kas_masuk", [
					"no_reff" => 110,
					"id_bayar" => $val['id_bayar'],
					"id_sub_bayar" => $val['id_sub_bayar'],
					"id_user" => $this->iduser,
					"id_generate" => $autoNumber,
					"pengeluaran" => $val['jml_bayar'],
					"create_date" => $val['tgl_bayar'],
					"catatan" => "Pengeluaran No.#" . $val['id_pengeluaran'],
					]);
				}
			}
		}
		
		public function cashback()
		{
			
			$data['title'] = 'Cashback | '.$this->title;		
			
			$this->template->load('main/themes','kas/cashback',$data);		
		}
		
		public function ajaxCashback(){
			$page = $this->input->post('page'); 
            if(!$page){ 
                $offset = 0; 
                }else{ 
                $offset = $page; 
			} 
            
            $limits = $this->input->post('limits'); 
            if(!empty($limits)){ 
                $limit = $limits; 
                }else{ 
                $limit = $this->perPage; 
			} 
            $sortBy = $this->input->post('sortBy'); 
            
            if(!empty($sortBy)){ 
                $conditions['search']['sortBy'] = $sortBy; 
			} 
			
            // Get record count 
            $conditions['returnType'] = 'count'; 
            $totalRec = $this->cashback->getCashback($conditions); 
            
            // Pagination configuration 
            $config['target']      = '#dataCashback'; 
            $config['base_url']    = base_url('kas/ajaxCashback'); 
            $config['total_rows']  = $totalRec; 
            $config['per_page']    = $limit; 
            $config['link_func']   = 'FilterCashback'; 
            
            // Initialize pagination library 
            $this->ajax_pagination->initialize($config); 
            // Get records 
            
			$conditions = array( 
            'start' => $offset, 
            'limit' => $limit 
			); 
			
			
            // print_r($conditions);
			
            unset($conditions['returnType']); 
			
            $data['result'] = $this->cashback->getCashback($conditions); 
            
            // Load the data list view 
            $this->load->view('kas/ajax-cashback', $data); 
		}
	}																																																																													