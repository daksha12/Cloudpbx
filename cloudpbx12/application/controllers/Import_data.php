<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Import_data extends MY_Controller {

	public function index()
	{
		error_reporting(0);
		/**** GET UMC DETAILS ****/
		$this->db->select('*'); 
		$this->db->from('umc_details');
		$query = $this->db->get();
		$umc   = $query->row();

		if(isset($_FILES["account"]["name"])){

     		    $filename=$_FILES["account"]["tmp_name"];     	

		        $file = fopen($filename, "r");
		          while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
		           {						
						# the POST data we receive from Sencha (which is not JSON)			
						$account_code       = $getData[0];
					    $organization_name  = $getData[1];
						$address 		    = $getData[2];
						$site_key_issued 	= $getData[8];
						$t_person 	        = $getData[9];
						$t_number 	 	    = $getData[10];
						$s_person 		    = $getData[11];
						$s_number 		    = $getData[12];
						 
						if($account_code != 'AccountCode' AND $account_code != ''){

						$this->db->select('*'); 
						$this->db->from('account_details');
					    $this->db->where('account_code', $account_code);
					    $query = $this->db->get();
					    $account  = $query->row();
					    $acc_id   = $account->id; 
					    if(count($account) <= 0){
					    	
						/****** SELSE ADD ******/
						$sales = array(
							"account_code" 	=> $account_code,
							"first_name" => $s_person,
							"last_name"  => "",
							"phone"  	 => $s_number,
							"email"	     => "",
							"user_type"	 => 'sales'
						);

						if($s_person != ''){
						$this->db->insert('sales_details',$sales);
						$sales_id =  $this->db->insert_id();
						}						
						/****** TECH ADD ******/
						$tech = array(
							"account_code" 	=> $account_code,
							"first_name" => $t_person,
							"last_name"  => "",
							"phone"  	 => $t_number,
							"email"	     => "",
							"user_type"	 => 'technical'
						);
						
						if($t_person != ''){
						$this->db->insert('sales_details',$tech);
						$tech_id =  $this->db->insert_id();
						}
						/****** ACCOUNT ADD ******/
						if($sales_id == ''){
							$sales_id = 0;
						}
						if($tech_id == ''){
							$tech_id = 0;
						}
		           		
		           		$account = array(
							"account_code" 	    => $account_code,
							"organization_name" => $organization_name,
							"address"  	 	    => $address,
							"site_key_issued"	=> $site_key_issued,
							"sales_id"			=> $sales_id,
							"tech_id"	        => $tech_id,
							"admin_email"       => "",
							"admin_phone"	    => ""
						);
						if($account_code != ''){
					     $this->db->insert('account_details',$account);
					     $acc_id =  $this->db->insert_id();
					    }
 					 }
 					}
				  } //whhile loop
				} // end if 

			if(isset($_FILES["tenant"]["name"])){

     		    $filename = $_FILES["tenant"]["tmp_name"];     	

		        $file = fopen($filename, "r");
		          while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
		           {				
					# the POST data we receive from Sencha (which is not JSON)			
					$tenant           = $getData[0];
					$branch           = $getData[1];
	  
					/***** ACCOUNT CODE *****/	
					 if($tenant != 'TenantName' AND $tenant != ''){
				
					 	$username = str_replace(" ","_",$tenant);
				
						$this->db->select('*'); 
						$this->db->from('login_details');
					    $this->db->where('username', $tenant);
					    $query = $this->db->get();
					    $user  = $query->row();
					    if(count($user) <= 0){											    
					    	
							$log = array(								
						 	  "tenant_name" => $tenant,
						 	  "username"    => $username
							);

							$this->db->insert('login_details',$log);
							$tenant_id =  $this->db->insert_id();
					    
							/***** sit table *****/
							if(!$this->db->table_exists($username.'_site'))
					        {
		 					    $this->db->query('CREATE TABLE '.$username.'_site (
									`id` int(20) NOT NULL AUTO_INCREMENT,
									`site_name` varchar(50) NOT NULL,
									`moh` text NOT NULL,
									`trunk_id` int(20) NOT NULL,
									`did` varchar(20) NOT NULL,
									`country_code` varchar(20) NOT NULL,
									`isd_allowed` enum("Y","N") NOT NULL,
									`park_retreive` enum("Y","N") NOT NULL,
									`park_extension` varchar(50) NOT NULL,
									`parking_slot` enum("Y","N") NOT NULL,
									`call_recording` enum("Y","N") NOT NULL,
									`call_monitoring` enum("Y","N") NOT NULL,
									`inter_branch` enum("Y","N") NOT NULL,
									`cdr_timezone` varchar(50) NOT NULL,
									`branch_prefix` varchar(50) NOT NULL,
									`fax_did` varchar(100) NOT NULL,
									`fax_2_email` varchar(100) NOT NULL,
									`site_logo` varchar(100) NOT NULL,
									`site_admin` varchar(50) NOT NULL,
									`site_address` text NOT NULL,									
									PRIMARY KEY (`id`)
									) ENGINE=InnoDB DEFAULT CHARSET=latin1');	
		 					}

							/**** EXT TABLE ****/
							if(!$this->db->table_exists($username.'_extensions'))
					        {
		 					    $this->db->query('CREATE TABLE '.$username.'_extensions (
									`id` int(20) NOT NULL AUTO_INCREMENT,
									`account_id` int(50) NOT NULL,
									`site_id` int(50) NOT NULL,
									`extension_type` varchar(30) NOT NULL,
									`extension` varchar(20) NOT NULL,									
									`username` varchar(100) NOT NULL,
									`password` text NOT NULL,
									`display_name` varchar(50) NOT NULL,
									`voicemail_enabled` enum("Y","N") NOT NULL,
									`vm_email` varchar(100) NOT NULL,
									`vm_timezone` varchar(50) NOT NULL,
									`trunk_id` int(20) NOT NULL,
									`outbound_did` varchar(20) NOT NULL,
									`isd_allowed` enum("Y","N") NOT NULL,
									`park_retrive` enum("Y","N") NOT NULL,
									`call_recording` enum("Y","N") NOT NULL,
									`call_monitoring` enum("Y","N") NOT NULL,									
									`presence_blf` enum("Y","N") NOT NULL,									
									`mobility` enum("Y","N") NOT NULL,
									`synergy` enum("Y","N") NOT NULL,
									`portal_access` enum("Y","N") NOT NULL,	
									`mobile_number`varchar(50) NOT NULL,												
									`force_password_reset` enum("Y","N") NOT NULL,
									`password_temp` text NOT NULL,
									PRIMARY KEY (`id`)
									) ENGINE=InnoDB DEFAULT CHARSET=latin1');	
		 					}
 					    }


 					    $site = array(
						 "site_name"         => $branch
						);

 					    $this->db->select('*'); 
						$this->db->from($username.'_site');
					    $this->db->where('site_name', $branch);
					    $query = $this->db->get();
					    $site_data  = $query->row();
					    if(count($site_data) <= 0){

 					      if($branch != 'BranchName'){
						   $this->db->insert($username.'_site',$site);
						   $site_id =  $this->db->insert_id();
					      }
					    
					    }
 					/****** SITE INSERT ******/
 				   } 
				  } //whhile loop
				} // end if
	

			    if(isset($_FILES["trunk"]["name"])){

     		    $filename=$_FILES["trunk"]["tmp_name"];     	

		        $file = fopen($filename, "r");
		          while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
		           {						
						# the POST data we receive from Sencha (which is not JSON)			
						$tenant     = $getData[0];
						$branch     = $getData[1];
						$trunk_name = $getData[2];
					    $trunk_did 	= $getData[3];
					    $username   = $getData[4];
						$password 	= $getData[2];
						$host 	    = $getData[3];
						$port 	    = $getData[4];
						$domain 	= $getData[5];
						$dtmf_mode	= $getData[6];
						$nat 		= $getData[7];
						$directrtp 	= $getData[8];

						$username = str_replace(" ","_",$tenant);
																	
						if($tenant != 'TenantName' AND $tenant != ''){

						$tid =  get_tenant_id($username);
						$sid = 	get_site_id($branch,$username.'_site');
						
						$this->db->select('*'); 
						$this->db->from('trunk_master');
					    $this->db->where('tenant_id', $tid);
					    $this->db->where('site_id', $sid);
					    $this->db->where('trunk_name', $trunk_name);
					    $query  = $this->db->get();
					    $trunk  = $query->row();
					    if(count($trunk) <= 0){	
						/****** SELSE ADD ******/
						$trunk = array(
							"tenant_id"  => get_tenant_id($username),
							"site_id"    => get_site_id($branch,$username.'_site'),
							"trunk_name" => $trunk_name,
							"username"   => $username,
							"password"   => $password,
							"host"	     => $host,
							"port"	     => $port,
							"domain"	 => $domain,
							"dtmf_mode"	 => $dtmf_mode,
							"nat"	     => $nat,
							"directrtp"	 => $directrtp,
							"trunk_did"	 => $trunk_did
						);

						$this->db->insert('trunk_master',$trunk);
						$trunk_id =  $this->db->insert_id();
 					   }
 					}
				  } //whhile loop
				} // end if	



			if(isset($_FILES["didmaster"]["name"])){

     		    $filename=$_FILES["didmaster"]["tmp_name"];     	

		        $file = fopen($filename, "r");
		          while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
		           {						
						# the POST data we receive from Sencha (which is not JSON)			
						$tenant      = $getData[0];
						$branch      = $getData[1];
						$trunk       = $getData[2];
						$did_number  = $getData[3];
						$extension   = $getData[4];
						$did_type 	 = $getData[5];
						$did_mask 	 = $getData[6];
						$fax_did 	 = $getData[7];
						$fax2_mail	 = $getData[8];
						$sms 		 = $getData[9];
						$sms2_mail 	 = $getData[10];
						
						$username = str_replace(" ","_",$tenant);

						if($did_number != 'TrunkDID' AND $did_number != ''){

						$tid =  get_tenant_id($username);
						$sid = 	get_site_id($branch,$username.'_site');

						$this->db->select('*'); 
						$this->db->from('did_details');
					    $this->db->where('tenant_id', $tid);
					    $this->db->where('site_id', $sid);
					    $this->db->where('did_number', $did_number);
					    $query = $this->db->get();
					    $did  = $query->row();
					    if(count($did) <= 0){

						/****** SELSE ADD ******/
						$trunk = array(
							"tenant_id"  => get_tenant_id($username),
							"site_id"    => get_site_id($branch,$username.'_site'),
							"trunk_id"   => get_trunk($trunk),
							"did_number" => $did_number,
							"extension"  => $extension,
							"did_type"   => $did_type,
							"did_mask"   => $did_mask,
							"fax_did"	 => $fax_did,
							"fax2_mail"	 => $fax2_mail,
							"sms"	     => $sms,
							"sms2_mail"	 => $sms2_mail
						);

						$this->db->insert('did_details',$trunk);
						$did_id =  $this->db->insert_id();
				
 			   	      }
 					}
				  } //whhile loop
				} // end if

			if(isset($_FILES["e911"]["name"])){

     		    $filename=$_FILES["e911"]["tmp_name"];     	

		        $file = fopen($filename, "r");
		          while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
		           {						
						# the POST data we receive from Sencha (which is not JSON)			
						$did_number  = $getData[2];
						$e911    	 = $getData[3];
						$address 	 = $getData[4];
						$address1 	 = $getData[5];
						$city	     = $getData[6];
						$state		 = $getData[7];
						$pincode 	 = $getData[8];
						
						if($did_number != 'DIDnumber' AND $did_number != ''){
						/****** SELSE ADD ******/
						$e911 = array(
							"E911_enable" => $e911,
							"address1"    => $address,
							"address2"    => $address1,
							"city"	      => $city,
							"state"	      => $state,
							"pincode"	  => $pincode
						);
						
						if($did_number != 'DIDnumber'){
						  $this->db->where('did_number',$did_number);
						  $this->db->update('did_details',$e911);
						}	
 					 }
				  } //whhile loop
				} // end if

			if(isset($_FILES["did_ivr"]["name"])){

     		    $filename=$_FILES["did_ivr"]["tmp_name"];     	

		        $file = fopen($filename, "r");
		          while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
		           {						
						# the POST data we receive from Sencha (which is not JSON)			
						$tenant          = $getData[0];
						$branch          = $getData[1];
						$trunk           = $getData[2];
						$did_number      = $getData[3];
						$star_time    	 = $getData[4];
						$off_time 	     = $getData[5];
						$off_days 	     = $getData[6];
						$IVR_Prompt_file = $getData[7];
						$ivr_level	     = $getData[8];
						$ringingseconds  = $getData[9];
						$choice1 	     = $getData[10];
						$choice2 	     = $getData[11];
						$choice3 	     = $getData[12];
						$choice4 	     = $getData[13];
						$choice5 	     = $getData[14];
						$choice6 	     = $getData[15];
						$choice7 	     = $getData[16];
						$choice8 	     = $getData[17];
						$choice9 	     = $getData[18];
						$default_choice  = $getData[19];
						$off_time_choice = $getData[20];
						
					   if($did_number != 'TrunkDID' AND $did_number != ''){

					   	$username = str_replace(" ","_", $tenant);
					 	
					 	$tid = get_tenant_id($username);
					 	$sid = get_site_id($branch,$username.'_site');

					 	$this->db->select('*'); 
						$this->db->from('did_routing_ivr');
					    $this->db->where('tenant_id', $tid);
					    $this->db->where('site_id', $sid);
					    $this->db->where('did', $did_number);
					    $this->db->where('off_start', $star_time);
					    $this->db->where('off_end', $off_time);
					    $this->db->where('off_days', $off_days);
					    $this->db->where('ivr_level', $ivr_level);
					    $query = $this->db->get();
					    $ivr  = $query->row();
					    if(count($ivr) <= 0){

						/***** IVR INSERT ******/
						$ivr = array(
							"tenant_id"  => get_tenant_id($username),
							"site_id"    => get_site_id($branch,$username.'_site'),
							"trunk_id"   => get_trunk($trunk),
							"did"        => $did_number,
							"off_start"  => $star_time,
						    "off_end"    => $off_time,
						    "off_days"   => $off_days,						
							"IVR_Prompt_file" => $IVR_Prompt_file,
							"ivr_level"       => $ivr_level,
							"ringingseconds"  => $ringingseconds,
							"choice1"    => $choice1,
							"choice2"    => $choice2,
							"choice3"    => $choice3,
							"choice4"    => $choice4,
							"choice5"    => $choice5,
							"choice6"    => $choice6,
							"choice7"    => $choice7,
							"choice8"    => $choice8,
							"choice9"    => $choice9,
							"default_choice"   => $default_choice,
							"off_time_choice"  => $off_time_choice
						);
											
						$this->db->insert('did_routing_ivr',$ivr);
						$ivr_id = $this->db->insert_id();				    	
 					 }
 					}
				  } //whhile loop
				} // end		 

			if(isset($_FILES["tenant"]["name"])){

     		    $filename = $_FILES["tenant"]["tmp_name"];     	

		        $file = fopen($filename, "r");
		          while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
		           {				
					
					# the POST data we receive from Sencha (which is not JSON)			
					$tenant           = $getData[0];
					$branch           = $getData[1];
					$trunk_name       = $getData[3];
					$did              = $getData[4];
					$trunkprefix      = $getData[5];
					$moh              = $getData[6];
					$country_code     = $getData[7];									
					$isd_allowed      = $getData[8];
					$park_retreive    = $getData[9];
					$park_extension   = $getData[10];
					$parking_slot     = $getData[11];
					$call_recording   = $getData[12];
					$call_monitoring  = $getData[13];
					$inter_branch     = $getData[14];
					$cdr_timezone     = $getData[15];
					
			
				    $username = str_replace(" ","_",$tenant);
					 
					/***** ACCOUNT CODE *****/	
					 if($tenant != 'TenantName' AND $tenant != ''){
					    						
						$log = array(
							"account_id"           => $acc_id,
							"username"             => $username,
							"password"             => $this->Login_m->hash($username.'@b!z$'),
							"password_temp"        => $username.'@b!z$',
							"email"	               => "",
							"phone"	               => '',
							"force_password_reset" => 'Y'
						);

						$this->db->where('username',$username);
						$this->db->update('login_details',$log);
						$tenant_id =  $this->db->insert_id();
				    
 					    $site = array(
								"site_name"         => $branch,								
								"trunk_id" 			=> get_trunk($trunk_name),
								"did"    			=> $did,								
								"branch_prefix"		=> $trunkprefix,
								"moh"	            => $moh,
								"country_code" 		=> $country_code,
								"isd_allowed" 		=> $isd_allowed,
								"park_retreive" 	=> $park_retreive,
								"park_extension" 	=> $park_extension,
								"parking_slot" 	    => $parking_slot,
								"call_recording" 	=> $call_recording,
								"call_monitoring" 	=> $call_monitoring,
								"inter_branch" 		=> $inter_branch,
								"cdr_timezone" 		=> $cdr_timezone,								
								"fax_did" 			=> '',
								"fax_2_email" 		=> '',
								"site_logo" 		=> '',
								"site_admin" 		=> '',
								"site_address" 		=> '',
							);

 					    if($branch != 'BranchName'){
						 $this->db->where('site_name',$branch);
						 $this->db->update($username.'_site',$site);
						 $site_id =  $this->db->insert_id();
					    }
 					/****** SITE INSERT ******/
 				    }
				  } //whhile loop
				} // end if


			if(isset($_FILES["ext_no"]["name"])){

     		    $filename = $_FILES["ext_no"]["tmp_name"];     	

		        $file = fopen($filename, "r");
		          while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
		           {				
					# the POST data we receive from Sencha (which is not JSON)			
					$tenant          = $getData[0];
					$branch          = $getData[1];
					$Extension_type  = $getData[2];
					$Extension       = $getData[3];
					$DisplayID       = $getData[4];
					$Voicemail       = $getData[5];
					$VMtoEm          = $getData[6];
					$VMtimezone      = $getData[7];
					$Trunk_Name      = $getData[8];
					$OutgoingDID     = $getData[9];
					$ISDrequired     = $getData[10];
					$ParkRetrieve    = $getData[11];
					$Recording    	 = $getData[12];
					$CallMonitoring  = $getData[13];
					$PresenceBLF     = $getData[14];					
					$Mobility        = $getData[15];
					$Synergy         = $getData[16];
					$PortalAccess    = $getData[17];
					$mobile_number   = $getData[18];
					  
					if($tenant != 'TenantName' AND $tenant != ''){

					$username = str_replace(" ","_",$tenant);
						
					$this->db->select('*'); 
					$this->db->from($username.'_site');
				    $this->db->where('site_name',$branch);
				    $query = $this->db->get();
				    $site_data  = $query->row();
	
			        $this->db->select('*'); 
					$this->db->from($username.'_extensions');
				    $this->db->where('site_id', $site_data->id);
				    $this->db->where('extension', $Extension);
				    $query = $this->db->get();
				    $ext  = $query->row(); 
				    if(count($ext) <= 0){

				    	if($OutgoingDID == ''){
				    	  $OutgoingDID = $site_data->did;
				    	}

						$ext = array(
						"account_id"        => $acc_id,
						"site_id"           => $site_data->id,
						"extension_type"    => $Extension_type,
						"extension"         => $Extension,
						"username"	        => $Extension.$username.'@'.$username.'.'.$branch.'.bizrtc.com',				
						"password"	        => $this->Login_m->hash('b!z@'.$Extension.'$'),
						"password_temp"	    => 'b!z@'.$Extension.'$',
						"display_name" 		=> $DisplayID,					
						"trunk_id"          => get_trunk($Trunk_Name),
						"outbound_did" 		=> $OutgoingDID,
						"voicemail_enabled" => $Voicemail,
						"vm_email" 		    => $VMtoEm,						
						"vm_timezone" 		=> $VMtimezone,
						"isd_allowed"       => $ISDrequired,
						"park_retrive" 		=> $ParkRetrieve,
						"call_recording"    => $Recording,
						"call_monitoring" 	=> $CallMonitoring,
						"presence_blf" 		=> $PresenceBLF,						
						"mobility" 		    => $Mobility,
						"synergy" 			=> $Synergy,
						"portal_access" 	=> $PortalAccess,
						"mobile_number" 	=> $mobile_number,																
						"force_password_reset" => 'Y'
						);

 					    if($Extension != ''){
						  $this->db->insert($username.'_extensions',$ext);
						  $ext_id =  $this->db->insert_id();
					    }
					  }   
					}
 				   /**** EXTENSION ******/

				   /****************** SEND IN UMC ********************
				   	//// ADD UMC PATECH FIRSST AFTER USE ALL API //////
					$path = '/etc/asterisk/bizRTCPBX/'.$username.'/sip_'.$username.'_'.$branch.'_'.$Extension.'_user.conf';
					$data      = parse_ini_file($path,true);

				  	$user = $data['7'.$Extension.'-'.$branch.'-'.$username]['defaultuser'];
				   	$pass = $data['7'.$Extension.'-'.$branch.'-'.$username]['secret'];
				 
					if($user != ''){
					$data = array(
					"user" 	        => $user,
					"sipdisplay" 	=> $DisplayID,
					"sipauth"  	 	=> $user,
					"sippass"		=> $pass,
					"cmproxy"		=> $umc->umc_site_name,
					"email"         => $VMtoEm,
					"mobile"        => $mobile_number,
					"did"           => $OutgoingDID,
					"vmext"         => $Extension,
					"command"	    => "updateextension",
					);

					$data_string = http_build_query($data);
					$url = "https://".$umc->umc_ip.":".$umc->umc_port."/umc/servlet/prov?action=umobilityupdatedb";

					$ch = curl_init($url);

					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
					curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_TIMEOUT, 5);
					curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

					curl_setopt($ch, CURLOPT_URL, $url );
					curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
					echo $result = curl_exec($ch);

					} // user not null
					/******************** END UMMC ********************/

				} //whhile loop
				
				} // end if

				/**** BLOCK NUMBER *****/
				if(isset($_FILES["out_block"]["name"])){

     		    $filename = $_FILES["out_block"]["tmp_name"];     	

		        $file = fopen($filename, "r");
		          while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
		           {				
					# the POST data we receive from Sencha (which is not JSON)			
				 	 $tenant_name  = $getData[0];
				 	 $site_name    = $getData[1];
				 	 $number       = $getData[2];					 				  
				 	 
				 	 if($tenant_name != 'TenantName' AND $tenant_name != ''){

				 	 	$username = str_replace(" ","_",$tenant_name);

				 	 	$tid =  get_tenant_id($username);
						$sid = 	get_site_id($site_name,$username.'_site');

				 	 	$this->db->select('*'); 
						$this->db->from('block_number');
					    $this->db->where('tenant_id', $tid);
					    $this->db->where('site_id', $sid);
					    $this->db->where('number', $number);
					    $this->db->where('type', 'OUT');
					    $query = $this->db->get();
					    $out  = $query->row();
					    if(count($out) <= 0){

						$did_block = array(
						"tenant_id"  => get_tenant_id($username),
						"site_id"    => get_site_id($site_name,$username.'_site'),
						"did"        => '',
						"number"     => $number,
						"type"       => 'OUT'																		
						);

 					    if($number != ''){
						  $this->db->insert('block_number',$did_block);
						  $ext_id =  $this->db->insert_id();
					    }

					    /***** PUSH IN SQLLITE *****/
					    $db = new SQLite3('/var/lib/asterisk/astdb.sqlite3', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
					    $key = "/COG_".$username."_".$site_name."/calleridblk";
					    $value = str_replace(",","|",$number);
					    $db->query("INSERT INTO astdb (key, value) VALUES ('$key', '$value')");
					    /***** PUSH IN SQLLITE *****/

					  }   
					}
 					/**** EXTENSION ******/
				  } //whhile loop
				} // end f  


				/**** BLOCK NUMBER *****/
			   if(isset($_FILES["in_block"]["name"])){

     		     $filename = $_FILES["in_block"]["tmp_name"];     	
		         $file = fopen($filename, "r");

		          while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
		           {				
					# the POST data we receive from Sencha (which is not JSON)
					$tenant_name  = $getData[0];
				 	$site_name    = $getData[1];			
					$did_number   = $getData[2];
					$number       = $getData[3];

					if($tenant_name != 'TenantName' AND $tenant_name != ''){										  

						$username = str_replace(" ","_",$tenant_name);
						
						$tid =  get_tenant_id($username);
						$sid = 	get_site_id($site_name,$username.'_site');

						$this->db->select('*'); 
						$this->db->from('block_number');
					    $this->db->where('tenant_id', $tid);
					    $this->db->where('site_id', $sid);
					    $this->db->where('did', $did_number);
					    $this->db->where('number', $number);
					    $this->db->where('type', 'IN');
					    $query = $this->db->get();
					    $in  = $query->row();
					    if(count($in) <= 0){

						$did_block = array(
						"tenant_id"  => get_tenant_id($username),
						"site_id"    => get_site_id($site_name,$username.'_site'),
						"did"        => $did_number,
						"number"     => $number,
						"type"       => 'IN'																		
						);
 					 
						$this->db->insert('block_number',$did_block);
						$ext_id =  $this->db->insert_id();					 
					   
						/***** PUSH IN SQLLITE *****/
					     $db = new SQLite3('/var/lib/asterisk/astdb.sqlite3', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
					     $key = "/CIG_".$username."_".$site_name."/".$did_number;
					     $value = str_replace(",","|",$number);
					     $db->query("INSERT INTO astdb (key, value) VALUES ('$key', '$value')");
					    /***** PUSH IN SQLLITE *****/

					   }   
					 }
 				   /**** EXTENSION ******/
				  } //whhile loop
				} // end if


				/**** TENANT MASTER *****/
			   if(isset($_FILES["tenant_details"]["name"])){

     		    $filename = $_FILES["tenant_details"]["tmp_name"];     	
		        $file = fopen($filename, "r");

		          while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
		           {				
					# the POST data we receive from Sencha (which is not JSON)
					$tenant_name     = $getData[0];			
					$email           = $getData[1];
					$address         = $getData[2];
					$contact_person  = $getData[3];
					$phone_no        = $getData[4];
					$code            = $getData[5];
					$time_zone       = $getData[6];

					if($tenant_name != 'TenantName' AND $tenant_name != ''){										  
                        
                        $username = str_replace(" ","_",$tenant_name);
						$log_data = array(
						 "email"          => $email,
						 "phone"          => $phone_no,
						 "address"        => $address,
						 "contat_person"  => $contact_person,
						 "country_code"   => $code,
						 "time_zone"      => $time_zone																		
						);
 					 
 					 	$this->db->where('username',$username);
						$this->db->update('login_details',$log_data);		 
					}   
 					/**** EXTENSION ******/
				  } //whhile loop
				} // end if


				if(isset($_POST['import'])){
				 $this->session->set_flashdata('swal_message', 'Account Add Successfully');
				 redirect('Import_data/index');
			    }
                $this->load->view('import/import_data');
	}
}
