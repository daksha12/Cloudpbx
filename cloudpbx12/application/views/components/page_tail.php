<script type="text/javascript" src="<?php echo site_url('/assets/sweetalert2/sweetalert2.all.js') ?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/js/jquery-3.2.1.min.js'); ?>"></script>   

<script type="text/javascript" src="<?php echo site_url('assets/js/popper.min.js'); ?>"></script>         
<script type="text/javascript" src="<?php echo site_url('assets/js/bootstrap.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/js/mdb.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/datatables/datatables.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/js/bootstrap-notify.js'); ?>"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="<?php echo site_url('assets/jquery-ui/jquery-ui.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/js/jquery.validate.js'); ?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/js/form-validation.js'); ?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/js/addons-pro/stepper.min.js');?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/js/mdb-file-upload.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/dropzone/dropzone.js');?>"></script>

<script type="text/javascript">
      function SetupConfiguration(tenant_id,site_id,account_id){
        $("#overlay").css("display", "block");
        $(".spinner").show(); 
        $.ajax({
            url: "<?php echo site_url('System_configuration/export'); ?>",
            type: "POST",
            data:{tenant_id:tenant_id,site_id:site_id,account_id:account_id},
            cache: false,
            success: function(data){
              $("#overlay").css("display", "none");
                 if(data == 'success'){
                   swal({title: "Success", text: "Account Setup Successfully", type: "success"
                    },function(isConfirm){ 
                        if(isConfirm){
                           window.location="<?php echo base_url();?>/System_configuration";
                        }
                    });
                 }else{
                  console.log('error');
                  swal("Error!", "Incomplete Data", "error");
                 }
            }
        });
    
      }
        
    
</script> 


<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>

<script type="text/javascript">
$('.datepicker').pickadate({
format: 'yyyy-mm-dd',
formatSubmit: 'yyyy-mm-dd',
hiddenPrefix: 'prefix__',
hiddenSuffix: '__suffix'
})
</script>

<!-- caller Id Block -->

<script>
<?php if($this->uri->segment(3)=="Caller_id_block"){?>
   
  $(document).ready(function(){
    $('#dt-basic-checkbox').DataTable({
        "pagingType": "simple_numbers",
        lengthMenu: [[4, 10, 20, -1], [4, 10, 20, 'Todos']],
        "bSort" : false,
      });
    
    $('#dt-basic-outbound').dataTable({
        "pagingType": "simple_numbers",
        lengthMenu: [[4, 10, 20, -1], [4, 10, 20, 'Todos']],
        "bSort" : false, 
      });

    var maxField = 10; 
    var addButton = $('.inbound_did'); 
    var wrapper = $('.field_wrapper'); 
    var fieldHTML = '<tr><td><input type="text" class="form-control" name="did_no[]" id="did_no[]" value="" placeholder="DID Number" pattern="[0-9]+" required ></td><td><input type="hidden" id="inbounddid<?php echo $inbound_did; ?>" class="form-control" name="key_data[]" value="/CIG_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>/<?php echo $inbound_did ?>"><input type="text" class="form-control" name="value_data[]" id="did" value="" placeholder="Number" required></td><td><a class="edit-branch remove_button"> <h4> <i class="fas fa-trash" style="margin-top: 12px;"> </i> </h4> </a></td></tr>'; 
    var x = 1; 
    $(addButton).click(function(){
        if(x < maxField){ 
            x++; 
            $(wrapper).append(fieldHTML); 
        }
    });
    
  
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent().parent().remove();
        x--;
    });
    $("#dt-basic-checkbox").delegate(".remove-inbound", "click", function(){
      var id = $(this).closest('tr').find("#inbound_key_value").val();
      var family_name = $(this).closest('tr').find("#old_key_data_inbound").val();
      var ele =$(this).parent().parent().remove();
      $.ajax({
          url:"<?php echo base_url();?>Admin/Call_forward/Caller_id_block",
          data:{id:id,family_name:family_name},
          type:"POST",
          success:function(data){
            
                 ele.fadeOut().remove();
                 window.location.href="<?php echo base_url();?>Admin/Call_forward/Caller_id_block/1";
            

          }
      });
    });
  });
  $(document).ready(function(){
    var maxField = 10; 
    var addButton = $('.outbound_did'); 
    var wrapper = $('.caller_outbound_data'); 
    var fieldHTML = '<tr><td><input type="text" class="form-control" name="out_did_no[]" id="out_did_no[]" value="" placeholder="DID Number" pattern="[0-9]+" required></td><td><input type="hidden" id="inbounddid<?php echo $inbound_did; ?>" class="form-control" name="out_data[]" value="/COG_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>"><input type="text" class="form-control" name="out_value_data[]" id="out_did" value="" onKeyDown="if(event.keyCode === 32) return false;" placeholder="Number" required ></td><td><a class="edit-branch remove_button"> <h4> <i class="fas fa-trash" style="margin-top: 12px;"> </i> </h4> </a></td></tr>'; 
    var x = 1; 
    $(addButton).click(function(){
        if(x < maxField){ 
            x++; 
            $(wrapper).append(fieldHTML); 
        }
    });
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent().parent().remove();
        x--;
    });
    $("#dt-basic-outbound").delegate(".remove-outbound", "click", function(){
      var id = $(this).closest('tr').find("#outbound_key_value").val();
      var family_name = $(this).closest('tr').find("#old_key_outbound_data").val();
      var ele =$(this).parent().parent().remove();
      $.ajax({
          url:"<?php echo base_url();?>Admin/Call_forward/Caller_id_block",
          data:{id:id,family_name:family_name},
          type:"POST",
          success:function(data){
                 ele.fadeOut().remove();
                  window.location.href="<?php echo base_url();?>Admin/Call_forward/Caller_id_block/2";
             

          }
      });
    });
  });
<?php  } ?>
/*Conference */
<?php if($this->uri->segment(3)=="Conference_pin"){?>
  $(document).ready(function(){
     $('#dt-basic-pin4').dataTable({
           "pagingType": "simple_numbers",
            lengthMenu: [[4, 10, 20, -1], [4, 10, 20, 'Todos']],
            "bSort" : false,
    });
    $("#dt-basic-pin4").delegate(".remove-conf4", "click", function(){
      var id = $(this).closest('tr').find("#key_data_conf4").val();
      var family_name = $(this).closest('tr').find("#old_key_Conf4_data").val();
      var ele =$(this).parent().parent().remove();
      $.ajax({
          url:"<?php echo base_url();?>Admin/Call_forward/Conference_pin",
          data:{id:id,family_name:family_name},
          type:"POST",
          success:function(data){
              ele.fadeOut().remove();
              window.location.href="<?php echo base_url();?>Admin/Call_forward/Conference_pin/4";

          }
      });
    });
  });
 $(document).ready(function(){
    $('#dt-basic-pin8').dataTable({ "pagingType": "simple_numbers",
        lengthMenu: [[4, 10, 20, -1], [4, 10, 20, 'Todos']],
        "bSort" : false,
    });
    $("#dt-basic-pin8").delegate(".remove-conf8", "click", function(){
      var id = $(this).closest('tr').find("#key_data_conf8").val();
      var family_name = $(this).closest('tr').find("#old_key_Conf8_data").val();
      var ele =$(this).parent().parent().remove();
      $.ajax({
          url:"<?php echo base_url();?>Admin/Call_forward/Conference_pin",
          data:{id:id,family_name:family_name},
          type:"POST",
          success:function(data){
              ele.fadeOut().remove();
              window.location.href="<?php echo base_url();?>Admin/Call_forward/Conference_pin/8";

          }
      });
    });
  });
  $(document).ready(function(){
    $('#dt-basic-pin16').dataTable({ "pagingType": "simple_numbers",
        lengthMenu: [[4, 10, 20, -1], [4, 10, 20, 'Todos']],
        "bSort" : false,
    });
    $("#dt-basic-pin16").delegate(".remove-conf16", "click", function(){
      var id = $(this).closest('tr').find("#key_data_conf16").val();
      var family_name = $(this).closest('tr').find("#old_key_Conf16_data").val();
      var ele =$(this).parent().parent().remove();
      $.ajax({
          url:"<?php echo base_url();?>Admin/Call_forward/Conference_pin",
          data:{id:id,family_name:family_name},
          type:"POST",
          success:function(data){
                 ele.fadeOut().remove();
                 window.location.href="<?php echo base_url();?>Admin/Call_forward/Conference_pin/16";

          }
      });
    });
  });
<?php  } ?>

<?php if($this->uri->segment(3)=="speed_dial"){
  $branch_ext = getExtensionData($_SESSION['user_id'],$_SESSION['site_id']);?>
  $(document).ready(function(){
    $('#dt-basic-ext').DataTable({
        "pagingType": "simple_numbers",
        lengthMenu: [[4, 10, 20, -1], [4, 10, 20, 'Todos']],
        "bSort" : false,
      } );

      var maxField = 10; 
      var addButton = $('.ext_speed_dial'); 
      var wrapper = $('.field_wrapper'); 
      var fieldHTML = '<tr><td><input type="text" class="form-control" name="ext_did[]" id="ext_did[]" value="" placeholder="EXT Speed Dial " pattern="[*0-9]+" onKeyDown="if(event.keyCode === 32) return false;" required></td><td><input type="hidden" id="extdid" class="form-control" name="ext_data[]" value="/SPDext_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>"><select name="extension[]" id="extension" class="mdb-select md-form md-outline colorful-select dropdown-primary" required=""><option value="" selected>Extension</option><?php if(!empty($branch_ext)){foreach ($branch_ext as $value) { ?><option value="<?php echo $value->extension ?>"><?php echo $value->extension; ?></option><?php } } ?></select></td><td><a class="edit-branch remove_button"> <h4> <i class="fas fa-trash" style="margin-top: 12px;"> </i> </h4> </a></td></tr>'; 
      var x = 1; 
      $(addButton).click(function(){
          if(x < maxField){ 
              x++; 
              $(wrapper).append(fieldHTML); 
          }
      });
      
    
      $(wrapper).on('click', '.remove_button', function(e){
          e.preventDefault();
          $(this).parent().parent().remove();
          x--;
      });
  $("#dt-basic-ext").delegate(".remove-ext", "click", function(){
      var id = $(this).closest('tr').find("#exte_key_value").val();
      var family_name = $(this).closest('tr').find("#old_ext_key_data").val();
      var ele =$(this).parent().parent().remove();
        $.ajax({
            url:"<?php echo base_url();?>Admin/Call_forward/Speed_dial",
            data:{id:id,family_name:family_name},
            type:"POST",
            success:function(data){
                ele.fadeOut().remove();
                  //location.reload();
                  window.location.href="<?php echo base_url();?>Admin/Call_forward/speed_dial";

            }
        });
      });
  });
  $(document).ready(function(){
     $('#dt-basic-prefixpstn').dataTable({"pagingType": "simple_numbers",
        lengthMenu: [[4, 10, 20, -1], [4, 10, 20, 'Todos']],
        "bSort" : false,
     });
    var maxField = 10; 
    var addButton = $('.prefix_did'); 
    var wrapper = $('.field_wrapper'); 
    var fieldHTML = '<tr><td><input type="text" class="form-control" name="pstn_prefix_no[]" id="pstn_prefix_no[]" value="" placeholder="PSTN Prefix Speed Dial" pattern="[0-9]+" required></td><td><input type="hidden" id="prefix_key_data[]" class="form-control" name="prefix_key_data[]" value="/SPDpfxpstn_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>"><input type="text" class="form-control" name="prefix_value_data[]" id="prefix_value_data[]" value="" onKeyDown="if(event.keyCode === 32) return false;" placeholder="Number" required></td><td><a class="edit-branch remove_button"> <h4> <i class="fas fa-trash" style="margin-top: 12px;"> </i> </h4> </a></td></tr>'; 
    var x = 1; 
    $(addButton).click(function(){
        if(x < maxField){ 
            x++; 
            $(wrapper).append(fieldHTML); 
        }
    });
    
  
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent().parent().remove();
        x--;
    });
    $("#dt-basic-prefixpstn").delegate(".remove-prefix", "click", function(){
      var id = $(this).closest('tr').find("#prefix_key_value").val();
      var family_name = $(this).closest('tr').find("#old_key_prefixpstn_data").val();
      var ele =$(this).parent().parent().remove();
      $.ajax({
          url:"<?php echo base_url();?>Admin/Call_forward/Speed_dial",
          data:{id:id,family_name:family_name},
          type:"POST",
          success:function(data){
                ele.fadeOut().remove();
                  //location.reload();
                  window.location.href="<?php echo base_url();?>Admin/Call_forward/speed_dial/3";

          }
      });
    });
  });
   $(document).ready(function(){
    $('#dt-basic-pstn').dataTable({"pagingType": "simple_numbers",
        lengthMenu: [[4, 10, 20, -1], [4, 10, 20, 'Todos']],
        "bSort" : false,
     });

    var maxField = 10; 
    var addButton = $('.pstn_speed_dial'); 
    var wrapper = $('.pstn_field_wrapper'); 
    var fieldHTML = '<tr><td><input type="text" class="form-control" name="pstn_no[]" id="pstn_no[]" value="" placeholder="PSTN Number" pattern="[0-9]+"></td><td><input type="hidden" id="pstn_did" class="form-control" name="pstn_key_data[]" value="/SPDpstn_<?php echo $_SESSION['username'] ?>_<?php echo $_SESSION['site_name'] ?>"><input type="text" class="form-control" name="pstn_value_data[]" id="pstn_value_data[]" value="" onKeyDown="if(event.keyCode === 32) return false;" placeholder="Number"  ></td><td><a class="edit-branch remove_button"> <h4> <i class="fas fa-trash" style="margin-top: 12px;"> </i> </h4> </a></td></tr>'; 
    var x = 1; 
    $(addButton).click(function(){
        if(x < maxField){ 
            x++; 
            $(wrapper).append(fieldHTML); 
        }
    });
    
  
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent().parent().remove();
        x--;
    });
   $("#dt-basic-pstn").delegate(".remove-pstn", "click", function(){
      var id = $(this).closest('tr').find("#pstn_key_data").val();
      var family_name = $(this).closest('tr').find("#old_pstn_data").val();
      var ele =$(this).parent().parent().remove();
      $.ajax({
          url:"<?php echo base_url();?>Admin/Call_forward/Speed_dial",
          data:{id:id,family_name:family_name},
          type:"POST",
          success:function(data){
           
                 ele.fadeOut().remove();
                 window.location.href="<?php echo base_url();?>Admin/Call_forward/speed_dial/2";
            

          }
      });
    });
  });

