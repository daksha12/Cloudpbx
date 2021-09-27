<?php
class Login_Controller extends MY_Controller
{
	function __construct ()
	{
		parent::__construct();
		$this->data['meta_title'] = 'Cloud PBX Portal';
	
		// LOAD MODEL //
		$this->load->model('Login_m');
	    //$meta_title='$site_title';
	}	
}