<?php $this->load->view('/components/page_head') ?>



<body style="background: #e4e4e485">

<style type="text/css">
  * {
  margin: 0;
  padding: 0;
}

.loader {
  display: none;
  top: 50%;
  left: 50%;
  position: absolute;
  transform: translate(-50%, -50%);
}

.loading {
  border: 2px solid #ccc;
  width: 60px;
  height: 60px;
  border-radius: 50%;
  border-top-color: #1ecd97;
  border-left-color: #1ecd97;
  animation: spin 1s infinite ease-in;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }

  100% {
    transform: rotate(360deg);
  }
}
</style>

<div class="row">

<div class="col-md-3"></div>

<div class="col-md-6"><h1 class="font-weight-bold text-center my-4">System Configuration</h1></div>

<div class="col-md-3">

<a href="http://www.bizrtc.com" target="_blank">  <img src="<?php echo site_url('images/bizrtc.png'); ?>" style="height:100px; width: 260px; float: right;  "></a>

</div>

</div>

<div class="row">

  

  <div class="col-md-12">



    <div class="card" style="margin-bottom: 10px;">

    <div class="card-body" style="padding: 10px;height: 70px;margin-right: 0px;border: 1px solid;">

    <form method="post" name="filter_form" id="filter_form" >

      <div class="row" style="margin-top:-18px;">

          <div class="col-md-2">

            <div class="md-form md-outline form-md">

              <input id="account_code" class="form-control form-control-md" type="text" disabled value="<?php echo $account_code;?>">

              <label for="account_code">Account code</label>

            </div>

          </div>

          <div class="col-md-2">

              <select class="mdb-select md-form md-outline colorful-select dropdown-primary" name="tenant_id" id="filter_tenant_id">

                <?php

                if(!empty($tenantList)){            

                  foreach ($tenantList as $key => $tenant_detail) {

                    ?><option value="<?php echo $tenant_detail->id;?>" <?php if($_SESSION['tenant_id'] == $tenant_detail->id){ echo 'selected';} ?>><?php echo $tenant_detail->tenant_name;?></option><?php

                  }

                }

                ?>

              </select>

              <label for="tenant_id">Tenant name</label>

          </div>

          <div class="col-md-2">

            <select class="mdb-select md-form md-outline colorful-select dropdown-primary" name="branch_id" id="filter_branch_id" onchange="javascript:this.form.submit()">

              <?php

              if(!empty($branchList)){            

                foreach ($branchList as $key => $branch_detail) {

                  ?><option value="<?php echo $branch_detail->id;?>" <?php if($_SESSION['site_id'] == $branch_detail->id){ echo 'selected'; }?>><?php echo $branch_detail->site_name;?></option><?php

                }

              }

              ?>

            </select>

            <label for="branch_id">Branch name</label>

          </div>

          <div class="col-md-1" style="margin-top: 29px; margin-left: -25px;">

          <a href="#" class="edit-branch" data-toggle="modal" data-target="#centralModalSmBranch"> <h4> <i class="fas fa-edit"></i> </h4> </a></div>

          <div class="col-md-5">

            <div class="md-form md-outline form-md" style="float: right;margin-top: 18px;margin-right: -32px;margin-left: -36px;">              

              <a href="" data-toggle="modal" data-target="#centralModalSm" class="waves-effect waves-dark btn btn-sm btn-primary" id="add_account"><i class="fas fa-edit"></i> Account</a>



              <a href="" class="waves-effect waves-dark btn btn-sm btn-primary" data-toggle="modal" data-target="#centralModalInfo" id="add_branch"><i class="fas fa-plus"> </i> Branch</a>



              <!--a href="<?php echo site_url('System_configuration/export'); ?>" class="waves-effect waves-dark btn btn-sm btn-primary"><i class="fas fa-file-export"></i> Export</a-->

              <!-- Basic dropdown -->

              <button class="waves-effect waves-dark btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown"

              aria-haspopup="true" aria-expanded="false">Configure</button>



              <div class="dropdown-menu">

              <!-- <a class="dropdown-item" href="<?php echo site_url('PhpScript/master_file/'.$_SESSION['tenant_id'].'/'.$_SESSION['account_id']); ?>" ><i class="fas fa-file-export"></i> Setup PBX</a> -->

              <a class="dropdown-item" id="setup_data" onclick="SetupConfiguration('<?php echo $_SESSION['tenant_id'];?>','<?php echo $_SESSION['site_id'];?>','<?php echo $_SESSION['account_id'];?>')"><i class="fas fa-file-export"></i> Setup Configuration</a> 
              <!-- <a class="dropdown-item" href="<?php //echo site_url('System_configuration/export'); ?>" ><i class="fas fa-file-export"></i> Setup Configuration</a> -->

              <?php

              $file = "../csvfile/Login_Details_".getUserNameByTenantId($_SESSION['tenant_id']).".csv";

              if(file_exists($file)) {$dis = '';}else {$dis = 'disabled';};

              ?>

              <a class="dropdown-item <?php echo $dis ?>" href="../csvfile/Login_Details_<?php echo getUserNameByTenantId($_SESSION['tenant_id']) ?>.csv"><i class="fas fa-download"></i> Export Extensions</a>



              </div>

              <!-- Basic dropdown -->



              <a href="<?php echo site_url('System_configuration/logout'); ?>" class="waves-effect waves-dark btn btn-sm btn-primary"><i class="fas fa-sign-out-alt"></i> Logout</a>

              

            </div>

          </div>

      </div>

    </form>

  </div>