<?php } ?>
  

</script>

<script type="text/javascript">  
$('.avoid_space').keypress(function( e ) {
    if(e.which === 32) 
        return false;
});
</script>

<script type="text/javascript">
$( window ).on( "load", function() {
var set = "<?php echo $_SESSION['pass_reset']; ?>";
if(set == 'Y'){
$('#change_pass').click()
}
call_manage(); // call mamage values
});
</script>

<script type="text/javascript">
function reset_pass(id){
 $('#agent_id').val(id);
 $('#agent_newpass').val('');
 $('#agent_conpass').val('');
 $("#agent_changepass").attr("disabled", false);
 $('#agent_pass').click()
}
</script>

<script type="text/javascript">
 function did_name_sql(didval,row){
 	var did = $('#inbounddid'+row).val();
 	var tenant = did.split("/");
 	var block = '/'+tenant[1]+'/'+didval;
    document.getElementById("inbounddid"+row).value = block;
    
    if(didval == ''){
	  document.getElementById("did"+row).value='';
	  document.getElementById("did"+row).readOnly = true;
	  document.getElementById("did"+row).required = false;
    }else{
    	document.getElementById("did"+row).value='';	
    	document.getElementById("did"+row).readOnly = false;
    	document.getElementById("did"+row).required = true;
    }
 }	
</script>

<script type="text/javascript">
 function spd_name_sql(didval,row){
 	var did = $('#spddial'+row).val();
 	var tenant = did.split("/");
 	var block = '/'+tenant[1]+'/'+didval;
    document.getElementById("spddial"+row).value = block;

    if(didval == ''){
	  document.getElementById("num"+row).value='';
	  document.getElementById("num"+row).readOnly = true;
	  document.getElementById("num"+row).required = false;
    }else{
    	document.getElementById("num"+row).readonly;
    	document.getElementById("num"+row).readOnly = false;
    	document.getElementById("num"+row).required = true;
    }
 }	
</script>


<script type="text/javascript">
 function spdext_name_sql(didval,row){
    var did = $('#spddial'+row).val();
    var tenant = did.split("/");
    var block = '/'+tenant[1]+'/'+didval;
    document.getElementById("spddial"+row).value = block;

    if(didval == ''){
      document.getElementById("numext"+row).value='';
      document.getElementById("numext"+row).readOnly = true;
      document.getElementById("numext"+row).required = false;
    }else{
        document.getElementById("numext"+row).readonly;
        document.getElementById("numext"+row).readOnly = false;
        document.getElementById("numext"+row).required = true;
    }
 }  
</script>


<script type="text/javascript">
function show_ext(id){ 
$.ajax({
url: "<?php echo site_url('LocalResponse/get_ext_details/'); ?>"+id,
type: "POST",
cache: false,
success: function(data){
$('#Show_ext').click()
var txt = data;
var obj = JSON.parse(txt);      
$('#display_name').html(obj.display_name);
$('#did_id').html(obj.outbound_did);
$('#recording_enabled').html(obj.call_recording);
$('#call_monitoring').html(obj.call_monitoring);
$('#presence_blf').html(obj.presence_blf);
$('#park_retrive').html(obj.park_retrive);
$('#mobility').html(obj.mobility);
$('#portal_access').html(obj.portal_access);
$('#synergy').html(obj.synergy); 
$('#voicemail_enabled').html(obj.voicemail_enabled);
$('#vm_email').html(obj.vm_email); 
$('#cfna').html(obj.CFNA); 
$('#cfyc').html(obj.CFUC); 
}
});
}
</script>

<script type="text/javascript">
    function import_data(data) {

       var checkBox = document.getElementById("import_check_"+data);
       if (checkBox.checked == true){
         $(".import_"+data).prop('disabled', false);
       } else {
         $(".import_"+data).prop('disabled', true);
         $(".import_"+data).val('');
       }
        
    }
</script>

<script type="text/javascript">
(function() {
'use strict';
window.addEventListener('load', function() {
// Fetch all the forms we want to apply custom Bootstrap validation styles to
var forms = document.getElementsByClassName('needs-validation');
// Loop over them and prevent submission
var validation = Array.prototype.filter.call(forms, function(form) {
form.addEventListener('submit', function(event) {
if (form.checkValidity() === false) {
event.preventDefault();
event.stopPropagation();
}
form.classList.add('was-validated');
}, false);
});
}, false);
})();
</script>

<script type="text/javascript">
function show_site(id){ 
$.ajax({    
url: "<?php echo site_url('LocalResponse/get_site_details/'); ?>"+id,
type: "POST",
cache: false,
success: function(data){
$('#Show_site').click()
var txt = data
var obj = JSON.parse(txt);      
$('#site_name').html(obj.site_name);
$('#country_code_site').html(obj.country_code);
$('#isd_allowed_site').html(obj.isd_allowed);
$('#park_retreive_site').html(obj.park_retreive);
$('#park_extension').html(obj.park_extension);
$('#parking_slot').html(obj.parking_slot);
$('#call_recording_site').html(obj.call_recording);
$('#call_monitoring_site').html(obj.call_monitoring);
$('#inter_branch_site').html(obj.inter_branch);
$('#cdr_timezone_site').html(obj.cdr_timezone);
$('#trunkprefix_site').html(obj.branch_prefix); 
$('#fax_did_site').html(obj.fax_did);
$('#fax_2_email_site').html(obj.fax_2_email); 
$('#site_admin_site').html(obj.site_admin); 
$('#site_address_site').html(obj.site_address); 
}
});
}
</script>

<script type="text/javascript">
$(document).ready(function () {

var table = $('#rate_card').DataTable({
"bLengthChange":true,
"processing": true,
"scrollY": 200,
"stateSave":true,
"deferRender": true,
"scroller" : true,
"ordering" : false,
"dom": '<lp<t>if>',

});
});
</script>


<script type="text/javascript">
$(document).ready(function () {

var table = $('#cdr_data').DataTable({
"bLengthChange":true,
"sAjaxSource": "<?php echo site_url('LocalResponse/cdr_json'); ?>",
"processing": true,
//"scrollY": 200,
"stateSave":true,
"deferRender": true,
//"scroller" : true,
"ordering" : false,
"serverSide": true,
//"dom": '<lp<t>if>',

'language': {
'loadingRecords': '&nbsp;',
"emptyTable": "No Records Available.",
'processing': '<div class="preloader-wrapper big active"><div class="spinner-layer spinner-blue-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>'
},  
"aoColumns": [
{ mData: 'id'} ,
{ mData: 'call_date'} ,            
{ mData: 'src'},
{ mData: 'dst'},
{ mData: 'billsec'},                                
{ mData: 'recordingfile'},
{ mData: 'disposition'},
{ mData: 'did'},
],
columnDefs: [
{ 
targets: [0],
visible: true,
render: function ( data, type, row, meta){
if(row['recordingfile'] != ''){	
return '<div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input checkbox" id="checkbox'+data+'"><label class="custom-control-label" for="checkbox'+data+'"></label></div>'
}else{
return '-';	
}
},
},
{ 
targets: [5],
visible: true,
render: function ( data, type, row, meta ){

if(data != '' && row['billsec'] != '00:00:00') {
<?php if($_SESSION['user_type'] == 'Admin') { ?>  
var ring_url = "<?php echo ccs_recording_path.$_SESSION['username'].'/' ?>"+data;
<?php }else{ ?>
var ring_url = "<?php echo ccs_recording_path.$_SESSION['tenant_name'].'/' ?>"+data;
<?php } ?>  

return '<audio controls preload="none" controlsList="download" style="height: 30px"><source src='+ring_url+' type="audio/mpeg"></audio>'
}
else{
return 'Not Recorded'
}            
},
},      
],  

responsive: {
details: {
display: $.fn.dataTable.Responsive.display.modal( {
header: function ( row ) {
var data = row.data();
return 'Details for '+data[0]+' '+data[1];
}
} ),
renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
tableClass: 'table'
} )
}
},

"drawCallback": function () {
$('.dataTables_paginate > .pagination').addClass('pagination  pg-blue mb-0');
}
});

//// END TR ///
$('#cdr_data tbody').on( 'click', "input[type='checkbox']", function () {

var row = $(this).closest('tr').index();    

var column_num = parseInt(row) + 1;
var file_name  = document.getElementById("cdr_data").rows[column_num].cells.item(5).innerHTML;

if(file_name != 'No Recording'){

$(this).closest('tr').toggleClass('selected');
$(this).closest('tr').toggleClass("highlight");

var x = document.getElementsByClassName("selected").length;
if(x > 0)
{           
$( "#download_recordings" ).
removeClass( "disabled" );	
}else{
$( "#download_recordings" ).addClass( "disabled" );
}
}else{
	$(this).prop('checked',false);
}
});

