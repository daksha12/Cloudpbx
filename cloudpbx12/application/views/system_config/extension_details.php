<form class="text-center" style="color: #757575;" method="post" action="" id="extenstion_detail_form" name="extenstion_detail_form" onsubmit="savedata()" enctype="multipart/form-data">    

<div id="table" class="table-editable" style="overflow: scroll;height: 300px"><div>


<!-- <a href="" data-toggle="modal" data-target="#import_ext" class="waves-effect waves-dark btn btn-sm btn-primary" id="import_ext_data" style="float: left"><i class="fas fa-edit"></i> Import Extesion</a> -->

<table class="table table-bordered table-responsive-md table-striped text-center" id="extension_master">
  <!-- Table head -->
  <thead>
    <tr>      
    <th class="text-center">#</th>     
    <th class="text-center">Extension</th>       
    <th class="text-center">Extension type</th>    
    <th class="text-center">Display id</th>
    <th class="text-center">Voice mail</th>
    <th class="text-center">Email</th>
    <th class="text-center">Time zone</th>
    <th class="text-center">Trunk name</th>
    <th class="text-center">Outbound did</th>
    <th class="text-center">ISD</th>
    <th class="text-center">Park retrieve</th>
    <th class="text-center">Recording</th>
    <th class="text-center">Monitoring</th>
    <th class="text-center">Presence BLF</th>
    <th class="text-center">Mobility</th>
    <th class="text-center">Synergy</th>
    <th class="text-center">Portal access</th>
    <th class="text-center">Mobile number</th>
    <th class="text-center">Audio file</th> 
    <th class="text-center">Audio avoid</th>
    </tr>
  </thead>
  <!-- Table head -->
  <!-- Table body -->
   <tbody>
  <?php
    $cntExt = 1;
    if(!empty($extensionList)){   
      foreach ($extensionList as $key => $extension_detail) {   
        ?><tr class="extension_div" >  
          <td>
            <a href="#" class="remove-extension"><i class="fas fa-trash"></i></a>
          </td>
          <td class="pt-3-half" style="vertical-align: inherit;">
            <input type="text" placeholder="Extension" name="extension[<?php echo $cntExt;?>]" id="extension[<?php echo $cntExt;?>]" pattern="[0-9 _,]*" value="<?php echo $extension_detail->extension;?>" class="avoid_space" required>
          </td>        
          <td class="pt-3-half" style="vertical-align: inherit;">
            <select name="extension_type[<?php echo $cntExt;?>]" id="extension_type[<?php echo $cntExt;?>]" class="browser-default custom-select " style="width: 150px;height: 28px; border-radius: 0px;padding: 1px;" required>
              <option value="">Extension type</option>
              <option value="Super" <?php if($extension_detail->extension_type=='Super'){ echo 'selected';}?>>Super</option>
              <option value="User" <?php if($extension_detail->extension_type=='User'){ echo 'selected';}?>>User</option>
            </select>
          </td>          
          <td class="pt-3-half" style="vertical-align: inherit;">
            <input type="text" placeholder="Display name" name="display_name[<?php echo $cntExt;?>]" id="display_name[<?php echo $cntExt;?>]" value="<?php echo $extension_detail->display_name;?>" class="">
          </td>
          <td class="pt-3-half" style="vertical-align: inherit;">
            <select name="voicemail_enabled[<?php echo $cntExt;?>]" id="voicemail_enabled[<?php echo $cntExt;?>]" class="browser-default custom-select" style="width: 100px;height: 28px;border-radius: 0px;padding: 1px;">
              <option value="Y" <?php if($extension_detail->voicemail_enabled=='Y'){ echo 'selected';}?>>Yes</option>
              <option value="N" <?php if($extension_detail->voicemail_enabled=='N'){ echo 'selected';}?>>No</option>
            </select> 
          </td>
          <td class="pt-3-half" style="vertical-align: inherit;">
            <input type="email" placeholder="Vm to email"  name="vm_email[<?php echo $cntExt;?>]" id="vm_email[<?php echo $cntExt;?>]" value="<?php echo $extension_detail->vm_email;?>" class="avoid_space">
          </td>
          <td class="pt-3-half" style="vertical-align: inherit;">
            <select name="vm_timezone[<?php echo $cntExt;?>]" id="vm_timezone[<?php echo $cntExt;?>]" class="browser-default custom-select " style="width: auto;height: 28px; border-radius: 0px;padding: 1px;">
                <option value="" disabled selected>Select time zone</option>
                <?php 
                if(!empty($timeZonesList)){
                  foreach ($timeZonesList as $key => $timeZone) {
                     ?><option value="<?php echo $timeZone->time;?>" <?php if($extension_detail->vm_timezone== $timeZone->time){ echo 'selected';}?>><?php echo $timeZone->name;?></option><?php
                  }
                }
                ?>
            </select>
          </td>
          <td class="pt-3-half" style="vertical-align: inherit;">
            <select name="trunk_name[<?php echo $cntExt;?>]" id="extension_trunk_name_1" class="browser-default custom-select trunk_select" style="width: 200px;height: 28px; border-radius: 0px;padding: 1px;">
              <option value="" disabled selected>Select trunk name</option>
              <?php 
                if(!empty($trunkList)){
                  foreach ($trunkList as $key => $trunk_detail) {
                     ?><option value="<?php echo $trunk_detail->id;?>" <?php if($extension_detail->trunk_id==$trunk_detail->id){ echo 'selected';}?> ><?php echo $trunk_detail->trunk_name;?></option><?php
                  }
                }
              ?>
            </select>
          </td>   
          <td class="pt-3-half" style="vertical-align: inherit;">
            <input type="text" placeholder="Outbound did" name="outbound_did[<?php echo $cntExt;?>]" id="outbound_did[<?php echo $cntExt;?>]" pattern="^\d{10,15}$" value="<?php echo $extension_detail->outbound_did;?>" class="avoid_space">
          </td>
          <td class="pt-3-half" style="vertical-align: inherit;">
            <select name="isd_allowed[<?php echo $cntExt;?>]" id="isd_allowed[<?php echo $cntExt;?>]" class="browser-default custom-select" style="width: 100px;height: 28px;border-radius: 0px;padding: 1px;">
              <option value="Y" <?php if($extension_detail->isd_allowed=='Y'){ echo 'selected';}?>>Yes</option>
              <option value="N" <?php if($extension_detail->isd_allowed=='N'){ echo 'selected';}?>>No</option>
            </select>
          </td>
          <td class="pt-3-half" style="vertical-align: inherit;">
            <select name="park_retreive[<?php echo $cntExt;?>]" id="park_retreive[<?php echo $cntExt;?>]" class="browser-default custom-select" style="width: 100px;height: 28px;border-radius: 0px;padding: 1px;">
              <option value="Y" <?php if($extension_detail->park_retrive=='Y'){ echo 'selected';}?>>Yes</option>
              <option value="N" <?php if($extension_detail->park_retrive=='N'){ echo 'selected';}?>>No</option>            </select>
          </td>
          <td class="pt-3-half" style="vertical-align: inherit;">
            <select name="call_recording[<?php echo $cntExt;?>]" id="call_recording[<?php echo $cntExt;?>]" class="browser-default custom-select" style="width: 100px;height: 28px;border-radius: 0px;padding: 1px;">
              <option value="Y" <?php if($extension_detail->call_recording=='Y'){ echo 'selected';}?>>Yes</option>
              <option value="N" <?php if($extension_detail->call_recording=='N'){ echo 'selected';}?>>No</option>
            </select> 
          </td>
          <td class="pt-3-half" style="vertical-align: inherit;">
            <select name="call_monitoring[<?php echo $cntExt;?>]" id="call_monitoring[<?php echo $cntExt;?>]" class="browser-default custom-select" style="width: 100px;height: 28px;border-radius: 0px;padding: 1px;">
              <option value="Y" <?php if($extension_detail->call_monitoring=='Y'){ echo 'selected';}?>>Yes</option>
              <option value="N" <?php if($extension_detail->call_monitoring=='N'){ echo 'selected';}?>>No</option>
            </select>
          </td>
          <td class="pt-3-half" style="vertical-align: inherit;">
            <select name="presence_blf[<?php echo $cntExt;?>]" id="presence_blf[<?php echo $cntExt;?>]" class="browser-default custom-select" style="width: 105px;height: 28px;border-radius: 0px;padding: 1px;">
              <option value="Y" <?php if($extension_detail->presence_blf=='Y'){ echo 'selected';}?>>Yes</option>
              <option value="N" <?php if($extension_detail->presence_blf=='N'){ echo 'selected';}?>>No</option>
            </select>
          </td>
          <td class="pt-3-half" style="vertical-align: inherit;">
            <select name="mobility[<?php echo $cntExt;?>]" id="mobility[<?php echo $cntExt;?>]" class="browser-default custom-select" style="width: 100px;height: 28px;border-radius: 0px;padding: 1px;">
              <option value="Y" <?php if($extension_detail->mobility=='Y'){ echo 'selected';}?>>Yes</option>
              <option value="N" <?php if($extension_detail->mobility=='N'){ echo 'selected';}?>>No</option>
            </select>
          </td>
          <td class="pt-3-half" style="vertical-align: inherit;">
            <select name="synergy[<?php echo $cntExt;?>]" id="synergy[<?php echo $cntExt;?>]" class="browser-default custom-select" style="width: 100px;height: 28px;border-radius: 0px;padding: 1px;">
              <option value="Y" <?php if($extension_detail->synergy=='Y'){ echo 'selected';}?>>Yes</option>
              <option value="N" <?php if($extension_detail->synergy=='N'){ echo 'selected';}?>>No</option>
            </select>
          </td>
          <td class="pt-3-half" style="vertical-align: inherit;">
            <select name="portal_access[<?php echo $cntExt;?>]" id="portal_access[<?php echo $cntExt;?>]" class="browser-default custom-select" style="width: 100px;height: 28px;border-radius: 0px;padding: 1px;">
              <option value="Y" <?php if($extension_detail->synergy=='Y'){ echo 'selected';}?>>Yes</option>
              <option value="N" <?php if($extension_detail->synergy=='N'){ echo 'selected';}?>>No</option>
            </select>
          </td>
          <td class="pt-3-half" style="vertical-align: inherit;">
            <input type="text" placeholder="Mobile number" name="mobile_number[<?php echo $cntExt;?>]" id="mobile_number[<?php echo $cntExt;?>]" value="<?php echo $extension_detail->mobile_number;?>" pattern="^\d{10}$" class="avoid_space">
            <input type="hidden" name="old_extension_id[<?php echo $cntExt;?>]" class="old_value_hidden" value="<?php echo $extension_detail->id;?>">
          </td>


        <input type="hidden" name="audio_file_old[<?php echo $cntExt;?>]" value="<?php echo $extension_detail->audio_file;?>">
   
        <td class="pt-3-half" style="vertical-align: inherit;">        
        <input type="file" name="audio_file[<?php echo $cntExt;?>]" placeholder="Audio File" value="<?php echo $extension_detail->audio_file;?>" id="audio_file[<?php echo $cntExt;?>]" class="" style="width: 200px;height: 28px;border-radius: 0px;padding: 1px;font-size: 12px">
        
        <?php if($extension_detail->audio_file != '') { ?>
        <hr style="margin-top: 1px;margin-bottom: 1px;">
            <audio controls preload="none" controlsList="download" style="height: 40px"><source src='<?php echo ivr_path.$extension_detail->audio_file.'.wav' ?>' type="audio/mpeg"></audio>
          <?php } ?>
      </td>
   
  <!-- 
        <input type="hidden" name="audio_file_old[<?php echo $cntExt;?>]" value="<?php echo $extension_detail->audio_file;?>">

        <td class="pt-3-half" style="vertical-align: inherit;">      
          <input type="file" placeholder="audio avoid" name="audio_file[<?php echo $cntExt;?>]" id="audio_file[<?php echo $cntExt;?>]" class="avoid_space">

          <?php if($extension_detail->audio_file != '') { ?>
          <hr style="margin-top: 1px;margin-bottom: 1px;">
              <audio controls preload="none" controlsList="download" style="height: 40px"><source src='<?php echo ivr_path.$extension_detail->audio_file.'.wav' ?>' type="audio/mpeg"></audio>
            <?php } ?>
        </td> 
    -->
      <td class="pt-3-half" style="vertical-align: inherit;">
        <select name="audio_avoid[<?php echo $cntExt;?>]" id="audio_avoid[<?php echo $cntExt;?>]" class="browser-default custom-select" style="width: 100px;height: 28px;border-radius: 0px;padding: 1px;">      <option value="N" <?php if($extension_detail->audio_avoid=='N'){ echo 'selected';}?>>No</option>
        <option value="Y" <?php if($extension_detail->audio_avoid=='Y'){ echo 'selected';}?>>Yes</option>
        </select>
      </td>


        </tr><?php
        $cntExt++;
      }
    }
    ?><tr class="extension_div" >  
      <td>
        <a href="#" class="remove-extension"><i class="fas fa-trash"></i></a>
      </td> 
      <td class="pt-3-half" style="vertical-align: inherit;">
        <input type="text" placeholder="Extension" name="extension[<?php echo $cntExt;?>]" id="extension[<?php echo $cntExt;?>]" value="" class="extension_first avoid_space" pattern="[0-9 _,]*" required>
      </td> 
      <td class="pt-3-half" style="vertical-align: inherit;">
        <select name="extension_type[<?php echo $cntExt;?>]" id="extension_type[<?php echo $cntExt;?>]" class="browser-default custom-select " style="width: 150px;height: 28px; border-radius: 0px;padding: 1px;" required>
          <option value="">Extension type</option>
          <option value="Super">Super</option>
          <option value="User">User</option>
        </select>
      </td>      
      <td class="pt-3-half" style="vertical-align: inherit;">
        <input type="text" placeholder="Display name" name="display_name[<?php echo $cntExt;?>]" id="display_name[<?php echo $cntExt;?>]" value="" class="" >
      </td>
      <td class="pt-3-half" style="vertical-align: inherit;">
        <select name="voicemail_enabled[<?php echo $cntExt;?>]" id="voicemail_enabled[<?php echo $cntExt;?>]" class="browser-default custom-select" style="width: 100px;height: 28px;border-radius: 0px;padding: 1px;">
          <option value="Y">Yes</option>
          <option value="N">No</option>
        </select> 
      </td>
      <td class="pt-3-half" style="vertical-align: inherit;">
        <input type="email" placeholder="Vm to email"  name="vm_email[<?php echo $cntExt;?>]" id="vm_email[<?php echo $cntExt;?>]" value="" class="avoid_space">
      </td>
      <td class="pt-3-half" style="vertical-align: inherit;">
        <select name="vm_timezone[<?php echo $cntExt;?>]" id="vm_timezone[<?php echo $cntExt;?>]" class="browser-default custom-select " style="width: auto;height: 28px; border-radius: 0px;padding: 1px;" >
            <option value="" disabled selected>Select time zone</option>
            <?php 
            if(!empty($timeZonesList)){
              foreach ($timeZonesList as $key => $timeZone) {
                 ?><option value="<?php echo $timeZone->time;?>"><?php echo $timeZone->name;?></option><?php
              }
            }
            ?>
        </select>
      </td>
      <td class="pt-3-half" style="vertical-align: inherit;">
        <select name="trunk_name[<?php echo $cntExt;?>]" id="extension_trunk_name_1" class="browser-default custom-select trunk_select" style="width: 200px;height: 28px; border-radius: 0px;padding: 1px;">
          <option value="" disabled selected>Select trunk name</option>
          <?php 
            if(!empty($trunkList)){
              foreach ($trunkList as $key => $trunk_detail) {
                 ?><option value="<?php echo $trunk_detail->id;?>"><?php echo $trunk_detail->trunk_name;?></option><?php
              }
            }
          ?>
        </select>
      </td>
      <td class="pt-3-half" style="vertical-align: inherit;">
        <input type="text" placeholder="Outbound did" name="outbound_did[<?php echo $cntExt;?>]" id="outbound_did[<?php echo $cntExt;?>]" value="" pattern="^\d{10,15}$" class="avoid_space">
      </td>
      <td class="pt-3-half" style="vertical-align: inherit;">
        <select name="isd_allowed[<?php echo $cntExt;?>]" id="isd_allowed[<?php echo $cntExt;?>]" class="browser-default custom-select" style="width: 100px;height: 28px;border-radius: 0px;padding: 1px;">
          <option value="N">No</option>
          <option value="Y">Yes</option>
        </select>
      </td>
      <td class="pt-3-half" style="vertical-align: inherit;">
        <select name="park_retreive[<?php echo $cntExt;?>]" id="park_retreive[<?php echo $cntExt;?>]" class="browser-default custom-select" style="width: 100px;height: 28px;border-radius: 0px;padding: 1px;">
          <option value="Y">Yes</option>
          <option value="N">No</option>
        </select>
      </td>
      <td class="pt-3-half" style="vertical-align: inherit;">
        <select name="call_recording[<?php echo $cntExt;?>]" id="call_recording[<?php echo $cntExt;?>]" class="browser-default custom-select" style="width: 100px;height: 28px;border-radius: 0px;padding: 1px;">
          <option value="Y">Yes</option>
          <option value="N">No</option>
        </select> 
      </td>
      <td class="pt-3-half" style="vertical-align: inherit;">
        <select name="call_monitoring[<?php echo $cntExt;?>]" id="call_monitoring[<?php echo $cntExt;?>]" class="browser-default custom-select" style="width: 100px;height: 28px;border-radius: 0px;padding: 1px;">
          <option value="Y">Yes</option>
          <option value="N">No</option>
        </select>
      </td>
      <td class="pt-3-half" style="vertical-align: inherit;">
        <select name="presence_blf[<?php echo $cntExt;?>]" id="presence_blf[<?php echo $cntExt;?>]" class="browser-default custom-select" style="width: 105px;height: 28px;border-radius: 0px;padding: 1px;">
          <option value="Y">Yes</option>
          <option value="N">No</option>
        </select>
      </td>
      <td class="pt-3-half" style="vertical-align: inherit;">
        <select name="mobility[<?php echo $cntExt;?>]" id="mobility[<?php echo $cntExt;?>]" class="browser-default custom-select" style="width: 100px;height: 28px;border-radius: 0px;padding: 1px;">
          <option value="Y">Yes</option>
          <option value="N">No</option>
        </select>
      </td>
      <td class="pt-3-half" style="vertical-align: inherit;">
        <select name="synergy[<?php echo $cntExt;?>]" id="synergy[<?php echo $cntExt;?>]" class="browser-default custom-select" style="width: 100px;height: 28px;border-radius: 0px;padding: 1px;">
          <option value="Y">Yes</option>
          <option value="N">No</option>
        </select>
      </td>
      <td class="pt-3-half" style="vertical-align: inherit;">
        <select name="portal_access[<?php echo $cntExt;?>]" id="portal_access[<?php echo $cntExt;?>]" class="browser-default custom-select" style="width: 100px;height: 28px;border-radius: 0px;padding: 1px;">
          <option value="Y">Yes</option>
          <option value="N">No</option>
        </select>
      </td>
      <td class="pt-3-half" style="vertical-align: inherit;">
        <input type="text" placeholder="Mobile number" name="mobile_number[<?php echo $cntExt;?>]" id="mobile_number[<?php echo $cntExt;?>]" pattern="^\d{10}$" value="" class="avoid_space" >
      </td>


     <td class="pt-3-half" style="vertical-align: inherit;">
        <input type="file" name="audio_file[<?php echo $cntExt;?>]" id="audio_file[<?php echo $cntExt;?>]"  class="" style="width: 200px;height: 28px;border-radius: 0px;padding: 1px;font-size: 12px">
      </td>
    
     
   <!--   <td class="pt-3-half" style="vertical-align: inherit;">
         <input type="file" placeholder="audio avoid" name="audio_file[<?php echo $cntExt;?>]" id="audio_file[<?php echo $cntExt;?>]" class="avoid_space" value="<?php echo $extension_detail->audio_file;?>">
      </td>  -->

      <td class="pt-3-half" style="vertical-align: inherit;">
        <select name="audio_avoid[<?php echo $cntExt;?>]" id="audio_avoid[<?php echo $cntExt;?>]" class="browser-default custom-select" style="width: 100px;height: 28px;border-radius: 0px;padding: 1px;">
          <option value="N">No</option>
          <option value="Y">Yes</option>
        </select>
      </td>


    </tr>
  </tbody>
  <!-- Table body -->
