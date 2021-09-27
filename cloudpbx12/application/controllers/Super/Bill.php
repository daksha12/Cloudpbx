<?php
class Bill extends User_Controller
{
public function __construct()
{
parent::__construct();
}

public function index($id = null)
{ 
  
  if(isset($_POST['save'])){

    $account = get_account_detail_id($_POST['account']);
    $account_id = $_POST['account'];
    $rate    = $_POST['rate_card'];
    $id      = $_POST['id'];

    $valide = get_assign_rate($account,$id);
    if($valide == '1'){
  	  $this->session->set_flashdata('swal_error', 'Rate Card Already Added');
      redirect('Super/bill/index/'.$id);	
    } 

    $count  = count($rate); $rate ='';
    for($i=0; $i < $count; $i++) { 
     $rate .= $_POST['rate_card'][$i].',';
    }

    $data = array(
     'account_id' => $account_id,
     'account_code' => $account,
     'rate_card'    => $rate, 
     'create_by'    => $_SESSION['username'], 
    );

    if($id == ''){
      $this->db->insert('assign_rate_card',$data);
    }else{
      $this->db->where('id',$id);
      $this->db->update('assign_rate_card',$data);
    }
  
  	$this->session->set_flashdata('swal_message', 'Rate Card Add Successfully');
    redirect('Super/bill/index');	

  }	

  if($id != ''){
   $this->data['assign_rate_card_data'] = get_assign_rate_details($id);
  }

  $this->data['assign_rate_card_details'] = get_assign_rate_details();
  $this->data['tenant']    = get_all_tenant();
  $this->data['rate_card'] = get_rate_card();
  $this->data['subview']   = 'super/bill';
  $this->load->view('_layout_main', $this->data);   

}

public function delete($id)
{
  $this->db->where('id', $id);
  $del=$this->db->delete('assign_rate_card');       
  $affectedRows=$this->db->affected_rows();
  if($affectedRows > 0){
  $this->session->set_flashdata('swal_message','Tenant Rate Deleted Successfully'); 
  }else{
  $this->session->set_flashdata('swal_error','Tenant Rate Not Deleted'); 
  }

  redirect('Super/bill/index');
}

public function view()
{
  $this->data['subview']   = 'super/view_bill';
  $this->load->view('_layout_main', $this->data);  
}


}
?>