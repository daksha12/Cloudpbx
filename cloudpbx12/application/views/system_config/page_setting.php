
<form class="text-center" style="color: #757575;" method="post" action="" id="e911_form" onsubmit="savedata()">    
<div id="table" class="table-editable" style="overflow: scroll;height: 300px"><div>
<table class="table table-bordered table-responsive-md table-striped text-center" id="page_setting">
<!-- Table head -->
<thead>
<tr>      
 <th class="text-center">#</th>
 <th class="text-center">Page parameter</th>
</tr>
</thead>
<!-- Table head -->

<!-- Table body -->
<tbody>
	<?php
	$cnt = 1;
	if(!empty($page_setting_List)){		
		foreach ($page_setting_List as $key => $page_setting) {		   
		   ?>
		   <tr class="page_setting_div">

			<td class="pt-3-half" style="vertical-align: inherit;">
			<a href="#" class="remove-trunk"><i class="fas fa-trash"></i></a>		 	
			</td>
  	
  			<input type="hidden" name="old_page_setting_id[<?php echo $cnt;?>]" class="old_value_hidden" value="<?php echo $page_setting->id;?>">

		    <td class="pt-3-half" style="vertical-align: inherit;"><input type="text" placeholder="Page Parameter Name" name="pageparameter[<?php echo $cnt;?>]" id="pageparameter[<?php echo $cnt;?>]" value="<?php echo $page_setting->pageparameter;?>" class="page_setting_first avoid_space" style="width:100%"></td>	
			</tr>
		<?php
		 $cnt++;
	   }
	}
	?>

	  <tr class="page_setting_div">		
		<td class="pt-3-half" style="vertical-align: inherit;">
		  <a href="#" class="remove-trunk"><i class="fas fa-trash"></i></a>
		</td>

		<td class="pt-3-half" style="vertical-align: inherit;"><input type="text" placeholder="Page Parameter Name" name="pageparameter[<?php echo $cnt;?>]" id="pageparameter[<?php echo $cnt;?>]" value="" class="page_setting_first avoid_space" style="width:100%"></td>
	  </tr>

</tbody>
<!-- Table body -->
</table>
</div>
</div>			

<div class="col-md-12" style="text-align: left;"><hr> 
<input type="submit" class="waves-effect waves-dark btn btn-sm btn-primary" name="save_page_setting" value="Save">
</div>
</form>
