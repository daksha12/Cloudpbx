<?php
class LocalResponse extends MY_Controller
{
public function __construct()
{
parent::__construct();
}

public function tenant_ext_json($data = null)
{     
/*** GET EXTNSION ***/
$extension = $this->Report_m->get_tenant_ext('',$_GET['sSearch'],$data,$_GET['iDisplayStart'],$_GET['iDisplayLength'],$_GET['sEcho']);
echo json_encode($extension);  
}

public function tenant_site_json($site_id = null)
{     
/*** GET SITE ***/
$site = $this->Report_m->get_tenant_site($site_id,$_GET['sSearch']); 

$response = ["sEcho" => $_GET['sEcho'],
"iTotalRecords" => count($site),
"iTotalDisplayRecords" => count($site),
"aaData" => $site];  
echo json_encode($response);  
}

public function cdr_json()
{

$code = get_account_code($_SESSION['account_id']);
if(isset($_SESSION['extension'])){
$ext = $_SESSION['extension'];
}else{
$ext = null;
}

$cdr  = $this->Report_m->get_cdr($code,$ext,$_GET['sSearch'],$_GET['iDisplayStart'],$_GET['iDisplayLength'],$_GET['sEcho']);      
echo json_encode($cdr); 
}


public function voice_mail_json($extension = null,$type = null,$site = null){

/*** GET TEXT FILE ***/ 
$array_result = array();
$i = 0;
if($_SESSION['user_type'] == 'Admin'){
$path = '/var/spool/asterisk/voicemail/'.$_SESSION['username'].'_'.$site.'/'.$extension.'/'.$type.'/';
}else{
$path = '/var/spool/asterisk/voicemail/'.$_SESSION['tenant_name'].'_'.$site.'/'.$extension.'/'.$type.'/';
}
$fileList = glob($path.'*.txt');
foreach($fileList as $filename){

$data      = parse_ini_file($filename,true);
$src       = explode('<', $data['message']['callerid']);
$file_data = explode('/', $filename);
$wav       = explode('.',$file_data[8]);

$date = date("Y-m-d H:i:s", strtotime($data['message']['origdate']));
$array_result[$i]['origdate']  = time_zone_convert($date);
$array_result[$i]['callerid']  = $src[0];
$array_result[$i]['exten']     = $data['message']['exten'];
$array_result[$i]['filename']  = $file_data[5].'/'.$file_data[6].'/'.$type.'/'.$wav[0].'.wav';
$sectime = (floor($data['message']['duration'] / 3600).":".floor(($data['message']['duration'] / 60) % 60).":".$data['message']['duration'] % 60);		
$array_result[$i]['duration']  = date('H:i:s',strtotime($sectime));;  
$i++;
}   

$response = ["sEcho" => $_GET['sEcho'],
"iTotalRecords" => count($array_result),
"iTotalDisplayRecords" => count($array_result),
"aaData" => $array_result];  

echo json_encode($response);
}


public function voice_mail_export($site = null,$extension = null,$type = null){

/*** GET TEXT FILE ***/ 
$array_result = array();
$i = 0;
if($_SESSION['user_type'] == 'Admin'){
$path = '/var/spool/asterisk/voicemail/'.$_SESSION['username'].'_'.$site.'/'.$extension.'/'.$type.'/';
}else{
$path = '/var/spool/asterisk/voicemail/'.$_SESSION['tenant_name'].'_'.$site.'/'.$extension.'/'.$type.'/';
}

$fileList = glob($path.'*.txt');

$rand = rand(10,10000);
$filename_csv = 'Voice_Mail_Records'.date('d_m_Y').'_'.$rand.'.csv';
$data_array = $array_result;
$csv = "CALL DATE,CALLER,RECIPIENT NUMBER,DURATION \n";//Column headers

foreach($fileList as $filename){

$data      = parse_ini_file($filename,true);
$src       = explode('<', $data['message']['callerid']);
$file_data = explode('/', $filename);
$wav       = explode('.',$file_data[8]);

$date = date("Y-m-d H:i:s", strtotime($data['message']['origdate']));
$csv .= time_zone_convert($date).','.$src[0].','.$data['message']['exten'].','.date('H:i:s',strtotime($sectime))."\n";
$i++;

}   

$csv_handler = fopen ('/var/www/html/downloads/'.$filename_csv,'w');
fwrite ($csv_handler,$csv);
fclose ($csv_handler);

/*** DOWNLOAD FILE ***/
$filepath ='/var/www/html/downloads/'.$filename_csv;
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($filepath));
flush(); // Flush system output buffer
readfile($filepath);

exit(0);

}


