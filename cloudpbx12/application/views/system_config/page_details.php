
<form class="text-center" style="color: #757575;" method="post" action="" id="e911_form" onsubmit="savedata()">    
<div id="table" class="table-editable" style="overflow: scroll;height: 300px"><div>
<table class="table table-bordered table-responsive-md table-striped text-center" id="page_details">

<!-- Table head -->
<thead>
<tr>      
 <th class="text-center">#</th>
 <th class="text-center">Page list name</th>
 <th class="text-center">Page command</th>
 <th class="text-center">Page members</th>
</tr>
</thead>
<!-- Table head -->

<!-- Table body -->
<tbody>
	<?php
	$cnt = 1;
	if(!empty($page_details_List)){		
		foreach ($page_details_List as $key => $page_detail) {		   
		   ?>
		   <tr class="page_details_div">

			<td class="pt-3-half" style="vertical-align: inherit;">
			<a href="#" class="remove-trunk"><i class="fas fa-trash"></i></a>		 	
			</td>
  	
  			<input type="hidden" name="old_page_details_id[<?php echo $cnt;?>]" class="old_value_hidden" value="<?php echo $page_detail->id;?>" required>

		    <td class="pt-3-half" style="vertical-align: inherit;"><input type="text" placeholder="Page List Name" name="pagelistname[<?php echo $cnt;?>]" id="pagelistname[<?php echo $cnt;?>]" value="<?php echo $page_detail->pagelistname;?>" class="page_details_first avoid_space" style="width:100%" required></td>

		    <td class="pt-3-half" style="vertical-align: inherit;"><input type="text" placeholder="Page Command" name="pagecommand[<?php echo $cnt;?>]" id="pagecommand[<?php echo $cnt;?>]" value="<?php echo $page_detail->pagecommand;?>" class="avoid_space" style="width:100%" required></td>

		    <td class="pt-3-half" style="vertical-align: inherit;"><input type="text" placeholder="Page Members" name="pagemembers[<?php echo $cnt;?>]" id="pagemembers[<?php echo $cnt;?>]" value="<?php echo $page_detail->pagemembers;?>" class="avoid_space" style="width:100%" required></td>
			
			</tr>
			<?php
			$cnt++;
		}
	}
	?>

	  <tr class="page_details_div">
		<td class="pt-3-half" style="vertical-align: inherit;">
		  <a href="#" class="remove-trunk"><i class="fas fa-trash"></i></a>
		</td>

		<td class="pt-3-half" style="vertical-align: inherit;"><input type="text" placeholder="Page List Name" name="pagelistname[<?php echo $cnt;?>]" id="pagelistname[<?php echo $cnt;?>]" value="" class="page_details_first avoid_space" style="width:100%" required></td>

		<td class="pt-3-half" style="vertical-align: inherit;"><input type="text" placeholder="Page Command" name="pagecommand[<?php echo $cnt;?>]" id="pagecommand[<?php echo $cnt;?>]" value="" class="avoid_space" style="width:100%" required></td>

		<td class="pt-3-half" style="vertical-align: inherit;"><input type="text" placeholder="Page Members" name="pagemembers[<?php echo $cnt;?>]" id="pagemembers[<?php echo $cnt;?>]" value="" class="avoid_space" style="width:100%" required></td>

	</tr>

</tbody>
<!-- Table body -->
</table>
</div>
</div>			

<div class="col-md-12" style="text-align: left;"><hr> 
<input type="submit" class="waves-effect waves-dark btn btn-sm btn-primary" name="save_page_details" value="Save">
</div>
</form>
