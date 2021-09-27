
<form class="text-center" style="color: #757575;" method="post" action="" id="trunk_form" onsubmit="savedata()">    

<div id="table" class="table-editable" style="overflow: scroll;height: 300px">                     
<div>
<table class="table table-bordered table-responsive-md table-striped text-center" id="trunk_master">

<!-- Table head -->
<thead>
<tr>      
<th class="text-center">#</th>
<th class="text-center">Trunk name</th>
<th class="text-center">Trunk DID</th>
<th class="text-center">Username</th>
<th class="text-center">Password</th>
<th class="text-center">Host</th>
<th class="text-center">Port</th>
<th class="text-center">Domain</th>
<th class="text-center">DTMF mode</th>
<th class="text-center">NAT</th>
<th class="text-center">Direct rtp</th>
<th class="text-center">Register trunk</th>

<th class="text-center">Prefix</th>
<th class="text-center">Failover</th>
<th class="text-center">Ring duration</th>
<th class="text-center">CPE IP</th>
<th class="text-center">D2E</th>
</tr>
</thead>
<!-- Table head -->

<!-- Table body -->
<tbody>
	<?php
	$cnt = 1;
	if(!empty($trunkList)){		
		foreach ($trunkList as $key => $trunk_detail) {		   
		   ?>
		   <tr class="trunk_div">

			<td class="pt-3-half" style="vertical-align: inherit;">
			<a href="#" class="remove-trunk"><i class="fas fa-trash"></i></a>		 	
			</td>
			<td class="pt-3-half" style="vertical-align: inherit;">
				<input type="text" placeholder="Trunk name" name="trunk_name[<?php echo $cnt;?>]" id="trunk_name[<?php echo $cnt;?>]" value="<?php echo $trunk_detail->trunk_name;?>" class="" required list='trunk2'>
				<datalist id="trunk2">
    		 	<option>tata</option>
    		 	<option>reliance</option>
    		 	<option>jio</option>
    		 	<option>vodafone</option>
    		 	<option>airtel</option>
 	        </datalist>
			</td>
			<td class="pt-3-half" style="vertical-align: inherit;"><input type="text"  placeholder="Trunk did" name="trunk_did[<?php echo $cnt;?>]" id="trunk_did[<?php echo $cnt;?>]" maxlength="15" min="0" value="<?php echo $trunk_detail->trunk_did;?>" class="avoid_space"> </td>
			<td class="pt-3-half" style="vertical-align: inherit;" ><input type="text" placeholder="User name" name="username[<?php echo $cnt;?>]" id="username[<?php echo $cnt;?>]" value="<?php echo $trunk_detail->username;?>" class="avoid_space" ></td>
			<td class="pt-3-half" style="vertical-align: inherit;"><input type="password" placeholder="Password" name="password[<?php echo $cnt;?>]" id="password[<?php echo $cnt;?>]" value="<?php echo $trunk_detail->password;?>" class="avoid_space" ></td>
			<td class="pt-3-half" style="vertical-align: inherit;"><input type="text" placeholder="Host" name="host[<?php echo $cnt;?>]" id="host[<?php echo $cnt;?>]" value="<?php echo $trunk_detail->host;?>" class="" required></td>
			<td class="pt-3-half" style="vertical-align: inherit;"><input type="text" placeholder="Port" name="port[<?php echo $cnt;?>]" id="port[<?php echo $cnt;?>]" pattern="^\d{4,5}$" value="<?php echo $trunk_detail->port;?>" class="avoid_space" min="0" required></td>
			<td class="pt-3-half" style="vertical-align: inherit;"><input type="text" placeholder="Domain" name="domain[<?php echo $cnt;?>]" id="domain[<?php echo $cnt;?>]" value="<?php echo $trunk_detail->domain;?>" class="avoid_space" required></td>
			<td class="pt-3-half" style="vertical-align: inherit;">
			<select name="dtmf_mode[<?php echo $cnt;?>]" id="dtmf_mode[<?php echo $cnt;?>]" required>
				<option value="" selected>Select DTMF</option>
				<option value="info" <?php if($trunk_detail->dtmf_mode == 'info'){echo "selected";} ?>>info</option>
				<option value="rfc2833"  <?php if($trunk_detail->dtmf_mode == 'rfc2833'){echo "selected";} ?>>rfc2833</option>
			</select>
			</td>

			<td class="pt-3-half" style="vertical-align: inherit;">
				<select name="nat[<?php echo $cnt;?>]" id="nat[<?php echo $cnt;?>]" class="browser-default custom-select" style="width: 100px;height: 28px;border-radius: 0px;padding: 1px;" required>
					<option value="Y" <?php if($trunk_detail->nat=='Y'){ echo 'selected';}?>>Yes</option>
					<option value="N" <?php if($trunk_detail->nat=='N'){ echo 'selected';}?>>No</option>
				</select></td>
			<td class="pt-3-half" style="vertical-align: inherit;">
				<select  name="directrtp[<?php echo $cnt;?>]" id="directrtp[<?php echo $cnt;?>]" class="browser-default custom-select" style="width: 100px;height: 28px;border-radius: 0px;padding: 1px;" required>
					<option value="Y" <?php if($trunk_detail->directrtp=='Y'){ echo 'selected';}?>>Yes</option>
					<option value="N" <?php if($trunk_detail->directrtp=='N'){ echo 'selected';}?>>No</option>
				</select>
			</td>
			<td class="pt-3-half" style="vertical-align: inherit;">
				<select  name="register_trunk[<?php echo $cnt;?>]" id="register_trunk[<?php echo $cnt;?>]" class="browser-default custom-select" style="width: 105px;height: 28px;border-radius: 0px;padding: 1px;" required>
					<option value="Y" <?php if($trunk_detail->register_trunk=='Y'){ echo 'selected';}?>>Yes</option>
					<option value="N" <?php if($trunk_detail->register_trunk=='N'){ echo 'selected';}?>>No</option>
				</select>
				<input type="hidden" name="old_trunk_id[<?php echo $cnt;?>]" class="old_value_hidden" value="<?php echo $trunk_detail->id;?>">
			</td>

			<td class="pt-3-half" style="vertical-align: inherit;"><input type="text" placeholder="Prefix" name="prefix[<?php echo $cnt;?>]" id="prefix[<?php echo $cnt;?>]" value="<?php echo $trunk_detail->prefix;?>" class="avoid_space"></td>

			<td class="pt-3-half" style="vertical-align: inherit;"><input type="text" placeholder="Failover" name="failover[<?php echo $cnt;?>]" id="failover[<?php echo $cnt;?>]" value="<?php echo $trunk_detail->failover;?>" class="avoid_space"></td>

			<td class="pt-3-half" style="vertical-align: inherit;"><input type="text" placeholder="Ring Duration" name="ringduration[<?php echo $cnt;?>]" id="ringduration[<?php echo $cnt;?>]" value="<?php echo $trunk_detail->ringduration;?>" class="avoid_space" ></td>

			<td class="pt-3-half" style="vertical-align: inherit;"><input type="text" placeholder="CPE IP" name="cpe_ip[<?php echo $cnt;?>]" id="cpe_ip[<?php echo $cnt;?>]" value="<?php echo $trunk_detail->cpe_ip;?>" class="avoid_space"></td>

			<td class="pt-3-half" style="vertical-align: inherit;"><select  name="d2e[<?php echo $cnt;?>]" id="d2e[<?php echo $cnt;?>]" class="browser-default custom-select" style="width: 105px;height: 28px;border-radius: 0px;padding: 1px;">
				<option value="N" <?php if($trunk_detail->d2e=='N'){ echo 'selected';}?>>No</option>
				<option value="Y" <?php if($trunk_detail->d2e=='Y'){ echo 'selected';}?>>Yes</option>
			</select>
		    </td>
  
			</tr>
			<?php
			$cnt++;
		}
	}
	
	?>
	  <tr class="trunk_div">
		<td class="pt-3-half" style="vertical-align: inherit;">
		<a href="#" class="remove-trunk"><i class="fas fa-trash"></i></a>
		</td>
		<td class="pt-3-half" style="vertical-align: inherit;">
			<input type="text" placeholder="Trunk name" name="trunk_name[<?php echo $cnt;?>]" id="trunk_name[<?php echo $cnt;?>]" value="" class="trunkname_first" required list="trunk2">	
 			<datalist id="trunk2">
    		 <option>tata</option>
    		 <option>reliance</option>
    		 <option>jio</option>
    		 <option>vodafone</option>
    		 <option>airtel</option>
 	        </datalist>
		</td>
		<td class="pt-3-half" style="vertical-align: inherit;">
			<input type="text"  placeholder="Trunk did" name="trunk_did[<?php echo $cnt;?>]" id="trunk_did[<?php echo $cnt;?>]" value="" class="avoid_space" >
		</td>
		<td class="pt-3-half" style="vertical-align: inherit;" ><input type="text" placeholder="User name" name="username[<?php echo $cnt;?>]" id="username[<?php echo $cnt;?>]" value="" class="avoid_space"></td>
		<td class="pt-3-half" style="vertical-align: inherit;"><input type="password" placeholder="Password" name="password[<?php echo $cnt;?>]" id="password[<?php echo $cnt;?>]" value="" class="avoid_space"></td>
		<td class="pt-3-half" style="vertical-align: inherit;"><input type="text" placeholder="Host" name="host[<?php echo $cnt;?>]" id="host[<?php echo $cnt;?>]" value="" class="avoid_space" required></td>
		<td class="pt-3-half" style="vertical-align: inherit;"><input type="text" placeholder="Port"  pattern="^\d{4,5}$" name="port[<?php echo $cnt;?>]" id="port[<?php echo $cnt;?>]" value="" class="avoid_space" required></td>
		<td class="pt-3-half" style="vertical-align: inherit;"><input type="text" placeholder="Domain" name="domain[<?php echo $cnt;?>]" id="domain[<?php echo $cnt;?>]" value="" class="avoid_space" required></td>

		 <td class="pt-3-half" style="vertical-align: inherit;">
			<select name="dtmf_mode[<?php echo $cnt;?>]" id="dtmf_mode[<?php echo $cnt;?>]" required>
			<option value="" selected>Select DTMF</option>
			<option value="info">info</option>
			<option value="rfc2833">rfc2833</option>
			</select>
		</td>


		<td class="pt-3-half" style="vertical-align: inherit;"><select name="nat[<?php echo $cnt;?>]" id="nat[<?php echo $cnt;?>]" class="browser-default custom-select" style="width: 100px;height: 28px;border-radius: 0px;padding: 1px;"><option value="Y">Yes</option><option value="N">No</option></select></td>
		<td class="pt-3-half" style="vertical-align: inherit;"><select  name="directrtp[<?php echo $cnt;?>]" id="directrtp[<?php echo $cnt;?>]" class="browser-default custom-select" style="width: 100px;height: 28px;border-radius: 0px;padding: 1px;"><option value="N">No</option><option value="Y">Yes</option></select></td>
		<td class="pt-3-half" style="vertical-align: inherit;"><select  name="register_trunk[<?php echo $cnt;?>]" id="register_trunk[<?php echo $cnt;?>]" class="browser-default custom-select" style="width: 105px;height: 28px;border-radius: 0px;padding: 1px;"><option value="N">No</option><option value="Y">Yes</option></select></td>
	
		<td class="pt-3-half" style="vertical-align: inherit;"><input type="text" placeholder="Prefix" name="prefix[<?php echo $cnt;?>]" id="prefix[<?php echo $cnt;?>]" value="" class="avoid_space"></td>

		<td class="pt-3-half" style="vertical-align: inherit;"><input type="text" placeholder="Failover" name="failover[<?php echo $cnt;?>]" id="failover[<?php echo $cnt;?>]" value="" class="avoid_space"></td>

		<td class="pt-3-half" style="vertical-align: inherit;"><input type="text" placeholder="Ring Duration" name="ringduration[<?php echo $cnt;?>]" id="ringduration[<?php echo $cnt;?>]" value="" class="avoid_space"></td>

		<td class="pt-3-half" style="vertical-align: inherit;"><input type="text" placeholder="CPE IP" name="cpe_ip[<?php echo $cnt;?>]" id="cpe_ip[<?php echo $cnt;?>]" value="" class="avoid_space" ></td>

		<td class="pt-3-half" style="vertical-align: inherit;"><select  name="d2e[<?php echo $cnt;?>]" id="d2e[<?php echo $cnt;?>]" class="browser-default custom-select" style="width: 105px;height: 28px;border-radius: 0px;padding: 1px;" required><option value="N">No</option><option value="Y">Yes</option></select></td>
	

	</tr>

</tbody>
<!-- Table body -->
</table>
</div>
</div>			

<div class="col-md-12" style="text-align: left;"><hr> 
<input type="submit" class="waves-effect waves-dark btn btn-sm btn-primary" name="save_trunk" value="Save">
</div>
</form>
