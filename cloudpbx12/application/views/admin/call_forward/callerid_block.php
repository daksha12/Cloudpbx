<!--================================ 
- DATA FETCH FROM PAGE TAIL 
- ALL JS FUNCTION SET IN PAGE TAIL
==================================-->
<?php 
if($_SESSION['site_name']!='All'){
$db  = new SQLite3('/var/lib/asterisk/astdb.sqlite3', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
$this->db->where('tenant_id',$_SESSION["user_id"]);
$this->db->where('site_id',$_SESSION['site_id']);
$trunkDID=$this->db->get('trunk_master')->result();
?>
<div class="col-md-6 mt-3">
	<div class="card mb-6 p-3">
	<p class="col-md-12 badge badge-info"> Call Management List</p>  
	
		<section id="tabs">
			<div class="container">
				<!-- <h6 class="section-title h1">Tabs</h6> -->
				<div class="row">
					<div class="col-xs-12 ">
						<ul class="nav nav-tabs md-tabs" id="myTabMD" role="tablist">
						  <li class="nav-item">
						    <a class="nav-link <?php if($this->uri->segment(4)==''){echo"active";}elseif($this->uri->segment(4)=='1'){echo "active";}?>" id="inbound-tab-md" data-toggle="tab" href="#inbound-md" role="tab" aria-controls="inbound-md"
						      aria-selected="true">Caller ID block for Inbound</a>
						  </li>
						  <li class="nav-item">
						    <a class="nav-link <?php if($this->uri->segment(4)=='2'){echo "active";}?>" id="outbound-tab-md" data-toggle="tab" href="#outbound-md" role="tab" aria-controls="outbound-md"
						      aria-selected="false">Caller ID block for Outbound</a>
						  </li>
						  
						</ul>
						<div class="tab-content card pt-5" id="myTabContentMD">
						  <div class="tab-pane fade show <?php if($this->uri->segment(4)==''){echo"active";}elseif($this->uri->segment(4)=='1'){echo "active";}?>" id="inbound-md" role="tabpanel" aria-labelledby="inbound-tab-md">
							<table id="dt-basic-checkbox" class="table table-striped table-bordered" cellspacing="0" width="100%" >
									  	<thead>
										    <tr>      
												<th class="text-center">#</th>
												
												<th class="text-center">DID Number</th>
												<th class="text-center">Numbers</th>

											</tr>
									  	</thead>
									  	<tbody>
									  		<?php 
											$incall    = "/CIG_".$_SESSION['username']."_".$_SESSION['site_name'];
											$statement = $db->prepare('SELECT * FROM "astdb" where key like "%'.$incall.'%"');
											$result    = $statement->execute();
											while ($inbound = $result->fetchArray()) {
											$data      = explode("/",$inbound['key']);
											$inbound_did = $data[2];
											?>
										    <tr>

										      <input type="hidden" name="old_key_data" value="CIG_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>" id="old_key_data_inbound">
										      <input type="hidden" name="inbound_key_value" id="inbound_key_value" value="<?php echo $inbound_did; ?>">
												<td class="pt-3-half" style="vertical-align: inherit;">
													<a id="<?php echo $inbound_did; ?>"
													 class="remove-inbound"><i class="fas fa-trash"></i></a>		 	
												</td>
											
												<td><?php echo $inbound_did;?></td>
												<td><?php echo $inbound[1];?></td>
										    </tr>
										<?php }?>
										</tbody>
									</table>		

							<div class="col-md-12" style="text-align: left;padding-top: 30px;"><hr> 
							<!-- <input type="submit" class="waves-effect waves-dark btn btn-sm btn-primary" name="save_trunk" value="Save"> -->
							</div>
						  </div>
						  <div class="tab-pane fade show <?php if($this->uri->segment(4)=='2'){echo "active";}?>" id="outbound-md" role="tabpanel" aria-labelledby="outbound-tab-md">
						     
									<table id="dt-basic-outbound" class="table table-striped table-bordered" cellspacing="0" width="100%" >

										<!-- Table head -->
										<thead>
											<tr>      
												<th class="text-center">#</th>
												
												<th class="text-center">DID Number</th>
												<th class="text-center">Numbers</th>

											</tr>
										</thead>
										<tbody>
											
										   <?php 
											$outcall    = "/COG_".$_SESSION['username']."_".$_SESSION['site_name'];
											$ostatement = $db->prepare('SELECT * FROM "astdb" where key like "%'.$outcall.'%"');
											$Oresult    = $ostatement->execute();
											while ($out_bound_data = $Oresult->fetchArray()) {
											$O_data      = explode("/",$out_bound_data['key']);
											$out_data = $O_data[2];
											?>
										    <tr>
										      	<input type="hidden" name="old_key_outbound_data" value="COG_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>" id="old_key_outbound_data">
										      
										      	<input type="hidden" name="outbound_key_value" id="outbound_key_value" value="<?php echo $out_data; ?>">
												<td class="pt-3-half" style="vertical-align: inherit;">
													<a id="<?php echo $out_data; ?>" class="remove-outbound"><i class="fas fa-trash"></i></a>		 	
												</td>
												
												<td><?php echo $out_data;?></td>
												<td><?php echo $out_bound_data[1];?></td>
										    </tr>
										<?php }?>
												
										</tbody>
										<!-- Table body -->
									</table>
										
							
							<div class="col-md-12" style="text-align: left;padding-top: 30px;"><hr> 
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
<p class="col-md-12 badge badge-info" style="margin-bottom:-5px;z-index: 111">Add Caller ID block </p>  

	<div class="row p-3">

		<div class="col-md-12"><br><b></b></div>

		<div class="col-md-4">
		  <div class="md-form md-outline speed">
		    <input  data-toggle="modal" data-target="#add_inbound_did" type="button" name="addrow" class="btn btn-primary btn-sm addrow addspd <?php if($this->uri->segment(4)==''){echo "active";}elseif($this->uri->segment(4)=='1'){echo "active";}?>" value="Caller ID block for inbound">
		  </div>
		</div>

		<div class="col-md-4">
		  <div class="md-form md-outline speed">
		    <input  data-toggle="modal" data-target="#add_outbound_did" type="button" name="addrow" class="btn btn-primary btn-sm addrow addspd <?php if($this->uri->segment(4)=='2'){echo "active";}?>" value="Caller ID block for outbound">
		  </div>
		</div>

		
	</div>
	
</div>
<div class="modal fade show" id="add_inbound_did" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false" aria-modal="true" style="display: none; padding-left: 7px;">
<!-- Change class .modal-sm to change the size of the modal -->
	<div class="modal-dialog modal-fade" role="document">

		<div class="modal-content">
			<div class="modal-header">
			<h5 class="modal-title w-100 modal-header-top" id="myModalLabel">Caller ID block for Inbound DID <span style="float: right;"><button type="button" class="btn btn-danger btn-sm waves-effect waves-light" data-dismiss="modal" style="padding: 3px;padding-right: 10px;padding-left: 10px"><i class="fas fa-times"></i></button></span></h5>
			</div>
			<div class="modal-body">
				<?php if(!empty($trunkDID)){?>
				<form method="post" action="">
					<table class="table table-striped table-bordered table-sm">
						<tbody class="field_wrapper">										
							<tr>
							
								<!--- HIDDEN OLD KEY ---->
								<input type="hidden" name="old_key_data[]" value="/CIG_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>/<?php echo $inbound_did ?>">
								<!------ END KEY ------->
								<td><!-- <input type="text" class="form-control" name="did_no[]" id="did_no[]" value="" placeholder="DID Number" pattern="[0-9]+" required=""> -->
									<select name="trunk_did" id="trunk_did" class="mdb-select md-form md-outline colorful-select dropdown-primary" style="margin-top: 20px;" required=""> 
										<option value="" selected>Trunk did</option>
										<?php if(!empty($trunkDID)){foreach ($trunkDID as $value) { ?>
										<option value="<?php echo $value->trunk_did ?>" <?php if(isset($arrDidRoutingIVR)){if($arrDidRoutingIVR->did==$value->trunk_did){ echo 'selected';}}?>><?php echo $value->trunk_did; ?></option>
											<?php } } ?>
									</select>

								</td>
								<td><input type="hidden" id="inbounddid[]" class="form-control" name="key_data[]" value="/CIG_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>"><input type="text" class="form-control" name="value_data[]" id="did" value="" onKeyDown="if(event.keyCode === 32) return false;" placeholder="Number" required="" ></td>
								<td>

	  							<a class="edit-branch inbound_did"> <h4> <i class="fas fa-plus" style="margin-top: 12px;"> </i> </h4> </a></td>
								</tr>
								

							</tbody>
						</table>
						<div class="col-md-12">
							
							<center><input type="submit" name="save_inbound" value="Save" class="btn btn-primary btn-sm">
							</center>
						</div>
				</form>
				<?php }else{ ?>
					<div class="col-md-12">
					<center><h6 class="note note-danger">Please Insert Trunk Did in System Configuration</h6></center>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

<div class="modal fade show" id="add_outbound_did" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false" aria-modal="true" style="display: none; padding-left: 7px;">
<!-- Change class .modal-sm to change the size of the modal -->
	<div class="modal-dialog modal-fade" role="document">

		<div class="modal-content">
			<div class="modal-header">
			<h5 class="modal-title w-100 modal-header-top" id="myModalLabel">Caller ID block for Outbound DID <span style="float: right;"><button type="button" class="btn btn-danger btn-sm waves-effect waves-light" data-dismiss="modal" style="padding: 3px;padding-right: 10px;padding-left: 10px"><i class="fas fa-times"></i></button></span></h5>
			</div>
			<div class="modal-body">
				<form method="post" action="">
					<table class="table table-striped table-bordered table-sm">
						<tbody class="caller_outbound_data">										
							<tr>
							
								<!--- HIDDEN OLD KEY ---->
								<input type="hidden" name="old_key_outbound_data[]" value="/COG_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>/<?php echo $inbound_did ?>">
								<!------ END KEY ------->
								<td><input type="text" class="form-control" name="out_did_no[]" id="out_did_no[]" value="" placeholder="DID Number" pattern="[0-9]+" required></td>
								<td><input type="hidden" id="outbounddid[]" class="form-control" name="out_data[]" value="/COG_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>"><input type="text" class="form-control" name="out_value_data[]" id="out_did" value="" onKeyDown="if(event.keyCode === 32) return false;" placeholder="Number" required="" ></td>
								<td>

	  							<a class="edit-branch outbound_did"> <h4> <i class="fas fa-plus" style="margin-top: 12px;"> </i> </h4> </a></td>
								</tr>
								

							</tbody>
						</table>
						<div class="col-md-12">
							
							<center><input type="submit" name="save_out_bound" value="Save" class="btn btn-primary btn-sm">
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