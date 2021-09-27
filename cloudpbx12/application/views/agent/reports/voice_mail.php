<!--================================ 
- DATA FETCH FROM PAGE TAIL 
- ALL JS FUNCTION SET IN PAGE TAIL
==================================-->

  <!-- Section: Analytical panel -->
  <div class="col-md-12">
  <form method="post" action="voice_list">
  <input type="hidden" name="extension" value="<?php echo $extension ?>,<?php echo $site ?>">
  <div class="row">

  <div class="col-md-3 select-outline" style="margin-top: -17px">
  <select class="mdb-select md-form md-outline colorful-select dropdown-primary" name="mail_type" required="">
  <option value="" disabled selected>Choose Type</option>
  <option value="INBOX" <?php if('INBOX' == $mail_type || $mail_type == '') {echo "selected";} ?>>Inbox</option>
  <option value="Old" <?php if('Old' == $mail_type) {echo "selected";} ?>>Archive</option>
  </select>
  <label>Select Mail type</label>
  </div>
  <div class="col-md-3">
  <input type="submit" name="search" value="Search" class="btn btn-primary btn-sm">
  </div>

  <div class="col-md-6">
  <a  href="<?php echo site_url('LocalResponse/voice_mail_export/'.$site.'/'.$extension.'/'.$mail_type) ?>" class="btn btn-primary btn-sm" style="float: right;"><i class="fas fa-download"></i> Export</a>
  <a  href="<?php echo site_url('LocalResponse/download_mail/'.$site.'/'.$extension.'/'.$mail_type) ?>" class="btn btn-primary btn-sm" style="float: right;"><i class="fas fa-download"></i> Download All</a>
  <a class="btn btn-primary btn-sm disabled" id="download_mail" style="float: right;"><i class="fas fa-download"></i> Download</a>
  </div>

  </div>
  </form>

  <hr style="margin-top: 2px;">
  </div>

  <div class="col-md-12 mt-2">
  <table id="voice_mail_data" class="table table-striped table-bordered table-sm text-center" cellspacing="0">
  <thead>
  <tr>
  <th class="th-sm">
    <!--div class="custom-control custom-checkbox">
      &nbsp;&nbsp;&nbsp;
      <input type="checkbox" class="custom-control-input" id="selectAll" name="select_all">
      <label class="custom-control-label" for="selectAll"></label>
    </div-->
    &nbsp;&nbsp;&nbsp;#
  </th>
  <th class="th-sm">Call Date</th>
  <th class="th-sm">Caller</th>
  <th class="th-sm">Recipients</th>
  <th class="th-sm">Voice Mail</th>
  <th class="th-sm" data-trigger="hover" data-toggle="tooltip" data-placement="top" title="" data-content="(HH:MM:SS)" data-original-title="(HH:MM:SS)">Duration</th>
  </tr>
  </thead>
  </table>
  </div>
  <!-- Grid row -->
  </div>
  <!-- Grid row -->