</div>



    <div class="card">

    <div class="card-body" style="padding: 30px;height: 480px;border: 1px solid;">

    <ul class="stepper horizontal" id="myTab">   
  
      <li class="step <?php if($page_title=='Dashboard'){echo 'active';}elseif($this->uri->segment(3)=='1'){echo 'active';}?>" role="tab" id="trunk">

        <div class="step-title waves-effect waves-dark">Trunk</div>

        <div class="step-new-content">

          <div class="row">

            <div class="col-md-12">


          <?php $this->load->view('system_config/trunk_master') ?>          

           </div>

          </div>

        </div>

      </li>

      <li class="step <?php if($this->uri->segment(3)=="2"){echo 'active';}?>" role="tab" id="extension">

        <div class="step-title waves-effect waves-dark">Extension </div>

        <div class="step-new-content">

        <div class="row">

          <div class="col-md-12">

          <?php $this->load->view('system_config/extension_details') ?>          

        </div>

        </div>

        </div>

      </li>

      <li class="step <?php if($this->uri->segment(3)=="3"){echo 'active';}?>" role="tab" id="routing">

        <div class="step-title waves-effect waves-dark">Routing</div>

        <div class="step-new-content">

        <div class="row">

        <div class="col-md-12">

          <?php $this->load->view('system_config/trunkdid_details') ?>                    

        </div>

        </div>

        </div>

      </li>

      <li class="step <?php if($this->uri->segment(3)=="4"){echo 'active';}?>" id="ivr_config">

        <div class="step-title waves-effect waves-dark">IVR config</div>

        <div class="step-new-content">

        <div class="row">

            <div class="col-md-12">

          <?php $this->load->view('system_config/didrouting_with_ivr') ?>     

        </div>

        </div>

        </div>

      </li>

      <li class="step <?php if($this->uri->segment(3)=="5"){echo 'active';}?>" id="e911">

        <div class="step-title waves-effect waves-dark">E911</div>

        <div class="step-new-content">

        <div class="row">

            <div class="col-md-12">

          <?php $this->load->view('system_config/e911') ?> 

        </div>

        </div>

        </div>

      </li>

      <li class="step <?php if($this->uri->segment(3)=="6"){echo 'active';}?>" id="page_details">

        <div class="step-title waves-effect waves-dark">Page Details</div>

        <div class="step-new-content">

        <div class="row">

            <div class="col-md-12">

          <?php $this->load->view('system_config/page_details') ?> 

        </div>

        </div>

        </div>

      </li>

       <li class="step <?php if($this->uri->segment(3)=="7"){echo 'active';}?>" id="page_setting">

        <div class="step-title waves-effect waves-dark">Page Setting</div>

        <div class="step-new-content">

        <div class="row">

            <div class="col-md-12">

          <?php $this->load->view('system_config/page_setting') ?> 

        </div>

        </div>

        </div>

      </li>

     <!--  <li class="step <?php //if($this->uri->segment(3)=="8"){echo 'active';}?>" id="faq_detail">

        <div class="step-title waves-effect waves-dark">FAQ</div>

        <div class="step-new-content">

          <div class="row">

              <div class="col-md-12">

              <?php //$this->load->view('system_config/faq') ?> 

            </div>

          </div>

        </div>

      </li> -->

    </ul>

    </div>

    </div>

  </div>

