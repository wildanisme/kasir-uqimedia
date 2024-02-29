<?php 
	defined("BASEPATH") or exit();
	class Model_gaji extends CI_model{
		function cekgajipokok($id){
			
			$this->db->select('`gaji`.`ID`,
			`gaji`.`id_user`,
			`gaji`.`gaji_pokok`,
			`gaji`.`tun_jab`,
			`gaji`.`transport`,
			`gaji`.`makan`,
			`gaji`.`asuransi`,
			`gaji`.`jam_kerja`,
			`gaji`.`istirahat`,
			`tb_users`.`nama_lengkap`');
			$this->db->from('tb_users');
			$this->db->join('gaji', '`tb_users`.`id_user` = `gaji`.`id_user`');
			$this->db->where('`gaji`.`id_user`',$id);
			return $this->db->get()->row_array();
		}
		public function getGaji($id){
			return $this->db->select('`gaji`.`ID`,
			`gaji`.`id_user`,
			`gaji`.`gaji_pokok`,
			`gaji`.`tun_jab`,
			`gaji`.`transport`,
			`gaji`.`makan`,
			`gaji`.`asuransi`,
			`gaji`.`jam_kerja`,
			`gaji`.`istirahat`,
			`tb_users`.`nama_lengkap`')
            ->from('tb_users')
            ->where('`gaji`.`id_user`',$id)
            ->join('gaji','`tb_users`.`id_user` = `gaji`.`id_user`')
            ->get();
		}
		function cekbonus($id,$dari,$sampai){
			
			$this->db->select('id_user,bonus,keterangan');
			$this->db->from('bonus');
			$this->db->where('id_user',$id);
			$this->db->where('tgl` BETWEEN "'. date('Y-m-d', strtotime($dari)). '" and "'. date('Y-m-d', strtotime($sampai)).'"');
			return $this->db->get();
		}
		
		function cek_uang_makan($id,$dari,$sampai){
			
			$this->db->select('id_user,jumlah');
			$this->db->from('uang_makan');
			$this->db->where('id_user',$id);
			$this->db->where('tanggal` BETWEEN "'. date('Y-m-d', strtotime($dari)). '" and "'. date('Y-m-d', strtotime($sampai)).'"');
			return $this->db->get();
		}
		function cek_uang_transport($id,$dari,$sampai){
			
			$this->db->select('id_user,jumlah');
			$this->db->from('uang_transport');
			$this->db->where('id_user',$id);
			$this->db->where('tanggal` BETWEEN "'. date('Y-m-d', strtotime($dari)). '" and "'. date('Y-m-d', strtotime($sampai)).'"');
			return $this->db->get();
		}
		
		function cekcuti($id,$dari,$sampai){
			$this->db->select('*');
			$this->db->from('izin');
			$this->db->where('id_user',$id);
			$this->db->where('tgl` BETWEEN "'. date('Y-m-d', strtotime($dari)). '" and "'. date('Y-m-d', strtotime($sampai)).'"');
			return $this->db->get();
		}
		
		function countcuti($id,$dari,$sampai){
			$this->db->select('count(*) as total');
			$this->db->from('izin');
			$this->db->where('id_user',$id);
			$this->db->where('tgl` BETWEEN "'. date('Y-m-d', strtotime($dari)). '" and "'. date('Y-m-d', strtotime($sampai)).'"');
			return $this->db->get()->row()->total;
		}
		function cekharilibur($dari,$sampai){
			
			$this->db->select('*');
			$this->db->from('hari_libur');
			$this->db->where('tgl` BETWEEN "'. date('Y-m-d', strtotime($dari)). '" and "'. date('Y-m-d', strtotime($sampai)).'"');
			return $this->db->get();
		}
		
		function kehadiran($id,$dari,$sampai){
			
			$this->db->select('*');
			$this->db->from('absen');
			$this->db->where('tgl` BETWEEN "'. date('Y-m-d', strtotime($dari)). '" and "'. date('Y-m-d', strtotime($sampai)).'"');
			$this->db->where('id_user',$id);
			$this->db->order_by('tgl','ASC');
			return $this->db->get();
		}
		
		function slip_gaji($id,$bulan,$tahun){
			
			$this->db->select('*');
			$this->db->from('slip_gaji');
			$this->db->where('id_user',$id);
			$this->db->where('bulan_gaji',$bulan);
			$this->db->where('tahun_gaji',$tahun);
			return $this->db->get();
		}
		
		function cek_slip_gaji($id,$bulan,$tahun){
			
			$this->db->select('`slip_gaji`.`id_slip`,
			`slip_gaji`.`id_user`,
			`slip_gaji`.`tgl_rekap`,
			`slip_gaji`.`bulan_gaji`,
			`slip_gaji`.`tahun_gaji`,
			`slip_gaji`.`gaji_pokok`,
			`slip_gaji`.`tun_jab`,
			`slip_gaji`.`transport`,
			`slip_gaji`.`makan`,
			`slip_gaji`.`asuransi`,
			`slip_gaji`.`jam_kerja`,
			`slip_gaji`.`istirahat`,
			`slip_gaji`.`jml_kerja`,
			`slip_gaji`.`jml_cuti`,
			`slip_gaji`.`jml_libur`,
			`slip_gaji`.`gaji_kotor`,
			`slip_gaji`.`lembur`,
			`slip_gaji`.`tot_makan`,
			`slip_gaji`.`tot_transport`,
			`slip_gaji`.`tot_tun_cuti`,
			`slip_gaji`.`tot_tun_libur`,
			`slip_gaji`.`tot_tun_jab`,
			`slip_gaji`.`tot_bonus`,
			`slip_gaji`.`pot_absen`,
			`slip_gaji`.`pot_asuransi`,
			`slip_gaji`.`pot_kasbon`,
			`slip_gaji`.`uang_makan_diambil`,
			`slip_gaji`.`uang_trans_diambil`,
			`tb_users`.`nama_lengkap`');
			$this->db->from('slip_gaji');
			$this->db->join('tb_users','`slip_gaji`.`id_user` = `tb_users`.`id_user`');
			$this->db->where('slip_gaji.id_user',$id);
			$this->db->where('bulan_gaji',$bulan);
			$this->db->where('tahun_gaji',$tahun);
			return $this->db->get();
		}
		
		function sum_kasbon($id){
			
			$this->db->select('SUM(`kasbon`.`pinjam`) AS `debet`, SUM(`kasbon`.`bayar`) AS `kredit`');
			$this->db->from('kasbon');
			$this->db->where('id_pegawai',$id);
			return $this->db->get();
		}
		
		function sum_where_kasbon($id,$dari,$sampai){
			
			$this->db->select('id_pegawai, SUM(`kasbon`.`pinjam`) AS `debet`, SUM(`kasbon`.`bayar`) AS `kredit`');
			$this->db->from('kasbon');
			$this->db->where('tgl_kasbon` BETWEEN "'. date('Y-m-d', strtotime($dari)). '" and "'. date('Y-m-d', strtotime($sampai)).'"');
			$this->db->where('id_pegawai',$id);
			return $this->db->get();
		}
		
		function kasbon($id,$dari,$sampai){
			$this->db->select('*');
			$this->db->from('kasbon');
			$this->db->where('tgl_kasbon` BETWEEN "'. date('Y-m-d', strtotime($dari)). '" and "'. date('Y-m-d', strtotime($sampai)).'"');
			$this->db->where('id_pegawai',$id);
			return $this->db->get();
		}
		
		function cek_bayar_kasbon($id,$dari,$sampai){
			$this->db->select('bayar, SUM(`kasbon`.`bayar`) AS `kredit`');
			$this->db->from('kasbon');
			$this->db->where('tgl_kasbon` BETWEEN "'. date('Y-m-d', strtotime($dari)). '" and "'. date('Y-m-d', strtotime($sampai)).'"');
			$this->db->where('id_pegawai',$id);
			$this->db->where('jenis_kasbon','Bayar');
			$this->db->where('status_bayar',1);
			$this->db->group_by('bayar','ASC');
			return $this->db->get();
		}
		function update_kasbon($id,$dari,$sampai,$kredit){
			$this->db->set('bayar', $kredit, FALSE);
			$this->db->where('tgl_kasbon` BETWEEN "'. date('Y-m-d', strtotime($dari)). '" and "'. date('Y-m-d', strtotime($sampai)).'"');
			$this->db->where('id_pegawai',$id);
			$this->db->where('bayar >',0);
			return $this->db->update('kasbon');
		}
	}							