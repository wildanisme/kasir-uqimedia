<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Curl\Curl;

class Promo extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		cek_session_login();
		$this->load->model("model_promo");
		$this->perPage = 10;
		$this->iduser = $this->session->idu;
		$this->title = info()['title'];
		$this->curl = new Curl();
	}

	public function panel()
	{
		cek_menu_akses();
		cek_crud_akses(8);
		$data['title'] = 'Kirim Promo| ' . $this->title;
		$data['promo'] = $this->model_promo->get_promo();
		$data['label'] = $this->model_promo->get_label();
		$data['device'] = get_device();
		// $data['status'] = $this->cek_status();
		$this->template->load('main/themes', 'promo/kirim_promo', $data);
	}

	/**
	 * load_device
	 *
	 * @param  mixed $param
	 * @return void
	 */
	public function load_device()
	{
		$load = $this->model_app->views('device')->result();
		foreach ($load as $row) {
			$response[] = array("id" => encrypt_url($row->token), "name" => $row->device);
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
	}

	public function report()
	{
		cek_menu_akses();
		cek_crud_akses(8);
		$data['title'] = 'Report Promo| ' . $this->title;
		$this->template->load('main/themes', 'promo/report', $data);
	}

	public function ajaxReport()
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
		$keywords = $this->input->post('keywords');
		$sortBy = $this->input->post('sortBy');
		if (!empty($keywords)) {
			$conditions['search']['keywords'] = $keywords;
		}
		if (!empty($sortBy)) {
			$conditions['search']['sortBy'] = $sortBy;
		}

		$conditions['returnType'] = 'count';
		$totalRec = $this->model_promo->getReport($conditions);

		// Pagination configuration 
		$config['target']      = '#data_report';
		$config['base_url']    = base_url('promo/ajaxReport');
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $limit;
		$config['link_func']   = 'search_LaporanGrup';

		// Initialize pagination library 
		$this->ajax_pagination->initialize($config);
		// Get records 
		$conditions['start'] = $offset;
		$conditions['limit'] = $limit;
		unset($conditions['returnType']);

		$data['result'] = $this->model_promo->getReport($conditions);
		// dump($data['result']);
		$this->load->view('promo/ajax-report', $data, false);
	}

	public function hapus_report()
	{
		$id = decrypt_url($this->input->post('id'));
		$konsumen = decrypt_url($this->input->post('konsumen'));

		$delete = $this->model_promo->delete_report($id, $konsumen);

		if ($delete == true) {
			$result = array('status' => 200, 'msg' => 'Data berhasil dihapus');
		} else {
			$result = array('status' => 400, 'msg' => 'Data gagal dihapus');
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($result));
	}

	public function cek_status()
	{
		$token = decrypt_url($this->input->post('token'));
		$result = $this->fonnte('https://api.fonnte.com/device', $token);
		if ($result['status'] == true) {
			if ($result['msg']->status == true) {
				$data = $result['msg'];
			} else {
				$data = $result['msg'];
			}
		}
		if ($result['status'] == false) {
			$data = ['status' => false, 'msg' => $result['msg']];
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	public function template()
	{
		cek_crud_akses(8);
		$data['title'] = 'Template promo | ' . $this->title;
		$this->template->load('main/themes', 'promo/template', $data);
		$this->load->view('promo/media');
	}

	public function data_template()
	{
		cek_crud_akses(8);
		$data['record'] = $this->model_app->view_where_ordering('template_promo', array(), 'id', 'DESC')->result();
		$this->load->view('promo/data_template', $data);
	}

	public function get_template()
	{

		if ($this->input->is_ajax_request()) {
			cek_crud_akses(8, 'json');
			$id = $this->db->escape_str($this->input->post('id'));

			if ($id > 0) {
				$row = $this->model_app->view_where('template_promo', ['id' => $id])->row();

				$result = [
					'status' => true,
					'id' => $id,
					'title' => $row->title,
					'deskripsi' => $row->deskripsi,
					'status_pesan' => $row->status,
					'jenis_pesan' => $row->jenis_pesan,
					'publish' => $row->active,
					'msg' => '',
					'readonly' => false,
					'disabled' => false
				];
			} else {

				$result = [
					'status' => true,
					'id' => 0,
					'title' => '',
					'deskripsi' => '',
					'status_pesan' => 0,
					'jenis_pesan' => 0,
					'publish' => 'Y',
					'modal_title' => 'Form Input Demo Only',
					'msg' => '',
					'readonly' => false,
					'disabled' => false
				];
			}
		} else {
			$result = ['status' => false];
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($result));
	}


	public function save_template()
	{
		if ($this->input->is_ajax_request()) {
			$id = $this->db->escape_str($this->input->post('id'));
			$type = $this->db->escape_str($this->input->post('type'));
			$title = $this->db->escape_str($this->input->post('title'));
			$deskripsi = $this->input->post('deskripsi');
			$active = $this->input->post('publish');
			$status = $this->input->post('status');
			$jenis_pesan = $this->input->post('jenis_pesan');

			$this->form_validation->set_rules(array(array(
				'field' => 'title',
				'label' => 'Title',
				'rules' => 'required|trim',
				'errors' => array(
					'required' => '%s. Harus di isi'
				)
			)));

			$this->form_validation->set_rules(array(array(
				'field' => 'deskripsi',
				'label' => 'Deskripsi',
				'rules' => 'required|trim',
				'errors' => array(
					'required' => '%s. Harus di isi'
				)
			)));

			if ($this->form_validation->run()) {
				if ($jenis_pesan == 1) {
					$media = $this->input->post('media');
					$a = explode('/', $media);
					$filename = $a[count($a) - 1];
					$a2 = explode('.', $filename);
					$namefile = $a2[count($a2) - 2];
					$filetype = $a2[count($a2) - 1];
					$getstorage = $this->db->get_where('storage', ['namafile' => $filename])->row();
					$filename = $getstorage->nama_original;
				} else {
					$media = '';
					$filename = '';
					$filetype = '';
				}

				if ($type == 'add') {
					simpan_demo('Simpan');
					cek_crud_akses(7, 'json');
					$param = [
						'title' => $title,
						'deskripsi' => $deskripsi,
						'status' => $status,
						'jenis_pesan' => $jenis_pesan,
						'active' => $active,
						'url' => $media,
						'filename' => $filename,
						'filetype' => $filetype,
						'create_date' => today()
					];

					$input =  $this->model_app->input('template_promo', $param);
					if ($input['status'] == 'ok') {
						$result = array('status' => 200, 'msg' => 'Data berhasil diinput');
					} else {
						$result = array('status' => false);
					}
				}
				if ($type == 'edit'  and $id > 0) {
					simpan_demo('Simpan');
					cek_crud_akses(9, 'json');

					$param = [
						'title' => $title,
						'deskripsi' => $deskripsi,
						'status' => $status,
						'jenis_pesan' => $jenis_pesan,
						'active' => $active,
						'url' => $media,
						'filename' => $filename,
						'filetype' => $filetype
					];

					$update = $this->model_app->update('template_promo', $param, ['id' => $id]);
					if ($update['status'] == 'ok') {
						$result = ['status' => 200, 'msg' => 'Berhasil'];
					} else {
						$result = ['status' => false, 'msg' => 'Gagal'];
					}
				}
			} else {

				$result['status'] = 'error';
				$result['alert']['type'] = 'error';
				$result['alert']['content'] = validation_errors();
			}
			if ($type == 'hapus' and $id > 0) {
				simpan_demo('Hapus');
				cek_crud_akses(10, 'json'); //delete
				$cek = $this->model_app->view_where('template_promo', array('id' => $id));
				if ($cek->num_rows() > 0) {
					$res = $this->model_app->hapus('template_promo', array('id' => $id));
					if ($res['status'] == 'ok') {
						$result = array('status' => 200, 'msg' => 'Data berhasil dihapus');
					} else {
						$result = array('status' => 400, 'msg' => 'Data gagal dihapus');
					}
				} else {
					$result = array('status' => 400, 'msg' => 'Data tidak ditemukan');
				}
			}
		} else {
			$result = ['status' => false];
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($result));
	}

	private function fonnte($url, $token)
	{
		$this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
		$this->curl->setDefaultJsonDecoder($assoc = true);
		$this->curl->setHeader('Authorization', $token);
		$this->curl->setHeader('Content-Type', 'application/json');
		$this->curl->post($url);
		if ($this->curl->error) {
			$result = ['status' => false, 'msg' => $this->curl->errorMessage];
		} else {
			$result = ['status' => true, 'msg' => (object)$this->curl->response];
		}
		return $result;
	}

	public function cek_paket()
	{
		$token = decrypt_url($this->input->post('token'));
		$result = $this->fonnte('https://api.fonnte.com/device', $token);
		if ($result['status'] == true) {
			if ($result['msg']->status == true) {
				$data = $result['msg'];
			} else {
				$data = $result['msg'];
			}
		}
		if ($result['status'] == false) {
			$data = ['status' => false, 'msg' => $result['msg']];
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	public function cek_label()
	{
		$id = $this->db->escape_str($this->input->post('id'));
		if ($id == 1) {
			$where = ['kunci' => 0];
		} else {
			$where = ['panggilan' => $id, 'kunci' => 0];
		}
		$data = $this->model_promo->total_label($where);

		$response = ['status' => true, 'total' => $data];

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
	}

	public function cek_nomor()
	{
		simpan_demo('Simpan');
		$promo = $this->db->escape_str($this->input->post('promo'));
		$label = $this->db->escape_str($this->input->post('label'));

		if ($label == 1) {
			$where = ['kunci' => 0];
		} else {
			$where = ['panggilan' => $label, 'kunci' => 0];
		}
		$total = $this->model_promo->total_label($where);
		if ($total > 0) {
			$data = $this->model_promo->cek_nomor_bylabel($where);
			$pesan = $this->model_promo->get_promo_byid($promo);


			if ($pesan->jenis_pesan == 0) {
				$response = [
					'status' => true,
					'id' => $data->id,
					'name' => $data->nama,
					'number' => $data->no_hp,
					'title' => $pesan->title,
					'message' => '',
					'url' => '',
					'filename' => '',
					'filetype' => ''
				];
			} else {
				$response = [
					'status' => true,
					'id' => $data->id,
					'name' => $data->nama,
					'number' => $data->no_hp,
					'title' => $pesan->title,
					'message' => '',
					'url' => $pesan->url,
					'filename' => $pesan->filename,
					'filetype' => $pesan->filetype
				];
			}
		} else {
			$response = [
				'status' => false,
				'msg' => 'Nomor tidak ditemukan'
			];
		}

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
	}

	public function cek_contoh()
	{
		simpan_demo('Simpan');
		$id = $this->db->escape_str($this->input->post('id'));

		$pesan = $this->model_promo->get_promo_byid($id);

		$nama = 'Jhon';
		$panggilan = 'Mas';

		$searchVal = array(
			"{perusahaan}",
			"{web}",
			"{selamat}",
			"{hp}",
			"{email}",
			"{alamat}",
			"{nama}",
			"{panggilan}"
		);

		// Array containing replace string from  search string
		$replaceVal = array(
			info()['perusahaan'],
			base_url(),
			ucapan(),
			hp62(info()['phone']),
			info()['email'],
			strip_word_html(base64_decode(info()['deskripsi'])),
			$nama,
			$panggilan
		);
		$msg = str_replace($searchVal, $replaceVal, $pesan->deskripsi);
		$response = [
			'status' => true,
			'name' => $nama,
			'number' => info()['phone'],
			'title' => $pesan->title,
			'message' => $msg,
			'url' => '',
			'filename' => '',
			'filetype' => ''
		];


		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
	}

	public function kirim_pesan()
	{
		simpan_demo('Simpan');
		$token = decrypt_url($this->input->post('device'));
		$format_pesan = $this->db->escape_str($this->input->post('format_pesan'));
		$promo = $this->db->escape_str($this->input->post('promo'));
		$delay = $this->db->escape_str($this->input->post('delay'));

		$nomor_tujuan = $this->db->escape_str($this->input->post('number'));
		$schedule = $this->input->post('schedule');

		$where = ['no_hp' => $nomor_tujuan, 'kunci' => 0];
		$data = $this->model_promo->cek_nomor_bylabel($where);
		$pesan = $this->model_promo->get_promo_byid($promo);

		$nama = cekKonsumen($data->id)['nama'];
		$panggilan = cekKonsumen($data->id)['panggilan'];

		$searchVal = array(
			"{perusahaan}",
			"{web}",
			"{selamat}",
			"{hp}",
			"{email}",
			"{alamat}",
			"{nama}",
			"{panggilan}"
		);

		// Array containing replace string from  search string
		$replaceVal = array(
			info()['perusahaan'],
			base_url(),
			ucapan(),
			hp62(info()['phone']),
			info()['email'],
			strip_word_html(base64_decode(info()['deskripsi'])),
			$nama,
			$panggilan
		);

		// Function to replace string
		$msg = str_replace($searchVal, $replaceVal, $pesan->deskripsi);

		if ($format_pesan == 0) {
			$_schedule = 0;
		} else {
			$min = 1;
			$max = 59;
			$var2 =  rand($min, $max);
			$_delay = sprintf('%02s', $var2);
			$dateTime = new DateTime($schedule);
			$timeIn24HourFormat = $dateTime->format('Y-m-d H:i:' . $_delay);
			$_schedule = strtotime($timeIn24HourFormat);
		}

		if ($pesan->jenis_pesan == 0) {

			$isi_pesan = $msg;
			$url       = '';
			$filename  = '';
		} else {
			$isi_pesan = $msg;
			$url       = $pesan->url;
			$filename  = $pesan->filename;
		}

		$data_send = array(
			'target' => $nomor_tujuan,
			'message' => $isi_pesan,
			'url' => $url,
			'filename' => $filename,
			'schedule' => $_schedule,
			'typing' => false,
			'delay' => $delay,
			'countryCode' => '62'
		);

		$this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
		$this->curl->setDefaultJsonDecoder($assoc = true);
		$this->curl->setHeader('Authorization', $token);
		$this->curl->setHeader('Content-Type', 'application/json');
		$this->curl->post('https://api.fonnte.com/send', $data_send);
		if ($this->curl->error) {
			$result = ['status' => false, 'msg' => $this->curl->errorMessage];
		} else {
			$response = $this->curl->response;
			$this->report_pesan($response, $isi_pesan, $data->id);
			$result = ['status' => true, 'msg' => (object)$this->curl->response];
		}

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($result));
	}

	private function report_pesan($response, $message, $id_konsumen)
	{

		foreach ($response["id"] as $k => $v) {
			$target = $response["target"][$k];
			$process = $response["process"];
			$status = $response["status"];
			$data = ['id_kirim' => $v, 'id_konsumen' => $id_konsumen, 'device' => get_device(), 'target' => $target, 'message' => $message, 'status' => $process, 'create_date' => date('Y-m-d')];
			if ($status == true) {
				$this->model_promo->insert_report($data);
			}
			// dump($data);
		}
	}

	public function pesan_terkirim()
	{
		$type = $this->db->escape_str($this->input->post('type'));
		$number = $this->db->escape_str($this->input->post('number'));

		$pesan = $this->model_promo->update_konsumen(['kunci' => 2], ['no_hp' => $number]);
		if ($pesan == true) {
			$response = ['status' => true, 'msg' => 'Sukses update'];
		} else {
			$response = ['status' => false, 'msg' => 'Gagal update'];
		}

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
	}


	public function pesan_gagal()
	{
		$type = $this->db->escape_str($this->input->post('type'));
		$number = $this->db->escape_str($this->input->post('number'));

		$pesan = $this->model_promo->update_konsumen(['kunci' => 3], ['no_hp' => $number]);
		if ($pesan == true) {
			$response = ['status' => true, 'msg' => 'Sukses update'];
		} else {
			$response = ['status' => false, 'msg' => 'Gagal update'];
		}

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
	}

	public function get_media()
	{
		$media = $this->db->query('SELECT * FROM storage ORDER BY id DESC')->result();
		echo '<div class="row">';
		foreach ($media as $m) {
			if (preg_match('/.pdf/', $m->namafile)) {
				$namafile = 'pdf.png';
			} else {
				$namafile = $m->namafile;
			}
			$bb = _storage() . $m->namafile;
			echo '  <div class="col-6 col-xl-2 col-lg-3 col-md-4 col-sm-4">
				<a href="javascript:void(0)" style="text-decoration: none; color: black" data-dismiss="modal" onclick="getmedia(' . "'$bb'" . ')">
				<div class="card">
				<img src="' . base_url('uploads/whatsapp/') . $namafile . '" class="card-img-top" style="max-height: 8rem; min-height: 8rem; object-fit: cover;">
				<div class="card-body p-1 text-center">
				<small style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">' . $m->nama_original . '</small>
				</div>
				</div>
				</a>
				</div>';
		}
		echo '</div>';
	}

	public function upload()
	{
		// echo FCPATH;
		$img = uploadimg([
			'path' => FCPATH . "/uploads/whatsapp/",
			'name' => 'fileupload',
			'compress' => false
		]);
		if ($img['result'] == 'success') {
			$this->db->insert('storage', [
				'namafile' => $img['nama_file'],
				'nama_original' => $_FILES['fileupload']['name']
			]);
			echo 'berhasil';
		} else {
			echo 'Hanya File pdf | jpeg | jpg | png yang diizinkan';
		}
	}
}
