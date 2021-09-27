<?php

class Company extends User_Controller
{
public function __construct()
{
parent::__construct();
}

public function info()
{
 /**** TIME ZONE GET FOR TENANT ****/ 
 $tenant_details = $this->Report_m->get_tenant_info();  

 $sales_details  = $this->Report_m->get_sales_info(get_account_code($tenant_details->account_id));

 $this->data['sales_details']  = $sales_details;
 $this->data['tenant_details'] = $tenant_details;
 $this->data['subview'] = 'admin/company/tenant_info';
 $this->load->view('_layout_main', $this->data);   
}

public function time_zone()
{
 /**** TIME ZONE GET FOR TENANT ****/ 
 $time_zone = $this->Report_m->get_tenant_info();  

 $this->data['time_zone']  = $time_zone->time_zone;
 $this->data['subview'] = 'admin/company/time_zone';
 $this->load->view('_layout_main', $this->data);   
} 

}
?>
