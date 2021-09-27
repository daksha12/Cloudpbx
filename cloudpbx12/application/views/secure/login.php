
<?php echo validation_errors(); ob_start();
$attributes = array('autocomplete'=>'off','class'=>"needs-validation",'novalidate'=>'true'); ?>
<!-- Rotating card -->

<div class="card" style="width: 28rem;height: auto;margin: 0 auto;top: 50%;">
<div id="card-1" class="card-rotating effect__click h-100 w-100 mt-5" style="background-color: #fff">
<!-- Front Side -->
<div class="face front">
<!-- Image-->
<div class="card-up text-center" style="margin-top:15px;">
<img class="js-animating-object animated img-responsive " src="<?php echo site_url('images/bizrtc.png'); ?>" style="height:100px; width: 260px;margin-bottom: 10px;" >
<h2 style="text-align: center;" class="m-t-10">
<i class="fas fa-user-tie" aria-hidden="true" ></i> Admin    
</h2>
</div>
<!-- Avatar -->
<!-- Content -->
<div class="card-body">
<?php echo form_open('secure/login',$attributes);?>
<div class="md-form md-outline">
<?php echo form_input('username', set_value('username'),'class="form-control avoid_space" name="username" placeholder="Username" required autofocus'); ?>
</div>
<div class="md-form md-outline">
<?php echo form_password('password',set_value('password'),'class="form-control avoid_space" name="password" placeholder="Password" required'); ?>
<span toggle="#input-pwd" class="fa fa-fw fa-eye field-icon toggle-password"></span>
</div>
<div class="row">
<div class=" col-md-12" >
<?php echo form_submit('submit', 'Login', 'class="btn btn-primary waves-effect btn-sm " style="color:white !important;"'); ?>
<!--a href="<?php echo site_url('Admin/account/forgot_password'); ?>" class="float-right mt-3"> Forgot Password <i class="fas fa-unlock-alt"></i></a-->
<br><br>
</div>
</div>
<?php echo form_close();?>
<?php  if ($this->session->flashdata('error')) {  ?>
<p class="note note-danger col-md-12 mt-2" id="msg"><strong>Error :</strong> <?php echo $this->session->flashdata('error'); ?></p>
<?php } ?> 
</div>
</div>
<!-- Front Side -->
</div>
</div>