public function get_block_no($type = null)
{     

$tenant_id = $_SESSION['user_id'];
$number = $this->Report_m->get_block_number($tenant_id,$type);

$array_result = array();

foreach ($number as $key => $value) {             
$array_result[$key]['site_id'] = get_site_name($value->site_id);
$array_result[$key]['did']  = $value->did;
$array_result[$key]['number']  = $value->number;
}

$response = ["sEcho" => $_GET['sEcho'],
"iTotalRecords" => count($array_result),
"iTotalDisplayRecords" => count($array_result),
"aaData" => $array_result];

echo json_encode($response);  
}

public function phone_company_json(){

$tenant_id = $_SESSION['user_id'];
$company   = $this->Report_m->get_phone_company($tenant_id);

$array_result = array();

foreach ($company as $key => $value) {             
$array_result[$key]['name']     = $value->name;
$array_result[$key]['datetime'] = $value->datetime;
$array_result[$key]['id']       = $value->id;
}

$response = ["sEcho" => $_GET['sEcho'],
"iTotalRecords" => count($array_result),
"iTotalDisplayRecords" => count($array_result),
"aaData" => $array_result];

echo json_encode($response);  

}

public function phone_family_json(){

$tenant_id = $_SESSION['user_id'];
$company   = $this->Report_m->get_phone_family($tenant_id);

$array_result = array();

foreach ($company as $key => $value) {             
$array_result[$key]['model']    = $value->model;	
$array_result[$key]['company']  = get_phone_name($value->company);
$array_result[$key]['datetime'] = $value->datetime;
$array_result[$key]['id']       = $value->id;
}

$response = ["sEcho" => $_GET['sEcho'],
"iTotalRecords" => count($array_result),
"iTotalDisplayRecords" => count($array_result),
"aaData" => $array_result];

echo json_encode($response);  

}


public function phone_template_json(){

$tenant_id = $_SESSION['user_id'];
$company   = $this->Report_m->get_phone_template($tenant_id);

$array_result = array();

foreach ($company as $key => $value) {             
$array_result[$key]['company']  = get_phone_name($value->company);
$array_result[$key]['model']    = get_phone_model_name($value->model);	
$array_result[$key]['file']     = $value->file_name;
$array_result[$key]['id']       = $value->id;
$array_result[$key]['datetime']       = $value->datetime;
$array_result[$key]['c_id']     = $value->company;
$array_result[$key]['m_id']     = $value->model;
}

$response = ["sEcho" => $_GET['sEcho'],
"iTotalRecords" => count($array_result),
"iTotalDisplayRecords" => count($array_result),
"aaData" => $array_result];

echo json_encode($response);  

}


public function phone_provisioning_json(){

$tenant_id    = $_SESSION['user_id'];
$site_id      = $_SESSION['site_id'];
$provisioning = $this->Report_m->get_phone_provisioning($tenant_id,$site_id);

$array_result = array();

foreach ($provisioning as $key => $value) {             
 $array_result[$key]['tenant_id']  = $value->tenant_id;
 $array_result[$key]['site_id']    = $value->site_id;	
 $array_result[$key]['company']    = get_phone_name($value->phone_company);
 $array_result[$key]['model']      = get_phone_model_name($value->model);
 $array_result[$key]['extension']  = $value->extension;
 $array_result[$key]['phone_ip']   = $value->phone_ip;
 $array_result[$key]['mac']        = $value->mc;
 $array_result[$key]['datetime']   = $value->datetime;
 $array_result[$key]['c_id']       = $value->phone_company;
 $array_result[$key]['m_id']       = $value->model;
 $array_result[$key]['id']         = $value->id;
}

$response = ["sEcho" => $_GET['sEcho'],
"iTotalRecords" => count($array_result),
"iTotalDisplayRecords" => count($array_result),
"aaData" => $array_result];

echo json_encode($response);  

}


