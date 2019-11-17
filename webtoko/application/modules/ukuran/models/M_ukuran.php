<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_ukuran extends CI_Model {
	
	function get()
	{
		$this->db->select('a.id_ukuran, a.ukuran, a.id_satuan, b.id_satuan, b.satuan')
				->from("ukuran a")
				->join("satuan b","a.id_satuan = b.id_satuan","LEFT OUTER");
		$query = $this->db->get();
		return $query->result();
	}
	
	function add($data)
	{
		$query = $this->db->insert('ukuran',$data);
	}

	function getid($id_ukuran)
	{
		$this->db->where("id_ukuran",$id_ukuran);
		$query = $this->db->get('ukuran');

		return $query->result();
	}

	function edit($data,$id_ukuran)
	{
		$this->db->where("id_ukuran",$id_ukuran);
		$this->db->update('ukuran',$data);

	}

	function delete($id_ukuran)
	{
		$this->db->where('id_ukuran', $id_ukuran);
  		 $this->db->delete('ukuran'); 
	}

	function satuan($id_satuan=null)
	{
		$query = $this->db->get('satuan');

		return $query->result();

	}

	function view_satuan($id_satuan=null) //
	{
		$query = $this->db->get('satuan');

		return $query->result(); //Lempar result ke query
    }
}
