<?php

class Call_forward extends Agent_Controller
{
public function __construct()
{
parent::__construct();
}

public function index()
{ 

$db = new SQLite3('/var/lib/asterisk/astdb.sqlite3', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);

if(isset($_POST['save'])){

$count = count($_POST['key_data']);

for ($i=0; $i <= $count -1; $i++) { 
$key    = $_POST['key_data'][$i];
$value  = $_POST['value_data'][$i];
$status = $_POST['status'][$i];

/**** VALIDATION *****/
$len = strlen($value);
if($value != '' && $len < 10){
$this->db->select('*'); 
$this->db->where('site_id',$_SESSION['site_id']);
$this->db->where('extension',$value);
$this->db->from($_SESSION['tenant_extensions']);
$query = $this->db->get();
$ext   = $query->row();

if(count($ext) == 0){
 $this->session->set_flashdata('swal_error', 'Enter valid extension');
 redirect('Agent/Call_forward/index');
}

}
/**** VALIDATION *****/

if($status != 'Active'){
  if($value != ''){
    $db->query("INSERT INTO astdb (key, value) VALUES ('$key', '$value')");
  }
}else{
if($value != ''){	
    $db->query('UPDATE astdb SET value = "'.$value.'" where key ="'.$key.'"');
}else{
	
	$db->query('DELETE FROM astdb where key="'.$key.'"');	
}
}
}

}

$this->data['available'] = sqllite_data_get("/CFNA_".$_SESSION["tenant_name"]."_".$_SESSION["site_name"]."/".$_SESSION["extension"]);
$this->data['unconditional'] = sqllite_data_get("/CFUC_".$_SESSION["tenant_name"]."_".$_SESSION["site_name"]."/".$_SESSION["extension"]);

$this->data['subview']      = 'agent/call_forward/call_forwarding';
$this->load->view('_layout_main', $this->data);   

}

}
?>
