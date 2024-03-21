<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \VisualAppeal\AutoUpdate;
use Curl\Curl;

class Updateversi extends CI_Controller
{
	public $title;
	public $versi;
	private $user;
	private $pass;
	private $api_key;
	private $curl;
	private $pro;

	function __construct()
	{
		parent::__construct();
		error_reporting(0);
		// cek_tabel();
		cek_session_login();

		$this->load->model('model_update');
		$this->load->library('add_menu');
		$this->lang->load('update_controller_lang', 'indonesia');

		$this->curl        = new Curl();
		$this->url_checker = URL_CHECKER;
		$this->api_key     = info()['api_key'];
		$this->title       = info()['title'];
		$this->versi       = info()['version'];
		$this->pro         = info()['user_pass'];

		$this->user = info()['user_name'];
	}

	/**
	 * index
	 *
	 * @return string
	 */
	public function index()
	{
		cek_menu_akses();
		$data['title'] = 'Cek Update | ' . $this->title;
		$data['tema'] =  info()['tema'];
		$data['nama'] =  $this->session->nama;
		$this->template->load('main/themes', 'update', $data);
	}

	/**
	 * cek_notif
	 *
	 * @return void
	 */
	public function cek_notifikasi()
	{
		// cek_nput_post('GET');
		$cek_notif = $this->input->post('tipe');

		$fileOffline = FCPATH . "version.json";

		if (!is_file($fileOffline)) {
			echo "";
			die();
		}
		if (ENVIRONMENT == 'development') {
			$url_checker = URL_CHECKER_SANDBOX;
			$file_checker = '/update_checker_sandbox_kasir.json';
		} else {
			$url_checker = $this->url_checker;
			$file_checker = '/update_checker_kasir.json';
		}
		$html = "";
		$url_update = base_url('updateversi');
		$url_checker = $url_checker . $file_checker;

		$fileOffline = site_url('', 'http') . "version.json";
		$this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
		$this->curl->get($url_checker);
		if ($this->curl->error) {
			$response  =  (object)$this->curl->errorMessage;

			$html .= '';
		} else {
			$response = (object)$this->curl->response;
			$last_version = end($response->aplikasi);

			$this->curl->get($fileOffline);

			if ($this->curl->error) {
				// $response_offline  =  (object)$this->curl->errorMessage;
				$html .= '';
			} else {
				$response_offline = (object)$this->curl->response;
				if ($last_version->version == $response_offline->aplikasi[0]->version) {
					$html .= '<a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
						aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-bell fa-fw"></i>
						<span class="badge badge-danger badge-counter" id="remove-notif">0</span>
						</a>';
				} elseif ($last_version->version > $response_offline->aplikasi[0]->version) {
					$html .= '<a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
						aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-bell fa-fw"></i>
						<span class="badge badge-danger badge-counter">1</span>
						</a>
						<div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
						aria-labelledby="alertsDropdown">
						<h6 class="dropdown-header">Versi ' . $last_version->version . ' tersedia</h6>
						<div id="slimm">
						<a class="dropdown-item d-flex align-items-center remove-notif" href="' . $url_update . '" id="remove-notif">
						<div class="dropdown-list-image mr-3">
						<img class="rounded-circle" src="' . $last_version->url_image . '" style="max-width: 60px" alt="">
						<div class="status-indicator bg-success"></div>
						</div>
						<div>
						<div class="small text-gray-500">Versi ' . $last_version->version . '</div>
						<span class="font-weight-bold">' . $last_version->caption . '</span>
						<div class="small text-gray-500">' . dtime($last_version->updateDate) . '</div>
						</div>
						</a>';

					array_pop($response->aplikasi);
					rsort($response->aplikasi);
					foreach ($response->aplikasi as $key => $val) {
						$html .= '
							<a class="dropdown-item d-flex align-items-center remove-notif" href="#" id="remove-notif">
							<div class="dropdown-list-image mr-3">
							<img class="rounded-circle" src="' . $val->url_image . '" style="max-width: 60px" alt="">
							<div class="status-indicator bg-default"></div>
							</div>
							<div>
							<div class="small text-gray-500">Versi ' . $val->version . '</div>
							<span class="font-weight-bold">' . $val->caption . '</span>
							<div class="small text-gray-500">' . dtime($val->updateDate) . '</div>
							</div>
							</a>';
					}
					$html .= '</div>
						<a class="dropdown-item text-center small text-gray-500" href="https://pospercetakan.my.id/detail-update" target="_blank">Detail update</a>';
				} else {
					$html .= '';
				}
			}
			$html .= '<script>
				$("#slimm").slimscroll({
				height: "260px"
				});
				</script>';
			echo $html;
		}
	}


	/**
	 * update_app
	 *
	 * @return array
	 */

