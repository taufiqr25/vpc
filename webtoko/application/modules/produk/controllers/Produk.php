<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('M_produk');
		$ses = $this->session->userdata('koneksi');
	      if (!$ses) {
	         redirect(base_url().'login');
	     }
	}

	public function index()
	{
		$data['produk'] = $this->M_produk->get();
		$data['ses'] = $this->session->userdata('koneksi');
		$this->load->view('header',$data);
		$this->load->view('V_produk',$data);
		$this->load->view('footer');
	}

	public function add()
	{
		
		$submit = $this->input->post('submit');
		if($submit){
			$id_produk=$this->input->post('id_produk');
			$nama_sub_produk = $this->input->post('nama_sub_produk');
			$deskripsi_sub_produk = $this->input->post('deskripsi_sub_produk');
			$harga_sub_produk = $this->input->post('harga_sub_produk');
			$jumlah_sub_produk = $this->input->post('jumlah_sub_produk');
			$id_ukuran = $this->input->post('id_ukuran');
			$images = $_FILES["images"]["name"];
			$target_dir = "gambar/";
			$data['b'] = $_FILES["images"]["tmp_name"];
			$target_file = $target_dir. basename($_FILES["images"]["name"]);
			$data['d'] = $target_file;
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			// Check if image file is a actual image or fake image
			// Check if file already exists
			if (file_exists($target_file)) {
			    echo "Sorry, file already exists.";
			    $uploadOk = 0;
			}
			// Check file size
			if ($_FILES["images"]["size"] > 5000000000000) {
			    echo "Sorry, your file is too large.";
			    $uploadOk = 0;
			}
			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
			    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			    $uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
			    $data['a'] = "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
			} else {
			    if (move_uploaded_file($_FILES["images"]["tmp_name"], $target_file)) {
			         $data['a'] =  "The file ". basename( $_FILES["images"]["name"]). " has been uploaded.";
			    } else {
			         $data['a'] = "Sorry, there was an error uploading your file.";
			    }
			}

				$target_file2= base_url().$target_file."";


				$produk1 = array(
						'id_produk' => $id_produk,
						'nama_sub_produk' => $nama_sub_produk,
						'deskripsi_sub_produk' => $deskripsi_sub_produk,
						'harga_sub_produk' => $harga_sub_produk,
						'jumlah_sub_produk' => $jumlah_sub_produk,
						'id_ukuran' => $id_ukuran,
						'images' => $target_file2
						// 'tgl_barang' => date("Y-m-d")

					);
				$this->M_produk->add($produk1);
				redirect(base_url('produk'));

			}

		$data['ses'] = $this->session->userdata('koneksi');
		$data['produk'] = $this->M_produk->view_produk();
		$this->load->view('header',$data);
		$this->load->view('V_produk_add',$data);
		$this->load->view('footer');

	}
	public function uji()
	{

		$data['produk'] = $this->M_produk->get();
		print_r($data);


	}
	public function edit($id_produk=null)
	{
		$submit = $this->input->post('submit');
		if($submit){
			$id_produk=$this->input->post('id_produk');
			$id_sub_produk=$this->input->post('id_sub_produk');
			$nama_sub_produk = $this->input->post('nama_sub_produk');
			$deskripsi_sub_produk = $this->input->post('deskripsi_sub_produk');
			$harga_sub_produk = $this->input->post('harga_sub_produk');
			$jumlah_sub_produk = $this->input->post('jumlah_sub_produk');
			$id_ukuran = $this->input->post('id_ukuran');
			$images = $_FILES["images"]["name"];
			
			$target_dir = "gambar/";
			$target_file = $target_dir . basename($_FILES["images"]["name"]);
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			// Check if image file is a actual image or fake image
			// Check if file already exists
			// if (file_exists($target_file)) {
			//     echo "Sorry, file already exists.";
			//     $uploadOk = 0;
			// }
			// // Check file size
			// if ($_FILES["images"]["size"] > 500000) {
			//     echo "Sorry, your file is too large.";
			//     $uploadOk = 0;
			// }
			// // Allow certain file formats
			// if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			// && $imageFileType != "gif" ) {
			//     echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			//     $uploadOk = 0;
			// }
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
			    echo "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
			} else {
			    if (move_uploaded_file($_FILES["images"]["tmp_name"], $target_file)) {
			        echo "The file ". basename( $_FILES["images"]["name"]). " has been uploaded.";
			    } else {
			        echo "Sorry, there was an error uploading your file.";
			    }
			}

			$target_file2= base_url().$target_file."";
	
			if($images == '') {
				$produk1 = array(
						'id_produk' => $id_produk,
						'nama_sub_produk' => $nama_sub_produk,
						'deskripsi_sub_produk' => $deskripsi_sub_produk,
						'harga_sub_produk' => $harga_sub_produk,
						'jumlah_sub_produk' => $jumlah_sub_produk,
						'id_ukuran' => $id_ukuran,

						// 'tgl_barang' => date("Y-m-d")

					);
				// $sql = "INSERT INTO produk (`images`) VALUES (``)";
			}else {

				$produk1 = array(
						'id_produk' => $id_produk,
						'nama_sub_produk' => $nama_sub_produk,
						'deskripsi_sub_produk' => $deskripsi_sub_produk,
						'harga_sub_produk' => $harga_sub_produk,
						'jumlah_sub_produk' => $jumlah_sub_produk,
						'id_ukuran' => $id_ukuran,
						'images' => $target_file2
						// 'tgl_barang' => date("Y-m-d")

					);
				
			}
				$cekimg = $this->M_produk->cekgambar($id_produk);
				// // echo "<br>";
				// echo $cekimg[0]->images;
				if($cekimg[0]->images != null)
				{
					$this->M_produk->edit($produk1,$id_sub_produk);
				redirect(base_url('produk'));
				}else{
					unlink($target_dir.$cekimg[0]->images);
					$this->M_produk->edit($produk1,$id_sub_produk);
				redirect(base_url('produk'));
				}	
				
			}

			else{
			$data['produk'] = $this->M_produk->getid($id_produk);
			$data['view'] = $this->M_produk->view_produk();
		$data['ses'] = $this->session->userdata('koneksi');
		$this->load->view('header',$data);
		$this->load->view('V_produk_edit',$data);
		$this->load->view('footer');
			}
		}


	public function delete($id_produk = null)
	{
		$query = $this->M_produk->delete($id_produk);
	


 	  redirect($_SERVER['HTTP_REFERER']);  
	}


	public function get_data_ukuran()
	{
		$id_satuan = $this->input->post("id_satuan");
		$data_ukuran = $this->M_produk->get_data_ukuran($id_satuan);
		echo '<select class="form-control m-bot15" name="id_ukuran" >';
		foreach ($data_ukuran as $data_ukuran) {
			echo '<option value="'.$data_ukuran->id_ukuran.'">'.$data_ukuran->ukuran.'</option>';
		} 
		echo '</select>';
	}
	

}
