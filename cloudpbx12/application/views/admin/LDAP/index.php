<!--================================ 
- DATA FETCH FROM PAGE TAIL 
- ALL JS FUNCTION SET IN PAGE TAIL
==================================-->

<form method="post" action="" enctype="multipart/form-data">
<input type="hidden" class="form-control" name="id" value="<?php echo $ldap->id; ?>" />

<div class="row">

<div class="col-md-4">
  <div class="md-form md-outline">
    <input type="text" id="ip_address" class="form-control " name="ip_address" value="<?php echo $ldap->ip_address; ?>" required/>
    <label class="form-label" for="ip_address">IP Address</label>
  </div>
</div>

<div class="col-md-4">
  <div class="md-form md-outline">
    <input type="text" id="ldap_name" class="form-control" name="ldap_name" value="<?php echo $ldap->ldap_name; ?>" required/>
    <label class="form-label" for="ldap_name">LDAP Name</label>
  </div>
</div>

<div class="col-md-4">
  <div class="md-form md-outline">
    <input type="text" id="port" class="form-control" name="port" value="<?php echo $ldap->port; ?>" required/>
    <label class="form-label" for="port">Port</label>
  </div>
</div>

<div class="col-md-4">
  <div class="md-form md-outline">
    <input type="text" id="username" class="form-control" name="username" value="<?php echo $ldap->username; ?>" required/>
    <label class="form-label" for="username">Username</label>
  </div>
</div>

<div class="col-md-4">
  <div class="md-form md-outline">
    <input type="password" id="password" class="form-control" name="password" value="<?php echo $ldap->password; ?>" required/>
    <label class="form-label" for="password">Password</label>
  </div>
</div>

<div class="col-md-4">
  <div class="md-form md-outline">
    <input type="text" id="base_domain" class="form-control" name="base_domain" value="<?php echo $ldap->base_domain; ?>" required/>
    <label class="form-label" for="Port1">Base Domian</label>
  </div>
</div>

<div class="col-md-4">
  <div class="md-form md-outline">
    <input type="text" id="on_filter" class="form-control" name="on_filter" value="<?php echo $ldap->on_filter; ?>" required/>
    <label class="form-label" for="on_filter">On Filter</label>
  </div>
</div>


</div>

<div class="col-md-12"><hr>
  <input type="submit" name="save" value="Save" class="btn btn-primary btn-sm"> 
  <?php if($ldap->id != ''){ ?>
  | <a href="<?php echo site_url('Admin/LDAP/delete/'.$ldap->id) ?>" class="btn btn-danger btn-sm">Delete</a> 
<?php } ?>
</div>

</form>

</div>
</div>
