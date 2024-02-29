<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Login extends CI_Controller {
		function __construct(){
			parent::__construct();
			$this->load->helper('string');
			$this->title = info()['title']; 
		}
		function index(){
			$data['title'] = 'Administrator &rsaquo; Log In | '.$this->title;
			$data['description'] = 'Aplikasi POS Percetakan';
			$data['keywords'] = 'point of sale, pos percetakan, aplikasi percetakan';
			if (isset($_POST['submit'])){
				//cek ip
				$cek_info   = cek_info();
				 
				$email_user = $this->input->post('email_user');
				$password   = $this->input->post('pass_user');
				$cek        = $this->model_app->cek_user($email_user);
				$total      = $cek->num_rows();
				
				if ($total > 0){
					$sid_baru = session_id();
					$row = $cek->row_array();
					$hash = $row['password'];
					if (password_verify($password, $hash)) {
						$this->session->set_userdata(
						array('idu'=>$row['id_user'],
						'email_absen'=>$row['email'],
						'nama_absen'=>$row['nama_lengkap'],
						'level_absen'=>$row['level'],
						'id_session'=>$row['id_session']
						));
						$this->model_app->update('tb_users', array("sesi_login"=>$sid_baru),array('id_user'=>$this->session->idu));
						
						 
						redirect('absen/');
						
						}else{
						echo $this->session->set_flashdata('message', '<div class="alert alert-danger"><center>Username atau Password Salah!!</center></div>');
						$data['title'] = 'Username atau Password salah!';
						$this->load->view('element/login', $data);
					}
					}else{
					echo $this->session->set_flashdata('message', '<div class="alert alert-danger"><center>Username atau Password Salah!!</center></div>');
					$data['title'] = 'username salah atau akun anda sedang diblokir';
					$this->load->view('element/login_absen', $data);
				}
				}else{
				if ($this->session->level_absen!=''){
					redirect('absen/');
					}else{
					$this->load->view('element/login_absen', $data);
				}
			}
		}
		public function logout(){
			$this->session->sess_destroy();
			redirect('absen');
		}
		public function cek_login(){
			$ci = & get_instance();
			$ip = gethostbyname(trim(exec("hostname")));
			$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
			$session = $ci->session->userdata('idu');
			$ids = $ci->session->userdata('ids');
			$rses = $ci->db->query("SELECT sesi_login FROM tb_users where id_user='$session'")->row_array();
			if ($rses['sesi_login'] != $ids) {
				session_destroy();
				echo 'logout';
			}
			if ($this->session->level_absen==''){
				echo 'logout';
				// exit;
			} 
		}
	}
?>