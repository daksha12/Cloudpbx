<?php
function isLoginSessionExpired() {
	$login_session_duration = round($this->config->config['sess_expiration'] / 60,4); 
	$to_time = strtotime(date("Y-m-d H:i:s"));
	$from_time = strtotime($_SESSION['loggedin_time']);
	echo $difference_min=round(abs($to_time - $from_time) / 60,1);
	if(isset($_SESSION['loggedin_time']) and isset($_SESSION["username"])){  
		if($difference_min > $login_session_duration){ 
			return true; 
		} 
	}
	return false;
}
function get_valid_account($code,$name)
{
	$CI =& get_instance();

	$CI->db->select('*');  
	$CI->db->where('account_code',$code);	
	$CI->db->from('account_details');
	$query =  $CI->db->get();
	$result =  $query->row();
	if(count($result)){
	 $id = $result->id;	
	}else{
		return 0;
		exit(0);
	}
	

	$CI->db->select('*');  
	$CI->db->where('tenant_name',$name);	
	$CI->db->where('account_id',$id);	
	$CI->db->from('login_details');
	$query =  $CI->db->get();
	$result =  $query->row();
	if(count($result)){
		return 1;
	}else{
		return 0;
	}

}

/**** TENAT WISE *****/
function get_all_tenant($id = null) {

$CI =& get_instance();

$CI->db->select('*');  
if($id != ''){
$CI->db->where('id',$id);	
}
$CI->db->from('login_details');
$query =  $CI->db->get();
$result =  $query->result();
return $result;
}

function get_extension($branch_id) {

	$CI =& get_instance();
	$CI->db->select('*');  
	$CI->db->from($_SESSION['tenant_extensions']);
	$CI->db->where('site_id', $branch_id);
	$query =  $CI->db->get();
	$result =  $query->result();
	if (count($result)) {
	 return $result;
	}else{
	 return "";
	}
}


function get_prov_extension($branch_id) {

	$CI =& get_instance();
	$CI->db->select('*');  
	$CI->db->from($_SESSION['tenant_extensions']);
	$CI->db->where('site_id', $branch_id);
	$where = 'extension NOT IN (select extension from phone_provisioning where site_id= "'.$branch_id.'")';
	$CI->db->where($where);
	$query =  $CI->db->get();
	$result =  $query->result();
	if (count($result)) {
	 return $result;
	}else{
	 return "";
	}
}

/**** TENAT WISE *****/
function get_crm_ip($code,$name) {

$CI =& get_instance();

$CI->db->select('*');  
$CI->db->where('account_code',$code);	
$CI->db->where('tenant_name',$name);	
$CI->db->from('crm_config');
$query =  $CI->db->get();
$result =  $query->row();
return $result;

}

/**** TENAT WISE *****/
function get_token_ip($ip,$token) {

$CI =& get_instance();

$CI->db->select('*');  
$CI->db->where('crm_ip',$ip);
$CI->db->where('token_number',$token);
$CI->db->from('crm_config');
$query =  $CI->db->get();
$result =  $query->row();
if (count($result)) {
return 1;
}else{
return 0;
}
}

/**** TENAT WISE *****/
function get_timezone($time) {

$CI =& get_instance();

$time = $time[0].$time[1].$time[2].':'.$time[3].$time[4];

$CI->db->select('*');  
$CI->db->like('name',$time);
$CI->db->from('timezones');
$query =  $CI->db->get();
$result =  $query->row();
if (count($result)) {
return $result->timezone;
}else{
return "";
}
}


/**** TENAT WISE *****/
function get_tenant_id($name) {

$CI =& get_instance();

$CI->db->select('*');  
$CI->db->where('username',$name);
$CI->db->from('login_details');
$query =  $CI->db->get();
$result =  $query->row();
if (count($result)) {
return $result->id;
}else{
return "";
}
}


/**** PREFIX NUMBER  *****/
function prefix_number() {

$CI =& get_instance();

$CI->db->select('*');  
$CI->db->from('prefix_number');
$query =  $CI->db->get();
$result =  $query->row();
return $result;
}

/**** PREFIX NUMBER  *****/
function prefix_number_old() {

$CI =& get_instance();

$CI->db->select('*');  
$CI->db->from('prefix_number');
$query =  $CI->db->get();
$result =  $query->row();
return $result;
}

/**** TENAT WISE *****/
function get_site_id($name,$table) {

$CI =& get_instance();

$CI->db->select('*');  
$CI->db->where('site_name',$name);
$CI->db->from($table);
$query =  $CI->db->get();
$result =  $query->row();
if (count($result)) {
return $result->id;
}else{
return "";
}
}

/**** TENAT WISE *****/
function get_trunk($name) {

$CI =& get_instance();

$CI->db->select('*');  
$CI->db->where('trunk_name',$name);
$CI->db->from('trunk_master');
$query =  $CI->db->get();
$result =  $query->row();
if (count($result)) {
return $result->id;
}else{
return "";
}
}

/**** TENAT WISE *****/
function get_sites_details($id = null) {

$CI =& get_instance();
$CI->db->select('*');  
if($id != null){
$CI->db->where('id',$id);
}
$CI->db->from($_SESSION['tenant_site']);
$query =  $CI->db->get();
$result =  $query->result();
if (count($result)) {
return $result;
}else{
return "";
}
}

/**** TENAT WISE *****/
function get_site_name($id) {

$CI =& get_instance();

$CI->db->select('*');  
$CI->db->where('id',$id);
$CI->db->from($_SESSION['tenant_site']);
$query  = $CI->db->get();
$result = $query->row();
if(count($result)) {
 return $result->site_name;
}else{
 return "";
}

}

/**** TENAT WISE *****/
function get_site_no_ext($id) {

 $CI =& get_instance();
 $CI->db->select('count(*) as total');  
 $CI->db->where('site_id',$id);
 $CI->db->from($_SESSION['tenant_extensions']);
 $query =  $CI->db->get();
 $result =  $query->row();
 return $result->total;
}

/**** TENAT WISE *****/
function get_ext_details($ext) {

 $CI =& get_instance();
 $CI->db->select('count(*) as total');  
 $CI->db->where('extension',$ext);
 $CI->db->from($_SESSION['tenant_extensions']);
 $query =  $CI->db->get();
 $result =  $query->row();
 return $result->total;
}

function get_account_code($id) {

$CI =& get_instance();

$CI->db->select('*');  
$CI->db->where('id',$id);
$CI->db->from('account_details');
$query =  $CI->db->get();
$result =  $query->row();
if (count($result)) {
return $result->account_code;
}else{
return "";
}
}

function get_account_sitekey($id) {

$CI =& get_instance();

$CI->db->select('*');  
$CI->db->where('id',$id);
$CI->db->from('account_details');
$query =  $CI->db->get();
$result =  $query->row();
if (count($result)) {
return $result->site_key_issued;
}else{
return "";
}
}


