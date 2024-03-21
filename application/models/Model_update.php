<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \VisualAppeal\AutoUpdate;
use Curl\Curl;

class Model_update extends CI_model
{


	function __construct()
	{
		parent::__construct();

		$this->curl        = new Curl();
		$this->url_checker = URL_CHECKER;
		$this->url_api     = ENVIRONMENT == 'production' ? URL_API : 'https://pospercetakan.my.id';
		$this->api_key     = info()['api_key'];
		$this->versi       = info()['version'];
		$this->pro         = info()['versi_pro'];
		$this->custom      = info()['versi_custom'];
		$this->patch      = info()['patch'];
		$this->title      = info()['title'];
		$this->perusahaan = info()['perusahaan'];
		$this->email      = info()['email'];
		$this->phone      = info()['phone'];
	}

	private function default_api($command = '', $url_api = '')
	{

		$api_url = empty($url_api) ? $this->url_api : $url_api;

		$data = [
			'APP-API-KEY'  => $this->api_key,
			'text'  => $command,
			'title'        => $this->title,
			'perusahaan'   => $this->perusahaan,
			'email'        => $this->email,
			'phone'        => $this->phone
		];

		$this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
		$this->curl->setDefaultJsonDecoder($assoc = true);
		$this->curl->setHeader('Content-Type', 'application/json');
		$this->curl->post($api_url . '/api/command', $data);
		if ($this->curl->error) {
			$response[] = $this->curl->errorMessage;
			return $response;
			exit;
		} else {
			$response = (object)$this->curl->response;
		}

		return $response;
	}

	private function curl_update($token = '', $counter = 0, $url_api = '')
	{

		$api_url = empty($url_api) ? $this->url_api : $url_api;

		$data = [
			'APP-API-KEY'  => $this->api_key,
			'token'  => $token,
			'counter'  => $counter
		];

		$this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
		$this->curl->setDefaultJsonDecoder($assoc = true);
		$this->curl->setHeader('Content-Type', 'application/json');
		$this->curl->post($api_url . '/api/counter', $data);
		if ($this->curl->error) {
			$response[] = $this->curl->errorMessage;
			return $response;
			exit;
		} else {
			$response = (object)$this->curl->response;
		}

		return $response;
	}

	public function ping()
	{

		$output = '';
		$status = '';
		$ip =   "pospercetakan.my.id";
		exec("ping -n 3 $ip", $output, $status) . '\n';

		return $output;
	}

	public function cleartmp()
	{
		$arr = deleteFiles('./temp');
		return $arr;
	}

	public function clearlog($command)
	{

		$response = $this->default_api($command);

		$files = array($response->status, $response->pro, $response->custom);
		$no = 0;
		foreach ($files as $file) {
			$no++;
			if ($file == $response->status) {
				if (@unlink($response->status)) {
					$arr[$no] =  'log update berhasil dibersihkan';
				} else {
					$arr[$no] =  'log update gagal dibersihkan / file tidak ditemukan';
				}
			}

			if ($file == $response->pro) {
				if (@unlink($response->pro)) {
					$arr[$no] =  'log pro berhasil dibersihkan';
				} else {
					$arr[$no] =  'log pro gagal dibersihkan / file tidak ditemukan';
				}
			}
			if ($file == $response->custom) {
				if (@unlink($response->custom)) {
					$arr[$no] =  'log custom berhasil dibersihkan';
				} else {
					$arr[$no] =  'log custom gagal dibersihkan / file tidak ditemukan';
				}
			}
		}
		deleteLog('./application/logs');
		return $arr;
	}

	public function log($command)
	{

		$response = $this->default_api($command);

		$arr['status'] = 'log';
		$filename = FCPATH . $response->status;
		if (file_exists($filename)) {
			$arr['data'] = file_get_contents($filename);
		} else {
			$arr['data'] =  $response->msg;
		}

		return $arr;
	}

	public function migrasi($command)
	{

		$response = $this->default_api($command);
		$arr[] = 'status :' . $response->status;
		$arr[] .= 'versi :' . $response->version;
		$arr[] .= $response->message;
		return $arr;
	}

