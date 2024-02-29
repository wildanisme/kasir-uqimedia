<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Absen extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->perPage = 10;
		$this->title = info()['title'];
		$this->iduser = $this->session->idu;
		$this->akses = $this->session->type_akses;
		$this->load->model('model_gaji');
	}


	public function index()
	{
		cek_login_kehadiran(1);
		$data['title'] = 'Dashboard | ' . $this->title;
		$data['id'] = encrypt_url($this->iduser);
		$data['result'] = $this->model_app->view_where('hak_akses', ['publish' => 'Y']);
		$data['setting'] = $this->model_app->views('pengaturan_presensi')->row();
		$this->template->load('main/thm', 'main/dashboard_absen', $data);
	}

	public function list_kehadiran()
	{
		cek_login_kehadiran(1);
		$data["kehadiran"] = $this->model_app
			->view_where("absen", ["tgl" => date('Y-m-d')])
			->result();

		$this->load->view("absen/list_kehadiran", $data);
	}

	public function load_masuk()
	{

		$conditions['where'] = ['masuk!=' => null, "tgl" => date('Y-m-d')];
		$data = $this->model_app->counter("absen", $conditions);
		$this->output
			->set_content_type("application/json")
			->set_output(json_encode($data));
	}

	public function load_pulang()
	{

		$conditions['where'] = ['pulang!=' => null, "tgl" => date('Y-m-d')];
		$data = $this->model_app->counter("absen", $conditions);
		$this->output
			->set_content_type("application/json")
			->set_output(json_encode($data));
	}

	public function load_karyawan()
	{
		$conditions['where'] = array(
			'level !=' => 'owner',
			'aktif' => 'Y',
		);
		$conditions['search']['level'] = 'admin';
		// print_r($conditions);
		$data = $this->model_app->counter("tb_users", $conditions);
		$this->output
			->set_content_type("application/json")
			->set_output(json_encode($data));
	}

	public function penggajian()
	{
		$data['title'] = 'Penggajian | ' . $this->title;

		$data['dari'] = date('01/m/Y', strtotime(today()));
		$data['sampai'] = date('t/m/Y', strtotime(today()));
		if ($this->session->level_absen == 'admin' or $this->session->level_absen == 'owner' or $this->session->level_absen == 'keuangan') {
			$data['user'] = $this->model_app->views('tb_users')->result();
			$this->template->load('main/thm', 'absen/penggajian', $data);
		}
	}
	public function cetak_slip()
	{
		$url = $this->input->get();
		// print_r($url);
		$data['user'] = detail_user($url['iduser']);
		$data['bln'] = getBulan($url['bln']);
		$data['thn'] = $url['thn'];
		$data['perusahaan'] = info()['title'];
		$data['logo'] = info()['favicon'];
		$data['email'] = info()['email'];
		$data['phone'] = info()['phone'];
		$data['alamat'] = (info()['deskripsi']);
		$data['row'] = $this->model_gaji->cek_slip_gaji($url['iduser'], $url['bln'], $url['thn'])->row_array();
		$this->load->view("absen/cetak_slip_gaji", $data);
	}

	public function cetak_pdf()
	{
		$url = $this->input->get();
		// print_r($url);
		$data['user'] = detail_user($url['iduser']);
		$data['bln'] = getBulan($url['bln']);
		$data['thn'] = $url['thn'];
		$data['perusahaan'] = info()['title'];
		$data['logo'] = info()['favicon'];
		$data['email'] = info()['email'];
		$data['phone'] = info()['phone'];
		$data['alamat'] = (info()['deskripsi']);
		$data['row'] = $this->model_gaji->cek_slip_gaji($url['iduser'], $url['bln'], $url['thn'])->row_array();

		$this->load->library('pdf');
		$this->pdf->setPaper('A4', 'potrait');
		$this->pdf->filename = "Slip_Gaji";
		$this->pdf->load_view('absen/cetak_slip_gaji_pdf', $data);
		// $this->load->view("absen/cetak_slip_gaji", $data);
	}
	public function detail_penggajian()
	{
		// print_r($_POST);		
		if ($this->input->post('dari')) {
			$iduser = $this->input->post('user');
			$tglawal = date_slash($this->input->post('dari'));
			$tglakhir = date_slash($this->input->post('sampai'));
			$bln = date('m', strtotime($tglakhir));
			$thn = date('Y', strtotime($tglakhir));

			if ($tglawal == "") {
				$bln = date('m');
				$thn = date('Y');
				$tglawal = $tgl_pertama;
				$tglakhir = $tgl_terakhir;
			}
		} elseif ($this->input->post('user')) {
			$iduser = $this->input->post('user');
			$tglawal = date_slash($this->input->post('dari'));
			$tglakhir = date_slash($this->input->post('sampai'));
			$bln = date('m', strtotime($tglakhir));
			$thn = date('Y', strtotime($tglakhir));
		} else {
			$bln = date('m');
			$thn = date('Y');
			$tglawal = $tgl_pertama;
			$tglakhir = $tgl_terakhir;
		}
		$data['iduser'] = $iduser;
		$data['nama'] = juser($iduser);
		$data['tglawal'] = $tglawal;
		$data['tglakhir'] = $tglakhir;
		$data['hari_kerja'] = $this->model_app->views('pengaturan_presensi')->row()->hari_kerja;

		$data['cekgajipokok'] = $this->model_gaji->getGaji($iduser)->row_array();
		$data['kehadiran'] = $this->model_gaji->kehadiran($iduser, $tglawal, $tglakhir)->result_array();
		$data['cekbonus'] = $this->model_gaji->cekbonus($iduser, $tglawal, $tglakhir)->row();
		$data['uang_makan'] = $this->model_gaji->cek_uang_makan($iduser, $tglawal, $tglakhir)->row();
		$data['uang_transport'] = $this->model_gaji->cek_uang_transport($iduser, $tglawal, $tglakhir)->row();
		$data['row_gaji'] = $this->model_gaji->slip_gaji($iduser, $bln, $thn)->row_array();
		$data['kasbon'] = $this->model_gaji->sum_kasbon($iduser)->row_array();
		$data['detail_kasbon'] = $this->model_gaji->kasbon($iduser, $tglawal, $tglakhir)->result_array();

		$data['cekcuti'] = $this->model_gaji->cekcuti($iduser, $tglawal, $tglakhir)->result_array();
		$data['cekharilibur'] = $this->model_gaji->cekharilibur($tglawal, $tglakhir)->result_array();

		$data['tglakhir'] = $tglakhir;


		$this->load->view("absen/detail_penggajian", $data);
	}

	public function detail_koreksi()
	{
		// print_r($_POST);		
		if ($this->input->post('dari')) {
			$iduser = $this->input->post('user');
			$tglawal = date_slash($this->input->post('dari'));
			$tglakhir = date_slash($this->input->post('sampai'));
			$bln = date('m', strtotime($tglakhir));
			$thn = date('Y', strtotime($tglakhir));

			if ($tglawal == "") {
				$bln = date('m');
				$thn = date('Y');
				$tglawal = $tgl_pertama;
				$tglakhir = $tgl_terakhir;
			}
		} elseif ($this->input->post('user')) {
			$iduser = $this->input->post('user');
			$tglawal = date_slash($this->input->post('dari'));
			$tglakhir = date_slash($this->input->post('sampai'));
			$bln = date('m', strtotime($tglakhir));
			$thn = date('Y', strtotime($tglakhir));
		} else {
			$bln = date('m');
			$thn = date('Y');
			$tglawal = $tgl_pertama;
			$tglakhir = $tgl_terakhir;
		}
		$data['iduser'] = $iduser;
		$data['nama'] = juser($iduser);
		$data['tglawal'] = $tglawal;
		$data['tglakhir'] = $tglakhir;
		$data['hari_kerja'] = $this->model_app->views('pengaturan_presensi')->row()->hari_kerja;

		$data['cekgajipokok'] = $this->model_gaji->getGaji($iduser)->row_array();
		$data['kehadiran'] = $this->model_gaji->kehadiran($iduser, $tglawal, $tglakhir)->result_array();
		$data['cekbonus'] = $this->model_gaji->cekbonus($iduser, $tglawal, $tglakhir)->row();
		$data['row_gaji'] = $this->model_gaji->slip_gaji($iduser, $bln, $thn)->row_array();
		$data['kasbon'] = $this->model_gaji->sum_kasbon($iduser)->row_array();
		$data['detail_kasbon'] = $this->model_gaji->kasbon($iduser, $tglawal, $tglakhir)->result_array();
		$data['cekcuti'] = $this->model_gaji->cekcuti($iduser, $tglawal, $tglakhir)->result_array();
		$data['cekharilibur'] = $this->model_gaji->cekharilibur($tglawal, $tglakhir)->result_array();

		$data['tglakhir'] = $tglakhir;


		$this->load->view("absen/detail_koreksi", $data);
	}
	public function pengaturan()
	{
		$data['title'] = 'Pengaturan | ' . $this->title;
		if ($this->session->level_absen == 'admin' or $this->session->level_absen == 'owner') {
			$data['row'] = $this->model_app->views('pengaturan_presensi')->row_array();
			$this->template->load('main/thm', 'absen/pengaturan', $data);
		}
	}
	public function save_pengaturan()
	{
		$data = [
			'jam_masuk_shift_1' => $this->input->post('jam_masuk_shift_1'),
			'jam_masuk_shift_2' => $this->input->post('jam_masuk_shift_2'),
			'jam_pulang_shift_1' => $this->input->post('jam_pulang_shift_1'),
			'jam_pulang_shift_2' => $this->input->post('jam_pulang_shift_2'),
			'toleransi_shift_1' => $this->input->post('toleransi_shift_1'),
			'toleransi_shift_2' => $this->input->post('toleransi_shift_2'),
			'jumlah_libur' => $this->input->post('jumlah_libur'),
			'hari_kerja' => $this->input->post('hari_kerja'),
		];

		$update = $this->model_app->update('pengaturan_presensi', $data, ["id" => 1]);
		if ($update['status'] == 'ok') {
			$this->session->set_flashdata('message', '<script>notif("Data di simpan","success");</script>');
			redirect('absen/pengaturan');
		} else {
			$this->session->set_flashdata('message', '<script>notif("Data gagal di simpan","danger");</script>');
			redirect('absen/pengaturan');
		}
	}
	public function detail($id = '')
	{
		$data['title'] = 'Detail kehadiran | ' . $this->title;
		$id_user = $this->iduser;
		$data['id'] = $id_user;
		$bulan = month();
		$tahun = year();
		if ($this->session->level_absen == 'admin') {
			$data['user'] = $this->model_app->views("tb_users")->result();
		} else {
			$data['user'] = $this->model_app->view_where("tb_users", ["id_user" => $id_user])->result();
		}
		$data['detail'] = $this->model_app->view_where("absen", ["id_user" => $id_user, "MONTH(tgl)" => $bulan, 'YEAR(tgl)' => $tahun])->result();
		$data['periode'] = date('m/Y');
		$this->template->load('main/thm', 'absen/detail_kehadiran', $data);
	}

	public function ajaxDetail()
	{
		$id_user = $this->input->post('id_user');
		$tanggal = $this->input->post('tanggal');
		$tanggal = date_my($tanggal);

		$data['user'] = $this->model_app->view_where("tb_users", ["id_user" => $id_user])->result();

		$data['detail'] = $this->model_app->view_where("absen", ["id_user" => $id_user, "MONTH(tgl)" => $tanggal['bulan'], 'YEAR(tgl)' => $tanggal['tahun']])->result();
		$this->load->view("absen/load_detail_kehadiran", $data);
	}
	public function save_masuk()
	{
		cek_login_kehadiran(0);
		$id_user = decrypt_url($this->input->post('id'));

		$tgl = date('Y-m-d');
		$query = $this->model_app->view_where("absen", ["id_user" => $id_user, "tgl" => $tgl]);
		if ($query->num_rows() > 0) {
			$rows = $this->model_app->view_where("tb_users", ["id_user" => $id_user])->row_array();
			$data = array('status' => 400, 'msg' => $rows['nama_lengkap'] . ' sudah hadir');
			echo json_encode($data);
			$this->session->unset_userdata('sessiondata');
		} else {
			$sid_baru = generateRandomString(10);

			$data = [
				'id_user' => $id_user,
				'tgl' => $tgl
			];
			$this->db->set('masuk', 'localtimestamp()', FALSE);
			$this->db->set('real_masuk', 'localtimestamp()', FALSE);
			$this->model_app->input('absen', $data);
			$this->model_app->update('absen', ['id_session' => $sid_baru], ["id_user" => $id_user]);
			$this->model_app->update('tb_users', ['id_session' => $sid_baru], ["id_user" => $id_user]);
			$rows = $this->model_app->view_where("tb_users", ["id_user" => $id_user])->row_array();
			$data = array('status' => 200, 'msg' => $rows['nama_lengkap'] . ' sudah hadir');
			$this->output
				->set_content_type("application/json")
				->set_output(json_encode($data));
			$this->session->unset_userdata('sessiondata');
		}
	}

	public function save_pulang()
	{
		cek_login_kehadiran(0);
		$id_user = decrypt_url($this->input->post('id'));

		$tgl = date('Y-m-d');
		$cek_sesi = $this->model_app->pilih_where("nama_lengkap,id_session", "tb_users", ["id_user" => $id_user])->row();
		$query = $this->model_app->view_where("absen", ["id_user" => $id_user, "tgl" => $tgl, "id_session" => $cek_sesi->id_session, 'real_pulang' => NULL]);
		if ($query->num_rows() > 0) {
			$this->db->set('pulang', 'localtimestamp()', FALSE);
			$this->db->set('real_pulang', 'localtimestamp()', FALSE);
			$this->model_app->update('absen', ['id_session' => $cek_sesi->id_session], ["id_user" => $id_user]);
			$data = array('status' => 200, 'msg' => $cek_sesi->nama_lengkap . ' sudah pulang');
			$this->output
				->set_content_type("application/json")
				->set_output(json_encode($data));
			$this->session->unset_userdata('sessiondata');
		} else {
			$data = array('status' => 400, 'msg' => $cek_sesi->nama_lengkap . ' sudah pulang');
			$this->output
				->set_content_type("application/json")
				->set_output(json_encode($data));
			$this->session->unset_userdata('sessiondata');
		}
	}
}
