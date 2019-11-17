<?php

use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Laporan extends REST_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Laporan_model', 'laporan');
    }

    public function index_get()
    {       
        $id_laporan = $this->get('id_laporan');

        if($id_laporan === null){
            $laporan = $this->laporan->getLaporan();            
        }else{
            $laporan = $this->laporan->getLaporan($id_laporan);            
        }

        if($laporan){
            $this->response([
                'status' => TRUE,
                'data' => $laporan
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'Id Laporan Not Found'
            ], REST_Controller::HTTP_NOT_FOUND );
        }
    }

    public function index_delete()
    {
        $id_laporan = $this->delete('id_laporam');
        if($id_laporan === null){
            $this->response([
                'status' => FALSE,
                'message' => 'Id Laporan Require'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }else {
            if($this->laporan->deleteLaporan($id_laporan) > 0){
                $this->response([
                    'status' => TRUE,
                    'id laporan' => $id_laporan,
                    'message' => 'deleted'
                ], REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'Id Laporan Not Found'
                ], REST_Controller::HTTP_NOT_FOUND );
            }
        }
    }

    public function index_post()
    {
        $data = [
            'nama_pelapor' => $this->post('nama_pelapor') ,
            'nama_selesai' => $this->post('nama_selesai') ,
            'jurusan' => $this->post('jurusan') ,
            'nama_alat' => $this->post('nama_alat') ,
            'tipe' => $this->post('tipe') ,
            'status' => 'in process' ,
            'deskripsi' => $this->post('deskripsi') ,
            'solusi' => $this->post('solusi') ,
            'biaya' => $this->post('biaya') ,
            'tanggal' => date("Y-m-d") 
        ];

        if($this->laporan->addLaporan($data) > 0){
            $this->response([
                'status' => TRUE,
                'message' => 'New Laporan has been Added'
            ], REST_Controller::HTTP_CREATED);
        }else {
            $this->response([
                'status' => FALSE,
                'message' => 'Failed to Add new Laporan '
            ], REST_Controller::HTTP_BAD_REQUEST );
        }
    }

    public function index_put()
    {
        $id_laporan = $this->put('id_laporan');
        $data = [
            'nama_pelapor' => $this->put('nama_pelapor') ,
            'nama_selesai' => $this->put('nama_selesai') ,
            'jurusan' => $this->put('jurusan') ,
            'nama_alat' => $this->put('nama_alat') ,
            'tipe' => $this->put('tipe') ,
            'status' => $this->put('status') ,
            'deskripsi' => $this->put('deskripsi') ,
            'solusi' => $this->put('solusi') ,
            'biaya' => $this->put('biaya') ,
            'tanggal' => $this->put('tanggal'),
        ];

        if($this->pegawai->updatelaporan($data, $id_laporan) > 0){
            $this->response([
                'status' => TRUE,
                'id laporan' => $id_laporan,
                'message' => 'Laporan has been Updated'
            ], REST_Controller::HTTP_OK);
        }else {
            $this->response([
                'status' => FALSE,
                'message' => 'Failed to Update Pegawai '
            ], REST_Controller::HTTP_BAD_REQUEST );
        }
    }

    public function image_post()
    {
        $this->load->library('upload');
        
        if(isset($_FILES['file']['size']) > 0){
            $config['upload_path'] = 'assets/uploads';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_width'] = 5000;
            $config['max_height'] = 5000;
            $config['overwrite'] = TRUE;
            $config['max_filename'] = 25;
            $this->upload->initialize($config);

            if(!$this->upload->do_upload('file')){
                $error = $this->upload->display_errors();
                $this->response([
                    'status' => FALSE,
                    'message' => $error
                ], REST_Controller::HTTP_NOT_FOUND );
            }else{
                $photo = $this->upload->file_name;
                $this->load->helper('file');
                $this->load->library('image_lib');
                $config['image_library'] = 'gd2';
                $config['source_image'] = 'assets/uploads/' . $photo;
                $config['new_image'] = 'assets/uploads/thumbs/' . $photo;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 600;
                $config['height'] = 600;

                $this->image_lib->clear();
                $this->image_lib->initialize($config);

                if(!$this->image_lib->resize()){
                    $error = $this->image_lib->display_errors();
                    $this->response([
                        'status' => FALSE,
                        'message' => $error
                    ], REST_Controller::HTTP_NOT_FOUND );
                }

                // $this->response([
                //     'status' => TRUE,
                //     'message' => $this->post('name')
                // ], REST_Controller::HTTP_OK );
                $data = [
                    'nama_pelapor' => $this->post('nama_pelapor') ,
                    'jurusan' => $this->post('jurusan') ,
                    'nama_alat' => $this->post('nama_alat') ,
                    'tipe' => $this->post('tipe') ,
                    'status' => 'awaiting' ,
                    'deskripsi' => $this->post('deskripsi') ,
                    'biaya' => $this->post('biaya') ,
                    'foto_laporan' => $photo,
                    'tanggal' => date("Y-m-d") 
                ];
        
                if($this->laporan->addLaporan($data) > 0){
                    $this->response([
                        'status' => TRUE,
                        'message' => 'New Laporan has been Added'
                    ], REST_Controller::HTTP_CREATED);
                }else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'Failed to Add new Laporan '
                    ], REST_Controller::HTTP_BAD_REQUEST );
                }
            }
        }else{
            $data = [
                'nama_pelapor' => $this->post('nama_pelapor') ,
                'jurusan' => $this->post('jurusan') ,
                'nama_alat' => $this->post('nama_alat') ,
                'tipe' => $this->post('tipe') ,
                'status' => 'awaiting' ,
                'deskripsi' => $this->post('deskripsi') ,
                'biaya' => $this->post('biaya') ,
                'tanggal' => date("Y-m-d") 
            ];
    
            if($this->laporan->addLaporan($data) > 0){
                $this->response([
                    'status' => TRUE,
                    'message' => 'New Laporan has been Added'
                ], REST_Controller::HTTP_CREATED);
            }else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Failed to Add new Laporan '
                ], REST_Controller::HTTP_BAD_REQUEST );
            }
        }
    }

}