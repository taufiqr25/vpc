<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Satuan extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('M_satuan');
		$ses = $this->session->userdata('koneksi');
	      if (!$ses) {
	         redirect(base_url().'login');
     }
	}

	public function index()
	{
		$data['satuan'] = $this->M_satuan->get();
		$data['ses'] = $this->session->userdata('koneksi');
		$this->load->view('header',$data);
		$this->load->view('V_satuan',$data);
		$this->load->view('footer');
	}

	public function jsonjoin(){

		$data['satuan'] = $this->M_satuan->get();
		echo json_encode($data);
	}

		public function add()
	{
		$submit = $this->input->post('submit');
		if($submit){
			$id_satuan = $this->input->post('id_satuan');
			$satuan = $this->input->post('satuan');

				$satuan1 = array(
						// 'kode_barang' => $kode_barang,
						// 'nama_barang' => $nama_barang,
						// 'jenis_barang' => $pilihjenis,
						// 'satuan' => $satuan,
						'id_satuan' => $id_satuan,
						'satuan' => $satuan,
					);
				$this->M_satuan->add($satuan1);
				redirect(base_url('satuan'));

			}
		$data['ses'] = $this->session->userdata('koneksi');
		$this->load->view('header',$data);
		$this->load->view('V_satuan_add',$data);
		$this->load->view('footer');

	}

	public function edit($id_satuan=null)
	{
		$submit = $this->input->post('submit');
		if($submit){
			$id_satuan = $this->input->post('id_satuan');
			$satuan = $this->input->post('satuan');

				$satuan1 = array(
						// 'kode_barang' => $kode_barang,
						// 'nama_barang' => $nama_barang,
						// 'jenis_barang' => $pilihjenis,
						// 'satuan' => $satuan,
						'id_satuan' => $id_satuan,
						'satuan' => $satuan,
					);
				$this->M_satuan->edit($satuan1,$id_satuan);
				redirect(base_url('satuan'));

			}

			else{
		$data['satuan'] = $this->M_satuan->getid($id_satuan);
		$data['ses'] = $this->session->userdata('koneksi');
		$this->load->view('header',$data);
		$this->load->view('V_satuan_edit',$data);
		$this->load->view('footer');
			}
	}


	public function delete($id_satuan = null)
	{

   		$query = $this->M_satuan->delete($id_satuan);
   		redirect($_SERVER['HTTP_REFERER']);  
	}
	

}
