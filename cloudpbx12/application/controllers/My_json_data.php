<?php
class LocalResponse extends MY_Controller
{
	public function __construct()
	{
	   parent::__construct();
	}

  public function tenant_ext_json($site = null)
  {     
  /*** GET EXTNSION ***/
  $extension = $this->Report_m->get_tenant_ext('',$_GET['sSearch'],$site);

  $response = ["sEcho" => $_GET['sEcho'],
  "iTotalRecords" => count($extension),
  "iTotalDisplayRecords" => count($extension),
  "aaData" => $extension];  

  echo json_encode($response);  
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

  $cdr  = $this->Report_m->get_cdr($code,$ext,$_GET['sSearch']);      

  $response = ["sEcho" => $_GET['sEcho'],
  "iTotalRecords" => count($cdr),
  "iTotalDisplayRecords" => count($cdr),
  "aaData" => $cdr];  

  echo json_encode($response); 
  }

  public function ext_status_json(){
       
      $ext    = $this->Report_m->get_tenant_ext('',$_GET['sSearch'],'');
      $prefix = $this->Report_m->get_prefix();

      $array_result = array();

      foreach ($ext as $key => $ext_value) {             

      $mobile_prefix  =  $prefix->mobile_prefix.$ext_value->extension;
      $desktop_prefix =  $prefix->desktop_prefix.$ext_value->extension;

      $array_result[$key]['extension']       = $ext_value->extension;
      $array_result[$key]['extension_status'] = get_ext_status($ext_value->extension);
      $array_result[$key]['mobile_status']   = get_ext_status($mobile_prefix);
      $array_result[$key]['desktop_status']  = get_ext_status($desktop_prefix);
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
  $extension = $this->Report_m->get_tenant_ext($id);   
  $json = json_encode($extension);

  $data   = json_decode($json,true);
  $id     = $data[0]['did_id'];
  $data[0]['did_id'] = get_did_number($id);
  $json = json_encode($data);
  $old = ["[", "]"];
  $new = ["", ""];

  echo str_replace($old, $new, $json);
  }

  public function get_site_details($id)
  {
  /*** GET EXTNSION ***/
  $extension = $this->Report_m->get_tenant_site($id);   
  $json = json_encode($extension);
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

}
?>
