<?php
class Reports extends Agent_Controller
{
public function __construct()
{
parent::__construct();
}

public function cdr()
{

if(isset($_POST['search'])){
 $_SESSION['fromdate'] = $_POST['fromdate'];
 $_SESSION['todate']   = $_POST['todate'];
}else{
 $_SESSION['fromdate'] = date('Y-m-d');
 $_SESSION['todate']   = date('Y-m-d');
}

$this->data['subview'] = 'agent/reports/cdr_report';
$this->load->view('_layout_main', $this->data);   
}
}
?>
