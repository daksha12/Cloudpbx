<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Demo_data extends MY_Controller {

	public function index()
	{
	    $this->load->view('components/page_head');

		?>

		<table width="100%" border="0" cellspacing="0" cellpadding="0" id="table-data">
		<tr>
		<td>SelectOne</td>
		<td>Select two</td>
		<td>TetxBox</td>
		<td>Select Three</td>
		<td>Add</td>
		</tr>
		<tr>
		<td>
		<select id="Id.0" name="Id.0">
		<option value=1>One</option>
		<option value=2>Two</option>
		</select>
		</td>
		<td>
		<select id="Comparator.0" name="Comparator.0">
		<option value=1>One</option>
		<option value=2>Two</option>
		</select>
		</td>
		<td><input type="text" id="Integer.0" name="Integer.0"/></td>
		<td>
		<select id="Value.0" name="Value.0">
		<option value=1>One</option>
		<option value=2>Two</option>
		</select>
		</td>
		<td><input type="button" class="addButton" value="Add" /></td>
		</tr>
		</table>
		<script type="text/javascript">
			
			$("#table-data").on('click', 'input.addButton', function() {
			var $tr = $(this).closest('tr');
			var allTrs = $tr.closest('table').find('tr');
			var lastTr = allTrs[allTrs.length-1];
			var $clone = $(lastTr).clone();
			$clone.find('td').each(function(){
			var el = $(this).find(':first-child');
			var id = el.attr('id') || null;
			if(id) {
			var i = id.substr(id.length-1);
			var prefix = id.substr(0, (id.length-1));
			el.attr('id', prefix+(+i+1));
			el.attr('name', prefix+(+i+1));
			}
			});
			$clone.find('input:text').val('');
			$tr.closest('table').append($clone);
			});

			$("#table-data").on('change', 'select', function(){
			var val = $(this).val();
			$(this).closest('tr').find('input:text').val(val);
			});
			
		</script>
		<?php
		$this->load->view('components/page_tail');
	}

	public function Demo()
	{
		 $this->load->view('system_config_demo/system_config');
	}
}s