</div>

<div id="overlay" style="display:none;">

    <div class="spinner"></div>

    <br/>

   Apply system changes

</div>

</form>



<!-- MODEL FOR Add New BRANCH -->

<div class="modal fade" id="centralModalInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"

   aria-hidden="true" <?php if($showModelAddBranch){ ?> data-backdrop="static" data-keyboard="false" <?php } ?>>

   <div class="modal-dialog modal-notify modal-info" role="document" style="width:350px;">

     <!--Content-->

     <div class="modal-content">

   <div class="modal-body">

      <form  method="post" action="<?php echo site_url('System_configuration/addBranch');?>">

           

        <h5><i class="fas fa-tasks"></i> Add new branch</h5><hr style="margin-top: 5px;margin-bottom: 0;">



    <div id="table" class="table-editable" style="overflow: scroll;height: 180px">                     

    <div>       

      <table class="table table-bordered table-responsive-md table-striped text-center" id="addbranch">

        <thead>                        

          <tr>

    

            <th class="text-center">#</th>

            

            <th class="text-center">Branch name</th> 

            </tr>

        </thead>

        

        <tbody>

          <tr class="branch_div">

            <td class="pt-3-half" style="vertical-align: inherit;"><a href="#" class="remove-branch delete-disabled"><i class="fas fa-trash"></i></a></td>

            <td class="pt-3-half" style="vertical-align: inherit;"><input type="text" name="branch[1]" id="branch[1]" placeholder="branch" value=""  class="branch_first" style="width: 100%;"required></td>

            </tr>

        </tbody>                                                

      </table>

      </div>

  </div>

</div>



       <!--Footer-->

       <div class="modal-footer justify-content-center"> 

       <div class="col-md-12" style="text-align: center;">

            <input type="submit" name="submit" value="Save" class="btn-primary">  

            <?php if(!$showModelAddBranch){ ?>

              <input type="submit" class="btn-primary" name="" data-dismiss="modal" value="Close"> 

            <?php }else{ ?>

              <a href="<?php echo site_url('System_configuration/logout')?>" class="btn-primary"><input type="button" class="btn-primary" name="" value="Logout"></a>

            <?php } ?>

      </div>

       </div>

     </div>

     <!--/.Content-->

     </form>

   </div>

 </div>



