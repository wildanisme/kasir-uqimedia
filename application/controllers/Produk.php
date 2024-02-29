<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Produk extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		// cek_tabel();
		cek_session_login();

		$this->info = info();
		$this->back = $this->agent->referrer();
		$this->iduser = $this->session->idu;
		$this->perPage = 12;
		$this->perPageBahan = 10;
	}

	/**
	 * data
	 *
	 * @return void
	 */
	public function data()
	{
		cek_menu_akses();
		$data['title'] = 'Data Produk | ' . info()['title'];
		$data['judul'] = 'Data Produk';

		$conditions['where'] = array(
			'produk.kunci' => 0
		);
		$conditions['returnType'] = 'count';
		$totalRec = $this->model_data->getProduk($conditions);

		// Pagination configuration 
		$config['target']      = '#dataProduk';
		$config['base_url']    = base_url('produk/cariProduk');
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config['link_func']   = 'search_Produk';
		// Initialize pagination library 
		$this->ajax_pagination->initialize($config);

		// Get records 
		$conditions = array(
			'limit' => $this->perPage
		);
		$conditions['where'] = array(
			'produk.kunci' => 0
		);
		$data['jenis'] = $this->model_app->view_where('jenis_cetakan', ['pub' => 'Y', 'kunci' => 0])->result();
		$data['result'] = $this->model_data->getProduk($conditions);
		$this->template->load('main/themes', 'produk/produk', $data);
	}

	/**
	 * cari_invoice_page
	 *
	 * @return void
	 */
	public function cari_invoice_page()
	{
		cek_nput_post('GET');
		$page = $this->input->post('page');
		if (!$page) {
			$offset = 0;
		} else {
			$offset = $page;
		}

		$limit = 10;
		$keywords = $this->input->post('keywords');

		if (!empty($keywords)) {
			$conditions['search']['keywords'] = $keywords;
		}

		// Get record count 
		$conditions['returnType'] = 'count';
		$totalRec = $this->model_data->getCari($conditions);

		// Pagination configuration 
		$config['target']      = '#hasil_cari';
		$config['base_url']    = base_url('produk/cari_invoice');
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $limit;
		$config['link_func']   = 'cariFilterIn';

		// Initialize pagination library 
		$this->ajax_pagination->initialize($config);

		// Get records 
		$conditions['start'] = $offset;
		$conditions['limit'] = $limit;
		unset($conditions['returnType']);
		$data['posts'] = $this->model_data->getCari($conditions);
		$data['pilihan'] = $this->model_app->view('tb_users');
		// Load the data list view 
		$this->load->view('produk/cari_invoice', $data, false);
	}

	/**
	 * modal_popup
	 *
	 * @return void
	 */
	public function modal_popup()
	{
		$data['title'] = 'Data Produk | ' . info()['title'];
		$this->load->view('produk/modal_popup');
	}

	/**
	 * cari_harga
	 *
	 * @return void
	 */
	public function cari_harga()
	{
		cek_nput_post('POST');

		$id_bahan  = xss_filter($this->input->get('id'), 'xss');
		$jumlah    = xss_filter($this->input->get('jml'), 'xss');
		$totukuran = xss_filter($this->input->get('totukuran'), 'xss');
		$id_member = xss_filter($this->input->get('id_member'), 'xss');

		$cek_status = $this->model_app->pilih_where('status_stok,type_harga,id_satuan,status', 'bahan', ['id' => $id_bahan])->row();
		$cek_satuan = $this->model_app->pilih_where('satuan', 'satuan', ['id' => $cek_status->id_satuan])->row();
		$type_harga = $cek_status->type_harga;

		if ($cek_status->status_stok == 'Y') {
			$this->cek_stok($id_bahan, $jumlah);
		}

		$status = $cek_status->status;

		if ($status > 0) {
			$jml = $totukuran * $jumlah;
		} else {
			$jml = $jumlah;
		}

		if ($type_harga == 1) {
			$sql1 = $this->db->query("SELECT 
				`satuan`.`id` AS idsatuan,
				`satuan`.`satuan`,
				`satu_harga`.`harga_jual`,
				`bahan`.`title`
				FROM
				`bahan`
				INNER JOIN `satu_harga` ON (`bahan`.`id` = `satu_harga`.`id_bahan`)
				INNER JOIN `satuan` ON (`satu_harga`.`id_satuan` = `satuan`.`id`)
				WHERE
				`bahan`.`id` = $id_bahan");
			$harga_jual = $sql1->row()->harga_jual;
			$satuan = $sql1->row()->idsatuan;
			$data = ['status' => true, 'harga' => $harga_jual, 'satuan' => $satuan, 'type_harga' => $type_harga];
		} elseif ($type_harga == 2) {

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
				`harga_satuan`.`id_bahan` = $id_bahan");
			$harga_jual = $sql2->row()->harga_jual;
			$satuan = $sql2->row()->idsatuan;
			$data = ['status' => true, 'harga' => $harga_jual, 'satuan' => $satuan, 'type_harga' => $type_harga];
		} elseif ($type_harga == 3) {

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
				$sql = $this->db->query("select id,id_satuan,harga_modal from bahan where id=$id_bahan");
				$harga_jual = $sql->row()->harga_modal;
				$satuan = $sql->row()->id_satuan;
			}
			$data = ['status' => true, 'harga' => $harga_jual, 'satuan' => $satuan, 'type_harga' => $type_harga];
		} elseif ($type_harga == 4) {
			$sql = $this->db->query("select id_satuan,harga_jual from range_harga where id_bahan=$id_bahan AND $jml between jumlah_minimal and jumlah_maksimal");
			if ($sql->num_rows() > 0) {

				$harga_jual = $sql->row()->harga_jual;
				$satuan = $sql->row()->id_satuan;
			} else {
				$sql = $this->db->query("select id,id_satuan,harga_modal from bahan where id=$id_bahan");
				$harga_jual = $sql->row()->harga_modal;
				$satuan = $sql->row()->id_satuan;
			}
			$data = ['status' => true, 'harga' => $harga_jual, 'satuan' => $satuan, 'type_harga' => $type_harga];

			//cari type harga 5
		} elseif ($type_harga == 5) {
			$sql4 = $this->db->query("select id_satuan,harga_jual from harga_range_member where id_bahan=$id_bahan AND id_member='$id_member' AND $jml between jumlah_minimal and jumlah_maksimal");
			if ($sql4->num_rows() > 0) {
				$harga_jual = $sql4->row()->harga_jual;
				$satuan = $sql4->row()->id_satuan;
				$msg = 1;
			} else {
				$sql = $this->db->query("select id,id_satuan,harga_modal from bahan where id=$id_bahan");
				$harga_jual = $sql->row()->harga_modal;
				$satuan = $sql->row()->id_satuan;
				$msg = 2;
			}
			$data = ['status' => true, 'harga' => $harga_jual, 'satuan' => $satuan, 'type_harga' => $type_harga, 'msg' => $msg];
		} else {
			$sql = $this->db->query("select id,id_satuan,harga_modal from bahan where id=$id_bahan");
			$harga_jual = $sql->row()->harga_modal;
			$satuan = $sql->row()->id_satuan;
			$data = ['status' => true, 'harga' => $harga_jual, 'satuan' => $satuan, 'type_harga' => $type_harga, 'msg' => 3];
		}

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	/**
	 * cek_stok
	 *
	 * @param  mixed $id
	 * @param  mixed $jumlah
	 * @return void
	 */
	private function cek_stok($id, $jumlah)
	{

		$jml_masuk = stok_masuk($id);
		$jml_keluar = stok_keluar($id);
		$total = $jml_masuk - $jml_keluar;
		if ($jumlah > $total) {
			$data = ['status' => false, 'msg' => 'sisa stok ' . $total, 'stok' => $total];
			$this->output
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
				->_display();
			exit;
		}
	}

	/**
	 * tambah_produk
	 *
	 * @return void
	 */
	public function tambah_produk()
	{
		cek_nput_post('GET');
		$tipe = xss_filter($this->input->post('tipe'), 'xss');
		$where = array('kunci' => 0);
		$data['tipe'] = $tipe;
		$data['jenis'] = $this->model_app->view_where('jenis_cetakan', $where)->result_array();
		$this->load->view('produk/add_produk', $data);
	}

	/**
	 * edit_produk
	 *
	 * @return void
	 */
	/**
	 * edit_produk
	 *
	 * @return void
	 */
	public function edit_produk()
	{
		cek_nput_post('GET');

		$noid = xss_filter($this->input->post('id'), 'xss');
		$tipe = xss_filter($this->input->post('tipe'), 'xss');
		$where = array('id' => $noid);
		$record = $this->model_app->edit('produk', $where)->row_array();
		$data['back'] = $this->back;
		$data['tipe'] = $tipe;
		$data['record'] = $record;
		$data['jenis'] = $this->model_app->view_where('jenis_cetakan', array('kunci' => 0))->result_array();
		$this->load->view('produk/edit_produk', $data);
	}

	/**
	 * number
	 *
	 * @return void
	 */
	private function number()
	{
		return random_string('numeric', 13);
	}

	/**
	 * save_produk
	 *
	 * @return void
	 */
	public function save_produk()
	{
		cek_nput_post('GET');
		simpan_demo('Simpan');

		$id         = xss_filter($this->input->post('id'), 'xss');
		$type       = xss_filter($this->input->post('type'), 'xss');
		$bahan      = $this->input->post('bahan', true);
		$jenis      = xss_filter($this->input->post('jenis'), 'xss');
		$ukuran     = xss_filter($this->input->post('ukuran'), 'xss');
		$jumlah     = xss_filter($this->input->post('jumlah'), 'xss');
		$lock_harga = xss_filter($this->input->post('lock_harga'), 'xss');
		$barcode    = xss_filter($this->input->post('barcode'), 'xss');

		if (!empty($bahan)) {
			$bahan = implode(',', array_unique($bahan));
		} else {
			$bahan = '';
		}
		if (empty($barcode)) {
			$barcode = $this->number();
		}

		if ($id > 0 and $type == 'edit') {
			$this->form_validation->set_rules(array(
				array(
					'field' => 'barcode',
					'label' => 'Barcode',
					'rules' => 'required|trim|numeric|min_length[12]|max_length[12]',
					'errors' => array(
						'required' => '%s. Harus di isi',
						'numeric' => '%s. Harus angka',
						'min_length' => '%s minimal 12 digit.',
						'max_length' => '%s maksimal 12 digit.'
					)
				),

				array(
					'field' => 'nama',
					'label' => 'Nama Produk',
					'rules' => 'required|trim|min_length[3]|max_length[100]',
					'errors' => array(
						'required' => '%s Harus diisi.',
						'min_length' => '%s minimal 3 digit.',
						'max_length' => '%s minimal 100 digit.'
					)
				),
			));

			if ($this->form_validation->run() == FALSE) {
				$response['status'] = 400;
				$response['msg']['content'] = validation_errors();
			} else {

				$data = array(
					'title' => xss_filter($this->input->post('nama'), 'xss'),
					'id_jenis' => $jenis,
					// 'id_bahan' => $bahan,
					'ukuran' => $ukuran,
					'jumlah' => $jumlah,
					'barcode' => $barcode,
					'lock_harga' => $lock_harga
				);
				$res = $this->model_app->update('produk', $data, array('id' => $id));
				if ($res['status'] == 'ok') {
					$response = array('status' => 200, 'msg' => 'Data berhasil disimpan');
				} else {
					$response = array('status' => 400, 'msg' => 'Data gagal disimpan');
				}
			}
		} else {
			$data = array(
				'title' => xss_filter($this->input->post('nama'), 'xss'),
				'id_jenis' => $jenis,
				// 'id_bahan' => $bahan,
				'ukuran' => $ukuran,
				'jumlah' => $jumlah,
				'barcode' => $barcode,
				'lock_harga' => $lock_harga
			);
			$res = $this->model_app->input('produk', $data);
			if ($res['status'] == 'ok') {
				$response = array('status' => 200, 'msg' => 'Data berhasil disimpan');
			} else {
				$response = array('status' => 400, 'msg' => 'Data gagal disimpan');
			}
		}
		$this->output
			->set_status_header(200)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($response, JSON_HEX_APOS | JSON_HEX_QUOT))
			->_display();
		exit();
	}

	/**
	 * hapus_produk
	 *
	 * @return void
	 */
	public function hapus_produk()
	{
		cek_nput_post('GET');
		simpan_demo('Hapus');
		cek_crud_akses(10);

		$id   = xss_filter($this->input->post('id'), 'xss');
		$type = xss_filter($this->input->post('type'), 'xss');

		if ($id > 0 and $type == 'hapus') {
			$cek = $this->model_app->view_where('invoice_detail', array('id_produk' => $id));
			if ($cek->num_rows() > 0) {
				$data = array('status' => 400, 'msg' => 'Data tidak dapat dihapus');
			} else {
				$res = $this->model_app->hapus('produk', array('id' => $id));
				if ($res['status'] == 'ok') {
					$data = array('status' => 200, 'msg' => 'Data berhasil dihapus');
				} else {
					$data = array('status' => 400, 'msg' => 'Data gagal dihapus');
				}
			}
		} else {
			$data = array('status' => 400, 'msg' => 'Data tida ditemukan');
		}

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}


	/**
	 * edit_satuan
	 *
	 * @return void
	 */
	public function edit_satuan()
	{
		cek_nput_post('GET');
		$id = xss_filter($this->input->post('id'), 'xss');
		if ($id > 0) {
			$where = array('id' => $id);
			$row = $this->model_app->edit('satuan', $where)->row_array();

			$data = array(
				'id'    => $id,
				'judul' => $row['satuan'],
				'nama'  => $row['nama_satuan'],
				'jumlah' => $row['jumlah'],
				'aktif' => $row['pub']
			);
		} else {
			$data = array('id' => 0, 'judul' => "", 'nama' => '', 'jumlah' => 0, "aktif" => "");
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	/**
	 * save_satuan
	 *
	 * @return void
	 */
	public function save_satuan()
	{
		cek_nput_post('GET');
		simpan_demo('Simpan');
		cek_crud_akses(7);

		$id     = xss_filter($this->input->post('id'), 'xss');
		$type   = xss_filter($this->input->post('type'), 'xss');
		$judul  = ($this->db->escape_str($this->input->post('judul')));
		$nama   = change_case($this->db->escape_str($this->input->post('nama')));
		$jumlah = change_case($this->db->escape_str($this->input->post('jumlah')));
		$aktif  = xss_filter($this->input->post('aktif'), 'xss');

		$_data = array('satuan' => $judul, 'nama_satuan' => $nama, 'jumlah' => $jumlah, 'pub' => $aktif);
		if ($id == 0 and $type == 'add') {
			///data baru
			$res = $this->model_app->input('satuan', $_data);
			if ($res['status'] == 'ok') {
				$data = array('status' => 200, 'msg' => 'Data berhasil disimpan');
			} else {
				$data = array('status' => 400);
			}
		} elseif ($type == 'edit') {
			///data update
			$res =  $this->model_app->update('satuan', $_data, array('id' => $id));
			if ($res['status'] == 'ok') {
				$data = array('status' => 200, 'msg' => 'Data berhasil update');
			} else {
				$data = array('status' => 400);
			}
		} else {
			$data = array('status' => 400, 'msg' => 'Data tidak ditemukan');
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	/**
	 * hapus_satuan
	 *
	 * @return void
	 */
	public function hapus_satuan()
	{
		cek_nput_post('GET');
		simpan_demo('Hapus');
		cek_crud_akses(10);

		$id = xss_filter($this->input->post('id'), 'xss');

		$res = $this->model_app->hapus('satuan', array('id' => $id));
		if ($res['status'] == 'ok') {
			$data = array('status' => 200, 'msg' => 'Data berhasil dihapus');
		} else {
			$data = array('status' => 400, 'msg' => 'Data gagal dihapus');
		}

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	/**
	 * cari_bahan
	 *
	 * @return void
	 */
	public function cari_bahan()
	{
		cek_nput_post('GET');
		cek_crud_akses(8);

		$name   = xss_filter($this->input->post('name'), 'xss');
		$result = $this->model_app->view_like('bahan', array('title' => $name));

		$data = array();
		foreach ($result->result_array() as $row) {
			$data[] = array("id" => $row['id'], "name" => $row['title']);
		}

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	/**
	 * bahan
	 *
	 * @return void
	 */
	public function bahan()
	{
		cek_menu_akses();
		cek_crud_akses(8);
		$data['title'] = 'Data Bahan | ' . info()['title'];
		$data['judul'] = 'Data Bahan';

		$data['kategori'] = $this->model_app->view_where('jenis_cetakan', ['kunci' => 0, 'pub' => 'Y'])->result();
		$data['satuan'] = $this->model_app->view_where('satuan', ['pub' => 0])->result();

		$this->template->load('main/themes', 'produk/bahan', $data);
	}

	/**
	 * edit_bahan
	 *
	 * @return void
	 */
	public function edit_bahan()
	{
		cek_nput_post('GET');
		cek_crud_akses(8);
		$id = xss_filter($this->input->post('id'), 'xss');
		if ($id > 0) {
			$masuk = $this->model_app->sum_stok('stok_masuk', ['id_bahan' => $id])->row();
			$keluar = $this->model_app->sum_stok('stok_keluar', ['id_bahan' => $id])->row();
			$total = $masuk->total - $keluar->total;
			$select = [
				'`bahan`.`title`',
				'`bahan`.`id`',
				'`bahan`.`id_jenis`',
				'`bahan`.`harga_modal`',
				'`bahan`.`harga`',
				'`bahan`.`id_satuan`',
				'`bahan`.`status`',
				'`bahan`.`status_stok`',
				'`bahan`.`barcode`',
				'`bahan`.`kunci`',
				'`satuan`.`satuan`',
				'`bahan`.`pub`'
			];
			$where = array('bahan.id' => $id);

			$row = $this->model_app->join_where($select, 'satuan', 'bahan', 'id', 'id_satuan', $where)->row_array();
			$data = array(
				'id' => $id,
				'judul' => $row['title'],
				'kategori' => $row['id_jenis'],
				'modal' => $row['harga_modal'],
				'harga_pokok' => $row['harga'],
				'id_satuan' => $row['id_satuan'],
				'satuan' => $row['satuan'],
				'ukuran' => $row['status'],
				'stok' => $row['status_stok'],
				'jenis' => $row['kunci'],
				'barcode' => $row['barcode'],
				'total' => $total,
				'aktif' => $row['pub']
			);
		} else {
			$data = array('id' => 0, 'judul' => "", 'harga' => '', "aktif" => "", 'msg' => 'error');
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	/**
	 * atur_harga
	 *
	 * @return void
	 */
	public function atur_harga()
	{
		cek_nput_post('GET');
		cek_crud_akses(8);
		$id = xss_filter($this->input->post('id'), 'xss');
		if ($id > 0) {

			$select = [
				'`bahan`.`title`',
				'`bahan`.`id`',
				'`bahan`.`id_jenis`',
				'`bahan`.`harga_modal`',
				'`bahan`.`id_satuan`',
				'`bahan`.`status`',
				'`bahan`.`status_stok`',
				'`bahan`.`type_harga`',
				'`satuan`.`satuan`',
				'`bahan`.`pub`'
			];
			$where = array('bahan.id' => $id);

			$row = $this->model_app->join_where($select, 'satuan', 'bahan', 'id', 'id_satuan', $where)->row_array();
			$data = array(
				'id' => $id,
				'judul' => $row['title'],
				'type_harga' => $row['type_harga'],
				'id_satuan' => $row['id_satuan'],
				'modal' => $row['harga_modal']
			);
		} else {
			$data = array('id' => 0, 'judul' => "", 'harga' => 0, "aktif" => "N", 'msg' => 'error');
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	/**
	 * save_tab
	 *
	 * @return void
	 */
	public function save_tab()
	{
		cek_nput_post('GET');

		$id  = xss_filter($this->input->post('id'), 'xss');
		$tab = xss_filter($this->input->post('idtab'), 'xss');

		$res =  $this->model_app->update('bahan', ['type_harga' => $tab], ['id' => $id]);
		if ($res['status'] == 'ok') {
			$cek = $this->model_app->view_where('satu_harga', ['id_bahan' => $id]);
			if ($cek->num_rows() > 0) {
				$data = array('status' => 200, 'id' => $cek->row()->id_satuan, 'msg' => 'Data berhasil update');
			} else {
				$data = array('status' => 200, 'id' => 0, 'msg' => 'Data berhasil update');
			}
		} else {
			$data = array('status' => 400, 'id' => 0);
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	/**
	 * save_bahan
	 *
	 * @return void
	 */
	public function save_bahan()
	{
		cek_nput_post('GET');
		simpan_demo('Simpan');
		cek_crud_akses(9);

		$id          = xss_filter($this->input->post('id'), 'xss');
		$type        = xss_filter($this->input->post('type'), 'xss');
		$judul       = xss_filter($this->input->post('judul'), 'xss');
		$kategori    = xss_filter($this->input->post('kategori'), 'xss');
		$modal       = xss_filter($this->input->post('modal'), 'xss');
		$harga_pokok = xss_filter($this->input->post('harga_pokok'), 'xss');
		$satuan      = xss_filter($this->input->post('satuan'), 'xss');
		$ukuran      = xss_filter($this->input->post('ukuran'), 'xss');
		$stok        = xss_filter($this->input->post('stok'), 'xss');
		$kunci       = xss_filter($this->input->post('jenis'), 'xss');
		$barcode       = xss_filter($this->input->post('barcode'), 'xss');
		$aktif       = xss_filter($this->input->post('aktif'), 'xss');

		$_data = array(
			'id_jenis' => $kategori,
			'title' => $judul,
			'harga_modal' => $modal,
			'harga' => $harga_pokok,
			'id_satuan' => $satuan,
			'status' => $ukuran,
			'status_stok' => $stok,
			'kunci' => $kunci,
			'barcode' => $barcode,
			'pub' => $aktif
		);

		if ($id == 0 and $type == 'add') {
			///data baru
			$res = $this->model_app->input('bahan', $_data);
			if ($res['status'] == 'ok') {
				$array = [
					'id_satuan' => $satuan,
					'id_bahan' => $res['id'],
					'harga_jual' => $modal
				];
				$this->model_app->input('harga_satuan', $array);
				$this->model_app->update('bahan', ['type_harga' => 2], ['id' => $res['id']]);
				$data = array('status' => 200, 'msg' => 'Data berhasil disimpan');
			} else {
				$data = array('status' => 400);
			}
		}
		if ($id > 0 and $type == 'edit') {
			///data update
			$res =  $this->model_app->update('bahan', $_data, array('id' => $id));
			if ($res['status'] == 'ok') {
				$data = array('status' => 200, 'msg' => 'Data berhasil update');
			} else {
				$data = array('status' => 400);
			}
		}

		if ($id > 0 and $type == 'featured') {

			$featured = xss_filter($this->input->post('featured'), 'xss');
			$kategori = xss_filter($this->input->post('kategori'), 'xss');
			$array = array(
				'featured' => $featured
			);

			$res = $this->model_app->update('bahan', $array, array('id_jenis' => $kategori, 'id' => $id));

			if ($res['status'] == 'ok') {
				$this->model_app->update('bahan', ['featured' => 0], array('id_jenis' => $kategori, 'id !=' => $id));
				$data = array('status' => 200, 'msg' => 'Data berhasil update');
			} else {
				$data = array('status' => 400);
			}
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	/**
	 * hapus_bahan
	 *
	 * @return void
	 */
	public function hapus_bahan()
	{
		cek_nput_post('GET');
		simpan_demo('Hapus');
		cek_crud_akses(10);

		$id   = xss_filter($this->input->post('id'), 'xss');
		$type = xss_filter($this->input->post('type'), 'xss');

		if ($id > 0 and $type == 'hapus') {
			$cek = $this->model_app->view_where('invoice_detail', array('id_bahan' => $id));
			if ($cek->num_rows() == 0) {
				$search = $this->model_app->view_where('invoice_detail', array('id_bahan' => $id));
				if ($search->num_rows() > 0) {
					$data = array('status' => 400, 'msg' => 'Bahan tidak bisa dihapus');
				} else {
					$res = $this->model_app->hapus('bahan', array('id' => $id));
					if ($res['status'] == 'ok') {
						$this->hapus_harga($id);
						$data = array('status' => 200, 'msg' => 'Data berhasil dihapus');
					} else {
						$data = array('status' => 400, 'msg' => 'Data gagal dihapus');
					}
				}
			} else {
				$data = array('status' => 400, 'msg' => 'Data tidak bisa dihapus');
			}
		} else {
			$data = array('status' => 400, 'msg' => 'Bad Request');
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	/**
	 * hapus_harga
	 *
	 * @param  mixed $id
	 * @return void
	 */
	private function hapus_harga($id)
	{
		$satu_harga = $this->model_app->view_where('satu_harga', array('id_bahan' => $id));
		if ($satu_harga->num_rows() > 0) {
			$this->model_app->hapus('satu_harga', array('id_bahan' => $id));
		}

		$harga_satuan = $this->model_app->view_where('harga_satuan', array('id_bahan' => $id));
		if ($harga_satuan->num_rows() > 0) {
			$this->model_app->hapus('harga_satuan', array('id_bahan' => $id));
		}

		$harga_member = $this->model_app->view_where('harga_member', array('id_bahan' => $id));
		if ($harga_member->num_rows() > 0) {
			$this->model_app->hapus('harga_member', array('id_bahan' => $id));
		}
		$range_harga = $this->model_app->view_where('range_harga', array('id_bahan' => $id));
		if ($range_harga->num_rows() > 0) {
			$this->model_app->hapus('range_harga', array('id_bahan' => $id));
		}

		$harga_range_member = $this->model_app->view_where('harga_range_member', array('id_bahan' => $id));
		if ($harga_range_member->num_rows() > 0) {
			$this->model_app->hapus('harga_range_member', array('id_bahan' => $id));
		}
	}

	/**
	 * jenis
	 *
	 * @return void
	 */
	public function jenis()
	{
		cek_menu_akses();
		$data['title'] = 'Jenis Produk | ' . info()['title'];
		$data['judul'] = 'Jenis Produk';

		$conditions['where'] = array(
			'jenis_cetakan.kunci' => 0
		);

		$conditions['returnType'] = 'count';
		$totalRec = $this->model_data->getJenis($conditions);

		// Pagination configuration 
		$config['target']      = '#dataJenis';
		$config['base_url']    = base_url('produk/cariJenis');
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config['link_func']   = 'search_Jenis';
		// Initialize pagination library 
		$this->ajax_pagination->initialize($config);

		// Get records 
		$conditions = array(
			'limit' => $this->perPage
		);

		$conditions['where'] = array(
			'jenis_cetakan.kunci' => 0
		);

		$data['akun'] = $this->model_app->views('akun')->result();
		$data['result'] = $this->model_data->getJenis($conditions);
		$this->template->load('main/themes', 'produk/jenis', $data);
	}


	/**
	 * satuan
	 *
	 * @return void
	 */
	public function satuan()
	{
		cek_menu_akses();
		cek_crud_akses(8);
		$data['title'] = 'Satuan Produk | ' . info()['title'];

		$conditions['returnType'] = 'count';
		$totalRec = $this->model_data->getSatuan($conditions);

		// Pagination configuration 
		$config['target']      = '#dataSatuan';
		$config['base_url']    = base_url('produk/cariSatuan');
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config['link_func']   = 'search_Satuan';
		// Initialize pagination library 
		$this->ajax_pagination->initialize($config);

		// Get records 
		$conditions = array(
			'limit' => $this->perPage
		);

		$data['result'] = $this->model_data->getSatuan($conditions);
		$this->template->load('main/themes', 'produk/satuan', $data);
	}

	/**
	 * edit_jenis
	 *
	 * @return void
	 */
	public function edit_jenis()
	{
		cek_nput_post('GET');
		$id = xss_filter($this->input->post('id'), 'xss');
		if ($id > 0) {
			$where = array('id_jenis' => $id);
			$row = $this->model_app->edit('jenis_cetakan', $where)->row_array();
			$data = array('id' => $id, 'judul' => $row['jenis_cetakan'], "ukuran" => $row['status'], 'aktif' => $row['pub']);
		} else {
			$data = array('id' => 0, 'judul' => "", "grup" => "", "ukuran" => "", "aktif" => "");
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	/**
	 * save_jenis
	 *
	 * @return void
	 */
	public function save_jenis()
	{
		cek_nput_post('GET');
		simpan_demo('Simpan');

		$id    = xss_filter($this->input->post('id'), 'xss');
		$type  = xss_filter($this->input->post('type'), 'xss');
		$judul = xss_filter($this->db->escape_str($this->input->post('judul')), 'xss');
		$aktif = xss_filter($this->input->post('aktif'), 'xss');

		$_data = array('jenis_cetakan' => $judul, 'id_akun' => 400, 'pub' => $aktif);
		if ($id == 0 and $type == 'add') {
			///data baru
			$res = $this->model_app->input('jenis_cetakan', $_data);
			if ($res['status'] == 'ok') {
				$data = array('status' => 200, 'msg' => 'Data berhasil disimpan');
			} else {
				$data = array('status' => 400);
			}
		} else {
			///data update
			$res =  $this->model_app->update('jenis_cetakan', $_data, array('id_jenis' => $id));
			if ($res['status'] == 'ok') {
				$data = array('status' => 200, 'msg' => 'Data berhasil update');
			} else {
				$data = array('status' => 400);
			}
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	/**
	 * hapus_jenis
	 *
	 * @return void
	 */
	public function hapus_jenis()
	{
		cek_nput_post('GET');
		simpan_demo('Hapus');
		$id   = xss_filter($this->input->post('id'), 'xss');
		$type = xss_filter($this->input->post('type'), 'xss');

		if ($id > 0 and $type == 'hapus') {
			if ($id == 9) {
				$data = array('status' => 400, 'msg' => 'Data desain jangan dihapus');
				echo json_encode($data);
				exit;
			}
			$cek = $this->model_app->view_where('invoice_detail', array('id_bahan' => $id));
			if ($cek->num_rows() == 0) {
				$cek2 = $this->model_app->view_where('pengeluaran_detail', array('id_biaya' => $id));
				if ($cek2->num_rows() == 0) {
					$search = $this->model_app->view_where('invoice_detail', array('jenis_cetakan' => $id));
					if ($search->num_rows() > 0) {
						$data = array('status' => 400, 'msg' => 'Jenis tidak bisa dihapus');
					} else {
						$where = array('id_jenis' => $id);
						$res = $this->model_app->hapus('jenis_cetakan', $where);
						if ($res['status'] == 'ok') {
							$data = array('status' => 200, 'msg' => 'Data berhasil dihapus');
						} else {
							$data = array('status' => 400, 'msg' => 'Data gagal dihapus');
						}
					}
				} else {
					$data = array('status' => 400, 'msg' => 'Data tidak bisa dihapus');
				}
			} else {
				$data = array('status' => 400, 'msg' => 'Data tidak bisa dihapus');
			}
		} else {
			$data = array('status' => 400, 'msg' => 'Bad request');
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	/**
	 * print_cek
	 *
	 * @return void
	 */
	public function print_cek()
	{
		cek_nput_post('GET');
		$id = xss_filter($this->input->post('id'), 'xss');
		$data = array('status' => 200, 'id' => $id, 'encrypt_url' => encrypt_url($id));
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	/**
	 * print_invoice
	 *
	 * @param  mixed $noid
	 * @return void
	 */
	public function print_invoice($noid = null)
	{
		$noid = decrypt_url($noid);
		$id = array('id_invoice' => $noid);
		$pub = array('slug' => 'in'); //printer aktif
		$cek_printer = $this->model_app->view_where('printer', $pub);
		$rowc = $cek_printer->row_array();

		$search = $this->model_app->view_where('invoice', $id);

		//icon
		$data['waicon'] 	= ['color' => FCPATH . 'assets/img/wa_icon.png', 'bw' => FCPATH . 'assets/img/wa_icon_bw.png'];
		$data['mail'] 		= ['color' => FCPATH . 'assets/img/gmail_icon.png', 'bw' => FCPATH . 'assets/img/gmail_icon_bw.png'];
		$data['fbicon'] 	= ['color' => FCPATH . 'assets/img/fb_icon.png', 'bw' => FCPATH . 'assets/img/fb_icon_bw.png'];
		$data['igicon'] 	= ['color' => FCPATH . 'assets/img/ig_icon.png', 'bw' => FCPATH . 'assets/img/ig_icon_bw.png'];

		$data['logo_lunas'] = FCPATH . 'uploads/' . info()['logo'];
		$data['logo_blunas'] = FCPATH . 'uploads/' . info()['logo_bw'];
		$data['lunas'] = FCPATH . 'uploads/' . info()['stamp_l'];
		$data['blunas'] = FCPATH . 'uploads/' . info()['stamp_b'];
		$data['favicon'] = FCPATH . 'uploads/' . info()['favicon'];
		$data['qris'] = info()['kode_qris'];
		$data['kode_qris'] = FCPATH . 'uploads/qrcode/qris.png';

		$data['html'] = 'N';

		if ($search->num_rows() > 0) {
			$this->session->unset_userdata('cart');
			$row = $search->row();
			$jml = $row->cetak + 1;
			$this->model_app->update('tb_users', array("last_invoice" => 0), array('id_user' => $this->session->idu));
			if ($row->status != 'batal') {
				$this->model_app->update('invoice', array('cetak' => $jml, 'status' => 'simpan', 'pos' => 'Y', 'oto' => 6), array('id_invoice' => $noid));
			}
			//cek sisa
			$_total = 'ROUND(SUM((`invoice_detail`.`jumlah` * harga) - (`invoice_detail`.`jumlah` * harga) * (`invoice_detail`.`diskon`/100))) AS sisa';
			$cari_total = $this->model_app->cek_total('invoice_detail', $_total, array('id_invoice' => $noid));
			$data['sisanya'] = $cari_total->sisa;
			//
			$data['cetak'] = $row;
			$data['info'] = info();
			$konsumen = $this->model_app->view_where('konsumen', array('id' => $row->id_konsumen))->row_array();

			if ($konsumen['max_utang'] > 0 and $jml <= 1) {
				$max_utang = $konsumen['max_utang'] - 1;
				$this->model_app->update('konsumen', array('max_utang' => $max_utang), array('id' => $row->id_konsumen));
			}

			$data['konsumen']    = $konsumen;
			$data['marketing']   = $this->model_app->view_where('tb_users', array('id_user' => $row->id_marketing))->row_array();
			$data['detail']      = $this->model_app->produk_cart(array('invoice_detail.id_invoice' => $noid));
			$data['total']       = $this->model_app->total_bayar(array('bayar_invoice_detail.id_invoice' => $noid))->row();
			$select              = 'pajak,potongan_harga,cashback, total_bayar AS total, jumlah_bayar, kembalian';
			$where               = array('id_invoice' => $noid);
			$tdetail             = $this->model_app->cek_total('invoice', $select, $where);
			$data['tdetail']     = $tdetail->total;
			$data['pajak']       = $tdetail->pajak;
			$data['jumlah_bayar'] = $tdetail->jumlah_bayar;
			$data['potongan_harga'] = $tdetail->potongan_harga;
			$data['cashback']	 = $tdetail->cashback;
			$data['kembalian']	 = $tdetail->kembalian;
			$_diskon             = 'SUM(diskon) AS `disc`';
			$cdiskon             = $this->model_app->cek_total('invoice_detail', $_diskon, $where);
			$data['cdiskon']     = $cdiskon->disc;
			$_select             = 'COUNT(id) AS `jml`';
			$cdetail             = $this->model_app->cek_total('bayar_invoice_detail', $_select, $where);
			$data['cdetail']     = $cdetail->jml;
			//bayar detail
			$data['bdetail']     = $this->model_app->view_where('bayar_invoice_detail', $id)->result_array();
			///
			$data['cara']        = $this->model_app->cara_bayar(array('`jenis_bayar`.`publish`' => 'Y', '`bayar_invoice_detail`.`id_invoice`' => $noid));
			$data['bank']        = $this->model_app->view_where('rekening_bank', ['footer_invoice' => 1, 'publish' => 'Y'])->result();

			$this->load->library('pdf');
			$this->pdf->setPaper($rowc['ukuran_kertas'], $rowc['posisi']);
			$this->pdf->filename = "invoice_" . $noid . "_" . $row->tgl_trx;
			$data['show_footer']  = $rowc['show_footer'];
			if ($rowc['slug'] == 'dotmatrix' and $rowc['pub'] == 1) {
				$data['font_size']  = $rowc['ukuran_font'];
				$data['font_wight'] = 'bold';
				$this->pdf->load_view('produk/print_invoice_dotmatrix', $data);
			} else {
				$data['font_size'] = $rowc['ukuran_font'];
				$data['font_wight'] = 'normal';
				$this->pdf->load_view('produk/print_invoice', $data);
			}
			// $this->load->view('produk/print_invoice',$data);
		} else {
			$data['cetak']       = 'error';
			$this->load->view('errors/404', $data);
		}
	}

	/**
	 * print_invoice_html
	 *
	 * @param  mixed $noid
	 * @return void
	 */
	public function print_invoice_html($noid = null)
	{
		$noid = decrypt_url($noid);
		$id = array('id_invoice' => $noid);
		$pub = array('pub' => 1); //printer aktif
		$search = $this->model_app->view_where('invoice', $id);

		$cek_printer = $this->model_app->view_where('printer', $pub);
		if ($cek_printer->num_rows() > 0) {
			$rowc = $cek_printer->row_array();
			$data['show_footer']  = $rowc['show_footer'];
			//print thermal
			if ($rowc['slug'] == 'th' and $rowc['pub'] == 1) {

				if ($search->num_rows() > 0) {

					$this->session->unset_userdata('cart');
					$row = $search->row_array();
					$jml = $row['cetak'] + 1;
					$this->model_app->update(
						"tb_users",
						["last_invoice" => 0],
						["id_user" => $this->iduser]
					);

					if ($row['status'] != 'batal') {
						$this->model_app->update('invoice', array('cetak' => $jml, 'status' => 'simpan', 'pos' => 'Y', 'oto' => 6), array('id_invoice' => $noid));
					}

					//marketing 
					$marketing = $this->model_app->view_where('tb_users', array('id_user' => $row['id_marketing']))->row_array();
					//bayar detail
					$detail = $this->model_app->produk_cart(array('invoice_detail.id_invoice' => $noid));
					//total bayar
					$total = $this->model_app->total_bayar(array('bayar_invoice_detail.id_invoice' => $noid))->row();
					$bdetail =  $this->model_app->view_where('bayar_invoice_detail', $id)->result_array();

					//load library
					$this->load->library('escpos');
					// membuat connector printer ke shared printer bernama "printer_a" (yang telah disetting sebelumnya)
					$connector = new Escpos\PrintConnectors\WindowsPrintConnector($rowc['shared_name']);

					// membuat objek $printer agar dapat di lakukan fungsinya
					$printer = new Escpos\Printer($connector);
					// Get status
					$printer->initialize();
					$printer->selectPrintMode(Escpos\Printer::MODE_DOUBLE_HEIGHT); // Setting teks menjadi lebih besar
					$printer->setJustification(Escpos\Printer::JUSTIFY_CENTER); // Setting teks menjadi rata tengah
					$printer->text($this->info['title'] . "\n");

					$printer->initialize();
					$printer->setJustification(Escpos\Printer::JUSTIFY_CENTER);
					$printer->text(strip_word_html(base64_decode($this->info['deskripsi'])) . "\n");
					$printer->text("\n");

					// Data transaksi
					$printer->initialize();
					$printer->text("Invoice : #" . $row['id_invoice'] . "\n");
					$printer->text("Kasir : " . $marketing['nama_lengkap'] . "\n");
					$printer->text("Waktu : " . tgl_indo($row['tgl_trx']) . "\n");

					// Membuat tabel
					$printer->initialize(); // Reset bentuk/jenis teks

					$printer->text("-----------------------------------------------\n");
					$printer->text(buatBaris4Kolom("Deskripsi", "QTY", "Harga", "Subtotal"));
					$printer->text("-----------------------------------------------\n");
					$no = 1;
					$totalb = 0;
					$subtotal = 0;
					$sisa = 0;
					$diskon = 0;
					foreach ($detail  as $val) {
						$diskon = $val['jumlah'] * $val['harga'] * $val['diskon'] / 100;
						$totalb = $val['jumlah'] * $val['harga'] - $diskon;
						$subtotal += $totalb;

						$printer->text(buatBaris4Kolom($val['title'] . ' ' . $val['ukuran'], $val['jumlah'] . $val['satuan'], rp($val['harga']), rp($totalb)));
						$printer->text("Ket: " . $val['nbahan'] . ' ' . $val['keterangan'] . "\n");
						//
						$pajak = ($subtotal * $row['pajak']) / 100;
						$sisa = $pajak + $subtotal - $total->total;
						$cek_bayar = $pajak + $subtotal;
					}

					$printer->text("-----------------------------------------------\n");
					$printer->text(buatBaris4Kolom('', '', "TOTAL", rp($subtotal)));
					$select              = 'pajak, total_bayar AS total, jumlah_bayar, kembalian';
					$where               = array('id_invoice' => $noid);
					$tdetail             = $this->model_app->cek_total('invoice', $select, $where);

					if ($sisa == 0) {
						if ($tdetail->jumlah_bayar > $total->total) {
							$jumlah_bayar = $tdetail->jumlah_bayar;
							$sisa = $tdetail->kembalian;
						} else {
							$jumlah_bayar = $total->total;
						}
						$printer->text(buatBaris4Kolom('', '', "BAYAR", rp($total->total)));
						$printer->text(buatBaris4Kolom('', '', "KEMBALIAN", rp($sisa)));
					} else {
						$printer->text("\n");
						$printer->text(buatBaris4Kolom('', '', "BAYAR", rp($total->total)));
						$printer->text(buatBaris4Kolom('', '', "SISA", rp($sisa)));
					}

					$printer->text("\n");
					// Pesan penutup
					$printer->initialize();
					$printer->setJustification(Escpos\Printer::JUSTIFY_CENTER);
					$printer->text("Terima kasih\n");
					$printer->text("HP: " . $this->info['phone'] . "\n");
					$printer->text(" EMAIL : " . $this->info['email'] . "\n");
					$printer->feed(3); // mencetak 5 baris kosong agar terangkat (pemotong kertas saya memiliki jarak 5 baris dari toner)
					// echo "ok";

					$printer->close();
				} else {
					echo "gagal";
				}
				//print thermal 58
			} elseif ($rowc['slug'] == 'th58' and $rowc['pub'] == 1) {

				if ($search->num_rows() > 0) {

					$this->session->unset_userdata('cart');
					$row = $search->row_array();
					$jml = $row['cetak'] + 1;
					$this->model_app->update(
						"tb_users",
						["last_invoice" => 0],
						["id_user" => $this->iduser]
					);

					if ($row['status'] != 'batal') {
						$this->model_app->update('invoice', array('cetak' => $jml, 'status' => 'simpan', 'pos' => 'Y', 'oto' => 6), array('id_invoice' => $noid));
					}

					//marketing 
					$marketing = $this->model_app->view_where('tb_users', array('id_user' => $row['id_marketing']))->row_array();
					//bayar detail
					$detail = $this->model_app->produk_cart(array('invoice_detail.id_invoice' => $noid));
					//total bayar
					$total = $this->model_app->total_bayar(array('bayar_invoice_detail.id_invoice' => $noid))->row();
					$bdetail =  $this->model_app->view_where('bayar_invoice_detail', $id)->result_array();

					//load library
					$this->load->library('escpos');
					// membuat connector printer ke shared printer bernama "printer_a" (yang telah disetting sebelumnya)
					$connector = new Escpos\PrintConnectors\WindowsPrintConnector($rowc['shared_name']);

					// membuat objek $printer agar dapat di lakukan fungsinya
					$printer = new Escpos\Printer($connector);
					// Get status
					$printer->initialize();
					$printer->selectPrintMode(Escpos\Printer::MODE_DOUBLE_HEIGHT); // Setting teks menjadi lebih besar
					$printer->setJustification(Escpos\Printer::JUSTIFY_CENTER); // Setting teks menjadi rata tengah
					$printer->text($this->info['title'] . "\n");

					$printer->initialize();
					$printer->setJustification(Escpos\Printer::JUSTIFY_CENTER);
					$printer->text(strip_word_html(base64_decode($this->info['deskripsi'])) . "\n");
					$printer->text("\n");

					// Data transaksi
					$printer->initialize();
					$printer->text("Invoice : #" . $row['id_invoice'] . "\n");
					$printer->text("Kasir : " . $marketing['nama_lengkap'] . "\n");
					$printer->text("Waktu : " . tgl_indo($row['tgl_trx']) . "\n");

					// Membuat tabel
					$printer->initialize(); // Reset bentuk/jenis teks

					$printer->text("-----------------------------------------------\n");
					$printer->text(buatBaris4Kolom58("Deskripsi", "QTY", "Harga", "Subtotal"));
					$printer->text("-----------------------------------------------\n");
					$no = 1;
					$totalb = 0;
					$subtotal = 0;
					$sisa = 0;
					$diskon = 0;
					foreach ($detail  as $val) {
						$diskon = $val['jumlah'] * $val['harga'] * $val['diskon'] / 100;
						$totalb = $val['jumlah'] * $val['harga'] - $diskon;
						$subtotal += $totalb;

						$printer->text(buatBaris4Kolom58($val['title'] . ' ' . $val['ukuran'], $val['jumlah'] . $val['satuan'], rp($val['harga']), rp($totalb)));
						$printer->text("Ket: " . $val['nbahan'] . ' ' . $val['keterangan'] . "\n");
						//
						$pajak = ($subtotal * $row['pajak']) / 100;
						$sisa = $pajak + $subtotal - $total->total;
						$cek_bayar = $pajak + $subtotal;
					}

					$printer->text("--------------------------------\n");
					$printer->text(buatBaris4Kolom58('', '', "TOTAL", rp($subtotal)));
					$select              = 'pajak, total_bayar AS total, jumlah_bayar, kembalian';
					$where               = array('id_invoice' => $noid);
					$tdetail             = $this->model_app->cek_total('invoice', $select, $where);

					if ($sisa == 0) {
						if ($tdetail->jumlah_bayar > $total->total) {
							$jumlah_bayar = $tdetail->jumlah_bayar;
							$sisa = $tdetail->kembalian;
						} else {
							$jumlah_bayar = $total->total;
							$sisa = $tdetail->kembalian;
						}
						$printer->text("\n");
						$printer->text(buatBaris4Kolom58('', '', "BAYAR", rp($total->total)));
						$printer->text(buatBaris4Kolom58('', '', "KEMBALIAN", rp($sisa)));
					} else {
						$printer->text("\n");
						$printer->text(buatBaris4Kolom58('', '', "BAYAR", rp($total->total)));
						$printer->text(buatBaris4Kolom58('', '', "SISA", rp($sisa)));
					}

					$printer->text("\n");
					// Pesan penutup
					$printer->initialize();
					$printer->setJustification(Escpos\Printer::JUSTIFY_CENTER);
					$printer->text("Terima kasih\n");
					$printer->text("HP: " . $this->info['phone'] . "\n");
					$printer->text(" EMAIL : " . $this->info['email'] . "\n");
					$printer->feed(3);

					$printer->close();
				} else {
					echo "gagal";
				}
			} elseif (($rowc['slug'] == 'direct58' or $rowc['slug'] == 'direct85') and $rowc['pub'] == 1) {

				$data['waicon'] 	= ['color' => base_url() . 'assets/img/wa_icon.png', 'bw' => base_url() . 'assets/img/wa_icon_bw.png'];
				$data['mail'] 		= ['color' => base_url() . 'assets/img/gmail_icon.png', 'bw' => base_url() . 'assets/img/gmail_icon_bw.png'];
				$data['fbicon'] 	= ['color' => base_url() . 'assets/img/fb_icon.png', 'bw' => base_url() . 'assets/img/fb_icon_bw.png'];
				$data['igicon'] 	= ['color' => base_url() . 'assets/img/ig_icon.png', 'bw' => base_url() . 'assets/img/ig_icon_bw.png'];

				$data['logo_lunas'] = base_url() . 'uploads/' . info()['logo'];
				$data['logo_blunas'] = base_url() . 'uploads/' . info()['logo_bw'];
				$data['lunas'] = base_url() . 'uploads/' . info()['stamp_l'];
				$data['blunas'] = base_url() . 'uploads/' . info()['stamp_b'];
				$data['favicon'] = base_url() . 'uploads/' . info()['favicon'];
				$data['qris'] = info()['kode_qris'];
				$data['html'] = 'Y';

				$data['ukuran'] = $rowc['ukuran_kertas'];
				$data['font_size'] = $rowc['ukuran_font'];

				if ($search->num_rows() > 0) {
					$this->session->unset_userdata('cart');
					$row = $search->row();
					$jml = $row->cetak + 1;

					$this->model_app->update(
						"tb_users",
						["last_invoice" => 0],
						["id_user" => $this->iduser]
					);

					if ($row->status != 'batal') {
						$this->model_app->update('invoice', array('cetak' => $jml, 'status' => 'simpan', 'pos' => 'Y', 'oto' => 6), array('id_invoice' => $noid));
					}
					//cek sisa
					$_total = 'ROUND(SUM((`invoice_detail`.`jumlah` * harga) - (`invoice_detail`.`jumlah` * harga) * (`invoice_detail`.`diskon`/100))) AS sisa';
					$cari_total = $this->model_app->cek_total('invoice_detail', $_total, array('id_invoice' => $noid));
					$data['sisanya'] = $cari_total->sisa;
					//
					$data['cetak'] = $row;
					$data['info'] = info();
					$konsumen = $this->model_app->view_where('konsumen', array('id' => $row->id_konsumen))->row_array();

					if ($konsumen['max_utang'] > 0 and $jml <= 1) {
						$max_utang = $konsumen['max_utang'] - 1;
						$this->model_app->update('konsumen', array('max_utang' => $max_utang), array('id' => $row->id_konsumen));
					}

					$data['konsumen']    = $konsumen;
					$data['marketing']   = $this->model_app->view_where('tb_users', array('id_user' => $row->id_marketing))->row_array();
					$data['detail']      = $this->model_app->produk_cart(array('invoice_detail.id_invoice' => $noid));
					$data['total']       = $this->model_app->total_bayar(array('bayar_invoice_detail.id_invoice' => $noid))->row();
					$select              = 'pajak, potongan_harga,cashback,total_bayar AS total, jumlah_bayar, kembalian';
					$where               = array('id_invoice' => $noid);
					$tdetail             = $this->model_app->cek_total('invoice', $select, $where);
					$data['tdetail']     = $tdetail->total;
					$data['pajak']       = $tdetail->pajak;
					$data['jumlah_bayar'] = $tdetail->jumlah_bayar;
					$data['potongan_harga'] = $tdetail->potongan_harga;
					$data['cashback']	 = $tdetail->cashback;
					$data['kembalian']	 = $tdetail->kembalian;
					$_diskon             = 'SUM(diskon) AS `disc`';
					$cdiskon             = $this->model_app->cek_total('invoice_detail', $_diskon, $where);
					$data['cdiskon']     = $cdiskon->disc;
					$_select             = 'COUNT(id) AS `jml`';
					$cdetail             = $this->model_app->cek_total('bayar_invoice_detail', $_select, $where);
					$data['cdetail']     = $cdetail->jml;
					//bayar detail
					$data['bdetail']     = $this->model_app->view_where('bayar_invoice_detail', $id)->result_array();
					///
					$data['cara']        = $this->model_app->cara_bayar(array('`jenis_bayar`.`publish`' => 'Y', '`bayar_invoice_detail`.`id_invoice`' => $noid));
					$data['bank']        = $this->model_app->view_where('rekening_bank', ['footer_invoice' => 1, 'publish' => 'Y'])->result();
					if ($rowc['slug'] == 'direct58') {
						$this->load->view('produk/print_invoice_direct58', $data);
					}
					if ($rowc['slug'] == 'direct85') {
						$this->load->view('produk/print_invoice_direct85', $data);
					}
				} else {
					$data['cetak'] = 'error';
					$this->load->view('errors/404', $data);
				}
				//print dotmatrix
			} elseif ($rowc['slug'] == 'dotmatrix' and $rowc['pub'] == 1) {
				//icon
				$data['waicon'] = ['color' => base_url() . 'assets/img/wa_icon.png', 'bw' => base_url() . 'assets/img/wa_icon_bw.png'];

				$data['mail'] 		= ['color' => base_url() . 'assets/img/gmail_icon.png', 'bw' => base_url() . 'assets/img/gmail_icon_bw.png'];
				$data['fbicon'] 	= ['color' => base_url() . 'assets/img/fb_icon.png', 'bw' => base_url() . 'assets/img/fb_icon_bw.png'];
				$data['igicon'] 	= ['color' => base_url() . 'assets/img/ig_icon.png', 'bw' => base_url() . 'assets/img/ig_icon_bw.png'];

				$data['logo_lunas'] = base_url() . 'uploads/' . info()['logo'];
				$data['logo_blunas'] = base_url() . 'uploads/' . info()['logo_bw'];
				$data['lunas'] = base_url() . 'uploads/' . info()['stamp_l'];
				$data['blunas'] = base_url() . 'uploads/' . info()['stamp_b'];
				$data['favicon'] = base_url() . 'uploads/' . info()['favicon'];
				$data['html'] = 'Y';
				$data['max_item'] = $rowc['max_item'];
				$data['font_size'] = $rowc['ukuran_font'];
				$data['font_wight'] = 'bold';
				if ($search->num_rows() > 0) {
					$this->session->unset_userdata('cart');
					$row = $search->row();
					$jml = $row->cetak + 1;
					$this->model_app->update('tb_users', array("last_invoice" => 0), array('id_user' => $this->session->idu));
					if ($row->status != 'batal') {
						$this->model_app->update('invoice', array('cetak' => $jml, 'status' => 'simpan', 'pos' => 'Y', 'oto' => 6), array('id_invoice' => $noid));
					}
					//cek sisa
					$_total = 'ROUND(SUM((`invoice_detail`.`jumlah` * harga) - (`invoice_detail`.`jumlah` * harga) * (`invoice_detail`.`diskon`/100))) AS sisa';
					$cari_total = $this->model_app->cek_total('invoice_detail', $_total, array('id_invoice' => $noid));
					$data['sisanya'] = $cari_total->sisa;
					//
					$data['cetak'] = $row;
					$data['info'] = info();
					$konsumen = $this->model_app->view_where('konsumen', array('id' => $row->id_konsumen))->row_array();

					if ($konsumen['max_utang'] > 0 and $jml <= 1) {
						$max_utang = $konsumen['max_utang'] - 1;
						$this->model_app->update('konsumen', array('max_utang' => $max_utang), array('id' => $row->id_konsumen));
					}

					$data['konsumen']    = $konsumen;
					$data['marketing']   = $this->model_app->view_where('tb_users', array('id_user' => $row->id_marketing))->row_array();
					$data['detail']      = $this->model_app->produk_cart(array('invoice_detail.id_invoice' => $noid));
					$data['total']       = $this->model_app->total_bayar(array('bayar_invoice_detail.id_invoice' => $noid))->row();
					$select              = 'pajak,potongan_harga,cashback, total_bayar AS total, jumlah_bayar, kembalian';
					$where               = array('id_invoice' => $noid);
					$tdetail             = $this->model_app->cek_total('invoice', $select, $where);
					$data['tdetail']     = $tdetail->total;
					$data['pajak']       = $tdetail->pajak;
					$data['jumlah_bayar'] = $tdetail->jumlah_bayar;
					$data['potongan_harga'] = $tdetail->potongan_harga;
					$data['cashback']	 = $tdetail->cashback;
					$data['kembalian']	 = $tdetail->kembalian;
					$_diskon             = 'SUM(diskon) AS `disc`';
					$cdiskon             = $this->model_app->cek_total('invoice_detail', $_diskon, $where);
					$data['cdiskon']     = $cdiskon->disc;
					$_select             = 'COUNT(id) AS `jml`';
					$cdetail             = $this->model_app->cek_total('bayar_invoice_detail', $_select, $where);
					$data['cdetail']     = $cdetail->jml;
					//bayar detail
					$data['bdetail']     = $this->model_app->view_where('bayar_invoice_detail', $id)->result_array();
					///
					$data['cara']        = $this->model_app->cara_bayar(array('`jenis_bayar`.`publish`' => 'Y', '`bayar_invoice_detail`.`id_invoice`' => $noid));
					$data['bank']        = $this->model_app->view_where('rekening_bank', ['footer_invoice' => 1, 'publish' => 'Y'])->result();

					$this->load->view('produk/print_invoice_dotmatrix', $data);
				} else {
					$data['cetak'] = 'error';
					$this->load->view('errors/404', $data);
				}
				//print html
			} else {
				//icon
				$data['waicon'] 	= ['color' => base_url() . 'assets/img/wa_icon.png', 'bw' => base_url() . 'assets/img/wa_icon_bw.png'];
				$data['mail'] 		= ['color' => base_url() . 'assets/img/gmail_icon.png', 'bw' => base_url() . 'assets/img/gmail_icon_bw.png'];
				$data['fbicon'] 	= ['color' => base_url() . 'assets/img/fb_icon.png', 'bw' => base_url() . 'assets/img/fb_icon_bw.png'];
				$data['igicon'] 	= ['color' => base_url() . 'assets/img/ig_icon.png', 'bw' => base_url() . 'assets/img/ig_icon_bw.png'];

				$data['logo_lunas'] = base_url() . 'uploads/' . info()['logo'];
				$data['logo_blunas'] = base_url() . 'uploads/' . info()['logo_bw'];
				$data['lunas'] = base_url() . 'uploads/' . info()['stamp_l'];
				$data['blunas'] = base_url() . 'uploads/' . info()['stamp_b'];
				$data['favicon'] = base_url() . 'uploads/' . info()['favicon'];
				$data['qris'] = info()['kode_qris'];
				$data['kode_qris'] = base_url() . 'uploads/qrcode/qris.png';

				$data['html'] = 'Y';
				$data['font_size']  = $rowc['ukuran_font'];
				$data['font_wight'] = 'bold';
				if ($search->num_rows() > 0) {
					$this->session->unset_userdata('cart');
					$row = $search->row();
					$jml = $row->cetak + 1;
					$this->model_app->update('tb_users', array("last_invoice" => 0), array('id_user' => $this->session->idu));
					if ($row->status != 'batal') {
						$this->model_app->update('invoice', array('cetak' => $jml, 'status' => 'simpan', 'pos' => 'Y', 'oto' => 6), array('id_invoice' => $noid));
					}
					//cek sisa
					$_total = 'ROUND(SUM((`invoice_detail`.`jumlah` * harga) - (`invoice_detail`.`jumlah` * harga) * (`invoice_detail`.`diskon`/100))) AS sisa';
					$cari_total = $this->model_app->cek_total('invoice_detail', $_total, array('id_invoice' => $noid));
					$data['sisanya'] = $cari_total->sisa;
					//
					$data['cetak'] = $row;
					$data['info'] = info();
					$konsumen = $this->model_app->view_where('konsumen', array('id' => $row->id_konsumen))->row_array();

					if ($konsumen['max_utang'] > 0 and $jml <= 1) {
						$max_utang = $konsumen['max_utang'] - 1;
						$this->model_app->update('konsumen', array('max_utang' => $max_utang), array('id' => $row->id_konsumen));
					}

					$data['konsumen']    = $konsumen;
					$data['marketing']   = $this->model_app->view_where('tb_users', array('id_user' => $row->id_marketing))->row_array();
					$data['detail']      = $this->model_app->produk_cart(array('invoice_detail.id_invoice' => $noid));
					$data['total']       = $this->model_app->total_bayar(array('bayar_invoice_detail.id_invoice' => $noid))->row();
					$select              = 'pajak,potongan_harga,cashback, total_bayar AS total, jumlah_bayar, kembalian';
					$where               = array('id_invoice' => $noid);
					$tdetail             = $this->model_app->cek_total('invoice', $select, $where);
					$data['tdetail']     = $tdetail->total;
					$data['pajak']       = $tdetail->pajak;
					$data['jumlah_bayar'] = $tdetail->jumlah_bayar;
					$data['potongan_harga'] = $tdetail->potongan_harga;
					$data['cashback']	 = $tdetail->cashback;
					$data['kembalian']	 = $tdetail->kembalian;
					$_diskon             = 'SUM(diskon) AS `disc`';
					$cdiskon             = $this->model_app->cek_total('invoice_detail', $_diskon, $where);
					$data['cdiskon']     = $cdiskon->disc;
					$_select             = 'COUNT(id) AS `jml`';
					$cdetail             = $this->model_app->cek_total('bayar_invoice_detail', $_select, $where);
					$data['cdetail']     = $cdetail->jml;
					//bayar detail
					$data['bdetail']     = $this->model_app->view_where('bayar_invoice_detail', $id)->result_array();
					///
					$data['cara']        = $this->model_app->cara_bayar(array('`jenis_bayar`.`publish`' => 'Y', '`bayar_invoice_detail`.`id_invoice`' => $noid));
					$data['bank']        = $this->model_app->view_where('rekening_bank', ['footer_invoice' => 1, 'publish' => 'Y'])->result();

					$this->load->view('produk/print_invoice', $data);
				} else {
					$data['cetak'] = 'error';
					$this->load->view('errors/404', $data);
				}
			}
		}
	}

	/**
	 * finishing
	 *
	 * @return void
	 */
	public function finishing()
	{
		$data['title'] = 'Data Produk | ' . info()['title'];
		$cari_finishing = $this->model_app->view_where('invoice_detail', array('id_rincianinvoice' => $this->input->post('id')));
		$finishing = '';
		$nama_produk = '-';
		if ($cari_finishing->num_rows() > 0) {
			$rows = $cari_finishing->row();
			$finishing = $rows->detail;
			$row = $this->model_app->view_where('produk', ['id' => $rows->id_produk])->row();
			$nama_produk = $row->title;
		}

		$data['detail'] = array(
			"invoice" => xss_filter($this->input->post('invoice'), 'xss'),
			"idr"     => xss_filter($this->input->post('id'), 'xss'),
			"kode"    => xss_filter($this->input->post('kode'), 'xss'),
			"jenis"   => xss_filter($this->input->post('jenis'), 'xss')
		);

		$data['nama_produk'] = $nama_produk;
		$data['desain'] =  $this->model_app->view_where('tb_users', ['aktif' => 'Y'])->result();
		$data['finishing'] = json_decode($finishing);
		$this->load->view('produk/detail', $data);
	}

	/**
	 * hapus_finishing
	 *
	 * @return void
	 */
	public function hapus_finishing()
	{
		cek_nput_post('GET');
		simpan_demo('Hapus');
		$kode      = xss_filter($this->input->post('kode'), 'xss');
		$id_finish = xss_filter($this->input->post('id'), 'xss');

		$cari = $this->model_app->view_where('invoice_detail', array('id_rincianinvoice' => $kode));
		$data = array();
		if ($cari->num_rows() > 0) {
			$row = $cari->row();
			$detail = $row->detail;
			if (!empty($detail)) {
				$json = json_decode($detail);
				foreach ($json->data as $key => $entry) {
					if ($entry->id == $id_finish) {
						unset($entry);
					} else {
						$new[] = $entry;
					}
				}
				$data['kode'] = $kode;
				$data['tipe'] = 'finishing';
				$data['data'] = array_values($new);
				$updateData = json_encode($data);
				$res = $this->model_app->update('invoice_detail', ['detail' => $updateData], ['id_rincianinvoice' => $kode]);
				if ($res['status'] == 'ok') {
					$data = array('status' => 200);
				} else {
					$data = array('status' => 400);
				}
			} else {
				$data = array('status' => 400);
			}
		} else {
			$data = array('status' => 400);
		}
		echo json_encode($data);
	}

	/**
	 * update_finishing
	 *
	 * @return void
	 */
	public function update_finishing()
	{
		cek_nput_post('GET');
		// simpan_demo('Simpan');
		$id_finish    = $this->input->post('id_finish', true);
		$title        = $this->input->post('title', true);
		$isi          = $this->input->post('isi', true);
		$tipe         = $this->input->post('tipe');
		$kode         = xss_filter($this->input->post('kode'), 'sql');
		$kode_invoice = xss_filter($this->input->post('kode_invoice'), 'sql');
		// dump($kode_invoice);
		$this->form_validation->set_rules(array(
			array(
				'field' => 'title[]',
				'label' => 'Title',
				'rules' => 'required|trim|min_length[3]|max_length[50]',
				'errors' => array(
					'required' => '%s. Harus di isi',
					'min_length' => '%s minimal 3 digit.',
					'max_length' => '%s minimal 50 digit.'
				)
			),

			array(
				'field' => 'isi[]',
				'label' => 'Keterangan',
				'rules' => 'required|trim|min_length[3]|max_length[50]',
				'errors' => array(
					'required' => '%s. Harus diisi.',
					'min_length' => '%s minimal 3 digit.',
					'max_length' => '%s minimal 50 digit.'
				)
			),
		));

		if ($this->form_validation->run() == FALSE) {
			$response['status'] = false;
			$response['msg'] = validation_errors();
			$this->output
				->set_status_header(200)
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($response, JSON_HEX_APOS | JSON_HEX_QUOT))
				->_display();
			exit();
		}

		if ($tipe == 'desain') {
			$id_desain = xss_filter($this->input->post('id_desain'), 'xss');
			$where = array('id_invoice' => $kode_invoice);
			$_data = array('id_desain' => $id_desain);
			$res = $this->model_app->update('invoice', $_data, $where);
			if ($res['status'] == 'ok') {
				$data = array("ok" => "ok", 'msg' => 'ok');
			} else {
				$data = array("ok" => "err", 'msg' => 'error');
			}
			echo json_encode($data);
		} else {
			$data = array();
			$data['kode'] = $kode;
			$data['tipe'] = 'finishing';
			$index = 0;
			foreach ($id_finish as $str) {
				$data['data'][] = array(
					'id' => $str,
					'title' => xss_filter($title[$index], 'xss'),
					'isi' => xss_filter($isi[$index], 'xss'),
				);

				$index++;
			}

			$json_update = json_encode($data);

			if (!empty($json_update)) {
				$_data = array('detail' => $json_update);
				$where = array('id_rincianinvoice' => $kode);
				$res = $this->model_app->update('invoice_detail', $_data, $where);
				if ($res['status'] == 'ok') {
					$data = array("ok" => "ok", 'msg' => 'ok');
				} else {
					$data = array("ok" => "err", 'msg' => 'error');
				}
				echo json_encode($data);
			}
		}
	}
	/**
	 * ajax
	 *
	 * @return void
	 */
	public function ajax()
	{
		cek_nput_post('GET');
		$type = $this->db->escape_str($this->input->post('type'));
		if ($type == 'jenis_table') {
			$row_num = $_POST['row_num'];
			$name = $_POST['name_startsWith'];
			$query = "SELECT * FROM jenis_cetakan where UPPER(jenis_cetakan) LIKE '%" . strtoupper($name) . "%' AND pub='Y' AND status='0'";
			$result = $this->db->query($query);
			$data = array();
			foreach ($result->result_array() as $row) {
				$name = $row['jenis_cetakan'] . '|' . $row['id_jenis'] . '|' . $row['status'] . '|' . $row_num;
				array_push($data, $name);
			}
			if (!empty($data)) {
				echo json_encode($data);
			} else {
				array_push($data, 'NONE');
				echo json_encode($data);
			}
		}
		if ($type == 'jenis_pengeluaran') {
			$row_num = $_POST['row_num'];
			$name = $_POST['name_startsWith'];
			$query = "SELECT * FROM jenis_pengeluaran where UPPER(title) LIKE '%" . strtoupper($name) . "%' AND pub='Y' AND id_akun!='102'";
			$result = $this->db->query($query);
			$data = array();
			foreach ($result->result_array() as $row) {
				$name = $row['title'] . '|' . $row['id_jenis'] . '|' . $row_num;
				array_push($data, $name);
			}
			if (!empty($data)) {
				echo json_encode($data);
			} else {
				array_push($data, 'NONE');
				echo json_encode($data);
			}
		}

		if ($type == 'jenis_pembelian') {
			$row_num = $_POST['row_num'];
			$name = $_POST['name_startsWith'];
			$query = "SELECT * FROM jenis_pengeluaran where UPPER(title) LIKE '%" . strtoupper($name) . "%'";
			$result = $this->db->query($query);
			$data = array();
			foreach ($result->result_array() as $row) {
				$name = $row['title'] . '|' . $row['id_jenis'] . '|' . $row_num;
				array_push($data, $name);
			}
			if (!empty($data)) {
				echo json_encode($data);
			} else {
				array_push($data, 'NONE');
				echo json_encode($data);
			}
		}
		if ($type == 'bahan_table') {
			$idprod = $this->input->post('idprod');
			$id_konsumen = $this->input->post('id_konsumen');
			$cek = "SELECT * FROM `produk` where id='$idprod'";
			$res = $this->db->query($cek);
			$rows = $res->row_array();
			$row_num = $this->input->post('row_num');
			$name = $this->input->post('name_startsWith');

			$query = "SELECT * FROM bahan where UPPER(title) LIKE '%" . strtoupper($name) . "%' AND id_jenis=$rows[id_jenis]";
			$result = $this->db->query($query);
			$data = array();
			$name = "";
			$satuan = "-";
			foreach ($result->result_array() as $row) {
				$id_bahan = $row['id'];
				if ($row['type_harga'] == 1) {
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
						WHERE `bahan`.`id` = $id_bahan");
					if ($sql1->num_rows() > 0) {
						$harga_jual = $sql1->row()->harga_jual;
						$satuan = $sql1->row()->id_satuan;
					} else {
						$sql = $this->db->query("select id,id_satuan,harga_jual from bahan where id=$id_bahan");
						$harga_jual = $sql->row()->harga_jual;
						$satuan = $sql->row()->id_satuan;
					}
				} elseif ($row['type_harga'] == 2) {
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
						WHERE  `harga_satuan`.`id_bahan` = $id_bahan");
					$harga_jual = $sql2->row()->harga_jual;
					$satuan = $sql2->row()->idsatuan;
				} elseif ($row['type_harga'] == 3) {
					$id_member = $this->model_app->pilih_where('jenis_member', 'konsumen', ['id' => $id_konsumen])->row()->jenis_member;
					$sql = $this->db->query("SELECT 
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

					if ($sql->num_rows() > 0) {
						$harga_jual = $sql->row()->harga_jual;
						$satuan = $sql->row()->id_satuan;
					} else {
						$sql = $this->db->query("select id,id_satuan,harga_jual from bahan where id=$id_bahan");
						$harga_jual = $sql->row()->harga_jual;
						$satuan = $sql->row()->id_satuan;
					}
				} elseif ($row['type_harga'] == 4) {
					$jumlah = $this->input->post('jumlah');
					$sql = $this->db->query("select id_satuan,harga_jual from range_harga where id_bahan=$id_bahan AND $jumlah between jumlah_minimal and jumlah_maksimal");
					if ($sql->num_rows() > 0) {
						$harga_jual = $sql->row()->harga_jual;
						$satuan = $sql->row()->id_satuan;
					} else {
						$sql = $this->db->query("select id,id_satuan,harga_jual from bahan where id=$id_bahan");
						$harga_jual = $sql->row()->harga_jual;
						$satuan = $sql->row()->id_satuan;
					}
				} elseif ($row['type_harga'] == 5) {

					$id_member = $this->model_app->pilih_where('jenis_member', 'konsumen', ['id' => $id_konsumen])->row()->jenis_member;
					$sql = $this->db->query("select id_satuan,harga_jual from harga_range_member where id_bahan=$id_bahan AND id_member='$id_member' AND 1 between jumlah_minimal and jumlah_maksimal");

					if ($sql->num_rows() > 0) {
						$harga_jual = $sql->row()->harga_jual;
						$satuan = $sql->row()->id_satuan;
					} else {
						$sql = $this->db->query("select id,id_satuan,harga_jual from bahan where id=$id_bahan");
						$harga_jual = $sql->row()->harga_jual;
						$satuan = $sql->row()->id_satuan;
					}
				} else {
					$sql = $this->db->query("select id,id_satuan,harga_jual from bahan where id_bahan=$id_bahan");
					$harga_jual = $sql->row()->harga_jual;
					$satuan = $sql->row()->id_satuan;
				}
				$name =
					$row['title'] . '|' .
					$row['id'] . '|' .
					$satuan . '|' .
					$harga_jual . '|' .
					$row['status'] . '|' .
					$row['type_harga'] . '|' .
					$row_num;
				array_push($data, $name);
			}
			if (!empty($data)) {
				echo json_encode($data);
			} else {
				array_push($data, 'Data tidak ditemukan');
				echo json_encode($data);
			}
		}
		if ($type == 'bahan_table_tiga') {
			$idprod = $_POST['idprod'];
			$cek = "SELECT * FROM `produk` where id='$idprod'";
			$res = $this->db->query($cek);
			$rows = $res->row_array();
			$row_num = $_POST['row_num'];
			$name = $_POST['name_startsWith'];
			// $query = "SELECT * FROM bahan where UPPER(title) LIKE '%".strtoupper($name)."%'";
			$query = "SELECT * FROM bahan where id_jenis=$rows[id_jenis]";
			$result = $this->db->query($query);
			$data = array();
			$name = "";
			$satuan = "-";
			foreach ($result->result_array() as $row) {

				$name =
					$row['title'] . '|' .
					$row['id'] . '|' .
					$row['id_satuan'] . '|' .
					$row['harga'] . '|' .
					$row['status'] . '|' .
					$row['type_harga'] . '|' .
					$row_num;
				array_push($data, $name);
			}
			if (!empty($data)) {
				echo json_encode($data);
			} else {
				array_push($data, 'Data tidak ditemukan');
				echo json_encode($data);
			}
		}

		if ($type == 'pembelian_bahan_table') {
			$row_num = $_POST['row_num'];
			$name = $_POST['name_startsWith'];
			$query = "SELECT * FROM bahan where UPPER(title) LIKE '%" . strtoupper($name) . "%'";
			$result = $this->db->query($query);
			$data = array();
			$name = "";
			$satuan = "-";
			foreach ($result->result_array() as $row) {
				$name = $row['title'] . '|' . $row['id'] . '|' . $row['harga_modal'] . '|' . $row_num;
				array_push($data, $name);
			}
			if (!empty($data)) {
				echo json_encode($data);
			} else {
				array_push($data, 'Data tidak ditemukan');
				echo json_encode($data);
			}
		}
		if ($type == 'bahan_table_dua') {
			$idprod = $_POST['idprod'];
			$cek = "SELECT * FROM `produk` where id='$idprod'";
			$res = $this->db->query($cek);
			$rows = $res->row_array();
			$row_num = $_POST['row_num'];
			$name = $_POST['name_startsWith'];
			// $query = "SELECT * FROM bahan where UPPER(title) LIKE '%".strtoupper($name)."%'";
			$query = "SELECT * FROM bahan where id IN ($rows[id_bahan])";
			$result = $this->db->query($query);
			$data = array();
			$name = "";
			$satuan = "-";
			foreach ($result->result_array() as $row) {
				$res = $this->db->query("SELECT satuan FROM satuan where id=" . $row['id_satuan']);
				if ($res->num_rows() > 0) {
					$rowx = $res->row_array();
					$satuan = $rowx['satuan'];
				}
				$name = $row['title'] . '|' . $row['id'] . '|' . $row['harga'] . '|' . $satuan . '|' . $rows['id_bahan'] . '|' . $row_num;
				array_push($data, $name);
			}
			if (!empty($data)) {
				echo json_encode($data);
			} else {
				array_push($data, 'Data tidak ditemukan');
				echo json_encode($data);
			}
		}
		if ($type == 'satuan_table') {
			$row_num = $_POST['row_num'];
			$name = $_POST['name_startsWith'];
			$like = ['satuan' => $name];
			$result = $this->model_app->view_like('satuan', $like);
			$data = array();
			foreach ($result->result_array() as $row) {
				$name = $row['satuan'] . '|' . $row['id'] . '|' . $row['jumlah'] . '|' . $row_num;
				array_push($data, $name);
			}
			if (!empty($data)) {
				echo json_encode($data);
			} else {
				array_push($data, $name);
				echo json_encode($data);
			}
		}

		if ($type == 'harga_table') {
			$row_num = $_POST['row_num'];
			$name = $_POST['name_startsWith'];
			$like = ['title' => $name];
			$result = $this->model_app->view_like('harga', $like);
			$data = array();
			foreach ($result->result_array() as $row) {
				$name = $row['title'] . '|' . $row['id'] . '|' . $row_num;
				array_push($data, $name);
			}
			if (!empty($data)) {
				echo json_encode($data);
			} else {
				array_push($data, $name);
				echo json_encode($data);
			}
		}

		if ($type == 'ukuran_table') {
			$row_num = $_POST['row_num'];
			$name = $_POST['name_startsWith'];
			$like = ['title' => $name];
			$result = $this->model_app->view_like('ukuran', $like);
			$data = array();
			foreach ($result->result_array() as $row) {
				$name = $row['title'] . '|' . $row['id'] . '|' . $row_num;
				array_push($data, $name);
			}
			if (!empty($data)) {
				echo json_encode($data);
			} else {
				array_push($data, $name);
				echo json_encode($data);
			}
		}

		if ($type == 'ket_table') {
			$row_num = $_POST['row_num'];
			$name = $_POST['name_startsWith'];
			$like = ['keterangan' => $name];
			$result = $this->model_app->view_like_group('invoice_detail', $like, 'keterangan');
			$data = array();
			foreach ($result->result_array() as $row) {
				$name = $row['keterangan'] . '|' . $row_num;
				array_push($data, $name);
			}
			if (!empty($data)) {
				echo json_encode($data);
			} else {
				array_push($data, $name);
				echo json_encode($data);
			}
		}
		if ($type == 'supplier') {
			$row_num = $_POST['row_num'];
			$name = $_POST['name_startsWith'];
			$like = ['nama_perusahaan' => $name];
			$result = $this->model_app->view_like('supplier', $like);
			$data = array();
			foreach ($result->result_array() as $row) {
				$name = $row['nama_perusahaan'] . '|' . $row['id_supplier'] . '|' . $row_num;
				array_push($data, $name);
			}
			if (!empty($data)) {
				echo json_encode($data);
			} else {
				array_push($data, 'NONE');
				echo json_encode($data);
			}
		}
		if ($type == 'marketing_table') {
			$row_num = $_POST['row_num'];
			$name = $_POST['name_startsWith'];
			$like = ['nama_lengkap' => $name];
			$result = $this->model_app->view_like('tb_users', $like);
			$data = array();
			foreach ($result->result_array() as $row) {
				$name = $row['nama_lengkap'] . '|' . $row['id_user'] . '|' . $row_num;
				array_push($data, $name);
			}
			if (!empty($data)) {
				echo json_encode($data);
			} else {
				array_push($data, 'NONE');
				echo json_encode($data);
			}
		}
		if ($type == 'designer_table') {
			$row_num = $_POST['row_num'];
			$name = $_POST['name_startsWith'];
			$like = ['nama_lengkap' => $name];
			$result = $this->model_app->view_like('tb_users', $like);
			$data = array();
			foreach ($result->result_array() as $row) {
				$name = $row['nama_lengkap'] . '|' . $row['id_user'] . '|' . $row_num;
				array_push($data, $name);
			}
			if (!empty($data)) {
				echo json_encode($data);
			} else {
				array_push($data, 'NONE');
				echo json_encode($data);
			}
		}
		if ($type == 'produk_table') {
			$row_num = $_POST['row_num'];
			$id_member = $this->input->post("id_member");
			$name = $this->input->post("name_startsWith");
			if (!empty($name)) {

				$query = "SELECT 
					`jenis_cetakan`.`jenis_cetakan`,
					`produk`.`barcode`,
					`produk`.`title`,
					`produk`.`ukuran`,
					`produk`.`id`,
					`produk`.`id_jenis`,
					`produk`.`id_bahan`,
					`produk`.`jumlah`,
					`produk`.`lock_harga`
					FROM
					`jenis_cetakan`
					INNER JOIN `produk` ON (`jenis_cetakan`.`id_jenis` = `produk`.`id_jenis`)
					where (UPPER(`produk`.`title`) LIKE '%" . strtoupper($name) . "%' OR UPPER(`produk`.`barcode`) LIKE '%" . strtoupper($name) . "%') AND produk.pub='1'";
				$result = $this->db->query($query);
				$data = array();

				$idb         = 0;
				$title       = '-';
				$harga_jual = 0;
				$status      = 0;
				$type_harga  = 1;
				$id_satuan   = 1;
				$data = array();
				if ($result->num_rows() > 0) {


					foreach ($result->result_array() as $row) {
						if (!empty($row['id_jenis'])) {

							$res = $this->db->query("SELECT * FROM bahan where id_jenis IN ($row[id_jenis]) AND featured=1");
							if ($res->num_rows() > 0) {
								$rowx = $res->row_array();
								$id_bahan = $rowx['id'];
								$title = $rowx['title'];
								$harga_jual = $rowx['harga_jual'];
								$status = $rowx['status'];
								$type_harga = $rowx['type_harga'];
								$id_satuan = $rowx['id_satuan'];
							} else {
								$res = $this->db->query("SELECT * FROM bahan where id_jenis IN ($row[id_jenis]) order by id desc");
								if ($res->num_rows() > 0) {
									$rowz = $res->row_array();
									$id_bahan = $rowz['id'];
									$title = $rowz['title'];
									$harga_jual = $rowz['harga_jual'];
									$status = $rowz['status'];
									$type_harga = $rowz['type_harga'];
									$id_satuan = $rowz['id_satuan'];
								} else {
									$id_bahan = 0;
									$title = '-';
									$harga_jual = 0;
									$status = 0;
									$type_harga = 0;
									$id_satuan = 0;
								}
							}
						} else {
							array_push($data, 'NONE');
							echo json_encode($data);
							exit;
						}
						if ($type_harga == 1) {
							$sql1 = $this->db->query("SELECT 
								`satuan`.`id` AS idsatuan,
								`satuan`.`satuan`,
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
								$satuan = $sql1->row()->idsatuan;
							} else {
								$sql = $this->db->query("select id,id_satuan,harga_jual from bahan where id=$id_bahan");
								$harga_jual = $sql->row()->harga_jual;
								$satuan = $sql->row()->id_satuan;
							}
						}
						if ($type_harga == 2) {
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
								`harga_satuan`.`id_bahan` = $id_bahan");
							if ($sql2->num_rows() > 0) {
								$harga_jual = $sql2->row()->harga_jual;
								$satuan = $sql2->row()->id_satuan;
							} else {
								$sql = $this->db->query("select id,id_satuan,harga_jual from bahan where id=$id_bahan");
								$harga_jual = $sql->row()->harga_jual;
								$satuan = $sql->row()->id_satuan;
							}
						}
						if ($type_harga == 3) {
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
								$sql = $this->db->query("select id,id_satuan,harga_jual from bahan where id=$id_bahan");
								$harga_jual = $sql->row()->harga_jual;
								$satuan = $sql->row()->id_satuan;
							}
						}
						if ($type_harga == 4) {
							$sql = $this->db->query("select id_satuan,harga_jual from range_harga where id_bahan=$id_bahan AND 1 between jumlah_minimal and jumlah_maksimal");
							if ($sql->num_rows() > 0) {
								$harga_jual = $sql->row()->harga_jual;
								$satuan = $sql->row()->id_satuan;
							} else {
								$sql = $this->db->query("select id,id_satuan,harga_jual from bahan where id=$id_bahan");
								$harga_jual = $sql->row()->harga_jual;
								$satuan = $sql->row()->id_satuan;
							}
						}
						if ($type_harga == 5) {
							$sql4 = $this->db->query("select id_satuan,harga_jual from harga_range_member where id_bahan=$id_bahan AND id_member='$id_member' AND 1 between jumlah_minimal and jumlah_maksimal");
							if ($sql4->num_rows() > 0) {
								$harga_jual = $sql4->row()->harga_jual;
								$satuan = $sql4->row()->id_satuan;
							} else {
								$sql = $this->db->query("select id,id_satuan,harga_jual from bahan where id=$id_bahan");
								$harga_jual = $sql->row()->harga_jual;
								$satuan = $sql->row()->id_satuan;
							}
						}
						$name =
							$row['title'] . '|' .
							rp($harga_jual) . '|' .
							$row['id'] . '|' .
							$row['jenis_cetakan'] . '|' .
							$title . '|' .
							$row['id_jenis'] . '|' .
							$id_bahan . '|' .
							$status . '|' .
							$satuan . '|' .
							$row['ukuran'] . '|' .
							$row['jumlah'] . '|' .
							$row['lock_harga'] . '|' .
							$type_harga . '|' .
							$row['barcode'] . '|' .
							$row_num;
						array_push($data, $name);
					}
				} else {
					$query = "SELECT 
						`produk`.`title` AS `judul`,
						`bahan`.`harga_jual`,
						`bahan`.`title`,
						`produk`.`jumlah`,
						`produk`.`lock_harga`,
						`produk`.`kunci`,
						`produk`.`id_jenis`,
						`bahan`.`id` AS id_bahan,
						`bahan`.`type_harga`,
						`bahan`.`id_satuan`,
						`bahan`.`status`,
						`bahan`.`barcode`,
						`bahan`.`status_stok`,
						`jenis_cetakan`.`jenis_cetakan`,
						`produk`.`id`,
						`produk`.`ukuran`,
						`satuan`.`id` AS satuan
						FROM
						`jenis_cetakan`
						INNER JOIN `produk` ON (`jenis_cetakan`.`id_jenis` = `produk`.`id_jenis`)
						INNER JOIN `bahan` ON (`jenis_cetakan`.`id_jenis` = `bahan`.`id_jenis`)
						INNER JOIN `satuan` ON (`bahan`.`id_satuan` = `satuan`.`id`)
						WHERE  `bahan`.`barcode` LIKE '%" . $name . "%' AND produk.pub='1'";
					$result = $this->db->query($query);
					if ($result->num_rows() > 0) {
						foreach ($result->result_array() as $row) {
							$name =
								$row['judul'] . '|' .
								rp($row['harga_jual']) . '|' .
								$row['id'] . '|' .
								$row['jenis_cetakan'] . '|' .
								$row['title'] . '|' .
								$row['id_jenis'] . '|' .
								$row['id_bahan'] . '|' .
								$row['status'] . '|' .
								$row['satuan'] . '|' .
								$row['ukuran'] . '|' .
								$row['jumlah'] . '|' .
								$row['lock_harga'] . '|' .
								$row['type_harga'] . '|' .
								$row['barcode'] . '|' .
								$row_num;
							array_push($data, $name);
						}
					}
				}
				if (!empty($data)) {
					echo json_encode($data);
				} else {
					array_push($data, 'NONE');
					echo json_encode($data);
				}
			} else {

				echo json_encode(array('NONE'));
			}
		}

		if ($type == 'produk_table_qr') {
			$row_num = $_POST['row_num'];
			$name = $_POST['name_startsWith'];

			$query = "SELECT 
				`jenis_cetakan`.`jenis_cetakan`,
				`produk`.`barcode`,
				`produk`.`title`,
				`produk`.`ukuran`,
				`produk`.`id`,
				`produk`.`id_jenis`,
				`produk`.`id_bahan`,
				`produk`.`jumlah`,
				`produk`.`lock_harga`
				FROM
				`jenis_cetakan`
				INNER JOIN `produk` ON (`jenis_cetakan`.`id_jenis` = `produk`.`id_jenis`)
				where `produk`.`barcode` ='$name' AND produk.pub='1'";
			$result = $this->db->query($query);
			$data = array();

			$idb         = 0;
			$title       = '-';
			$harga_dasar = 0;
			$status      = 0;
			$type_harga  = 1;
			$id_satuan   = 'pcs';

			foreach ($result->result_array() as $row) {
				$res = $this->db->query("SELECT * FROM bahan where id IN ($row[id_bahan])");
				if ($res->num_rows() > 0) {
					$rowx = $res->row_array();
					$idb = $rowx['id'];
					$title = $rowx['title'];
					$harga_dasar = $rowx['harga'];
					$status = $rowx['status'];
					$type_harga = $rowx['type_harga'];
					$id_satuan = $rowx['id_satuan'];
				}
				$name =
					$row['title'] . '|' .
					rp($harga_dasar) . '|' .
					$row['id'] . '|' .
					$row['jenis_cetakan'] . '|' .
					$title . '|' .
					$row['id_jenis'] . '|' .
					$idb . '|' .
					$status . '|' .
					$id_satuan . '|' .
					$row['ukuran'] . '|' .
					$row['jumlah'] . '|' .
					$row['lock_harga'] . '|' .
					$type_harga . '|' .
					$row['barcode'] . '|' .
					$row_num;
				array_push($data, $name);
			}
			if (!empty($data)) {
				echo json_encode($data);
			} else {
				array_push($data, 'NONE');
				echo json_encode($data);
			}
		}

		if ($type == 'produk_table_tiga') {
			$row_num = $_POST['row_num'];
			$name = $_POST['name_startsWith'];

			$query = "SELECT 
				`bahan`.`title` AS `nbahan`,
				`jenis_cetakan`.`jenis_cetakan`,
				`produk`.`title`,
				`produk`.`ukuran`,
				`bahan`.`id` AS idb,
				`bahan`.`harga_modal`,
				`bahan`.`harga_jual`,
				`bahan`.`status`,
				`bahan`.`harga` AS harga_dasar,
				`produk`.`id`,
				`produk`.`id_jenis`,
				`produk`.`jumlah`,
				`produk`.`lock_harga`,
				`bahan`.`id_satuan`
				FROM
				`jenis_cetakan`
				INNER JOIN `produk` ON (`jenis_cetakan`.`id_jenis` = `produk`.`id_jenis`)
				INNER JOIN `bahan` ON (`jenis_cetakan`.`id_jenis` = `bahan`.`id_jenis`)
				where UPPER(`produk`.`title`) LIKE '%" . strtoupper($name) . "%' AND produk.pub='1' GROUP BY bahan.id_jenis";
			$result = $this->db->query($query);
			$data = array();
			foreach ($result->result_array() as $row) {
				$name = $row['title'] . '|' . rp($row['harga_dasar']) . '|' . $row['id'] . '|' . $row['jenis_cetakan'] . '|' . $row['nbahan'] . '|' . $row['id_jenis'] . '|' . $row['idb'] . '|' . $row['status'] . '|' . get_satuan($row['id_satuan']) . '|' . $row['ukuran'] . '|' . $row['jumlah'] . '|' . $row['lock_harga'] . '|' . $row_num;
				array_push($data, $name);
			}
			if (!empty($data)) {
				echo json_encode($data);
			} else {
				array_push($data, 'NONE');
				echo json_encode($data);
			}
		}

		if ($type == 'produk_table_dua') {
			$row_num = $_POST['row_num'];
			$name = $_POST['name_startsWith'];
			$query = "SELECT 
				`produk`.`id`,
				`produk`.`id_jenis`,
				`produk`.`title`,
				`produk`.`ukuran`,
				`jenis_cetakan`.`id_jenis`,
				`jenis_cetakan`.`jenis_cetakan`,
				`jenis_cetakan`.`status`,
				`bahan`.`id` AS idb,
				`bahan`.`title` AS nbahan,
				`bahan`.`harga` AS harga_dasar,
				`bahan`.`id_satuan`
				FROM
				`jenis_cetakan`
				INNER JOIN `produk` ON (`jenis_cetakan`.`id_jenis` = `produk`.`id_jenis`)
				INNER JOIN `bahan` ON (`produk`.`id_bahan` = `bahan`.`id`)
				where UPPER(`produk`.`title`) LIKE '%" . strtoupper($name) . "%' AND produk.pub='1'";
			$result = $this->db->query($query);
			$data = array();
			foreach ($result->result_array() as $row) {
				$name = $row['title'] . '|' . rp($row['harga_dasar']) . '|' . $row['id'] . '|' . $row['jenis_cetakan'] . '|' . $row['nbahan'] . '|' . $row['id_jenis'] . '|' . $row['idb'] . '|' . $row['status'] . '|' . get_satuan($row['id_satuan']) . '|' . $row['ukuran'] . '|' . $row_num;
				array_push($data, $name);
			}
			if (!empty($data)) {
				echo json_encode($data);
			} else {
				array_push($data, 'NONE');
				echo json_encode($data);
			}
		}
	}

	public function cari_nominal()
	{
		cek_nput_post('GET');
		$idorder = $this->db->escape_str($this->input->post('idorder'));
		$idorder = id_transaksi($idorder);
		$idedit = $this->db->escape_str($this->input->post('idedit'));
		$idkasir = $this->db->escape_str($this->input->post('idkasir'));
		$jml = $this->db->escape_str($this->input->post('jml'));
		$search = $this->model_app->view_where('bayar_invoice_detail', array('jml_bayar' => $jml, 'id_invoice' => $idorder));
		if ($search->num_rows() > 0) {
			$row = $search->row_array();
			if ($row['kunci'] == 1) {
				$data = array('status' => 'edit', 'idorder' => $idorder, 'idedit' => $idedit, 'idkasir' => $idkasir, 'jml' => $jml);
			} else {
				$data = array('status' => 200, 'idorder' => $idorder, 'idedit' => $idedit, 'idkasir' => $idkasir, 'jml' => $jml);
			}
		} else {
			$data = array('status' => 400);
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	/**
	 * save_cari_invoice
	 *
	 * @return void
	 */
	public function save_cari_invoice()
	{

		cek_nput_post('GET');
		$idorder    = $this->db->escape_str($this->input->post('idorder'));
		$idorder    = strtoupper($idorder);
		if ((int)$idorder) {
			$id_invoice = ($idorder);
		} else {
			$id_invoice = id_transaksi($idorder);
		}
		$idkasir    = $this->db->escape_str($this->input->post('idkasir'));
		$idedit     = $this->db->escape_str($this->input->post('idedit'));
		$jml        = $this->db->escape_str($this->input->post('jml'));
		$id         = array('id_user' => $this->session->idu);

		$typenya = array($idedit);
		$cek_batal = $this->model_app->view_where('invoice', array('status' => 'batal', 'id_transaksi' => $idorder));
		if ($cek_batal->num_rows() > 0) {

			$data = array('status' => 400, 'msg' => 'Maaf Order Sudah dibatalkan');
			echo json_encode($data);
			exit();
		}
		$search = $this->model_app->view_where('tb_users', $id);
		if ($search->num_rows() > 0) {
			$row = $search->row_array();
			$query = "SELECT * FROM tb_users where FIND_IN_SET('$idedit', CONCAT(type_akses, ',')) AND id_user=" . $this->session->idu;
			$result = $this->db->query($query);
			if ($result->num_rows() > 0) {
				if ($idedit == 1) {
					$search = $this->model_app->view_where('invoice', array('lunas' => 1, 'id_transaksi' => $idorder));
					if ($search->num_rows() > 0) {
						$data = array('status' => 400, 'msg' => 'Maaf Order Sudah Lunas');
					} else {
						$res = $this->model_app->update('invoice', array('status' => 'edit', 'oto' => $idedit), array('id_invoice' => $id_invoice));
						if ($res['status'] == 'ok') {
							$data = array('status' => 200, 'msg' => 1);
						} else {
							$data = array('status' => 400);
						}
					}
				} elseif ($idedit == 2) { //hapus pembayaran + edit
					$res = $this->model_app->update('bayar_invoice_detail', array('kunci' => 1), array('id_invoice' => $id_invoice, 'jml_bayar' => $jml));
					$this->model_app->update('invoice', array('oto' => 1), array('id_invoice' => $id_invoice));
					if ($res['status'] == 'ok') {
						$_where = ["pemasukan" => $jml, "catatan" => "Pendapatan INVOICE NO.#" . $id_invoice];
						$this->model_app->delete("kas_masuk", $_where);
						$this->model_app->delete('bayar_invoice_detail', array('jml_bayar' => $jml, 'id_invoice' => $id_invoice));
						$data = array('status' => 200, 'msg' => 2);
					} else {
						$data = array('status' => 400);
					}
				} elseif ($idedit == 3) { //edit lunas
					$search = $this->model_app->view_where('invoice', array('lunas' => 1, 'id_transaksi' => $idorder));
					if ($search->num_rows() > 0) {
						$this->model_app->update('invoice', array('oto' => 3), array('id_transaksi' => $idorder));
						$data = array('status' => 200, 'msg' => 3);
					} else {
						$data = array('status' => 400, 'msg' => 'Order belum Lunas');
					}
				} elseif ($idedit == 4) { //pending
					$_select = 'SUM(jml_bayar) AS `jml`';
					$cdetail = $this->model_app->cek_total('bayar_invoice_detail', $_select, array('id_invoice' => $id_invoice));
					if ($cdetail->jml == 0) {
						$this->model_app->update('invoice', array('status' => 'pending', 'oto' => 1), array('id_transaksi' => $idorder));
						$data = array('status' => 200, 'msg' => 4);
						$this->model_app->update('tb_users', array("last_invoice" => 0), array('id_user' => $idkasir));
					} else {
						$data = array('status' => 400, 'msg' => 'Transaksi tidak bisa di pending');
					}
				} elseif ($idedit == 5) { //batal
					$data = array('status' => 400, 'msg' => 'batal di menu transaksi');
				}
			} else {
				$data = array('ok' => 'error');
			}
		} else {
			$data = array('ok' => 'error');
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}
	//ajak cari data	
	/**
	 * cariProduk
	 *
	 * @return void
	 */
	public function cariProduk()
	{
		cek_nput_post('GET');
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
		$sortBy = $this->input->post('sortBy');
		if (!empty($sortBy)) {
			$conditions['search']['sortBy'] = $sortBy;
		}

		$keywords = $this->input->post('keywords');
		if (!empty($keywords)) {
			$conditions['search']['keywords'] = $keywords;
		}

		$jenis = $this->input->post('jenis');
		if (!empty($jenis)) {
			$conditions['where'] = array(
				'jenis_cetakan.id_jenis' => $jenis,
				'produk.kunci' => 0
			);
		} else {
			$conditions['where'] = array(
				'produk.kunci' => 0
			);
		}
		// Get record count 
		$conditions['returnType'] = 'count';
		$totalRec = $this->model_data->getProduk($conditions);

		// Pagination configuration 
		$config['target']      = '#dataProduk';
		$config['base_url']    = base_url('produk/cariProduk');
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $limit;
		$config['link_func']   = 'search_Produk';

		// Initialize pagination library 
		$this->ajax_pagination->initialize($config);

		// Get records 
		$conditions['start'] = $offset;
		$conditions['limit'] = $limit;

		if (!empty($sortBy)) {
			$conditions['search']['sortBy'] = $sortBy;
		}

		if (!empty($keywords)) {
			$conditions['search']['keywords'] = $keywords;
		}


		if (!empty($jenis)) {
			$conditions['where'] = array(
				'jenis_cetakan.id_jenis' => $jenis,
				'produk.kunci' => 0
			);
		} else {
			$conditions['where'] = array(
				'produk.kunci' => 0
			);
		}

		unset($conditions['returnType']);
		$data['result'] = $this->model_data->getProduk($conditions);
		// Load the data list view 
		$this->load->view('produk/cari-produk', $data, false);
	}
	//jenis	
	/**
	 * cariJenis
	 *
	 * @return void
	 */
	public function cariJenis()
	{
		cek_nput_post('GET');
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
		$sortBy = $this->input->post('sortBy');
		if (!empty($sortBy)) {
			$conditions['search']['sortBy'] = $sortBy;
		}

		$keywords = $this->input->post('keywords');
		if (!empty($keywords)) {
			$conditions['search']['keywords'] = $keywords;
		}

		$jenis = $this->input->post('jenis');
		if (!empty($jenis)) {
			$conditions['where'] = array(
				'jenis_cetakan.id_jenis' => $jenis
			);
		}
		$conditions['where'] = array(
			'jenis_cetakan.kunci' => 0
		);

		// Get record count 
		$conditions['returnType'] = 'count';
		$totalRec = $this->model_data->getJenis($conditions);

		// Pagination configuration 
		$config['target']      = '#dataJenis';
		$config['base_url']    = base_url('produk/cariJenis');
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config['link_func']   = 'search_Jenis';

		// Initialize pagination library 
		$this->ajax_pagination->initialize($config);

		// Get records 
		$conditions['start'] = $offset;
		$conditions['limit'] = $this->perPage;
		$conditions['where'] = array(
			'jenis_cetakan.kunci' => 0
		);
		unset($conditions['returnType']);
		$data['result'] = $this->model_data->getJenis($conditions);

		$conditions['offset'] = $offset;
		// Load the data list view 
		$this->load->view('produk/cari-jenis', $data, false);
	}

	//bahan	
	/**
	 * cariBahan
	 *
	 * @return void
	 */
	public function cariBahan()
	{
		cek_nput_post('GET');
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
			$limit = $this->perPageBahan;
		}
		$sortBy = $this->input->post('sortBy');
		if (!empty($sortBy)) {
			$conditions['search']['sortBy'] = $sortBy;
		}

		$keywords = $this->input->post('keywords');
		if (!empty($keywords)) {
			$conditions['search']['keywords'] = $keywords;
		}

		$kategori = $this->input->post('kategori');
		if (!empty($kategori)) {
			$conditions['where'] = array(
				'`bahan`.`id_jenis`' => $kategori
			);
		}


		// dump($conditions);
		// Get record count 
		$conditions['returnType'] = 'count';
		$totalRec = $this->model_data->getBahan($conditions);

		// Pagination configuration 
		$config['target']      = '#dataBahan';
		$config['base_url']    = base_url('produk/cariBahan');
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $limit;
		$config['link_func']   = 'search_Bahan';

		// Initialize pagination library 
		$this->ajax_pagination->initialize($config);

		// Get records 
		$conditions['start'] = $offset;
		$conditions['limit'] = $limit;


		if (!empty($kategori)) {
			$conditions['where'] = array(
				'`bahan`.`id_jenis`' => $kategori
			);
		}
		unset($conditions['returnType']);
		$data['result'] = $this->model_data->getBahan($conditions);

		$conditions['offset'] = $offset;
		// Load the data list view 
		$this->load->view('produk/cari-bahan', $data, false);
	}

	//satuan	
	/**
	 * cariSatuan
	 *
	 * @return void
	 */
	public function cariSatuan()
	{
		cek_nput_post('GET');
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
		$sortBy = $this->input->post('sortBy');
		if (!empty($sortBy)) {
			$conditions['search']['sortBy'] = $sortBy;
		}

		$keywords = $this->input->post('keywords');
		if (!empty($keywords)) {
			$conditions['search']['keywords'] = $keywords;
		}

		// Get record count 
		$conditions['returnType'] = 'count';
		$totalRec = $this->model_data->getSatuan($conditions);

		// Pagination configuration 
		$config['target']      = '#dataSatuan';
		$config['base_url']    = base_url('produk/cariSatuan');
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $limit;
		$config['link_func']   = 'search_Satuan';

		// Initialize pagination library 
		$this->ajax_pagination->initialize($config);

		// Get records 
		$conditions['start'] = $offset;
		$conditions['limit'] = $limit;

		unset($conditions['returnType']);
		$data['result'] = $this->model_data->getSatuan($conditions);

		$conditions['offset'] = $offset;
		// Load the data list view 
		$this->load->view('produk/cari-satuan', $data, false);
	}
	/**
	 * export_produk
	 *
	 * @return void
	 */
	public function export_produk()
	{
		$productlist       = $this->model_app->view_where('produk', ['kunci' => 0])->result();
		$jenis_cetakan     = $this->model_app->view_where('jenis_cetakan', ['kunci' => 0])->result();
		$bahan             = $this->model_app->view_where('bahan', ['kunci' => 0])->result();
		$satuan            = $this->model_app->view_where('satuan', ['pub' => 0])->result();
		$satu_harga        = $this->model_app->views('satu_harga')->result();
		$harga_satuan      = $this->model_app->views('harga_satuan')->result();
		$harga_member      = $this->model_app->views('harga_member')->result();
		$range_harga       = $this->model_app->views('range_harga')->result();
		$harga_range_member = $this->model_app->views('harga_range_member')->result();

		$spreadsheet = new Spreadsheet();

		$spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', 'NO');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('B1', 'JENIS');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('C1', 'ID BAHAN');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('D1', 'NAMA PRODUK');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('E1', 'BARCODE');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('F1', 'UKURAN DEFAULT');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('G1', 'JUMLAH DEFAULT');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('H1', 'LOCK');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('I1', 'LOCK HARGA');

		$a = 2;
		foreach ($productlist as $prod) {
			$spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $a, $prod->id);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $a, $prod->id_jenis);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $a, $prod->id_bahan);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $a, $prod->title);
			$spreadsheet->getActiveSheet(0)->setCellValueExplicit('E' . $a, $prod->barcode, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $a, $prod->ukuran);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $a, $prod->jumlah);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $a, $prod->kunci);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $a, $prod->lock_harga);
			$a++;
		}
		//SHEET 0
		$spreadsheet->getActiveSheet()->setTitle('PRODUK');

		$spreadsheet->createSheet();

		$spreadsheet->setActiveSheetIndex(1)->setCellValue('A1', 'ID');
		$spreadsheet->setActiveSheetIndex(1)->setCellValue('B1', 'NAMA KATEGORI');
		$spreadsheet->setActiveSheetIndex(1)->setCellValue('C1', 'LOCK');
		$spreadsheet->setActiveSheetIndex(1)->setCellValue('D1', 'STATUS');
		$spreadsheet->setActiveSheetIndex(1)->setCellValue('E1', 'ID AKUN');

		$b = 2;
		foreach ($jenis_cetakan as $val) {
			$spreadsheet->setActiveSheetIndex(1)->setCellValue('A' . $b, $val->id_jenis);
			$spreadsheet->setActiveSheetIndex(1)->setCellValue('B' . $b, $val->jenis_cetakan);
			$spreadsheet->setActiveSheetIndex(1)->setCellValue('C' . $b, $val->kunci);
			$spreadsheet->setActiveSheetIndex(1)->setCellValue('D' . $b, $val->status);
			$spreadsheet->setActiveSheetIndex(1)->setCellValue('E' . $b, $val->id_akun);
			$b++;
		}
		//SHEET 1
		$spreadsheet->getActiveSheet()->setTitle('KATEGORI');

		$spreadsheet->createSheet();
		$spreadsheet->setActiveSheetIndex(2)->setCellValue('A1', 'ID');
		$spreadsheet->setActiveSheetIndex(2)->setCellValue('B1', 'JENIS');
		$spreadsheet->setActiveSheetIndex(2)->setCellValue('C1', 'NAMA BAHAN');
		$spreadsheet->setActiveSheetIndex(2)->setCellValue('D1', 'HARGA BELI');
		$spreadsheet->setActiveSheetIndex(2)->setCellValue('E1', 'ID SATUAN');
		$spreadsheet->setActiveSheetIndex(2)->setCellValue('F1', 'STATUS_STOK');
		$spreadsheet->setActiveSheetIndex(2)->setCellValue('G1', 'LOCK');
		$spreadsheet->setActiveSheetIndex(2)->setCellValue('H1', 'STATUS');
		$spreadsheet->setActiveSheetIndex(2)->setCellValue('I1', 'AKTIF');
		$spreadsheet->setActiveSheetIndex(2)->setCellValue('J1', 'TYPE HARGA');

		$c = 2;
		foreach ($bahan as $val) {
			$spreadsheet->setActiveSheetIndex(2)->setCellValue('A' . $c, $val->id);
			$spreadsheet->setActiveSheetIndex(2)->setCellValue('B' . $c, $val->id_jenis);
			$spreadsheet->setActiveSheetIndex(2)->setCellValue('C' . $c, $val->title);
			$spreadsheet->setActiveSheetIndex(2)->setCellValue('D' . $c, $val->harga_modal);
			$spreadsheet->setActiveSheetIndex(2)->setCellValue('E' . $c, $val->id_satuan);
			$spreadsheet->setActiveSheetIndex(2)->setCellValue('F' . $c, $val->status_stok);
			$spreadsheet->setActiveSheetIndex(2)->setCellValue('G' . $c, $val->kunci);
			$spreadsheet->setActiveSheetIndex(2)->setCellValue('H' . $c, $val->status);
			$spreadsheet->setActiveSheetIndex(2)->setCellValue('I' . $c, $val->pub);
			$spreadsheet->setActiveSheetIndex(2)->setCellValue('J' . $c, $val->type_harga);
			$c++;
		}

		//SHEET 2
		$spreadsheet->getActiveSheet()->setTitle('BAHAN');

		$spreadsheet->createSheet();
		$spreadsheet->setActiveSheetIndex(3)->setCellValue('A1', 'ID');
		$spreadsheet->setActiveSheetIndex(3)->setCellValue('B1', 'SATUAN');
		$spreadsheet->setActiveSheetIndex(3)->setCellValue('C1', 'NAMA SATUAN');
		$spreadsheet->setActiveSheetIndex(3)->setCellValue('D1', 'JUMLAH SATUAN');

		$d = 2;
		foreach ($satuan as $val) {
			$spreadsheet->setActiveSheetIndex(3)->setCellValue('A' . $d, $val->id);
			$spreadsheet->setActiveSheetIndex(3)->setCellValue('B' . $d, $val->satuan);
			$spreadsheet->setActiveSheetIndex(3)->setCellValue('C' . $d, $val->nama_satuan);
			$spreadsheet->setActiveSheetIndex(3)->setCellValue('D' . $d, $val->jumlah);
			$d++;
		}
		//SHEET 3
		$spreadsheet->getActiveSheet()->setTitle('SATUAN');

		$spreadsheet->createSheet();
		$spreadsheet->setActiveSheetIndex(4)->setCellValue('A1', 'ID');
		$spreadsheet->setActiveSheetIndex(4)->setCellValue('B1', 'ID BAHAN');
		$spreadsheet->setActiveSheetIndex(4)->setCellValue('C1', 'ID SATUAN');
		$spreadsheet->setActiveSheetIndex(4)->setCellValue('D1', 'HARGA POKOK');
		$spreadsheet->setActiveSheetIndex(4)->setCellValue('E1', 'PERSENTASE');
		$spreadsheet->setActiveSheetIndex(4)->setCellValue('F1', 'HARGA JUAL');

		$e = 2;
		foreach ($satu_harga as $val) {
			$spreadsheet->setActiveSheetIndex(4)->setCellValue('A' . $e, $val->id);
			$spreadsheet->setActiveSheetIndex(4)->setCellValue('B' . $e, $val->id_bahan);
			$spreadsheet->setActiveSheetIndex(4)->setCellValue('C' . $e, $val->id_satuan);
			$spreadsheet->setActiveSheetIndex(4)->setCellValue('D' . $e, $val->harga_pokok);
			$spreadsheet->setActiveSheetIndex(4)->setCellValue('E' . $e, $val->persen);
			$spreadsheet->setActiveSheetIndex(4)->setCellValue('F' . $e, $val->harga_jual);
			$e++;
		}
		//SHEET 4
		$spreadsheet->getActiveSheet()->setTitle('SATU_HARGA');

		$spreadsheet->createSheet();
		$spreadsheet->setActiveSheetIndex(5)->setCellValue('A1', 'ID');
		$spreadsheet->setActiveSheetIndex(5)->setCellValue('B1', 'ID SATUAN');
		$spreadsheet->setActiveSheetIndex(5)->setCellValue('C1', 'ID BAHAN');
		$spreadsheet->setActiveSheetIndex(5)->setCellValue('D1', 'HARGA JUAL');

		$f = 2;
		foreach ($harga_satuan as $val) {
			$spreadsheet->setActiveSheetIndex(5)->setCellValue('A' . $f, $val->id);
			$spreadsheet->setActiveSheetIndex(5)->setCellValue('B' . $f, $val->id_satuan);
			$spreadsheet->setActiveSheetIndex(5)->setCellValue('C' . $f, $val->id_bahan);
			$spreadsheet->setActiveSheetIndex(5)->setCellValue('D' . $f, $val->harga_jual);
			$f++;
		}
		//SHEET 5
		$spreadsheet->getActiveSheet()->setTitle('HARGA_BERDASARKAN_SATUAN');

		$spreadsheet->createSheet();
		$spreadsheet->setActiveSheetIndex(6)->setCellValue('A1', 'ID');
		$spreadsheet->setActiveSheetIndex(6)->setCellValue('B1', 'ID SATUAN');
		$spreadsheet->setActiveSheetIndex(6)->setCellValue('C1', 'ID BAHAN');
		$spreadsheet->setActiveSheetIndex(6)->setCellValue('D1', 'ID MEMBER');
		$spreadsheet->setActiveSheetIndex(6)->setCellValue('E1', 'HARGA JUAL');

		$g = 2;
		foreach ($harga_member as $val) {
			$spreadsheet->setActiveSheetIndex(6)->setCellValue('A' . $g, $val->id);
			$spreadsheet->setActiveSheetIndex(6)->setCellValue('B' . $g, $val->id_satuan);
			$spreadsheet->setActiveSheetIndex(6)->setCellValue('C' . $g, $val->id_bahan);
			$spreadsheet->setActiveSheetIndex(6)->setCellValue('D' . $g, $val->id_member);
			$spreadsheet->setActiveSheetIndex(6)->setCellValue('E' . $g, $val->harga_jual);
			$g++;
		}
		//SHEET 6
		$spreadsheet->getActiveSheet()->setTitle('HARGA_BERDASARKAN_LEVEL');

		$spreadsheet->createSheet();
		$spreadsheet->setActiveSheetIndex(7)->setCellValue('A1', 'ID');
		$spreadsheet->setActiveSheetIndex(7)->setCellValue('B1', 'ID BAHAN');
		$spreadsheet->setActiveSheetIndex(7)->setCellValue('C1', 'ID SATUAN');
		$spreadsheet->setActiveSheetIndex(7)->setCellValue('D1', 'JML. MIN');
		$spreadsheet->setActiveSheetIndex(7)->setCellValue('E1', 'JML. MAX');
		$spreadsheet->setActiveSheetIndex(7)->setCellValue('F1', 'HARGA JUAL');

		$h = 2;
		foreach ($range_harga as $val) {
			$spreadsheet->setActiveSheetIndex(7)->setCellValue('A' . $h, $val->id);
			$spreadsheet->setActiveSheetIndex(7)->setCellValue('B' . $h, $val->id_satuan);
			$spreadsheet->setActiveSheetIndex(7)->setCellValue('C' . $h, $val->id_bahan);
			$spreadsheet->setActiveSheetIndex(7)->setCellValue('D' . $h, $val->jumlah_minimal);
			$spreadsheet->setActiveSheetIndex(7)->setCellValue('E' . $h, $val->jumlah_maksimal);
			$spreadsheet->setActiveSheetIndex(7)->setCellValue('F' . $h, $val->harga_jual);
			$h++;
		}
		//SHEET 7
		$spreadsheet->getActiveSheet()->setTitle('HARGA_BERDASARKAN_JUMLAH');

		$spreadsheet->createSheet();
		$spreadsheet->setActiveSheetIndex(8)->setCellValue('A1', 'ID');
		$spreadsheet->setActiveSheetIndex(8)->setCellValue('B1', 'ID MEMBER');
		$spreadsheet->setActiveSheetIndex(8)->setCellValue('C1', 'ID BAHAN');
		$spreadsheet->setActiveSheetIndex(8)->setCellValue('D1', 'ID SATUAN');
		$spreadsheet->setActiveSheetIndex(8)->setCellValue('E1', 'JML. MIN');
		$spreadsheet->setActiveSheetIndex(8)->setCellValue('F1', 'JML. MAX');
		$spreadsheet->setActiveSheetIndex(8)->setCellValue('G1', 'HARGA JUAL');

		$i = 2;
		foreach ($harga_range_member as $val) {
			$spreadsheet->setActiveSheetIndex(8)->setCellValue('A' . $i, $val->id);
			$spreadsheet->setActiveSheetIndex(8)->setCellValue('B' . $i, $val->id_member);
			$spreadsheet->setActiveSheetIndex(8)->setCellValue('C' . $i, $val->id_bahan);
			$spreadsheet->setActiveSheetIndex(8)->setCellValue('D' . $i, $val->id_satuan);
			$spreadsheet->setActiveSheetIndex(8)->setCellValue('E' . $i, $val->jumlah_minimal);
			$spreadsheet->setActiveSheetIndex(8)->setCellValue('F' . $i, $val->jumlah_maksimal);
			$spreadsheet->setActiveSheetIndex(8)->setCellValue('G' . $i, $val->harga_jual);
			$i++;
		}
		//SHEET 8
		$spreadsheet->getActiveSheet()->setTitle('HARGA_JUMLAH_DAN_LEVEL');


		$spreadsheet->setActiveSheetIndex(0);

		$filename = 'produk-list';

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
		header('Cache-Control: max-age=0');

		$writer = new Xlsx($spreadsheet);
		$writer->save("php://output");
	}
	/**
	 * import_data
	 *
	 * @return void
	 */
	public function import_data()
	{
		$this->load->library('dummy');
		$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

		$spreadsheet = $reader->load($_FILES['filess']['tmp_name']);

		$sheetData          = $spreadsheet->getActiveSheet()->toArray();
		$sheetJenis         = $spreadsheet->getSheet(1)->toArray();
		$sheetBahan         = $spreadsheet->getSheet(2)->toArray();
		$sheetsatuan        = $spreadsheet->getSheet(3)->toArray();
		$satu_harga         = $spreadsheet->getSheet(4)->toArray();
		$harga_satuan       = $spreadsheet->getSheet(5)->toArray();
		$harga_member       = $spreadsheet->getSheet(6)->toArray();
		$range_harga        = $spreadsheet->getSheet(7)->toArray();
		$harga_range_member = $spreadsheet->getSheet(8)->toArray();

		$count_nom = [];
		for ($i = 1; $i < count($sheetData); $i++) {
			$nomor = (int)$sheetData[$i]['0'];
			if (!empty($nomor) and is_numeric($nomor)) {
				$count_produk[]     = $sheetData[$i]['0'];

				$produk[] =  array(
					'id_jenis'    => $sheetData[$i]['1'],
					'id_bahan'    => $sheetData[$i]['2'],
					'title'       => $sheetData[$i]['3'],
					'barcode'     => $sheetData[$i]['4'],
					'ukuran'      => $sheetData[$i]['5'],
					'jumlah'      => $sheetData[$i]['6'],
					'kunci'       => $sheetData[$i]['7'],
					'lock_harga'  => $sheetData[$i]['8'],
				);
			} else {
				$empty_produk[] = $sheetData[$i]['0'];
			}

			// print_r($nomor);
		}

		for ($j = 1; $j < count($sheetJenis); $j++) {
			$no_jenis = (int)$sheetJenis[$j]['0'];
			if (!empty($no_jenis) and is_numeric($no_jenis)) {
				$count_jenis[] = $sheetJenis[$j]['0'];

				$kategori[] =  array(
					'jenis_cetakan' => $sheetJenis[$j]['1'],
					'kunci'        => $sheetJenis[$j]['2'],
					'status'       => $sheetJenis[$j]['3'],
					'id_akun'      => $sheetJenis[$j]['4']
				);
			} else {
				$empty_jenis[] = $sheetJenis[$j]['0'];
			}
		}
		//array bahan
		for ($k = 1; $k < count($sheetBahan); $k++) {
			$no_bahan = (int)$sheetBahan[$k]['0'];
			if (!empty($no_bahan) and is_numeric($no_bahan)) {
				$count_bahan[]     = $sheetBahan[$k]['0'];

				$bahan[] =  array(
					'id_jenis'     => $sheetBahan[$k]['1'],
					'title'        => $sheetBahan[$k]['2'],
					'harga_modal'  => $sheetBahan[$k]['3'],
					'harga_jual'   => $sheetBahan[$k]['4'],
					'id_satuan'    => $sheetBahan[$k]['5'],
					'status_stok'  => $sheetBahan[$k]['6'],
					'kunci'        => $sheetBahan[$k]['7'],
					'status'       => $sheetBahan[$k]['8'],
					'pub'          => $sheetBahan[$k]['9'],
					'type_harga'   => $sheetBahan[$k]['10'],
				);
			} else {
				$empty_bahan[] = $sheetBahan[$k]['0'];
			}
		}

		//array satuan
		for ($l = 1; $l < count($sheetsatuan); $l++) {
			$no_satuan = (int)$sheetsatuan[$l]['0'];
			if (!empty($no_satuan) and is_numeric($no_satuan)) {
				$count_satuan[]     = $sheetsatuan[$l]['0'];

				$satuan[] =  array(
					'satuan'     => $sheetsatuan[$l]['1'],
					'nama_satuan' => $sheetsatuan[$l]['2'],
					'jumlah'     => $sheetsatuan[$l]['3']
				);
			} else {
				$empty_satuan[] = $sheetsatuan[$l]['0'];
			}
		}
		//array satu_harga
		for ($l = 1; $l < count($satu_harga); $l++) {
			$no_satu_harga = (int)$satu_harga[$l]['0'];
			if (!empty($no_satu_harga) and is_numeric($no_satu_harga)) {
				$count_satu_harga[]     = $satu_harga[$l]['0'];

				$satuharga[] =  array(
					'id_bahan'   => $satu_harga[$l]['1'],
					'id_satuan'  => $satu_harga[$l]['2'],
					'harga_pokok' => $satu_harga[$l]['3'],
					'persen'     => $satu_harga[$l]['4'],
					'harga_jual' => $satu_harga[$l]['5']
				);
			} else {
				$empty_satu_harga[] = $satu_harga[$l]['0'];
			}
		}

		//array harga_satuan
		for ($l = 1; $l < count($harga_satuan); $l++) {
			$no_harga_satuan = (int)$harga_satuan[$l]['0'];
			if (!empty($no_harga_satuan) and is_numeric($no_harga_satuan)) {
				$count_harga_member[]     = $harga_satuan[$l]['0'];

				$hargasatuan[] =  array(
					'id_satuan'   => $harga_satuan[$l]['1'],
					'id_bahan'    => $harga_satuan[$l]['2'],
					'harga_jual'  => $harga_satuan[$l]['3']
				);
			} else {
				$empty_harga_satuan[] = $harga_satuan[$l]['0'];
			}
		}
		//array harga_member
		for ($l = 1; $l < count($harga_member); $l++) {
			$no_harga_member = (int)$harga_member[$l]['0'];
			if (!empty($no_harga_member) and is_numeric($no_harga_member)) {
				$count_harga_member[]     = $harga_member[$l]['0'];

				$hargamember[] =  array(
					'id_satuan'   => $harga_member[$l]['1'],
					'id_bahan'    => $harga_member[$l]['2'],
					'id_member'   => $harga_member[$l]['3'],
					'harga_jual'  => $harga_member[$l]['4']
				);
			} else {
				$empty_harga_member[] = $harga_member[$l]['0'];
			}
		}
		//array range_harga
		for ($l = 1; $l < count($range_harga); $l++) {
			$no_harga_member = (int)$range_harga[$l]['0'];
			if (!empty($no_harga_member) and is_numeric($no_harga_member)) {
				$count_range_harga[]     = $range_harga[$l]['0'];

				$rangeharga[] =  array(
					'id_satuan'         => $range_harga[$l]['1'],
					'id_bahan'          => $range_harga[$l]['2'],
					'jumlah_minimal'    => $range_harga[$l]['3'],
					'jumlah_maksimal'   => $range_harga[$l]['4'],
					'harga_jual'        => $range_harga[$l]['5']
				);
			} else {
				$empty_range_harga[] = $range_harga[$l]['0'];
			}
		}

		//array harga_range_member
		for ($l = 1; $l < count($harga_range_member); $l++) {
			$no_harga_range_member = (int)$harga_range_member[$l]['0'];
			if (!empty($no_harga_range_member) and is_numeric($no_harga_range_member)) {
				$count_harga_range_member[]     = $harga_range_member[$l]['0'];

				$hargarangemember[] =  array(
					'id_member'         => $harga_range_member[$l]['1'],
					'id_bahan'          => $harga_range_member[$l]['2'],
					'id_satuan'         => $harga_range_member[$l]['3'],
					'jumlah_minimal'    => $harga_range_member[$l]['4'],
					'jumlah_maksimal'   => $harga_range_member[$l]['5'],
					'harga_jual'        => $harga_range_member[$l]['6']
				);
			} else {
				$empty_harga_range_member[] = $harga_range_member[$l]['0'];
			}
		}

		$this->db->truncate('produk');
		$this->db->truncate('jenis_cetakan');
		$this->db->truncate('bahan');
		$this->db->truncate('satuan');
		$this->db->truncate('satu_harga');
		// $this->db->truncate('harga_satuan');
		// $this->db->truncate('harga_member');
		// $this->db->truncate('range_harga');
		// $this->db->truncate('harga_range_member');

		if (!empty($produk)) {
			$_produk = $this->dummy->reset_produk();
			$this->db->insert_batch('produk', $_produk);
			$this->db->insert_batch('produk', $produk);
		}

		if (!empty($kategori)) {
			$jenis_cetakan = $this->dummy->reset_kategori();
			$this->db->insert_batch('jenis_cetakan', $jenis_cetakan);
			$this->db->insert_batch('jenis_cetakan', $kategori);
		}

		if (!empty($bahan)) {
			$_bahan = $this->dummy->reset_bahan();
			$this->db->insert_batch('bahan', $_bahan);
			$this->db->insert_batch('bahan', $bahan);
		}

		if (!empty($satuan)) {

			$this->db->insert_batch('satuan', $satuan);
		}

		if (!empty($satuharga)) {
			$this->db->insert_batch('satu_harga', $satuharga);
		}

		// if (!empty($hargasatuan)) {
		// $this->db->insert_batch('harga_satuan', $hargasatuan);
		// }

		// if (!empty($hargamember)) {
		// $this->db->insert_batch('harga_member', $hargamember);
		// }

		// if (!empty($rangeharga)) {
		// $this->db->insert_batch('range_harga', $rangeharga);
		// }

		$arr = array('status' => 200, 'msg' => 'berhasil input');
		if (!empty($satuharga)) {
			$res = $this->model_app->import_satuharga($satuharga);
			if ($res) {
				$arr = array('status' => 200, 'msg' => 'berhasil input');
			} else {

				$arr = array('status' => 404, 'msg' => 'data gagal di input');
			}
		}
		$this->output->set_output(json_encode($arr));
	}

	public function import_data_kategori()
	{
		$this->load->library('dummy');
		$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

		$spreadsheet = $reader->load($_FILES['filess']['tmp_name']);

		$sheetJenis          = $spreadsheet->getActiveSheet()->toArray();


		for ($j = 1; $j < count($sheetJenis); $j++) {
			$no_jenis = (int)$sheetJenis[$j]['0'];
			if (!empty($no_jenis) and is_numeric($no_jenis)) {
				$count_jenis[] = $sheetJenis[$j]['0'];

				$kategori[] =  array(
					'jenis_cetakan' => $sheetJenis[$j]['1'],
					'kunci'        => $sheetJenis[$j]['2'],
					'status'       => 0,
					'id_akun'      => 411
				);
			} else {
				$empty_jenis[] = $sheetJenis[$j]['0'];
			}
		}

		$this->db->truncate('jenis_cetakan');

		if (!empty($kategori)) {
			$jenis_cetakan = $this->dummy->reset_kategori();
			$this->db->insert_batch('jenis_cetakan', $jenis_cetakan);
			$this->db->insert_batch('jenis_cetakan', $kategori);
		}

		$arr = array('status' => 200, 'msg' => 'berhasil input');
		if (!empty($hargarangemember)) {
			$res = $this->model_app->import_harga_range_member($hargarangemember);
			if ($res) {
				$arr = array('status' => 200, 'msg' => 'berhasil input');
			} else {

				$arr = array('status' => 404, 'msg' => 'data gagal di input');
			}
		}
		$this->output->set_output(json_encode($arr));
	}


	/**
	 * ajax_bahan
	 *
	 * @return void
	 */
	public function ajax_bahan()
	{
		cek_nput_post('GET');
		// Search term
		$searchTerm = $this->input->post('searchTerm');

		// Get users
		$response = $this->model_data->getBahanAjax($searchTerm);

		echo json_encode($response);
	}

	/**
	 * harga_range
	 *
	 * @return void
	 */
	public function harga_range()
	{
		cek_menu_akses();
		cek_crud_akses(8);
		$data['title'] = 'Harga range | ' . info()['title'];

		$conditions['returnType'] = 'count';
		$totalRec = $this->model_data->getRange($conditions);

		// Pagination configuration 
		$config['target']      = '#dataRange';
		$config['base_url']    = base_url('produk/cariRange');
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		// Initialize pagination library 
		$this->ajax_pagination->initialize($config);

		// Get records 
		$conditions = array(
			'limit' => $this->perPage
		);
		$data['bahan'] = $this->model_app->view_where('bahan', ['pub' => 1])->result();
		$data['result'] = $this->model_data->getRange($conditions);
		$this->template->load('main/themes', 'produk/harga_range', $data);
	}

	/**
	 * cariRange
	 *
	 * @return void
	 */
	public function cariRange()
	{
		cek_nput_post('GET');
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
		$sortBy = $this->input->post('sortBy');
		if (!empty($sortBy)) {
			$conditions['search']['sortBy'] = $sortBy;
		}

		$keywords = $this->input->post('keywords');
		if (!empty($keywords)) {
			$conditions['search']['keywords'] = $keywords;
		}

		$conditions['where'] = array(
			'range_harga.pub' => 0
		);

		// Get record count 
		$conditions['returnType'] = 'count';
		$totalRec = $this->model_data->getRange($conditions);

		// Pagination configuration 
		$config['target']      = '#dataRange';
		$config['base_url']    = base_url('produk/cariRange');
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $limit;
		$config['link_func']   = 'search_Range';

		// Initialize pagination library 
		$this->ajax_pagination->initialize($config);

		// Get records 
		$conditions['start'] = $offset;
		$conditions['limit'] = $limit;

		unset($conditions['returnType']);
		$data['result'] = $this->model_data->getRange($conditions);

		$conditions['offset'] = $offset;
		// Load the data list view 
		$this->load->view('produk/cari-harga', $data, false);
	}

	/**
	 * edit_range
	 *
	 * @return void
	 */
	public function edit_range()
	{
		cek_nput_post('GET');
		$id = $this->db->escape_str($this->input->post('id'));
		if ($id > 0) {
			$where = array('id' => $id);
			$row = $this->model_app->edit('range_harga', $where)->row_array();
			$data = array('id' => $id, 'bahan' => $row['id_bahan'], 'jml_min' => $row['jumlah_minimal'], 'jml_max' => $row['jumlah_maksimal'], 'harga' => rp($row['harga_jual']), 'aktif' => $row['pub']);
		} else {
			$data = array('id' => 0, 'bahan' => "", 'title' => '', 'jml_min' => 0, 'jml_max' => 0, "aktif" => "");
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	/**
	 * save_range
	 *
	 * @return void
	 */
	public function save_range()
	{
		cek_nput_post('GET');
		simpan_demo('Simpan');
		cek_crud_akses(7);

		$config = array(
			array(
				'field' => 'bahan',
				'label' => 'Nama Barang',
				'rules' => 'required',
				'errors' => array(
					'required' => '%s. Harus dipilih',
				),
			),
			array(
				'field' => 'jml_min',
				'label' => 'Jumlah minimal',
				'rules' => 'required',
				'errors' => array(
					'required' => '%s. Harus diisi',
				),
			),
			array(
				'field' => 'jml_max',
				'label' => 'Jumlah maksimal',
				'rules' => 'required',
				'errors' => array(
					'required' => '%s. Harus diisi',
				),
			),
			array(
				'field' => 'harga_jual',
				'label' => 'Harga jual',
				'rules' => 'required',
				'errors' => array(
					'required' => '%s. Harus diisi',
				),
			),
			array(
				'field' => 'aktif',
				'label' => 'Aktif',
				'rules' => 'required',
				'errors' => array(
					'required' => '%s. Harus dipilih',
				),
			)
		);
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE) {
			$data = array(
				'error'   => true,
				'id_bahan_error' => clean(form_error('bahan')),
				'jml_min_error' => clean(form_error('jml_min')),
				'jml_max_error' => clean(form_error('jml_max')),
				'harga_jual_error' => clean(form_error('harga_jual')),
				'aktif_error' => clean(form_error('aktif'))
			);
		} else {
			$type = $this->db->escape_str($this->input->post('type'));
			$id = $this->db->escape_str($this->input->post('id_range'));
			$_data = [
				'id_bahan'       => $this->db->escape_str($this->input->post('bahan')),
				'jumlah_minimal' => $this->db->escape_str($this->input->post('jml_min')),
				'jumlah_maksimal' => $this->db->escape_str($this->input->post('jml_max')),
				'harga_jual'     => rp_to_int($this->db->escape_str($this->input->post('harga_jual'))),
				'pub'            => $this->db->escape_str($this->input->post('aktif'))
			];

			if ($id == 0 and $type == 'add') {
				///data baru
				$res = $this->model_app->input('range_harga', $_data);
				if ($res['status'] == 'ok') {
					$data = array('error' => false, 'status' => 200, 'msg' => 'Data berhasil disimpan');
				} else {
					$data = array('error' => false, 'status' => 400);
				}
			} elseif ($type == 'edit') {
				///data update
				$res =  $this->model_app->update('range_harga', $_data, array('id' => $id));
				if ($res['status'] == 'ok') {
					$data = array('error' => false, 'status' => 200, 'msg' => 'Data berhasil update');
				} else {
					$data = array('error' => false, 'status' => 400);
				}
			} else {
				$data = array('error' => false, 'status' => 400, 'msg' => 'Data tidak ditemukan');
			}
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	/**
	 * hapus_range
	 *
	 * @return void
	 */
	public function hapus_range()
	{
		cek_nput_post('GET');
		simpan_demo('Hapus');
		cek_crud_akses(10);
		$id = $this->db->escape_str($this->input->post('id'));
		$res = $this->model_app->hapus('range_harga', array('id' => $id));
		if ($res['status'] == 'ok') {
			$data = array('status' => 200, 'msg' => 'Data berhasil dihapus');
		} else {
			$data = array('status' => 400, 'msg' => 'Data gagal dihapus');
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	/**
	 * load_satuan
	 *
	 * @return void
	 */
	public function load_satuan()
	{
		cek_nput_post('GET');
		$id = $this->db->escape_str($this->input->post('id'));

		$result = $this->model_app->view_where('satuan', array('pub' => '0'));
		$data = array();
		foreach ($result->result() as $row) {
			$data[] = array("id" => $row->id, "name" => $row->satuan);
		}

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	/**
	 * load_satuan_range
	 *
	 * @return void
	 */
	public function load_satuan_range()
	{
		cek_nput_post('GET');
		$id = $this->db->escape_str($this->input->post('id'));

		$result = $this->model_app->view_where('satuan', array('pub' => '0'));
		$data = array();
		foreach ($result->result() as $row) {
			$data[] = array("id" => $row->id, "name" => $row->satuan);
		}

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	/**
	 * load_member
	 *
	 * @return void
	 */
	public function load_member()
	{
		cek_nput_post('GET');
		$id = $this->db->escape_str($this->input->post('id'));

		$result = $this->model_app->view_where('member', ['status' => 1]);
		$data = array();
		foreach ($result->result() as $row) {
			$data[] = array("id" => $row->id, "name" => $row->title);
		}

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	/**
	 * load_satu_harga
	 *
	 * @return void
	 */
	public function load_satu_harga()
	{
		cek_nput_post('GET');
		$id = $this->db->escape_str($this->input->post('id'));
		$data['id_bahan'] = $id;
		$data['bahan'] = $this->model_app->pilih_where('harga,harga_modal,id_satuan', 'bahan', ['id' => $id])->row();

		$finishing = '';
		$nama_produk = '-';
		$cari_finishing = $this->model_app->view_where('satu_harga', array('id_bahan' => $id));
		if ($cari_finishing->num_rows() > 0) {
			$rows = $cari_finishing->row();
			$finishing = $rows->detail_harga_pokok;
		}
		$data['detail_hpp'] = json_decode($finishing);
		$data['satuan'] = $this->model_app->view_where('satuan', ['pub' => 0])->result();
		$data['row'] = $this->model_app->view_where('satu_harga', ['id_bahan' => $id])->row();

		$this->load->view('produk/load_satu_harga', $data, false);
	}

	/**
	 * load_level
	 *
	 * @return void
	 */
	public function load_level()
	{
		cek_nput_post('GET');
		$id = $this->db->escape_str($this->input->post('id'));

		$cek = $this->model_app->view_where('harga_member', ['id_bahan' => $id]);
		if ($cek->num_rows() > 0) {
			$row = $cek->row();
			$data = ['id' => $id, 'id_satuan' => $row->id_satuan, 'id_member' => $row->id_member, 'jual' => $row->harga_jual];
		} else {
			$data = ['id' => $id, 'id_satuan' => 0, 'id_member' => 0, 'jual' => 0];
		}

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	/**
	 * save_satu_harga
	 *
	 * @return void
	 */
	public function save_satu_harga()
	{
		cek_nput_post('GET');
		$id = $this->db->escape_str($this->input->post('id'));
		$satuan = $this->db->escape_str($this->input->post('satuan'));
		$harga_beli = $this->db->escape_str($this->input->post('harga_beli'));
		$harga_pokok = $this->db->escape_str($this->input->post('harga_pokok'));
		$persen = $this->db->escape_str($this->input->post('persen'));
		$harga_jual = $this->db->escape_str($this->input->post('harga_jual'));
		$total_hpp = $this->db->escape_str($this->input->post('total_hpp'));
		$_data = [
			'id_bahan' => $id,
			'id_satuan' => $satuan,
			'harga_beli' => $harga_beli,
			'harga_pokok' => $harga_pokok,
			'persen' => $persen,
			'harga_jual' => $harga_jual
		];
		$cek = $this->model_app->view_where('satu_harga', ['id_bahan' => $id]);
		if ($cek->num_rows() > 0) {
			$res =  $this->model_app->update('satu_harga', $_data, array('id_bahan' => $id));
			$this->model_app->update('bahan', ['harga_modal' => $harga_beli, 'harga_jual' => $harga_jual, 'harga' => $harga_pokok + $total_hpp, 'id_satuan' => $satuan], array('id' => $id));
			if ($res['status'] == 'ok') {
				$data = array('error' => false, 'status' => 200, 'msg' => 'Data berhasil update');
			} else {
				$data = array('error' => false, 'status' => 400);
			}
		} else {
			$res = $this->model_app->input('satu_harga', $_data);
			if ($res['status'] == 'ok') {
				$data = array('error' => false, 'status' => 200, 'msg' => 'Data berhasil disimpan');
			} else {
				$data = array('error' => false, 'status' => 400);
			}
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	/**
	 * satuan_harga
	 *
	 * @return void
	 */
	public function satuan_harga()
	{
		cek_nput_post('GET');
		$id = $this->db->escape_str($this->input->post('id'));
		$data['id_bahan'] = $id;
		$data['bahan'] = $this->model_app->pilih_where('harga_modal,harga_jual,id_satuan', 'bahan', ['id' => $id])->row();
		$data['result'] = $this->model_app->view_where('harga_satuan', ['id_bahan' => $id])->result();
		$this->load->view('produk/load_satuan', $data, false);
	}

	/**
	 * load_harga_level
	 *
	 * @return void
	 */
	public function load_harga_level()
	{
		cek_nput_post('GET');
		$id = $this->db->escape_str($this->input->post('id'));
		$data['id_bahan'] = $id;
		$data['bahan'] = $this->model_app->pilih_where('harga_modal,harga_jual,id_satuan', 'bahan', ['id' => $id])->row();
		$data['result'] = $this->model_app->view_where('harga_member', ['id_bahan' => $id])->result();
		$this->load->view('produk/load_level', $data, false);
	}

	/**
	 * load_range
	 *
	 * @return void
	 */
	public function load_range()
	{
		cek_nput_post('GET');
		$id = $this->db->escape_str($this->input->post('id'));
		$data['id_bahan'] = $id;
		$data['bahan'] = $this->model_app->pilih_where('harga_modal,harga_jual,id_satuan', 'bahan', ['id' => $id])->row();
		$data['result'] = $this->model_app->view_where('range_harga', ['id_bahan' => $id])->result();
		$this->load->view('produk/load_range', $data, false);
	}

	/**
	 * load_range_level
	 *
	 * @return void
	 */
	public function load_range_level()
	{
		cek_nput_post('GET');
		$id = $this->db->escape_str($this->input->post('id'));
		$data['id_bahan'] = $id;
		$data['bahan'] = $this->model_app->pilih_where('harga_modal,harga_jual,id_satuan', 'bahan', ['id' => $id])->row();
		$data['result'] = $this->model_app->view_where('harga_range_member', ['id_bahan' => $id])->result();
		$this->load->view('produk/load_range_level', $data, false);
	}

	/**
	 * add_harga_range
	 *
	 * @return void
	 */
	public function add_harga_range()
	{
		cek_nput_post('GET');
		$a = $this->db->escape_str($this->input->post('no'));
		$no = $this->db->escape_str($this->input->post('row'));
		$_data = [
			'id_bahan'       => $this->db->escape_str($this->input->post('id')),
			'id_satuan'       => $this->db->escape_str($this->input->post('satuan')),
			'jumlah_minimal' => $this->db->escape_str($this->input->post('minimal')),
			'jumlah_maksimal' => $this->db->escape_str($this->input->post('maksimal')),
			'harga_jual'     => rp_to_int($this->db->escape_str($this->input->post('harga')))
		];

		$res = $this->model_app->input('range_harga', $_data);
		// $result = $this->model_app->views('satuan')->result();
		if ($res['status'] == 'ok') {
			$row = $this->model_app->view_where('range_harga', ['id' => $res['id']])->row();
			$data = [
				'a' => $a,
				'no' => $no,
				'id' => $row->id,
				'satuan' => $row->id_satuan,
				'jumlah_minimal' => $row->jumlah_minimal,
				'jumlah_maksimal' => $row->jumlah_maksimal,
				'harga_jual' => $row->harga_jual,
			];
			$this->load->view('produk/add_harga_range', $data, false);
		}
	}
	/**
	 * add_harga_range_level
	 *
	 * @return void
	 */
	public function add_harga_range_level()
	{
		cek_nput_post('GET');
		$a = $this->db->escape_str($this->input->post('no'));
		$no = $this->db->escape_str($this->input->post('row'));

		$_data = [
			'id_member'       => $this->db->escape_str($this->input->post('level')),
			'id_bahan'       => $this->db->escape_str($this->input->post('id')),
			'id_satuan'       => $this->db->escape_str($this->input->post('satuan')),
			'jumlah_minimal' => $this->db->escape_str($this->input->post('minimal')),
			'jumlah_maksimal' => $this->db->escape_str($this->input->post('maksimal')),
			'harga_jual'     => rp_to_int($this->db->escape_str($this->input->post('harga')))
		];
		$res = $this->model_app->input('harga_range_member', $_data);
		if ($res['status'] == 'ok') {
			$row = $this->model_app->view_where('harga_range_member', ['id' => $res['id']])->row();

			$data =
				[
					'a' => $a,
					'no' => $no,
					'id' => $row->id,
					'satuan' => $row->id_satuan,
					'id_member' => $row->id_member,
					'id_bahan' => $row->id_bahan,
					'jumlah_minimal' => $row->jumlah_minimal,
					'jumlah_maksimal' => $row->jumlah_maksimal,
					'harga_jual' => $row->harga_jual
				];

			$this->load->view('produk/add_harga_range_level', $data, false);
		}
	}


	/**
	 * add_harga_level
	 *
	 * @return void
	 */
	public function add_harga_level()
	{
		cek_nput_post('GET');
		$no = $this->db->escape_str($this->input->post('no'));
		$a = $this->db->escape_str($this->input->post('row'));
		$_data = [
			'id_satuan'       => $this->db->escape_str($this->input->post('satuan')),
			'id_bahan'       => $this->db->escape_str($this->input->post('id')),
			'id_member'       => $this->db->escape_str($this->input->post('level')),
			'harga_jual'     => rp_to_int($this->db->escape_str($this->input->post('harga')))
		];
		$res = $this->model_app->input('harga_member', $_data);
		if ($res['status'] == 'ok') {
			$row = $this->model_app->view_where('harga_member', ['id' => $res['id']])->row();

			$data =
				[
					'a' => $a,
					'no' => $no,
					'id' => $row->id,
					'satuan' => $row->id_satuan,
					'id_member' => $row->id_member,
					'harga_jual' => $row->harga_jual,
				];
			$this->load->view('produk/add_harga_level', $data, false);
		}
	}
	/**
	 * add_satuan_harga
	 *
	 * @return void
	 */
	public function add_satuan_harga()
	{
		cek_nput_post('GET');
		// dump($_POST);
		$no = xss_filter($this->input->post('no'), 'xss');
		$a = $this->db->escape_str($this->input->post('row'));
		$id_bahan = xss_filter($this->input->post('id'), 'xss');
		$harga_pokok = xss_filter($this->input->post('harga_pokok'), 'xss');
		$harga_jual = xss_filter($this->input->post('harga_jual'), 'xss');
		$harga_jual = rp_to_int($harga_jual);
		$_data = [
			'id_satuan' => xss_filter($this->input->post('satuan'), 'xss'),
			'id_bahan'	=> $id_bahan,
			'harga_pokok' => $harga_pokok,
			'harga_jual' => $harga_jual
		];

		$res = $this->model_app->input('harga_satuan', $_data);
		if ($res['status'] == 'ok') {
			$row = $this->model_app->view_where('harga_satuan', ['id' => $res['id']])->row();

			$data =
				[
					'a' => $a,
					'no' => $no,
					'id' => $row->id,
					'satuan' => $row->id_satuan,
					'harga_pokok' => $row->harga_pokok,
					'harga_jual' => $row->harga_jual,
				];

			$this->load->view('produk/add_satuan_harga', $data, false);
		}
	}

	/**
	 * edit_harga_satuan
	 *
	 * @return void
	 */
	public function edit_harga_satuan()
	{
		cek_nput_post('GET');
		$id = $this->db->escape_str($this->input->post('id'));
		$column = $this->db->escape_str($this->input->post('column'));
		$editval = $this->db->escape_str($this->input->post('editval'));

		$res = $this->model_app->update('harga_satuan', [$column => $editval], array('id' => $id));

		if ($res['status'] == 'ok') {
			$data = array('error' => false, 'status' => 200, 'msg' => 'Data berhasil update');
		} else {
			$data = array('error' => true, 'status' => 400);
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	/**
	 * edit_harga_level
	 *
	 * @return void
	 */
	public function edit_harga_level()
	{
		cek_nput_post('GET');
		$id = $this->db->escape_str($this->input->post('id'));
		$column = $this->db->escape_str($this->input->post('column'));
		$editval = $this->db->escape_str($this->input->post('editval'));

		$res = $this->model_app->update('harga_member', [$column => $editval], array('id' => $id));

		if ($res['status'] == 'ok') {
			$data = array('error' => false, 'status' => 200, 'msg' => 'Data berhasil update');
		} else {
			$data = array('error' => true, 'status' => 400);
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	public function edit_harga_range()
	{
		cek_nput_post('GET');
		$id = $this->db->escape_str($this->input->post('id'));
		$column = $this->db->escape_str($this->input->post('column'));
		$editval = $this->db->escape_str($this->input->post('editval'));

		$res = $this->model_app->update('range_harga', [$column => $editval], array('id' => $id));

		if ($res['status'] == 'ok') {
			$data = array('error' => false, 'status' => 200, 'msg' => 'Data berhasil update');
		} else {
			$data = array('error' => true, 'status' => 400);
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	public function edit_harga_range_level()
	{
		cek_nput_post('GET');
		$id = $this->db->escape_str($this->input->post('id'));
		$column = $this->db->escape_str($this->input->post('column'));
		$editval = $this->db->escape_str($this->input->post('editval'));

		$res = $this->model_app->update('harga_range_member', [$column => $editval], array('id' => $id));

		if ($res['status'] == 'ok') {
			$data = array('error' => false, 'status' => 200, 'msg' => 'Data berhasil update');
		} else {
			$data = array('error' => true, 'status' => 400);
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	public function delete_harga_range()
	{
		cek_nput_post('GET');
		simpan_demo('Hapus');
		cek_crud_akses(10);
		$id = $this->db->escape_str($this->input->post('id'));
		$res = $this->model_app->hapus('range_harga', array('id' => $id));
		if ($res['status'] == 'ok') {
			$data = array('status' => 200, 'msg' => 'Data berhasil dihapus');
		} else {
			$data = array('status' => 400, 'msg' => 'Data gagal dihapus');
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	public function delete_harga_range_level()
	{
		cek_nput_post('GET');
		simpan_demo('Hapus');
		cek_crud_akses(10);
		$id = $this->db->escape_str($this->input->post('id'));
		$res = $this->model_app->hapus('harga_range_member', array('id' => $id));
		if ($res['status'] == 'ok') {
			$data = array('status' => 200, 'msg' => 'Data berhasil dihapus');
		} else {
			$data = array('status' => 400, 'msg' => 'Data gagal dihapus');
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	public function delete_harga_satuan()
	{
		cek_nput_post('GET');
		simpan_demo('Hapus');
		cek_crud_akses(10);
		$id = $this->db->escape_str($this->input->post('id'));
		$res = $this->model_app->hapus('harga_satuan', array('id' => $id));
		if ($res['status'] == 'ok') {
			$data = array('status' => 200, 'msg' => 'Data berhasil dihapus');
		} else {
			$data = array('status' => 400, 'msg' => 'Data gagal dihapus');
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	public function delete_harga_level()
	{
		cek_nput_post('GET');
		simpan_demo('Hapus');
		cek_crud_akses(10);
		$id = $this->db->escape_str($this->input->post('id'));
		$res = $this->model_app->hapus('harga_member', array('id' => $id));
		if ($res['status'] == 'ok') {
			$data = array('status' => 200, 'msg' => 'Data berhasil dihapus');
		} else {
			$data = array('status' => 400, 'msg' => 'Data gagal dihapus');
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	public function export_barcode()
	{
		$data['title'] = 'Data Produk | ' . info()['title'];
		$data['judul'] = 'Data Produk';
		$data['result'] = $this->model_app->view_where('produk', ['kunci' => 0])->result_array();

		$this->load->view('produk/export_barcode', $data);
	}

	public function export_harga()
	{
		$data['title'] = 'Data Harga Produk | ' . info()['title'];
		$data['judul'] = 'Barcode Harga Produk';
		$data['result'] = $this->model_app->view_where('bahan', ['pub' => 1])->result_array();

		$this->load->view('produk/export_harga', $data);
	}

	public function update_hpp()
	{
		cek_nput_post('GET');

		$id_bahan	= ($this->input->post('id_bahan', true));
		$id_detail	= ($this->input->post('id_detail', true));
		$title    	= ($this->input->post('title', true));
		$harga		= $this->input->post('harga', true);
		$harga		= $nohp = str_replace(".", "", $harga);

		// dump($harga);
		$this->form_validation->set_rules(array(
			array(
				'field' => 'title[]',
				'label' => 'Title',
				'rules' => 'required|trim|min_length[1]|max_length[9]',
				'errors' => array(
					'required' => '%s. Harus di isi',
					'min_length' => '%s minimal 1 digit.',
					'max_length' => '%s minimal 9 digit.'
				)
			),

			array(
				'field' => 'harga[]',
				'label' => 'Harga',
				'rules' => 'required|trim|min_length[1]|max_length[9]',
				'errors' => array(
					'required' => '%s. Harus diisi.',
					'min_length' => '%s minimal 1 digit.',
					'max_length' => '%s minimal 9 digit.'
				)
			),
		));
		// dump($_POST);
		if ($this->form_validation->run() == FALSE) {
			$response['status'] = false;
			$response['msg'] = validation_errors();
			$this->output
				->set_status_header(200)
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($response, JSON_HEX_APOS | JSON_HEX_QUOT))
				->_display();
			exit();
		}
		// dump($_POST);
		$index = 0;
		foreach ($id_detail as $str) {
			$data['data'][] = array(
				'id' => $index,
				'id_bahan' => $id_bahan,
				'link_produk' => $id_bahan,
				'title' => $title[$index],
				'harga' => $harga[$index],
				'tanggal' => strtotime(today()),
			);

			$index++;
		}
		$json_update = json_encode($data);
		// dump($json_update);

		if (!empty($json_update)) {
			$_data = array('detail_harga_pokok' => $json_update);
			$where = array('id_bahan' => $id_bahan);
			$res = $this->model_app->update('satu_harga', $_data, $where);
			if ($res['status'] == 'ok') {
				$data = array("ok" => "ok", 'msg' => 'ok');
			} else {
				$data = array("ok" => "err", 'msg' => 'error');
			}
			echo json_encode($data);
		}
	}

	public function hitung_ukuran()
	{
		$id_hitung	= $this->input->post('id', true);
		$data['id'] = $id_hitung;
		$this->load->view('produk/load_hitung_ukuran', $data);
	}
}
