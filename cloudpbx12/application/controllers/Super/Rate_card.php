<?php
class Rate_card extends User_Controller
{
public function __construct()
{
parent::__construct();
}

public function index($id = null)
{ 
  if(isset($_POST['save'])){

     $country = $_POST['country_code'];
     $rate    = $_POST['rate'];
     $pulse   = $_POST['pulse'];
     $id      = $_POST['id'];

    $valide = get_country_code($country,$id);
    if($valide == '1'){
  	$this->session->set_flashdata('swal_error', 'County Code Already Added');
    redirect('Super/rate_card/index/'.$id);	
    }

     $data = array(
      'country_code' => $country,
      'rate'         => $rate,
      'pulse'        => $pulse, 
      'create_by'    => $_SESSION['username'], 
     );

     if($id == ''){
      $this->db->insert('rate_card',$data);
     }else{
      $this->db->where('id',$id);
      $this->db->update('rate_card',$data);
     }
  
  	$this->session->set_flashdata('swal_message', 'Rate Card Add Successfully');
    redirect('Super/rate_card/index');	

  }	

  $this->data['rate_card_id'] = get_rate_card($id);
  $this->data['rate_card']    = get_rate_card();
  $this->data['subview'] = 'super/rate_card';
  $this->load->view('_layout_main', $this->data);   
}

public function delete($id)
{
 
  $this->db->where('id', $id);
  $del=$this->db->delete('rate_card');       
  $affectedRows=$this->db->affected_rows();
  if($affectedRows > 0){
  $this->session->set_flashdata('swal_message','Rate Card Deleted Successfully'); 
  }else{
  $this->session->set_flashdata('swal_error','Rate Card Not Deleted'); 
  }

  redirect('Super/rate_card/index');
}

}
?>