	public  function update_app()
	{

		$command = strtolower($this->input->post('command'));

		if ($command == 'update') {
			update_demo_admin($this->session->nama);
			$arr = $this->model_update->update_aplikasi($command);
		} elseif ($command == 'update_dev') {
			$arr = $this->model_update->update_developement($command);
		} elseif ($command == 'env') {
			$arr[] = ENVIRONMENT;
		} elseif ($command == 'ping2') {
			$host = 'pospercetakan.my.id';
			$ttl = 128;
			$timeout = 5;
			$ping = new \JJG\Ping($host, $ttl, $timeout);
			$latency = $ping->ping();
			if ($latency !== false) {
				$arr[] = 'Latency is ' . $latency . ' ms';
			} else {
				$arr[] = 'Host could not be reached.';
			}
		} elseif ($command == 'ping') {
			$arr = $this->model_update->ping();
		} elseif ($command == 'log') {
			update_demo_admin($this->session->nama);
			$arr = $this->model_update->log($command);
		} elseif ($command == 'versions' or $command == 'versis') {

			$arr = $this->model_update->version($command);
		} elseif ($command == 'cleartmp') {

			$arr = $this->model_update->cleartmp();
		} elseif ($command == 'clearlog') {

			$arr = $this->model_update->clearlog($command);
		} elseif ($command == 'migrasi') {

			update_demo_admin($this->session->nama);
			$arr = $this->model_update->migrasi($command);
			//START MULTI COMMAND
		} else {

			$response = $this->model_update->global_command($command);

			if (empty($response->status)) {
				$arr['status'] = json_encode($response->message);
				echo json_encode($arr);
				exit;
			}
			if ($response->status == 'add_column') {
				// update_demo_admin($this->session->nama);
				$arr = $this->model_update->add_column($response);
			} elseif ($response->status == 'modify_column') {
				update_demo_admin($this->session->nama);
				$arr = $this->model_update->add_column($response);
			} elseif ($response->status == 'drop_column') {
				$fields = $response->fields;
				$kolom = array_keys($fields);
				if ($this->db->field_exists($kolom[0], $response->table)) {
					$this->load->dbforge();
					$this->dbforge->drop_column($response->table, $kolom[0]);
					$arr['status'] =  $response->message;
				} else {
					$arr['status'] =  $this->lang->line('column_not_found');
				}
			} elseif ($response->status == 'add_key') {
				update_demo_admin($this->session->nama);
			} elseif ($response->status == 'create_table') {
				update_demo_admin($this->session->nama);
				$arr = $this->model_update->create_table($response);
			} elseif ($response->status == 'drop_table') {
				update_demo_admin($this->session->nama);
			} elseif ($response->status == 'input_data') {
				update_demo_admin($this->session->nama);
				$arr = $this->model_update->input_data($response);
			} elseif ($response->status == 'update_data') {
				update_demo_admin($this->session->nama);
			} elseif ($response->status == 'readme') {

				$arr  =  $response->message;
			} elseif ($response->status == 'mkdir') {
				update_demo_admin($this->session->nama);
				if (!is_dir($response->message)) {
					mkdir($response->message, 0777, true);
					$arr[]  =  'Folder ' . $response->message . ' berhasil dibuat';
				} else {
					$arr[]  =  'Folder ' . $response->message . ' sudah ada';
				}
			} elseif ($response->status == 'demo') {
				$arr = $this->model_update->demo($response);
			} elseif ($response->status == 'installpatch') {
				update_demo_admin($this->session->nama);
				$arr = $this->model_update->install_patch($response);
			} elseif ($response->status == 'patch') {

				$arr = $this->model_update->patch($response);
			} elseif ($response->status == 'update') {
				$arr = $this->model_update->update_with_token($response);
			} elseif ($response->status == 'versi') {
				$arr = $this->model_update->version($response);
			} elseif ($response->status == 'versipro') {

				if ($response->user == true) {

					$arr = $this->model_update->versipro($response);
				} else {
					$arr[] = $response->message;
				}
			} elseif ($response->status == 'updatepro' or $response->status == 'custom') {

				update_demo_admin($this->session->nama);
				if (empty($response->user) and empty($response->auth)) {
					$arr = $response->message;
				} else {
					if (empty($response->modul)) {
						$arr = $response->message;
					} else {
						$arr = $this->model_update->updatepro($response);
					}
				}
			} elseif ($response->status == 'help') {
				$arr[]  =  $response->message;
			} else {
				$arr[]  =  $response->message;
			}
		}

		if (empty($arr)) {
			$result[] =  '[[b;red;black]command ' . $command . ' tidak ditemukan]';
		} else {
			$result = $arr;
		}
		echo json_encode($result);
	}
}
