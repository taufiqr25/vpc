<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends MY_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$this->session->unset_userdata(SESSION_NAME); 
		redirect(base_url().'login');
	}
}