	private function cek_kolom($arg)
	{
		$string = explode(' ', strtolower($arg));

		if (count($string) == 1) {
			return ['satu' => $arg];
		} elseif (count($string) == 2) {
			list($kolom, $field) = $string;
			return ['satu' => $kolom, 'dua' => $field];
		} elseif (count($string) == 3) {
			list($kolom, $field, $tiga) = $string;
			return ['satu' => $kolom, 'dua' => $field, 'tiga' => $tiga];
		} elseif (count($string) == 4) {
			list($satu, $dua, $tiga, $empat) = $string;
			return ['satu' => $satu, 'dua' => $dua, 'tiga' => $tiga, 'empat' => $empat];
		} elseif (count($string) == 5) {
			list($satu, $dua, $tiga, $empat, $lima) = $string;
			return ['satu' => $satu, 'dua' => $dua, 'tiga' => $tiga, 'empat' => $empat, 'lima' => $lima];
		} else {
			return ['satu' => '', 'dua' => '', 'tiga' => '', 'empat' => '', 'lima' => '', 'enam' => ''];
		}
	}

	private function cek_versi($command)
	{

		$data = [
			'APP-API-KEY'  => $this->api_key,
			'text'  => $command,
			'title'        => $this->title,
			'perusahaan'   => $this->perusahaan,
			'email'        => $this->email,
			'phone'        => $this->phone
		];

		$this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
		$this->curl->setDefaultJsonDecoder($assoc = true);
		$this->curl->setHeader('Content-Type', 'application/json');
		$this->curl->post($this->url_api . '/api/command', $data);
		if ($this->curl->error) {
			$response = $this->curl->errorMessage;
			echo json_encode($response);
			exit;
		} else {
			$response = (object)$this->curl->response;
		}

		$update = new AutoUpdate(FCPATH . $response->temp, FCPATH . $response->path, $response->time);
		$update->setUpdateUrl($response->updateurl);
		$update->setUpdateFile($response->updatefile);
		$update->setCurrentVersion($this->versi);
		$update->setInstallDir('./');

		$logger = new \Monolog\Logger("default");
		$logger->pushHandler(new Monolog\Handler\StreamHandler(FCPATH . $response->logs));
		$update->setLogger($logger);

		if ($update->checkUpdate() === false) {
			die($this->lang->line('check_update'));
		}

		if ($update->newVersionAvailable()) {
			$data = $update->getLatestVersion();
		} else {
			$data = $this->versi;
		}

		return $data;
	}

	public function global_command($command)
	{
		$explode = $this->cek_kolom($command);
		$counter = count($explode);
		if ($explode['satu'] == 'patch' or $explode['satu'] == 'installpatch' or $explode['satu'] == 'versipro' or $explode['satu'] == 'updatepro' or $explode['satu'] == 'readmepro' or $explode['satu'] == 'readme_custom' or $explode['dua'] == 'pro' or $counter > 2) {
			$data = [
				'APP-API-KEY'  => $this->api_key,
				'text'  => $command,
				'env'  => ENVIRONMENT,
				'title'        => $this->title,
				'perusahaan'   => $this->perusahaan,
				'email'        => $this->email,
				'phone'        => $this->phone
			];
		} else {
			$data = [
				'APP-API-KEY'  => $this->api_key,
				'text'  => $command,
				'env'  => ENVIRONMENT,
				'version'  => $this->cek_versi($command),
				'title'        => $this->title,
				'perusahaan'   => $this->perusahaan,
				'email'        => $this->email,
				'phone'        => $this->phone
			];
		}

		$this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
		$this->curl->setDefaultJsonDecoder($assoc = true);
		$this->curl->setHeader('Content-Type', 'application/json');

		$this->curl->post($this->url_api . '/api/command', $data);

		if ($this->curl->error) {
			$response[]  = $this->curl->errorMessage;
			echo json_encode($response);
			exit;
		} else {
			$response = (object)$this->curl->response;
		}

		return $response;
	}

	public function add_column($response)
	{
		$fields = $response->fields;
		$kolom = array_keys($fields);

		if ($this->db->field_exists($kolom[0], $response->table)) {
			$arr['status'] =  $this->lang->line('column_already_exists');
		} else {
			$this->load->dbforge();
			$this->dbforge->add_column($response->table, $fields);
			$arr['status'] =  $response->message;
		}

		return $arr;
	}

