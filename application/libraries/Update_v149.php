<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Update_v149 {
		private $name; 
		private $ci;
		public function __construct()
		{      
			$this -> ci=& get_instance();
			$this -> ci->load->database();
		}
		
		public function invoice_detail(){
			$fields = $this->field_invoice_detail();
			$kolom = array_keys($fields);
			
			// dump($query);
			if ($this->ci->db->field_exists($kolom[0],'invoice_detail')) {
				$arr['status'] = false;
				$arr['msg'] =  'column '.$kolom[0].' already exists';
				} else {
				$this->ci->load->dbforge();
				$this->ci->dbforge->add_column('invoice_detail', $fields);
				$arr['status'] = true;
				$arr['msg'] = 'sukses';
			}
			
			return $this->name = $arr;
			
		}
		
		public function satu_harga(){
			$fields = $this->field_satu_harga_a();
			$kolom = array_keys($fields);
			
			// dump($query);
			if ($this->ci->db->field_exists($kolom[0],'satu_harga')) {
				$arr['status'] = false;
				$arr['msg'] =  'column '.$kolom[0].' already exists';
				} else {
				$this->ci->load->dbforge();
				$this->ci->dbforge->add_column('satu_harga', $fields);
				$this->update_satu_harga();
				$arr['status'] = true;
				$arr['msg'] = 'sukses';
			}
			
			return $this->name = $arr;
			
		}
		
		public function satu_harga_b(){
			$fields = $this->field_satu_harga_b();
			$kolom = array_keys($fields);
			
			// dump($query);
			if ($this->ci->db->field_exists($kolom[0],'satu_harga')) {
				$arr['status'] = false;
				$arr['msg'] =  'column '.$kolom[0].' already exists';
				} else {
				$this->ci->load->dbforge();
				$this->ci->dbforge->add_column('satu_harga', $fields);
				$this->update_satu_harga();
				$arr['status'] = true;
				$arr['msg'] = 'sukses';
			}
			
			return $this->name = $arr;
			
		}
		
		public function satu_harga_C(){
			$fields = $this->field_satu_harga_c();
			$kolom = array_keys($fields);
			
			// dump($query);
			if ($this->ci->db->field_exists($kolom[0],'satu_harga')) {
				$arr['status'] = false;
				$arr['msg'] =  'column '.$kolom[0].' already exists';
				} else {
				$this->ci->load->dbforge();
				$this->ci->dbforge->add_column('satu_harga', $fields);
				$arr['status'] = true;
				$arr['msg'] = 'sukses';
			}
			
			return $this->name = $arr;
			
		}
		
		public function harga_satuan(){
			$fields = $this->field_harga_satuan();
			$kolom = array_keys($fields);
			
			// dump($query);
			if ($this->ci->db->field_exists($kolom[0],'harga_satuan')) {
				$arr['status'] = false;
				$arr['msg'] =  'column '.$kolom[0].' already exists';
				} else {
				$this->ci->load->dbforge();
				$this->ci->dbforge->add_column('harga_satuan', $fields);
				$this->update_harga_satuan();
				$arr['status'] = true;
				$arr['msg'] = 'sukses';
			}
			
			return $this->name = $arr;
			
		}
		
		public function harga_member(){
			$fields = $this->field_harga_member();
			$kolom = array_keys($fields);
			
			// dump($query);
			if ($this->ci->db->field_exists($kolom[0],'harga_member')) {
				$arr['status'] = false;
				$arr['msg'] =  'column '.$kolom[0].' already exists';
				} else {
				$this->ci->load->dbforge();
				$this->ci->dbforge->add_column('harga_member', $fields);
				$this->update_harga_member();
				$arr['status'] = true;
				$arr['msg'] = 'sukses';
			}
			
			return $this->name = $arr;
			
		}
		
		public function range_harga(){
			$fields = $this->field_range_harga();
			$kolom = array_keys($fields);
			
			if ($this->ci->db->field_exists($kolom[0],'range_harga')) {
				$arr['status'] = false;
				$arr['msg'] =  'column '.$kolom[0].' already exists';
				} else {
				$this->ci->load->dbforge();
				$this->ci->dbforge->add_column('range_harga', $fields);
				$this->update_range_harga();
				$arr['status'] = true;
				$arr['msg'] = 'sukses';
			}
			
			return $this->name = $arr;
			
		}
		
		public function harga_range_member(){
			$fields = $this->field_harga_range_member();
			$kolom = array_keys($fields);
			
			if ($this->ci->db->field_exists($kolom[0],'harga_range_member')) {
				$arr['status'] = false;
				$arr['msg'] =  'column '.$kolom[0].' already exists';
				} else {
				$this->ci->load->dbforge();
				$this->ci->dbforge->add_column('harga_range_member', $fields);
				$this->update_harga_range_member();
				$arr['status'] = true;
				$arr['msg'] = 'sukses';
			}
			
			return $this->name = $arr;
			
		}
		
		public function invoice_one(){
			$fields = $this->field_invoice_one();
			$kolom = array_keys($fields);
			
			if ($this->ci->db->field_exists($kolom[0],'invoice')) {
				$arr['status'] = false;
				$arr['msg'] =  'column '.$kolom[0].' already exists';
				} else {
				$this->ci->load->dbforge();
				$this->ci->dbforge->add_column('invoice', $fields);
				$arr['status'] = 'sukses';
			}
			
			return $this->name = $arr;
			
		}
		
		public function laporan_penerimaan(){
			$fields = $this->field_laporan_penerimaan();
			$kolom = array_keys($fields);
			
			if ($this->ci->db->field_exists($kolom[0],'laporan_penerimaan')) {
				$arr['status'] = false;
				$arr['msg'] =  'column '.$kolom[0].' already exists';
				} else {
				$this->ci->load->dbforge();
				$this->ci->dbforge->add_column('laporan_penerimaan', $fields);
				$arr['status'] = 'sukses';
			}
			
			return $this->name = $arr;
			
		}
		
		public function cols_printer(){
			$fields = $this->field_printer();
			$kolom = array_keys($fields);
			
			if ($this->ci->db->field_exists($kolom[0],'printer')) {
				$arr['status'] = false;
				$arr['msg'] =  'column '.$kolom[0].' already exists';
				} else {
				$this->ci->load->dbforge();
				$this->ci->dbforge->add_column('printer', $fields);
				$arr['status'] = 'sukses';
			}
			
			return $this->name = $arr;
			
		}
		
		public function info_devtools(){
			$fields = $this->field_info();
			$kolom = array_keys($fields);
			
			if ($this->ci->db->field_exists($kolom[0],'info')) {
				$arr['status'] = false;
				$arr['msg'] =  'column '.$kolom[0].' already exists';
				} else {
				$this->ci->load->dbforge();
				$this->ci->dbforge->add_column('info', $fields);
				$arr['status'] = 'sukses';
			}
			
			return $this->name = $arr;
			
		}
		
		public function invoice_two(){
			$fields = $this->field_invoice_two();
			$kolom = array_keys($fields);
			
			if ($this->ci->db->field_exists($kolom[0],'invoice')) {
				$arr['status'] = false;
				$arr['msg'] =  'column '.$kolom[0].' already exists';
				} else {
				$this->ci->load->dbforge();
				$this->ci->dbforge->add_column('invoice', $fields);
				$arr['status'] = 'sukses';
			}
			
			return $this->name = $arr;
			
		}		
		public function bahan(){
			$fields = $this->field_bahan();
			$kolom = array_keys($fields);
			
			if ($this->ci->db->field_exists($kolom[0],'bahan')) {
				$arr['status'] = false;
				$arr['msg'] =  'column '.$kolom[0].' already exists';
				} else {
				$this->ci->load->dbforge();
				$this->ci->dbforge->add_column('bahan', $fields);
				$arr['status'] = 'sukses';
			}
			
			return $this->name = $arr;
			
		}
		
		private function update_satu_harga(){
			$query = $this->ci->db->select('id,harga_jual')
			->from('satu_harga')
			->get()->result();
			foreach($query AS $val)
			{
				$this->ci->model_app->update('satu_harga', ['harga_beli' =>$val->harga_jual,'harga_pokok' =>$val->harga_jual], ['id' =>$val->id]);
				
			}
		}
		
		private function update_harga_satuan(){
			$query = $this->ci->db->select('id,harga_jual')
			->from('harga_satuan')
			->get()->result();
			foreach($query AS $val)
			{
				$this->ci->model_app->update('harga_satuan', ['harga_pokok' =>$val->harga_jual], ['id' =>$val->id]);
				
			}
		}
		
		private function update_harga_member(){
			$query = $this->ci->db->select('id,harga_jual')
			->from('harga_member')
			->get()->result();
			foreach($query AS $val)
			{
				$this->ci->model_app->update('harga_member', ['harga_pokok' =>$val->harga_jual], ['id' =>$val->id]);
				
			}
		}
		
		private function update_range_harga(){
			$query = $this->ci->db->select('id,harga_jual')
			->from('range_harga')
			->get()->result();
			foreach($query AS $val)
			{
				$this->ci->model_app->update('range_harga', ['harga_pokok' =>$val->harga_jual], ['id' =>$val->id]);
				
			}
		}
		
		private function update_harga_range_member(){
			$query = $this->ci->db->select('id,harga_jual')
			->from('harga_range_member')
			->get()->result();
			foreach($query AS $val)
			{
				$this->ci->model_app->update('harga_range_member', ['harga_pokok' =>$val->harga_jual], ['id' =>$val->id]);
				
			}
		}
		
		private function field_bahan()
		{
			$fields = array(
			'featured' => array(
			'type' => 'INT',
			'constraint' => 1,
			'after' => 'type_harga',
			'null' => FALSE,
			'default' => 0
			),
			'barcode' => array(
			'type' => 'VARCHAR',
			'constraint' => 15,
			'after' => 'featured',
			'null' => TRUE
			)
			);
			return $this->name = $fields;
		}
		private function field_satu_harga_a(){
			$fields = array(
			'harga_beli' => array(
			'type' => 'INT',
			'constraint' => 11,
			'after' => 'id_satuan',
			'default' => '0',
			)
			);
			return $this->name = $fields;
		}	
		private function field_invoice_detail(){
			$fields = array(
			'no_spk' => array(
			'type' => 'INT',
			'constraint' => 11,
			'after' => 'id_invoice',
			'default' => '0',
			)
			);
			return $this->name = $fields;
		}	
		private function field_satu_harga_b(){
			$fields = array(
			'harga_pokok' => array(
			'type' => 'INT',
			'constraint' => 11,
			'after' => 'harga_beli',
			'default' => '0',
			)
			);
			return $this->name = $fields;
		}
		private function field_satu_harga_c(){
			$fields = array(
			'detail_harga_pokok' => array(
			'type' => 'TEXT',
			'after' => 'harga_pokok',
			'null' => TRUE,
			)
			);
			return $this->name = $fields;
		}
		
		private function field_printer(){
			$fields = array(
			'show_footer' => array(
			'type' => 'INT',
			'constraint' => 1,
			'after' => 'pub',
			'default' => '0',
			)
			);
			return $this->name = $fields;
		}
		private function field_info(){
			$fields = array(
			'dev_tools' => array(
			'type' => 'INT',
			'constraint' => 11,
			'after' => 'version',
			'default' => '0',
			)
			);
			return $this->name = $fields;
		}
		
		private function field_harga_satuan(){
			$fields = array(
			'harga_pokok' => array(
			'type' => 'INT',
			'constraint' => 11,
			'after' => 'id_bahan',
			'default' => '0',
			)
			);
			return $this->name = $fields;
		}
		
		private function field_harga_member(){
			$fields = array(
			'harga_pokok' => array(
			'type' => 'INT',
			'constraint' => 11,
			'after' => 'id_member',
			'default' => '0',
			)
			);
			return $this->name = $fields;
		}
		
		private function field_range_harga(){
			$fields = array(
			'harga_pokok' => array(
			'type' => 'INT',
			'constraint' => 11,
			'after' => 'jumlah_maksimal',
			'default' => '0',
			)
			);
			return $this->name = $fields;
		}	
		
		private function field_harga_range_member(){
			$fields = array(
			'harga_pokok' => array(
			'type' => 'INT',
			'constraint' => 11,
			'after' => 'jumlah_maksimal',
			'default' => '0',
			)
			);
			return $this->name =  $fields;
		}
		
		private function field_invoice_one(){
			$fields = array(
			'cashback' => array(
			'type' => 'INT',
			'constraint' => 11,
			'after' => 'potongan_harga',
			'default' => '0',
			)
			);
			return $this->name =  $fields;
		}
		
		private function field_laporan_penerimaan(){
			$fields = array(
			'id_invoice' => array(
			'type' => 'text',
			'after' => 'id',
			'default' => null,
			)
			);
			return $this->name =  $fields;
		}
		
		private function field_invoice_two(){
			$fields = array(
			'potongan_harga' => array(
			'type' => 'INT',
			'constraint' => 11,
			'after' => 'kembalian',
			'default' => '0',
			),
			'cashback' => array(
			'type' => 'INT',
			'constraint' => 11,
			'after' => 'potongan_harga',
			'default' => '0',
			)
			);
			return $this->name =  $fields;
		}
		
		public function add_column($response,$table){
			$fields = $response;
			$kolom = array_keys($fields);
			
			if ($this->ci->db->field_exists($kolom[0], $table)) {
				$arr['status'] = false;
				$arr['msg'] =  'Table '.$table.' already exists';
				} else {
				$this->ci->load->dbforge();
				$this->ci->dbforge->add_column($table, $fields);
				$arr['status'] = true;
				$arr['msg'] =  'sukses';
			}
			
			return $arr;
			
		}
		
		public function add_table_deposit()
		{
			$fields = array(
			'id' => array(
			'type' => 'INT',
			'constraint' => 11,
			'unsigned' => TRUE,
			'auto_increment' => TRUE
			),
			'id_user' => array(
			'type' => 'INT',
			'constraint' => 11,
			'null' => TRUE,
			'default' => 0
			),
			'id_konsumen' => array(
			'type' => 'INT',
			'constraint' => 11,
			'null' => TRUE,
			),
			'id_invoice' => array(
			'type' => 'INT',
			'constraint' => 11,
			'null' => TRUE,
			'default' => 0
			),
			'masuk' => array(
			'type' => 'INT',
			'constraint' => 11,
			'null' => TRUE,
			'default' => 0
			),
			'keluar' => array(
			'type' => 'INT',
			'constraint' => 11,
			'null' => TRUE,
			'default' => 0
			),
			'create_date' => array(
			'type' => 'DATE',
			'null' => TRUE
			),
			'status' => array(
			'type' => 'INT',
			'constraint' => 1,
			'null' => TRUE,
			'default' => 0
			),
			'catatan' => array(
			'type' => 'text',
			'null' => TRUE,
			'default' => TRUE
			)
			);
			return $this->name = $fields;
		}
		
		function get_name() {
			return $this->name;
		}
	}																																																																		