public function get_ext_details($id)
{
/*** GET EXTNSION ***/
$extension = $this->Report_m->get_tenant_ext($id,'','All');   
$json = json_encode($extension['aaData']);
$json = json_decode($json,true);
$ext  = $json[0]['extension'];
$site = $json[0]['site_name'];

if($_SESSION['user_type'] == 'Admin'){
$json[0]['CFNA'] = sqllite_data_get("/CFNA_".$_SESSION["username"]."_".$site."/".$ext);
$json[0]['CFUC'] = sqllite_data_get("/CFUC_".$_SESSION["username"]."_".$site."/".$ext);
}else{
$json[0]['CFNA'] = sqllite_data_get("/CFNA_".$_SESSION["tenant_name"]."_".$site."/".$ext);
$json[0]['CFUC'] = sqllite_data_get("/CFUC_".$_SESSION["tenant_name"]."_".$site."/".$ext);	
}

$json = json_encode($json);

$old = ["[", "]"];
$new = ["", ""];

echo str_replace($old, $new, $json);
}

public function get_site_details($id)
{

/*** GET EXTNSION ***/
$extension = $this->Report_m->get_tenant_site($id,'','All');   
$json = json_encode($extension);
$json = json_decode($json,true);
$json[0]['cdr_timezone'] = get_timezone($json[0]['cdr_timezone']).' ( '.$json[0]['cdr_timezone'].' )';
$json = json_encode($json);

$old = ["[", "]"];
$new = ["", ""];
echo str_replace($old, $new, $json);
}


public function download_rec(){

$file_names = array();
if(isset($_POST['files'])) {

for($i=0; $i < count($_POST['files']); $i++) { 
$file_names[$i] =  $_POST['files'][$i];
}

$rand = rand(10,10000);
$filenamedownload = 'Recordings_'.date('d_m_Y_').'_'.$rand.'.zip';
$archive_file_name = '/var/www/html/downloads/'.$filenamedownload;

if($_SESSION['user_type'] == 'Admin'){
$file_path = "/var/spool/asterisk/monitor/bizRTCPBX/".$_SESSION['username'].'/';
}else{
$file_path = "/var/spool/asterisk/monitor/bizRTCPBX/".$_SESSION['tenant_name'].'/';
}
error_log("Exectued till line  " .__LINE__);

if (!empty($file_names)) {
$create = zipFilesAndDownload($file_names,$archive_file_name,$file_path);
echo $filenamedownload;
}
else
{
echo "File are empty";
error_log(" File are empty  " .__LINE__);
}
}
else{
echo "File in POST are Empty";
}       
}

public function download_mail($site=null,$extension=null,$type=null){

$file_names = array();
if(isset($_POST['files'])) {
for($i=0; $i < count($_POST['files']); $i++) { 
if($_POST['files'][$i] != ''){
$file_names[$i] =  $_POST['files'][$i];
}
}

}else{

if($_SESSION['user_type'] == 'Admin'){
$path = '/var/spool/asterisk/voicemail/'.$_SESSION['username'].'_'.$site.'/'.$extension.'/'.$type.'/';
}else{
$path = '/var/spool/asterisk/voicemail/'.$_SESSION['tenant_name'].'_'.$site.'/'.$extension.'/'.$type.'/';
}

$fileList = glob($path.'*.txt');
$i=0;
foreach($fileList as $filename){

$data      = parse_ini_file($filename,true);
$src       = explode('<', $data['message']['callerid']);
$file_data = explode('/', $filename);
$wav       = explode('.',$file_data[8]); 

$file_names[$i] = $file_data[5].'/'.$file_data[6].'/'.$type.'/'.$wav[0].'.wav';
$i++;
}
}

$rand = rand(10,10000);
$filenamedownload = 'Voice_Mail_'.date('d_m_Y_').'_'.$rand.'.zip';
$archive_file_name = '/var/www/html/downloads/'.$filenamedownload;

$file_path = '/var/spool/asterisk/voicemail/';

error_log("Exectued till line  " .__LINE__);

if (!empty($file_names)) {
$create = zipFilesAndDownload($file_names,$archive_file_name,$file_path);
echo $filenamedownload;
}
else
{
echo "File are empty";
error_log(" File are empty  " .__LINE__);
$handle = fopen("error_message.txt", "w");
fwrite($handle, "Note : No Voice Mail Audio File Available");
fclose($handle);

header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename='.basename('error_message.txt'));
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize('error_message.txt'));
readfile('error_message.txt');
exit(0);
}

