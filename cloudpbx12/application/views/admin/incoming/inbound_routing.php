<!-- Section: Analytical panel -->
<div class="col-md-9 mt-2">


<!---- DID IVR ROUTING ------>
<?php if(count($ivr)){ foreach ($ivr as $value) {?>
<table class="table table-striped table-bordered table-sm" cellspacing="0">
<thead> 
<tr>
<th class="th-sm" style="width: 10%">DID</th>
<th class="th-sm" style="width: 30%">Office time</th>
<th class="th-sm" style="width: 40%">In office routing</th>
<th class="th-sm" style="width: 20%">Out office routing</th>
</tr>
</thead>
<tbody>
<td><b><?php echo $value->did ?></b></td>
<td><b><?php echo $value->off_start.' to '.$value->off_end ?> <br> <?php echo str_replace('|', ' , ', strtoupper($value->off_days)); ?></b>
</td>
<td>
<div style="height: 200px;overflow-y: scroll;">
<?php
/*******************/
$this->db->select('*'); 
$this->db->from('did_routing_ivr');
$this->db->where('tenant_id',$_SESSION['user_id']);
if($_SESSION['site_id'] != 'All'){
 $this->db->where('site_id',$_SESSION['site_id']);
}
$this->db->where('did',$value->did);
$this->db->where('off_days',$value->off_days);
$query = $this->db->get();
$rout_ivr   = $query->result();
$i = 1; $off_time = '';
/*******************/
foreach ($rout_ivr as $key => $rout) {

$off_time .= $rout->off_time_choice.' ';

if($i == '1'){
 echo "IVRPRompt is  ".$rout->IVR_Prompt_file.", Ringing Time is ".$rout->ringingseconds."Sec.";
}else{
 echo $rout->ivr_level ." IVR is  ".$rout->IVR_Prompt_file.", Ringing Time is ".$rout->ringingseconds."Sec.";
}

echo "<br>";
if($rout->choice1 != ''){echo 'Press 1 For : '.str_replace('|', ' , ', $rout->choice1);echo ".<br>";}
if($rout->choice2 != ''){echo 'Press 2 For : '.str_replace('|', ' , ', $rout->choice2);echo ".<br>";}
if($rout->choice3 != ''){echo 'Press 3 For : '.str_replace('|', ' , ', $rout->choice3);echo ".<br>";}
if($rout->choice4 != ''){echo 'Press 4 For : '.str_replace('|', ' , ', $rout->choice4);echo ".<br>";}
if($rout->choice5 != ''){echo 'Press 5 For : '.str_replace('|', ' , ', $rout->choice5);echo ".<br>";}
if($rout->choice6 != ''){echo 'Press 6 For : '.str_replace('|', ' , ', $rout->choice6);echo ".<br>";}
if($rout->choice7 != ''){echo 'Press 7 For : '.str_replace('|', ' , ', $rout->choice7);echo ".<br>";}
if($rout->choice8 != ''){echo 'Press 8 For : '.str_replace('|', ' , ', $rout->choice8);echo ".<br>";}
if($rout->choice9 != ''){echo 'Press 9 For : '.str_replace('|', ' , ', $rout->choice9);echo ".<br>";}

echo "(noanswer) Land to Voice Mail ". str_replace('|', ' , ', $rout->default_choice);
echo ".<br>"; 
echo "Default Ring " .str_replace('|', ' , ', $rout->default_choice);
echo ".<br><br>";
$i++;
} // sub loop
?>
</div>
</td>
<td> 
<?php echo 'Out of office hours';
echo "<br>";
echo 'lands to '.str_replace('|', ' , ', $off_time);
 ?>.
</td>
<tr>
</tbody>
</table>
<?php } } ?>
<!--- DID IVR ROUTING END---->

<!--- DID TRUNK ROUTING ---->
<?php if(count($did_ivr)){ foreach ($did_ivr as $value) {?>
<table class="table table-striped table-bordered table-sm" cellspacing="0">
<thead>
<tr>
<th class="th-sm" style="width: 1%">DID</th>
<th class="th-sm" style="width: 20%">Timing</th>
<th class="th-sm" style="width: 40%">Routing</th>
</tr>
</thead>
<tbody>
<td><b><?php echo $value->did_number ?></b></td>
<td><b>For 24 Hours</b></td>
<td>Rings <?php echo str_replace('|', ' , ', $value->extension) ?> for 20 seconds.<br>
 then<br>
<?php $ext = preg_split('#[-]#', $value->extension);

?>
 lands in voicemail <?php if(isset($ext)){echo $ext[0];}else{substr($value->extension,1,strrpos($value->extension,"-"));} //echo str_replace('|', ' , ', $value->extension)?>
.</td>
<tr>
</tbody>
</table>
<?php } } ?>
<!--- DID TRUNK ROUTING END ---->


</div>
<!-- Grid row -->
