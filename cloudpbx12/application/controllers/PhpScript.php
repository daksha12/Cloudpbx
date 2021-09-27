<?php
class PhpScript extends MY_Controller
{
  
  public function __construct()
  {
    parent::__construct();   
  }
  
  public function master_file($tenant_id,$account_id)
  { 
    error_reporting(0);
    $tenant = getUserNameByTenantId($tenant_id);   

    exec('chmod -R 777 /etc/asterisk');
    
    mkdir('/etc/asterisk/bizRTCPBX/back_file/', 0777, true);    

    /***** BACK ALL FILES *******/
    $folder = 'backup_'.date('d-m-Y-H-i-s');
    mkdir('/etc/asterisk/bizRTCPBX/BACKUP/'.$folder, 0777, true);

    copy("/etc/asterisk/sip.conf", "/etc/asterisk/bizRTCPBX/BACKUP/".$folder."/sip.conf");
    copy("/etc/asterisk/trunk.conf", "/etc/asterisk/bizRTCPBX/BACKUP/".$folder."/trunk.conf");
    copy("/etc/asterisk/extensions.conf", "/etc/asterisk/bizRTCPBX/BACKUP/".$folder."/extensions.conf");
    copy("/etc/asterisk/extensions_trunk.conf", "/etc/asterisk/bizRTCPBX/BACKUP/".$folder."/extensions_trunk.conf");
    copy("/etc/asterisk/voicemail.conf", "/etc/asterisk/bizRTCPBX/BACKUP/".$folder."/voicemail.conf");
    copy("/etc/asterisk/res_parking.conf", "/etc/asterisk/bizRTCPBX/BACKUP/".$folder."/res_parking.conf"); 
 
    $tenant_all = get_all_tenant($tenant_id);
    foreach ($tenant_all as $tenant_data) {
      Move_Folder_To("/etc/asterisk/bizRTCPBX/".$tenant_data->tenant_name,  "/etc/asterisk/bizRTCPBX/BACKUP/".$folder.'/'.$tenant_data->tenant_name);
    }

    /***** BACK ALL FILES *******/

    
    /****** REMOVE ALL OLF LINE ******/
    $sip      = '/etc/asterisk/sip.conf';
    $get_sip  = file_get_contents($sip);

    $search      = getUserNameByTenantId($tenant_id);
    ///// SIP.CONF /////
    $file        = '/etc/asterisk/sip.conf';
    $lines       = file($file);
    $line_number = false;

    while (list($key, $line) = each($lines)) {
     $line_number = (strpos($line, $search) !== FALSE) ? $key + 1 : $line_number;
     $row = $line_number - 1;
     unset($lines[$row]); 
      
    $line_number = (strpos($line, 'main host') !== FALSE) ? $key + 1 : $line_number;
     $row = $line_number - 1;
     unset($lines[$row]); 
    } 
     
    $old = ["#include trunk.conf"];
    $new   = [""];

    $lines = str_replace($old, $new, $lines);

    file_put_contents($file, implode("", $lines));

    ///// EXTENSION.CONF //////
    $file        = '/etc/asterisk/extensions.conf';
    $lines       = file($file);
    $line_number = false;

    while (list($key, $line) = each($lines)) {
     $line_number = (strpos($line, $search) !== FALSE) ? $key + 1 : $line_number;
     $row = $line_number - 1;
     unset($lines[$row]); 
    }

    $lines = str_replace("#include extensions_trunk.conf", '', $lines);
    
    file_put_contents($file, implode("", $lines));

    ////// EXTENSION_TRUNK.CONF //////
    $file        = '/etc/asterisk/extensions_trunk.conf';
    $lines       = file($file);
    $line_number = false;

    while (list($key, $line) = each($lines)) {
     $line_number = (strpos($line, $search) !== FALSE) ? $key + 1 : $line_number;
     $row = $line_number - 1;
     unset($lines[$row]); 
    }
    
    //$lines = str_replace("[pbx.bizrtc.com_incoming]", '', $lines);

    file_put_contents($file, implode("", $lines));

    ///// RES_PARKING.CONF //////
    $file        = '/etc/asterisk/res_parking.conf';
    $lines       = file($file);
    $line_number = false;

    while (list($key, $line) = each($lines)) {
     $line_number = (strpos($line, $search) !== FALSE) ? $key + 1 : $line_number;
     $row = $line_number - 1;
     unset($lines[$row]); 
    }
    file_put_contents($file, implode("", $lines));

    ///// TRUNK.CONF /////
    $file        = '/etc/asterisk/trunk.conf';
    $lines       = file($file);
    $line_number = false;

    while (list($key, $line) = each($lines)) {
     $line_number = (strpos($line, $search) !== FALSE) ? $key + 1 : $line_number;
     $row = $line_number - 1;
     unset($lines[$row]); 
    }
    file_put_contents($file, implode("", $lines));

    ///// VOICEMAIL.CONF /////
    $file        = '/etc/asterisk/voicemail.conf';
    $lines       = file($file);
    $line_number = false;

    while (list($key, $line) = each($lines)) {
     $line_number = (strpos($line, $search) !== FALSE) ? $key + 1 : $line_number;
     $row = $line_number - 1;
     unset($lines[$row]); 
    }

    file_put_contents($file, implode("", $lines));
    
    /**********************************/
    

    /******* SIP.CONF FILE *******/
    $file      = '/etc/asterisk/sip.conf';
    $get_data  = file_get_contents($file);
    $file_open = fopen($file, 'a') or die('Cannot open file: '.$file); 

    $branchData     = getTenantBranchData($tenant_id,$account_id);
    $trunkData      = getTrunkData($tenant_id);
    $tenantData     = getTenantData($tenant_id,$account_id);
    $extensionData  = getExtensionData($tenant_id);
    $trunkDIDData   = getTrunkDIDData($tenant_id);
    $ivrConfigData  = getIVRConfigDataDID($tenant_id);
    $accountCode    = get_account_code($account_id);


    if(!empty($branchData)){
    
     foreach ($branchData as $data) {
     $domain .= 'domain='.$data->site_name.'.'.$data->tenant_name.'.bizrtc.com,extdial_'.$data->tenant_name.'_'.$data->site_name.'  ;'.$data->tenant_name. "\n";
     }

     $line_numbr = (strpos($get_data, ';domain details company wise') !== FALSE);
     if($line_numbr == ""){
      $domain .= ';domain details company wise';
     }
     $data = find_string($get_data, "(0.0.0.0 binds to all)", " \n ". $domain);
     file_put_contents($file, $data);
     }

     if(!empty($trunkData)){
     $get_data = file_get_contents($file);
     $host_server = $_SERVER['SERVER_ADDR'];
     $trunk_host = 'domain='.$host_server.',pbx.bizrtc.com_incoming ; main host'."\n\n";  
     
     $host_details = getTrunkDataHost($tenant_id);
     
     foreach ($host_details as $trunk) {
      $host  = gethostbyname($trunk->host); 
      $line_ip  = (strpos($get_sip, $host) !== FALSE);
      if($line_ip == ''){
       $trunk_host .= 'domain='.$host.','.$trunk->domain.'_incoming '."\n\n";  
      }
     } 
      
      $data = find_string($get_data, ";domain details company wise", " \n ". $trunk_host);
      file_put_contents($file, $data);
     }

     if(!empty($trunkData)){
     $get_data = file_get_contents($file);
     foreach ($trunkData as $trunk) {
     $register .= 'register => '.$trunk->username.':'.$trunk->password.'@'.$trunk->domain.':'.$trunk->port.'/'.$trunk->trunk_did.'  ;'.$trunk->tenant_name. "\n";
     }
     $data = find_string($get_data, "20 seconds (default)", " \n ". $register);
     file_put_contents($file, $data);
     }
     
     if(!empty($trunkData)){
     $get_data  = file_get_contents($file);
     $trunk_data = '#include trunk.conf';
     $data = find_string($get_data, "; qualify=1000", " \n ". $trunk_data);
     file_put_contents($file, $data);
     }

     if(!empty($tenantData)){
      $sip_file = '#include bizRTCPBX/'.$tenantData->tenant_name.'/sip_'.$tenantData->tenant_name.'_detail.conf ; '.$tenantData->tenant_name."\n\n"; 
      fwrite($file_open, $sip_file);
     }

     fclose($file_open);   
    
  /******* SIP.CONF FILE *******/    
 
    /****** TRUNK FILE *******/
    if(!empty($trunkData)){
      $file = '/etc/asterisk/trunk.conf';
      $trunk_file = fopen($file, 'a') or die('Cannot open file: '.$file); 
      foreach ($trunkData as $trunk) {
        $trunk_details .= '#include /etc/asterisk/trunk_'.$trunk->trunk_did.'.conf  ;'.$trunk->tenant_name." \n";
        
        $trunk_did = fopen("/etc/asterisk/trunk_".$trunk->trunk_did.".conf", "w") or die("Unable to open file! 1");
       
        $trunk_log_details = '';
        $trunk_log_details .= "[".$trunk->trunk_did."]"."\n";
        $trunk_log_details .= "type=friend"."\n";
        $trunk_log_details .= "secret=".$trunk->password."\n";
        $trunk_log_details .= "host=".$trunk->host."\n";
        $trunk_log_details .= "port=".$trunk->port."\n";
        $trunk_log_details .= "disallow=all"."\n";
        $trunk_log_details .= "allow=ulaw"."\n";
        $trunk_log_details .= "allow=alaw"."\n";
        $trunk_log_details .= "allow=g729"."\n";
        $trunk_log_details .= "context=pbx.bizrtc.com_incoming"."\n";
        $trunk_log_details .= "fromdomain=".$trunk->host."\n";
        $trunk_log_details .= "nat=force_rport,comedia"."\n";
        $trunk_log_details .= "canreinvite=no"."\n";
        $trunk_log_details .= "username=".$trunk->username."\n";
        $trunk_log_details .= "fromuser=".$trunk->username."\n";
        $trunk_log_details .= "dtmfmode=rfc2833"."\n";
        $trunk_log_details .= "insecure=port,invite";
  
        fwrite($trunk_did, $trunk_log_details);

       }

      fwrite($trunk_file, $trunk_details);
     }
    /******** END FILE ******/

    /****** EXTENSION FILE *******/
    if(!empty($extensionData)){
      $file     = '/etc/asterisk/extensions.conf';
      $get_data  = file_get_contents($file);
      $ext_file = fopen($file, 'a') or die('Cannot open file: '.$file); 
      
      $main_ext = '#include extensions_trunk.conf';
      $data = find_string($get_data, "names are UPPER CASE.", " \n ". $main_ext);
      file_put_contents($file, $data);
     
     if(!empty($tenantData)){
      $call_file = "\n".'#include bizRTCPBX/'.$tenantData->tenant_name.'/extensions_'.$tenantData->tenant_name.'_call_detail.conf    ;'.$tenantData->tenant_name; 
      fwrite($ext_file, $call_file);
     }

     }
    /************ END FILE ***********/

    /****** EXTENSION TRUNK FILE *******/
    if(!empty($extensionData)){
      $file     = '/etc/asterisk/extensions_trunk.conf';
      $get_data = file_get_contents($file);
      $ext_truk_file = fopen($file, 'a') or die('Cannot open file: '.$file); 
      
      $line_numbr = (strpos($get_data, '[pbx.bizrtc.com_incoming]') !== FALSE);
      if($line_numbr == ''){  
        $con_ext = "\n".'[pbx.bizrtc.com_incoming]'."\n";
        fwrite($ext_truk_file , $con_ext);
      }

      if(!empty($trunkDIDData)){
        foreach ($trunkDIDData as $data) {
         if($data->did_type == 'extensions' AND $data->extension != ''){
            $ext_truk_data = 'exten => '.$data->did_number.',1,goto('.$data->tenant_name.'_'.$data->site_name.'_'.$data->did_number.'_igcall,'.$data->did_number.',1) ; '.$data->tenant_name." \n";
         }

         if($data->did_type == 'conference'){
            $ext_truk_data = 'exten => '.$data->did_number.',1,goto('.$data->tenant_name.'_'.$data->site_name.'_'.$data->did_number.'_igcallconf,'.$data->did_number.',1) ; '.$data->tenant_name." \n";  
         }

         fwrite($ext_truk_file, $ext_truk_data);
        }
      }

      if(!empty($ivrConfigData)){
        foreach ($ivrConfigData as $data) {
          $ext_truk_ivr .= 'exten => '.$data->did.',1,goto('.$data->tenant_name.'_'.$data->site_name.'_'.$data->did.'_igcallivr,'.$data->did.',1) ; '.$data->tenant_name." \n";
        }
        fwrite($ext_truk_file, $ext_truk_ivr);
      }

     }
    /******** END FILE ******/



    /******* Park FILE *****/
     if(!empty($tenantData)){
      $file      = '/etc/asterisk/res_parking.conf';
      $park_file = fopen($file, 'a') or die('Cannot open file: '.$file); 
     
      $park_data = "\n".'#include bizRTCPBX/'.$tenantData->tenant_name.'/park_'.$tenantData->tenant_name.'_detail.conf     ;'.$tenantData->tenant_name."\n"; 
      fwrite($park_file, $park_data);
     }
    /******* END FILE *******/

    /******* Voice FILE *****/
     if(!empty($tenantData)){
      $file       = '/etc/asterisk/voicemail.conf';
      $voice_file = fopen($file, 'a') or die('Cannot open file: '.$file); 

      $voice_data = "\n".'#include bizRTCPBX/'.$tenantData->tenant_name.'/voicemail_'.$tenantData->tenant_name.'_detail.conf     ;'.$tenantData->tenant_name."\n"; 
      fwrite($voice_file, $voice_data);
     }
    /******* END FILE *******/

    /************************* END OF MASTER FILES ***************************/

   
    /************************* COMPANY WISE FOLDER **************************/
    if(!empty($extensionData)){
      mkdir('/etc/asterisk/bizRTCPBX/'.$tenantData->tenant_name.'/', 0777, true); 
      $file     = '/etc/asterisk/bizRTCPBX/'.$tenantData->tenant_name.'/sip_'.$tenantData->tenant_name.'_detail.conf';
      $sip_ext = fopen($file, 'a') or die('Cannot open file: '.$file);

      foreach ($extensionData as $ext_data) {
        $sip_ext_data .= "\n".'#include bizRTCPBX/'.$ext_data->tenant_name.'/sip_'.$ext_data->tenant_name.'_'.$ext_data->site_name.'_'.$ext_data->extension.'_user.conf';   
      }

      fwrite($sip_ext, $sip_ext_data); 
    }

    if(!empty($extensionData)){ 
      $array_result = array();
      $key = 0;
      foreach ($extensionData as $ext_data) {

      $file     = '/etc/asterisk/bizRTCPBX/'.$tenantData->tenant_name.'/sip_'.$tenantData->tenant_name.'_'.$ext_data->site_name.'_'.$ext_data->extension.'_user.conf';
      $use_ext_file  = fopen($file, 'a') or die('Cannot open file: '.$file);

      /******** GET PREFIX *******/
      //$prefix = prefix_number_old();
      /***** END GET PREFIX ******/

      $this->db->select('pbx_password'); 
      $this->db->from($tenantData->tenant_name.'_extensions');
      $this->db->where('site_id', $ext_data->id);
      $this->db->where('extension', $ext_data->extension);
      $query = $this->db->get();
      $ext  = $query->row();
      
      $pass = $ext->pbx_password; //substr($ext_data->site_name, 0,4).date('dmYhis');

      $ext_user ='';
      //////  softphone_prefix ///////
      $ext_user .= "\n"."[6".$ext_data->extension."-".$ext_data->site_name."-".$ext_data->tenant_name."]"."\n";
      $ext_user .= "accountcode=".$accountCode."\n";
      $ext_user .= "type=friend"."\n";
      $ext_user .= "host=dynamic"."\n";
      $ext_user .= "defaultuser=6".$ext_data->extension."-".$ext_data->site_name."-".$ext_data->tenant_name."\n";
      $ext_user .= "secret=".$pass."\n";
      $ext_user .= "disallow=all"."\n";
      $ext_user .= "allow=g729"."\n";
      $ext_user .= "allow=ulaw"."\n";
      $ext_user .= "allow=alaw"."\n";
      $ext_user .= "allow=h263p"."\n";
      $ext_user .= "allow=h264"."\n";
      $ext_user .= "videosupport=yes"."\n";
      $ext_user .= "allowtransfer=yes"."\n";
      $ext_user .= "canreinvite=no"."\n";
      $ext_user .= "nat=force_rport,comedia"."\n";
      $ext_user .= "qualify=yes"."\n";
      $ext_user .= "dtmfmode=info"."\n";
      $ext_user .= 'callerid="ext'.$ext_data->extension.'" <'.$ext_data->extension.'>'."\n";
      $ext_user .= "context=".$ext_data->tenant_name."_".$ext_data->site_name."_og_".$ext_data->extension."\n";
      $ext_user .= "parkinglot=".$ext_data->tenant_name."_".$ext_data->site_name."_parking"."\n";
      $ext_user .= "domain=".$ext_data->site_name.".".$ext_data->tenant_name.".bizrtc.com"."\n";
      $ext_user .= "fromdomain=".$ext_data->site_name.".".$ext_data->tenant_name.".bizrtc.com"."\n";
      $ext_user .= "vmexten=".$ext_data->extension."\n";
      $ext_user .= "mailbox=".$ext_data->extension."@".$ext_data->tenant_name."_".$ext_data->site_name."\n";
      $ext_user .= "subscribecontext=".$ext_data->tenant_name."_".$ext_data->site_name."_".$ext_data->extension."\n";
      $ext_user .= "allowsubscribe=yes"."\n";
      $ext_user .= "busylevel=1"."\n";
      $ext_user .= "notifyringing=yes"."\n";
      $ext_user .= "notifyhold=yes"."\n";
      $ext_user .= "notifycid=yes"."\n";

      /******** export ********/
      $array_result[$key]['user']   = "6".$ext_data->extension."-".$ext_data->site_name."-".$ext_data->tenant_name; //deep
      $array_result[$key]['pass']   = $pass;
      $array_result[$key]['server'] = $ext_data->site_name.".".$ext_data->tenant_name.".bizrtc.com";
      $array_result[$key]['proxy']  = $_SERVER['SERVER_ADDR'];
      $array_result[$key]['port']   = '7066';      
      $key++;
      /************************/

      //////  mobile_prefix ///////
      $ext_user .= "\n"."[7".$ext_data->extension."-".$ext_data->site_name."-".$ext_data->tenant_name."]"."\n";
      $ext_user .= "accountcode=".$accountCode."\n";
      $ext_user .= "type=friend"."\n";
      $ext_user .= "host=dynamic"."\n";
      $ext_user .= "defaultuser=7".$ext_data->extension."-".$ext_data->site_name."-".$ext_data->tenant_name."\n";
      $ext_user .= "secret=".$pass."\n";
      $ext_user .= "disallow=all"."\n";
      $ext_user .= "allow=g729"."\n";
      $ext_user .= "allow=ulaw"."\n";
      $ext_user .= "allow=alaw"."\n";
      $ext_user .= "allow=h263p"."\n";
      $ext_user .= "allow=h264"."\n";
      $ext_user .= "videosupport=yes"."\n";
      $ext_user .= "allowtransfer=yes"."\n";
      $ext_user .= "canreinvite=no"."\n";
      $ext_user .= "nat=force_rport,comedia"."\n";
      $ext_user .= "qualify=yes"."\n";
      $ext_user .= "dtmfmode=info"."\n";
      $ext_user .= 'callerid="ext'.$ext_data->extension.'" <'.$ext_data->extension.'>'."\n";
      $ext_user .= "context=".$ext_data->tenant_name."_".$ext_data->site_name."_og_".$ext_data->extension."\n";
      $ext_user .= "parkinglot=".$ext_data->tenant_name."_".$ext_data->site_name."_parking"."\n";
      $ext_user .= "domain=".$ext_data->site_name.".".$ext_data->tenant_name.".bizrtc.com"."\n";
      $ext_user .= "fromdomain=".$ext_data->site_name.".".$ext_data->tenant_name.".bizrtc.com"."\n";
      $ext_user .= "vmexten=".$ext_data->extension."\n";
      $ext_user .= "mailbox=".$ext_data->extension."@".$ext_data->tenant_name."_".$ext_data->site_name."\n";
      $ext_user .= "subscribecontext=".$ext_data->tenant_name."_".$ext_data->site_name."_".$ext_data->extension."\n";
      $ext_user .= "allowsubscribe=yes"."\n";
      $ext_user .= "busylevel=1"."\n";
      $ext_user .= "notifyringing=yes"."\n";
      $ext_user .= "notifyhold=yes"."\n";
      $ext_user .= "notifycid=yes"."\n";

      /******** export ********/
      $array_result[$key]['user']   = "7".$ext_data->extension."-".$ext_data->site_name."-".$ext_data->tenant_name; //deep
      $array_result[$key]['pass']   = $pass;
      $array_result[$key]['server'] = $ext_data->site_name.".".$ext_data->tenant_name.".bizrtc.com";
      $array_result[$key]['proxy']  = $_SERVER['SERVER_ADDR'];
      $array_result[$key]['port']   = '7066';      
      $key++;
      /************************/


      //////  desktop_prefix ///////
      $ext_user .= "\n"."[8".$ext_data->extension."-".$ext_data->site_name."-".$ext_data->tenant_name."]"."\n";
      $ext_user .= "accountcode=".$accountCode."\n";
      $ext_user .= "type=friend"."\n";
      $ext_user .= "host=dynamic"."\n";
      $ext_user .= "defaultuser=8".$ext_data->extension."-".$ext_data->site_name."-".$ext_data->tenant_name."\n";
      $ext_user .= "secret=".$pass."\n";
      $ext_user .= "disallow=all"."\n";
      $ext_user .= "allow=g729"."\n";
      $ext_user .= "allow=ulaw"."\n";
      $ext_user .= "allow=alaw"."\n";
      $ext_user .= "allow=h263p"."\n";
      $ext_user .= "allow=h264"."\n";
      $ext_user .= "videosupport=yes"."\n";
      $ext_user .= "allowtransfer=yes"."\n";
      $ext_user .= "canreinvite=no"."\n";
      $ext_user .= "nat=force_rport,comedia"."\n";
      $ext_user .= "qualify=yes"."\n";
      $ext_user .= "dtmfmode=info"."\n";
      $ext_user .= 'callerid="ext'.$ext_data->extension.'" <'.$ext_data->extension.'>'."\n";
      $ext_user .= "context=".$ext_data->tenant_name."_".$ext_data->site_name."_og_".$ext_data->extension."\n";
      $ext_user .= "parkinglot=".$ext_data->tenant_name."_".$ext_data->site_name."_parking"."\n";
      $ext_user .= "domain=".$ext_data->site_name.".".$ext_data->tenant_name.".bizrtc.com"."\n";
      $ext_user .= "fromdomain=".$ext_data->site_name.".".$ext_data->tenant_name.".bizrtc.com"."\n";
      $ext_user .= "vmexten=".$ext_data->extension."\n";
      $ext_user .= "mailbox=".$ext_data->extension."@".$ext_data->tenant_name."_".$ext_data->site_name."\n";
      $ext_user .= "subscribecontext=".$ext_data->tenant_name."_".$ext_data->site_name."_".$ext_data->extension."\n";
      $ext_user .= "allowsubscribe=yes"."\n";
      $ext_user .= "busylevel=1"."\n";
      $ext_user .= "notifyringing=yes"."\n";
      $ext_user .= "notifyhold=yes"."\n";
      $ext_user .= "notifycid=yes"."\n";

      /******** export ********/
      $array_result[$key]['user']   = "8".$ext_data->extension."-".$ext_data->site_name."-".$ext_data->tenant_name; //deep
      $array_result[$key]['pass']   = $pass;
      $array_result[$key]['server'] = $ext_data->site_name.".".$ext_data->tenant_name.".bizrtc.com";
      $array_result[$key]['proxy']  = $_SERVER['SERVER_ADDR'];
      $array_result[$key]['port']   = '7066';      
      $key++;
      /************************/

       fwrite($use_ext_file, $ext_user);

      }
       
    } 

    /******* Park Slot FILE *****/
     if(!empty($branchData)){
     
      $file      = '/etc/asterisk/bizRTCPBX/'.$tenantData->tenant_name.'/park_'.$tenantData->tenant_name.'_detail.conf';
      $park_slot = fopen($file, 'a') or die('Cannot open file: '.$file); 
     
      foreach ($branchData as $slot_details) {
      
          $park_details = "\n".'#include bizRTCPBX/'.$tenantData->tenant_name.'/park_'.$tenantData->tenant_name.'_detail.conf     ;'.$tenantData->tenant_name."\n"; 

          $parkslot_details .= "\n"."[".$slot_details->tenant_name."_".$slot_details->site_name."_parking]"."\n";
          $parkslot_details .= "courtesytone = beep"."\n"; 
          $parkslot_details .= "comebacktoorigin = yes"."\n"; 
          $parkslot_details .= "parkedmusicclass = ".$slot_details->moh."\n"; 
          $parkslot_details .= "parkext_exclusive=yes"."\n"; 
          $parkslot_details .= "parkinghints = yes"."\n"; 
          $parkslot_details .= "parkedcalltransfers = caller"."\n"; 
          $parkslot_details .= "parkedplay = caller"."\n"; 
          $parkslot_details .= "parkext=".$slot_details->park_extension."\n";
          
          if($slot_details->parking_slot > 0){
          $pos = $slot_details->park_extension + 1;
          if($slot_details->park_extension > 1){
           $endpos = $pos + $slot_details->parking_slot;
           $pos = $pos."-".$endpos;
          }
          }

          $parkslot_details .= "parkpos=".$pos."\n"; 
          $parkslot_details .= "parkingtime=220"."\n";    
          $parkslot_details .= "context => ".$slot_details->tenant_name."_".$slot_details->site_name."_parkedcalls"."\n";  
       }

       fwrite($park_slot, $parkslot_details);

     }
    /******* END FILE *******/


    /****** VOICE MAIL FILE ******/
    if(!empty($extensionData)){
      $file     = '/etc/asterisk/bizRTCPBX/'.$tenantData->tenant_name.'/voicemail_'.$tenantData->tenant_name.'_detail.conf';
      $voicemail = fopen($file, 'a') or die('Cannot open file: '.$file);

      foreach ($branchData as $branchdata) {
        $mail_data .= "\n"."[".$branchdata->tenant_name."_".$branchdata->site_name."]"."\n";   
      
      $extension = getExtensionData($tenant_id,$branchdata->id);
       foreach ($extension as $ext_data) {
        $mail_data .= '#include bizRTCPBX/'.$ext_data->tenant_name.'/voicemail_'.$ext_data->tenant_name.'_'.$ext_data->site_name.'_'.$ext_data->extension.'_vm.conf'."\n";  
       }

       }

      fwrite($voicemail, $mail_data); 
    }
    /********* END FILE *********/

    /***** USER WISE VOICE MAIL *****/
    if(!empty($extensionData)){
    
       foreach ($extensionData as $ext_data) {
      
        $file  = '/etc/asterisk/bizRTCPBX/'.$ext_data->tenant_name.'/voicemail_'.$ext_data->tenant_name.'_'.$ext_data->site_name.'_'.$ext_data->extension.'_vm.conf';
        $voicemail_user = fopen($file, 'a') or die('Cannot open file: '.$file);

        $mail_data_user = $ext_data->extension ." => ".$ext_data->extension.",,".$ext_data->vm_email.",,|tz=india||attach=yes|saycid=yes|envelop=yes|sayduration=yes|saydurationm=1"."\n"; 

        fwrite($voicemail_user, $mail_data_user); 
       }
      
    }
    /***** END USER WISE  MAIL *****/


    /****** EXTENSION CALL FILE *******/
    if(!empty($extensionData)){
      $file     = '/etc/asterisk/bizRTCPBX/'.$tenantData->tenant_name.'/extensions_'.$tenantData->tenant_name.'_call_detail.conf';
      $ext_call_file = fopen($file, 'a') or die('Cannot open file: '.$file); 

      foreach ($extensionData as $call_ext) {
      $call_file_etx .= "\n".'#include bizRTCPBX/'.$call_ext->tenant_name.'/extensions_'.$call_ext->tenant_name.'_'.$call_ext->site_name.'_'.$call_ext->extension.'_call.conf'. "\n";
      $call_file_etx .= "\n".'#include bizRTCPBX/'.$call_ext->tenant_name.'/extensions_'.$call_ext->tenant_name.'_'.$call_ext->site_name.'_'.$call_ext->extension.'_outgoingcall.conf'. "\n";
      if($call_ext->extension_type == 'Super'){
      $call_file_etx .= "\n".'#include bizRTCPBX/'.$call_ext->tenant_name.'/extensions_'.$call_ext->tenant_name.'_'.$call_ext->site_name.'_'.$call_ext->extension.'_callmonitor.conf'. "\n";
      }
      }

      fwrite($ext_call_file, $call_file_etx);

      foreach ($branchData as $call_branch) {

        $call_branch_data .= "\n".'#include bizRTCPBX/'.$call_branch->tenant_name.'/extensions_'.$call_branch->tenant_name.'_'.$call_branch->site_name.'_park.conf'. "\n";
        $call_branch_data .= "\n".'#include bizRTCPBX/'.$call_branch->tenant_name.'/extensions_'.$call_branch->tenant_name.'_'.$call_branch->site_name.'_extdial_internal.conf'. "\n";
        $call_branch_data .= "\n".'#include bizRTCPBX/'.$call_branch->tenant_name.'/extensions_'.$call_branch->tenant_name.'_'.$call_branch->site_name.'_callforward.conf'. "\n";
        $call_branch_data .= "\n".'#include bizRTCPBX/'.$call_branch->tenant_name.'/extensions_'.$call_branch->tenant_name.'_'.$call_branch->site_name.'_confpin.conf'. "\n";

      }

      fwrite($ext_call_file, $call_branch_data);
        
      /***** INTER FOOICE FILE *******/
      $interoffice = "\n".'#include bizRTCPBX/'.$tenantData->tenant_name.'/extensions_'.$tenantData->tenant_name.'_extdial_interoffice_internal.conf'."\n";
      fwrite($ext_call_file, $interoffice);
      /********* END FILE ********/
       
      /******* CALL IVR FILE ******/
      if(!empty($ivrConfigData)){
        foreach ($ivrConfigData as $ivr_data) {
          $call_ivr .= "\n".'#include bizRTCPBX/'.$ivr_data->tenant_name.'/extensions_'.$ivr_data->tenant_name.'_'.$ivr_data->site_name.'_external_'.$ivr_data->did.'_ivr_incomingcall.conf'." \n";          
        }

        fwrite($ext_call_file, $call_ivr);
      }
      /********** END FILE ********/

       /******* CALL IVR FILE ******/ 
      if(!empty($trunkDIDData)){
        foreach ($trunkDIDData as $data) {
        if($data->did_type == 'extensions' AND $data->extension != ''){
          $call_incom .= "\n".'#include bizRTCPBX/'.$data->tenant_name.'/extensions_'.$data->tenant_name.'_'.$data->site_name.'_external_'.$data->did_number.'_incomingcall.conf'." \n";        
            //#include bizRTCPBX/Bizrtc/extensions_Bizrtc_mumbai_external_01205097548_incomingcall.conf  
         }
         if($data->did_type == 'conference'){
          $call_incom .= "\n".'#include bizRTCPBX/'.$data->tenant_name.'/extensions_'.$data->tenant_name.'_'.$data->site_name.'_external_'.$data->did_number.'_conference_incomingcall.conf'." \n";        
         }
          
        }

        fwrite($ext_call_file, $call_incom);
      }
      /********** END FILE ********/
     
     }
    /************ END FILE ***********/


    /******* EXT EISE CALL CONF FIEL *******/ 
    if(!empty($extensionData)){

      foreach ($extensionData as $call_user) {
      $file     = '/etc/asterisk/bizRTCPBX/'.$call_user->tenant_name.'/extensions_'.$call_user->tenant_name.'_'.$call_user->site_name.'_'.$call_user->extension.'_call.conf';
      $user_call_file = fopen($file, 'a') or die('Cannot open file: '.$file); 

       $user_call_details = '['.$call_user->tenant_name.'_'.$call_user->site_name.'_'.$call_user->extension.']      
        exten => '.$call_user->extension.'/'.$call_user->extension.',1,goto('.$call_user->tenant_name.'_'.$call_user->site_name.'_'.$call_user->extension.'_vmctx,'.$call_user->extension.',1)

        exten => '.$call_user->extension.',1,NoOP(Recording not enabled going to next step)
        exten => '.$call_user->extension.',2,NoOP(Recording not enabled going to next step)
        exten => '.$call_user->extension.',3,NoOP(Recording not enabled going to next step)
        exten => '.$call_user->extension.',4,NoOP(Recording not enabled going to next step)
        exten => '.$call_user->extension.',5(CFUC),Gotoif($[${DB_EXISTS(CFUC_'.$call_user->tenant_name.'_'.$call_user->site_name.'/${EXTEN})}]?CFUCdial:dial) 
        exten => '.$call_user->extension.',n(CFUCdial),Dial(SIP/${DB(CFUC_'.$call_user->tenant_name.'_'.$call_user->site_name.'/${EXTEN})},40)
        exten => '.$call_user->extension.',n(CFUCdial2),goto('.$call_user->tenant_name.'_'.$call_user->site_name.'_og_'.$call_user->extension.',${DB(CFUC_'.$call_user->tenant_name.'_'.$call_user->site_name.'/${EXTEN})},1)
        exten => '.$call_user->extension.',n(dial),NoOP() 
        exten => '.$call_user->extension.',n(dial2),Set(from=${SIP_HEADER(FROM)}) ;extdn=${CUT(DN1FROM,@,1)})
        exten => '.$call_user->extension.',n(dial3),Set(from2=${CUT(from,:,2)}) ;extdn=${CUT(DN1FROM,@,1)}) 
        exten => '.$call_user->extension.',n(dial4),Set(CDR(extsrc)=${CUT(from2,@,1)}) ;extdn=${CUT(DN1FROM,@,1)}) 
        exten => '.$call_user->extension.',n(dial5),noop(extsrc is $extsrc and ${extsrc}) 
        exten => '.$call_user->extension.',n(dial6),Set(to1=${CUT(SIP_HEADER(TO),@,1)}); 
        exten => '.$call_user->extension.',n(dial7),Set(to2=${CUT(to1,:,2)}); 
        exten => '.$call_user->extension.',n(dial8),Set(CDR(extdst)=${to2}-'.$call_user->site_name.'-'.$call_user->tenant_name.'); 
        exten => '.$call_user->extension.',n(dial9),noop(extdst is $extdst and ${extdst} sipto is ${SIP_HEADER(TO)}) 
        exten => '.$call_user->extension.',n(dial10),Dial(SIP/6'.$call_user->extension.'-'.$call_user->site_name.'-'.$call_user->tenant_name.'&SIP/7'.$call_user->extension.'-'.$call_user->site_name.'-'.$call_user->tenant_name.'&SIP/8'.$call_user->extension.'-'.$call_user->site_name.'-'.$call_user->tenant_name.',30) 
        exten => '.$call_user->extension.',n(dial11),Goto(CFNA)
        exten => '.$call_user->extension.',n(CFNA),Gotoif($[${DB_EXISTS(CFNA_'.$call_user->tenant_name.'_'.$call_user->site_name.'/${EXTEN})}]?CFNAdial:voicemail) 
        exten => '.$call_user->extension.',n(CFNAdial),Dial(SIP/${DB(CFNA_'.$call_user->tenant_name.'_'.$call_user->site_name.'/${EXTEN})},40) 
        exten => '.$call_user->extension.',n(CFNAdial2),goto('.$call_user->tenant_name.'_'.$call_user->site_name.'_og_'.$call_user->extension.',${DB(CFNA_'.$call_user->tenant_name.'_'.$call_user->site_name.'/${EXTEN})},1) 
        exten => '.$call_user->extension.',n(voicemail),Voicemail('.$call_user->extension.'@'.$call_user->tenant_name.'_'.$call_user->site_name.',u) 
        exten => '.$call_user->extension.',n,hangup 

