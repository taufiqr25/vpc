<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_satuan extends CI_Model {
	
	function get()
	{
		$query = $this->db->get('satuan');
		return $query->result();
	}
	
	function add($data)
	{
		$query = $this->db->insert('satuan',$data);
	}

	function getid($id_satuan)
	{
		$this->db->where("id_satuan",$id_satuan);
		$query = $this->db->get('satuan');
		return $query->result();
	}

	function edit($data,$id_satuan)
	{
		$this->db->where("id_satuan",$id_satuan);
		$this->db->update('satuan',$data);
	}

	function delete($id_satuan)
	{
		$this->db->where('id_satuan', $id_satuan);
  		$this->db->delete('satuan'); 
	}
}
