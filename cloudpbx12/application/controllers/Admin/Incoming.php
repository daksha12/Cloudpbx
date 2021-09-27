<?php

class Incoming extends User_Controller
{

public function __construct()
{
 parent::__construct();
}

public function inbound_plan()
{

/// DID TRUNK ROUT ///
$this->db->select('*'); 
$this->db->from('did_details');
$this->db->where('tenant_id',$_SESSION['user_id']);
if($_SESSION['site_id'] != 'All'){
 $this->db->where('site_id',$_SESSION['site_id']);
}
$this->db->where('did_type','extensions');
$query = $this->db->get();
$did_ivr   = $query->result();


$this->data['did_ivr'] = $did_ivr;

/// DID IVR ROUTING ///
$this->db->select('*'); 
$this->db->from('did_routing_ivr');
$this->db->where('tenant_id',$_SESSION['user_id']);
if($_SESSION['site_id'] != 'All'){
 $this->db->where('site_id',$_SESSION['site_id']);
}
$this->db->group_by('off_days,off_start,off_end,did');
$query = $this->db->get();
$ivr   = $query->result();

$this->data['ivr'] = $ivr;

$this->data['subview'] = 'admin/incoming/inbound_routing';	
$this->load->view('_layout_main', $this->data);  

} // end function

public function block_number()
{
 $this->data['subview'] = 'admin/incoming/block_number';
 $this->load->view('_layout_main', $this->data);   
}

}
?>
