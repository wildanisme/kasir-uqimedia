<?php
defined("BASEPATH") or exit("No direct script access allowed");

/**
 * Penjualan
 */
class Penjualan extends CI_Controller
{
	/**
	 * __construct
	 *
	 * @return void
	 */

	public function __construct()
	{
		parent::__construct();

		//cek sesi login
		cek_session_login();
		$this->load->model("model_penjualan", "model");
		//default global perpage
		$this->perPage = 10;
		//global title
		$this->title = info()["title"];
		//session id user
		$this->iduser = $this->session->idu;
	}

	/**
	 * cart
	 *
	 * @return void
	 */

	public function cart()
	{
		//cek jika di method GET message error
		cek_nput_post("GET");
		cek_crud_akses(8, "json");

		//post id invoice
		$id = $this->input->post("id");
		//post type invoice
		$edit = $this->input->post("edit");

		$data["result_produk"] = $this->model_app->view_where('produk', ['pub' => 1])->result_array();

		$_select = "SUM(jumlah * harga) AS `jml`";
		if ($id > 0) {
			//0
			$data["echo"] = 0;
			$data["type"] = $edit;
			$data["diskon"] = $this->model_app->diskon("bayar_invoice_detail", [
				"bayar_invoice_detail.id_invoice" => $id,
			]);
			$data["id"] = $id;
			$data["detail"] = $this->model_app->produk_cart([
				"invoice_detail.id_invoice" => $id,
			]);
			$data["proses"] = $this->model_app
				->edit("invoice", ["id_invoice" => $id])
				->row_array();

			//sum detail
			$cdetail = $this->model_app->cek_total("invoice_detail", $_select, [
				"id_invoice" => $id,
			]);
			$data["cdetail"] = $cdetail->jml;
			//end

			//hapus data kosong
			$this->cek_data_kosong($id);
		} else {
			$cari_last_invoice = $this->model_app->view_where("tb_users", [
				"last_invoice >" => 0,
				"id_user" => $this->iduser,
			]);
			if ($cari_last_invoice->num_rows() > 0) {
				//1
				$data["echo"] = 1;
				$rows = $cari_last_invoice->row();
				$data["type"] = "baru";
				$data["diskon"] = $this->model_app->diskon(
					"bayar_invoice_detail",
					["bayar_invoice_detail.id_invoice" => $rows->last_invoice]
				);
				$data["id"] = $rows->last_invoice;
				$data["detail"] = $this->model_app->produk_cart([
					"invoice_detail.id_invoice" => $rows->last_invoice,
				]);
				$data["proses"] = $this->model_app
					->edit("invoice", ["id_invoice" => $rows->last_invoice])
					->row_array();
				//sum detail
				$cdetail = $this->model_app->cek_total(
					"invoice_detail",
					$_select,
					["id_invoice" => $rows->last_invoice]
				);
				$data["cdetail"] = $cdetail->jml;
				//end

				//hapus data kosong
				$this->cek_data_kosong($rows->last_invoice);
			} else {
				//2
				$data["echo"] = 2;
				$search = $this->model_app->view_where("invoice", [
					"id_invoice" => $this->session->cart,
				]);
				if ($search->num_rows() > 0) {
					//3
					$data["echo"] = 3;
					$rows = $search->row();
					$data["type"] = "baru";
					$data["diskon"] = $this->model_app->diskon(
						"bayar_invoice_detail",
						["bayar_invoice_detail.id_invoice" => $rows->id_invoice]
					);
					$data["id"] = $rows->id_invoice;
					$data["detail"] = $this->model_app->produk_cart([
						"invoice_detail.id_invoice" => $rows->id_invoice,
					]);
					$data["proses"] = $this->model_app
						->edit("invoice", ["id_invoice" => $rows->id_invoice])
						->row_array();
					//sum detail
					$cdetail = $this->model_app->cek_total(
						"invoice_detail",
						$_select,
						["id_invoice" => $rows->id_invoice]
					);
					$data["cdetail"] = $cdetail->jml;
					//end

					//hapus data kosong
					$this->cek_data_kosong($rows->id_invoice);
				} else {
					$search = $this->model_app->view_where_ordering_limit(
						"invoice",
						["id_user" => $this->iduser, "id_konsumen" => 1, 'POS' => 'N', 'status' => 'baru'],
						"id_invoice",
						"DESC",
						1
					);
					if ($search->num_rows() > 0) {
						//4 edit
						$rows = $search->row();
						$data["echo"] = 4;
						$data["type"] = "baru";
						$data["diskon"] = $this->model_app->diskon(
							"bayar_invoice_detail",
							[
								"bayar_invoice_detail.id_invoice" =>
								$rows->id_invoice,
							]
						);
						$data["id"] = $rows->id_invoice;
						$data["detail"] = $this->model_app->produk_cart([
							"invoice_detail.id_invoice" => $rows->id_invoice,
						]);
						$data["proses"] = $this->model_app
							->edit("invoice", [
								"id_invoice" => $rows->id_invoice,
							])
							->row_array();
						//sum detail
						$cdetail = $this->model_app->cek_total(
							"invoice_detail",
							$_select,
							["id_invoice" => $rows->id_invoice]
						);
						$data["cdetail"] = $cdetail->jml;
						//end
						$this->cek_data_kosong($rows->id_invoice);
					} else {
						//5 input

						$data["echo"] = 5;
						$data["type"] = "baru";
						$autoNumber = autoNumber(
							NOMOR_TRX,
							DIGIT_TRX,
							"id_transaksi",
							"invoice"
						);

						$data_arr = [
							"id_transaksi" => $autoNumber,
							"id_konsumen" => "1",
							"id_user" => $this->iduser,
							"id_marketing" => $this->iduser,
							"tgl_trx" => date("Y-m-d"),
							"jam_order" => date("H:i:s"),
							"tgl_ambil" => date("Y-m-d H:i:s"),
							"status" => "baru",
							"sesi_cart" => session_id(),
						];

						$data["autonumber"] = $autoNumber;
						$input = $this->model_app->input("invoice", $data_arr);
						if ($input["status"] == "error") {
							echo $input["msg"];
							exit();
						}
						$last_id = $this->db->insert_id();
						$datain = [
							"id_invoice" => $last_id,
							"id_produk" => 1,
							"id_bahan" => 1,
							"jenis_cetakan" => 1,
							"jumlah" => 1,
						];
						// $this->db->insert("invoice_detail", $datain);
						$data["diskon"] = $this->model_app->diskon(
							"bayar_invoice_detail",
							["bayar_invoice_detail.id_invoice" => $last_id]
						);
						$data["detail"] = $this->model_app->produk_cart([
							"invoice_detail.id_invoice" => $last_id,
						]);
						$data["id"] = $last_id;
						$data["proses"] = $this->model_app
							->edit("invoice", ["id_invoice" => $last_id])
							->row_array();
						//sum detail
						$cdetail = $this->model_app->cek_total(
							"invoice_detail",
							$_select,
							["id_invoice" => $last_id]
						);
						$data["cdetail"] = $cdetail->jml;
						//end
						$this->session->set_userdata(["cart" => $last_id]);
					}
				}
			}
		}

		$data["idsesi"] = $this->iduser;
		$this->load->view("penjualan/keranjang", $data);
	}


	private function cek_data_kosong($id)
	{
		$where_produk = ["id_produk" => 0, "id_invoice" => $id];
		$this->hapus_data_kosong('invoice_detail', $where_produk);
		$where_jenis = ["jenis_cetakan" => 0, "id_invoice" => $id];
		$this->hapus_data_kosong('invoice_detail', $where_jenis);
	}

	private function hapus_data_kosong($tabel, $where)
	{
		$this->model_app->delete($tabel, $where);
	}


	/**
	 * del_bayar
	 *
	 * @return json
	 */
	public function del_bayar()
	{
		cek_nput_post("GET");
		cek_crud_akses(10);
		$id_rincian = xss_filter($this->input->post("id"), 'xss');
		$no_invoice = xss_filter($this->input->post("noin"), 'xss');
		$kunci      = xss_filter($this->input->post("kunci"), 'xss');
		$jml        = xss_filter($this->input->post("jml"), 'xss');
		$idbayar    = xss_filter($this->input->post("idbayar"), 'xss');

		$where = ($this->session->level == "admin" or
			$this->session->level == "owner") ? ["id" => $id_rincian, "id_invoice" => $no_invoice] : [
			"id" => $id_rincian,
			"id_invoice" => $no_invoice,
			"kunci" => $kunci,
		];
		$res = $this->model_app->delete("bayar_invoice_detail", $where);
		if ($res == true) {
			$where = ["catatan" => "Pendapatan INVOICE NO.#" . $no_invoice];
			$this->model_app->delete("kas_masuk", $where);
			$_where = ["catatan" => "Pendapatan No.#" . $no_invoice];
			$this->model_app->delete("jurnal_transaksi", ['reff' => 'I-' . $no_invoice]);
			$this->model_app->delete("deposit", ['id_invoice' => $no_invoice]);
			$data = ["ok" => "ok", "uang" => $jml];
		} else {
			$data = ["ok" => "no", "uang" => 0];
		}
		echo json_encode($data);
	}

	/**
	 * list_bayar
	 *
	 * @return void
	 */
	public function list_bayar()
	{
		$noin = $this->db->escape_str($this->input->post("id"));
		$noin = decrypt_url($noin);
		$data["total_bayar"] = $this->model_app
			->pilih("total_bayar", "invoice", ["id_invoice" => $noin])
			->row();
		$data["bayar"] = $this->model_app->view_where("bayar_invoice_detail", [
			"id_invoice" => $noin,
		]);
		$this->load->view("penjualan/bayar", $data);
	}

	/**
	 * list_bayar_piutang
	 *
	 * @return void
	 */
	public function list_bayar_piutang()
	{
		$noin = $this->db->escape_str($this->input->post("id"));
		$noin = decrypt_url($noin);
		$data["total_bayar"] = $this->model_app
			->pilih("total_bayar", "invoice", ["id_invoice" => $noin])
			->row();
		$data["bayar"] = $this->model_app->view_where("bayar_invoice_detail", [
			"id_invoice" => $noin,
		]);
		$this->load->view("penjualan/list_bayar_piutang", $data);
	}

	/**
	 * list_invoice
	 *
	 * @return void
	 */
	public function list_invoice()
	{
		$data["invoice"] = $this->model_app
			->view_where_ordering_limit(
				"invoice",
				["id_konsumen!=" => 1],
				"id_invoice",
				"DESC",
				10
			)
			->result_array();
		$this->load->view("penjualan/list_invoice", $data);
	}

	/**
	 * list_invoice_desain
	 *
	 * @return html
	 */
	public function list_invoice_desain()
	{
		$data["invoice"] = $this->model_app
			->view_where_ordering_limit(
				"invoice",
				["id_konsumen!=" => 1, "id_desain" => $this->iduser],
				"id_invoice",
				"DESC",
				10
			)
			->result_array();
		$this->load->view("penjualan/list_invoice", $data);
	}

