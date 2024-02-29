<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Post extends CI_Controller
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


	public function crud_gaji()
	{
		$type = $this->input->post('type');
		$iduser = $this->input->post('id');
		if ($type == 'get') {
			$data = $this->model_gaji->getGaji($iduser);
			if ($data->num_rows() > 0) {
				$return = $data->row_array();
				$data = array(
					'id' => $return['id_user'],
					'gajipokok' => $return['gaji_pokok'],
					'makan' => $return['makan'],
					'transport' => $return['transport'],
					'asuransi' => $return['asuransi'],
					'tunjab' => $return['tun_jab'],
					'jamkerja' => $return['jam_kerja'],
					'istirahat' => $return['istirahat']
				);
			} else {
				$data = array(
					'id' => $iduser,
					'gajipokok' => 0,
					'makan' => 0,
					'transport' => 0,
					'asuransi' => 0,
					'tunjab' => 0,
					'jamkerja' => 0,
					'istirahat' => 0
				);
			}
		}
		if ($type == 'edit') {
			$_data = [
				'gaji_pokok'  =>  clean($this->input->post('gaji_pokok')),
				'makan' => clean($this->input->post('makan')),
				'transport' => clean($this->input->post('transport')),
				'tun_jab' => clean($this->input->post('tun_jab')),
				'jam_kerja' => comma_to_dot($this->input->post('jam_kerja')),
				'istirahat' => comma_to_dot($this->input->post('istirahat')),
				'asuransi' => clean($this->input->post('asuransi')),
				'id_user' => $iduser
			];
			// print_r($data);exit;
			$data = $this->model_gaji->getGaji($iduser);
			if ($data->num_rows() > 0) {
				$update = $this->model_app->update('gaji', $_data, ['id_user' => $iduser]);
				if ($update['status'] == 'ok') {
					$data = ['status' => 200, 'msg' => 'sukses'];
				} else {
					$data = ['status' => 400, 'msg' => 'gagal'];
				}
			} else {
				$input = $this->model_app->input('gaji', $_data);
				if ($input['status'] == 'ok') {
					$data = ['status' => 200, 'msg' => 'sukses'];
				} else {
					$data = ['status' => 400, 'msg' => 'gagal'];
				}
			}
		}

		$this->output
			->set_content_type("application/json")
			->set_output(json_encode($data));
	}

	public function crud_bonus()
	{
		// print_r($_POST);exit;
		$type = $this->input->post('type');
		$iduser = $this->input->post('id');
		$dari = $this->input->post('tgl1');
		$sampai = $this->input->post('tgl2');

		if ($type == 'get') {

			$sql = $this->model_gaji->cekbonus($iduser, $dari, $sampai);
			if ($sql->num_rows() > 0) {
				$return = $sql->row_array();
				$data = array(
					'iduser' => $return['id_user'],
					'ketbonus' => $return['keterangan'],
					'bonusb' => $return['bonus'],
					'tgl1' => $dari,
					'tgl2' => $sampai
				);
			} else {
				$data = array(
					'iduser' => $iduser,
					'ketbonus' => '',
					'bonusb' => 0,
					'tgl1' => $dari,
					'tgl2' => $sampai
				);
			}
		}
		if ($type == 'edit') {
			$_data = [
				'id_user'  =>  $this->input->post('id'),
				'keterangan' => $this->input->post('ket_bonus'),
				'bonus' => clean($this->input->post('bonus_bonus')),
				'tgl' => day_ymd()
			];

			$sql = $this->model_gaji->cekbonus($iduser, $dari, $sampai);
			if ($sql->num_rows() > 0) {
				$update = $this->model_app->update('bonus', $_data, ['id_user' => $iduser]);
				if ($update['status'] == 'ok') {
					$data = ['status' => 200, 'msg' => 'sukses'];
				} else {
					$data = ['status' => 400, 'msg' => 'gagal'];
				}
			} else {
				$input = $this->model_app->input('bonus', $_data);
				if ($input['status'] == 'ok') {
					$data = ['status' => 200, 'msg' => 'sukses'];
				} else {
					$data = ['status' => 400, 'msg' => 'gagal'];
				}
			}
		}

		$this->output
			->set_content_type("application/json")
			->set_output(json_encode($data));
	}

	public function crud_uang_makan()
	{
		// print_r($_POST);exit;
		$type = $this->input->post('type');
		$iduser = $this->input->post('id');
		$dari = $this->input->post('tgl1');
		$sampai = $this->input->post('tgl2');

		if ($type == 'get') {

			$sql = $this->model_gaji->cek_uang_makan($iduser, $dari, $sampai);
			if ($sql->num_rows() > 0) {
				$return = $sql->row_array();
				$data = array(
					'iduser' => $return['id_user'],
					'jumlah' => $return['jumlah'],
					'dari' => $dari,
					'sampai' => $sampai
				);
			} else {
				$data = array(
					'iduser' => $iduser,
					'jumlah' => 0,
					'dari' => $dari,
					'sampai' => $sampai
				);
			}
		}
		if ($type == 'edit') {
			$_data = [
				'id_user'  =>  $this->input->post('id'),
				'jumlah' => clean($this->input->post('jumlah_uang_makan_diambil')),
				'tanggal' => day_ymd()
			];

			$sql = $this->model_gaji->cek_uang_makan($iduser, $dari, $sampai);
			if ($sql->num_rows() > 0) {
				$update = $this->model_app->update('uang_makan', $_data, ['id_user' => $iduser]);
				if ($update['status'] == 'ok') {
					$data = ['status' => 200, 'msg' => 'sukses'];
				} else {
					$data = ['status' => 400, 'msg' => 'gagal'];
				}
			} else {
				$input = $this->model_app->input('uang_makan', $_data);
				if ($input['status'] == 'ok') {
					$data = ['status' => 200, 'msg' => 'sukses'];
				} else {
					$data = ['status' => 400, 'msg' => 'gagal'];
				}
			}
		}

		$this->output
			->set_content_type("application/json")
			->set_output(json_encode($data));
	}

	public function crud_uang_transport()
	{
		// print_r($_POST);exit;
		$type = $this->input->post('type');
		$iduser = $this->input->post('id');
		$dari = $this->input->post('tgl1');
		$sampai = $this->input->post('tgl2');

		if ($type == 'get') {

			$sql = $this->model_gaji->cek_uang_transport($iduser, $dari, $sampai);
			if ($sql->num_rows() > 0) {
				$return = $sql->row_array();
				$data = array(
					'iduser' => $return['id_user'],
					'jumlah' => $return['jumlah'],
					'dari' => $dari,
					'sampai' => $sampai
				);
			} else {
				$data = array(
					'iduser' => $iduser,
					'jumlah' => 0,
					'dari' => $dari,
					'sampai' => $sampai
				);
			}
		}
		if ($type == 'edit') {
			$_data = [
				'id_user'  =>  $this->input->post('id'),
				'jumlah' => clean($this->input->post('jumlah_uang_transport_diambil')),
				'tanggal' => day_ymd()
			];

			$sql = $this->model_gaji->cek_uang_transport($iduser, $dari, $sampai);
			if ($sql->num_rows() > 0) {
				$update = $this->model_app->update('uang_transport', $_data, ['id_user' => $iduser]);
				if ($update['status'] == 'ok') {
					$data = ['status' => 200, 'msg' => 'sukses'];
				} else {
					$data = ['status' => 400, 'msg' => 'gagal'];
				}
			} else {
				$input = $this->model_app->input('uang_transport', $_data);
				if ($input['status'] == 'ok') {
					$data = ['status' => 200, 'msg' => 'sukses'];
				} else {
					$data = ['status' => 400, 'msg' => 'gagal'];
				}
			}
		}

		$this->output
			->set_content_type("application/json")
			->set_output(json_encode($data));
	}
	public function crud_kasbon()
	{
		// print_r($_POST);exit;
		$type = $this->input->post('type');
		$iduser = $this->input->post('id');
		$dari = $this->input->post('tgl1');
		$sampai = $this->input->post('tgl2');

		if ($type == 'get') {

			$sql = $this->model_gaji->sum_where_kasbon($iduser, $dari, $sampai);
			if ($sql->num_rows() > 0) {
				$return = $sql->row_array();
				$data = array(
					'iduser' => $return['id_pegawai'],
					'jumlah' => $return['kredit'],
					'dari' => $dari,
					'sampai' => $sampai
				);
			} else {
				$data = array(
					'iduser' => $iduser,
					'jumlah' => 0,
					'dari' => $dari,
					'sampai' => $sampai
				);
			}
		}
		// print_r($_POST);exit;
		if ($type == 'edit') {
			$_data = [
				'id_pegawai'  =>  $this->input->post('id'),
				'bayar' => clean($this->input->post('jml_bayar_kasbon')),
				'tgl_kasbon' => day_ymd(),
				'jenis_kasbon' => 'Bayar',
				'status_bayar' => 1
			];
			$data = ['status' => 400, 'msg' => 'gagal'];
			$jumlah = clean($this->input->post('jml_bayar_kasbon'));
			if ($jumlah > 0) {
				$sql = $this->model_gaji->cek_bayar_kasbon($iduser, $dari, $sampai);
				$this->model_app->hapus('kasbon', ['id_pegawai' => $iduser, 'status_bayar' => 1]);
				if ($sql->num_rows() == 0) {
					$input = $this->model_app->input('kasbon', $_data);
					if ($input['status'] == 'ok') {
						$data = ['status' => 200, 'msg' => 'sukses'];
					} else {
						$data = ['status' => 400, 'msg' => 'gagal'];
					}
				}
			}
		}

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
		$data['user'] = $this->model_app->views('tb_users')->result();
		$this->template->load('main/thm', 'absen/penggajian', $data);
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

		$data['cekgajipokok'] = $this->model_data->cekgajipokok($iduser);
		$data['kehadiran'] = $this->model_data->kehadiran($iduser, $tglawal, $tglakhir)->result_array();

		$data['tglakhir'] = $tglakhir;


		$this->load->view("absen/detail_penggajian", $data);
	}
	public function pengaturan()
	{
		$data['title'] = 'Pengaturan | ' . $this->title;
		$data['row'] = $this->model_app->views('pengaturan_presensi')->row_array();
		$this->template->load('main/thm', 'absen/pengaturan', $data);
	}
	public function save_pengaturan()
	{

		$data = [
			'jam_masuk' => $this->input->post('jam_masuk'),
			'jam_pulang' => $this->input->post('jam_pulang'),
			'jam_masuk_weekend' => $this->input->post('jam_masuk_weekend'),
			'jam_pulang_weekend' => $this->input->post('jam_pulang_weekend'),
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

	public function tambah_data()
	{
		$user = $this->input->post('user');
		$tanggal = date_slash($this->input->post('tanggal'));

		$data = ['id_user' => $user, 'tgl' => $tanggal];
		$cek = $this->model_app->view_where('absen', ['id_user' => $user, 'tgl' => $tanggal]);
		if ($cek->num_rows() > 0) {
			$data = ['status' => 400, 'msg' => 'Tanggal sudah ada'];
		} else {
			$input = $this->model_app->input('absen', $data);
			if ($input['status'] == 'ok') {
				$data = ['status' => 200, 'msg' => 'sukses'];
			} else {
				$data = ['status' => 400, 'msg' => 'gagal'];
			}
		}
		$this->output
			->set_content_type("application/json")
			->set_output(json_encode($data));
	}
	public function detail($id = '')
	{
		$data['title'] = 'Detail kehadiran | ' . $this->title;
		$id_user = decrypt_url($id);
		$data['id'] = $id_user;
		if ($this->input->post()) {
			$bulan = $this->input->post('bulan');
			$tahun = $this->input->post('tahun');
		} else {
			$bulan = month();
			$tahun = year();
		}
		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;
		$data['year'] = $this->model_jurnal->getAbsenByYear();
		$data['detail'] = $this->model_app->view_where("absen", ["id_user" => $id_user, "MONTH(tgl)" => $bulan, 'YEAR(tgl)' => $tahun])->result();
		$this->template->load('main/thm', 'absen/detail_kehadiran', $data);
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
			// $this->session->unset_userdata('sessiondata');
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

			$data = array('status' => 200, 'msg' => $rows['nama_lengkap'] . ' sudah hadir');
			$this->output
				->set_content_type("application/json")
				->set_output(json_encode($data));
			// $this->session->unset_userdata('sessiondata');

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
			// $this->session->unset_userdata('sessiondata');
		} else {
			$data = array('status' => 400, 'msg' => $cek_sesi->nama_lengkap . ' sudah pulang');
			$this->output
				->set_content_type("application/json")
				->set_output(json_encode($data));
			// $this->session->unset_userdata('sessiondata');

		}
	}
	public function crud_cuti()
	{
		$id = $this->input->post('id');
		$action_type = $this->input->post('action_type');
		$iduser = $this->input->post('iduser');
		$tgl_awal = ($this->input->post('tgla'));
		$tgl_akhir = ($this->input->post('tglak'));
		$keterangan = ($this->input->post('keterangan'));
		if ($action_type == 'add') {
			$tgl = date_slash($this->input->post('tgl'));
			$countcuti = $this->model_gaji->countcuti($iduser, $tgl_awal, $tgl_akhir);
			$data = [
				'id_user' => $iduser,
				'tgl' => $tgl,
				'keterangan' => $keterangan,
			];
			$input = $this->model_app->input('izin', $data);
			if ($input['status'] == 'ok') {
				$arr = ['status' => 200, 'jml' => $countcuti];
			} else {
				$arr = ['status' => 400, 'jml' => $countcuti];
			}
		}
		if ($action_type == 'data') {
			$return = $this->model_app->view_where('izin', ['id' => $id])->row_array();
			$arr = array(
				'id' => $return['id'],
				'iduser' => $return['id_user'],
				'tgl' => tgl_ambil($return['tgl']),
				'keterangan' => $return['keterangan']
			);
		}

		if ($action_type == 'edit') {
			if (empty($this->input->post('tgl')) || empty($keterangan)) {
				$arr = ['status' => 'gagal', 'msg' => 'Form Harus diisi'];
			} else {
				$tgl = date_slash($this->input->post('tgl'));
				$countcuti = $this->model_gaji->countcuti($iduser, $tgl_awal, $tgl_akhir);
				$data = [
					'id_user' => $iduser,
					'tgl' => $tgl,
					'keterangan' => $keterangan,
				];
				$update = $this->model_app->update('izin', $data, ['id' => $id]);
				if ($update['status'] == 'ok') {
					$arr = ['status' => 200, 'jml' => $countcuti];
				} else {
					$arr = ['status' => 400, 'jml' => $countcuti];
				}
			}
		}

		if ($action_type == 'delete') {
			// print_r($_POST);exit;

			$delete = $this->model_app->hapus('izin', ['id' => $id]);
			if ($delete['status'] == 'ok') {
				$arr = ['status' => 200, 'jml' => 0];
			} else {
				$arr = ['status' => 400, 'jml' => 0];
			}
		}
		// exit;
		$this->output
			->set_content_type("application/json")
			->set_output(json_encode($arr));
	}

	public function crud_libur()
	{
		// print_r($_POST);exit;
		$id = $this->input->post('id');
		$action_type = $this->input->post('action_type');
		$keterangan = ($this->input->post('keterangan'));
		if ($action_type == 'add') {
			$tgl = date_slash($this->input->post('tgl'));
			$data = [
				'tgl' => $tgl,
				'keterangan' => $keterangan,
			];
			$input = $this->model_app->input('hari_libur', $data);
			if ($input['status'] == 'ok') {
				$arr = ['status' => 200, 'msg' => 'Data berhasil disimpan'];
			} else {
				$arr = ['status' => 400, 'msg' => 'Data gagal disimpan'];
			}
		}
		if ($action_type == 'data') {
			$return = $this->model_app->view_where('hari_libur', ['id' => $id])->row_array();
			$arr = array(
				'id' => $return['id'],
				'tgl' => tgl_ambil($return['tgl']),
				'keterangan' => $return['keterangan']
			);
		}

		if ($action_type == 'edit') {
			if (empty($this->input->post('tgl')) || empty($keterangan)) {
				$arr = ['status' => 'gagal', 'msg' => 'Form Harus diisi'];
			} else {
				$tgl = date_slash($this->input->post('tgl'));

				$data = [
					'tgl' => $tgl,
					'keterangan' => $keterangan,
				];
				$update = $this->model_app->update('hari_libur', $data, ['id' => $id]);
				if ($update['status'] == 'ok') {
					$arr = ['status' => 200, 'msg' => 'Data berhasil update'];
				} else {
					$arr = ['status' => 400, 'msg' => 'Data gagal update'];
				}
			}
		}

		if ($action_type == 'delete') {

			$delete = $this->model_app->hapus('hari_libur', ['id' => $id]);
			if ($delete['status'] == 'ok') {
				$arr = ['status' => 200, 'msg' => 'Data berhasil hapus'];
			} else {
				$arr = ['status' => 400, 'msg' => 'Data gagal hapus'];
			}
		}
		// exit;
		$this->output
			->set_content_type("application/json")
			->set_output(json_encode($arr));
	}

	public function rekap()
	{
		// print_r($_POST);exit;
		$iduser = $this->input->post('iduser');
		$tanggal = $this->input->post('tglakhir');
		$bln = getMonth($tanggal);
		$thn = getYear($tanggal);
		if ($this->input->post()) {
			$row_gaji = $this->model_gaji->slip_gaji($iduser, $bln, $thn);

			$data = [
				'id_user'      => $this->input->post('iduser'),
				'tgl_rekap'    => date('Y-m-d'),
				'bulan_gaji'   => $bln,
				'tahun_gaji'   => $thn,
				'gaji_pokok'   => rp_to_int($this->input->post('gaji_pokok')),
				'tun_jab'      => rp_to_int($this->input->post('tun_jab')),
				'transport'    => rp_to_int($this->input->post('transport')),
				'makan'        => rp_to_int($this->input->post('makan')),
				'asuransi'     => rp_to_int($this->input->post('asuransi')),
				'jam_kerja'    => ($this->input->post('jam_kerja')),
				'istirahat'    => ($this->input->post('istirahat')),
				'jml_kerja'    => ($this->input->post('jmlhari')),
				'jml_cuti'     => ($this->input->post('jmlharicuti')),
				'jml_libur'    => ($this->input->post('jmlharilibur')),
				'gaji_kotor'   => rp_to_int($this->input->post('gaji_kotor')),
				'lembur'       => rp_to_int($this->input->post('total_lembur')),
				'tot_makan'    => rp_to_int($this->input->post('tot_makan')),
				'tot_transport' => rp_to_int($this->input->post('tot_transport')),
				'tot_tun_cuti' => rp_to_int($this->input->post('tot_tun_cuti')),
				'tot_tun_libur' => rp_to_int($this->input->post('tot_tun_libur')),
				'tot_tun_jab'  => rp_to_int($this->input->post('tot_tun_jab')),
				'tot_bonus'    => rp_to_int($this->input->post('bonus')),
				'pot_absen'    => rp_to_int($this->input->post('pot_absen')),
				'pot_asuransi' => rp_to_int($this->input->post('pot_asuransi')),
				'pot_kasbon'   => rp_to_int($this->input->post('pot_kasbon')),
				'uang_makan_diambil'   => rp_to_int($this->input->post('uang_makan')),
				'uang_trans_diambil'   => rp_to_int($this->input->post('uang_transport'))
			];
			//update
			if ($row_gaji->num_rows() > 0) {
				$update = $this->model_app->update('slip_gaji', $data, ['id_user' => $iduser, 'bulan_gaji' => $bln, 'tahun_gaji' => $thn]);
				if ($update['status'] == 'ok') {
					$arr = ['status' => 200, 'msg' => 'Data berhasil update'];
				} else {
					$arr = ['status' => 400, 'msg' => 'Data gagal update'];
				}
				//input
			} else {
				$input = $this->model_app->input('slip_gaji', $data);
				if ($input['status'] == 'ok') {
					$arr = ['status' => 200, 'msg' => 'Data berhasil rekap'];
				} else {
					$arr = ['status' => 400, 'msg' => 'Data gagal rekap'];
				}
			}
		} else {
			$arr = ['status' => 400, 'msg' => 'Data gagal'];
		}
		$this->output
			->set_content_type("application/json")
			->set_output(json_encode($arr));
	}
	public function cek_rekap()
	{
		$iduser = $this->input->post('iduser');
		$tanggal = $this->input->post('tglakhir');
		$getMonth = getMonth($tanggal);
		$getYear = getYear($tanggal);

		$cek = $this->model_gaji->slip_gaji($iduser, $getMonth, $getYear);
		if ($cek->num_rows() > 0) {
			$rekap = ['status' => 200, 'msg' => 'Y', 'judul' => 'Sudah di rekap'];
		} else {
			$rekap = ['status' => 200, 'msg' => 'N', 'judul' => 'Belum di rekap'];
		}
		$this->output
			->set_content_type("application/json")
			->set_output(json_encode($rekap));
	}

	public function update_jam_masuk()
	{
		$iduser    = $this->input->post('user');
		$tglawal   = date_slash($this->input->post('dari'));
		$tglakhir  = date_slash($this->input->post('sampai'));
		$setting   = $this->model_app->views('pengaturan_presensi')->row();
		$koreksi   = $this->model_gaji->kehadiran($iduser, $tglawal, $tglakhir)->result_array();

		foreach ($koreksi as $row) {

			$id   = $row['ID'];
			$tanggal_jam_masuk = date('Y-m-d', strtotime($row['real_masuk']));
			$real_masuk  = date('H:i', strtotime($row['real_masuk']));
			//shift 1
			$jam_masuk_shift_1 = ($setting->jam_masuk_shift_1);
			$toleransi_shift_1 = ($setting->toleransi_shift_1);
			//shift 2
			$jam_masuk_shift_2 = ($setting->jam_masuk_shift_2);
			$toleransi_shift_2 = ($setting->toleransi_shift_2);
			$batas_awal_shift2 = '11:00';
			if ($real_masuk < date('H:i', strtotime($jam_masuk_shift_1))) {
				$jam_masuk = $jam_masuk_shift_1;
				$arr[] = 1;
			} else if ($real_masuk > date('H:i', strtotime($jam_masuk_shift_1))  and ($real_masuk <= date('H:i', strtotime($toleransi_shift_1)))) {
				$jam_masuk = $setting->jam_masuk_shift_1;
				$arr[] = 2;
			} elseif ($real_masuk > date('H:i', strtotime($batas_awal_shift2))  and $real_masuk <= date('H:i', strtotime($toleransi_shift_2))) {
				$jam_masuk = $setting->jam_masuk_shift_2;
				$arr[] = 3;
			} else {
				$jam_masuk = $real_masuk;
				$arr[] = 5;
			}
			// dump($arr);
			$masuk = $tanggal_jam_masuk . " " . $jam_masuk . ":00";

			if ($row['real_masuk'] != "") {
				$this->model_app->update("absen", ["masuk" => $masuk], ["ID" => $id]);
			}

			$arr = ['status' => 200, 'msg' => 'Berhasil disimpan'];
			$this->output
				->set_content_type("application/json")
				->set_output(json_encode($arr));
		}
	}

	public function update_jam_pulang()
	{
		$iduser    = $this->input->post('user');
		$tglawal   = date_slash($this->input->post('dari'));
		$tglakhir  = date_slash($this->input->post('sampai'));

		$setting   = $this->model_app->views('pengaturan_presensi')->row();
		$jam_kerja = $this->model_gaji->getGaji($iduser)->row()->jam_kerja;

		$koreksi   = $this->model_gaji->kehadiran($iduser, $tglawal, $tglakhir)->result_array();
		$no = 1;
		foreach ($koreksi as $row) {

			$lembur = $row['lembur'];
			$id     = $row['ID'];
			$tanggal_jam_pulang   = date('Y-m-d', strtotime($row['real_pulang']));
			$real_masuk    = date('H:i', strtotime($row['real_masuk']));
			$real_pulang    = date('H:i', strtotime($row['real_pulang']));

			$awal  = strtotime($row['real_masuk']);
			$akhir = strtotime($row['real_pulang']);
			$diff  = $akhir - $awal;

			$jumlah_jam_kerja = floor($diff / (60 * 60)) - 1;

			$detik_jam_masuk  = date('i', strtotime($row['real_masuk']));
			$detik_jam_pulang = date('i', strtotime($row['real_pulang']));



			$batas_pulang1 = '18:00';
			$batas_pulang2 = '20:40';

			$jam_masuk_shift_2    = date('H:i', strtotime($setting->jam_masuk_shift_2));
			$pulang_shift1    = date('H:i', strtotime($setting->jam_pulang_shift_1));
			$pulang_shift2    = date('H:i', strtotime($setting->jam_pulang_shift_2));
			$toleransi_shift1 = date('H:i', strtotime($setting->toleransi_shift_1));
			$toleransi_shift2 = date('H:i', strtotime($setting->toleransi_shift_2));

			//pulang shift 1 set ke pukul 17:00
			if ($jumlah_jam_kerja >= $jam_kerja  and $real_pulang < $pulang_shift1) {
				$jam_pulang = $setting->jam_pulang_shift_1;
				$arr['a'] = 1;
				//pulang shit 1
			} elseif ($jumlah_jam_kerja >= $jam_kerja and $real_pulang > $pulang_shift1 and $real_pulang < date('H:i', strtotime($batas_pulang1))) {
				$jam_pulang = $setting->jam_pulang_shift_1;
				$arr['a'] = 2;
			} elseif ($jumlah_jam_kerja >= $jam_kerja and $real_pulang < $pulang_shift2) {
				$arr['a'] = 3;
				$jam_pulang = $real_pulang;
			} elseif ($jumlah_jam_kerja >= $jam_kerja and $real_pulang > $pulang_shift2 and $lembur == 0) {
				$arr['a'] = 4;
				$jam_pulang = $setting->jam_pulang_shift_2;
			} else {
				$arr['a'] = 5;
				$jam_pulang = $real_pulang;
			}
			// dump($arr);
			$pulang = $tanggal_jam_pulang . " " . $jam_pulang . ":00";
			if ($row['real_pulang'] != "") {
				$this->model_app->update("absen", ["pulang" => $pulang], ["ID" => $id]);
			}

			$arr = ['status' => 200, 'msg' => 'Berhasil disimpan'];

			$this->output
				->set_content_type("application/json")
				->set_output(json_encode($arr));
		}
	}

	public function save_koreksi()
	{
		$id = $this->input->post('id');
		$type = $this->input->post('type');
		if ($type == 'tanggal') {
			$tgl = date_slash($this->input->post('tgl'));
			$update = $this->model_app->update('absen', ['tgl' => $tgl], ['ID' => $id]);
		}

		if ($type == 'tgl_masuk') {
			$tgl = tgl_koreksi($this->input->post('tgl'));
			$update = $this->model_app->update('absen', ['masuk' => $tgl], ['ID' => $id]);
		}

		if ($type == 'tgl_pulang') {
			$tgl = tgl_koreksi($this->input->post('tgl'));
			$update = $this->model_app->update('absen', ['pulang' => $tgl], ['ID' => $id]);
		}

		if ($type == 'lembur') {
			$lembur = $this->input->post('lembur');
			$update = $this->model_app->update('absen', ['lembur' => $lembur], ['ID' => $id]);
		}

		// dump($_POST);
		// exit; 

		if ($update['status'] == 'ok') {
			$arr = ['status' => 200, 'msg' => 'Berhasil disimpan'];
		} else {
			$arr = ['status' => 400, 'msg' => 'Gagal disimpan'];
		}
		$this->output
			->set_content_type("application/json")
			->set_output(json_encode($arr));
	}
}
