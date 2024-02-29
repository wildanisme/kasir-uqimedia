<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_base extends CI_Migration {

	public function up() {

		## Create Table absen
		$this->dbforge->add_field(array(
			'ID' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_user' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'tgl' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
			'real_masuk' => array(
				'type' => 'DATETIME',
				'null' => TRUE,

			),
			'masuk' => array(
				'type' => 'DATETIME',
				'null' => TRUE,

			),
			'real_pulang' => array(
				'type' => 'DATETIME',
				'null' => TRUE,

			),
			'pulang' => array(
				'type' => 'DATETIME',
				'null' => TRUE,

			),
			'jam_masuk_lembur' => array(
				'type' => 'DATETIME',
				'null' => TRUE,

			),
			'real_masuk_lembur' => array(
				'type' => 'DATETIME',
				'null' => TRUE,

			),
			'jam_pulang_lembur' => array(
				'type' => 'DATETIME',
				'null' => TRUE,

			),
			'real_pulang_lembur' => array(
				'type' => 'DATETIME',
				'null' => TRUE,

			),
			'id_session' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE,

			),
			'lembur' => array(
				'type' => 'INT',
				'constraint' => 1,
				'null' => FALSE,
				'default' => '0',

			),
		));
		$this->dbforge->add_key("ID",true);
		$this->dbforge->create_table("absen", TRUE);
		$this->db->query('ALTER TABLE  `absen` ENGINE = MyISAM');

		## Create Table akun
		$this->dbforge->add_field(array(
			'no_reff' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'id_user' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'nama_reff' => array(
				'type' => 'VARCHAR',
				'constraint' => 40,
				'null' => FALSE,

			),
			'keterangan' => array(
				'type' => 'VARCHAR',
				'constraint' => 40,
				'null' => FALSE,

			),
			'laba_rugi' => array(
				'type' => 'INT',
				'constraint' => 1,
				'null' => FALSE,
				'default' => '0',

			),
			'aktiva' => array(
				'type' => 'INT',
				'constraint' => 1,
				'null' => FALSE,
				'default' => '0',

			),
			'pasiva' => array(
				'type' => 'INT',
				'constraint' => 1,
				'null' => FALSE,
				'default' => '0',

			),
			'kewajiban' => array(
				'type' => 'INT',
				'constraint' => 1,
				'null' => FALSE,
				'default' => '0',

			),
			'beban' => array(
				'type' => 'INT',
				'constraint' => 1,
				'null' => FALSE,
				'default' => '0',

			),
			'urutan' => array(
				'type' => 'INT',
				'constraint' => 4,
				'null' => FALSE,
				'default' => '0',

			),
			'kunci' => array(
				'type' => 'INT',
				'constraint' => 1,
				'null' => FALSE,
				'default' => '0',

			),
		));
		$this->dbforge->add_key("no_reff",true);
		$this->dbforge->create_table("akun", TRUE);
		$this->db->query('ALTER TABLE  `akun` ENGINE = MyISAM');

		## Create Table bahan
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_jenis' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'title' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => FALSE,

			),
			'harga_modal' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'harga_jual' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'harga' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'id_satuan' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'status_stok' => array(
				'type' => 'ENUM("Y","N")',
				'null' => FALSE,
				'default' => 'N',

			),
			'kunci' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'status' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'pub' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'type_harga' => array(
				'type' => 'INT',
				'constraint' => 1,
				'null' => FALSE,
				'default' => '1',

			),
			'featured' => array(
				'type' => 'INT',
				'constraint' => 1,
				'null' => FALSE,
				'default' => '0',

			),
			'barcode' => array(
				'type' => 'VARCHAR',
				'constraint' => 15,
				'null' => TRUE,

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("bahan", TRUE);
		$this->db->query('ALTER TABLE  `bahan` ENGINE = MyISAM');

		## Create Table bayar_gaji
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_slip' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'tgl_bayar' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
			'jml_bayar' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'id_byr' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'id_user' => array(
				'type' => 'INT',
				'constraint' => 3,
				'null' => TRUE,

			),
			'jurnal' => array(
				'type' => 'ENUM("Y","N")',
				'null' => TRUE,
				'default' => 'N',

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("bayar_gaji", TRUE);
		$this->db->query('ALTER TABLE  `bayar_gaji` ENGINE = MyISAM');

		## Create Table bayar_invoice_detail
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_invoice' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'tgl_bayar' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
			'jam_bayar' => array(
				'type' => 'TIME',
				'null' => TRUE,

			),
			'jml_bayar' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'jdiskon' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'kunci' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'id_bayar' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'id_sub_bayar' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'lampiran' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,

			),
			'id_user' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'rekap' => array(
				'type' => 'ENUM("Y","N")',
				'null' => FALSE,
				'default' => 'N',

			),
			'setor' => array(
				'type' => 'ENUM("Y","N")',
				'null' => FALSE,
				'default' => 'N',

			),
			'tgl_setor' => array(
				'type' => 'DATETIME',
				'null' => TRUE,

			),
			'hapus' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'urutan' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("bayar_invoice_detail", TRUE);
		$this->db->query('ALTER TABLE  `bayar_invoice_detail` ENGINE = MyISAM');

		## Create Table bayar_pembelian
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_pembelian' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'tgl_bayar' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
			'jml_bayar' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'id_bayar' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'id_sub_bayar' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'id_user' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'setor' => array(
				'type' => 'ENUM("Y","N")',
				'null' => FALSE,
				'default' => 'N',

			),
			'tgl_setor' => array(
				'type' => 'DATETIME',
				'null' => TRUE,

			),
			'jurnal' => array(
				'type' => 'ENUM("Y","N")',
				'null' => TRUE,
				'default' => 'N',

			),
			'lampiran' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("bayar_pembelian", TRUE);
		$this->db->query('ALTER TABLE  `bayar_pembelian` ENGINE = MyISAM');

		## Create Table bayar_pengeluaran
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_pengeluaran' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'tgl_bayar' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
			'jml_bayar' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'id_bayar' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'id_sub_bayar' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'id_user' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'setor' => array(
				'type' => 'ENUM("Y","N")',
				'null' => FALSE,
				'default' => 'N',

			),
			'tgl_setor' => array(
				'type' => 'DATETIME',
				'null' => TRUE,

			),
			'jurnal' => array(
				'type' => 'ENUM("Y","N")',
				'null' => TRUE,
				'default' => 'N',

			),
			'lampiran' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("bayar_pengeluaran", TRUE);
		$this->db->query('ALTER TABLE  `bayar_pengeluaran` ENGINE = MyISAM');

		## Create Table bayar_piutang
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_pengeluaran' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'tgl_bayar' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
			'jml_bayar' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'id_bayar' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'id_sub_bayar' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'id_user' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'setor' => array(
				'type' => 'ENUM("Y","N")',
				'null' => FALSE,
				'default' => 'N',

			),
			'tgl_setor' => array(
				'type' => 'DATETIME',
				'null' => TRUE,

			),
			'jenis' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => TRUE,

			),
			'jurnal' => array(
				'type' => 'ENUM("Y","N")',
				'null' => TRUE,
				'default' => 'N',

			),
			'lampiran' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("bayar_piutang", TRUE);
		$this->db->query('ALTER TABLE  `bayar_piutang` ENGINE = MyISAM');

		## Create Table bonus
		$this->dbforge->add_field(array(
			'ID' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_user' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'tgl' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
			'keterangan' => array(
				'type' => 'VARCHAR',
				'constraint' => 150,
				'null' => TRUE,

			),
			'bonus' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
		));
		$this->dbforge->add_key("ID",true);
		$this->dbforge->create_table("bonus", TRUE);
		$this->db->query('ALTER TABLE  `bonus` ENGINE = MyISAM');

		## Create Table ci_sessions
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'VARCHAR',
				'constraint' => 128,
				'null' => FALSE,

			),
			'ip_address' => array(
				'type' => 'VARCHAR',
				'constraint' => 45,
				'null' => FALSE,

			),
			'timestamp' => array(
				'type' => 'TIMESTAMP',
				'null' => FALSE,
				'default' => 'current_timestamp()',

			),
			'data' => array(
				'type' => 'BLOB',
				'null' => FALSE,

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("ci_sessions", TRUE);
		$this->db->query('ALTER TABLE  `ci_sessions` ENGINE = InnoDB');

		## Create Table deposit
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 1,
				'unsigned' => TRUE,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_user' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				'default' => '0',

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
				'default' => '0',

			),
			'masuk' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				'default' => '0',

			),
			'keluar' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				'default' => '0',

			),
			'create_date' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
			'status' => array(
				'type' => 'INT',
				'constraint' => 1,
				'null' => TRUE,
				'default' => '0',

			),
			'catatan' => array(
				'type' => 'TEXT',
				'null' => TRUE,
				'default' => '1',

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("deposit", TRUE);
		$this->db->query('ALTER TABLE  `deposit` ENGINE = MyISAM');

		## Create Table device
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'token' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => FALSE,

			),
			'device' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => FALSE,

			),
			'device_status' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => FALSE,

			),
			'expired' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => FALSE,

			),
			'messages' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => FALSE,

			),
			'package' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => FALSE,

			),
			'quota' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("device", TRUE);
		$this->db->query('ALTER TABLE  `device` ENGINE = MyISAM');

		## Create Table gaji
		$this->dbforge->add_field(array(
			'ID' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_user' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'gaji_pokok' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'tun_jab' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'transport' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'makan' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'asuransi' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'jam_kerja' => array(
				'type' => 'FLOAT',
				'null' => TRUE,

			),
			'istirahat' => array(
				'type' => 'FLOAT',
				'null' => TRUE,

			),
		));
		$this->dbforge->add_key("ID",true);
		$this->dbforge->create_table("gaji", TRUE);
		$this->db->query('ALTER TABLE  `gaji` ENGINE = MyISAM');

		## Create Table hak_akses
		$this->dbforge->add_field(array(
			'id_level' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_parent' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'nama' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => FALSE,

			),
			'level' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => FALSE,

			),
			'publish' => array(
				'type' => 'ENUM("Y","N")',
				'null' => FALSE,
				'default' => 'Y',

			),
			'status' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				'default' => '0',

			),
		));
		$this->dbforge->add_key("id_level",true);
		$this->dbforge->create_table("hak_akses", TRUE);
		$this->db->query('ALTER TABLE  `hak_akses` ENGINE = MyISAM');

		## Create Table harga
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'title' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => TRUE,

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("harga", TRUE);
		$this->db->query('ALTER TABLE  `harga` ENGINE = MyISAM');

		## Create Table harga_member
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_satuan' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'id_bahan' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'id_member' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'harga_pokok' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				'default' => '0',

			),
			'harga_jual' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("harga_member", TRUE);
		$this->db->query('ALTER TABLE  `harga_member` ENGINE = InnoDB');

		## Create Table harga_range_member
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_member' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'id_bahan' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'id_satuan' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'jumlah_minimal' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'jumlah_maksimal' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'harga_pokok' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				'default' => '0',

			),
			'harga_jual' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'create_date' => array(
				'type' => 'DATETIME',
				'null' => FALSE,
				'default' => 'current_timestamp()',
				'on update current_timestamp()' => TRUE
			),
			'diskon' => array(
				'type' => 'INT',
				'constraint' => 2,
				'null' => FALSE,
				'default' => '0',

			),
			'pub' => array(
				'type' => 'INT',
				'constraint' => 1,
				'null' => FALSE,
				'default' => '0',

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("harga_range_member", TRUE);
		$this->db->query('ALTER TABLE  `harga_range_member` ENGINE = MyISAM');

		## Create Table harga_satuan
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_satuan' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'id_bahan' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'harga_pokok' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				'default' => '0',

			),
			'harga_jual' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("harga_satuan", TRUE);
		$this->db->query('ALTER TABLE  `harga_satuan` ENGINE = MyISAM');

		## Create Table hari_libur
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'tgl' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
			'keterangan' => array(
				'type' => 'VARCHAR',
				'constraint' => 150,
				'null' => TRUE,

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("hari_libur", TRUE);
		$this->db->query('ALTER TABLE  `hari_libur` ENGINE = MyISAM');

		## Create Table history_stok
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_laporan' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'tb' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => FALSE,

			),
			'id_bahan' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'create_date' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
			'jumlah' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'ket' => array(
				'type' => 'VARCHAR',
				'constraint' => 200,
				'null' => FALSE,

			),
			'stat' => array(
				'type' => 'INT',
				'constraint' => 1,
				'null' => FALSE,
				'default' => '1',

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("history_stok", TRUE);
		$this->db->query('ALTER TABLE  `history_stok` ENGINE = InnoDB');

		## Create Table info
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'title' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE,

			),
			'perusahaan' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE,

			),
			'deskripsi' => array(
				'type' => 'TEXT',
				'null' => TRUE,

			),
			'keywords' => array(
				'type' => 'TEXT',
				'null' => TRUE,

			),
			'email' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE,

			),
			'phone' => array(
				'type' => 'VARCHAR',
				'constraint' => 16,
				'null' => TRUE,

			),
			'fb' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE,

			),
			'tw' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE,

			),
			'ig' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE,

			),
			'logo' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE,

			),
			'logo_bw' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,

			),
			'favicon' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE,

			),
			'stamp_l' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE,

			),
			'stamp_b' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE,

			),
			'warna_lunas' => array(
				'type' => 'VARCHAR',
				'constraint' => 10,
				'null' => TRUE,

			),
			'warna_blunas' => array(
				'type' => 'VARCHAR',
				'constraint' => 10,
				'null' => TRUE,

			),
			'tema' => array(
				'type' => 'VARCHAR',
				'constraint' => 10,
				'null' => TRUE,

			),
			'ket' => array(
				'type' => 'TEXT',
				'null' => TRUE,

			),
			'footer_invoice' => array(
				'type' => 'TEXT',
				'null' => TRUE,

			),
			'demo' => array(
				'type' => 'ENUM("Y","N")',
				'null' => FALSE,
				'default' => 'N',

			),
			'api_key' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,

			),
			'version' => array(
				'type' => 'VARCHAR',
				'constraint' => 10,
				'null' => TRUE,

			),
			'dev_tools' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				'default' => '0',

			),
			'user_name' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => TRUE,

			),
			'user_pass' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => TRUE,

			),
			'versi_pro' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => TRUE,

			),
			'versi_custom' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => TRUE,

			),
			'kode_qris' => array(
				'type' => 'TEXT',
				'null' => TRUE,

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("info", TRUE);
		$this->db->query('ALTER TABLE  `info` ENGINE = MyISAM');

		## Create Table invoice
		$this->dbforge->add_field(array(
			'id_invoice' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_transaksi' => array(
				'type' => 'VARCHAR',
				'constraint' => 11,
				'null' => TRUE,

			),
			'total_bayar' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'jumlah_bayar' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'kembalian' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'potongan_harga' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'cashback' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'pajak' => array(
				'type' => 'FLOAT',
				'null' => FALSE,
				'default' => '0',

			),
			'pos' => array(
				'type' => 'ENUM("Y","N")',
				'null' => FALSE,
				'default' => 'N',

			),
			'lunas' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'tgl_trx' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
			'jam_order' => array(
				'type' => 'TIME',
				'null' => FALSE,

			),
			'tgl_ambil' => array(
				'type' => 'DATETIME',
				'null' => TRUE,

			),
			'id_user' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'id_marketing' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'id_desain' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'tgl_update' => array(
				'type' => 'DATETIME',
				'null' => TRUE,
				'default' => 'current_timestamp()',

			),
			'status' => array(
				'type' => 'ENUM("baru","simpan","edit","pending","batal")',
				'null' => FALSE,
				'default' => 'baru',

			),
			'oto' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'history' => array(
				'type' => 'TEXT',
				'null' => TRUE,

			),
			'data_json' => array(
				'type' => 'TEXT',
				'null' => TRUE,

			),
			'id_konsumen' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'cetak' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'sesi_cart' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,

			),
		));
		$this->dbforge->add_key("id_invoice",true);
		$this->dbforge->create_table("invoice", TRUE);
		$this->db->query('ALTER TABLE  `invoice` ENGINE = InnoDB');

		## Create Table invoice_detail
		$this->dbforge->add_field(array(
			'id_rincianinvoice' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'no_spk' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE,

			),
			'id_invoice' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'id_produk' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'jenis_cetakan' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				'default' => '0',

			),
			'status_hitung' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'type_harga' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'id_mesin' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '1',

			),
			'keterangan' => array(
				'type' => 'TEXT',
				'null' => TRUE,

			),
			'detail' => array(
				'type' => 'TEXT',
				'null' => TRUE,

			),
			'jumlah' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				'default' => '0',

			),
			'harga' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				'default' => '0',

			),
			'diskon' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'satuan' => array(
				'type' => 'VARCHAR',
				'constraint' => 10,
				'null' => TRUE,

			),
			'id_satuan' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'ukuran' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => TRUE,

			),
			'tot_ukuran' => array(
				'type' => 'FLOAT',
				'null' => TRUE,
				'default' => '0',

			),
			'hpp' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'uk_real' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => TRUE,
				'default' => '0',

			),
			'id_bahan' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				'default' => '0',

			),
			'catatan' => array(
				'type' => 'TEXT',
				'null' => TRUE,

			),
			'ambil' => array(
				'type' => 'ENUM("Y","N")',
				'null' => TRUE,
				'default' => 'N',

			),
			'rak' => array(
				'type' => 'ENUM("Y","N")',
				'null' => FALSE,
				'default' => 'N',

			),
			'id_operator' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				'default' => '0',

			),
			'id_pengirim' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				'default' => '0',

			),
			'id_gudang' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				'default' => '0',

			),
			'jumlah_kirim' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				'default' => '0',

			),
			'status' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'kunci' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'token' => array(
				'type' => 'VARCHAR',
				'constraint' => 6,
				'null' => TRUE,

			),
			'update_date' => array(
				'type' => 'DATETIME',
				'null' => FALSE,
				'default' => 'current_timestamp()',

			),
		));
		$this->dbforge->add_key("id_rincianinvoice",true);
		$this->dbforge->create_table("invoice_detail", TRUE);
		$this->db->query('ALTER TABLE  `invoice_detail` ENGINE = InnoDB');

		## Create Table izin
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_user' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'tgl' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
			'keterangan' => array(
				'type' => 'VARCHAR',
				'constraint' => 150,
				'null' => TRUE,

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("izin", TRUE);
		$this->db->query('ALTER TABLE  `izin` ENGINE = MyISAM');

		## Create Table jenis_akun
		$this->dbforge->add_field(array(
			'id_jenis_akun' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'nama_jenis_akun' => array(
				'type' => 'VARCHAR',
				'constraint' => 30,
				'null' => TRUE,

			),
		));
		$this->dbforge->add_key("id_jenis_akun",true);
		$this->dbforge->create_table("jenis_akun", TRUE);
		$this->db->query('ALTER TABLE  `jenis_akun` ENGINE = MyISAM');

		## Create Table jenis_bayar
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_akun' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'nama_bayar' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => FALSE,

			),
			'publish' => array(
				'type' => 'ENUM("Y","N")',
				'null' => FALSE,
				'default' => 'Y',

			),
			'kunci' => array(
				'type' => 'INT',
				'constraint' => 1,
				'null' => FALSE,
				'default' => '0',

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("jenis_bayar", TRUE);
		$this->db->query('ALTER TABLE  `jenis_bayar` ENGINE = MyISAM');

		## Create Table jenis_cetakan
		$this->dbforge->add_field(array(
			'id_jenis' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'jenis_cetakan' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => TRUE,

			),
			'kunci' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'status' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'id_akun' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'pub' => array(
				'type' => 'ENUM("Y","N")',
				'null' => FALSE,
				'default' => 'Y',

			),
		));
		$this->dbforge->add_key("id_jenis",true);
		$this->dbforge->create_table("jenis_cetakan", TRUE);
		$this->db->query('ALTER TABLE  `jenis_cetakan` ENGINE = MyISAM');

		## Create Table jenis_kas
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'title' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => FALSE,

			),
			'id_akun' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'kunci' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'status' => array(
				'type' => 'INT',
				'constraint' => 1,
				'null' => FALSE,
				'default' => '0',

			),
			'aktiva' => array(
				'type' => 'ENUM("Y","N")',
				'null' => FALSE,
				'default' => 'N',

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("jenis_kas", TRUE);
		$this->db->query('ALTER TABLE  `jenis_kas` ENGINE = MyISAM');

		## Create Table jenis_lembaga
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'title' => array(
				'type' => 'VARCHAR',
				'constraint' => 30,
				'null' => TRUE,

			),
			'pub' => array(
				'type' => 'INT',
				'constraint' => 1,
				'null' => FALSE,
				'default' => '0',

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("jenis_lembaga", TRUE);
		$this->db->query('ALTER TABLE  `jenis_lembaga` ENGINE = MyISAM');

		## Create Table jenis_pengeluaran
		$this->dbforge->add_field(array(
			'id_jenis' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'title' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE,

			),
			'kunci' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'id_akun' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'pub' => array(
				'type' => 'ENUM("Y","N")',
				'null' => FALSE,
				'default' => 'Y',

			),
			'status' => array(
				'type' => 'INT',
				'constraint' => 1,
				'null' => FALSE,
				'default' => '0',

			),
		));
		$this->dbforge->add_key("id_jenis",true);
		$this->dbforge->create_table("jenis_pengeluaran", TRUE);
		$this->db->query('ALTER TABLE  `jenis_pengeluaran` ENGINE = MyISAM');

		## Create Table jurnal_transaksi
		$this->dbforge->add_field(array(
			'id_transaksi' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_user' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'no_reff' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'reff' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE,

			),
			'tgl_input' => array(
				'type' => 'DATETIME',
				'null' => FALSE,

			),
			'tgl_transaksi' => array(
				'type' => 'DATE',
				'null' => FALSE,

			),
			'jenis_saldo' => array(
				'type' => 'ENUM("debit","kredit")',
				'null' => FALSE,

			),
			'saldo' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'keterangan' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,

			),
		));
		$this->dbforge->add_key("id_transaksi",true);
		$this->dbforge->create_table("jurnal_transaksi", TRUE);
		$this->db->query('ALTER TABLE  `jurnal_transaksi` ENGINE = InnoDB');

		## Create Table kas_masuk
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_generate' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => TRUE,

			),
			'id_jenis' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'id_parent' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'id_user' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'id_bayar' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'id_sub_bayar' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'no_reff' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE,

			),
			'catatan' => array(
				'type' => 'VARCHAR',
				'constraint' => 200,
				'null' => TRUE,

			),
			'pemasukan' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'pengeluaran' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'create_date' => array(
				'type' => 'DATETIME',
				'null' => FALSE,
				'default' => 'current_timestamp()',

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("kas_masuk", TRUE);
		$this->db->query('ALTER TABLE  `kas_masuk` ENGINE = InnoDB');

		## Create Table kasbon
		$this->dbforge->add_field(array(
			'id_kasbon' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'tgl_kasbon' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
			'jenis_kasbon' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => TRUE,

			),
			'id_pegawai' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'pinjam' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'bayar' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'catatan' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE,

			),
			'status_bayar' => array(
				'type' => 'INT',
				'constraint' => 1,
				'null' => FALSE,
				'default' => '0',

			),
		));
		$this->dbforge->add_key("id_kasbon",true);
		$this->dbforge->create_table("kasbon", TRUE);
		$this->db->query('ALTER TABLE  `kasbon` ENGINE = MyISAM');

		## Create Table konsumen
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_member' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => TRUE,

			),
			'kode_unik' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => TRUE,

			),
			'panggilan' => array(
				'type' => 'VARCHAR',
				'constraint' => 10,
				'null' => TRUE,

			),
			'jenis' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '1',

			),
			'jenis_member' => array(
				'type' => 'INT',
				'constraint' => 2,
				'null' => FALSE,
				'default' => '1',

			),
			'nama' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE,

			),
			'no_hp' => array(
				'type' => 'VARCHAR',
				'constraint' => 17,
				'null' => TRUE,

			),
			'tgl_daftar' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
			'last_update' => array(
				'type' => 'DATETIME',
				'null' => TRUE,
				'default' => 'current_timestamp()',

			),
			'referal' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => TRUE,

			),
			'alamat' => array(
				'type' => 'TEXT',
				'null' => TRUE,

			),
			'perusahaan' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE,

			),
			'alamat_lembaga' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => FALSE,

			),
			'no_telp' => array(
				'type' => 'VARCHAR',
				'constraint' => 17,
				'null' => FALSE,

			),
			'email' => array(
				'type' => 'VARCHAR',
				'constraint' => 30,
				'null' => FALSE,

			),
			'tampil' => array(
				'type' => 'INT',
				'constraint' => 1,
				'null' => FALSE,
				'default' => '0',

			),
			'kunci' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'status' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'hapus' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'history' => array(
				'type' => 'TEXT',
				'null' => TRUE,

			),
			'max_utang' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				'default' => '3',

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("konsumen", TRUE);
		$this->db->query('ALTER TABLE  `konsumen` ENGINE = MyISAM');

		## Create Table laporan_penerimaan
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_invoice' => array(
				'type' => 'MEDIUMTEXT',
				'null' => TRUE,

			),
			'id_user' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'id_penerima' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'total' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'tanggal' => array(
				'type' => 'DATE',
				'null' => FALSE,

			),
			'tanggal_verifikasi' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
			'tanggal_setor' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
			'tanggal_terima' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
			'create_date' => array(
				'type' => 'DATETIME',
				'null' => FALSE,
				'default' => 'current_timestamp()',

			),
			'status' => array(
				'type' => 'INT',
				'constraint' => 1,
				'null' => FALSE,
				'default' => '0',

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("laporan_penerimaan", TRUE);
		$this->db->query('ALTER TABLE  `laporan_penerimaan` ENGINE = MyISAM');

		## Create Table laporan_stok
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'title' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => FALSE,

			),
			'tanggal' => array(
				'type' => 'DATE',
				'null' => FALSE,

			),
			'stat' => array(
				'type' => 'INT',
				'constraint' => 1,
				'null' => FALSE,
				'default' => '1',

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("laporan_stok", TRUE);
		$this->db->query('ALTER TABLE  `laporan_stok` ENGINE = InnoDB');

		## Create Table member
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'title' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => FALSE,

			),
			'nominal_belanja' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'nominal_upgrade' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'potongan_diskon' => array(
				'type' => 'INT',
				'constraint' => 2,
				'null' => FALSE,
				'default' => '0',

			),
			'potongan_harga' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'status' => array(
				'type' => 'INT',
				'constraint' => 1,
				'null' => FALSE,
				'default' => '0',

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("member", TRUE);
		$this->db->query('ALTER TABLE  `member` ENGINE = MyISAM');

		## Create Table menuadmin
		$this->dbforge->add_field(array(
			'idmenu' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'idparent' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'id_level' => array(
				'type' => 'TINYTEXT',
				'null' => TRUE,

			),
			'nama_menu' => array(
				'type' => 'VARCHAR',
				'constraint' => 200,
				'null' => TRUE,

			),
			'link' => array(
				'type' => 'VARCHAR',
				'constraint' => 200,
				'null' => TRUE,

			),
			'target' => array(
				'type' => 'VARCHAR',
				'constraint' => 10,
				'null' => FALSE,
				'default' => '_self',

			),
			'link_on' => array(
				'type' => 'ENUM("Y","N")',
				'null' => FALSE,
				'default' => 'Y',

			),
			'treeview' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => FALSE,
				'default' => 'treeview',

			),
			'classes' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => TRUE,

			),
			'classicon' => array(
				'type' => 'ENUM("Y","N")',
				'null' => FALSE,
				'default' => 'Y',

			),
			'icon' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => TRUE,

			),
			'aktif' => array(
				'type' => 'ENUM("Y","N")',
				'null' => FALSE,
				'default' => 'Y',

			),
			'level' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE,

			),
			'urutan' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
		));
		$this->dbforge->add_key("idmenu",true);
		$this->dbforge->create_table("menuadmin", TRUE);
		$this->db->query('ALTER TABLE  `menuadmin` ENGINE = MyISAM');

		## Create Table mesin
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'nama_mesin' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE,

			),
			'pemilik' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE,

			),
			'publish' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("mesin", TRUE);
		$this->db->query('ALTER TABLE  `mesin` ENGINE = MyISAM');

		## Create Table migrations
		$this->dbforge->add_field(array(
			'version' => array(
				'type' => 'BIGINT',
				'constraint' => 20,
				'null' => FALSE,

			),
		));

		$this->dbforge->create_table("migrations", TRUE);
		$this->db->query('ALTER TABLE  `migrations` ENGINE = InnoDB');

		## Create Table nama_barang
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_satuan' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'title' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => FALSE,

			),
			'create_date' => array(
				'type' => 'DATE',
				'null' => FALSE,

			),
			'stat' => array(
				'type' => 'INT',
				'constraint' => 1,
				'null' => FALSE,
				'default' => '0',

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("nama_barang", TRUE);
		$this->db->query('ALTER TABLE  `nama_barang` ENGINE = InnoDB');

		## Create Table pembelian
		$this->dbforge->add_field(array(
			'id_pembelian' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_bayar' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'id_kas' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'tgl_pembelian' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
			'tgl_rekap' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
			'tgl_jatuhtempo' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
			'id_user' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'total_bayar' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'pos' => array(
				'type' => 'ENUM("Y","N")',
				'null' => FALSE,
				'default' => 'N',

			),
			'rekap' => array(
				'type' => 'ENUM("Y","N")',
				'null' => FALSE,
				'default' => 'N',

			),
			'stok' => array(
				'type' => 'ENUM("Y","N")',
				'null' => FALSE,
				'default' => 'N',

			),
			'lunas' => array(
				'type' => 'ENUM("Y","N")',
				'null' => TRUE,
				'default' => 'N',

			),
		));
		$this->dbforge->add_key("id_pembelian",true);
		$this->dbforge->create_table("pembelian", TRUE);
		$this->db->query('ALTER TABLE  `pembelian` ENGINE = InnoDB');

		## Create Table pembelian_detail
		$this->dbforge->add_field(array(
			'no' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_bahan' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'id_pembelian' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'id_biaya' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				'default' => '0',

			),
			'id_supplier' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				'default' => '1',

			),
			'no_invo' => array(
				'type' => 'VARCHAR',
				'constraint' => 25,
				'null' => TRUE,

			),
			'keterangan' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE,

			),
			'jumlah' => array(
				'type' => 'FLOAT',
				'null' => TRUE,
				'default' => '0',

			),
			'harga' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				'default' => '0',

			),
			'satuan' => array(
				'type' => 'VARCHAR',
				'constraint' => 10,
				'null' => TRUE,

			),
			'id_pemesan' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				'default' => '0',

			),
			'no_order' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => TRUE,

			),
			'create_date' => array(
				'type' => 'DATETIME',
				'null' => FALSE,
				'default' => 'current_timestamp()',

			),
		));
		$this->dbforge->add_key("no",true);
		$this->dbforge->create_table("pembelian_detail", TRUE);
		$this->db->query('ALTER TABLE  `pembelian_detail` ENGINE = InnoDB');

		## Create Table pengaturan_kertas
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'title' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE,

			),
			'modul' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE,

			),
			'ukuran' => array(
				'type' => 'ENUM("A3","A4","A5","A6")',
				'null' => FALSE,
				'default' => 'A4',

			),
			'posisi' => array(
				'type' => 'ENUM("potrait","landscape")',
				'null' => FALSE,
				'default' => 'potrait',

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("pengaturan_kertas", TRUE);
		$this->db->query('ALTER TABLE  `pengaturan_kertas` ENGINE = MyISAM');

		## Create Table pengaturan_presensi
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'jam_masuk_shift_1' => array(
				'type' => 'TIME',
				'null' => FALSE,

			),
			'jam_masuk_shift_2' => array(
				'type' => 'TIME',
				'null' => FALSE,

			),
			'jam_pulang_shift_1' => array(
				'type' => 'TIME',
				'null' => FALSE,

			),
			'jam_pulang_shift_2' => array(
				'type' => 'TIME',
				'null' => FALSE,

			),
			'toleransi_shift_1' => array(
				'type' => 'TIME',
				'null' => FALSE,

			),
			'toleransi_shift_2' => array(
				'type' => 'TIME',
				'null' => FALSE,

			),
			'jumlah_libur' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'hari_kerja' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("pengaturan_presensi", TRUE);
		$this->db->query('ALTER TABLE  `pengaturan_presensi` ENGINE = MyISAM');

		## Create Table pengeluaran
		$this->dbforge->add_field(array(
			'id_pengeluaran' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_bayar' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'id_kas' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'tgl_pengeluaran' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
			'tgl_rekap' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
			'tgl_jatuhtempo' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
			'id_user' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'total_bayar' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'pos' => array(
				'type' => 'ENUM("Y","N")',
				'null' => FALSE,
				'default' => 'N',

			),
			'rekap' => array(
				'type' => 'ENUM("Y","N")',
				'null' => FALSE,
				'default' => 'N',

			),
			'lunas' => array(
				'type' => 'ENUM("Y","N")',
				'null' => TRUE,
				'default' => 'N',

			),
		));
		$this->dbforge->add_key("id_pengeluaran",true);
		$this->dbforge->create_table("pengeluaran", TRUE);
		$this->db->query('ALTER TABLE  `pengeluaran` ENGINE = InnoDB');

		## Create Table pengeluaran_detail
		$this->dbforge->add_field(array(
			'no' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_pengeluaran' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'id_biaya' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				'default' => '0',

			),
			'id_supplier' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				'default' => '1',

			),
			'no_invo' => array(
				'type' => 'VARCHAR',
				'constraint' => 25,
				'null' => TRUE,

			),
			'keterangan' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE,

			),
			'jumlah' => array(
				'type' => 'FLOAT',
				'null' => TRUE,
				'default' => '0',

			),
			'harga' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				'default' => '0',

			),
			'satuan' => array(
				'type' => 'VARCHAR',
				'constraint' => 10,
				'null' => TRUE,

			),
			'id_pemesan' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				'default' => '0',

			),
			'no_order' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => TRUE,

			),
			'create_date' => array(
				'type' => 'DATETIME',
				'null' => FALSE,
				'default' => 'current_timestamp()',

			),
		));
		$this->dbforge->add_key("no",true);
		$this->dbforge->create_table("pengeluaran_detail", TRUE);
		$this->db->query('ALTER TABLE  `pengeluaran_detail` ENGINE = InnoDB');

		## Create Table printer
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => FALSE,

			),
			'ukuran_kertas' => array(
				'type' => 'VARCHAR',
				'constraint' => 10,
				'null' => TRUE,

			),
			'ukuran_font' => array(
				'type' => 'DECIMAL',
				'constraint' => 10,0,
				'null' => FALSE,

			),
			'posisi' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => TRUE,

			),
			'max_item' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'shared_name' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE,

			),
			'slug' => array(
				'type' => 'VARCHAR',
				'constraint' => 10,
				'null' => TRUE,

			),
			'pub' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'show_footer' => array(
				'type' => 'INT',
				'constraint' => 1,
				'null' => TRUE,
				'default' => '0',

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("printer", TRUE);
		$this->db->query('ALTER TABLE  `printer` ENGINE = MyISAM');

		## Create Table produk
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_jenis' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				'default' => '0',

			),
			'id_bahan' => array(
				'type' => 'VARCHAR',
				'constraint' => 200,
				'null' => TRUE,
				'default' => '0',

			),
			'barcode' => array(
				'type' => 'VARCHAR',
				'constraint' => 15,
				'null' => TRUE,

			),
			'title' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE,

			),
			'harga_beli' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'harga_jual' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'harga_grosir' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'diskon' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'ukuran' => array(
				'type' => 'VARCHAR',
				'constraint' => 10,
				'null' => TRUE,

			),
			'jumlah' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '1',

			),
			'pub' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '1',

			),
			'kunci' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'lock_harga' => array(
				'type' => 'ENUM("Y","N")',
				'null' => FALSE,
				'default' => 'N',

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("produk", TRUE);
		$this->db->query('ALTER TABLE  `produk` ENGINE = MyISAM');

		## Create Table range_harga
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_bahan' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'id_satuan' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'jumlah_minimal' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'jumlah_maksimal' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'harga_pokok' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				'default' => '0',

			),
			'harga_jual' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'create_date' => array(
				'type' => 'DATETIME',
				'null' => FALSE,
				'default' => 'current_timestamp()',
				'on update current_timestamp()' => TRUE
			),
			'diskon' => array(
				'type' => 'INT',
				'constraint' => 2,
				'null' => FALSE,
				'default' => '0',

			),
			'pub' => array(
				'type' => 'INT',
				'constraint' => 1,
				'null' => FALSE,
				'default' => '0',

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("range_harga", TRUE);
		$this->db->query('ALTER TABLE  `range_harga` ENGINE = MyISAM');

		## Create Table referal
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'title' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => TRUE,

			),
			'slug' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => TRUE,

			),
			'pub' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '1',

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("referal", TRUE);
		$this->db->query('ALTER TABLE  `referal` ENGINE = MyISAM');

		## Create Table rekening_bank
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_akun' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				'default' => '3',

			),
			'nama_bank' => array(
				'type' => 'VARCHAR',
				'constraint' => 30,
				'null' => TRUE,

			),
			'inisial' => array(
				'type' => 'VARCHAR',
				'constraint' => 10,
				'null' => TRUE,

			),
			'nomor_rekening' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => TRUE,

			),
			'pemilik' => array(
				'type' => 'VARCHAR',
				'constraint' => 40,
				'null' => TRUE,

			),
			'footer_invoice' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'publish' => array(
				'type' => 'VARCHAR',
				'constraint' => 1,
				'null' => FALSE,
				'default' => 'Y',

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("rekening_bank", TRUE);
		$this->db->query('ALTER TABLE  `rekening_bank` ENGINE = MyISAM');

		## Create Table report
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_kirim' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'id_konsumen' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'device' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,

			),
			'target' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => FALSE,

			),
			'message' => array(
				'type' => 'TEXT',
				'null' => FALSE,

			),
			'stateid' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,

			),
			'status' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => FALSE,

			),
			'state' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,

			),
			'create_date' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("report", TRUE);
		$this->db->query('ALTER TABLE  `report` ENGINE = InnoDB');

		## Create Table report_pesan
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_kirim' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'id_konsumen' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'device' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,

			),
			'target' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => FALSE,

			),
			'message' => array(
				'type' => 'TEXT',
				'null' => FALSE,

			),
			'stateid' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,

			),
			'status' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => FALSE,

			),
			'state' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,

			),
			'create_date' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("report_pesan", TRUE);
		$this->db->query('ALTER TABLE  `report_pesan` ENGINE = InnoDB');

		## Create Table satu_harga
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_bahan' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'id_satuan' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'harga_beli' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				'default' => '0',

			),
			'harga_pokok' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'detail_harga_pokok' => array(
				'type' => 'TEXT',
				'null' => TRUE,

			),
			'persen' => array(
				'type' => 'INT',
				'constraint' => 1,
				'null' => FALSE,
				'default' => '0',

			),
			'harga_jual' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("satu_harga", TRUE);
		$this->db->query('ALTER TABLE  `satu_harga` ENGINE = MyISAM');

		## Create Table satuan
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'satuan' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => FALSE,

			),
			'nama_satuan' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE,

			),
			'jumlah' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'pub' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("satuan", TRUE);
		$this->db->query('ALTER TABLE  `satuan` ENGINE = MyISAM');

		## Create Table shared_folder
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'nama' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => FALSE,

			),
			'isi' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => FALSE,

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("shared_folder", TRUE);
		$this->db->query('ALTER TABLE  `shared_folder` ENGINE = MyISAM');

		## Create Table slip_gaji
		$this->dbforge->add_field(array(
			'id_slip' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_user' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'tgl_rekap' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
			'bulan_gaji' => array(
				'type' => 'VARCHAR',
				'constraint' => 5,
				'null' => TRUE,

			),
			'tahun_gaji' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'gaji_pokok' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'tun_jab' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'transport' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'makan' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'asuransi' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'jam_kerja' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'istirahat' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'jml_kerja' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'jml_cuti' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'jml_libur' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'gaji_kotor' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'lembur' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'tot_makan' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'tot_transport' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'tot_tun_cuti' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'tot_tun_libur' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'tot_tun_jab' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'tot_bonus' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'pot_absen' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'pot_asuransi' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'pot_kasbon' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'uang_makan_diambil' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'uang_trans_diambil' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
		));
		$this->dbforge->add_key("id_slip",true);
		$this->dbforge->create_table("slip_gaji", TRUE);
		$this->db->query('ALTER TABLE  `slip_gaji` ENGINE = MyISAM');

		## Create Table stok_keluar
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_invoice' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'id_bahan' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'jumlah' => array(
				'type' => 'FLOAT',
				'null' => FALSE,
				'default' => '0',

			),
			'create_date' => array(
				'type' => 'DATETIME',
				'null' => FALSE,

			),
			'ket' => array(
				'type' => 'VARCHAR',
				'constraint' => 200,
				'null' => TRUE,

			),
			'stat' => array(
				'type' => 'INT',
				'constraint' => 1,
				'null' => FALSE,
				'default' => '1',

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("stok_keluar", TRUE);
		$this->db->query('ALTER TABLE  `stok_keluar` ENGINE = InnoDB');

		## Create Table stok_keluar_gudang
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_barang' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'id_user' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'jumlah' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'create_date' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
			'ket' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,

			),
			'stat' => array(
				'type' => 'INT',
				'constraint' => 1,
				'null' => FALSE,
				'default' => '1',

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("stok_keluar_gudang", TRUE);
		$this->db->query('ALTER TABLE  `stok_keluar_gudang` ENGINE = InnoDB');

		## Create Table stok_masuk
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_bahan' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'jumlah' => array(
				'type' => 'FLOAT',
				'null' => FALSE,
				'default' => '0',

			),
			'harga_beli' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'harga_jual' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'create_date' => array(
				'type' => 'DATETIME',
				'null' => FALSE,

			),
			'update_date' => array(
				'type' => 'DATETIME',
				'null' => FALSE,
				'default' => 'current_timestamp()',

			),
			'ket' => array(
				'type' => 'VARCHAR',
				'constraint' => 200,
				'null' => TRUE,

			),
			'stat' => array(
				'type' => 'INT',
				'constraint' => 1,
				'null' => FALSE,
				'default' => '1',

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("stok_masuk", TRUE);
		$this->db->query('ALTER TABLE  `stok_masuk` ENGINE = InnoDB');

		## Create Table stok_masuk_gudang
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_barang' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'id_user' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'jumlah' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,

			),
			'create_date' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
			'ket' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,

			),
			'stat' => array(
				'type' => 'INT',
				'constraint' => 1,
				'null' => FALSE,
				'default' => '1',

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("stok_masuk_gudang", TRUE);
		$this->db->query('ALTER TABLE  `stok_masuk_gudang` ENGINE = InnoDB');

		## Create Table supplier
		$this->dbforge->add_field(array(
			'id_supplier' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'nama_perusahaan' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => FALSE,

			),
			'jenis_usaha' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE,

			),
			'pemilik' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => TRUE,

			),
			'jabatan' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => TRUE,

			),
			'alamat' => array(
				'type' => 'VARCHAR',
				'constraint' => 150,
				'null' => TRUE,

			),
			'telp' => array(
				'type' => 'VARCHAR',
				'constraint' => 25,
				'null' => TRUE,

			),
			'email' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE,

			),
			'nomor_rekening' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => TRUE,

			),
			'tgl_terdaftar' => array(
				'type' => 'DATETIME',
				'null' => FALSE,
				'default' => 'current_timestamp()',

			),
			'publish' => array(
				'type' => 'ENUM("Y","N")',
				'null' => TRUE,
				'default' => 'Y',

			),
			'kunci' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
		));
		$this->dbforge->add_key("id_supplier",true);
		$this->dbforge->create_table("supplier", TRUE);
		$this->db->query('ALTER TABLE  `supplier` ENGINE = MyISAM');

		## Create Table surat_jalan
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_user' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'id_invoice' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'no_pol' => array(
				'type' => 'VARCHAR',
				'constraint' => 10,
				'null' => TRUE,

			),
			'alamat_kirim' => array(
				'type' => 'TEXT',
				'null' => TRUE,

			),
			'catatan' => array(
				'type' => 'TEXT',
				'null' => TRUE,

			),
			'tanggal' => array(
				'type' => 'DATE',
				'null' => FALSE,

			),
			'stat' => array(
				'type' => 'INT',
				'constraint' => 1,
				'null' => FALSE,
				'default' => '0',

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("surat_jalan", TRUE);
		$this->db->query('ALTER TABLE  `surat_jalan` ENGINE = MyISAM');

		## Create Table tb_users
		$this->dbforge->add_field(array(
			'id_user' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'parent' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'idmenu' => array(
				'type' => 'TEXT',
				'null' => TRUE,

			),
			'id_level' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE,
				'default' => '2',

			),
			'idlevel' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE,
				'default' => '1,2,3,4',

			),
			'password' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,

			),
			'nama_lengkap' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE,

			),
			'tgl_daftar' => array(
				'type' => 'DATE',
				'null' => TRUE,

			),
			'alamat' => array(
				'type' => 'VARCHAR',
				'constraint' => 30,
				'null' => TRUE,

			),
			'email' => array(
				'type' => 'VARCHAR',
				'constraint' => 30,
				'null' => TRUE,

			),
			'no_hp' => array(
				'type' => 'VARCHAR',
				'constraint' => 30,
				'null' => TRUE,

			),
			'foto' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,

			),
			'level' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'null' => TRUE,

			),
			'aktif' => array(
				'type' => 'ENUM("Y","N")',
				'null' => FALSE,
				'default' => 'Y',

			),
			'hak_akses' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'type_akses' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => FALSE,
				'default' => '0',

			),
			'id_session' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE,

			),
			'sesi_login' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE,

			),
			'logo' => array(
				'type' => 'VARCHAR',
				'constraint' => 200,
				'null' => TRUE,

			),
			'verify' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'app_secret' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,

			),
			'last_invoice' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'last_idp' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => TRUE,
				'default' => '0',

			),
			'last_idbeli' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
		));
		$this->dbforge->add_key("id_user",true);
		$this->dbforge->create_table("tb_users", TRUE);
		$this->db->query('ALTER TABLE  `tb_users` ENGINE = MyISAM');

		## Create Table template_pesan
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'title' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE,

			),
			'deskripsi' => array(
				'type' => 'MEDIUMTEXT',
				'null' => TRUE,

			),
			'status' => array(
				'type' => 'VARCHAR',
				'constraint' => 1,
				'null' => TRUE,
				'default' => '0',

			),
			'create_date' => array(
				'type' => 'DATETIME',
				'null' => FALSE,

			),
			'active' => array(
				'type' => 'ENUM("Y","N")',
				'null' => TRUE,
				'default' => 'Y',

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("template_pesan", TRUE);
		$this->db->query('ALTER TABLE  `template_pesan` ENGINE = MyISAM');

		## Create Table template_promo
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'title' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE,

			),
			'deskripsi' => array(
				'type' => 'MEDIUMTEXT',
				'null' => TRUE,

			),
			'status' => array(
				'type' => 'VARCHAR',
				'constraint' => 1,
				'null' => TRUE,
				'default' => '0',

			),
			'jenis_pesan' => array(
				'type' => 'INT',
				'constraint' => 1,
				'null' => FALSE,
				'default' => '0',

			),
			'url' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,

			),
			'filename' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => TRUE,

			),
			'filetype' => array(
				'type' => 'VARCHAR',
				'constraint' => 10,
				'null' => TRUE,

			),
			'create_date' => array(
				'type' => 'DATETIME',
				'null' => FALSE,

			),
			'active' => array(
				'type' => 'ENUM("Y","N")',
				'null' => TRUE,
				'default' => 'Y',

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("template_promo", TRUE);
		$this->db->query('ALTER TABLE  `template_promo` ENGINE = MyISAM');

		## Create Table themes
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'title' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE,

			),
			'folder' => array(
				'type' => 'VARCHAR',
				'constraint' => 10,
				'null' => TRUE,

			),
			'pub' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("themes", TRUE);
		$this->db->query('ALTER TABLE  `themes` ENGINE = MyISAM');

		## Create Table type_akses
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_parent' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'title' => array(
				'type' => 'VARCHAR',
				'constraint' => 30,
				'null' => FALSE,

			),
			'slug' => array(
				'type' => 'VARCHAR',
				'constraint' => 10,
				'null' => FALSE,

			),
			'status' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '0',

			),
			'pub' => array(
				'type' => 'INT',
				'constraint' => 1,
				'null' => FALSE,
				'default' => '0',

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("type_akses", TRUE);
		$this->db->query('ALTER TABLE  `type_akses` ENGINE = MyISAM');

		## Create Table uang_makan
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_user' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'tanggal' => array(
				'type' => 'DATE',
				'null' => FALSE,

			),
			'jumlah' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("uang_makan", TRUE);
		$this->db->query('ALTER TABLE  `uang_makan` ENGINE = MyISAM');

		## Create Table uang_transport
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'id_user' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
			'tanggal' => array(
				'type' => 'DATE',
				'null' => FALSE,

			),
			'jumlah' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("uang_transport", TRUE);
		$this->db->query('ALTER TABLE  `uang_transport` ENGINE = MyISAM');

		## Create Table user_agent
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'auto_increment' => TRUE
			),
			'ip' => array(
				'type' => 'VARCHAR',
				'constraint' => 15,
				'null' => TRUE,

			),
			'os' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE,

			),
			'browser' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'null' => TRUE,

			),
			'counter' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => FALSE,
				'default' => '1',

			),
			'create_date' => array(
				'type' => 'DATETIME',
				'null' => TRUE,

			),
			'update_date' => array(
				'type' => 'DATETIME',
				'null' => TRUE,
				'default' => 'current_timestamp()',

			),
		));
		$this->dbforge->add_key("id",true);
		$this->dbforge->create_table("user_agent", TRUE);
		$this->db->query('ALTER TABLE  `user_agent` ENGINE = MyISAM');
	 }

	public function down()	{
		### Drop table absen ##
		$this->dbforge->drop_table("absen", TRUE);
		### Drop table akun ##
		$this->dbforge->drop_table("akun", TRUE);
		### Drop table bahan ##
		$this->dbforge->drop_table("bahan", TRUE);
		### Drop table bayar_gaji ##
		$this->dbforge->drop_table("bayar_gaji", TRUE);
		### Drop table bayar_invoice_detail ##
		$this->dbforge->drop_table("bayar_invoice_detail", TRUE);
		### Drop table bayar_pembelian ##
		$this->dbforge->drop_table("bayar_pembelian", TRUE);
		### Drop table bayar_pengeluaran ##
		$this->dbforge->drop_table("bayar_pengeluaran", TRUE);
		### Drop table bayar_piutang ##
		$this->dbforge->drop_table("bayar_piutang", TRUE);
		### Drop table bonus ##
		$this->dbforge->drop_table("bonus", TRUE);
		### Drop table ci_sessions ##
		$this->dbforge->drop_table("ci_sessions", TRUE);
		### Drop table deposit ##
		$this->dbforge->drop_table("deposit", TRUE);
		### Drop table device ##
		$this->dbforge->drop_table("device", TRUE);
		### Drop table gaji ##
		$this->dbforge->drop_table("gaji", TRUE);
		### Drop table hak_akses ##
		$this->dbforge->drop_table("hak_akses", TRUE);
		### Drop table harga ##
		$this->dbforge->drop_table("harga", TRUE);
		### Drop table harga_member ##
		$this->dbforge->drop_table("harga_member", TRUE);
		### Drop table harga_range_member ##
		$this->dbforge->drop_table("harga_range_member", TRUE);
		### Drop table harga_satuan ##
		$this->dbforge->drop_table("harga_satuan", TRUE);
		### Drop table hari_libur ##
		$this->dbforge->drop_table("hari_libur", TRUE);
		### Drop table history_stok ##
		$this->dbforge->drop_table("history_stok", TRUE);
		### Drop table info ##
		$this->dbforge->drop_table("info", TRUE);
		### Drop table invoice ##
		$this->dbforge->drop_table("invoice", TRUE);
		### Drop table invoice_detail ##
		$this->dbforge->drop_table("invoice_detail", TRUE);
		### Drop table izin ##
		$this->dbforge->drop_table("izin", TRUE);
		### Drop table jenis_akun ##
		$this->dbforge->drop_table("jenis_akun", TRUE);
		### Drop table jenis_bayar ##
		$this->dbforge->drop_table("jenis_bayar", TRUE);
		### Drop table jenis_cetakan ##
		$this->dbforge->drop_table("jenis_cetakan", TRUE);
		### Drop table jenis_kas ##
		$this->dbforge->drop_table("jenis_kas", TRUE);
		### Drop table jenis_lembaga ##
		$this->dbforge->drop_table("jenis_lembaga", TRUE);
		### Drop table jenis_pengeluaran ##
		$this->dbforge->drop_table("jenis_pengeluaran", TRUE);
		### Drop table jurnal_transaksi ##
		$this->dbforge->drop_table("jurnal_transaksi", TRUE);
		### Drop table kas_masuk ##
		$this->dbforge->drop_table("kas_masuk", TRUE);
		### Drop table kasbon ##
		$this->dbforge->drop_table("kasbon", TRUE);
		### Drop table konsumen ##
		$this->dbforge->drop_table("konsumen", TRUE);
		### Drop table laporan_penerimaan ##
		$this->dbforge->drop_table("laporan_penerimaan", TRUE);
		### Drop table laporan_stok ##
		$this->dbforge->drop_table("laporan_stok", TRUE);
		### Drop table member ##
		$this->dbforge->drop_table("member", TRUE);
		### Drop table menuadmin ##
		$this->dbforge->drop_table("menuadmin", TRUE);
		### Drop table mesin ##
		$this->dbforge->drop_table("mesin", TRUE);
		### Drop table migrations ##
		$this->dbforge->drop_table("migrations", TRUE);
		### Drop table nama_barang ##
		$this->dbforge->drop_table("nama_barang", TRUE);
		### Drop table pembelian ##
		$this->dbforge->drop_table("pembelian", TRUE);
		### Drop table pembelian_detail ##
		$this->dbforge->drop_table("pembelian_detail", TRUE);
		### Drop table pengaturan_kertas ##
		$this->dbforge->drop_table("pengaturan_kertas", TRUE);
		### Drop table pengaturan_presensi ##
		$this->dbforge->drop_table("pengaturan_presensi", TRUE);
		### Drop table pengeluaran ##
		$this->dbforge->drop_table("pengeluaran", TRUE);
		### Drop table pengeluaran_detail ##
		$this->dbforge->drop_table("pengeluaran_detail", TRUE);
		### Drop table printer ##
		$this->dbforge->drop_table("printer", TRUE);
		### Drop table produk ##
		$this->dbforge->drop_table("produk", TRUE);
		### Drop table range_harga ##
		$this->dbforge->drop_table("range_harga", TRUE);
		### Drop table referal ##
		$this->dbforge->drop_table("referal", TRUE);
		### Drop table rekening_bank ##
		$this->dbforge->drop_table("rekening_bank", TRUE);
		### Drop table report ##
		$this->dbforge->drop_table("report", TRUE);
		### Drop table report_pesan ##
		$this->dbforge->drop_table("report_pesan", TRUE);
		### Drop table satu_harga ##
		$this->dbforge->drop_table("satu_harga", TRUE);
		### Drop table satuan ##
		$this->dbforge->drop_table("satuan", TRUE);
		### Drop table shared_folder ##
		$this->dbforge->drop_table("shared_folder", TRUE);
		### Drop table slip_gaji ##
		$this->dbforge->drop_table("slip_gaji", TRUE);
		### Drop table stok_keluar ##
		$this->dbforge->drop_table("stok_keluar", TRUE);
		### Drop table stok_keluar_gudang ##
		$this->dbforge->drop_table("stok_keluar_gudang", TRUE);
		### Drop table stok_masuk ##
		$this->dbforge->drop_table("stok_masuk", TRUE);
		### Drop table stok_masuk_gudang ##
		$this->dbforge->drop_table("stok_masuk_gudang", TRUE);
		### Drop table supplier ##
		$this->dbforge->drop_table("supplier", TRUE);
		### Drop table surat_jalan ##
		$this->dbforge->drop_table("surat_jalan", TRUE);
		### Drop table tb_users ##
		$this->dbforge->drop_table("tb_users", TRUE);
		### Drop table template_pesan ##
		$this->dbforge->drop_table("template_pesan", TRUE);
		### Drop table template_promo ##
		$this->dbforge->drop_table("template_promo", TRUE);
		### Drop table themes ##
		$this->dbforge->drop_table("themes", TRUE);
		### Drop table type_akses ##
		$this->dbforge->drop_table("type_akses", TRUE);
		### Drop table uang_makan ##
		$this->dbforge->drop_table("uang_makan", TRUE);
		### Drop table uang_transport ##
		$this->dbforge->drop_table("uang_transport", TRUE);
		### Drop table user_agent ##
		$this->dbforge->drop_table("user_agent", TRUE);

	}
}