/**** TENAT WISE *****/
function get_did_number($id) {

$CI =& get_instance();

$CI->db->select('*');  
$CI->db->where('id',$id);
$CI->db->from('did_details');
$query =  $CI->db->get();
$result =  $query->row();
if (count($result)) {
return $result->did_number;
}else{
return "";
}
}

/**** TENAT WISE *****/
function get_conference_did() {

$CI =& get_instance();

$CI->db->select('*');  
$CI->db->where('tenant_id',$_SESSION['user_id']);
$CI->db->where('site_id	',$_SESSION['site_id']);
$CI->db->where('did_type','conference');
$CI->db->from('did_details');
$query =  $CI->db->get();
$result =  $query->row();
if (count($result)) {
return $result->did_number;
}else{
return "";
}
}

/**** TENAT WISE *****/
function get_trunk_name($id) {

$CI =& get_instance();

$CI->db->select('*');  
$CI->db->where('id',$id);
$CI->db->from('trunk_master');
$query =  $CI->db->get();
$result =  $query->row();
if (count($result)) {
return $result->trunk_name;
}else{
return "";
}
}

/**** TENAT WISE *****/
function get_ext_status($ext,$site_id) {

if($_SESSION['user_type'] != 'Admin'){
  $user =  $ext.'-'.$site_id.'-'.$_SESSION['tenant_name'];
 }else{
  $user =  $ext.'-'.$site_id.'-'.$_SESSION['username'];
 } 

$ext  = exec('/usr/sbin/asterisk -rx  "sip show peers" | grep "'.$user.'" | grep OK');

if($ext != ''){
 $status_ext = explode(" ",$ext);
 $ip      = $status_ext[1].':'.$status_ext[49].$status_ext[50].$status_ext[51].$status_ext[52];
} else {
 $ip      = '';
}
 return $ip;
}

function zipFilesAndDownload($file_names,$archive_file_name,$file_path)
{ 
$zip = new ZipArchive();
if ($zip->open($archive_file_name, ZIPARCHIVE::CREATE )!==TRUE) {
exit("cannot open <$archive_file_name>\n");
}
foreach($file_names as $files)
{
$zip->addFile($file_path.$files,$files);
}
$zip->close();
return $archive_file_name;          
}


function time_zone_convert($date = null){
    $CI =& get_instance();
	$system = time_zone;
	$datetime = $CI->db->query('SELECT CONVERT_TZ ("'.$date.'", "'.$system.'","'.$_SESSION['time_zone'].'") as time_zone');
	$zone = $datetime->row();
	return $zone->time_zone;	
}


function sqllite_data_get($key){
// connection//	
$db = new SQLite3('/var/lib/asterisk/astdb.sqlite3', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);

$statement = $db->prepare('SELECT * FROM "astdb" where key like "%'.$key.'%"');
$result    = $statement->execute();
$row       = $result->fetchArray();
return $row['value'];

}

function getTrunkList($tenant_id,$site_id=NULL) {

	$CI =& get_instance();

	$CI->db->select('*');  
	$CI->db->from('trunk_master');
	$CI->db->where('tenant_id', $tenant_id);
	if(!empty($site_id)){
	  $CI->db->where('site_id', $site_id);
	}

	$CI->db->where('deleted_at IS NULL');
	$query =  $CI->db->get();
	$result =  $query->result();

	if (count($result)) {
	 return $result;
	}else{
	 return "";
	}
}


function getE911List($tenant_id,$site_id=NULL) {

	$CI =& get_instance();

	$CI->db->select('*');  
	$CI->db->from('e911_master');
	$CI->db->where('tenant_id', $tenant_id);
	if(!empty($site_id)){
		$CI->db->where('site_id', $site_id);
	}
	$CI->db->where('deleted_at IS NULL');
	$query =  $CI->db->get();
	$result =  $query->result();

	if (count($result)) {
		return $result;
	}else{
		return "";
	}
}

function getE911ListExport($tenant_id) {

	$arrayName = array();

	$CI =& get_instance();

	$CI->db->select('*');  
	$CI->db->from('e911_master');
	$CI->db->where('tenant_id', $tenant_id);
	$CI->db->where('deleted_at IS NULL');
	$query =  $CI->db->get();
	$result =  $query->result();

	if (count($result)) {
	
		foreach ($result as $key => $value) {
			$arrayName[$key]['tenant_id'] = getUserNameByTenantId($value->tenant_id);
			$arrayName[$key]['site_id']   = get_site_name($value->site_id);
			$arrayName[$key]['trunk_did'] = $value->trunk_did;
			$arrayName[$key]['emergencyenable'] = $value->emergencyenable;
			$arrayName[$key]['emergencynumber'] = str_replace(',', '|', $value->emergencynumber);
			$arrayName[$key]['address1'] = $value->address1;
			$arrayName[$key]['address2'] = $value->address2;
			$arrayName[$key]['state']     = $value->state;
			$arrayName[$key]['city']     = $value->city;
			$arrayName[$key]['pincode']  = $value->pincode;
		}

		return $arrayName;
	}else{
		return "";
	}
}


function getPageList($tenant_id,$site_id=NULL) {

	$CI =& get_instance();

	$CI->db->select('*');  
	$CI->db->from('page_details');
	$CI->db->where('tenant_id', $tenant_id);
	if(!empty($site_id)){
		$CI->db->where('site_id', $site_id);
	}
	$CI->db->where('deleted_at IS NULL OR deleted_at = ""');
	$query =  $CI->db->get();
	$result =  $query->result();

	if (count($result)) {
		return $result;
	}else{
		return "";
	}
}

function getPageListExport($tenant_id) {

	$arrayName = array();

	$CI =& get_instance();

	$CI->db->select('*');  
	$CI->db->from('page_details');
	$CI->db->where('tenant_id', $tenant_id);
	$CI->db->where('deleted_at IS NULL OR deleted_at = ""');
	$query =  $CI->db->get();
	$result =  $query->result();

	if (count($result)) {
	
		foreach ($result as $key => $value) {
			$arrayName[$key]['tenant_id'] = getUserNameByTenantId($value->tenant_id);
			$arrayName[$key]['site_id']   = get_site_name($value->site_id);
			$arrayName[$key]['pagelistname'] = $value->pagelistname;
			$arrayName[$key]['pagecommand'] = $value->pagecommand;
			$arrayName[$key]['pagemembers'] = str_replace(',', '|', $value->pagemembers);
		}

		return $arrayName;
	}else{
		return "";
	}
}


