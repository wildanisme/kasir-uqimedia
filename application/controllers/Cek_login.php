<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
		
	/**
	 * Cek_login
	 */
	class Cek_login extends CI_Controller {
				
		/**
		 * 2023-07-23 01:09:18
		 * index
		 *
		 * @return void
		 */
		
		function index(){
			$data = ($this->session->level!='') ? ['status'=>true,'msg'=>'login ok'] : ['status'=>false,'msg'=>'re login'];
			
			$this->output
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
			->_display();
			exit;
		}
		
	}			

	 