<?php
class Secure extends Login_Controller
{
public function __construct()
{
parent::__construct();
}

public function home()
{
$this->load->view('home');
}

public function login()
{
if(isset($_POST['submit'])){

if ($this->Login_m->login() == TRUE)
{						
 if($_SESSION['user_type'] == 'Super Admin'){
   redirect('Super/Rate_card/index');          
 }else{
  redirect('Admin/Dashboard/index');          
 }     
}
else
{				
$this->session->set_flashdata('error', 'Invalid Username or Password');
redirect('secure/login');
}			
}

$this->data['subview'] = 'secure/login';
$this->load->view('_layout_modal', $this->data);	
}

public function Agentlogin()
{
if(isset($_POST['submit'])){

if ($this->Login_m->agentlogin() == TRUE)
{						
redirect('Agent/Dashboard/index');               
}
else
{					
$this->session->set_flashdata('error', 'Invalid Username or Password');
redirect('secure/agentlogin');
}			
}

$this->data['subview'] = 'secure/agentlogin';
$this->load->view('_layout_modal', $this->data);	
}

public function logout()
{   
$this->Login_m->logout();
redirect('secure/home');	
}

public function agentlogout()
{   
$this->Login_m->agentlogout();
redirect('secure/home');	
}

}
?>