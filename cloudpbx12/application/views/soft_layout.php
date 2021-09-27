<?php $this->load->view('components/page_head') ?> 
<?php $this->load->view('widgets/_layout_header') ?>

 <div class="col-md-12" style="margin-bottom: 10px;">
   <div class="row"> 
      <div class="col-md-12">
         <!-- Card Light -->
        <div class="card card-cascade" id="card_scroll"> 
          <!-- Card content -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-9">
                 <!-- Title -->
                 <h3 class="card-title"><?php echo $header ?></h3><small class="text-title"><?php echo $subheader ?></small>
              </div>
              <div class="col-md-3 text-right"> 
                   <?php if(isset($_SERVER['HTTP_REFERER'])) {$url = $_SERVER['HTTP_REFERER'];}else{ $url = 'Faq/faq_list';} ?>
                  <a href="<?php echo $url ?>" data-trigger="hover" data-container="body" data-toggle="popover" data-placement="bottom" title="" data-content="Go Back" data-original-title=""><i class="fas fa-arrow-left"></i> </a>

                  <a href="javascript:void(0);" data-trigger="hover" data-container="body" data-toggle="popover" data-placement="left" title="" data-content="<?php echo $help_body;?>" data-original-title="<?php echo $info_title;?>"> <i class="fas fa-question-circle"></i>
                  </a> 

                  <a href="javascript:void(0);" data-trigger="hover" data-container="body" data-toggle="popover" data-placement="bottom" title="" data-content="<?php echo $info_body;?>" data-original-title="<?php echo $info_title;?>"><i class="fas fa-info-circle"></i> </a>  
              </div>
        </div> 
        <hr >
        <!-- show error and success message on action=== -->
        <?php
          if ($this->session->flashdata('message')) {  ?> 
         <p class="note note-success col-md-6 mt-2"><strong>Success :</strong> <?php echo $this->session->flashdata('message'); ?> 
        <?php }  ?> 
        <?php  if ($this->session->flashdata('error')) {  ?>
        <p class="note note-danger col-md-6 mt-2"><strong>Error :</strong> <?php echo $this->session->flashdata('error'); ?> 
        <?php }   
        $this->load->view($subview); 
        ?>  
          </div>
        </div>
      </div> 
     </div>
 </div>
</div>

<?php $this->load->view('widgets/_layout_modal') ?>
<?php $this->load->view('widgets/_layout_footer') ?>
<?php $this->load->view('/components/page_tail'); ?>

