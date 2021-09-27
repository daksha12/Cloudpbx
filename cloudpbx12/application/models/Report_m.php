<?php 
/****/
class Report_m  extends MY_Model
{
protected $_table_name = '';
protected $_order_by = '';

public function __construct()
{
 parent::__construct();
}


/****** TENANT WISE REPORT EXT *******/
public function get_tenant_ext($id = null,$search = null,$data =null,$start=null,$end=null,$sEcho=null) {
$this->db->select($_SESSION['tenant_extensions'].'.*,'.$_SESSION['tenant_site'].'.site_name');
$this->db->from($_SESSION['tenant_extensions']);
$this->db->join($_SESSION['tenant_site'],$_SESSION['tenant_site'].'.id = '.$_SESSION['tenant_extensions'].'.site_id');
if($id != ''){
$this->db->where($_SESSION['tenant_extensions'].'.id',$id);
}
if($_SESSION['site_id'] != 'All'){
$this->db->where('site_id',$_SESSION['site_id']);
}
$where = '(extension LIKE "%'.$search.'%" OR display_name LIKE "%'.$search.'%" OR site_name LIKE "%'.$search.'%" OR outbound_did LIKE "%'.$search.'%" OR vm_email LIKE "%'.$search.'%")';
$this->db->where($where);

$num_rows = $this->db->count_all_results('',false);
$this->db->limit($end,$start);

$query  = $this->db->get();
$result = $query->result();

if($data != 'All'){

/*** GET PREFIX ***/
$prefix = $this->Report_m->get_prefix_old();
/*** GET PREFIX ***/

$array_result = array();
foreach ($result as $key => $value) {             
$array_result[$key]['id']               = $value->id;
$array_result[$key]['extension']        = $value->extension;
$array_result[$key]['display_name'] 	 = $value->display_name;
$array_result[$key]['site_name']        = $value->site_name;
$array_result[$key]['extension_status'] = get_ext_status('8'.$value->extension,$value->site_name);
$array_result[$key]['mobile_status']    = get_ext_status('7'.$value->extension,$value->site_name);
$array_result[$key]['desktop_status']   = get_ext_status('6'.$value->extension,$value->site_name);
$array_result[$key]['vm_email']         = $value->vm_email;
$array_result[$key]['outbound_did']     = $value->outbound_did;

/****** GET PBX PASSWORD ******/
$path     = '/etc/asterisk/bizRTCPBX/'.$_SESSION['username'].'/sip_'.$_SESSION['username'].'_'.$value->site_name.'_'.$value->extension.'_user.conf';
$data     = parse_ini_file($path,true);
$pbx_pass = $data['8'.$value->extension.'-'.$value->site_name.'-'.$_SESSION['username']]['secret'];
/****** GET PBX PASSWORD ******/
$array_result[$key]['password'] = $pbx_pass;

}

$response = ["sEcho" => $sEcho,
"iTotalRecords" => $num_rows,
"iTotalDisplayRecords" => $num_rows,
"aaData" => $array_result];  
}else{
$response = ["sEcho" => $sEcho,
"iTotalRecords" => $num_rows,
"iTotalDisplayRecords" => $num_rows,
"aaData" => $result];  	
} 

return $response;
}

/****** TENANT WISE REPORT SITE *******/
public function get_tenant_site($id = null,$search = null,$data = null) {
$this->db->select($_SESSION['tenant_site'].'.*,trunk_master.trunk_name');
$this->db->from($_SESSION['tenant_site']);
$this->db->join('trunk_master',$_SESSION['tenant_site'].'.trunk_id = trunk_master.id');
if($id != ''){
$this->db->where($_SESSION['tenant_site'].'.id',$id);
}
if($_SESSION['site_id'] != 'All'){
$this->db->where($_SESSION['tenant_site'].'.id',$_SESSION['site_id']);
}
$where = '(site_name LIKE "%'.$search.'%" OR did LIKE "%'.$search.'%" OR trunk_name LIKE "%'.$search.'%" OR moh LIKE "%'.$search.'%")';
$this->db->where($where);
$query  = $this->db->get();
$result = $query->result();

if($data != 'All'){
$array_result = array();
foreach ($result as $key => $value) {             
$array_result[$key]['site_name']     = $value->site_name;
$array_result[$key]['moh'] 		    = $value->moh;
$array_result[$key]['trunk_name']    = $value->trunk_name;
$array_result[$key]['no_ext']        = get_site_no_ext($value->id);
$array_result[$key]['branch_prefix'] = $value->branch_prefix;
$array_result[$key]['did']           = $value->did;
$array_result[$key]['id']   		    = $value->id;
}
return $array_result;
}else{
return $result;
}
}
/****** TENANT WISE REPORT *******/

/****** TENANT WISE REPORT CDR *******/
public function get_cdr($code,$ext,$search = null,$start=null,$end=null,$sEcho=null) {

$this->db->select('id,src,dst,SUBSTRING_INDEX(SUBSTRING_INDEX(dstchannel,"/",-1),"-",1) as dst_in,billsec,recordingfile,disposition,CONVERT_TZ (calldate, "'.time_zone.'","'.$_SESSION['time_zone'].'") as call_date,SUBSTR(SUBSTRING_INDEX(SUBSTRING_INDEX(channel,"/",-1),"-",1),2) as ex_src,did');
$this->db->from('cdr');
$this->db->where('accountcode',$code);
$this->db->where('lastapp','Dial');

if($_SESSION['user_type'] == 'Admin'){
 $this->db->like('dcontext',$_SESSION['username']);
}else{
 $this->db->like('dcontext',$_SESSION['tenant_name']);
}

if($ext != ''){
$where = '(src like "%'.$ext.'%" OR SUBSTRING_INDEX(SUBSTRING_INDEX(dstchannel,"/",-1),"-",1) like "%'.$ext.'%")';
$this->db->where($where);
}
if($_SESSION['site_id'] != 'All'){
$where = "(SUBSTRING_INDEX(SUBSTRING_INDEX(dcontext,'_',2),'_',-1) = '".$_SESSION['site_name']."')";
$this->db->where($where);
}

$where_date = "DATE_FORMAT(calldate,'%Y-%m-%d') between '".$_SESSION['fromdate']."' AND '".$_SESSION['todate']."'";
$this->db->where($where_date);
$where = '(calldate LIKE "%'.$search.'%" OR src LIKE "%'.$search.'%" OR dst LIKE "%'.$search.'%" OR billsec LIKE "%'.$search.'%" OR disposition LIKE "%'.$search.'%")';
$this->db->where($where);

$num_rows = $this->db->count_all_results('',false);

if($end != ''){
 $this->db->limit($end,$start);
}

$query  = $this->db->get();
$result = $query->result();

$array_result = array();

foreach ($result as $key => $cdr_value) {            

$user = get_ext_details($cdr_value->src);
if($user == 0){

	$user_ext = get_ext_details($cdr_value->ex_src);
	if($user_ext == 0){
	   $dst = substr($cdr_value->dst_in, 1);
	   if($dst == ''){
		  $dst = $cdr_value->dst;
		  $src = $cdr_value->src;
	   }
	}else{
	 $dst = $cdr_value->dst;
	 $src = $cdr_value->ex_src;
	}	 
}else{
 $dst = $cdr_value->dst;
 $src = $cdr_value->src;
}

$array_result[$key]['id']            = $cdr_value->id;
$array_result[$key]['src']           = $src;
$array_result[$key]['dst']           = $dst;
$sectime = (floor($cdr_value->billsec / 3600).":".floor(($cdr_value->billsec / 60) % 60).":".$cdr_value->billsec % 60);		
$array_result[$key]['billsec']       = date('H:i:s',strtotime($sectime));
$array_result[$key]['recordingfile'] = $cdr_value->recordingfile;
$array_result[$key]['disposition']   = $cdr_value->disposition;
$array_result[$key]['call_date']     = $cdr_value->call_date;
$array_result[$key]['did']           = $cdr_value->did;
}

$response = ["sEcho" => $_GET['sEcho'],
"iTotalRecords" => $num_rows,
"iTotalDisplayRecords" => $num_rows,
"aaData" => $array_result];  

return $response;
}

/****** TENANT WISE REPORT BLOCK NUMBER *******/
public function get_block_number($id,$type) {
$this->db->select('*');
$this->db->where('tenant_id',$_SESSION['user_id']);
$this->db->where('type',$type);
if($_SESSION['site_id'] != 'All'){
$this->db->where('site_id',$_SESSION['site_id']);
}

$this->db->from('block_number');
$query  = $this->db->get();
$result = $query->result();
return $result;
}


/****** TENANT WISE REPORT BLOCK NUMBER *******/
public function get_tenant_info() {
$this->db->select('*');
$this->db->where('id',$_SESSION['user_id']);
$this->db->from('login_details');
$query  = $this->db->get();
$result = $query->row();
return $result;
}

/****** TENANT WISE SAELS DETAILS *******/
public function get_sales_info($code) {
$this->db->select('*');
$this->db->where('account_code',$code);
$this->db->where('user_type','sales');
$this->db->from('sales_details');
$query  = $this->db->get();
$result = $query->row();
return $result;
}

/****** TENANT WISE PREFIX *******/
public function get_prefix() {
$this->db->select('*');
$this->db->from('prefix_number');
$query  = $this->db->get();
$result = $query->row();
return $result;
}

public function get_prefix_old() {
$this->db->select('*');
$this->db->from('prefix_number_old');
$query  = $this->db->get();
$result = $query->row();
return $result;
}


public function get_phone_company($tenant_id){
 $this->db->select('*');
 $this->db->from('phone_company');
 $this->db->where('tenant_id',$tenant_id); 
 $query  = $this->db->get();
 $result = $query->result();
 return $result;
}

public function get_phone_family($tenant_id){
 $this->db->select('*');
 $this->db->from('phone_family');
 $this->db->where('tenant_id',$tenant_id); 
 $query  = $this->db->get();
 $result = $query->result();
 return $result;
}

public function get_phone_template($tenant_id){
 $this->db->select('*');
 $this->db->from('phone_template');
 $this->db->where('tenant_id',$tenant_id); 
 $query  = $this->db->get();
 $result = $query->result();
 return $result;
}

public function get_phone_provisioning($tenant_id,$site_id){
 $this->db->select('*');
 $this->db->from('phone_provisioning');
 $this->db->where('tenant_id',$tenant_id); 
 $this->db->where('site_id',$site_id); 
 $query  = $this->db->get();
 $result = $query->result();
 return $result;
}


/****** TENANT WISE PREFIX *******/
public function sql_data_get($key) {

// connection//	
$db = new SQLite3('/var/lib/asterisk/astdb.sqlite3', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);

$statement = $db->prepare('SELECT * FROM "astdb" where key like "%'.$key.'%"');
$result    = $statement->execute();
$row       = $result->fetchArray();
return $row;

}


/****** TENANT WISE REPORT SITE *******/
public function api_tenant_site($token) {

$this->db->select('*');
$this->db->where('token_number',$token);
$this->db->from('crm_config');
$query  = $this->db->get();
$result = $query->row();
$name = $result->tenant_name;

$this->db->select('*');
$this->db->from($name.'_site');
$query  = $this->db->get();
$result = $query->result();

$array_result = array();
foreach ($result as $key => $value) {             
$array_result[$key]['tenant_name']   = $name;
$array_result[$key]['branch_id']     = $value->id;
$array_result[$key]['branch_name'] 	 = $value->site_name;
}

 if(count($array_result) > 0){
  $json = array('status' => 200,'Data' => $array_result);
 }else{
  $json = array('status' => 200,'msg' => 'Branch no available');
 }

 return json_encode($json);	

}
/****** TENANT WISE REPORT *******/


/****** TENANT WISE REPORT CDR *******/
public function api_site_cdr($token,$branch,$start,$end,$recipient=null) {

$this->db->select('*');
$this->db->where('token_number',$token);
$this->db->from('crm_config');
$query  = $this->db->get();
$result = $query->row();
$tenant_name   = $result->tenant_name;
$code = $result->account_code;

////// CHECK BRANCH /////
$this->db->select('*');
$this->db->where('site_name',$branch);
$this->db->from($tenant_name.'_site');
$query  = $this->db->get();
$result = $query->row();
if(count($result) == 0){
 $json = array('status' => 404,'msg' => 'Branch name not Available');
 return json_encode($json);	
 exit(0);
}
////////////////////////

$this->db->select('id,src,dst,SUBSTRING_INDEX(SUBSTRING_INDEX(dstchannel,"/",-1),"-",1) as dst_in,billsec,recordingfile,disposition,calldate');
$this->db->from('cdr');
$this->db->where('accountcode',$code);
$this->db->where('lastapp','Dial');
$this->db->like('dcontext',$tenant_name);

if($recipient != ''){
$where = '(src like "%'.$recipient.'%" OR dst like "%'.$recipient.'%" OR SUBSTRING_INDEX(SUBSTRING_INDEX(dstchannel,"/",-1),"-",1) like "%'.$recipient.'%")';
$this->db->where($where);
}

$where = "(SUBSTRING_INDEX(SUBSTRING_INDEX(dcontext,'_',2),'_',-1) = '".$branch."')";
$this->db->where($where);

$where_date = "DATE_FORMAT(calldate,'%Y-%m-%d %H:%i:%s') between '".$start."' AND '".$end."'";
$this->db->where($where_date);


$query  = $this->db->get();
$result = $query->result();

$array_result = array();

foreach ($result as $key => $cdr_value) {            

 $this->db->select('count(*) as total');  
 $this->db->where('extension',$cdr_value->src);
 $this->db->from($tenant_name.'_extensions');
 $query =  $this->db->get();
 $result =  $query->row();
 $user = $result->total;

if($user == 0){
$dst = substr($cdr_value->dst_in, 1);
 if($dst == ''){
  $dst = $cdr_value->dst;
 }
}else{
$dst = $cdr_value->dst;
}

$array_result[$key]['branch']     = $branch;
$array_result[$key]['calldate']      = $cdr_value->calldate;
$array_result[$key]['caller']        = $cdr_value->src;
$array_result[$key]['recipient']     = $dst;
$sectime = (floor($cdr_value->billsec / 3600).":".floor(($cdr_value->billsec / 60) % 60).":".$cdr_value->billsec % 60);		
$array_result[$key]['call_duration'] = date('H:i:s',strtotime($sectime));
$array_result[$key]['recordingfile'] = ccs_recording_path.$tenant_name.'/'.$cdr_value->recordingfile;
$array_result[$key]['disposition']   = $cdr_value->disposition;

}

if(count($array_result) > 0){
  $json = array('status' => 200,'Data' => $array_result);	
}else{
  $json = array('status' => 200,'msg' => 'No CDR Record Available');
}

 return json_encode($json);
}
/***************************************/

}

?>
