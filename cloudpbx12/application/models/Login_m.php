<?php 

class Login_m extends MY_Model
{
protected $_table_name = 'login_details';
protected $_order_by = 'id';

public function __construct()
{
 parent::__construct();
}

public $rules_login = 
array(
'username' => array(
'field' => 'username', 
'label' => 'Username', 
'rules' => 'trim|xss_clean|required'
), 
'password' => array(
'field' => 'password', 
'label' => 'Password', 
'rules' => 'trim|required|xss_clean'
),	
);	
public function login(){

$user = $this->get_by(array(
'username' => $this->input->post('username'),//this->input->post('username'),
'password' => $this->hash($this->input->post('password')),		
), TRUE);		

if (count($user)) {			

if($user->user_type == 'Admin'){

if($user->time_zone == ''){
	$time_zone = time_zone;
	$def = 'Y';
}else{
	$time_zone = $user->time_zone;
}

if($def != 'Y'){
 $time_zone = $time_zone[0].$time_zone[1].$time_zone[2].':'.$time_zone[3].$time_zone[4];
}

 /**** SITE DETAILS *****/
 $this->db->select('*');
 $this->db->from($user->username.'_site');
 $query  = $this->db->get();
 $site   = $query->result();
 $count  = count($site);
 if($count > 1){
   $site_id   = 'All'; 
   $site_name = 'All';
 }else{
   $site_id   = $site[0]->id;	
   $site_name = $site[0]->site_name;
 }

}

$data = array(
'user_type'     => $user->user_type,
'user_id'       => $user->id,
'username'      => $user->username,
'password'      => $this->input->post('password'),
'account_id'    => $user->account_id,
'tenant_site'   => $user->username.'_site',
'site_id'       => $site_id,
'site_name'     => $site_name,
'tenant_extensions' => $user->username.'_extensions',
'time_zone'     => $time_zone,
'pass_reset'    => $user->force_password_reset,
'loggedin' 	    => TRUE,
);


$set  = $this->session->set_userdata($data);

return TRUE;
}
else{
return FALSE;
exit(0);
}

}

public function agentlogin(){

if(isset($_POST['submit'])){

$username = $_POST['username'];
$password = $this->hash($_POST['password']);

$data = explode("@",$username);
$com  = explode(".",$data[1]);

$this->db->select('*');
$this->db->from('login_details');
$this->db->where('username',$com[0]);
$query  = $this->db->get();
$tenat  = $query->row();

if(count($tenat)) {

/**** TENANT INFO ****/	
$this->db->select('*');
$this->db->from($com[0].'_extensions');
$this->db->where('username',$username);
$this->db->where('password',$password);
$query  = $this->db->get();
$agentlogin = $query->row();

if (count($agentlogin)) {

/*** SITE ZONE ****/
 $this->db->select('*');
 $this->db->from($tenat->username.'_site');
 $this->db->where('id',$agentlogin->site_id);
 $query  = $this->db->get();
 $site   = $query->row();
 
if($agentlogin->vm_timezone == ''){

 $time_zone = $site->cdr_timezone;

 if($time_zone == '')
 {
 	$time_zone = $tenat->time_zone;
	
 	if($time_zone == ''){
	  $time_zone = time_zone;
	  $def = 'Y';
    }
 }
}else{
	$time_zone = $agentlogin->vm_timezone; 
}

if($def != 'Y'){
 $time_zone = $time_zone[0].$time_zone[1].$time_zone[2].':'.$time_zone[3].$time_zone[4];
}

$data = array(
'user_type'     => 'Agent',
'user_id'       => $tenat->id,
'tenant_name'   => $tenat->username,
'site_id'       => $agentlogin->site_id,
'site_name'     => $site->site_name,
'account_id'    => $agentlogin->account_id,
'agent_id'      => $agentlogin->id,
'extension'     => $agentlogin->extension,
'username'      => $agentlogin->username,
'password'      => $_POST['password'],
'tenant_site'   => $tenat->username.'_site',
'tenant_extensions' => $tenat->username.'_extensions',
'time_zone'     => $time_zone,	
'pass_reset'    => $agentlogin->force_password_reset,
'loggedin' 	    => TRUE,
);				

$set  = $this->session->set_userdata($data);
return TRUE;
}
else{
return FALSE;
exit(0);
}
}else{
return FALSE;
exit(0);
}
} // isset end
}

public function logout ()
{	
unset($_SESSION['username']);
unset($_SESSION['user_type']);
unset($_SESSION['password']);
unset($_SESSION['account_code']);
unset($_SESSION['user_id']);
unset($_SESSION['pass_reset']);
unset($_SESSION['extension']);
unset($_SESSION['time_zone']);
unset($_SESSION['site_id']);
unset($_SESSION['site_name']);
}

public function agentlogout ()
{	
unset($_SESSION['username']);
unset($_SESSION['user_type']);
unset($_SESSION['agent_pass']);
unset($_SESSION['account_id']);
unset($_SESSION['user_id']);
unset($_SESSION['pass_reset']);
unset($_SESSION['extension']);
unset($_SESSION['time_zone']);
unset($_SESSION['site_id']);
unset($_SESSION['site_name']);
}

public function loggedin ()
{
return (bool) $this->session->userdata('loggedin');
}

public function hash ($string)
{
return hash('sha512', $string . config_item('encryption_key'));
}
}