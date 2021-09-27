<?php $this->load->view('/components/page_head') ?>
<body style="background: #e4e4e485">
<div class="row">
  <div class="col-md-3"></div>
  <div class="col-md-6"><h1 class="font-weight-bold text-center my-4">System Configuration</h1></div>

  <div class="col-md-3">
    <a href="http://www.bizrtc.com" target="_blank">  <img src="<?php echo site_url('images/bizrtc.png'); ?>" style="height:100px; width: 260px; float:center;  "></a>
  </div>

  <div class="col-md-12"><hr style="margin-top:0px !important"></div>

  <div class="col-md-4"></div>

  <div class="col-md-4">
    <!-- Material form login -->
    <div class="card">
      <h5 class="card-header info-color white-text text-center py-4">
        <strong>Login</strong>
      </h5>
      <!--Card content-->
      <div class="card-body px-lg-5 pt-0">
        <!-- Form -->
        <form class="text-center" style="color: #757575;" action="<?php site_url('System_configuration/login')?>" method="post" id="loginform" name="loginform" onsubmit="return validateForm();">
  
          <?php if(!empty($error)){
            ?>  <p class="note note-danger col-md-12 mt-2" id="msg"><strong>Error :</strong> <?php echo $error;?></p><?php
          }
          ?>

          <!-- Email -->
          <div class="md-form md-outline">
            <input type="text" id="username" name="username" onkeypress="return blockSpecialChar(event)" class="form-control avoid_space" required>
            <label for="username">Tenant name</label>
          </div>

          <!-- Password -->
          <div class="md-form md-outline">
            <input type="password" id="password" name="password" class="form-control"   required >
            <label for="password">Password</label>
          </div>
          <!-- Sign in button -->
          
          <div class="text-left">
            <input type="submit" class="waves-effect waves-dark btn btn-sm btn-primary" name="login" value="Login" onclick="validateForm();">
          </div>
        </form>
      </div>   
      <!-- Register -->      
      <div class="col-md-12">
        <hr>
        <p>
          <center><a href="" data-toggle="modal" data-target="#centralModalInfo">Create new account </a></center>
        </p>
      </div>
    </div>
  </div>
  <div class="col-md-4"></div>
  <!-- Central Modal Medium Info -->
  <div class="modal fade" id="centralModalInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
   aria-hidden="true"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-notify modal-info" role="document" style="width:350px;">
     <!--Content-->
      <div class="modal-content">
        <div class="modal-body">
          <form  method="post" action="<?php echo site_url('System_configuration/addaccount');?>">
            <h5><i class="fas fa-tasks"></i> Account details</h5><hr style="margin-top: 5px;margin-bottom: 0;">  
            <div class="md-form md-outline">
              <input type="text" id="account_code" name="account_code" style="width: 300px;height:38px;" class="form-control avoid_space" value="" pattern="^[0-9]*$" required>
              <label for="account_code">Account code</label>
            </div>

            <div class="md-form md-outline">
              <input type="text" name="tenant_name" id="tenant_name" style="width: 300px;height:38px;" value="" class="form-control avoid_space" onkeypress="return blockSpecialChar(event)" required>
              <label for="tenant_name">Tenant name</label>
            </div>
    
            <div class="md-form md-outline">
              <input type="email" name="email" id="email" value="" style="width: 300px;height:38px;" class="form-control avoid_space" required>
              <label for="email">E-mail</label>
            </div>

            <div class="md-form md-outline">
              <input type="password" name="password" id="password" value="" style="width: 300px;height:38px;" class="form-control avoid_space"  required>
              <label for="password">Password</label>
            </div>

            <select name="time_zone" class="browser-default custom-select ivr_trunk_select" style="margin-top: 20px;" required> 
              <option value="" disabled selected>Time zone</option>
              <?php 
              if(!empty($timeZonesList)){
                foreach ($timeZonesList as $key => $timeZone) {
                  ?><option value="<?php echo $timeZone->time;?>"><?php echo $timeZone->name;?></option><?php
                }
              }
              ?>
            </select>   
          
             <!--Footer-->
            <div class="modal-footer justify-content-center">
              <div class="col-md-12" style="text-align: left;">
                <input type="submit" class="waves-effect waves-dark btn btn-sm btn-primary" name="add_Account" value="Save">
                <input type="submit" class="waves-effect waves-dark btn btn-sm btn-primary" name="" data-dismiss="modal" value="Close">
              </div>
            </div>
          </form>
        </div>
      </div>
     
     <!--/.Content-->
    </div>
  </div>
</div>
 <!-- Central Modal Medium Info-->
<?php $this->load->view('/components/page_tail') ?>
<?php  $this->load->view('widgets/_layout_footer') ?>