<?php $this->load->view('/components/page_head') ?>

<body>

<div class="row">
	<div class="col-md-12">

	<div class="col-md-3" style="float: left;">
		
	</div>
	
	<div class="col-md-6" style="border:none;">
     <h3 style="font-family: Century, Tahoma, Arial, Verdana, Georgia;
               font-size: 25pt; text-align: center; font-weight: 800;"> <?php echo $portal_name; ?> </h3>
    </div>

    <div class="col-md-3" style="float: right;">
    <img src="<?php echo site_url('images/bizrtc.png'); ?>" style="height:100px; width: 260px;" >
    </div>
	

	</div>

</div>


<nav class="navbar navbar-default" style="box-shadow:0px 22px 64px 0px #C3DDE8; background-color: black;" >
<ul class="nav navbar-nav navbar-right">
        
    <li><a href="#"><?php echo date("M d,Y") ; ?></a></li>
    
  </ul>
</nav>
		

<style type="text/css">
.verticalLine 
{
border-left: thick solid gray;
height: 240px;
margin-left: 234px;	
}
</style>

	

	<div class="modal-dialog">
		<div class="modal-content" style="border: 4px solid #008ade;">
		<?php $this->load->view($subview); // Subview is set in controller ?>
		<div class="modal-footer">
			
			&copy; <?php echo date('Y'); ?> <?php echo $portal_name; ?>
		</div>
		</div>
	</div>


<style type="text/css">
	li
	{
		font-size: 11px;
		text-align: left;
	}
</style>


	

<div class="col-md-3" style="float:right; margin-top:20px;">
  
  
    <h3 class="panel-title">Supported Browsers</h3>
	<ul>
	<li>Microsoft Edge 38.14393.0.0</li>
    <li data-toggle="tooltip" data-html="true" title="Edge">Internet Explorer 11.51.14393.0</li>
    <li>Google Chrome 52.0.2743.116m  </li>
    <li>Safari 10.0.1</li>
    <li>Firefox 47.0</li>

    </ul>
  
</div>

		</div>
	</div>

<style type="text/css">
	tr:nth-child(even) 
	{
		background: transparent;

	}
	tr:nth-child(odd) 
	{
		background:transparent;

	}
</style>

<script type="text/javascript">
  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
<?php $this->load->view('/components/page_tail'); ?>