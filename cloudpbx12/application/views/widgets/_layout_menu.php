<?php if($_SESSION['user_type'] == 'Super Admin'){ ?>

<nav class="navbar navbar-expand-lg navbar-dark primary-color affix-top" data-spy="affix" data-offset-top="197" id="main-nav" style="margin-bottom: 20px; background-color: #000 !important;">
<!-- Collapse button -->
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav" aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>

<!-- Collapsible content -->
<div class="collapse navbar-collapse" id="basicExampleNav">
<!-- Links -->
<ul class="navbar-nav mr-auto">
<?php
/****** DATA GET FROM DATABASE ******/
$this->db->select('*');
$this->db->from('menu_list'); 
$this->db->order_by('menu_position');
$this->db->where('parent_id','0');
$this->db->where('disable !=','disabled');
$this->db->where('super_rights','1');
$query    = $this->db->get();
$menulist = $query->result();
foreach ($menulist as $menu){
$menuname = $menu->id; //str_replace(" ","_",$menu->menu_name);
?>	

<?php if($menu->sub_menu == '0') { ?>
<!---- Single Menu -----> 
<li class="nav-item" id="<?php echo str_replace(' ', '', $menu->menu_name); ?>">
<a class="nav-link waves-effect waves-light <?php echo $menu->disable ?>" href="<?php echo site_url('Super/'.$menu->uri); ?>"> <?php echo $menu->menu_name ?> 
<span class="sr-only">(current)</span>
</a>
</li> 
<!---- End Single Menu ----->
<?php }else{ ?>
<!---- Dropdown Menu ----->

<li class="nav-item dropdown" id="<?php echo str_replace(' ', '', $menu->menu_name); ?>">
<a class="nav-link dropdown-toggle waves-effect waves-light <?php echo $menu->disable ?>" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">  <!--i class="<?php echo $menu->menu_icon ?>"></i--> <?php echo $menu->menu_name ?> </a>
<div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
<?php
/****** DATA GET FROM DATABASE ******/
$this->db->select('*');
$this->db->from('menu_list'); 
$this->db->order_by('menu_position');
$this->db->where('parent_id',$menu->id);  
$this->db->where('disable !=','disabled');    
$this->db->where('super_rights','1');
$query    = $this->db->get();
$sublist = $query->result();
foreach ($sublist as $submenu) {
$subname = $submenu->id;
?>   
<a class="dropdown-item waves-effect waves-light <?php echo $submenu->disable; ?>" href="<?php echo site_url('Super/'.$submenu->uri); ?>"> <?php echo $submenu->menu_name ?></a>      
<?php  } ?>
</div>
</li>
<!---- End Dropdown Menu ----->
<?php } } ?>
</ul>
<!-- Links -->


<ul class="navbar-nav ml-auto nav-flex-icons">


<li class="nav-item dropdown active ">
<a class="nav-link dropdown-toggle waves-effect waves-light" id="navbarDropdownMenuLink-5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
<strong>
<?php 
echo strtolower($_SESSION['username']); 
?>
</strong>
</a>

<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink-5">

<a class="dropdown-item waves-effect waves-light" href="<?php echo site_url('secure/logout')?>"> <i class="fas fa-power-off"></i> Logout</a>

</div>
</li>
</ul>
</div>
<!-- Collapsible content -->
</nav>
<!--/.Navbar-->

<?php }else { ?>

<nav class="navbar navbar-expand-lg navbar-dark primary-color affix-top" data-spy="affix" data-offset-top="197" id="main-nav" style="margin-bottom: 20px; background-color: #000 !important;">
<!-- Collapse button -->
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav" aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>

<!-- Collapsible content -->
<div class="collapse navbar-collapse" id="basicExampleNav">
<!-- Links -->
<ul class="navbar-nav mr-auto">
<?php
/****** DATA GET FROM DATABASE ******/
$this->db->select('*');
$this->db->from('menu_list'); 
$this->db->order_by('menu_position');
$this->db->where('parent_id','0');
$this->db->where('disable !=','disabled');
if($_SESSION['user_type'] == 'Admin'){
$this->db->where('admin_rights','1');
} 
if($_SESSION['user_type'] == 'Agent'){
$this->db->where('agent_rights','1');
}      
$query    = $this->db->get();
$menulist = $query->result();
foreach ($menulist as $menu){
$menuname = $menu->id; //str_replace(" ","_",$menu->menu_name);
?>	

<?php if($menu->sub_menu == '0') { ?>
<!---- Single Menu -----> 
<li class="nav-item" id="<?php echo str_replace(' ', '', $menu->menu_name); ?>">
<a class="nav-link waves-effect waves-light <?php echo $menu->disable ?>" href="<?php echo site_url($_SESSION['user_type'].'/'.$menu->uri); ?>"> <?php echo $menu->menu_name ?> 
<span class="sr-only">(current)</span>
</a>
</li>
<!---- End Single Menu ----->
<?php }else{ ?>
<!---- Dropdown Menu ----->

<li class="nav-item dropdown" id="<?php echo str_replace(' ', '', $menu->menu_name); ?>">
<a class="nav-link dropdown-toggle waves-effect waves-light <?php echo $menu->disable ?>" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">  <!--i class="<?php echo $menu->menu_icon ?>"></i--> <?php echo $menu->menu_name ?> </a>
<div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
<?php
/****** DATA GET FROM DATABASE ******/
$this->db->select('*');
$this->db->from('menu_list'); 
$this->db->order_by('menu_position');
$this->db->where('parent_id',$menu->id);  
$this->db->where('disable !=','disabled'); 
if($_SESSION['user_type'] == 'Admin'){
$this->db->where('admin_rights','1');
}    
if($_SESSION['user_type'] == 'Agent'){
$this->db->where('agent_rights','1');
} 
$query    = $this->db->get();
$sublist = $query->result();
foreach ($sublist as $submenu) {
$subname = $submenu->id;
?>   
<a class="dropdown-item waves-effect waves-light <?php echo $submenu->disable; ?>" href="<?php echo site_url($_SESSION['user_type'].'/'.$submenu->uri); ?>"> <?php echo $submenu->menu_name ?></a>      
<?php  } ?>
</div>
</li>
<!---- End Dropdown Menu ----->



<?php } } ?>
</ul>
<!-- Links -->


<ul class="navbar-nav ml-auto nav-flex-icons">


<li class="nav-item dropdown active ">
<a class="nav-link dropdown-toggle waves-effect waves-light" id="navbarDropdownMenuLink-5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
<strong>
<?php 
if($_SESSION['user_type'] == 'Admin'){
echo strtolower($_SESSION['username']); 
}else{
echo strtolower($_SESSION['extension']);	
}
?>
</strong>
</a>

<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink-5">
<?php if($_SESSION['user_type'] == 'Admin'){ ?>
<a class="dropdown-item waves-effect waves-light" href="<?php echo site_url($_SESSION['user_type'].'/crm_data'); ?>"  id="crm_config"><i class="fas fa-list"></i>  CRM Configration</a>
<a class="dropdown-item waves-effect waves-light" href="<?php echo site_url($_SESSION['user_type'].'/LDAP'); ?>"  id="crm_config"><i class="fas fa-list"></i> LDAP Configration</a>

<?php } ?>
<a class="dropdown-item waves-effect waves-light" href="" data-toggle="modal" id="change_pass" data-target="#ChangePass"><i class="fas fa-lock"></i>  Change Password</a>

<?php if($_SESSION['user_type'] == 'Agent'){ ?>
<a class="dropdown-item waves-effect waves-light" href="<?php echo site_url('secure/agentlogout')?>"> <i class="fas fa-power-off"></i> Logout</a>
<?php }else{ ?>
<a class="dropdown-item waves-effect waves-light <?php if($_SESSION['logo'] == 0){ ?>disabled <?php } ?>" onclick="ConfirmAndRelease('<?php echo site_url('Admin/dashboard/reset_logo') ?>','Reset the current logo')"><i class="fas fa-key"></i>  <?php echo $logo; ?>Reset Logo</a>	
<a class="dropdown-item waves-effect waves-light" href="<?php echo site_url('secure/logout')?>"> <i class="fas fa-power-off"></i> Logout</a>
<?php } ?>
</div>
</li>
</ul>
</div>
<!-- Collapsible content -->
</nav>
<!--/.Navbar-->
<?php } ?>