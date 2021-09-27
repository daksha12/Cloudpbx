<!--================================ 
- DATA FETCH FROM PAGE TAIL 
- ALL JS FUNCTION SET IN PAGE TAIL
==================================-->
<div class="col-md-8 mt-2">
<div class="card mb-8 p-2">
<p class="col-md-12 badge badge-info"> Assign Rate Card</p>  
<table id="rate_card" class="table table-striped table-bordered table-sm text-center" cellspacing="0">
  <thead>
    <tr>
      <th class="th-sm">Tenant name</th>
      <th class="th-sm">Account Code</th>
      <th class="th-sm">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php  
        foreach ($assign_rate_card_details as $key => $value) 
        { 
          $tenant_details = getTenantListDetails($value->id);  
      ?>
      <tr>
        <td><?php echo $tenant_details->tenant_name; ?></td>
        <td><?php echo $value->account_code; ?></td>
        <td><a href="<?php echo site_url('Super/bill/index/'.$value->id) ?>"><i class="fas fa-edit"></i></a> | <a href="#" onclick="ConfirmRate('<?php echo $value->id ?>')"><i class="fas fa-trash"></i></a></td>
      </tr>
    <?php } ?>
  </tbody>
</table>
</div>
</div>

<div class="col-md-4 mt-2" style="border-left: 1px solid #000">
<div class="card mb-4 p-2">
<p class="col-md-12 badge badge-info" style="margin-bottom:-5px"><?php if($rate_card_id->id == ''){ echo 'Add';}else{echo 'Edit';} ?> Assign Rate Card</p>  

<form method="post" action="">
 
<input type="hidden" class="form-control" name="id" value="<?php echo $assign_rate_card_data->id; ?>" />

<div class="col-md-12">
      <select name="account" class="mdb-select md-form md-outline colorful-select dropdown-primary" required=""> 
       <option value="" disabled selected>Select Tenant</option>
       <?php foreach($tenant as $value){   ?>
         <option <?php if($assign_rate_card_data->account_id == $value->account_id){echo "selected";} ?> value="<?php echo $value->account_id ?>"><?php echo $value->tenant_name ?></option>
       <?php } ?>
      </select>
</div>


<div class="col-md-12 select-outline">
      <select name="rate_card[]" class="mdb-select md-form md-outline colorful-select dropdown-primary" required="" multiple="">
       <option value="" disabled selected>Select Rate Card</option>
       <?php foreach ($rate_card as $value) { ?>
         <option value="<?php echo $value->id ?>" <?php if(in_array($value->id, explode(',', $assign_rate_card_data->rate_card))){echo "selected";} ?> ><?php echo $value->country_code ?></option>
       <?php } ?>
      </select>
</div>


<div class="col-md-12"><hr>
  <input type="submit" name="save" value="Save" class="btn btn-primary btn-sm"> 
</div>

</form>
</div>
</div>