var files_download = [];
$('#download_recordings').click( function () {
var rows_selected = document.getElementsByClassName("selected").length;
var alert_download = toastr.success('Selected ' + rows_selected  + ' records to download. Your download will begin shortly' ,{"progressBar": true,});

$( "#download_recordings" ).addClass( "disabled" );
console.log("Selected files length is " + rows_selected);

files_download.length=0;
for (var i = 0; i < rows_selected; i++) { 
var files_data = $(table.rows('.selected').data());
console.log("Files data " , files_data);
var files = files_data[i].recordingfile;
files_download.push(files);
}
console.log('fiel : '+files);

$.ajax({
method:'POST',
data:{files:files_download},
url: "<?php echo site_url('LocalResponse/download_rec'); ?>",
success: function(result){
console.log("Result is " + result);
if (result != "File in POST are Empty") {
$('tr').removeClass('selected');
document.getElementById("download_recordings").disabled = false;
$('input[type=checkbox]').prop('checked',false);
window.location = "<?php echo site_url ?>/downloads/"+result;
}
else{
console.log("Internal Error  " + result); 
}
console.log("Result is " + result);
},

});
console.log("Ok done");
});


$('#cdr_data_processing').removeClass('card');
$('#cdr_data_wrapper .dataTables_filter').find('input').each(function () {

$('input').removeClass('form-control-sm');
$('input[type=search]').addClass('form-control-sm');
});
});
</script>


<?php if(!isset($site_id)){$site_id = null;} ?>

<script type="text/javascript">
$(document).ready(function () {
var table = $('#ext_data').DataTable({
"bLengthChange":false,
"processing": true,
"scrollY": 200,
"stateSave":true,
"deferRender": true,
"scroller" : true,
"ordering" : false,
<?php if(strtolower($this->uri->segment(2)) == 'dashboard'){ ?>
"sAjaxSource": "<?php echo site_url('LocalResponse/tenant_ext_json/All'); ?>",
"serverSide": false,
<?php }else{ ?>
"sAjaxSource": "<?php echo site_url('LocalResponse/tenant_ext_json/'); ?>",
"serverSide": true,
'iDisplayLength': 15,
<?php } ?>
"dom": '<lp<t>if>',

'language': {
'loadingRecords': '&nbsp;',
"emptyTable": "No Records Available.",
'processing': '<div class="preloader-wrapper big active"><div class="spinner-layer spinner-blue-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>'
},  
"aoColumns": [
{ mData: 'extension' } ,            
{ mData: 'display_name' },
{ mData: 'site_name'},
{ mData: 'extension_status'},
{ mData: 'mobile_status'},
{ mData: 'desktop_status'},
{ mData: 'id'},
//{ mData: 'extension' } SEND OTA MAIL
{ mData: 'password'}
],
columnDefs: [
{
targets: [0],
visible: true,
render: function ( data, type, row, meta ){           
if (data != null) {
var type = "<?php echo $_SESSION['user_type'] ?>";
if(type == 'Admin'){ 
return '<a onclick="show_ext('+row['id']+')" title="Show More Information">'+data+'</a>'
}else{
var id = "<?php echo $_SESSION['agent_id'] ?>"; 
if(id == row['id']){
return '<a onclick="show_ext('+row['id']+')" title="Show More Information">'+data+'</a>'
}else{
return data
}
}  
/// END IF ///
}
},
},
{
targets: [3],
visible: true,
render: function ( data, type, row, meta ){   

if (data != '') {
return '<a class="btn-floating btn-sm success-color" data-toggle="tooltip" title="Host : '+data+'"></a>'
}else{
return '<a class="btn-floating btn-sm btn-danger"></a>'
}
},
},
{
targets: [4],
visible: true,
render: function ( data, type, row, meta ){           
if (data != '') {
return '<a class="btn-floating btn-sm success-color" data-toggle="tooltip" title="Host : '+data+'"></a>'
}else{
return '<a class="btn-floating btn-sm btn-danger"></a>'
}
},
},
{
targets: [5],
visible: true,
render: function ( data, type, row, meta ){           
if (data != '') {
return '<a class="btn-floating btn-sm success-color" data-toggle="tooltip" title="Host :'+data+'"></a>'
}else{
return '<a class="btn-floating btn-sm btn-danger"></a>'
}
},
},
{
targets: [6],
visible: true,
render: function ( data, type, row, meta ){           
if (data != null) {
return '<a onclick="reset_pass('+data+')" data-trigger="hover" data-toggle="tooltip" data-placement="top" title="Reset Portal Password" data-content="Reset Portal Password" data-original-title="Reset Portal Password"><i class="fas fa-key"></i></a>'
}
},
},
/****** SEND OTA MAIL ******
{
targets: [7],
visible: true,
render: function ( data, type, row, meta ){           
if (data != null) {
var user = data+'-'+row['site_name']+'-<?php echo $_SESSION['username'] ?>';
return '<a href="<?php //echo site_url('Admin/Users/OTA_mail/') ?>'+user+'"><i class="fas fa-paper-plane"></i></a>'
}
},
},
***************************/
{
targets: [7],
visible: true,
render: function ( data, type, row, meta ){           
if (data != null) {
return '<label class="sr-only" for="'+data+'"></label><div class="input-group" ><div class="input-group-prepend"><div class="input-group-text" onclick="type_toggle(this.id)" id="'+data+'"><i class="fas fa-eye"></i></div></div><input type="password" class="form-control py-0" id="'+data+'_pass" value="'+data+'" readonly style="background-color: #ffffff;"></div>'
}else{
	return '-';
}
},
},

],

responsive: {
details: {
display: $.fn.dataTable.Responsive.display.modal( {
header: function ( row ) {
var data = row.data();
return 'Details for '+data[0]+' '+data[1];
}
} ),
renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
tableClass: 'table'
} )
}
},
"drawCallback": function () {
$('.dataTables_paginate > .pagination').addClass('pagination  pg-blue mb-0');
}
});

<?php if(strtolower($this->uri->segment(2)) == 'dashboard'){ ?>
table.column(3).visible(false);
table.column(4).visible(false);
table.column(5).visible(false);
table.column(6).visible(false);
table.column(7).visible(false);
<?php }else{
if($_SESSION['user_type'] != 'Agent'){
?>
table.column(3).visible(true);
table.column(4).visible(true);
table.column(5).visible(true);
table.column(6).visible(true);
table.column(7).visible(true);
<?php }} ?>

$('#ext_data_processing').removeClass('card');
$('#ext_data_wrapper .dataTables_filter').find('input').each(function () {
$('input').removeClass('form-control-sm');
$('input[type=search]').addClass('form-control-sm');
});
});
</script>

<script type="text/javascript">
$(document).ready(function () {
var table = $('#outgoing_list').DataTable({
"bLengthChange":false,
"sAjaxSource": "<?php echo site_url('LocalResponse/tenant_ext_json/All/'); ?>",
"processing": true,
"scrollY": 200,
"stateSave":true,
"deferRender": true,
"scroller" : true,
"ordering" : false,
"serverSide": false,
"dom": '<lp<t>if>',

'language': {
'loadingRecords': '&nbsp;',
"emptyTable": "No Records Available.",
'processing': '<div class="preloader-wrapper big active"><div class="spinner-layer spinner-blue-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>'
},  
"aoColumns": [
{ mData: 'display_name' },
{ mData: 'extension' } ,
{ mData: 'outbound_did'},
{ mData: 'vm_email'},
{ mData: 'site_name'},
],
columnDefs: [ 
],
responsive: {
details: {
display: $.fn.dataTable.Responsive.display.modal( {
header: function ( row ) {
var data = row.data();
return 'Details for '+data[0]+' '+data[1];
}
} ),
renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
tableClass: 'table'
} )
}
},
"drawCallback": function () {
$('.dataTables_paginate > .pagination').addClass('pagination  pg-blue mb-0');
}
});

$('#outgoing_list_processing').removeClass('card');
$('#outgoing_list_wrapper .dataTables_filter').find('input').each(function () {
$('input').removeClass('form-control-sm');
$('input[type=search]').addClass('form-control-sm');
});
});
</script>


<script type="text/javascript">
$(document).ready(function () {
var table = $('#site_data').DataTable({
"bLengthChange":false,
"sAjaxSource": "<?php echo site_url('LocalResponse/tenant_site_json/'.$site_id); ?>",
"processing": true,
"scrollY": 200,
"stateSave":true,
"deferRender": true,
"scroller" : true,
"ordering" : false,
"serverSide": false,
"dom": '<lp<t>if>',

'language': {
'loadingRecords': '&nbsp;',
"emptyTable": "No Records Available.",
'processing': '<div class="preloader-wrapper big active"><div class="spinner-layer spinner-blue-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>'
},  
"aoColumns": [
{ mData: 'site_name' } ,            
{ mData: 'moh' },
{ mData: 'trunk_name'},
{ mData: 'no_ext'},
{ mData: 'branch_prefix'},
{ mData: 'did'},
{ mData: 'id'},
],
columnDefs: [
{
targets: [6],
visible: true,
render: function ( data, type, row, meta ){           
if (data != null) {
var type = "<?php echo $_SESSION['user_type'] ?>";
if(type == 'Admin'){ 
return '<a onclick="show_site('+data+')"><i class="fas fa-info-circle"></i></a>'
}else{
return '-';
}
}
},
}, 
],
responsive: {
details: {
display: $.fn.dataTable.Responsive.display.modal( {
header: function ( row ) {
var data = row.data();
return 'Details for '+data[0]+' '+data[1];
}
} ),
renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
tableClass: 'table'
} )
}
},
"drawCallback": function () {
$('.dataTables_paginate > .pagination').addClass('pagination  pg-blue mb-0');
}
});

<?php if(strtolower($this->uri->segment(2)) == 'dashboard'){ ?>
table.column(6).visible(false);
<?php }else{ ?>
table.column(6).visible(true);
<?php } ?>

$('#site_data_processing').removeClass('card');
$('#site_data_wrapper .dataTables_filter').find('input').each(function () {
$('input').removeClass('form-control-sm');
$('input[type=search]').addClass('form-control-sm');
});
});
</script>


<script type="text/javascript">
$(document).ready(function () {
var table = $('#voice_mail_data').DataTable({
"bLengthChange":false,
"sAjaxSource": "<?php echo site_url('LocalResponse/voice_mail_json/'.$extension.'/'.$mail_type.'/'.$site); ?>",
"processing": true,
"scrollY": 200,
"stateSave":true,
"deferRender": true,
"scroller" : true,
"ordering" : false,
"serverSide": false,
"dom": '<lp<t>if>',

'language': {
'loadingRecords': '&nbsp;',
"emptyTable": "No Records Available.",
'processing': '<div class="preloader-wrapper big active"><div class="spinner-layer spinner-blue-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>'
},  
"aoColumns": [
{ mData: 'filename'},
{ mData: 'origdate' } ,            
{ mData: 'callerid' },
{ mData: 'exten'},
{ mData: 'filename'},                                
{ mData: 'duration'},
],
columnDefs: [
{ 
targets: [0],
visible: true,
render: function ( data, type, row, meta ){
return '<div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" id="checkbox'+data+'"><label class="custom-control-label" for="checkbox'+data+'"></label></div>'
},
},//
{ 
targets: [4],
visible: true,
render: function ( data, type, row, meta ){

var ring_url = "<?php echo ccs_mail_path ?>"+data;

if (data != '') {
if(data != 'Processing'){
return '<audio controls preload="metadata" controlsList="download" style="height: 30px"><source src='+ring_url+' type="audio/mpeg"></audio>'
}else{
return '<h6><center>File Processing</center></h6>'
}
}
else{
return '<h5><center><span class="badge badge-primary">No Recording</span></center></h5>'
}            
},
},      
],  
responsive: {
details: {
display: $.fn.dataTable.Responsive.display.modal( {
header: function ( row ) {
var data = row.data();
return 'Details for '+data[0]+' '+data[1];
}
} ),
renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
tableClass: 'table'
} )
}
},
"drawCallback": function () {
$('.dataTables_paginate > .pagination').addClass('pagination  pg-blue mb-0');
}
});


