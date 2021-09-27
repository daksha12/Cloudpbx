  <?php
/**** SET TIME ****/
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends MY_Controller
{
  
  public function __construct()
  {
    parent::__construct();   
  }
  
 /****** FAQ List******/
  public function faq_list()
  {
    $this->data['header'] = "<i class='fa fa-list'></i> FAQ List" ; 
    $this->data['subheader'] = "FAQ";
    $this->data['help_body'] = "FAQ List";
    $this->data['info_title'] = "FAQ List";
    $this->data['info_body'] = "FAQ List";

    $this->db->select('*');
    $this->db->from('faq');
    $query = $this->db->get();
    $faqs = $query->result();
  
    $this->data['faqs'] =  $faqs;       

    $this->data['subview'] = 'faq/faq_list';  
    $this->load->view('soft_layout',$this->data);    
  }
  /****** End FAQ List ******/


   /****** FAQ Add ******/
    public function faq($id=null)
    {

    	error_reporting(0);
      $this->data['header'] = "<i class='fas fa-plus-square'></i> Add FAQ" ; 
      $this->data['subheader'] = "Add FAQ.";
      $this->data['help_body'] = "Add FAQ";
      $this->data['info_title'] = "Add FAQ";
      $this->data['info_body'] = "Add FAQ";

      $back = "";
      if(isset($id)){

        $this->data['header'] = "<i class='fas fa-plus-square'></i> Edit FAQ" ; 
        $this->data['subheader'] = "Edit FAQ.";
        $this->data['help_body'] = "Edit FAQ";
        $this->data['info_title'] = "Edit FAQ";
        $this->data['info_body'] = "Edit FAQ";

        $this->db->select('*');
        $this->db->from('faq');
        $this->db->where('faq_id',$id);
        $query = $this->db->get();
        $faq_detail = $query->row();

        $back = "/".$id;
      }

      /**** Data Get From ***/
      if(isset($_POST['Save'])){
       $faq_title = $_POST['faq_title'];                         
       $faq_desc = $_POST['faq_desc']; 
       $faq_category = $_POST['faq_category'];
       $createdate = date('Y-m-d H:i:s');

      
      if(empty($faq_title)){
        $this->session->set_flashdata('error','Faq Title is required field !!');
        redirect('Faq/faq'.$back);
      }
      else if(empty($faq_category)){
        $this->session->set_flashdata('error','Faq Category is required field !!');
        redirect('Faq/faq'.$back);
      }
      else if(empty($faq_desc)){
        $this->session->set_flashdata('error','Faq Description is required field !!');
        redirect('Faq/faq'.$back);
      }

       /*** Insert Data ***/
       $data = array('faq_title' => $faq_title,'faq_desc'=> $faq_desc, 'faq_category' => $faq_category, 'faq_created_at' => $createdate);

        if(isset($id)){
          $this->db->where('faq_id',$id); 
          $this->db->update('faq',$data);
          $this->session->set_flashdata('message','FAQ Updated Successfully !!');
        }else{
           $this->db->insert('faq',$data);
           $this->session->set_flashdata('message','FAQ Add Successfully !!');
        }          
        redirect('Faq/faq_list');
      }
      /**** Data Get From  ***/
      $this->data['faq_detail'] = $faq_detail;
      $this->data['subview'] = 'faq/faq';  
      $this->load->view('soft_layout',$this->data);     
  }
  /****** End FAQ ADD ******/

  public function faq_delete($id=null)
  {
    $this->db->delete('faq', array('faq_id' => $id));

    $this->session->set_flashdata('message','FAQ Deleted Successfully !!');
    redirect('Faq/faq_list');    
  }

} 
?>