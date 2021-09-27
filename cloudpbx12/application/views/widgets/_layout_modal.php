<!----- LOGO UPLOAD MODAL -------->
<div class="modal fade" id="UploadLogo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
<!-- Change class .modal-sm to change the size of the modal -->
<div class="modal-dialog modal-fade" role="document">

<div class="modal-content">
<div class="modal-header">
<h3  class="modal-title w-100 modal-header-top" id="myModalLabel"><center>Upload Logo</center></h3>
</div>
<div class="modal-body">

<div class="col-md-12" style="margin-top: -20px;"> 
<form class="md-form" id="uploadlogo" form="uploadlogo" action="<?php echo site_url('Admin/dashboard/upload_logo'); ?>" enctype="multipart/form-data" method="post">
<div class="file-field">
<div class="input-group">
<div class="custom-file">
<input type="file" class="custom-file-input" name="userfile" id="file" aria-describedby="inputGroupFileAddon01" required  onchange="fileValidation()">
<label class="custom-file-label" for="file">Choose file</label>
</div>
</div>
</div><br>  
<span class="help-block"><code style="font-size: 16px">It is recommended that logo should be transparent supported image types</code></span>
<span class="help-block"><code style="font-size: 16px">Supported Image type: JPEG | JPG | PNG | TIF </code></span>
<span class="help-block"><br>Maximum Dimensions : <code>1024 x 768</code></span><br> 
</div>
</div>
<div class="modal-footer">      
<button type="submit" class="btn btn-primary btn-sm" name="upload">Upload</button>
<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times"></i></button>
</div>
</form>
</div>
</div>
</div>
<!-- Central Modal Small -->
<!--------------------------------->


<!----- CHNAGE PASS MODAL -------->
<div class="modal fade" id="ChangePass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"  data-backdrop="static" data-keyboard="false">
<!-- Change class .modal-sm to change the size of the modal -->
<div class="modal-dialog modal-fade" role="document">

<div class="modal-content">
<div class="modal-header">
<h3 class="modal-title w-100 modal-header-top" id="myModalLabel"><center>Change Password</center></h3>
</div>
<div class="modal-body">

<div class="col-md-12" style="margin-top: -20px;"> 
<?php if($_SESSION['user_type'] == 'Admin'){?>
<form class="md-form" action="<?php echo site_url('Admin/dashboard/reset_password'); ?>" enctype="multipart/form-data" method="post">  
<input type="hidden" name="id" value="<?php echo $_SESSION['user_id'] ?>">
<input type="hidden" name="pass_old" id="pass_old" value="<?php echo $_SESSION['password']; ?>">
<?php }else{?>
<form class="md-form" action='<?php echo site_url('Agent/dashboard/reset_password'); ?>' enctype="multipart/form-data" method="post">
<input type="hidden" name="id" value="<?php echo $_SESSION['agent_id'] ?>">
<input type="hidden" name="pass_old" id="pass_old" value="<?php echo $_SESSION['password']; ?>">
<?php } ?>
<div class="file-field">

<?php if($_SESSION['pass_reset'] == 'N'){?>
<!--- OLD PASSWORD --->
<div class="col-md-12">     
<div class="md-form md-outline"> 
<input type="password" name="oldpass" class="form-control avoid_space" id='oldpass' required value="" onchange="passcheck()">
<label for="oldpass">Old password</label>
</div>
</div>
<?php }else{ ?>
<input type="hidden" name="oldpass" id="oldpass" value="<?php echo $_SESSION['password']; ?>">
<?php } ?>

<!--- PASSWORD --->
<!--- NEW PASSWORD --->
<div class="col-md-12">     
<div class="md-form md-outline"> 
<input type="password" name="newpass" class="form-control avoid_space" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" id="newpass" required value="" onchange="passcheck()">
<label for="newpass">New password</label>
</div>
</div>
<!--- PASSWORD --->

