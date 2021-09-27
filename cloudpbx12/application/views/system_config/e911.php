
<form class="text-center" style="color: #757575;" method="post" action="" id="e911_form" onsubmit="savedata()">    

<div id="table" class="table-editable" style="overflow: scroll;height: 300px">                     
<div>
<table class="table table-bordered table-responsive-md table-striped text-center" id="e911_master">

<!-- Table head -->
<thead>
<tr>      
 <th class="text-center">#</th>
 <th class="text-center">Trunk DID</th>
 <th class="text-center">Emergency enable</th>
 <th class="text-center">Emergency number</th>
 <th class="text-center">Address1</th>
 <th class="text-center">Address2</th>
 <th class="text-center">City</th>
 <th class="text-center">State</th>
 <th class="text-center">Pincode</th>
</tr>
</thead>
<!-- Table head -->

<!-- Table body -->
<tbody>
	<?php
	$cnt = 1;
	if(!empty($e911List)){		
		foreach ($e911List as $key => $e911_detail) {		

		   ?>
		   <tr class="e911_div">

			<td class="pt-3-half" style="vertical-align: inherit;">
			<a href="#" class="remove-trunk"><i class="fas fa-trash"></i></a>		 	
			</td>
  	
  			 <input type="hidden" name="old_e911_id[<?php echo $cnt;?>]" class="old_value_hidden" value="<?php echo $e911_detail->id;?>">

		    <td class="pt-3-half" style="vertical-align: inherit;"><input type="text" placeholder="Trunk DID" name="trunk_did[<?php echo $cnt;?>]" id="trunk_did[<?php echo $cnt;?>]" value="<?php echo $e911_detail->trunk_did;?>" class="e911_first avoid_space" required></td>

			<td class="pt-3-half" style="vertical-align: inherit;"><select  name="emergencyenable[<?php echo $cnt;?>]" id="emergencyenable[<?php echo $cnt;?>]" class="browser-default custom-select" style="width: 105px;height: 28px;border-radius: 0px;padding: 1px;" required>
				<option value="N" <?php if($e911_detail->emergencyenable=='N'){ echo 'selected';}?>>No</option>
				<option value="Y" <?php if($e911_detail->emergencyenable=='Y'){ echo 'selected';}?>>Yes</option>
			</select></td>

			<td class="pt-3-half" style="vertical-align: inherit;"><input type="text" placeholder="Emergency Number" name="emergencynumber[<?php echo $cnt;?>]" id="emergencynumber[<?php echo $cnt;?>]" value="<?php echo $e911_detail->emergencynumber;?>" class="avoid_space" required></td>

			<td class="pt-3-half" style="vertical-align: inherit;"><input type="text" placeholder="Address 1" name="address1[<?php echo $cnt;?>]" id="address1[<?php echo $cnt;?>]" value="<?php echo $e911_detail->address1;?>" class="avoid_space" required></td>

			<td class="pt-3-half" style="vertical-align: inherit;"><input type="text" placeholder="Address 2" name="address2[<?php echo $cnt;?>]" id="address2[<?php echo $cnt;?>]" value="<?php echo $e911_detail->address2;?>" class="avoid_space" required ></td>

			<td class="pt-3-half" style="vertical-align: inherit;"><input type="text" placeholder="City" name="city[<?php echo $cnt;?>]" id="city[<?php echo $cnt;?>]" value="<?php echo $e911_detail->city;?>" class="avoid_space" required></td>

			<td class="pt-3-half" style="vertical-align: inherit;"><input type="text" placeholder="State" name="state[<?php echo $cnt;?>]" id="state[<?php echo $cnt;?>]" value="<?php echo $e911_detail->state;?>" class="avoid_space" required></td>

			<td class="pt-3-half" style="vertical-align: inherit;"><input type="text" placeholder="Pincode" name="pincode[<?php echo $cnt;?>]" id="pincode[<?php echo $cnt;?>]" value="<?php echo $e911_detail->pincode;?>" class="avoid_space" required></td>

			</tr>
			<?php
			$cnt++;
		}
	}
	?>

	  <tr class="e911_div">
		<td class="pt-3-half" style="vertical-align: inherit;">
		  <a href="#" class="remove-trunk"><i class="fas fa-trash"></i></a>
		</td>

		<td class="pt-3-half" style="vertical-align: inherit;"><input type="text" placeholder="Trunk DID" name="trunk_did[<?php echo $cnt;?>]" id="trunk_did[<?php echo $cnt;?>]" value="" class="e911_first avoid_space" required></td>

		<td class="pt-3-half" style="vertical-align: inherit;"><select  name="emergencyenable[<?php echo $cnt;?>]" id="emergencyenable[<?php echo $cnt;?>]" class="browser-default custom-select" style="width: 105px;height: 28px;border-radius: 0px;padding: 1px;" required>
			<option value="N">No</option><option value="Y">Yes</option></select></td>

		<td class="pt-3-half" style="vertical-align: inherit;"><input type="text" placeholder="Emergency Number" name="emergencynumber[<?php echo $cnt;?>]" id="emergencynumber[<?php echo $cnt;?>]" value="" class="avoid_space" required></td>

		<td class="pt-3-half" style="vertical-align: inherit;"><input type="text" placeholder="Address 1" name="address1[<?php echo $cnt;?>]" id="address1[<?php echo $cnt;?>]" value="" class="avoid_space" required ></td>

		<td class="pt-3-half" style="vertical-align: inherit;"><input type="text" placeholder="Address 2" name="address2[<?php echo $cnt;?>]" id="address2[<?php echo $cnt;?>]" value="" class="avoid_space" required></td>

		<td class="pt-3-half" style="vertical-align: inherit;"><input type="text" placeholder="City" name="city[<?php echo $cnt;?>]" id="city[<?php echo $cnt;?>]" value="" class="avoid_space" required></td>

		<td class="pt-3-half" style="vertical-align: inherit;"><input type="text" placeholder="State" name="state[<?php echo $cnt;?>]" id="state[<?php echo $cnt;?>]" value="" class="avoid_space" required></td>

		<td class="pt-3-half" style="vertical-align: inherit;"><input type="text" placeholder="Pincode" name="pincode[<?php echo $cnt;?>]" id="pincode[<?php echo $cnt;?>]" value="" class="avoid_space" required></td>
		
	</tr>

</tbody>
<!-- Table body -->
</table>
</div>
</div>			

<div class="col-md-12" style="text-align: left;"><hr> 
<input type="submit" class="waves-effect waves-dark btn btn-sm btn-primary" name="save_e911" value="Save">
</div>
</form>