//// END TR ///
$('#voice_mail_data tbody').on( 'click', "input[type='checkbox']", function () {

var row = $(this).closest('tr').index();    

var column_num = parseInt(row) + 1;
var file_name  = document.getElementById("voice_mail_data").rows[column_num].cells.item(4).innerHTML;

$(this).closest('tr').toggleClass('selected');
$(this).closest('tr').toggleClass("highlight");

var x = document.getElementsByClassName("selected").length;
if(x > 0)
{           
$( "#download_mail" ).removeClass( "disabled" );	
}else{
$( "#download_mail" ).addClass( "disabled" );
}
});

var files_download = [];
$('#download_mail').click( function () {
var rows_selected = document.getElementsByClassName("selected").length;
var alert_download = toastr.success('Selected ' + rows_selected  + ' records to download. Your download will begin shortly' ,{"progressBar": true,});

$( "#download_mail" ).addClass( "disabled" );

files_download.length=0;
for (var i = 0; i < rows_selected; i++) { 
var files_data = $(table.rows('.selected').data());
console.log(files_data[i].filename);
var files = files_data[i].filename;
console.log(files_download[i]);
files_download.push(files);
}
console.log(files);

$.ajax({
method:'POST',
data:{files:files_download},
url: "<?php echo site_url('LocalResponse/download_mail/'.$extension.'/'.$mail_type.'/'.$site); ?>",
success: function(result){

if (result != "File in POST are Empty") {
$('tr').removeClass('selected');
document.getElementById("voice_mail_data").disabled = false;
$('input[type=checkbox]').prop('checked',false);
window.location = "<?php echo site_url ?>/downloads/"+result;
}
else{
console.log("Internal Error  " + result); 
}
console.log("Result is " + result);
},
error: function (request, error) {
alert(" Can't do because: " + error + " And Reques  " + request + " URL "  + url);
}
});
console.log("Ok done");
});

/*********** VOICE MAIL SEARCH ***************
<?php if(strtolower($this->uri->segment(2)) == 'voice_mail'){ ?>
$(".form-control-sm").css({"display": "none"});
<?php } ?>

$('#voice_mail_data_wrapper .dataTables_filter').find('input').each(function () {
$('input').removeClass('form-control-sm');
$('input[type=search]').addClass('form-control-sm');
$('input.form-control-sm').after('<input type="search" class="form-control form-control-sm" id="serchbox" autofocus/>');
});
********************/


$('#voice_mail_data_processing').removeClass('card');
$('#voice_mail_data_wrapper .dataTables_filter').find('input').each(function () {
$('input').removeClass('form-control-sm');
$('input[type=search]').addClass('form-control-sm');
});


});
</script>

<script type="text/javascript">
$(document).ready(function () {
var table = $('#in_block').DataTable({
"bLengthChange":false,
"sAjaxSource": "<?php echo site_url('LocalResponse/get_block_no/IN'); ?>",
"processing": true,
"scrollY": 200,
"stateSave":true,
"deferRender": true,
"scroller" : true,
"ordering" : false,
"serverSide": false,
"dom": '<lp<t>if>',

'language': {
'loadingRecords': '&nbsp;',
"emptyTable": "No Records Available.",
'processing': '<div class="preloader-wrapper big active"><div class="spinner-layer spinner-blue-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>'
},  
"aoColumns": [
{ mData: 'site_id' } ,            
{ mData: 'did' },
{ mData: 'number'},
],

responsive: {
details: {
display: $.fn.dataTable.Responsive.display.modal( {
header: function ( row ) {
var data = row.data();
return 'Details for '+data[0]+' '+data[1];
}
} ),
renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
tableClass: 'table'
} )
}
},
"drawCallback": function () {
$('.dataTables_paginate > .pagination').addClass('pagination  pg-blue mb-0');
}
});

$('#ext_data_processing').removeClass('card');
$('#ext_data_wrapper .dataTables_filter').find('input').each(function () {
$('input').removeClass('form-control-sm');
$('input[type=search]').addClass('form-control-sm');
});
});
</script>


<script type="text/javascript">
$(document).ready(function () {
var table = $('#out_block').DataTable({
"bLengthChange":false,
"sAjaxSource": "<?php echo site_url('LocalResponse/get_block_no/OUT'); ?>",
"processing": true,
"scrollY": 200,
"stateSave":true,
"deferRender": true,
"scroller" : true,
"ordering" : false,
"serverSide": false,
"dom": '<lp<t>if>',

'language': {
'loadingRecords': '&nbsp;',
"emptyTable": "No Records Available.",
'processing': '<div class="preloader-wrapper big active"><div class="spinner-layer spinner-blue-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>'
},  
"aoColumns": [
{ mData: 'site_id' } ,            
{ mData: 'number'},
],

responsive: {
details: {
display: $.fn.dataTable.Responsive.display.modal( {
header: function ( row ) {
var data = row.data();
return 'Details for '+data[0]+' '+data[1];
}
} ),
renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
tableClass: 'table'
} )
}
},
"drawCallback": function () {
$('.dataTables_paginate > .pagination').addClass('pagination  pg-blue mb-0');
}
});

$('#ext_data_processing').removeClass('card');
$('#ext_data_wrapper .dataTables_filter').find('input').each(function () {
$('input').removeClass('form-control-sm');
$('input[type=search]').addClass('form-control-sm');
});
});
</script>

<script type="text/javascript">
$(document).ready(function () {
var table = $('#phone_commpany').DataTable({
"bLengthChange":false,
"sAjaxSource": "<?php echo site_url('LocalResponse/phone_company_json'); ?>",
"processing": true,
"scrollY": 200,
"stateSave":true,
"deferRender": true,
"scroller" : true,
"ordering" : false,
"serverSide": false,
"dom": '<lp<t>if>',

'language': {
'loadingRecords': '&nbsp;',
"emptyTable": "No Records Available.",
'processing': '<div class="preloader-wrapper big active"><div class="spinner-layer spinner-blue-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>'
},  
"aoColumns": [
{ mData: 'name' } ,            
{ mData: 'datetime' },
{ mData: 'id'}
],
columnDefs: [
{
targets: [2],
visible: true,
render: function ( data, type, row, meta ){           
if (data != null) {
return '<a href="<?php echo site_url('Admin/Provisioning/company/') ?>'+data+'"><i class="fas fa-edit"></i></a> | <a href="#" onclick="ConfirmCompany('+data+')"><i class="far fa-trash-alt"></i></a>'
}
},
},
],

responsive: {
details: {
display: $.fn.dataTable.Responsive.display.modal( {
header: function ( row ) {
var data = row.data();
return 'Details for '+data[0]+' '+data[1];
}
} ),
renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
tableClass: 'table'
} )
}
},
"drawCallback": function () {
$('.dataTables_paginate > .pagination').addClass('pagination  pg-blue mb-0');
}
});

$('#phone_commpany_processing').removeClass('card');
$('#phone_commpany_wrapper .dataTables_filter').find('input').each(function () {
$('input').removeClass('form-control-sm');
$('input[type=search]').addClass('form-control-sm');
});
});
</script>


<script type="text/javascript">
$(document).ready(function () {
var table = $('#phone_family').DataTable({
"bLengthChange":false,
"sAjaxSource": "<?php echo site_url('LocalResponse/phone_family_json'); ?>",
"processing": true,
"scrollY": 200,
"stateSave":true,
"deferRender": true,
"scroller" : true,
"ordering" : false,
"serverSide": false,
"dom": '<lp<t>if>',

'language': {
'loadingRecords': '&nbsp;',
"emptyTable": "No Records Available.",
'processing': '<div class="preloader-wrapper big active"><div class="spinner-layer spinner-blue-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>'
},  
"aoColumns": [
{ mData: 'model'},
{ mData: 'company'},            
{ mData: 'datetime' },
{ mData: 'id'}
],
columnDefs: [
{
targets: [3],
visible: true,
render: function ( data, type, row, meta ){           
if (data != null) {
return '<a href="<?php echo site_url('Admin/Provisioning/family/') ?>'+data+'"><i class="fas fa-edit"></i></a> | <a href="#" onclick="ConfirmFamily('+data+')"><i class="far fa-trash-alt"></i></a>'
}
},
},
],

responsive: {
details: {
display: $.fn.dataTable.Responsive.display.modal( {
header: function ( row ) {
var data = row.data();
return 'Details for '+data[0]+' '+data[1];
}
} ),
renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
tableClass: 'table'
} )
}
},
"drawCallback": function () {
$('.dataTables_paginate > .pagination').addClass('pagination  pg-blue mb-0');
}
});

$('#phone_family_processing').removeClass('card');
$('#phone_family_wrapper .dataTables_filter').find('input').each(function () {
$('input').removeClass('form-control-sm');
$('input[type=search]').addClass('form-control-sm');
});
});
</script>


<script type="text/javascript">
$(document).ready(function () {
var table = $('#phone_template').DataTable({
"bLengthChange":false,
"sAjaxSource": "<?php echo site_url('LocalResponse/phone_template_json'); ?>",
"processing": true,
"scrollY": 200,
"stateSave":true,
"deferRender": true,
"scroller" : true,
"ordering" : false,
"serverSide": false,
"dom": '<lp<t>if>',

'language': {
'loadingRecords': '&nbsp;',
"emptyTable": "No Records Available.",
'processing': '<div class="preloader-wrapper big active"><div class="spinner-layer spinner-blue-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>'
},  
"aoColumns": [
{ mData: 'company'},
{ mData: 'model'},
{ mData: 'file' },
{ mData: 'datetime'},
{ mData: 'id'}
],
columnDefs: [
{
targets: [2],
visible: true,
render: function ( data, type, row, meta ){           
if (data != null) {

return '<a targets="_blank" download href="<?php echo site_url('../templates/'.$_SESSION['user_id'].'/') ?>'+row['c_id']+'/'+row['m_id']+'/'+data+'">'+data+'</a>'
}
},
},
{
targets: [4],
visible: true,
render: function ( data, type, row, meta ){           
if (data != null) {
return '<a href="<?php echo site_url('Admin/Provisioning/template/') ?>'+data+'"><i class="fas fa-edit"></i></a> | <a href="#" onclick="ConfirmTemplate('+data+')"><i class="far fa-trash-alt"></i></a>'
}
},
},
],

responsive: {
details: {
display: $.fn.dataTable.Responsive.display.modal( {
header: function ( row ) {
var data = row.data();
return 'Details for '+data[0]+' '+data[1];
}
} ),
renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
tableClass: 'table'
} )
}
},
"drawCallback": function () {
$('.dataTables_paginate > .pagination').addClass('pagination  pg-blue mb-0');
}
});

$('#phone_template_processing').removeClass('card');
$('#phone_template_wrapper .dataTables_filter').find('input').each(function () {
$('input').removeClass('form-control-sm');
$('input[type=search]').addClass('form-control-sm');
});
});
</script>


