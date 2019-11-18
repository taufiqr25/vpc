<?php

class Login_model extends CI_Model
{
    public function getLogin($username , $password)
    {        
        // $this->db->select('id','nama','username');
        return $this->db->get_where('tb_users', ['username' => $username, 'password' => $password])->result_array();
    }  

    public function getUserData($username)
    {
        return $this->db->get_where('tb_users', ['username' => $username])->result_array();
    }
}
