<form class="text-center" style="color: #757575;" method="post" action="" id="clid_blog" name="clid_blog" onsubmit="savedata()">    
  <div id="table" class="table-editable" style="overflow: scroll;height: 300px">                     
     <div>   
         
      <table class="table table-bordered table-responsive-md table-striped text-center" id="clid_blog_master">
        <thead>                        
          <tr>         
          <th class="text-center">#</th>      
           <th class="text-center">Type</th>
            <th class="text-center">Trunk DID</th>
            <th class="text-center">Block number</th>  
          </tr>
        </thead>
        <tbody>
          <?php
          $cntBlock = 1;
          if(!empty($blockNumberList)){   
            foreach ($blockNumberList as $key => $blockNumberDetail) {      
              ?>
              <tr class="clid_block_div">
                <td class="pt-3-half" style="vertical-align: inherit;">
                  <a href="#" class="remove-clidblock"><i class="fas fa-trash"></i></a>
                </td>       
                <td class="pt-3-half" style="vertical-align: inherit;">
                  <select name="call_type[<?php echo $cntBlock;?>]" id="call_type[<?php echo $cntBlock;?>]" class="browser-default custom-select call_type" style="width: 100%;height: 28px;    border-radius: 0px;padding: 1px;" required>
                    <option value="" disabled selected>Select Block Type</option>
                    <option value="incoming" <?php if($blockNumberDetail->type=="IN"){ echo 'selected';}?>>Incoming</option>
                    <option value="outgoing" <?php if($blockNumberDetail->type=="OUT"){ echo 'selected';}?>>Outgoing</option>
                  </select>
                </td>
                <td class="pt-3-half" style="vertical-align: inherit;">
                  <input type="text"  name="did[<?php echo $cntBlock;?>]" id="did[<?php echo $cntBlock;?>]" <?php if($blockNumberDetail->type=="OUT"){ echo 'readonly';}?> placeholder="Trunk did" value="<?php echo $blockNumberDetail->did;?>" class="did avoid_space" style="width: 100%;"  pattern="^\d{10,15}$" <?php if($blockNumberDetail->type=="OUT"){ echo 'required';}?>>
                </td>
                <td class="pt-3-half" style="vertical-align: inherit;">
                  <input type="text" name="number[<?php echo $cntBlock;?>]" id="number[<?php echo $cntBlock;?>]" value="<?php echo str_replace("|", ",", $blockNumberDetail->number);?>" class="avoid_space" placeholder="Clid block" style="width: 100%;" pattern="[0-9 _,]*" required>
                  <input type="hidden" name="old_block_number_id[<?php echo $cntBlock;?>]" class="old_value_hidden" value="<?php echo $blockNumberDetail->id;?>">
                  <input type="hidden" name="old_did[<?php echo $cntBlock;?>]" class="old_value_hidden_did" value="<?php echo $blockNumberDetail->did;?>">
                </td>
              </tr><?php
              $cntBlock++;
            }
          }
          ?>
          <tr class="clid_block_div">
            <td class="pt-3-half" style="vertical-align: inherit;"><a href="#" class="remove-clidblock"><i class="fas fa-trash"></i></a></td>       
            <td class="pt-3-half" style="vertical-align: inherit;"><select name="call_type[<?php echo $cntBlock;?>]" id="call_type[<?php echo $cntBlock;?>]" class="browser-default custom-select call_type clidblock_first" style="width: 100%;height: 28px;    border-radius: 0px;padding: 1px;" required><option value="" disabled selected>Select Block Type</option><option value="incoming">Incoming</option><option value="outgoing">Outgoing</option></select></td>
            <td class="pt-3-half" style="vertical-align: inherit;"><input type="text"  pattern="^\d{10,15}$" name="did[<?php echo $cntBlock;?>]" id="did[<?php echo $cntBlock;?>]" placeholder="Trunk DID" value="" class="did avoid_space" style="width: 100%;" required></td>
            <td class="pt-3-half" style="vertical-align: inherit;"><input type="text" pattern="[0-9 _,]*" name="number[<?php echo $cntBlock;?>]" class="avoid_space" id="number[<?php echo $cntBlock;?>]" placeholder="Clid block" style="width: 100%;" required>
            </td>
          </tr>
        </tbody>                                                
      </table>
    </div>
  </div>
  <div class="col-md-12" style="text-align: left;"><hr> 
  <input type="submit" class="waves-effect waves-dark btn btn-sm btn-primary" name="save_clid_block_detail" value="Save">
          </div>
</form>