	/**
	 * save_bayar
	 *
	 * @return void
	 */
	public function save_bayar()
	{
		cek_nput_post("GET");

		$lampiran = "";
		$rekening = $this->db->escape_str($this->input->post("rekening"));
		if ($rekening > 0) {
			$config["upload_path"] = "./uploads/lampiran/";
			$config["allowed_types"] = "jpeg|jpg|png|webp";
			$config["max_size"] = "1000"; // kb
			$this->load->library("upload", $config);
			$this->upload->initialize($config);
			if (!empty($_FILES["lampiran"]["name"])) {
				if (!$this->upload->do_upload("lampiran")) {
					echo $this->upload->display_errors();
				} else {
					$data = $this->upload->data();
					$lampiran = $data["file_name"];
				}
			}
		}

		$type           = xss_filter($this->input->post("type"), 'xss');
		$no_order       = xss_filter($this->input->post("noin"), 'xss');
		$id_bayar       = xss_filter($this->input->post("id_byr"), 'xss');
		$jml_bayar      = xss_filter($this->input->post("uang"), 'xss');
		$nourut         = xss_filter($this->input->post("nourut"), 'xss');
		$pajak          = xss_filter($this->input->post("pajak"), 'xss');
		$sumpajak       = xss_filter($this->input->post("sumpajak"), 'xss');
		$total_bayar    = xss_filter($this->input->post("sisabayar"), 'xss');
		$jumlah_bayar   = xss_filter($this->input->post("jumlah_bayar"), 'xss');
		$kembalian      = xss_filter($this->input->post("kembalian"), 'xss');
		$diskon_harga   = xss_filter($this->input->post("diskon_harga"), 'xss');
		$total_cashback = xss_filter($this->input->post("total_cashback"), 'xss');
		$id_konsumen    = xss_filter($this->input->post("id_konsumen"), 'xss');
		$status    		= xss_filter($this->input->post("status"), 'xss');

		$getIdAkun = getIdAkun($id_bayar);
		$arr = [];
		$alert = [];
		if ($type == "simpan_bayar") {
			$reff = 'I-' . $no_order;
			$nama = cekKonsumen($id_konsumen)['nama'];
			$catat =  $nama . " No.Order. :" . "$no_order";
			if (empty($pajak)) {
				$_diskon = "ROUND(SUM((`invoice_detail`.`jumlah`) * (`invoice_detail`.`harga` * `invoice_detail`.`diskon`/100))) AS diskon";


				$data_bayar = [
					"id_invoice" => $no_order,
					"tgl_bayar" => date("Y-m-d"),
					"jam_bayar" => date("H:i:s"),
					"jml_bayar" => $jml_bayar,
					"id_bayar" => $id_bayar,
					"id_sub_bayar" => $getIdAkun,
					"urutan" => $nourut,
					"lampiran" => $lampiran,
					"id_user" => $this->iduser,
				];

				$catatan = "Pendapatan INVOICE NO.#" . $no_order;
				if ($no_order != null and $jml_bayar > 0) {
					$cek_lunas = $this->cek_lunas($no_order);
					if ($cek_lunas == true) {
						$input = $this->model_app->input("bayar_invoice_detail", $data_bayar);

						$this->kas_masuk();
						$this->update_invoice($diskon_harga, $total_bayar, $jumlah_bayar, $kembalian, $total_cashback, $no_order);

						$cek_diskon = $this->model_app->cek_total("invoice_detail", $_diskon, ["id_invoice" => $no_order])->diskon;
						$sum_detail = $this->model->cek_total_detail($no_order);
						$cek_total_bayar = $this->model->cek_total_bayar($no_order);
						$sisa = $sum_detail - $cek_total_bayar - $cek_diskon; //piutang
						if ($status == 'baru' or $status == 'edit') {
							$this->model_jurnal->hapus_jurnal($no_order);
							$this->model_jurnal->hapus_kas_masuk($catatan);
							if ($input["status"] == "ok") {
								if ($sisa > 0) {

									if ($cek_total_bayar > 0) {
										$cek_bayar = $this->model_jurnal->cek_bayar($no_order)->row();
										$id_akunbyr = $cek_bayar->id_sub_bayar;
										$jml_bay 	= $cek_bayar->jml_bayar;
										$this->model_jurnal->input_jurnal_debet($id_akunbyr, $reff, $jml_bay, $catat);
										$this->model_app->update("bayar_invoice_detail", ["rekap" => 'Y'], ["id_invoice" => $no_order]);
									}
									if ($diskon_harga == 1) {
										$catatan = "Diskon Penjualan INVOICE NO.#" . $no_order;
										$id_akun_piutang = 402;
										$this->model_jurnal->input_jurnal_debet($id_akun_piutang, $reff, $sisa, $catat);
									} elseif ($diskon_harga == 2) {
										$catatan = "Cashback Penjualan INVOICE NO.#" . $no_order;
										$id_akun_piutang = 403;
										$this->model_jurnal->input_jurnal_debet($id_akun_piutang, $reff, $sisa, $catat);
									} else {
										$id_akun_piutang = 112;
										$this->model_jurnal->input_jurnal_debet($id_akun_piutang, $reff, $sisa, $catat);
									}
								} else {
									$row = $this->model_jurnal->cek_bayar_byid($no_order);

									$id_akunbyr = $row->id_sub_bayar;
									$jml_bay 	= $row->total;
									$this->model_jurnal->input_jurnal_debet($id_akunbyr, $reff, $jml_bay, $catat);
									$this->model_app->update("bayar_invoice_detail", ["rekap" => 'Y'], ["id_invoice" => $no_order]);
								}

								$this->model_jurnal->input_jurnal_kredit(411, $reff, $sum_detail, $catat);
								if ($sisa == 0) {
									$this->model_app->update(
										"invoice",
										["lunas" => 1],
										["id_invoice" => $no_order]
									);
									$alert = [
										"status" => 200,
										"id" => $no_order,
										"uang" => $jml_bayar,
										"total" => $cek_total_bayar,
										"msg" => $arr,
									];
								} else {
									$alert = [
										"status" => 200,
										"id" => $no_order,
										"uang" => $jml_bayar,
										"total" => $cek_total_bayar,
										"msg" => $arr,
									];
								}
							} else {
								$alert = [
									"status" => 304,
									"id" => 0,
									"uang" => 0,
									"total" => 0,
								];
							}
						} elseif ($status == 'simpan') {


							if ($input["status"] == "ok") {


								$cek_count = $this->model_jurnal->cek_count($no_order);

								//bayar awal
								if ($sisa > 0 and $cek_count == 1) {
									$arr['a'] = 1;
									$cek_bayar = $this->model_jurnal->cek_bayar($no_order)->row();
									$id_akunbyr = $cek_bayar->id_sub_bayar;
									$jml_bay 	= $cek_bayar->jml_bayar;
									$this->model_jurnal->input_jurnal_debet($id_akunbyr, $reff, $jml_bay, $catat);
									$this->model_app->update("bayar_invoice_detail", ["rekap" => 'Y'], ["id_invoice" => $no_order]);

									//piutang
									$id_akun_piutang = 112;
									$this->model_jurnal->input_jurnal_debet($id_akun_piutang, $reff, $sisa, $catat);
									$this->model_jurnal->input_jurnal_kredit(411, $reff, $sum_detail, $catat);
									//bayar piutang
								} elseif ($sisa > 0 and $cek_count > 1) {
									$arr['a'] = 2;
									$ket_jurnal = 'Piutang Inv. No. : ' . $no_order;
									$cek_bayar = $this->model_jurnal->cek_bayar($no_order)->row();

									$id_akunbyr = $cek_bayar->id_sub_bayar;
									$jml_bay 	= $cek_bayar->jml_bayar;
									$this->model_jurnal->input_jurnal_debet($id_akunbyr, $reff, $jml_bay, $catat);
									$this->model_app->update("bayar_invoice_detail", ["rekap" => 'Y'], ["id_invoice" => $no_order]);

									// //piutang
									$id_akun_piutang = 112;
									$this->model_jurnal->input_jurnal_kredit($id_akun_piutang, $reff, $jml_bayar, $ket_jurnal);
									//bayar piutang
								} elseif ($sisa == 0 and $cek_count > 1) {
									$arr['a'] = 3;
									$ket_jurnal = 'Piutang Inv. No. : ' . $no_order;
									$cek_bayar = $this->model_jurnal->cek_bayar($no_order)->row();

									$id_akunbyr = $cek_bayar->id_sub_bayar;
									$jml_bay 	= $cek_bayar->jml_bayar;
									$this->model_jurnal->input_jurnal_debet($id_akunbyr, $reff, $jml_bay, $ket_jurnal);
									$this->model_app->update("bayar_invoice_detail", ["rekap" => 'Y'], ["id_invoice" => $no_order]);

									// //piutang
									$id_akun_piutang = 112;
									$this->model_jurnal->input_jurnal_kredit($id_akun_piutang, $reff, $jml_bayar, $ket_jurnal);
									//bayar lunas
								} else {

									$arr['a'] = 4;
									$cek_bayar = $this->model_jurnal->cek_bayar($no_order)->row();
									$id_akunbyr = $cek_bayar->id_sub_bayar;
									$jml_bay 	= $cek_bayar->jml_bayar;
									$this->model_jurnal->input_jurnal_debet($id_akunbyr, $reff, $jml_bay, $catat);
									$this->model_app->update("bayar_invoice_detail", ["rekap" => 'Y'], ["id_invoice" => $no_order]);
									$this->model_jurnal->input_jurnal_kredit(411, $reff, $jml_bayar, $catat);
								}

								if ($sisa <= 0) {
									// $this->model_app->update("invoice",["lunas" => 1],["id_invoice" => $no_order]);
									$alert = ["status" => 200, "id" => $no_order, "uang" => $jml_bayar, "total" => $jml_bayar, "msg" => $arr,];
								} else {
									$alert = ["status" => 200, "id" => $no_order, "uang" => $jml_bayar, "total" => $jml_bayar, "msg" => $arr,];
								}
							} else {
								$alert = ["status" => 304, "id" => 0, "uang" => 0, "total" => 0,];
							}
						} else {
							$alert = [
								"status" => 301,
								"msg" => "error",
								"id" => $no_order,
								"uang" => $jml_bayar,
								"total" => 0,
							];
						}
					} else {
						$alert = [
							"status" => 301,
							"msg" => "Order sudah lunas",
							"id" => $no_order,
							"uang" => $jml_bayar,
							"total" => 0,
						];
					}
				}
			} else {
			}
		}

		$this->output
			->set_content_type("application/json")
			->set_output(json_encode($alert));
	}

	/**
	 * input_kas
	 *
	 * @param  mixed $diskon_harga
	 * @param  mixed $data
	 * @return array
	 */
	private function update_invoice($diskon_harga, $total_bayar, $jumlah_bayar, $kembalian, $total_cashback, $noin)
	{
		if ($diskon_harga == 1) {
			$update_invoice = [
				"total_bayar" => $total_bayar,
				"jumlah_bayar" => $jumlah_bayar,
				"kembalian" => $kembalian,
				"potongan_harga" => $total_cashback,
				"pos" => 'Y',
				"status" => 'simpan',
			];
		} elseif ($diskon_harga == 2) {
			$update_invoice = [
				"total_bayar" => $total_bayar,
				"jumlah_bayar" => $jumlah_bayar,
				"kembalian" => $kembalian,
				"cashback" => $total_cashback,
				"pos" => 'Y',
				"status" => 'simpan',
			];
		} else {
			$update_invoice = [
				"total_bayar" => $total_bayar,
				"jumlah_bayar" => $jumlah_bayar,
				"kembalian" => $kembalian,
				"pos" => 'Y',
				"status" => 'simpan',
			];
		}
		$this->model_app->update(
			"invoice",
			$update_invoice,
			["id_invoice" => $noin]
		);
	}

	/**
	 * input_kas
	 *
	 * @param  mixed $diskon_harga
	 * @param  mixed $data
	 * @return array
	 */
	private function cek_lunas($no_order)
	{
		$_diskon = "ROUND(SUM((`invoice_detail`.`jumlah`) * (`invoice_detail`.`harga` * `invoice_detail`.`diskon`/100))) AS diskon";
		$cek_diskon = $this->model_app->cek_total("invoice_detail", $_diskon, ["id_invoice" => $no_order])->diskon;
		$sum_detail = $this->model->cek_total_detail($no_order);
		$cek_total_bayar = $this->model->cek_total_bayar($no_order);
		$sisa = $sum_detail - $cek_total_bayar -  $cek_diskon; //piutang
		return true;
		if ($sisa == 0) {
			return false;
		}
	}

