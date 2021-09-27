<?php $this->load->view('components/page_head') ?>

<!--/.Navbar-->
<div class="login-page">
<div class="login-box animated flipInY" id="login_box">
<div class="card">
<?php $this->load->view($subview); // Subview is set in controller ?>
</div>
</div>
</div>    
</div>
</div>

<?php  $this->load->view('widgets/_layout_footer') ?>
<?php $this->load->view('components/page_tail'); ?>