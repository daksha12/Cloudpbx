<!--================================ 
- DATA FETCH FROM PAGE TAIL 
- ALL JS FUNCTION SET IN PAGE TAIL
==================================-->

<!-- Section: Analytical panel -->
<div class="col-md-6">
<form method="post" action="">
<div class="row">
<table class="table table-striped table-bordered table-sm text-center" cellspacing="0">
<thead>
<tr>
<th>Type</th>
<th>Numbers</th>
<th>Status</th>
</tr>
</thead>
<tbody>
<tr>
<td>Call forward unavailable</td>
<td><input type="hidden" class="form-control" name="key_data[]" value="/CFNA_<?php echo $_SESSION['tenant_name'] ?>_<?php echo $_SESSION['site_name'] ?>/<?php echo $_SESSION['extension'] ?>"><input type="text" class="form-control" name="value_data[]" value='<?php echo $available ?>' id="unavailable_call" onchange="call_manage()" onKeyDown="if(event.keyCode === 32) return false;"></td>
<td>
<?php if($available == ''){$status = 'Deactive'; echo "<span class='badge badge-danger'>Disabled</sapn>";}else{$status ='Active'; echo "<span class='badge badge-success'>Enabled</span>";}?>
<input type="hidden" class="form-control" name="status[]" value='<?php echo $status ?>' >
</td> 
</tr>
<tr>
<td>Call forward unconditional</td>
<td><input type="hidden" class="form-control" name="key_data[]" value="/CFUC_<?php echo $_SESSION['tenant_name'] ?>_<?php echo $_SESSION['site_name'] ?>/<?php echo $_SESSION['extension'] ?>"><input type="text" class="form-control" name="value_data[]" value='<?php echo $unconditional ?>' id="unconditional_call" onchange="call_manage()" onKeyDown="if(event.keyCode === 32) return false;"></td>
<td>
<?php if($unconditional == ''){$status = 'Deactive'; echo "<span class='badge badge-danger'>Disabled</sapn>";}else{$status ='Active'; echo "<span class='badge badge-success'>Enabled</span>";} ?>
 <input type="hidden" class="form-control" name="status[]" value='<?php echo $status ?>'>
</td>
</tr>
</tbody>
</table> 
<div class="col-md-12">
<hr style="margin-top: 2px;">
<input type="submit" name="save" value="Save" class="btn btn-primary btn-sm">
</div>
</div>
</form>
</div>
