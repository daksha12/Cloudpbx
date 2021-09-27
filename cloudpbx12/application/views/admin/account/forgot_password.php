<?php $this->load->view('components/page_head') ?>

 <div style="height: 100vh">
    <div class="flex-center flex-column" style="margin-top: -40px">

      <h1 class="text-hide animated fadeIn mb-4" style="background-image: url(<?php echo site_url('images/bizrtc.png'); ?>); width: 500px;
    height: 150px;">bizRTC</h1>
      <div class="row">
        <div class="col-md-12">
        
             
             <div class="col-md-12">
               
                <p class="animated fadeIn mb-3 note note-primary text-center"><strong>Note :
                </strong> Please keep your registered phone handy, an OTP will be sent to that number. If you do not receive an OTP kindly, contact our support at bizcare@bizrtc.com </p>
            
             </div>

        </div>
      </div>
      
      <div class="row">
        <div class="col-md-12">
            <a href="<?php echo site_url('secure/login'); ?>"> <button type="button" class="btn btn-outline-primary waves-effect" ><i class="fas fa-arrow-left fa-lg " aria-hidden="true"></i> Back</button></a>
 
         <a href=""   data-toggle="modal" data-target="#sendOTPModal" class="btn btn-outline-primary waves-effect" >Verify Your Details</a>

     
        </div>
      </div>  
      
    </div>
  </div>


<!--Modal Form Login with Avatar Demo-->
  <div class="modal animated flipInY " id="sendOTPModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true" >
    <div class="modal-dialog cascading-modal modal-avatar modal-sm" role="document">
      <!--Content-->
      <div class="modal-content">

        <!--Header-->
        <div class="modal-header">
          <img src="<?php echo site_url('images/verify_otp.png'); ?>" class="rounded-circle img-responsive"
            alt="Avatar photo">
        </div>
        <!--Body-->
        <div class="modal-body text-center mb-1">        
          <h5 class="mt-1 mb-2">Enter your details</h5>
          <div id="element">
            
          </div>
          <form action="" autocomplete="off" method="post" class="needs-validation" novalidate>
            <div class="md-form ml-0 mr-0 md-outline">
              <input type="text" id="username" name="username" class="form-control ml-0" maxlength="6" required="">
              <label for="username" class="ml-0">Enter your username</label>
              <div class="invalid-feedback">
                Please provide valid username.
             </div>
            </div>

            <div class="select-outline">
                <select class="mdb-select md-form md-outline colorful-select dropdown-primary" name="auth_method">
                  <option value="email">e-Mail</option>
                  <option value="phone">Phone</option>
                </select>

            </div>
            <div class="text-center mt-4">
              <button class="btn btn-outline-primary waves-effect" type="submit">Submit
           
              </button>
            </div>
          </form>
          
        </div>

      </div>
      <!--/.Content-->
    </div>
  </div>
  <!--Modal Form Login with Avatar Demo-->


<?php  $this->load->view('widgets/_layout_footer') ?>
<?php $this->load->view('/components/page_tail'); ?>