function getPageSettingList($tenant_id,$site_id=NULL) {

	$CI =& get_instance();

	$CI->db->select('*');  
	$CI->db->from('page_setting');
	$CI->db->where('tenant_id', $tenant_id);
	if(!empty($site_id)){
		$CI->db->where('site_id', $site_id);
	}
	$CI->db->where('(deleted_at IS NULL OR deleted_at = "")');
	$query =  $CI->db->get();
	$result =  $query->result();

	if (count($result)) {
		return $result;
	}else{
		return "";
	}
}

function getPageSettingListExport($tenant_id) {

	$arrayName = array();

	$CI =& get_instance();

	$CI->db->select('*');  
	$CI->db->from('page_setting');
	$CI->db->where('tenant_id', $tenant_id);
	$CI->db->where('(deleted_at IS NULL OR deleted_at = "")');
	$query =  $CI->db->get();
	$result =  $query->result();

	if (count($result)) {
	
		foreach ($result as $key => $value) {
			$arrayName[$key]['tenant_id'] = getUserNameByTenantId($value->tenant_id);
			$arrayName[$key]['site_id']   = get_site_name($value->site_id);
			$arrayName[$key]['pageparameter'] = $value->pageparameter;
		}

		return $arrayName;
	}else{
		return "";
	}
}


function getTimeZoneList() {

	$CI =& get_instance();

	$CI->db->select('*');  
	$CI->db->from('timezones');
	$query =  $CI->db->get();
	$result =  $query->result();
	if (count($result)) {
		if(!empty($result)){
        	foreach ($result as $key => $timeZones) {
        		$name = $timeZones->name;
    			$end_pos  = strpos($name, ")");
    			$new_name = substr($name,1,$end_pos - 1);
    			$new_name = str_replace('GMT','', $new_name);
    			$time = str_replace(':','', $new_name);
        		$result[$key]->time = $time;
        	}        	
        }
		return $result;
	}else{
		return "";
	}
}

function getTenantList($account_id) {

	$CI =& get_instance();

	$CI->db->select('*');  
	$CI->db->from('login_details');
	$CI->db->where('account_id', $account_id);
	$query =  $CI->db->get();
	$result =  $query->result();
	if (count($result)) {
		return $result;
	}else{
		return "";
	}
}


function getTenantListDetails($account_id) {

	$CI =& get_instance();

	$CI->db->select('*');  
	$CI->db->from('login_details');
	$CI->db->where('account_id', $account_id);
	$query =  $CI->db->get();
	$result =  $query->row();
	if (count($result)) {
		return $result;
	}else{
		return "";
	}
}

function getUserNameByTenantId($tenant_id){
    $CI =& get_instance();

	$CI->db->select('*');  
	$CI->db->from('login_details');
	$CI->db->where('id', $tenant_id);;
	$query =  $CI->db->get();
	$result =  $query->row();
	if (count($result)) {
		return $result->username;
	}else{
		return "";
	}
}

function getBranchList($tenant_id) {

	$username = getUserNameByTenantId($tenant_id);
	$CI =& get_instance();

	if(!empty($username)){

	    $CI->db->select('*');  
		$CI->db->from($username.'_site');
		$CI->db->where('deleted_at IS NULL');
		$query =  $CI->db->get();
		$result =  $query->result();
		if (count($result)) {
			return $result;
		}else{
			return "";
		}
    }
}

function getBranchDetail($tenant_id,$branch_id) {

	$username = getUserNameByTenantId($tenant_id);
	$CI =& get_instance();

	if(!empty($username)){

	    $CI->db->select('*');  
		$CI->db->from($username.'_site');
		$CI->db->where('id', $branch_id);;
		$query =  $CI->db->get();
		$result =  $query->row();
		if (count($result)) {
			return $result;
		}else{
			return "";
		}
    }
}

function getExtensionList($tenant_id,$branch_id) {

	$username = getUserNameByTenantId($tenant_id);
	$CI =& get_instance();

	if(!empty($username)){

	    $CI->db->select('*');  
		$CI->db->from($username.'_extensions');
		$CI->db->where('site_id', $branch_id);
		$CI->db->where('deleted_at IS NULL');
		$query =  $CI->db->get();
		$result =  $query->result();
		if (count($result)) {
			return $result;
		}else{
			return "";
		}
    }
}

function getTrunkDidList($tenant_id,$branch_id) {

	$CI =& get_instance();

	if(!empty($tenant_id) && !empty($branch_id) ){

	    $CI->db->select('*');  
		$CI->db->from('did_details');
		$CI->db->where('tenant_id', $tenant_id);
		$CI->db->where('site_id', $branch_id);
		$CI->db->where('deleted_at IS NULL');
		$query =  $CI->db->get();
		$result =  $query->result();
		if (count($result)) {
			return $result;
		}else{
			return "";
		}
    }
}

function getBlockNumberList($tenant_id,$branch_id) {

	$CI =& get_instance();

	if(!empty($tenant_id) && !empty($branch_id) ){

	    $CI->db->select('*');  
		$CI->db->from('block_number');
		$CI->db->where('tenant_id', $tenant_id);
		$CI->db->where('site_id', $branch_id);
		$CI->db->where('deleted_at IS NULL');
		$query =  $CI->db->get();
		$result =  $query->result();
		if (count($result)) {
			return $result;
		}else{
			return "";
		}
    }
}

function getDidRoutingIVRGroup($tenant_id,$branch_id) {

	$CI =& get_instance();

	if(!empty($tenant_id) && !empty($branch_id) ){

	    $CI->db->select('dri.*,tm.trunk_name');  
		$CI->db->from('did_routing_ivr dri');
		$CI->db->join("trunk_master as tm ",'dri.trunk_id = tm.id','left');
		$CI->db->where('dri.tenant_id', $tenant_id);
		$CI->db->where('dri.site_id', $branch_id);
		$CI->db->where('dri.deleted_at IS NULL');		
		$CI->db->where('tm.deleted_at IS NULL');		
		$CI->db->group_by("code");
		$query =  $CI->db->get();
		$result =  $query->result();
		if (count($result)) {
			return $result;
		}else{
			return "";
		}
    }
}

function getDidRoutingIVRList($tenant_id,$site_id,$code){
	$CI =& get_instance();
	$CI->db->select('*'); 
	$CI->db->from('did_routing_ivr');
    $CI->db->where('tenant_id', $tenant_id);
    $CI->db->where('site_id', $site_id);
    $CI->db->where('code', $code);
    $CI->db->where('deleted_at IS NULL');
    $query =  $CI->db->get();
	$result =  $query->result();
	if (count($result)) {
		return $result;
	}else{
		return "";
	}
}

function get_account_detail($id) {

	$CI =& get_instance();

	$CI->db->select('*');  
	$CI->db->where('id',$id);
	$CI->db->where('deleted_at IS NULL');
	$CI->db->from('account_details');
	$query =  $CI->db->get();
	$result =  $query->row();
	if (count($result)) {
		return $result;
	}else{
		return "";
	}
}