        exten => '.$call_user->extension.',hint,SIP/6'.$call_user->extension.'&SIP/7'.$call_user->extension.'&SIP/8'.$call_user->extension.' 
        exten => '.$call_user->extension.'-'.$call_user->site_name.'-'.$call_user->tenant_name.',hint,SIP/6'.$call_user->extension.'-'.$call_user->site_name.'-'.$call_user->tenant_name.'&SIP/7'.$call_user->extension.'-'.$call_user->site_name.'-'.$call_user->tenant_name.'&SIP/8'.$call_user->extension.'-'.$call_user->site_name.'-'.$call_user->tenant_name.'  

        ['.$call_user->tenant_name.'_'.$call_user->site_name.'_'.$call_user->extension.'_vmctx]
        exten => '.$call_user->extension.'/'.$call_user->extension.',1,VoiceMailMain(s'.$call_user->extension.'@'.$call_user->tenant_name.'_'.$call_user->site_name.')';

        fwrite($user_call_file, $user_call_details);
      
       }
    }
    /************** END FILE ***************/


    /****** OUTGOING CALL DETAILS FILE *********/
      if(!empty($branchData)){

        foreach ($branchData as $branch_data) {
        $ext     = substr($branch_data->park_extension, 0,4);       
        $preffix = $branch_data->branch_prefix;

        $extension = getExtensionData($tenant_id,$branch_data->id);
        foreach ($extension as $ext_data) {

        $file     = '/etc/asterisk/bizRTCPBX/'.$branch_data->tenant_name.'/extensions_'.$branch_data->tenant_name.'_'.$branch_data->site_name.'_'.$ext_data->extension.'_outgoingcall.conf';
        $outgoing_call_file = fopen($file, 'a') or die('Cannot open file: '.$file); 

        $out_call = '';
        $out_call = '['.$branch_data->tenant_name.'_'.$branch_data->site_name.'_og_'.$ext_data->extension.']
        
        include => extdial_'.$branch_data->tenant_name.'_'.$branch_data->site_name.' 
          
        ;;;; interoffice trunk access dial plan 
          
        exten => _'.$preffix.'XXXXXXXXXX,1,Set(MONITOR_FILENAME=${STRFTIME(${EPOCH},,%Y%m%d-%H%M%S)}-${EXTEN}-${CALLERID(num)})
        exten => _'.$preffix.'XXXXXXXXXX,n,Set(CDR(recordingfile)=${MONITOR_FILENAME}.mp3) 
        exten => _'.$preffix.'XXXXXXXXXX,n,Set(DIR=bizRTCPBX/'.$branch_data->tenant_name.') 
        exten => _'.$preffix.'XXXXXXXXXX,n,MixMonitor(${MONITOR_FILENAME}.wav,W(4),/var/spool/asterisk/wav2mp3 ^{MONITOR_FILENAME}.wav ${DIR})
        exten => _'.$preffix.'XXXXXXXXXX,n,Set(CDR(accountcode)='.$accountCode.') 
        exten => _'.$preffix.'XXXXXXXXXX,n,Set(CDR(extsrc)='.$ext_data->extension.'-'.$branch_data->site_name.'-'.$branch_data->tenant_name.') 
        exten => _'.$preffix.'XXXXXXXXXX,n,Set(CDR(extdst)=${EXTEN}) 
        exten => _'.$preffix.'XXXXXXXXXX,n,dial(SIP/91${EXTEN:1}@0'.$branch_data->did.') 
        exten => _'.$preffix.'XXXXXXXXXX,n,hangup 
          
        exten => _'.$preffix.'00XXXXXXXXXX.,1,Set(MONITOR_FILENAME=${STRFTIME(${EPOCH},,%Y%m%d-%H%M%S)}-${EXTEN}-${CALLERID(num)})
        exten => _'.$preffix.'00XXXXXXXXXX.,n,Set(CDR(recordingfile)=${MONITOR_FILENAME}.mp3) 
        exten => _'.$preffix.'00XXXXXXXXXX.,n,Set(DIR=bizRTCPBX/'.$branch_data->tenant_name.') 
        exten => _'.$preffix.'00XXXXXXXXXX.,n,MixMonitor(${MONITOR_FILENAME}.wav,W(4),/var/spool/asterisk/wav2mp3 ^{MONITOR_FILENAME}.wav ${DIR})
        exten => _'.$preffix.'00XXXXXXXXXX.,n,Set(CDR(accountcode)='.$accountCode.') 
        exten => _'.$preffix.'00XXXXXXXXXX.,n,Set(CDR(extsrc)='.$ext_data->extension.'-'.$branch_data->site_name.'-'.$branch_data->tenant_name.') 
        exten => _'.$preffix.'00XXXXXXXXXX.,n,Set(CDR(extdst)=${EXTEN}) 
        exten => _'.$preffix.'00XXXXXXXXXX.,n,dial(SIP/${EXTEN:1}@'.$branch_data->did.') 
        exten => _'.$preffix.'00XXXXXXXXXX.,n,hangup 
          
        exten => _'.$preffix.'011XXXXXXXXXX.,1,Set(MONITOR_FILENAME=${STRFTIME(${EPOCH},,%Y%m%d-%H%M%S)}-${EXTEN}-${CALLERID(num)})
        exten => _'.$preffix.'011XXXXXXXXXX.,n,Set(CDR(recordingfile)=${MONITOR_FILENAME}.mp3) 
        exten => _'.$preffix.'011XXXXXXXXXX.,n,Set(DIR=bizRTCPBX/'.$branch_data->tenant_name.') 
        exten => _'.$preffix.'011XXXXXXXXXX.,n,MixMonitor(${MONITOR_FILENAME}.wav,W(4),/var/spool/asterisk/wav2mp3 ^{MONITOR_FILENAME}.wav ${DIR})
        exten => _'.$preffix.'011XXXXXXXXXX.,n,Set(CDR(accountcode)='.$accountCode.') 
        exten => _'.$preffix.'011XXXXXXXXXX.,n,Set(CDR(extsrc)='.$ext_data->extension.'-'.$branch_data->site_name.'-'.$branch_data->tenant_name.') 
        exten => _'.$preffix.'011XXXXXXXXXX.,n,Set(CDR(extdst)=${EXTEN}) 
        exten => _'.$preffix.'011XXXXXXXXXX.,n,dial(SIP/00${EXTEN:4}@'.$branch_data->did.') 
        exten => _'.$preffix.'011XXXXXXXXXX.,n,hangup 
           
        ;; for monitoring
         
        exten => _'.$ext.'22X,1,goto('.$branch_data->tenant_name.'_'.$branch_data->site_name.'_callmonitor'.$ext.',${EXTEN},1)
          
        ;; for conference 
         
        exten => '.$ext.'200,1,ConfBridge(int_cb_'.$branch_data->tenant_name.'_'.$branch_data->site_name.') 
         
        exten => _'.$ext.'20X,1,goto('.$branch_data->tenant_name.'_'.$branch_data->site_name.'_conf,${EXTEN},1) 
          
        ;; for park and reterieve
         
        exten => _'.$ext.'8XX,1,goto('.$branch_data->tenant_name.'_'.$branch_data->site_name.'_park_ft,${EXTEN},1)
         
        ;; for call forward
        exten => _'.$ext.'6X,1,goto('.$branch_data->tenant_name.'_'.$branch_data->site_name.'_callcf,${EXTEN},1) 
         
        exten => _'.$ext.'7X,1,goto('.$branch_data->tenant_name.'_'.$branch_data->site_name.'_callcf,${EXTEN},1)'; 
         
        
        if(strlen($ext_data->extension) != '4'){
        $out_call .= 'exten => _XXXX,1,GotoIF($[${DB_EXISTS(SPD_'.$branch_data->tenant_name.'_'.$branch_data->site_name.'/${EXTEN})}]?spddial:) 
        exten => _XXXX,2(spddial),Set(NEXTEN=${DB(SPD_'.$branch_data->tenant_name.'_'.$branch_data->site_name.'/${EXTEN})}) 
        exten => _XXXX,3(spddial2),goto('.$branch_data->tenant_name.'_'.$branch_data->site_name.'_og_'.$ext_data->extension.',${NEXTEN},6)'; 
        }
         
        if(strlen($ext_data->extension) != '3'){ 
        $out_call .= 'exten => _XXX,1,GotoIF($[${DB_EXISTS(SPD_'.$branch_data->tenant_name.'_'.$branch_data->site_name.'/${EXTEN})}]?spddial:) 
        exten => _XXX,2(spddial),Set(NEXTEN=${DB(SPD_'.$branch_data->tenant_name.'_'.$branch_data->site_name.'/${EXTEN})}) 
        exten => _XXX,3(spddial2),goto('.$branch_data->tenant_name.'_'.$branch_data->site_name.'_og_'.$ext_data->extension.',${NEXTEN},6)'; 
        }
         
        if(strlen($ext_data->extension) != '2'){ 
        $out_call .= 'exten => _XX,1,GotoIF($[${DB_EXISTS(SPD_'.$branch_data->tenant_name.'_'.$branch_data->site_name.'/${EXTEN})}]?spddial:) 
        exten => _XX,2(spddial),Set(NEXTEN=${DB(SPD_'.$branch_data->tenant_name.'_'.$branch_data->site_name.'/${EXTEN})}) 
        exten => _XX,3(spddial2),goto('.$branch_data->tenant_name.'_'.$branch_data->site_name.'_og_'.$ext_data->extension.',${NEXTEN},6)'; 
        }

        $out_call .=';; here we define rules for outgoing calls 
         
        exten => _91XXXXXXXXXX,1,goto('.$branch_data->tenant_name.'_'.$branch_data->site_name.'_og_'.$ext_data->extension.',${EXTEN:2},2) 
         
        exten => _+91XXXXXXXXXX,1,goto('.$branch_data->tenant_name.'_'.$branch_data->site_name.'_og_'.$ext_data->extension.',${EXTEN:3},2) 
         
        exten => _XXXXXXXX.,6,Set(clb="${DB(COG_'.$branch_data->tenant_name.'_'.$branch_data->site_name.'/calleridblk)}") 
        exten => _XXXXXXXX.,n,gotoif($[${EXTEN:-10}:${clb}]?fail:fine) 
        exten => _XXXXXXXX.,n(fail),Playback(the-number-u-dialed&is&disabled) 
        exten => _XXXXXXXX.,n(fail2),hangup() 
        exten => _XXXXXXXX.,n(fine),goto('.$branch_data->tenant_name.'_'.$branch_data->site_name.'_og_'.$ext_data->extension.',${EXTEN},11)
         
        exten => _00XXXXXXXX.,1,goto('.$branch_data->tenant_name.'_'.$branch_data->site_name.'_og_'.$ext_data->extension.',${EXTEN},2) 
        exten => _011XXXXXXXX.,1,goto('.$branch_data->tenant_name.'_'.$branch_data->site_name.'_og_'.$ext_data->extension.',00${EXTEN:3},1) 
        exten => _+XXXXXXXX.,1,goto('.$branch_data->tenant_name.'_'.$branch_data->site_name.'_og_'.$ext_data->extension.',00${EXTEN:1},1) 
         
        exten => _XXXXXXXX.,1,NoOP(len is ${LEN(${EXTEN})} and ext is ${EXTEN} and extlen is ${LEN(${EXTEN})}) 
        exten => _XXXXXXXX.,2,Set(extlen=${LEN(${EXTEN})}) 
        exten => _XXXXXXXX.,3,GotoIf($[${extlen} = 4]?goext:chkext) 
        exten => _XXXXXXXX.,4(goext),goto(extdial_'.$branch_data->tenant_name.'_'.$branch_data->site_name.',${EXTEN},1) 
        exten => _XXXXXXXX.,5(chkext),goto('.$branch_data->tenant_name.'_'.$branch_data->site_name.'_og_'.$ext_data->extension.',${EXTEN},6) 
        exten => _XXXXXXXX.,11,Set(MONITOR_FILENAME=${STRFTIME(${EPOCH},,%Y%m%d-%H%M%S)}-${EXTEN}-${CALLERID(num)})
        exten => _XXXXXXXX.,n,Set(CDR(recordingfile)=${MONITOR_FILENAME}.mp3) 
        exten => _XXXXXXXX.,n,Set(DIR=bizRTCPBX/'.$branch_data->tenant_name.') 
        exten => _XXXXXXXX.,n,MixMonitor(${MONITOR_FILENAME}.wav,W(4),/var/spool/asterisk/wav2mp3 ^{MONITOR_FILENAME}.wav ${DIR})
        exten => _XXXXXXXX.,n,Set(CDR(accountcode)='.$accountCode.') 
        exten => _XXXXXXXX.,n,Set(CDR(extsrc)='.$ext.'-'.$branch_data->site_name.'-'.$branch_data->tenant_name.') 
        exten => _XXXXXXXX.,n,Set(CDR(extdst)=${EXTEN}) 
        exten => _XXXXXXXX.,n,Set(ext=${EXTEN}) 
        exten => _XXXXXXXX.,n,Set(extlen=${LEN(${EXTEN})}) 
        exten => _XXXXXXXX.,n,GotoIf($[${extlen} > 12]?isd:national) 
        exten => _XXXXXXXX.,n(isd),NoOP(yes i came in isd ) ; Dial(SIP/@trunk) 
        exten => _XXXXXXXX.,n(isd2),Dial(SIP/${EXTEN}@'.$branch_data->did.') 
        exten => _XXXXXXXX.,n(national),Dial(SIP/91${EXTEN}@'.$branch_data->did.') 
        exten => _XXXXXXXX.,n(national2),hangup 
        exten => _XXXXXXXX.,n,hangup';

        fwrite($outgoing_call_file, $out_call);

       
         /******* MONNITOER FILE ********/
         // deep
        if($ext_data->extension_type == 'Super'){
        $file_monit     = '/etc/asterisk/bizRTCPBX/'.$branch_data->tenant_name.'/extensions_'.$branch_data->tenant_name.'_'.$branch_data->site_name.'_'.$ext.'_callmonitor.conf';
        $monit_call_file = fopen($file_monit, 'a') or die('Cannot open file: '.$file); 

            $monitoring = '['.$branch_data->tenant_name.'_'.$branch_data->site_name.'_callmonitor'.$ext.']

            ;listen 

            exten => '.$ext.'222,1,Answer  
            exten => '.$ext.'222,n,Playback(hello) 
            exten => '.$ext.'222,n,Playback(vm-enter-num-to-call&vm-then-pound) 
            exten => '.$ext.'222,n,Read(NUM) 
            ;exten => '.$ext.'222,n,NoCDR 
            exten => '.$ext.'222,n,Set(lnnumlen=${LEN(${NUM})}) 
            exten => '.$ext.'222,n,GotoIf($[${lnnumlen} = 0]?lnplayzro:lnnxt) 
            exten => '.$ext.'222,n(lnplayzro),Playback(vm-pls-try-again) 
            exten => '.$ext.'222,n(lnplayzro1),hangup 
            exten => '.$ext.'222,n(lnnxt),GotoIf($[${lnnumlen} > 1]?lnsuccs:lnfailnum) 
            exten => '.$ext.'222,n(lnfailnum),Playback(option-is-invalid) 
            exten => '.$ext.'222,n(lnfailnum1),hangup 
            exten => '.$ext.'222,n(lnsuccs),Wait(1) 
            exten => '.$ext.'222,n(lnsuccs1),ChanSpy(SIP/${NUM}-'.$branch_data->site_name.'-'.$branch_data->tenant_name.',q) 
            exten => '.$ext.'222,n,Hangup 

            ;whisper ChanSpy(sip/,qw) 

            exten => '.$ext.'223,1,Answer 
            exten => '.$ext.'223,n,Playback(hello)
            exten => '.$ext.'223,n,Playback(vm-enter-num-to-call&vm-then-pound)
            exten => '.$ext.'223,n,Read(NUM) 
            ;exten => '.$ext.'223,n,NoCDR 
            exten => '.$ext.'223,n,Set(wsnumlen=${LEN(${NUM})}) 
            exten => '.$ext.'223,n,GotoIf($[${wsnumlen} = 0]?wsplayzro:wsnxt) 
            exten => '.$ext.'223,n(wsplayzro),Playback(vm-pls-try-again) 
            exten => '.$ext.'223,n(wsplayzro1),hangup 
            exten => '.$ext.'223,n(wsnxt),GotoIf($[${wsnumlen} > 1]?wssuccs:wsfailnum) 
            exten => '.$ext.'223,n(wsfailnum),Playback(option-is-invalid) 
            exten => '.$ext.'223,n(wsfailnum1),hangup 
            exten => '.$ext.'223,n(wssuccs),Wait(1) 
            exten => '.$ext.'223,n(wssuccs1),ChanSpy(SIP/${NUM}-'.$branch_data->site_name.'-'.$branch_data->tenant_name.',qw) 
            exten => '.$ext.'223,n,Hangup 

            ;Barge ChanSpy(SIP/,qB)  

            exten => '.$ext.'224,1,Answer 
            exten => '.$ext.'224,n,Playback(hello) 
            exten => '.$ext.'224,n,Playback(vm-enter-num-to-call&vm-then-pound) 
            exten => '.$ext.'224,n,Read(NUM) 
            ;exten => '.$ext.'224,n,NoCDR 
            exten => '.$ext.'224,n,Set(bgnumlen=${LEN(${NUM})}) 
            exten => '.$ext.'224,n,GotoIf($[${bgnumlen} = 0]?bgplayzro:bgnxt) 
            exten => '.$ext.'224,n(bgplayzro),Playback(vm-pls-try-again) 
            exten => '.$ext.'224,n(bgplayzro1),hangup 
            exten => '.$ext.'224,n(bgnxt),GotoIf($[${bgnumlen} > 1]?bgsuccs:bgfailnum) 
            exten => '.$ext.'224,n(bgfailnum),Playback(option-is-invalid) 
            exten => '.$ext.'224,n(bgfailnum1),hangup 
            exten => '.$ext.'224,n(bgsuccs),Wait(1) 
            exten => '.$ext.'224,n(bgsuccs1),ChanSpy(SIP/${NUM}-'.$branch_data->site_name.'-'.$branch_data->tenant_name.',qB) 
            exten => '.$ext.'224,n,Hangup'; 
          
            fwrite($monit_call_file, $monitoring);       
          /********* END FILE ***********/
         }

        } //// ext loop

       
        /******* CALL FORWORD FILE ****/
        $file_fwd     = '/etc/asterisk/bizRTCPBX/'.$branch_data->tenant_name.'/extensions_'.$branch_data->tenant_name.'_'.$branch_data->site_name.'_callforward.conf';
        $fwd_call_file = fopen($file_fwd, 'a') or die('Cannot open file: '.$file); 


        $fwd_data ='['.$branch_data->tenant_name.'_'.$branch_data->site_name.'_callcf]
        ;enable Call Forward Unconditional CFUC
        exten => '.$ext.'66,1,Answer()
        exten => '.$ext.'66,n,Playback(hello) 
        exten => '.$ext.'66,n,Playback(vm-enter-num-to-call&vm-then-pound) 
        exten => '.$ext.'66,n,Read(NUM)
        exten => '.$ext.'66,n,Set(DB(CFUC_'.$branch_data->tenant_name.'_'.$branch_data->site_name.'/${CALLERID(number)})=${NUM})
        exten => '.$ext.'66,n,Playback(enabled) 
        exten => '.$ext.'66,n,Hangup() 


        ;disable CFUC 
        exten => '.$ext.'67,1,Answer() 
        exten => '.$ext.'67,2,NoOp(${DB_DELETE(CFUC_'.$branch_data->tenant_name.'_'.$branch_data->site_name.'/${CALLERID(number)})}) 
        exten => '.$ext.'67,n,Playback(disabled) 
        exten => '.$ext.'67,n,Hangup() 


        ;enable Call No answer CFNA 
        exten => '.$ext.'68,1,Answer() 
        exten => '.$ext.'68,n,Playback(hello) 
        exten => '.$ext.'68,n,Playback(vm-enter-num-to-call&vm-then-pound) 
        exten => '.$ext.'68,n,Read(NUM) 
        exten => '.$ext.'68,n,Set(DB(CFNA_'.$branch_data->tenant_name.'_'.$branch_data->site_name.'/${CALLERID(number)})=${NUM})
        exten => '.$ext.'68,n,Playback(enabled) 
        exten => '.$ext.'68,n,Hangup() 


        ;disable CFNA  
        exten => '.$ext.'69,1,Answer() 
        exten => '.$ext.'69,2,NoOp(${DB_DELETE(CFNA_'.$branch_data->tenant_name.'_'.$branch_data->site_name.'/${CALLERID(number)}) } ) 
        exten => '.$ext.'69,3,Playback(disabled) 
        exten => '.$ext.'69,n,Hangup() 

        ;enable Call block for outbound 
        exten => '.$ext.'61,1,Answer() 
        exten => '.$ext.'61,n,Playback(hello) 
        exten => '.$ext.'61,n,Playback(privacy-to-blacklist-this-number&vm-then-pound) 
        exten => '.$ext.'61,n,Read(NUM) 
        exten => '.$ext.'61,n,Set(DB(COG_'.$branch_data->tenant_name.'_'.$branch_data->site_name.'/calleridblk)=${NUM}|${DB(COG_'.$branch_data->tenant_name.'_'.$branch_data->site_name.'/calleridblk)}) 
        exten => '.$ext.'61,n,Playback(enabled) 
        exten => '.$ext.'61,n,Hangup() 

        ;disable Call outbound 
        exten => '.$ext.'62,1,Answer() 
        exten => '.$ext.'62,2,NoOp(${DB_DELETE(COG_'.$branch_data->tenant_name.'_'.$branch_data->site_name.'/calleridblk)}) 
        exten => '.$ext.'62,n,Playback(disabled) 
        exten => '.$ext.'62,n,Hangup() 

        ;enable call inbound 
        exten => '.$ext.'63,1,Answer() 
        exten => '.$ext.'63,n,Playback(hello) 
        exten => '.$ext.'63,n,Playback(please-enter-the&telephone-number&vm-then-pound) 
        exten => '.$ext.'63,n,Read(DID)
        exten => '.$ext.'63,n,Playback(privacy-to-blacklist-this-number&vm-then-pound)
        exten => '.$ext.'63,n,Read(NUM) 
        exten => '.$ext.'63,n,Set(DB(CIG_'.$branch_data->tenant_name.'_'.$branch_data->site_name.'/${DID})=${NUM}|${DB(CIG_'.$branch_data->tenant_name.'_'.$branch_data->site_name.'/${DID})}) 
        exten => '.$ext.'63,n,Playback(enabled) 
        exten => '.$ext.'63,n,Hangup() 

        ;disable Call inbound 
        exten => '.$ext.'64,1,Answer() 
        exten => '.$ext.'64,n,Playback(please-enter-the&telephone-number&vm-then-pound) 
        exten => '.$ext.'64,n,Read(DID) 
        exten => '.$ext.'64,n,NoOp(${DB_DELETE(CIG_'.$branch_data->tenant_name.'_'.$branch_data->site_name.'/${DID})}) 
        exten => '.$ext.'64,n,Playback(disabled) 
        exten => '.$ext.'64,n,Hangup() 

        ;enable speed dial 
        exten => '.$ext.'71,1,Answer() 
        exten => '.$ext.'71,n,Playback(hello) 
        exten => '.$ext.'71,n,Playback(vm-toenternumber&vm-then-pound) 
        exten => '.$ext.'71,n,Read(spdext) 
        exten => '.$ext.'71,n,Playback(vm-enter-num-to-call&vm-then-pound) 
        exten => '.$ext.'71,n,Read(NUM) 
        exten => '.$ext.'71,n,Set(DB(SPD_'.$branch_data->tenant_name.'_'.$branch_data->site_name.'/${spdext})=${NUM}) 
        exten => '.$ext.'71,n,Playback(enabled) 
        exten => '.$ext.'71,n,Hangup() 

        ;read speed dial numbers 
        exten => '.$ext.'72,1,Playback(welcome) 
        exten => '.$ext.'72,n,Playback(vm-enter-num-to-call&vm-then-pound) 
        exten => '.$ext.'72,n,Read(NUM) 
        exten => '.$ext.'72,n,Set(readspd=${DB(SPD_'.$branch_data->tenant_name.'_'.$branch_data->site_name.'/${NUM})}) 
        exten => '.$ext.'72,n,SayDigits(${readspd}) 
        exten => '.$ext.'72,n,Playback(goodbye) 
        exten => '.$ext.'72,n,hangup 

        ;delete speed dial set 
        exten => '.$ext.'73,1,Playback(pm-prompt-number&vm-then-pound) 
        exten => '.$ext.'73,n,Read(NUM) 
        exten => '.$ext.'73,n,NoOp(${DB_DELETE(SPD_'.$branch_data->tenant_name.'_'.$branch_data->site_name.'/${NUM})}) 
        exten => '.$ext.'73,n,Playback(disabled) 
        exten => '.$ext.'73,n,Hangup()'; 

        fwrite($fwd_call_file, $fwd_data);
        /********* END FILE ***********/


        /******* CALL FORWORD FILE ****/
        $file_confpin  = '/etc/asterisk/bizRTCPBX/'.$branch_data->tenant_name.'/extensions_'.$branch_data->tenant_name.'_'.$branch_data->site_name.'_confpin.conf';
        $confpin_file = fopen($file_confpin, 'a') or die('Cannot open file: '.$file); 


        $confpin_data ='['.$branch_data->tenant_name.'_'.$branch_data->site_name.'_conf]
 
        ;; set conference pin 

        exten => '.$ext.'201,1,NoOP(setting the conference password) 
        exten => '.$ext.'201,n,Playback(hello) 
        exten => '.$ext.'201,n,Playback(pls-enter-conf-password) 
        exten => '.$ext.'201,n,Read(confpswd) 
        exten => '.$ext.'201,n,Set(DB(ConfPWD_'.$branch_data->tenant_name.'_'.$branch_data->site_name.'/'.$branch_data->site_name.'_200)=${confpswd}) 
        exten => '.$ext.'201,n,Playback(vm-password) 
        exten => '.$ext.'201,n,SayDigits(${confpswd}) 
        exten => '.$ext.'201,n,Playback(enabled) 
        exten => '.$ext.'201,n,hangup 

        ;; remove conference pin set 

        exten => '.$ext.'202,1,Answer() 
        exten => '.$ext.'202,n,NoOP(${DB_DELETE(ConfPWD_'.$branch_data->tenant_name.'_'.$branch_data->site_name.'/'.$branch_data->site_name.'_200)}) 
        exten => '.$ext.'202,n,playback(removed) 
        exten => '.$ext.'202,n,Playback(goodbye) 
        exten => '.$ext.'202,n,hangup 

        ;; say conference pin set  

        exten => '.$ext.'203,1,Answer() 
        exten => '.$ext.'203,n,Playback(welcome) 
        exten => '.$ext.'203,n,Set(cnfpwd=${DB(ConfPWD_'.$branch_data->tenant_name.'_'.$branch_data->site_name.'/'.$branch_data->site_name.'_200)}) 
        exten => '.$ext.'203,n,SayDigits(${cnfpwd}) 
        exten => '.$ext.'203,n,Playback(goodbye) 
        exten => '.$ext.'203,n,hangup'; 

        fwrite($confpin_file, $confpin_data);
        /********* END FILE ***********/

        /******* CALL PARK FILE ****/
        $file_park_branch  = '/etc/asterisk/bizRTCPBX/'.$branch_data->tenant_name.'/extensions_'.$branch_data->tenant_name.'_'.$branch_data->site_name.'_park.conf';
        $park_branch = fopen($file_park_branch, 'a') or die('Cannot open file: '.$file); 


        $park_branch_data ='['.$branch_data->tenant_name.'_'.$branch_data->site_name.'_park_ft]  
  
        exten => '.$ext.'800,1,Answer
        exten => '.$ext.'800,n,Wait(1)
        exten => '.$ext.'800,n,Set(_PARKINGLOT='.$branch_data->tenant_name.'_parking)
        exten => '.$ext.'800,n,Set(DN1BF=${BLINDTRANSFER}) 
        exten => '.$ext.'800,n,Set(DN1=${CUT(DN1BF,/,2)}) 
        exten => '.$ext.'800,n,Set(DN1=${CUT(DN1,-,1):0:5}) 
        exten => '.$ext.'800,n,NoOP(value of dn is ${DN} and dn1 is ${DN1} blindxfer is ${BLINDTRANSFER} ) 
        exten => '.$ext.'800,n,Set(MONITOR_FILENAME=${STRFTIME(${EPOCH},,%Y%m%d-%H%M%S)}-${EXTEN}-${DN1})
        exten => '.$ext.'800,n,Set(CDR(recordingfile)=${MONITOR_FILENAME}.mp3)
        exten => '.$ext.'800,n,Set(DIR=bizRTCPBX/'.$branch_data->tenant_name.') 
        exten => '.$ext.'800,n,MixMonitor(${MONITOR_FILENAME}.wav,W(4),/var/spool/asterisk/wav2mp3 ^{MONITOR_FILENAME}.wav ${DIR})
        ;exten => 800,n,nocdr() 
        exten => '.$ext.'800,n,ParkAndAnnounce('.$branch_data->tenant_name.'_'.$branch_data->site_name.'_parking,r,vm-youhave:a:pbx-transfer:at:vm-extension:PARKED,Local/${DN1}@extdial_'.$branch_data->tenant_name.'_'.$branch_data->site_name.',ParkedAt'.$branch_data->tenant_name.''.$branch_data->site_name.') 
        exten => '.$ext.'800,n,Playback(vm-nobodyavail) 
        exten => '.$ext.'800,n,Playback(vm-goodbye) 
        exten => '.$ext.'800,n,Hangup()  


        exten => _'.$ext.'80[1-5],1,Set(MONITOR_FILENAME=${STRFTIME(${EPOCH},,%Y%m%d-%H%M%S)}-${EXTEN}-${CALLERID(num)}) 
        exten => _'.$ext.'80[1-5],n,Set(CDR(recordingfile)=${MONITOR_FILENAME}.mp3) 
        exten => _'.$ext.'80[1-5],n,Set(DIR=bizRTCPBX/'.$branch_data->tenant_name.') 
        exten => _'.$ext.'80[1-5],n,MixMonitor(${MONITOR_FILENAME}.wav,W(4),/var/spool/asterisk/wav2mp3 ^{MONITOR_FILENAME}.wav ${DIR}) 
        exten => _'.$ext.'80[1-5],n,ParkedCall(,${EXTEN}) 
        exten => _'.$ext.'80[1-5],n,Hangup() 

        [ParkedAt'.$branch_data->tenant_name.''.$branch_data->site_name.']
        exten => s,1,NoOp(Call was parked at ${PARKEDAT})
        ;exten => s,n,Set(DB(LastParkedAt)=${PARKEDAT}) 
        exten => s,n,NoOP(${PARKEDAT}) 
        exten => s,n,Hangup'; 

        fwrite($park_branch, $park_branch_data);
        /********* END FILE ***********/

       } /// branch loop
     }
    /**************** END FILE *****************/

    /********* INTERNAL CALL FILE *********/
    if(!empty($extensionData)){

      foreach ($branchData as $branch_data) {
      
      $file  = '/etc/asterisk/bizRTCPBX/'.$branch_data->tenant_name.'/extensions_'.$branch_data->tenant_name.'_'.$branch_data->site_name.'_extdial_internal.conf';
      $inter_file = fopen($file, 'a') or die('Cannot open file: '.$file); 

      $inter_call ='';
      $inter_call .= '[extdial_'.$branch_data->tenant_name.'_'.$branch_data->site_name.']
      include => extdial_'.$branch_data->tenant_name.'_interoffice'."\n";

      $extension = getExtensionData($tenant_id,$branch_data->id);
      foreach ($extension as $ext_data) {
      
      $inter_call .= "\n".'exten => 8'.$ext_data->extension.'/'.$ext_data->extension.',1,GotoIf($[${EXTEN} = 8'.$ext_data->extension.' ]?mgodial:mgovm)
      exten => 8'.$ext_data->extension.'/'.$ext_data->extension.',n(mgodial),Dial(SIP/8'.$ext_data->extension.'-'.$ext_data->site_name.'-'.$ext_data->tenant_name.',30)
      exten => 8'.$ext_data->extension.'/'.$ext_data->extension.',n(mgovm),goto('.$ext_data->tenant_name.'_'.$ext_data->site_name.'_'.$ext_data->extension.'_vmctx,'.$ext_data->extension.',1)

      exten => 6'.$ext_data->extension.'/'.$ext_data->extension.',1,GotoIf($[${EXTEN} = 6'.$ext_data->extension.' ]?dgodial:dgovm)
      exten => 6'.$ext_data->extension.'/'.$ext_data->extension.',n(dgodial),Dial(SIP/6'.$ext_data->extension.'-'.$ext_data->site_name.'-'.$ext_data->tenant_name.',30)
      exten => 6'.$ext_data->extension.'/'.$ext_data->extension.',n(dgovm),goto('.$ext_data->tenant_name.'_'.$ext_data->site_name.'_'.$ext_data->extension.'_vmctx,'.$ext_data->extension.',1)

      exten => 7'.$ext_data->extension.'/'.$ext_data->extension.',1,GotoIf($[${EXTEN} = 7'.$ext_data->extension.' ]?pgodial:pgovm)
      exten => 7'.$ext_data->extension.'/'.$ext_data->extension.',n(pgodial),Dial(SIP/7'.$ext_data->extension.'-'.$ext_data->site_name.'-'.$ext_data->tenant_name.',30)
      exten => 7'.$ext_data->extension.'/'.$ext_data->extension.',n(pgovm),goto('.$ext_data->tenant_name.'_'.$ext_data->site_name.'_'.$ext_data->extension.'_vmctx,'.$ext_data->extension.',1)

      exten => '.$ext_data->extension.',1,goto('.$ext_data->tenant_name.'_'.$ext_data->site_name.'_'.$ext_data->extension.','.$ext_data->extension.',1)
      exten => 8'.$ext_data->extension.',1,goto('.$ext_data->tenant_name.'_'.$ext_data->site_name.'_'.$ext_data->extension.','.$ext_data->extension.',1)
      exten => 7'.$ext_data->extension.',1,goto('.$ext_data->tenant_name.'_'.$ext_data->site_name.'_'.$ext_data->extension.','.$ext_data->extension.',1)
      exten => 6'.$ext_data->extension.',1,goto('.$ext_data->tenant_name.'_'.$ext_data->site_name.'_'.$ext_data->extension.','.$ext_data->extension.',1)
      exten => ext'.$ext_data->extension.',1,goto('.$ext_data->tenant_name.'_'.$ext_data->site_name.'_'.$ext_data->extension.','.$ext_data->extension.',1)'."\n";

       } // ext loop

       fwrite($inter_file, $inter_call);

      } // branch loop
    }
    /************* END FILE ***************/


    /********* extensions_company1_extdial_interoffice_internal *********/
    if(!empty($branchData)){ 

      $file  = '/etc/asterisk/bizRTCPBX/'.$tenantData->tenant_name.'/extensions_'.$tenantData->tenant_name.'_extdial_interoffice_internal.conf';
      $interoffice_file = fopen($file, 'a') or die('Cannot open file: '.$file); 

      $interoffice = '[extdial_'.$branch_data->tenant_name.'_interoffice]'."\n\n";

      foreach ($branchData as $branch_data) {
      
      $interoffice .= 'exten => _'.$branch_data->branch_prefix.'XXXX,1,goto(extdial_'.$branch_data->tenant_name.'_'.$branch_data->site_name.',${EXTEN:1},1) '."\n";

      } // branch loop

      fwrite($interoffice_file, $interoffice);
    }
    /**************** END FILE ****************/
 

    /********  EXE TO DID DIRECT CALL ********/
    if(!empty($trunkDIDData)){
    
     foreach ($trunkDIDData as $data) {
       
    if($data->did_type == 'extensions' AND $data->extension != ''){
                                 
      $file = '/etc/asterisk/bizRTCPBX/'.$data->tenant_name.'/extensions_'.$data->tenant_name.'_'.$data->site_name.'_external_'.$data->did_number.'_incomingcall.conf';
      $ext_did_dir = fopen($file, 'a') or die('Cannot open file: '.$file); 
      
         $ext_did_data ='';    
      
          $ext_did_data = '['.$data->tenant_name.'_'.$data->site_name.'_'.$data->did_number.'_igcall] 

          exten => '.$data->did_number.',1,Set(clb="${DB(CIG_'.$data->tenant_name.'_'.$data->site_name.'/'.$data->did_number.')}") 
          exten => '.$data->did_number.',n,gotoif($[${CALLERID(number):-10}:${clb:0:-1}]?fail:fine) 
          exten => '.$data->did_number.',n(fail),hangup()
          exten => '.$data->did_number.',n(fine),goto('.$data->tenant_name.'_'.$data->site_name.'_'.$data->did_number.'_igcall,'.$data->did_number.',10) 

          exten => '.$data->did_number.',10,NoOP(user1 '.$data->extension.') 
          exten => '.$data->did_number.',n,Set(DIR=bizRTCPBX/'.$data->tenant_name.') 
          exten => '.$data->did_number.',n,Set(CDR(accountcode)='.$accountCode.') 
          exten => '.$data->did_number.',n,Set(DN2=${SIP_HEADER(TO):5})
          exten => '.$data->did_number.',n,Set(DN3=${DN2:0:11}) 
          exten => '.$data->did_number.',n,Set(MONITOR_FILENAME=${STRFTIME(${EPOCH},,%Y%m%d-%H%M%S)}-${CALLERID(num)}-${DN3}) 
          exten => '.$data->did_number.',n,Set(CDR(accountcode)='.$accountCode.') 
          exten => '.$data->did_number.',n,Set(DIR=bizRTCPBX/'.$data->tenant_name.') 
          exten => '.$data->did_number.',n,Set(CDR(recordingfile)=${MONITOR_FILENAME}.mp3) 
          exten => '.$data->did_number.',n,MixMonitor(${MONITOR_FILENAME}.wav,W(4),/var/spool/asterisk/wav2mp3 ^{MONITOR_FILENAME}.wav ${DIR})
          exten => '.$data->did_number.',n,Set(from=${SIP_HEADER(FROM)}) ;extdn=${CUT(DN1FROM,@,1)}) 
          exten => '.$data->did_number.',n,Set(from2=${CUT(from,:,2)}) ;extdn=${CUT(DN1FROM,@,1)}) 
          exten => '.$data->did_number.',n,Set(CDR(extsrc)=${CUT(from2,@,1)}) ;extdn=${CUT(DN1FROM,@,1)})'."\n"; 
                 
          if($data->call_type == 'sequential'){
          $ext =explode('-', $data->extension);

          for ($k=0; $k < count($ext); $k++) { 
          if($k == 0){$ext_voice = $ext[$k];}
          $ext_data  = '';
          $ext_data .= 'SIP/6'.$ext[$k].'-'.$data->site_name.'-'.$data->tenant_name.'&SIP/7'.$ext[$k].'-'.$data->site_name.'-'.$data->tenant_name.'&SIP/8'.$ext[$k].'-'.$data->site_name.'-'.$data->tenant_name.'&';
          $ext_did_data .= 'exten => '.$data->did_number.',n,Dial('.substr($ext_data, 0,-1).',20)'."\n";

          }     

          }else{

          $ext =explode('|', $data->extension);
          if($k == 0){$ext_voice = $ext[$k];}
          $ext_data = '';
          for ($k=0; $k < count($ext); $k++) { 
          $ext_data .= 'SIP/6'.$ext[$k].'-'.$data->site_name.'-'.$data->tenant_name.'&SIP/7'.$ext[$k].'-'.$data->site_name.'-'.$data->tenant_name.'&SIP/8'.$ext[$k].'-'.$data->site_name.'-'.$data->tenant_name.'&';
          }     

          $ext_did_data .= 'exten => '.$data->did_number.',n,Dial('.substr($ext_data, 0,-1).',20)'."\n";
          }
                 
          $ext_did_data .= 'exten => '.$data->did_number.',n,Voicemail('.$ext_voice.'@'.$data->tenant_name.'_'.$data->site_name.',u) 
          exten => '.$data->did_number.',n,hangup'; 
          //deep

          fwrite($ext_did_dir, $ext_did_data);
         }
       }
     }
    /*************************************/

    /********  EXE TO DID DIRECT CALL ********/
    if(!empty($trunkDIDData)){
      
     foreach ($trunkDIDData as $data) {
      
      if($data->did_type == 'conference'){
                                 
      $file = '/etc/asterisk/bizRTCPBX/'.$data->tenant_name.'/extensions_'.$data->tenant_name.'_'.$data->site_name.'_external_'.$data->did_number.'_conference_incomingcall.conf';
      $ext_did_dir_conf = fopen($file, 'a') or die('Cannot open file: '.$file); 
       
      
         $ext_did_data_conf .= '['.$data->tenant_name.'_'.$data->site_name.'_'.$data->did_number.'_igcallconf]

          exten => '.$data->did_number.',1,Set(clb="${DB(CIG_'.$data->tenant_name.'_'.$data->site_name.'/'.$data->did_number.')}") 
          exten => '.$data->did_number.',n,gotoif($[${CALLERID(number):-10}:${clb:0:-1}]?fail:fine) 
          exten => '.$data->did_number.',n(fail),hangup()
          exten => '.$data->did_number.',n(fine),goto('.$data->tenant_name.'_'.$data->site_name.'_'.$data->did_number.'_igcallconf,'.$data->did_number.',10) 

          exten => '.$data->did_number.',10,NoOP(come in conference '.$data->did_number.') 
          exten => '.$data->did_number.',n,Set(CDR(accountcode)='.$accountCode.') 
          exten => '.$data->did_number.',n,Answer() 
          exten => '.$data->did_number.',n,Playback(hello)  
          exten => '.$data->did_number.',n,Playback(pls-enter-conf-password&vm-then-pound) 
          exten => '.$data->did_number.',n,Read(NUM)
          exten => '.$data->did_number.',n,Set(pwd=${DB(ConfPWD_'.$data->tenant_name.'_'.$data->site_name.'/'.$data->site_name.'_200)}) 
          exten => '.$data->did_number.',n,Set(alen=${LEN(${pwd})}) 
          exten => '.$data->did_number.',n,gotoif($[${alen} < 2]?setactpwd:succs) 
          exten => '.$data->did_number.',n(setactpwd),Set(pwd='.$accountCode.') 
          exten => '.$data->did_number.',n(succs),noop(${DB($cpd/$cpdval)} and num is ${NUM}) 
          exten => '.$data->did_number.',n,Gotoif($[${pwd}=${NUM}]?inconf:pinfail) 
          exten => '.$data->did_number.',n(inconf),Set(CONFBRIDGE(user,announce_join_leave)=yes) 
          exten => '.$data->did_number.',n(inconf2),ConfBridge(int_cb_'.$data->tenant_name.'_'.$data->site_name.')
          exten => '.$data->did_number.',n(pinfail),playback(passwords_not_match) 
          exten => '.$data->did_number.',n(pinfail2),goto('.$data->tenant_name.'_'.$data->site_name.'_'.$data->did_number.'_igcallconf,'.$data->did_number.',5) 
          exten => '.$data->did_number.',n(pinfail3),hangup 
          exten => '.$data->did_number.',n,hangup ';

          fwrite($ext_did_dir_conf, $ext_did_data_conf);
         }
       }
     }
    /*************************************/


    /****** DID IVR ROUTING FILE ********/ 
    if(!empty($ivrConfigData)){

      foreach ($ivrConfigData as $ivi_did) {
    
      $file  = '/etc/asterisk/bizRTCPBX/'.$ivi_did->tenant_name.'/extensions_'.$ivi_did->tenant_name.'_'.$ivi_did->site_name.'_external_'.$ivi_did->did.'_ivr_incomingcall.conf';
      $ivr_file = fopen($file, 'a') or die('Cannot open file: '.$file); 

      $ivr_rout = '';
      $ivr_rout = '['.$ivi_did->tenant_name.'_'.$ivi_did->site_name.'_'.$ivi_did->did.'_igcallivr] 
 
      ;for internal extension from ivr routing 
      include => extdial_'.$ivi_did->tenant_name.'_'.$ivi_did->site_name.'

      ;for interbranch extension from ivr routing 
      include => extdial_'.$ivi_did->tenant_name.'_interoffice

      ;; adding callerid check and block
      exten => '.$ivi_did->did.',1,Set(clb="${DB(CIG_'.$ivi_did->tenant_name.'_'.$ivi_did->site_name.'/'.$ivi_did->did.')}") 
      exten => '.$ivi_did->did.',n,gotoif($[${CALLERID(number):-10}:${clb:0:-1}]?fail:fine) 
      exten => '.$ivi_did->did.',n(fail),hangup()
      exten => '.$ivi_did->did.',n(fine),goto('.$ivi_did->tenant_name.'_'.$ivi_did->site_name.'_'.$ivi_did->did.'_igcallivr,'.$ivi_did->did.',10) 
      '."\n\n";

      $day  = $ivi_did->off_days;
      $days = explode('|', $day);
    
      for ($i=0; $i < count($days); $i++) { 
      if($i == 0){
        $ivr_rout .= 'exten => '.$ivi_did->did.',10,GotoifTime('.$ivi_did->off_start.'-'.$ivi_did->off_end.','.$days[$i].',*,*?200)'."\n";  
      }else{
        $ivr_rout .= 'exten => '.$ivi_did->did.',n,GotoifTime('.$ivi_did->off_start.'-'.$ivi_did->off_end.','.$days[$i].',*,*?200)'."\n"; 
      }
      }
      
      $ivr_rout .='exten => '.$ivi_did->did.',n,Goto(300)'."\n\n";
      

      $ivr_rout .='exten => '.$ivi_did->did.',300,NoOP()
      exten => '.$ivi_did->did.',n,NoOP(recording disabled) 
      exten => '.$ivi_did->did.',n,Set(from=${SIP_HEADER(FROM)}) ;extdn=${CUT(DN1FROM,@,1)}) 
      exten => '.$ivi_did->did.',n,Set(from2=${CUT(from,:,2)}) ;extdn=${CUT(DN1FROM,@,1)}) 
      exten => '.$ivi_did->did.',n,Set(CDR(extsrc)=${CUT(from2,@,1)}) ;extdn=${CUT(DN1FROM,@,1)}) 
      exten => '.$ivi_did->did.',n,goto('.$ivi_did->tenant_name.'_'.$ivi_did->site_name.'_'.$ivi_did->off_time_choice.','.$ivi_did->off_time_choice.',1) 
      exten => '.$ivi_did->did.',n,Voicemail('.$ivi_did->off_time_choice.'@'.$ivi_did->tenant_name.'_'.$ivi_did->site_name.',u) 
      exten => '.$ivi_did->did.',n,hangup'; 


      $ivr_rout .="\n\n".'exten => '.$ivi_did->did.',200,Answer() 
      exten => '.$ivi_did->did.',n,Wait(1) 
      exten => '.$ivi_did->did.',n,Background(bizRTCPBX/'.$ivi_did->tenant_name.'/'.$ivi_did->IVR_Prompt_file.') 
      exten => '.$ivi_did->did.',n,WaitExten(10) 
      exten => '.$ivi_did->did.',n,Goto(i,1)'."\n\n"; 

      for ($j=1; $j < 10; $j++) { 
        $choice = 'choice'.$j;
        
        if($ivi_did->$choice != ''){
  
          if(substr($ivi_did->$choice, 0,-1) == 'level'){
          
           $ivr_rout .='exten => '.$j.',1,Goto('.$ivi_did->tenant_name.'_'.$ivi_did->site_name.'_'.$ivi_did->did.'_'.$ivi_did->$choice.'-ivr'.substr($ivi_did->$choice, -1).','.$ivi_did->did.'_'.substr($ivi_did->$choice, -1).',1)'."\n\n"; 
          }else{
            $ivr_rout .='exten => '.$j.',1,NoOP(keypress is '.$j.' for  '.$ivi_did->$choice.') 
            exten => '.$j.',n,Set(DIR=bizRTCPBX/'.$ivi_did->tenant_name.') 
            exten => '.$j.',n,Set(CDR(accountcode)='.$accountCode.') 
            exten => '.$j.',n,Set(DN2=${SIP_HEADER(TO):5})
            exten => '.$j.',n,Set(DN3=${DN2:0:11}) 
            exten => '.$j.',n,Set(CDR(didkeypress)=${DN3},${EXTEN}) 
            exten => '.$j.',n,Set(MONITOR_FILENAME=${STRFTIME(${EPOCH},,%Y%m%d-%H%M%S)}-${CALLERID(num)}-${DN3}) 
            exten => '.$j.',n,Set(CDR(accountcode)='.$accountCode.') 
            exten => '.$j.',n,Set(DIR=bizRTCPBX/'.$ivi_did->tenant_name.') 
            exten => '.$j.',n,Set(CDR(recordingfile)=${MONITOR_FILENAME}.mp3) 
            exten => '.$j.',n,MixMonitor(${MONITOR_FILENAME}.wav,W(4),/var/spool/asterisk/wav2mp3 ^{MONITOR_FILENAME}.wav ${DIR})
            exten => '.$j.',n,Set(from=${SIP_HEADER(FROM)}) ;extdn=${CUT(DN1FROM,@,1)}) 
            exten => '.$j.',n,Set(from2=${CUT(from,:,2)}) ;extdn=${CUT(DN1FROM,@,1)}) 
            exten => '.$j.',n,Set(CDR(extsrc)=${CUT(from2,@,1)}) ;extdn=${CUT(DN1FROM,@,1)})'."\n"; 
            
            $ch = $choice."_type";
            $type = $ivi_did->$ch;
            
            if($type == 'sequential'){
            $ext =explode('-', $ivi_did->$choice);
            
            for ($k=0; $k < count($ext); $k++) { 
                $ext_data = '';
                $ext_data.= 'SIP/6'.$ext[$k].'-'.$ivi_did->site_name.'-'.$ivi_did->tenant_name.'&SIP/7'.$ext[$k].'-'.$ivi_did->site_name.'-'.$ivi_did->tenant_name.'&SIP/8'.$ext[$k].'-'.$ivi_did->site_name.'-'.$ivi_did->tenant_name.'&';
              $ivr_rout .= 'exten => '.$j.',n,Dial('.substr($ext_data, 0,-1).',20)'."\n";
              }     
            }else{
            $ext =explode('|', $ivi_did->$choice);

            $ext_data = '';
            for ($k=0; $k < count($ext); $k++) { 
                $ext_data.= 'SIP/6'.$ext[$k].'-'.$ivi_did->site_name.'-'.$ivi_did->tenant_name.'&SIP/7'.$ext[$k].'-'.$ivi_did->site_name.'-'.$ivi_did->tenant_name.'&SIP/8'.$ext[$k].'-'.$ivi_did->site_name.'-'.$ivi_did->tenant_name.'&';
              }     

              $ivr_rout .= 'exten => '.$j.',n,Dial('.substr($ext_data, 0,-1).',20)'."\n";
            }

              $ivr_rout .= "\n".'exten => '.$j.',n,Voicemail('.$ivi_did->default_choice.'@'.$ivi_did->tenant_name.'_'.$ivi_did->site_name.',u) 
              exten => '.$j.',n,hangup'."\n\n";
          }  
        }
      }


      $ivr_rout .='exten => i,1,NoOP(nokeypress hence defaultinput '.$ivi_did->default_choice.') 
      exten => i,n,Set(DIR=bizRTCPBX/'.$ivi_did->tenant_name.') 
      exten => i,n,Set(CDR(accountcode)='.$accountCode.') 
      exten => i,n,Set(DN2=${SIP_HEADER(TO):5})
      exten => i,n,Set(DN3=${DN2:0:11}) 
      exten => i,n,Set(CDR(didkeypress)=${DN3},${EXTEN}) 
      exten => i,n,NoOP(recording disabled) 
      exten => i,n,Set(from=${SIP_HEADER(FROM)}) ;extdn=${CUT(DN1FROM,@,1)}) 
      exten => i,n,Set(from2=${CUT(from,:,2)}) ;extdn=${CUT(DN1FROM,@,1)}) 
      exten => i,n,Set(CDR(extsrc)=${CUT(from2,@,1)}) ;extdn=${CUT(DN1FROM,@,1)}) 
      exten => i,n,goto('.$ivi_did->tenant_name.'_'.$ivi_did->site_name.'_'.$ivi_did->default_choice.','.$ivi_did->default_choice.',1) 
      exten => i,n,Voicemail('.$ivi_did->default_choice.'@'.$ivi_did->tenant_name.'_'.$ivi_did->site_name.',u) 
      exten => i,n,hangup'."\n";

       //////////// MULTI LEVEL ////////////
       $ivrConfig = getIVRConfigLevel($tenant_id,$ivi_did->did);
       $l = 2;
       foreach ($ivrConfig as $level) {
        
        $ivr_rout .="\n\n".'['.$level->tenant_name.'_'.$level->site_name.'_'.$level->did.'_'.$level->ivr_level.'-ivr'.$l.']  
  
        exten => '.$level->did.'_'.$l.',1,noop() 
        exten => '.$level->did.'_'.$l.',n,Background(bizRTCPBX/'.$level->tenant_name.'/'.$level->IVR_Prompt_file.') 
        exten => '.$level->did.'_'.$l.',n,WaitExten(10)  
        exten => '.$level->did.'_'.$l.',n,goto(i,1)'."\n\n";  


         for ($j=1; $j < 10; $j++) { 
         $choice = 'choice'.$j;
        
          if($level->$choice != ''){

          if(substr($level->$choice, 0,-1) == 'level'){
          $ivr_rout .='exten => '.$j.',1,Goto('.$level->tenant_name.'_'.$level->site_name.'_'.$level->did.'_'.$level->$choice.'-ivr'.substr($level->$choice, -1).','.$level->did.'_'.substr($level->$choice, -1).',1)'."\n\n"; 
          }else{
          $ivr_rout .='exten => '.$j.',1,NoOP(keypress is '.$j.' for  '.$level->$choice.') 
          exten => '.$j.',n,Set(DIR=bizRTCPBX/'.$level->tenant_name.') 
          exten => '.$j.',n,Set(CDR(accountcode)='.$accountCode.') 
          exten => '.$j.',n,Set(DN2=${SIP_HEADER(TO):5})
          exten => '.$j.',n,Set(DN3=${DN2:0:11}) 
          exten => '.$j.',n,Set(CDR(didkeypress)=${DN3},${EXTEN}) 
          exten => '.$j.',n,Set(MONITOR_FILENAME=${STRFTIME(${EPOCH},,%Y%m%d-%H%M%S)}-${CALLERID(num)}-${DN3}) 
          exten => '.$j.',n,Set(CDR(accountcode)='.$accountCode.') 
          exten => '.$j.',n,Set(DIR=bizRTCPBX/'.$level->tenant_name.') 
          exten => '.$j.',n,Set(CDR(recordingfile)=${MONITOR_FILENAME}.mp3) 
          exten => '.$j.',n,MixMonitor(${MONITOR_FILENAME}.wav,W(4),/var/spool/asterisk/wav2mp3 ^{MONITOR_FILENAME}.wav ${DIR})
          exten => '.$j.',n,Set(from=${SIP_HEADER(FROM)}) ;extdn=${CUT(DN1FROM,@,1)}) 
          exten => '.$j.',n,Set(from2=${CUT(from,:,2)}) ;extdn=${CUT(DN1FROM,@,1)}) 
          exten => '.$j.',n,Set(CDR(extsrc)=${CUT(from2,@,1)}) ;extdn=${CUT(DN1FROM,@,1)})'."\n"; 

            $ch = $choice."_type";
            $type = $level->$ch;
            if($type == 'sequential'){
            $ext =explode('-', $level->$choice);
         
            
            for ($k=0; $k < count($ext); $k++) { 
            $ext_data = '';
            $ext_data .= 'SIP/6'.$ext[$k].'-'.$level->site_name.'-'.$level->tenant_name.'&SIP/7'.$ext[$k].'-'.$level->site_name.'-'.$level->tenant_name.'&SIP/8'.$ext[$k].'-'.$level->site_name.'-'.$level->tenant_name.'&';
            
              $ivr_rout .= 'exten => '.$j.',n,Dial('.substr($ext_data, 0,-1).',20)'."\n";
            }     
            }else{
            $ext =explode('|', $level->$choice);
         
            $ext_data = '';
            for ($k=0; $k < count($ext); $k++) { 
            $ext_data .= 'SIP/6'.$ext[$k].'-'.$level->site_name.'-'.$level->tenant_name.'&SIP/7'.$ext[$k].'-'.$level->site_name.'-'.$level->tenant_name.'&SIP/8'.$ext[$k].'-'.$level->site_name.'-'.$level->tenant_name.'&';
            }     

            $ivr_rout .= 'exten => '.$j.',n,Dial('.substr($ext_data, 0,-1).',20)'."\n";

            }

         
          $ivr_rout .= "\n".'exten => '.$j.',n,Voicemail('.$level->default_choice.'@'.$level->tenant_name.'_'.$ivi_did->site_name.',u) 
          exten => '.$j.',n,hangup'."\n\n";
          }  
          } 
          }


        $ivr_rout .='exten => i,1,NoOP(nokeypress hence defaultinput '.$level->default_choice.') 
        exten => i,n,Set(DIR=bizRTCPBX/'.$level->tenant_name.') 
        exten => i,n,Set(CDR(accountcode)='.$accountCode.') 
        exten => i,n,Set(DN2=${SIP_HEADER(TO):5})
        exten => i,n,Set(DN3=${DN2:0:11}) 
        exten => i,n,Set(CDR(didkeypress)=${DN3},${EXTEN}) 
        exten => i,n,NoOP(recording disabled) 
        exten => i,n,Set(from=${SIP_HEADER(FROM)}) ;extdn=${CUT(DN1FROM,@,1)}) 
        exten => i,n,Set(from2=${CUT(from,:,2)}) ;extdn=${CUT(DN1FROM,@,1)}) 
        exten => i,n,Set(CDR(extsrc)=${CUT(from2,@,1)}) ;extdn=${CUT(DN1FROM,@,1)}) 
        exten => i,n,goto('.$level->tenant_name.'_'.$level->site_name.'_'.$level->default_choice.','.$level->default_choice.',1) 
        exten => i,n,Voicemail('.$level->default_choice.'@'.$level->tenant_name.'_'.$level->site_name.',u) 
        exten => i,n,hangup'."\n";
       
        $l++;
      }
      ////////// EMD LEVEL ///////////////

      fwrite($ivr_file, $ivr_rout);

      } // branch loop
    
    }
  
  /************************************/

  /**** ASTERISK RELOAD CODE ******/
  exec('chmod -R 777 /etc/asterisk/bizRTCPBX/'.$tenantData->tenant_name);
  exec('dos2unix -R /etc/asterisk/bizRTCPBX/'.$tenantData->tenant_name.'/*');
  exec('asterisk -rx "reload" ');
  exec('asterisk -rx "sip reload" '); 
  
  $filename_csv = 'Login_Details_'.$tenantData->tenant_name.'.csv';
  $data_array   = $array_result;

  $csv = "AGENT,PASSWORD,SERVER,PROXY,PORT \n";//Column headers

  foreach ($array_result as $record){
    $csv.= $record['user'].','.$record['pass'].','.$record['server'].','.$record['proxy'].','.$record['port']."\n"; //Append data to csv
  }

  $csv_handler = fopen ('/var/spool/asterisk/downloads/'.$filename_csv,'w');
  fwrite ($csv_handler,$csv);
  fclose ($csv_handler);

  $this->session->set_flashdata('swal_message', 'Account Setup Successfully');
  redirect('System_configuration');
 /************************* COMPANY WISE FOLDER ***************************/
 }

} 
?>  