	public function modify_column($response)
	{

		$fields = $response->fields;
		$kolom = array_keys($fields);
		$this->load->dbforge();

		$this->dbforge->modify_column($response->table, $fields);
		$arr['status'] =  $this->lang->line('column_moved_success');

		return $arr;
	}

	public function drop_column($command)
	{
	}

	public function add_key($command)
	{
	}

	public function create_table($response)
	{
		$fields = $response->fields;
		$kolom = array_keys($fields);
		if ($this->db->table_exists($response->table)) {
			$arr['status'] =  'Table ' . $response->table . ' sudah ada';
		} else {
			$this->load->dbforge();
			$this->dbforge->add_field($fields);
			$this->dbforge->add_key($response->key, TRUE);
			$attributes = array('ENGINE' => 'MyISAM');
			$this->dbforge->create_table($response->table, FALSE, $attributes);
			$arr['status'] =  $response->message;
		}
		return $arr;
	}

	public function drop_table($command)
	{
	}

	public function input_data($response)
	{

		$cek_row = $this->model_app->view_where($response->table, [$response->coloum => $response->nama_menu]);

		if ($cek_row->num_rows() > 0) {
			$arr[] =  $response->lang_status . ' ' . $response->nama_menu . ' ' . $response->notice;
		} else {
			$insert = $this->model_app->input($response->table, $response->fields);
			if ($insert['status'] == 'ok') {
				$arr[] =  $response->message;
			} else {
				$arr[] =  $this->lang->line('add_menu_fail');
			}
		}
		return $arr;
	}

	public function update_data($response)
	{
	}

	public function update_aplikasi($command)
	{

		$data = [
			'APP-API-KEY'  => $this->api_key,
			'text'         => $command,
			'title'        => $this->title,
			'perusahaan'   => $this->perusahaan,
			'email'        => $this->email,
			'phone'        => $this->phone
		];

		$this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
		$this->curl->setDefaultJsonDecoder($assoc = true);
		$this->curl->setHeader('Content-Type', 'application/json');
		$this->curl->post($this->url_api . '/api/command', $data);
		if ($this->curl->error) {
			$response = $this->curl->errorMessage;
			echo json_encode($response);
			exit;
		} else {
			$response = (object)$this->curl->response;
		}

		$update = new AutoUpdate(FCPATH . $response->status, FCPATH . $response->path, $response->time);
		$update->setUpdateUrl($response->updateurl);
		$update->setUpdateFile($response->updatefile);
		$update->setCurrentVersion($this->versi);

		$update->setInstallDir('./');
		$update->setBasicAuth($response->user, $response->auth);

		$logger = new \Monolog\Logger("default");
		$logger->pushHandler(new Monolog\Handler\StreamHandler(FCPATH . $response->logs));
		$update->setLogger($logger);

		$cache = new Desarrolla2\Cache\File(FCPATH . 'cache');
		$update->setCache($cache, 3600);


		if ($update->checkUpdate() === false) {
			die($this->lang->line('check_update'));
		}

		if ($update->newVersionAvailable()) {

			$arr[] = '[[b;red;black]' . strtoupper($this->lang->line('new_version')) . ' : ' . $update->getLatestVersion() . ']';
			$arr[] = '';
			$array_map =  array_map(function ($version) {
				return (string) $version;
			}, $update->getVersionsToUpdate());

			$arr[] =  'MEMPROSES PEMBARUAN:';
			$arr[] =  $array_map;

			$f = @fopen(FCPATH . $response->logs, 'rb+');
			if ($f !== false) {
				ftruncate($f, 0);
				fclose($f);
			}


			function eachUpdateFinishCallback($updatedVersion)
			{
				$arr[] =  'callback for version' . $updatedVersion;
			}
			$update->onEachUpdateFinish('eachUpdateFinishCallback');

			function onAllUpdateFinishCallbacks($updatedVersions)
			{
				$arr[] =  'callback for all updated versions : ';

				foreach ($updatedVersions as $v) {
					$arr[] =   $v;
				}
			}
			$update->setOnAllUpdateFinishCallbacks('onAllUpdateFinishCallbacks');

			$result = $update->update(false);

			if ($result === true) {
				$res = $this->model_app->update('info', ['version' => $update->getLatestVersion()], ['id' => 1]);
				$this->curl_update($response->token, $response->counter);
				$arr[] = '';
				$arr[] = '[[b;green;black]UPDATE SUKSES]';
				$arr[] = $response->message[0];
			} else {
				$arr[] = 'UPDATE FAILED : ' . $result . '!';
				$arr[] = $response->message[0];

				if ($result = AutoUpdate::ERROR_SIMULATE) {
					$arr[] = $update->getSimulationResults();
				}
			}
		} else {
			$arr[] =  'the latest current version';
		}

		return $arr;
	}

