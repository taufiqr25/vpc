<?php
	Class Login extends MY_Controller{
		function __construct(){
			parent::__construct();
			$this->_isLogin(false);
		}

		function index(){
			$submit = $this->input->post('submit');
			if($submit){
				$username = $this->input->post('email');
				$pwd = md5($this->input->post('password'));

				$cek = $this->crud->read('tb_users', "email='$username' AND password='$pwd'");
				if($cek->num_rows() > 0){
					//berhasil login
					$userdata = $cek->result();
					//print_r($userdata);
					$this->session->set_userdata(SESSION_NAME, $userdata[0]->id);

					redirect(base_url('home'));
				}else{
					//gagal login
					$this->session->set_flashdata('alert', 'Username/Password salah!');
					// redirect(base_url('login'));
				}

			}else $this->load->view('V_login');
		}
	}