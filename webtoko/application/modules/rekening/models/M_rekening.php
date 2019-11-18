<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_rekening extends CI_Model {
	
	function get()
	{
		$this->db->where('id_bank !=10');
		$query = $this->db->get('rekening_tujuan');

		return $query->result();
	}
	
	function add($data)
	{
		$query = $this->db->insert('rekening_tujuan',$data);
	}

	function getid($id_bank)
	{
		$this->db->where("id_bank",$id_bank);
		$query = $this->db->get('rekening_tujuan');

		return $query->result();
	}

	function edit($data,$id_bank)
	{
		$this->db->where("id_bank",$id_bank);
		$this->db->update('rekening_tujuan',$data);

	}

	function delete($id_bank)
	{
		$this->db->where('id_bank', $id_bank);
  		 $this->db->delete('rekening_tujuan'); 
	}
}
