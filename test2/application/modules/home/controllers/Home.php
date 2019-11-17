<?php
define('MENU_AKTIF', 'home');
	Class Home extends MY_Controller{
		function __construct(){
			parent::__construct();
			$this->_isLogin();
			$this->_createUserdata();
		}

		function index(){
			$data['active'] = 'dashboard';
			$data['title'] = 'Dashboard';
			$data['jml_user'] = $this->crud->read('tb_users')->num_rows();
			$data['jml_barang'] = $this->crud->read('tb_penjualan')->num_rows();
			$data['jml_order'] = $this->crud->read('tb_order')->num_rows();
			/*$data['mhs']['nama'] = 'Taufik';
			$data['mhs']['nim'] = '42514022';*/

			//print_r($data);
			/*$data = array(
				'active' => 'dashboard',
				'title' => 'Dashboard'
			);*/
			$this->_show('V_home', $data);
		}
	}