<script type="text/javascript">
$(document).ready(function () {
var table = $('#phone_provisioning').DataTable({
"bLengthChange":false,
"sAjaxSource": "<?php echo site_url('LocalResponse/phone_provisioning_json'); ?>",
"processing": true,
"scrollY": 200,
"stateSave":true,
"deferRender": true,
"scroller" : true,
"ordering" : false,
"serverSide": false,
"dom": '<lp<t>if>',

'language': {
'loadingRecords': '&nbsp;',
"emptyTable": "No Records Available.",
'processing': '<div class="preloader-wrapper big active"><div class="spinner-layer spinner-blue-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>'
},  
"aoColumns": [
{ mData: 'extension'},
{ mData: 'company'},
{ mData: 'model'},
{ mData: 'datetime'},
{ mData: 'id'}
],           
columnDefs: [
{
targets: [4],
visible: true,
render: function ( data, type, row, meta ){           
if (data != null) {

return '<a href="<?php echo site_url('Admin/Provisioning/provisioning/') ?>'+data+'"><i class="fas fa-edit"></i></a> | <a href="#" onclick="ConfirmProvisioning('+data+')"><i class="far fa-trash-alt"></i></a> | <a download target="_blank" href="<?php echo site_url('Admin/Provisioning/provisi_down/'.$_SESSION['user_id'].'/'.$_SESSION['site_id']) ?>/'+row['c_id']+'/'+row['m_id']+'/'+row['extension']+'.xml"><i class="fas fa-download"></i></a>'

//return '<a href="<?php //echo site_url('Admin/Provisioning/provisioning/') ?>'+data+'"><i class="fas fa-edit"></i></a> | <a href="#" onclick="ConfirmProvisioning('+data+')"><i class="far fa-trash-alt"></i></a> | <a download target="_blank" href="<?php //echo site_url('../tftp/'.$_SESSION['user_id'].'/') ?>'+row['c_id']+'/'+row['m_id']+'/'+row['extension']+'.xml"><i class="fas fa-download"></i></a>'

}   
},
},
],

responsive: {
details: {
display: $.fn.dataTable.Responsive.display.modal( {
header: function ( row ) {
var data = row.data();
return 'Details for '+data[0]+' '+data[1];
}
} ),
renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
tableClass: 'table'
} )
}
},
"drawCallback": function () {
$('.dataTables_paginate > .pagination').addClass('pagination  pg-blue mb-0');
}
});

$('#phone_provisioning_processing').removeClass('card');
$('#phone_provisioning_wrapper .dataTables_filter').find('input').each(function () {
$('input').removeClass('form-control-sm');
$('input[type=search]').addClass('form-control-sm');
});
});
</script>


<!--script type="text/javascript">
setTimeout(function () {
//document.getElementById('msg').style.display='none';
}, 5000); 
</script-->

<script type="text/javascript">
$('.file_upload').file_upload();
$(document).ready(function() {
$('.mdb-select').materialSelect();
var selected = $('#select-options-office_days');
   if(selected){
      selected.find('li:nth-child(3) input[type=checkbox]')
   }
console.log(selected);
});
</script>

<script>
$(document).ready(function(){
$('[data-toggle="tooltip"]').tooltip();
});
</script>

<script type="text/javascript">
$(document).ready(function(){
$('.datepicker').datepicker
});
</script>

<script>
$( function() {
$( "#sortable" ).sortable();
} );
</script>

<script type="text/javascript">
$(document).ready(function(){

$('#selectAll').click(function(){
if($(this).prop("checked") == true){
$('table tbody input[type="checkbox"]:not(:checked)').trigger('click');
}
else if($(this).prop("checked") == false){
$('table tbody input[type="checkbox"]:checked').trigger('click');
}
});

$('table tbody').on( 'click', "input[type='checkbox']", function () {
if (!$(this).prop("checked")) {
$("#selectAll").prop("checked", false);
}
});
});
</script>

<script type="text/javascript">
function  value_reomve(){ 
$('#oldpass').val(''); 
$('#newpass').val('');
$('#conpass').val('');
$("#changepass").attr("disabled", false);
}
</script>

<script type="text/javascript">
function type_toggle(id){
var x = document.getElementById(id+'_pass');
if (x.type === "password") {
x.type = "text";
} else {
x.type = "password";
}
}
</script>

<script type="text/javascript">
var _URL = window.URL || window.webkitURL;
$("#file").change(function(e) {

var fileInput = document.getElementById('file'); 
var filePath = fileInput.value; 
var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.tif)$/i; 
if (!allowedExtensions.exec(filePath)) { 
alert('Invalid File Type Please Upload ( JPEG | JPG | PNG | TIF )'); 
fileInput.value = ''; 
return false; 
}

var image, file;
if ((file = this.files[0])) {
image = new Image();
image.onload = function() {
var width = this.width;
var height = this.height;
if(width > 1024 || height > 769){
alert('Invalid File Size Please Upload ( Maximum Dimensions : 1024 x 768 )'); 
$("#uploadlogo").trigger("reset");
return false;
}
};
image.src = _URL.createObjectURL(file);
}
});

</script>

<script type="text/javascript">
var _URL = window.URL || window.webkitURL;
$("#file_temp").change(function(e) {

var fileInput = document.getElementById('file_temp'); 
var filePath = fileInput.value; 
var allowedExtensions = /(\.xml|\.cfg|\.csv|\.txt)$/i; 
if (!allowedExtensions.exec(filePath)) { 
alert('Invalid File Type Please Upload ( xml | cfg | csv | txt )'); 
fileInput.value = ''; 
return false; 
}

});

</script>


<script type="text/javascript">
    function date_val(){
        var from = $('#fromdate').val();
        var to   = $('#todate').val();
        if(from > to){
         alert('Invalid From and To Date.');
         $("#search_date").attr("disabled", true);
        }else{
         $("#search_date").attr("disabled", false);
        }
    }
</script>

<script type="text/javascript">
function  passcheck(){ 
// OLD PASS ///
var old  = $('#oldpass').val();
var pass = $('#pass_old').val();
if(old != pass){ 
alert('Old Password Not Match');
$("#changepass").attr("disabled", true);
return false;
}else{
$("#changepass").attr("disabled", false);
}
// CONF PASS // 
var newpass = $('#newpass').val();
var conpass = $('#conpass').val();
if(newpass != conpass && newpass != '' && conpass != ''){ 
alert('New Password And Confirm Password Not Match');
$("#changepass").attr("disabled", true);
return false;
}else{
$("#changepass").attr("disabled", false);
}
}  
</script>

<script type="text/javascript">
function  agent_pass_check(){ 

// CONF PASS // 
var newpass = $('#agent_newpass').val();
var conpass = $('#agent_conpass').val();
if(newpass != conpass && newpass != '' && conpass != ''){ 
alert('New Password And Confirm Password Not Match');
$("#agent_changepass").attr("disabled", true);
return false;
}else{
$("#agent_changepass").attr("disabled", false);
}
}  
</script>

<script type="text/javascript">
function call_manage(){ 

var unavailable_call   = $('#unavailable_call').val(); 
var unconditional_call = $('#unconditional_call').val();

if(unavailable_call != ''){ 
 $('#unconditional_call').val('');
 $('#unconditional_call').attr('readonly', true); 
}else{
 $('#unconditional_call').attr('readonly', false); 	
}

if(unconditional_call != ''){ 
 $('#unavailable_call').val('');
 $('#unavailable_call').attr('readonly', true); 
}else{
 $('#unavailable_call').attr('readonly', false); 	
}
}  
</script>


<script type="text/javascript">
$('.dropdown-submenu .dropdown-toggle').on("click", function(e) {
e.stopPropagation();
e.preventDefault();
$(this).next('.dropdown-menu').toggle();
});
</script>


<?php $current_uri = $this->uri->segment(2); if(isset($current_uri)) {?>
<?php 
if($current_uri != 'Reports'){ 
if($current_uri == 'Site') {$current_uri ='Branch';} 
if($current_uri == 'Incoming') {$current_uri ='Inbound';} 
if($current_uri == 'Number') {$current_uri ='Outbound';} 
if($current_uri == 'Voice_mail') {$current_uri ='VoiceMail';} 
if($current_uri == 'Call_forward') {$current_uri ='CallManagement';} 
if($current_uri == 'Call_forward') {$current_uri ='CallManagement';} 
if($current_uri == 'Rate_card') {$current_uri ='RateCard';} 
if($current_uri == 'bill') {$current_uri ='RateCardAssign';} 
?>
<script type="text/javascript">
$(document).ready(function(){
var uri = "<?php echo $current_uri ?>";
$("#dashboard").removeClass("active");
$("#"+uri).addClass("active");
});
</script>
<?php }else{ ?>
<script type="text/javascript">
$(document).ready(function(){
var uri = "<?php echo $current_uri ?>";
$("#dashboard").removeClass("active");
$("#CallRecords").addClass("active");
});
</script>
<?php } } ?>  


<script type="text/javascript"></script>
<?php  if ($this->session->flashdata('swal_message')) {  ?>
<script type="text/javascript">
swal("Success!", "<?php echo $this->session->flashdata('swal_message');?>", "success");

</script>
<?php }  ?>
<?php  if ($this->session->flashdata('swal_error')) {  ?>
<script type="text/javascript">
swal("Error!", "<?php echo $this->session->flashdata('swal_error');?>", "error");

</script> 
<?php }  ?>

<!-- Rotating card -->
<script type="text/javascript">
$("#error-alert").fadeTo(4000, 6200).slideUp(6200, function(){
$("#error-alert").slideUp(6000);
});
</script>


<script type="text/javascript">

function ConfirmAndRelease(link,message) {
var txt;
var r = confirm_data(link,message);

console.log("The value of R is "+ r);
if (r == true) {
 window.location.href = link;
} 
} 

function ConfirmCompany(id) {

var link = '<?php echo site_url('Admin/Provisioning/delete_company/') ?>'+id;
var message = 'Delete Phone Company';
var r = confirm_data(link,message);

console.log("The value of R is "+ r);
if (r == true) {
 window.location.href = link;
}
}

function ConfirmFamily(id) {

var link = '<?php echo site_url('Admin/Provisioning/delete_family/') ?>'+id;
var message = 'Delete Phone Family';
var r = confirm_data(link,message);

console.log("The value of R is "+ r);
if (r == true) {
 window.location.href = link;
}
} 

function ConfirmTemplate(id) {

var link = '<?php echo site_url('Admin/Provisioning/delete_template/') ?>'+id;
var message = 'Delete Phone Template';
var r = confirm_data(link,message);

console.log("The value of R is "+ r);
if (r == true) {
 window.location.href = link;
}
} 


function ConfirmProvisioning(id) {

var link = '<?php echo site_url('Admin/Provisioning/delete_provisioning/') ?>'+id;
var message = 'Delete Phone Provisioning';
var r = confirm_data(link,message);

console.log("The value of R is "+ r);
if (r == true) {
 window.location.href = link;
}
}

function ConfirmRate(id) {

var link = '<?php echo site_url('Super/rate_card/delete/') ?>'+id;
var message = 'Delete Rate Card';
var r = confirm_data(link,message);

console.log("The value of R is "+ r);
if (r == true) {
 window.location.href = link;
}
} 

function confirm_data(link,message) {

var response = '';
swal({
title: 'Are you sure?',
text: message,
type: 'warning',
showCancelButton: true,
confirmButtonColor: '#2196F3',
cancelButtonColor: '#d33',	
confirmButtonText: 'Yes, delete it!',
cancelButtonText: 'No, cancel!',
confirmButtonClass: 'btn btn-primary',
cancelButtonClass: 'btn btn-danger',
buttonsStyling: true,
reverseButtons: false
}).then((result) => {
if (result.value) {

if (result.value == true) {
window.location.href = link;
} 
console.log("The result is "+ result.value);
return result.value;
} else if (result.dismiss === 'cancel') {
}
});
}
</script>

<script type="text/javascript">
  
  $(".toggle-password").on('click',function() {

  $(this).find('> svg').toggleClass(" fa-eye fa-eye-slash");

  var input = $(this).parent().find('.form-control');

  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});
</script>
<script type="text/javascript">
// Start System configuration script
$(document).ready(function () {
	$('.stepper').mdbStepper();

	$('#filter_tenant_id').change(function(){
		// Call submit() method on <form id='myform'>
		$("#filter_branch_id").val('');
		$('#filter_form').submit();
	});
	<?php
	if($showModelAddBranch){
		?>
		$('#add_branch').click();
		<?php
	}
	?>
});