function get_account_detail_id($id) {

	$CI =& get_instance();
	$CI->db->select('*');  
	$CI->db->where('id',$id);
	$CI->db->where('deleted_at IS NULL');
	$CI->db->from('account_details');
	$query  = $CI->db->get();
	$result = $query->row();
	if(count($result)) {
	  return $result->account_code;
	}else{
	  return "";
	}
}

function get_sales_detail($id, $user_type) {

	$CI =& get_instance();

	$CI->db->select('*');  
	$CI->db->where('id',$id);
	$CI->db->where('user_type',$user_type);
	$CI->db->where('deleted_at IS NULL');
	$CI->db->from('sales_details');
	$query =  $CI->db->get();
	$result =  $query->row();
	if (count($result)) {
		return $result;
	}else{
		return "";
	}
}

function get_tenant_detail($id) {

	$CI =& get_instance();

	$CI->db->select('*');  
	$CI->db->where('id',$id);
	$CI->db->from('login_details');
	$query =  $CI->db->get();
	$result =  $query->row();
	if (count($result)) {
		return $result;
	}else{
		return "";
	}
}

// Start Export CSV Functions
function getAccountData($account_id){

	$arrFinalDetails = array();
	$account_detail = get_account_detail($account_id);

	if(!empty($account_detail)){
	    // Get Sales Detail
        $sales_detail = get_sales_detail($account_detail->sales_id,'sales');

        // Get Technical Detail
        $technical_detail = get_sales_detail($account_detail->tech_id,'technical');

       // $arrFinalDetails = array();
        $arrFinalDetails[0]['account_code'] =  $account_detail->account_code;
        $arrFinalDetails[0]['organization_name'] =  $account_detail->organization_name;
        $arrFinalDetails[0]['address'] =  $account_detail->address;

        $arrFinalDetails[0]['BranchName'] =  '';
        $arrFinalDetails[0]['BranchAddress'] =  '';
        $arrFinalDetails[0]['Branchcontactperson'] =  '';
        $arrFinalDetails[0]['Branchcontactnumber'] =  '';
        $arrFinalDetails[0]['RequestExecutedBy'] =  '';

       
        $arrFinalDetails[0]['site_key_issued'] = (isset($account_detail->site_key_issued)) ? $account_detail->site_key_issued : '';        
        $arrFinalDetails[0]['technical_name'] = (isset($technical_detail->first_name)) ? $technical_detail->first_name : '';
        $arrFinalDetails[0]['technical_phone'] = (isset($technical_detail->phone)) ? $technical_detail->phone : '';        
        $arrFinalDetails[0]['sales_name'] = (isset($sales_detail->first_name)) ? $sales_detail->first_name : '';        
        $arrFinalDetails[0]['sales_phone'] = (isset($sales_detail->phone)) ? $sales_detail->phone : '';    
    }     
       
    return $arrFinalDetails;
}

function getTenantData($tenant_id,$account_id){

	$CI =& get_instance();

	$CI->db->select('tenant_name,email,address,contat_person,phone,country_code,time_zone'); 
	$CI->db->from('login_details');
    $CI->db->where('id', $tenant_id);
    $CI->db->where('account_id', $account_id);
    $CI->db->where('deleted_at IS NULL');
    $query = $CI->db->get();
	$result =  $query->row();
	if (count($result)) {
		return $result;
	}else{
		return "";
	}
}

function getTenantBranchData($tenant_id,$account_id){

	$tenant_detail = get_tenant_detail($tenant_id);
	$username      = $tenant_detail->username;
	$tenant_name   = $tenant_detail->tenant_name;
	$tenant_site   = $username."_site";
	$account_code  = get_account_code($account_id);

	$CI =& get_instance();

	//$CI->db->select("'$tenant_name' as tenant_name,ts.id,ts.site_name,'$account_code' as account_code,tm.trunk_name,ts.did,ts.branch_prefix,ts.moh,ts.country_code,ts.isd_allowed,ts.park_retreive,ts.park_extension,ts.parking_slot,ts.call_recording,ts.call_monitoring,ts.inter_branch,ts.cdr_timezone");
	$CI->db->select("'$tenant_name' as tenant_name,ts.site_name,'$account_code' as account_code,tm.trunk_name,ts.did,ts.branch_prefix,ts.moh,ts.country_code,ts.isd_allowed,ts.park_retreive,ts.park_extension,ts.parking_slot,ts.call_recording,ts.call_monitoring,ts.inter_branch,ts.cdr_timezone,ts.off_start,ts.off_end,ts.off_days");
	$CI->db->from("$tenant_site as ts");
	$CI->db->join("trunk_master as tm ",'ts.trunk_id = tm.id','left');	
	$CI->db->where('ts.deleted_at IS NULL');
	$CI->db->where('tm.deleted_at IS NULL');	
	$query  = $CI->db->get();
	
	$result = $query->result();
	if (count($result)) {
		return $result;
	}else{
		return "";
	}
}

function getTrunkData($tenant_id,$site_id=NULL){

	$tenant_detail = get_tenant_detail($tenant_id);
	$username      = $tenant_detail->username;
	$tenant_name   = $tenant_detail->tenant_name;
	$tenant_site   = $username."_site";

	$CI =& get_instance();

	$CI->db->select("'$tenant_name' as tenant_name,ts.site_name,tm.trunk_name,tm.trunk_did,tm.username,tm.password,tm.host,tm.port,tm.domain,tm.dtmf_mode,tm.nat,tm.directrtp,tm.register_trunk");
	$CI->db->from("trunk_master as tm");	
    $CI->db->where('tm.tenant_id', $tenant_id);   
    if(!empty($site_id)){    	
      $CI->db->where('tm.site_id', $site_id);   
    }
	$CI->db->join("$tenant_site as ts",'tm.site_id = ts.id');	
	$CI->db->where('tm.deleted_at IS NULL');	
	$CI->db->where('ts.deleted_at IS NULL');	
	$CI->db->group_by('trunk_did');	
	$query  = $CI->db->get();
	$result = $query->result();
	if (count($result)) {
		return $result;
	}else{
		return "";
	}
}


function getTrunkDataHost($tenant_id,$site_id=NULL){

	$tenant_detail = get_tenant_detail($tenant_id);
	$username      = $tenant_detail->username;
	$tenant_name   = $tenant_detail->tenant_name;
	$tenant_site   = $username."_site";

	$CI =& get_instance();

	$CI->db->select("'$tenant_name' as tenant_name,ts.site_name,tm.trunk_name,tm.trunk_did,tm.username,tm.password,tm.host,tm.port,tm.domain,tm.dtmf_mode,tm.nat,tm.directrtp,tm.register_trunk,tm.prefix,tm.failover,tm.ringduration,tm.cpe_ip,tm.d2e");
	$CI->db->from("trunk_master as tm");	
    $CI->db->where('tm.tenant_id', $tenant_id);   
    if(!empty($site_id)){    	
      $CI->db->where('tm.site_id', $site_id);   
    }
	$CI->db->join("$tenant_site as ts",'tm.site_id = ts.id');	
	$CI->db->where('tm.deleted_at IS NULL');	
	$CI->db->where('ts.deleted_at IS NULL');	
	$CI->db->group_by('tm.host');	
	$query  = $CI->db->get();
	$result = $query->result();
	if (count($result)) {
		return $result;
	}else{
		return "";
	}
}

