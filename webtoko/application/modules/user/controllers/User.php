<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('M_user');
		$ses = $this->session->userdata('koneksi');
	      if (!$ses) {
	         redirect(base_url().'login');
     }
	}

	public function index()
	{
		$data['user'] = $this->M_user->get();
		$data['ses'] = $this->session->userdata('koneksi');
		$this->load->view('header',$data);
		$this->load->view('V_user',$data);
		$this->load->view('footer');
	}

	public function jsonjoin(){

		$data['user'] = $this->M_user->get();
		echo json_encode($data);
	}

		public function add()
	{
		$submit = $this->input->post('submit');
		if($submit){
			$id = $this->input->post('id');
			$username = $this->input->post('username');
			$nama_user = $this->input->post('nama_user');
			$password = md5($this->input->post('password'));
			$role = $this->input->post('role');

				$user1 = array(
						// 'kode_barang' => $kode_barang,
						// 'nama_barang' => $nama_barang,
						// 'jenis_barang' => $pilihjenis,
						// 'satuan' => $satuan,
						'id' => $id,
						'username' => $username,
						'nama_user' => $nama_user,
						'password' => $password,
						'role' => $role,
					);
				$this->M_user->add($user1);
				redirect(base_url('user'));

			}
		$data['ses'] = $this->session->userdata('koneksi');
		$this->load->view('header',$data);
		$this->load->view('V_user_add',$data);
		$this->load->view('footer');

	}

	public function edit($id=null)
	{
		$submit = $this->input->post('submit');
		if($submit){
			$id = $this->input->post('id');
			$username = $this->input->post('username');
			$nama_user = $this->input->post('nama_user');
			$password = $this->input->post('password');
			$role = $this->input->post('role');
			if(!empty($password))
			{
				$user1 = array(
						// 'kode_barang' => $kode_barang,
						// 'nama_barang' => $nama_barang,
						// 'jenis_barang' => $pilihjenis,
						// 'satuan' => $satuan,
						'username' => $username,
						'nama_user' => $nama_user,
						'password' => md5($password),
						'role' => $role,
					);
				
			}
			else
			{
				$user1 = array(
						// 'kode_barang' => $kode_barang,
						// 'nama_barang' => $nama_barang,
						// 'jenis_barang' => $pilihjenis,
						// 'satuan' => $satuan,
						'username' => $username,
						'nama_user' => $nama_user,
						'role' => $role,
					);
			}
				
				$this->M_user->edit($user1,$id);
				redirect(base_url('user'));

			}

			else{
			$data['user'] = $this->M_user->getid($id);
		$data['ses'] = $this->session->userdata('koneksi');
		$this->load->view('header',$data);
		$this->load->view('V_user_edit',$data);
		$this->load->view('footer');
			}
		}


	public function delete($id = null)
	{

   		$this->M_user->delete($id);


 	  redirect($_SERVER['HTTP_REFERER']);  
	}
	

}
