<!--================================ 
- DATA FETCH FROM PAGE TAIL 
- ALL JS FUNCTION SET IN PAGE TAIL
==================================-->

<div class="col-md-6 mt-2">
<div class="card mb-6 p-2">
<p class="col-md-12 badge badge-info"> Phone Model List</p>  
<table id="phone_family" class="table table-striped table-bordered table-sm text-center" cellspacing="0">
  <thead>
    <tr>
      <th class="th-sm">Phone Model</th>
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
<p class="col-md-12 badge badge-info" style="margin-bottom:-5px"><?php if($model->id == ''){ echo 'Add';}else{echo 'Edit';} ?> Phone Model</p>  
<form method="post" action="">
<input type="hidden" class="form-control" name="id" value="<?php echo $model->id; ?>" />

<div class="row">
<div class="col-md-12 select-outline">
      <select name="company" class="mdb-select md-form md-outline colorful-select dropdown-primary" required="">
       <option value="" disabled selected>Select Company</option>
       <?php foreach ($company as $value) { ?>
         <option value="<?php echo $value->id ?>" <?php if($model->company == $value->id){ echo "selected";} ?> ><?php echo $value->name ?></option>
       <?php } ?>
      </select>
    <label>Phone Company</label>
</div>


<div class="col-md-12">
  <div class="md-form md-outline">
    <input type="text" id="form1" class="form-control" name="model" value="<?php echo $model->model; ?>" />
    <label class="form-label" for="form1">Phone Model Name</label>
  </div>
</div>

<div class="col-md-12">
  <div class="md-form md-outline">
    <input type="text" id="form2" class="form-control" name="file_prifix" value="<?php echo $model->file_prifix; ?>" />
    <label class="form-label" for="form2">Provision File Prifix</label>
  </div>
</div>

<div class="col-md-12"><hr>
  <input type="submit" name="save" value="Save" class="btn btn-primary btn-sm"> 
</div>

</div>
</form>

</div>
</div>
