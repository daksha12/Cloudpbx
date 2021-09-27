    <?php $this->load->view('components/page_head') ?>


    <div class="col-lg-12 p-5" style="width: 50rem;height: auto;margin: 0 auto;margin-top:50px"> 
    <div class="card mb-12 p-2 blue-gradient">

    <!-- Image-->
    <div class="card-up text-center" style="margin-top:5px;">

    <img class="js-animating-object animated img-responsive " src="<?php echo site_url('images/bizrtc.png'); ?>" style="height:120px; width: 350px;margin-bottom: 10px;" >     
    <hr style="margin-top: -10px"></div>

    <!-- Grid row -->
    <p class="h3 text-center" > Cloud PBX Portal</p>
    <div class="row p-5">
    <!-- Grid column -->

    

    <div class="col-lg-6 col-md-12" style="text-align: center;font-size: 60px">
    <!-- Panel -->
    <a href="<?php echo site_url('secure/login') ?>">
    <div class="card mb-6  blue-gradient">
    <div class="card-body">
    <i class="fas fa-user-tie"></i>   
    <h4 style="text-align: center;">Admin</h4>
    </div>
    </div>
    <!-- Panel -->
    </div>
    </a>
    <!-- Grid column -->

    <!-- Grid column -->
    <div class="col-lg-6 col-md-12" style="text-align: center;font-size: 60px">
    <!-- Panel -->
    <a href="<?php echo site_url('secure/agentlogin') ?>">
    <div class="card mb-6 blue-gradient">
    <div class="card-body">
    <i class="fas fa-user"></i>
    <h4 style="text-align: center;">User</h4>
    </div>
    </div>
    <!-- Panel -->
    </div>
    </a>
    <!-- Grid column -->

    </div>
    <!-- Grid row -->
    </div>
    </div>


    <?php  $this->load->view('widgets/_layout_footer') ?>
    <?php $this->load->view('components/page_tail'); ?>