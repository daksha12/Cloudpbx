<?php

class Number extends User_Controller
{
public function __construct()
{
parent::__construct();
}

public function index()
{
$this->data['subview'] = 'admin/number/block_number';
$this->load->view('_layout_main', $this->data);   
}

public function outgoing_number()
{
$this->data['subview'] = 'admin/number/outgoing_list';	
$this->load->view('_layout_main', $this->data);   
}

}
?>
