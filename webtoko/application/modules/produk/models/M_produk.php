<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_produk extends CI_Model {
	
	function get()
	{
		$query=$this->db->query('
SELECT 
    a.id_sub_produk, 
    a.nama_sub_produk, 
    a.deskripsi_sub_produk, 
    a.harga_sub_produk, 
    a.jumlah_sub_produk, 
    a.images,
    a.id_ukuran,
    a.ukuran,
    a.satuan, 
    b.nama_produk
FROM (SELECT c.id_produk,
    c.id_sub_produk, 
    c.nama_sub_produk, 
    c.deskripsi_sub_produk, 
    c.harga_sub_produk, 
    c.jumlah_sub_produk, 
    c.images,
    d.id_ukuran,
    d.ukuran,
    d.satuan
    FROM sub_produk c LEFT OUTER JOIN 
         (SELECT g.id_ukuran,
         g.ukuran,
         h.satuan
         FROM ukuran g LEFT OUTER JOIN satuan h ON g.id_satuan = h.id_satuan) d ON c.id_ukuran = d.id_ukuran) a
         LEFT OUTER JOIN 
         produk b 
         ON 
         a.id_produk = b.id_produk');
		
		return $query->result();
	}
	
	function add($data)
	{
		$query = $this->db->insert('sub_produk',$data);
	}

	function cekgambar($id)
	{
		$this->db->where("id_produk",$id);
		$query = $this->db->get('produk');

		return $query->result();
	}


	function getid($id_produk)
	{
		$this->db->where("id_sub_produk",$id_produk);
		$query = $this->db->get('sub_produk');

		return $query->result();
	}

	function edit($data,$id_produk)
	{
		$this->db->where("id_sub_produk",$id_produk);
		$this->db->update('sub_produk',$data);

	}

	function delete($id_produk)
	{
		$this->db->where('id_sub_produk', $id_produk);
  		$this->db->delete('sub_produk'); 
	}

	function view_produk($id_produk=null) //
	{
		$query = $this->db->get('produk');

		return $query->result(); //Lempar result ke query
    }
    
    function get_data_ukuran($id_satuan)
	{
		$this->db->where("id_satuan",$id_satuan);
		$query = $this->db->get('ukuran');
		return $query->result();
    }
    
    function get_data_satuan()
	{
		// $this->db->where("id_satuan",$id_satuan);
		$query = $this->db->get('satuan');
		return $query->result();
	}
}