	public function update_with_token($response)
	{


		$update = new AutoUpdate(FCPATH . $response->temp, FCPATH . $response->path, $response->time);
		$update->setUpdateUrl($response->updateurl);
		$update->setUpdateFile($response->updatefile);
		$update->setCurrentVersion($this->versi);

		$update->setInstallDir('./');
		$update->setBasicAuth($response->user, $response->auth);

		$logger = new \Monolog\Logger("default");
		$logger->pushHandler(new Monolog\Handler\StreamHandler(FCPATH . $response->logs));
		$update->setLogger($logger);

		$cache = new Desarrolla2\Cache\File(FCPATH . 'cache');
		$update->setCache($cache, 3600);

		if ($update->checkUpdate() === false) {
			die($this->lang->line('check_update'));
		}

		if ($update->newVersionAvailable()) {
			$arr[] = '[[b;red;black]' . strtoupper($this->lang->line('new_version')) . ' : ' . $update->getLatestVersion() . ']';
			$arr[] = '';
			$array_map =  array_map(function ($version) {
				return (string) $version;
			}, $update->getVersionsToUpdate());

			$arr[] =  'MEMPROSES PEMBARUAN:';
			$arr[] =  $array_map;

			$f = @fopen(FCPATH . $response->logs, 'rb+');
			if ($f !== false) {
				ftruncate($f, 0);
				fclose($f);
			}

			function eachUpdateFinishCallback($updatedVersion)
			{
				$arr[] =  'callback for version' . $updatedVersion;
			}
			$update->onEachUpdateFinish('eachUpdateFinishCallback');

			function onAllUpdateFinishCallbacks($updatedVersions)
			{
				$arr[] =  'callback for all updated versions : ';

				foreach ($updatedVersions as $v) {
					$arr[] =   $v;
				}
			}
			$update->setOnAllUpdateFinishCallbacks('onAllUpdateFinishCallbacks');

			$result = $update->update(false);

			if ($result === true) {
				$res = $this->model_app->update('info', ['version' => $update->getLatestVersion()], ['id' => 1]);
				$this->curl_update($response->token, $response->counter);
				$arr[] = '';
				$arr[] = '[[b;green;black]UPDATE SUKSES]';
				$arr[] = $response->message[0];
			} else {
				$arr[] = 'UPDATE FAILED : ' . $result . '!';
				$arr[] = $response->message[0];

				if ($result = AutoUpdate::ERROR_SIMULATE) {
					$arr[] = $update->getSimulationResults();
				}
			}
		} else {
			$arr[] =  'the latest current version';
		}

		return $arr;
	}

