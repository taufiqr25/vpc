<?php

use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Pegawai extends REST_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pegawai_model', 'pegawai');
    }

    public function index_get()
    {       
        $nip = $this->get('nip');

        if($nip === null){
            $pegawai = $this->pegawai->getPegawai();            
        }else{
            $pegawai = $this->pegawai->getPegawai($nip);            
        }

        if($pegawai){
            $this->response([
                'status' => TRUE,
                'data' => $pegawai
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'NIP Not Found'
            ], REST_Controller::HTTP_NOT_FOUND );
        }
    }

    public function index_delete()
    {
        $nip = $this->delete('nip');
        if($nip === null){
            $this->response([
                'status' => FALSE,
                'message' => 'NIP Require'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }else {
            if($this->pegawai->deletePegawai($nip) > 0){
                $this->response([
                    'status' => TRUE,
                    'nip' => $nip,
                    'message' => 'deleted'
                ], REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'NIP Not Found'
                ], REST_Controller::HTTP_NOT_FOUND );
            }
        }
    }

    public function index_post()
    {
        $data = [
            'list_nip' => $this->post('nip'),
            'list_nama_lengkap' => $this->post('nama'),
            'list_jenis_kelamin' => $this->post('kelamin'),
            'list_email' => $this->post('email'),
            'list_foto' => $this->post('foto'),
            'list_status_pegawai' => $this->post('status'),
        ];

        if($this->pegawai->addPegawai($data) > 0){
            $this->response([
                'status' => TRUE,
                'message' => 'New Pegawai has been Added'
            ], REST_Controller::HTTP_CREATED);
        }else {
            $this->response([
                'status' => FALSE,
                'message' => 'Failed to Add new Pegawai '
            ], REST_Controller::HTTP_BAD_REQUEST );
        }
    }

    public function index_put()
    {
        $nip = $this->put('nip');
        $data = [
            'list_nama_lengkap' => $this->put('nama'),
            'list_jenis_kelamin' => $this->put('kelamin'),
            'list_email' => $this->put('email'),
            'list_foto' => $this->put('foto'),
            'list_status_pegawai' => $this->put('status'),
        ];

        if($this->pegawai->updatePegawai($data, $nip) > 0){
            $this->response([
                'status' => TRUE,
                'nip' => $nip,
                'message' => 'Pegawai has been Updated'
            ], REST_Controller::HTTP_OK);
        }else {
            $this->response([
                'status' => FALSE,
                'message' => 'Failed to Update Pegawai '
            ], REST_Controller::HTTP_BAD_REQUEST );
        }
    }

    public function search_post()
    {
        $search = $this->post('search');

        $pegawai = $this->pegawai->getSearch($search);            
        // var_dump($pegawai);
        if($pegawai){
            $this->response([
                'status' => TRUE,
                'data' => $pegawai
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'data Not Found'
            ], REST_Controller::HTTP_NOT_FOUND );
        }
    }

}