<?php

use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Login extends REST_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model', 'login');
    }

    public function index_post()
    {
        $username = $this->post('username');
        $password = md5($this->post('password'));

        $login = $this->login->getLogin($username,$password);

        if($login //&& $login[0]['status'] === "1"//
        ){
            $data = $this->login->getUserData($username);
            if($data){
                $this->response([
                    'status' => TRUE,
                    'data' => $data
                ], REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'data user tidak ditemukan'
                ], REST_Controller::HTTP_NOT_FOUND );
            }
        // }else if($login && $login[0]['status'] === "0"){
        //     $this->response([
        //         'status' => FALSE,
        //         'message' => 'akun belum di aktifkan'
        //     ], REST_Controller::HTTP_NOT_FOUND );
        }
        else {
            $this->response([
                'status' => FALSE,
                'message' => $login
            ], REST_Controller::HTTP_NOT_FOUND );
        }
        
    }
}