	private function input_kas($array)
	{
		$this->model_app->insert("kas_masuk", $array);
	}

	/**
	 * deposit
	 *
	 * @param  mixed $diskon_harga
	 * @param  mixed $data
	 * @return array
	 */
	private function deposit($diskon_harga, $data)
	{
		if ($diskon_harga == 2) {
			$this->model_app->input("deposit", $data);
		}
	}

	/**
	 * add_detail
	 *
	 * @return void
	 */
	public function add_detail()
	{
		cek_nput_post("GET");
		$id = $this->db->escape_str($this->input->post("id"));
		$res = $this->db->insert("invoice_detail", ["id_invoice" => $id]);
		$last_id = $this->db->insert_id();
		if ($res == true) {
			$data = ["status" => 200, "idr" => $last_id];
		} else {
			$data = ["status" => 400, "idr" => 0];
		}
		$this->output
			->set_content_type("application/json")
			->set_output(json_encode($data));
	}

	/**
	 * Summary of hapus_detail
	 * @return void
	 */
	public function hapus_detail()
	{
		cek_nput_post("GET");
		$id = [
			"id_rincianinvoice" => $this->db->escape_str(
				$this->input->post("idr")
			),
		];
		$res = $this->model_app->delete("invoice_detail", $id);
		if ($res == true) {
			$data = ["status" => 200, 'msg' => 'Berhasil'];
		} else {
			$data = ["status" => 400, 'msg' => 'Gagal'];
		}
		$this->output
			->set_content_type("application/json")
			->set_output(json_encode($data));
	}

	/**
	 * Summary of hapus_order_batal
	 * @return void
	 */
	public function hapus_order_batal()
	{
		cek_nput_post("GET");
		cek_crud_akses(10);
		$id = $this->input->post("id");
		$id = decrypt_url($id);
		$id = xss_filter($id, 'sql');
		$id = ["id_invoice" => $id];
		$res = $this->model_app->delete("invoice", $id);

		if ($res == true) {
			$this->model_app->delete("invoice_detail", $id);
			$this->model_app->delete("bayar_invoice_detail", $id);
			$data = ["status" => 200, 'msg' => 'Berhasil'];
		} else {
			$data = ["status" => 400, 'msg' => 'Gagal'];
		}
		$this->output
			->set_content_type("application/json")
			->set_output(json_encode($data));
	}

	/**
	 * Summary of totaltrx
	 * @return void
	 */
	function totaltrx()
	{
		$conditions = [];
		$data = $this->model_app->counter("invoice", $conditions);
		$this->output
			->set_content_type("application/json")
			->set_output(json_encode($data));
	}

	/**
	 * Summary of hari_ini
	 * @return void
	 */
	function hari_ini()
	{
		$conditions["where"] = [
			"tgl_trx" => date("Y-m-d"),
			"status" => "simpan",
		];
		$data = $this->model_app->counter("invoice", $conditions);
		$this->output
			->set_content_type("application/json")
			->set_output(json_encode($data));
	}

	/**
	 * Summary of baru
	 * @return void
	 */
	function baru()
	{
		$conditions["where"] = [
			"status" => "baru",
		];
		$data = $this->model_app->counter("invoice", $conditions);
		$this->output
			->set_content_type("application/json")
			->set_output(json_encode($data));
	}

	/**
	 * Summary of desain
	 * @return void
	 */
	public function desain()
	{
		$conditions["where"] = [
			"id_desain" => $this->iduser,
		];
		$data = $this->model_app->counter("invoice", $conditions);
		$this->output
			->set_content_type("application/json")
			->set_output(json_encode($data));
	}

	/**
	 * Summary of desainnow
	 * @return void
	 */
	public function desainnow()
	{
		$conditions["where"] = [
			"tgl_trx" => date("Y-m-d"),
			"id_desain" => $this->iduser,
		];
		$data = $this->model_app->counter("invoice", $conditions);
		$this->output
			->set_content_type("application/json")
			->set_output(json_encode($data));
	}
	/**
	 * Summary of pending
	 * @return void
	 */
	public function pending()
	{
		$conditions["where"] = [
			"status" => "pending",
		];
		$data = $this->model_app->counter("invoice", $conditions);
		$this->output
			->set_content_type("application/json")
			->set_output(json_encode($data));
	}

	/**
	 * Summary of batal
	 * @return void
	 */
	public function batal()
	{

		$this->session->unset_userdata("cart");
		$conditions["where"] = [
			"status" => "batal",
		];
		$data = $this->model_app->counter("invoice", $conditions);
		$this->output
			->set_content_type("application/json")
			->set_output(json_encode($data));
	}
	/**
	 * Summary of konsumen
	 * @return void
	 */
	public function konsumen()
	{
		$conditions["where"] = [
			"kunci" => "0",
		];
		$data = $this->model_app->counter("konsumen", $conditions);
		$this->output
			->set_content_type("application/json")
			->set_output(json_encode($data));
	}

	/**
	 * Summary of cari
	 * @return void
	 */
	public function cari()
	{
		cek_nput_post("GET");
		$search = $this->input->post("search");
		$data = $this->model_data->getdata($search);
		$this->output
			->set_content_type("application/json")
			->set_output(json_encode($data));
	}

	/**
	 * Summary of simpan_data
	 * @return void
	 */
	public function simpan_data()
	{
		cek_nput_post("GET");
		$noin = $this->input->post("id");
		if ((int)$noin) {
			$noin = $noin;
		} else {
			$noin = decrypt_url($noin);
		}
		$idkon = $this->input->post("idk");
		$total = $this->input->post("total");
		$this->session->unset_userdata("cart");

		if ($noin != null and $total > 0) {
			//hapus data kosong
			$this->cek_data_kosong($noin);
			//cek jml bayar
			$select = "SUM(jml_bayar) AS total";
			$where = ["id_invoice" => $noin];
			$cek_print = $this->model_app->view_where("invoice", $where)->row();

			$konsumen = $this->model_app
				->view_where("konsumen", ["id" => $idkon])
				->row();
			if ($konsumen->max_utang > 0 and $cek_print->cetak <= 1) {
				$max_utang = $konsumen->max_utang - 1;
				$this->model_app->update(
					"konsumen",
					["max_utang" => $max_utang],
					["id" => $idkon]
				);
			}

			$search = $this->model_app->cek_total("bayar_invoice_detail", $select, $where);
			//total di invoice
			$invoice = "total_bayar AS total";
			$searchin = $this->model_app->cek_total("invoice", $invoice, $where);

			if ($searchin->total == $search->total) {
				$this->model_app->update(
					"invoice",
					[
						"lunas" => 1,
						"status" => "simpan",
						"pos" => "Y",
						"oto" => 6,
					],
					["id_invoice" => $noin]
				);
				$data = [
					"status" => 200,
					"id" => $noin,
					"total" => $search->total,
				];
				$this->model_app->update(
					"tb_users",
					["last_invoice" => 0],
					["id_user" => $this->iduser]
				);
			} else {
				$this->model_app->update(
					"invoice",
					["status" => "simpan", "pos" => "Y", "oto" => 6],
					["id_invoice" => $noin]
				);
				$this->model_app->update(
					"tb_users",
					["last_invoice" => 0],
					["id_user" => $this->iduser]
				);
				$data = [
					"status" => 200,
					"id" => $noin,
					"total" => $searchin->total,
				];
			}
		} else {
			$data = ["status" => 400, "id" => $noin, "total" => 0];
		}
		echo json_encode($data);
	}

	/**
	 * Summary of auto_save_invoice
	 * @return void
	 */
	public function auto_save_invoice()
	{
		cek_nput_post("GET");
		$id        = xss_filter($this->input->post("id"), 'xss');
		$tgli      = xss_filter($this->input->post("tglin"), 'xss');
		$tgla      = xss_filter($this->input->post("tgla"), 'xss');
		$jam       = xss_filter($this->input->post("jam"), 'xss');
		$marketing = xss_filter($this->input->post("marketing"), 'xss');

		$data = [
			"tgl_trx" => $tgli,
			"tgl_ambil" => $tgla . " " . $jam,
			"id_marketing" => $marketing,
		];
		$where = ["id_invoice" => $id];

		$res = $this->model_app->update("invoice", $data, $where);
		if ($res["status"] == "ok") {
			$data = ["ok" => "ok"];
		} else {
			$data = ["ok" => "err"];
		}
		echo json_encode($data);
	}