<div class="modal fade" id="centralModalSm" tabindex="-1" role="dialog" aria-labelledby="account"

  aria-hidden="true" data-backdrop="static" data-keyboard="false">



  <!-- Change class .modal-sm to change the size of the modal -->

  <div class="modal-dialog modal-lg" role="document">

    <div class="modal-content">

      <div class="modal-body">

        <!-- FORM START      -->

        <form class="" style="color: #757575;" method="post" action="" id="Account_detail" name="Account_detail" onsubmit="">

          <div class="row">

            <div class="col-md-12">

              <h5><i class="fas fa-tasks"></i> Account detail</h5><hr style="margin-top: 5px;margin-bottom: 0;">

            </div>

            <div class="col-md-4">

              <div class="md-form md-outline">

                <input type="number" name="account_code" id="account_code" value="<?php echo $account_detail->account_code;?>" class="form-control" readonly required>

                <label for="account_code">Account code</label>

              </div>

            </div>



            <div class="col-md-4">

              <div class="md-form md-outline">

                <input type="text" name="organization_name" id="organization_name" value="<?php echo $account_detail->organization_name;?>" class="form-control" required>

                <label for="organization_name">Organization name</label>

              </div>

            </div>



            <div class="col-md-4">

              <div class="md-form md-outline">

                <input type="text" name="address" id="address" value="<?php echo $account_detail->address;?>" class="form-control" >

                <label for="address">Address</label>

              </div>

            </div>



            <div class="col-md-4">

              <div class="md-form md-outline">

                <input type="text" name="site_key_issued" id="site_key_issued" value="<?php echo $account_detail->site_key_issued;?>" class="form-control avoid_space" >

                <label for="site_key_issued">Site key issued</label>

              </div>

            </div>



            <div class="col-md-4">

              <div class="md-form md-outline">

                <input type="text" name="customer_contact_name" id="customer_contact_name" value="<?php echo $technical_detail->first_name;?>" class="form-control" >

                <label for="customer_contact_name">Customer contact name</label>

              </div>

            </div>



            <div class="col-md-4">

              <div class="md-form md-outline">

                <input type="text" name="customer_contact_number" id="customer_contact_number" value="<?php echo $technical_detail->phone;?>" class="form-control avoid_space" pattern="^\d{10}$" >

                <label for="customer_contact_number">Customer number</label>

              </div>

            </div>



            <div class="col-md-4">

              <div class="md-form md-outline">

                <input type="text" name="sales_contact_name" id="sales_contact_name" value="<?php echo $sales_detail->first_name;?>" class="form-control"  >

                <label for="sales_contact_name">Sales contact name</label>

              </div>

            </div>



            <div class="col-md-4">

              <div class="md-form md-outline">

                <input type="text" name="sales_contact_number" id="sales_contact_number" value="<?php echo $sales_detail->phone;?>" class="form-control avoid_space" pattern="^\d{10}$">

                <label for="sales_contact_number">Sales contact number</label>

              </div>

            </div>



            <div class="col-md-12" style="margin-top: 10px !important;">

              <h5><i class="fas fa-user-tie"></i> Tenant detail</h5><hr style="margin-top: 5px;margin-bottom: 0;">

            </div>



            <div class="col-md-4">

              <div class="md-form md-outline">

                <input type="text" name="tenant_name" id="tenant_name" value="<?php echo $tenantDetail->tenant_name;?>" class="form-control" readonly >

                <label for="tenant_name">Tenant name</label>

              </div>

            </div>



            <div class="col-md-4">

              <div class="md-form md-outline">

                <input type="email" name="email" id="email" value="<?php echo $tenantDetail->email;?>" class="form-control avoid_space" >

                <label for="email">E-mail</label>

              </div>

            </div>





            <div class="col-md-4">

              <div class="md-form md-outline">

                <input type="text" name="conatct_person" id="conatct_person" value="<?php echo $tenantDetail->contat_person;?>" class="form-control" >

                <label for="conatct_person">Conatct person</label>

              </div>

            </div>



            <div class="col-md-4">

              <div class="md-form md-outline">

                <input type="text" name="country_code" id="country_code" value="<?php echo $tenantDetail->country_code;?>" class="form-control avoid_space" pattern="^[0-9]*$">

                <label for="country_code">Country code</label>

              </div>

            </div>



            <div class="col-md-4">

              <div class="md-form md-outline">

                <input type="text" name="phone" id="phone" value="<?php echo $tenantDetail->phone;?>" class="form-control avoid_space" pattern="^\d{10}$">

                <label for="phone">Phone number</label>

              </div>

            </div>



            <div class="col-md-4">

              <select name="time_zone" class="browser-default custom-select" style="margin-top: 26px;" required> 

                <option value="" disabled selected>Time zone</option>

                <?php 

                if(!empty($timeZonesList)){

                  foreach ($timeZonesList as $key => $timeZone) {

                     ?><option value="<?php echo $timeZone->time;?>" <?php if($tenantDetail->time_zone == $timeZone->time){ echo 'selected';}?>><?php echo $timeZone->name;?></option><?php

                  }

                }

                ?>

              </select>

              <!-- <label for="time">Time zone</label> -->

            </div>  

            <div class="col-md-12"><hr>            

              <input type="hidden" name="account_id_update" value="<?php echo $account_detail->id;?>">

              <input type="hidden" name="tenant_id_update" value="<?php echo $tenantDetail->id;?>">

              <input type="submit" class="waves-effect waves-dark btn btn-sm btn-primary" name="save_account" value="Save">

              <button type="button" class="waves-effect waves-dark btn btn-sm btn-primary" data-dismiss="modal">Close</button>

            </div>

          </div> 

        </form>

        <!-- FORM End -->

      </div>

    </div>

  </div>

