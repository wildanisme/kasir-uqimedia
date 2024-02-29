<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PHPUnit\Util\Json;
use Curl\Curl;

class Whatsapp extends CI_Controller
{
	var $title;
	private $token;
	private $curl;
	var $output;
	var $template;
	var $input;

	public function __construct()
	{
		parent::__construct();

		cek_session_login();
		$this->title = info()['title'];
		$this->curl = new Curl();
	}

	/**
	 * index
	 *
	 * @return void
	 */
	public function index()
	{
		cek_menu_akses();
		$data['title'] = 'Device| ' . $this->title;
		$data['ip'] = $this->input->ip_address();
		$this->template->load('main/themes', 'whatsapp/device', $data);
	}

	public function report()
	{
		cek_menu_akses();
		cek_crud_akses(8);
		$data['title'] = 'Report Pesan| ' . $this->title;
		$this->template->load('main/themes', 'whatsapp/report', $data);
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
		$totalRec = $this->model_data->getReport($conditions);

		// Pagination configuration 
		$config['target']      = '#data_report';
		$config['base_url']    = base_url('whatsapp/ajaxReport');
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $limit;
		$config['link_func']   = 'search_LaporanGrup';

		// Initialize pagination library 
		$this->ajax_pagination->initialize($config);
		// Get records 
		$conditions['start'] = $offset;
		$conditions['limit'] = $limit;
		unset($conditions['returnType']);

		$data['result'] = $this->model_data->getReport($conditions);
		// dump($data['result']);
		$this->load->view('whatsapp/ajax-report', $data, false);
	}
	/**
	 * data_device
	 *
	 * @return void
	 */
	public function data_device()
	{
		$device = $this->model_app->views('device')->result();
		$html = '';
		if (!empty($device)) {
			foreach ($device as $row) {
				if ($row->device_status == 'connect') {
					$device_status = 'connect';
					$device_btn = 'success';
					$scan_qr = 'logout_qr';
				} else {
					$device_btn = 'danger';
					$scan_qr = 'scan_qr';
					$device_status = 'Click to scan';
				}

				$html .= '<tr>';
				$html .= '<td><a href="javascript:void(0)" class="add_device" data-id="' . $row->id . '">' . $row->device . '</a></td>';
				$html .= '<td><button type="button" class="btn  btn-' . $device_btn . ' btn-circle btn-sm rounded-circle ' . $scan_qr . '" token-id="' . $row->token . '" title="' . $device_status . '"><i class="fa fa-qrcode rounded-circle"></i></button>&nbsp;&nbsp;' . $device_status . '</td>';
				$html .= '<td>' . $row->expired . '</td>';
				$html .= '<td>' . $row->quota . '</td>';
				$html .= '<td>' . $row->package . '</td>';
				$html .= "<td><a class='btn btn-link text-danger' data-toggle='modal'   data-target='#confirm-delete' title='Edit Data' data-id='{$row->id}' href='#'><i class='fa fa-remove'></i> Hapus</a></td>";
				$html .= '</tr>';
			}
		} else {
			$html .= '<tr>';
			$html .= '<td colspan="6">Belum Ada Device</td>';
			$html .= '</tr>';
		}
		echo $html;
	}