</table>
<!-- Table  -->

</div>
</div>
<div class="col-md-12" style="text-align: left;"><hr> 
<input type="submit" class="waves-effect waves-dark btn btn-sm btn-primary" name="save_extension_detail" value="Save">
</div>
</form>


<div class="modal fade" id="import_ext" tabindex="-1" role="dialog" aria-labelledby="account"
  aria-hidden="true" data-backdrop="static" data-keyboard="false">

  <!-- Change class .modal-sm to change the size of the modal -->
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <!-- FORM START      -->
        <form enctype="multipart/form-data" style="color: #757575;" method="post" name="Account_detail" action="<?php echo site_url('System_configuration/import_ext') ?>">
          <div class="row">          

            <div class="col-md-12">
              <h5><i class="fas fa-tasks"></i> Import Extension</h5><hr style="margin-top: 5px;margin-bottom: 0;">
            </div>

            <div class="col-md-12"><br>
              <center><a href="<?php echo site_url('assets/temp/extension.csv') ?>" target="_blank">Download Tempalete</a></center>
              <hr>
            </div>

            <div class="col-md-12">
              <div class="md-form md-outline">
                <input type="file" name="extension" id="extension" class="form-control" required>              
              </div>
            </div>        

            <div class="col-md-12"><hr>                        
              <input type="submit" class="waves-effect waves-dark btn btn-sm btn-primary" name="import_ext_data" value="Save">
              <button type="button" class="waves-effect waves-dark btn btn-sm btn-primary" data-dismiss="modal">Close</button>
            </div>
          </div> 
        </form>
        <!-- FORM End -->
      </div>
    </div>
  </div>
</div>