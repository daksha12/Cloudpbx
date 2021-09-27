<?php

class Call_forward extends User_Controller
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

$key     = $_POST['key_data'][$i];
$value   = str_replace(",","|",$_POST['value_data'][$i]);
$status  = $_POST['status'][$i];
$key_old = $_POST['old_key_data'][$i];
$old_did = explode("/",$key_old);

$data    = explode("/",$key);
$type    = explode("_",$data[1]);

if($status != 'Active'){
  if($value != ''){
    $db->query("INSERT INTO astdb (key, value) VALUES ('$key', '$value')");
  }
}else{
  if($value != ''){
    if($type[0] != 'CIG' AND $type[0] != 'SPD' AND $type[0] != 'SPDext'){
     $db->query('UPDATE astdb SET value = "'.$value.'" where key ="'.$key.'"');
    }else{
     $db->query('UPDATE astdb SET value = "'.$value.'", key ="'.$key.'" where key ="'.$key_old.'"');
    }
  }else{
    $db->query('DELETE FROM astdb where key="'.$key.'"');	
  }
}

/***** DATA INSERT IN MYSQL *******/
$tenant_id = $_SESSION['user_id'];
$site_id   = $_SESSION['site_id'];

if($type[0] == 'COG'){
 $this->db->delete('block_number', array('tenant_id' => $tenant_id,'site_id'=>$site_id,'type'=>'OUT'));
 /*** ADD NEW ***/ 
 if($value != ''){

  $did_block = array(
  "tenant_id"  => $tenant_id,
  "site_id"    => $site_id,
  "number"     => $value,
  "type"       => 'OUT'																		
  );
 
  $this->db->insert('block_number',$did_block);	
 }
 /*** ADD NEW ***/ 
}

if($type[0] == 'CIG'){
 $this->db->delete('block_number', array('tenant_id' => $tenant_id,'site_id'=>$site_id,'did'=>$old_did[2],'type'=>'IN'));
 /*** ADD NEW ***/ 
 if($value != ''){
 $did_block = array(
 "tenant_id"  => $tenant_id,
 "site_id"    => $site_id,
 "did"        => $data[2],
 "number"     => $value,
 "type"       => 'IN'																		
 );
 
  $this->db->insert('block_number',$did_block);	
 }
 /*** ADD NEW ***/ 
}
/***** DATA INSERT IN MYSQL *******/
}

}

$this->data['outbound'] = str_replace("|",",",sqllite_data_get("/COG_".$_SESSION['username']."_".$_SESSION['site_name']."/calleridblk"));

$this->data['conference'] = str_replace("|",",",sqllite_data_get("/ConfPWD_".$_SESSION['username']."_".$_SESSION['site_name']."/".$_SESSION['site_name']."_200"));

