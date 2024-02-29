<?php
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(0);
class Gudang extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// cek_tabel();
		cek_session_login();
		$this->load->model("model_gudang");

		$this->info = info();
		$this->back = $this->agent->referrer();
		$this->perPage = 10;
		$this->iduser = $this->session->idu;
		$this->level = $this->session->level;
	}

	public function stok_barang($kategori = '', $id = '')
	{

		$data['title'] = 'Data & Stok Barang | ' . info()['title'];
		$data['judul'] = 'Data & Stok Barang';
		// Get record count 
		$conditions['where'] = array(
			'stat' => 1
		);


		$conditions['returnType'] = 'count';
		$totalRec = $this->model_gudang->getInventory($conditions);

		// Pagination configuration 
		$config['target']      = '#posts_content';
		$config['base_url']    = base_url('gudang/ajaxInventory');
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config['link_func']   = 'searchMutasiPenerimaan';

		// Initialize pagination library 
		$this->ajax_pagination->initialize($config);

		// Get records 
		$conditions = array(
			'limit' => $this->perPage
		);

		$conditions['where'] = array(
			'stat' => 1
		);
		$data['iduser'] = $this->iduser;
		$data['list'] = $this->model_gudang->getInventory($conditions);

		$data['mutasi'] = $this->model_gudang->get_current_mutasi($data['list']);
		$data['divisi'] = $this->model_gudang->load_divisi();

		$this->template->load('main/themes', 'stok_gudang/data-barang', $data);
	}

	function ajaxInventory()
	{
		// Define offset 
		$page = $this->input->post('page');
		if (!$page) {
			$offset = 0;
		} else {
			$offset = $page;
		}
		$limit = $this->input->post('limit');
		if (!$limit) {
			$limit = $this->perPage;
		} else {
			$limit = $limit;
		}
		$keywords = $this->input->post('keywords');
		if (!empty($keywords)) {
			$conditions['search']['keywords'] = $keywords;
		}
		$sortBy = $this->input->post('sortBy');
		if (!empty($sortBy)) {
			$conditions['search']['sortBy'] = $sortBy;
		}

		// Get record count 
		$conditions['returnType'] = 'count';
		$totalRec = $this->model_gudang->getInventory($conditions);

		// Pagination configuration 
		$config['target']      = '#posts_content';
		$config['base_url']    = base_url('gudang/ajaxInventory');
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $limit;
		$config['link_func']   = 'searchMutasiPenerimaan';

		// Initialize pagination library 
		$this->ajax_pagination->initialize($config);

		// Get records 
		$conditions['start'] = $offset;
		$conditions['limit'] = $limit;
		if (!empty($sortBy)) {
			$conditions['search']['sortBy'] = $sortBy;
		}
		$conditions['where'] = array(
			'stat' => 1
		);
		// $sWhere = "WHERE level='owner' AND parent='$iduser' OR level='marketing' AND parent='$iduser'";
		unset($conditions['returnType']);
		$data['list'] = $this->model_gudang->getInventory($conditions);
		// print_r($data['list']); 
		if (!empty($data['list'])) {
			$data['mutasi'] = $this->model_gudang->get_current_mutasi($data['list']);
		}
		$data['start'] = $offset;
		// Load the data list view 
		$this->load->view('stok_gudang/cari-stok-masuk', $data);
	}

	public function load_detail()
	{

		$idmaster = $this->db->escape_str($this->input->post('id'));
		$row = $this->model_gudang->get_page("nama_barang", $idmaster);
		$data['row'] = $row;
		$data['idmaster'] = $idmaster;
		$data['divisi'] = $this->model_app->view_where('tb_users', ['aktif' => 'Y'])->result_array();
		// print_r($data['divisi']);
		$data['item_mutasi'] = $this->model_gudang->item_mutasi($idmaster);
		$this->load->view('stok_gudang/detail_global', $data, false);
	}

	public function load_detail_divisi()
	{

		$iddivisi = $this->db->escape_str($this->input->post('id'));
		$idmaster = $this->db->escape_str($this->input->post('idmaster'));
		// echo $idmaster;
		$row = $this->model_gudang->get_page("nama_barang", $idmaster);
		$data['row'] = $row;
		$data['idmaster'] = $idmaster;
		$data['iddivisi'] = $iddivisi;
		$data['divisi'] = $this->model_app->view_where('tb_users', ['aktif' => 'Y'])->result_array();
		$data['disabled'] = '';
		if ($iddivisi == 0) {
			$data['item_mutasi'] = $this->model_gudang->item_mutasi($idmaster);
			$this->load->view('stok_gudang/detail_global', $data);
		} else {
			$data['item_mutasi'] = $this->model_gudang->item_mutasi_divisi($idmaster, $iddivisi);
			$this->load->view('stok_gudang/detail_divisi', $data);
		}
	}

	public function load_terima()
	{
		$id = $this->db->escape_str($this->input->post('id'));
		$row = $this->model_app->edit('nama_barang', ['id' => $id])->row();
		$data = ['id' => $row->id, 'title' => $row->title, 'tgl' => date('Y-m-d'), 'pengguna' => $this->iduser];
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	public function notifikasi_stok()
	{
		$result = $this->model_gudang->notif_stok();



		if (!empty($result)) {
			$counter = count($result);
?>

			<li class="nav-item dropdown no-arrow mx-1">
				<a class="nav-link dropdown-toggle" href="javascript:void(0)" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					<i class="fa fa-bell fa-fw"></i>
					<span class="badge badge-danger badge-counter"><?= $counter; ?></span>
				</a>
				<div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
					<h6 class="dropdown-header">
						Notifikasi Stok Gudang
					</h6>
					<?php foreach ($result as $row) {
						$stok = $row->stok - $row->pemakaian;
					?>
						<a class="dropdown-item d-flex align-items-center" href="#">
							<div class="mr-3">
								<div class="icon-circle bg-primary">
									<i class="fas fa-file-alt text-white"></i>
								</div>
							</div>
							<div>
								<div class="small text-gray-500"><?= strtoupper($row->title); ?></div>
								<span class="font-weight-bold">SISA STOK : <?= $stok; ?></span>
							</div>
						</a>
					<?php }
					?>

					<a class="dropdown-item text-center small text-gray-500" href="<?= base_url('gudang/stok_barang'); ?>">LIHAT DETAIL STOK</a>
				</div>
			</li>
<?php }
	}

	public function notification_limit()
	{

		$result = $this->model_gudang->notif_stok();

		$response = array();
		foreach ($result as $row) {

			$response[] = $row->stok - $row->pemakaian;
		}

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
	}

	public function simpan_barang_diterima()
	{
		$idmaster = $this->db->escape_str($this->input->post('id'));

		$arr = array(
			"id_barang" => $idmaster,
			"id_user" => $this->iduser,
			"create_date" => $this->db->escape_str($this->input->post('tanggal')),
			"jumlah" => $this->db->escape_str($this->input->post('jumlah')),
			"ket" => $this->db->escape_str($this->input->post('keterangan')),
			"stat" => 1
		);
		$input = $this->model_app->input("stok_masuk_gudang", $arr);
		if ($input['status'] == 'ok') {
			$arr = [
				'status' => true,
				'title' => 'Input data',
				'msg'   => 'Data berhasil Input'
			];
		} else {
			$arr = [
				'status' => false,
				'title' => 'Input data',
				'msg'   => 'Data gagal Input'
			];
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($arr));
	}

	public function simpan_barang_kirim()
	{

		$idmaster = $this->db->escape_str($this->input->post('id'));
		$jumlah_kirim = $this->db->escape_str($this->input->post('jumlah_kirim'));
		$ket_kirim = $this->db->escape_str($this->input->post('ket_kirim'));
		$id_divisi = $this->db->escape_str($this->input->post('satker'));

		$stokmaster = $this->model_gudang->real_stok($idmaster);
		if ($jumlah_kirim > $stokmaster) {
			$data = array('status' => 500, 'title' => 'Alert !!!', 'msg' => 'Stok tidak mencukupi untuk melakukan pengiriman.<br> (Stok : ' . $stokmaster . ', dikirim : ' . $jumlah_kirim . ')');
			$this->output
				->set_status_header(200)
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
				->_display();
			exit;
		}
		$listdiv = $this->model_gudang->list_divisi();

		if (empty($ket_kirim)) {
			$ket_kirim = "Dikirim ke " . $listdiv[$id_divisi];
		}

		$arr = array(
			"id_barang" => $idmaster,
			"id_user" => $id_divisi,
			"create_date" => $this->db->escape_str($this->input->post('tanggal_kirim')),
			"jumlah" => $jumlah_kirim,
			"ket" => $ket_kirim,
			"stat" => 1
		);

		$input = $this->model_app->input("stok_keluar_gudang", $arr);
		if ($input['status'] == 'ok') {
			$arr = [
				'status' => true,
				'title' => 'Input data',
				'msg'   => 'Data berhasil Input'
			];
		} else {
			$arr = [
				'status' => false,
				'title' => 'Input data',
				'msg'   => 'Data gagal Input'
			];
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($arr));
	}

	public function save_barang()
	{
		cek_nput_post('GET');
		simpan_demo('Simpan');
		cek_crud_akses(9);

		$type       = xss_filter($this->input->post('type'));
		$id_satuan  = xss_filter($this->input->post('id_satuan'));
		$title      = xss_filter($this->input->post('title'));

		if ($type == 'add') {
			$_data = array(
				'id_satuan' => $id_satuan,
				'title' => $title,
				'create_date' => today(),
				'stat' => 1
			);
			$res = $this->model_gudang->insert_barang($_data);
			if ($res['status'] == true) {
				$data = array('status' => 200, 'msg' => 'Data berhasil disimpan');
			} else {
				$data = array('status' => 400);
			}
		}

		if ($type == 'edit') {
			$id   = xss_filter($this->input->post('id'), 'xss');
			$id   = decrypt_url($id);

			$_data = array(
				'id_satuan' => $id_satuan,
				'title' => $title,
				'create_date' => today()
			);

			$res = $this->model_gudang->update_barang($id, $_data);
			// dump($res);

			if ($res == true) {
				$data = array('status' => 200, 'msg' => 'Data berhasil disimpan');
			} else {
				$data = array('status' => 400);
			}
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	public function edit_barang()
	{

		$id = xss_filter($this->input->post('id'), 'xss');

		$id = decrypt_url($id);
		$row = $this->model_gudang->get_barang($id);

		$response = [
			'id' => encrypt_url($row->id),
			'title' => $row->title,
			'satuan' => $row->satuan,
			'id_satuan' => $row->id_satuan
		];

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
	}

	public function laporan()
	{
		$data['title'] = 'Laporan Stok Barang | ' . info()['title'];
		$data['judul'] = 'Laporan Stok Barang';
		$this->load->model("model_gudang");
		$data['list_cc'] = $this->model_gudang->list_cc();
		$data['listdiv'] = $this->model_gudang->listdiv("array");

		// $dtl = 0;
		$bulan    = $this->input->get('bulan');
		$dtl    = $this->input->get('dtl');
		$filter = $this->input->get('filter');
		$show   = $this->input->get('show');

		if (isset($bulan)) {
			$bulan = $bulan;
		}
		if (isset($dtl)) {
			$dtl = intval($dtl);
		}
		if (isset($filter)) {
			$filter = $filter;
		}

		$data['level'] = $this->level;
		$data['id_divisi'] = $this->iduser;
		$data['detail'] = $dtl;
		$data['bulan'] = $bulan;

		if (isset($show)) {
			$show = intval($show);
			if ($show == 1 and !empty($bulan)) {
				$data['query'] = $this->model_gudang->report_master($dtl, $bulan);
				$data['show'] = 1;
				$data['title'] .= " Stok CC Master";
			} else if ($show == 2) {
				$data['show'] = 2;
				$data['title'] .= " Stok CC Divisi";
				$data['query'] = $this->model_gudang->report_divisi($dtl, $filter, $bulan);

				if (strlen($filter) > 0) {
					$data['title'] .= " " . $data['listdiv'][$filter];
				}
			}
		}

		$data['date'] = date("Y-m-d");

		$this->template->load('main/themes', 'stok_gudang/laporan', $data);
	}
} //end CI_Controller																																	
