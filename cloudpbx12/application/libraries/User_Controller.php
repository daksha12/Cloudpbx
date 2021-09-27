<?php
class User_Controller extends MY_Controller
{

	function __construct ()
	{
		parent::__construct();
		$this->data['meta_title'] = 'Cloud PBX Portal';
		
		// SESSION VALIDATION CHECK //
		if($this->uri->segment(1) != 'login'){
          if(!isset($_SESSION['username']))
	      {
	        redirect('secure/login');
	      }
	      if($_SESSION['user_type'] != 'Super Admin'){
	       if(!isset($_SESSION['site_name']))
	       {
	          redirect('secure/login');
	        }
	      }
	      
	    }

	    if($_SESSION['user_type'] != 'Admin' AND $_SESSION['user_type'] != 'Super Admin'){
	       redirect('secure/login');
	    }
	    // SESSION VALIDATION CHECK //
	}
}
?>