<!--================================ 
- DATA FETCH FROM PAGE TAIL 
- ALL JS FUNCTION SET IN PAGE TAIL
==================================-->
<div class="col-md-6 mt-2">
<div class="card mb-6 p-2">
<p class="col-md-12 badge badge-info"> Rate Card List</p>  
<table id="rate_card" class="table table-striped table-bordered table-sm text-center" cellspacing="0">
  <thead>
    <tr>
      <th class="th-sm">County Code</th>
      <th class="th-sm">Rate</th>
      <th class="th-sm">Pulse</th>
      <th class="th-sm">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($rate_card as $key => $value) { ?>
      <tr>
        <td><?php echo $value->country_code; ?></td>
        <td><?php echo $value->rate; ?></td>
        <td><?php echo $value->pulse; ?></td>
        <td><a href="<?php echo site_url('Super/rate_card/index/'.$value->id) ?>"><i class="fas fa-edit"></i></a> | <a href="#" onclick="ConfirmRate('<?php echo $value->id ?>')"><i class="fas fa-trash"></i></a></td>
      </tr>
    <?php } ?>
  </tbody>
</table>
</div>
</div>

<div class="col-md-6 mt-2" style="border-left: 1px solid #000">
<div class="card mb-6 p-2">
<p class="col-md-12 badge badge-info" style="margin-bottom:-5px"><?php if($rate_card_id->id == ''){ echo 'Add';}else{echo 'Edit';} ?> Rate card</p>  
<form method="post" action="">
<input type="hidden" class="form-control" name="id" value="<?php echo $rate_card_id->id; ?>" />

<div class="col-md-12">
  <div class="md-form md-outline">
    <input type="text" id="country_code" class="form-control" name="country_code" value="<?php echo $rate_card_id->country_code; ?>" required/>
    <label class="form-label" for="country_code">Country Code</label>
  </div>
</div>

<div class="col-md-12">
  <div class="md-form md-outline">
    <input type="text" id="rate" class="form-control" name="rate" value="<?php echo $rate_card_id->rate; ?>" required />
    <label class="form-label" for="rate">Rate</label>
  </div>
</div>

<div class="col-md-12">
  <div class="md-form md-outline">
    <input type="text" id="pulse" class="form-control" name="pulse" value="<?php echo $rate_card_id->pulse; ?>" required/>
    <label class="form-label" for="pulse">Pulse</label>
  </div>
</div>

<div class="col-md-12"><hr>
  <input type="submit" name="save" value="Save" class="btn btn-primary btn-sm"> 
</div>

</form>

</div>
</div>
