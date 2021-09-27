<!--================================ 
- DATA FETCH FROM PAGE TAIL 
- ALL JS FUNCTION SET IN PAGE TAIL
==================================-->
<?php 
if($_SESSION['site_name'] != 'All'){
$db  = new SQLite3('/var/lib/asterisk/astdb.sqlite3', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
$branch_ext = getExtensionData($_SESSION['user_id'],$_SESSION['site_id']);

?>
<div class="col-md-6 mt-2">
	<div class="card mb-6 p-2">
	<p class="col-md-12 badge badge-info"> Call Management List</p>  
	
		<section id="tabs" style="height: 435px">
			<div class="container">
				<!-- <h6 class="section-title h1">Tabs</h6> -->
				<div class="row">
					<div class="col-xs-12 ">
						<ul class="nav nav-tabs md-tabs" id="myTabMD" role="tablist" style="padding: 0.3rem;">
						  <li class="nav-item" style="margin-bottom: 4px; margin-top: 5px;">
						    <a class="nav-link <?php if($this->uri->segment(4)==''){echo"active";}elseif($this->uri->segment(4)=='1'){echo "active";}?>" id="ext-tab-md" data-toggle="tab" href="#ext-md" role="tab" aria-controls="ext-md"
						      aria-selected="true">EXT Speed Dial</a>
						  </li>
						  <li class="nav-item" style="margin-bottom: 4px; margin-top: 5px;">
						    <a class="nav-link <?php if($this->uri->segment(4)=='2'){echo "active";}?>" id="pstn-tab-md" data-toggle="tab" href="#pstn-md" role="tab" aria-controls="pstn-md"
						      aria-selected="false">PSTN Speed Dial</a>
						  </li>
						  <li class="nav-item" style="margin-bottom: 4px; margin-top: 5px;">
						    <a class="nav-link <?php if($this->uri->segment(4)=='3'){echo "active";}?>" id="prefixpstn-tab-md" data-toggle="tab" href="#prefixpstn-md" role="tab" aria-controls="prefixpstn-md"
						      aria-selected="false">Prefix PSTN Speed Dial</a>
						  </li>
						  
						</ul>
						<div class="tab-content card pt-5" id="myTabContentMD">
						  <div class="tab-pane fade show <?php if($this->uri->segment(4)==''){echo"active";}elseif($this->uri->segment(4)=='1'){echo "active";}?>" id="ext-md" role="tabpanel" aria-labelledby="ext-tab-md">
									<table id="dt-basic-ext" class="table table-striped table-bordered" cellspacing="0" width="100%" >
										<thead>
											<tr>      
											<th class="text-center">#</th>
											<th class="text-center">EXT Number</th>
											<th class="text-center">Numbers</th>

											</tr>
										</thead>
										<tbody>
											
										   <?php 
											$ext_speed    = "/SPDext_".$_SESSION['username']."_".$_SESSION['site_name'];
											$ext_statement = $db->prepare('SELECT * FROM "astdb" where key like "%'.$ext_speed.'%"');
											$ext_result    = $ext_statement->execute();
											while ($ext_data = $ext_result->fetchArray()) {
											$e_data      = explode("/",$ext_data['key']);
											$ext_number = $e_data[2];
											?>
										    <tr>
										     	<input type="hidden" name="old_ext_key_data[]" value="SPDext_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>" id="old_ext_key_data">
										     	<input type="hidden" name="exte_key_value" id="exte_key_value" value="<?php echo $ext_number; ?>">
												<td class="pt-3-half" style="vertical-align: inherit;">
													<a  class="remove-ext"><i class="fas fa-trash"></i></a>		 	
												</td>
												
												<td><?php echo $ext_number;?></td>
												<td><?php echo $ext_data[1];?></td>
										    </tr>
										<?php }?>
												
										</tbody>
										<!-- Table body -->
									</table>
								
							<div class="col-md-12" style="text-align: left;padding-top: 30px;"><hr> 
							<!-- <input type="submit" class="waves-effect waves-dark btn btn-sm btn-primary" name="save_trunk" value="Save"> -->
							</div>
						  </div>
						  <div class="tab-pane fade show <?php if($this->uri->segment(4)=='2'){echo "active";}?>" id="pstn-md" role="tabpanel" aria-labelledby="pstn-tab-md">
						      
									<table id="dt-basic-pstn" class="table table-striped table-bordered" cellspacing="0" width="100%" >
										<thead>
										<tr>      
										<th class="text-center">#</th>
										<th class="text-center">PSTN Number</th>
										<th class="text-center">Numbers</th>

										</tr>
										</thead>
										<tbody>
											
										   <?php 
											$pstn_incall    = "/SPDpstn_".$_SESSION['username']."_".$_SESSION['site_name'];
											$pstn_statement = $db->prepare('SELECT * FROM "astdb" where key like "%'.$pstn_incall.'%"');
											$pstn_result    = $pstn_statement->execute();
											while ($pstn_inbound = $pstn_result->fetchArray()) {
											$pstn_data      = explode("/",$pstn_inbound['key']);
											$pstn_did = $pstn_data[2];
											?>
										    <tr>
										      <input type="hidden" name="old_pstn_data" value="SPDpstn_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>" id="old_pstn_data">
										      <input type="hidden" name="pstn_key_data" id="pstn_key_data" value="<?php echo $pstn_did; ?>">
												<td class="pt-3-half" style="vertical-align: inherit;">
													<a id="<?php echo $pstn_did; ?>" class="remove-pstn"><i class="fas fa-trash"></i></a>		 	
												</td>
												
												<td><?php echo $pstn_did;?></td>
												<td><?php echo $pstn_inbound[1];?></td>
										    </tr>
										<?php }?>
												
										</tbody>
										<!-- Table body -->
									</table>
								
							<div class="col-md-12" style="text-align: left;"><hr> 
							<!-- <input type="submit" class="waves-effect waves-dark btn btn-sm btn-primary" name="save_trunk" value="Save"> -->
							</div>
						  </div>
						  <div class="tab-pane fade show <?php if($this->uri->segment(4)=='3'){echo "active";}?>" id="prefixpstn-md" role="tabpanel" aria-labelledby="prefixpstn-tab-md">
									<table id="dt-basic-prefixpstn" class="table table-striped table-bordered" >
										<thead>
										<tr>      
										<th class="text-center">#</th>
										<th class="text-center">PSTN Prefix Number</th>
										<th class="text-center">Numbers</th>

										</tr>
										</thead>
										<tbody>
											
										   <?php 
											$incall    = "/SPDpfxpstn_".$_SESSION['username']."_".$_SESSION['site_name'];
											$statement = $db->prepare('SELECT * FROM "astdb" where key like "%'.$incall.'%"');
											$result    = $statement->execute();
											if($result){
											while ($inbound = $result->fetchArray()) {
											$data      = explode("/",$inbound['key']);
											$inbound_did = $data[2];
											?>
										    <tr>
										      <input type="hidden" name="old_key_prefixpstn_data[]" value="SPDpfxpstn_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>" id="old_key_prefixpstn_data">
										      <input type="hidden" name="prefix_key_value" value="<?php echo $inbound_did;?>" id="prefix_key_value">
												<td class="pt-3-half" style="vertical-align: inherit;">
													<a id="<?php echo $inbound_did; ?>" class="remove-prefix"><i class="fas fa-trash"></i></a>		 	
												</td>
												
												<td><?php echo $inbound_did;?></td>
												<td><?php echo $inbound[1];?></td>
										    </tr>
										<?php } }else{ ?>

											<tr> <?php echo "No matching records found ";?></tr>
										<?php }?>
												
										</tbody>
										<!-- Table body -->
									</table>		

							<div class="col-md-12" style="text-align: left;"><hr> 
							<!-- <input type="submit" class="waves-effect waves-dark btn btn-sm btn-primary" name="save_trunk" value="Save"> -->
							</div>
						  </div>
						  
						</div>
					
					</div>
				</div>
			</div>
		</section>
	</div>
</div>
	

<div class="col-md-6 mt-2" style="border-left: 1px solid #000">
<div class="card mb-6 p-2">
<p class="col-md-12 badge badge-info" style="margin-bottom:-5px;z-index: 111">Add Speed Dial </p>  

	<div class="row p-3">

		<div class="col-md-12"><br><b></b></div>

		<div class="col-md-4">
		  <div class="md-form md-outline speed">
		     <input type="button" data-toggle="modal" data-target="#add_ext_speed_dial" name="addspdext" class="btn btn-primary btn-sm addspdext addspd <?php if($this->uri->segment(4)==''){echo"active";}elseif($this->uri->segment(4)=='1'){echo "active";}?>" value="Ext Speed Numbers" style="float: right;">
		  </div>
		</div>

		<div class="col-md-4">
		  <div class="md-form md-outline speed">
		     <input type="button" data-toggle="modal" data-target="#add_pstn_speed_dial" name="addpstnspd" class="btn btn-primary btn-sm addspd <?php if($this->uri->segment(4)=='2'){echo "active";}?>" value="PSTN Speed Numbers">
		  </div>
		</div>

		<div class="col-md-4">
		  <div class="md-form md-outline speed">
		     <input type="button" data-toggle="modal" data-target="#add_pstn_prefix_speed_dial" name="addprefix" class="btn btn-primary btn-sm addspd <?php if($this->uri->segment(4)=='3'){echo "active";}?>" value="Prefix PSTN Speed Numbers" style="float: left;width: 175px;">
		  </div>
		</div>

		
	</div>
	
</div>
<div class="modal fade show" id="add_ext_speed_dial" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false" aria-modal="true" style="display: none; padding-left: 7px;">
<!-- Change class .modal-sm to change the size of the modal -->
	<div class="modal-dialog modal-fade" role="document">

		<div class="modal-content">
			<div class="modal-header">
			<h5 class="modal-title w-100 modal-header-top" id="myModalLabel">EXT Speed Dial <span style="float: right;"><button type="button" class="btn btn-danger btn-sm waves-effect waves-light" data-dismiss="modal" style="padding: 3px;padding-right: 10px;padding-left: 10px"><i class="fas fa-times"></i></button></span></h5>
			</div>
			<div class="modal-body">
				<form method="post" action="">
				<table class="table table-striped table-bordered table-sm">
					<tbody class="field_wrapper">
							<tr>
							
								<!--- HIDDEN OLD KEY ---->
								<input type="hidden" name="old_key_data[]" value="/SPDext_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>">
								<!------ END KEY ------->
								<td><input type="text" class="form-control" name="ext_did[]" id="ext_did[]" value="" placeholder="EXT Speed Dial" pattern="[*0-9]+" onKeyDown="if(event.keyCode === 32) return false;"></td>
								<td><input type="hidden" id="extdid" class="form-control" name="ext_data[]" value="/SPDext_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>">
									<select name="extension[]" id="extension" class="mdb-select md-form md-outline colorful-select dropdown-primary" required=""> 
										<option value="" selected>Extension</option>

										<?php if(!empty($branch_ext)){foreach ($branch_ext as $value) { ?>             
											<option value="<?php echo $value->extension ?>"><?php echo $value->extension; ?></option>
										<?php } } ?>

									</select>
								</td>
								<td>
      							<a href="#" class="edit-branch ext_speed_dial" data-toggle="modal" data-target="#centralModalSmBranch"> <h4> <i class="fas fa-plus" style="display: block;text-align: center; margin-top: 5px; margin-bottom: 5px; "> </i> </h4> </a></td>
								</tr>
							

						</tbody>
					</table>
					<div class="col-md-12">
						
						<center><input type="submit" name="ext_speed_dial_save" value="Save" class="btn btn-primary btn-sm">
						</center>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="modal fade show" id="add_pstn_speed_dial" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" data-backdrop="static" data-keyboard="false" aria-modal="true" style="display: none; padding-left: 7px;">
<!-- Change class .modal-sm to change the size of the modal -->
	<div class="modal-dialog modal-fade" role="document">

		<div class="modal-content">
			<div class="modal-header">
			<h5 class="modal-title w-100 modal-header-top" id="myModalLabel">PSTN Speed Dial <span style="float: right;"><button type="button" class="btn btn-danger btn-sm waves-effect waves-light" data-dismiss="modal" style="padding: 3px;padding-right: 10px;padding-left: 10px"><i class="fas fa-times"></i></button></span></h5>
			</div>
			<div class="modal-body">
				<form method="post" action="">
					<table class="table table-striped table-bordered table-sm" id="pstn_value">
						<tbody class="pstn_field_wrapper">										
							<tr>
							
								<!--- HIDDEN OLD KEY ---->
								<input type="hidden" name="old_key_data[]" value="/SPDpstn_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>/<?php echo $inbound_did ?>">
								<!------ END KEY ------->
								<td><input type="text" class="form-control pstn" name="pstn_no[]" id="pstn_no[]" value="" placeholder="PSTN Number" pattern="[0-9]+"></td>
								<td><input type="hidden" id="pstn_did" class="form-control" name="pstn_key_data[]" value="/SPDpstn_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>"><input type="text" class="form-control" name="pstn_value_data[]" id="pstn_value_data[]" value="" onKeyDown="if(event.keyCode === 32) return false;" placeholder="Number"  ></td>
								<td>

	  							<a class="edit-branch pstn_speed_dial"> <h4> <i class="fas fa-plus" style="margin-top: 12px;"> </i> </h4> </a></td>
								</tr>
								

							</tbody>
						</table>
						<div class="col-md-12">
							
							<center><input type="submit" name="pstn_save" value="Save" class="btn btn-primary btn-sm">
							</center>
						</div>
					</form>
			</div>
		</div>
	</div>
</div>
<div class="modal fade show" id="add_pstn_prefix_speed_dial" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false" aria-modal="true" style="display: none; padding-left: 7px;">
<!-- Change class .modal-sm to change the size of the modal -->
	<div class="modal-dialog modal-fade" role="document">

		<div class="modal-content">
			<div class="modal-header">
			<h5 class="modal-title w-100 modal-header-top" id="myModalLabel">Prefix PSTN Speed Dial <span style="float: right;"><button type="button" class="btn btn-danger btn-sm waves-effect waves-light" data-dismiss="modal" style="padding: 3px;padding-right: 10px;padding-left: 10px"><i class="fas fa-times"></i></button></span></h5>
			</div>
			<div class="modal-body">
				<form method="post" action="">
					<table class="table table-striped table-bordered table-sm">
						<tbody class="field_wrapper">										
							<tr>
							
								<!--- HIDDEN OLD KEY ---->
								<input type="hidden" name="prefix_old_key_data[]" value="/SPDpfxpstn_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>/<?php echo $inbound_did ?>">
								<!------ END KEY ------->
								<td><input type="text" class="form-control" name="pstn_prefix_no[]" id="pstn_prefix_no[]" value="" placeholder="PSTN Prefix Speed Dial" pattern="[0-6]+"></td>
								<td><input type="hidden" id="prefix_key_data[]" class="form-control" name="prefix_key_data[]" value="/SPDpfxpstn_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>"><input type="text" class="form-control" name="prefix_value_data[]" id="prefix_value_data[]" value="" onKeyDown="if(event.keyCode === 32) return false;" placeholder="Number"  ></td>
								<td>

	  							<a class="edit-branch prefix_did"> <h4> <i class="fas fa-plus" style="margin-top: 12px;"> </i> </h4> </a></td>
								</tr>
								

							</tbody>
						</table>
						<div class="col-md-12">
							
							<center><input type="submit" name="prefix_save" value="Save" class="btn btn-primary btn-sm">
							</center>
						</div>
					</form>
			</div>
		</div>
	</div>
</div>
<?php }else{ ?>
<div class="col-md-12">
<center><h6 class="note note-danger">Please select any one branch to do call management.</h6></center>
</div>
<?php } ?>