function getExtensionData($tenant_id,$site_id=NULL){

	$tenant_detail = get_tenant_detail($tenant_id);
	$username = $tenant_detail->username;
	$tenant_name = $tenant_detail->tenant_name;
	$tenant_site = $username."_site";
	$tenant_extensions = $username."_extensions";

	$CI =& get_instance();

	//$CI->db->select("'$tenant_name' as tenant_name,ts.id,ts.site_name,te.extension_type,te.extension,te.display_name,te.voicemail_enabled,te.vm_email,te.vm_timezone,tm.trunk_name,te.outbound_did,te.isd_allowed,te.park_retrive,te.call_recording,te.call_monitoring,te.presence_blf,te.mobility,te.synergy,te.portal_access,te.mobile_number");
	$CI->db->select("'$tenant_name' as tenant_name,ts.site_name,te.extension_type,te.extension,te.display_name,te.voicemail_enabled,te.vm_email,te.vm_timezone,tm.trunk_name,te.outbound_did,te.isd_allowed,te.park_retrive,te.call_recording,te.call_monitoring,te.presence_blf,te.mobility,te.synergy,te.portal_access,te.mobile_number,te.audio_file,te.audio_avoid,tm.trunk_did");
	$CI->db->from("$tenant_extensions as te");
	$CI->db->join("$tenant_site as ts",'te.site_id = ts.id');	
	$CI->db->join("trunk_master as tm ",'te.trunk_id = tm.id','left');
	if(!empty($site_id)){    	
    	$CI->db->where('te.site_id', $site_id);   
    }
	$CI->db->where('te.deleted_at IS NULL');	
	$CI->db->where('ts.deleted_at IS NULL');	
	$query  = $CI->db->get();
	$result = $query->result();
	if (count($result)) {
		return $result;
	}else{
		return "";
	}
}
function getTrunkDIDData($tenant_id,$site_id=NULL){

	$tenant_detail = get_tenant_detail($tenant_id);
	$username = $tenant_detail->username;
	$tenant_name = $tenant_detail->tenant_name;
	$tenant_site = $username."_site";

	$CI =& get_instance();

	$CI->db->select("'$tenant_name' as tenant_name,ts.site_name,tm.trunk_name,dd.did_number,dd.extension,dd.did_number,dd.did_type,dd.call_type,tm.trunk_did");
	$CI->db->from("did_details as dd");
	$CI->db->where('dd.tenant_id', $tenant_id);   
	if(!empty($site_id)){    	
    	$CI->db->where('dd.site_id', $site_id);   
    }
	$CI->db->join("$tenant_site as ts",'dd.site_id = ts.id');	
	$CI->db->join("trunk_master as tm ",'dd.trunk_id = tm.id','left');
	$CI->db->where('dd.deleted_at IS NULL');	
	$CI->db->where('ts.deleted_at IS NULL');	
	$query  = $CI->db->get();
	$result = $query->result();
	if (count($result)) {
		return $result;
	}else{
		return "";
	}
}

function getIVRConfigData($tenant_id){

	$tenant_detail = get_tenant_detail($tenant_id);
	$username = $tenant_detail->username;
	$tenant_name = $tenant_detail->tenant_name;
	$tenant_site = $username."_site";

	$CI =& get_instance();

	$CI->db->select("'$tenant_name' as tenant_name,ts.site_name,tm.trunk_name,dr.did,dr.off_start,dr.off_end,dr.off_days,dr.IVR_Prompt_file,dr.ivr_level,dr.ringingseconds,dr.choice1,dr.choice2,dr.choice3,dr.choice4,,dr.choice5,dr.choice6,,dr.choice7,dr.choice8,,dr.choice9,dr.default_choice,dr.off_time_choice");
	$CI->db->from("did_routing_ivr as dr");
	$CI->db->where('dr.tenant_id', $tenant_id);   
	$CI->db->join("$tenant_site as ts",'dr.site_id = ts.id');	
	$CI->db->join("trunk_master as tm ",'dr.trunk_id = tm.id','left');
	$CI->db->where('dr.deleted_at IS NULL');	
	$CI->db->where('ts.deleted_at IS NULL');	
	$query  = $CI->db->get();
	$result = $query->result_array();
	if (count($result)) {
		return $result;
	}else{
		return "";
	}
}

function getIVRConfigDataDID($tenant_id){

	$tenant_detail = get_tenant_detail($tenant_id);
	$username      = $tenant_detail->username;
	$tenant_name   = $tenant_detail->tenant_name;
	$tenant_site   = $username."_site";

	$CI =& get_instance();

	$CI->db->select("'$tenant_name' as tenant_name,ts.site_name,tm.trunk_name,dr.did,dr.off_start,dr.off_end,dr.off_days,dr.IVR_Prompt_file,dr.ivr_level,dr.ringingseconds,dr.choice1,dr.choice2,dr.choice3,dr.choice4,,dr.choice5,dr.choice6,dr.choice7,dr.choice8,,dr.choice9,dr.choice1_type,dr.choice2_type,dr.choice3_type,dr.choice4_type,dr.choice5_type,dr.choice6_type,dr.choice7_type,dr.choice8_type,dr.choice9_type,dr.default_choice,dr.off_time_choice");
	$CI->db->from("did_routing_ivr as dr");
	$CI->db->where('dr.tenant_id', $tenant_id);   
	$CI->db->join("$tenant_site as ts",'dr.site_id = ts.id');	
	$CI->db->join("trunk_master as tm ",'dr.trunk_id = tm.id','left');
	$CI->db->where('dr.deleted_at IS NULL');	
	$CI->db->where('ts.deleted_at IS NULL');
	$CI->db->group_by('did,site_name');	
	$query  = $CI->db->get();
	$result = $query->result();
	if (count($result)) {
		return $result;
	}else{
		return "";
	}
}

