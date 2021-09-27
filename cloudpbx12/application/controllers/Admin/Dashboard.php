<?php
class Dashboard extends User_Controller
{
public function __construct()
{
 parent::__construct();
}


public function index()
{  	  
 $this->data['subview'] = 'admin/dashboard/index';
 $this->load->view('_layout_main', $this->data);   
}

public function upload_logo()
{	
 $filename = $_FILES['userfile']['name'];
 $tmp      = $_FILES['userfile']['tmp_name'];

$logo_data  = 
array
(   
'user_id'   => $_SESSION['user_id'],  
'logo_name' => $filename,
'logo_path' => '/var/www/html/cloudpbx/upload/' 
);

$this->Logo_m->save($logo_data,$id);					

move_uploaded_file($tmp,'/var/www/html/cloudpbx/upload/'.$filename);

redirect('Admin/dashboard/index'); 
}

public function reset_password()
{	
if(isset($_POST['save'])){
$newpass = $this->Login_m->hash($_POST['newpass']);
$id      = $_POST['id'];

$update_data  = array('password' => $newpass,'password_temp' => $_POST['newpass'],'force_password_reset'=>'N');

$this->db->where('id',$id);
$this->db->update('login_details',$update_data);				

// reset session //	
$_SESSION['pass_reset'] = 'N';
$_SESSION['password']   = $_POST['newpass'];	

$this->session->set_flashdata('swal_message', 'Password Reset Successfully');
redirect('Admin/dashboard/index'); 
}
}

public function reset_agent_password()
{	
if(isset($_POST['save'])){
$newpass = $this->Login_m->hash($_POST['newpass']);
$id      = $_POST['agent_id'];
$force   = $_POST['forcepass'];

if($force == ''){
 $force = 'N';
}

$update_data  = array('password' => $newpass,'password_temp' => $_POST['newpass'],'force_password_reset'=>$force);

$_SESSION['password']   = $_POST['newpass'];

$this->db->where('id',$id);
$this->db->update($_SESSION['tenant_extensions'],$update_data);				

$this->session->set_flashdata('swal_message', 'Password Reset Successfully');
redirect('Admin/Users/index'); 
}
}

public function reset_logo()
{ 
$this->db->delete('pbx_logo',array('user_id'=> $_SESSION['user_id']));        
$this->session->set_flashdata('swal_message', 'Reset logo Successfully');
redirect('Admin/dashboard/index'); 
}
}
?>
