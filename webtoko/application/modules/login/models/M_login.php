<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_login extends CI_Model {
	public function get_user_data(){
  $id_kategori_main = '1';
  $query = $this->db->get('user');
  return $query->result();
 }
function cek_login($username = null , $password = null){
  $this->db->where('username', $username);
  $this->db->where('password', $password);
  $query = $this->db->get('user');
  return $query->result();
 }
}
