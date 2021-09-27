<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crm_api extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function branch()
	{
		if(!isset($_POST['ip'], $_POST['token'])) {
		  $er = array('status' => 404,'msg'=> 'Bed Request');			
		  echo json_encode($er);
		  exit(0); 
		}

		$ip    = $this->input->get_post('ip');
		$token = $this->input->get_post('token');

		$ip_valid = get_token_ip($ip,$token);
		if($ip_valid == 0){
		  $er = array('status' => 404,'msg'=> 'IP and Token Not Valid');			
		  echo json_encode($er);
		  exit(0);
		}
	  echo $site = $this->Report_m->api_tenant_site($token);
	}

	public function cdr()
	{
		if(!isset($_POST['ip'], $_POST['token'],$_POST['branch'],$_POST['start_date'],$_POST['end_date'])) {
		  $er = array('status' => 404,'msg'=> 'Bed Request');			
		  echo json_encode($er);
		  exit(0); 
		}

		$ip     = $this->input->get_post('ip');
		$token  = $this->input->get_post('token');
		$branch = $this->input->get_post('branch');
		$start  = $this->input->get_post('start_date');
		$end    = $this->input->get_post('end_date');
		$recipient    = $this->input->get_post('recipient');

		$ip_valid = get_token_ip($ip,$token);
		if($ip_valid == 0){
		  $er = array('status' => 404,'msg'=> 'IP and Token Not Valid');			
		  echo json_encode($er);
		  exit(0);
		}

		echo $cdr = $this->Report_m->api_site_cdr($token,$branch,$start,$end,$recipient);
		
	}

	public function hangup() 
	{
		if(!isset($_POST['ip'], $_POST['token'])) {
		  $er = array('status' => 404,'msg'=> 'Bed Request');			
		  echo json_encode($er);
		  exit(0); 
		}

		$ip          = $this->input->get_post('ip');
		$token       = $this->input->get_post('token');
		$extension   = $this->input->get_post('extension');
		$branch      = $this->input->get_post('branch_name');

		$ip_valid = get_token_ip($ip,$token);
		if($ip_valid == 0){
		  $er = array('status' => 404,'msg'=> 'IP and Token Not Valid');			
		  echo json_encode($er);
		  exit(0);
		}

		$this->db->select('*');
		$this->db->where('token_number',$token);
		$this->db->from('crm_config');
		$query  = $this->db->get();
		$result = $query->row();
		$tenant_name = $result->tenant_name;


 	    $channels = exec("asterisk -rx 'core show channels concise' | grep ".$extension." | grep ".$branch." | grep ".$tenant_name." |  cut -d'!' -f1");
		
		if($channels != ''){
		 $cut = exec('asterisk -rx "hangup request '.$channels.'"');
	
		 $res = explode("'", $cut);
		 if($res['1'] == $channels){

		  $sus = array('status' => 200,'msg'=> 'Call Hangup');			
		  echo json_encode($sus);

		 }else{

		  $sus = array('status' => 404,'msg'=> 'Call Not Hangup');			
		  echo json_encode($sus);	
		 }

		}else{
		  $sus = array('status' => 404,'msg'=> 'Channel not active');			
		  echo json_encode($sus);		
		}

	}


}
