<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_menu extends CI_Model
{

    function get_kat_daerah(){
        $query = $this->db->get('kategori_daerah');
        return $query->result();
    }

    function get_kat_video(){
        $query = $this->db->get('kategori_video');
        return $query->result();
    }

}
