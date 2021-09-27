<!--================================ 
- DATA FETCH FROM PAGE TAIL 
- ALL JS FUNCTION SET IN PAGE TAIL
==================================-->

<div class="col-md-6 mt-2">
<div class="card mb-6 p-2">
<p class="col-md-12 badge badge-info"> Phone Template List</p>  
<table id="phone_template" class="table table-striped table-bordered text-center" cellspacing="0">
  <thead>
    <tr>
      <th class="th-sm">Model</th>
      <th class="th-sm">Company</th>
      <th class="th-sm">Template</th>
      <th class="th-sm">Date Time</th>
      <th class="th-sm">Action</th>
    </tr>
  </thead>
</table>
</div>
</div>

<div class="col-md-6 mt-2" style="border-left: 1px solid #000">
<div class="card mb-6 p-2">
<p class="col-md-12 badge badge-info" style="margin-bottom:-5px;z-index: 111"><?php if($template->id == ''){ echo 'Add';}else{echo 'Edit';} ?> Phone Template</p>  

<form method="post" action="" enctype="multipart/form-data">
<input type="hidden" class="form-control" name="id" value="<?php echo $template->id; ?>" />

<div class="row" style="height: 280px;overflow-y: scroll;">

<div class="col-md-6 select-outline">
      <select name="company" class="mdb-select md-form md-outline colorful-select dropdown-primary" required="">
       <option value="" disabled selected>Select Company</option>
       <?php foreach ($company as $value) { ?>
         <option value="<?php echo $value->id ?>" <?php if($template->company == $value->id){ echo "selected";} ?> ><?php echo $value->name ?></option>
       <?php } ?>
      </select>
    <label>Phone Company</label>
</div>

<div class="col-md-6 select-outline">    
      <select name="model" class="mdb-select md-form md-outline colorful-select dropdown-primary" required="">
       <option value="" disabled selected>Select Model</option>
       <?php foreach ($model as $value) { ?>
         <option value="<?php echo $value->id ?>" <?php if($template->model == $value->id){ echo "selected";} ?> ><?php echo $value->model ?></option>
       <?php } ?>
      </select>
    <label>Phone Company</label>
</div>
 
<div class="col-md-6">
  <div class="md-form md-outline" style="margin-top: auto;">
    <input type="file" id="file_temp" class="form-control" name="file_name" value="" <?php if($template->id == ''){ echo "required";} ?>/>
    <input type="hidden" name="file_name_old" value="<?php echo $template->file_name ?>" />
  </div>
</div>

<?php if($template->file_name != ''){ ?>
<div class="col-md-6">
  <b>OLD File :</b> <?php echo $template->file_name ?> 
</div>
<?php } ?>

<div class="col-md-12"><br><b>Parameter Name</b><hr style="margin-bottom:0px;margin-top:0px"></div>

<div class="col-md-4">
  <div class="md-form md-outline">
    <input type="text" id="Username" class="form-control " name="username" value="<?php echo $template->username; ?>" required/>
    <label class="form-label" for="Username">Username</label>
  </div>
</div>

<div class="col-md-4">
  <div class="md-form md-outline">
    <input type="text" id="Auth" class="form-control" name="auth_username" value="<?php echo $template->auth_username; ?>" required/>
    <label class="form-label" for="Auth">Auth username</label>
  </div>
</div>

<div class="col-md-4">
  <div class="md-form md-outline">
    <input type="text" id="Password" class="form-control" name="password" value="<?php echo $template->password; ?>" required/>
    <label class="form-label" for="Password">Password</label>
  </div>
</div>

<div class="col-md-4">
  <div class="md-form md-outline">
    <input type="text" id="Domain1" class="form-control" name="domain1" value="<?php echo $template->domain1; ?>" required/>
    <label class="form-label" for="Domain1">Domain1</label>
  </div>
</div>

<div class="col-md-4">
  <div class="md-form md-outline">
    <input type="text" id="Proxy1" class="form-control" name="proxy1" value="<?php echo $template->proxy1; ?>" required/>
    <label class="form-label" for="Proxy1">Proxy1</label>
  </div>
</div>

<div class="col-md-4">
  <div class="md-form md-outline">
    <input type="text" id="Port1" class="form-control" name="port1" value="<?php echo $template->port1; ?>" required/>
    <label class="form-label" for="Port1">Port1</label>
  </div>
</div>

<div class="col-md-4">
  <div class="md-form md-outline">
    <input type="text" id="Domain2" class="form-control" name="domain2" value="<?php echo $template->domain2; ?>" required/>
    <label class="form-label" for="Domain2">Domain2</label>
  </div>
</div>

<div class="col-md-4">
  <div class="md-form md-outline">
    <input type="text" id="Proxy2" class="form-control" name="proxy2" value="<?php echo $template->proxy2; ?>" required/>
    <label class="form-label" for="Proxy2">Proxy2</label>
  </div>
</div>

<div class="col-md-4">
  <div class="md-form md-outline">
    <input type="text" id="Port2" class="form-control" name="port2" value="<?php echo $template->port2; ?>" required/>
    <label class="form-label" for="Port2">Port2</label>
  </div>
</div>

<div class="col-md-4">
  <div class="md-form md-outline">
    <input type="text" id="mac" class="form-control" name="mac" value="<?php echo $template->mac; ?>" required/>
    <label class="form-label" for="mac">MAC Address</label>
  </div>
</div>

<div class="col-md-12"><br><b>LDAP Parameter Name</b><hr style="margin-bottom:0px;margin-top:0px"></div>


<div class="col-md-4">
  <div class="md-form md-outline">
    <input type="text" id="ip_address" class="form-control " name="ip_address" value="<?php echo $template->ldap_ip_address; ?>" required/>
    <label class="form-label" for="ip_address">IP Address</label>
  </div>
</div>

<div class="col-md-4">
  <div class="md-form md-outline">
    <input type="text" id="ldap_name" class="form-control" name="ldap_name" value="<?php echo $template->ldap_name; ?>" required/>
    <label class="form-label" for="ldap_name">LDAP Name</label>
  </div>
</div>

<div class="col-md-4">
  <div class="md-form md-outline">
    <input type="text" id="port" class="form-control" name="port" value="<?php echo $template->ldap_port; ?>" required/>
    <label class="form-label" for="port">Port</label>
  </div>
</div>

<div class="col-md-4">
  <div class="md-form md-outline">
    <input type="text" id="ldap_username" class="form-control" name="ldap_username" value="<?php echo $template->ldap_username; ?>" required/>
    <label class="form-label" for="ldap_username">Username</label>
  </div>
</div>

<div class="col-md-4">
  <div class="md-form md-outline">
    <input type="text" id="ldap_password" class="form-control" name="ldap_password" value="<?php echo $template->ldap_password; ?>" required/>
    <label class="form-label" for="ldap_password">Password</label>
  </div>
</div>

<div class="col-md-4">
  <div class="md-form md-outline">
    <input type="text" id="base_domain" class="form-control" name="base_domain" value="<?php echo $template->ldap_base_domain; ?>" required/>
    <label class="form-label" for="Port1">Base Domian</label>
  </div>
</div>

<div class="col-md-4">
  <div class="md-form md-outline">
    <input type="text" id="on_filter" class="form-control" name="on_filter" value="<?php echo $template->ldap_on_filter; ?>" required/>
    <label class="form-label" for="on_filter">On Filter</label>
  </div>
</div>


</div>

<div class="col-md-12"><hr>
  <input type="submit" name="save" value="Save" class="btn btn-primary btn-sm"> 
</div>

</form>

</div>
</div>