$this->data['subview']      = 'admin/call_forward/call_forwarding';
$this->load->view('_layout_main', $this->data);   

}
public function Caller_id_block(){


    if(isset($_POST['save_inbound'])){

      $count = count($_POST['did_no']);
      $data    = explode("/",$_POST['key_data'][0]);
      for ($i=0; $i <= $count -1; $i++) { 

        $key     = $_POST['did_no'][$i];
        $value_data  = $_POST['value_data'][$i];

        $inbound = exec('sudo /usr/sbin/asterisk -rx "database put '.$data[1].' '.$key.' "'. $value_data.'""');
        redirect('Admin/Call_forward/Caller_id_block/1');
      }
    }
     if(isset($_POST['save_out_bound'])){
      
      $count = count($_POST['out_did_no']);
      $data    = explode("/",$_POST['out_data'][0]);
      for ($i=0; $i <= $count -1; $i++) { 

        $key_outbound    = $_POST['out_did_no'][$i];
        $out_value_data  = $_POST['out_value_data'][$i];

        $outbound = exec('sudo /usr/sbin/asterisk -rx "database put '.$data[1].' '.$key_outbound.' "'. $out_value_data.'""');

      }
      redirect('Admin/Call_forward/Caller_id_block/2');
    }
    
    if(isset($_POST['id'])){
      $key = $_POST['id'];
      $family_name = $_POST['family_name'];
      $del_asterisk = exec('sudo /usr/sbin/asterisk -rx "database del '.$family_name.' '.$key.' "');
      echo "success";
    }
    

    $this->data['subview']      = 'admin/call_forward/callerid_block';
    $this->load->view('_layout_main', $this->data);   

}
public function Conference_pin(){
/*Insert Conference Pin Data*/
    if(isset($_POST['save'])){

        $data    = explode("/",$_POST['old_key_conf_data']);
        $type    = explode("_",$data[1]);
        $key = $_POST['key_data'];
        $value_data     = $_POST['conference_pin'];

        if($type[0]=="Conf4PWD"){

            $conference_pin4 = exec('sudo /usr/sbin/asterisk -rx "database put '.$data[1].' '.$key.' "'.$value_data.'""');
            $this->session->set_flashdata('swal_message', 'Conference PIN 4 Party Added Successfully');
            redirect('Admin/Call_forward/Conference_pin/4');   

        }elseif($type[0]=="Conf8PWD"){

            $conference_pin6 = exec('sudo /usr/sbin/asterisk -rx "database put '.$data[1].' '.$key.' "'.$value_data.'""');
            $this->session->set_flashdata('swal_message', 'Conference PIN 8 Party Added Successfully');
            redirect('Admin/Call_forward/Conference_pin/8'); 

        }elseif($type[0]=="Conf16PWD"){

            $conference_pin16 = exec('sudo /usr/sbin/asterisk -rx "database put '.$data[1].' '.$key.' "'.$value_data.'""');
            $this->session->set_flashdata('swal_message', 'Conference PIN 16 Party Added Successfully');
            redirect('Admin/Call_forward/Conference_pin/16'); 
        }
    }
    /*Delete Conference Pin Data */
    if(isset($_POST['id'])){
      $key = $_POST['id'];
      $family_name = $_POST['family_name'];
      $del_asterisk = exec('sudo /usr/sbin/asterisk -rx "database del '.$family_name.' '.$key.' "');
      echo "success";
    }

    $this->data['subview']      = 'admin/call_forward/conference_pin';
    $this->load->view('_layout_main', $this->data); 

}
public function Speed_dial(){

    if(isset($_POST['ext_speed_dial_save'])){
      $count = count($_POST['ext_did']);
      $data    = explode("/",$_POST['ext_data'][0]);
      for ($i=0; $i <= $count -1; $i++) { 

        $ext_key     = $_POST['ext_did'][$i];
        $extesion_data  = $_POST['extension'][$i];
        $cmd4 = exec('sudo /usr/sbin/asterisk -rx "database put '.$data[1].' '.$ext_key.' "'. $extesion_data.'""');
      }
      $this->session->set_flashdata('swal_message', 'Extension Speed Dial Added Successfully');
      redirect('Admin/Call_forward/speed_dial/1');
    }
    if(isset($_POST['prefix_save'])){
   
      $prefix_data    = explode("/",$_POST['prefix_key_data'][0]);
      $count = count($_POST['pstn_prefix_no']);
      for ($i=0; $i <= $count -1; $i++) { 

        $prefix_key     = $_POST['pstn_prefix_no'][$i];
        $prefix_data_value  = $_POST['prefix_value_data'][$i];
        $cmd4 = exec('sudo /usr/sbin/asterisk -rx "database put '.$prefix_data[1].' '.$prefix_key.' "'. $prefix_data_value.'""');
     }
     $this->session->set_flashdata('swal_message', 'PSTN Prefix Speed Dial Added Successfully');
     redirect('Admin/Call_forward/speed_dial/3');
    }

    if(isset($_POST['pstn_save'])){
   
      $pstn_data    = explode("/",$_POST['pstn_key_data'][0]);
      $count = count($_POST['pstn_no']);
      for ($i=0; $i <= $count -1; $i++) { 

        $pstn_key     = $_POST['pstn_no'][$i];
        $pstn_data_value  = $_POST['pstn_value_data'][$i];
        $cmd4 = exec('sudo /usr/sbin/asterisk -rx "database put '.$pstn_data[1].' '.$pstn_key.' "'. $pstn_data_value.'""');
        
     }
     $this->session->set_flashdata('swal_message', 'PSTN Speed Dial Added Successfully');
     redirect('Admin/Call_forward/speed_dial/2');
    }

    if(isset($_POST['id'])){
      $key = $_POST['id'];
      $family_name = $_POST['family_name'];
      $del_asterisk = exec('sudo /usr/sbin/asterisk -rx "database del '.$family_name.' '.$key.' "');
      echo "success";
    }
    $this->data['subview']  = 'admin/call_forward/speed_dial';
    $this->load->view('_layout_main', $this->data); 

}

}
?>
