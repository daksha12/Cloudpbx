<!--================================ 
- DATA FETCH FROM PAGE TAIL 
- ALL JS FUNCTION SET IN PAGE TAIL
==================================-->

<!-- Section: Analytical panel -->
 <?php 
 foreach ($site_data as $key => $value) {
  $extension = substr($value->park_extension, 0, -3);
?>
<div class="col-md-4">
 <table class="table table-striped table-bordered table-sm" cellspacing="0">
  <thead>
    <tr>
      <th class="th-sm text-center" colspan="2" style="background: #000;"><?php echo ucfirst($value->site_name); ?></th>
    </tr>
    <tr>
      <th class="th-sm">Feature</th>
      <th class="th-sm">Dial</th>
    </tr>
  </thead>
  <div>
  <tbody>
    <tr>
      <td>Call Forward Unconditional Set</td>
      <td><?php echo $extension ?>66</td>
    </tr>
    <tr>
      <td>Call Forward UnAvailable Unset</td>
      <td> <?php echo $extension ?>67</td>
    </tr>
    <tr>
      <td>Call Forward UnAvailable Set</td>
      <td> <?php echo $extension ?>68</td>
    </tr>
    <tr>
      <td>Call Forward UnAvailable Unset </td>
      <td> <?php echo $extension ?>69</td>
    </tr>
    <tr>
      <td> Listen </td>
      <td> <?php echo $extension ?>222</td>
    </tr>
    <tr>
      <td> Wishper</td>
      <td> <?php echo $extension ?>223</td>
    </tr>
    <tr>
      <td> Barge</td>
      <td> <?php echo $extension ?>224</td>
    </tr>
    <tr>
      <td> Conference PIN Set</td>
      <td> <?php echo $extension ?>201</td>
    </tr>
    <tr>
      <tr>
      <td> Conference PIN UNSET</td>
      <td> <?php echo $extension ?>202</td>
    </tr>
    <tr>
      <td> To Know Conference PIN</td>
      <td> <?php echo $extension ?>203</td>
    </tr>
    <tr>
      <td> CONFERENCE INTERNAL NUMBER</td>
      <td> <?php echo $extension ?>200</td>
    </tr>
    <tr>
      <td> PARKING Extesion</td>
      <td> <?php echo $extension ?>800</td>
    </tr>
  </tbody>
</div>
</table>
</div>
<?php } ?>
<!-- Grid row -->
</div>
<!-- Grid row -->
