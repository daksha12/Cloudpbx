<!--================================ 
- DATA FETCH FROM PAGE TAIL 
- ALL JS FUNCTION SET IN PAGE TAIL
==================================-->
<style type="text/css">
	.md-form.md-outline.speed {margin-top: 0rem; margin-bottom: 0rem;}
	input.btn.btn-primary.btn-sm.addspd {margin-top: auto; } 
	.nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {color: #ffffff; background-color: #000000; border-color: #4285f4 #dee2e6 #fff;border: 1px solid #ffffff;
    border-radius: 11px; } 
	.nav-tabs, .nav-tabs .nav-link{font-weight: 500; color: #fff; background: #4285f4; border: 1px solid #ffffff; border-radius: 11px; margin-left: 5px; border-bottom-style: dotted; }
	div.dataTables_wrapper div.dataTables_info {padding-top: 1.85em !important; white-space: nowrap; }
	div.dataTables_wrapper div.dataTables_filter {text-align: right; margin-top: -1px !important; }
	input.btn.btn-primary.btn-sm.addspd.active {background-color: #000000 !important; border-color: #4285f4 #dee2e6 #fff; border: 1px solid #ffffff; border-radius: 11px; }
	
</style>
   
<?php
if($_SESSION['site_name']!='All'){ 
$db  = new SQLite3('/var/lib/asterisk/astdb.sqlite3', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
?>
<div class="col-md-6 mt-2">
	<div class="card mb-6 p-2">
	<p class="col-md-12 badge badge-info"> Call Management List</p>  
	
		<section id="tabs" style="height: 435px">
			<div class="container">
				<!-- <h6 class="section-title h1">Tabs</h6> -->
				<div class="row">
					<div class="col-xs-12 ">
						<ul class="nav nav-tabs md-tabs" id="myTabMD" role="tablist">
						  <li class="nav-item">
						    <a class="nav-link <?php if($this->uri->segment(4)==''){echo'active';}elseif($this->uri->segment(4)=='4'){echo "active";}?>" id="pin4-tab-md" data-toggle="tab" href="#pin4-md" role="tab" aria-controls="pin4-md"
						      aria-selected="true">Conference PIN 4</a>
						  </li>
						  <li class="nav-item">
						    <a class="nav-link <?php if($this->uri->segment(4)=='8'){echo "active";}?>" id="pin8-tab-md" data-toggle="tab" href="#pin8-md" role="tab" aria-controls="pin8-md"
						      aria-selected="false">Conference PIN 8</a>
						  </li>
						  <li class="nav-item">
						    <a class="nav-link <?php if($this->uri->segment(4)=='16'){echo "active";}?>" id="pin16-tab-md" data-toggle="tab" href="#pin16-md" role="tab" aria-controls="pin16-md"
						      aria-selected="false">Conference PIN 16</a>
						  </li>
						  
						</ul>
						<div class="tab-content card pt-5" id="myTabContentMD">
						  <div class="tab-pane fade show  <?php if($this->uri->segment(4)==''){echo'active';}elseif($this->uri->segment(4)=='4'){echo "active";}?>" id="pin4-md" role="tabpanel" aria-labelledby="pin4-tab-md">
									<table id="dt-basic-pin4" class="table table-striped table-bordered" >
										<thead>
										<tr>      
										<th class="text-center">#</th>

										<th class="text-center">Conference PIN 4 Party</th>

										</tr>
										</thead>
										<tbody>
											
										   <?php 
											$incall    = "/Conf4PWD_".$_SESSION['username']."_".$_SESSION['site_name'];
											$statement = $db->prepare('SELECT * FROM "astdb" where key like "%'.$incall.'%"');
											$result    = $statement->execute();
											while ($inbound = $result->fetchArray()) {
											$data      = explode("/",$inbound['key']);
											$inbound_did = $data[2];
											?>
										    <tr>
										      <input type="hidden" name="old_key_Conf4_data" value="Conf4PWD_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>" id="old_key_Conf4_data">
										      <input type="hidden" name="key_data_conf4" value="<?php echo $inbound_did;?>" id="key_data_conf4">
												<td class="pt-3-half" style="vertical-align: inherit;">
													<a id="<?php echo $inbound_did; ?>" class="remove-conf4"><i class="fas fa-trash" style="display: block; text-align: center;margin-top: 5px;margin-bottom: 5px;"></i></a>		 	
												</td>
												
												<td><?php echo $inbound[1];?></td>
										    </tr>
										<?php }?>
												
										</tbody>
										<!-- Table body -->
									</table>
										

							<div class="col-md-12" style="text-align: left;"><hr> 
							<!-- <input type="submit" class="waves-effect waves-dark btn btn-sm btn-primary" name="save_trunk" value="Save"> -->
							</div>
						  </div>
						  <div class="tab-pane fade show <?php if($this->uri->segment(4)=='8'){echo "active";}?>" id="pin8-md" role="tabpanel" aria-labelledby="pin8-tab-md">
									<table id="dt-basic-pin8" class="table table-striped table-bordered" >

										<!-- Table head -->
										<thead>
										<tr>      
										<th class="text-center">#</th>
										<th class="text-center">Conference PIN 8 Party</th>

										</tr>
										</thead>
										<tbody>
											
										   <?php 
											$incall    = "/Conf8PWD_".$_SESSION['username']."_".$_SESSION['site_name'];
											$statement = $db->prepare('SELECT * FROM "astdb" where key like "%'.$incall.'%"');
											$result    = $statement->execute();
											while ($inbound = $result->fetchArray()) {
											$data      = explode("/",$inbound['key']);
											$inbound_did = $data[2];
											?>
										    <tr>
										      <input type="hidden" name="old_key_Conf8_data" value="Conf8PWD_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>" id="old_key_Conf8_data">
										      <input type="hidden" name="key_data_conf8" value="<?php echo $inbound_did;?>" id="key_data_conf8">
												<td class="pt-3-half" style="vertical-align: inherit;">
													<a id="<?php echo $inbound_did; ?>" class="remove-conf8"><i class="fas fa-trash"  style="display: block; text-align: center;margin-top: 5px;margin-bottom: 5px;"></i></a>		 	
												</td>
												<td><?php echo $inbound[1];?></td>
										    </tr>
										<?php }?>
												
										</tbody>
										<!-- Table body -->
									</table>
											

							<div class="col-md-12" style="text-align: left;"><hr> 
							<!-- <input type="submit" class="waves-effect waves-dark btn btn-sm btn-primary" name="save_trunk" value="Save"> -->
							</div>
						  </div>
						  <div class="tab-pane fade show <?php if($this->uri->segment(4)=='16'){echo "active";}?>" id="pin16-md" role="tabpanel" aria-labelledby="pin16-tab-md">
						      <div id="table" class="table-editable " style="height: 200px">                     
								<div>
									<table id="dt-basic-pin16" class="table table-striped table-bordered" >

										<!-- Table head -->
										<thead>
										<tr>      
										<th class="text-center">#</th>
										<th class="text-center">Conference PIN 16 Party</th>

										</tr>
										</thead>
										<tbody>
											
										   <?php 
											$incall    = "/Conf16PWD_".$_SESSION['username']."_".$_SESSION['site_name'];
											$statement = $db->prepare('SELECT * FROM "astdb" where key like "%'.$incall.'%"');
											$result    = $statement->execute();
											while ($inbound = $result->fetchArray()) {
											$data      = explode("/",$inbound['key']);
											$inbound_did = $data[2];
											?>
										    <tr>
										      <input type="hidden" name="old_key_Conf16_data" value="Conf16PWD_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>" id="old_key_Conf16_data">
										      <input type="hidden" name="key_data_conf16" value="<?php echo $inbound_did;?>" id="key_data_conf16">
												<td class="pt-3-half" style="vertical-align: inherit;">
													<a id="<?php echo $inbound_did; ?>" class="remove-conf16"><i class="fas fa-trash" style="display: block; text-align: center;margin-top: 5px;margin-bottom: 5px;"></i></a>		 	
												</td>
												<td><?php echo $inbound[1];?></td>
										    </tr>
										<?php }?>
												
										</tbody>
										<!-- Table body -->
									</table>
								</div>
							</div>			

							<!-- <div class="col-md-12" style="text-align: left;"><hr> 
							<input type="submit" class="waves-effect waves-dark btn btn-sm btn-primary" name="save_trunk" value="Save">
							</div> -->
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
<p class="col-md-12 badge badge-info" style="margin-bottom:-5px;z-index: 111">Add Conference PIN  </p>  

	<div class="row p-3">

		<div class="col-md-12"><br><b></b></div>

		<div class="col-md-4">
		  <div class="md-form md-outline speed">
		    <input type="button" data-toggle="modal" data-target="#add_conference_pin4" name="addspd" class="btn btn-primary btn-sm addspd <?php if($this->uri->segment(4)==''){echo'active';}elseif($this->uri->segment(4)=='4'){echo "active";}?>" value="Conference PIN 4 Party" >
		  </div>
		</div>

		<div class="col-md-4">
		  <div class="md-form md-outline speed">
		    <input type="button" data-toggle="modal" data-target="#add_conference_pin8" name="addspd" class="btn btn-primary btn-sm addspd <?php if($this->uri->segment(4)=='8'){echo "active";}?>" value="Conference PIN 8 Party" >
		  </div>
		</div>

		<div class="col-md-4">
		  <div class="md-form md-outline speed">
		    <input type="button" data-toggle="modal" data-target="#add_conference_pin16" name="addspd" class="btn btn-primary btn-sm addspd <?php if($this->uri->segment(4)=='16'){echo "active";}?>" value="Conference PIN 16 Party" >
		  </div>
		</div>

		
	</div>
	
</div>
<div class="modal fade show" id="add_conference_pin4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false" aria-modal="true" style="display: none; padding-left: 7px;">
	<div class="modal-dialog modal-fade" role="document">
		<div class="modal-content">
			<div class="modal-header">
			<h5 class="modal-title w-100 modal-header-top" id="myModalLabel">Conference PIN 4 Party <span style="float: right;"><button type="button" class="btn btn-danger btn-sm waves-effect waves-light" data-dismiss="modal" style="padding: 3px;padding-right: 10px;padding-left: 10px"><i class="fas fa-times"></i></button></span></h5>
			</div>
			<div class="modal-body">
				<form method="post" action="">
				<table class="table table-striped table-bordered table-sm">
					<tbody class="field_wrapper">
						<tr>
							<input type="hidden" name="old_key_conf_data" value="/Conf4PWD_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>">
								<input type="hidden" name="key_data" id="key_data" value="4party">
							<td>
								<input type="text" class="form-control" name="conference_pin" id="conference_pin" value="" placeholder="Conference PIN 4" pattern="[0-9]+" onKeyDown="if(event.keyCode === 32) return false;" required=""></td>
  							
						</tr>
					</tbody>
				</table>
				<div class="col-md-12">
					
					<center><input type="submit" name="save" value="Save" class="btn btn-primary btn-sm">
					</center>
				</div>
			</form>
			</div>
		</div>
	</div>
</div>
<div class="modal fade show" id="add_conference_pin8" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false" aria-modal="true" style="display: none; padding-left: 7px;">
	<div class="modal-dialog modal-fade" role="document">
		<div class="modal-content">
			<div class="modal-header">
			<h5 class="modal-title w-100 modal-header-top" id="myModalLabel">Conference PIN 8 Party <span style="float: right;"><button type="button" class="btn btn-danger btn-sm waves-effect waves-light" data-dismiss="modal" style="padding: 3px;padding-right: 10px;padding-left: 10px"><i class="fas fa-times"></i></button></span></h5>
			</div>
			<div class="modal-body">
				<form method="post" action="">
				<table class="table table-striped table-bordered table-sm">
					<tbody class="conference_pin_data8">
						<tr>
							<input type="hidden" name="old_key_conf_data" value="/Conf8PWD_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>">
							<input type="hidden" name="key_data" id="key_data" value="8party">
							
							<td>
								<input type="text" class="form-control" name="conference_pin" id="conferencepin8" value="" placeholder="Conference PIN 8" pattern="[0-9]+" onKeyDown="if(event.keyCode === 32) return false;" required=""></td>
  							
						</tr>
							

					</tbody>
				</table>
				<div class="col-md-12">
					<center><input type="submit" name="save" value="Save" class="btn btn-primary btn-sm">
					</center>
				</div>
			</form>
			</div>
		</div>
	</div>
</div>
<div class="modal fade show" id="add_conference_pin16" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false" aria-modal="true" style="display: none; padding-left: 7px;">
	<div class="modal-dialog modal-fade" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title w-100 modal-header-top" id="myModalLabel">Conference PIN 16 Party <span style="float: right;">
					<button type="button" class="btn btn-danger btn-sm waves-effect waves-light" data-dismiss="modal" style="padding: 3px;padding-right: 10px;padding-left: 10px"><i class="fas fa-times"></i></button></span>
				</h5>
			</div>
			<div class="modal-body">
				<form method="post" action="">
				<table class="table table-striped table-bordered table-sm">
					<tbody class="conference_pin_data16">
						
							<tr>
								<input type="hidden" name="old_key_conf_data" value="/Conf16PWD_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>">
								<input type="hidden" name="key_data" value="16party">
								<td><input type="text" class="form-control" name="conference_pin" id="conference_pin16" value="" placeholder="Conference PIN 16" pattern="[0-9]+" onKeyDown="if(event.keyCode === 32) return false;" required=""></td>
      							
							</tr>
						</tbody>
				</table>
				<div class="col-md-12">
					<center><input type="submit" name="save" value="Save" class="btn btn-primary btn-sm"></center>
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