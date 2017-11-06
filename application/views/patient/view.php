
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

</head>
<body class="hold-transition skin-black sidebar-mini">
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

      <!-- Custom Tabs -->
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab_1" data-toggle="tab">Information</a></li>
          <li><a href="#tab_2" data-toggle="tab">Cases</a></li>
          <li><a href="#tab_3" data-toggle="tab">Billing</a></li>
          <li><a href="#tab_4" data-toggle="tab">Med. Certificates</a></li>
          <li><a href="#tab_5" data-toggle="tab">Immunizations</a></li>
          <li><a href="#tab_6" data-toggle="tab">Logs</a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab_1">
            <h3 class="header">Patient Information: <?=$title?></h3>
            <table class="table table-striped">
              <tr>
                <th>Lastname:</th>
                <td><?=$info['lastname']?></td>
              </tr>
              <tr>
                <th>Firstname:</th>
                <td><?=$info['fullname']?></td>
              </tr>
              <tr>
                <th>Middlename:</th>
                <td><?=$info['middlename']?></td>
              </tr>
              <tr>
                <th>Sex:</th>
                <td>
                <?php if ($info['sex'] == 0): ?>
                  <span class="label bg-maroon">Female</span>     
                <?php else: ?>
                  <span class="label bg-blue">Male</span>  
                <?php endif ?>
                </td>
              </tr>
              <tr>
                <th>Birthdate / Age:</th>
                <td><?=$info['birthdate']?> / <?=getAge($info['birthdate'], time())?> y.o</td>
              </tr>
              <tr>
                <th>Birthplace:</th>
                <td>
                  <?php 
                  if($bplace['building']) {
                    echo $bplace['building'] . ', ';
                  } 
                  if($bplace['street']) {
                    echo $bplace['street'] . ', ';
                  }
                  if($bplace['barangay']) {
                    echo $bplace['barangay'] . ', ';
                  }
                  if($bplace['city']) {
                    echo $bplace['city'] . ', ';
                  }
                  if($bplace['province']) {
                    echo $bplace['province'] . ', ';
                  }
                  if($bplace['zip']) {
                    echo $bplace['zip'] . ', ';
                  }
                  if($bplace['country']) {
                    echo $bplace['country'];
                  }
                  ?>
                  <a href="#updateBplace" data-toggle="modal"><i class="fa fa-pencil"></i></a>                      
                </td>
              </tr> 
              <tr>
                <th>Address:</th>
                <td>
                <?php 
                  if($addr['building']) {
                    echo $addr['building'] . ', ';
                  } 
                  if($addr['street']) {
                    echo $addr['street'] . ', ';
                  }
                  if($addr['barangay']) {
                    echo $addr['barangay'] . ', ';
                  }
                  if($addr['city']) {
                    echo $addr['city'] . ', ';
                  }
                  if($addr['province']) {
                    echo $addr['province'] . ', ';
                  }
                  if($addr['zip']) {
                    echo $addr['zip'] . ', ';
                  }
                  if($addr['country']) {
                    echo $addr['country'];
                  }
                  ?>
                  <a href="#updateAddr" data-toggle="modal"><i class="fa fa-pencil"></i></a>
                </td>
              </tr>
              <tr>
                <th>Contact Number:</th>
                <td>
                  <ul>
                    <?php if ($mobile): ?>
                    <?php foreach ($mobile as $con): ?>
                      <li class="removeBullet"><?=$con['details']?> <a href="#delCon<?=$con['id']?>" data-toggle="modal"><i class="fa fa-minus-circle"></i></a> </li>
                    <?php endforeach ?>  
                    <?php endif ?>
                    <li class="removeBullet"><small><a href="#createContact" data-toggle="modal"><em>[ New Contact... ]</em></a></small></li>
                  </ul>
                </td>
              </tr>
              <tr>
                <th>Email:</th>
                <td>
                  <ul>
                    <?php if ($email): ?>
                    <?php foreach ($email as $mail): ?>
                      <li class="removeBullet"><?=$mail['details']?> <a href="#delEmail<?=$mail['id']?>" data-toggle="modal"><i class="fa fa-minus-circle"></i></a> </li>
                    <?php endforeach ?>  
                    <?php endif ?>
                    <li class="removeBullet"><small><a href="#createEmail" data-toggle="modal"><em>[ New Email... ]</em></a></small></li>
                  </ul>
                </td>
              </tr>
              <tr>
                <td>Date Registered:</td>
                <td><em><?=$info['created_at']?></em></td>
              </tr>
              <?php if ($info['created_at'] != $info['updated_at']): ?>
              <tr>
                <td>Last Update:</td>
                <td><em><?=timespan(mysql_to_unix($info['updated_at']), time())?> ago <small><?=$info['updated_at']?></small></em></td>
              </tr>
              <?php endif ?>   
            </table>
            <br />
            <div class="box-footer">
              <div class="form-group pull-right">
                <a href="<?=current_url()?>/print" target="_blank" class="btn btn-primary btn-flat"><i class="fa fa-print"></i> Print</a>
                <a href="#UpdateModal" data-toggle="modal" class="btn btn-warning btn-flat"><i class="fa fa-edit"></i> Update</a>
                <a href="#deleteModal" data-toggle="modal" class="btn btn-danger btn-flat"><i class="fa fa-trash"></i> Archive</a>
              </div><!-- /.right -->
            </div>
          </div>
          <!-- /.tab-pane -->
          <!-- caseTab -->
          <div class="tab-pane" id="tab_2">
            <h4 class="header">Cases <span class="badge"><?=$total_cases?></span></h4><!-- /.header -->
            <table class="table table-condensed">
            <?php if($cases): ?>
            <?php foreach($cases AS $cse): ?>
            <tr>
              <td>
                <a href="<?=base_url('patients/view/'.$cse['patient_id'].'/case/'.$cse['id'])?>">
                <?=$cse['title']?> 
                <?php if ($cse['status'] == 3): ?>
                  <span class="label bg-gray">Cancelled</span>     
                <?php elseif($cse['status'] == 1): ?>
                  <span class="label bg-green">Served</span>                                   
                <?php else: ?> 
                  <span class="label bg-maroon">Pending</span> 
                <?php endif ?>
                </a>
              </td>
              <td><a href="<?=base_url('patients/view/'.$cse['patient_id'].'/case/'.$cse['id'])?>"><?=nice_date(($cse['created_at']), 'M. d, Y')?></a></td>
            </tr>
            <?php endforeach ?>
            <?php else: ?>
            <tr>
              <td>No Case Found!</td>
            </tr>
            <?php endif ?>
            </table><!-- /.bordered -->
            <br />
            <div class="box-footer">
              <div class="form-group pull-right">
                <a href="#caseModal" data-toggle="modal" class="btn btn-success">New Case<i class="mdi-av-my-library-books left"></i></a>
              </div>
            </div>
          </div>
          <!-- /.tab-pane -->

          <!-- billingTab -->
          <div class="tab-pane" id="tab_3">
            <div class="alert alert-success alert-dismissible">
              <i class="icon fa fa-info"></i>To add a Billing Queue, go to tab <em>Cases > Select a Case > Generate Billing Queue</em>.
            </div>
            <table class="table table-condensed">
            <?php if($billing): ?>
              <thead>
                <tr>
                  <th>Billing ID</th>
                  <th>Case</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
            <?php foreach($billing AS $bill): ?>
              <tr>
                <td><a href="<?=base_url('billing/view/'.$bill['id'])?>">BILL #<?=prettyID($bill['id'])?></a></td>
                <td>
                  <a href="<?=base_url('billing/view/'.$bill['id'])?>">
                    <?=$bill['case_title']?>                              
                 <?php if ($bill['status'] == 3): ?>
                   <span class="label bg-gray">Cancelled</span>     
                 <?php elseif($bill['status'] == 1): ?>
                   <span class="label bg-green">Served</span>                                   
                 <?php else: ?> 
                   <span class="label bg-maroon">Pending</span> 
                 <?php endif ?>
                 </a>
                </td>
                <td><a href="<?=base_url('billing/view/'.$bill['id'])?>"><?=nice_date(($bill['created_at']), 'M. d, Y')?></a></td>
              </tr>
            <?php endforeach ?>
              </tbody>
            <?php else: ?>
              <tr>
                <td>No Billing Queue Found!</td>
              </tr>
            <?php endif ?>
            </table>
          </div>
          <!-- /.tab-pane -->

          <!-- Med.CertificatesTab -->
          <div class="tab-pane" id="tab_4">
            <h4 class="header">Medical Certificates</h4><!-- /.header -->
            <table class="table table-condensed">
            <?php if ($medcerts): ?>
              <thead>  
                <tr>
                  <th></th>
                  <th>Doctor</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody>
            <?php foreach ($medcerts AS $med): ?>
                <tr>
                  <td><a href="<?=base_url('patients/view/'.$med['patient_id'].'/medcert/view/'.$med['cert_id'])?>">CERT #<?=prettyID($med['cert_id'])?></a></td>
                  <td><a href="<?=base_url('patients/view/'.$med['patient_id'].'/medcert/view/'.$med['cert_id'])?>"><?=$med['doctor']?></a></td>
                  <td><a href="<?=base_url('patients/view/'.$med['patient_id'].'/medcert/view/'.$med['cert_id'])?>"><?=$med['created_at']?></a></td>
                </tr>
            <?php endforeach ?>
              </tbody>
            <?php else: ?>
                <tr>
                  <td>No Medical Certificates Found!</td>
                </tr>
            <?php endif ?>
            </table>
          </div>
          <!-- /.tab-pane -->

          <!-- ImmunicationsTab -->
          <div class="tab-pane" id="tab_5">
            <h4 class="header">Immunizations Taken</h4><!-- /.header -->
            <table class="table table-condensed">
            <?php if ($immunizations): ?>
              <thead>
                <tr>
                  <th></th>
                  <th>Service</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody>
            <?php foreach ($immunizations AS $immu): ?>
                <tr>
                  <td><a href="<?=base_url('patients/view/'.$immu['patient_id'].'/case/'.$immu['case_id'].'/immunization/'.$immu['id'])?>">IMMU #<?=prettyID($immu['id'])?></a></td>
                  <td><a href="<?=base_url('patients/view/'.$immu['patient_id'].'/case/'.$immu['case_id'].'/immunization/'.$immu['id'])?>"><?=$immu['service']?></a></td>
                  <td><a href="<?=base_url('patients/view/'.$immu['patient_id'].'/case/'.$immu['case_id'].'/immunization/'.$immu['id'])?>"><?=$immu['updated_at']?></a></td>
                </tr>  
            <?php endforeach ?>
              </tbody>
            <?php else: ?>
                <tr>
                  <td>No Immunization Records Found!</td>
                </tr>
            <?php endif ?>
            </table>
          </div>
          <!-- /.tab-pane -->

          <!-- Logstab -->
          <div class="tab-pane" id="tab_6">
            <h6 class="header"><b>Patient Logs</b> <small><em><a href="<?=base_url('patients/view/'.$info['id'].'/logs')?>" class="pull-right">[ View All Logs ]</a></em></small></h6><!-- /.header -->
            <table class="table table-condensed">
            <?php if ($logs): ?>
            <?php foreach ($logs AS $log): ?>
              <tr>
                <td><span class="label bg-maroon"><?=$log['user']?></span></td>
                <td><?=$log['action']?></td>
                <td><small><?=$log['date_time']?></small></td>
              </tr>
            <?php endforeach ?>
            <?php else: ?>
              <tr>
                <td>No Logs Found!</td>
              </tr>
            <?php endif ?>
            </table>
          </div>
          <!-- /.tab-pane -->   

        </div>
        <!-- /.tab-content -->
      </div>
      <!-- nav-tabs-custom -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">    
    <?php $this->load->view('inc/footer')?>    
  </footer>

