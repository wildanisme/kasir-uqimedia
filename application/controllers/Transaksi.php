<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		// cek_tabel();
		cek_session_login();
		$this->load->model('model_transaksi');
		$this->info = info();
		$this->iduser = $this->session->idu;
		$this->perPage = 10;
		$this->title = info()['title'];
		$this->level = $this->session->level;
	}

	/**
	 * index
	 *
	 * @return string
	 */
	public function index()
	{
		cek_menu_akses();
		$data['title'] = 'Laporan Transaksi Penjualan | ' . info()['title'];

		$data['tanggal'] = tgl_sampai_slash();
		$data['periode'] = date('M Y');
		$data['pilihan'] = $this->model_app->view('tb_users');
		$data['level'] = $this->level;
		$this->template->load('main/themes', 'transaksi/view_index', $data);
	}


	/**
	 * load_data
	 *
	 * @return void
	 */
	public function load_data()
	{
		$jenis = $this->input->post('jenis');
		if ($jenis == 1) {
			$this->harian();
		} else {
			$this->perbulan();
		}
	}

	/**
	 * harian
	 *
	 * @return string
	 */
	public function harian()
	{
		cek_nput_post('GET');
		$tanggal = $this->input->post('tanggal');
		$user = $this->input->post('user');

		if (!empty($tanggal)) {
			$tanggal = date_slash($this->input->post('tanggal'));
		}

		$masuk['masuk'] = $this->model_transaksi->getLaporanHarian($tanggal, $user);
		$keluar['keluar'] = $this->model_transaksi->getPengeluaranHarian($tanggal, $user);
		$beli['beli'] = $this->model_transaksi->getPembelianHarian($tanggal, $user);
		$result = array_merge($masuk, $keluar, $beli);
		$data['result'] = $result;
		// dump($masuk);
		$this->load->view('transaksi/laporan-harian', $data, false);
	}
	/**
	 * perbulan
	 *
	 * @return string
	 */
	public function perbulan()
	{
		cek_nput_post('GET');
		$user = $this->input->post('user');
		$periode = $this->input->post('periode');

		$bulan = periode($periode)['bulan'];
		$tahun = periode($periode)['tahun'];

		$masuk['masuk'] = $this->model_transaksi->getLaporanBulanan($bulan, $tahun, $user);
		$keluar['keluar'] = $this->model_transaksi->getPengeluaranBulanan($bulan, $tahun, $user);
		$beli['beli'] = $this->model_transaksi->getPembelianBulanan($bulan, $tahun, $user);
		$result = array_merge($masuk, $keluar, $beli);
		$data['result'] = $result;
		// dump($data);
		$this->load->view('transaksi/laporan-harian', $data, false);
	}


	/**
	 * cetak_pdf
	 *
	 * @return string
	 */
	public function cetak_pdf()
	{

		$jenis = $this->db->escape_str($this->input->post('jenis'));

		if ($jenis == 1) {
			$this->cetak_harian();
		} else {
			$this->cetak_perbulan();
		}
	}

	/**
	 * cetak_harian
	 *
	 * @return string
	 */
	private function cetak_harian()
	{
		$tgl    = date("Y_m_d_H_i_s");
		$data['logo'] = FCPATH . 'uploads/' . info()['logo'];
		$data['logop'] = base_url() . 'uploads/' . info()['logo'];
		$data['info'] = info();
		$data['tgl'] = date('d/m/Y');
		$user_trx = $this->db->escape_str($this->input->post('user_trx'));

		$tanggal = date_slash($this->input->post('tanggal'));

		//user
		$_user = $this->model_app->view_where('tb_users', array('id_user' => $this->iduser))->row();
		$data['user'] = $_user->nama_lengkap;
		$data['periode_name'] = 'TANGGAL TRANSAKSI';
		$data['periode'] = $this->input->post('tanggal');

		$masuk['masuk'] = $this->model_transaksi->getLaporanHarian($tanggal, $user_trx);
		$keluar['keluar'] = $this->model_transaksi->getPengeluaranHarian($tanggal, $user_trx);
		$beli['beli'] = $this->model_transaksi->getPembelianHarian($tanggal, $user_trx);
		$result = array_merge($masuk, $keluar, $beli);
		$data['result'] = $result;

		$this->load->library('pdf');
		$this->pdf->setPaper('A4', 'potrait');
		$this->pdf->filename = "LAPORAN_TRANSAKSI_" . $tgl;
		$this->pdf->load_view('transaksi/cetak_transaksi', $data);
		// $this->load->view('transaksi/cetak_transaksi',$data);
	}

	/**
	 * cetak_perbulan
	 *
	 * @return string
	 */
	private function cetak_perbulan()
	{
		$tgl    = date("Y_m_d_H_i_s");
		$data['logo'] = FCPATH . 'uploads/' . info()['logo'];
		$data['logop'] = base_url() . 'uploads/' . info()['logo'];
		$data['info'] = info();
		$data['tgl'] = date('d/m/Y');
		$user_trx = $this->db->escape_str($this->input->post('user_trx'));

		$periode = $this->input->post('periode');

		$bulan = periode($periode)['bulan'];
		$tahun = periode($periode)['tahun'];

		//user
		$_user = $this->model_app->view_where('tb_users', array('id_user' => $this->iduser))->row();
		$data['user'] = $_user->nama_lengkap;
		$data['periode_name'] = 'PERIODE TRANSAKSI';
		$data['periode'] = getBulan($bulan) . ' ' . $tahun;

		$masuk['masuk'] = $this->model_transaksi->getLaporanBulanan($bulan, $tahun, $user_trx);
		$keluar['keluar'] = $this->model_transaksi->getPengeluaranBulanan($bulan, $tahun, $user_trx);
		$beli['beli'] = $this->model_transaksi->getPembelianBulanan($bulan, $tahun, $user_trx);
		$result = array_merge($masuk, $keluar, $beli);
		$data['result'] = $result;

		$this->load->library('pdf');
		$this->pdf->setPaper('A4', 'potrait');
		$this->pdf->filename = "LAPORAN_TRANSAKSI_" . $tgl;
		$this->pdf->load_view('transaksi/cetak_transaksi', $data);
		// $this->load->view('transaksi/cetak_transaksi',$data);
	}
}
