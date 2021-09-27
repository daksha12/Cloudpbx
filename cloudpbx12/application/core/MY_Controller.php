<?php
class MY_Controller extends CI_Controller {
	
	public $data = array();
		function __construct() {
		
			parent::__construct();
			
			$this->data['errors'] = array();
			$this->load->helper('security');
			$this->data['site_name'] = config_item('site_name');
			$this->data['meta_title'] = 'PBX';	
			
			$this->load->helper('form');
		    $this->load->library('form_validation');
	     	$this->load->library('session');
	  	    $this->load->helper('report_helper');
		
		    // LOAD MODAL //
		    $this->load->model('Login_m');
		    $this->load->model('Logo_m');
		    $this->load->model('Report_m');
		    $this->load->model('Faq_m');
		
		    /**** GET MENU HELP AND INFO TEXT ****/
			error_reporting(0);
			$uri = $this->uri->segment(1);
			if($uri != 'secure'){
			$uri1 = $this->uri->segment(2);
			$uri2 = $this->uri->segment(3);

			$this->db->select('*');
			$this->db->LIKE('uri',$uri1.'/'.$uri2); /// user login id session
			$this->db->from('menu_list');			
			$query  = $this->db->get();
			$page_details = $query->row();
			$this->data['menu_icon']    = $page_details->menu_icon; // ALL PAGE icon
			$this->data['page_title']   = $page_details->page_title; // ALL PAGE TITLE
			$this->data['info_text']    = $page_details->info_text;  // ALL PAGE INFO TEXT
			$this->data['help_text']    = $page_details->help_text; // ALL PAGE HELP TEXT				
			}
			/**** GET MENU HELP AND INFO TEXT ****/

		}
}		