<!--- CON PASSWORD --->
<div class="col-md-12">     
<div class="md-form md-outline"> 
<input type="password" name="conpass" class="form-control avoid_space" id="conpass" required value="" onchange="passcheck()">
<label for="conpass">Confirm Password</label>
</div>
</div>
<!--- PASSWORD --->
</div>
</div>

<h6 class="note note-danger">Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters</h6>

</div>
<div class="modal-footer">      
<button type="submit" class="btn btn-primary btn-sm" id="changepass" name="save">Save</button>
<?php if($_SESSION['pass_reset'] == 'N'){?>
<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" onclick="value_reomve()"><i class="fas fa-times"></i></button>
<?php } ?>
</div>
</form>
</div>
</div>
</div>
<!-- Central Modal Small -->


<!----- SHOW EXTENSION DETAILS MODAL -------->
<input type="submit" name="ext" id="Show_ext" style="display: none;" data-toggle="modal" data-target="#show_ext_details">
<div class="modal fade" id="show_ext_details" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
<!-- Change class .modal-sm to change the size of the modal -->
<div class="modal-dialog modal-fade" role="document">

<div class="modal-content">
<div class="modal-header">
<h3 class="modal-title w-100 modal-header-top" id="myModalLabel">Extension Details <span style="float: right;"><button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" style="padding: 3px;padding-right: 10px;padding-left: 10px"><i class="fas fa-times"></i></button></span></h3>
</div>
<div class="modal-body">

<div class="col-md-12">  
<table class="table table-striped table-bordered table-sm">
<tr><td>Display Name</td><td><span id="display_name"></span></td></tr>
<tr><td>Outbound CLID</td><td><span id="did_id"></span></td></tr>
<tr><td>Recording Enabled</td><td><span id="recording_enabled"></span></td></tr>
<tr><td>Call Monitoring</td><td><span id="call_monitoring"></span></td></tr>
<tr><td>Presence Blf</td><td><span id="presence_blf"></span></td></tr>
<tr><td>Park Retrive</td><td><span id="park_retrive"></span></td></tr>
<tr><td>Mobility</td><td><span id="mobility"></span></td></tr>
<tr><td>Portal Access</td><td><span id="portal_access"></span></td></tr>
<tr><td>Synergy</td><td><span id="synergy"></span></td></tr>
<tr><td>Voicemail Enabled</td><td><span id="voicemail_enabled"></span></td></tr>
<tr><td>Voice Email</td><td><span id="vm_email"></span></td></tr>
<tr><td>Call Forward Not Available</td><td><span id="cfna"></span></td></tr>
<tr><td>Call Forward Unconditional</td><td><span id="cfyc"></span></td></tr>
</table>
</div>
</div>
</div>
</div>
</div>
<!-- Central Modal Small -->

<!----- SHOW EXTENSION DETAILS MODAL -------->
<input type="submit" name="site" id="Show_site" style="display: none;" data-toggle="modal" data-target="#show_site_details">
<div class="modal fade" id="show_site_details" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
<!-- Change class .modal-sm to change the size of the modal -->
<div class="modal-dialog modal-fade" role="document">

<div class="modal-content">
<div class="modal-header">
<h3 class="modal-title w-100 modal-header-top" id="myModalLabel">Branch Details <span style="float: right;"><button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" style="padding: 3px;padding-right: 10px;padding-left: 10px"><i class="fas fa-times"></i></button></span></h3>
</div>
<div class="modal-body">