	/**
	 * Summary of auto_save_invoice_detail
	 * @return never
	 */
	public function auto_save_invoice_detail()
	{
		cek_nput_post("GET");
		$idorder       = xss_filter($this->input->post("id_invoice"), 'xss');
		$jml           = xss_filter($this->input->post("jml"), 'xss');
		$uangmuka      = xss_filter($this->input->post("uangmuka"), 'xss');
		$id            = xss_filter($this->input->post("id_rincianinvoice"), 'xss');
		$harga         = xss_filter($this->input->post("harga"), 'xss');
		$jumlah        = xss_filter($this->input->post("jumlah"), 'xss');
		$id_produk     = xss_filter($this->input->post("id_produk"), 'xss');
		$ket           = xss_filter($this->input->post("ket"), 'xss');
		$ukuran        = xss_filter($this->input->post("ukuran"), 'xss');
		$ukuran        = comma_to_dot($ukuran);
		$satuan        = xss_filter($this->input->post("satuan"), 'xss');
		$id_bahan      = xss_filter($this->input->post("id_bahan"), 'xss');
		$jenis         = xss_filter($this->input->post("jenis"), 'xss');
		$totukuran     = xss_filter($this->input->post("totukuran"), 'xss');
		$diskon        = xss_filter($this->input->post("diskon"), 'xss');
		$type_harga    = xss_filter($this->input->post("type_harga"), 'xss');
		$status_hitung = xss_filter($this->input->post("status_hitung"), 'xss');
		$hsatuan       = xss_filter($this->input->post("hargasatuan"), 'xss');

		if (empty($id_bahan)) {
			$id_bahan = 1;
		}
		if (empty($satuan)) {
			$satuan = "-";
		}
		if (empty($satuan)) {
			$satuan = "-";
		}

		if (empty($totukuran) or $totukuran == 'NaN') {
			$totukuran = 1;
		} else {
			if ($status_hitung > 0) {
				$totukuran = $totukuran;
			}
		}

		$harga_hpp = harga_hpp($id_bahan);

		if (!empty($totukuran) and $harga_hpp > 0) {
			$hpp = $totukuran * $harga_hpp;
		} elseif (empty($totukuran) and $harga_hpp > 0) {
			$hpp = $jumlah * $harga_hpp;
		} else {
			$hpp = 0;
		}

		$this->form_validation->set_rules(array(
			array(
				'field' => 'ukuran',
				'label' => 'Ukuran',
				'rules' => 'required|trim|min_length[1]|max_length[20]',
				'errors' => array(
					'required' => '%s. Harus di isi',
					'min_length' => '%s minimal 20 digit.',
					'max_length' => '%s minimal 20 digit.'
				)
			),

			array(
				'field' => 'ket',
				'label' => 'Keterangan',
				'rules' => 'trim|min_length[1]|max_length[50]',
				'errors' => array(
					'min_length' => '%s minimal 1 digit.',
					'max_length' => '%s minimal 50 digit.'
				)
			),
		));

		if ($this->form_validation->run() == FALSE) {
			$response['status'] = false;
			$response['msg'] = validation_errors();
		} else {
			$this->model_app->update("invoice", ['total_bayar' => $jml], ['id_invoice' => $idorder]);
			//where
			$where = ["id_rincianinvoice" => $id];
			//execute
			$cek_harga = $this->model_app->view_where("bahan", ["id" => $id_bahan]);
			$row = $cek_harga->row();
			$type_harga = $row->type_harga;

			$harga_jual = $row->harga_jual;
			if ($harga < $harga_jual and $harga > 0 and $totukuran >= 1 and $type_harga == 1) {
				$response = [
					"status" => 401,
					"harga" => rp($harga_jual),
					"msg" => "Harga dibawah harga modal (RUGI DONG)",
				];

				$data_array = [
					"id_produk" => $id_produk,
					"jumlah" => $jumlah,
					"harga" => $harga_jual,
					"ukuran" => $ukuran,
					"satuan" => $satuan,
					"id_satuan" => $satuan,
					"keterangan" => $ket,
					"id_bahan" => $id_bahan,
					"jenis_cetakan" => $jenis,
					"type_harga" => $type_harga,
					"status_hitung" => $status_hitung,
					"tot_ukuran" => $totukuran,
					"hpp" => $hpp,
					"diskon" => $diskon,
					"kunci" => 0,
				];


				$this->model_app->update("invoice_detail", $data_array, $where);
			} else {
				if (empty($id_produk)) {
					$id_produk = 1;
				}

				if (empty($jenis)) {
					$jenis = 1;
				}

				if (empty($totukuran)) {
					$totukuran = 1;
				}

				$cek_harga = $this->model_app->view_where("harga", [
					"title" => $harga,
				]);

				$_reload = $this->model_app
					->view_where("invoice_detail", $where)
					->row_array();
				if ($jml < $uangmuka) {
					$response = [
						"status" => 400,
						"jml" => $_reload["jumlah"],
						"harga" => $_reload["harga"],
						"diskon" => $_reload["diskon"],
						"ukuran" => $_reload["ukuran"],
					];
				} else {
					$data_array = [
						"id_produk" => $id_produk,
						"jumlah" => $jumlah,
						"harga" => $harga,
						"ukuran" => $ukuran,
						"satuan" => $satuan,
						"id_satuan" => $satuan,
						"keterangan" => $ket,
						"id_bahan" => $id_bahan,
						"jenis_cetakan" => $jenis,
						"type_harga" => $type_harga,
						"status_hitung" => $status_hitung,
						"tot_ukuran" => $totukuran,
						"hpp" => $hpp,
						"diskon" => $diskon,
						"kunci" => 0,
					];

					$res = $this->model_app->update(
						"invoice_detail",
						$data_array,
						$where
					);
					if ($res["status"] == "ok") {
						$response = ["status" => 200, "msg" => "Saved", 'ukuran' => $ukuran];
					} else {
						$response = ["status" => 400, "msg" => "Save Gagal"];
					}
				}
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
	 * Summary of simpan_pajak
	 * @return void
	 */
	public function simpan_pajak()
	{
		cek_nput_post("GET");
		$id    = xss_filter($this->input->post("id"), 'xss');
		$pajak = xss_filter($this->input->post("pajak"), 'xss');
		$total = xss_filter($this->input->post("totalbyr"), 'xss');
		$where = ["id_invoice" => $id];
		$data  = ["pajak" => $pajak];
		$res   = $this->model_app->update("invoice", $data, $where);
		$value = $this->hitung_pajak($total, $pajak);
		if ($res["status"] == "ok") {
			$data = [
				"ok" => "ok",
				"pajak" => $pajak,
				"total_pajak" => $value['total_pajak'],
				'total_bayar' => $value['total_bayar']
			];
		} else {
			$data = ["ok" => "err", "pajak" => 0, 'total_pajak' => 0, 'total_bayar' => 0];
		}
		echo json_encode($data);
	}

	private function hitung_pajak($total, $pajak)
	{
		if ($pajak > 0) {
			$hitung = ($total * $pajak) / 100;
			return ['total_pajak' => $hitung, 'total_bayar' => $total + $hitung];
		} else {
			return ['total_pajak' => 0, 'total_bayar' => $total];
		}
	}
	/**
	 * Summary of bayar_detail
	 * @return void
	 */
	public function bayar_detail()
	{
		cek_nput_post("GET");
		$id = $this->input->post("id");
		$select = "SUM(jml_bayar) AS `total`";
		$where = ["id_invoice" => $id];
		$search = $this->model_app->cek_total(
			"bayar_invoice_detail` ",
			$select,
			$where
		);
		// print_r($search);
		if (!empty($search->total)) {
			$data = $search->total;
		} else {
			$data = 0;
		}
		$this->output
			->set_content_type("application/json")
			->set_output(json_encode($data));
	}

	/**
	 * Summary of cek_jml_bayar
	 * @return void
	 */
	public function cek_jml_bayar()
	{
		cek_nput_post("GET");
		$id = $this->input->post("id");
		$select = "total_bayar AS total";
		$where = ["id_invoice" => $id];
		$search = $this->model_app->cek_total("invoice", $select, $where);
		if (!empty($search->total)) {
			$data = $search->total;
		} else {
			$data = 0;
		}
		$this->output
			->set_content_type("application/json")
			->set_output(json_encode($data));
	}

	/**
	 * Summary of cek_total_detail
	 * @return void
	 */
	public function cek_total_detail()
	{
		cek_nput_post("GET");
		$id = $this->input->post("id");
		$select = "SUM(jumlah * harga) AS `total`";
		$where = ["id_invoice" => $id];
		$search = $this->model_app->cek_total(
			"invoice_detail",
			$select,
			$where
		);
		if (!empty($search->total)) {
			$data = $search->total;
		} else {
			$data = 0;
		}
		$this->output
			->set_content_type("application/json")
			->set_output(json_encode($data));
	}

	/**
	 * Summary of cek_data_total
	 * @return void
	 */
	public function cek_data_total()
	{
		cek_nput_post("GET");
		$id = $this->input->post("id");
		$iduser = $this->input->post("iduser");
		$pajak = $this->input->post("pajak");
		$where = ["id_invoice" => $id];
		$invoice = "total_bayar AS total";
		$searchin = $this->model_app->cek_total("invoice", $invoice, $where);
		//cek konsumen
		$idkon = $this->model_app->view_where("invoice", $where)->row();

		$this->cek_boleh_utang($idkon->id_konsumen, $id);

		//diskon
		$sisa =
			"ROUND(SUM((`invoice_detail`.`jumlah`) * (`invoice_detail`.`harga` * `invoice_detail`.`diskon`/100))) AS sisa";
		$cari_sisa = $this->model_app->cek_total(
			"invoice_detail",
			$sisa,
			$where
		);
		////
		$select = "SUM(jumlah * harga) AS `total`";
		$search = $this->model_app->cek_total(
			"invoice_detail",
			$select,
			$where
		);
		$total_detail = $search->total - $cari_sisa->sisa;
		$kurangpajak = $searchin->total - $total_detail;
		$total_bayar = $searchin->total - $kurangpajak;
		if ($total_detail == $total_bayar and $pajak > 0) {
			$data = [
				"urutan" => 1,
				"ok" => "ok",
				"id" => $id,
				"iduser" => $iduser,
				"total" => $total_detail,
			];
		} elseif ($total_detail == $searchin->total and $pajak == 0) {
			$data = [
				"urutan" => 2,
				"ok" => "ok",
				"id" => $id,
				"idkon" => $idkon->id_konsumen,
				"iduser" => $iduser,
				"total" => $total_detail,
			];
		} else {
			$data = [
				"urutan" => 3,
				"ok" => "err",
				"id" => $id,
				"idkon" => $idkon->id_konsumen,
				"iduser" => $iduser,
				"total" => 0,
				"tipe" => "simpan_cetak",
			];
		}
		// echo json_encode($data);
		$this->output
			->set_content_type("application/json")
			->set_output(json_encode($data));
	}

	/**
	 * cek_di_invoice
	 *
	 * @return void
	 */
	public function cek_di_invoice()
	{
		cek_nput_post("GET");
		$id = $this->input->post("id");
		$total = $this->input->post("total");
		$pajak = $this->input->post("pajak");
		$where = ["id_invoice" => $id];
		// $invoice = 'total_bayar AS total';
		$invoice = "SUM(total_bayar) AS `total`";
		//cek konsumen
		$idkon = $this->model_app->view_where("invoice", $where)->row();
		//cek total invoice
		$searchin = $this->model_app->cek_total("invoice", $invoice, $where);
		//cek pajak di invoice

		//diskon`/100
		$sisa =
			"ROUND(SUM((`invoice_detail`.`jumlah` * `invoice_detail`.`harga`) - (`invoice_detail`.`jumlah` * `invoice_detail`.`harga` * `invoice_detail`.`diskon`/100))) AS sisa";
		$cari_sisa = $this->model_app->cek_total(
			"invoice_detail",
			$sisa,
			$where
		);
		//invoice_detail
		$select = "SUM(jumlah * harga) AS `total`";
		$search = $this->model_app->cek_total(
			"invoice_detail",
			$select,
			$where
		);
		$total_detail = $cari_sisa->sisa;
		if ($pajak > 0) {
			$pajak = $pajak;
			$total_detail = $total_detail + ($total_detail * $pajak) / 100;
		}
		if ($total_detail == $searchin->total and $pajak == 0) {
			$data = [
				"ok" => "ok",
				"id" => $id,
				"idkon" => $idkon->id_konsumen,
				"total" => $search->total,
			];
		} elseif ($total_detail == $searchin->total and $pajak > 0) {
			$data = [
				"ok" => "ok",
				"id" => $id,
				"idkon" => $idkon->id_konsumen,
				"total" => $search->total,
			];
		} else {
			$data = [
				"ok" => "err",
				"id" => $id,
				"idkon" => $idkon->id_konsumen,
				"total_1" => $searchin->total,
				"total_2" => $search->total,
				"sisa" => $cari_sisa->sisa,
				"total" => $total_detail,
				"tipe" => "simpan",
			];
		}
		$this->output
			->set_content_type("application/json")
			->set_output(json_encode($data));
	}

	/**
	 * Summary of update_data
	 * @return void
	 */
	public function update_data()
	{
		cek_nput_post("GET");
		$id = $this->input->post("id");
		$iduser = $this->input->post("iduser");
		$idlunas = $this->input->post("idlunas");
		$total = $this->input->post("total");
		$tipe = $this->input->post("tipe");
		$data = ["total_bayar" => $total];
		$where = ["id_invoice" => $id];
		$idkon = $this->model_app->view_where("invoice", $where)->row();
		$search = $this->model_app->update("invoice", $data, $where);

		//sum detail
		$cdetail = $this->model_app->cek_total(
			"invoice_detail",
			"SUM(jumlah * harga) AS `jml`",
			["id_invoice" => $id]
		);
		if ($idlunas == 1 and $cdetail->jml != $total) {
			$this->model_app->update("invoice", ["lunas" => 0], $where);
		}

		//end
		if ($search["status"] == "ok") {
			$this->model_app->update(
				"tb_users",
				["last_invoice" => $id],
				["id_user" => $iduser]
			);
			$data = [
				"ok" => "ok",
				"id" => encrypt_url($id),
				"idkon" => $idkon->id_konsumen,
				"tipe" => $tipe,
				"total" => $total,
			];
		} else {
			$data = [
				"ok" => "err",
				"id" => 0,
				"idkon" => 0,
				"tipe" => "",
				"total" => 0,
			];
		}
		$this->output
			->set_content_type("application/json")
			->set_output(json_encode($data));
	}

	/**
	 * Summary of update_lunas
	 * @return void
	 */
	public function update_lunas()
	{
		cek_nput_post("GET");
		$noin = $this->input->post("id");
		$iduser = $this->input->post("iduser");
		$total = $this->input->post("total");
		$status = $this->input->post("status");

		if ($noin != null and $total > 0) {

			//cek jml bayar
			$select = "SUM(jml_bayar) AS `total`";
			$where = ["id_invoice" => $noin];
			$search = $this->model_app->cek_total(
				"bayar_invoice_detail`",
				$select,
				$where
			);
			//total di invoice
			$invoice = "total_bayar AS total, potongan_harga AS diskon, cashback AS cashback";
			$searchin = $this->model_app->cek_total(
				"invoice",
				$invoice,
				$where
			);
			$total_bayar = $search->total;
			if ($searchin->diskon > 0) {
				$total_bayar = $search->total + $searchin->diskon;
			}

			if ($searchin->total == $total_bayar) {
				$this->model_app->update(
					"invoice",
					["lunas" => 1],
					["id_invoice" => $noin]
				);
				$data = [
					"ok" => "ok",
					"id" => $noin,
					"iduser" => $iduser,
					"total" => $search->total,
					"lunas" => 'Y',
				];
			} else {
				$data = [
					"ok" => "ok",
					"id" => $noin,
					"iduser" => $iduser,
					"total" => $searchin->total,
					"lunas" => 'N',
				];
			}
		}
		$this->output
			->set_content_type("application/json")
			->set_output(json_encode($data));
	}

	/**
	 * Summary of trx
	 * @param mixed $id
	 * @return void
	 */
	public function trx($id = "")
	{
		$data["id"] = $id;
		$conditions["returnType"] = "count";
		$totalRec = $this->model_data->getRows($conditions);

		// Pagination configuration
		$config["target"] = "#dataList";
		$config["base_url"] = base_url("penjualan/ajaxPaginationData");
		$config["total_rows"] = $totalRec;
		$config["per_page"] = $this->perPage;

		// Initialize pagination library
		$this->ajax_pagination->initialize($config);

		// Get records
		$conditions = [
			"limit" => $this->perPage,
		];
		$data["posts"] = $this->model_data->getRows($conditions);

		$this->load->view("penjualan/trx", $data);
	}

	/**
	 * Summary of order
	 * @return void
	 */
	public function order()
	{
		cek_menu_akses();
		cek_crud_akses(8);
		$this->template->set("title", "Data order | " . $this->title);
		$data["id"] = "";
		$data["tgl"] = "";
		$data["select"] = [
			0 => "SEMUA",
			1 => "LUNAS",
			2 => "BELUM LUNAS",
			"baru" => "BARU",
			"pending" => "PENDING",
			"edit" => "EDIT",
			"batal" => "BATAL",
		];

		$this->template->load("main/themes", "penjualan/order", $data);
	}

	/**
	 * Summary of ajaxPaginationData
	 * @return void
	 */
	function ajaxPaginationData()
	{
		cek_nput_post("GET");
		$page = $this->input->post("page");
		if (!$page) {
			$offset = 0;
		} else {
			$offset = $page;
		}

		$limits = $this->input->post("limits");
		if (!empty($limits)) {
			$limit = $limits;
		} else {
			$limit = $this->perPage;
		}
		// Set conditions for search and filter
		$keywords = $this->input->post("keywords");
		$sortBy = $this->input->post("sortBy");
		$trx = $this->input->post("trx");
		$tgl = $this->input->post("tgl");

		$data['tanggal']	= 'TANGGAL : ' . day_ymd();
		if (!empty($trx)) {
			$conditions["search"]["trx"] = $trx;
		}
		if (!empty($keywords)) {
			if (substr(trim(strtoupper($keywords)), 0, 4) == NOMOR_TRX) {
				$conditions["search"]["keywords"] = $keywords;
				$arr["a"] = "a";
			} elseif (substr(trim($keywords), 0, 1) == "0") {
				$conditions["search"]["keywords"] = $keywords;
				$arr["a"] = "b";
			} elseif (substr(trim($keywords), 0, 2) == "62") {
				$conditions["search"]["keywords"] = clearnohp($keywords);
				$arr["a"] = "c";
			} elseif (substr(trim($keywords), 0, 3) == "+62") {
				$conditions["search"]["keywords"] = clearnohp($keywords);
				$arr["a"] = "d";
			} elseif (is_numeric($keywords)) {
				$conditions["where"] = ["id_invoice" => $keywords];
				$arr["a"] = "e";
			} elseif (substr(trim($keywords), 0, 1) == "#") {
				$conditions["search"]["keywords"] = clean($keywords);
				$arr["a"] = "f";
			} else {
				$conditions["search"]["keywords"] = trim($keywords);
				$arr["a"] = "g";
			}
			// print_r($arr);
		}
		if (!empty($sortBy)) {
			$conditions["search"]["sortBy"] = $sortBy;
		}
		if (!empty($limits)) {
			$conditions["search"]["limits"] = $limits;
		}
		if (!empty($tgl)) {
			$date = date_ranges($tgl);
			$dari = date_replace_slash($date['dari']);
			$sampai = date_replace_slash($date['sampai']);
			$conditions["search"]["dari"] = $dari;
			$conditions["search"]["sampai"] = $sampai;
			if (strtotime($dari) == strtotime($sampai)) {
				$data['tanggal']	= 'TANGGAL : ' . $date['dari'];
			} else {
				$data['tanggal']	= 'PEROIDE : ' . $date['dari'] . ' - ' . $date['sampai'];
			}
		}
		// dump($conditions);
		// Get record count
		$conditions["returnType"] = "count";
		$totalRec = $this->model_data->getRows($conditions);

		// Pagination configuration
		$config["target"] = "#dataList";
		$config["base_url"] = base_url("penjualan/ajaxPaginationData");
		$config["total_rows"] = $totalRec;
		$config["per_page"] = $limit;
		$config["link_func"] = "searchFilter";

		// Initialize pagination library
		$this->ajax_pagination->initialize($config);

		// Get records
		$conditions["start"] = $offset;
		$conditions["limit"] = $limit;
		// if (!empty($sortBy)) {
		// $conditions["search"]["sortBy"] = $sortBy;
		// }
		// if (!empty($limits)) {
		// $conditions["search"]["limits"] = $limits;
		// }

		unset($conditions["returnType"]);

		$data["posts"] = $this->model_data->getRows($conditions);

		// Load the data list view
		$this->load->view("penjualan/ajax-order", $data, false);
	}

	/**
	 * Summary of pending_data
	 * @return void
	 */
	public function pending_data()
	{
		cek_nput_post("GET");
		$noin = $this->input->post("id");
		$cari_pending = $this->model_app->view_where("invoice", [
			"status" => "pending",
			"id_invoice" => $noin,
		]);
		if ($cari_pending->num_rows() > 0) {
			$data = ["ok" => "pending"];
		} else {
			$res = $this->model_app->update(
				"invoice",
				[
					"pos" => "N",
					"status" => "pending",
					"id_user" => $this->iduser,
				],
				["id_invoice" => $noin]
			);
			if ($res["status"] == "ok") {
				$this->model_app->update(
					"tb_users",
					["last_invoice" => 0],
					["id_user" => $this->iduser]
				);
				$this->session->unset_userdata("cart");
				$data = ["ok" => "ok"];
			} else {
				$data = ["ok" => "err"];
			}
		}
		$this->output
			->set_content_type("application/json")
			->set_output(json_encode($data));
	}

	/**
	 * Summary of grafik
	 * @return void
	 */
	public function grafik()
	{
		$page = $this->input->post("bulan");
		$hari = date("d");
		if (!empty($page)) {
			$bulan = $page;
		} else {
			$bulan = date("m");
		}
		$tahun = date("Y");
		$totalRec = $this->model_data->grafik_perbulan($bulan, $tahun);
		$hasil = [];
		if (!empty($totalRec)) {
			foreach ($totalRec as $row) {
				$hasil["omset"][] = [
					"total" => $row->jml_bayar,
					"tanggal" => "TGL." . $row->hari,
				];
			}
		} else {
			$hasil["omset"][] = [
				"total" => 0,
				"tanggal" =>  "TGL." . $hari,
			];
		}
		$bulan = ["bulan" => getBulan($bulan)];
		$array_merge = array_merge($hasil, $bulan);
		// print_r($array_merge);exit;
		echo json_encode($array_merge);
	}

	/**
	 * Summary of grafik_desain
	 * @return void
	 */
	public function grafik_desain()
	{
		$page = $this->input->post("bulan");
		$hari = date("d");
		if (!empty($page)) {
			$bulan = $page;
		} else {
			$bulan = date("m");
		}
		$tahun = date("Y");
		$where = ["id_desain" => $this->iduser];
		$totalRec = $this->model_data->grafik_perbulan_desain(
			$bulan,
			$tahun,
			$where
		);
		$hasil = [];
		if (!empty($totalRec)) {
			foreach ($totalRec as $row) {
				$hasil["omset"][] = [
					"total" => $row->counter,
					"tanggal" => "TGL." . $row->hari,
				];
			}
		} else {
			$hasil["omset"][] = [
				"total" => 0,
				"tanggal" =>  "TGL." . $hari,
			];
		}
		$bulan = ["bulan" => getBulan($bulan)];
		$array_merge = array_merge($hasil, $bulan);
		echo json_encode($array_merge);
	}

	/**
	 * Summary of ajaxKonsumen
	 * @return void
	 */
	function ajaxKonsumen()
	{
		cek_nput_post("GET");
		$page = $this->input->post("page");
		if (!$page) {
			$offset = 0;
		} else {
			$offset = $page;
		}

		$limits = $this->input->post("limits");
		if (!empty($limits)) {
			$limit = $limits;
		} else {
			$limit = $this->perPage;
		}
		// Set conditions for search and filter
		$keywords = $this->input->post("keywords");
		$sortBy = $this->input->post("sortBy");

		if (!empty($keywords)) {
			$conditions["search"]["keywords"] = $keywords;
		}
		if (!empty($sortBy)) {
			$conditions["search"]["sortBy"] = $sortBy;
		}
		if (!empty($limits)) {
			$conditions["search"]["limits"] = $limits;
		}

		// Get record count
		$conditions["returnType"] = "count";
		$totalRec = $this->model_data->getKonsumen($conditions);

		// Pagination configuration
		$config["target"] = "#dataListKonsumen";
		$config["base_url"] = base_url("konsumen/ajaxKonsumen");
		$config["total_rows"] = $totalRec;
		$config["per_page"] = $limit;
		$config["link_func"] = "searchFilterKonsumen";

		// Initialize pagination library
		$this->ajax_pagination->initialize($config);

		// Get records
		$conditions["start"] = $offset;
		$conditions["limit"] = $limit;
		unset($conditions["returnType"]);
		$data["posts"] = $this->model_data->getKonsumen($conditions);

		// Load the data list view
		$this->load->view("konsumen/ajax-konsumen", $data, false);
	}

	/**
	 * Summary of cek_harga_type
	 * @return never
	 */
	public function cek_harga_type()
	{
		$cari_produk = $this->input->post("cari_produk");
		$id_konsumen = $this->input->post("id_konsumen_cari");
		$id_detail = $this->input->post("id_detail");
		$invoice_add = $this->input->post("invoice_add");
		$id_member = $this->input->post("idmember_add");
		// $id_member = $this->model_app->pilih_where('jenis_member','konsumen',['id'=>$id_konsumen])->row()->jenis_member;

		if (!empty($cari_produk) and (int)$cari_produk) {

			$result = $this->cari_produk($cari_produk);
			if ($result != false) {
				$row = $result->row();
				$id_bahan = explode(',', $row->id_bahan);
				$id_bahan = $id_bahan[0];
				$this->cek_stok($id_bahan, 1);
				$getBahan = getDetailBahan($id_bahan);
				$array = ['type_harga' => $getBahan->type_harga, 'id_bahan' => $row->id_bahan, 'id_member' => $id_member];
				$getHarga = $this->model_data->getHarga($array);

				$data_insert = [
					'id_invoice' => $invoice_add,
					'id_produk' => $row->id,
					'jenis_cetakan' => $row->id_jenis,
					'status_hitung' => $getBahan->status,
					'type_harga' => $getBahan->type_harga,
					'jumlah' => $row->jumlah,
					'harga' => $getHarga['harga'],
					'id_satuan' => $getHarga['satuan'],
					'ukuran' => $row->ukuran,
					'id_bahan' => $getHarga['id_bahan'],
				];
				$addDetail = $this->addDetail($data_insert);

				if ($addDetail['status'] == true) {

					$data = [
						'status' => 'qr',
						'id' => $addDetail['id'],
						'kodeproduk' => $row->title,
						'id_produk' => $row->id,
						'harga' => $getHarga['harga'],
						'jenis_cetakan' => $row->jenis_cetakan,
						'id_jenis' => $row->id_jenis,
						'bahan' => $getHarga['title'],
						'id_bahan' => $getHarga['id_bahan'],
						'status_hitung' => $getBahan->status,
						'type_harga' => $getBahan->type_harga,
						'id_satuan' => $getHarga['satuan'],
						'ukuran' => $row->ukuran,
						'jumlah' => $row->jumlah,
						'lock_harga' => $row->lock_harga,
						'iddetail' => $id_detail,
					];
				} else {
					$data = ['status' => false, 'msg' => 'qr 1'];
				}
			} else {
				$data = ['status' => false, 'msg' => 'qr 2'];
			}
		} else {
			$id_bahan = (!empty($this->input->post('id_bahan')) ? $this->input->post('id_bahan') : 0);
			$jumlah = (!empty($this->input->post('jumlah')) ? $this->input->post('jumlah') : 0);

			$type_harga = $this->input->post("type_harga");
			$harga_jual = $satuan = 0;

			$this->cek_stok($id_bahan, $jumlah);

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
					$sql = $this->db->query("select id,id_satuan,harga_modal from bahan where id=$id_bahan");
					$harga_jual = $sql->row()->harga_modal;
					$satuan = $sql->row()->id_satuan;
				}
				$data = ['status' => true, 'harga' => $harga_jual, 'satuan' => $satuan, 'id_bahan' => $id_bahan];
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
				if ($sql2->num_rows() > 0) {
					$harga_jual = $sql2->row()->harga_jual;
					$satuan = $sql2->row()->id_satuan;
				} else {
					$sql = $this->db->query("select id,id_satuan,harga_modal from bahan where id=$id_bahan");
					$harga_jual = $sql->row()->harga_modal;
					$satuan = $sql->row()->id_satuan;
				}
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
				$sql = $this->db->query("select id_satuan,harga_jual from range_harga where id_bahan=$id_bahan AND $jumlah between jumlah_minimal and jumlah_maksimal");
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
				$sql4 = $this->db->query("select id_satuan,harga_jual from harga_range_member where id_bahan=$id_bahan AND id_member='$id_member' AND $jumlah between jumlah_minimal and jumlah_maksimal");
				if ($sql4->num_rows() > 0) {
					$harga_jual = $sql4->row()->harga_jual;
					$satuan = $sql4->row()->id_satuan;
				} else {
					$sql = $this->db->query("select id,id_satuan,harga_modal from bahan where id=$id_bahan");
					$harga_jual = $sql->row()->harga_modal;
					$satuan = $sql->row()->id_satuan;
				}
				$data = ['status' => true, 'harga' => $harga_jual, 'satuan' => $satuan, 'type_harga' => $type_harga];
			} else {
				$sql = $this->db->query("select id,id_satuan,harga_modal from bahan where id=$id_bahan");
				$harga_jual = $sql->row()->harga_modal;
				$satuan = $sql->row()->id_satuan;
				$data = ['status' => true, 'harga' => $harga_jual, 'satuan' => $satuan, 'type_harga' => $type_harga];
			}
		}

		$this->output
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
			->_display();
		exit;
	}
	/**
	 * Summary of addDetail
	 * @param mixed $param
	 * @return array
	 */
	private function addDetail($param = array())
	{

		$res = $this->db->insert("invoice_detail", $param);
		$last_id = $this->db->insert_id();
		if ($res == true) {
			$data = ["status" => true, "id" => $last_id];
		} else {
			$data = ["status" => false, "id" => 0];
		}
		return $data;
	}

	/**
	 * Summary of cari_produk
	 * @param mixed $name
	 * @return mixed
	 */
	private function cari_produk($name)
	{
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
			where `produk`.`barcode`='" . $name . "' AND produk.pub='1'";
		$result = $this->db->query($query);
		if ($result->num_rows() > 0) {
			return $result;
		} else {
			return false;
		}
	}

	/**
	 * Summary of update_detail
	 * @return void
	 */
	public function update_detail()
	{
		$id_konsumen = $this->input->post("idkonsumen");
		$id_bahan    = $this->input->post("idbahan");
		$jumlah      = $this->input->post("jumlah");
		$baris       = $this->input->post("baris");
		$totukuran   = $this->input->post("totukuran");

		$cek_status = $this->model_app->pilih_where('status_stok,type_harga,id_satuan,status', 'bahan', ['id' => $id_bahan])->row();
		$cek_satuan = $this->model_app->pilih_where('satuan', 'satuan', ['id' => $cek_status->id_satuan])->row();
		$type_harga = $cek_status->type_harga;

		if ($cek_status->status_stok == 'Y') {
			$this->cek_stok($id_bahan, $jumlah);
		}

		$status = $cek_status->status;

		if ($status > 0) {
			$jml = $totukuran / $jumlah;
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
			if ($sql1->num_rows() > 0) {
				$harga_jual = $sql1->row()->harga_jual * $jml;
				$satuan = $sql1->row()->idsatuan;
			} else {
				$sql = $this->db->query("select id,id_satuan,harga_modal from bahan where id=$id_bahan");
				$harga_jual = $sql->row()->harga_modal;
				$satuan = $sql->row()->id_satuan;
			}
			$data = ['status' => true, 'harga' => rp($harga_jual), 'satuan' => $satuan, 'id_bahan' => $id_bahan];
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
			if ($sql2->num_rows() > 0) {
				$harga_jual = $sql2->row()->harga_jual * $jml;
				$satuan = $sql2->row()->id_satuan;
			} else {
				$sql = $this->db->query("select id,id_satuan,harga_modal from bahan where id=$id_bahan");
				$harga_jual = $sql->row()->harga_modal;
				$satuan = $sql->row()->id_satuan;
			}
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
				$harga_jual = $sql3->row()->harga_jual * $jml;
				$satuan = $sql3->row()->id_satuan;
			} else {
				$sql = $this->db->query("select id,id_satuan,harga_modal from bahan where id=$id_bahan");
				$harga_jual = $sql->row()->harga_modal;
				$satuan = $sql->row()->id_satuan;
			}
			$data = ['status' => true, 'harga' => $harga_jual, 'satuan' => $satuan, 'type_harga' => $type_harga];
		} elseif ($type_harga == 4) {
			$sql = $this->db->query("select id_satuan,harga_jual from range_harga where id_bahan=$id_bahan AND $jumlah between jumlah_minimal and jumlah_maksimal");
			if ($sql->num_rows() > 0) {
				$harga_jual = $sql->row()->harga_jual * $jml;
				$satuan = $sql->row()->id_satuan;
			} else {
				$sql = $this->db->query("select id,id_satuan,harga_modal from bahan where id=$id_bahan");
				$harga_jual = $sql->row()->harga_modal;
				$satuan = $sql->row()->id_satuan;
			}
			$data = ['status' => true, 'harga' => $harga_jual, 'satuan' => $satuan, 'type_harga' => $type_harga];

			//cari type harga 5
		} elseif ($type_harga == 5) {
			$sql4 = $this->db->query("select id_satuan,harga_jual from harga_range_member where id_bahan=$id_bahan AND id_member='$id_member' AND $jumlah between jumlah_minimal and jumlah_maksimal");
			if ($sql4->num_rows() > 0) {
				$harga_jual = $sql4->row()->harga_jual * $jml;
				$satuan = $sql4->row()->id_satuan;
			} else {
				$sql = $this->db->query("select id,id_satuan,harga_modal from bahan where id=$id_bahan");
				$harga_jual = $sql->row()->harga_modal;
				$satuan = $sql->row()->id_satuan;
			}
			$data = ['status' => true, 'harga' => $harga_jual, 'satuan' => $satuan, 'type_harga' => $type_harga];
		} else {
			$sql = $this->db->query("select id,id_satuan,harga_modal from bahan where id=$id_bahan");
			$harga_jual = $sql->row()->harga_modal;
			$satuan = $sql->row()->id_satuan;
			$data = ['status' => true, 'harga' => $harga_jual, 'satuan' => $satuan, 'type_harga' => $type_harga];
		}
		echo json_encode($data);
	}

