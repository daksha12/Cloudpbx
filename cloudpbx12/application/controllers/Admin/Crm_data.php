<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crm_data extends User_Controller {

	public function index()
	{
	    error_reporting(0);

	    if(isset($_POST['save'])){
	      $ip     = $_POST['crmip'];
	      $code   = $_POST['accountcode'];
	      $tenant = $_POST['tenantname'];
	      $date   = date('Y-m-d H:i:s');
	      $token  = md5($ip.$date); 
	      ///// VALIDATE ACCOU /////
	      $valid = get_valid_account($code,$tenant);
	      if($valid == 0){
	        $this->session->set_flashdata('swal_error', 'Wrong account code and tenant name');
		    redirect('Admin/crm_data/index');	
	      }

	      if($_POST['id'] == ''){

	      	$data = array(
	      	'crm_ip' => $ip, 
	      	'account_code' => $code, 
	      	'tenant_name'  => $tenant,
	      	'token_number' => $token,
	      	'date'         => $date
	        );

	        $this->db->insert('crm_config',$data);	
	      		
	      }else{

	      	$data = array(
	      	'crm_ip' => $ip, 
	      	'account_code' => $code, 
	      	'tenant_name'  => $tenant,
	      	'date'         => $date
	        );

	        $this->db->where('account_code',$code);
	        $this->db->where('tenant_name',$tenant);
	        $this->db->update('crm_config',$data);
	      
	      }

		  $this->session->set_flashdata('swal_message', 'CRM Configration Add Successfully');
		  redirect('Admin/crm_data/index');
	    }

	   $code = get_account_code($_SESSION['account_id']); 
       $this->data['code'] = $code;
       $this->data['crmip'] = get_crm_ip($code,$_SESSION['username']);
	   $this->data['subview']  = 'admin/crm/index';
	   $this->load->view('_layout_main', $this->data);   

	}
}
