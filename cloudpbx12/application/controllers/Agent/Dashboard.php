<?php

class Dashboard extends Agent_Controller
{
public function __construct()
{
parent::__construct();
}

public function index()
{ 
$this->data['site_id'] = $_SESSION['site_id'];
$this->data['subview'] = 'agent/dashboard/index';
$this->load->view('_layout_main', $this->data);   
}

public function reset_password()
{	
  if(isset($_POST['save'])){
  $newpass = $this->Login_m->hash($_POST['newpass']);
  $id      = $_POST['id'];

  $update_data  = array('password' => $newpass,'password_temp' => $_POST['newpass'],'force_password_reset'=>'N');

  $this->db->where('id',$id);
  $this->db->update($_SESSION['tenant_extensions'],$update_data);        

  // reset session // 
  $_SESSION['pass_reset'] = 'N';				
  $_SESSION['password']   = $_POST['newpass'];

  $this->session->set_flashdata('swal_message', 'Password Reset Successfully');
  redirect('Agent/dashboard/index'); 
  }
}

}
?>