	public function update_developement($command)
	{

		$data = [
			'APP-API-KEY'  => $this->api_key,
			'text'  	   => $command,
			'title'        => $this->title,
			'perusahaan'   => $this->perusahaan,
			'email'        => $this->email,
			'phone'        => $this->phone
		];

		$this->curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
		$this->curl->setDefaultJsonDecoder($assoc = true);
		$this->curl->setHeader('Content-Type', 'application/json');
		$this->curl->post($this->url_api . '/api/updatedev', $data);
		if ($this->curl->error) {
			$response = $this->curl->errorMessage;
			echo json_encode($response);
			exit;
		} else {
			$response = (object)$this->curl->response;
		}

		$update = new AutoUpdate(FCPATH . $response->status, FCPATH . $response->path, $response->time);
		$update->setUpdateUrl($response->updateurl);
		$update->setUpdateFile($response->updatefile);
		$update->setCurrentVersion($this->versi);

		$update->setInstallDir('./');

		$logger = new \Monolog\Logger("default");
		$logger->pushHandler(new Monolog\Handler\StreamHandler(FCPATH . $response->logs));
		$update->setLogger($logger);

		$cache = new Desarrolla2\Cache\File(FCPATH . 'cache');
		$update->setCache($cache, 3600);


		if ($update->checkUpdate() === false) {
			die($this->lang->line('check_update'));
		}

		if ($update->newVersionAvailable()) {
			$arr[] = '[[b;red;black]' . strtoupper($this->lang->line('new_version')) . ' : ' . $update->getLatestVersion() . ']';
			$arr[] = '';
			$array_map =  array_map(function ($version) {
				return (string) $version;
			}, $update->getVersionsToUpdate());

			$arr[] =  'MEMPROSES PEMBARUAN:';
			$arr[] =  $array_map;

			$f = @fopen(FCPATH . $response->logs, 'rb+');
			if ($f !== false) {
				ftruncate($f, 0);
				fclose($f);
			}

			function eachUpdateFinishCallback($updatedVersion)
			{
				$arr[] =  'callback for version' . $updatedVersion;
			}
			$update->onEachUpdateFinish('eachUpdateFinishCallback');

			function onAllUpdateFinishCallbacks($updatedVersions)
			{
				$arr[] =  'callback for all updated versions : ';

				foreach ($updatedVersions as $v) {
					$arr[] =   $v;
				}
			}
			$update->setOnAllUpdateFinishCallbacks('onAllUpdateFinishCallbacks');

			$result = $update->update(false);

			if ($result === true) {
				$res = $this->model_app->update('info', ['version' => $update->getLatestVersion()], ['id' => 1]);
				$arr[] =  '';
				$arr[] =  '[[b;green;black]UPDATE SUKSES]';
			} else {
				$arr[] =  'UPDATE FAILED : ' . $result . '!';

				if ($result = AutoUpdate::ERROR_SIMULATE) {
					$arr[] = $update->getSimulationResults();
				}
			}
		} else {
			$arr[] =  'the latest current version';
		}

		return $arr;
	}

	public function install_patch($response)
	{
		$patch = parse_ini_file(FCPATH . "patch.ini");
		if (empty($patch)) {
			$patch['version'] =  $this->versi;
		}

		$update = new AutoUpdate(FCPATH . $response->temp, FCPATH . $response->path, $response->time);
		$update->setUpdateUrl($response->updateurl);
		$update->setUpdateFile($response->updatefile);
		$update->setCurrentVersion($patch['version']);

		$update->setInstallDir('./');
		$update->setBasicAuth($response->user, $response->auth);

		$logger = new \Monolog\Logger("default");
		$logger->pushHandler(new Monolog\Handler\StreamHandler(FCPATH . $response->logs));
		$update->setLogger($logger);

		$cache = new Desarrolla2\Cache\File(FCPATH . 'cache');
		$update->setCache($cache, 3600);

		if ($update->checkUpdate() === false) {
			die($this->lang->line('check_update'));
		}

		if ($update->newVersionAvailable()) {
			$arr[] = '[[b;red;black] PATCH VERSI : ' . $update->getLatestVersion() . ']';
			$arr[] = '';
			$array_map =  array_map(function ($version) {
				return (string) $version;
			}, $update->getVersionsToUpdate());

			$arr[] =  'MEMPROSES PATCH:';
			$arr[] =  $array_map;

			$f = @fopen(FCPATH . $response->logs, 'rb+');
			if ($f !== false) {
				ftruncate($f, 0);
				fclose($f);
			}

			function eachUpdateFinishCallback($updatedVersion)
			{
				$arr[] =  'callback for version' . $updatedVersion;
			}
			$update->onEachUpdateFinish('eachUpdateFinishCallback');

			function onAllUpdateFinishCallbacks($updatedVersions)
			{
				$arr[] =  'callback for all updated versions : ';

				foreach ($updatedVersions as $v) {
					$arr[] =   $v;
				}
			}
			$update->setOnAllUpdateFinishCallbacks('onAllUpdateFinishCallbacks');

			$result = $update->update(false);

			if ($result === true) {
				$arr[] =  '';
				$arr[] =  '[[b;green;black]PATCH SUKSES]';
				$arr[] =  $response->message;
				if (file_exists(FCPATH . "patch.ini") or !file_exists(FCPATH . "patch.ini")) {
					$data = '[patch] version=' . $response->update_versi;
					write_file('./patch.ini', $data);
				}
			} else {
				$arr[] =  'UPDATE FAILED : ' . $result . '!';
				$arr[] =  $response->message;
				if ($result = AutoUpdate::ERROR_SIMULATE) {
					$arr[] = $update->getSimulationResults();
				}
			}
		} else {
			$arr[] =  'the latest patch';
		}

		return $arr;
	}

