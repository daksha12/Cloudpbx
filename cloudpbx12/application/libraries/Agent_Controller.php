<?php
class Agent_Controller extends MY_Controller
{

	function __construct ()
	{
		parent::__construct();
		$this->data['meta_title'] = 'Cloud PBX Portal';

		// SESSION VALIDATION CHECK //
		if($this->uri->segment(1) != 'agentlogin'){
          if(!isset($_SESSION['username']))
	      {
	        redirect('secure/agentlogin');
	      }
	      if(!isset($_SESSION['site_name']))
	      {
	        redirect('secure/agentlogin');
	      }
	      if(!isset($_SESSION['site_id']))
	      {
	        redirect('secure/agentlogin');
	      }
	    }

	    if($_SESSION['user_type'] != 'Agent'){
	       redirect('secure/agentlogin');
	    }
	    // SESSION VALIDATION CHECK //
	}
}
?>