	/**
	 * cek_status
	 *
	 * @return void
	 */
	public function cek_status()
	{
		$token = decrypt_url($this->input->post('token'));
		$result = $this->fonnte('https://api.fonnte.com/device', $token);

		if ($result['status'] == true) {
			if ($result['msg']->status == true) {
				$this->update_device($result['msg'], $token);
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
	/**
	 * cek_status
	 *
	 * @return void
	 */
	public function cek_status_device()
	{
		$token = ($this->input->post('token'));
		$result = $this->fonnte('https://api.fonnte.com/device', $token);

		if ($result['status'] == true) {
			if ($result['msg']->status == true) {
				$this->update_device($result['msg'], $token);
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


	/**
	 * scan_qr
	 *
	 * @return void
	 */
	public function scan_qr()
	{
		$token = $this->input->post('token');
		// cek_promo('get',$token);
		$result = $this->fonnte('https://api.fonnte.com/qr', $token);
		// dump($result);
		$_token = (object)['token' => $token];
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
		$obj_merged = (object) array_merge((array) $data, (array) $_token);

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($obj_merged));
	}

	/**
	 * logout_device
	 *
	 * @return string
	 */
	public function logout_device()
	{
		$token = $this->input->post('token');
		$status = cek_demo_promo('disconnect', $token);
		if ($status['status'] == true) {
			$response = $status;
		} else {
			$response = $this->fonnte('https://api.fonnte.com/disconnect', $token);
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
	}

	/**
	 * validate_number
	 *
	 * @return string
	 */
	public function validate_number()
	{
		$token = $this->input->post('token');
		$target = $this->input->post('target');
		$cek_nomor = array(
			'target' => $target,
			'countryCode' => '62'
		);

		$this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
		$this->curl->setDefaultJsonDecoder($assoc = true);
		$this->curl->setHeader('Authorization', $token);
		$this->curl->setHeader('Content-Type', 'application/json');
		$this->curl->post('https://api.fonnte.com/validate', $cek_nomor);
		if ($this->curl->error) {
			$result = ['status' => false, 'msg' => $this->curl->errorMessage];
		} else {
			$result = ['status' => true, 'msg' => (object)$this->curl->response];
		}

		if ($result['status'] == true) {
			if (!empty($result->registered)) {
				$data = ['status' => true, 'msg' => 'OK'];
			} else {
				$data = ['status' => false, 'msg' => 'ERROR'];
			}
		} else {
			$data = ['status' => false, 'msg' => $result['msg']];
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	/**
	 * fonnte
	 *
	 * @param  mixed $url
	 * @return array
	 */
	private function fonnte($url, $token = "")
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
	/**
	 * add_device
	 *
	 * @param  mixed $param
	 * @return void
	 */
	public function add_device()
	{
		$id = $this->input->post('id');
		$tipe = $this->input->post('tipe');
		$token = $this->input->post('token');

		if ($tipe == 'get' and $id == 0) {
			simpan_demo('Tambah');
			$response = ['status' => false, 'id' => 0];
		}

		if ($tipe == 'get' and $id > 0) {
			// simpan_demo('Simpan');
			cek_crud_akses(8); //read
			$cek = $this->model_app->view_where('device', ['id' => $id]);
			if ($cek->num_rows() > 0) {
				$response = ['status' => 200, 'id' => $id, 'token' => maskString($cek->row()->token)];
			} else {
				$response = ['status' => false, 'token' => ''];
			}
		}

		if ($tipe == 'add') {
			simpan_demo('Simpan');
			cek_crud_akses(7); //create
			$cek = $this->model_app->view_where('device', ['token' => $token]);
			if ($cek->num_rows() > 0) {
				$response = ['status' => false, 'msg' => 'Token Sudah ada'];
			} else {
				$input = $this->model_app->input('device', ['token' => $token]);
				if ($input['status'] == 'ok') {
					$response = ['status' => 200, 'msg' => 'Berhasil di simpan'];
					$this->get_data_fonnte($token);
				} else {
					$response = ['status' => false, 'msg' => 'Gagal di simpan'];
				}
			}
		}

		if ($tipe == 'edit' and $id > 0) {
			simpan_demo('Simpan');
			cek_crud_akses(9, 'json'); //update
			$cek = $this->model_app->view_where('device', ['token' => $token, 'id !=' => $id]);
			if ($cek->num_rows() > 0) {
				$response = ['status' => false, 'msg' => 'Token Sudah ada'];
			} else {
				$update = $this->model_app->update('device', ['token' => $token], ['id' => $id]);
				if ($update['status'] == 'ok') {
					$response = ['status' => 200, 'msg' => 'Berhasil di update'];
					$this->get_data_fonnte($token);
				} else {
					$response = ['status' => false, 'msg' => 'Gagal di update'];
				}
			}
		}

		if ($tipe == 'hapus' and $id > 0) {
			cek_crud_akses(10, 'json'); //delete
			$cek = $this->model_app->view_where('device', ['id' => $id]);
			if ($cek->num_rows() > 0) {
				$hapus = $this->model_app->hapus('device', array('id' => $id));
				if ($hapus['status'] == 'ok') {
					$response = ['status' => 200, 'msg' => 'Berhasil di hapus'];
				} else {
					$response = ['status' => false, 'msg' => 'Gagal di hapus'];
				}
			} else {
				$response = ['status' => false, 'msg' => 'Data tidak ditemukan'];
			}
		}

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
	}

	/**
	 * cek_status
	 *
	 * @return void
	 */
	public function get_data_fonnte($token)
	{

		$result = $this->fonnte('https://api.fonnte.com/device', $token);

		if ($result['status'] == true) {
			if ($result['msg']->status == true) {
				$this->update_device($result['msg'], $token);
			}
		}
	}

	/**
	 * update_device
	 *
	 * @param  mixed $param
	 * @return void
	 */
	private function update_device($array, $token)
	{
		$param = [
			'device'       => $array->device,
			'device_status' => $array->device_status,
			'expired'      => $array->expired,
			'messages'     => $array->messages,
			'name'         => $array->name,
			'package'      => $array->package,
			'quota'        => $array->quota,
		];

		$cek = $this->model_app->view_where('device', ['token' => $token]);
		if ($cek->num_rows() > 0) {
			$this->model_app->update('device', $param, ['token' => $token]);
		}
	}

	/**
	 * get_pesan
	 *
	 * @return void
	 */
	public function get_pesan()
	{
		if ($this->input->is_ajax_request()) {
			$idorder     = $this->input->post('idorder');
			$deid        = decrypt_url($idorder);
			$status      = xss_filter($this->input->post('status'), 'xss');
			$nomor_order = xss_filter($this->input->post('nomor_order'), 'xss');
			$tgl         = xss_filter($this->input->post('tgl'), 'xss');
			$user        = xss_filter($this->input->post('user'), 'xss');

			if (empty($status)) {
				$pesan = "";
			} else {
				$pesan = $this->model_app->view_where('template_pesan', ['id' => $status])->row()->deskripsi;
			}


			if (!empty($pesan)) {
				$id_fo = get_id_transaksi($deid)['id_fo'];
				$fo = cekUser($id_fo)['nama'];

				$idkonsumen = get_id_transaksi($deid)['idkonsumen'];
				$nama = cekKonsumen($idkonsumen)['nama'];
				$panggilan = cekKonsumen($idkonsumen)['panggilan'];
				$piutang = $this->total($deid)['piutang'];

				$detail = $this->kirim_rincian($deid);
				if ($piutang > 0) {
					$status_order = 'BELUM LUNAS';
				} else {
					$status_order = 'LUNAS';
				}
				// Array containing search string
				$searchVal = array(
					"{perusahaan}",
					"{web}",
					"{link_mobile}",
					"{link_desktop}",
					"{selamat}",
					"{invoice}",
					"{tgl}",
					"{fo}",
					"{hp}",
					"{detail}",
					"{total}",
					"{bayar}",
					"{diskon}",
					"{cashback}",
					"{piutang}",
					"{status}",
					"{email}",
					"{alamat}",
					"{nama}",
					"{panggilan}"
				);

				// Array containing replace string from  search string
				$replaceVal = array(
					info()['perusahaan'],
					base_url(),
					base_url('e-invoice-mobile/') . $idorder,
					base_url('e-invoice-desktop/') . $idorder,
					ucapan(),
					$nomor_order,
					dtimes($tgl, false, false),
					$fo,
					hp62(info()['phone']),
					$detail,
					$this->total($deid)['total'],
					$this->total($deid)['bayar'],
					$this->total($deid)['diskon'],
					$this->total($deid)['cashback'],
					$this->total($deid)['piutang'],
					$status_order,
					info()['email'],
					strip_word_html(base64_decode(info()['deskripsi'])),
					$nama,
					$panggilan
				);

				// Function to replace string
				$msg = str_replace($searchVal, $replaceVal, $pesan);
				if (preg_match('/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/', $msg, $ip_match)) {
					$data = ['status' => false, 'msg' => 'Aplikasi harus online'];
				} elseif (stripos($msg, "localhost") !== false) {
					$data = ['status' => false, 'msg' => 'Aplikasi harus online'];
				} else {
					$data = ['status' => true, 'msg' => $msg];
				}
			} else {
				$data = ['status' => false, 'msg' => 'Pesan belum dipilih'];
			}
		} else {
			$data = ['status' => false];
		}

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	/**
	 * kirim_rincian
	 *
	 * @param  mixed $id
	 * @return string
	 */
	private function kirim_rincian($id)
	{
		$detail = $this->model_app->produk_cart(array('invoice_detail.id_invoice' => $id));
		$break = "%0A";
		$result = $break . '----------------------------------' . $break;
		foreach ($detail  as $row) {
			$result .= '*Produk :* ' . $row['title'] .
				$break . '*Bahan :* ' . $row['nbahan'] .
				$break . '*Jml. :* ' . $row['jumlah'] .
				$break . '*Harga :* ' . rp($row['harga']) .
				$break . '*Ukuran :* ' . $row['ukuran'] .
				$break . '*Keterangan :* ' . $row['keterangan'] .
				$break . '----------------------------------' . $break;
		}
		return $result;
	}

	/**
	 * kirim_pesan
	 *
	 * @return void
	 */
	public function kirim_pesan()
	{
		cek_crud_akses(9);
		if ($this->input->is_ajax_request()) {

			$token  	   = decrypt_url($this->input->post('device'));
			$nomor_tujuan  = xss_filter($this->input->post('nomor_tujuan'), 'xss');
			$isi_pesan     = xss_filter($this->input->post('isi_pesan'), 'xss');

			$remove = array("\r\n", "\r", "<p>", "</p>", "<h1>", "</h1>", "<br>", "<br />", "<br/>");
			$content = str_replace($remove, '', $isi_pesan);

			$data_send = array(
				'target' => $nomor_tujuan,
				'message' => $isi_pesan,
				'countryCode' => '62'
			);

			$id_konsumen = $this->get_id_konsumen($nomor_tujuan);
			$device_status = cek_device_status($token);
			if ($device_status == true) {
				$this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
				$this->curl->setDefaultJsonDecoder($assoc = true);
				$this->curl->setHeader('Authorization', $token);
				$this->curl->setHeader('Content-Type', 'application/json');
				$this->curl->post('https://api.fonnte.com/send', $data_send);
				if ($this->curl->error) {
					$result = ['status' => false, 'msg' => $this->curl->errorMessage];
				} else {
					$response = $this->curl->response;
					$result = ['status' => true, 'msg' => (object)$response];
					$this->report_pesan($response, $isi_pesan, $id_konsumen);
				}
			} else {
				$result = ['status' => false, 'target' => hp62($nomor_tujuan), 'msg' => $isi_pesan];
			}
		} else {
			$result = ['status' => false];
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
				$this->model_app->input('report_pesan', $data);
			}
			// dump($data);
		}
	}

	/**
	 * get_form_wa
	 *
	 * @return int
	 */

	private function get_id_konsumen($nomor)
	{

		return $this->model_app->pilih_where('id', 'konsumen', ['no_hp' => $nomor])->row()->id;
	}
	/**
	 * get_form_wa
	 *
	 * @return void
	 */
	public function get_form_wa()
	{
		cek_crud_akses(8);
		if ($this->input->is_ajax_request()) {

			$id    = $this->input->post('id');
			$deid  = decrypt_url($id);
			$nomor = xss_filter($this->input->post('nomor'), 'xss');
			$tgl   = ($this->input->post('tgl'));

			$data['id'] = $id;
			$data['nomor'] = $nomor;
			$data['tgl'] = $tgl;
			$data['user'] = cekUser($deid)['nama'];
			// $data['device'] = $this->load_device();
			$data['id_invoice'] = get_id_transaksi($deid)['nomor_order'];
			$data['jenis'] = $this->model_app->view_where('template_pesan', ['active' => 'Y'])->result();
			$data['kirim'] = $this->model_app->view_where('invoice', ['id_invoice' => $deid])->row();
			$this->load->view('whatsapp/kirim_wa', $data);
		}
	}

	/**
	 * template
	 *
	 * @return void
	 */
	public function template()
	{
		cek_menu_akses();
		cek_crud_akses(8);
		$data['title'] = 'Template Pesan | ' . $this->title;
		$this->template->load('main/themes', 'whatsapp/template', $data);
	}

	/**
	 * data_template
	 *
	 * @return void
	 */
	public function data_template()
	{
		cek_crud_akses(8);
		$data['record'] = $this->model_app->view_where_ordering('template_pesan', array(), 'id', 'DESC')->result();
		$this->load->view('whatsapp/data_template', $data);
	}

	/**
	 * total
	 *
	 * @param  mixed $id
	 * @return array
	 */
	private function total($id)
	{

		$total_order = $this->model_app->sum_data('total_bayar', 'invoice', ['id_invoice' => $id]);
		$totalorder = $total_order > 0 ? rp($total_order) : 0;
		$total_bayar = $this->model_app->sum_data('jml_bayar', 'bayar_invoice_detail', ['id_invoice' => $id]);
		$totalbayar = $total_bayar > 0 ? rp($total_bayar) : 0;

		$_diskon = $this->model_app->sum_data('potongan_harga', 'invoice', ['id_invoice' => $id]);
		$diskon = $_diskon > 0 ? rp($_diskon) : 0;
		$cashback = $this->model_app->sum_data('cashback', 'invoice', ['id_invoice' => $id]);
		$cashback = $cashback > 0 ? rp($cashback) : 0;
		if ($total_bayar <= 0) {
			$piutang = $total_order;
		} elseif ($total_bayar > 0 and $total_bayar < $total_order) {
			$piutang = $total_order - $total_bayar - $_diskon;
		} else {
			$piutang = 0;
		}

		$result = [
			'total' => $totalorder,
			'bayar' => $totalbayar,
			'diskon' => $diskon,
			'cashback' => $cashback,
			'piutang' => rp($piutang)
		];
		return $result;
	}

	/**
	 * get_template
	 *
	 * @return void
	 */
	public function get_template()
	{
		cek_crud_akses(8);

		if ($this->input->is_ajax_request()) {
			$id = xss_filter($this->input->post('id'), 'xss');
			$row = $this->model_app->view_where('template_pesan', ['id' => $id])->row();
			$result = [
				'status' => true,
				'id' => $id,
				'title' => $row->title,
				'deskripsi' => $row->deskripsi,
				'publish' => $row->active
			];
		} else {
			$result = ['status' => false];
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($result));
	}

	/**
	 * save_template
	 *
	 * @return void
	 */
	public function save_template()
	{
		if ($this->input->is_ajax_request()) {
			$type      = xss_filter($this->input->post('type'), 'xss');
			$title     = xss_filter($this->input->post('title'), 'xss');
			$deskripsi = xss_filter($this->input->post('deskripsi'));
			$active    = $this->input->post('publish');

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
				if ($type == 'add') {
					simpan_demo('Simpan');
					$param = ['title' => $title, 'deskripsi' => $deskripsi, 'status' => 5, 'active' => $active, 'create_date' => today()];
					$input =  $this->model_app->input('template_pesan', $param);
					if ($input['status'] == 'ok') {
						$result = array('status' => true, 'msg' => 'Data berhasil diinput');
					} else {
						$result = array('status' => false);
					}
				}
				if ($type == 'edit') {
					simpan_demo('Edit');
					$id = xss_filter($this->input->post('id'), 'xss');
					$param = ['title' => $title, 'deskripsi' => $deskripsi, 'active' => $active];
					$update = $this->model_app->update('template_pesan', $param, ['id' => $id]);
					if ($update['status'] == 'ok') {
						$result = ['status' => true, 'msg' => 'Berhasil'];
					} else {
						$result = ['status' => false, 'msg' => 'Gagal'];
					}
				}
			} else {

				$result['status'] = 'error';
				$result['alert']['type'] = 'error';
				$result['alert']['content'] = validation_errors();
			}
			if ($type == 'hapus') {
				simpan_demo('Hapus');
				cek_crud_akses(10);
				$id = xss_filter($this->input->post('id'), 'xss');
				$cek = $this->model_app->view_where('template_pesan', array('id' => $id));
				if ($cek->num_rows() > 0) {
					$res = $this->model_app->hapus('template_pesan', array('id' => $id));
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
}
