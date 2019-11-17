<?php
define('MENU_AKTIF', 'order');
	Class Order extends MY_Controller{
		function __construct(){
			parent::__construct();
			$this->_isLogin();
			$this->_createUserdata();
		}

		function index(){
			$data['active'] = 'dashboard';
			$data['title'] = 'Daftar Order';
			$data['data_order'] = $this->crud->query('SELECT o.id,u.nama,p.nama_barang,o.jumlah,o.waktu,o.status FROM `tb_order` as o INNER JOIN tb_penjualan as p ON o.id_barang=p.id INNER JOIN tb_users as u ON o.id_user=u.id');
			/*$data['mhs']['nama'] = 'Taufik';
			$data['mhs']['nim'] = '42514022';*/

			//print_r($data);
			/*$data = array(
				'active' => 'dashboard',
				'title' => 'Dashboard'
			);*/
			$this->_show('V_order', $data);
		}

		function get_data(){
			$data = $this->crud->query('SELECT o.id,u.nama,p.nama_barang,o.jumlah,o.waktu,o.status FROM `tb_order` as o INNER JOIN tb_penjualan as p ON o.id_barang=p.id INNER JOIN tb_users as u ON o.id_user=u.id')->result();
			echo json_encode($data);
		}

		function hapus(){
			$id = $this->input->post('id');
			$hapus = $this->crud->delete('tb_order', ['id' => $id]);
		}
	}