	/**
	 * Summary of cek_harga_range
	 * @return void
	 */
	public function cek_harga_range()
	{
		cek_nput_post("GET");
		$id_konsumen = $this->input->post("id_member");
		$id_member   = $this->model_app->pilih_where('jenis_member', 'konsumen', ['id' => $id_konsumen])->row()->jenis_member;
		$id_bahan    = $this->input->post("id_bahan");
		$id_satuan	 = $this->input->post("satuan");
		$harga_awal  = $this->input->post("harga");
		$jumlah      = $this->input->post("jumlah");
		$totukuran   = $this->input->post("totukuran");
		$totukuran   = $totukuran != 'NaN' ? $totukuran : 1;
		$type_harga  = $this->input->post("type_harga");
		$status_hitung  = $this->input->post("status_hitung");
		// dump($_POST);
		$this->cek_stok($id_bahan, $jumlah);

		if ($status_hitung > 0) {
			$jml = $totukuran * $jumlah;
		} else {
			$jml = $jumlah;
		}
		$get_harga_range = $this->model->get_harga_range($id_member, $id_bahan, $id_satuan, $type_harga, $jml, $harga_awal);

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($get_harga_range));
	}

	/**
	 * Summary of cek_harga_satuan
	 * @return void
	 */
	public function cek_harga_satuan()
	{
		$id_satuan     = $this->input->post("satuan");
		$id_bahan   = $this->input->post("id_bahan");
		$harga_awal = $this->input->post("harga");
		$jml        = $this->input->post("jumlah");
		$totukuran  = $this->input->post("totukuran");
		$totukuran  = $totukuran != '' ? $totukuran : 1;
		$id_member  = $this->db->escape_str($this->input->post('idmember'));
		$type_harga  = $this->input->post("type_harga");
		$status_hitung  = $this->input->post("status_hitung");

		$cek_status = $this->model_app->pilih_where('status_stok,type_harga,id_satuan,status,harga_jual', 'bahan', ['id' => $id_bahan])->row();

		$cek_satuan = $this->model_app->pilih_where('id_satuan,id_bahan', 'harga_satuan', ['id_satuan' => $id_satuan, 'id_bahan' => $id_bahan]);

		$get_satuan = $this->model_app->pilih_where('satuan,jumlah', 'satuan', ['id' => $id_satuan])->row();

		if (empty($id_satuan)) {
			$data = [
				'status' => 200,
				'harga' => rp($cek_status->harga_jual),
				'satuan' => $cek_status->id_satuan,
				'type_harga' => $type_harga,
				'msg' => 'Satuan harus dipilih'
			];
			echo json_encode($data);
			exit;
		}
		if ($cek_satuan->num_rows() == 0) {
			$data = [
				'status' => 200,
				'harga' => rp($cek_status->harga_jual),
				'satuan' => $cek_status->id_satuan,
				'type_harga' => $type_harga,
				'msg' => 'Tidak ada Harga dengan satuan ' . $get_satuan->satuan
			];
			echo json_encode($data);
			exit;
		}
		// $type_harga = $cek_status->type_harga;

		if ($cek_status->status_stok == 'Y') {
			$this->cek_stok($id_bahan, $jml);
		}

		// $status = $cek_status->status;
		if ($type_harga > 0) {
			$jumlah = (int)$totukuran * $jml;
		} else {
			$jumlah = $jml;
		}

		$get_harga_satuan = $this->model->get_harga_satuan($id_member, $id_bahan, $id_satuan, $type_harga, $jumlah, $harga_awal);

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($get_harga_satuan));
	}

	/**
	 * Summary of cek_stok
	 * @param mixed $id
	 * @param mixed $jumlah
	 * @return void
	 */
	private function cek_stok($id, $jumlah)
	{
		$cek_status = $this->model_app->pilih_where('status_stok', 'bahan', ['id' => $id])->row()->status_stok;
		if ($cek_status == 'Y') {
			$jml_masuk = stok_masuk($id);
			$jml_keluar = stok_keluar($id);
			$total = $jml_masuk - $jml_keluar;
			if ($jumlah > $total and $jumlah > 0) {
				$data = ['status' => false, 'msg' => 'sisa stok ' . $total, 'stok' => $total];
				$this->output
					->set_content_type('application/json', 'utf-8')
					->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
					->_display();
				exit;
			}
		}
	}

	/**
	 * Summary of cek_boleh_utang
	 * @param mixed $id_konsumen
	 * @param mixed $id_invoice
	 * @return void
	 */
	private function cek_boleh_utang($id_konsumen, $id_invoice)
	{
		$max_utang = $this->model_app
			->pilih_where("max_utang,status", "konsumen", ["id" => $id_konsumen])
			->row();

		$cek_bayar = $this->model_app->cek_total("bayar_invoice_detail", "SUM(jml_bayar) AS `total`", ['id_invoice' => $id_invoice]);

		if ($max_utang->max_utang == 0 and $max_utang->status == 0 and $cek_bayar->total == 0) {
			$data = ["status" => 'harus_dp', "id" => $id_invoice, "msg" => 'Belum ada pembayaran'];
			$this->output
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
				->_display();
			exit;
		}
	}

	/**
	 * Summary of save_bayar_piutang
	 * @return void
	 */
	public function save_bayar_piutang()
	{
		cek_nput_post("GET");
		// dump($_POST);
		$lampiran = "";
		$arr = [];
		if (!empty($_FILES["lampiran"]["name"])) {
			$config["upload_path"] = "./uploads/lampiran/";
			$config["allowed_types"] = "jpeg|jpg|png|webp";
			$config["max_size"] = "1000"; // kb
			$this->load->library("upload", $config);
			$this->upload->initialize($config);
			// if (!empty($_FILES["lampiran"]["name"])) {
			if (!$this->upload->do_upload("lampiran")) {

				$alert = [
					"status" => 301,
					"msg" => $this->upload->display_errors(),
					"id" => 0,
					"uang" => 0,
					"total" => 0,
				];
				$this->output
					->set_content_type('application/json', 'utf-8')
					->set_output(json_encode($alert, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
					->_display();
				exit;
			} else {
				$data = $this->upload->data();
				$lampiran = $data["file_name"];
			}
		}
		// exit;
		$type         = xss_filter($this->input->post("type"), 'xss');
		$status       = xss_filter($this->input->post("status_bayar"), 'xss');
		$noin         = $this->input->post("noin");
		$no_order     = decrypt_url($noin);
		$id_bayar     = xss_filter($this->input->post("id_byr"), 'xss');
		$nourut        = xss_filter($this->input->post("nourut"), 'xss');
		$rekening     = xss_filter($this->input->post("rekening"), 'xss');
		$jml_bayar    = xss_filter($this->input->post("uang"), 'xss');
		$sisabayar    = xss_filter($this->input->post("sisabayar"), 'xss');
		$jumlah_bayar = xss_filter($this->input->post("jumlah_bayar"), 'xss');
		$kembalian    = xss_filter($this->input->post("kembalian"), 'xss');
		$getIdAkun = getIdAkun($id_bayar);

		$sisa        = 0;
		$alert        = [];
		if ($type     == "simpan_bayar") {
			$this->session->unset_userdata("cart");
			$id_konsumen = get_id_transaksi($no_order)['idkonsumen'];
			$reff = 'I-' . $no_order;
			$nama = cekKonsumen($id_konsumen)['nama'];
			$catat =  $nama . " No.Order. :" . "$no_order";

			$_diskon = "ROUND(SUM((`invoice_detail`.`jumlah`) * (`invoice_detail`.`harga` * `invoice_detail`.`diskon`/100))) AS diskon";


			$data_bayar = [
				"id_invoice" => $no_order,
				"tgl_bayar" => date("Y-m-d"),
				"jam_bayar" => date("H:i:s"),
				"jml_bayar" => $jml_bayar,
				"id_bayar" => $id_bayar,
				"id_sub_bayar" => $getIdAkun,
				"urutan" => $nourut,
				"lampiran" => $lampiran,
				"id_user" => $this->iduser,
			];

			$catatan = "Pendapatan INVOICE NO.#" . $no_order;

			if ($no_order != null and $jml_bayar > 0) {
				$this->model_app->update("invoice", ["pos" => 'Y', "status" => 'simpan'], ["id_invoice" => $no_order]);
				$cek_lunas = $this->cek_lunas($no_order);
				if ($cek_lunas == true) {
					$input = $this->model_app->input("bayar_invoice_detail", $data_bayar);

					$this->kas_masuk();

					$cek_diskon = $this->model_app->cek_total("invoice_detail", $_diskon, ["id_invoice" => $no_order])->diskon;
					$sum_detail = $this->model->cek_total_detail($no_order);
					$cek_total_bayar = $this->model->cek_total_bayar($no_order);
					$sisa = $sum_detail - $cek_total_bayar -  $cek_diskon; //piutang
					$cek_bayar = $this->model_jurnal->cek_bayar($no_order)->row();
					if ($status == 'baru' or $status == 'edit') {
						$this->model_jurnal->hapus_jurnal($no_order);
						$this->model_jurnal->hapus_kas_masuk($catatan);
						if ($input["status"] == "ok") {

							//hapus jurnal
							if ($sisa > 0) {
								if ($cek_total_bayar > 0) {
									$cek_bayar = $this->model_jurnal->cek_bayar($no_order)->row();
									$id_akunbyr = $cek_bayar->id_sub_bayar;
									$jml_bay 	= $cek_bayar->jml_bayar;
									$this->model_jurnal->input_jurnal_debet($id_akunbyr, $reff, $jml_bay, $catat);
									$this->model_app->update("bayar_invoice_detail", ["rekap" => 'Y'], ["id_invoice" => $no_order]);
								}
								//piutang
								$id_akun_piutang = 112;
								$this->model_jurnal->input_jurnal_debet($id_akun_piutang, $reff, $sisa, $catat);
							} else {
								$row = $this->model_jurnal->cek_bayar_byid($no_order);

								$id_akunbyr = $row->id_sub_bayar;
								$jml_bay 	= $row->total;
								$this->model_jurnal->input_jurnal_debet($id_akunbyr, $reff, $jml_bay, $catat);
								$this->model_app->update("bayar_invoice_detail", ["rekap" => 'Y'], ["id_invoice" => $no_order]);
							}

							$this->model_jurnal->input_jurnal_kredit(411, $reff, $sum_detail, $catat);
							if ($sisa == 0) {
								$arr['a'] = 1;
								$this->model_app->update(
									"invoice",
									["pos" => 'Y', "lunas" => 1, "status" => 'simpan'],
									["id_invoice" => $no_order]
								);
								$alert = [
									"status" => 200,
									"id" => $no_order,
									"uang" => $jml_bayar,
									"total" => $cek_bayar,
									"msg" => $arr,
									"sisa" => $sisa
								];
							} else {
								$this->model_app->update(
									"invoice",
									["pos" => 'Y', "status" => 'simpan'],
									["id_invoice" => $no_order]
								);
								$arr['a'] = 2;
								$alert = [
									"status" => 200,
									"id" => $no_order,
									"uang" => $jml_bayar,
									"total" => $cek_total_bayar,
									"msg" => $arr,
									"sisa" => $sisa
								];
							}
						} else {
							$alert = [
								"status" => 304,
								"id" => 0,
								"uang" => 0,
								"total" => 0,
								"sisa" => $sisa
							];
						}
					} elseif ($status == 'simpan') {


						if ($input["status"] == "ok") {


							$cek_count = $this->model_jurnal->cek_count($no_order);

							//bayar awal
							if ($sisa > 0 and $cek_count == 1) {


								$id_akunbyr = $cek_bayar->id_sub_bayar;
								$jml_bay 	= $cek_bayar->jml_bayar;
								$this->model_jurnal->input_jurnal_debet($id_akunbyr, $reff, $jml_bay, $catat);
								$this->model_app->update("bayar_invoice_detail", ["rekap" => 'Y'], ["id_invoice" => $no_order]);

								//piutang
								$id_akun_piutang = 112;
								$this->model_jurnal->input_jurnal_debet($id_akun_piutang, $reff, $sisa, $catat);
								$this->model_jurnal->input_jurnal_kredit(411, $reff, $sum_detail, $catat);
								//bayar piutang
							} elseif ($sisa > 0 and $cek_count > 1) {
								$arr['a'] = 3;
								$ket_jurnal = 'Piutang Inv. No. : ' . $no_order;
								$cek_bayar = $this->model_jurnal->cek_bayar($no_order)->row();

								$id_akunbyr = $cek_bayar->id_sub_bayar;
								$jml_bay 	= $cek_bayar->jml_bayar;
								$this->model_jurnal->input_jurnal_debet($id_akunbyr, $reff, $jml_bay, $catat);
								$this->model_app->update("bayar_invoice_detail", ["rekap" => 'Y'], ["id_invoice" => $no_order]);

								// //piutang
								$id_akun_piutang = 112;
								$this->model_jurnal->input_jurnal_kredit($id_akun_piutang, $reff, $jml_bayar, $ket_jurnal);
								//bayar piutang
							} elseif ($sisa == 0 and $cek_count > 1) {
								$arr['a'] = 4;
								$ket_jurnal = 'Piutang Inv. No. : ' . $no_order;
								$cek_bayar = $this->model_jurnal->cek_bayar($no_order)->row();

								$id_akunbyr = $cek_bayar->id_sub_bayar;
								$jml_bay 	= $cek_bayar->jml_bayar;
								$this->model_jurnal->input_jurnal_debet($id_akunbyr, $reff, $jml_bay, $ket_jurnal);
								$this->model_app->update("bayar_invoice_detail", ["rekap" => 'Y'], ["id_invoice" => $no_order]);

								// //piutang
								$id_akun_piutang = 112;
								$this->model_jurnal->input_jurnal_kredit($id_akun_piutang, $reff, $jml_bayar, $ket_jurnal);
								//bayar lunas
							} else {

								$arr['a'] = 5;
								$cek_bayar = $this->model_jurnal->cek_bayar($no_order)->row();
								$id_akunbyr = $cek_bayar->id_sub_bayar;
								$jml_bay 	= $cek_bayar->jml_bayar;
								$this->model_jurnal->input_jurnal_debet($id_akunbyr, $reff, $jml_bay, $catat);
								$this->model_app->update("bayar_invoice_detail", ["rekap" => 'Y'], ["id_invoice" => $no_order]);
								$this->model_jurnal->input_jurnal_kredit(411, $reff, $jml_bayar, $catat);
								$this->model_app->update("invoice", ["pos" => 'Y', "lunas" => 1, "status" => 'simpan'], ["id_invoice" => $no_order]);
							}

							if ($sisa <= 0) {
								// $this->model_app->update("invoice",["lunas" => 1],["id_invoice" => $no_order]);
								$alert = ["status" => 200, "id" => $no_order, "uang" => $jml_bayar, "total" => $jml_bayar, "msg" => $arr, "sisa" => $sisa];
							} else {
								$alert = ["status" => 200, "id" => $no_order, "uang" => $jml_bayar, "total" => $jml_bayar, "msg" => $arr, "sisa" => $sisa];
							}
						} else {
							$alert = ["status" => 304, "id" => 0, "uang" => 0, "total" => 0, "sisa" => $sisa];
						}
					} else {
						$alert = [
							"status" => 301,
							"msg" => "error",
							"id" => $noin,
							"uang" => $jml_bayar,
							"sisa" => $sisa,
							"total" => 0,
						];
					}
				} else {
					$alert = [
						"status" => 301,
						"msg" => "Order sudah lunas",
						"id" => $noin,
						"uang" => $jml_bayar,
						"sisa" => $sisa,
						"total" => 0,
					];
				}
			}


			$this->output
				->set_content_type("application/json")
				->set_output(json_encode($alert));
		}
	}

	/**
	 * Summary of load_total
	 * @return void
	 */
	public function load_total()
	{
		$status = $this->db->escape_str($this->input->post("status"));
		if (!empty($status)) {
			$conditions["search"]["trx"] = $status;
		} else {
			$conditions["search"]["trx"] = 0;
		}

		$tgl = $this->db->escape_str($this->input->post("tgl"));
		if (!empty($tgl)) {
			$date = date_ranges($tgl);
			$dari = date_replace_slash($date['dari']);
			$sampai = date_replace_slash($date['sampai']);
			$conditions["search"]["dari"] = $dari;
			$conditions["search"]["sampai"] = $sampai;
		}

		$invoice = $this->model_data->getRowsOrder($conditions);
		if (!empty($invoice)) {
			$total_order = $total_bayar = $total_diskon = $total_cashback = $total_pajak = 0;
			$pajak = 0;
			foreach ($invoice as $val) {

				$total_order += $this->model_app->cek_total_detail(['id_invoice' => $val->id_invoice])->row()->total;

				$_total_order = $this->model_app->cek_total_detail(['id_invoice' => $val->id_invoice])->row()->total;

				$total_bayar += $this->model_app->total_bayar(['id_invoice' => $val->id_invoice])->row()->total;


				$pajak += $this->model_app->cek_total('invoice', 'pajak', ['id_invoice' => $val->id_invoice])->pajak;

				$total_pajak += ($_total_order * $pajak) / 100;

				$total_diskon += $this->model_app->cek_total('invoice', 'potongan_harga', ['id_invoice' => $val->id_invoice])->potongan_harga;

				$total_cashback += $this->model_app->cek_total('invoice', 'cashback', ['id_invoice' => $val->id_invoice])->cashback;
			}

			if ($total_order > 9000000) {
				$totalorder = number_format_short($total_order);
			} else {
				$totalorder = rp($total_order);
			}

			if ($total_bayar  > 9000000) {
				// $_totalbayar = $total_bayar - $total_pajak;
				$totalbayar = number_format_short($total_bayar);
			} else {
				// $_totalbayar = $total_bayar-$total_pajak;
				$totalbayar = rp($total_bayar);
			}

			$total_piutang = $total_order - $total_bayar - $total_diskon + $total_pajak;
			if ($total_piutang > 9000000) {
				$total_piutang = number_format_short($total_piutang);
			} else {
				$total_piutang = rp($total_piutang);
			}
		} else {
			$totalorder = 0;
			$totalbayar = 0;
			$total_piutang = 0;
			$total_diskon = 0;
			$total_pajak = 0;
			$pajak = 0;
		}

		$result = [
			"status" => 200,
			"total_order" => $totalorder,
			"total_bayar" => $totalbayar,
			"total_diskon" => rp($total_diskon),
			"total_pajak" => '(+' . $pajak . '%)',
			"total_piutang" => $total_piutang,
		];
		$this->output
			->set_content_type("application/json")
			->set_output(json_encode($result));
	}

	/**
	 * Summary of kas_masuk
	 * @return void
	 */
	private function kas_masuk()
	{

		$noin      = $this->input->post("noin");
		$id_bayar  = xss_filter($this->input->post("id_byr"), 'xss');
		$jml_bayar = xss_filter($this->input->post("uang"), 'xss');
		$rekening  = xss_filter($this->input->post("rekening"), 'xss');

		if ($id_bayar == 1) {
			$no_reff = 411;
		} elseif ($id_bayar == 2) {
			$no_reff = 110;
		}

		$autoNumber = autoNumber(
			NOMOR_REFF,
			DIGIT_REFF,
			"id_generate",
			"kas_masuk"
		);
		$this->model_app->insert("kas_masuk", [
			"no_reff" => $no_reff,
			"id_bayar" => $id_bayar,
			"id_sub_bayar" => $rekening,
			"id_user" => $this->iduser,
			"id_generate" => $autoNumber,
			"pemasukan" => $jml_bayar,
			"catatan" => "Pendapatan INVOICE NO.#" . $noin,
		]);
	}

	/**
	 * Summary of get_data_produk
	 * @return void
	 */
	public function get_data_produk()
	{

		$id = $this->db->escape_str($this->input->post("id"));
		$id_member = $this->db->escape_str($this->input->post("idmember"));

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
			where `produk`.`id` = $id AND produk.pub='1'";
		$result = $this->db->query($query);

		$idb         = 0;
		$title       = '-';
		$harga_dasar = 0;
		$status      = 0;
		$type_harga  = 1;
		$id_satuan   = 1;
		$data = array();
		foreach ($result->result_array() as $row) {
			if (!empty($row['id_bahan'])) {
				$res = $this->db->query("SELECT * FROM bahan where id IN ($row[id_bahan])");
				if ($res->num_rows() > 0) {
					$rowx = $res->row_array();
					$id_bahan = $rowx['id'];
					$title = $rowx['title'];
					$harga_dasar = $rowx['harga'];
					$status = $rowx['status'];
					$type_harga = $rowx['type_harga'];
					$id_satuan = $rowx['id_satuan'];
				}
			} else {
				$this->output
					->set_content_type("application/json")
					->set_output(json_encode($data));
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
				$harga_jual = $sql1->row()->harga_jual;
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
				} else {
					$sql = $this->db->query("select id,id_satuan,harga_modal from bahan where id=$id_bahan");
					$harga_jual = $sql->row()->harga_modal;
				}
			} elseif ($type_harga == 4) {
				$sql = $this->db->query("select id_satuan,harga_jual from range_harga where id_bahan=$id_bahan AND 1 between jumlah_minimal and jumlah_maksimal");
				if ($sql->num_rows() > 0) {

					$harga_jual = $sql->row()->harga_jual;
				} else {
					$sql = $this->db->query("select id,id_satuan,harga_modal from bahan where id=$id_bahan");
					$harga_jual = $sql->row()->harga_modal;
				}
			} elseif ($type_harga == 5) {
				$sql4 = $this->db->query("select id_satuan,harga_jual from harga_range_member where id_bahan=$id_bahan AND id_member='$id_member' AND 1 between jumlah_minimal and jumlah_maksimal");
				if ($sql4->num_rows() > 0) {
					$harga_jual = $sql4->row()->harga_jual;
				} else {
					$sql = $this->db->query("select id,id_satuan,harga_modal from bahan where id=$id_bahan");
					$harga_jual = $sql->row()->harga_modal;
				}
			}

			$data = [
				'harga' => rp($harga_jual),
				'id_produk' => $row['id'],
				'jenis_cetakan' => $row['jenis_cetakan'],
				'id_jenis' => $row['id_jenis'],
				'bahan' => $title,
				'id_bahan' => $id_bahan,
				'status' => $status,
				'satuan' => $id_satuan,
				'ukuran' => $row['ukuran'],
				'jumlah' => $row['jumlah'],
				'lock_harga' => $row['lock_harga'],
				'type_harga' => $type_harga
			];
		}
		$this->output
			->set_content_type("application/json")
			->set_output(json_encode($data));
	}

	/**
	 * Summary of set_produk
	 * @param mixed $id
	 * @return void
	 */
	public function set_produk($id)
	{
		// $searchTerm = $this->input->get("searchTerm");
		$json = [];

		if (!empty($id)) {
			$this->db->where('id', $id);
			$query = $this->db->select('id,title as name')
				->where('kunci', 0)
				->limit(10)
				->get("produk");
			$json = $query->result();
		}
		$this->output
			->set_content_type("application/json")
			->set_output(json_encode($json));
	}

	/**
	 * Summary of get_produk
	 * @return void
	 */
	public function get_produk()
	{
		$searchTerm = $this->input->get("q");
		$json = [];

		if (!empty($searchTerm)) {
			$this->db->like('title', $searchTerm);
			$query = $this->db->select('id,title as text')
				->where('kunci', 0)
				->limit(10)
				->get("produk");
			$json = $query->result();
		} else {
			$query = $this->db->select('id,title as text')
				->where('kunci', 0)
				->limit(10)
				->get("produk");
			$json = $query->result();
		}
		$this->output
			->set_content_type("application/json")
			->set_output(json_encode($json));
	}

	/**
	 * Summary of duplikat_data
	 * @return void
	 */
	public function duplikat_data()
	{
		// $id = $this->input->get("id");
		$product_id = $this->input->post('id', TRUE);
		// remove white spaces 
		if ($product_id) {
			$last_id = $this->duplicate($product_id, 1);
			$result = $this->model_app->view_where('invoice_detail', ['id_rincianinvoice' => $last_id])->row();

			if (!empty($result)) {
				$response = [
					'id' => $result->id_rincianinvoice,
					'id_produk' => $result->id_produk,
					'nama_produk' => nama_produk($result->id_produk),
					'id_jenis' => $result->jenis_cetakan,
					'jenis' => jenis_cetakan($result->jenis_cetakan),
					'id_jenis' => $result->jenis_cetakan,
					'status_hitung' => $result->status_hitung,
					'type_harga' => $result->type_harga,
					'ket' => $result->keterangan,
					'jumlah' => $result->jumlah,
					'harga' => $result->harga,
					'id_satuan' => $result->id_satuan,
					'ukuran' => $result->ukuran,
					'tot_ukuran' => $result->tot_ukuran,
					'id_bahan' => $result->id_bahan,
					'bahan' => getBahan($result->id_bahan),
				];
				$data = ['status' => true, 'data' => $response, 'msg' => 'Sukses'];
			} else {
				$data = ['status' => false, 'msg' => 'Gagal'];
			}
			$this->output
				->set_content_type("application/json")
				->set_output(json_encode($data));
		}
	}

	private function duplicate($id, $count)
	{
		$this->db->where('id_rincianinvoice', $id);
		$query = $this->db->get('invoice_detail');
		foreach ($query->result() as $row) {
			foreach ($row as $key => $val) {

				if ($key != 'id_rincianinvoice') {
					$this->db->set($key, $val);
				}
			}
		}
		$result = array();
		for ($i = 0; $i < $count; $i++) {
			$this->db->insert('invoice_detail');
			$last_id = $this->db->insert_id();
		}

		return $last_id;
	}
}