function getIVRConfigLevel($tenant_id,$did){

	$tenant_detail = get_tenant_detail($tenant_id);
	$username = $tenant_detail->username;
	$tenant_name = $tenant_detail->tenant_name;
	$tenant_site = $username."_site";

	$CI =& get_instance();

	$CI->db->select("'$tenant_name' as tenant_name,ts.site_name,tm.trunk_name,dr.did,dr.off_start,dr.off_end,dr.off_days,dr.IVR_Prompt_file,dr.ivr_level,dr.ringingseconds,dr.choice1,dr.choice2,dr.choice3,dr.choice4,,dr.choice5,dr.choice6,dr.choice7,dr.choice8,,dr.choice9,dr.choice1_type,dr.choice2_type,dr.choice3_type,dr.choice4_type,dr.choice5_type,dr.choice6_type,dr.choice7_type,dr.choice8_type,dr.choice9_type,dr.default_choice,dr.off_time_choice");
	$CI->db->from("did_routing_ivr as dr");
	$CI->db->where('dr.tenant_id', $tenant_id);   
	$CI->db->where('dr.ivr_level !=', 'level1');   
	$CI->db->join("$tenant_site as ts",'dr.site_id = ts.id');	
	$CI->db->join("trunk_master as tm ",'dr.trunk_id = tm.id','left');
	$CI->db->where('dr.did',$did);	
	$CI->db->where('dr.deleted_at IS NULL');	
	$CI->db->where('ts.deleted_at IS NULL');	
	$query  = $CI->db->get();
	$result = $query->result();
	if (count($result)) {
		return $result;
	}else{
		return "";
	}
}

function getBlockNumber($tenant_id, $type){

	$tenant_detail = get_tenant_detail($tenant_id);
	$username = $tenant_detail->username;
	$tenant_name = $tenant_detail->tenant_name;
	$tenant_site = $username."_site";

	$CI =& get_instance();
	if($type == "IN"){
		$CI->db->select("'$tenant_name' as tenant_name,ts.site_name,bn.did,bn.number");
	}
	else {
		$CI->db->select("'$tenant_name' as tenant_name,ts.site_name,bn.number");
	}
	$CI->db->from("block_number as bn");
	$CI->db->where('bn.tenant_id', $tenant_id);   
	$CI->db->where('bn.type', $type);   
	$CI->db->join("$tenant_site as ts",'bn.site_id = ts.id');	
	$CI->db->where('bn.deleted_at IS NULL');	
	$CI->db->where('ts.deleted_at IS NULL');	
	$query  = $CI->db->get();
	$result = $query->result_array();
	if (count($result)) {
		return $result;
	}else{
		return "";
	}
}

function checkTrunkUsed($tenant_id, $site_id, $trunk_id){

	$CI =& get_instance();

	// Check Branch Exists 
	$tenant_detail = get_tenant_detail($tenant_id);
	$username = $tenant_detail->username;
	$tenant_site = $username."_site";
	$tenant_extensions = $username."_extensions";

	// check in Branch 
	$CI->db->select('*');  
	$CI->db->from($tenant_site);
	$CI->db->where('trunk_id', $trunk_id);
	$CI->db->where('deleted_at IS NULL');
	$query =  $CI->db->get();
	$result =  $query->result();
	if (count($result)) {
		return true;
	}

	// Check in extensions
	$CI->db->select('*');  
	$CI->db->from($tenant_extensions);
	$CI->db->where('trunk_id', $trunk_id);
	$CI->db->where('deleted_at IS NULL');
	$query =  $CI->db->get();
	$result =  $query->result();
	if (count($result)) {
		return true;
	}

	// check in did_details	
	$CI->db->select('*');  
	$CI->db->from("did_details");
	$CI->db->where('trunk_id', $trunk_id);
	$CI->db->where('site_id', $site_id);
	$CI->db->where('tenant_id', $tenant_id);
	$CI->db->where('deleted_at IS NULL');
	$query =  $CI->db->get();
	$result =  $query->result();
	if (count($result)) {
		return true;
	}

	// check in did_routing_ivr	
	$CI->db->select('*');  
	$CI->db->from("did_routing_ivr");
	$CI->db->where('trunk_id', $trunk_id);
	$CI->db->where('site_id', $site_id);
	$CI->db->where('tenant_id', $tenant_id);
	$CI->db->where('deleted_at IS NULL');
	$query =  $CI->db->get();
	$result =  $query->result();
	if (count($result)) {
		return true;
	}
	return false;	
}

function find_string ($string, $keyword, $body) {
  return substr_replace($string, PHP_EOL . $body, strpos($string, $keyword) + strlen($keyword), 0); 
}

function checkExtensionUsed($tenant_id, $site_id, $extension_id){

	$CI =& get_instance();

	// Get Extension number
	$tenant_detail = get_tenant_detail($tenant_id);
	$username = $tenant_detail->username;

	$CI->db->select('*');  
	$CI->db->from($username.'_extensions');
	$CI->db->where('id', $extension_id);
	$CI->db->where('deleted_at IS NULL');
	$query =  $CI->db->get();
	$result =  $query->row();
	if (count($result)) {
		if($result->extension) {
			$extension = $result->extension;
		}
	}

	// check in did_details	
	$CI->db->select('*');  
	$CI->db->from("did_details");
	$CI->db->where('site_id', $site_id);
	$CI->db->where('tenant_id', $tenant_id);
	$CI->db->where("FIND_IN_SET(".$extension.", REPLACE(extension,'|',',')) > 0");
	$CI->db->where('deleted_at IS NULL');
	$query =  $CI->db->get();
	$result =  $query->result();
	if (count($result)) {
		return true;
	}

	// check in did_routing_ivr	
	$CI->db->select('*');  
	$CI->db->from("did_routing_ivr");
	$CI->db->where('site_id', $site_id);
	$CI->db->where('tenant_id', $tenant_id);
	$where = "(FIND_IN_SET('".$extension."', REPLACE(choice1,'|',',')) > 0 OR
	FIND_IN_SET(".$extension.", REPLACE(choice2,'|',',')) > 0 OR FIND_IN_SET('".$extension."', REPLACE(choice3,'|',',')) > 0 OR FIND_IN_SET('".$extension."', REPLACE(choice4,'|',',')) > 0 OR FIND_IN_SET('".$extension."', REPLACE(choice5,'|',',')) > 0 OR FIND_IN_SET('".$extension."', REPLACE(choice6,'|',',')) > 0 OR FIND_IN_SET('".$extension."', REPLACE(choice7,'|',',')) > 0 OR FIND_IN_SET('".$extension."', REPLACE(choice8,'|',',')) > 0 OR FIND_IN_SET('".$extension."', REPLACE(choice9,'|',',')) > 0 OR FIND_IN_SET('".$extension."', REPLACE(default_choice,'|',',')) > 0 OR FIND_IN_SET('".$extension."', REPLACE(off_time_choice,'|',',')) > 0)";

	$CI->db->where($where);
	$CI->db->where('deleted_at IS NULL');
	$query =  $CI->db->get();
	$result =  $query->result();
	if (count($result)) {
		return true;
	}
	return false;	
}

function Move_Folder_To($source, $target){
      if( !is_dir($target) ) mkdir(dirname($target),null,true);
      rename( $source,  $target);
  }

