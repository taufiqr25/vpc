<?php
define('MENU_AKTIF', 'barang');
	Class Barang extends MY_Controller{
		function __construct(){
			parent::__construct();
			$this->_isLogin();
			$this->_createUserdata();
		}

		function index(){
			$data['active'] = 'dashboard';
			$data['title'] = 'Daftar Barang';
			$data['data_barang'] = $this->crud->read('tb_penjualan');
			/*$data['mhs']['nama'] = 'Taufik';
			$data['mhs']['nim'] = '42514022';*/

			//print_r($data);
			/*$data = array(
				'active' => 'dashboard',
				'title' => 'Dashboard'
			);*/
			$this->_show('V_barang', $data);
		}

		function get_data(){
			$data = $this->crud->read('tb_penjualan')->result();
			echo json_encode($data);
		}

		function hapus(){
			$id = $this->input->post('id');
			$hapus = $this->crud->delete('tb_penjualan', ['id' => $id]);
		}
	}