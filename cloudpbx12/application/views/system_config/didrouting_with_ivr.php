<div id="table" class="table-editable" style="overflow: scroll;height: 300px">                     
    <div> 
      <a href="" data-toggle="modal" data-target="#add_ivr_config" class="waves-effect waves-dark btn btn-sm btn-primary" id="show_ivr_config_model" style="display:none"><i class="fas fa-plus"> Add</i></a> 
      <a onclick="show_ivr_config();" class="waves-effect waves-dark btn btn-xs btn-primary"><i class="fas fa-plus"> Add New</i></a>
      <table class="table table-bordered table-responsive-md table-striped text-center" id="">
        <thead>                        
          <tr>             
            <th class="text-center">#</th>
            <th class="text-center">Trunk name</th>
            <th class="text-center">Trunk DID</th>
            <th class="text-center">Office start time</th>
            <th class="text-center">Office end time</th>    
            <th class="text-center">Office days</th>    
          </tr>
        </thead>
        <tbody>
        <?php
        $cntTrunkDid = 0;
        if(!empty($didRoutingIVRGroup)){
          foreach ($didRoutingIVRGroup as $key => $arrDidRoutingIVR) {   
            $cntTrunkDid++;   
            ?> 
            <tr class="">                
                <td>                 
                	<a href="#" onclick="show_ivr_config('<?php echo $arrDidRoutingIVR->code;?>');" class=""><i class="fas fa-edit"></i></a>
                </td>
                <td class="pt-3-half" style="vertical-align: inherit;"><?php echo $arrDidRoutingIVR->trunk_name;?></td>
                <td class="pt-3-half" style="vertical-align: inherit;"><?php echo $arrDidRoutingIVR->did;?></td>
                <td class="pt-3-half" style="vertical-align: inherit;"><?php echo $arrDidRoutingIVR->off_start;?></td>
                <td class="pt-3-half" style="vertical-align: inherit;"><?php echo $arrDidRoutingIVR->off_end;?></td>
                <td class="pt-3-half" style="vertical-align: inherit;"><?php echo $arrDidRoutingIVR->off_days;?></td>                
            </tr><?php            
          }
        }
        ?>
        </tbody>                                                
      </table>
    </div>
</div>