function copy_directory($src,$dst) {
    $dir = opendir($src);
    @mkdir($dst);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_dir($src . '/' . $file) ) {
                recurse_copy($src . '/' . $file,$dst . '/' . $file);
            }
            else {
                copy($src . '/' . $file,$dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}

function checkTrunkDidUsed($tenant_id, $site_id, $trunk_did_id){

	$CI =& get_instance();

	// Get DID number
	$tenant_detail = get_tenant_detail($tenant_id);
	$username = $tenant_detail->username;

	$CI->db->select('*');  
	$CI->db->from('did_details');
	$CI->db->where('id', $trunk_did_id);
	$CI->db->where('deleted_at IS NULL');
	$query =  $CI->db->get();
	$result =  $query->row();
	if (count($result)) {
		if($result->did_number) {
			$did = $result->did_number;
		}
	}

	// check in extensions
	$CI->db->select('*');  
	$CI->db->from($username.'_extensions');
	$CI->db->where('outbound_did', $did);
	$CI->db->where('site_id', $site_id);
	$CI->db->where('deleted_at IS NULL');
	$query =  $CI->db->get();
	$result =  $query->row();
	if (count($result)) {
		return true;
	}

	// Check in branch
	$CI->db->select('*');  
	$CI->db->from($username.'_site');
	$CI->db->where('did', $did);
	$CI->db->where('deleted_at IS NULL');
	$query =  $CI->db->get();
	$result =  $query->row();
	if (count($result)) {
		echo "hello2";
		return true;
	}

	// check in did_routing_ivr	
	$CI->db->select('*');  
	$CI->db->from("did_routing_ivr");
	$CI->db->where('site_id', $site_id);
	$CI->db->where('tenant_id', $tenant_id);
	$CI->db->where('did', $did);
	$CI->db->where('deleted_at IS NULL');
	$query =  $CI->db->get();
	$result =  $query->result();
	if (count($result)) {
		echo "hello3";
		return true;
	}

	// check in block number	
	$CI->db->select('*');  
	$CI->db->from("block_number");
	$CI->db->where('site_id', $site_id);
	$CI->db->where('tenant_id', $tenant_id);
	$CI->db->where('did', $did);
	$CI->db->where('deleted_at IS NULL');
	$query =  $CI->db->get();
	$result =  $query->result();
	if (count($result)) {
		echo "hello4";
		return true;
	}

	return false;	
}


function get_phone_company_valid($name,$tenant_id,$id) {

$CI =& get_instance();

$CI->db->select('*');  
$CI->db->where('name',$name);
$CI->db->where('tenant_id',$tenant_id);
$CI->db->where('id !=',$id);
$CI->db->from('phone_company');
$query =  $CI->db->get();
$result =  $query->row();
if (count($result)) {
return 1;
}else{
return 0;
}
}


function get_phone_company($id) {

$CI =& get_instance();

$CI->db->select('*');  
$CI->db->where('id',$id);
$CI->db->from('phone_company');
$query =  $CI->db->get();
$result =  $query->row();
if (count($result)) {
return $result;
}else{
return '';
}
}

function get_phone_company_tenant($id) {

$CI =& get_instance();

$CI->db->select('*');  
$CI->db->where('tenant_id',$id);
$CI->db->from('phone_company');
$query =  $CI->db->get();
$result =  $query->result();
if (count($result)) {
return $result;
}else{
return '';
}
}

function get_phone_family_valid($com,$model,$tenant_id,$id) {

$CI =& get_instance();

$CI->db->select('*');  
$CI->db->where('company',$com);
$CI->db->where('model',$model);
$CI->db->where('tenant_id',$tenant_id);
$CI->db->where('id !=',$id);
$CI->db->from('phone_family');
$query =  $CI->db->get();
$result =  $query->row();
if (count($result)) {
return 1;
}else{
return 0;
}
}


function get_phone_family($id) {

$CI =& get_instance();

$CI->db->select('*');  
$CI->db->where('id',$id);
$CI->db->from('phone_family');
$query =  $CI->db->get();
$result =  $query->row();
if (count($result)) {
return $result;
}else{
return '';
}
}

function get_phone_name($id) {

$CI =& get_instance();

$CI->db->select('*');  
$CI->db->where('id',$id);
$CI->db->from('phone_company');
$query =  $CI->db->get();
$result =  $query->row();
if (count($result)) {
return $result->name;
}else{
return '';
}
}

function get_phone_model_name($id) {

$CI =& get_instance();

$CI->db->select('*');  
$CI->db->where('id',$id);
$CI->db->from('phone_family');
$query =  $CI->db->get();
$result =  $query->row();
if (count($result)) {
return $result->model;
}else{
return '';
}
}

function get_phone_family_tenant($id) {

$CI =& get_instance();

$CI->db->select('*');  
$CI->db->where('tenant_id',$id);
$CI->db->from('phone_family');
$query =  $CI->db->get();
$result =  $query->result();
if (count($result)) {
return $result;
}else{
return '';
}
}

function get_phone_family_com_wise($id) {

$CI =& get_instance();

$CI->db->select('*');  
$CI->db->where('company',$id);
$CI->db->from('phone_family');
$query =  $CI->db->get();
$result =  $query->result();
if (count($result)) {
return 1;
}else{
return 0;
}
}


function get_phone_temp($id) {

$CI =& get_instance();

$CI->db->select('*');  
$CI->db->where('id',$id);
$CI->db->from('phone_template');
$query =  $CI->db->get();
$result =  $query->row();
if (count($result)) {
return $result;
}else{
return '';
}
}


function get_phone_temp_model($company,$model) {

$CI =& get_instance();

$CI->db->select('*');  
$CI->db->where('company',$company);
$CI->db->where('model',$model);
$CI->db->where('tenant_id',$_SESSION['user_id']);
$CI->db->from('phone_template');
$query =  $CI->db->get();
$result =  $query->row();
if (count($result)) {
return $result;
}else{
return 0;
}
}

function get_model_file_prifix($company,$model) {

$CI =& get_instance();

$CI->db->select('*');  
$CI->db->where('company',$company);
$CI->db->where('id',$model);
$CI->db->where('tenant_id',$_SESSION['user_id']);
$CI->db->from('phone_family');
$query =  $CI->db->get();
$result =  $query->row();
if (count($result)) {
return $result->file_prifix;
}else{
return 0;
}
}


function get_phone_temp_model_wise($model) {

$CI =& get_instance();

$CI->db->select('*');  
$CI->db->where('model',$model);
$CI->db->from('phone_template');
$query =  $CI->db->get();
$result =  $query->result();
if (count($result)) {
return 1;
}else{
return 0;
}
}

function get_phone_temp_valid($com,$model,$tenant_id,$id) {

$CI =& get_instance();

$CI->db->select('*');  
$CI->db->where('company',$com);
$CI->db->where('model',$model);
$CI->db->where('tenant_id',$tenant_id);
$CI->db->where('id !=',$id);
$CI->db->from('phone_template');
$query =  $CI->db->get();
$result =  $query->row();
if (count($result)) {
return 1;
}else{
return 0;
}
}

function get_phone_provisioning($id) {

$CI =& get_instance();

$CI->db->select('*');  
$CI->db->where('id',$id);
$CI->db->from('phone_provisioning');
$query =  $CI->db->get();
$result =  $query->row();
if (count($result)) {
return $result;
}else{
return '';
}
}


function get_model_phone_provisioning($company,$model,$tenant_id) {

$CI =& get_instance();

$CI->db->select('*');  
$CI->db->where('phone_company',$company);
$CI->db->where('model',$model);
$CI->db->where('tenant_id',$tenant_id);
$CI->db->from('phone_provisioning');
$query =  $CI->db->get();
$result =  $query->result();
if (count($result)) { 
return json_decode(json_encode($result), true);;
}else{
return '';
}
}

function get_phone_provisioning_valid($tenant_id,$site_id,$ext,$id) {

$CI =& get_instance();

$CI->db->select('*');  
$CI->db->where('tenant_id',$tenant_id);
$CI->db->where('site_id',$site_id);
$CI->db->where('extension',$ext);
$CI->db->where('id !=',$id);
$CI->db->from('phone_provisioning');
$query =  $CI->db->get();
$result =  $query->row();
if (count($result)) {
return 1;
}else{
return 0;
}
}

function get_model_phone_provisioning_temp($id) {

$CI =& get_instance();

$temp = get_phone_temp($id);

$CI->db->select('*');  
$CI->db->where('phone_company',$temp->company);
$CI->db->where('model',$temp->company);
$CI->db->where('tenant_id',$_SESSION['user_id']);
$CI->db->from('phone_provisioning');
$query =  $CI->db->get();
$result =  $query->result();
if (count($result)) { 
return 1;
}else{
return 0;
}
}

function get_LDAP_details($id) {

$CI =& get_instance();

$CI->db->select('*');  
$CI->db->where('tenant_id',$id);
$CI->db->from('ldap_config');
$query =  $CI->db->get();
$result =  $query->row();
if (count($result)) {
return $result;
}else{
return '';
}
}


function get_file_json($company,$model,$file_name){

	$file_ext  = explode('.', $file_name);
	$file_path = '/var/www/html/templates/'.$_SESSION['user_id'].'/'.$company.'/'.$model.'/'.$file_name; 

	if($file_ext[1] == 'txt' || $file_ext[1] == 'cfg'){

	$fh = fopen($file_path,'r');
    $data = array();
    while ($line = fgets($fh)) {
    if(trim($line)!=''){
    $line_data = explode('=',$line);
      $data[trim($line_data[0])] = trim($line_data[1]);
    }
    }
    
    fclose($fh);
    return $json_data = json_encode($data);
    
	}

	if($file_ext[1] == 'csv'){

	if (!($fp = fopen($file_path, 'r'))) {
        die("Can't open file...");
    }
    
    $key = fgetcsv($fp,"1024",",");
    
    $json = array();
        while ($row = fgetcsv($fp,"1024",",")) {
        $json = array_combine($key, $row);
    }
    
    fclose($fp);
    
    return $json = json_encode($json);

	}

	if($file_ext[1] == 'xml'){

	 $xml_string = $file_path;	     
     $xmlObject  = simplexml_load_file($xml_string);
     return $jsonData = json_encode($xmlObject);

	}

}

function get_rate_card($id = null) {

	$CI =& get_instance();
	$CI->db->select('*');  
	$CI->db->from('rate_card');
	if($id != ''){
	$CI->db->where('id',$id);
	}
	$query =  $CI->db->get();
	if($id != ''){
	$result =  $query->row();
	}else{
	$result =  $query->result();
	}
	if (count($result)) {
	 return $result;
	}else{
	 return "";
	}
}

function get_country_code($code,$id = null) {

	$CI =& get_instance();
	$CI->db->select('*');  
	$CI->db->from('rate_card');
    $CI->db->where('country_code',$code);
	$CI->db->where('id !=',$id);
	$query =  $CI->db->get();
	$result =  $query->row();
	if (count($result)) {
	 return '1';
	}else{
	 return "0";
	}
}

function get_assign_rate_details($id = null) {

	$CI =& get_instance();
	$CI->db->select('*');  
	$CI->db->from('assign_rate_card');
	if($id != ''){
    $CI->db->where('id',$id);
    }
	$query =  $CI->db->get();
	if($id != ''){
	 $result =  $query->row();
	}else{
	 $result =  $query->result();		
	}	
	if (count($result)) {
	 return $result;
	}else{
	 return "0";
	}
}

function get_assign_rate($account,$id = null) {

	$CI =& get_instance();
	$CI->db->select('*');  
	$CI->db->from('assign_rate_card');
    $CI->db->where('account_code',$account);
	$CI->db->where('id !=',$id);
	$query =  $CI->db->get();
	$result =  $query->row();
	if (count($result)) {
	 return '1';
	}else{
	 return "0";
	}
}



function listFolderFiles($dir){
   $fileFolderList = scandir($dir);
   echo '<ul>';
   foreach($fileFolderList as $fileFolder){
       if($fileFolder != '.' && $fileFolder != '..'){
           if(!is_dir($dir.'/'.$fileFolder)){
               echo '<li><a target="_blank" href="'.SITE_URL.'/'.ltrim($dir.'/'.$fileFolder,'./').'">'.$fileFolder.'</a>';
           } else {
               echo '<li>'.$fileFolder;
           }
           if(is_dir($dir.'/'.$fileFolder)) listFolderFiles($dir.'/'.$fileFolder);
               echo '</li>';
           }
   }
   echo '</ul>';
}


function array2xml( $array, $xml = false) {
    
   // Loop through array
   $xml = '<?xml version="1.0" encoding="UTF-8"?>';
   $xml .= '<gs_provision version="1">';
   foreach( $array as $key => $value ) {
      
    if('@attributes' != $key){
        if ( is_array( $value ) ) {
          $keys = $key;
          $xml .= '<'.$keys.'>';
          foreach( $value as $key => $values ) {
          if('@attributes' != $key){                  
            $xml .= '<'.$key.'>'.$values.'</'.$key.'>';  
          }
          }
          $xml .= '</'.$keys.'>';
        }else{
            $xml .= '<'.$key.'>'.$value.'</'.$key.'>';
        }
      }
    }
   $xml .= '</gs_provision>';

 
    // Return XML
    return $xml = str_replace('AND', '&', $xml);;//->asXML();
}


?>
