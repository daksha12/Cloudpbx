<form class="text-center" style="color: #757575;" method="post" action="" id="trunk_did_detail" name="trunk_did_detail" onsubmit="savedata()">    
  <div id="table" class="table-editable" style="overflow: scroll;height: 300px">                     
    <div> 

      <table class="table table-bordered table-responsive-md table-striped text-center" id="trunk_did_detail_master">
        <thead>                        
          <tr>             
            <th class="text-center">#</th>
            <th class="text-center">Trunk name</th>
            <th class="text-center">Trunk DID</th>
            <th class="text-center">Extension</th>
            <th class="text-center">DID Type</th>
            <th class="text-center">Call Type</th>    
          </tr>
        </thead>
        <tbody>
        <?php
        $cntTrunkDid = 1;
        if(!empty($trunkDidList)){   
          foreach ($trunkDidList as $key => $trunk_did_detail) {      
            
            $str = ['|','-'];
            $rplc =[',',','];
            ?> 
            <tr class="trunk_did_div">
                <td><a href="#" class="remove-trunkdid" ><i class="fas fa-trash"></i></a></td>

                <td class="pt-3-half" style="vertical-align: inherit;"><select name="trunk_name[<?php echo $cntTrunkDid;?>]" id="trunkdid_trunk_name_1" class="browser-default custom-select trunkdid_trunk_select" style="width: 100%;height: 28px;    border-radius: 0px;padding: 1px;" required><option value=""  selected>Select Trunk Name</option>
                <?php 
                if(!empty($trunkList)){
                  foreach ($trunkList as $key => $trunk_detail) {
                     ?><option value="<?php echo $trunk_detail->id;?>" <?php if($trunk_did_detail->trunk_id==$trunk_detail->id){ echo 'selected';}?>><?php echo $trunk_detail->trunk_name;?></option><?php
                  }
                }
                ?>
                </select></td>

                <td class="pt-3-half" style="vertical-align: inherit;"><input type="text" name="trunk_did[<?php echo $cntTrunkDid;?>]" id="trunk_did[<?php echo $cntTrunkDid;?>]" placeholder="Trunk did" value="<?php echo $trunk_did_detail->did_number;?>" class="avoid_space" style="width: 100%;" required></td>
                
                <!--td class="pt-3-half" style="vertical-align: inherit;"><input type="text" name="extension[<?php echo $cntTrunkDid;?>]" id="extension[<?php echo $cntTrunkDid;?>]" value="<?php echo str_replace($str,$rplc, $trunk_did_detail->extension);?>" placeholder="Extension" pattern="[0-9 _,]*" style="width: 100%;"></td-->
  
                <?php 
                $ext = str_replace($str,$rplc, $trunk_did_detail->extension); 
                $ext_arr = explode(',', $ext);                      
                ?>

                <td class="pt-3-half" style="vertical-align: inherit;">
                <select class="colorful-select dropdown-primary trunkdid_trunk_select" name="extension_<?php echo $cntTrunkDid;?>[]" multiple style="width: 100%;" required>
                <option value="" selected="">Select Extension</option>
                <?php foreach ($branch_ext as $value) { ?>             
                <option value="<?php echo $value->extension ?>" <?php if(in_array($value->extension, $ext_arr) == '1'){echo "selected"; } ?> ><?php echo $value->extension ?></option>
                <?php } ?>
                </select>
                </td>

                <td class="pt-3-half" style="vertical-align: inherit;">
                <select name="did_type[<?php echo $cntTrunkDid;?>]" id="did_type[<?php echo $cntTrunkDid;?>]" required style="width: 100%;">
                <option value="" selected>Select Type</option>
                <option value="extensions" <?php if($trunk_did_detail->did_type == 'extensions'){echo "selected";} ?>>extensions</option>
                <option value="conference"  <?php if($trunk_did_detail->did_type == 'conference'){echo "selected";} ?>>conference</option>
                </select>

                <input type="hidden" name="old_trunkdid_id[<?php echo $cntTrunkDid;?>]" class="old_value_hidden" value="<?php echo $trunk_did_detail->id;?>">
                </td>

                <td class="pt-3-half" style="vertical-align: inherit;">
                  <select name="call_type[<?php echo $cntTrunkDid;?>]" class="browser-default custom-select trunkdid_trunk_select" style="width: 100%;height: 28px;border-radius: 0px;padding: 1px;" id="call_type[<?php echo $cntTrunkDid;?>]" required>
                  <option value="" selected>Select Type</option>
                  <option value="sequential" <?php if($trunk_did_detail->call_type == 'sequential'){echo "selected";} ?>>Sequential</option>
                  <option value="simultaneous"  <?php if($trunk_did_detail->call_type == 'simultaneous'){echo "selected";} ?>>Simultaneous</option>
                  </select>
                </td>
            </tr><?php
            $cntTrunkDid++;
          }
        }
        ?>
        <tr class="trunk_did_div">
            <td><a href="#" class="remove-trunkdid" ><i class="fas fa-trash"></i></a></td>

            <td class="pt-3-half" style="vertical-align: inherit;"><select name="trunk_name[<?php echo $cntTrunkDid;?>]" id="trunkdid_trunk_name_1" class="browser-default custom-select trunkdid_trunk_select trunkdid_first" style="width: 100%;height: 28px;    border-radius: 0px;padding: 1px;" required><option value=""  selected>Select trunk name</option>
            <?php 
            if(!empty($trunkList)){
              foreach ($trunkList as $key => $trunk_detail) {
                 ?><option value="<?php echo $trunk_detail->id;?>"><?php echo $trunk_detail->trunk_name;?></option><?php
              }
            }
            ?>
            </select></td>

            <td class="pt-3-half" style="vertical-align: inherit;"><input type="text" name="trunk_did[<?php echo $cntTrunkDid;?>]" id="trunk_did[<?php echo $cntTrunkDid;?>]" placeholder="Trunk did" pattern="^\d{10,15}$" value="" class="avoid_space" style="width: 100%;" required></td>

            <!--td class="pt-3-half" style="vertical-align: inherit;"><input type="text" name="extension[<?php echo $cntTrunkDid;?>]" id="extension[<?php echo $cntTrunkDid;?>]" placeholder="Extension" pattern="[0-9 _,]*" style="width: 100%;"></td-->


            <td class="pt-3-half" style="vertical-align: inherit;">
            <select class="colorful-select dropdown-primary trunkdid_trunk_select" name="extension_<?php echo $cntTrunkDid;?>[]" multiple style="width: 100%;" required>
            <option value="">Select Extension</option>
            <?php foreach ($branch_ext as $value) {?>             
            <option value="<?php echo $value->extension ?>"><?php echo $value->extension ?></option>
            <?php } ?>
            </select>
            </td>

            <td class="pt-3-half" style="vertical-align: inherit;">
            <select name="did_type[<?php echo $cntTrunkDid;?>]" id="did_type[<?php echo $cntTrunkDid;?>]" required style="width: 100%;">
            <option value="">Select Type</option>
            <option value="extensions">extensions</option>
            <option value="conference">conference</option>
            </select>
            </td>

             <td class="pt-3-half" style="vertical-align: inherit;">
                  <select name="call_type[<?php echo $cntTrunkDid;?>]" id="call_type[<?php echo $cntTrunkDid;?>]" class="browser-default custom-select trunkdid_trunk_select" style="width: 100%;height: 28px;border-radius: 0px;padding: 1px;" required>
                  <option value="">Select Type</option>
                  <option value="sequential">Sequential</option>
                  <option value="simultaneous">Simultaneous</option>
                  </select>
              </td>
          </tr>
        </tbody>                                                
      </table>
    </div>
  </div>          
  <div class="col-md-12" style="text-align: left;"><hr> 
    <input type="submit" class="waves-effect waves-dark btn btn-sm btn-primary" name="save_trunkdid_detail" value="Save">
  </div>   
</form>