<!--================================ 
- DATA FETCH FROM PAGE TAIL 
- ALL JS FUNCTION SET IN PAGE TAIL
==================================-->

<div class="col-md-12">
<form method="post" action="">
<div class="row">


<div class="col-md-2 select-outline" style="margin-top: -17px">
<div class="md-form md-outline">
<input placeholder="Selected date" type="text" id="fromdate" value="<?php echo $_SESSION['fromdate'] ?>" name="fromdate" class="form-control datepicker" onchange="date_val()">
<label for="fromdate">From Date</label>
</div>
</div>

<div class="col-md-2 select-outline" style="margin-top: -17px">
<div class="md-form md-outline">
<input placeholder="Selected date" type="text" id="todate" name="todate" value="<?php echo $_SESSION['todate'] ?>" name="fromdate" class="form-control datepicker" onchange="date_val()">
<label for="todate">To Date</label>

</div>
</div>
<div class="col-md-1">
<input type="submit" name="search" value="Search" class="btn btn-primary btn-sm" id="search_date">
</div>

<div class="col-md-7">
<a href="<?php echo site_url('LocalResponse/cdr_report_export'); ?>" class="btn btn-primary btn-sm" style="float: right;"><i class="fas fa-download"></i> Export CDR</a>	
<a href="<?php echo site_url('LocalResponse/cdr_export_all'); ?>" class="btn btn-primary btn-sm" style="float: right;"><i class="fas fa-download"></i> Download All</a>
<button class="btn btn-primary btn-sm disabled" id="download_recordings" style="float: right;"><i class="fas fa-download"></i> Download</button>
</div>
</div>
</form>
<hr style="margin-top: 2px;">
</div>


<!-- Section: Analytical panel -->
<div class="col-md-12 mt-2">
<table id="cdr_data" class="table table-striped table-bordered table-sm text-center" cellspacing="0">
<thead>
<tr>
 <th class="th-sm">&nbsp;&nbsp;&nbsp;#</th>
 <th class="th-sm">Call Date</th>
 <th class="th-sm">Caller</th>
 <th class="th-sm">Recipients</th> 
 <th class="th-sm" data-trigger="hover" data-toggle="tooltip" data-placement="top" title="" data-content="(HH:MM:SS)" data-original-title="(HH:MM:SS)">Duration</th>
 <th class="th-sm">Recording</th>
 <th class="th-sm">Disposition</th>
 <th class="th-sm">DID Number</th>
</tr>
</thead>
</table>
</div>
<!-- Grid row -->