	public function version($response)
	{

		$update = new AutoUpdate(FCPATH . $response->temp, FCPATH . $response->path, $response->time);
		$update->setUpdateUrl($response->updateurl);
		$update->setUpdateFile($response->updatefile);
		$update->setCurrentVersion($this->versi);
		$update->setInstallDir('./');
		$update->setBasicAuth($response->user, $response->auth);

		$logger = new \Monolog\Logger("default");
		$logger->pushHandler(new Monolog\Handler\StreamHandler(FCPATH . $response->logs));
		$update->setLogger($logger);

		if ($update->checkUpdate() === false) {
			die($this->lang->line('check_update'));
		}
		$arr[] = '';
		if ($update->newVersionAvailable()) {

			$arr[] .= $this->lang->line('current_version_available') . ' [[b;green;black]' . $update->getLatestVersion() . '] ' . $this->lang->line('current_version') . ' [[b;red;black]' . $this->versi . ']';
			$arr[] .= $this->lang->line('read_instructions') . ' [[b;blue;black]README]';
			$arr[] .= '';
			$arr[] .= $response->message[0];
			$arr[] .= '';
			$arr[] .= $this->lang->line('commands') . '> [[b;green;black]UPDATE] ' . $this->lang->line('app_updates');
			$arr[] .= '';
		} else {
			$arr[] .=  $this->lang->line('latest_current_version') . ' : ' . $this->versi;
			$arr[] .= '';
			$arr[] .= $response->message[0];
			$arr[] .= '';
		}
		return $arr;
	}

	public function patch($response)
	{
		if (file_exists(FCPATH . "patch.ini")) {
			$patch = parse_ini_file(FCPATH . "patch.ini");
		} else {
			$patch['version'] = $this->versi;
		}
		$update = new AutoUpdate(FCPATH . $response->temp, FCPATH . $response->path, $response->time);
		$update->setUpdateUrl($response->updateurl);
		$update->setUpdateFile($response->updatefile);
		$update->setCurrentVersion($patch['version']);
		$update->setInstallDir('./');
		$update->setBasicAuth($response->user, $response->auth);

		$logger = new \Monolog\Logger("default");
		$logger->pushHandler(new Monolog\Handler\StreamHandler(FCPATH . $response->logs));
		$update->setLogger($logger);


		if ($update->checkUpdate() === false) {
			die($this->lang->line('check_update'));
		}
		$arr[] = '';
		if ($update->newVersionAvailable()) {
			$arr[] .= 'Tersedia patch terbaru [[b;yellow;black]' . $update->getLatestVersion() . '] untuk menambal versi [[b;red;black]' . $response->versi . ']';
			$arr[] .= $this->lang->line('read_instructions') . ' [[b;blue;black]README PATCH]';
			$arr[] .= '';
			$arr[] .= $response->message[0];
			$arr[] .= '';
			$arr[] .= $this->lang->line('commands') . '> [[b;green;black]INSTALL PATCH] untuk melakukan penambalan, note : hanya ketik perintah yang berwana hijau';
			$arr[] .= '';
		} else {
			$arr[] .= 'patch saat ini yang terbaru : [[b;green;black]' . $patch['version'] . ']';
			$arr[] .= $response->message[0];
			$arr[] .= '';
		}
		return $arr;
	}

