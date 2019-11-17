<?php
	Class MY_Controller extends CI_Controller{
		function __construct(){
			parent::__construct();
			define('SESSION_NAME', 'terserah');
		}

		function _isLogin($param=true){
			$sess = $this->session->userdata(SESSION_NAME);
			if($sess){
				if(!$param) redirect(base_url('home'));
			}else{
				if($param) redirect(base_url('login'));
			}
		}

		function _createUserdata(){
			$id = $this->session->userdata(SESSION_NAME);
			$userdata = $this->crud->read('tb_users', "id=$id")->result()[0];

			define("NAMA_USER", $userdata->nama);
			define("USERNAME_USER", $userdata->username);
			define("PASSWORD_USER", $userdata->password);
		}

		function _show($view, $data=null){
			$this->load->view('header', $data);
			$this->load->view($view);
			$this->load->view('footer');
		}
	}