<!--================================ 
- DATA FETCH FROM PAGE TAIL 
- ALL JS FUNCTION SET IN PAGE TAIL
==================================-->
<?php if($_SESSION['site_name'] == 'All'){ ?>
<div class="col-md-12">
<center><h6 class="note note-danger">Please select any one branch to do phone provisioning.</h6></center>
</div>
<?php }else{ ?>

<div class="col-md-6 mt-2">
<div class="card mb-6 p-2">
<p class="col-md-12 badge badge-info"> Phone Provisioning List </p>  
<table id="phone_provisioning" class="table table-bordered text-center" cellspacing="0">
  <thead>
    <tr>
      <th class="th-sm">Extension</th>
      <th class="th-sm">Company</th>
      <th class="th-sm">Model</th>
      <th class="th-sm">Date</th>
      <th class="th-sm">Action</th>
    </tr>
  </thead>
</table>
</div>
</div>

<div class="col-md-6 mt-2" style="border-left: 1px solid #000">
<div class="card mb-6 p-2">
<p class="col-md-12 badge badge-info" style="margin-bottom:-5px;z-index: 111"><?php if($provisioning->id == ''){ echo 'Add';}else{echo 'Edit';} ?> Phone Provisioning 
  <?php if($provisioning->id == ''){ ?>
  <span style="float: right;margin-right:8px">
    <a href="" data-toggle="modal" id="Import_Ext" data-target="#ImportExt" class="btn-primary btn-sm" style="padding: 2px;padding-right:5px;padding-left :5px;border-radius: 2px;font-size: 13px">Import Extension</a>
  </span>
<?php } ?>
</p>  

<?php if($extension != '' || $provisioning->id != ''){ ?>
<form method="post" action="" enctype="multipart/form-data">
<input type="hidden" class="form-control" name="id" value="<?php echo $provisioning->id; ?>" />

<div class="row" style="overflow-y: scroll;height: 270px">


  <div class="col-md-6 select-outline">
                
    <select name="company" class="mdb-select md-form md-outline colorful-select dropdown-primary" searchable="Search here.." required="">
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
    <label>Phone Model</label>
</div>
 
<div class="col-md-12"><b>Extension Details</b> <hr style="margin-top:0px;margin-bottom: 0px"></div> 
<div class="col-md-4 select-outline">              
      <select name="extension" class="mdb-select md-form md-outline colorful-select dropdown-primary" required="" searchable="Search here..">
       <option value="" disabled selected>Select Extenion</option>
        
       <?php  
        if($extension != '') { 
        foreach ($extension as $value) { 
        if($provisioning->id != ''){
        ?>
         <option value="<?php echo $provisioning->extension ?>" selected><?php echo $provisioning->extension ?></option>
       <?php } ?>
         <option value="<?php echo $value->extension ?>" <?php if($provisioning->extension == $value->extension){ echo "selected";} ?> ><?php echo $value->extension ?></option>
       <?php } }else{ ?>
        <option value="<?php echo $provisioning->extension ?>" selected><?php echo $provisioning->extension ?></option>
       <?php } ?>
      </select>
    <label>Extension</label>
</div>

<div class="col-md-4">
  <div class="md-form md-outline">
    <input type="text" id="ip" class="form-control" name="phone_ip" value="<?php echo $provisioning->phone_ip; ?>" required/>
    <label class="form-label" for="ip">Phone IP</label>
  </div>
</div>

<div class="col-md-4">
  <div class="md-form md-outline">
    <input type="text" id="mac" class="form-control" name="mac" value="<?php echo $provisioning->mac; ?>" required/>
    <label class="form-label" for="mac">MAC Address</label>
  </div>
</div>

<div class="col-md-12"><b>Server Details</b> <hr style="margin-top:0px;margin-bottom: 0px"></div> 
<!---- DOMIAN ----->
<div class="col-md-4">
  <div class="md-form md-outline">
    <input type="text" id="domian1" class="form-control" name="domain1" value="<?php echo $provisioning->domain1; ?>" required/>
    <label class="form-label" for="domian1">Domian1</label>
  </div>
</div>
<div class="col-md-4">
  <div class="md-form md-outline">
    <input type="text" id="proxy1" class="form-control" name="proxy1" value="<?php echo $provisioning->proxy1; ?>" required/>
    <label class="form-label" for="proxy1">Proxy1</label>
  </div>
</div>
<div class="col-md-4">
  <div class="md-form md-outline">
    <input type="text" id="port1" class="form-control" name="port1" value="<?php echo $provisioning->port1; ?>" required/>
    <label class="form-label" for="port1">Port1</label>
  </div>
</div>

<div class="col-md-4">
  <div class="md-form md-outline">
    <input type="text" id="domain2" class="form-control" name="domain2" value="<?php echo $provisioning->domain2; ?>" required/>
    <label class="form-label" for="domain2">Domian2</label>
  </div>
</div>
<div class="col-md-4">
  <div class="md-form md-outline">
    <input type="text" id="proxy2" class="form-control" name="proxy2" value="<?php echo $provisioning->proxy2; ?>" required/>
    <label class="form-label" for="proxy2">Proxy2</label>
  </div>
</div>
<div class="col-md-4">
  <div class="md-form md-outline">
    <input type="text" id="port2" class="form-control" name="port2" value="<?php echo $provisioning->port2; ?>" required/>
    <label class="form-label" for="port2">Port2</label>
  </div>
</div>
<!-- END DOMAIN -->
</div>
<div class="col-md-12"><hr>
  <input type="submit" name="save" value="Save" class="btn btn-primary btn-sm"> 
</div>
</form>
<?php }else { ?>
<div class="col-md-12"> 
<br><h6 class="btn-outline-danger p-2"> All Extension Of This Branch Is Already Provisioning.</h6>
</div>
<?php } ?> 
</div>
</div>

<?php } ?>