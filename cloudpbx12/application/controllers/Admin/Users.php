<?php
class Users extends User_Controller
{
public function __construct()
{
parent::__construct();
}

public function index()
{  
$this->data['subview'] = 'admin/users/list_users';	
$this->load->view('_layout_main', $this->data);   
}

public function OTA_mail($user){
/****************** SEND IN UMC ********************/	

/**** GET UMC DETAILS ****/
$this->db->select('*'); 
$this->db->from('umc_details');
$query = $this->db->get();
$umc   = $query->row();

$data = array(
 "resendMailUser" => '7'.$user,
);

$data_string = http_build_query($data);
$url = "https://".$umc->umc_ip.":".$umc->umc_port."/umc/OTAapi.jsp";

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
$result = curl_exec($ch);
/******************** END UMMC ********************/
$this->session->set_flashdata('swal_message', 'OTA Mail Successfully Send');
redirect('Admin/Users/index');
}

}
?>
