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
$where = "menu_name IN ('Dashboard','Call Recording')";
//$this->db->where_in('menu_name','Dashboard','Call Recording');
$this->db->where($where);      
$query    = $this->db->get();
$menulist = $query->result();
//echo $this->db->last_query();
//var_dump($menulist);
//exit(0);
foreach ($menulist as $menu){
$menuname = $menu->id; //str_replace(" ","_",$menu->menu_name);
?>	

<?php if($menu->sub_menu == '0') { ?>
<!---- Single Menu -----> 
<li class="nav-item" id="<?php echo str_replace(' ', '', $menu->menu_name); ?>">
 <a class="nav-link waves-effect waves-light <?php echo $menu->disable ?>" href="<?php echo site_url('Agent/'.$menu->uri); ?>"> <?php echo $menu->menu_name ?> 
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
$query    = $this->db->get();
$sublist = $query->result();
foreach ($sublist as $submenu) {
$subname = $submenu->id;
?>   
<a class="dropdown-item waves-effect waves-light <?php echo $submenu->disable; ?>" href="<?php echo site_url('Agent/'.$submenu->uri); ?>"> <?php echo $submenu->menu_name ?></a>      
<?php  } ?>
</div>
</li>
<!---- End Dropdown Menu ----->
<?php } } ?>
</ul>
<!-- Links -->


<ul class="navbar-nav ml-auto nav-flex-icons">

<li class="nav-item dropdown notifications-nav ">

<div class="dropdown-menu dropdown-primary dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">

<a class="dropdown-item waves-effect waves-light" href="<?php echo site_url('tenant/activity'); ?>">
<span>You have 0 failed login attempts.</span>
<span class="float-right"><i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i> </span>
</a>

<a class="dropdown-item waves-effect waves-light" href="#">
<span>No New Notification</span>
<span class="float-right"><i class="fas fa-exclamation-triangle mr-2" aria-hidden="true"></i> </span>
</a>
</div>
</li> 


<li class="nav-item dropdown active ">
<a class="nav-link dropdown-toggle waves-effect waves-light" id="navbarDropdownMenuLink-5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
<strong><?php echo $_SESSION['username'] ?></strong>
</a>

<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink-5">
<a class="dropdown-item waves-effect waves-light" href="" data-toggle="modal" id="change_pass" data-target="#ChangePass"><i class="fas fa-lock"></i>  Change Password</a>
<?php if($_SESSION['user_type'] == 'Agent'){ ?>
  <a class="dropdown-item waves-effect waves-light" href="<?php echo site_url('secure/agentlogout')?>"> <i class="fas fa-power-off"></i> Logout</a>
<?php }else{ ?>
	<a class="dropdown-item waves-effect waves-light" href="<?php echo site_url('secure/logout')?>"> <i class="fas fa-power-off"></i> Logout</a>
<?php } ?>
</div>
</li>
</ul>
</div>
<!-- Collapsible content -->
</nav>
<!--/.Navbar-->