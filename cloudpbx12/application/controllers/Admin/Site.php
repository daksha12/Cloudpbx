<?php

class Site extends User_Controller
{
public function __construct()
{
parent::__construct();
}

public function index()
{
/*** GET EXTNSION ***/
$this->data['subview'] = 'admin/site/list_site';
$this->load->view('_layout_main', $this->data);   
}

public function codes()
{
$site = $this->Report_m->get_tenant_site('','','All');
/*** GET BRANCH ***/
$this->data['site_data'] = $site;
$this->data['subview']   = 'admin/site/code_list';
$this->load->view('_layout_main', $this->data);   
}

}
?>
