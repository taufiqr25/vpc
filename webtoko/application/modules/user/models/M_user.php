<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_user extends CI_Model {
	
	function get()
	{
		$query = $this->db->get('user');

		return $query->result();
	}
	
	function add($data)
	{
		$query = $this->db->insert('user',$data);
	}

	function cekgambar($id)
	{
		$this->db->where("id",$id);
		$query = $this->db->get('user');

		return $query->result();
	}


	function getid($id)
	{
		$this->db->where("id",$id);
		$query = $this->db->get('user');

		return $query->result();
	}

	function edit($data,$id)
	{
		$this->db->where("id",$id);
		$this->db->update('user',$data);

	}

	function delete($id)
	{
		$this->db->where('id', $id);
  		 $this->db->delete('user'); 
	}
}