	public function versipro($response)
	{

		$versipro = $this->pro != '' ? $this->pro : '0.0.0';
		$update = new AutoUpdate(FCPATH . $response->temp, FCPATH . $response->path, $response->time);
		$update->setUpdateUrl($response->updateurl);
		$update->setUpdateFile($response->updatefile);
		$update->setCurrentVersion($versipro);
		$update->setInstallDir('./');
		$update->setBasicAuth($response->user, $response->auth);

		$logger = new \Monolog\Logger("default");
		$logger->pushHandler(new Monolog\Handler\StreamHandler(FCPATH . $response->logs));
		$update->setLogger($logger);

		if ($update->checkUpdate() === false) {
			die($this->lang->line('check_update'));
		}

		if ($update->newVersionAvailable()) {

			$arr[]  = $this->lang->line('current_version_available') . ' [[b;green;black]' . $update->getLatestVersion() . '] ' . $this->lang->line('current_version') . ' [[b;red;black]' . $versipro . ']';
			$arr[] .= $this->lang->line('read_instructions') . ' [[b;red;black]' . $response->readme . ']';
			$arr[] .= $this->lang->line('commands') . '> [[b;green;black]' . $response->update . '] ' . $this->lang->line('app_updates');
		} else {
			$arr['j'] =  $this->lang->line('latest_current_version') . ' : ' . $versipro;
		}
		return $arr;
	}

	public function updatepro($response)
	{
		if ($response->status == 'custom') {
			$versipro = $this->custom != '' ? $this->custom : '0.0.0';
			$colom = 'versi_custom';
		} else {
			$versipro = $this->pro != '' ? $this->pro : '0.0.0';
			$colom = 'versi_pro';
		}

		$update = new AutoUpdate(FCPATH . $response->temp, FCPATH . $response->path, $response->time);
		$update->setUpdateUrl($response->updateurl);
		$update->setUpdateFile($response->updatefile);
		$update->setCurrentVersion($versipro);

		$update->setInstallDir('./');
		$update->setBasicAuth($response->user, $response->auth);

		$logger = new \Monolog\Logger("default");
		$logger->pushHandler(new Monolog\Handler\StreamHandler(FCPATH . $response->logs));
		$update->setLogger($logger);

		if ($update->checkUpdate() === false) {
			die($this->lang->line('check_update'));
		}

		if ($update->newVersionAvailable()) {

			$arr[] = '[[b;red;black]' . strtoupper($this->lang->line('new_version')) . ' : ' . $update->getLatestVersion() . ']';
			$arr[] = '';
			$array_map =  array_map(function ($version) {
				return (string) $version;
			}, $update->getVersionsToUpdate());

			$arr[] = 'MEMPROSES PEMBARUAN :';
			$arr[] = $array_map;

			$f = @fopen(FCPATH . $response->logs, 'rb+');
			if ($f !== false) {
				ftruncate($f, 0);
				fclose($f);
			}

			function eachUpdateFinishCallback($updatedVersion)
			{
				$arr[] =  'callback for version' . $updatedVersion;
			}
			$update->onEachUpdateFinish('eachUpdateFinishCallback');

			function onAllUpdateFinishCallbacks($updatedVersions)
			{
				$arr[] =  'callback for all updated versions : ';

				foreach ($updatedVersions as $v) {
					$arr[] =   $v;
				}
			}
			$update->setOnAllUpdateFinishCallbacks('onAllUpdateFinishCallbacks');

			$result = $update->update(false);

			if ($result === true) {
				$this->model_app->update('info', [$colom => $update->getLatestVersion()], ['id' => 1]);
				$arr[] =  '';
				$arr[] =  '[[b;green;black]UPDATE SUKSES]';
			} else {
				$arr[] =  'update failed : ' . $result . '!';

				if ($result = AutoUpdate::ERROR_SIMULATE) {
					$arr[] = $update->getSimulationResults();
				}
			}
		} else {
			$arr[] =  'the latest current version';
		}
		return $arr;
	}

	public function demo($response)
	{
		$update = $this->model_app->update($response->table, [$response->status => $response->fields], ['id' => 1]);

		if ($update['status'] == 'ok') {
			$arr[] =  $response->message;
		} else {
			$arr[] =  $this->lang->line('update_failed');
		}
		return $arr;
	}
}
