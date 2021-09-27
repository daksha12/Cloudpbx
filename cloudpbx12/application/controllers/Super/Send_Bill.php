<?php
class Send_Bill extends MY_Controller
{
public function __construct()
{
parent::__construct();
}

public function Mail($month=null,$cc = null)
{ 
    //// GET ALL REAT CARD FOR ACCOUNT ///
    $rate_card = get_assign_rate_details();

    foreach ($rate_card as $key => $rate_code) {

    $tenant_data = getTenantListDetails($rate_code->account_id);

    $rate = explode(',', $rate_code->rate_card);

    $total = ''; $array_result = array(); 
    foreach ($rate as $key => $value) {

     $pre = get_rate_card($value);    
     
     ////////////////////////////////
      $this->db->select('id,src,dst,billsec,recordingfile,disposition,calldate,SUBSTRING(dst, 1, 2) as code');
      $this->db->from('cdr');
      $this->db->where('accountcode',$rate_code->account_code);
      $this->db->where('SUBSTRING(dst, 1, 2) =',$pre->country_code);
      $this->db->where('SUBSTRING(calldate, 6, 2) =',$month);          
      $this->db->where('lastapp','Dial');
                  
      $query  = $this->db->get();
      $result = $query->result();      

      foreach ($result as $key => $cdr_value) {                                      
        $array_result[$key]['call_date']     = $cdr_value->calldate;
        $array_result[$key]['src']           = $cdr_value->src;
        $array_result[$key]['dst']           = $cdr_value->dst;        
        $array_result[$key]['billsec']       = $cdr_value->billsec;        
        $array_result[$key]['disposition']   = $cdr_value->disposition;            
        $array_result[$key]['rate']          = $cdr_value->billsec * $pre->rate / $pre->pulse;
        $total +=  $cdr_value->billsec * $pre->rate / $pre->pulse;
      }

    }

    //// EXPORT DATA /////
    $dir = "/home/bizadmin/bill/".$tenant_data->tenant_name.'/'.date('Y').'/'.date('M',strtotime($month));
    if (!file_exists($dir)) {
    mkdir($dir, 0777, true);
    }

    $filename = $tenant_data->tenant_name.'_'.$rate_code->account_code.'_bill.csv';
    $filepath = $dir . "/". $filename;
    $output = fopen($filepath, 'w');
    fputcsv($output, array('CALL DATE','SRC','DST','BILLSEC','DISPOSITION','RATE'));

    if(count($array_result) > 0) 
    {
      foreach ($array_result as $row) {                    
      fputcsv($output, $row);
      } 
      fputcsv($output, array('TOTAL','','','','',$total));
      fclose($output);
    }    
    //////////////////////////  

    if(count($array_result) > 0) 
    {
    ///////// Mail Code ////////    
    $config = Array(
     'protocol'  => 'smtp',
     'smtp_host' => 'mail.bizrtc.com',
     'smtp_port' => '587',
     'smtp_user' => SMTP_USER,
     'smtp_pass' => SMTP_PASS,
     'mailtype'  => 'html',
     'charset'   => 'utf-8',
     'wordwrap'  => TRUE,
     'smtp_timeout' => '30'
    );

    $this->load->library('email', $config);
    $this->email->set_newline("\r\n");
    $this->email->from(FROM_EMAIL);
    $this->email->to($tenant_data->email);
    $this->email->cc($cc);
    
    $this->email->subject('CDR Bill Details of '. date('M',strtotime($month)) );
    $this->email->message('Here attach your CDR call details with per call rate and total amount of bill.');
    $this->email->attach($filepath);
    if($this->email->send())
    {
      echo 'Email send '.$tenant_data->email.'<br>';
    }
    else
    {
     show_error($this->email->print_debugger());
    }
    ///////// Mail Code ////////  
    }
    }


}

}
?>