<div class="col-md-12"> 
<table class="table table-striped table-bordered table-sm">
<tr><td>Branch</td><td><span id="site_name"></span></td></tr>
<tr><td>Country Code</td><td><span id="country_code_site"></span></td></tr>
<tr><td>Branch Prefix</td><td><span id="trunkprefix_site"></span></td></tr>
<tr><td>ISD Allowed</td><td><span id="isd_allowed_site"></span></td></tr>
<tr><td>Park Extension</td><td><span id="park_extension"></span></td></tr>
<tr><td>No. of parking slots</td><td><span id="parking_slot"></span></td></tr>
<tr><td>Call Recording</td><td><span id="call_recording_site"></span></td></tr>   
<tr><td>Park Retreive</td><td><span id="park_retreive_site"></span></td></tr>
<tr><td>Call Monitoring</td><td><span id="call_monitoring_site"></span></td></tr>
<tr><td>Inter Branch</td><td><span id="inter_branch_site"></span></td></tr>
<tr><td>CDR Timezone</td><td><span id="cdr_timezone_site"></span></td></tr>
<tr><td>Fax DID</td><td><span id="fax_did_site"></span></td></tr>
<tr><td>Fax to e-Mail</td><td><span id="fax_2_email_site"></span></td></tr>
<tr><td>Branch Admin</td><td><span id="site_admin_site"></span></td></tr>
<tr><td>Branch Address</td><td><span id="site_address_site"></span></td></tr>
</table>
</div>
</div>
</div>
</div>
</div>
<!-- Central Modal Small -->


<!----- CHNAGE PASS MODAL -------->
<input type="submit" name="site" id="agent_pass" style="display: none;" data-toggle="modal" data-target="#Reset_Agent_Pass">
<div class="modal fade" id="Reset_Agent_Pass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"  data-backdrop="static" data-keyboard="false">

<div class="modal-dialog modal-fade" role="document">
<div class="modal-content">
<div class="modal-header">
<h3 class="modal-title w-100 modal-header-top" id="myModalLabel"><center>Change Portal Password</center></h3>
</div>
<div class="modal-body">

<div class="col-md-12" style="margin-top: -20px;"> 
<form class="md-form" action="<?php echo site_url('Admin/dashboard/reset_agent_password'); ?>" enctype="multipart/form-data" method="post">  
<input type="hidden" name="agent_id" id="agent_id" value="">
<div class="file-field">

<div class="col-md-12">     
<div class="md-form md-outline"> 
<input type="password" name="newpass" class="form-control avoid_space" onchange="agent_pass_check()" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" id="agent_newpass" required value="">
<label for="agent_newpass">New password</label>
</div>
</div>

<div class="col-md-12">     
<div class="md-form md-outline"> 
<input type="password" name="conpass" class="form-control avoid_space" onchange="agent_pass_check()" id="agent_conpass" required value="">
<label for="agent_conpass">Confirm Password</label>
</div>
</div>

<div class="col-md-12">     
<div class="custom-control custom-checkbox md-form md-outline" style="margin-left: 25px;">
<input type="checkbox" class="custom-control-input" id="forcepass" name="forcepass" value="Y">
<label class="custom-control-label" for="forcepass">Force Password Change </label>
</div>
</div>

</div>
</div>
<br>
<h6 class="note note-danger">Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters</h6>

</div>
<div class="modal-footer">      
<button type="submit" class="btn btn-primary btn-sm" id="agent_changepass" name="save">Save</button>
<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times"></i></button>
</div>
</form>
</div>
</div>
</div>
<!-- Central Modal Small -->

 
<!----- CHNAGE PASS MODAL -------->
<div class="modal fade" id="ImportExt" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"  data-backdrop="static" data-keyboard="false">
<!-- Change class .modal-sm to change the size of the modal -->
<div class="modal-dialog modal-xl" role="document">

