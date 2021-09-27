<?php

class Provisioning extends User_Controller
{

public function __construct()
{
parent::__construct();
}

/************ COMPANNY PART **************/
public function company($id = null)
{
 
 if(isset($_POST['save'])){
 
  $name = $_POST['company'];
    $id   = $_POST['id'];
    /////// VALIDATE PHONE /////
    $phone = get_phone_company_valid($name,$_SESSION['user_id'],$id);
    if($phone == 1){
      $this->session->set_flashdata('swal_error', 'Already Use Phone Company Name');
    redirect('Admin/Provisioning/company'); 
    }

  $data = array('name' => $name,'tenant_id' => $_SESSION['user_id']);
  
  if($id == ''){
   $this->db->insert('phone_company',$data);  
    }else{
     $this->db->where('id',$id);    
     $this->db->update('phone_company',$data);  
    }

    $this->session->set_flashdata('swal_message', 'Phone Company Add Successfully');
    redirect('Admin/Provisioning/company');
 }

 if($id != ''){
  $phone = get_phone_company($id);
    $this->data['phone'] = $phone;
 }

 $this->data['subview'] = 'admin/provisioning/company';
 $this->load->view('_layout_main', $this->data);   
}

public function delete_company($id)
{
  $family = get_phone_family_com_wise($id);
  if($family == 1){
    $this->session->set_flashdata('swal_error','This Phone Company Use In Phone Family'); 
     redirect('Admin/Provisioning/company');
  }

  $this->db->where('id', $id);
  $del=$this->db->delete('phone_company');       
  $affectedRows=$this->db->affected_rows();
  if($affectedRows > 0){
  $this->session->set_flashdata('swal_message','Phone Company Deleted Successfully'); 
  }else{
  $this->session->set_flashdata('swal_error','Phone Company Not Deleted'); 
  }

  redirect('Admin/Provisioning/company');
} 


/************ FAMILY PART **************/
public function family($id = null)
{
 
 if(isset($_POST['save'])){
 
  $company = $_POST['company'];
  $model   = $_POST['model'];
  $file_prifix = $_POST['file_prifix'];
  $id      = $_POST['id'];
    /////// VALIDATE PHONE /////
    $phone = get_phone_family_valid($company,$model,$_SESSION['user_id'],$id);
    if($phone == 1){
      $this->session->set_flashdata('swal_error', 'Already Use Phone Family Name');
    redirect('Admin/Provisioning/family');  
    }

  $data = array('company' => $company,'model' => $model,'file_prifix' => $file_prifix,'tenant_id' => $_SESSION['user_id']);
  
  if($id == ''){
   $this->db->insert('phone_family',$data); 
    }else{
     $this->db->where('id',$id);    
     $this->db->update('phone_family',$data); 
    }

    $this->session->set_flashdata('swal_message', 'Phone Family Add Successfully');
    redirect('Admin/Provisioning/family');
 }

 if($id != ''){
  $model = get_phone_family($id);
  $this->data['model'] = $model;
 }

 $this->data['company'] = get_phone_company_tenant($_SESSION['user_id']);
 $this->data['subview'] = 'admin/provisioning/family';
 $this->load->view('_layout_main', $this->data);   

}

public function delete_family($id)
{

  $temp = get_phone_temp_model_wise($id);
  if($temp == 1){
    $this->session->set_flashdata('swal_error','This Phone family Use In Phone Template'); 
     redirect('Admin/Provisioning/family');
  }

  $this->db->where('id', $id);
  $del=$this->db->delete('phone_family');       
  $affectedRows=$this->db->affected_rows();
  if($affectedRows > 0){
  $this->session->set_flashdata('swal_message','Phone Family Deleted Successfully'); 
  }else{
  $this->session->set_flashdata('swal_error','Phone Family Not Deleted'); 
  }

  redirect('Admin/Provisioning/family');
} 



/************ TEMPLATE PART **************/
public function template($id = null)
{

 if(isset($_POST['save'])){
 
  $company   = $_POST['company'];
  $model     = $_POST['model'];
  $username  = $_POST['username'];
  $auth_username = $_POST['auth_username'];
  $password  = $_POST['password'];
  $domain1   = $_POST['domain1'];
  $proxy1    = $_POST['proxy1'];
  $port1     = $_POST['port1'];
  $domain2   = $_POST['domain2'];
  $proxy2    = $_POST['proxy2'];
  $port2     = $_POST['port2'];
  $mac       = $_POST['mac'];
  
  //// LDAP ////
  $ip_address  = $_POST['ip_address'];
  $ldap_name   = $_POST['ldap_name'];
  $port        = $_POST['port'];
  $ldap_username    = $_POST['ldap_username'];
  $ldap_password    = $_POST['ldap_password'];
  $base_domain = $_POST['base_domain'];
  $on_filter   = $_POST['on_filter'];
  ////////////
  $id        = $_POST['id'];
    

    $file = $_FILES['file_name']['name'];
    if($file == ''){
       $file = $_POST['file_name_old'];
    }

    $file_temp = $_FILES['file_name']['tmp_name'];

    /////// VALIDATE TEMP /////
    $phone = get_phone_temp_valid($company,$model,$_SESSION['user_id'],$id);
    if($phone == 1){
      $this->session->set_flashdata('swal_error', 'Already Use Template For This Model');
      redirect('Admin/Provisioning/template');  
    }

  $data = array(
    'company'   => $company,
    'model'     => $model,
    'tenant_id' => $_SESSION['user_id'],
    'username'  => $username,
    'auth_username' => $auth_username,
    'password'  => $password,
    'domain1'   => $domain1,
    'proxy1'    => $proxy1,
    'port1'     => $port1,
    'domain2'   => $domain2,
    'proxy2'    => $proxy2,
    'port2'     => $port2,
    'mac'       => $mac,
    'ldap_ip_address'  => $ip_address,
    'ldap_name'        => $ldap_name,
    'ldap_port'        => $port,
    'ldap_username'    => $ldap_username,
    'ldap_password'    => $ldap_password,
    'ldap_base_domain' => $base_domain,
    'ldap_on_filter'   => $on_filter,
    'file_name' => $file
  );
  
  if($id == ''){
     $this->db->insert('phone_template',$data); 
    }else{
     $this->db->where('id',$id);    
     $this->db->update('phone_template',$data); 
    }

    ///// FILE MOVE ////
    if($_FILES['file_name']['name'] != ''){
    $path = mkdir('/var/www/html/templates/'.$_SESSION['user_id'].'/'.$company.'/'.$model,0777,TRUE);
    move_uploaded_file($file_temp,'/var/www/html/templates/'.$_SESSION['user_id'].'/'.$company.'/'.$model.'/'.$file);
    }

    ///////// CRETA ALL FILE FOR ////////

    $ldap = get_LDAP_details($_SESSION['user_id']);
    $get_json_data = get_file_json($company,$model,$file);
    $get_json = str_replace('AND', 'AND', $get_json_data);
    $json     = json_decode($get_json,true);
    $extfile  = explode('.', $file);

    $ext = get_model_phone_provisioning($company,$model,$_SESSION['user_id']);

    foreach ($ext as $value) {
    $extension   = $value['extension'];
    $phone_ip    = $value['phone_ip'];
    $ex_mac      = $value['mac'];
    $ex_domain1  = $value['domain1'];
    $ex_proxy1   = $value['proxy1'];
    $ex_port1    = $value['port1'];
    $ex_domain2  = $value['domain2'];
    $ex_proxy2   = $value['proxy2'];
    $ex_port2    = $value['port2'];
    $site_id     = $value['site_id'];

    /**** GET CONFIG DETAILS ****/
    $path     = '/etc/asterisk/bizRTCPBX/'.$_SESSION['username'].'/sip_'.$_SESSION['username'].'_'.$_SESSION['site_name'].'_'.$extension.'_user.conf';
    $data     = parse_ini_file($path,true); 

    if($extfile[1] != 'xml'){
    
    $json[$mac]      = $ex_mac;
    $json[$username] = $data['6'.$extension.'-'.$_SESSION['site_name'].'-'.$_SESSION['username']]['defaultuser'];   
    $json[$auth_username] = $data['6'.$extension.'-'.$_SESSION['site_name'].'-'.$_SESSION['username']]['defaultuser'];
    $json[$password] = $data['6'.$extension.'-'.$_SESSION['site_name'].'-'.$_SESSION['username']]['secret'];
    $json[$domain1]  = $ex_domain1;     
    $json[$proxy1]   = $ex_proxy1;     
    $json[$port1]    = $ex_port1;     
    $json[$domain2]  = $ex_domain2;     
    $json[$proxy2]   = $ex_proxy2;     
    $json[$port2]    = $ex_port2;     
   
    //// LDAP /////
    $json[$ip_address]    = $ldap->ip_address;     
    $json[$ldap_name]     = $ldap->ldap_name;     
    $json[$port]          = $ldap->port;     
    $json[$ldap_username] = $ldap->username;     
    $json[$ldap_password] = $ldap->password;     
    $json[$base_domain] = $ldap->base_domain;     
    $json[$on_filter]   = $ldap->on_filter;     
    //////////////  
  
    }else{

    $json[$mac] = $ex_mac;  
    $json['config'][$username] = $data['6'.$extension.'-'.$_SESSION['site_name'].'-'.$_SESSION['username']]['defaultuser'];   
    $json['config'][$auth_username] = $data['6'.$extension.'-'.$_SESSION['site_name'].'-'.$_SESSION['username']]['defaultuser'];
    $json['config'][$password] = $data['6'.$extension.'-'.$_SESSION['site_name'].'-'.$_SESSION['username']]['secret'];
    $json['config'][$domain1]  = $ex_domain1;     
    $json['config'][$proxy1]   = $ex_proxy1;     
    $json['config'][$port1]    = $ex_port1;     
    $json['config'][$domain2]  = $ex_domain2;     
    $json['config'][$proxy2]   = $ex_proxy2;     
    $json['config'][$port2]    = $ex_port2;     
   
    //// LDAP /////
    $json['config'][$ip_address]    = $ldap->ip_address;     
    $json['config'][$ldap_name]     = $ldap->ldap_name;     
    $json['config'][$port]          = $ldap->port;     
    $json['config'][$ldap_username] = $ldap->username;     
    $json['config'][$ldap_password] = $ldap->password;     
    $json['config'][$base_domain] = $ldap->base_domain;     
    $json['config'][$on_filter]   = $ldap->on_filter;     
    //////////////  
    }

    $json_data = json_encode($json);
    $jSON      = json_decode($json_data, true);
    $xml       = array2xml($jSON, false);

    $prifix = get_model_file_prifix($company,$model);    

    $path = mkdir('/var/www/html/tftp/'.$_SESSION['user_id'].'/'.$site_id.'/'.$company.'/'.$model,0777,TRUE);
    $fp = fopen('/var/www/html/tftp/'.$_SESSION['user_id'].'/'.$site_id.'/'.$company.'/'.$model.'/'.$prifix.$ex_mac.'.xml',"wb");
    fwrite($fp,$xml);
    fclose($fp);
    ////// end xml file ///// 
    }

    /////////////////////////////////////

    $this->session->set_flashdata('swal_message', 'Phone Template Add Successfully');
    redirect('Admin/Provisioning/template');
 }

 if($id != ''){
   $temp = get_phone_temp($id);
   $this->data['template'] = $temp;
 }

  $this->data['company'] = get_phone_company_tenant($_SESSION['user_id']);
  $this->data['model']   = get_phone_family_tenant($_SESSION['user_id']);
  $this->data['subview'] = 'admin/provisioning/template';
  $this->load->view('_layout_main', $this->data);   
}

public function delete_template($id)
{
  $pro = get_model_phone_provisioning_temp($id);
  if($pro == 1){
    $this->session->set_flashdata('swal_error','This Phone Template Use In Phone Provisioning'); 
    redirect('Admin/Provisioning/template');
  }

  $this->db->where('id', $id);
  $del=$this->db->delete('phone_template');       
  $affectedRows=$this->db->affected_rows();
  if($affectedRows > 0){
   $this->session->set_flashdata('swal_message','Phone Template Deleted Successfully'); 
  }else{
   $this->session->set_flashdata('swal_error','Phone Template Not Deleted'); 
  }

  redirect('Admin/Provisioning/template');
} 

/************ TEMPLATE PART **************/
public function provisioning($id = null)
{

 if(isset($_POST['save']))
 {
  $company   = $_POST['company'];
  $model     = $_POST['model'];
  $extension = $_POST['extension'];
  $phone_ip  = $_POST['phone_ip'];
  $mac       = $_POST['mac'];
  $site_id   = $_SESSION['site_id'];
  $domain1   = $_POST['domain1'];
  $proxy1    = $_POST['proxy1'];
  $port1     = $_POST['port1'];
  $domain2   = $_POST['domain2'];
  $proxy2    = $_POST['proxy2'];
  $port2     = $_POST['port2'];
  $id        = $_POST['id'];

  /////// VALIDATE TEMP /////
  $pro = get_phone_provisioning_valid($_SESSION['user_id'],$site_id,$extension,$id);
  if($pro == 1){
  $this->session->set_flashdata('swal_error', 'Already Extenion Provisioning');
  redirect('Admin/Provisioning/provisioning');  
  }

   ////// CREATE TE FILE //////
   $temp = get_phone_temp_model($company,$model);
   if($temp != 0){
 
   $ldap = get_LDAP_details($_SESSION['user_id']);

   $get_json_data = get_file_json($company,$model,$temp->file_name);
   $get_json = str_replace('AND', 'AND', $get_json_data);
   $json     = json_decode($get_json,true);
   $extfile  = explode('.', $temp->file_name);

   /**** GET CONFIG DETAILS ****/
   $path     = '/etc/asterisk/bizRTCPBX/'.$_SESSION['username'].'/sip_'.$_SESSION['username'].'_'.$_SESSION['site_name'].'_'.$extension.'_user.conf';
   $data     = parse_ini_file($path,true); 
   
   if($extfile[1] != 'xml'){
   
   $json[$temp->mac] = $mac;  
   $json[$temp->username] = $data['6'.$extension.'-'.$_SESSION['site_name'].'-'.$_SESSION['username']]['defaultuser'];   
   $json[$temp->auth_username] = $data['6'.$extension.'-'.$_SESSION['site_name'].'-'.$_SESSION['username']]['defaultuser'];
   $json[$temp->password] = $data['6'.$extension.'-'.$_SESSION['site_name'].'-'.$_SESSION['username']]['secret'];     
   $json[$temp->domain1]  = $domain1;     
   $json[$temp->proxy1]   = $proxy1;     
   $json[$temp->port1]    = $port1;     
   $json[$temp->domain2]  = $domain2;     
   $json[$temp->proxy2]   = $proxy2;     
   $json[$temp->port2]    = $port2;

   //// LDAP /////
   $json[$temp->ldap_ip_address]  = $ldap->ip_address;     
   $json[$temp->ldap_name]        = $ldap->ldap_name;     
   $json[$temp->ldap_port]        = $ldap->port;     
   $json[$temp->ldap_username]    = $ldap->username;     
   $json[$temp->ldap_password]    = $ldap->password;     
   $json[$temp->ldap_base_domain] = $ldap->base_domain;     
   $json[$temp->ldap_on_filter]   = $ldap->on_filter;     
   //////////////
   
   }else{

   $json[$temp->mac] = $mac;
   $json['config'][$temp->username] = $data['6'.$extension.'-'.$_SESSION['site_name'].'-'.$_SESSION['username']]['defaultuser'];   
   $json['config'][$temp->auth_username] = $data['6'.$extension.'-'.$_SESSION['site_name'].'-'.$_SESSION['username']]['defaultuser'];
   $json['config'][$temp->password] = $data['6'.$extension.'-'.$_SESSION['site_name'].'-'.$_SESSION['username']]['secret'];     
   $json['config'][$temp->domain1]  = $domain1;     
   $json['config'][$temp->proxy1]   = $proxy1;     
   $json['config'][$temp->port1]    = $port1;     
   $json['config'][$temp->domain2]  = $domain2;     
   $json['config'][$temp->proxy2]   = $proxy2;     
   $json['config'][$temp->port2]    = $port2;     

      //// LDAP /////
   $json['config'][$temp->ldap_ip_address]  = $ldap->ip_address;     
   $json['config'][$temp->ldap_name]        = $ldap->ldap_name;     
   $json['config'][$temp->ldap_port]        = $ldap->port;     
   $json['config'][$temp->ldap_username]    = $ldap->username;     
   $json['config'][$temp->ldap_password]    = $ldap->password;     
   $json['config'][$temp->ldap_base_domain] = $ldap->base_domain;     
   $json['config'][$temp->ldap_on_filter]   = $ldap->on_filter;     
   //////////////
  
   }

   $json_data = json_encode($json);
   $jSON      = json_decode($json_data, true);
   $xml       = array2xml( $jSON, false);
   

  $prifix = get_model_file_prifix($company,$model);    
  //// xml file move  /////
  $path = mkdir('/var/www/html/tftp/'.$_SESSION['user_id'].'/'.$site_id.'/'.$company.'/'.$model,0777,TRUE);
  $fp = fopen('/var/www/html/tftp/'.$_SESSION['user_id'].'/'.$site_id.'/'.$company.'/'.$model.'/'.$prifix.$mac.'.xml',"wb");
  fwrite($fp,$xml);
  fclose($fp);
  ////// end xml file ///// 


   /**** GET CONFIG DETAILS ****/
  }else{ 
    $this->session->set_flashdata('swal_error', 'Please Add Phone Model Template');
    redirect('Admin/Provisioning/provisioning');  
  }
  
  ///////////////////////////

  $data = array(
    'tenant_id' => $_SESSION['user_id'],
    'site_id'   => $site_id,
    'phone_company' => $company,
    'model'     => $model,
    'extension' => $extension,
    'phone_ip'  => $phone_ip,
    'mac'       => $mac,
    'domain1'   => $domain1,
    'proxy1'    => $proxy1,
    'port1'     => $port1,
    'domain2'   => $domain2,
    'proxy2'    => $proxy2,
    'port2'     => $port2,
    'file_name' => $extension.'.xml'
  );
  
  if($id == ''){
    $this->db->insert('phone_provisioning',$data); 
  }else{
    $this->db->where('id',$id);    
    $this->db->update('phone_provisioning',$data); 
  }
  

  $this->session->set_flashdata('swal_message', 'Phone Provisioning Successfully');
  redirect('Admin/Provisioning/provisioning');
 }

 if($id != ''){
   $provisioning = get_phone_provisioning($id); 
   $this->data['provisioning'] = $provisioning;
 }

 $this->data['extension'] = get_prov_extension($_SESSION['site_id']);
 $this->data['company']   = get_phone_company_tenant($_SESSION['user_id']);
 $this->data['model']     = get_phone_family_tenant($_SESSION['user_id']);
 $this->data['subview']   = 'admin/provisioning/provisioning';
 $this->load->view('_layout_main', $this->data);   
}



public function import_provisioning($id = null)
{

 if(isset($_POST['save'])){
 
  $company   = $_POST['company'];
  $model     = $_POST['model'];
  
  $temp = get_phone_temp_model($company,$model);
  if($temp == 0){
    $this->session->set_flashdata('swal_error', 'Please Add Phone Model Template');
    redirect('Admin/Provisioning/provisioning');  
  }else{
   
   $ldap = get_LDAP_details($_SESSION['user_id']);
    
   $get_json_data = get_file_json($company,$model,$temp->file_name);
   $get_json = str_replace('AND', 'AND', $get_json_data);
   $json     = json_decode($get_json,true);
   $extfile  = explode('.', $temp->file_name);
  }

  $count = count($_POST['phone_ip']);
  for($i=0;$i < $count;$i++){

  $extension = $_POST['extension'][$i];
  $phone_ip  = $_POST['phone_ip'][$i];
  $mac       = $_POST['mac'][$i];
  $site_id   = $_SESSION['site_id'];
  $domain1   = $_POST['domain1'][$i];
  $proxy1    = $_POST['proxy1'][$i];
  $port1     = $_POST['port1'][$i];
  $domain2   = $_POST['domain2'][$i];
  $proxy2    = $_POST['proxy2'][$i];
  $port2     = $_POST['port2'][$i];

   /**** GET CONFIG DETAILS ****/
   $path     = '/etc/asterisk/bizRTCPBX/'.$_SESSION['username'].'/sip_'.$_SESSION['username'].'_'.$_SESSION['site_name'].'_'.$extension.'_user.conf';
   $data     = parse_ini_file($path,true); 
   
   if($extfile[1] != 'xml'){

   $json[$temp->mac] = $mac;   
   $json[$temp->username] = $data['6'.$extension.'-'.$_SESSION['site_name'].'-'.$_SESSION['username']]['defaultuser'];   
   $json[$temp->auth_username] = $data['6'.$extension.'-'.$_SESSION['site_name'].'-'.$_SESSION['username']]['defaultuser'];
   $json[$temp->password] = $data['6'.$extension.'-'.$_SESSION['site_name'].'-'.$_SESSION['username']]['secret'];     
   $json[$temp->domain1]  = $domain1;     
   $json[$temp->proxy1]   = $proxy1;     
   $json[$temp->port1]    = $port1;     
   $json[$temp->domain2]  = $domain2;     
   $json[$temp->proxy2]   = $proxy2;     
   $json[$temp->port2]    = $port2;   

    //// LDAP /////
   $json[$temp->ldap_ip_address]  = $ldap->ip_address;     
   $json[$temp->ldap_name]        = $ldap->ldap_name;     
   $json[$temp->ldap_port]        = $ldap->port;     
   $json[$temp->ldap_username]    = $ldap->username;     
   $json[$temp->ldap_password]    = $ldap->password;     
   $json[$temp->ldap_base_domain] = $ldap->base_domain;     
   $json[$temp->ldap_on_filter]   = $ldap->on_filter;     
   //////////////  
   
   }else{

   $json[$temp->mac] = $mac;
   $json['config'][$temp->username] = $data['6'.$extension.'-'.$_SESSION['site_name'].'-'.$_SESSION['username']]['defaultuser'];   
   $json['config'][$temp->auth_username] = $data['6'.$extension.'-'.$_SESSION['site_name'].'-'.$_SESSION['username']]['defaultuser'];
   $json['config'][$temp->password] = $data['6'.$extension.'-'.$_SESSION['site_name'].'-'.$_SESSION['username']]['secret'];     
   $json['config'][$temp->domain1]  = $domain1;     
   $json['config'][$temp->proxy1]   = $proxy1;     
   $json['config'][$temp->port1]    = $port1;     
   $json['config'][$temp->domain2]  = $domain2;     
   $json['config'][$temp->proxy2]   = $proxy2;     
   $json['config'][$temp->port2]    = $port2;

    //// LDAP /////
   $json['config'][$temp->ldap_ip_address]  = $ldap->ip_address;     
   $json['config'][$temp->ldap_name]        = $ldap->ldap_name;     
   $json['config'][$temp->ldap_port]        = $ldap->port;     
   $json['config'][$temp->ldap_username]    = $ldap->username;     
   $json['config'][$temp->ldap_password]    = $ldap->password;     
   $json['config'][$temp->ldap_base_domain] = $ldap->base_domain;     
   $json['config'][$temp->ldap_on_filter]   = $ldap->on_filter;     
   //////////////     

   }

   $json_data = json_encode($json);
   $jSON      = json_decode($json_data, true);
   $xml       = array2xml( $jSON, false );
  
  $prifix = get_model_file_prifix($company,$model); 
   //// xml file move  /////
   $path = mkdir('/var/www/html/tftp/'.$_SESSION['user_id'].'/'.$_SESSION['site_id'].'/'.$company.'/'.$model,0777,TRUE);
   $fp = fopen('/var/www/html/tftp/'.$_SESSION['user_id'].'/'.$_SESSION['site_id'].'/'.$company.'/'.$model.'/'.$prifix.$mac.'.xml',"wb");
   fwrite($fp,$xml);
   fclose($fp);
   ////// end xml file ///// 

   /**** GET CONFIG DETAILS ****/
  
  ///////////////////////////

  $data = array(
    'tenant_id' => $_SESSION['user_id'],
    'site_id'   => $site_id,
    'phone_company' => $company,
    'model'     => $model,
    'extension' => $extension,
    'phone_ip'  => $phone_ip,
    'mac'       => $mac,
    'domain1'   => $domain1,
    'proxy1'    => $proxy1,
    'port1'     => $port1,
    'domain2'   => $domain2,
    'proxy2'    => $proxy2,
    'port2'     => $port2,
    'file_name' => $extension.'.xml'
   );
  
   $this->db->insert('phone_provisioning',$data); 
   
   } // for loop

 } /// submit if

  $this->session->set_flashdata('swal_message', 'Phone Provisioning Successfully');
  redirect('Admin/Provisioning/provisioning');
}


public function provisi_down($tenant_id,$site_id,$com,$model,$file){

 $file='/var/www/html/tftp/'.$tenant_id.'/'.$site_id.'/'.$com.'/'.$model.'/'.$file;   

 $filetype=filetype($file);

 $filename=basename($file);

 header ("Content-Type: ".$filetype);

 header ("Content-Length: ".filesize($file));

 header ("Content-Disposition: attachment; filename=".$filename);

 readfile($file);

}

public function delete_provisioning($id)
{
  $this->db->where('id', $id);
  $del=$this->db->delete('phone_provisioning');       
  $affectedRows=$this->db->affected_rows();
  if($affectedRows > 0){
  $this->session->set_flashdata('swal_message','Phone provisioning Deleted Successfully'); 
  }else{
  $this->session->set_flashdata('swal_error','Phone provisioning Not Deleted'); 
  }

  redirect('Admin/Provisioning/provisioning');
} 



}
?>
