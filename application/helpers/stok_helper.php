<?php
	
	if ( ! function_exists('stok_masuk_gudang'))
	{
		/**
			* Code pengaturan
			*
			@param $val string
			@return string
		*/
		function stok_masuk_gudang($id)
		{
			$ci = & get_instance();
			$ci->db->select_sum('jumlah');
			$ci->db->from('stok_masuk_gudang');
			$ci->db->where('id',$id);
			$query = $ci->db->get(); 
			$result = ($query->num_rows() > 0)?$query->row()->jumlah:0; 
			return $result; 
		}
	}
	
	if ( ! function_exists('stok_keluar_gudang'))
	{
		/**
			* Code pengaturan
			*
			@param $val string
			@return string
		*/
		function stok_keluar_gudang($val)
		{
			$ci = & get_instance();
			$ci->db->select_sum('jumlah');
			$ci->db->from('stok_keluar_gudang');
			$ci->db->where('id',$id);
			$query = $ci->db->get(); 
			$result = ($query->num_rows() > 0)?$query->row()->jumlah:0; 
			return $result; 
		}
	}
