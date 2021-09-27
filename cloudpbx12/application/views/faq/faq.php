<div class="row">
      <div class="col-md-12">
            <form method="post" action="<?php site_url('Faq/faq')?>">
                  <div class="row">

                        <div class="col-md-10">
                              <div class="md-form md-outline">
                                    <input type="text" name="faq_title" id="faq_title" value="<?php echo $faq_detail->faq_title ?>" class="form-control faq_title" required>
                                    <label for="faq_title">Title</label>
                              </div>
                        </div>

                        <div class="col-md-2">
                              <div class="md-form md-outline">
                                    <input type="text" name="faq_category" id="faq_category" value="<?php echo $faq_detail->faq_category ?>" class="form-control faq_category" required>
                                    <label for="faq_category">Category</label>
                              </div>
                        </div>

                        <div class="col-md-12">
                              <div class="md-form md-outline">
                                    <textarea name="faq_desc" id="faq_desc" class="form-control faq_desc" id="faq_desc" required data-sample-short><?php echo $faq_detail->faq_desc ?></textarea>
                                    <label for="faq_desc"></label>
                              </div>
                        </div>

                        <div class="offset-md-1 col-md-12" style="margin: 0px !important;">
                              <hr>
                              <input type="submit" value="Save" class="btn btn-sm btn-outline-primary waves-effect" name="Save"> 
                        </div>  
                  </div>
            </form>
      </div>
</div>


<script src='<?= base_url() ?>assets/plugins/ckeditor_standard/ckeditor.js'></script>
<script src='<?= base_url() ?>assets/js/jquery.min.js'></script> 

<script type="text/javascript">

CKEDITOR.replace('faq_desc', {
      // Configure your file manager integration. This example uses CKFinder 3 for PHP.
      filebrowserBrowseUrl: '<?= base_url() ?>assets/plugins/ckfinder/ckfinder.html',
      filebrowserImageBrowseUrl: '<?= base_url() ?>assets/plugins/ckfinder/ckfinder.html?type=Images',
      filebrowserUploadUrl: '<?= base_url() ?>assets/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
      filebrowserImageUploadUrl: '<?= base_url() ?>assets/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'
});

$(document).ready(function () {
      $("form").submit(function(event){
            var faq_desc = CKEDITOR.instances.faq_desc.getData();
            if($("#faq_title").val() == ''){
                  alert("Title is required field");
                  return false;
            }
            else if($("#faq_category").val() == ''){
                  alert("Category required field");
                  return false;
            }
            else if(faq_desc == ''){

                  alert("Description required field");
                  return false;
            }
            return true;
      });
});
</script>