</div>
<!-- ./wrapper -->

<!-- deleteContact Modal -->
<?php if ($mobile): ?>
<?php foreach ($mobile as $con): ?>
<div class="modal modal-danger fade" id="delCon<?=$con['id']?>">
  <div class="modal-dialog">
    <?=form_open('patients/delete_contact')?>
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <p>Are you sure to delete this Contact Number- <?=$con['details']?>? </p>
          <p>You <b>CANNOT UNDO</b> this action.</p>
          <input type="hidden" name="pid" value="<?=$this->encryption->encrypt($info['id'])?>" />
          <input type="hidden" name="id" value="<?=$this->encryption->encrypt($con['id'])?>" />
          <input type="hidden" name="tag" value="<?=$this->encryption->encrypt($con['tag'])?>" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-outline">Delete Contact</button>
        </div>
      </div>
      <!-- /.modal-content -->
    <?=form_close()?>
  </div>
  <!-- /.modal-dialog -->
</div>
<?php endforeach ?>
<?php endif ?>
<!-- /.modal -->

<!-- createContact Modal -->
<div class="modal fade" id="createContact">
  <div class="modal-dialog">
      <?=form_open('patients/create_contact')?>
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Add Contact</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="details">Mobile / Telephone / Fax No.</label>
            <input type="text" name="details" id="details" class="form-control" required/>
          </div>
        </div>
        <input type="hidden" name="pid" value="<?=$this->encryption->encrypt($info['id'])?>" />
        <input type="hidden" name="tag" value="<?=$this->encryption->encrypt(0)?>" />
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">New Contact</button>
        </div>
      </div>
      <!-- /.modal-content -->
    <?=form_close()?>
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- deleteEmail Modal -->
<?php if ($email): ?>
<?php foreach ($email as $mail): ?>
<div class="modal modal-danger fade" id="delEmail<?=$mail['id']?>">
  <div class="modal-dialog">
    <?=form_open('patients/delete_contact')?>
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <p>Are you sure to delete this Email Address- <?=$mail['details']?>? </p>
          <p>You <b>CANNOT UNDO</b> this action.</p>
          <input type="hidden" name="pid" value="<?=$this->encryption->encrypt($info['id'])?>" />
          <input type="hidden" name="id" value="<?=$this->encryption->encrypt($mail['id'])?>" />
          <input type="hidden" name="tag" value="<?=$this->encryption->encrypt($mail['tag'])?>" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-outline">Delete Email</button>
        </div>
      </div>
      <!-- /.modal-content -->
    <?=form_close()?>
  </div>
  <!-- /.modal-dialog -->
