<div class="card" style="overflow: scroll;height: 400px">
<div class="body">
  <div class="accordion" id="accordionEx78" role="tablist" aria-multiselectable="false">
    <?php if(count($faq)): foreach($faq as $key => $value): ?>  
    <!-- Accordion card -->
    <div class="card">
      <!-- Card header -->
      <div class="card-header" role="tab" id="headingUnfiled">
        <!-- Heading -->
        <?php 
        if($value->faq_id == 1):?>
          <a data-toggle="collapse" href="#collapseOne_<?php echo  $value->faq_id; ?>" aria-expanded="true" aria-controls="collapseOne_<?php echo  $value->faq_id; ?>" >
              <h5 class="mt-1 mb-0">
                  <span><?php echo $value->faq_title; ?></span>
              </h5>
          </a>
        <?php 
        else:
        ?>
          <a class="collapsed" data-toggle="collapse"  href="#collapseOne_<?php echo  $value->faq_id; ?>" aria-expanded="true" aria-controls="collapseOne_<?php echo  $value->faq_id; ?>" >
            <h5 class="mt-1 mb-0">
                <span><?php echo $value->faq_title; ?></span>
            </h5>
         </a>
        <?php endif; ?>
      </div>
      <?php 
      if($value->faq_id == 1):?>
        <div id="collapseOne_<?php echo $value->faq_id; ?>" class="collapse show" role="tabpanel" aria-labelledby="headingUnfiled" data-parent="#accordionEx78">
      <?php 
      else: 
      ?>
        <div id="collapseOne_<?php echo $value->faq_id; ?>" class="collapse" role="tabpanel" aria-labelledby="headingUnfiled" data-parent="#accordionEx78">
      <?php 
      endif; 
      ?>
          <div class="card-body">
            <div class="row clearfix">
              <div class="col-lg-12 col-md-9 col-sm-9 col-xs-12">
                <div class="card">
                  <div class="body">                
                    <?php echo $value->faq_desc; ?>
                  </div>
                </div>
              </div>
            </div> <!-- END  CARD -->
          </div>
        </div>
      </div>   
    
    <!-- END THE PANEL -->
    <?php endforeach; ?>
    <?php else: ?>
      <br>
      <div class="alert alert-dismissible alert-danger">
        <!--button type="button" class="close" data-dismiss="alert">×</button-->
        <h4>No FAQ Available</h4>
      </div>
    <?php endif; ?>    
  </div>
</div>