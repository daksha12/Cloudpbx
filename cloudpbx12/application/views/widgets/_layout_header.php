<?php
/****** GET LOGO *******/
$this->db->select('*');
$this->db->from('pbx_logo');
$this->db->where('user_id',$_SESSION['user_id']);
$query  = $this->db->get();
$result = $query->row();
$_SESSION['logo'] = count($result); 
/****** GET LOGO *******/
?>

<div class="row">

<div class="col-md-3" style="left: 10px;top: 5px;">
<?php if (count($result) == 1):?>
<img src="<?php echo site_url('upload/'.$result->logo_name); ?>" style="max-height:90px; max-width: 200px; float: left;" class=" img-responsive">
<?php else: ?>
<?php if($_SESSION['user_type'] == 'Admin') { ?>
<a href="#" data-toggle="modal" data-target="#UploadLogo">
<img id="place_logo_here" src="<?php echo site_url('images/place_your_logo.svg'); ?>" style="height:84px; 
width: 160px; float: left;margin-top: 3px;" class="js-animating-object animated swing img-responsive">
</a>
<?php } ?>
<?php endif; ?>
</div>

<div class="col-md-6" style="border-right:1">
<h1 class="h1-responsive" style="text-align: center; padding-top: 25px;" id="top-section" id="top_section">bizPBX Portal</h1>
</div>

<div class="col-md-3" >
<a href="http://www.bizrtc.com" target="_blank">  <img src="<?php echo site_url('images/bizrtc.png'); ?>" style="height:100px; width: 260px; float: right;  "  class="img-responsive"></a>
</div>
</div>

<!--Navbar-->