</div>

<!-- Central Modal Small for Edit branch Details -->

<div class="modal fade" id="centralModalSmBranch" tabindex="-1" role="dialog" aria-labelledby="branch"

  aria-hidden="true" data-backdrop="static" data-keyboard="false">



  <!-- Change class .modal-sm to change the size of the modal -->

  <div class="modal-dialog modal-lg" role="document">

    <div class="modal-content">

      <div class="modal-body">

        <!-- FORM START      -->

        <form class="text-center" style="color: #757575;" method="post" action="" id="branch_master_form" name="branch_master_form" onsubmit="savedata()"> 

      <div class="col-md-12" style="text-align: left;">

      <h5><i class="fas fa-tasks"></i> Branch detail</h5><hr style="margin-top: 5px;margin-bottom: 0;">

    </div>   

  <div class="row">

  

    <div class="col-md-4">

      <div class="md-form md-outline">

          <input type="text" name="site_name" id="site_name" value="<?php echo $branchDetail->site_name;?>" class="form-control" required>

          <label for="site_name">Branch name</label>

      </div>

    </div>

    <div class="col-md-4">

      <!-- <div class="md-form md-outline"> -->

        <select name="trunk_name" id="trunk_name" class="mdb-select md-form md-outline colorful-select dropdown-primary" required=""><option value="">Select trunk</option>

        <?php 

          if(!empty($trunkList)){

            foreach ($trunkList as $key => $trunk_detail) {

               ?><option value="<?php echo $trunk_detail->id;?>" <?php if($branchDetail->trunk_id==$trunk_detail->id){ echo 'selected';}?>><?php echo $trunk_detail->trunk_name;?></option><?php

            }

          }

        ?>

        </select>

        <label>Trunk name</label>

      <!-- </div> -->

    </div>    

    <div class="col-md-4">

      <div class="md-form md-outline">

          <input type="text" name="branch_prefix_number" id="branch_prefix_number" value="<?php echo $branchDetail->branch_prefix;?>" class="form-control avoid_space" pattern="^[0-9]*$" required>

          <label for="branch_prefix_number">Branch prefix</label>

        </div>

    </div>    

    <div class="col-md-4">

      <div class="md-form md-outline">

        <input type="text" name="moh" id="moh" value="<?php echo $branchDetail->moh;?>" class="form-control">

        <label for="moh">Music on hold</label>

      </div>

    </div>

    

    <div class="col-md-4">

      <div class="md-form md-outline">  

        <input type="text" name="park_extension" id="park_extension" value="<?php echo $branchDetail->park_extension;?>" class="form-control avoid_space" pattern="^[0-9]*$" required>

        <label for="park_extension">Park extension</label>

      </div>

    </div>

    <div class="col-md-4">

      <!-- <div class="md-form md-outline">    -->               

        <select name="isd_allowed" id="isd_allowed" class="mdb-select md-form md-outline colorful-select dropdown-primary" required>

          <option value="" disabled selected>ISD allowed</option>

          <option value="Y" <?php if($branchDetail->isd_allowed=='Y'){ echo 'selected';}?>>Yes</option>

          <option value="N" <?php if($branchDetail->isd_allowed=='N'){ echo 'selected';}?>>No</option>

        </select>

        <label>ISD allowed</label>

      <!-- </div> -->

    </div>

    

    <div class="col-md-4">

      <div class="md-form md-outline">

        <input type="text" name="parking_slot" pattern="^[0-9]*$" id="parking_slot" value="<?php echo $branchDetail->parking_slot;?>" class="form-control avoid_space" required>

        <label for="parking_slot">Parking slot</label>

      </div>

    </div>

    <div class="col-md-4">

      <div class="md-form md-outline">

        <input type="text" name="country_code" id="country_code" value="<?php echo $branchDetail->country_code;?>" class="form-control avoid_space" pattern="^[0-9]*$" required>

        <label for="country_code ">Country code</label>

      </div>

    </div>

    <div class="col-md-4">

      

        <select name="park_retreive" id="park_retreive" class="mdb-select md-form md-outline colorful-select dropdown-primary" required>

          <option value="" disabled selected>Park retreive</option>

          <option value="Y" <?php if($branchDetail->park_retreive=='Y'){ echo 'selected';}?>>Yes</option>

          <option value="N" <?php if($branchDetail->park_retreive=='N'){ echo 'selected';}?>>No</option>

        </select>

         <label>Park retreive</label> 

  

    </div>

    <div class="col-md-4">

        <select name="call_recording" id="call_recording" class="mdb-select md-form md-outline colorful-select dropdown-primary" required>

          <option value="" disabled selected>Call recording</option>

          <option value="Y" <?php if($branchDetail->call_recording=='Y'){ echo 'selected';}?>>Yes</option>

          <option value="N" <?php if($branchDetail->call_recording=='N'){ echo 'selected';}?>>No</option>

        </select>

        <label>Call recording</label> 

    </div>

    <div class="col-md-4">

        <select name="call_monitoring" id="call_monitoring" class="mdb-select md-form md-outline colorful-select dropdown-primary" required><option value="" disabled selected>Call monitoring</option>

          <option value="Y" <?php if($branchDetail->call_monitoring=='Y'){ echo 'selected';}?>>Yes</option>

          <option value="N" <?php if($branchDetail->call_monitoring=='N'){ echo 'selected';}?>>No</option>

        </select>

        <label>Call monitoring</label>

    </div>

    <div class="col-md-4">

        <select name="inter_branch" id="inter_branch" class="mdb-select md-form md-outline colorful-select dropdown-primary" required><option value="" disabled selected>Inter branch</option>

          <option value="Y" <?php if($branchDetail->inter_branch=='Y'){ echo 'selected';}?>>Yes</option>

          <option value="N" <?php if($branchDetail->inter_branch=='N'){ echo 'selected';}?>>No</option>

        </select>

        <label>Inter branch</label>

        <input type="hidden" name="branch_id" value="<?php echo $branchDetail->id;?>">

    </div>           

    

    <div class="col-md-4">

    <div class="md-form md-outline">

      <input type="time" id="off_start-picker" name="off_start"  value="<?php if(!empty($branchDetail->off_start)){echo $branchDetail->off_start;}else{echo "00:00";}?>" class="form-control" >

      <label for="off_start-picker">Office start time</label>

    </div>

  </div>





  <div class="col-md-4">

    <div class="md-form md-outline">

      <input type="time" id="off_end-picker" name="off_end" value="<?php if(!empty($branchDetail->off_end)){echo $branchDetail->off_end;}else{echo "23:59";}?>" class="form-control">

      <label for="off_end-picker">Office end time</label>

    </div>

  </div>