function removeRequiredFromLastRow(table_id){
	if($('#'+table_id+' tr').length > 2){
		$('#'+table_id+' > tbody > tr').last().find('select,input').prop('required',false);
	}
}
function removeWhiteSpaceFromTextBox() {	
    $("[type = text").change(function(){
	    var id  = this.id;
	    var str = this.value.trim();  
	    if(id != ''){
	    	document.getElementById(id).value = str;  
	    }
	});    

	// Last Blank Row 
	$('.avoid_space').keypress(function( e ) {
    	if(e.which === 32) 
	        return false;
	});
}

function removeTableTr(remove_tr){
	var x = confirm("Are you sure you want to remove?");
	if (x) {
		remove_tr.remove();    
	}
}

function addRemoveFirstClass(table_id,first_class){
	$("#"+table_id).find('.'+first_class).removeClass(first_class);
	$("#"+table_id+' > tbody > tr').last().find('select,input').first().addClass(first_class);
}

function addRequiredFields(table_id,arrRequiredFields){
	$('#'+table_id+' tr').each(function (i) {
	    // create required field array
	    $(this).find('td').each(function(){
	    	var el = $(this).find(':first-child');
	    	var name = el.attr('name') || null;
            if(name) {
            	id = el.attr('id');

            	strIdNumber = id.match(/[^[\]]+(?=])/g);
            	strNameNumber = name.match(/[^[\]]+(?=])/g);

            	new_id = id.replace(strIdNumber,i);	            	
            	new_name = name.replace(strNameNumber,i);   

            	el.attr('id', new_id);
	            el.attr('name', new_name);

	            old_value_hidden =  $(this).find('.old_value_hidden').attr('name');
	            if(typeof old_value_hidden !== 'undefined'){
	            	new_old_value_hidden = old_value_hidden.replace(strNameNumber,i); 
	            	$(this).find('.old_value_hidden').attr('name',new_old_value_hidden);
	            }

	            old_value_hidden_did =  $(this).find('.old_value_hidden_did').attr('name');
	            if(typeof old_value_hidden_did !== 'undefined'){
	            	new_old_value_hidden_did = old_value_hidden_did.replace(strNameNumber,i); 
	            	$(this).find('.old_value_hidden_did').attr('name',new_old_value_hidden_did);
	            }
            	// Add required to required fields                	
        		str_name = new_name.replace('['+i+']','');
        		if(jQuery.inArray( str_name, arrRequiredFields) >= 0){
            		el.prop('required',true);
            	}
            	else {
            		el.prop('required',false);
            	}                
            }
	    });
	});
}

//-------**Start** Add TR by using jquery in a view for add more multiple elements----------// 
// --------------jQuery code For Add multiple Elements----------------------//
$(document).ready(function(){

	// Remove Starting and Ending space from textbox
	removeWhiteSpaceFromTextBox();			
	//Start Trunk Master
	//------------------------Start Trunk Master----------------------//
	var arrTrunkRequiredFields = ["trunk_name", "trunk_did", "username", "password", "host", "port", "domain", "dtmf_mode", "nat", "directrtp", "register_trunk", "prefix", "failover", "ringduration", "cpe_ip", "d2e"];

    function addTrunkRow() {

    	$('#trunk_master tbody').append($('#trunk_master tbody tr:last').clone());
    	var trTotal = $('#trunk_master tr').length - 1;
	    $('#trunk_master tr').each(function (i) {
	        $(this).find('td').each(function(){
	            var el = $(this).find(':first-child');
	            var name = el.attr('name') || null;
	            if(name) {

	            	id = el.attr('id');
	            	strIdNumber = id.match(/[^[\]]+(?=])/g);
	            	strNameNumber = name.match(/[^[\]]+(?=])/g);

	            	new_id = id.replace(strIdNumber,i);	            	
	            	new_name = name.replace(strNameNumber,i);

	            	el.attr('id', new_id);
	                el.attr('name', new_name);

	                if(trTotal == i){
	                	if(el.attr('type') == "text" || el.attr('type') == "number"){
							el.val('');                  
						}
						else {
							el.prop('selectedIndex',0);
						}
						// Remove when adding new row
						$(this).find('.old_value_hidden').remove();
						el.prop('required',false);	
	                }
	                else{	                	
	                	// Add required to required fields                	
	            		str_name = new_name.replace('['+i+']','');
	            		if(jQuery.inArray( str_name, arrTrunkRequiredFields) >= 0){
                    if(str_name != 'trunk_did' && str_name != 'username' && str_name != 'password' && str_name != 'prefix' && str_name != 'failover' && str_name != 'cpe_ip' && str_name != 'ringduration'){                      
	                	el.prop('required',true);
                    }
	                }
	              }
	            }
	        });
	    });

	    addRemoveFirstClass("trunk_master","trunkname_first");
    }

	$("#trunk_master").delegate(".remove-trunk", "click", function(){
		var id = $(this).closest('tr').find(".old_value_hidden").val();
		var tenant_id = $("#filter_tenant_id").val();
		var site_id = $("#filter_branch_id").val();
		var totalTR = $('#trunk_master tr').length;
		remove_tr = $(this).closest('tr');
		if(id){
			$.ajax({
				url: "<?php echo site_url('System_configuration/ajaxCheckUsed/'); ?>",
				type: "POST",
				data:{id:id,tenant_id:tenant_id,site_id:site_id,table_name:'trunk_master'},
				cache: false,
				success: function(data){
					if(data){
						alert('Trunk Name Already Used You can not remove it.');
					}
					else {
						if(totalTR == 2){
							addTrunkRow();
			        		removeWhiteSpaceFromTextBox();
						}
						removeTableTr(remove_tr);
						addRemoveFirstClass("trunk_master","trunkname_first");
						addRequiredFields('trunk_master',["trunk_name","host", "port", "domain", "dtmf_mode"]);
						//removeRequiredFromLastRow('trunk_master');
					}
				}
			});
		}
		else {		
			if(totalTR == 2){
				addTrunkRow();
        		removeWhiteSpaceFromTextBox();
			}
			removeTableTr(remove_tr);
			addRemoveFirstClass("trunk_master","trunkname_first");
      addRequiredFields('trunk_master',["trunk_name","host", "port", "domain", "dtmf_mode"]);
			//removeRequiredFromLastRow('trunk_master');			
		}
	});

	$("#trunk_master").delegate(".trunkname_first", "keydown change", function(e){		
        if($(this).val()){
        	addTrunkRow();
        	removeWhiteSpaceFromTextBox();
        }
	});

	// Remove required from last row in trunk master
	removeRequiredFromLastRow('trunk_master');

//----------------- End Trunk Master-----------------------//

