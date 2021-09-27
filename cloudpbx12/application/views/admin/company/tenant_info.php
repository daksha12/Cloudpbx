<!--================================ 
- DATA FETCH FROM PAGE TAIL 
- ALL JS FUNCTION SET IN PAGE TAIL
==================================-->

  <div class="col-md-6 mt-2">
  <table class="table table-striped table-bordered table-sm" cellspacing="0">
  <thead><tr><th class="th-sm" colspan="2">Company Details</th></tr></thead>
  <tr><th class="th-sm" style="width: 50%">Company Name</th><td><b><?php echo $tenant_details->tenant_name ?></b></td></tr>
  <tr><th class="th-sm">Account Code</th><td><b><?php echo get_account_code($tenant_details->account_id); ?></b></td></tr>
  <tr><th class="th-sm">Site Key</th><td><b><?php echo get_account_sitekey($tenant_details->account_id) ?></b></td></tr>
  <tr><th class="th-sm">Email ID</th><td><b><?php echo $tenant_details->email ?></b></td></tr>
  <tr><th class="th-sm">Contact Person</th><td><b><?php echo $tenant_details->contat_person ?></b></td></tr>
  <tr><th class="th-sm">County Code</th><td><b><?php echo $tenant_details->country_code ?></b></td></tr>
  <tr><th class="th-sm">Phone</th><td><b><?php echo $tenant_details->phone ?></b></td></tr>
  
  </table>
  </div>
  <!-- Grid row -->
  
  <div class="col-md-6 mt-2">
  <table class="table table-striped table-bordered table-sm" cellspacing="0">
  <thead><tr><th class="th-sm" colspan="2">Sales Details</th></tr></thead>
  <tr><th class="th-sm" style="width: 50%">Sales Name</th><td><b><?php echo $sales_details->first_name ?> <?php echo $sales_details->last_name ?></b></td></tr>
  <tr><th class="th-sm">Phone Number</th><td><b><?php echo $sales_details->phone ?></b></td></tr>
  
  </table>
  </div>
  <!-- Grid row -->
  
