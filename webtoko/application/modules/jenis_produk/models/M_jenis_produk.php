<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_jenis_produk extends CI_Model {
	
	function get()
	{
		$query = $this->db->get('produk');

		return $query->result();
	}
	
	function add($data)
	{
		$query = $this->db->insert('produk',$data);
	}

	function cekgambar($id_produk)
	{
		$this->db->where("id_produk",$id_produk);
		$query = $this->db->get('produk');

		return $query->result();
	}


	function getid($id_produk)
	{
		$this->db->where("id_produk",$id_produk);
		$query = $this->db->get('produk');

		return $query->result();
	}

	function edit($data,$id_produk)
	{
		$this->db->where("id_produk",$id_produk);
		$this->db->update('produk',$data);

	}

	function delete($id_produk)
	{
		$this->db->where('id_produk', $id_produk);
  		 $this->db->delete('produk'); 
	}
}
