<?php 
class LDAP extends User_Controller
{

public function __construct()
{
parent::__construct();
}

/************ COMPANNY PART **************/
public function index($id = null)
{
 
 if(isset($_POST['save'])){
 
  $ip_address  = $_POST['ip_address'];
  $ldap_name   = $_POST['ldap_name'];
  $port        = $_POST['port'];
  $username    = $_POST['username'];
  $password    = $_POST['password'];
  $base_domain = $_POST['base_domain'];
  $on_filter   = $_POST['on_filter'];
  $id          = $_POST['id'];
 
  $data = array(
   'tenant_id'   => $_SESSION['user_id'],
   'ip_address'  => $ip_address,
   'ldap_name'   => $ldap_name,
   'port'        => $port,
   'username'    => $username,
   'password'    => $password,
   'base_domain' => $base_domain,
   'on_filter'   => $on_filter
  );
  
  if($id == ''){
   $this->db->insert('ldap_config',$data);  
  }else{
   $this->db->where('id',$id);    
   $this->db->update('ldap_config',$data);  
  }

  $this->session->set_flashdata('swal_message', 'Add LDAP Successfully');
  redirect('Admin/LDAP/index');
 }

 
 $ldap = get_LDAP_details($_SESSION['user_id']);
 $this->data['ldap'] = $ldap;
 
 $this->data['subview'] = 'admin/LDAP/index';
 $this->load->view('_layout_main', $this->data);   
}


public function delete($id)
{
 
  $this->db->where('id', $id);
  $del=$this->db->delete('ldap_config');       
  $affectedRows=$this->db->affected_rows();
  if($affectedRows > 0){
  $this->session->set_flashdata('swal_message','LDAP Details Deleted Successfully'); 
  }else{
  $this->session->set_flashdata('swal_error','LDAP Details Not Deleted'); 
  }

  redirect('Admin/LDAP/index');
} 

}
?>