<?php
	defined('BASEPATH') or exit('No direct script access allowed');
	
	class Laporan extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			// cek_tabel();
			cek_session_login();
			$this->info = info();
			$this->back = $this->agent->referrer();
			$this->iduser = $this->session->idu;
			$this->perPage = 10; 
			$this->title = info()['title']; 
		}
		
		public function omset_penjualan()
		{
			cek_menu_akses();
			$data['title'] ='Laporan Omset Penjualan | '.info()['title'];
			
			$data['dari'] = tgl_dari_slash();	
			$this->template->load('main/themes','laporan/omset_penjualan',$data);
		}
		
		public function penjualan()
		{
			cek_menu_akses();
			$data['title'] ='Laporan Penjualan | '.info()['title'];
			
			$data['dari'] = tgl_dari_slash();	
			$data['jenis'] = $this->model_app->view_where('jenis_cetakan',['pub'=>'Y','kunci'=>0])->result(); 
			$this->template->load('main/themes','laporan/penjualan',$data);
		}
		//bahan
		public function produk(){
			cek_nput_post('GET');
			$dari = $this->input->post('dari'); 
			$sampai = $this->input->post('sampai'); 
			$page = $this->input->post('page');
			
			
			if(!$page){ 
				$offset = 0; 
				}else{ 
				$offset = $page; 
			} 
			
			
			// Pagination configuration 
			$config['target']      = '#dataProduk'; 
			$config['base_url']    = base_url('laporan/produk'); 
			
			$config['link_func']   = 'search_LaporanProduk'; 
			
			
			if(!empty($dari)){ 
				$dari = date_slash($this->input->post('dari')); 
				$conditions['search']['dari'] = $dari; 
			} 
			if(!empty($sampai)){ 
				$sampai = date_slash($this->input->post('sampai')); 
				$conditions['search']['sampai'] = $sampai; 
			} 
			// dump($sampai);
			$data['result'] = $this->model_data->getLaporanPenjualan($dari,$sampai);
			
			$this->load->view('laporan/laporan-produk', $data, false); 
		}
		
		public function pergrup(){
			cek_nput_post('GET');
			
			$dari = $this->input->post('dari'); 
			$sampai = $this->input->post('sampai'); 
			$page = $this->input->post('page'); 
			$jenis = $this->input->post('jenis'); 
			if(!$page){ 
				$offset = 0; 
				}else{ 
				$offset = $page; 
			} 
			
			// dump($_POST);
			if(!empty($dari)){ 
				$dari = date_slash($this->input->post('dari')); 
				$conditions['search']['dari'] = $dari; 
			} 
			if(!empty($sampai)){ 
				$sampai = date_slash($this->input->post('sampai')); 
				$conditions['search']['sampai'] = $sampai; 
			} 
			if(!empty($jenis)){ 
				$conditions['where'] = array(
				"produk.id_jenis" => $jenis,
				"invoice.status" => 'simpan'
				); 
				}else{
				$conditions['where'] = array(
				"invoice.status" => 'simpan'
				); 
			}
			
			// Get record count 
			$conditions['returnType'] = 'count'; 
			$totalRec = $this->model_data->getLaporanPergrup($conditions); 
			
			// Pagination configuration 
			$config['target']      = '#dataKategori'; 
			$config['base_url']    = base_url('laporan/pergrup'); 
			$config['total_rows']  = $totalRec; 
			$config['per_page']    = $this->perPage; 
			$config['link_func']   = 'search_LaporanGrup'; 
			
			// Initialize pagination library 
			$this->ajax_pagination->initialize($config); 
			
			// Get records 
			$conditions['start'] = $offset; 
			$conditions['limit'] = $this->perPage;
			if(!empty($jenis)){ 
				$conditions['where'] = array(
				"produk.id_jenis" => $jenis,
				"invoice.status" => 'simpan'
				); 
				}else{
				$conditions['where'] = array(
				"invoice.status" => 'simpan'
				); 
			}
			if(!empty($dari)){ 
				$dari = date_slash($this->input->post('dari')); 
				$conditions['search']['dari'] = $dari; 
			} 
			if(!empty($sampai)){ 
				$sampai = date_slash($this->input->post('sampai')); 
				$conditions['search']['sampai'] = $sampai; 
			}  
			unset($conditions['returnType']); 
			$data['id_jenis'] = $jenis;
			$data['jenis'] = $this->model_app->view_where('jenis_cetakan',['pub'=>'Y','kunci'=>0])->result(); 
			$data['result'] = $this->model_data->getLaporanPergrup($conditions); 
			
			// Load the data list view 
			$this->load->view('laporan/laporan-pergrup', $data, false); 
		}
		
		public function perkategori(){	
			cek_nput_post('GET');
			$dari = $this->input->post('dari'); 
			$sampai = $this->input->post('sampai'); 
			$page = $this->input->post('page'); 
			if(!$page){ 
				$offset = 0; 
				}else{ 
				$offset = $page; 
			} 
			
			
			if(!empty($dari)){ 
				$dari = date_slash($this->input->post('dari')); 
				$conditions['search']['dari'] = $dari; 
			} 
			if(!empty($sampai)){ 
				$sampai = date_slash($this->input->post('sampai')); 
				$conditions['search']['sampai'] = $sampai; 
			} 
			
			// Get record count 
			$conditions['returnType'] = 'count'; 
			$totalRec = $this->model_data->getLaporanPerkategori($conditions); 
			
			// Pagination configuration 
			$config['target']      = '#dataKategori'; 
			$config['base_url']    = base_url('laporan/perkategori'); 
			$config['total_rows']  = $totalRec; 
			$config['per_page']    = $this->perPage; 
			$config['link_func']   = 'search_LaporanKategori'; 
			
			// Initialize pagination library 
			$this->ajax_pagination->initialize($config); 
			
			// Get records 
			$conditions['start'] = $offset; 
			$conditions['limit'] = $this->perPage;
			$conditions['where'] = array(
			"invoice.status" => 'simpan'
			); 
			if(!empty($dari)){ 
				$dari = date_slash($this->input->post('dari')); 
				$conditions['search']['dari'] = $dari; 
			} 
			if(!empty($sampai)){ 
				$sampai = date_slash($this->input->post('sampai')); 
				$conditions['search']['sampai'] = $sampai; 
			}  
			unset($conditions['returnType']); 
			$data['result'] = $this->model_data->getLaporanPerkategori($conditions); 
			
			// Load the data list view 
			$this->load->view('laporan/laporan-perkategori', $data, false); 
		}
		
		public function cariPendapatan()
		{
			cek_nput_post('GET');
			$dari = $this->input->post('dari'); 
			$sampai = $this->input->post('sampai'); 
			
			if(!empty($dari)){ 
				$dari = date_dmy($this->input->post('dari')); 
				$conditions['search']['dari'] = $dari; 
			} 
			if(!empty($sampai)){ 
				$sampai = date_dmy($this->input->post('sampai')); 
				$conditions['search']['sampai'] = $sampai; 
			}
			
			$data['penjualan'] 		= $this->model_data->getLabaRugi($conditions);
			$data['pengeluaran'] 	= $this->model_data->getLabaRugiBiaya($conditions);
			$this->load->view('laporan/laporan-labarugi', $data, false);
		}
		
		
		public function cetak_laporan_penjualan(){
			$jenis = $this->input->post('jenis'); 
			$id_jenis = $this->input->post('id_jenis'); 
			// dump($jenis);
			if(isset($jenis)){
				$dari = $this->input->post('startdate'); 
				$sampai = $this->input->post('enddate'); 
				if(!empty($dari)){ 
					$dari = date_slash($this->input->post('startdate')); 
				} 
				if(!empty($sampai)){ 
					$sampai = date_slash($this->input->post('enddate')); 
				} 
				
				$data['logo'] = FCPATH.'uploads/'.info()['logo_bw'];			
				$data['info'] = info();
				$data['dari'] = $dari;
				$data['sampai'] = $sampai;
				$data['user'] = $this->model_app->view_where('tb_users', array('id_user' => $this->iduser))->row_array();
				$this->load->library('pdf');				
				$this->pdf->setPaper('A4', 'potrait');				
				$this->pdf->filename = "laporan_penjualan";	
				if($jenis=='produk'){ 
					$data['detail'] = $this->model_data->getLaporanPenjualan($dari,$sampai);
				}
				if($jenis=='kategori'){ 
					$data['detail'] = $this->model_data->getLaporanPenjualanJenis($dari,$sampai);
				}
				if($jenis=='grup'){ 
					$data['detail'] = $this->model_data->getLaporanPenjualanGrup($id_jenis,$dari,$sampai);
				}
				$this->pdf->load_view('laporan/cetak_laporan_penjualan', $data);	
				
				// $this->load->view('laporan/cetak_laporan_penjualan', $data);				
				
				}else{
				$data['cetak']       = 'error';
				$this->load->view('errors/404',$data);
			}
		}
		
		public function cetak_laporan_pendapatan(){
			$dari = $this->input->post('startdate'); 
			$sampai = $this->input->post('enddate'); 
			// echo $dari;
			if(isset($dari)){
				
				if(!empty($dari)){ 
					$dari = date_dmy($this->input->post('startdate')); 
					$data['search']['dari'] = $dari; 
				} 
				if(!empty($sampai)){ 
					$sampai = date_dmy($this->input->post('enddate')); 
					$data['search']['sampai'] = $sampai; 
				} 
				
				$data['logo']           = FCPATH.'uploads/'.info()['logo_bw'];			
				$data['info']           = info();
				$data['user']           = $this->model_app->view_where('tb_users', array('id_user' => $this->iduser))->row_array();
				$data['penjualan'] 		= $this->model_data->getLabaRugi($data);
				$data['pengeluaran'] 	= $this->model_data->getLabaRugiBiaya($data);
				
				$this->load->library('pdf');				
				$this->pdf->setPaper('A5', 'landscape');				
				$this->pdf->filename = "laporan_penjualan";				
				$this->pdf->load_view('laporan/cetak_laporan_pendapatan', $data);	
				
				}else{
				$data['cetak']       = 'error';
				$this->load->view('errors/404',$data);
			}
		}
		
		public function cetak_data_bahan(){
			$data['waicon'] 	= ['color'=>FCPATH.'assets/img/wa_icon.png','bw'=>FCPATH.'assets/img/wa_icon_bw.png'];
			$data['mail'] 		= ['color'=>FCPATH.'assets/img/gmail_icon.png','bw'=>FCPATH.'assets/img/gmail_icon_bw.png'];
			$data['fbicon'] 	= ['color'=>FCPATH.'assets/img/fb_icon.png','bw'=>FCPATH.'assets/img/fb_icon_bw.png'];
			$data['igicon'] 	= ['color'=>FCPATH.'assets/img/ig_icon.png','bw'=>FCPATH.'assets/img/ig_icon_bw.png'];
			
			$data['logo_blunas']	= FCPATH.'uploads/'.info()['logo_bw'];
			$data['info']			= info();
			$data['tanggal']		= today();
			$data['user']			= $this->model_app->view_where('tb_users', array('id_user' => $this->iduser))->row_array();
			$data['laporan']		= $this->model_app->view_where('bahan',['id >'=>1])->result(); 
			
			$this->load->library('pdf');				
			$this->pdf->setPaper('A4', 'landscape');					
			$this->pdf->filename = "laporan_data_bahan_".date('d_F_Y');				
			$this->pdf->load_view('laporan/cetak_data_bahan', $data);	
		}
		
		public function cetak_stok_bahan(){
			$data['waicon'] 	= ['color'=>FCPATH.'assets/img/wa_icon.png','bw'=>FCPATH.'assets/img/wa_icon_bw.png'];
			$data['mail'] 		= ['color'=>FCPATH.'assets/img/gmail_icon.png','bw'=>FCPATH.'assets/img/gmail_icon_bw.png'];
			$data['fbicon'] 	= ['color'=>FCPATH.'assets/img/fb_icon.png','bw'=>FCPATH.'assets/img/fb_icon_bw.png'];
			$data['igicon'] 	= ['color'=>FCPATH.'assets/img/ig_icon.png','bw'=>FCPATH.'assets/img/ig_icon_bw.png'];
			
			$data['logo_blunas']	= FCPATH.'uploads/'.info()['logo_bw'];
			$data['info']			= info();
			$data['tanggal']		= today();
			$data['user']			= $this->model_app->view_where('tb_users', array('id_user' => $this->iduser))->row_array();
			$data['laporan']		= $this->model_app->view_where('bahan',['id >'=>1,'status_stok'=>'Y'])->result(); 
			
			$mod = modul_cetak('cetak_stok');
			$this->load->library('pdf');				
			$this->pdf->setPaper($mod['ukuran'], $mod['posisi']);					
			$this->pdf->filename = "laporan_stok_bahan_".date('d_F_Y');				
			$this->pdf->load_view('laporan/cetak_stok_bahan', $data);	
			// $this->load->view('laporan/cetak_stok_bahan', $data);	
		}
		
		public function cetak_order_harian(){
			
			if(!empty($_POST)){
				$sortby = ($this->input->post('sortby_cetak')); 
				$status = ($this->input->post('trx_cetak')); 
				$tanggal = $this->input->post('tanggal_cetak'); 
				
				$date = date_ranges($tanggal);
				$dari = date_replace_slash($date['dari']);
				$sampai = date_replace_slash($date['sampai']);
				$data['periode']	= 'Tanggal Order';
				$data['tanggal']	= today();
				if(!empty($sortby)){ 
					$conditions['search']['sortBy'] = $sortby; 
				} 
				if(!empty($status)){ 
					$conditions['search']['trx'] = $status; 
				} 
				if(!empty($tanggal)){
					$conditions["search"]["dari"] = $dari;
					$conditions["search"]["sampai"] = $sampai;
					if(strtotime($dari)==strtotime($sampai)){
						$data['periode']	= 'Tanggal Order';
						$data['tanggal']	= $date['dari'];
						}else{
						$data['periode']	= 'Peroide Order';
						$data['tanggal']	= $date['dari'].' - '.$date['sampai'];
					}
				} 
				$conditions['where']= array(
				'invoice.status !='=>'baru'
				); 
				
				
				$show_footer = $this->model_app->view_where('printer', ['slug' => 'in'])->row()->show_footer;
				//icon
				$data['waicon'] 	= ['color'=>FCPATH.'assets/img/wa_icon.png','bw'=>FCPATH.'assets/img/wa_icon_bw.png'];
				$data['mail'] 		= ['color'=>FCPATH.'assets/img/gmail_icon.png','bw'=>FCPATH.'assets/img/gmail_icon_bw.png'];
				$data['fbicon'] 	= ['color'=>FCPATH.'assets/img/fb_icon.png','bw'=>FCPATH.'assets/img/fb_icon_bw.png'];
				$data['igicon'] 	= ['color'=>FCPATH.'assets/img/ig_icon.png','bw'=>FCPATH.'assets/img/ig_icon_bw.png'];
				
				$data['logo_blunas']	= FCPATH.'uploads/'.info()['logo_bw'];
				$data['info']			= info();
				$data['show_footer']	= $show_footer;
				
				$data['user']			= $this->model_app->view_where('tb_users', array('id_user' => $this->iduser))->row_array();
				$data['laporan']		= $this->model_data->getRows($conditions); 
				$data['penjualan']		= $this->model_data->getLabaRugi($data);
				$data['pengeluaran']	= $this->model_data->getLabaRugiBiaya($data);
				
				$mod = modul_cetak('cetak_order');
				$this->load->library('pdf');				
				$this->pdf->setPaper($mod['ukuran'], $mod['posisi']);					
				$this->pdf->filename = "laporan_penjualan";				
				$this->pdf->load_view('laporan/cetak_order_harian', $data);	
				// $this->load->view('laporan/cetak_order_harian', $data);	
				}else{
				$data['cetak']       = 'error';
				$this->load->view('errors/404',$data);
			}
		}
		public function cetak_piutang()
		{
			// dump($_POST);
			$iduser= $this->db->escape_str($this->input->post('user'));		
			$periode= $this->db->escape_str($this->input->post('range'));		
			
			$keywords= $this->db->escape_str($this->input->post('keywords'));		
			
			if($iduser !='' AND !empty($periode)){
				$date = date_ranges($periode);
				$dari = date_replace_slash($date['dari']);
				$sampai = date_replace_slash($date['sampai']);
				
				$waktu = 'invoice.tgl_trx BETWEEN "'. date('Y-m-d', strtotime($dari)). '" and "'. date('Y-m-d', strtotime($sampai)).'"';				
				
				if ( substr($keywords,0,1 )== '0' )			
				{
					$whereSQL = "AND konsumen.no_hp LIKE '%$keywords%'";				
					}elseif($keywords!=''){
					$whereSQL = "AND konsumen.nama LIKE '%$keywords%'";				
					}elseif(is_numeric($keywords)){				
					$whereSQL = "AND invoice.id_invoice =".$keywords;				
					}else{				
					$whereSQL = "";				
				}			
				
				if ($iduser=='0' AND $keywords==''){
					$data['user'] = 'SEMUA KASIR';			
					$where = "WHERE $waktu AND `invoice`.`status` = 'simpan'";				
					}elseif ($iduser=='0' AND $keywords!=''){				
					$data['user'] = 'SEMUA KASIR';			
					$where = "WHERE $waktu  $whereSQL  AND `invoice`.`status` = 'simpan'";				
					}else{				
					$_user = $this->model_app->view_where('tb_users', array('id_user' => $iduser))->row();
					$data['user'] = $_user->nama_lengkap;			
					$where = "WHERE $waktu AND `invoice`.`id_user` = '$iduser' $whereSQL  AND `invoice`.`status` = 'simpan'" ;				
				}						
				
				$tgl    = date("Y-m-d H:i:s");
				$data['logo'] = FCPATH.'uploads/'.info()['logo'];
				$data['logop'] = base_url().'uploads/'.info()['logo'];
				$data['info'] = info();
				$data['tgl'] = date('d/m/Y'); 
				
				if(strtotime($dari)==strtotime($sampai)){
					$data['periode']	= 'Tanggal';
					$data['tanggal']	= $date['dari'];
					}else{
					$data['periode']	= 'Peroide';
					$data['tanggal']	= $date['dari'].' - '.$date['sampai'];
				}
				
				$data['detail'] = $this->model_data->piutang($where);	
				$this->load->library('pdf');
				$this->pdf->setPaper('A5', 'landscape');
				$this->pdf->filename = "rekap_".$tgl;
				$this->pdf->load_view('pembukuan/cetak_piutang', $data);
				// $this->load->view('pembukuan/cetak_piutang',$data);
				}else{
				$data['cetak']       = 'error';
				
				$this->load->view('errors/404',$data);
			}
		}
		
		public function desain(){
			cek_menu_akses();
			$data['title'] = 'Data Desain | '.info()['title'];
			$data['tgl'] = date('d/m/Y');	
			$params =  ['id'=>'id_user','title'=>'nama_lengkap']; 
			if($this->session->level=='admin'){
				$desain[] = $this->model_app->view_where('tb_users',['aktif'=>'Y'])->result();	
				$data['select'] = select_box($desain,0,0,'',$params);
				}else{
				$desain[] = $this->model_app->view_where('tb_users',['aktif'=>'Y'])->result();
				$data['select'] = select_box($desain,0,0,$this->iduser,$params);	
			}
			
			// $conditions['where'] = array(
			// 'invoice.status' => 'pending'
			// );
			
			
			$conditions['returnType'] = 'count'; 
			$totalRec = $this->model_data->getDesain($conditions); 
			
			// Pagination configuration 
			$config['target']      = '#dataDesain'; 
			$config['base_url']    = base_url('laporan/ajaxdesain'); 
			$config['total_rows']  = $totalRec; 
			$config['per_page']    = $this->perPage; 
			$config['link_func']   = 'search_Desain'; 
			// Initialize pagination library 
			$this->ajax_pagination->initialize($config); 
			
			// Get records 
			$conditions = array( 
            'limit' => $this->perPage 
			); 
			// $conditions['where'] = array(
			// 'invoice.status' => 'pending'
			// );
			
			$data['posts'] = $this->model_data->getDesain($conditions); 
			// dump($data['posts']);
			$this->template->load('main/themes','laporan/desain',$data);
		}
		public function ajaxDesain(){
			cek_nput_post('GET');
			$dari = date_slash($this->input->post('dari')); 
			$sampai = date_slash($this->input->post('sampai')); 
			
			$page = $this->input->post('page'); 
			if(!$page){ 
				$offset = 0; 
				}else{ 
				$offset = $page; 
			} 
			
			
			if(!empty($dari)){ 
				$conditions['search']['dari'] = $dari; 
			} 
			
			if(!empty($sampai)){ 
				$conditions['search']['sampai'] = $sampai; 
			} 
			
			$jenis = $this->input->post('jenis'); 
			if($jenis!=1){ 
				$conditions['where'] = array(
				'invoice.status' => $jenis
				);
			} 
			// print_r($conditions);
			$user = $this->input->post('user'); 
			if(!empty($user)){ 
				$conditions['where'] = array(
				'invoice.id_desain' => $user
				);
			} 
			
			$conditions['returnType'] = 'count'; 
			$totalRec = $this->model_data->getDesain($conditions); 
			
			// Pagination configuration 
			$config['target']      = '#dataDesain'; 
			$config['base_url']    = base_url('laporan/ajaxdesain'); 
			$config['total_rows']  = $totalRec; 
			$config['per_page']    = $this->perPage; 
			$config['link_func']   = 'search_Desain'; 
			
			// Initialize pagination library 
			$this->ajax_pagination->initialize($config); 
			
			
			unset($conditions['returnType']); 
			$data['result'] = $this->model_data->getDesain($conditions); 
			
			// Load the data list view 
			$this->load->view('laporan/laporan-desain', $data, false); 
		}
		public function operator(){
			$data['title'] ='Laporan operator | '.$this->title;
			
			$data['pilihan'] = $this->model_app->pilih('id_user, nama_lengkap','tb_users')->result_array();		
			
			// $conditions['where'] = array(
			// 'invoice.status' => 'simpan'
			// );
			
			$dari 	= date('Y-m-').'01';				
			$conditions['search']['dari'] = $dari; 
			$conditions['search']['sampai'] = date("Y-m-d"); 
			
			$conditions['returnType'] = 'count'; 
			$totalRec = $this->model_data->get_operator($conditions); 
			
			// Pagination configuration 
			$config['target']      = '#dataListOmset'; 
			$config['base_url']    = base_url('laporan/ajaxOperator'); 
			$config['total_rows']  = $totalRec; 
			$config['per_page']    = $this->perPage; 
			$config['link_func']   = 'search_Operator'; 
			// Initialize pagination library 
			$this->ajax_pagination->initialize($config); 
			
			// Get records 
			$conditions = array( 
            'limit' => $this->perPage 
			); 
			
			// $conditions['where'] = array(
			// 'invoice.status' => 'simpan'
			// );
			$dari 	= date('Y-m-').'01';				
			$conditions['search']['dari'] = $dari; 
			$conditions['search']['sampai'] = date("Y-m-d"); 
			$data['dari'] = tgl_dari_slash();
			$data['sampai'] = tgl_sampai_slash();
			$data['posts'] = $this->model_data->get_operator($conditions); 
			$data['produk'] = $this->model_app->view_where('produk',['pub'=>1])->result_array(); 
			// print_r($data['produk']);
			$this->template->load('main/themes','laporan/operator',$data);
		}
		//23:15 08/10/2023
		public function spk(){
			$data['title'] ='Laporan operator | '.$this->title;
			
			$data['pilihan'] = $this->model_app->pilih('id_user, nama_lengkap','tb_users')->result_array();		
			
			$conditions['where'] = array(
			'invoice.status' => 'simpan'
			);
			
			$dari 	= date('Y-m-').'01';				
			$conditions['search']['dari'] = $dari; 
			$conditions['search']['sampai'] = date("Y-m-d"); 
			
			$conditions['returnType'] = 'count'; 
			$totalRec = $this->model_data->get_operator($conditions); 
			
			// Pagination configuration 
			$config['target']      = '#dataListOmset'; 
			$config['base_url']    = base_url('laporan/ajaxSpk'); 
			$config['total_rows']  = $totalRec; 
			$config['per_page']    = $this->perPage; 
			$config['link_func']   = 'search_Operator'; 
			// Initialize pagination library 
			$this->ajax_pagination->initialize($config); 
			
			// Get records 
			$conditions = array( 
            'limit' => $this->perPage 
			); 
			
			$conditions['where'] = array(
			'invoice.status' => 'simpan'
			);
			$dari 	= date('Y-m-').'01';				
			$conditions['search']['dari'] = $dari; 
			$conditions['search']['sampai'] = date("Y-m-d"); 
			$data['dari'] = tgl_dari_slash();
			$data['sampai'] = tgl_sampai_slash();
			$data['posts'] = $this->model_data->get_operator($conditions); 
			// print_r($data['posts']);
			$this->template->load('main/themes','laporan/spk',$data);
		}
		
		//19:45 07/19/2023
		public function ajaxSpk()
		{
			
			$page = $this->input->post('page');
			if (!$page) {
				$offset = 0;
				} else {
				$offset = $page;
			}
			$sortBy = $this->input->post('sortBy');
			if (!empty($sortBy)) {
				$conditions['search']['sortBy'] = $sortBy;
			}
			$limits = $this->input->post('limits');
			if (!empty($limits)) {
				$limit = $limits;
				} else {
				$limit = $this->perPage;
			}
			// Set conditions for search and filter
			$user = $this->input->post('user');
			$dari = date_slash($this->input->post('dari'));
			$sampai = date_slash($this->input->post('sampai'));
			
			$conditions['where'] = array(
			'invoice.status' => 'simpan'
			);
			
			if (!empty($user)) {
				$conditions['where'] = array(
				'invoice.id_user' => $user
				);
			}
			
			if (!empty($dari)) {
				$conditions['search']['dari'] = $dari;
			}
			if (!empty($sampai)) {
				$conditions['search']['sampai'] = $sampai;
			}
			
			
			
			// Get record count
			$conditions['returnType'] = 'count';
			$totalRec = $this->model_data->get_operator($conditions);
			
			// Pagination configuration
			$config['target'] = '#dataListOmset';
			$config['base_url'] = base_url('laporan/ajaxSpk');
			$config['total_rows'] = $totalRec;
			$config['per_page'] = $limit;
			$config['link_func'] = 'search_Operator';
			
			// Initialize pagination library
			$this->ajax_pagination->initialize($config);
			
			// Get records
			$conditions['start'] = $offset;
			$conditions['limit'] = $limit;
			
			$conditions['where'] = array(
			'invoice.status' => 'simpan'
			);
			if (!empty($user)) {
				$conditions['where'] = array(
				'invoice.id_user' => $user
				);
			}
			
			unset($conditions['returnType']);
			
			$data['posts'] = $this->model_data->get_operator($conditions);
			$data['user'] = $user;
			$data['status_order'] = $this->input->post('status');
			// Load the data list view 
			$this->load->view('laporan/ajax-spk', $data, false); 
		}
		//19:45 07/19/2023
		public function ajaxOperator()
		{
			
			$page = $this->input->post('page');
			if (!$page) {
				$offset = 0;
				} else {
				$offset = $page;
			}
			
			$limits = $this->input->post('limits');
			if (!empty($limits)) {
				$limit = $limits;
				} else {
				$limit = $this->perPage;
			}
			// Set conditions for search and filter
			$user = $this->input->post('user');
			$produk = $this->input->post('produk');
			$dari = date_slash($this->input->post('dari'));
			$sampai = date_slash($this->input->post('sampai'));
			
			// $conditions['where'] = array(
			// 'invoice.status' => 'simpan'
			// );
			
			if (!empty($user)) {
				$conditions['where'] = array(
				'invoice.id_user' => $user
				);
			}
			$keywords = $this->input->post('invoice_op');
			if (!empty($keywords)) {
				$conditions["search"]["keywords"] = $keywords;
			}
			if (!empty($dari)) {
				$conditions['search']['dari'] = $dari;
			}
			if (!empty($sampai)) {
				$conditions['search']['sampai'] = $sampai;
			}
			
			
			
			
			// Get record count
			$conditions['returnType'] = 'count';
			$totalRec = $this->model_data->get_operator($conditions);
			
			// Pagination configuration
			$config['target'] = '#dataListOmset';
			$config['base_url'] = base_url('laporan/ajaxOperator');
			$config['total_rows'] = $totalRec;
			$config['per_page'] = $limit;
			$config['link_func'] = 'search_Operator';
			
			// Initialize pagination library
			$this->ajax_pagination->initialize($config);
			
			// Get records
			$conditions['start'] = $offset;
			$conditions['limit'] = $limit;
			
			// $conditions['where'] = array(
			// 'invoice.status' => 'simpan'
			// );
			if (!empty($user)) {
				$conditions['where'] = array(
				'invoice.id_user' => $user
				);
			}
			
			unset($conditions['returnType']);
			
			$data['posts'] = $this->model_data->get_operator($conditions);
			$data['produk'] = $produk;
			$data['status_order'] = $this->input->post('status');
			// Load the data list view 
			$this->load->view('laporan/ajax-operator', $data, false); 
		}
		
		public function simpan_laporan()
		{
			
			$id = $this->input->post('id');
			$id = decrypt_url($id);
			$arr = ['Error request'];
			if (!empty($id)) {
				$type = $this->input->post('type');
				$status = $this->input->post('status');
				
				$data = ['status' => $status, 'id_operator' => $this->iduser];
				$arr = $this->update_status_laporan($data,$id);
				if ($status == 3) {
					input_stok_keluar($id);
				}
				} else {
				$arr = ['Error request'];
			}
			echo json_encode($arr);
			
		}
		
		private function update_status_laporan($data,$id){
			$update = $this->model_app->update('invoice_detail', $data, [
			'id_invoice' => $id
			]);
			if ($update) {
				$arr = [
				'status' => 200,
				'title' => 'Simpan Status',
				'msg' => 'Berhasil disimpan'
				];
				} else {
				$arr = [
				'status' => 400,
				'title' => 'Simpan Status',
				'msg' => 'Gagal disimpan'
				];
			}
			return $arr;
		}
		public function get_laporan(){
			
			$id = $this->input->post('id');
			$id = decrypt_url($id);
			$row = $this->model_app
			->view_where('invoice_detail', ['id_invoice' => $id])
			->row();
			
			$data = [
			'id' => $row->id_rincianinvoice,
			'nomor_order' => get_id_transaksi($row->id_invoice)['nomor_order'],
			'idorder' => encrypt_url($row->id_invoice),
			'status' => $row->status
			];
			echo json_encode($data);
			
		}
		
		public function load_modal(){
			$id= $this->db->escape_str($this->input->post('id'));	
			$id = decrypt_url($id);
			$iduser= $this->db->escape_str($this->input->post('user'));			
			$format = "%Y-%m-%d";			
			$mdate = mdate($format);
			
			$cek_invoice = $this->model_app
			->view_where('surat_jalan', ['id_invoice' => $id]);
			if($cek_invoice->num_rows() > 0){
				$row = $cek_invoice->row();
				$data['id'] = $row->id;
				$data['id_user']  = $row->id_user;
				$data['tanggal']  = $row->tanggal;
				$data['no_pol']  = $row->no_pol;
				$data['alamat_kirim']  = $row->alamat_kirim;
				$data['status'] = $row->stat;
				}else{
				
				$datain = [
				"id_invoice" => $id,
				"tanggal" => $mdate
				];
				$input = $this->model_app->input("surat_jalan", $datain);
				if($input['status']=='ok'){
					$data['id'] = $input['id'];
					$data['id_user']  = '';
					$data['tanggal']  = $mdate;
					$data['no_pol']  = '';
					$data['alamat_kirim']  = '';
					$data['status'] = 0;
				}
			}
			$data['user'] = $this->model_app
			->view_where('tb_users', ['aktif' => 'Y'])
			->result();
			
			$data['row'] = $this->model_app
			->view_where('invoice', ['id_invoice' => $id])
			->row();
			// dump($data['row'],'print_r','exit');
			$data["detail"] = $this->model_app->produk_cart([
			"invoice_detail.id_invoice" => $id,
			]);
			
			$this->load->view('laporan/load_modal', $data, false);
		}
		public function load_modal_spk(){
			$id= $this->db->escape_str($this->input->post('id'));	
			$id = decrypt_url($id);
			$iduser= $this->db->escape_str($this->input->post('user'));			
			$format = "%Y-%m-%d";			
			$mdate = mdate($format);
			
			
			$data['user'] = $this->model_app
			->view_where('tb_users', ['aktif' => 'Y'])
			->result();
			
			$data['row'] = $this->model_app
			->view_where('invoice', ['id_invoice' => $id])
			->row();
			// dump($data['row'],'print_r','exit');
			$data["detail"] = $this->model_app->produk_cart([
			"invoice_detail.id_invoice" => $id,
			]);
			
			$this->load->view('laporan/load_modal_spk', $data, false);
		}
		
		public function simpan_spk(){
			$id_invoice = decrypt_url($this->db->escape_str($this->input->post('id_invoive')));
			$no_order = $this->db->escape_str($this->input->post('no_order'));
			$id = $this->db->escape_str($this->input->post('id'));
			$no_spk = $this->db->escape_str($this->input->post('no_spk'));
			
			$data             = array();        
			$index            = 0;  
			
			foreach($id as $key){
				
				array_push($data, array(
				'id'              =>$key,
				'no_spk'          =>$no_spk[$index]
				));
				$update = $this->model_app->update('invoice_detail',['no_spk'=>$no_spk[$index]],['id_rincianinvoice'=>$key,'id_invoice'=>$id_invoice]);
				$index++;    
			}
			// dump($data);
			
			
			if($update['status']=='ok'){
				$arr = ['status'=>200,'msg'=>'sukses','id'=>encrypt_url($id_invoice)];
				}else{
				$arr = ['status'=>400,'msg'=>'gagal'];
			}
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($arr));
		}
		
		public function simpan_surat(){
			$no_surat = $this->db->escape_str($this->input->post('no_surat'));
			$id_invoice = decrypt_url($this->db->escape_str($this->input->post('id_invoive')));
			$no_order = $this->db->escape_str($this->input->post('no_order'));
			$pengirim = $this->db->escape_str($this->input->post('pengirim'));
			$nopol = $this->db->escape_str($this->input->post('nopol'));
			$alamat = $this->db->escape_str($this->input->post('alamat'));
			$id = $this->db->escape_str($this->input->post('id'));
			$jml = $this->db->escape_str($this->input->post('jumlah'));
			$title = $this->db->escape_str($this->input->post('title'));
			$bahan = $this->db->escape_str($this->input->post('bahan'));
			$ukuran = $this->db->escape_str($this->input->post('ukuran'));
			$keterangan = $this->db->escape_str($this->input->post('keterangan'));
			// dump($_POST,'print_r','exit');
			$data             = array();        
			$index            = 0;  
			
			foreach($id as $key){
				
				array_push($data, array(
				'id'              =>$key,
				'jumlah'          =>$jml[$index],
				'title'     	  =>$title[$index],
				'bahan' 	      =>$bahan[$index], 
				'ukuran'          =>$ukuran[$index],
				'keterangan'      =>$keterangan[$index]
				));
				
				$index++;    
			}
			
			$detail = json_encode(['detail'=>$data]);
			
			$array = [
			'id_user'=>$pengirim,
			'id_invoice'=>$id_invoice,
			'no_pol'=>$nopol,
			'alamat_kirim'=>$alamat,
			'catatan'=>$detail,
			'stat'=>1,
			];
			// dump($array,'print_r','exit');
			$update = $this->model_app->update('surat_jalan',$array,['id'=>$no_surat]);
			if($update['status']=='ok'){
				$arr = ['status'=>200,'msg'=>'sukses','id'=>encrypt_url($no_surat)];
				}else{
				$arr = ['status'=>400,'msg'=>'gagal'];
			}
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($arr));
		}
		public function suratjalan()
		{
			$data['title'] ='Laporan Surat Jalan | '.$this->title;
			
			$data['pilihan'] = $this->model_app->pilih('id_user, nama_lengkap','tb_users')->result_array();		
			
			$conditions['where'] = array(
			'surat_jalan.stat' => 1
			);
			
			$dari 	= date('Y-m-').'01';				
			$conditions['search']['dari'] = $dari; 
			$conditions['search']['sampai'] = date("Y-m-d"); 
			
			$conditions['returnType'] = 'count'; 
			$totalRec = $this->model_data->getSurat($conditions); 
			
			// Pagination configuration 
			$config['target']      = '#dataListOmset'; 
			$config['base_url']    = base_url('laporan/ajaxSuratjalan'); 
			$config['total_rows']  = $totalRec; 
			$config['per_page']    = $this->perPage; 
			$config['link_func']   = 'search_surat'; 
			// Initialize pagination library 
			$this->ajax_pagination->initialize($config); 
			
			// Get records 
			$conditions = array( 
            'limit' => $this->perPage 
			); 
			
			$conditions['where'] = array(
			'surat_jalan.stat' => 1
			);
			
			$dari 	= date('Y-m-').'01';				
			$conditions['search']['dari'] = $dari; 
			$conditions['search']['sampai'] = date("Y-m-d"); 
			$data['dari'] = tgl_dari_slash();
			$data['sampai'] = tgl_sampai_slash();
			$data['posts'] = $this->model_data->getSurat($conditions); 
			
			$this->template->load('main/themes','laporan/surat_jalan',$data);
		}
		public function ajaxSuratjalan()
		{
			$page = $this->input->post('page');
			if (!$page) {
				$offset = 0;
				} else {
				$offset = $page;
			}
			$sortBy = $this->input->post('sortBy');
			if (!empty($sortBy)) {
				$conditions['search']['sortBy'] = $sortBy;
			}
			$limits = $this->input->post('limits');
			if (!empty($limits)) {
				$limit = $limits;
				} else {
				$limit = $this->perPage;
			}
			// Set conditions for search and filter
			$user = $this->input->post('user');
			$dari = date_slash($this->input->post('dari'));
			$sampai = date_slash($this->input->post('sampai'));
			
			$conditions['where'] = array(
			'surat_jalan.stat' => 1
			);
			
			if (!empty($user)) {
				$conditions['where'] = array(
				'surat_jalan.id_user' => $user
				);
			}
			
			if (!empty($dari)) {
				$conditions['search']['dari'] = $dari;
			}
			if (!empty($sampai)) {
				$conditions['search']['sampai'] = $sampai;
			}
			
			// Get record count
			$conditions['returnType'] = 'count';
			$totalRec = $this->model_data->getSurat($conditions);
			
			// Pagination configuration
			$config['target'] = '#dataListOmset';
			$config['base_url'] = base_url('laporan/getSurat');
			$config['total_rows'] = $totalRec;
			$config['per_page'] = $limit;
			$config['link_func'] = 'search_surat';
			
			// Initialize pagination library
			$this->ajax_pagination->initialize($config);
			
			// Get records
			$conditions['start'] = $offset;
			$conditions['limit'] = $limit;
			
			$conditions['where'] = array(
			'surat_jalan.stat' => 1
			);
			
			if (!empty($user)) {
				$conditions['where'] = array(
				'surat_jalan.id_user' => $user
				);
			}
			
			unset($conditions['returnType']);
			
			$data['posts'] = $this->model_data->getSurat($conditions);
			$data['user'] = $user;
			
			// Load the data list view 
			$this->load->view('laporan/ajax-surat', $data, false); 
		}
		public function cetak_surat($id='')
		{
			$id = decrypt_url($id);
			
			$cek = $this->model_app->view_where('surat_jalan',['id'=>$id]);
			if($cek->num_rows() > 0){
				$data['cetak'] = $cek->row();
				$row = $this->model_app->view_where('invoice', ['id_invoice'=>$cek->row()->id_invoice])->row();
				// dump($row,'print_r','exit');
				$data['konsumen'] = $this->model_app->view_where('konsumen', array('id' => $row->id_konsumen))->row_array();
				$data['marketing']   = $this->model_app->view_where('tb_users', array('id_user' => $cek->row()->id_user))->row_array();
				$data['order'] = $row;
				$data['info'] = info();
				//icon
				$data['waicon'] 	= ['color'=>FCPATH.'assets/img/wa_icon.png','bw'=>FCPATH.'assets/img/wa_icon_bw.png'];
				$data['mail'] 		= ['color'=>FCPATH.'assets/img/gmail_icon.png','bw'=>FCPATH.'assets/img/gmail_icon_bw.png'];
				$data['fbicon'] 	= ['color'=>FCPATH.'assets/img/fb_icon.png','bw'=>FCPATH.'assets/img/fb_icon_bw.png'];
				$data['igicon'] 	= ['color'=>FCPATH.'assets/img/ig_icon.png','bw'=>FCPATH.'assets/img/ig_icon_bw.png'];
				
				$data['logo_lunas'] = FCPATH.'uploads/'.info()['logo'];
				$data['logo_blunas'] = FCPATH.'uploads/'.info()['logo_bw'];
				$data['lunas'] = FCPATH.'uploads/'.info()['stamp_l'];
				$data['blunas'] = FCPATH.'uploads/'.info()['stamp_b'];
				$data['favicon'] = FCPATH.'uploads/'.info()['favicon'];
				$data['html'] = 'N';
				$pub = array('pub' =>1);//printer aktif
				$cek_printer = $this->model_app->view_where('printer', $pub);
				$rowc = $cek_printer->row_array();
				$this->load->library('pdf');
				$this->pdf->setPaper('A4', 'potrait');
				$this->pdf->filename = "surat_jalan_".$id."_".$cek->row()->tanggal;
				$this->pdf->load_view('laporan/print_surat_jalan', $data);
				// $this->load->view('laporan/print_surat_jalan',$data);
				}else{
				$data['cetak']       = 'error';
				$this->load->view('errors/404',$data);
			}
		}
		
		public function cetak_laporan_operator(){
			// dump($_POST);
			if(!empty($_POST)){
				
				$status = ($this->input->post('status')); 
				$operator = ($this->input->post('operator')); 
				
				$dari = date_slash($this->input->post('startdate'));
				$sampai = date_slash($this->input->post('enddate'));
				
				$conditions['where'] = array(
				'invoice.status' => 'simpan'
				);
				
				if (!empty($operator)) {
					$conditions['where'] = array(
					'invoice.id_user' => $operator
					);
				}
				
				if (!empty($dari)) {
					$conditions['search']['dari'] = $dari;
				}
				if (!empty($sampai)) {
					$conditions['search']['sampai'] = $sampai;
				}
				
				//icon
				$data['waicon'] 	= ['color'=>FCPATH.'assets/img/wa_icon.png','bw'=>FCPATH.'assets/img/wa_icon_bw.png'];
				$data['mail'] 		= ['color'=>FCPATH.'assets/img/gmail_icon.png','bw'=>FCPATH.'assets/img/gmail_icon_bw.png'];
				$data['fbicon'] 	= ['color'=>FCPATH.'assets/img/fb_icon.png','bw'=>FCPATH.'assets/img/fb_icon_bw.png'];
				$data['igicon'] 	= ['color'=>FCPATH.'assets/img/ig_icon.png','bw'=>FCPATH.'assets/img/ig_icon_bw.png'];
				
				$data['logo_blunas']	= FCPATH.'uploads/'.info()['logo_bw'];
				$data['info']			= info();
				$data['periode']		= $this->input->post('startdate') .' - '. $this->input->post('enddate');
				$data['tanggal']		= date("Y-m-d"); ;
				$data['user']			= $this->model_app->view_where('tb_users', array('id_user' => $this->iduser))->row_array();
				$data['laporan']		= $this->model_data->get_operator($conditions); 
				$mod = modul_cetak('cetak_order');
				$this->load->library('pdf');				
				$this->pdf->setPaper('A4', 'landscape');					
				$this->pdf->filename = "laporan_penjualan";				
				$this->pdf->load_view('laporan/cetak_laporan_operator', $data);	
				// $this->load->view('laporan/cetak_laporan_operator', $data);	
				}else{
				$data['cetak']       = 'error';
				$this->load->view('errors/404',$data);
			}
		}
	}																																																																																																																																																														