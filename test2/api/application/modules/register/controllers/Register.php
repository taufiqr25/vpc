<?php

use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Register extends REST_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Register_model', 'register');
    }

    public function index_post()
    {
        $data = [
            'nama' => $this->post('nama'),
            'username' => $this->post('username'),
            'password' => md5($this->post('password')),
        ];

        if($this->register->addUsers($data) > 0){
            $this->response([
                'status' => TRUE,
                'message' => 'New Users has been Added'
            ], REST_Controller::HTTP_CREATED);
        }else {
            $this->response([
                'status' => FALSE,
                'message' => 'Failed to Add new Users '
            ], REST_Controller::HTTP_BAD_REQUEST );
        }
        
    }
}