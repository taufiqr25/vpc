<?php

class Pegawai_model extends CI_Model
{
    public function getPegawai($nip = null)
    {
        if($nip === null){
            return $this->db->get('pegawai')->result_array();
        }else{
            return $this->db->get_where('pegawai', ['list_nip' => $nip])->result_array();
        }
    }   

    public function deletePegawai($nip)
    {
        $this->db->delete('pegawai', ['list_nip' => $nip]);
        return $this->db->affected_rows();
    }

    public function addPegawai($data)
    {
        $this->db->insert('pegawai', $data);
        return $this->db->affected_rows();   
    }

    public function updatePegawai($data,$nip)
    {
        $this->db->update('pegawai', $data, ['list_nip' => $nip]);
        return $this->db->affected_rows();
    }

    public function getSearch($search = null)
    {        
        $this->db->like('list_nip' , $search, 'both');
        $this->db->or_like('list_nama_lengkap' , $search, 'both');
        return $this->db->get('pegawai')->result_array();
    }  

}
