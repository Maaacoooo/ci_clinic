
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?=$title?> &middot; <?=$site_title?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <?php $this->load->view('inc/css')?>
  <!-- Custom -->
  <link rel="stylesheet" href="<?=base_url('assets/custom/css/custom.css')?>">
  <!-- -->
  <link rel="stylesheet" href="<?=base_url('assets/custom/css/jquery-ui.min.css')?>">
  <!-- Custom Image CSS-->
  <link rel="stylesheet" href="<?=base_url('assets/custom/img-custom/css/magnific-popup.css')?>">

  <script type="text/javascript">
    function queues() {

        if(document.getElementById("served").checked == true) {
          document.getElementById("clearqueue").checked = true;
        } 

        if(document.getElementById("pending").checked == true) {
          document.getElementById("generatequeue").checked = true;
          document.getElementById("generateBilling").checked = true;          
        } 

        if(document.getElementById("cancel").checked == true) {
          document.getElementById("clearqueue").checked = true;
          document.getElementById("generateBilling").checked = false;          
          document.getElementById("generatequeue").checked = false;      
        } 

    }
  </script>
</head>
<body class="hold-transition skin-black sidebar-mini" <?php if($this->session->flashdata('invoice'))echo 'onload="load_receipt()"';?>>
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <?php $this->load->view('inc/header')?>
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <?php $this->load->view('inc/left_nav')?>    
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$title?>        
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url()?>">Dashboard</a></li>
        <li><a href="<?=base_url('patients')?>">Patients</a></li>
        <li><a href="<?=base_url('patients/view/'.$info['id'])?>"><?=$info['fullname'] . ' ' . $info['lastname']?></a></li>
        <li class="active"><?=$title?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      
      <div class="row">
        <div class="col-xs-12">
          <?php
            //ALERT / NOTIFICATION
            //ERROR ACTION                          
            if($this->session->flashdata('error')): ?>

            <div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h4><i class="icon fa fa-ban"></i> Oops!</h4>
              <?=$this->session->flashdata('error')?>
            </div>
                       
        <?php 
            endif; //error end
            //SUCCESS ACTION                          
            if($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h4><i class="icon fa fa-check"></i> Success!</h4>
              <?=$this->session->flashdata('success')?>
            </div>
        <?php 
            endif; //success end
            //FORM VALIDATION ERROR
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            if(validation_errors()): ?>
            <div class="alert alert-warning alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h4><i class="icon fa fa-warning"></i> Warning!</h4>         
              <?=validation_errors()?>         
            </div>
        <?php endif; //formval end ?> 
        </div><!-- /.col-xs-12 -->
      </div><!-- /.row -->

    
      <!-- START CUSTOM TABS -->
      <div class="row">
        <div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Case Information</a></li>
              <li><a href="#tab_2" data-toggle="tab">Prescriptions</a></li>
              <li><a href="#tab_3" data-toggle="tab">Lab Request</a></li>
              <li><a href="#tab_4" data-toggle="tab">Med. Certificates</a></li>
              <li><a href="#tab_5" data-toggle="tab">Immunizations</a></li>
              <li><a href="#tab_6" data-toggle="tab">Logs</a></li>
            </ul>
            <div class="tab-content">
              <!-- Case Information -->
              <div class="tab-pane active" id="tab_1">
                <div class="row">
                  <div class="col-sm-8">
                    <h3>Case Information : <?=$case['title']?></h3>
                    <table class="table table-striped">
                      <tr>
                        <th width="20%">Patient Name :</th>
                        <td><?=$info['fullname'] . ' ' . $info['lastname']?></td>
                      </tr>
                      <tr>
                        <th>Case Status:</th>
                        <td>
                        <?php if ($case['status'] == 3): ?>
                          <span class="label bg-grey">Cancelled</span>     
                        <?php elseif($case['status'] == 1): ?>
                          <span class="label bg-green">Served</span>                                   
                        <?php else: ?> 
                          <span class="label bg-red">Pending</span> 
                        <?php endif ?>
                        </td>
                      </tr>
                      <tr>
                        <th>Date of Entry:</th>
                        <td><?=nice_date($case['created_at'], 'M. d, Y')?></td>
                      </tr>
                      <tr>
                        <th>Age of Entry:</th>
                        <td><?=getAge($info['birthdate'], mysql_to_unix($case['created_at']))?></td>
                      </tr>
                      <tr>
                        <th>Weight (kg):</th>
                        <td><?=$case['weight']?></td>
                      </tr>
                      <tr>
                        <th>Height (cm):</th>
                        <td><?=$case['height']?></td>
                      </tr>
                      <tr>
                        <th colspan="2">Description:</th>
                      </tr>
                      <tr>
                        <td colspan="2"><?=$case['description']?></td>
                      </tr>
                    </table>
                    <p>
                    <small>
                      <em>
                        Registered: <?=$case['created_at']?>
                        <?php if ($case['created_at'] != $case['updated_at']): ?>
                          <span class="right">Updated: <?=$case['updated_at']?></span>
                        <?php endif ?>
                      </em>
                    </small>
                    </p>
                  </div><!-- /.col-sm-8 -->
                  <!-- Image Magnifier -->
                  <div class="col-sm-4">
                  <?php if ($case['img']): ?>
                    <div class="form-group">
                      <div class="row row-bottom-padded-sm">
                        <div class="col-md-4 col-sm-6 col-xxs-12">
                          <a href="<?=base_url('uploads/patients/'.$info['id'].'/case/'.$case['id'].'/'.$case['img'])?>" class="fh5co-project-item image-popup to-animate">
                            <img src="<?=base_url('uploads/patients/'.$info['id'].'/case/'.$case['id'].'/'.$case['img'])?>" alt="Image" class="img-responsive">
                          </a>
                        </div><!-- /.col-md-4 col-sm-6 col-xxs-12 -->
                      </div><!-- /.row row-bottom-padded-sm -->
                    </div><!-- /.form-group -->
                  <?php endif ?>
                  <!-- Options -->
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title">Options</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <div class="form-group">
                        <a href="<?=current_url()?>/print" target="_blank" class="btn btn-primary form-control"><i class="fa fa-print"></i> Print Case Report</a> 
                      </div>
                      <div class="form-group">
                        <a href="#medcertModal" class="btn btn-primary form-control" data-toggle="modal">Issue Med. Certificates</a>
                      </div>
                      <?php if ($user['usertype'] == 'Doctor'): ?>
                      <div class="form-group">
                        <a href="#addPrescription" class="btn btn-success form-control" data-toggle="modal">Add Prescription</a>  
                      </div>
                      <div class="form-group">
                        <a href="#changeStatus" class="btn btn-warning form-control" data-toggle="modal">Change Status</a>
                      </div>
                    <?php endif ?>
                    </div>
                    <!-- /.box-body -->
                  </div>
                  <!-- /.box -->

                  </div><!-- col-sm-4 -->

                </div><!-- /.row -->
              </div>
              <!-- /.tab-pane -->

              <!-- Prescription -->
              <div class="tab-pane" id="tab_2">
                <h3>Prescription</h3>
                <hr />
                <?php if ($prescriptions): ?>
                <table class="table table-condensed table-striped">
                  <thead>
                    <tr>
                      <th>Issued by</th>
                      <th>Title</th>
                      <th>Date and Time</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($prescriptions AS $pres): ?>
                    <tr>
                      <td><a href="<?=base_url('patients/view/'.$info['id'].'/case/'.$case['id'].'/prescription/view/'.$pres['id'])?>"><?=$pres['created_by']?></a></td>
                      <td><a href="<?=base_url('patients/view/'.$info['id'].'/case/'.$case['id'].'/prescription/view/'.$pres['id'])?>"><?=$pres['title']?></a></td>
                      <td><a href="<?=base_url('patients/view/'.$info['id'].'/case/'.$case['id'].'/prescription/view/'.$pres['id'])?>"><?=$pres['created_at']?></a></td>
                    </tr>
                  <?php endforeach ?>
                  </tbody> 
                </table><!-- ./table-condensed table-striped -->
                <?php else: ?>
                  <div class="alert alert-warning alert-dismissible">
                    <h4><i class="icon fa fa-warning"></i> No Records Found!</h4>
                    No Prescriptions record found in the System
                  </div> 
                <?php endif ?> 
                <div class="box-footer">
                  <div class="form-group pull-right">
                    <a href="#addPrescription" data-toggle="modal" class="btn btn-success">Add Prescription</a>
                  </div>
                </div><!-- /.box-footer -->
              </div>
              <!-- /.tab-pane -->

              <!-- Lab Request -->
              <div class="tab-pane" id="tab_3">
                <h3>Lab Request</h3>
                <hr />
                <?=form_open('laboratory/create')?> 
                <label for="labreq">Request for Laboratory Service</label>
                  <div class="input-group">
                    <input type="text" name="labreq" class="form-control" id="labreq" required/>
                    <div class="input-group-btn">
                      <button type="submit" class="btn btn-warning">Request</button>
                    </div>
                    <!-- /btn-group -->
                  </div>
                  <!-- /input-group -->
                <?=form_close()?>
                <hr />
                <?php if ($labreqs): ?>
                <table class="table table-condensed table-striped">
                  <thead>
                    <tr>
                      <th>Request</th>
                      <th>Service</th>
                      <th>Requestor</th>
                      <th>Date Time</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($labreqs AS $lab): ?>
                    <tr>
                      <td><a href="<?=base_url('patients/view/'.$info['id'].'/case/'.$lab['case_id'].'/laboratory/'.$lab['id'])?>">#<?=prettyID($lab['id'])?></a></td>
                      <td>
                        <a href="<?=base_url('patients/view/'.$info['id'].'/case/'.$lab['case_id'].'/laboratory/'.$lab['id'])?>"><?=$lab['service']?> - <?=$lab['code']?></a>
                      <?php if ($lab['status'] == 3): ?>
                        <span class="label bg-grey">Cancelled</span>     
                      <?php elseif($lab['status'] == 1): ?>
                        <span class="label bg-green">Served</span>                                   
                      <?php else: ?> 
                        <span class="label bg-maroon">Pending</span> 
                      <?php endif ?>
                      </td>
                      <td><a href="<?=base_url('patients/view/'.$info['id'].'/case/'.$lab['case_id'].'/laboratory/'.$lab['id'])?>"><?=$lab['user']?></a></td>
                      <td><a href="<?=base_url('patients/view/'.$info['id'].'/case/'.$lab['case_id'].'/laboratory/'.$lab['id'])?>"><?=$lab['created_at']?></a></td>
                    </tr>
                  <?php endforeach ?>
                  </tbody>
                  <?php else: ?>
                    <div class="alert alert-warning alert-dismissible">
                      <h4><i class="icon fa fa-warning"></i> No Records Found!</h4>
                      No Laboratory Request record found in the System
                    </div> 
                  <?php endif ?>
                </table><!-- /.table table-condensed table-striped -->
              </div>
              <!-- /.tab-pane -->

              <!-- Medical Certificates -->
              <div class="tab-pane" id="tab_4">
                <h3>Medical Certificates</h3>
                <hr />
                <?php if ($medcerts): ?>
                <table class="table table-striped table-condensed"> 
                  <thead>
                    <tr>
                      <th></th>
                      <th>Doctor</th>
                      <th>Date</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($medcerts as $med): ?>
                    <tr>
                      <td><a href="<?=base_url('patients/view/'.$med['patient_id'].'/medcert/view/'.$med['cert_id'])?>">CERT #<?=prettyID($med['cert_id'])?> - <?=$med['title']?></a></td>
                      <td><a href="<?=base_url('patients/view/'.$med['patient_id'].'/medcert/view/'.$med['cert_id'])?>"><?=$med['doctor']?></a></td>
                      <td><a href="<?=base_url('patients/view/'.$med['patient_id'].'/medcert/view/'.$med['cert_id'])?>"><?=$med['created_at']?></a></td>
                    </tr>
                  <?php endforeach ?>
                  </tbody>
                </table><!-- /.table table-striped table-condensed -->
                <?php else: ?>
                  <div class="alert alert-warning alert-dismissible">
                    <h4><i class="icon fa fa-warning"></i> No Records Found!</h4>
                    No Medical Certificates record found in the System
                  </div> 
                <?php endif ?>
                <div class="box-footer">
                  <div class="form-group pull-right">
                    <a href="#medcertModal" data-toggle="modal" class="btn btn-info">Issue Medical Certificate</a>
                  </div>
                </div><!-- /.box-footer -->
              </div>
              <!-- /.tab-pane -->

              <!-- Immunizations -->
              <div class="tab-pane" id="tab_5">
                <h3>Immunizations</h3>
                <hr />
                <?=form_open('immunization/create')?>
                <label for="immu">Request for Immunization Service</label>
                  <div class="input-group">
                    <input type="text" name="immu" class="form-control" id="immu" required/>
                    <input type="hidden" name="id" value="<?=$this->encryption->encrypt($case['id'])?>" /> 
                    <div class="input-group-btn">
                      <button type="submit" class="btn btn-warning">Request</button>
                    </div>
                    <!-- /btn-group -->
                  </div>
                  <!-- /input-group -->
                <?=form_close()?>
                <hr />
                <?php if ($immunizations): ?>
                <table class="table table-condensed table-striped">
                  <thead>
                    <th></th>
                    <th>Service</th>
                    <th>Date</th>
                  </thead>
                  <tbody>
                  <?php foreach ($immunizations as $immu): ?>
                    <tr>
                      <td><a href="<?=base_url('patients/view/'.$immu['patient_id'].'/case/'.$immu['case_id'].'/immunization/'.$immu['id'])?>">IMMU #<?=prettyID($immu['id'])?></a></td>
                      <td>
                      <a href="<?=base_url('patients/view/'.$immu['patient_id'].'/case/'.$immu['case_id'].'/immunization/'.$immu['id'])?>">
                      <?=$immu['service']?>
                    <?php if ($immu['status'] == 3): ?>
                        <span class="label bg-grey">Cancelled</span>     
                    <?php elseif($immu['status'] == 1): ?>
                        <span class="label bg-green">Served</span>                                   
                    <?php else: ?> 
                        <span class="label bg-red">Pending</span> 
                    <?php endif ?>
                      </a>
                      </td>  
                      <td><a href="<?=base_url('patients/view/'.$immu['patient_id'].'/case/'.$immu['case_id'].'/immunization/view/'.$immu['id'])?>"><?=$immu['updated_at']?></a></td>                  
                    </tr>
                  <?php endforeach ?>
                  </tbody>
                </table><!-- /.table table-bordered table-striped -->
                <?php else: ?>
                  <div class="alert alert-warning alert-dismissible">
                    <h4><i class="icon fa fa-warning"></i> No Records Found!</h4>
                    No Immunization Records found in the System
                  </div> 
                <?php endif ?>
              </div>
              <!-- /.tab-pane -->

              <!-- Logs -->
              <div class="tab-pane" id="tab_6">
                <h3>Case Logs</h3>
                <?php if ($logs): ?>
                <table class="table table-condensed">
                <?php foreach ($logs AS $log): ?>
                  <tr>
                    <td><span class="label bg-maroon"><?=$log['user']?></span></td>
                    <td><?=$log['action']?></td>
                    <td><small><?=$log['date_time']?></small></td>
                  </tr>
                <?php endforeach ?>
                </table><!-- /.table table-bordered -->
                <?php else: ?>
                  <div class="alert alert-warning alert-dismissible">
                    <h4><i class="icon fa fa-warning"></i> No Records Found!</h4>
                    No Case Logs Record found in the System
                  </div> 
                <?php endif ?>
              </div>
              <!-- /.tab-pane -->

            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
        <!-- /.col-sm-12 -->
      </div>
      <!-- /.row -->

      <!-- Issue Med. Certificates -->
      <div class="modal fade" id="medcertModal">
        <div class="modal-dialog modal-lg">
          <?=form_open('cases/create_medcert')?>
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Issue Medical Certificate</h4>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="callout callout-info">
                      <i class="fa fa-info-circle"></i> Please note that you <span class="text-red"><b>CANNOT UNDO nor UPDATE</b></span> the Medical Certificate. All Inputs should treated as final and true.
                    </div>
                    <p>Please input the required fields</p>
                    <div class="col-sm-12">
                      <label for="title">Case Title</label>
                      <input type="text" name="title" class="form-control" id="title" placeholder="Case Title*" required/>
                    </div><!-- /.col-sm-12 -->
                    <div class="col-sm-12">
                      <label>Attending Physician</label>
                      <select name="doctor" class="form-control" required>
                        <option value="" disabled="" selected="">Choose Physician...</option>
                      <?php foreach ($meddoctors as $doc): ?>
                        <option value="<?=$doc['name']?>">Dr. <?=$doc['name'].' - LIC. # '.$doc['lic_no']?></option>
                      <?php endforeach ?>
                      </select>
                    </div><!-- /.col-sm-12 --> 
                  </div><!-- /.col-sm-6 -->
                  <div class="col-sm-6">
                    <label for="remarks">Remarks And Recommendations</label>
                    <textarea name="remarks" id="remarks" cols="30" rows="10" class="ckeditor" required=""></textarea>
                  </div>
                </div><!-- /.row -->
              </div>
              <input type="hidden" name="id" value="<?=$this->encryption->encrypt($case['id'])?>" />
              <input type="hidden" name="pid" value="<?=$this->encryption->encrypt($info['id'])?>" />
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                <button type="sucmit" class="btn btn-info">Issue Certificate</button>
              </div>
            </div>
            <!-- /.modal-content -->
          <?=form_close()?>
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <!-- Add Prescription -->
      <div class="modal fade" id="addPrescription">
        <div class="modal-dialog">
          <?=form_open('prescription/create')?>
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Prescription</h4>
              </div>
              <div class="modal-body">
              <p>When adding a prescription, please input the title(optional) and the description of the prescription.</p>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="title">Title</label>
                      <input type="text" name="title" class="form-control" id="title" placeholder="(Optional)" required/>
                    </div><!-- /.form-group -->
                  </div><!-- /.col-sm-12 -->
                  <div class="col-sm-12">
                    <textarea name="description" cols="30" rows="10" class="ckeditor" required=""></textarea>
                  </div><!-- /.col-sm-12 -->
                </div><!-- /.row -->
              </div>
              <input type="hidden" name="id" value="<?=$this->encryption->encrypt($case['id'])?>" />
              <input type="hidden" name="pid" value="<?=$this->encryption->encrypt($info['id'])?>" />
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Add Prescription</button>
              </div>
            </div>
            <!-- /.modal-content -->
          <?=form_close()?>
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <!-- ChangeStatus Modal -->
      <div class="modal fade" id="changeStatus">
        <div class="modal-dialog">
          <?=form_open('cases/change_status')?>
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Change Status</h4>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-sm-12">
                    <p>This changes the status of the case.</p> 
                    <input name="status" type="radio" id="pending" onclick="queues()" value="<?=$this->encryption->encrypt(0)?>" class="with-gap" <?php if ($case['status'] == 0)echo'checked';?>>
                    <label for="pending">Pending</label>
                    <input name="status" type="radio" id="served" onclick="queues()" value="<?=$this->encryption->encrypt(1)?>" class="with-gap" <?php if ($case['status'] == 1)echo'checked';?>>
                    <label for="served">Served</label>
                    <input name="status" type="radio" id="cancel" onclick="queues()" value="<?=$this->encryption->encrypt(3)?>" class="with-gap" <?php if ($case['status'] == 3)echo'checked';?>>
                    <label for="cancel">Cancelled</label>
                    <div class="callout callout-danger">
                      <i class="icon fa fa-info-circle"></i> Once case is set to <span class="label bg-green">Served</span>, Please tick the <a href="#">`clear queues`</a> checkbox to accomodate a new queue.
                    </div>
                  </div><!-- /.col-sm-6 -->
                  <div class="col-sm-12">
                    <div class="callout callout-info">
                      <i class="fa fa-info-circle"></i> You can clear and generate queues at the same time.
                    </div> 
                    <!-- Options -->
                    <h4>Options</h4>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <input type="checkbox" id="clearqueue" name="clearqueue">
                        <check-label for="clearqueue">Clear Queues for this Case</check-label>
                      </div>
                      <div class="form-group">
                        <input type="checkbox" id="generatequeue" name="generatequeue">
                        <check-label for="generatequeue">Generate New Queue</check-label>
                      </div>
                    </div><!-- /.col-sm-6 -->
                    <div class="col-sm-6">
                      <div class="form-group">
                        <input type="checkbox" id="nextqueue" name="nextqueue" checked>
                        <check-label for="nextqueue">Proceed to the Next Queue</check-label> 
                      </div>
                      <div class="form-group">
                        <input type="checkbox" id="generateBilling" name="generateBilling">
                        <check-label for="generateBilling">Generate New Billing Queue</check-label>
                      </div>
                    </div><!-- /.col-sm-6 -->
                  </div><!-- /.col-sm-12 -->
                </div><!-- /.row -->
              <input type="hidden" name="id" value="<?=$this->encryption->encrypt($case['id'])?>" />
              <input type="hidden" name="pid" value="<?=$this->encryption->encrypt($info['id'])?>" />
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning">Change</button>
              </div>
            </div>
            <!-- /.modal-content -->
          <?=form_close()?>
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">    
    <?php $this->load->view('inc/footer')?>    
  </footer>

</div>
<!-- ./wrapper -->

<?php $this->load->view('inc/js')?>    
<!-- SELECT2 -->
<script type="text/javascript" src="<?=base_url('assets/custom/js/jquery-1.11.2.min.js')?>"></script> 
<script src="<?=base_url('assets/custom/js/jquery-ui.js');?>" type="text/javascript" language="javascript" charset="UTF-8"></script>
<!-- Custom Magni -->
<script src="<?=base_url('assets/custom/img-custom/js/jquery.magnific-popup.min.js')?>"></script>  
<script src="<?=base_url('assets/custom/img-custom/js/magnific-popup-options.js')?>"></script>
<script src="<?=base_url('assets/custom/img-custom/js/jquery.stellar.min.js')?>"></script>
<script src="<?=base_url('assets/custom/img-custom/js/jquery.waypoints.min.js')?>"></script>
<!-- Page Script -->
<script type="text/javascript">
  $(function(){
  $("#labreq").autocomplete({    
    source: "<?php echo base_url('index.php/laboratory/autocomplete');?>" // path to the get_birds method
  });
});

   $(function(){
  $("#immu").autocomplete({    
    source: "<?php echo base_url('index.php/immunization/autocomplete');?>" // path to the get_birds method
  });
});
</script>
<!-- CKEDITOR -->
<script src="<?=base_url('assets/ckeditor/ckeditor.js')?>"></script>

</body>
</html>
