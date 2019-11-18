<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ukuran extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('M_ukuran');
		$ses = $this->session->userdata('koneksi');
	      if (!$ses) {
	         redirect(base_url().'login');
     }
	}

	public function index()
	{
		$data['ukuran'] = $this->M_ukuran->get();
		$data['ses'] = $this->session->userdata('koneksi');
		$this->load->view('header',$data);
		$this->load->view('V_ukuran',$data);
		$this->load->view('footer');
	}

	public function jsonjoin(){

		$data['ukuran'] = $this->M_ukuran->get();
		echo json_encode($data);
	}

		public function uji()
	{

		$data['ukuran'] = $this->M_ukuran->get('satuan');
		print_r($data);


	}

		public function add()
	{
		$submit = $this->input->post('submit');
		if($submit){
			$id_ukuran = $this->input->post('id_ukuran');
			$ukuran = $this->input->post('ukuran');
			$id_satuan = $this->input->post('id_satuan');

				$ukuran1 = array(
						// 'kode_barang' => $kode_barang,
						// 'nama_barang' => $nama_barang,
						// 'jenis_barang' => $pilihjenis,
						// 'satuan' => $satuan,
						'id_ukuran' => $id_ukuran,
						'ukuran' => $ukuran,
						'id_satuan' => $id_satuan,
					);
				$this->M_ukuran->add($ukuran1);
				redirect(base_url('ukuran'));

			}
		$data['ses'] = $this->session->userdata('koneksi');
		$data['satuan'] = $this->M_ukuran->view_satuan();
		$this->load->view('header',$data);
		$this->load->view('V_ukuran_add',$data);
		$this->load->view('footer');

	}

	public function edit($id_ukuran=null)
	{
		$submit = $this->input->post('submit');
		if($submit){
			$id_ukuran = $this->input->post('id_ukuran');
			$ukuran = $this->input->post('ukuran');
			$id_satuan = $this->input->post('id_satuan');

				$ukuran1 = array(
						// 'kode_barang' => $kode_barang,
						// 'nama_barang' => $nama_barang,
						// 'jenis_barang' => $pilihjenis,
						// 'satuan' => $satuan,
						'id_ukuran' => $id_ukuran,
						'ukuran' => $ukuran,
						'id_satuan' => $id_satuan,
					);
				$this->M_ukuran->edit($ukuran1,$id_ukuran);
				redirect(base_url('ukuran'));

			}

			else{
			$data['ukuran'] = $this->M_ukuran->getid($id_ukuran);
		$data['ses'] = $this->session->userdata('koneksi');
		$data['satuan'] = $this->M_ukuran->view_satuan();
		$this->load->view('header',$data);
		$this->load->view('V_ukuran_edit',$data);
		$this->load->view('footer');
			}
		}


	public function delete($id_ukuran = null)
	{

   		$this->M_ukuran->delete($id_ukuran);


 	  redirect($_SERVER['HTTP_REFERER']);  
	}
	

}
