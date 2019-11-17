<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_produk extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('M_jenis_produk');
		$ses = $this->session->userdata('koneksi');
	      if (!$ses) {
	         redirect(base_url().'login');
     }
	}

	public function index()
	{
		$data['produk'] = $this->M_jenis_produk->get();
		$data['ses'] = $this->session->userdata('koneksi');
		$this->load->view('header',$data);
		$this->load->view('V_jenis_produk',$data);
		$this->load->view('footer');
	}

	public function jsonjoin(){

		$data['produk'] = $this->M_jenis_produk->get();
		echo json_encode($data);
	}

		public function add()
	{
		$submit = $this->input->post('submit');
		if($submit){
			$id_produk = $this->input->post('id_produk');
			$nama_produk = $this->input->post('nama_produk');
			$kategori_produk = $this->input->post('kategori_produk');

				$produk1 = array(
						'id_produk' => $id_produk,
						'nama_produk' => $nama_produk,
						'kategori_produk' => $kategori_produk,
					);
				$this->M_jenis_produk->add($produk1);
				redirect(base_url('jenis_produk'));

			}
		$data['ses'] = $this->session->userdata('koneksi');
		$this->load->view('header',$data);
		$this->load->view('V_jenis_produk_add',$data);
		$this->load->view('footer');

	}

	public function edit($id_produk=null)
	{
		$submit = $this->input->post('submit');
		if($submit){
			$id_produk = $this->input->post('id_produk');
			$nama_produk = $this->input->post('nama_produk');
			$kategori_produk = $this->input->post('kategori_produk');

					$produk1 = array(
						'id_produk' => $id_produk,
						'nama_produk' => $nama_produk,
						'kategori_produk' => $kategori_produk,
					);

				$this->M_jenis_produk->edit($produk1,$id_produk);
				redirect(base_url('jenis_produk'));

			}

			else{
			$data['produk'] = $this->M_jenis_produk->getid($id_produk);
		$data['ses'] = $this->session->userdata('koneksi');
		$this->load->view('header',$data);
		$this->load->view('V_jenis_produk_edit',$data);
		$this->load->view('footer');
			}
		}


	public function delete($id = null)
	{

   		$this->M_jenis_produk->delete($id);


 	  redirect($_SERVER['HTTP_REFERER']);  
	}
	

}
