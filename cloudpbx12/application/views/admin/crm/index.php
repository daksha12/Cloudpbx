<!--================================ 
- DATA FETCH FROM PAGE TAIL 
- ALL JS FUNCTION SET IN PAGE TAIL
==================================-->

<div class="col-md-12" >

<form method="post" action="" enctype="multipart/form-data" >
<input type="hidden" class="form-control" name="id" value="<?php echo $crmip->id; ?>">

<div class="row">
<div class="col-md-4"></div> 	
<div class="col-md-4 card"> 	


<div class="md-form md-outline">
<b>CRM IP</b>
<input type="text" class="form-control" id="crmip" name="crmip" aria-describedby="inputGroupFileAddon01" required="" value="<?php echo $crmip->crm_ip; ?>">
</div>

<div class="md-form md-outline">
<b>Account Code</b>
<input type="text" class="form-control" id="accountcode" name="accountcode" aria-describedby="inputGroupFileAddon01" required="" readonly="" value="<?php echo $code; ?>">
</div>

<div class="md-form md-outline">
<b>Tenant Name</b>
<input type="text" class="form-control" id="tenantname" name="tenantname" aria-describedby="inputGroupFileAddon01" required="" readonly="" value="<?php echo $_SESSION['username'] ?>">
</div>


<div class="col-md-12"><hr>
<input type="submit" name="save" value="Save" class="btn btn-primary btn-sm"> 
</div>
<br>
</div>

<?php if($crmip->id != ''){ ?>
<div class="col-md-4"> 
	<p class="alert alert-danger" style="border-left: 6px solid #f9a0a8;border-radius: 5px;">Token no is :<br> <?php echo $crmip->token_number ?>
</div>
<?php } ?>

</div>

</form>