</div>
<?php endforeach ?>
<?php endif ?>
<!-- /.modal -->

<!-- createEmail Modal -->
<div class="modal fade" id="createEmail">
  <div class="modal-dialog">
    <?=form_open('patients/create_contact')?>
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Add Email Address</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="details">Email Address</label>
            <input type="email" name="details" id="details" class="form-control" required/>
          </div>
        </div>
        <input type="hidden" name="pid" value="<?=$this->encryption->encrypt($info['id'])?>" />
        <input type="hidden" name="tag" value="<?=$this->encryption->encrypt(1)?>" />
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">New Email</button>
        </div>
      </div>
      <!-- /.modal-content -->
    <?=form_close()?>
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- updateBplace Modal -->
<div class="modal modal fade" id="updateBplace">
  <div class="modal-dialog modal-lg">
    <?=form_open('patients/update_address')?>
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Update Birthplace</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              <legend class="strong">Birthplace</legend>
              <div class="col-sm-4">
                <div class="form-group"> 
                  <label for="bldg">Building / Block / House</label>
                  <input type="text" name="bldg" id="bldg" class="form-control" value="<?=$bplace['building']?>"/>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group"> 
                  <label for="strt">Street</label>
                  <input type="text" name="strt" id="strt" class="form-control" value="<?=$bplace['street']?>"/>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group"> 
                  <label for="brgy">Barangay</label>
                  <input type="text" name="brgy" id="brgy" class="form-control" value="<?=$bplace['barangay']?>"/>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group"> 
                  <label for="city">City / Municipality</label>
                  <input type="text" name="city" id="city" class="form-control" value="<?=$bplace['city']?>"/>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group"> 
                  <label for="province">Province / Region</label>
                  <input type="text" name="province" id="province" class="form-control" value="<?=$bplace['province']?>"/>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group"> 
                  <label for="zip">Zip Code</label>
                  <input type="text" name="zip" id="zip" class="form-control" value="<?=$bplace['zip']?>"/>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group"> 
                  <label for="country">Country</label>
                  <input type="text" name="country" id="country" class="form-control" value="<?=$bplace['country']?>"/>
                </div>
              </div>
            </div>
          </div>
          <input type="hidden" name="id" value="<?=$this->encryption->encrypt($bplace['id'])?>" />
          <input type="hidden" name="pid" value="<?=$this->encryption->encrypt($info['id'])?>" />
          <input type="hidden" name="tag" value="<?=$this->encryption->encrypt(0)?>" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update Birthplace</button>
        </div>
      </div>
      <!-- /.modal-content -->
    <?=form_close()?>
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- UpdateAddr Modal -->
<div class="modal fade" id="updateAddr">
  <div class="modal-dialog modal-lg">
    <?=form_open('patients/update_address')?>
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Update Present Address</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              <legend class="strong">Present Address</legend>
              <div class="col-sm-4">
                <div class="form-group"> 
                  <label for="bldg">Building / Block / House</label>
                  <input type="text" name="bldg" id="bldg" class="form-control" value="<?=$addr['building']?>"/>
                </div>
              </div><!-- /.col-sm-4 -->
              <div class="col-sm-4">
                <div class="form-group"> 
                  <label for="strt">Street</label>
                  <input type="text" name="strt" id="strt" class="form-control" value="<?=$addr['street']?>"/>
                </div>
              </div><!-- /.col-sm-4 -->
              <div class="col-sm-4">
                <div class="form-group"> 
                  <label for="brgy">Barangay</label>
                  <input type="text" name="brgy" id="brgy" class="form-control" value="<?=$addr['barangay']?>"/>
                </div>
              </div><!-- /.col-sm-4 -->
              <div class="col-sm-3">
                <div class="form-group"> 
                  <label for="city">City / Municipality</label>
                  <input type="text" name="city" id="city" class="form-control" value="<?=$addr['city']?>"/>
                </div>
              </div><!-- /.col-sm-3 -->
              <div class="col-sm-3">
                <div class="form-group"> 
                  <label for="province">Province / Region</label>
                  <input type="text" name="province" id="province" class="form-control" value="<?=$addr['province']?>"/>
                </div>
              </div><!-- /.col-sm-3 -->
              <div class="col-sm-3">
                <div class="form-group"> 
                  <label for="zip">Zip Code</label>
                  <input type="text" name="zip" id="zip" class="form-control" value="<?=$bplace['zip']?>"/>
                </div>
              </div><!-- /.col-sm-3 -->
              <div class="col-sm-3">
                <div class="form-group"> 
                  <label for="country">Country</label>
                  <input type="text" name="country" id="country" class="form-control" value="<?=$bplace['country']?>"/>
                </div>
              </div><!-- /.col-sm-3 -->
            </div><!-- /.col-sm-12 -->
          </div><!-- /.row -->
        </div>
        <!-- /.modal-body -->
        <input type="hidden" name="id" value="<?=$this->encryption->encrypt($addr['id'])?>" />
        <input type="hidden" name="pid" value="<?=$this->encryption->encrypt($info['id'])?>" />
        <input type="hidden" name="tag" value="<?=$this->encryption->encrypt(1)?>" />
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Update Address</button>
        </div>
      </div>
      <!-- /.modal-content -->
    <?=form_close()?>
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- updateInfo Modal -->
<div class="modal fade" id="UpdateModal">
  <div class="modal-dialog">
    <?=form_open('patients/update')?>
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Update: <?=$info['fullname'] . ' ' . $info['lastname']?></h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              <label for="lname">Last Name</label>
              <input type="text" name="lname" class="form-control" id="lname" value="<?=$info['lastname']?>" required/>
            </div>
            <div class="col-sm-12">
              <label for="fname">Full Name</label>
              <input type="text" name="fname" class="form-control" id="fname" value="<?=$info['fullname']?>" required/>
            </div>
            <div class="col-sm-12">
              <label for="mname">Middle Name</label>
              <input type="text" name="mname" class="form-control" id="mname" value="<?=$info['middlename']?>" required/>
            </div>
            <div class="col-sm-12">
              <label for="sex">Sex</label>
              <select name="sex" class="form-control" id="sex" required>
                <option value="" disabled="" selected="">Sex</option>
                <option value="1" <?php if($info['sex'])echo'selected';?>>Male</option>
                <option value="0" <?php if(!$info['sex'])echo'selected';?>>Female</option>
              </select>
            </div>
            <div class="col-sm-12">
              <label for="bdate">Birthdate</label>
              <input type="date" name="bdate" class="form-control" id="bdate" value="<?=$info['birthdate']?>" required/>
            </div>
          </div>
          <input type="hidden" name="id" value="<?=$this->encryption->encrypt($info['id'])?>" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Update</button>
        </div>
      </div>
      <!-- /.modal-content -->
    <?=form_close()?>
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- deleteInfo Modal -->
<div class="modal modal-danger fade" id="deleteModal">
  <div class="modal-dialog">
    <?=form_open('patients/delete')?>
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <p>Are you sure to move the record of <b><?=$info['fullname'] . ' ' . $info['lastname']?></b> to <strong>TRASH?</strong>?</p>
          <p>You <b>CANNOT UNDO</b> this action.</p>
          <input type="hidden" name="id" value="<?=$this->encryption->encrypt($info['id'])?>" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-outline">Move to Trash</button>
        </div>
      </div>
      <!-- /.modal-content -->
    <?=form_close()?>
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- CASETAB MODAL -->
<div class="modal fade" id="caseModal">
  <div class="modal-dialog">
    <?=form_open_multipart('cases/create')?>
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">New Case: <?=$info['fullname'] . ' ' . $info['lastname']?></h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-6">
              <label for="weight">Weight (kg)</label>
              <input type="number" name="weight" class="form-control" id="weight" value="<?=set_value('weight')?>" requried/>
            </div><!-- /.col-sm-6 -->
            <div class="col-sm-6">
              <label for="height">Height (cm)</label>
              <input type="number" name="height" class="form-control" id="height" value="<?=set_value('height')?>" requried/>
            </div><!-- /.col-sm-6 -->
            <div class="col-sm-12">
              <label for="img">Image</label>
              <input type="file" name="img" class="form-control" id="img"/>
            </div><!-- /.col-sm-12 -->
            <div class="col-sm-12">
              <label for="title">Case Title</label>
              <input type="text" name="title" class="form-control" id="title" value="<?=set_value('title')?>" requried/>
            </div><!-- /.col-sm-12 -->
            <div class="col-sm-12">
              <label for="description">Case Description</label>
              <textarea name="description" id="" class="ckeditor"><?=set_value('description')?></textarea>
            </div>
          </div><!-- /.row -->
          <input type="hidden" name="id" value="<?=$this->encryption->encrypt($info['id'])?>" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">New Case</button>
        </div>
      </div>
      <!-- /.modal-content -->
    <?=form_close()?>
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<?php $this->load->view('inc/js')?>    
<script src="<?=base_url('assets/ckeditor/ckeditor.js')?>"></script>
    
</body>
</html>


