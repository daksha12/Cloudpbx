<!--================================ 
- DATA FETCH FROM PAGE TAIL 
- ALL JS FUNCTION SET IN PAGE TAIL
==================================-->

<!-- Section: Analytical panel -->
<?php if($_SESSION['site_name'] != 'All'){ ?>
<div class="col-md-8">
<input type="button" name="addrow" class="btn btn-primary btn-sm addrow" value="Add inbound DID" style="float: right;">	
<input type="button" name="addspd" class="btn btn-primary btn-sm addspd" value="Add PSTN Speed Numbers" style="float: right;">
<input type="button" name="addspdext" class="btn btn-primary btn-sm addspdext" value="Add Ext Speed Numbers" style="float: right;">	
<form method="post" action="">
<div class="row">
<table class="table table-striped table-bordered table-sm text-center" cellspacing="0">
<thead>
<tr>
<th>Type</th>
<th>DID Number</th>
<th>Numbers / PIN</th>
<th>Status</th>
</tr>
</thead>
<tbody>
<tr>
<?php 
$row = 0;
$db  = new SQLite3('/var/lib/asterisk/astdb.sqlite3', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
$incall    = "/CIG_".$_SESSION['username']."_".$_SESSION['site_name'];
$statement = $db->prepare('SELECT * FROM "astdb" where key like "%'.$incall.'%"');
$shellscript =escapeshellarg("database show").'&> /tmp/error';
//$cmd = system("sudo /usr/sbin/asterisk -rx ",$shellscript);
//$cmd = system("sudo /usr/sbin/asterisk -rx " . escapeshellarg('database show') . " &> /tmp/error");
// $cmd1 = exec('sudo /usr/sbin/asterisk -rx "database show"');
// $cmd2 = exec('sudo /usr/sbin/asterisk -rx "database put CIG_CompanyA_branch1 123456 "9725608174""');
// $cmd3 = exec('sudo /usr/sbin/asterisk -rx "database show"');
// $cmd4 = exec('sudo /usr/sbin/asterisk -rx "database del CIG_CompanyA_branch1 123456 "');
// $cmd5 = exec('sudo /usr/sbin/asterisk -rx "database show"');




// echo "<pre>";
// print_r($cmd1);
// print_r($cmd2);
// print_r($cmd3);
// print_r($cmd4);
// print_r($cmd5);
// echo "<pre>";

// exit;

$result    = $statement->execute();
while ($inbound = $result->fetchArray()) {
$data      = explode("/",$inbound['key']);
$inbound_did = $data[2];
?>	

<td>Caller ID block for inbound DID</td>
<!--- HIDDEN OLD KEY ---->
<input type="hidden" name="old_key_data[]" value="/CIG_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>/<?php echo $inbound_did ?>">
<!------ END KEY ------->
<td><input type="text" class="form-control" name="did" id="did_no" value="<?php echo $inbound_did ?>" onchange="did_name_sql(this.value,'<?php echo $inbound_did ?>');" placeholder="DID Number" pattern="[0-9]+" onKeyDown="if(event.keyCode === 32) return false;"></td>
<td><input type="hidden" id="inbounddid<?php echo $inbound_did; ?>" class="form-control" name="key_data[]" value="/CIG_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>/<?php echo $inbound_did ?>"><input type="text" class="form-control" name="value_data[]" id="did<?php echo $inbound_did; ?>" pattern="[0-9]+" onKeyDown="if(event.keyCode === 32) return false;" value='<?php echo str_replace("|",",",$inbound['value']); ?>' placeholder="DID Number/PIN"></td>
<td>
<?php if($inbound['value'] == ''){$status = 'Deactive'; echo "<span class='badge badge-danger'>Disabled</sapn>";}else{$status ='Active'; echo "<span class='badge badge-success'>Enabled</span>";}?>
<input type="hidden" class="form-control" name="status[]" value='<?php echo $status ?>'>
</td>
</tr>
<?php 
$row++; }
if($row == 0) { 
?>
<tr>
<td>Caller ID block for inbound DID</td>
<!--- HIDDEN OLD KEY ---->
<input type="hidden" name="old_key_data[]" value="/CIG_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>/<?php echo $inbound_did ?>">
<!------ END KEY ------->
<td><input type="text" class="form-control" name="did" id="did_no" value="<?php echo $inbound_did ?>" onchange="did_name_sql(this.value,'<?php echo $inbound_did ?>');" placeholder="DID Number" pattern="[0-9]+" onKeyDown="if(event.keyCode === 32) return false;"></td>
<td><input type="hidden" id="inbounddid<?php echo $inbound_did; ?>" class="form-control" name="key_data[]" value="/CIG_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>/<?php echo $inbound_did ?>"><input type="text" class="form-control" name="value_data[]" id="did" pattern="[0-9]+" onKeyDown="if(event.keyCode === 32) return false;" value='<?php echo str_replace("|",",",$inbound['value']); ?>' placeholder="DID Number/PIN" readonly ></td>
<td>
<?php if($inbound['value'] == ''){$status = 'Deactive'; echo "<span class='badge badge-danger'>Disabled</sapn>";}else{$status ='Active'; echo "<span class='badge badge-success'>Enabled</span>";}?>
<input type="hidden" class="form-control" name="status[]" value='<?php echo $status ?>'>
</td>
</tr>
<?php } ?>

<tr class="dynamicRows"></tr>

<tr>
<td>Caller ID block for outbound </td>
<input type="hidden" name="old_key_data[]" value="/COG_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>/calleridblk">
<td>-</td>
<td><input type="hidden" class="form-control" name="key_data[]" value="/COG_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>/calleridblk"><input type="text" class="form-control" name="value_data[]" value='<?php echo $outbound ?>' pattern="[0-9]+" onKeyDown="if(event.keyCode === 32) return false;"></td>
<td>
<?php if($outbound == ''){$status = 'Deactive'; echo "<span class='badge badge-danger'>Disabled</sapn>";}else{$status ='Active'; echo "<span class='badge badge-success'>Enabled</span>";} ?>
 <input type="hidden" class="form-control" name="status[]" value='<?php echo $status ?>'>
</td>
</tr>

<tr>
<td>Conference PIN </td>

<input type="hidden" name="old_key_data[]" value="/ConfPWD_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>/<?php echo $_SESSION['site_name'] ?>_200">

<td style="font-size: 1rem;"><?php echo get_conference_did(); ?></td>
<td><input type="hidden" class="form-control" name="key_data[]" value="/ConfPWD_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>/<?php echo $_SESSION['site_name'] ?>_200"><input type="text" class="form-control" name="value_data[]" value='<?php echo $conference ?>' pattern="[0-9]+" onKeyDown="if(event.keyCode === 32) return false;"></td>
<td>
<?php if($conference == ''){$status = 'Deactive'; echo "<span class='badge badge-danger'>Disabled</sapn>";}else{$status ='Active'; echo "<span class='badge badge-success'>Enabled</span>";} ?>
 <input type="hidden" class="form-control" name="status[]" value='<?php echo $status ?>'>
</td>
</tr>

<!--- SPD DIAL ----->
<tr>
<?php 
$spd = 0;
$incall    = "/SPD_".$_SESSION['username']."_".$_SESSION['site_name'];
$statement = $db->prepare('SELECT * FROM "astdb" where key like "%'.$incall.'%"');
$result    = $statement->execute();
while ($inbound = $result->fetchArray()) {
$data      = explode("/",$inbound['key']);
$spd_port  = $data[2];
?>	

<td>PSTN Speed Dial Number</td>
<!--- HIDDEN OLD KEY ---->
<input type="hidden" name="old_key_data[]" value="/SPD_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>/<?php echo $spd_port ?>">
<!------ END KEY ------->
<td><input type="text" class="form-control" name="did" id="spd_port<?php echo $spd_port ?>" value="<?php echo $spd_port ?>" onchange="spd_name_sql(this.value,'<?php echo $spd_port ?>');" placeholder="PSTN Number" maxlength="3" pattern="[0-9]+" onKeyDown="if(event.keyCode === 32) return false;"></td>
<td><input type="hidden" id="spddial<?php echo $spd_port; ?>" class="form-control" name="key_data[]" value="/SPD_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>/<?php echo $spd_port ?>"><input type="text" class="form-control" name="value_data[]" id="num<?php echo $spd_port ?>" pattern="[0-9]+" onKeyDown="if(event.keyCode === 32) return false;" value='<?php echo str_replace("|",",",$inbound['value']); ?>'></td>
<td>
<?php if($inbound['value'] == ''){$status = 'Deactive'; echo "<span class='badge badge-danger'>Disabled</sapn>";}else{$status ='Active'; echo "<span class='badge badge-success'>Enabled</span>";}?>
<input type="hidden" class="form-control" name="status[]" value='<?php echo $status ?>'>
</td>
</tr> 
<?php 
$spd++; }
if($spd == 0) { 
?>
<tr>
<td>PSTN Speed Dial Number</td>
<!--- HIDDEN OLD KEY ---->
<input type="hidden" name="old_key_data[]" value="/SPD_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>/<?php echo $spd_port ?>">
<!------ END KEY ------->
<td><input type="text" class="form-control" name="did" id="spd_port" value="<?php echo $spd_port ?>" onchange="spd_name_sql(this.value,'<?php echo $spd_port ?>');" placeholder="PSTN Number" maxlength="3" pattern="[0-9]+" onKeyDown="if(event.keyCode === 32) return false;"></td>
<td><input type="hidden" id="spddial<?php echo $spd_port; ?>" class="form-control" name="key_data[]" value="/SPD_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>/<?php echo $spd_port ?>"><input type="text" class="form-control" name="value_data[]" id="num" value='<?php echo str_replace("|",",",$inbound['value']); ?>' readonly pattern="[0-9]+" onKeyDown="if(event.keyCode === 32) return false;" placeholder="PSTN Number/PIN"></td>
<td>
<?php if($inbound['value'] == ''){$status = 'Deactive'; echo "<span class='badge badge-danger'>Disabled</sapn>";}else{$status ='Active'; echo "<span class='badge badge-success'>Enabled</span>";}?>
<input type="hidden" class="form-control" name="status[]" value='<?php echo $status ?>'>
</td>
</tr>
<?php } ?>
<tr class="dynamicRowsSPD"></tr>

<!---- END dial ---->


<!----- EXT SPEED DIAL --------->
<tr>
<?php 
$spdext = 0;
$incall    = "/SPDext_".$_SESSION['username']."_".$_SESSION['site_name'];
$statement = $db->prepare('SELECT * FROM "astdb" where key like "%'.$incall.'%"');
$result    = $statement->execute();
while ($inbound = $result->fetchArray()) {
$data      = explode("/",$inbound['key']);
$spdext_port  = $data[2];
?>	

<td>EXT Speed Dial Number</td>
<!--- HIDDEN OLD KEY ---->
<input type="hidden" name="old_key_data[]" value="/SPDext_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>/<?php echo $spd_port ?>">
<!------ END KEY ------->
<td><input type="text" class="form-control" name="did" id="spdext_port<?php echo $spdext_port ?>" value="<?php echo $spdext_port ?>" onchange="spdext_name_sql(this.value,'<?php echo $spdext_port ?>');" placeholder="EXT Number" maxlength="3" pattern="[0-9]+" onKeyDown="if(event.keyCode === 32) return false;"></td>
<td><input type="hidden" id="spddial<?php echo $spdext_port; ?>" class="form-control" name="key_data[]" value="/SPDext_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>/<?php echo $spdext_port ?>"><input type="text" class="form-control" name="value_data[]" id="numext<?php echo $spdext_port ?>" pattern="[0-9]+" onKeyDown="if(event.keyCode === 32) return false;" value='<?php echo str_replace("|",",",$inbound['value']); ?>'></td>
<td>
<?php if($inbound['value'] == ''){$status = 'Deactive'; echo "<span class='badge badge-danger'>Disabled</sapn>";}else{$status ='Active'; echo "<span class='badge badge-success'>Enabled</span>";}?>
<input type="hidden" class="form-control" name="status[]" value='<?php echo $status ?>'>
</td>
</tr> 
<?php 
$spdext++; }
if($spdext == 0) { 
?>
<tr>
<td>EXT Speed Dial Number</td>
<!--- HIDDEN OLD KEY ---->
<input type="hidden" name="old_key_data[]" value="/SPDext_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>/<?php echo $spdext_port ?>">
<!------ END KEY ------->
<td><input type="text" class="form-control" name="did" id="spdext_port" value="<?php echo $spdext_port ?>" onchange="spdext_name_sql(this.value,'<?php echo $spdext_port ?>');" placeholder="EXT Number" maxlength="3" pattern="[0-9]+" onKeyDown="if(event.keyCode === 32) return false;"></td>
<td><input type="hidden" id="spddial<?php echo $spdext_port; ?>" class="form-control" name="key_data[]" value="/SPDext_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>/<?php echo $spdext_port ?>"><input type="text" class="form-control" name="value_data[]" id="numext" value='<?php echo str_replace("|",",",$inbound['value']); ?>' readonly pattern="[0-9]+" onKeyDown="if(event.keyCode === 32) return false;" placeholder="EXT Number/PIN"></td>
<td>
<?php if($inbound['value'] == ''){$status = 'Deactive'; echo "<span class='badge badge-danger'>Disabled</sapn>";}else{$status ='Active'; echo "<span class='badge badge-success'>Enabled</span>";}?>
<input type="hidden" class="form-control" name="status[]" value='<?php echo $status ?>'>
</td>
</tr>
<?php } ?>
<tr class="dynamicRowsSPDext"></tr>

<!---- END dial ---->
<!------ END OF SPEDD DIAL ----->


</tbody>
</table> 
<div class="col-md-12">
<hr style="margin-top: 2px;">
<input type="submit" name="save" value="Save" class="btn btn-primary btn-sm">
</div>
</div>
</form>
</div>
<div class="col-md-4" style="margin-top:30px">
	<h6 class="note note-danger">
    <strong>Note:</strong><hr>
    1. Data will get updated in up to 5 minutes after updating in portal.<br>
    2. In order to add multiple numbers use (,).
	</h6>
</div>
<?php }else{ ?>
<div class="col-md-12">
<center><h6 class="note note-danger">Please select any one branch to do call management.</h6></center>
</div>
<?php } ?>
