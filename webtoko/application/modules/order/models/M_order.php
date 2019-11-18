<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_order extends CI_Model {
	
	function get()
	{
		$query = $this->db->query('
			SELECT 
  a.id_order, 
    a.id_sub_produk,
    a.id_ukuran, 
    a.id_konsumen, 
    a.id_bank, 
    a.tanggal_orderan, 
    a.status_pemesanan, 
    a.no_resi, 
    b.nama_produk,
      b.nama_sub_produk,
      b.kategori_produk,
    c.id_konsumen, 
    c.nama_konsumen, 
    c.alamat_konsumen, 
    c.provinsi, 
    c.kabupaten, 
    c.id_telegram, 
    c.no_hp,  
    d.kuantitas, 
    d.total, 
    e.status, 
    e.gambar_bukti, 
    f.id_bank, 
    f.nomor_rekening,
    b.ukuran,
    b.satuan
FROM `order` a 
JOIN 
  (SELECT 
  a.id_produk,
    a.id_sub_produk, 
    a.nama_sub_produk, 
    a.deskripsi_sub_produk,  
    a.harga_sub_produk, 
    a.jumlah_sub_produk, 
    a.images,
    a.id_ukuran,
    a.ukuran,
    a.satuan, 
    b.nama_produk,
    b.kategori_produk
FROM (
    SELECT c.id_produk,
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
         (SELECT 
           g.id_ukuran,
            g.ukuran,
            h.satuan
         FROM 
            ukuran g 
         LEFT OUTER JOIN 
            satuan h 
         ON 
            g.id_satuan = 
            h.id_satuan) d 
        ON c.id_ukuran = d.id_ukuran) a
         LEFT OUTER JOIN 
         produk b 
         ON 
         a.id_produk = b.id_produk) b 
		ON 
		  a.id_sub_produk = b.id_sub_produk 
		JOIN 
		  konsumen c 
		ON 
		  a.id_konsumen = c.id_konsumen
		 JOIN 
		  detail_order d 
		ON 
		  a.id_order = d.id_order 
		 JOIN 
		  membayar e
		ON 
		  a.id_order = e.id_order 
		LEFT OUTER JOIN 
		  rekening_tujuan f 
		ON 
		  a.id_bank = f.id_bank
					');
		return $query->result();
	}
	function getbarang()
	{
		$query = $this->db->get('order');

		return $query->result();
	}

	function getid($id_order)
	{
		$this->db->where("a.id_order",$id_order)
				->select('a.id_order, a.id_produk, a.id_konsumen, a.id_bank, a.tanggal_orderan, a.status_pemesanan, a.no_resi, b.id_produk, b.nama_produk, c.id_konsumen, c.nama_konsumen, c.alamat_konsumen, c.provinsi, c.kabupaten, c.nomor_rekening_konsumen, c.id_telegram, c.no_hp, d.id_order, d.kuantitas, d.total, e.id_order,e.status,e.gambar_bukti,f.id_bank,f.nomor_rekening')
				->from("order a")
				->join("produk b","a.id_produk = b.id_produk")
				->join("konsumen c","a.id_konsumen = c.id_konsumen")
				->join("detail_order d","a.id_order = d.id_order")
				->join("membayar e","a.id_order = e.id_order")
				->join("rekening_tujuan f","a.id_bank = f.id_bank");
		$query = $this->db->get();
		return $query->result();
	}

	function edit($data,$id_order)
	{
		$this->db->where("id_order",$id_order);
		$stat = $this->db->update('membayar',$data);
		if($stat) return true; else return false;

	}

	function edit1($data,$id_order)
	{
		$this->db->where("id_order",$id_order);
		$this->db->update('order',$data);
	}

	function delete($id_order)
	{
		$this->db->where('id_order', $id_order);
  		 $this->db->delete('order'); 
	}

	function getid2($id_order)
	{
		$this->db->where("id_order",$id_order);
		$query = $this->db->get('order');

		return $query->result();
	}
}
