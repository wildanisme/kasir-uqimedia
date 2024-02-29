<?php
	defined('BASEPATH') or exit('No direct script access allowed');
	
	class Main extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			// cek_tabel();
			cek_session_login();
			$this->perPage = 10; 
			$this->title = info()['title']; 
			$this->tools = info()['dev_tools']; 
			$this->iduser = $this->session->idu; 
			$this->akses = $this->session->type_akses; 
			
		}
		
		public function cek_akses(){
			$id = $this->db->escape_str($this->input->post('id'));
			$mod = $this->db->escape_str($this->input->post('mod'));
			cek_type_akses(6,$this->iduser,$id,$mod);
		}
		public function ambildata(){
			$data['record'] = $this->model_app->view_ordering('tb_users','nama_lengkap','DESC');
			$arr = $this->load->view('main/user/ambildata',$data);
			$msg = array('hasil'=>$arr);
			echo json_encode($msg);
		}
		
		public function cek_order(){
			$id = $this->db->escape_str($this->input->post('id'));
			$total = $this->model_app->sum_data('jml_bayar','bayar_invoice_detail',['id_invoice'=>$id]);
			$cek = $this->model_app->view_where('invoice',['id_invoice'=>$id]);
			if($cek->num_rows() > 0){
				$row = $cek->row();
				$msg = array('status'=>'ok','id'=>$id,'notrx'=>get_id_transaksi($id)['nomor_order'],'total'=>$total,'ket'=>$row->history);
				}else{
				$msg = array('status'=>'error','id'=>0,'notrx'=>0);
			}
			echo json_encode($msg);
		}
		
		public function simpan_batal(){
			simpan_demo("Simpan");
			$id = $this->db->escape_str($this->input->post('no_order'));
			$mod = $this->db->escape_str($this->input->post('mod_batal'));
			$id_byrbatal = $this->db->escape_str($this->input->post('id_byrbatal'));
			$sumber_kas_batal = $this->db->escape_str($this->input->post('sumber_kas_batal'));
			$rekening_bayar = $this->db->escape_str($this->input->post('rekening_bayar'));
			$rekening_bayar = !empty($rekening_bayar) ? $rekening_bayar : 0;
			
			$total_batal = $this->db->escape_str($this->input->post('total_batal'));
			$total_batal = convert_to_number($total_batal);
			$keterangan = $this->db->escape_str($this->input->post('keterangan'));
			$query_cek = $this->model_cek->cek_akses(5,$this->iduser);
			if ($query_cek->num_rows()>0){
				$this->session->unset_userdata("cart");
				$where = array('id_invoice' => $id);
				
				$_where = ["catatan" => "Pendapatan INVOICE NO.#" . $id];
				$cek_invoice = $this->model_app->view_where('stok_keluar',$where);
				if($cek_invoice->num_rows() > 0){
					$data = array('status'=>'batal','oto'=>5,'history' => $keterangan);
					$res= $this->model_app->update('invoice', $data, $where);
					if($res['status']=='ok'){
						if($sumber_kas_batal!=211){
							$query_stok_keluar = $this->model_app->pilih_where('id_invoice,id_bahan,jumlah','stok_keluar',['id_invoice'=>$id])->result();
							
							foreach($query_stok_keluar AS $row){
								$cek_jenis_bahan = $this->model_app->pilih_where('kunci,status_stok','bahan',['id'=>$row->id_bahan])->row();
								if($cek_jenis_bahan->status_stok=='Y' AND $cek_jenis_bahan->kunci==1){
									$_data = [
									'id_bahan'=>$row->id_bahan,
									'jumlah'=>$row->jumlah,
									'create_date'=>today(),
									'ket'=>'Retur penjualan No.'.$row->id_invoice
									];
									$this->model_app->insert('stok_masuk',$_data);
								}
							}
							
							$this->model_app->update('bayar_invoice_detail', ['hapus'=>1], $where);
							$this->model_app->delete("deposit", $where);
							$this->model_app->delete("stok_keluar", $where);
							$this->model_app->delete("kas_masuk", $_where);
							$this->model_app->delete("jurnal_transaksi", ['reff'=>'O-'.$id]);
							$this->model_app->delete("jurnal_transaksi", ['reff'=>'I-'.$id]);
							
						}
						$msg = array('status'=>'ok','msg'=>'No. Order '. get_id_transaksi($id)['nomor_order'].' dibatalkan');
						}else{
						$msg = array('status'=>'err','msg'=>'Gagal');
					}
					}else{
					$data = array('status'=>'batal','oto'=>5,'history' => $keterangan);
					$res= $this->model_app->update('invoice', $data, $where);
					if($res['status']=='ok'){
						$this->model_app->update('bayar_invoice_detail', ['hapus'=>1], $where);
						$this->model_app->delete("stok_keluar", $where);
						// $this->model_app->delete("kas_masuk", $_where);
						$this->model_app->delete("jurnal_transaksi", ['reff'=>'O-'.$id]);
						
						$autoNumber = autoNumber(NOMOR_REFF,DIGIT_REFF,'id_generate','kas_masuk');
						$this->model_app->insert("kas_masuk", [
                        "id_bayar" => $id_byrbatal,
                        "id_sub_bayar" => $rekening_bayar,
                        "no_reff" => $sumber_kas_batal,
                        "id_user" => $this->iduser,
                        "id_generate" => $autoNumber,
                        "pengeluaran" => $total_batal,
                        "catatan" => "Batal Order No.#" . $id,
                        ]);
						$msg = array('status'=>'ok','msg'=>'No. Order '. get_id_transaksi($id)['nomor_order'].' dibatalkan');
						}else{
						$msg = array('status'=>'err','msg'=>'Gagal');
					}
				}
				}else{
				$msg = array('status'=>400,'msg'=>'Akses ditolak');
			}
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($msg));
		}
		public function logout(){
			$this->session->sess_destroy();
			redirect('adm');
		}
		
		public function menuadmin()
		{
			cek_menu_akses();
			$data['title'] = 'Menu Admin | ' .$this->title;
			$data['result'] = $this->model_app->view_where('hak_akses',['publish'=>'Y']);
			$this->template->load('main/themes','main/menuadmin',$data);
		}
		
		public function info()
		{
			cek_menu_akses();
			cek_crud_akses(8);
			$data['title'] = 'Pengaturan Aplikasi';
			$data['rows'] = $this->model_app->views('info')->row_array();
			$data['api_key'] = maskString($data['rows']['api_key']);
			$this->template->load('main/themes','main/website/info',$data);
		}
		
		public function info_save(){
			// dump($_POST);
			if (isset($_POST['submit'])){
				cek_crud_akses(9);
				save_demo_redirect('main/info');
				$config['upload_path'] = 'uploads/';
				$config['allowed_types'] = 'gif|jpg|png|ico|svg';
				$config['max_size'] = '1000'; // kb
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				$search=$this->model_app->view_where('info',array('id'=>1));
				if($search->num_rows()>0){
					$datas=$search->row();
					$nama_logo=$datas->logo;
					$nama_logo_bw=$datas->logo_bw;
					$nama_icon=$datas->favicon;
					$lunas=$datas->stamp_l;
					$blunas=$datas->stamp_b;
					$token_api=$datas->api_key;
				}
				
				if(!empty($_FILES["logo"]["name"])){
					$_logo=FCPATH."uploads/".$nama_logo;
					unlink($_logo);
					if(!$this->upload->do_upload('logo'))  
					{  
						echo $this->upload->display_errors();  
					}  
					else  
					{  
						$data = $this->upload->data();  
						$nama_logo = $data["file_name"];
					}  
				}
				
				if(!empty($_FILES["logo_bw"]["name"])){
					$_logo=FCPATH."uploads/".$nama_logo_bw;
					unlink($_logo);
					if(!$this->upload->do_upload('logo_bw'))  
					{  
						echo $this->upload->display_errors();  
					}  
					else  
					{  
						$data = $this->upload->data();  
						$nama_logo_bw = $data["file_name"];
					}  
				}
				if(!empty($_FILES["icon"]["name"])){
					$favicon=FCPATH."uploads/".$nama_icon;
					unlink($favicon);
					if(!$this->upload->do_upload('icon'))  
					{  
						echo $this->upload->display_errors();  
					}  
					else  
					{  
						$data = $this->upload->data();  
						$nama_icon = $data["file_name"];
					}  
				}
				if(!empty($_FILES["lunas"]["name"])){
					$favicon=FCPATH."uploads/".$lunas;
					unlink($favicon);
					if(!$this->upload->do_upload('lunas'))  
					{  
						echo $this->upload->display_errors();  
					}  
					else  
					{  
						$data = $this->upload->data();  
						$lunas = $data["file_name"];
					}  
				}
				if(!empty($_FILES["blunas"]["name"])){
					$favicon=FCPATH."uploads/".$blunas;
					unlink($favicon);
					if(!$this->upload->do_upload('blunas'))  
					{  
						echo $this->upload->display_errors();  
					}  
					else  
					{  
						$data = $this->upload->data();  
						$blunas = $data["file_name"];
					}  
				}
				$qris = $this->input->post('qris');
				
				if(empty($qris)){
					$qris = '';
					}else{
					$qris = $qris;
					$this->generate_qrcode($qris);
				}
				
				if($this->input->post('checkbox') == 'on'){
					$token_api = $this->input->post('token_api');
				}
				$data = array('title'=>$this->input->post('title')
				,'deskripsi'=>base64_encode($this->input->post('deskripsi'))
				,'ket'=>base64_encode($this->input->post('ket'))
				,'footer_invoice'=>base64_encode($this->input->post('footer'))
				,'email'=>$this->input->post('email')
				,'perusahaan'=>$this->input->post('perusahaan')
				,'phone'=>$this->input->post('phone')
				,'fb'=>$this->input->post('fb')
				,'ig'=>$this->input->post('ig')
				,'api_key'=>$token_api
				,'logo'=>$nama_logo
				,'logo_bw'=>$nama_logo_bw
				,'stamp_l'=>$lunas
				,'stamp_b'=>$blunas
				,'warna_lunas'=>$this->input->post('warna_lunas')
				,'warna_blunas'=>$this->input->post('warna_blunas')
				,'tema'=>$this->input->post('tema')
				,'keywords'=>$this->input->post('keywords')
				,'kode_qris'=>$qris
				,'dev_tools'=>$this->input->post('devtools', TRUE)
				,'favicon'=>$nama_icon);	
				$where = array('id' => 1);
				$res= $this->model_app->update('info', $data, $where);
				if($res['status']=='ok'){
					$this->session->set_flashdata('message', '<script>notif("Data di simpan","success");</script>');
					redirect('main/info');
					}else{
					$this->session->set_flashdata('message', '<script>notif("Data gagal di simpan","danger");</script>');
					redirect('main/info');
				}
			}
		}
		
		private function generate_qrcode($data)
		{
			/* Load QR Code Library */
			$this->load->library('ciqrcode');
			
			/* Data */
			$hex_data   = bin2hex($data);
			$save_name  = 'qris.png';
			
			/* QR Code File Directory Initialize */
			$dir = './uploads/qrcode/';
			if (file_exists($dir.$save_name)) {
				unlink($dir.$save_name);
			}
			if (!file_exists($dir)) {
				mkdir($dir, 0775, true);
			}
			
			/* QR Configuration  */
			$config['cacheable']    = true;
			$config['imagedir']     = $dir;
			$config['quality']      = true;
			$config['size']         = '1024';
			$config['black']        = array(255,255,255);
			$config['white']        = array(255,255,255);
			$this->ciqrcode->initialize($config);
			
			/* QR Data  */
			$params['data']     = $data;
			$params['level']    = 'L';
			$params['size']     = 10;
			$params['savename'] = FCPATH.$config['imagedir']. $save_name;
			
			$this->ciqrcode->generate($params);
			
			/* Return Data */
			$return = array(
            'content' => $data,
            'file'    => $dir. $save_name
			);
			return $return;
		}
		
		public function json_chart(){
			$data=$this->model_data->get_chart();
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		
		public function crud(){
			
			$type = $this->input->get('type', TRUE);
			$gdata = $this->input->get('data', TRUE);
			$id = $this->input->get('id', TRUE);('id');
			$label = $this->input->get('label', TRUE);
			$link = $this->input->get('link', TRUE);
			$eclass = $this->input->get('eclass', TRUE);
			$treeview = $this->input->get('parentc', TRUE);
			$target = $this->input->get('target', TRUE);
			$aktif = $this->input->get('aktif', TRUE);
			$submenu = $this->input->get('submenu', TRUE);
			if($type=='get'){
				$data = array();
				$return = $this->db->query("SELECT * FROM menuadmin WHERE idmenu='".$id."'")->row_array();	
				$data = array(
				'id' => $return['idmenu'],
				'label' => $return['nama_menu'],
				'link' => $return['link'],
				'target' => $return['target'],
				'eclass' => $return['icon'],
				'parentc' => $return['treeview'],
				'aktif' => $return['aktif'],
				'level' => $return['id_level'],
				'submenu' => $return['link_on']
				);	
				$this->output
				->set_content_type('application/json')
				->set_output(json_encode($data));
				}elseif($type=='simpan'){
				menu_demo();
				$data = json_decode($this->input->get('data', TRUE));
				function parseJsonArray($jsonArray, $parentID = 0) {
					$return = array();
					foreach ($jsonArray as $subArray) {
						$returnSubSubArray = array();
						if (isset($subArray->children)) {
							$returnSubSubArray = parseJsonArray($subArray->children, $subArray->id);
						}
						$return[] = array('id' => $subArray->id, 'parentID' => $parentID);
						$return = array_merge($return, $returnSubSubArray);
					}
					return $return;
				}
				
				$readbleArray = parseJsonArray($data);
				
				$i=0;
				foreach($readbleArray as $row){
					$qry = $this->db->query("update menuadmin set idparent = '".$row['parentID']."', urutan='$i' where idmenu = '".$row['id']."' ");
					$i++;
				}
				}elseif($type=='hapus'){
				menu_demo();
				function recursiveDeleteMenu($id) {
					$ci = & get_instance();
					$data = array('hapus'=>'hapus');
					$query = $ci->model_app->view_where('menuadmin',['idparent' =>$id]);
					if ($query->num_rows >0) {
						foreach ($query->result_array() as $current){
							recursiveDeleteMenu($current['idmenu']);
						}
					}
					
					$qry =$ci->model_app->hapus('menuadmin',['idmenu'=>$id]);
					if($qry['status']=='ok'){
						$data = array(0=>'ok');;
						}else{
						$data = array(0=>'error');;
					}
					return json_encode($data);
				}
				echo recursiveDeleteMenu($id);
			}
		}
		public function save_menu(){
			menu_demo();
			
			$type = $this->input->get('type', TRUE);
			$id = $this->input->get('id', TRUE);('id');
			$label = $this->input->get('label', TRUE);
			$link = $this->input->get('link', TRUE);
			$target = $this->input->get('target', TRUE);
			$eclass = $this->input->get('eclass', TRUE);
			$treeview = $this->input->get('parentc', TRUE);
			$aktif = $this->input->get('aktif', TRUE);
			$submenu = $this->input->get('submenu', TRUE);
			$level = $this->input->get('level', TRUE);
			
			
			///
			if($type=='simpan'){
				if($id != ''){
					$data_update = [
					'nama_menu'=>$label,
					'link'=>$link,
					'icon'=>$eclass,
					'treeview'=>$treeview,
					'id_level'=>$level,
					'target'=>$target,
					'aktif'=>$aktif,
					'link_on'=>$submenu
					];
					$this->model_app->update('menuadmin', $data_update, ['idmenu'=>$id]);
					
					$id_level = $this->model_app->pilih_where('id_level','hak_akses',['publish'=>'Y'])->result();
					$_level = explode(',',$level);
					foreach ($id_level as $rows){
						foreach ($_level as $row){
							if($rows->id_level==$row){
								$data_user = atur_menu($row);
								$this->model_app->update('tb_users', ['idmenu'=>$data_user], ['id_level'=>$row]);
								}else{
								$data_user = atur_menu($rows->id_level);
								$this->model_app->update('tb_users', ['idmenu'=>$data_user], ['id_level'=>$rows->id_level]);
							}
						}
					}
					
					$arr['type']  = 'edit';
					$arr['msg'] = 'Data di Updated';
					$arr['label'] = $label;
					$arr['link']  = $link;
					$arr['eclass']  = $eclass;
					$arr['parentc']  = $treeview;
					$arr['aktif']  = $aktif;
					$arr['submenu']  = $submenu;
					$arr['target']  = $target;
					$arr['level']  = $level;
					$arr['id']    = $id;
					} else {
					$row = $this->db->query("SELECT max(urutan)+1 as urutan FROM menuadmin")->row_array();
					$qry = $this->db->query("insert into menuadmin (nama_menu,link,icon,id_level,treeview,aktif,target,link_on,urutan) values ('".$label."', '".$link."', '".$eclass."', '".$level."', '".$treeview."', '".$aktif."','".$target."','".$submenu."','".$row['urutan']."')");
					if($qry){
						$arr['ok'] = 'ok';
						$lastid = $this->db->insert_id();
						 
						$id_level = $this->model_app->pilih_where('id_level','hak_akses',['publish'=>'Y'])->result();
						$_level = explode(',',$level);
						foreach ($id_level as $rows){
							foreach ($_level as $row){
								if($rows->id_level==$row){
									$data_user = atur_menu($row);
									$this->model_app->update('tb_users', ['idmenu'=>$data_user], ['id_level'=>$row]);
									}else{
									$data_user = atur_menu($rows->id_level);
									$this->model_app->update('tb_users', ['idmenu'=>$data_user], ['id_level'=>$rows->id_level]);
								}
							}
						}
						
						$arr['menu'] = '<li class="dd-item dd3-item '.$aktif.'" data-id="'.$lastid.'" >
						<div class="dd-handle dd3-handle"></div>
						<div class="ns-row">
						<div class="ns-title" id="label_show'.$lastid.'">'.$label.'</div>
						<div class="ns-url" id="link_show'.$lastid.'">'.$link.'</div> 
						<div class="ns-class" id="eclass_show'.$lastid.'">'.$eclass.'</div>
						<div class="ns-actions">
						<a class="edit-button" id="'.$lastid.'" label="'.$label.'" link="'.$link.'" eclass="'.$eclass.'" parentc="'.$treeview.'"><i class="fa fa-pencil"></i></a>
						<a href="#" class="confirm-delete" data-id="'.$lastid.'" id="'.$lastid.'"><i class="fa fa-trash"></i></a>
						</div> 
						</div>
						<script>
						$(".confirm-delete").on("click", function(e) {
						e.preventDefault();
						var id = $(this).data("id");
						$("#myModalDel").data("id", id).modal("show");
						});
						</script>';
						}else{
						$arr['type'] = 'error';
					}
					$arr['type'] = 'add';
					$arr['msg'] = 'Data di simpan';
				}
			}
			
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($arr));
		}
		
		
		
		public function printer()
		{
			cek_menu_akses();
			$data['title'] = 'Pengaturan printer |' .$this->title;
			$data['judul'] ='Pengaturan printer';
			
			$this->template->load('main/themes','main/printer',$data);
		}
		public function data_printer()
		{
			$data['record'] = $this->model_app->view_ordering('printer','id','DESC');
			$this->load->view('main/data_printer',$data);
		}
		public function edit_printer(){
			$id= $this->db->escape_str($this->input->post('id'));
			if($id>0){
				$where = array('id' => $id);
				$row = $this->model_app->edit('printer',$where)->row_array();
				
				$data = array(
				'id'    =>$id,
				'jenis' =>$row['name'],
				'shared'=>$row['shared_name'],
				'ukuran'=>$row['ukuran_kertas'],
				'font_size'=>$row['ukuran_font'],
				'posisi'=>$row['posisi'],
				'item'  =>$row['max_item'],
				'aktif' =>$row['pub'],
				'show_footer' =>$row['show_footer']
				);
				
				}else{
				$data = array('id'=>0,'jenis'=>"",'shared'=>'','ukuran'=>'','posisi'=>'','item'=>'',"aktif"=>"");
			}
			$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
		}
		
		public function save_printer()
		{
			cek_nput_post('GET');
			// simpan_demo('Simpan');
			$id    = $this->db->escape_str($this->input->post('id'));
			$type  = $this->db->escape_str($this->input->post('type'));
			$judul = $this->db->escape_str($this->input->post('judul'));
			$shared= $this->db->escape_str($this->input->post('shared'));
			$ukuran= $this->db->escape_str($this->input->post('ukuran'));
			$font_size= $this->db->escape_str($this->input->post('font_size'));
			$posisi= $this->db->escape_str($this->input->post('posisi'));
			$item  = $this->db->escape_str($this->input->post('item'));
			$aktif = $this->db->escape_str($this->input->post('aktif'));
			$show_footer = $this->db->escape_str($this->input->post('show_footer'));
			
			if($id > 0 AND $type=='on'){
				$this->model_app->update('printer',array('pub'=>$aktif),array('id'=>$id));
				$this->model_app->update('printer',array('pub'=>0),array('id!='=>$id));
				$data = array('status'=>200,'msg'=>'Data berhasil update');
			}elseif($id > 0 AND $type=='off')
			{
				$res=  $this->model_app->update('printer',array('pub'=>1),array('id'=>$id));
				$this->model_app->update('printer',array('pub'=>0),array('id!='=>$id));
				$data = array('status'=>200,'msg'=>'Data berhasil update');
			}elseif($id > 0 AND $type=='edit')
			{
				$_data = array('name'=>$judul,'shared_name'=>$shared,'ukuran_kertas'=>$ukuran,'ukuran_font'=>$font_size,'posisi'=>$posisi,'max_item'=>$item,'pub'=>$aktif,'show_footer'=>$show_footer);
				if($aktif==1){
					$res=  $this->model_app->update('printer',$_data,array('id'=>$id));
					$xdata = array('pub'=>0);
					$this->model_app->update('printer',$xdata,array('id!='=>$id));
					}else{
					$res=  $this->model_app->update('printer',$_data,array('id'=>$id));
				}
				///data update
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
		public function folder()
		{
			cek_menu_akses();
			$data['title'] = 'Pengaturan Folder | ' .$this->title;
			
			$this->cek_folder();
			
			$data['rows'] = ["computer_name"  =>pengaturan('computer_name'),
			"folder_af" =>pengaturan('folder_af'),
			"folder_gm" =>pengaturan('folder_gm'),
			"folder_ns" =>pengaturan('folder_ns'),
			"folder_tz" =>pengaturan('folder_tz'),
			"ukuran" =>!empty(pengaturan('ukuran')) ? pengaturan('ukuran') : 'U',
			"qty" =>!empty(pengaturan('qty')) ? pengaturan('qty') : 'Q',
			"bahan" =>!empty(pengaturan('bahan')) ? pengaturan('bahan') : 'B',
			"produk" =>!empty(pengaturan('produk')) ? pengaturan('produk') : 'P',
			"tanggal" =>!empty(pengaturan('tanggal')) ? pengaturan('tanggal') : 'TGL',
			"fo" =>!empty(pengaturan('fo')) ? pengaturan('fo') : 'FO',
			];
			$this->template->load('main/themes','main/website/folder',$data);
		}
		
		private function cek_folder()
		{
			$query = $this->model_app->view_where('shared_folder',['id' =>6]);
			if ($query->num_rows() < 1) {
				$this->model_app->input('shared_folder',['id'=>6,'nama'=>'ukuran','isi'=>'U']);
				$this->model_app->input('shared_folder',['id'=>7,'nama'=>'qty','isi'=>'Q']);
				$this->model_app->input('shared_folder',['id'=>8,'nama'=>'bahan','isi'=>'B']);
				$this->model_app->input('shared_folder',['id'=>9,'nama'=>'produk','isi'=>'P']);
				$this->model_app->input('shared_folder',['id'=>10,'nama'=>'tanggal','isi'=>'TGL']);
				$this->model_app->input('shared_folder',['id'=>11,'nama'=>'fo','isi'=>'FO']);
			}
		}
		public function c3d6fa211a7c7a(){
			$data['tools'] = $this->tools;
			$this->c3d6fas11a7c7a($data);
		}
		
		private function c3d6fas11a7c7a($data){
			return $this->load->view('home',$data);
		}
		
		public function save_folder()
		{
			simpan_demo('Simpan');
			if (isset($_POST['submit'])){
				
				$computer_name = array('isi'=>xss_filter($this->input->post('computer_name'),'folder'));
				// dump($computer_name,'print_r','exit');
				$computer_where = array('nama'=>'computer_name');	
				$update = $this->model_app->update('shared_folder',$computer_name,$computer_where);
				
				$ukuran_name = array('isi'=>xss_filter($this->input->post('ukuran_folder'),'xss'));
				$ukuran_where = array('nama'=>'ukuran');	
				$this->model_app->update('shared_folder',$ukuran_name,$ukuran_where);
				
				$qty_name = array('isi'=>xss_filter($this->input->post('qty_folder'),'xss'));
				$qty_where = array('nama'=>'qty');	
				$this->model_app->update('shared_folder',$qty_name,$qty_where);
				
				$bahan_name = array('isi'=>xss_filter($this->input->post('bahan_folder'),'xss'));
				$bahan_where = array('nama'=>'bahan');	
				$this->model_app->update('shared_folder',$bahan_name,$bahan_where);
				
				$produk_name = array('isi'=>xss_filter($this->input->post('produk_folder'),'xss'));
				$produk_where = array('nama'=>'produk');	
				$this->model_app->update('shared_folder',$produk_name,$produk_where);
				
				$tanggal_name = array('isi'=>xss_filter($this->input->post('tgl_folder'),'xss'));
				$tanggal_where = array('nama'=>'tanggal');	
				$this->model_app->update('shared_folder',$tanggal_name,$tanggal_where);
				
				$fo_name = array('isi'=>xss_filter($this->input->post('fo_folder'),'xss'));
				$fo_where = array('nama'=>'fo');	
				$this->model_app->update('shared_folder',$fo_name,$fo_where);
				
				if($update['status']=='ok'){
					$this->session->set_flashdata('message', '<script>notif("Data di simpan","success");</script>');
					redirect('main/folder');
					}else{
					$this->session->set_flashdata('message', '<script>notif("Data gagal di simpan","danger");</script>');
					redirect('main/folder');
				}
			}
			
		}
		
	}				