//-----------------------Start Add Extension Master-----------------//
 	var arrExtnsionRequiredFields = ["extension","extension_type","display_name","voicemail_enabled","vm_email","vm_timezone","trunk_name","outbound_did","isd_allowed","park_retreive","call_recording","call_monitoring","presence_blf","mobility","synergy","portal_access","mobile_number","audio_avoid","audio_file"];
    
 
    function addExtennsionRow(){
    	$('#extension_master tbody').append($('#extension_master tbody tr:last').clone() );
    	var trTotal = $('#extension_master tr').length - 1;
    
      addRemoveFirstClass("extension_master","extension_first");

	    $('#extension_master tr').each(function (i) {	        
	        $(this).find('td').each(function(){
	            var el = $(this).find(':first-child');
	            var name = el.attr('name') || null;
	            if(name) {
	            	id = el.attr('id');
	            	//strIdNumber = id.match(/[^[\]]+(?=])/g);
	            	strNameNumber = name.match(/[^[\]]+(?=])/g);

	            	new_id = id.replace(strNameNumber,i);	            	
	            	new_name = name.replace(strNameNumber,i);

	            	el.attr('id', new_id);
	              el.attr('name', new_name);
	         
           
           if(trTotal == i){          
           if(el.attr('type') == "text" || el.attr('type') == "number"){
							el.val('');                  
						}
						else {
							el.prop('selectedIndex',0);
						}
						// Remove when adding new row
						$(this).find('.old_value_hidden').remove();
						el.prop('required',false);				
	                }
	                else{                  
	                	// Add required to required fields                	
	            		str_name = new_name.replace('['+i+']','');	            	                
                  if(jQuery.inArray( str_name, arrExtnsionRequiredFields)>= 0){
	                		if(str_name!='display_name' && str_name!='vm_email' && str_name!='outbound_did' && str_name!='mobile_number' && str_name !='trunk_name' && str_name !='vm_timezone' && str_name != 'audio_file' && str_name != 'audio_avoid'){
                      el.prop('required',true);
                      }
	                	}
	                }
	            }
	        });
	    });
	    //addRemoveFirstClass("extension_master","extension_first");
    }

	$("#extension_master").delegate(".remove-extension", "click", function(){
		var id = $(this).closest('tr').find(".old_value_hidden").val();
		var tenant_id = $("#filter_tenant_id").val();
		var site_id = $("#filter_branch_id").val();
		var totalTR = $('#extension_master tr').length;
		remove_tr = $(this).closest('tr');
		if(id){
			$.ajax({
				url: "<?php echo site_url('System_configuration/ajaxCheckUsed/'); ?>",
				type: "POST",
				data:{id:id,tenant_id:tenant_id,site_id:site_id,table_name:'extension'},
				cache: false,
				success: function(data){
					if(data){
						alert('Extension Already Used You can not remove it.');
					}
					else {
						if(totalTR == 2){
							addExtennsionRow();
			        		removeWhiteSpaceFromTextBox();
						}
						removeTableTr(remove_tr);
						addRemoveFirstClass("extension_master","extension_first");
						addRequiredFields('extension_master',["extension","extension_type"]);
						//removeRequiredFromLastRow('extension_master');
					}
				}
			});
		}
		else {			
			if(totalTR == 2){
				addExtennsionRow();
        		removeWhiteSpaceFromTextBox();
			}
			removeTableTr(remove_tr);
			addRemoveFirstClass("extension_master","extension_first");
			addRequiredFields('extension_master',["extension","extension_type"]);
			//removeRequiredFromLastRow('extension_master');
		} 	    
	});

	$("#extension_master").delegate(".extension_first", "keydown change", function(e){		
      
        if($(this).val()){
        	addExtennsionRow();
        	removeWhiteSpaceFromTextBox();
        }
	});	

	// Remove required from last row in extenstion master
	removeRequiredFromLastRow('extension_master');
	//------------------- End Extension Master----------------------//

	//----------------- Start CLID Block Number Master-------------//
	var arrBlockNumberReqFields = ["call_type", "did", "number"];
	function addCLIDBlockRow(){
		$('#clid_blog_master tbody').append($('#clid_blog_master tbody tr:last').clone());
		var trTotal = $('#clid_blog_master tr').length - 1;
		$('#clid_blog_master tr').each(function (i) {
			$(this).find('td').each(function(){
				var el = $(this).find(':first-child');
				var name = el.attr('name') || null;
				if(name) {

					id = el.attr('id');
					strIdNumber = id.match(/[^[\]]+(?=])/g);
					strNameNumber = name.match(/[^[\]]+(?=])/g);

					new_id = id.replace(strNameNumber,i);	            	
					new_name = name.replace(strNameNumber,i);

					el.attr('id', new_id);
					el.attr('name', new_name);
					if(trTotal == i){
		            	if(el.attr('type') == "text"){
							el.val('');                  
						}
						else {
							el.prop('selectedIndex',0);
						}
						if(el.attr('class') == "did"){
							el.prop('required',true);	
							el.show();	
						}
						// Remove when adding new row
						$(this).find('.old_value_hidden').remove();
						$(this).find('.old_value_hidden_did').remove();
		            	el.prop('required',false);				
	                }
	                else{
	                	// Add required to required fields                	
	            		str_name = new_name.replace('['+i+']','');
	            		if(jQuery.inArray( str_name, arrBlockNumberReqFields) >= 0){
	                		el.prop('required',true);
	                	}
	                }
				}
			});
		});

		addRemoveFirstClass("clid_blog_master","clidblock_first");	
	}

	$("#clid_blog_master").delegate(".remove-clidblock", "click", function(){
		var totalTR = $('#clid_blog_master tr').length;
		remove_tr = $(this).closest('tr');
		if(totalTR == 2){
			addCLIDBlockRow();
    		removeWhiteSpaceFromTextBox();
		}	
		removeTableTr(remove_tr);
		addRemoveFirstClass("clid_blog_master","clidblock_first");	  
		addRequiredFields('clid_blog_master',arrTrunkDidReqFields);
		removeRequiredFromLastRow('clid_blog_master');
	});

	$("#clid_blog_master").delegate(".clidblock_first", "keydown change", function(e){		
		if($(this).val()){
			addCLIDBlockRow();
			removeWhiteSpaceFromTextBox();
		}
	});	

	$("#clid_blog_master").on('change', '.call_type', function(){
        var val = $(this).val();
        if(val == 'outgoing'){
        	$(this).closest('tr').find('.did').prop('required',false);
        	$(this).closest('tr').find('.did').prop('readonly',true);
        	$(this).closest('tr').find('.did').val('');
        	//$(this).closest('tr').find('.did').hide();
    	}
    	else {
    		$(this).closest('tr').find('.did').prop('required',true);
    		$(this).closest('tr').find('.did').prop('readonly',false);
        	//$(this).closest('tr').find('.did').show();
    	}
    });
    // Block Number - Do not allow same Trunk DID
    $("#clid_blog_master").delegate(".did", "change", function(){
	  const vals = $('.did').not(this).map(function() { return this.value }).get()
	  const that = this;
	  if (vals.indexOf(this.value) !=-1) {
	    alert('Trunk DID already exists');
	    that.value="";
	    setTimeout(function() { that.focus() },100)
	  }  
	});
    // Remove required from last row in block number
	removeRequiredFromLastRow('clid_blog_master');
	//---------------------- End CLID Block Master-------------------------//

	//----------------------- Start TrunkDID Number Master-----------------//
	var arrTrunkDidReqFields = ["trunk_name", "trunk_did", "did_type","extension"];
    function addTrunkDIDRow(){
		$('#trunk_did_detail_master tbody').append($('#trunk_did_detail_master tbody tr:last').clone());
		var trTotal = $('#trunk_did_detail_master tr').length - 1;
		$('#trunk_did_detail_master tr').each(function (i) {			
			$(this).find('td').each(function(){
				var el = $(this).find(':first-child');
				var name = el.attr('name') || null;
				if(name) {

					//id = el.attr('id');
					//strIdNumber = id.match(/[^[\]]+(?=])/g);
					strNameNumber = name.match(/[^[\]]+(?=])/g);

					var res = name.split("_");
					if(res[0] == 'extension'){
					  name = res[0]+'_'+i+'[]';	
            //alert(name);
					}	
					
					//new_id   = id.replace(strNameNumber,i);	            	
					new_name = name.replace(strNameNumber,i);

					//el.attr('id', new_id);
					el.attr('name', new_name);
					if(trTotal == i){
		          if(el.attr('type') == "text"){
							el.val('');                  
						}
						else {
							el.prop('selectedIndex',0);
						}
						// Remove when adding new row
						$(this).find('.old_value_hidden').remove();
		            	el.prop('required',false);				
	                }
	                else{
	                	// Add required to required fields                		            		
	            		str_name = new_name.replace('['+i+']','');	   
                  //alert(str_name[i]);   
	            		if(jQuery.inArray(str_name, arrTrunkDidReqFields) >= 0){
	                		el.prop('required',true);
                      if(str_name=='extension'){
                        el.prop('required[]',true);
                      }
	                	}
	                }
				}
			});
		});
		addRemoveFirstClass("trunk_did_detail_master","trunkdid_first");
	}

	$("#trunk_did_detail_master").delegate(".remove-trunkdid", "click", function(){
		var id = $(this).closest('tr').find(".old_value_hidden").val();
		var tenant_id = $("#filter_tenant_id").val();
		var site_id = $("#filter_branch_id").val();
		var totalTR = $('#trunk_did_detail_master tr').length;
		remove_tr = $(this).closest('tr');
		if(id){
			$.ajax({
				url: "<?php echo site_url('System_configuration/ajaxCheckUsed/'); ?>",
				type: "POST",
				data:{id:id,tenant_id:tenant_id,site_id:site_id,table_name:'trunk_did_detail'},
				cache: false,
				success: function(data){
					if(data){
						alert('Routing Already Used You can not remove it.');
					}
					else {
						if(totalTR == 2){
							addTrunkDIDRow();
			        		removeWhiteSpaceFromTextBox();
						}
						removeTableTr(remove_tr);
						addRemoveFirstClass("trunk_did_detail_master","trunkdid_first");
						addRequiredFields('trunk_did_detail_master',arrTrunkDidReqFields);
						removeRequiredFromLastRow('trunk_did_detail_master');
					}
				}
			});
		}
		else {		
			if(totalTR == 2){
				addTrunkDIDRow();
        		removeWhiteSpaceFromTextBox();
			}	
			removeTableTr(remove_tr);
			addRemoveFirstClass("trunk_did_detail_master","trunkdid_first");	  
			addRequiredFields('trunk_did_detail_master',arrTrunkDidReqFields);
			removeRequiredFromLastRow('trunk_did_detail_master');
		}
	});

	$("#trunk_did_detail_master").delegate(".trunkdid_first", "keydown change", function(e){		
		if($(this).val()){
			addTrunkDIDRow();
			removeWhiteSpaceFromTextBox();
		}
	});		
	// Remove required from last row in block number
	removeRequiredFromLastRow('trunk_did_detail_master');
	//----------------------- End TrunkDID Master-----------------------//	
	

    /////// ------------------ E911 MASTER -----------------------------/////
   
    var arrE911RequiredFields = ["trunk_did", "emergencyenable", "emergencynumber", "address1", "address2", "city", "state", "pincode"];

    function addE911Row() {

        $('#e911_master tbody').append($('#e911_master tbody tr:last').clone());
        var trTotal = $('#e911_master tr').length - 1;
        $('#e911_master tr').each(function (i) {
            $(this).find('td').each(function(){
                var el = $(this).find(':first-child');
                var name = el.attr('name') || null;
                if(name) {

                    id = el.attr('id');
                    strIdNumber = id.match(/[^[\]]+(?=])/g);
                    strNameNumber = name.match(/[^[\]]+(?=])/g);

                    new_id = id.replace(strIdNumber,i);                 
                    new_name = name.replace(strNameNumber,i);

                    el.attr('id', new_id);
                    el.attr('name', new_name);

                    if(trTotal == i){
                        if(el.attr('type') == "text" || el.attr('type') == "number"){
                            el.val('');                  
                        }
                        else {
                            el.prop('selectedIndex',0);
                        }
                        // Remove when adding new row
                        $(this).find('.old_value_hidden').remove();
                        el.prop('required',false);  
                    }
                    else{                       
                        // Add required to required fields                  
                        str_name = new_name.replace('['+i+']','');
                        if(jQuery.inArray( str_name, arrE911RequiredFields) >= 0){
                            el.prop('required',true);
                        }
                    }
                }
            });
        });

        addRemoveFirstClass("e911_master","e911_first");
    }

    $("#e911_master").delegate(".remove-trunk", "click", function(){
        var id = $(this).closest('tr').find(".old_value_hidden").val();
        var tenant_id = $("#filter_tenant_id").val();
        var site_id = $("#filter_branch_id").val();
        var totalTR = $('#e911_master tr').length;
        remove_tr = $(this).closest('tr');
        if(id){
            $.ajax({
                url: "<?php echo site_url('System_configuration/ajaxCheckUsed/'); ?>",
                type: "POST",
                data:{id:id,tenant_id:tenant_id,site_id:site_id,table_name:'e911_master'},
                cache: false,
                success: function(data){
                    if(data){
                        alert('Trunk Name Already Used You can not remove it.');
                    }
                    else {
                        if(totalTR == 2){
                            addE911Row();
                            removeWhiteSpaceFromTextBox();
                        }
                        removeTableTr(remove_tr);
                        addRemoveFirstClass("e911_master","e911_first");
                        addRequiredFields('e911_master',arrE911RequiredFields);
                        removeRequiredFromLastRow('e911_master');
                    }
                }
            });
        }
        else {      
            if(totalTR == 2){
                addE911Row();
                removeWhiteSpaceFromTextBox();
            }
            removeTableTr(remove_tr);
            addRemoveFirstClass("e911_master","e911_first");
            addRequiredFields('e911_master',arrE911RequiredFields);
            removeRequiredFromLastRow('e911_master');          
        }
    });

    $("#e911_master").delegate(".e911_first", "keydown change", function(e){      
        if($(this).val()){
            addE911Row();
            removeWhiteSpaceFromTextBox();
        }
    });

    // Remove required from last row in trunk master
    removeRequiredFromLastRow('e911_master');

    ////----------------------END E911 ---------------------------------/////



/////// ------------------ Page Details MASTER -----------------------------/////
   
    var arrPageRequiredFields = ["pagelistname", "pagecommand", "pagemembers"];

    function addPageRow() {

        $('#page_details tbody').append($('#page_details tbody tr:last').clone());
        var trTotal = $('#page_details tr').length - 1;
        $('#page_details tr').each(function (i) {
            $(this).find('td').each(function(){
                var el = $(this).find(':first-child');
                var name = el.attr('name') || null;
                if(name) {

                    id = el.attr('id');
                    strIdNumber = id.match(/[^[\]]+(?=])/g);
                    strNameNumber = name.match(/[^[\]]+(?=])/g);

                    new_id = id.replace(strIdNumber,i);                 
                    new_name = name.replace(strNameNumber,i);

                    el.attr('id', new_id);
                    el.attr('name', new_name);

                    if(trTotal == i){
                        if(el.attr('type') == "text" || el.attr('type') == "number"){
                            el.val('');                  
                        }
                        else {
                            el.prop('selectedIndex',0);
                        }
                        // Remove when adding new row
                        $(this).find('.old_value_hidden').remove();
                        el.prop('required',false);  
                    }
                    else{                       
                        // Add required to required fields                  
                        str_name = new_name.replace('['+i+']','');
                        if(jQuery.inArray( str_name, arrE911RequiredFields) >= 0){
                            el.prop('required',true);
                        }
                    }
                }
            });
        });

        addRemoveFirstClass("page_details","page_details_first");
    }

    $("#page_details").delegate(".remove-trunk", "click", function(){
        var id = $(this).closest('tr').find(".old_value_hidden").val();
        var tenant_id = $("#filter_tenant_id").val();
        var site_id = $("#filter_branch_id").val();
        var totalTR = $('#page_details tr').length;
        remove_tr = $(this).closest('tr');
        if(id){
            $.ajax({
                url: "<?php echo site_url('System_configuration/ajaxCheckUsed/'); ?>",
                type: "POST",
                data:{id:id,tenant_id:tenant_id,site_id:site_id,table_name:'page_details'},
                cache: false,
                success: function(data){
                    if(data){
                        alert('Page Lis Name Already Used You can not remove it.');
                    }
                    else {
                        if(totalTR == 2){
                            addPageRow();
                            removeWhiteSpaceFromTextBox();
                        }
                        removeTableTr(remove_tr);
                        addRemoveFirstClass("page_details","page_details_first");
                        addRequiredFields('page_details',arrPageRequiredFields);
                        removeRequiredFromLastRow('page_details');
                    }
                }
            });
        }
        else {      
            if(totalTR == 2){
                addPageRow();
                removeWhiteSpaceFromTextBox();
            }
            removeTableTr(remove_tr);
            addRemoveFirstClass("page_details","page_details_first");
            addRequiredFields('page_details',arrE911RequiredFields);
            removeRequiredFromLastRow('page_details');          
        }
    });

    $("#page_details").delegate(".page_details_first", "keydown change", function(e){      
        if($(this).val()){
            addPageRow();
            removeWhiteSpaceFromTextBox();
        }
    });

    // Remove required from last row in trunk master
    removeRequiredFromLastRow('page_details');

    ////----------------------page Details ---------------------------------/////