<div class="modal-content">
<div class="modal-header">
<h3 class="modal-title w-100 modal-header-top" id="myModalLabel"><center>Import Extension</center></h3>
</div>
<div class="modal-body">
<?php if($extension != ''){ ?>
<div class="col-md-12" style="margin-top: -20px;"> 
<form class="md-form" enctype="multipart/form-data" action="<?php echo site_url('Admin/Provisioning/import_provisioning'); ?>" enctype="multipart/form-data" method="post">  

<div class="file-field">

<div class="row">
<div class="col-md-6 select-outline">              
      <select name="company" class="mdb-select md-form md-outline colorful-select dropdown-primary" required="" searchable="Search here..">
       <option value="" disabled selected>Select Company</option>
       <?php foreach ($company as $value) { ?>
         <option value="<?php echo $value->id ?>" <?php if($provisioning->phone_company == $value->id){ echo "selected";} ?> ><?php echo $value->name ?></option>
       <?php } ?>
      </select>
    <label>Phone Company</label>
</div>

<div class="col-md-6 select-outline">              
      <select name="model" class="mdb-select md-form md-outline colorful-select dropdown-primary" required="" searchable="Search here..">
       <option value="" disabled selected>Select Model</option>
       <?php foreach ($model as $value) { ?>
         <option value="<?php echo $value->id ?>" <?php if($provisioning->model == $value->id){ echo "selected";} ?> ><?php echo $value->model ?></option>
       <?php } ?>
      </select>
    <label>Phone Company</label>
</div>

<div class="col-md-12"><b>Extension Details</b> <hr style="margin-top:10px;margin-bottom: 0px"></div> 

<div class="col-md-12" style="width: 100%;overflow-x: scroll;">
<table class="table-sm table-bordered table">
 <thead>
 <tr>
 <th>#</th>
   <th>Extension</th>
   <th>Phone IP</th>
   <th>MAC</th>
   <th>Domain1</th>
   <th>Proxy1</th>
   <th>Port1</th> 
   <th>Domain2</th> 
   <th>Proxy2</th>  
   <th>Port2</th> 
 </tr>
 </thead>
 <tr>
 	<td colspan="10" style="padding: 5px"><input type="text"placeholder="Search Extension.." name="" id="search_data" style="    width: 100%;background: #cccccc82;border: 1px solid;"></td>
 </tr>
 <tbody id="import_table">
 <?php $i=1; foreach ($extension as  $value) {?>
 <tr> 
 	<td><input type="checkbox" id="import_check_<?php echo $i ?>" name="import_check" onclick="import_data(<?php echo $i ?>)" style="position: unset;pointer-events: auto;opacity: unset;"></td>
 	<td><?php echo $value->extension ?></td>
 	<!-- hiddenvalue pass --->
 	<input type="hidden" class="import" name="extension[]" value="<?php echo $value->extension ?>" readonly>
 	<!-- hiddenvalue pass --->
 	<td><input type="text" class="import_<?php echo $i ?> " name="phone_ip[]" disabled required></td>
 	<td><input type="text" class="import_<?php echo $i ?>" name="mac[]" disabled required></td>
 	<td><input type="text" class="import_<?php echo $i ?>"name="domain1[]" disabled required></td>
 	<td><input type="text" class="import_<?php echo $i ?>" name="proxy1[]" disabled required></td>
 	<td><input type="text" class="import_<?php echo $i ?>" name="port1[]" disabled required></td>
 	<td><input type="text" class="import_<?php echo $i ?>" name="domain2[]" disabled required></td>
 	<td><input type="text" class="import_<?php echo $i ?>" name="proxy2[]" disabled required></td>
 	<td><input type="text" class="import_<?php echo $i ?>" name="port2[]" disabled requireda></td>
 </tr>
<?php $i++; } ?>
</tbody>
</table>
</div>

</div>

</div>
</div>

</div>
<div class="modal-footer">      
<button type="submit" class="btn btn-primary btn-sm" id="changepass" name="save">Save</button>
<button type="reset" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times"></i></button>
</div>
</form>
</div>
<?php }else{?> 
<div class="col-md-12">
<center><h6 class="btn-outline-danger p-2"> All Extension Of This Branch Is Already Provisioning.</h6></center>
</div>
<div class="modal-footer">      
<button type="reset" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times"></i></button>
</div>
<?php } ?>
</div>
</div>

<!-- Central Modal Small -->

