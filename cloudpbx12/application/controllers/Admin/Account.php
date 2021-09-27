<?php

class Account extends Login_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

  	public function forgot_password() {
       $this->load->view('admin/account/forgot_password', $this->data);   
    }

    public function set_session($id,$name)
	{
	  if($id == "All"){		 		
	    $_SESSION['site_id'] = 'All';
		$_SESSION['site_name'] = 'All'; 
	  }else{			
	    $_SESSION['site_id'] = $id;
		$_SESSION['site_name'] = $name; 
	  }

	 $previous = $_SERVER['HTTP_REFERER'];
	 redirect($previous);
	}
}
?>