<?php

  $off_days = $branchDetail->off_days;

  $arr_off_days = array();

  if(!empty($off_days)){

    $arr_off_days = explode("|",$off_days);

  }

  ?>

    

  <div class="col-md-4">

    <select class="mdb-select md-form md-outline colorful-select dropdown-primary" name="off_days[]" multiple searchable="Search here.." id="office_days">

      <option value="" disabled selected>Click & Select Days</option>

      <option value="mon" <?php if(in_array('mon', $arr_off_days)){ echo 'selected';}?>>Monday</option>

      <option value="tue" <?php if(in_array('tue', $arr_off_days)){ echo 'selected';}?>>Tuesday</option>

      <option value="wed" <?php if(in_array('wed', $arr_off_days)){ echo 'selected';}?>>Wednesday</option>

      <option value="thu" <?php if(in_array('thu', $arr_off_days)){ echo 'selected';}?>>Thursday</option>

      <option value="fri" <?php if(in_array('fri', $arr_off_days)){ echo 'selected';}?>>Friday</option>

      <option value="sat" <?php if(in_array('sat', $arr_off_days)){ echo 'selected';}?>>Saturday</option>

      <option value="sun" <?php if(in_array('sun', $arr_off_days)){ echo 'selected';}?>>Sunday</option>

    </select>

    <label>Office Days</label>

  </div>





  <div class="col-md-4">

  <!-- <div class="md-form md-outline"> -->

  <select name="cdr_timezone" id="cdr_timezone" class="mdb-select md-form md-outline colorful-select dropdown-primary"  searchable="Search here..">

  <option value="" disabled selected>Select time zone</option> 

  <?php 

  if(!empty($timeZonesList)){

    foreach ($timeZonesList as $key => $timeZone) {

       ?><option value="<?php    

        echo $timeZone->time;?>" <?php if($branchDetail->cdr_timezone==$timeZone->time){ echo 'selected';}?>><?php echo $timeZone->name;?></option><?php

    }

  }

  ?>

  </select>

  <label>Time Zone</label>

  <!-- </div> -->

  </div>   

  



    <div class="col-md-12" style="text-align: left;"><hr> 

      <input type="hidden" name="tenant_id_update" value="<?php echo $tenant_id_update;?>">

      <input type="hidden" name="site_id_update" value="<?php echo $site_id_update;?>">

      <input type="submit" class="waves-effect waves-dark btn btn-sm btn-primary" name="save_branch_detail" value="Save">

      <input type="submit" class="waves-effect waves-dark btn btn-sm btn-primary" name="close" value="Close" data-dismiss="modal">

    </div>

  </div>

</form>

        <!-- FORM End -->

      </div>

    </div>

  </div>

</div>

<div class="modal fade" id="add_ivr_config" tabindex="-1" role="dialog" aria-labelledby="IVR Config" aria-hidden="true" >



  <!-- Change class .modal-sm to change the size of the modal -->

  <div class="modal-dialog modal-fluid" role="document" style="width: 95%;">

    <div class="modal-content">

      <div class="modal-body" id="ivr_confi_model">



      </div>

  </div>

</div>

<!-- Central Modal Small -->



<!-- Button trigger modal -->

<!-- Modal -->



<style type="text/css">

  thead {

    background-color: #c4c7cc !important;

    color: #000;

  }

</style>

<?php $this->load->view('/components/page_tail') ?>

<?php  $this->load->view('widgets/_layout_footer') ?>





