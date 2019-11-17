<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekening extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('M_rekening');
		$ses = $this->session->userdata('koneksi');
	      if (!$ses) {
	         redirect(base_url().'login');
     }
	}

	public function index()
	{
		$data['rekening_tujuan'] = $this->M_rekening->get();
		$data['ses'] = $this->session->userdata('koneksi');
		$this->load->view('header',$data);
		$this->load->view('V_rekening',$data);
		$this->load->view('footer');
	}

	public function jsonjoin(){

		$data['rekening_tujuan'] = $this->M_rekening->get();
		echo json_encode($data);
	}

		public function add()
	{
		$submit = $this->input->post('submit');
		if($submit){
			$id_bank = $this->input->post('id_bank');
			$nama_bank = $this->input->post('nama_bank');
			$nomor_rekening = $this->input->post('nomor_rekening');
			$nama_pemilik = $this->input->post('nama_pemilik');

				$rekening1 = array(
						// 'kode_barang' => $kode_barang,
						// 'nama_barang' => $nama_barang,
						// 'jenis_barang' => $pilihjenis,
						// 'satuan' => $satuan,
						'id_bank' => $id_bank,
						'nama_bank' => $nama_bank,
						'nomor_rekening' => $nomor_rekening,
						'nama_pemilik' => $nama_pemilik,
					);
				$this->M_rekening->add($rekening1);
				redirect(base_url('rekening'));

			}
		$data['ses'] = $this->session->userdata('koneksi');
		$this->load->view('header',$data);
		$this->load->view('V_rekening_add',$data);
		$this->load->view('footer');

	}

	public function edit($id_bank=null)
	{
		$submit = $this->input->post('submit');
		if($submit){
			$id_bank = $this->input->post('id_bank');
			$nama_bank = $this->input->post('nama_bank');
			$nomor_rekening = $this->input->post('nomor_rekening');
			$nama_pemilik = $this->input->post('nama_pemilik');

				$rekening1 = array(
						// 'kode_barang' => $kode_barang,
						// 'nama_barang' => $nama_barang,
						// 'jenis_barang' => $pilihjenis,
						// 'satuan' => $satuan,
						'id_bank' => $id_bank,
						'nama_bank' => $nama_bank,
						'nomor_rekening' => $nomor_rekening,
						'nama_pemilik' => $nama_pemilik,
					);
				$this->M_rekening->edit($rekening1,$id_bank);
				redirect(base_url('rekening'));

			}

			else{
			$data['rekening_tujuan'] = $this->M_rekening->getid($id_bank);
		$data['ses'] = $this->session->userdata('koneksi');
		$this->load->view('header',$data);
		$this->load->view('V_rekening_edit',$data);
		$this->load->view('footer');
			}
		}


	public function delete($id_bank = null)
	{

   		$this->M_rekening->delete($id_bank);


 	  redirect($_SERVER['HTTP_REFERER']);  
	}
	

}
