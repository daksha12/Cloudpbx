<!--================================ 
- DATA FETCH FROM PAGE TAIL 
- ALL JS FUNCTION SET IN PAGE TAIL
==================================-->

<div class="col-md-6 mt-2">
<div class="card mb-6 p-2">
<p class="col-md-12 badge badge-info"> Phone Company List</p>  
<table id="phone_commpany" class="table table-striped table-bordered table-sm text-center" cellspacing="0">
  <thead>
    <tr>
      <th class="th-sm">Phone Company</th>
      <th class="th-sm">Date</th>
      <th class="th-sm">Action</th>
    </tr>
  </thead>
</table>
</div>
</div>

<div class="col-md-6 mt-2" style="border-left: 1px solid #000">
<div class="card mb-6 p-2">
<p class="col-md-12 badge badge-info" style="margin-bottom:-5px"><?php if($phone->id == ''){ echo 'Add';}else{echo 'Edit';} ?> Phone Company</p>  
<form method="post" action="">
<input type="hidden" class="form-control" name="id" value="<?php echo $phone->id; ?>" />

<div class="col-md-12">
  <div class="md-form md-outline">
    <input type="text" id="form1" class="form-control" name="company" value="<?php echo $phone->name; ?>" />
    <label class="form-label" for="form1">Phone Company Name</label>
  </div>
</div>

<div class="col-md-12"><hr>
  <input type="submit" name="save" value="Save" class="btn btn-primary btn-sm"> 
</div>

</form>

</div>
</div>
