<?php $this->load->view('/components/page_head') ?>

<div class="row">
<div class="col-md-3"></div>
<div class="col-md-6"><h1 class="font-weight-bold text-center my-4">Import Data</h1></div>
<div class="col-md-3">
<a href="http://www.bizrtc.com" target="_blank">  <img src="<?php echo site_url('images/bizrtc.png'); ?>" style="height:100px; width: 260px; float: right;  "></a>
</div>
</div>

<div class="col-md-12" style="margin-top: -20px"><hr></div>

<form method="post" action="" enctype="multipart/form-data" >
<div class="row">

<div class="col-md-4"></div>
<div class="col-md-4"> 	
<div class="col-md-12 card p-3" style="height: 400px;overflow-y: scroll;"> 	
<p><b>1. Account Code Sheet</b></p>
<div class="input-group">
<div class="custom-file">
<input type="file" class="custom-file-input" id="account" name="account" aria-describedby="inputGroupFileAddon01">
<label class="custom-file-label" for="account">Choose file</label>
</div>
</div>


<p><b>2. Tenant Details Sheet</b></p>
<div class="input-group">
<div class="custom-file">
<input type="file" class="custom-file-input" id="tenant_details" name="tenant_details" aria-describedby="inputGroupFileAddon01">
<label class="custom-file-label" for="tenant_details">Choose file</label>
</div>
</div>


<p class="mt-2"><b>3. Trunk Details Sheet</b></p>
<div class="input-group">
<div class="custom-file">
<input type="file" class="custom-file-input" id="trunk" name="trunk" aria-describedby="inputGroupFileAddon01">
<label class="custom-file-label" for="trunk">Choose file</label>
</div>
</div>

<p class="mt-2"><b>4. Trunk DID Details Sheet</b></p>
<div class="input-group">
<div class="custom-file">
<input type="file" class="custom-file-input" id="didmaster" name="didmaster" aria-describedby="inputGroupFileAddon01">
<label class="custom-file-label" for="didmaster">Choose file</label>
</div>
</div>

<!--p class="mt-2"><b>5. E911 Sheet</b></p>
<div class="input-group">
<div class="custom-file">
<input type="file" class="custom-file-input" id="e911" name="e911" aria-describedby="inputGroupFileAddon01">
<label class="custom-file-label" for="e911">Choose file</label>
</div>
</div-->

<p class="mt-2"><b>5. DID IVR Routing Sheet</b></p>
<div class="input-group">
<div class="custom-file">
<input type="file" class="custom-file-input" id="did_ivr" name="did_ivr" aria-describedby="inputGroupFileAddon01">
<label class="custom-file-label" for="did_ivr">Choose file</label>
</div>
</div>

<p class="mt-2"><b>6. Tenant Branch Sheet</b></p>
<div class="input-group">
<div class="custom-file">
<input type="file" class="custom-file-input" id="tenant" name="tenant" aria-describedby="inputGroupFileAddon01">
<label class="custom-file-label" for="tenant">Choose file</label>
</div>
</div>

<p class="mt-2"><b>7. Extension Sheet</b></p>
<div class="input-group">
<div class="custom-file">
<input type="file" class="custom-file-input" id="ext_no" name="ext_no" aria-describedby="inputGroupFileAddon01">
<label class="custom-file-label" for="ext_no">Choose file</label>
</div>
</div>

<p class="mt-2"><b>8. Outgoing Block Sheet</b></p>
<div class="input-group">
<div class="custom-file">
<input type="file" class="custom-file-input" id="out_block_no" name="out_block" aria-describedby="inputGroupFileAddon01">
<label class="custom-file-label" for="out_block_no">Choose file</label>
</div> 
</div>

<p class="mt-2"><b>9. Incoming Block Sheet</b></p>
<div class="input-group">
<div class="custom-file">
<input type="file" class="custom-file-input" id="in_block_no" name="in_block" aria-describedby="inputGroupFileAddon01">
<label class="custom-file-label" for="in_block_no">Choose file</label>
</div>
</div>
</div>

<div class="col-md-12"><hr>
<input type="submit" name="import" value="Import" class="btn btn-primary btn-sm"> 
</div>
</div>


</div>

</form>

<?php $this->load->view('/components/page_tail') ?>
<?php  $this->load->view('widgets/_layout_footer') ?>
