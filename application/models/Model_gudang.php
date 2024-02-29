<?php
class Model_gudang extends CI_model
{

	private $_table = 'stok_masuk_gudang';
	private $table  = 'stok_keluar_gudang';

	function __construct()
	{
		// Set table name 

	}

	function getInventory($params = array())
	{
		// print_r($params);
		$this->db->select('*');
		$this->db->from('nama_barang');

		if (array_key_exists("where", $params)) {
			foreach ($params['where'] as $key => $val) {
				$this->db->where($key, $val);
			}
		}
		if (array_key_exists("search", $params)) {
			if (!empty($params['search']['keywords'])) {
				$this->db->like('title', $params['search']['keywords']);
			}
		}
		if (!empty($params['search']['sortBy'])) {
			$this->db->order_by('`nama_barang`.`title`', $params['search']['sortBy']);
		}
		if (array_key_exists("returnType", $params) && $params['returnType'] == 'count') {
			$result = $this->db->count_all_results();
		} else {
			if (array_key_exists("id", $params) || (array_key_exists("returnType", $params) && $params['returnType'] == 'single')) {
				if (!empty($params['id'])) {
					$this->db->where('nama_barang.id', $params['id']);
				}
				$query = $this->db->get();
				$result = $query->row_array();
			} else {
				$this->db->order_by('nama_barang.create_date', 'DESC');
				if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
					$this->db->limit($params['limit'], $params['start']);
				} elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
					$this->db->limit($params['limit']);
				}

				$query = $this->db->get();
				$result = ($query->num_rows() > 0) ? $query->result_array() : FALSE;
			}
		}

		// Return fetched data 
		return $result;
	}

	public function real_stok($idmaster, $tgl = null)
	{
		if (empty($tgl))
			$tgl = date("Y-m-d");

		$dapat = query("SELECT SUM(jumlah) AS total_terima FROM stok_masuk_gudang WHERE create_date <= " . quote($tgl) . " AND id_barang = " . quote($idmaster));
		$row = $dapat->row_array();
		$a = $row['total_terima'];

		$kirim = query("SELECT SUM(jumlah) AS total_kirim FROM stok_keluar_gudang WHERE create_date <= " . quote($tgl) . " AND id_barang = " . quote($idmaster));
		$row2 = $kirim->row_array();
		$b = $row2['total_kirim'];

		$real_stok = $a - $b;
		return $real_stok;
	}

	public function list_divisi()
	{
		$sql = query("SELECT * FROM tb_users WHERE aktif ='Y' ORDER BY nama_lengkap");
		$arr = array();
		foreach ($sql->result_array() as $row) {
			$arr[$row['id_user']] = $row['nama_lengkap'];
		}
		return $arr;
	}

	function getStokMasuk($params = array())
	{
		$this->db->select(' `nama_barang`.`title`,
			`stok_masuk_gudang`.`jumlah`,
			`stok_masuk_gudang`.`create_date`,
			`stok_masuk_gudang`.`id`,
			`stok_masuk_gudang`.`id_barang`,
			`stok_masuk_gudang`.`id_user`');
		$this->db->from($this->_table);
		$this->db->join('nama_barang', '`stok_masuk_gudang`.`id_barang` = `nama_barang`.`id`');
		if (array_key_exists("where", $params)) {
			foreach ($params['where'] as $key => $val) {
				$this->db->where($key, $val);
			}
		}

		if (array_key_exists("search", $params)) {
			if (!empty($params['search']['keywords'])) {
				$this->db->like('stok_masuk_gudang.create_date', $params['search']['keywords']);
			}

			if (!empty($params['search']['dari']) and !empty($params['search']['sampai'])) {
				$this->db->where(
					'stok_masuk_gudang.create_date BETWEEN "' .
						date('Y-m-d', strtotime($params['search']['dari'])) .
						'" and "' .
						date('Y-m-d', strtotime($params['search']['sampai'])) .
						'"'
				);
			}
		}

		// Sort data by ascending or desceding order 
		if (!empty($params['search']['sortBy'])) {
			$this->db->order_by('`nama_barang`.`title`', $params['search']['sortBy']);
		}

		if (array_key_exists("returnType", $params) && $params['returnType'] == 'count') {
			$result = $this->db->count_all_results();
		} else {
			if (array_key_exists("id", $params) || (array_key_exists("returnType", $params) && $params['returnType'] == 'single')) {

				$query = $this->db->get();
				$result = ($query->num_rows() > 0) ? $query->result() : FALSE;
			} else {
				$this->db->order_by('`stok_masuk_gudang`.`create_date`', 'DESC');
				if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {

					$this->db->limit($params['limit'], $params['start']);
				} elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {

					$this->db->limit($params['limit']);
				}

				$query = $this->db->get();
				$result = ($query->num_rows() > 0) ? $query->result() : FALSE;
			}
		}

		// Return fetched data 
		return $result;
	}

	function getStokKeluar($params = array())
	{
		// print_r($params);
		$this->db->select(' `nama_barang`.`title`,
			`stok_keluar_gudang`.`jumlah`,
			`stok_keluar_gudang`.`create_date`,
			`stok_keluar_gudang`.`id`,
			`stok_keluar_gudang`.`id_barang`,
			`stok_keluar_gudang`.`id_user`');
		$this->db->from($this->_table);
		$this->db->join('nama_barang', '`stok_keluar_gudang`.`id_barang` = `nama_barang`.`id`');
		$this->db->from($this->table);
		if (array_key_exists("where", $params)) {
			foreach ($params['where'] as $key => $val) {
				$this->db->where($key, $val);
			}
		}

		if (array_key_exists("search", $params)) {
			if (!empty($params['search']['keywords'])) {
				$this->db->like('stok_keluar_gudang.create_date', $params['search']['keywords']);
			}

			if (!empty($params['search']['dari']) and !empty($params['search']['sampai'])) {
				$this->db->where(
					'stok_keluar_gudang.create_date BETWEEN "' .
						date('Y-m-d', strtotime($params['search']['dari'])) .
						'" and "' .
						date('Y-m-d', strtotime($params['search']['sampai'])) .
						'"'
				);
			}
		}

		// Sort data by ascending or desceding order 
		if (!empty($params['search']['sortBy'])) {
			$this->db->order_by('`nama_barang`.`title`', $params['search']['sortBy']);
		}

		if (array_key_exists("returnType", $params) && $params['returnType'] == 'count') {
			$result = $this->db->count_all_results();
		} else {
			if (array_key_exists("id", $params) || (array_key_exists("returnType", $params) && $params['returnType'] == 'single')) {

				$query = $this->db->get();
				$result = ($query->num_rows() > 0) ? $query->result() : FALSE;
			} else {
				$this->db->order_by('`stok_keluar_gudang`.`create_date`', 'DESC');
				if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {

					$this->db->limit($params['limit'], $params['start']);
				} elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {

					$this->db->limit($params['limit']);
				}

				$query = $this->db->get();
				$result = ($query->num_rows() > 0) ? $query->result() : FALSE;
			}
		}

		// Return fetched data 
		return $result;
	}

	public function insert(array $data)
	{
		if ($this->db->insert($this->_table, $data)) {
			$response['status'] =  true;
			$response['msg']    =  "Input berhasil";
			$response['id']     = $this->db->insert_id();
		} else {
			$response['status'] =  false;
			$response['msg']    =  "Input Gagal";
			$response['id']     =  "";
		}

		return $response;
	}

	public function insert_barang(array $data)
	{
		if ($this->db->insert('nama_barang', $data)) {
			$response['status'] =  true;
			$response['msg']    =  "Input berhasil";
			$response['id']     = $this->db->insert_id();
		} else {
			$response['status'] =  false;
			$response['msg']    =  "Input Gagal";
			$response['id']     =  "";
		}

		return $response;
	}

	public function update($id = 0, array $data)
	{
		if ($id > 0 && $this->cek_id($id) == 1) {
			$this->db->where("BINARY id='$id'", NULL, FALSE)->update($this->_table, $data);
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function update_barang($id = 0, array $data)
	{
		if ($id > 0 && $this->cek_id_barang($id) == 1) {
			$this->db->where("BINARY id='$id'", NULL, FALSE)->update('nama_barang', $data);
			return TRUE;
		} else {
			return FALSE;
		}
	}


	public function delete($id)
	{
		if ($this->cek_id($id) > 0) {
			$query = $this->db->where('id', $id);
			$query = $this->db->delete($this->_table);
			return TRUE;
		} else
			return FALSE;
	}


	public function delete_keluar($id)
	{
		if ($this->cek_id_keluar($id) > 0) {
			$query = $this->db->where('id', $id);
			$query = $this->db->delete($this->table);
			return TRUE;
		} else
			return FALSE;
	}

	public function cari_barang($name = '')
	{

		$query = $this->db->like('title', $name, 'both');
		$query = $this->db->get('nama_barang');
		$result = $query->result_array();

		return $result;
	}

	public function get_masuk($id = 0)
	{
		$result = NULL;

		if ($this->cek_id($id) == 1) {
			$this->db->select(' `nama_barang`.`title`,
				`stok_masuk_gudang`.`jumlah`,
				`stok_masuk_gudang`.`create_date`,
				`stok_masuk_gudang`.`id`,
				`stok_masuk_gudang`.`id_barang`,
				`stok_masuk_gudang`.`id_user`');
			$this->db->from($this->_table);
			$this->db->join('nama_barang', '`stok_masuk_gudang`.`id_barang` = `nama_barang`.`id`');
			$query = $this->db->where('stok_masuk_gudang.id', $id);
			$query = $this->db->get();
			$result = $query->row();
		}

		return $result;
	}


	public function get_barang($id = 0)
	{
		$result = NULL;

		if ($this->cek_id_barang($id) == 1) {
			$this->db->select('`nama_barang`.`id`,
				`nama_barang`.`title`,
				`satuan`.`satuan`,
				`nama_barang`.`id_satuan`');
			$this->db->from('nama_barang');
			$this->db->join('satuan', '`satuan`.`id` = `nama_barang`.`id_satuan`');
			$query = $this->db->where('nama_barang.id', $id);
			$query = $this->db->get();
			$result = $query->row();
		}

		return $result;
	}

	public function get_keluar($id = 0)
	{
		$result = NULL;

		if ($this->cek_id_keluar($id) == 1) {
			$query = $this->db->where('id', $id);
			$query = $this->db->get($this->table);
			$result = $query->row();
		}

		return $result;
	}

	public function cek_id($id = 0)
	{
		$id = xss_filter($id, 'xss');

		$query = $this->db->select('id');
		$query = $this->db->where("BINARY id='$id'", NULL, FALSE);
		$query = $this->db->get($this->_table);
		$result = $query->num_rows();

		return $result;
	}

	public function cek_id_barang($id = 0)

	{
		$id = xss_filter($id, 'xss');

		$query = $this->db->select('id');
		$query = $this->db->where("BINARY id='$id'", NULL, FALSE);

		$query = $this->db->get('nama_barang');

		$result = $query->num_rows();

		return $result;
	}

	public function get_current_mutasi($list, $iddiv = 0)
	{
		$save = array();
		foreach ($list as $r) {
			array_push($save, $r['id']);
		}

		$imp = "";
		if (count($save) > 0) {
			$imp = "WHERE id_barang IN (" . implode(",", $save) . ")";
			if ($iddiv > 0) {
				$imp .= " AND id_user = " . quote($iddiv);
			}
		}

		$arr = array();
		if ($iddiv == 0) {
			$sql = query("SELECT id_barang, SUM(jumlah) AS jumlah_terima FROM stok_masuk_gudang $imp GROUP BY id_barang");
			foreach ($sql->result_array() as $row) {
				$arr[$row['id_barang']] = $row['jumlah_terima'];
			}
		}
		$sql2 = query("SELECT id_barang, id_user, SUM(jumlah) AS jumlah_kirim FROM stok_keluar_gudang $imp GROUP BY id_barang, id_user");
		foreach ($sql2->result_array() as $row) {
			if ($iddiv == 0) {
				if (isset($arr[$row['id_barang']])) {
					$arr[$row['id_barang']] -= $row['jumlah_kirim'];
				}
			} else {
				$arr[$row['id_barang']] = $row['jumlah_kirim'];
			}
		}

		if ($iddiv <> 0) {
			//tweak
			$tj = query("SELECT id_barang, id_user, SUM(jumlah) AS jumlah_terjual FROM cc_terjual $imp GROUP BY id_barang");
			foreach ($tj->result_array() as $r3) {
				$n = $r3['jumlah_terjual'];
				if (isset($arr[$r3['id_barang']]))
					$arr[$r3['id_barang']] -= $n;
				else
					$arr[$r3['id_barang']] = 0 - $n;
			}
		}

		return $arr;
	}

	public function listdiv($ret = "obj")
	{
		$sql = query("SELECT id_user,nama_lengkap FROM tb_users WHERE aktif ='Y' ORDER BY nama_lengkap");
		if ($ret == "array") {
			$r = array();
			foreach ($sql->result_array() as $row) {
				$r[$row['id_user']] = $row['nama_lengkap'];
			}
			return $r;
		} else {
			return $sql->result_array();
		}
	}

	public function list_cc()
	{
		$sql = query("SELECT * FROM nama_barang WHERE stat <> 9");
		$arr = array();
		foreach ($sql->result_array() as $row) {
			$arr[$row['id']] = $row['title'];
		}
		return $arr;
	}
	public function notif_stok()
	{
		$result = query("SELECT nama_barang.id, nama_barang.title, SUM(stok_masuk_gudang.jumlah) AS stok, pemakaian
			FROM nama_barang
			LEFT JOIN stok_masuk_gudang ON nama_barang.id=stok_masuk_gudang.id_barang
			LEFT JOIN
			(SELECT nama_barang.id, SUM(stok_keluar_gudang.jumlah) AS pemakaian
			FROM nama_barang, stok_keluar_gudang
			WHERE nama_barang.id=stok_keluar_gudang.id_barang
			GROUP BY stok_keluar_gudang.id_barang) AS pakai
			ON nama_barang.id=pakai.id
			GROUP BY nama_barang.id")->result();
		$response = array();
		foreach ($result as $row) {
			$stok = $row->stok - $row->pemakaian;
			if ($stok <= 5) {
				$response[] = $row;
			}
		}
		return $response;
	}

	function sum_masuk($id, $bulan, $tahun)
	{

		// Fetch users
		$month_year = $tahun . '-' . $bulan;
		$this->db->select_sum('jumlah');
		$this->db->where('id_barang', $id);
		$this->db->where("DATE_FORMAT(create_date,'%Y-%m') <", $month_year);

		$sql2 = $this->db->get('stok_masuk_gudang');
		$total_penyesuaian = ($sql2->num_rows() > 0) ? $sql2->row()->jumlah : 0;

		return $total_penyesuaian;
	}

	function sum_keluar($id, $bulan, $tahun)
	{

		// Fetch users
		$month_year = $tahun . '-' . $bulan;
		$this->db->select_sum('jumlah');
		$this->db->where('id_barang', $id);
		$this->db->where("DATE_FORMAT(create_date,'%Y-%m') <", $month_year);

		$sql2 = $this->db->get('stok_keluar_gudang');
		$total_penyesuaian = ($sql2->num_rows() > 0) ? $sql2->row()->jumlah : 0;

		return $total_penyesuaian;
	}

	public function report_master($detail = 0, $periode)
	{
		$arr = array();
		// $periode = periode($periode);
		list($bulan, $tahun) = explode('-', $periode);
		// $jml_keluar = $this->sum_keluar($bulan,$tahun);
		// $jumlah = $jml_masuk - $jml_keluar;
		$sql2 = $this->db->select('*');
		$sql2 = $this->db->from('stok_masuk_gudang');
		$sql2 = $this->db->where('MONTH(create_date)', $bulan);
		$sql2 = $this->db->where('YEAR(create_date)', $tahun);
		$sql3 = $this->db->order_by('create_date');
		$sql2 = $this->db->get();

		$n = 0;
		foreach ($sql2->result_array() as $row2) {
			$tgl = strtotime($row2['create_date']) + $n;
			$arr[$row2['id_barang']][$tgl]["id"] = $row2['id_barang'];
			$arr[$row2['id_barang']][$tgl]["terima"] = $row2['jumlah'];
			$arr[$row2['id_barang']][$tgl]["ket"] = $row2['ket'];
			$arr[$row2['id_barang']]['total']["total_masuk"] = $this->sum_masuk($row2['id_barang'], $bulan, $tahun);
			$n++;
		}
		// dump($arr);
		$sql3 = $this->db->select('*');
		$sql3 = $this->db->from('stok_keluar_gudang');
		$sql3 = $this->db->where('MONTH(create_date)', $bulan);
		$sql3 = $this->db->where('YEAR(create_date)', $tahun);
		$sql3 = $this->db->order_by('create_date');
		$sql3 = $this->db->get();
		foreach ($sql3->result_array() as $row3) {
			$tgl = strtotime($row3['create_date']) + $n;
			$arr[$row3['id_barang']][$tgl]["id"] = $row3['id_barang'];
			$arr[$row3['id_barang']][$tgl]["kirim"] = $row3['jumlah'];
			$arr[$row3['id_barang']][$tgl]["ket"] = $row3['ket'];
			$arr[$row3['id_barang']]['total']["total_keluar"] = $this->sum_keluar($row3['id_barang'], $bulan, $tahun);
			$n++;
		}
		// dump($arr);

		return $arr;
	}

	public function report_divisi($detail = 0, $filter = "", $periode)
	{
		list($bulan, $tahun) = explode('-', $periode);
		$arr = array();

		$addq = "";
		if (strlen($filter) > 0) {
			$addq = " AND id_user = " . quote($filter);
		}
		$dv = query("SELECT * FROM tb_users WHERE aktif='Y' $addq");
		$n = 0;
		foreach ($dv->result_array() as $row) {

			// $sql = query("SELECT * FROM stok_masuk_gudang WHERE id_user = ".$row['id_user']." AND stat <> 9 ORDER BY create_date");
			$sql3 = $this->db->select('*');
			$sql3 = $this->db->from('stok_masuk_gudang');
			$sql3 = $this->db->where('id_user', $row['id_user']);
			$sql3 = $this->db->where('MONTH(create_date)', $bulan);
			$sql3 = $this->db->where('YEAR(create_date)', $tahun);
			$sql3 = $this->db->get();
			foreach ($sql3->result_array() as $r) {
				$tgll = strtotime($r['create_date']) + $n;

				$arr[$row['id_user']][$r['id_barang']][$tgll]["id"] = $r['id_barang'];
				$arr[$row['id_user']][$r['id_barang']][$tgll]["kirim"] = $r['jumlah'];
				$arr[$row['id_user']][$r['id_barang']][$tgll]["ket"] = $r['ket'];
				$arr[$row['id_user']][$r['id_barang']]['total']["total_masuk"] = $this->sum_masuk($r['id_barang'], $bulan, $tahun);
				$n++;
			}

			$sql2 = $this->db->select('*');
			$sql2 = $this->db->from('stok_keluar_gudang');
			$sql2 = $this->db->where('id_user', $row['id_user']);
			$sql2 = $this->db->where('MONTH(create_date)', $bulan);
			$sql2 = $this->db->where('YEAR(create_date)', $tahun);
			$sql2 = $this->db->get();
			foreach ($sql2->result_array() as $r2) {
				$tgll = strtotime($r2['create_date']) + $n;

				$arr[$row['id_user']][$r2['id_barang']][$tgll]["id"] = $r2['id_barang'];
				$arr[$row['id_user']][$r2['id_barang']][$tgll]["jual"] = $r2['jumlah'];
				$arr[$row['id_user']][$r2['id_barang']][$tgll]["ket"] = $r2['ket'];
				$arr[$row['id_user']][$r2['id_barang']]['total']["total_keluar"] = $this->sum_keluar($r2['id_barang'], $bulan, $tahun);
				$n++;
			}
		}
		// dump($arr);


		return $arr;
	}

	public function load_divisi($ord = "id_user")
	{
		$sql = query("SELECT * FROM tb_users WHERE aktif ='Y' ORDER BY $ord ASC");
		return $sql;
	}

	public function get_page($tb, $id)
	{
		$sql = $this->db->query("SELECT * FROM $tb WHERE id = " . intval($id));
		if ($sql->num_rows() > 0)
			return $sql->row_array();
		return false;
	}

	public function item_mutasi($id)
	{
		$save = array();
		$sql = query("SELECT * FROM stok_masuk_gudang WHERE id_barang = " . quote($id) . " AND stat <> 9");
		$n = 0;
		foreach ($sql->result_array() as $row) {
			$tgl = strtotime($row['create_date']) + $n; //tweak untuk menampilkan data dengan tanggal yg sama. limit = 86399 data.
			$save[$tgl]['terima'] = $row['jumlah'];
			$save[$tgl]['ket'] = $row['ket'];
			$n++;
		}

		$sql2 = query("SELECT * FROM stok_keluar_gudang WHERE id_barang = " . quote($id) . " AND stat <> 9");
		foreach ($sql2->result_array() as $row) {
			$tgl = strtotime($row['create_date']) + $n;

			$save[$tgl]['kirim'] = $row['jumlah'];
			$save[$tgl]['ket'] = $row['ket'];
			$n++;
		}

		ksort($save);
		return $save;
	}

	public function item_mutasi_divisi($idmaster, $iddivisi)
	{
		$save = array();
		$sql2 = query("SELECT * FROM stok_masuk_gudang WHERE id_barang = $idmaster AND id_user = $iddivisi AND stat <> 9");
		$n = 0;
		foreach ($sql2->result_array() as $row) {
			$tgl = strtotime($row['create_date']) + $n;

			$save[$tgl]['kirim'] = $row['jumlah'];
			$save[$tgl]['ket'] = $row['ket'];
			$n++;
		}

		$sql3 = query("SELECT * FROM stok_keluar_gudang WHERE id_barang = $idmaster AND id_user = $iddivisi AND stat <> 9");
		foreach ($sql3->result_array() as $row2) {
			$tgl = strtotime($row2['create_date']) + $n;
			$save[$tgl]['terjual'] = $row2['jumlah'];
			$save[$tgl]['ket'] = $row2['ket'];
			$n++;
		}

		ksort($save);
		return $save;
	}
}
