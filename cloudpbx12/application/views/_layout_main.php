<?php $this->load->view('components/page_head') ?>
<?php $this->load->view('widgets/_layout_header') ?>
<?php $this->load->view('widgets/_layout_menu'); ?>

<!---- SUB VIEW ----->
<div class="row box">
<!-- HEADER FILE -->
<div class="col-md-12 mt-2">
<span style="font-size: 20px"><i class="<?php echo $menu_icon ?>"></i>  <?php echo $page_title ?></span>

<?php if($_SESSION['user_type'] == 'Agent'){ 

 /*** GET PREFIX ***/
 $prefix = $this->Report_m->get_prefix_old();
 /*** GET PREFIX ***/
 $extension_status = get_ext_status($prefix->softphone_prefix.$_SESSION['extension'],$_SESSION['site_name']);
 $mobile_status    = get_ext_status($prefix->mobile_prefix.$_SESSION['extension'],$_SESSION['site_name']);
 $desktop_status   = get_ext_status($prefix->desktop_prefix.$_SESSION['extension'],$_SESSION['site_name']);
?>
&nbsp;&nbsp;&nbsp;&nbsp;
<span>
Softphone : 
<?php if ($extension_status != '') { ?>
<a class="btn-floating btn-sm success-color" data-toggle="tooltip" title="Host :<?php echo $extension_status ?>"></a>
<?php }else{ ?>
<a class="btn-floating btn-sm btn-danger"></a>
<?php } ?>  

Mobile Phone :  
<?php if ($mobile_status != '') { ?>
<a class="btn-floating btn-sm success-color" data-toggle="tooltip" title="Host :<?php echo $mobile_status ?>"></a>
<?php }else{ ?>
<a class="btn-floating btn-sm btn-danger"></a>
<?php } ?>

Deskphone : 
<?php if ($desktop_status != '') { ?>
<a class="btn-floating btn-sm success-color" data-toggle="tooltip" title="Host :<?php echo $desktop_status ?>"></a>
<?php }else{ ?>
<a class="btn-floating btn-sm btn-danger"></a>
<?php } ?>
</span>
<?php } ?>


<span style="float: right;">
<!----- BRANCH START ----->
<?php 
if($_SESSION['user_type'] == 'Admin' AND strtolower($this->uri->segment(2)) != 'company'){
$sites     = get_sites_details(); 
$site_cout = count($sites);
if($site_cout > 1){ 
?>
<button class="btn btn-outline-dark btn-sm dropdown-toggle" type="button" id="dropdownMenu4" data-toggle="dropdown"
aria-haspopup="true" aria-expanded="false" style="padding: 1px;margin-top: -1px;padding-right: 10px;padding-left: 10px;">
<?php 
if($_SESSION['site_id'] == 'All'){
 echo 'All Branch';
}else{
 echo $_SESSION['site_name'];	
}
?>
</button>
<div class="dropdown-menu" aria-labelledby="dropdownMenu4">
<?php 
foreach ($sites as  $value) {
if($value->id != $_SESSION['site_id']){
?>
 <a class="dropdown-item" href="<?php echo site_url($_SESSION['user_type'].'/Account/set_session/'.$value->id.'/'.$value->site_name) ?>"><?php echo $value->site_name ?></a>
<?php 
} }
if('All' != $_SESSION['site_id']){
?>
<div class="dropdown-divider"></div>
<a class="dropdown-item" href="<?php echo site_url($_SESSION['user_type'].'/Account/set_session/All/All') ?>">All Branch</a>
<?php } ?>
</div>
<?php }else{ ?>
<button class="btn btn-primary btn-sm dropdown-toggle" type="button" style="padding: 3px;margin-top: -1px;padding-right: 10px;padding-left: 10px;">
<?php echo $_SESSION['site_name']; ?>
</button>
<?php } } ?>	
<!----- BRANCH END ----->

<a href = "javascript:history.back()" class="atag">
<i class="fas fa-arrow-left"></i>
</a>

<i class="fas fa-info-circle" tabindex="0" data-trigger="hover" data-toggle="tooltip" data-placement="left" title="<?php echo $info_text ?>" data-content="<?php echo $info_text ?>"></i>

<i class="fas fa-question-circle" tabindex="0" data-trigger="hover" data-toggle="tooltip" data-placement="left" title="<?php echo $help_text ?>" data-content="<?php echo $help_text ?>"></i>
</span> 
<hr style="margin-top:1px">
</div>
<!--- END FILE --->	

<?php $this->load->view($subview); ?>    
<br><br>
</div>
<style type="text/css">
	a{
		text-decoration-color: none;
	}
</style>
<!---- SUB VIEW ----->

<?php $this->load->view('widgets/_layout_footer') ?>
<?php $this->load->view('widgets/_layout_modal') ?>
<?php $this->load->view('components/page_tail'); ?>

