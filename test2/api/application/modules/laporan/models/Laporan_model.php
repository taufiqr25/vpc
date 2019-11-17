<?php

class Laporan_model extends CI_Model
{
    public function getLaporan($id_laporan = null)
    {
        if($id_laporan === null){
            return $this->db->get('laporan')->result_array();
        }else{
            return $this->db->get_where('laporan', ['id_laporan' => $id_laporan])->result_array();
        }
    }   

    public function deleteLaporan($id_laporan)
    {
        $this->db->delete('laporan', ['id_laporan' => $id_laporan]);
        return $this->db->affected_rows();
    }

    public function addLaporan($data)
    {
        $this->db->insert('laporan', $data);
        return $this->db->affected_rows();   
    }

    public function updateLaporan($data,$id_laporan)
    {
        $this->db->update('laporan', $data, ['id_laporan' => $id_laporan]);
        return $this->db->affected_rows();
    }
}
