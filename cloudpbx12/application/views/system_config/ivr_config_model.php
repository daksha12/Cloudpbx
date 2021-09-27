<?php 
$branch_ext = getExtensionData($_SESSION['tenant_id'],$_SESSION['site_id']);

$this->db->where('tenant_id',$_SESSION["tenant_id"]);
$this->db->where('site_id',$_SESSION['site_id']);
$trunkDID=$this->db->get('trunk_master')->result();


$str = ['|','-'];
$rplc =[',',','];
?>

<form class="" style="color: #757575;" method="post" action="<?php echo site_url('System_configuration'); ?>" id="ivr_routing" name="ivr_routing" onsubmit="savedata()" enctype="multipart/form-data">
<div class="row" class="" id="ivr_routing_div">

	<div class="col-md-12">
	      <h5><i class="fas fa-tasks"></i> IVR routing</h5><hr style="margin-top: 5px;margin-bottom: 0;">
	</div>
		
	<div class="col-md-3">
		<select name="trunk_name" id="ivr_trunk_select" class="mdb-select md-form md-outline colorful-select dropdown-primary" style="margin-top: 20px;"> 
			<option value="" disabled selected>Trunk name</option>
			<?php
			if(!empty($trunkList)){
              foreach ($trunkList as $key => $trunk_detail) {
                 ?><option value="<?php echo $trunk_detail->id;?>" <?php if($arrDidRoutingIVR->trunk_id==$trunk_detail->id){ echo 'selected';}?>><?php echo $trunk_detail->trunk_name;?></option><?php
              }
            }
			?>
		</select>
		<label>Trunk Name</label>
	</div>

	<div class="col-md-2">
		<div class="md-form md-outline">
			<!-- <input type="text" name="trunk_did" id="trunk_did"  value="<?php echo $arrDidRoutingIVR->did;?>" class="form-control avoid_space" required>
			<label for="trunk_did">Trunk did</label> -->
			<select name="trunk_did" id="trunk_did" class="mdb-select md-form md-outline colorful-select dropdown-primary" style="margin-top: 20px;" required=""> 
				<option value="" selected>Trunk did</option>

				<?php if(!empty($trunkDID)){foreach ($trunkDID as $value) { ?>             
					<option value="<?php echo $value->trunk_did ?>" <?php if(isset($arrDidRoutingIVR)){if($arrDidRoutingIVR->did==$value->trunk_did){ echo 'selected';}}?>><?php echo $value->trunk_did; ?></option>
				<?php } } ?>

			</select>

		</div>
	</div>

	<div class="col-md-2">
		<div class="md-form md-outline">
		  <input type="time" id="off_start-picker" name="off_start"  value="<?php if(isset($arrDidRoutingIVR)){echo $arrDidRoutingIVR->off_start;}else{echo "00:00";}?>" class="form-control" >
		  <label for="off_start-picker">Office start time</label>
		</div>
	</div>

	<div class="col-md-2">
		<div class="md-form md-outline">
		  <input type="time" id="off_end-picker" name="off_end" value="<?php if(isset($arrDidRoutingIVR)){echo $arrDidRoutingIVR->off_end;}else{echo "23:59";}?>" class="form-control">
		  <label for="off_end-picker">Office end time</label>
		</div>
	</div>

	<?php
	$off_days = $arrDidRoutingIVR->off_days;
	$arr_off_days = array();
	if(!empty($off_days)){
		$arr_off_days = explode("|",$off_days);
	}
	?>
		
	<div class="col-md-3">
		<select class="mdb-select md-form md-outline colorful-select dropdown-primary" name="off_days[]" multiple searchable="Search here.." required id="office_time" data-secondary-text="true">
			<option value="" disabled selected>Click & Select Days</option>
			<option value="mon" <?php if(in_array('mon', $arr_off_days)){ echo 'selected';}?>>Monday</option>
			<option value="tue" <?php if(in_array('tue', $arr_off_days)){ echo 'selected';}?>>Tuesday</option>
			<option value="wed" <?php if(in_array('wed', $arr_off_days)){ echo 'selected';}?>>Wednesday</option>
			<option value="thu" <?php if(in_array('thu', $arr_off_days)){ echo 'selected';}?>>Thursday</option>
			<option value="fri" <?php if(in_array('fri', $arr_off_days)){ echo 'selected';}?>>Friday</option>
			<option value="sat" <?php if(in_array('sat', $arr_off_days)){ echo 'selected';}?>>Saturday</option>
			<option value="sun" <?php if(in_array('sun', $arr_off_days)){ echo 'selected';}?>>Sunday</option>
		</select>
		<label>Office Days</label>
	</div>
		
	<div class="col-md-12">
      <h5><i class="fas fa-tasks"></i> Level detail</h5><hr style="margin-top: 8px;margin-bottom: 10px;">
	</div>

	<div id="table" class="table-editable" style="overflow: scroll;height: 320px">                     
		<div>       
			<table class="table table-bordered table-responsive-md table-striped text-center" id="ivr_routing_master">
				<thead>                        
					<tr>
		
						<th class="text-center">#</th>						
						<th class="text-center">IVR level</th>
						<th class="text-center">IVR prompt file name</th>
						<th class="text-center">Ringing seconds</th>
						<th class="text-center">Choice 1</th>
						<th class="text-center">Choice 1 Type</th>
						<th class="text-center">Choice 2</th>
						<th class="text-center">Choice 2 Type</th>
						<th class="text-center">Choice 3</th>
						<th class="text-center">Choice 3 Type</th>
						<th class="text-center">Choice 4</th>
						<th class="text-center">Choice 4 Type</th>
						<th class="text-center">Choice 5</th>
						<th class="text-center">Choice 5 Type</th>
						<th class="text-center">Choice 6</th>
						<th class="text-center">Choice 6 Type</th>
						<th class="text-center">Choice 7</th>
						<th class="text-center">Choice 7 Type</th>
						<th class="text-center">Choice 8</th>
						<th class="text-center">Choice 8 Type</th>
						<th class="text-center">Choice 9</th>
						<th class="text-center">Choice 9 Type</th>
						<th class="text-center">Default choice</th>
						<th class="text-center">Off time choice</th>
					</tr>
				</thead>
				
				<tbody>
					<?php
					$cntIVR = 1;
					if(!empty($didRoutingIVRList)){   
						foreach ($didRoutingIVRList as $key => $routing_detail) {
							$str = ['|','-'];
                            $rplc =[',',','];
							?>
							<tr class="IVR_did_div">
								<td class="pt-3-half" style="vertical-align: inherit;">
									<a href="#" class="remove-ivr"><i class="fas fa-trash"></i></a>
								</td>
								<td class="pt-3-half" style="vertical-align: inherit;">
									<input type="text" name="ivr_level[<?php echo $cntIVR;?>]" placeholder="Level" value="<?php echo $routing_detail->ivr_level;?>" class="" required>
								</td>
								<td class="pt-3-half" style="vertical-align: inherit;">
									<input type="hidden" name="IVR_Prompt_old[<?php echo $cntIVR;?>]" value="<?php echo $routing_detail->IVR_Prompt_file;?>">

									<input type="file" name="IVR_Prompt_file[<?php echo $cntIVR;?>]" placeholder="IVR Prompt file" value="<?php echo $routing_detail->IVR_Prompt_file;?>" class="" style="width: 200px;height: 28px;border-radius: 0px;padding: 1px;font-size: 12px" <?php if($routing_detail->IVR_Prompt_file == '') {echo 'required';} ?>>
									
									<hr style="margin-top: 1px;margin-bottom: 1px;">

							        <audio controls preload="none" controlsList="download" style="height: 40px"><source src='<?php echo ivr_path.$routing_detail->IVR_Prompt_file.'.wav' ?>' type="audio/mpeg"></audio>
								</td>
								<td class="pt-3-half" style="vertical-align: inherit;">
									<input type="text" name="ringingseconds[<?php echo $cntIVR;?>]" placeholder="Ringing seconds" value="<?php echo $routing_detail->ringingseconds;?>" class="avoid_space" pattern="^[0-9]*$">
								</td>

								<!--td class="pt-3-half" style="vertical-align: inherit;">
									<input type="text" name="choice1[<?php echo $cntIVR;?>]" id="choice1[<?php echo $cntIVR;?>]" placeholder="choice1" value="<?php echo str_replace($str,$rplc, $routing_detail->choice1);?>" class="">
								</td-->

								<?php 
								$ext = str_replace($str,$rplc, $routing_detail->choice1); 
								$ext_arr = explode(',', $ext);                      
								?>

								<td class="pt-3-half" style="vertical-align: inherit;">
								<select class="colorful-select dropdown-primary trunkdid_trunk_select" name="choice1-<?php echo $cntIVR;?>[]" multiple style="width: 150px !important;" >
								<option value="" selected="">Select Extension</option>
								<option value="level1" <?php if(in_array('level1', $ext_arr) == '1'){echo "selected"; } ?> >level1
								<option value="level2" <?php if(in_array('level2', $ext_arr) == '1'){echo "selected"; } ?> >level2
								<option value="level3" <?php if(in_array('level3', $ext_arr) == '1'){echo "selected"; } ?> >level3
								<option value="level4" <?php if(in_array('level4', $ext_arr) == '1'){echo "selected"; } ?> >level4
								<option value="level5" <?php if(in_array('level5', $ext_arr) == '1'){echo "selected"; } ?> >level5
								<?php foreach ($branch_ext as $value) { ?>             
								<option value="<?php echo $value->extension ?>" <?php if(in_array($value->extension, $ext_arr) == '1'){echo "selected"; } ?> ><?php echo $value->extension ?></option>
								<?php } ?>
								</option>
								</select>
								</td>

								<td class="pt-3-half" style="vertical-align: inherit;">
								  <select name="choice1_type[<?php echo $cntIVR;?>]">
								 	<option value="" selected>Select Type</option>
									<option value="sequential" <?php if($routing_detail->choice1_type == 'sequential'){echo "selected";} ?>>Sequential</option>
									<option value="simultaneous"  <?php if($routing_detail->choice1_type == 'simultaneous'){echo "selected";} ?>>Simultaneous</option>
								  </select>
								</td> 
								<!--td class="pt-3-half" style="vertical-align: inherit;">
									<input type="text" name="choice2[<?php echo $cntIVR;?>]" id="choice2[<?php echo $cntIVR;?>]" value="<?php echo str_replace($str,$rplc, $routing_detail->choice2);?>" placeholder="choice2">
								</td-->

								<?php 
								$ext = str_replace($str,$rplc, $routing_detail->choice2); 
								$ext_arr = explode(',', $ext);                      
								?>

								<td class="pt-3-half" style="vertical-align: inherit;">
								<select class="colorful-select dropdown-primary trunkdid_trunk_select" name="choice2-<?php echo $cntIVR;?>[]" multiple style="width: 150px !important;">
								<option value="" selected="">Select Extension</option>
								<option value="level1" <?php if(in_array('level1', $ext_arr) == '1'){echo "selected"; } ?> >level1
								<option value="level2" <?php if(in_array('level2', $ext_arr) == '1'){echo "selected"; } ?> >level2
								<option value="level3" <?php if(in_array('level3', $ext_arr) == '1'){echo "selected"; } ?> >level3
								<option value="level4" <?php if(in_array('level4', $ext_arr) == '1'){echo "selected"; } ?> >level4
								<option value="level5" <?php if(in_array('level5', $ext_arr) == '1'){echo "selected"; } ?> >level5
								<?php foreach ($branch_ext as $value) { ?>             
								<option value="<?php echo $value->extension ?>" <?php if(in_array($value->extension, $ext_arr) == '1'){echo "selected"; } ?> ><?php echo $value->extension ?></option>
								<?php } ?>
								</select>
								</td>

								<td class="pt-3-half" style="vertical-align: inherit;">
								  <select name="choice2_type[<?php echo $cntIVR;?>]">
								 	<option value="" selected>Select Type</option>
									<option value="sequential" <?php if($routing_detail->choice2_type == 'sequential'){echo "selected";} ?>>Sequential</option>
									<option value="simultaneous"  <?php if($routing_detail->choice2_type == 'simultaneous'){echo "selected";} ?>>Simultaneous</option>
								  </select>
								</td>
								<!--td class="pt-3-half" style="vertical-align: inherit;">
									<input type="text" name="choice3[<?php echo $cntIVR;?>]" id="choice3[<?php echo $cntIVR;?>]" value="<?php echo str_replace($str,$rplc, $routing_detail->choice3);?>" placeholder="choice3">
								</td-->

								<?php 
								$ext = str_replace($str,$rplc, $routing_detail->choice3); 
								$ext_arr = explode(',', $ext);                      
								?>

								<td class="pt-3-half" style="vertical-align: inherit;">
								<select class="colorful-select dropdown-primary trunkdid_trunk_select" name="choice3-<?php echo $cntIVR;?>[]" multiple style="width: 150px !important;">
								<option value="" selected="">Select Extension</option>
								<option value="level1" <?php if(in_array('level1', $ext_arr) == '1'){echo "selected"; } ?> >level1
								<option value="level2" <?php if(in_array('level2', $ext_arr) == '1'){echo "selected"; } ?> >level2
								<option value="level3" <?php if(in_array('level3', $ext_arr) == '1'){echo "selected"; } ?> >level3
								<option value="level4" <?php if(in_array('level4', $ext_arr) == '1'){echo "selected"; } ?> >level4
								<option value="level5" <?php if(in_array('level5', $ext_arr) == '1'){echo "selected"; } ?> >level5
								<?php foreach ($branch_ext as $value) { ?>             
								<option value="<?php echo $value->extension ?>" <?php if(in_array($value->extension, $ext_arr) == '1'){echo "selected"; } ?> ><?php echo $value->extension ?></option>
								<?php } ?>
								</select>
								</td>

								<td class="pt-3-half" style="vertical-align: inherit;">
								  <select name="choice3_type[<?php echo $cntIVR;?>]">
								 	<option value="" selected>Select Type</option>
									<option value="sequential" <?php if($routing_detail->choice3_type == 'sequential'){echo "selected";} ?>>Sequential</option>
									<option value="simultaneous"  <?php if($routing_detail->choice3_type == 'simultaneous'){echo "selected";} ?>>Simultaneous</option>
								  </select>
								</td>
								<!--td class="pt-3-half" style="vertical-align: inherit;">
									<input type="text" name="choice4[<?php echo $cntIVR;?>]" id="choice4[<?php echo $cntIVR;?>]" value="<?php echo str_replace($str,$rplc, $routing_detail->choice4);?>" placeholder="choice4">
								</td-->

								<?php 
								$ext = str_replace($str,$rplc, $routing_detail->choice4); 
								$ext_arr = explode(',', $ext);                      
								?>

								<td class="pt-3-half" style="vertical-align: inherit;">
								<select class="colorful-select dropdown-primary trunkdid_trunk_select" name="choice4-<?php echo $cntIVR;?>[]" multiple style="width: 150px !important;">
								<option value="" selected="">Select Extension</option>
								<option value="level1" <?php if(in_array('level1', $ext_arr) == '1'){echo "selected"; } ?> >level1
								<option value="level2" <?php if(in_array('level2', $ext_arr) == '1'){echo "selected"; } ?> >level2
								<option value="level3" <?php if(in_array('level3', $ext_arr) == '1'){echo "selected"; } ?> >level3
								<option value="level4" <?php if(in_array('level4', $ext_arr) == '1'){echo "selected"; } ?> >level4
								<option value="level5" <?php if(in_array('level5', $ext_arr) == '1'){echo "selected"; } ?> >level5
								<?php foreach ($branch_ext as $value) { ?>             
								<option value="<?php echo $value->extension ?>" <?php if(in_array($value->extension, $ext_arr) == '1'){echo "selected"; } ?> ><?php echo $value->extension ?></option>
								<?php } ?>
								</select>
								</td>

								<td class="pt-3-half" style="vertical-align: inherit;">
								  <select name="choice4_type[<?php echo $cntIVR;?>]">
								 	<option value="" selected>Select Type</option>
									<option value="sequential" <?php if($routing_detail->choice4_type == 'sequential'){echo "selected";} ?>>Sequential</option>
									<option value="simultaneous"  <?php if($routing_detail->choice4_type == 'simultaneous'){echo "selected";} ?>>Simultaneous</option>
								  </select>
								</td>
								<!--td class="pt-3-half" style="vertical-align: inherit;">
									<input type="text" name="choice5[<?php echo $cntIVR;?>]" id="choice5[<?php echo $cntIVR;?>]" value="<?php echo str_replace($str,$rplc, $routing_detail->choice5);?>" placeholder="choice5">
								</td-->
								
								<?php 
								$ext = str_replace($str,$rplc, $routing_detail->choice5); 
								$ext_arr = explode(',', $ext);                      
								?>

								<td class="pt-3-half" style="vertical-align: inherit;">
								<select class="colorful-select dropdown-primary trunkdid_trunk_select" name="choice5-<?php echo $cntIVR;?>[]" multiple style="width: 150px !important;">
								<option value="" selected="">Select Extension</option>
								<option value="level1" <?php if(in_array('level1', $ext_arr) == '1'){echo "selected"; } ?> >level1
								<option value="level2" <?php if(in_array('level2', $ext_arr) == '1'){echo "selected"; } ?> >level2
								<option value="level3" <?php if(in_array('level3', $ext_arr) == '1'){echo "selected"; } ?> >level3
								<option value="level4" <?php if(in_array('level4', $ext_arr) == '1'){echo "selected"; } ?> >level4
								<option value="level5" <?php if(in_array('level5', $ext_arr) == '1'){echo "selected"; } ?> >level5
								<?php foreach ($branch_ext as $value) { ?>             
								<option value="<?php echo $value->extension ?>" <?php if(in_array($value->extension, $ext_arr) == '1'){echo "selected"; } ?> ><?php echo $value->extension ?></option>
								<?php } ?>
								</select>
								</td>

								<td class="pt-3-half" style="vertical-align: inherit;">
								  <select name="choice5_type[<?php echo $cntIVR;?>]">
								 	<option value="" selected>Select Type</option>
									<option value="sequential" <?php if($routing_detail->choice5_type == 'sequential'){echo "selected";} ?>>Sequential</option>
									<option value="simultaneous"  <?php if($routing_detail->choice5_type == 'simultaneous'){echo "selected";} ?>>Simultaneous</option>
								  </select>
								</td>
								<!--td class="pt-3-half" style="vertical-align: inherit;">
									<input type="text" name="choice6[<?php echo $cntIVR;?>]" id="choice6[<?php echo $cntIVR;?>]" value="<?php echo str_replace($str,$rplc, $routing_detail->choice6);?>" placeholder="choice6">
								</td-->

								<?php 
								$ext = str_replace($str,$rplc, $routing_detail->choice6); 
								$ext_arr = explode(',', $ext);                      
								?>

								<td class="pt-3-half" style="vertical-align: inherit;">
								<select class="colorful-select dropdown-primary trunkdid_trunk_select" name="choice6-<?php echo $cntIVR;?>[]" multiple style="width: 150px !important;">
								<option value="" selected="">Select Extension</option>
								<option value="level1" <?php if(in_array('level1', $ext_arr) == '1'){echo "selected"; } ?> >level1
								<option value="level2" <?php if(in_array('level2', $ext_arr) == '1'){echo "selected"; } ?> >level2
								<option value="level3" <?php if(in_array('level3', $ext_arr) == '1'){echo "selected"; } ?> >level3
								<option value="level4" <?php if(in_array('level4', $ext_arr) == '1'){echo "selected"; } ?> >level4
								<option value="level5" <?php if(in_array('level5', $ext_arr) == '1'){echo "selected"; } ?> >level5
								<?php foreach ($branch_ext as $value) { ?>             
								<option value="<?php echo $value->extension ?>" <?php if(in_array($value->extension, $ext_arr) == '1'){echo "selected"; } ?> ><?php echo $value->extension ?></option>
								<?php } ?>
								</select>
								</td>

								<td class="pt-3-half" style="vertical-align: inherit;">
								  <select name="choice6_type[<?php echo $cntIVR;?>]">
								 	<option value="" selected>Select Type</option>
									<option value="sequential" <?php if($routing_detail->choice6_type == 'sequential'){echo "selected";} ?>>Sequential</option>
									<option value="simultaneous"  <?php if($routing_detail->choice6_type == 'simultaneous'){echo "selected";} ?>>Simultaneous</option>
								  </select>
								</td>
								<!--td class="pt-3-half" style="vertical-align: inherit;">
									<input type="text" name="choice7[<?php echo $cntIVR;?>]" id="choice7[<?php echo $cntIVR;?>]" value="<?php echo str_replace($str,$rplc, $routing_detail->choice7);?>" placeholder="choice7">
								</td-->

								<?php 
								$ext = str_replace($str,$rplc, $routing_detail->choice7); 
								$ext_arr = explode(',', $ext);                      
								?>

								<td class="pt-3-half" style="vertical-align: inherit;">
								<select class="colorful-select dropdown-primary trunkdid_trunk_select" name="choice7-<?php echo $cntIVR;?>[]" multiple style="width: 150px !important;">
								<option value="" selected="">Select Extension</option>
								<option value="level1" <?php if(in_array('level1', $ext_arr) == '1'){echo "selected"; } ?> >level1
								<option value="level2" <?php if(in_array('level2', $ext_arr) == '1'){echo "selected"; } ?> >level2
								<option value="level3" <?php if(in_array('level3', $ext_arr) == '1'){echo "selected"; } ?> >level3
								<option value="level4" <?php if(in_array('level4', $ext_arr) == '1'){echo "selected"; } ?> >level4
								<option value="level5" <?php if(in_array('level5', $ext_arr) == '1'){echo "selected"; } ?> >level5
								<?php foreach ($branch_ext as $value) { ?>             
								<option value="<?php echo $value->extension ?>" <?php if(in_array($value->extension, $ext_arr) == '1'){echo "selected"; } ?> ><?php echo $value->extension ?></option>
								<?php } ?>
								</select>
								</td>

								<td class="pt-3-half" style="vertical-align: inherit;">
								  <select name="choice7_type[<?php echo $cntIVR;?>]">
								 	<option value="" selected>Select Type</option>
									<option value="sequential" <?php if($routing_detail->choice7_type == 'sequential'){echo "selected";} ?>>Sequential</option>
									<option value="simultaneous"  <?php if($routing_detail->choice7_type == 'simultaneous'){echo "selected";} ?>>Simultaneous</option>
								  </select>
								</td>
								<!--td class="pt-3-half" style="vertical-align: inherit;">
									<input type="text" name="choice8[<?php echo $cntIVR;?>]" id="choice8[<?php echo $cntIVR;?>]" value="<?php echo str_replace($str,$rplc, $routing_detail->choice8);?>" placeholder="choice8">
								</td-->

								<?php 
								$ext = str_replace($str,$rplc, $routing_detail->choice8); 
								$ext_arr = explode(',', $ext);                      
								?>

								<td class="pt-3-half" style="vertical-align: inherit;">
								<select class="colorful-select dropdown-primary trunkdid_trunk_select" name="choice8-<?php echo $cntIVR;?>[]" multiple style="width: 150px !important;">
								<option value="" selected="">Select Extension</option>
								<option value="level1" <?php if(in_array('level1', $ext_arr) == '1'){echo "selected"; } ?> >level1
								<option value="level2" <?php if(in_array('level2', $ext_arr) == '1'){echo "selected"; } ?> >level2
								<option value="level3" <?php if(in_array('level3', $ext_arr) == '1'){echo "selected"; } ?> >level3
								<option value="level4" <?php if(in_array('level4', $ext_arr) == '1'){echo "selected"; } ?> >level4
								<option value="level5" <?php if(in_array('level5', $ext_arr) == '1'){echo "selected"; } ?> >level5
								<?php foreach ($branch_ext as $value) { ?>             
								<option value="<?php echo $value->extension ?>" <?php if(in_array($value->extension, $ext_arr) == '1'){echo "selected"; } ?> ><?php echo $value->extension ?></option>
								<?php } ?>
								</select>
								</td>

								<td class="pt-3-half" style="vertical-align: inherit;">
								  <select name="choice8_type[<?php echo $cntIVR;?>]">
								 	<option value="" selected>Select Type</option>
									<option value="sequential" <?php if($routing_detail->choice8_type == 'sequential'){echo "selected";} ?>>Sequential</option>
									<option value="simultaneous"  <?php if($routing_detail->choice8_type == 'simultaneous'){echo "selected";} ?>>Simultaneous</option>
								  </select>
								</td> 
								<!--td class="pt-3-half" style="vertical-align: inherit;">
									<input type="text" name="choice9[<?php echo $cntIVR;?>]" id="choice9[<?php echo $cntIVR;?>]" value="<?php echo str_replace($str,$rplc, $routing_detail->choice9);?>" placeholder="choice9">
								</td-->

								<?php 
								$ext = str_replace($str,$rplc, $routing_detail->choice9); 
								$ext_arr = explode(',', $ext);                      
								?>

								<td class="pt-3-half" style="vertical-align: inherit;">
								<select class="colorful-select dropdown-primary trunkdid_trunk_select" name="choice9-<?php echo $cntIVR;?>[]" multiple style="width: 150px !important;">
								<option value="" selected="">Select Extension</option>
								<option value="level1" <?php if(in_array('level1', $ext_arr) == '1'){echo "selected"; } ?> >level1
								<option value="level2" <?php if(in_array('level2', $ext_arr) == '1'){echo "selected"; } ?> >level2
								<option value="level3" <?php if(in_array('level3', $ext_arr) == '1'){echo "selected"; } ?> >level3
								<option value="level4" <?php if(in_array('level4', $ext_arr) == '1'){echo "selected"; } ?> >level4
								<option value="level5" <?php if(in_array('level5', $ext_arr) == '1'){echo "selected"; } ?> >level5
								<?php foreach ($branch_ext as $value) { ?>             
								<option value="<?php echo $value->extension ?>" <?php if(in_array($value->extension, $ext_arr) == '1'){echo "selected"; } ?> ><?php echo $value->extension ?></option>
								<?php } ?>
								</select>
								</td>

								<td class="pt-3-half" style="vertical-align: inherit;">
								  <select name="choice9_type[<?php echo $cntIVR;?>]">
								 	<option value="" selected>Select Type</option>
									<option value="sequential" <?php if($routing_detail->choice9_type == 'sequential'){echo "selected";} ?>>Sequential</option>
									<option value="simultaneous"  <?php if($routing_detail->choice9_type == 'simultaneous'){echo "selected";} ?>>Simultaneous</option>
								  </select>
								</td>
								<td class="pt-3-half" style="vertical-align: inherit;">
									<!-- <input type="text" name="default_choice[<?php echo $cntIVR;?>]" value="<?php echo $routing_detail->default_choice;?>" placeholder="default_choice" required> -->
									<select name="default_choice[<?php echo $cntIVR;?>]" class="colorful-select dropdown-primary trunkdid_trunk_select" required=""> 
										<option value="" disabled selected>Default Choice</option>

										<?php foreach ($branch_ext as $value) {?>             
											<option value="<?php echo $value->extension ?>" <?php if($routing_detail->default_choice == $value->extension){echo "selected";}?>><?php echo $value->extension ?></option>
										<?php } ?>
									

							</select>
								</td>
								<td class="pt-3-half" style="vertical-align: inherit;">
									<input type="text" name="off_time_choice[<?php echo $cntIVR;?>]" value="<?php echo $routing_detail->off_time_choice;?>" placeholder="off_time_choice">
									<input type="hidden" name="old_did_ivr_id[<?php echo $cntIVR;?>]" class="old_value_hidden" value="<?php echo $routing_detail->id;?>">
								</td>
							</tr><?php
							$cntIVR++;
						}
					}
					?>
					<tr class="IVR_did_div">
						<td class="pt-3-half" style="vertical-align: inherit;"><a href="#" class="remove-ivr"><i class="fas fa-trash"></i></a></td>
						<td class="pt-3-half" style="vertical-align: inherit;"><input type="text" name="ivr_level[<?php echo $cntIVR;?>]"  placeholder="Level" value="" class="IVR_first" required></td>

						<td class="pt-3-half" style="vertical-align: left !important;"><input type="file" name="IVR_Prompt_file[<?php echo $cntIVR;?>]" placeholder="IVR Prompt file" value="" class="" style="width: 200px;height: 28px;border-radius: 0px;padding: 1px;font-size: 12px">
						</td>
						
						<td class="pt-3-half" style="vertical-align: inherit;"><input type="text" name="ringingseconds[<?php echo $cntIVR;?>]" placeholder="Ringing seconds" value="" class="avoid_space" pattern="^[0-9]*$"></td>
						
						<!--td class="pt-3-half" style="vertical-align: inherit;"><input type="text" name="choice1[<?php echo $cntIVR;?>]" id="choice1[<?php echo $cntIVR;?>]" placeholder="choice1" value="" class=""></td-->
						
						<td class="pt-3-half" style="vertical-align: inherit;">
						<select class="colorful-select dropdown-primary trunkdid_trunk_select" name="choice1-<?php echo $cntIVR;?>[]" multiple style="width: 150px !important;">
						<option value="" selected="">Select Extension</option>
						<option value="level1" <?php if(in_array('level1', $ext_arr) == '1'){echo "selected"; } ?> >level1
								<option value="level2" <?php if(in_array('level2', $ext_arr) == '1'){echo "selected"; } ?> >level2
								<option value="level3" <?php if(in_array('level3', $ext_arr) == '1'){echo "selected"; } ?> >level3
								<option value="level4" <?php if(in_array('level4', $ext_arr) == '1'){echo "selected"; } ?> >level4
								<option value="level5" <?php if(in_array('level5', $ext_arr) == '1'){echo "selected"; } ?> >level5	
						<?php foreach ($branch_ext as $value) {?>             
						<option value="<?php echo $value->extension ?>"><?php echo $value->extension ?></option>
						<?php } ?>
						</select>
						</td>
						
						<td class="pt-3-half" style="vertical-align: inherit;">
							<select name="choice1_type[<?php echo $cntIVR;?>]">
								<option value="">Select Type</option>
								<option value="sequential">Sequential</option>
								<option value="simultaneous">Simultaneous</option>
							</select>
						</td>
						
						<!--td class="pt-3-half" style="vertical-align: inherit;"><input type="text" name="choice2[<?php echo $cntIVR;?>]" id="choice2[<?php echo $cntIVR;?>]" placeholder="choice2"></td-->

						<td class="pt-3-half" style="vertical-align: inherit;">
						<select class="colorful-select dropdown-primary trunkdid_trunk_select" name="choice2-<?php echo $cntIVR;?>[]" multiple style="width: 150px !important;">
							<option value="level1" <?php if(in_array('level1', $ext_arr) == '1'){echo "selected"; } ?> >level1
								<option value="level2" <?php if(in_array('level2', $ext_arr) == '1'){echo "selected"; } ?> >level2
								<option value="level3" <?php if(in_array('level3', $ext_arr) == '1'){echo "selected"; } ?> >level3
								<option value="level4" <?php if(in_array('level4', $ext_arr) == '1'){echo "selected"; } ?> >level4
								<option value="level5" <?php if(in_array('level5', $ext_arr) == '1'){echo "selected"; } ?> >level5
						<option value="" selected="">Select Extension</option>
						<?php foreach ($branch_ext as $value) {?>             
						<option value="<?php echo $value->extension ?>"><?php echo $value->extension ?></option>
						<?php } ?>
						</select>
						</td>

						<td class="pt-3-half" style="vertical-align: inherit;">
							<select name="choice2_type[<?php echo $cntIVR;?>]" >
								<option value="">Select Type</option>
								<option value="sequential">Sequential</option>
								<option value="simultaneous">Simultaneous</option>
							</select>
						</td>
						
						<!--td class="pt-3-half" style="vertical-align: inherit;"><input type="text" name="choice3[<?php echo $cntIVR;?>]" id="choice3[<?php echo $cntIVR;?>]" placeholder="choice3"></td-->
						
						<td class="pt-3-half" style="vertical-align: inherit;">
						<select class="colorful-select dropdown-primary trunkdid_trunk_select" name="choice3-<?php echo $cntIVR;?>[]" multiple style="width: 150px !important;">
							<option value="level1" <?php if(in_array('level1', $ext_arr) == '1'){echo "selected"; } ?> >level1
								<option value="level2" <?php if(in_array('level2', $ext_arr) == '1'){echo "selected"; } ?> >level2
								<option value="level3" <?php if(in_array('level3', $ext_arr) == '1'){echo "selected"; } ?> >level3
								<option value="level4" <?php if(in_array('level4', $ext_arr) == '1'){echo "selected"; } ?> >level4
								<option value="level5" <?php if(in_array('level5', $ext_arr) == '1'){echo "selected"; } ?> >level5
						<option value="" selected="">Select Extension</option>
						<?php foreach ($branch_ext as $value) {?>             
						<option value="<?php echo $value->extension ?>"><?php echo $value->extension ?></option>
						<?php } ?>
						</select>
						</td>

						<td class="pt-3-half" style="vertical-align: inherit;">
							<select name="choice3_type[<?php echo $cntIVR;?>]">
								<option value="">Select Type</option>
								<option value="sequential">Sequential</option>
								<option value="simultaneous">Simultaneous</option>
							</select>
						</td>

						<td class="pt-3-half" style="vertical-align: inherit;">
						<select class="colorful-select dropdown-primary trunkdid_trunk_select" name="choice4-<?php echo $cntIVR;?>[]" multiple style="width: 150px !important;">
						<option value="" selected="">Select Extension</option>
						<option value="level1" <?php if(in_array('level1', $ext_arr) == '1'){echo "selected"; } ?> >level1
								<option value="level2" <?php if(in_array('level2', $ext_arr) == '1'){echo "selected"; } ?> >level2
								<option value="level3" <?php if(in_array('level3', $ext_arr) == '1'){echo "selected"; } ?> >level3
								<option value="level4" <?php if(in_array('level4', $ext_arr) == '1'){echo "selected"; } ?> >level4
								<option value="level5" <?php if(in_array('level5', $ext_arr) == '1'){echo "selected"; } ?> >level5
						<?php foreach ($branch_ext as $value) {?>             
						<option value="<?php echo $value->extension ?>"><?php echo $value->extension ?></option>
						<?php } ?>
						</select>
						</td>

						
						<td class="pt-3-half" style="vertical-align: inherit;">
							<select name="choice4_type[<?php echo $cntIVR;?>]" >
								<option value="">Select Type</option>
								<option value="sequential">Sequential</option>
								<option value="simultaneous">Simultaneous</option>
							</select>
						</td>
						
						<!--td class="pt-3-half" style="vertical-align: inherit;"><input type="text" name="choice5[<?php echo $cntIVR;?>]" id="choice5[<?php echo $cntIVR;?>]" placeholder="choice5"></td-->

						<td class="pt-3-half" style="vertical-align: inherit;">
						<select class="colorful-select dropdown-primary trunkdid_trunk_select" name="choice5-<?php echo $cntIVR;?>[]" multiple style="width: 150px !important;">
						<option value="" selected="">Select Extension</option>
						<option value="level1" <?php if(in_array('level1', $ext_arr) == '1'){echo "selected"; } ?> >level1
								<option value="level2" <?php if(in_array('level2', $ext_arr) == '1'){echo "selected"; } ?> >level2
								<option value="level3" <?php if(in_array('level3', $ext_arr) == '1'){echo "selected"; } ?> >level3
								<option value="level4" <?php if(in_array('level4', $ext_arr) == '1'){echo "selected"; } ?> >level4
								<option value="level5" <?php if(in_array('level5', $ext_arr) == '1'){echo "selected"; } ?> >level5
						<?php foreach ($branch_ext as $value) {?>             
						<option value="<?php echo $value->extension ?>"><?php echo $value->extension ?></option>
						<?php } ?>
						</select>
						</td>
						
						<td class="pt-3-half" style="vertical-align: inherit;">
							<select name="choice5_type[<?php echo $cntIVR;?>]">
								<option value="">Select Type</option>
								<option value="sequential">Sequential</option>
								<option value="simultaneous">Simultaneous</option>
							</select>
						</td>
						
						<!--td class="pt-3-half" style="vertical-align: inherit;"><input type="text" name="choice6[<?php echo $cntIVR;?>]" id="choice6[<?php echo $cntIVR;?>]" placeholder="choice6"></td-->

						<td class="pt-3-half" style="vertical-align: inherit;">
						<select class="colorful-select dropdown-primary trunkdid_trunk_select" name="choice6-<?php echo $cntIVR;?>[]" multiple style="width: 150px !important;">
						<option value="" selected="">Select Extension</option>
						<option value="level1" <?php if(in_array('level1', $ext_arr) == '1'){echo "selected"; } ?> >level1
								<option value="level2" <?php if(in_array('level2', $ext_arr) == '1'){echo "selected"; } ?> >level2
								<option value="level3" <?php if(in_array('level3', $ext_arr) == '1'){echo "selected"; } ?> >level3
								<option value="level4" <?php if(in_array('level4', $ext_arr) == '1'){echo "selected"; } ?> >level4
								<option value="level5" <?php if(in_array('level5', $ext_arr) == '1'){echo "selected"; } ?> >level5
						<?php foreach ($branch_ext as $value) {?>             
						<option value="<?php echo $value->extension ?>"><?php echo $value->extension ?></option>
						<?php } ?>
						</select>
						</td>
				
						<td class="pt-3-half" style="vertical-align: inherit;">
							<select name="choice6_type[<?php echo $cntIVR;?>]" >
								<option value="">Select Type</option>
								<option value="sequential">Sequential</option>
								<option value="simultaneous">Simultaneous</option>
							</select>
						</td>
				
						<!--td class="pt-3-half" style="vertical-align: inherit;"><input type="text" name="choice7[<?php echo $cntIVR;?>]" id="choice7[<?php echo $cntIVR;?>]" placeholder="choice7"></td-->


					<td class="pt-3-half" style="vertical-align: inherit;">
						<select class="colorful-select dropdown-primary trunkdid_trunk_select" name="choice7-<?php echo $cntIVR;?>[]" multiple style="width: 150px !important;">
						<option value="" selected="">Select Extension</option>
						<option value="level1" <?php if(in_array('level1', $ext_arr) == '1'){echo "selected"; } ?> >level1
								<option value="level2" <?php if(in_array('level2', $ext_arr) == '1'){echo "selected"; } ?> >level2
								<option value="level3" <?php if(in_array('level3', $ext_arr) == '1'){echo "selected"; } ?> >level3
								<option value="level4" <?php if(in_array('level4', $ext_arr) == '1'){echo "selected"; } ?> >level4
								<option value="level5" <?php if(in_array('level5', $ext_arr) == '1'){echo "selected"; } ?> >level5
						<?php foreach ($branch_ext as $value) {?>             
						<option value="<?php echo $value->extension ?>"><?php echo $value->extension ?></option>
						<?php } ?>
						</select>
						</td>

						<td class="pt-3-half" style="vertical-align: inherit;">
							<select name="choice7_type[<?php echo $cntIVR;?>]">
								<option value="">Select Type</option>
								<option value="sequential">Sequential</option>
								<option value="simultaneous">Simultaneous</option>
							</select>
						</td>
						
						<!--td class="pt-3-half" style="vertical-align: inherit;"><input type="text" name="choice8[<?php echo $cntIVR;?>]" id="choice8[<?php echo $cntIVR;?>]" placeholder="choice8"></td--->

						<td class="pt-3-half" style="vertical-align: inherit;">
						<select class="colorful-select dropdown-primary trunkdid_trunk_select" name="choice8-<?php echo $cntIVR;?>[]" multiple style="width: 150px !important;">
						<option value="" selected="">Select Extension</option>
						<option value="level1" <?php if(in_array('level1', $ext_arr) == '1'){echo "selected"; } ?> >level1
								<option value="level2" <?php if(in_array('level2', $ext_arr) == '1'){echo "selected"; } ?> >level2
								<option value="level3" <?php if(in_array('level3', $ext_arr) == '1'){echo "selected"; } ?> >level3
								<option value="level4" <?php if(in_array('level4', $ext_arr) == '1'){echo "selected"; } ?> >level4
								<option value="level5" <?php if(in_array('level5', $ext_arr) == '1'){echo "selected"; } ?> >level5
						<?php foreach ($branch_ext as $value) {?>             
						<option value="<?php echo $value->extension ?>"><?php echo $value->extension ?></option>
						<?php } ?>
						</select>
						</td>

						<td class="pt-3-half" style="vertical-align: inherit;">
							<select name="choice8_type[<?php echo $cntIVR;?>]">
								<option value="">Select Type</option>
								<option value="sequential">Sequential</option>
								<option value="simultaneous">Simultaneous</option>
							</select>
						</td>

						<!--td class="pt-3-half" style="vertical-align: inherit;"><input type="text" name="choice9[<?php echo $cntIVR;?>]" id="choice9[<?php echo $cntIVR;?>]" placeholder="choice9"></td-->

						<td class="pt-3-half" style="vertical-align: inherit;">
						<select class="colorful-select dropdown-primary trunkdid_trunk_select" name="choice9-<?php echo $cntIVR;?>[]" multiple style="width: 150px !important;">
						<option value="" selected="">Select Extension</option>
						<option value="level1" <?php if(in_array('level1', $ext_arr) == '1'){echo "selected"; } ?> >level1
								<option value="level2" <?php if(in_array('level2', $ext_arr) == '1'){echo "selected"; } ?> >level2
								<option value="level3" <?php if(in_array('level3', $ext_arr) == '1'){echo "selected"; } ?> >level3
								<option value="level4" <?php if(in_array('level4', $ext_arr) == '1'){echo "selected"; } ?> >level4
								<option value="level5" <?php if(in_array('level5', $ext_arr) == '1'){echo "selected"; } ?> >level5
						<?php foreach ($branch_ext as $value) {?>             
						<option value="<?php echo $value->extension ?>"><?php echo $value->extension ?></option>
						<?php } ?>
						</select>
						</td>

						<td class="pt-3-half" style="vertical-align: inherit;">
							<select name="choice9_type[<?php echo $cntIVR;?>]">
								<option value="">Select Type</option>
								<option value="sequential">Sequential</option>
								<option value="simultaneous">Simultaneous</option>
							</select>
						</td>
						<td class="pt-3-half" style="vertical-align: inherit;">
							<!-- <input type="text" name="default_choice[<?php echo $cntIVR;?>]" placeholder="default_choice" required> -->
							<select name="default_choice[<?php echo $cntIVR;?>]" class="colorful-select dropdown-primary trunkdid_trunk_select" required=""> 
								<option value="" disabled selected>Default Choice</option>

								<?php foreach ($branch_ext as $value) {?>             
									<option value="<?php echo $value->extension ?>"><?php echo $value->extension ?></option>
								<?php } ?>
									

							</select>

						</td>
						<td class="pt-3-half" style="vertical-align: inherit;"><input type="text" name="off_time_choice[<?php echo $cntIVR;?>]" placeholder="off_time_choice"></td>
					</tr>
				</tbody>                                                
			</table>
		</div>
	</div>
	<div class="col-md-12"><hr style="margin-top: 8px;margin-bottom: 10px;" > 
	<input type="submit" class="waves-effect waves-dark btn btn-sm btn-primary" name="save_IVR_did_detail" value="Save">
	<button type="button" class="waves-effect waves-dark btn btn-sm btn-primary" data-dismiss="modal">Close</button>
	</div>		
</div> 
<input type="hidden" name="code" value="<?php echo $arrDidRoutingIVR->code;?>">

</form>