<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Curl\Curl;

class Webhook extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("model_promo");
		$this->curl = new Curl();
	}

	public function index()
	{
		$json = file_get_contents('php://input');
		if (!empty($json)) {
			$data = json_decode($json, true);
			$device = $data['device'];
			$id = $data['id'];
			$stateid = $data['stateid'];
			$status = $data['status'];
			$state = $data['state'];
			$where = ['id' => $id];
			//update status and state
			if (isset($id) && isset($stateid)) {
				$data = [
					'status' => $status,
					'state' => $state,
					'stateid' => $stateid
				];
				$this->model_promo->update_report($data, $where);
			} else if (isset($id) && !isset($stateid)) {
				$data = [
					'status' => $status
				];
				$this->model_promo->update_report($data, $where);
			} else {
				$data = [
					'state' => $state
				];
				$where = ['stateid' => $stateid];
				$this->model_promo->update_report($data, $where);
			}
		}
	}
}
