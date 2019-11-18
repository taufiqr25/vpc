<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_home extends CI_Model {
	
	/*
	public function get()
	{
		$id_kategori_main = '1';
		$query = $this->db->get('nama_tabel');
		return $query->result();
	}
	*/
	function minimalbarang(){
		$query =$this->db->query("SELECT nama_sub_produk, jumlah_sub_produk FROM `sub_produk` order by jumlah_sub_produk asc limit 1");
		return $query->result();

	}

	function orderhariini(){
		$tanggal = date('Y-m-d');
		$this->db->where('date(a.tanggal_orderan)="'.$tanggal.'"');
		$this->db->select('a.tanggal_orderan,sum(b.total) as total')
				->from("order a")
				->join("detail_order b","a.id_order = b.id_order");
		$query = $this->db->get();
		return $query->result();

	}
	
}
