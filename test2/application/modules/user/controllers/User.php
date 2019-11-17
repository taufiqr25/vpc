<?php
define('MENU_AKTIF', 'user');
	Class User extends MY_Controller{
		function __construct(){
			parent::__construct();
			$this->_isLogin();
			$this->_createUserdata();
		}

		function index(){
			$data['active'] = 'dashboard';
			$data['title'] = 'Daftar User';
			$data['data_user'] = $this->crud->read('tb_users');
			/*$data['mhs']['nama'] = 'Taufik';
			$data['mhs']['nim'] = '42514022';*/

			//print_r($data);
			/*$data = array(
				'active' => 'dashboard',
				'title' => 'Dashboard'
			);*/
			$this->_show('V_user', $data);
		}

		function get_data(){
			$data = $this->crud->read('tb_users')->result();
			echo json_encode($data);
		}

		function hapus(){
			$id = $this->input->post('id');
			$hapus = $this->crud->delete('tb_users', ['id' => $id]);
		}
	}