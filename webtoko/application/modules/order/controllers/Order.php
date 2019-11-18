<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('M_order');
		$ses = $this->session->userdata('koneksi');
	      if (!$ses) {
	         redirect(base_url().'login');
     }
	}

	public function index()
	{
		$data['order'] = $this->M_order->get();
		$data['ses'] = $this->session->userdata('koneksi');
		$this->load->view('header',$data);
		$this->load->view('V_order',$data);
		$this->load->view('footer');
	}

	public function jsonjoin(){

		$data['order'] = $this->M_order->get();
		echo json_encode($data);
	}

		public function add()
	{
		$submit = $this->input->post('submit');
		if($submit){
			// $kode_barang=$this->input->post('kode_barang');
			// $nama_barang = $this->input->post('nama_barang');
			// $pilihjenis = $this->input->post('pilihjenis');
			// $satuan = $this->input->post('satuan');
			$jumlah_beli = $this->input->post('jumlah_beli');
			$harga_beli = $this->input->post('harga_beli');
			$total_harga = $this->input->post('total_harga');
			$idbarang = $this->input->post('idbarang');
			

				$pembelian1 = array(
						// 'kode_barang' => $kode_barang,
						// 'nama_barang' => $nama_barang,
						// 'jenis_barang' => $pilihjenis,
						// 'satuan' => $satuan,
						'id_barang' => $idbarang,
						'jumlah' => $jumlah_beli,
						'harga' => $harga_beli,
						'tgl_update' => date("Y-m-d"),
					);
				$this->M_pembelian->add($pembelian1);
				redirect(base_url('pembelian'));

			}
		$data['barang'] = $this->M_pembelian->getbarang();
		$data['ses'] = $this->session->userdata('koneksi');
$this->load->view('header',$data);
		$this->load->view('V_pembelian_add',$data);
		$this->load->view('footer');

	}

	public function edit($id_order=null)
	{
		$submit = $this->input->post('submit');
		if($submit){
			$id_order = $this->input->post('id_order');
			$namakonsumen = $this->input->post('nama_konsumen');
			$alamat_konsumen = $this->input->post('alamat_konsumen');
			$provinsi = md5($this->input->post('provinsi'));
			$kabupaten = $this->input->post('kabupaten');
			$kuantitas = $this->input->post('kuantitas');
			$total = $this->input->post('total');
			$kartu_kredit = $this->input->post('kartu_kredit');
			$nomor_rekening_konsumen = $this->input->post('nomor_rekening_konsumen');
			$nomor_rekening = $this->input->post('nomor_rekening');
			$tanggal_orderan = $this->input->post('tanggal_orderan');
			$status = $this->input->post('status');

				$order1 = array(
						// 'kode_barang' => $kode_barang,
						// 'nama_barang' => $nama_barang,
						// 'jenis_barang' => $pilihjenis,
						// 'satuan' => $satuan,
						'id_order' => $id_order,
						'nama_konsumen' => $namakonsumen,
						'alamat_konsumen' => $alamat_konsumen,
						'provinsi' => $provinsi,
						'kabupaten' => $kabupaten,
						'kuantitas' => $kuantitas,
						'total' => $total,
						'kartu_kredit' => $kartu_kredit,
						'nomor_rekening_konsumen' => $nomor_rekening_konsumen,
						'nomor_rekening' => $nomor_rekening,
						'tanggal_orderan' => $tanggal_orderan,
						'status' => $status,

					);
				$this->M_order->edit($order1,$id_order);
				redirect(base_url('order'));

			}

			else{
			$data['order'] = $this->M_order->getid($id_order);
		$data['ses'] = $this->session->userdata('koneksi');
		$this->load->view('header',$data);
		$this->load->view('V_order_edit',$data);
		$this->load->view('footer');
			}
		}

	public function statusupdate($idorder){
			$rekening1 = array(
						'status' => 1
					);
				$ed = $this->M_order->edit($rekening1,$idorder);
				if($ed) redirect("order"); redirect("order");
	}


	public function delete($id_order = null)
	{

   		$this->M_order->delete($id_order);


 	  redirect($_SERVER['HTTP_REFERER']);  
	}

	public function edit1($id_order=null)
	{

		$submit = $this->input->post('submit');
		if($submit){
			$id_order = $this->input->post('id_order');
			$status_pemesanan = $this->input->post('status_pemesanan');
			$no_resi = $this->input->post('no_resi');
			

				$order1 = array(
						// 'kode_barang' => $kode_barang,
						// 'nama_barang' => $nama_barang,
						// 'jenis_barang' => $pilihjenis,
						// 'satuan' => $satuan,
						'id_order' => $id_order,
						'status_pemesanan' => $status_pemesanan,
						'no_resi' => $no_resi,
						
					);
				$this->M_order->edit1($order1,$id_order);
				redirect(base_url('order'));

			}

			else{

		$data['order'] = $this->M_order->getid2($id_order);
		$data['ses'] = $this->session->userdata('koneksi');
		$this->load->view('header',$data);
		$this->load->view('V_order_edit',$data);
		$this->load->view('footer');
			}
		
		
	}
	

}
