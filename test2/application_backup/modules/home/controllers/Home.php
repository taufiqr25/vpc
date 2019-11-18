<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('M_home');

	}

	public function index()
	{
		$this->load->view('header');
		$this->load->view('V_home');
		$this->load->view('footer');
	}
}
