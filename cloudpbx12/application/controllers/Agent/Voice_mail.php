<?php

class Voice_mail extends Agent_Controller
{
public function __construct()
{
parent::__construct();
}

public function voice_list()
{
  
 if(isset($_POST['search'])){
  $type = $_POST['mail_type'];
 }else{
 	$type = 'INBOX';
 } 

 $this->data['extension'] = $_SESSION['extension'];
 $this->data['mail_type'] = $type;
 $this->data['site']      = get_site_name($_SESSION['site_id']);
 $this->data['subview']   = 'agent/reports/voice_mail';
 $this->load->view('_layout_main', $this->data);   
} 

}
?>
