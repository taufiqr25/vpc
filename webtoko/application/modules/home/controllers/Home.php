<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('M_home');
		$ses = $this->session->userdata('koneksi');
	      if (!$ses) {
	         redirect(base_url().'login');
     }
	}

	public function index()
	{
		$data['orderhariini'] = $this->M_home->orderhariini();
		$data['minimalbarang'] = $this->M_home->minimalbarang();
		$data['ses'] = $this->session->userdata('koneksi');
		$this->load->view('header',$data);
		$this->load->view('V_home');
		$this->load->view('footer');
	}


}