/////// ------------------ Page Details MASTER -----------------------------/////
   
    var arrPageSettingRequiredFields = ["pageparameter"];

    function addPageSettingRow() {

        $('#page_setting tbody').append($('#page_setting tbody tr:last').clone());
        var trTotal = $('#page_setting tr').length - 1;
        $('#page_setting tr').each(function (i) {
            $(this).find('td').each(function(){
                var el = $(this).find(':first-child');
                var name = el.attr('name') || null;
                if(name) {

                    id = el.attr('id');
                    strIdNumber   = id.match(/[^[\]]+(?=])/g);
                    strNameNumber = name.match(/[^[\]]+(?=])/g);

                    new_id   = id.replace(strIdNumber,i);                 
                    new_name = name.replace(strNameNumber,i);

                    el.attr('id', new_id);
                    el.attr('name', new_name);

                    if(trTotal == i){
                        if(el.attr('type') == "text" || el.attr('type') == "number"){
                            el.val('');                  
                        }
                        else {
                            el.prop('selectedIndex',0);
                        }
                        // Remove when adding new row
                        $(this).find('.old_value_hidden').remove();
                        el.prop('required',false);  
                    }
                    else{                       
                        // Add required to required fields                  
                        str_name = new_name.replace('['+i+']','');
                        if(jQuery.inArray( str_name, arrPageSettingRequiredFields) >= 0){
                            el.prop('required',true);
                        }
                    }
                }
            });
        });

        addRemoveFirstClass("page_setting","page_setting_first");
    }

    $("#page_setting").delegate(".remove-trunk", "click", function(){
        var id = $(this).closest('tr').find(".old_value_hidden").val();
        var tenant_id = $("#filter_tenant_id").val();
        var site_id = $("#filter_branch_id").val();
        var totalTR = $('#page_setting tr').length;
        remove_tr = $(this).closest('tr');
        if(id){
            $.ajax({
                url: "<?php echo site_url('System_configuration/ajaxCheckUsed/'); ?>",
                type: "POST",
                data:{id:id,tenant_id:tenant_id,site_id:site_id,table_name:'page_setting'},
                cache: false,
                success: function(data){
                    if(data){
                      alert('Page Lis Name Already Used You can not remove it.');
                    }
                    else {
                      if(totalTR == 2){
                        addPageSettingRow();
                        removeWhiteSpaceFromTextBox();
                      }
                        removeTableTr(remove_tr);
                        addRemoveFirstClass("page_setting","page_setting_first");
                        addRequiredFields('page_setting',arrPageSettingRequiredFields);
                        removeRequiredFromLastRow('page_setting');
                    }
                }
            });
        }
        else {      
            if(totalTR == 2){
             addPageSettingRow();
             removeWhiteSpaceFromTextBox();
            }
            removeTableTr(remove_tr);
            addRemoveFirstClass("page_setting","page_setting_first");
            addRequiredFields('page_setting',arrPageSettingRequiredFields);
            removeRequiredFromLastRow('page_setting');          
        }
    });

    $("#page_setting").delegate(".page_setting_first", "keydown change", function(e){      
        if($(this).val()){
            addPageSettingRow();
            removeWhiteSpaceFromTextBox();
        }
    });

    // Remove required from last row in trunk master
    removeRequiredFromLastRow('page_setting');

    ////----------------------page Details ---------------------------------/////




	//------------------ Start branch model multiple---------------------//
	function addRow(){
		$('#addbranch tbody').append($('#addbranch tbody tr:last').clone());
		var trTotal = $('#addbranch tr').length - 1;
		$('#addbranch tr').each(function (i) {
			if (i === 1)
				return;

			$(this).find('td').each(function(){
				var el = $(this).find(':first-child');
				var name = el.attr('name') || null;
				if(name) {

					id = el.attr('id');
					strIdNumber = id.match(/[^[\]]+(?=])/g);
					strNameNumber = name.match(/[^[\]]+(?=])/g);

					new_id = id.replace(strIdNumber,i);	            	
					new_name = name.replace(strNameNumber,i);

					el.attr('id', new_id);
					el.attr('name', new_name);

					if(trTotal == i){
	            		el.val('');
						el.prop('required',false);				
	                }
	                else{
	                	el.prop('required',true);
	                }
				}
				$(this).find('.remove-branch').removeClass('delete-disabled');
			});
		});
		addRemoveFirstClass("addbranch","branch_first");
		/*$("#addbranch").find('.branch_first').removeClass("branch_first");
		$('#addbranch > tbody > tr').last().find('select,input').first().addClass('branch_first');*/
	}

	$("#addbranch").delegate(".remove-branch", "click", function(){
		$(this).closest('tr').remove();
		addRemoveFirstClass("addbranch","branch_first");
		/*$("#addbranch").find('.branch_first').removeClass("branch_first");
		$('#addbranch > tbody > tr').last().find('select,input').first().addClass('branch_first');*/ 
	});

	$("#addbranch").delegate(".branch_first", "keydown change", function(e){		
		if($(this).val()){
			addRow();
			removeWhiteSpaceFromTextBox();
		}
	});

	$("#centralModalInfo").on('shown.bs.modal', function(){
        $('.branch_first').focus();
    });
	// Remove required from last row in ivr_routing_master
	removeRequiredFromLastRow('addbranch');
	//------------------- End Branch model Master--------------------------//
}); 

function show_ivr_config(id){  //deep27
	$.ajax({
		url: "<?php echo site_url('System_configuration/get_ivr_config/'); ?>"+id,
		type: "POST",
		cache: false,
		success: function(data){
			$("#ivr_confi_model").html('');
			$("#ivr_confi_model").html(data);
			$('#ivr_confi_model .mdb-select').materialSelect();
			$('#show_ivr_config_model').click();
			$("#trunk_did").trigger("change");
			removeWhiteSpaceFromTextBox();
			var arrIVRRoutingReqFields = ["ivr_level", "IVR_Prompt_file", "ringingseconds", "default_choice"];
			function addIVRRoutingRow(){
				$('#ivr_routing_master tbody').append($('#ivr_routing_master tbody tr:last').clone());
				var trTotal = $('#ivr_routing_master tr').length - 1;
				$('#ivr_routing_master tr').each(function (i) {
					$(this).find('td').each(function(){
						var el = $(this).find(':first-child');
						var name = el.attr('name') || null;
						if(name) {

							//id = el.attr('id');
							//strIdNumber = id.match(/[^[\]]+(?=])/g);
							strNameNumber = name.match(/[^[\]]+(?=])/g);

							var res = name.split("-");
							if(res[0] == 'choice1'){
							name = res[0]+'-'+i+'[]';	
							}
							if(res[0] == 'choice2'){
							name = res[0]+'-'+i+'[]';	
							}
							if(res[0] == 'choice3'){
							name = res[0]+'-'+i+'[]';	
							}
							if(res[0] == 'choice4'){
							name = res[0]+'-'+i+'[]';	
							}
							if(res[0] == 'choice5'){
							name = res[0]+'-'+i+'[]';	
							}
							if(res[0] == 'choice6'){
							name = res[0]+'-'+i+'[]';	
							}
							if(res[0] == 'choice7'){
							name = res[0]+'-'+i+'[]';	
							}
							if(res[0] == 'choice8'){
							name = res[0]+'-'+i+'[]';	
							}	
							if(res[0] == 'choice9'){
							name = res[0]+'-'+i+'[]';	
							}

							//new_id = id.replace('['+strIdNumber+']','['+i+']');	            	
							new_name = name.replace('['+strNameNumber+']','['+i+']');
							//alert(new_name);

							//el.attr('id', new_id);
							el.attr('name', new_name);
							if(trTotal == i){
				            	if(el.attr('type') == "text"){
									el.val('');                  
								}
								else {
									el.prop('selectedIndex',0);
								}
								$(this).find('.old_value_hidden').remove();
				            	el.prop('required',false);				
			                }
			                else{
			                	// Add required to required fields                	
			            		str_name = new_name.replace('['+i+']','');
			            		if(jQuery.inArray( str_name, arrIVRRoutingReqFields) >=0 ){
                          if(str_name !='IVR_Prompt_file' && str_name !='ringingseconds'){
                              el.prop('required',true);
                          }
			                		// el.prop('required',true);
			                	}
			                }
						}
					});
				});

				addRemoveFirstClass("ivr_routing_master","IVR_first");
			}

			$("#ivr_routing_master").delegate(".remove-ivr", "click", function(){
				var totalTR = $('#ivr_routing_master tr').length;
				remove_tr = $(this).closest('tr');
				if(totalTR == 2){
					addIVRRoutingRow();
	        		removeWhiteSpaceFromTextBox();
				}				
				removeTableTr(remove_tr);
				addRemoveFirstClass("ivr_routing_master","IVR_first");
				addRequiredFields('ivr_routing_master',arrIVRRoutingReqFields);
				removeRequiredFromLastRow('ivr_routing_master'); 
			});

			$("#ivr_routing_master").delegate(".IVR_first", "keydown change", function(e){		
				if($(this).val()){
					addIVRRoutingRow();
					removeWhiteSpaceFromTextBox();
				}
			});	
			// Remove required from last row in ivr_routing_master
			removeRequiredFromLastRow('ivr_routing_master');
		}
	});
}
// ------------jQuery code End For Add multiple Elements-----------------//
// End System configuration script

//** Login Page Validation Start//
$("input#username").on({
  keydown: function(e) {
    if (e.which === 32)
      return false;
  },
  change: function() {
    this.value = this.value.replace(/\s/g, "");
  }
});

$("input#password").on({
  keydown: function(e) {
    if (e.which === 32)
      return false;
  },
  change: function() {
    this.value = this.value.replace(/\s/g, "");
  }
});

function blockSpecialChar(e){
var k;
document.all ? k = e.keyCode : k = e.which;
return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57));
}
//** Login Page Validation End//
</script>

<script type="text/javascript"> 
$(document).ready(function(){
  $("#search_data").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#import_table tr").filter(function() {
     $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>

<script type="text/javascript">
/********************************
 * ACCORDION WITH TOGGLE ICONS * 
*********************************/
  function toggleIcon(e) {
    $(e.target)
            .prev('.panel-heading')
            .find(".more-less")
            .toggleClass('fa-chevron-down fa-chevron-up');
    }

    $('.panel-group').on('hidden.bs.collapse', toggleIcon);
    $('.panel-group').on('shown.bs.collapse', toggleIcon);    
</script>
<!-- FAQ -->
<script type="text/javascript">
	$(document).ready(function () {
	  $('#AllDatatable').DataTable({
	    responsive: true,
	    stateSave:true,
	            "bDestroy": true,
	               "bSort": true,
	               "bFilter": true,
	               "lengthMenu": [ 5, 15, 25, 35, 100 ]

	    } );
	});
    
	$(document).ready (function(){
	   $(".note-danger").hide();
	    $(".note").fadeTo(5000, 500).slideUp(500, function(){
	        $(".note").slideUp(500);
	    });
	});

	$(document).ready (function(){
	    $(".alert-success").hide();
	    $(".alert-success").fadeTo(5000, 500).slideUp(500, function(){
	        $(".alert-success").slideUp(500);
	    }); 
	}); 
  
  

</script>
<!-- FAQ End -->

</body>
</html>