if(!isset($_POST['files'])) {
error_log(" EXT NOT empty " );
$url = site_url.'downloads/'.$filenamedownload;
redirect($url);
}

}

public function cdr_export_all()
{

$code = get_account_code($_SESSION['account_id']);
if(isset($_SESSION['extension'])){
$ext = $_SESSION['extension'];
}else{
$ext = null;
}

$cdr  = $this->Report_m->get_cdr($code,$ext,$_GET['sSearch'],'','',$_GET['sEcho']);

$file_names = array();

foreach ($cdr['aaData'] as $key => $value) {
if($value['recordingfile'] != ''){
$file_names[$key] =  $value['recordingfile'];
}
}

$rand = rand(10,10000);
$filenamedownload = 'Recordings_'.date('d_m_Y_').'_'.$rand.'.zip';
$archive_file_name = '/var/www/html/downloads/'.$filenamedownload;

if($_SESSION['user_type'] == 'Admin'){
$file_path = "/var/spool/asterisk/monitor/bizRTCPBX/".$_SESSION['username'].'/';
}else{
$file_path = "/var/spool/asterisk/monitor/bizRTCPBX/".$_SESSION['tenant_name'].'/';
}
error_log("Exectued till line  " .__LINE__);

if (!empty($file_names)) {
$create = zipFilesAndDownload($file_names,$archive_file_name,$file_path);
echo $filenamedownload;
}
else
{
echo "File are empty";
error_log(" File are empty  " .__LINE__);
$handle = fopen("error_message.txt", "w");
fwrite($handle, "Note : No Audio File Available");
fclose($handle);

header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename='.basename('error_message.txt'));
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize('error_message.txt'));
readfile('error_message.txt');

exit(0);
}

$url = site_url.'downloads/'.$filenamedownload;
redirect($url);
} 


public function cdr_report_export()
{

$code = get_account_code($_SESSION['account_id']);
if(isset($_SESSION['extension'])){
$ext = $_SESSION['extension'];
}else{
$ext = null;
}

/******  FILE REMOVE ******/
$files = glob('/var/www/html/downloads/*.csv'); //get all file names
foreach($files as $file){
if(is_file($file))
unlink($file); //delete file
}
/****** END REMOVE *******/

$cdr  = $this->Report_m->get_cdr($code,$ext,$_GET['sSearch'],'','',$_GET['sEcho']);
$data = $cdr['aaData'];

$rand = rand(10,10000);
$filename_csv = 'CallDetailRecords'.date('d_m_Y').'_'.$rand.'.csv';
$data_array = $array_result;
$csv  = "Data Export : FROM DATE : ".$_SESSION['fromdate']." | To DATE : ".$_SESSION['todate']."  \n";//Column headers
$csv .= "CALL DATE,CALLER,RECIPIENT NUMBER,DURATION,DISPOSITION \n";//Column headers

foreach ($data as $key => $record){
 $csv.= $record['call_date'].','.$record['src'].','.$record['dst'].','.$record['billsec'].','.$record['disposition']."\n"; //Append data to csv
}

$csv_handler = fopen ('/var/www/html/downloads/'.$filename_csv,'w');
fwrite ($csv_handler,$csv);
fclose ($csv_handler);

/*** DOWNLOAD FILE ***/
$filepath ='/var/www/html/downloads/'.$filename_csv;
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($filepath));
flush(); // Flush system output buffer
readfile($filepath);

exit(0);
 
} 


}
?>
