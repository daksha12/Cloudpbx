<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_configuration extends MY_Controller {

	public function index()
	{

		if(empty($_SESSION['tenant_id']) || empty($_SESSION['account_id'])){
			redirect('System_configuration/login');
		}

		if($this->input->post('save_account'))
		{		
			$date = date("Y-m-d H:i:s");
			$by_username = $_SESSION['username'];

        	$account_id 		= $_POST['account_id_update'];
		    $tenant_id  		= $_POST['tenant_id_update'];
		    $organization_name  = $_POST['organization_name'];
			$address 		    = $_POST['address'];
			$site_key_issued 	= $_POST['site_key_issued'];
			$t_person 	        = $_POST['customer_contact_name'];
			$t_number 	 	    = $_POST['customer_contact_number'];
			$s_person 		    = $_POST['sales_contact_name'];
			$s_number 		    = $_POST['sales_contact_number'];

			if(!empty($account_id)){
				$this->db->select('*'); 
				$this->db->from('account_details');
			    $this->db->where('id', $account_id);
			    $query = $this->db->get();
			    $account  = $query->row();			    
			    $acc_id   = $account->id; 
			    $account_code   = $account->account_code; 

			    $sales = array(
					"account_code" 	=> $account_code,
					"first_name" => $s_person,
					"last_name"  => "",
					"phone"  	 => $s_number,
					"email"	     => "",
					"user_type"	 => 'sales'
				);
			    if(!empty($account->sales_id)){
			    	$sales['updated_at'] = $date;
				   	$sales['updated_by'] = $by_username;
				   	$this->db->where('id',$account->sales_id);
			    	$sales_id = $this->db->update('sales_details',$sales);			    	
					//$sales_id =  $this->db->insert_id();
					$sales_id =  $account->sales_id;
			    }
			    else {
			    	$sales['created_at'] = $date;
				   	$sales['created_by'] = $by_username;
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

				if(!empty($account->tech_id)){
					$tech['updated_at'] = $date;
				   	$tech['updated_by'] = $by_username;
				   	$this->db->where('id',$account->tech_id);
			    	$this->db->update('sales_details',$tech);				    			    
					//$tech_id =  $this->db->insert_id();
					$tech_id =  $account->tech_id;
			    }
			    else {
			    	$tech['created_at'] = $date;
				   	$tech['created_by'] = $by_username;
			    	$this->db->insert('sales_details',$tech);
					$tech_id =  $this->db->insert_id();
			    }
				
				/****** ACCOUNT ADD ******/
           		$account = array(
					"organization_name" => $organization_name,
					"address"  	 	    => $address,
					"site_key_issued"	=> $site_key_issued,
					"sales_id"			=> $sales_id,
					"tech_id"	        => $tech_id,
					"admin_email"       => "",
					"admin_phone"	    => "",
					"updated_at"   		=> $date,
					"updated_by"    	=> $by_username,
				);

		     	$this->db->where('id',$account_id);
		     	$this->db->update('account_details',$account);
		     	$acc_id =  $this->db->insert_id();			 	

			 	$email            = $_POST['email'];
			 	$conatct_person   = $_POST['conatct_person'];
			 	$country_code     = $_POST['country_code'];
			 	$phone     		  = $_POST['phone'];
			 	$time_zone     	  = $_POST['time_zone'];
	  
				/***** ACCOUNT CODE *****/	
				if(!empty($tenant_id) AND !empty($account_id)){
				    	
					$log = array(				
						"email"       => $email,
						"phone"       => $phone,
						"address"     => $address,
						"contat_person" => $conatct_person,
						"country_code"   => $country_code,
						"time_zone"    => $time_zone,
						"updated_at"   => $date,
						"updated_by"    => $by_username,
					);

					$this->db->where('id',$tenant_id);
					$this->db->where('account_id',$account_id);
					$this->db->update('login_details',$log);
					$tenant_id =  $this->db->insert_id();
				}
			}
			$this->session->set_flashdata('swal_message', 'Account Information updated Successfully');
			redirect('System_configuration');
	    }

	    if(isset($_POST['save_trunk'])){	    	
	    	if(isset($_POST['trunk_name']) && !empty($_POST['trunk_name'])){
	    		$tid = $_SESSION['tenant_id'];
	    		$site_id = $_SESSION['site_id'];
	    		$date = date("Y-m-d H:i:s");
				$by_username = $_SESSION['username'];
	    		if(!empty($tid)){
	    			$trunkList = getTrunkList($_SESSION['tenant_id'],$_SESSION['site_id']);
			    	$arrTrunkIds = array();
			    	foreach ($trunkList as $key => $trunkData){
			    		$arrTrunkIds[]=$trunkData->id;
			    	}
			    	
			    	if(!empty($_POST['old_trunk_id'])){
			    		$arrOldtrunkIds = $_POST['old_trunk_id'];
			    		$arrDeleteTrunkIds = array_diff($arrTrunkIds,$arrOldtrunkIds);
			    	}
			    	else {
			    		$arrDeleteTrunkIds = $arrTrunkIds;
			    	}
		    		foreach ($_POST['trunk_name'] as $key => $value) {  
		    		
			    		$trunk_name = $_POST['trunk_name'][$key];
					    $trunk_did 	= $_POST['trunk_did'][$key];
					    $username   = $_POST['username'][$key];
						$password 	= $_POST['password'][$key];
						$host 	    = $_POST['host'][$key];
						$port 	    = $_POST['port'][$key];
						$domain 	= $_POST['domain'][$key];
						$dtmf_mode	= $_POST['dtmf_mode'][$key];
						$nat 		= $_POST['nat'][$key];
						$directrtp 	= $_POST['directrtp'][$key];
						$register_trunk = $_POST['register_trunk'][$key];

						$prefix     = $_POST['prefix'][$key];
						$failover   = $_POST['failover'][$key];
						$ringduration = $_POST['ringduration'][$key];
						$cpe_ip     = $_POST['cpe_ip'][$key];
						$d2e        = $_POST['d2e'][$key];

						if(!empty($trunk_name)){
							$trunk = array(
								"tenant_id"  => $tid,									
								"site_id"    => $site_id,									
								"trunk_name" => $trunk_name,
								"username"   => $username,
								"password"   => $password,
								"host"	     => $host,
								"port"	     => $port,
								"domain"	 => $domain,
								"dtmf_mode"	 => $dtmf_mode,
								"nat"	     => $nat,
								"directrtp"	 => $directrtp,
								"register_trunk"	 => $register_trunk,
								"prefix"	 => $prefix,
								"failover"	 => $failover,
								"ringduration" => $ringduration,
								"cpe_ip"	 => $cpe_ip,
								"d2e"	     => $d2e,
								"trunk_did"	 => $trunk_did
							);

				    		// Update Data
				    		if(!empty($_POST['old_trunk_id'][$key])){
				    			$trunk_id_old = $_POST['old_trunk_id'][$key];

				    			$trunk['updated_at'] = $date;
				    			$trunk['updated_by'] = $by_username;

				    			$this->db->where('id',$trunk_id_old);
								$this->db->update('trunk_master',$trunk);
								$trunk_id =  $this->db->insert_id(); 

				    		}	
				    		else {									
								$this->db->select('*'); 
								$this->db->from('trunk_master');
							    $this->db->where('tenant_id', $tid);
							    $this->db->where('site_id', $site_id);
							    $this->db->where('trunk_name', $trunk_name);
							    $this->db->where('deleted_at IS NULL');
							    $query  = $this->db->get();
							    $trunkExists  = $query->row();
							    if(count($trunkExists) <= 0){			
							    	$trunk['created_at'] = $date;
				    				$trunk['created_by'] = $by_username;						
									$this->db->insert('trunk_master',$trunk);
									$trunk_id =  $this->db->insert_id();
					    		}
				    		}	
				    	}				
					}
					// Delete Trunk
					if(!empty($arrDeleteTrunkIds)){
						$trunkDelete = array(
							"deleted_at"  => $date,									
							"deleted_by"  => $by_username,
						);
						foreach ($arrDeleteTrunkIds as $key => $trunk_id) {
							$this->db->where('id',$trunk_id);
							$this->db->update('trunk_master',$trunkDelete);
						}						
					}
				}
				$this->session->set_flashdata('swal_message', 'Trunk Information Added Successfully');
				redirect('System_configuration/index/1');
			}
		}

		if(isset($_POST['save_branch_detail'])){

			$tid = $_POST['tenant_id_update'];
	    	$site_id = $_POST['branch_id'];
	    	$date = date("Y-m-d H:i:s");
			$by_username = $_SESSION['username'];
						
			$branch           = $_POST['site_name'];
			$trunk_id         = $_POST['trunk_name'];
			$branch_prefix      = $_POST['branch_prefix_number'];
			$moh              = $_POST['moh'];
			$country_code     = $_POST['country_code'];									
			$isd_allowed      = $_POST['isd_allowed'];
			$park_retreive    = $_POST['park_retreive'];
			$park_extension   = $_POST['park_extension'];
			$parking_slot     = $_POST['parking_slot'];
			$call_recording   = $_POST['call_recording'];
			$call_monitoring  = $_POST['call_monitoring'];
			$inter_branch     = $_POST['inter_branch'];
			$cdr_timezone     = $_POST['cdr_timezone'];
			$off_start        = $_POST['off_start'];
			$off_end          = $_POST['off_end']; 

			$arr_off_days 	  = $_POST['off_days'];
			$off_days = "";
			if(!empty($arr_off_days)){
				$off_days = implode("|",$arr_off_days);
			}

			// Get User name of Tenant By Tenant ID
			$username = getUserNameByTenantId($tid);

		    // Get did of Tenant By trunk_id
			$this->db->select('*'); 
			$this->db->from('trunk_master');
		    $this->db->where('id', $trunk_id);
		    $this->db->where('deleted_at IS NULL');
		    $query = $this->db->get();
		    $trunk_data  = $query->row();
		    $trunk_did   = $trunk_data->trunk_did;	    

		 	if(!empty($branch)){
		    
			    $site = array(
					"site_name"         => $branch,						
					"trunk_id" 			=> $trunk_id,
					"did"    			=> $trunk_did,								
					"branch_prefix"		=> $branch_prefix,
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
					"off_start" 		=> $off_start,
					"off_end" 		    => $off_end,          
					"off_days" 			=> $off_days,         
					"updated_at" 		=> $date,
					"updated_by" 		=> $by_username,					
				);

				$this->db->where('id',$site_id);
				$this->db->update($username.'_site',$site);
				$site_id =  $this->db->insert_id();    
				    
				$this->session->set_flashdata('swal_message', 'Branch Information Updated Successfully');
				redirect('System_configuration');
			}
		}

		if(isset($_POST['save_extension_detail'])){		

			if(isset($_POST['extension']) && !empty($_POST['extension'])){

				/*Binary File Execute*/

				$umc_user_check = exec('sudo /home/bizadmin/script/user');

				/*Binary File End Execute*/
				
				if($umc_user_check > count($_POST['extension'])){

					$tenant_id = $_SESSION['tenant_id'];
			    	$site_id = $_SESSION['site_id'];

			    	$date = date("Y-m-d H:i:s");
					$by_username = $_SESSION['username'];

					if(!empty($tenant_id)){

						$extensionList = getExtensionList($tenant_id,$site_id);

				    	$arrExtensionIds = array();
				    	foreach ($extensionList as $key => $extensionkData) {
				    		$arrExtensionIds[]=$extensionkData->id;
				    	}

				    	if(!empty($_POST['old_extension_id'])){
				    		$arrOldextensionIds = $_POST['old_extension_id'];
				    		$arrDeleteExtensionIds = array_diff($arrExtensionIds,$arrOldextensionIds);
				    	}
				    	else {
				    		$arrDeleteExtensionIds = $arrExtensionIds;
				    	}			    	

						foreach ($_POST['extension'] as $key => $value) {

							$Extension_type  = $_POST['extension_type'][$key];
							$Extension       = $_POST['extension'][$key];
							$DisplayID       = $_POST['display_name'][$key];
							$Voicemail       = $_POST['voicemail_enabled'][$key];
							$VMtoEm          = $_POST['vm_email'][$key];
							$VMtimezone      = $_POST['vm_timezone'][$key];
							$trunk_id = '';
							if(!empty($_POST['trunk_name'][$key])){
								$trunk_id        = $_POST['trunk_name'][$key];
							}						
							$OutgoingDID     = $_POST['outbound_did'][$key];
							$ISDrequired     = $_POST['isd_allowed'][$key];
							$ParkRetrieve    = $_POST['park_retreive'][$key];
							$Recording    	 = $_POST['call_recording'][$key];
							$CallMonitoring  = $_POST['call_monitoring'][$key];
							$PresenceBLF     = $_POST['presence_blf'][$key];					
							$Mobility        = $_POST['mobility'][$key];
							$Synergy         = $_POST['synergy'][$key];
							$PortalAccess    = $_POST['portal_access'][$key];
							$mobile_number   = $_POST['mobile_number'][$key];
							$audio_avoid     = $_POST['audio_avoid'][$key];


							/**** FILE CONVERT ***/
							$audio_file      = $_FILES["audio_file"]['name'][$key];											
							if($audio_file != ''){
							$IVR_Prompt_file_temp = $_FILES["audio_file"]["tmp_name"][$key];

							$uploaddir  = '/var/spool/asterisk/sound/ivr/';
							$uploadfile = $uploaddir.$audio_file;
							move_uploaded_file($IVR_Prompt_file_temp, $uploadfile);

							$ext = explode('.', $audio_file);
							$wav =  $ext[0].'_'.getUserNameByTenantId($tenant_id).date('dmYHis');	
							exec('sox '.$uploaddir.$audio_file.' '.$uploaddir.$wav.'.wav');
							if(file_exists($uploaddir.$wav.'.wav')){
							unlink($uploaddir.$audio_file);
							}else{
							rename(''.$uploadfile.'', ''.$uploaddir.$wav.'.wav');
							}

							$audio_file = $wav;
							}else{
							$audio_file = $_POST['audio_file_old'][$key];
							}
							/**** FILE CONVERT ***/
							  
							$this->db->select('*'); 
							$this->db->from('login_details');
						    $this->db->where('id', $tenant_id);
						    $query = $this->db->get();
						    $tenant_data  = $query->row();
						    $username   = $tenant_data->username;			
								
							$this->db->select('*'); 
							$this->db->from($username.'_site');
						    $this->db->where('id',$site_id);
						    $this->db->where('deleted_at IS NULL');
						    $query = $this->db->get();

						    $site_data  = $query->row();

						    $branch_name = $site_data->site_name;

						    if($OutgoingDID == ''){
					    		$OutgoingDID = $site_data->did;
					    	}

					    	/***** set pbx pass *****/
							$this->db->select('pbx_password'); 
							$this->db->from($username.'_extensions');
							$this->db->where('site_id', $site_data->id);
							$this->db->where('extension', $Extension);
							$query = $this->db->get();
							$ext_pass  = $query->row();

							if($ext_pass->pbx_password != ''){
								$extpass = $ext_pass->pbx_password;
							}else{
								$extpass = substr($branch_name, 0,4).rand(100000,10000000);
							}
							/***** set pbx pass *****/

							$ext = array(
								"account_id"        => $tenant_data->account_id,
								"site_id"           => $site_data->id,
								"extension_type"    => $Extension_type,
								"extension"         => $Extension,
								"username"	        => $Extension.$username.'@'.$username.'.'.$branch_name.'.bizrtc.com',		
								"password"	        => $this->Login_m->hash('b!z@'.$Extension.'$'),
								"password_temp"	    => 'b!z@'.$Extension.'$',
								"display_name" 		=> $DisplayID,				
								"trunk_id"          => $trunk_id,
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
								"audio_file" 	    => $audio_file,	
								"audio_avoid" 	    => $audio_avoid,	
								"pbx_password"   	=> $extpass,	
								"force_password_reset" => 'Y'
							);

						    // Update Data
						    if($Extension != ''){
					    		if(!empty($_POST['old_extension_id'][$key])){				    			
					    			$old_extension_id = $_POST['old_extension_id'][$key];
					    			$ext['updated_at'] = $date;
					    			$ext['updated_by'] = $by_username;
					    			$this->db->where('id',$old_extension_id);
									$this->db->update($username.'_extensions',$ext);
									$ext_id =  $this->db->insert_id(); 
					    		}	
					    		else {
							        $this->db->select('*'); 
									$this->db->from($username.'_extensions');
								    $this->db->where('site_id', $site_data->id);
								    $this->db->where('extension', $Extension);
								    $query = $this->db->get();
								    $extExists = $query->row(); 
								    if(count($extExists) <= 0){				
								      $ext['created_at'] = $date;
					    			  $ext['created_by'] = $by_username;						
									  $this->db->insert($username.'_extensions',$ext);
									  $ext_id =  $this->db->insert_id();								    
									}
								}   
							}
						}
						// Delete Extensions
						if(!empty($arrDeleteExtensionIds)){
							foreach ($arrDeleteExtensionIds as $key => $extension_id) {
								$extDelete = array(
									"deleted_at"  => $date,									
									"deleted_by"  => $by_username,
								);
								$this->db->where('id',$extension_id);
								$this->db->update($username.'_extensions',$extDelete);
								$ext_id =  $this->db->insert_id();
							}						
						}
					}
					$this->session->set_flashdata('swal_message', 'Extension Updated Successfully');
					redirect('System_configuration/index/2');

				}else{

					$this->session->set_flashdata('swal_message', 'Maximum user existsed');
					redirect('System_configuration/index/2');
							
				}	
			}
		}

		if(isset($_POST['save_trunkdid_detail'])){

			if(isset($_POST['trunk_did']) && !empty($_POST['trunk_did'])){
				$tenant_id = $_SESSION['tenant_id'];
		    	$site_id   = $_SESSION['site_id'];

		    	$date = date("Y-m-d H:i:s");
				$by_username = $_SESSION['username'];

		    	$trunkDidList = getTrunkDidList($tenant_id,$site_id);

		    	$arrTrunkDidIds = array();
		    	foreach ($trunkDidList as $key => $trunkDidData) {
		    		$arrTrunkDidIds[]=$trunkDidData->id;
		    	}
		    	if(!empty($_POST['old_trunkdid_id'])){
		    		$arrOldTrunkDidIds = $_POST['old_trunkdid_id'];
		    		$arrDeleteTrunkDidIds = array_diff($arrTrunkDidIds,$arrOldTrunkDidIds);
		    	}
		    	else {
		    		$arrDeleteTrunkDidIds = $arrTrunkDidIds;
		    	}
		    	

				foreach ($_POST['trunk_did'] as $key => $value) {
								  														  			
					$trunk_id    = $_POST['trunk_name'][$key];
					$did_number  = $_POST['trunk_did'][$key];
				
					if($trunk_id != ''){

					//$extension   = $_POST['extension'][$key];				
				    $ex  = 'extension_'.$key;
					$ext = count($_POST[$ex]);			
					
					$extension = '';
					for ($i=0; $i <= $ext - 1; $i++) { 
			  		 $extension .= $_POST[$ex][$i].',';
					}

				    $extension = rtrim($extension, ","); 				

					$did_type 	 = $_POST['did_type'][$key];
					$call_type 	 = $_POST['call_type'][$key];						
					// Replace comma to pipe sign
					if($call_type == 'sequential'){
						$extension = str_replace(",", '-', $extension);
						$extension = ltrim($extension, "-");
					}else{
						$extension = str_replace(",", '|', $extension);						
						$extension = ltrim($extension, "|");
					}

					if(!empty($did_number)){

						$trunkDID = array(
							"tenant_id"  => $tenant_id,							
							"site_id"    => $site_id,
							"trunk_id"   => $trunk_id,
							"did_number" => $did_number,
							"extension"  => $extension,
							"did_type"   => $did_type,
							"call_type"  => $call_type,
						);

						if(!empty($_POST['old_trunkdid_id'][$key])){
			    			$old_extension_id = $_POST['old_trunkdid_id'][$key];
			    			$trunkDID['updated_at'] = $date;
				    		$trunkDID['updated_by'] = $by_username;
			    			$this->db->where('id',$old_extension_id);
							$this->db->update('did_details',$trunkDID);							
							$did_id =  $this->db->insert_id(); 
			    		}	
			    		else {
							$this->db->select('*'); 
							$this->db->from('did_details');
						    $this->db->where('tenant_id', $tenant_id);
						    $this->db->where('site_id', $site_id);
						    $this->db->where('did_number', $did_number);
						    $this->db->where('deleted_at IS NULL');
						    $query = $this->db->get();
						    $did  = $query->row();
						    if(count($did) <= 0){
						    	$trunkDID['created_at'] = $date;
				    			$trunkDID['created_by'] = $by_username;
								$this->db->insert('did_details',$trunkDID);								
								$did_id =  $this->db->insert_id();				
							}
						}
					 }	
			 	  }	
			    }
				// Delete TrunkDID
				if(!empty($arrDeleteTrunkDidIds)){
					foreach ($arrDeleteTrunkDidIds as $key => $trunkdid_id) {
						$trunkDIDDelete = array(
							"deleted_at"  => $date,									
							"deleted_by"  => $by_username,
						);
			    		$this->db->where('id',$trunkdid_id);
						$this->db->update('did_details',$trunkDIDDelete);
					}						
				}	
				$this->session->set_flashdata('swal_message', 'TrunkDID Information Updated Successfully');
				redirect('System_configuration/index/3');		
			}
		}

		if(isset($_POST['save_IVR_did_detail'])){
			if(isset($_POST['ivr_level']) && !empty($_POST['ivr_level'])){
				$tenant_id = $_SESSION['tenant_id'];
		    	$site_id   = $_SESSION['site_id'];

		    	$date = date("Y-m-d H:i:s");
				$by_username = $_SESSION['username'];

				$trunk_id   = $_POST['trunk_name'];
				$did_number = $_POST['trunk_did'];
				$off_start  = $_POST['off_start'];
				$off_end 	= $_POST['off_end'];
				if(isset($_POST['off_days'])){
					$arr_off_days 	= $_POST['off_days'];
					$off_days = "";
					if(!empty($arr_off_days)){
						$off_days = implode("|",$arr_off_days);
					}
				}

		        // Get Old Ids
		        if(!empty($_POST['code'])){
		        	$code = $_POST['code'];
		        	$didRoutingIVRList = getDidRoutingIVRList($tenant_id, $site_id,$_POST['code']);
		    	}
		    	else {
		    		$code = strtotime("now");
		    	}

		    	$arrDidRoutingIds = array();
		    	foreach ($didRoutingIVRList as $didRoutingIVRData) {
		    		$arrDidRoutingIds[]=$didRoutingIVRData->id;
		    	}

		    	if(!empty($_POST['old_did_ivr_id'])){
					$arrOldDidRoutingIds = $_POST['old_did_ivr_id'];
		    		$arrDeleteDidRoutingIds = array_diff($arrDidRoutingIds,$arrOldDidRoutingIds);
		    	}
		    	else {
		    		$arrDeleteDidRoutingIds = $arrDidRoutingIds;
		    	}
		    	
				foreach ($_POST['ivr_level'] as $key => $value) {
					 							
					//$IVR_Prompt_file = $_POST['IVR_Prompt_file'][$key];
					$ivr_level	     = $_POST['ivr_level'][$key];
					$ringingseconds  = $_POST['ringingseconds'][$key];
					$choice1_type    = $_POST['choice1_type'][$key];

					/**** FILE CONVERT ***/
					$IVR_Prompt_file      = $_FILES["IVR_Prompt_file"]['name'][$key];					
					//if($IVR_Prompt_file != ''){
					if(isset($IVR_Prompt_file)){
					$IVR_Prompt_file_temp = $_FILES["IVR_Prompt_file"]["tmp_name"][$key];
					$uploaddir  = '/var/spool/asterisk/sound/ivr/';
					$uploadfile = $uploaddir.$IVR_Prompt_file;
					move_uploaded_file($IVR_Prompt_file_temp, $uploadfile);

					$ext = explode('.', $IVR_Prompt_file);
					$wav =  $ext[0].'_'.getUserNameByTenantId($tenant_id).date('dmYHis');	
					exec('sox '.$uploaddir.$IVR_Prompt_file.' '.$uploaddir.$wav.'.wav');
					if(file_exists($uploaddir.$wav.'.wav')){
						unlink($uploaddir.$IVR_Prompt_file);
					}else{
						rename(''.$uploadfile.'', ''.$uploaddir.$wav.'.wav');
					}

					$IVR_Prompt_file = $wav;
				    }else{
				     $IVR_Prompt_file = $_POST['IVR_Prompt_old'][$key];
				    }
					/**** FILE CONVERT ***/

					$ex  = 'choice1-'.$key;
					$ext = count($_POST[$ex]);			

					$extension = '';
					for ($i=0; $i <= $ext - 1; $i++) { 
					$extension .= $_POST[$ex][$i].',';
					}
					$extension = rtrim($extension, ","); 				


					if($choice1_type == 'sequential'){
					  $choice1 		 = str_replace(",", '-', $extension);	
					}else{
					  $choice1 		 = str_replace(",", '|', $extension);
					}

					$ex  = 'choice2-'.$key;
					$ext = count($_POST[$ex]);			

					$extension = '';
					for ($i=0; $i <= $ext - 1; $i++) { 
					$extension .= $_POST[$ex][$i].',';
					}
					$extension = rtrim($extension, ","); 				
					
					$choice2_type    = $_POST['choice2_type'][$key];					
					if($choice2_type == 'sequential'){
					  $choice2 		 = str_replace(",", '-', $extension);	
					}else{
					  $choice2 		 = str_replace(",", '|', $extension);
					}

					$ex  = 'choice3-'.$key;
					$ext = count($_POST[$ex]);			

					$extension = '';
					for ($i=0; $i <= $ext - 1; $i++) { 
					$extension .= $_POST[$ex][$i].',';
					}
					$extension = rtrim($extension, ",");

					$choice3_type    = $_POST['choice3_type'][$key];					
					if($choice3_type == 'sequential'){
					  $choice3 		 = str_replace(",", '-', $extension);	
					}else{
					  $choice3 		 = str_replace(",", '|', $extension);
					}


					$ex  = 'choice4-'.$key;
					$ext = count($_POST[$ex]);			

					$extension = '';
					for ($i=0; $i <= $ext - 1; $i++) { 
					$extension .= $_POST[$ex][$i].',';
					}
					$extension = rtrim($extension, ",");

					$choice4_type    = $_POST['choice4_type'][$key];					
					if($choice4_type == 'sequential'){
					  $choice4 		 = str_replace(",", '-', $extension);	
					}else{
					  $choice4 		 = str_replace(",", '|', $extension);
					}


					$ex  = 'choice5-'.$key;
					$ext = count($_POST[$ex]);			

					$extension = '';
					for ($i=0; $i <= $ext - 1; $i++) { 
					$extension .= $_POST[$ex][$i].',';
					}
					$extension = rtrim($extension, ",");

					$choice5_type    = $_POST['choice5_type'][$key];					
					if($choice5_type == 'sequential'){
					  $choice5 		 = str_replace(",", '-', $extension);	
					}else{
					  $choice5 		 = str_replace(",", '|', $extension);
					}

					$ex  = 'choice6-'.$key;
					$ext = count($_POST[$ex]);			

					$extension = '';
					for ($i=0; $i <= $ext - 1; $i++) { 
					$extension .= $_POST[$ex][$i].',';
					}
					$extension = rtrim($extension, ",");

					$choice6_type    = $_POST['choice6_type'][$key];					
					if($choice6_type == 'sequential'){
					  $choice6 		 = str_replace(",", '-', $extension);	
					}else{
					  $choice6 		 = str_replace(",", '|', $extension);
					}

					$ex  = 'choice7-'.$key;
					$ext = count($_POST[$ex]);			

					$extension = '';
					for ($i=0; $i <= $ext - 1; $i++) { 
					$extension .= $_POST[$ex][$i].',';
					}
					$extension = rtrim($extension, ",");

					$choice7_type    = $_POST['choice7_type'][$key];					
					if($choice7_type == 'sequential'){
					  $choice7 		 = str_replace(",", '-', $extension);	
					}else{
					  $choice7 		 = str_replace(",", '|', $extension);
					}

					$ex  = 'choice8-'.$key;
					$ext = count($_POST[$ex]);			

					$extension = '';
					for ($i=0; $i <= $ext - 1; $i++) { 
					$extension .= $_POST[$ex][$i].',';
					}
					$extension = rtrim($extension, ",");

					$choice8_type    = $_POST['choice8_type'][$key];					
					if($choice4_type == 'sequential'){
					  $choice8 		 = str_replace(",", '-', $extension);	
					}else{
					  $choice8 		 = str_replace(",", '|', $extension);
					}

					$ex  = 'choice9-'.$key;
					$ext = count($_POST[$ex]);			

					$extension = '';
					for ($i=0; $i <= $ext - 1; $i++) { 
					$extension .= $_POST[$ex][$i].',';
					}
					$extension = rtrim($extension, ",");

					$choice9_type    = $_POST['choice9_type'][$key];					
					if($choice9_type == 'sequential'){
					  $choice9 		 = str_replace(",", '-', $extension);	
					}else{
					  $choice9 		 = str_replace(",", '|', $extension);
					}

					$default_choice  = $_POST['default_choice'][$key];
					$off_time_choice = $_POST['off_time_choice'][$key];
					
				    if(!empty($ivr_level)){

				    	$ivr = array(
							"tenant_id"  => $tenant_id,
							"site_id"    => $site_id,
							"trunk_id"   => $trunk_id,
							"did"        => $did_number,
							"off_start"  => $off_start,
						    "off_end"    => $off_end,
						    "off_days"   => $off_days,						
							"IVR_Prompt_file" => $IVR_Prompt_file,
							"ivr_level"       => $ivr_level,
							"ringingseconds"  => $ringingseconds,
							"choice1"    => ltrim($choice1, "|"),
							"choice1_type"   => $choice1_type,
							"choice2"    => ltrim($choice2, "|"),
							"choice2_type"   => $choice2_type,
							"choice3"    => ltrim($choice3, "|"),
							"choice3_type"   => $choice3_type,
							"choice4"    => ltrim($choice4, "|"),
							"choice4_type"   => $choice4_type,
							"choice5"    => ltrim($choice4, "|"),
							"choice5_type"   => $choice5_type,
							"choice6"    => ltrim($choice6, "|"),
							"choice6_type"   => $choice6_type,
							"choice7"    => ltrim($choice7, "|"),
							"choice7_type"   => $choice7_type,
							"choice8"    => ltrim($choice8, "|"),
							"choice8_type"   => $choice8_type,
							"choice9"    => ltrim($choice9, "|"),
							"choice9_type"   => $choice9_type,
							"default_choice"   => $default_choice,
							"off_time_choice"  => $off_time_choice
						);


				    	// Update
				    	if(!empty($_POST['old_did_ivr_id'][$key])){
			    			$old_did_ivr_id = $_POST['old_did_ivr_id'][$key];

			    			$this->db->select('*'); 
							$this->db->from('did_routing_ivr');
						    $this->db->where('tenant_id', $tenant_id);
						    $this->db->where('site_id', $site_id);
						    $this->db->where('did', $did_number);
						    /*$this->db->where('off_start', $off_start);
						    $this->db->where('off_end', $off_end);
						    $this->db->where('off_days', $off_days);*/
						    if(isset($off_days)){
						    	$this->db->where("off_days REGEXP REPLACE('".$off_days."',',','|')");
						    }
						    $this->db->where('code !=', $code);
						    $this->db->where('deleted_at IS NULL');
						   
						    $query = $this->db->get();
						    $ivrExists  = $query->row();						    
						    if(count($ivrExists) <= 0){
				    			$ivr['updated_at'] = $date;
					    		$ivr['updated_by'] = $by_username;
				    			$this->db->where('id',$old_did_ivr_id);
								$this->db->update('did_routing_ivr',$ivr);
								$ivr_id =  $this->db->insert_id();
							}
							else {
								$this->session->set_flashdata('swal_error', 'DID Already Exists.');
								redirect('System_configuration/index/4');
							} 
			    		}
			    		else{
			    			$this->db->select('*'); 
							$this->db->from('did_routing_ivr');
						    $this->db->where('tenant_id', $tenant_id);
						    $this->db->where('site_id', $site_id);
						    $this->db->where('did', $did_number);
						    /*$this->db->where('off_start', $off_start);
						    $this->db->where('off_end', $off_end);
						    $this->db->where('off_days', $off_days);*/
						    if(isset($off_days)){
						    	$this->db->where("off_days REGEXP REPLACE('".$off_days."',',','|')");
						    }
						    $this->db->where('code !=', $code);
						    $this->db->where('deleted_at IS NULL');
						    $query = $this->db->get();

						    $ivrExists  = $query->row();
						    if(count($ivrExists) <= 0){	
							 	$this->db->select('*'); 
								$this->db->from('did_routing_ivr');
							    $this->db->where('tenant_id', $tenant_id);
							    $this->db->where('site_id', $site_id);
							    $this->db->where('did', $did_number);
							    $this->db->where('off_start', $off_start);
							    $this->db->where('off_end', $off_end);
							    if(isset($off_days)){
							    	$this->db->where('off_days', $off_days);
							    }
							    $this->db->where('ivr_level', $ivr_level);
							    $this->db->where('deleted_at IS NULL');
							    $query = $this->db->get();

							    $ivrExists  = $query->row();
							    if(count($ivrExists) <= 0){				
							    	$ivr['created_at'] = $date;
					    			$ivr['created_by'] = $by_username;					
					    			$ivr['code'] = $code;		
									$this->db->insert('did_routing_ivr',$ivr);
									$ivr_id = $this->db->insert_id();
								}	
							}		
							else {
								$this->session->set_flashdata('swal_error', 'DID Already Exists.');
								redirect('System_configuration/index/4');
							}		
						}
					}
				}
				
				// Delete TrunkDID
				if(!empty($arrDeleteDidRoutingIds)){
					foreach ($arrDeleteDidRoutingIds as $did_ivr_id) {
						$trunkDIDRoutingDelete = array(
							"deleted_at"  => $date,									
							"deleted_by"  => $by_username,
						);
			    		$this->db->where('id',$did_ivr_id);
						$this->db->update('did_routing_ivr',$trunkDIDRoutingDelete);
					}						
				}
				$this->session->set_flashdata('swal_message', 'IVR Routing Information Added Successfully');
				redirect('System_configuration/index/4');
			}
		}


          if(isset($_POST['save_e911'])){	    	

	    	if(isset($_POST['trunk_did']))
	    	{
	    		$tid = $_SESSION['tenant_id'];
	    		$site_id = $_SESSION['site_id'];
	    		$date = date("Y-m-d H:i:s");
				
				$by_username = $_SESSION['username'];
	    		if(!empty($tid)){
	    			
	    			$trunkList   = getE911List($_SESSION['tenant_id'],$_SESSION['site_id']);
			    	$arrTrunkIds = array();
			    	foreach ($trunkList as $key => $trunkData){
			    	 $arrTrunkIds[]=$trunkData->id;
			    	}
			    	
			    	if(!empty($_POST['old_e911_id'])){
			    	  $arrOldtrunkIds = $_POST['old_e911_id'];
			    	  $arrDeleteTrunkIds = array_diff($arrTrunkIds,$arrOldtrunkIds);
			    	}
			    	else 
			    	{
			    	  $arrDeleteTrunkIds = $arrTrunkIds;
			    	}

		    		foreach($_POST['trunk_did'] as $key => $value) {  
		    		
					    $trunk_did 	= $_POST['trunk_did'][$key];
					    $emergencyenable = $_POST['emergencyenable'][$key];
						$emergencynumber = $_POST['emergencynumber'][$key];
						$address1 	= $_POST['address1'][$key];
						$address2 	= $_POST['address2'][$key];
						$city 		= $_POST['city'][$key];
						$state	    = $_POST['state'][$key];
						$pincode 	= $_POST['pincode'][$key];

						if(!empty($trunk_did)){
							$trunk = array(									
							 "tenant_id" => $tid,
							 "site_id"   => $site_id,
							 "trunk_did" => $trunk_did,
							 "emergencyenable" => $emergencyenable,
							 "emergencynumber" => $emergencynumber,
							 "address1" => $address1,
							 "address2" => $address1,
							 "city" 	=> $city,
							 "state"	=> $state,
							 "pincode" 	=> $pincode
							);

				    		// Update Data
				    		if(!empty($_POST['old_e911_id'][$key])){
				    			$trunk_id_old = $_POST['old_e911_id'][$key];

				    			$trunk['updated_at'] = $date;
				    			$trunk['updated_by'] = $by_username;

				    			$this->db->where('id',$trunk_id_old);
								$this->db->update('e911_master',$trunk);
								$trunk_id =  $this->db->insert_id(); 
				    		}	
				    		else{									
								$this->db->select('*'); 
								$this->db->from('e911_master');
							    $this->db->where('tenant_id', $tid);
							    $this->db->where('site_id', $site_id);
							    $this->db->where('trunk_did', $trunk_did);
							    $this->db->where('deleted_at IS NULL');
							    $query  = $this->db->get();
							    $trunkExists  = $query->row();
							    if(count($trunkExists) <= 0){			
							      $trunk['created_at'] = $date;
				    			  $trunk['created_by'] = $by_username;						
								  $this->db->insert('e911_master',$trunk);
								  $trunk_id =  $this->db->insert_id();
					    		}
				    		}	
				    	}				
					}
					// Delete Trunk
					if(!empty($arrDeleteTrunkIds)){
						$trunkDelete = array(
							"deleted_at"  => $date,									
							"deleted_by"  => $by_username,
						);
						foreach ($arrDeleteTrunkIds as $key => $trunk_id) {
							$this->db->where('id',$trunk_id);
							$this->db->update('e911_master',$trunkDelete);
						}						
					}
				}
				$this->session->set_flashdata('swal_message', 'E911 Information Added Successfully');
				redirect('System_configuration/index/5');
			}
		}


		 if(isset($_POST['save_page_details'])){	    	

	    	if(isset($_POST['pagelistname']))
	    	{
	    		$tid     = $_SESSION['tenant_id'];
	    		$site_id = $_SESSION['site_id'];
	    		$date    = date("Y-m-d H:i:s");
				$by_username = $_SESSION['username'];

	    		if(!empty($tid)){
	    			
	    			$trunkList   = getPageList($_SESSION['tenant_id'],$_SESSION['site_id']);
			    	$arrTrunkIds = array();
			    	foreach ($trunkList as $key => $trunkData){
			    	 $arrPageIds[]=$trunkData->id;
			    	}
			    	
			    	if(!empty($_POST['old_page_details_id'])){
			    	  $arrOldPageIds = $_POST['old_page_details_id'];
			    	  $arrDeletePageIds = array_diff($arrPageIds,$arrOldPageIds);
			    	}
			    	else 
			    	{
			    	  $arrDeletePageIds = $arrPageIds;
			    	}

		    		foreach($_POST['pagelistname'] as $key => $value) {  
		    		
					    $pagelistname = $_POST['pagelistname'][$key];
					    $pagecommand  = $_POST['pagecommand'][$key];
						$pagemembers  = $_POST['pagemembers'][$key];
					

						if(!empty($pagelistname)){
							$page = array(									
							 "tenant_id" => $tid,
							 "site_id"   => $site_id,
							 "pagelistname" => $pagelistname,
							 "pagecommand" => $pagecommand,
							 "pagemembers" => $pagemembers,
							);

				    		// Update Data
				    		if(!empty($_POST['old_page_details_id'][$key])){
				    			$page_details_old = $_POST['old_page_details_id'][$key];

				    			$page['updated_at'] = $date;
				    			$page['updated_by'] = $by_username;

				    			$this->db->where('id',$page_details_old);
								$this->db->update('page_details',$page);
								$page_id =  $this->db->insert_id(); 
				    		}	
				    		else{									
								$this->db->select('*'); 
								$this->db->from('page_details');
							    $this->db->where('tenant_id', $tid);
							    $this->db->where('site_id', $site_id);
							    $this->db->where('pagelistname', $pagelistname);
							    $this->db->where('deleted_at IS NULL');
							    $query  = $this->db->get();
							    $trunkExists  = $query->row();
							    if(count($trunkExists) <= 0){			
							      $page['created_at'] = $date;
				    			  $page['created_by'] = $by_username;						
								  $this->db->insert('page_details',$page);
								  $page_id =  $this->db->insert_id();
					    		}
				    		}	
				    	}				
					}
					// Delete Trunk
					if(!empty($arrDeletePageIds)){
						$PageDelete = array(
							"deleted_at"  => $date,									
							"deleted_by"  => $by_username,
						);
						foreach ($arrDeletePageIds as $key => $page_id) {
							$this->db->where('id',$page_id);
							$this->db->update('page_details',$PageDelete);
						}						
					}
				}
				$this->session->set_flashdata('swal_message', 'Page Details Information Added Successfully');
				redirect('System_configuration/index/6');
			}
		}


	    if(isset($_POST['save_page_setting'])){	    	

	    	if(isset($_POST['pageparameter']))
	    	{
	    		$tid     = $_SESSION['tenant_id'];
	    		$site_id = $_SESSION['site_id'];
	    	    $pageparameter = $_POST['pageparameter'];
	    		$date    = date("Y-m-d H:i:s");
				$by_username = $_SESSION['username'];

	    		if(!empty($tid)){
	    			
	    			$PageSettingList   = getPageSettingList($_SESSION['tenant_id'],$_SESSION['site_id']);
			    	$arrPageSettingIds = array();
			    	foreach ($PageSettingList as $key => $PageSettingData){
			    	 $arrPageIds[]=$PageSettingData->id;
			    	}
			    	
			    	if(!empty($_POST['old_page_setting_id'])){
			    	  $arrOldPageSettingIds = $_POST['old_page_Setting_id'];
			    	  $arrDeletePageSettingIds = array_diff($arrPageSettingIds,$arrOldPageSettingIds);
			    	}
			    	else 
			    	{
			    	  $arrDeletePageIds = $arrPageIds;
			    	}

		    		foreach($_POST['pageparameter'] as $key => $value) {  
		    		
					    $pageparameter = $_POST['pageparameter'][$key];		

						if(!empty($pageparameter)){
							$page = array(									
							 "tenant_id" => $tid,
							 "site_id"   => $site_id,
							 "pageparameter" => $pageparameter,							
							);

				    		// Update Data
				    		if(!empty($_POST['old_page_setting_id'][$key])){
				    			$page_details_old = $_POST['old_page_setting_id'][$key];

				    			$page['updated_at'] = $date;
				    			$page['updated_by'] = $by_username;

				    			$this->db->where('id',$page_setting_old);
								$this->db->update('page_setting',$page);
								$page_id =  $this->db->insert_id(); 
				    		}	
				    		else{									
								$this->db->select('*'); 
								$this->db->from('page_setting');
							    $this->db->where('tenant_id', $tid);
							    $this->db->where('site_id', $site_id);
							    $this->db->where('pageparameter',$pageparameter);
							    $this->db->where('deleted_at IS NULL');
							    $query  = $this->db->get();
							    $trunkExists  = $query->row();
							    if(count($PageExists) <= 0){			
							      $page['created_at'] = $date;
				    			  $page['created_by'] = $by_username;						
								  $this->db->insert('page_setting',$page);
								  $page_id =  $this->db->insert_id();
					    		}
				    		}	
				    	}				
					}
					// Delete Trunk
					if(!empty($arrDeletePageIds)){
						$PageDelete = array(
							"deleted_at"  => $date,									
							"deleted_by"  => $by_username,
						);
						foreach ($arrDeletePageIds as $key => $page_id) {
							$this->db->where('id',$page_id);
							$this->db->update('page_setting',$PageDelete);
						}						
					}
				}
				$this->session->set_flashdata('swal_message', 'Page Setting Information Added Successfully');
				redirect('System_configuration/index/7');
			}
		}



		if(isset($_POST['save_clid_block_detail'])){
			
			if(isset($_POST['number']) && !empty($_POST['number'])){
				$tenant_id = $_SESSION['tenant_id'];
		    	$site_id = $_SESSION['site_id'];

		    	$date = date("Y-m-d H:i:s");
				$by_username = $_SESSION['username'];

		    	$blockNumberList = getBlockNumberList($tenant_id,$site_id);

		    	$arrBlockNumberIds = array();
		    	foreach ($blockNumberList as $key => $blockNumberData) {
		    		if($blockNumberData->type == "IN"){
		    			$arrInDID[$blockNumberData->id] = $blockNumberData->did;
		    		}
		    		$arrBlockNumberIds[]=$blockNumberData->id;
		    	}

		    	if(!empty($_POST['old_block_number_id'])){
					$arrOldTrunkDidIds = $_POST['old_block_number_id'];
		    	    $arrDeleteBlockNumberIds = array_diff($arrBlockNumberIds,$arrOldTrunkDidIds);
		    	}
		    	else {
		    		$arrDeleteBlockNumberIds = $arrBlockNumberIds;
		    	}		    	

				foreach ($_POST['number'] as $key => $value) {

					$call_type   = $_POST['call_type'][$key];
					$did_number  = $_POST['did'][$key];
					$number  	 = $_POST['number'][$key];

					// Replace comma to pipe sign
					$number = str_replace(",", '|', $number);

					$type = 'IN';
					if($call_type == "outgoing"){
						$type = 'OUT';
					}					

					if(!empty($tenant_id)){										  

						$username = getUserNameByTenantId($tenant_id);

					    $this->db->select('*'); 
						$this->db->from($username.'_site');
					    $this->db->where('id',$site_id);
					    $this->db->where('deleted_at IS NULL');
					    $query = $this->db->get();
					    $site_data  = $query->row();

					    $site_name = $site_data->site_name;

					    $did_block = array(
							"tenant_id"  => $tenant_id,
							"site_id"    => $site_id,
							"did"        => $did_number,
							"number"     => $number,
							"type"       => $type																		
						);

						if(!empty($number)){
						
							if(!empty($_POST['old_block_number_id'][$key])){
				    			$old_block_number_id = $_POST['old_block_number_id'][$key];
				    			$did_block['updated_at'] = $date;
				    			$did_block['updated_by'] = $by_username;
				    			$this->db->where('id',$old_block_number_id);
								$this->db->update('block_number',$did_block);
								$ext_id =  $this->db->insert_id(); 								

								/***** PUSH IN SQLLITE *****/
							    $db = new SQLite3('/var/lib/asterisk/astdb.sqlite3', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
							    $value = str_replace(",","|",$number);
							     if($type == "IN"){
							     	$old_did = $_POST['old_did'][$key];
							     	$key = "/CIG_".$username."_".$site_name."/".$did_number;
							     	$key_old = "/CIG_".$username."_".$site_name."/".$old_did;
							     	$db->query('UPDATE astdb SET value = "'.$value.'", key ="'.$key.'" where key ="'.$key_old.'"');

							     }
							     else {
							     	if(!empty($arrInDID[$old_block_number_id])){
							     		$arrDeleteDID[] = $arrInDID[$old_block_number_id];
							     	}
							     	$key = "/COG_".$username."_".$site_name."/calleridblk";

							     	$db->query('UPDATE astdb SET value = "'.$value.'" where key ="'.$key.'"');
							     }
							    /***** PUSH IN SQLLITE *****/
				    		}	
				    		else {
								$this->db->select('*'); 
								$this->db->from('block_number');
							    $this->db->where('tenant_id', $tenant_id);
							    $this->db->where('site_id', $site_id);
							    if($type == "IN"){
							    	$this->db->where('did', $did_number);
							    }
							    $this->db->where('number', $number);
							    $this->db->where('type', $type);
							    $this->db->where('deleted_at IS NULL');
							    $query = $this->db->get();
							    $in  = $query->row();
							    if(count($in) <= 0){
									$did_block['created_at'] = $date;
				    				$did_block['created_by'] = $by_username;
									$this->db->insert('block_number',$did_block);
									$ext_id =  $this->db->insert_id();					 
								    
									/***** PUSH IN SQLLITE *****/
								     $db = new SQLite3('/var/lib/asterisk/astdb.sqlite3', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
								     if($type == "IN"){
								     	$key = "/CIG_".$username."_".$site_name."/".$did_number;
								     }
								     else {
								     	$key = "/COG_".$username."_".$site_name."/calleridblk";
								     }
								     $value = str_replace(",","|",$number);
								     $db->query("INSERT INTO astdb (key, value) VALUES ('$key', '$value')");
								    /***** PUSH IN SQLLITE *****/
							    }   
							}
						}
					}
				}
				// Delete Block Number
				if(!empty($arrDeleteBlockNumberIds)){
					foreach ($arrDeleteBlockNumberIds as $key => $block_number_id) {
						$blockNumberDelete = array(
							"deleted_at"  => $date,									
							"deleted_by"  => $by_username,
						);
			    		$this->db->where('id',$block_number_id);
						$this->db->update('block_number',$blockNumberDelete);

						if(!empty($arrInDID[$block_number_id])){
				     		$arrDeleteDID[] = $arrInDID[$block_number_id];
				     	}
					}						
				}
				if(!empty($arrDeleteDID)){
					foreach ($arrDeleteDID as $key => $did_number) {
						$db = new SQLite3('/var/lib/asterisk/astdb.sqlite3', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
						$keyDetele = "/CIG_".$username."_".$site_name."/".$did_number;
						$db->query('DELETE from astdb where key ="'.$keyDetele.'"');
					}
				}
				$this->session->set_flashdata('swal_message', 'Block Number Information Updated Successfully');
				redirect('System_configuration');				
			}
		}

		// Get Time Zone list
        $timeZonesList = getTimeZoneList();
        
        $account_id = $_SESSION['account_id'];    

        if(!empty($_POST['branch_id'])){
        	$_SESSION['site_id'] = $_POST['branch_id'];
        }
        else if(!empty($_POST['tenant_id'])){
        	$_SESSION['tenant_id'] = $_POST['tenant_id'];
        	// Reset Branch and Get First Branch based on Tenant
        	$branchList = getBranchList($_POST['tenant_id']);
        	$_SESSION['site_id'] = $branchList[0]->id;
        }        

        if(empty($_SESSION['site_id'])){
        	$branchList = getBranchList($_SESSION['tenant_id']);
        	$_SESSION['site_id'] = $branchList[0]->id;
        }

		$tenant_id = $_SESSION['tenant_id'];
		$site_id = $_SESSION['site_id'];

		// Get Trunk List
        $this->data['trunkList'] = getTrunkList($tenant_id,$site_id);

        $this->data['e911List']  = getE911List($tenant_id,$site_id);

        $this->data['page_details_List'] = getPageList($tenant_id,$site_id);

         $this->data['page_setting_List'] = getPageSettingList($tenant_id,$site_id);

        // Get Account Detail 
        $account_code = get_account_code($account_id);
        $this->data['account_code'] = $account_code;

        // Get Tenant Detail
        $tenantDetail = get_tenant_detail($tenant_id);
        $this->data['tenantDetail'] = $tenantDetail;

        // Get Account Details
        $account_detail = get_account_detail($account_id);
        $this->data['account_detail'] = $account_detail;

        // Get Sales Detail
        $sales_detail = get_sales_detail($account_detail->sales_id,'sales');
        $this->data['sales_detail'] = $sales_detail;

        // Get Technical Detail
        $technical_detail = get_sales_detail($account_detail->tech_id,'technical');
        $this->data['technical_detail'] = $technical_detail;

        // Get Time Zone List
        $this->data['timeZonesList'] = $timeZonesList;

        // Get Tenant List
        $tenantList = getTenantList($account_id);
        $this->data['tenantList'] = $tenantList;

        // Get Tenant's Branch
        $branchList = getBranchList($tenant_id);
        if(!empty($branchList)){
	        $this->data['branchList'] = $branchList;
	        $this->data['showModelAddBranch'] = false;
	    }
	    else {
	    	$this->data['showModelAddBranch'] = true;;
	    }

        $branchDetail = getBranchDetail($tenant_id,$site_id);
        $this->data['branchDetail'] = $branchDetail;

        // Get Extension List
        $extensionList = getExtensionList($tenant_id,$site_id);
        $this->data['extensionList'] = $extensionList;

        // Get Extension List
        $trunkDidList = getTrunkDidList($tenant_id,$site_id);
        $this->data['trunkDidList'] = $trunkDidList;

        // Get DID Routing IVR Group
        $didRoutingIVRGroup = getDidRoutingIVRGroup($tenant_id,$site_id);              
        $this->data['didRoutingIVRGroup'] = $didRoutingIVRGroup;

        // Get Block Number List
        $blockNumberList = getBlockNumberList($tenant_id,$site_id);
        $this->data['blockNumberList'] = $blockNumberList;

        $this->data['account_id_update'] = $account_id;
        $this->data['tenant_id_update'] = $tenant_id;
        $this->data['site_id_update'] = $site_id;

        // Get FAQ
    	$this->data['branch_ext'] = getExtensionData($_SESSION['tenant_id'],$_SESSION['site_id']);
        $faq = $this->Faq_m->get();  
        $this->data['faq'] = $faq;
		$this->load->view('system_config/system_config',$this->data);
	}


	public function import_ext()
	{

     	/////////////////////////////// IMPORT //////////////////////////////
		if(isset($_POST['import_ext_data'])){     

                $tenant_id = $_SESSION['tenant_id'];
                $site_id = $_SESSION['site_id'];

                $date = date("Y-m-d H:i:s");
                $by_username = $_SESSION['username'];

                if(!empty($tenant_id)){

                    $extensionList = getExtensionList($tenant_id,$site_id);

                    $arrExtensionIds = array();
                    foreach ($extensionList as $key => $extensionkData) {
                        $arrExtensionIds[]=$extensionkData->id;
                    }
                 
                    $filename=$_FILES["extension"]["tmp_name"];    
                   if($_FILES["extension"]["size"] <= 0)
                   {
                   	$this->session->set_flashdata('swal_message', 'File is empty');
                     redirect('System_configuration');
                   }
        		   
        		   $file = fopen($filename, "r"); $b=1;
          		   while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
           		   {                                         
                        $Extension       = $getData[0];
                        $Extension_type  = $getData[1];
                        $DisplayID       = $getData[2];
                        $Voicemail       = $getData[3];
                        $VMtoEm          = $getData[4];
                        $VMtimezone      = $getData[5];
                        $trunk_id        = get_trunk($getData[6]);                       
                        $OutgoingDID     = $getData[7];
                        $ISDrequired     = $getData[8];
                        $ParkRetrieve    = $getData[9];
                        $Recording       = $getData[10];
                        $CallMonitoring  = $getData[11];
                        $PresenceBLF     = $getData[12];
                        $Mobility        = $getData[13];
                        $Synergy         = $getData[14];
                        $PortalAccess    = $getData[15];
                        $mobile_number   = $getData[16];
                         
                        $this->db->select('*'); 
                        $this->db->from('login_details');
                        $this->db->where('id', $tenant_id);
                        $query = $this->db->get();
                        $tenant_data  = $query->row();
                        $username   = $tenant_data->username;           
                            
                        $this->db->select('*'); 
                        $this->db->from($username.'_site');
                        $this->db->where('id',$site_id);
                        $this->db->where('deleted_at IS NULL');
                        $query = $this->db->get();

                        $site_data  = $query->row();

                        $branch_name = $site_data->site_name;

                        if($OutgoingDID == ''){
                           $OutgoingDID = $site_data->did;
                        }

                        /***** set pbx pass *****/
                        $this->db->select('pbx_password'); 
                        $this->db->from($username.'_extensions');
                        $this->db->where('site_id', $site_data->id);
                        $this->db->where('extension', $Extension);
                        $query = $this->db->get();
                        $ext_pass  = $query->row();

                        if($ext_pass->pbx_password != ''){
                          $extpass = $ext_pass->pbx_password;
                        }else{
                          $extpass = substr($branch_name, 0,4).rand(100000,10000000);
                        }
                        /***** set pbx pass *****/

                        $ext = array(
                            "account_id"        => $tenant_data->account_id,
                            "site_id"           => $site_data->id,
                            "extension_type"    => $Extension_type,
                            "extension"         => $Extension,
                            "username"          => $Extension.$username.'@'.$username.'.'.$branch_name.'.bizrtc.com',       
                            "password"          => $this->Login_m->hash('b!z@'.$Extension.'$'),
                            "password_temp"     => 'b!z@'.$Extension.'$',
                            "display_name"      => $DisplayID,              
                            "trunk_id"          => $trunk_id,
                            "outbound_did"      => $OutgoingDID,
                            "voicemail_enabled" => $Voicemail,
                            "vm_email"          => $VMtoEm,                     
                            "vm_timezone"       => $VMtimezone,
                            "isd_allowed"       => $ISDrequired,
                            "park_retrive"      => $ParkRetrieve,
                            "call_recording"    => $Recording,
                            "call_monitoring"   => $CallMonitoring,
                            "presence_blf"      => $PresenceBLF,                        
                            "mobility"          => $Mobility,
                            "synergy"           => $Synergy,
                            "portal_access"     => $PortalAccess,
                            "mobile_number"     => $mobile_number,  
                            "pbx_password"      => $extpass,    
                            "force_password_reset" => 'Y'
                        );

                        /// Update Data
						$this->db->select('*'); 
						$this->db->from($username.'_extensions');
						$this->db->where('site_id', $site_data->id);
						$this->db->where('extension', $Extension);
						$query = $this->db->get();
						$extExists = $query->row(); 
						if(count($extExists) <= 0){             
						 $ext['created_at'] = $date;
						 $ext['created_by'] = $by_username;      

						 if($b != 1){                  
						 $this->db->insert($username.'_extensions',$ext);
						 echo $this->db->last_query();
						 $ext_id =  $this->db->insert_id();
						 }
					    }                              
                    $b++;
                     }                                     
                   }                    
                }
                $this->session->set_flashdata('swal_message', 'Extension Import Successfully');
                redirect('System_configuration');           
        }
	////////////////////////////// END IMPORT ///////////////////////////	



	public function login()
	{		
			if($this->input->post('login'))
			{
				$username = $this->input->post('username');
				$password = $this->Login_m->hash($this->input->post('password'));
				$que = $this->db->query("select * from login_details where tenant_name='".$username."' and password='$password'");
				$row = $que->row();
				
				if($que->num_rows() > 0)
				{

					// $sess_expiration_min = round($this->config->config['sess_expiration'] / 60,4);
					// $to_time = strtotime(date("Y-m-d H:i:s"));
					// $from_time = strtotime($row->login_time)."<br>";
					// $difference_min=round(abs($to_time - $from_time) / 60,1). " minute";
					// if($difference_min > $sess_expiration_min){
					// 	$login_status = array('login_status' =>'false');
					// 	$this->db->where('username',$username);
					// 	$this->db->update('login_details',$login_status);
					// 	redirect('System_configuration/login');
					// }
					// else{
					if($row->login_status == "true") {


						$this->data['error'] = "There is another session already loggedin for this user please logout and try again !";
					
					}else{
						
						$date = date("Y-m-d H:i:s");
						$_SESSION['tenant_id'] = $row->id;
						$_SESSION['username'] = $row->username;
						$_SESSION['account_id'] = $row->account_id;
						$_SESSION['loggedin_time'] = $row->login_time;
						
						$branchList = getBranchList($row->id);
		        		$_SESSION['site_id'] = $branchList[0]->id;
		        		$login_status = array('login_status' =>'true','login_time'=>$date);
						$this->db->where('username',$row->username);
						$this->db->update('login_details',$login_status);

						redirect('System_configuration');

					}
				}
				else
				{
					$this->data['error'] = "Invalid login details";
				}
			}
		

		if(!empty($_SESSION['tenant_id'])){
			redirect('System_configuration');
		}
		// Get Time Zone List
		$timeZonesList = getTimeZoneList();
        $this->data['timeZonesList'] = $timeZonesList;		
       
		$this->load->view('system_config/login', $this->data);
	}

	public function logout()
	{
		$username = $_SESSION['username'];
		unset($_SESSION['tenant_id']);
		unset($_SESSION['site_id']);
		unset($_SESSION['account_id']);

		$login_status = array('login_status' =>'false');
		$this->db->where('username',$username);
		$this->db->update('login_details',$login_status);
		redirect('System_configuration/login');
	}

	public function addBranch()	{
		if($this->input->post('submit'))
		{
			$date = date("Y-m-d H:i:s");
			$by_username = $_SESSION['username'];

			$arrBranch = $this->input->post('branch');
			$username = getUserNameByTenantId($_SESSION['tenant_id']);
			if(!empty($arrBranch)){
				foreach ($arrBranch as $key => $branch) {
					if(!empty($branch)){
						$site = array(
							"site_name" => $branch,
							"created_at" => $date,
							"created_by" => $by_username,
						);

						$this->db->select('*'); 
						$this->db->from($username.'_site');
					    $this->db->where('site_name', $branch);
					    $this->db->where('deleted_at IS NULL');
					    $query = $this->db->get();
					    $site_data  = $query->row();

					    if(count($site_data) <= 0){
						   $this->db->insert($username.'_site',$site);
						   $site_id =  $this->db->insert_id();	

						   $tenant_id = $_SESSION['tenant_id'];

						   $this->db->query("INSERT INTO `page_setting` (`tenant_id`, `site_id`, `pageparameter`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES ('".$tenant_id."', '".$site_id."', 'Set(Volume(RX)=5)', CURRENT_TIMESTAMP, '', '0000-00-00 00:00:00.000000', '', '0000-00-00 00:00:00.000000', ''), ('".$tenant_id."', '".$site_id."', 'Set(Volume(TX)=5)', CURRENT_TIMESTAMP, '', '0000-00-00 00:00:00.000000', '', '0000-00-00 00:00:00.000000', ''), ('".$tenant_id."', '".$site_id."', 'SIPAddHeader(Call-Info: answer-after=0)', CURRENT_TIMESTAMP, '', '0000-00-00 00:00:00.000000', '', '0000-00-00 00:00:00.000000', '');");			    
					    }
					}
				}
				$this->session->set_flashdata('swal_message', 'Branch Added Successfully');
			    redirect('System_configuration');
			}
		}
	}

	public function addaccount()
	{
		if($this->input->post('add_Account'))
		{
			$date = date("Y-m-d H:i:s");
			$by_username = $_SESSION['username'];

			$account_code = $this->input->post('account_code');
			$tenant_name = $this->input->post('tenant_name');
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			$time_zone = $this->input->post('time_zone');

			if(!empty($account_code)){
				$this->db->select('*'); 
				$this->db->from('account_details');
			    $this->db->where('account_code', $account_code);
			    $this->db->where('deleted_at IS NULL');
			    $query = $this->db->get();
			    $account  = $query->row();
			    $acc_id   = $account->id; 
			    if(count($account) <= 0){
			    	
					/****** ACCOUNT ADD ******/
	           		$account = array(
						"account_code" 	    => $account_code,
						"organization_name" => $tenant_name,
						"created_at" 	    => $date,
						"created_by" 	    => $tenant_name,
					);
			     	$this->db->insert('account_details',$account);
			     	$acc_id =  $this->db->insert_id();
			 	}
	  
				// Add Tenant Detail
				if(!empty($tenant_name) && !empty($acc_id)){
			
				 	$username = str_replace(" ","_",$tenant_name);
			
					$this->db->select('*'); 
					$this->db->from('login_details');
				    $this->db->where('username', $username);
				    $this->db->where('deleted_at IS NULL');
				    $query = $this->db->get();
				    $user  = $query->row();
				    if(count($user) <= 0){											    
				    	
						$log = array(								
							"tenant_name" => $tenant_name,
							"email"       => $email,					
							"time_zone"    => $time_zone,
							"account_id"       => $acc_id,
							"username"             => $username,
							"password"             => $this->Login_m->hash($password),
							"password_temp"        => $password,
							"force_password_reset" => 'Y',
							"user_type"         => 'Admin',
							"created_at" 	    => $date,
							"created_by" 	    => $username,
						);

						$this->db->insert('login_details',$log);
						$tenant_id =  $this->db->insert_id();

						/*** create folder ****/
						mkdir('/var/spool/asterisk/monitor/bizRTCPBX/'.$tenant_name, 0777, true);
						//exec('sudo chown bizadmin.apache /var/spool/asterisk/monitor/bizRTCPBX/'.$tenant_name.' -R');
						exec('ln -s /var/spool/asterisk/sound/ivr  /var/lib/asterisk/sounds/bizRTCPBX/'.$tenant_name);

						/***** site table *****/
						if(!$this->db->table_exists($username.'_site'))
				        {
	 					    $this->db->query('CREATE TABLE '.$username.'_site (
								`id` int(20) NOT NULL AUTO_INCREMENT,
								`site_name` varchar(50) NOT NULL,
								`moh` text NOT NULL,
								`trunk_id` int(20) NOT NULL,
								`did` varchar(20) NOT NULL,
								`country_code` varchar(20) NOT NULL,
								`isd_allowed` enum("N","Y") NOT NULL,
								`park_retreive` enum("Y","N") NOT NULL,
								`park_extension` varchar(50) NOT NULL,
								`parking_slot` varchar(50),
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
								`off_start` varchar(50) NOT NULL,
								`off_end` varchar(50) NOT NULL,
								`off_days` varchar(50) NOT NULL,
								`created_at` TIMESTAMP NULL, 
								`created_by` VARCHAR(50) NULL,
								`updated_at` TIMESTAMP NULL, 
								`updated_by` VARCHAR(50) NULL, 
								`deleted_at` TIMESTAMP NULL,
								`deleted_by` VARCHAR(50) NULL,									
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
								`vm_timezone` varchar(50) NULL,
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
								`pbx_password` VARCHAR(50) NOT NULL,
								`audio_file` VARCHAR(100) NULL,
								`audio_avoid` VARCHAR(50) NULL,			
								`created_at` TIMESTAMP NULL, 
								`created_by` VARCHAR(50) NULL,
								`updated_at` TIMESTAMP NULL, 
								`updated_by` VARCHAR(50) NULL, 
								`deleted_at` TIMESTAMP NULL,
								`deleted_by` VARCHAR(50) NULL,
								PRIMARY KEY (`id`)
								) ENGINE=InnoDB DEFAULT CHARSET=latin1');	
	 					}
					}
				}
			}
			$this->session->set_flashdata('swal_message', 'Account Information Added Successfully');
			redirect('System_configuration/login');
	    }			
	}

	public function export()
	{
		if(empty($_POST['tenant_id']) || empty($_POST['site_id']) || empty($_POST['account_id'])){
			redirect('System_configuration/login');
		}	

		//error_reporting(E_ALL);

		$export_dir = "csvfile";
		$tenant_id = $_POST['tenant_id'];
		$account_id = $_POST['account_id'];

		$_SESSION['tenant_site'] = $_SESSION['username'].'_site';

		// Get Account Details 
		$username    = getUserNameByTenantId($tenant_id);
		$accountData = getAccountData($account_id);
		$tenantData  = getTenantData($tenant_id,$account_id);
		$branchData  = getTenantBranchData($tenant_id,$account_id);
		$branchList = getBranchList($tenant_id);

/*		// Check for every branch has data
		foreach ($branchList as $key => $branchDetail) {
			if(empty($branchDetail->site_name) || empty($branchDetail->trunk_id)){
				$this->session->set_flashdata('swal_error', 'Incomplete Data for Branch '.$branchDetail->site_name);
				redirect('System_configuration');
			}
		}

		// check trunk data
		foreach ($branchList as $key => $branchDetail) { 
			$trunkData = getTrunkData($tenant_id,$branchDetail->id);
			if(empty($trunkData)){
				$this->session->set_flashdata('swal_error', 'Incomplete Trunk Data for Branch '.$branchDetail->site_name);
				redirect('System_configuration');
			}
		}
		// Check Extenstion Data
		foreach ($branchList as $key => $branchDetail) {
			$extensionData = getExtensionData($tenant_id,$branchDetail->id);
			if(empty($extensionData)){
				$this->session->set_flashdata('swal_error', 'Incomplete Extenstion Data for Branch '.$branchDetail->site_name);
				redirect('System_configuration');
			}
		}
		// Check TrunkDID Data
		foreach ($branchList as $key => $branchDetail) {
			$trunkDIDData = getTrunkDIDData($tenant_id,$branchDetail->id);
			if(empty($trunkDIDData)){
				$this->session->set_flashdata('swal_error', 'Incomplete Routing Data for Branch '.$branchDetail->site_name);
				redirect('System_configuration');
			}
		}
*/
		$trunkData         = getTrunkData($tenant_id);
		$extensionData     = getExtensionData($tenant_id);
		$trunkDIDData      = getTrunkDIDData($tenant_id);
		$ivrConfigData     = getIVRConfigData($tenant_id);
		$inBoundBlcokData  = getBlockNumber($tenant_id,"IN");
		$outBoundBlcokData = getBlockNumber($tenant_id,"OUT");
        $e911List          = getE911ListExport($tenant_id);
        $pageList          = getPageListExport($tenant_id);
        $page_settingList  = getPageSettingListExport($tenant_id);

		// Create Tenant Id Directory
		$dir = "/home/bizadmin/".$export_dir."/".$username;

		if(!empty($accountData) && !empty($tenantData) && !empty($branchData) && !empty($trunkData) && !empty($extensionData))
		{			

			if(!empty($accountData)){

				// Create Tenant Id Directory				
				if (!file_exists($dir)) {
					mkdir($dir, 0777, true);
				}
 
				$filename = 'Accountcode.csv';

				$filepath = $dir . "/". $filename;

				$output = fopen($filepath, 'w');

				fputcsv($output, array('AccountCode','CustomerName','BillingAddress','BranchName','BranchAddress','Branchcontactperson','Branchcontactnumber','RequestExecutedBy','Sitetagissued','Customercontactname','Customercontactnumber','BizRTCsalescontactname','BizRTCsalescontactnumber'));

				if (count($accountData) > 0) {
				    foreach ($accountData as $row) {
				    	
				        fputcsv($output, $row);
				    }
				    fclose($output); 
				}
			}


			//if(!empty($tenantData)){

				$filename = 'Tenant_Details.csv';

				$filepath = $dir . "/". $filename;

				$output = fopen($filepath, 'w');

				fputcsv($output, array('TenantName','email id','Address1','contact person','phone no','country code','TimeZone'));
				
				
				$tenantData = json_encode($tenantData);
				$tenantData = json_decode($tenantData,true);
				$tenantData  = array('0' => $tenantData);
				
				if (count($tenantData) > 0) {
				    foreach ($tenantData as $row) {				    	
				        fputcsv($output, $row);
				    }
				    fclose($output); 
				}
			//}

			//if(!empty($branchData)){

				$filename = 'Tenant_Branch_Detail.csv';

				$filepath = $dir . "/". $filename;

				$output = fopen($filepath, 'w');

				fputcsv($output, array('TenantName','BranchName','AccountCode','TrunkName','TrunkDID','BranchPrefix','MusicOnHold','10DigitCountryCode','ISDAllowed','ParkRetrieve','ParkExtension','NoOfParkingSlot','CallRecording','CallMonitoring','InterBranchcalls','TimeZone','starttime','endtime','officedays'));

				$branchData = json_encode($branchData);
				$branchData = json_decode($branchData,true);
				//$branchData  = array('0' => $branchData);

				if (count($branchData) > 0) {
				    foreach ($branchData as $row) {				    	
				       
  	                   fputcsv($output, $row);
				       //fputcsv($output, $row);				        
				    }
				    fclose($output);  
				}
			//}

			//if(!empty($trunkData)){

				$filename = 'Trunk_Detail.csv';

				$filepath = $dir . "/". $filename;

				$output = fopen($filepath, 'w');

				fputcsv($output, array('TenantName','BranchName','TrunkName','TrunkDID','Username','Password','Host','Port','Domain','DTMFMode','NAT','DirectRTP','RegisterTrunk','Prefix','failover','ringduration','CPE IP (for PRI)','d2e'));

				$trunkData = json_encode($trunkData);
				$trunkData = json_decode($trunkData,true);

				if (count($trunkData) > 0) {
				    foreach ($trunkData as $row) {				    	
				        fputcsv($output, $row);
				    }
				    fclose($output); 
				}
			//}			

			//if(!empty($extensionData)){

				$filename = 'Extension_Details.csv';

				$filepath = $dir . "/". $filename;

				$output = fopen($filepath, 'w');

				fputcsv($output, array('TenantName','BranchName','ExtensionType','Extension',' DisplayID',' Voicemail',' VMToEmail',' VMTimeZone','TrunkName','OutboundDID','ISDAllowed','ParkRetrieve','CallRecording','CallMonitoring','PresenceBLF','Mobility','Synergy','PortalAccess','MobileNumber','audiofnm','audioavoid'));

				$extensionData = json_encode($extensionData);
				$extensionData = json_decode($extensionData,true);

				if (count($extensionData) > 0) {
				    foreach ($extensionData as $row) {				    	
				        fputcsv($output, $row);
				    }
				    fclose($output); 
				}
			//}
			
			//if(!empty($trunkDIDData)){

				$filename = 'TrunkDID_Details.csv';

				$filepath = $dir . "/". $filename;

				$output = fopen($filepath, 'w');

				fputcsv($output, array('TenantName','BranchName','TrunkName','TrunkDID','Extension','DIDType','DIDMask (-- need support from trunk connected to this box)','FAXDID','FAX2Email','SMS','SMS2Email'));

				$trunkDIDData = json_encode($trunkDIDData);
				$trunkDIDData = json_decode($trunkDIDData,true);

				if (count($trunkDIDData) > 0) {
				    foreach ($trunkDIDData as $row) {				    	
				        fputcsv($output, $row);
				    }
				    fclose($output); 
				}
			//}

			//if(!empty($ivrConfigData)){

				$filename = 'DID_Routing_With_IVR.csv';

				$filepath = $dir . "/". $filename;

				$output = fopen($filepath, 'w');

				fputcsv($output, array('TenantName','BranchName','TrunkName','TrunkDID','OfficeStartTime(HH:MM)',' OfficeEndTime(HH:MM)','OfficeDays','OfficeTimeIVRPromptFilename','IVRLevel','RingingSeconds','Choice1','Choice2','Choice3','Choice4','Choice5','Choice6','Choice7','Choice8','Choice9','DefaultChoice','OffTimeChoice'));

				$ivrConfigData = json_encode($ivrConfigData);
				$ivrConfigData = json_decode($ivrConfigData,true);

				if (count($ivrConfigData) > 0) {
				    foreach ($ivrConfigData as $row) {				    	
				        fputcsv($output, $row);
				    }
				    fclose($output); 
				}
			//}


  			    ///// E911 FILE ////
  			    $filename = 'e911.csv';
				$filepath = $dir . "/". $filename;

				$output = fopen($filepath, 'w');

				fputcsv($output, array('TenantName','BranchName','TrunkDID','EmergencyEnable','emergency number','Address1','Address2','City','State','Pincode'));

				if (count($e911List) > 0) {
				    
				    foreach ($e911List as $row) {				    					    
  	                   fputcsv($output, $row);				
				    }

				    fclose($output);  
				}
				/////////////
	

			 ///// E911 FILE ////
			    $filename = 'page_details.csv';
				$filepath = $dir . "/". $filename;

				$output = fopen($filepath, 'w');

				fputcsv($output, array('TenantName','BranchName','PageListName','Pagecommand','Pagemembers'));

				if (count($pageList) > 0) {
				    
				    foreach ($pageList as $row) {				    					    
  	                   fputcsv($output, $row);				
				    }

				    fclose($output);  
				}
				/////////////

				///// E911 FILE ////
  			    $filename = 'page_setting.csv';
				$filepath = $dir . "/". $filename;

				$output = fopen($filepath, 'w');

				fputcsv($output, array('TenantName','BranchName','Pageparameter'));

				if (count($page_settingList) > 0) {
				    
				    foreach ($page_settingList as $row) {				    					    
  	                   fputcsv($output, $row);				
				    }

				    fclose($output);  
				}
				/////////////
			
			//if(!empty($inBoundBlcokData)){

				$filename = 'InboundCLIDBlock.csv';

				$filepath = $dir . "/". $filename;

				$output = fopen($filepath, 'w');

				fputcsv($output, array('TenantName','BranchName','TrunkDID','InboundCLIDBlock'));

				$inBoundBlcokData = json_encode($inBoundBlcokData);
				$inBoundBlcokData = json_decode($inBoundBlcokData,true);

				if (count($inBoundBlcokData) > 0) {
				    foreach ($inBoundBlcokData as $row) {				    	
				        fputcsv($output, $row);
				    }
				    fclose($output); 
				}
			//}

			//if(!empty($outBoundBlcokData)){

				$filename = 'OutboundCLIDBlock.csv';

				$filepath = $dir . "/". $filename;

				$output = fopen($filepath, 'w');

				fputcsv($output, array('TenantName','BranchName','OutboundCLIDBlock'));

				$outBoundBlcokData = json_encode($outBoundBlcokData);
				$outBoundBlcokData = json_decode($outBoundBlcokData,true);

				if (count($outBoundBlcokData) > 0) {
				    foreach ($outBoundBlcokData as $row) {				    	
				        fputcsv($output, $row);
				    }
				    fclose($output); 
				}
			//}
			
			/////// COPTY ALL FILES ///////
			$path = $dir;
			$arrFiles = glob("/home/bizadmin/script/*");			
			
			foreach($arrFiles as $file)
			{
		      $files= explode('/', $file);				
			  copy($file, $dir.'/'.$files[4]);
			} 
			
			
			unlink($dir.'/files_data.sh');

		    $file = $dir.'/files_data.sh';

		     if(fopen($file,"w")){
				$current = file_get_contents($file);
				
				$current .= "#!/bin/sh \n";		
				$current .= "cd $2 \n";
			    $current .= "sudo chown bizadmin.apache /home/bizadmin/csvfile/".$username." -R \n";
			    $current .= "sudo chown bizadmin.apache /etc/asterisk -R \n";
				$current .= "sudo dos2unix $2/*.csv \n";
				$current .= "`/home/bizadmin/csvfile/".$username."/generatefiles $1 $2`";

				file_put_contents($file, $current);

				exec('sudo chmod 777 -R /home/bizadmin/csvfile ./');
			    exec('sudo dos2unix /home/bizadmin/csvfile/'.$username.'/files_data.sh');
				exec('sh ' .$dir.'/files_data.sh initial /home/bizadmin/csvfile/'.$username);
				//////////////////////////////	
				echo "success";
			}else{
				die("Unable to open file!");
			}
		    /*$this->session->set_flashdata('swal_message', 'Account Setup Successfully');
			redirect('System_configuration');*/
		}
		else {
			 echo "error";
			/*$this->session->set_flashdata('swal_error', 'Incomplete Data.');
			redirect('System_configuration');*/
		}
	}

	function get_ivr_config($code){

		$tenant_id = $_SESSION['tenant_id'];
		$site_id = $_SESSION['site_id'];

		// Get Trunk List
        $this->data['trunkList'] = getTrunkList($tenant_id,$site_id); 
        if(!empty($code)){
	        $didRoutingIVRList = getDidRoutingIVRList($tenant_id, $site_id,$code);
	 		$this->data['didRoutingIVRList'] = $didRoutingIVRList;
	        if(!empty($didRoutingIVRList[0])){
	        	$this->data['arrDidRoutingIVR'] = $didRoutingIVRList[0];
	        }
	    }
		return $this->load->view('system_config/ivr_config_model',$this->data);
	}

	function ajaxCheckUsed(){
		$tenant_id = $_POST['tenant_id'];
		$site_id = $_POST['site_id'];
		$id = $_POST['id'];
		if(!empty($_POST['table_name'])){

			$tabel_name = $_POST['table_name'];

			switch ($tabel_name) {
			  case "trunk_master":
			    if(checkTrunkUsed($tenant_id,$site_id,$id)){
			    	echo true;
			    	exit;
			    }
			    else {
			    	echo false;
			    	exit;
			    }
			    break;

			  case "extension":
			    if(checkExtensionUsed($tenant_id,$site_id,$id)){
			    	echo true;
			    	exit;
			    }
			    else {
			    	echo false;
			    	exit;
			    }
			    break;

			  case "trunk_did_detail":
			    if(checkTrunkDidUsed($tenant_id,$site_id,$id)){
			    	echo true;
			    	exit;
			    }
			    else {
			    	echo false;
			    	exit;
			    }
			    break;
			}
		}
	}
}
