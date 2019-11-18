<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct()
 {
  parent::__construct();
  $this->load->model('M_login');
  $session = $this->session->userdata('koneksi');
  if($session)
  {
    redirect(base_url('home'));
  }
 }

 public function index()
 {
  $submit = $this->input->post('submit');
  if ($submit) {
   $username = $this->input->post('username');
   $password = md5($this->input->post('password'));
   //echo $username.$password;
   $login = $this->M_login->cek_login($username,($password));
   if ($login) {
    foreach ($login  as $login) {
    }
   $session_array = array(
    'username' => $username,
    'nama_user' => $login->nama_user,
    'role' => $login->role
    );

   $this->session->set_userdata('koneksi', $session_array);
   redirect(base_url(), 'refresh');

   }else{
    $data['error'] = true;
    $this->session->set_flashdata("Pesan","Username dan Password Salah");
    $this->load->view('V_login',$data);
   }
 }else{
   $data['error'] = false;
   $data['data'] = $this->M_login->get_user_data();
  //$this->load->view('header');
   $this->load->view('V_login', $data);
  //$this->load->view('footer');
  }
}
}
