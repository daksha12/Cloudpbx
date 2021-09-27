<?php

class Voice_mail extends User_Controller
{
public function __construct()
{
parent::__construct();
}

public function voice_list()
{
  
$ext = $this->Report_m->get_tenant_ext('','','All');  
$this->data['extension_list'] = $ext['aaData'];

if(isset($_POST['search'])){
 $ext       = explode(',', $_POST['extension']);
 $extension = $ext[0]; 
 $type      = $_POST['mail_type'];
 $site      = get_site_name($ext[1]);
 }else{
 $extension = '';
 $type      = '';
 $site      = '';
 }
	
 $this->data['extension'] = $extension;
 $this->data['mail_type'] = $type;
 $this->data['site']      = $site;
 $this->data['subview'] = 'admin/reports/voice_mail';
 $this->load->view('_layout_main', $this->data);   
} 

}
?>
