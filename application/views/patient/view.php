<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <title><?=$title?> &middot; <?=$site_title?></title>

    <?php $this->load->view('inc/css'); ?>


</head>

<body>
    
    <?php $this->load->view('inc/header'); ?>

    <!-- //////////////////////////////////////////////////////////////////////////// -->


  <!-- START MAIN -->
  <div id="main">
    <!-- START WRAPPER -->
    <div class="wrapper">

      <?php $this->load->view('inc/left_nav'); ?>

      <!-- //////////////////////////////////////////////////////////////////////////// -->

      <!-- START CONTENT -->
      <section id="content">
        
        <!--breadcrumbs start-->
        <div id="breadcrumbs-wrapper" class=" grey lighten-3">
          <div class="container">
            <div class="row">
              <div class="col s12 m12 l12">
                <ol class="breadcrumb">
                    <li><a href="<?=base_url()?>">Dashboard</a></li>
                    <li><a href="<?=base_url('patients')?>">Patients</a></li>
                    <li class="active"><?=$title?></li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!--breadcrumbs end-->
        

        <!--start container-->
        <div class="container">
          <div class="section">
            <div class="row">
              <div class="col s12">
                <?php
                //ERROR ACTION                          
                  if($this->session->flashdata('error')) { ?>
                    <div class="card-panel deep-orange darken-3">
                        <span class="white-text"><i class="mdi-alert-warning tiny"></i> <?php echo $this->session->flashdata('error'); ?></span>
                    </div>
              <?php } ?> 
              <?php
                //SUCCESS ACTION                          
                  if($this->session->flashdata('success')) { ?>
                    <div class="card-panel green">
                        <span class="white-text"><i class="mdi-action-done tiny"></i> <?php echo $this->session->flashdata('success'); ?></span>
                    </div>
              <?php } ?>             
              <?php
                //FORM VALIDATION ERROR
                    $this->form_validation->set_error_delimiters('<p><i class="mdi-alert-warning tiny"></i> ', '</p>');
                      if(validation_errors()) { ?>
                    <div class="card-panel yellow amber">
                        <span class="white-text"> <?php echo validation_errors(); ?></span>
                    </div>
              <?php } ?> 
              </div>
            </div>



            <div class="row">
              <div class="col s12">
                <ul class="tabs z-depth-1" style="width: 100%;">
                  <li class="tab col s2"><a class="active" href="#info">Information</a></li>
                  <li class="tab col s2"><a href="#cases">Cases</a></li>
                  <li class="tab col s2"><a href="#billing">Billing</a></li>
                  <li class="tab col s2"><a href="#medcert">Med. Certificates</a></li>
                  <li class="tab col s2"><a href="#immunization">Immunizations</a></li>
                  <li class="tab col s2"><a href="#logs">Logs</a></li>               
                </ul>
              </div>
              <div class="col s12 card">
                <!-- TABS CONTENT -->
                <!-- PATIENT INFORMATION -->
                <div id="info" class="col s12 card-content">
                  <h5 class="header">Patient Information: <?=$title?></h5><!-- /.header -->
                  <table class="striped bordered">
                    <tr>
                      <th>Lastname:</th>
                      <td width="80%"><?=$info['lastname']?></td>
                    </tr>
                    <tr>
                      <th>Firstname:</th>
                      <td><?=$info['fullname']?></td>
                    </tr>
                    <tr>
                      <th>Middle Name:</th>
                      <td><?=$info['middlename']?></td>
                    </tr>
                    <tr>
                      <th>Sex:</th>
                      <td>
                        <?php if ($info['sex'] == 0): ?>
                          <span class="badge-label pink">Female</span>     
                        <?php else: ?>
                          <span class="badge-label blue">Male</span>  
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
                        <a href="#updateBplace" class="modal-trigger"><i class="mdi-editor-mode-edit tiny"></i></a>                      
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
                        <a href="#updateAddr" class="modal-trigger"><i class="mdi-editor-mode-edit tiny"></i></a>
                      </td>
                    </tr>
                    <tr>
                      <th>Contact Number:</th>
                      <td>
                        <ul>
                          <?php if ($mobile): ?>
                          <?php foreach ($mobile as $con): ?>
                            <li><?=$con['details']?> <a href="#delCon<?=$con['id']?>" class="modal-trigger"><i class="mdi-content-remove-circle-outline tiny"></i></a> </li>
                          <?php endforeach ?>  
                          <?php endif ?>
                          <li><small><a href="#createContact" class="modal-trigger"><em>[ New Contact... ]</em></a></small></li>
                        </ul>
                      </td>
                    </tr>
                    <tr>
                      <th>Email:</th>
                      <td>
                        <ul>
                          <?php if ($email): ?>
                          <?php foreach ($email as $mail): ?>
                            <li><?=$mail['details']?> <a href="#delEmail<?=$mail['id']?>" class="modal-trigger"><i class="mdi-content-remove-circle-outline tiny"></i></a> </li>
                          <?php endforeach ?>  
                          <?php endif ?>
                          <li><small><a href="#createEmail" class="modal-trigger"><em>[ New Email... ]</em></a></small></li>
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
                  </table><!-- /.striped -->
                  <br />
                    <div class="right">
                      <a href="#UpdateModal" class="modal-trigger btn waves-effect amber">Update<i class="mdi-editor-border-color left"></i></a>
                      <a href="#deleteModal" class="modal-trigger btn waves-effect red">Archive<i class="mdi-action-delete left"></i></a>
                    </div><!-- /.right -->
                </div> <!-- /#info -->
                <!-- END PATIENT INFORMATION -->

                <!-- CASE INFORTION -->
                <div id="cases" class="col s12 card-content">
                  <h5 class="header">Cases <span class="right">(<?=$total_cases?>)</span></h5><!-- /.header -->
                  <table class="bordered">
                  <?php if ($cases): ?>
                  <?php foreach ($cases as $cse): ?>
                    <tr>
                      <td><a href="<?=base_url('patients/view/'.$cse['patient_id'].'/case/'.$cse['id'])?>">
                        <?=$cse['title']?>                              
                         <?php if ($cse['status'] == 3): ?>
                           <span class="badge-label grey darken-3">Cancelled</span>     
                         <?php elseif($cse['status'] == 1): ?>
                           <span class="badge-label green darken-3">Served</span>                                   
                         <?php else: ?> 
                           <span class="badge-label red darken-3">Pending</span> 
                         <?php endif ?>
                     </a></td>
                     <td><a href="<?=base_url('patients/view/'.$cse['patient_id'].'/case/'.$cse['id'])?>"><?=nice_date(($cse['created_at']), 'M. d, Y')?></a></td>
                   </tr>
                  <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td>No Case Found!</td>
                    </tr>
                  <?php endif; ?>                      
                  </table><!-- /.bordered -->
                  <br />
                  <div class="right">
                      <a href="#caseModal" class="modal-trigger btn waves-effect green">New Case<i class="mdi-av-my-library-books left"></i></a>
                  </div><!-- /.right -->
                </div>
                <!-- END CASE INFORMATION -->

                <!-- BILLING INFORTION --> 
                <div id="billing" class="col s12 card-content">
                  <h5 class="header">Billing Queues</h5><!-- /.header -->
                  <div class="card-panel light-green white-text">
                    <p><i class="mdi-action-info-outline tiny"></i> To add a Billing Queue, go to tab <em>Cases > Select a Case > Generate Billing Queue</em></p>
                  </div><!-- /.card-panel light-green white-text -->
                  <table class="bordered">
                  <?php if ($billing): ?>
                    <thead>
                      <tr>
                        <th></th>
                        <th>CASE</th>
                        <th>Payables</th>
                        <th>Payments</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($billing as $bill): ?>
                          <tr>
                            <td><a href="<?=base_url('billing/view/'.$bill['id'])?>">BILL #<?=prettyID($bill['id'])?></a></td>
                            <td><a href="<?=base_url('billing/view/'.$bill['id'])?>">
                              <?=$bill['case_title']?>                              
                               <?php if ($bill['status'] == 3): ?>
                                 <span class="badge-label grey darken-3">Cancelled</span>     
                               <?php elseif($bill['status'] == 1): ?>
                                 <span class="badge-label green darken-3">Served</span>                                   
                               <?php else: ?> 
                                 <span class="badge-label red darken-3">Pending</span> 
                               <?php endif ?>
                           </a></td>
                            <td><a href="<?=base_url('billing/view/'.$bill['id'])?>"><?=$bill['payables']?></a></td>
                            <td><a href="<?=base_url('billing/view/'.$bill['id'])?>"><?=$bill['payments']?></a></td>
                            <td><a href="<?=base_url('billing/view/'.$bill['id'])?>"><?=nice_date(($bill['created_at']), 'M. d, Y')?></a></td>
                         </tr>
                        <?php endforeach; ?>
                    </tbody>
                  
                  <?php else: ?>
                    <tr>
                      <td>No Billing Queue Found!</td>
                    </tr>
                  <?php endif; ?>                      
                  </table><!-- /.bordered -->
                </div>
                <!-- END BILLING INFORMATION -->

                <!-- MEDICAL CERTIFICATES INFORMATION --> 
                <div id="medcert" class="col s12 card-content">
                    <h5 class="header">Medical Certificates</h5><!-- /.header -->
                    <table class="striped bordered">
                    <?php if ($medcerts): ?>                    
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
                    </table><!-- /.striped bordered -->                    
                </div>
                <!-- END MEDICAL CERTIFICATES INFORMATION -->

                <!-- IMMUNIZATIONS INFORMATION --> 
                <div id="immunization" class="col s12 card-content">
                    <h5 class="header">Immunizations Taken</h5><!-- /.header -->
                    <table class="striped bordered">
                    <?php if ($immunizations): ?>                    
                      <thead>
                        <tr>
                          <th></th>
                          <th>Service</th>
                          <th>Date</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($immunizations as $immu): ?>
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
                    </table><!-- /.striped bordered --> 
                </div>
                <!-- END IMMUNIZATIONS INFORMATION -->

                <!-- LOGS INFORMATION --> 
                <div id="logs" class="col s12 card-content">
                  <h6 class="header"><span class="strong">Patient Logs</span> <small><em><a href="<?=base_url('patients/view/'.$info['id'].'/logs')?>" class="right">[ View All Logs ]</a></em></small></h6><!-- /.header -->
                    <table class="bordered">
                    <?php if ($logs): ?>
                    <?php foreach ($logs as $log): ?>
                      <tr>
                        <td><span class="badge-label pink darken-1"><?=$log['user']?></span></td>
                        <td><?=$log['action']?></td>
                        <td><small><?=$log['date_time']?></small></td>
                      </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                      <tr>
                        <td>No Logs Found!</td>
                      </tr>
                    <?php endif; ?>                      
                    </table><!-- /.bordered -->
                </div> 
                <!-- END LOGS INFORMATION -->                                 
                <!-- END TABS CONTENT -->
              </div> <!-- /. col s12 card -->
            </div><!-- /.row -->
                     
          </div>
        </div>
        <!--end container-->
      </section>
      <!-- END CONTENT -->

    </div>
    <!-- END WRAPPER -->

  </div>
  <!-- END MAIN -->


      <!-- Modals -->
          <div id="caseModal" class="modal modal-fixed-footer">
              <?=form_open('cases/create')?>              
                  <div class="modal-content">    
                   <h5 class="header">New Case: <?=$info['fullname'] . ' ' . $info['lastname']?></h5><!-- /.header black-text -->              
                   <div class="row">
                     <div class="input-field col s6">
                        <input type="number" name="weight" id="weight" class="validate" value="<?=set_value('weight')?>" required/>
                        <label for="weight">Weight (kg)</label>
                      </div><!-- /.input-field col s6 -->
                     <div class="input-field col s6">
                        <input type="number" name="height" id="height" class="validate" value="<?=set_value('height')?>" required/>
                        <label for="height">Height (cm)</label>
                      </div><!-- /.input-field col s6 -->
                   </div><!-- /.row -->
                   <div class="row">
                     <div class="input-field col s12">
                       <input type="text" name="title" id="title" class="validate" value="<?=set_value('title')?>" required/>
                       <label for="title">Case Title</label>
                     </div><!-- /.input-field col s12 -->
                   </div><!-- /.row -->
                   <div class="row">
                     <div class="col s12">
                        <p>Case Description</p> <br />
                        <textarea name="description" id="" class="ckeditor"><?=set_value('description')?></textarea>                       
                     </div><!-- /.col-s12 -->
                   </div><!-- /.row -->
                    <input type="hidden" name="id" value="<?=$this->encryption->encrypt($info['id'])?>" />
                  </div>
                  <div class="modal-footer">
                    <a href="#" class="waves-effect waves-green btn-flat red-text modal-action modal-close">Cancel</a>
                    <button type="submit" class="waves-effect waves-green btn green modal-action">New Case</button>
                  </div>
              <?=form_close()?>
            </div>


            <div id="UpdateModal" class="modal modal-fixed-footer">
              <?=form_open('patients/update')?>              
                  <div class="modal-content">    
                   <h5 class="header">Update: <?=$info['fullname'] . ' ' . $info['lastname']?></h5><!-- /.header black-text -->              
                    <div class="row">
                     <div class="input-field col s12">
                        <input type="text" name="lname" id="lname" class="validate" value="<?=$info['lastname']?>" required/>
                        <label for="lname">Last Name</label>
                     </div><!-- /.input-field col s4 l4 -->                   
                     <div class="input-field col s12">
                        <input type="text" name="fname" id="fname" class="validate" value="<?=$info['fullname']?>" required/>
                        <label for="fname">Full Name</label>
                     </div><!-- /.input-field col s4 l4 -->                   
                     <div class="input-field col s12">
                        <input type="text" name="mname" id="mname" class="validate" value="<?=$info['middlename']?>" required/>
                        <label for="mname">Middle Name</label>
                     </div><!-- /.input-field col s12 -->         
                     <div class="input-field col s12">
                        <small>Sex</small>
                        <select class="browser-default" name="sex" id="sex" required>                          
                          <option value="1" <?php if($info['sex'])echo'selected';?>>Male</option>
                          <option value="0" <?php if(!$info['sex'])echo'selected';?>>Female</option>                       
                        </select>
                     </div><!-- /.input-field col s8 -->
                     <div class="input-field col s12">
                     <small>Birthdate</small>
                        <input type="date" name="bdate" id="bdate" value="<?=$info['birthdate']?>" required/>                        
                     </div><!-- /.input-field col s4 -->
                 
                   </div><!-- /.row -->
                    <input type="hidden" name="id" value="<?=$this->encryption->encrypt($info['id'])?>" />
                  </div>
                  <div class="modal-footer yellow lighten-4">
                    <a href="#" class="waves-effect waves-green btn-flat red-text modal-action modal-close">Cancel</a>
                    <button type="submit" class="waves-effect waves-amber btn amber modal-action">Update</button>
                  </div>
              <?=form_close()?>
            </div>


            <div id="deleteModal" class="modal">
              <?=form_open('patients/delete')?>
                <div class="modal-content red darken-4 white-text">
                    <p>Are you sure to move the record of <span class="strong"><?=$info['fullname'] . ' ' . $info['lastname']?></span> to <strong>TRASH?</strong>?</p>
                    <p>You <span class="strong">CANNOT UNDO</span> this action.</p>
                    <input type="hidden" name="id" value="<?=$this->encryption->encrypt($info['id'])?>" />
                  </div>
                  <div class="modal-footer grey darken-4">
                    <a href="#" class="waves-effect waves-red btn-flat amber-text strong modal-action modal-close">Cancel</a>
                    <button type="submit" class="waves-effect waves-red btn red modal-action">Move to Trash</button>
                  </div>
              <?=form_close()?>
            </div>


            <?php if ($email): ?>
            <?php foreach ($email as $mail): ?>
            <div id="delEmail<?=$mail['id']?>" class="modal">
              <?=form_open('patients/delete_contact')?>
                <div class="modal-content red darken-4 white-text">
                    <p>Are you sure to delete this Email Address - <?=$mail['details']?>? </p>
                    <p>You <span class="strong">CANNOT UNDO</span> this action.</p>
                    <input type="hidden" name="pid" value="<?=$this->encryption->encrypt($info['id'])?>" />
                    <input type="hidden" name="id" value="<?=$this->encryption->encrypt($mail['id'])?>" />
                    <input type="hidden" name="tag" value="<?=$this->encryption->encrypt($mail['tag'])?>" />
                  </div>
                  <div class="modal-footer grey darken-4">
                    <a href="#" class="waves-effect waves-red btn-flat amber-text strong modal-action modal-close">Cancel</a>
                    <button type="submit" class="waves-effect waves-red btn red modal-action">Delete Email</button>
                  </div>
              <?=form_close()?>
            </div>
            <?php endforeach ?>
            <?php endif ?>

            <?php if ($mobile): ?>
            <?php foreach ($mobile as $con): ?>
            <div id="delCon<?=$con['id']?>" class="modal">
              <?=form_open('patients/delete_contact')?>
                <div class="modal-content red darken-4 white-text">
                    <p>Are you sure to delete this Contact Number- <?=$con['details']?>? </p>
                    <p>You <span class="strong">CANNOT UNDO</span> this action.</p>
                    <input type="hidden" name="pid" value="<?=$this->encryption->encrypt($info['id'])?>" />
                    <input type="hidden" name="id" value="<?=$this->encryption->encrypt($con['id'])?>" />
                    <input type="hidden" name="tag" value="<?=$this->encryption->encrypt($con['tag'])?>" />
                  </div>
                  <div class="modal-footer grey darken-4">
                    <a href="#" class="waves-effect waves-red btn-flat amber-text strong modal-action modal-close">Cancel</a>
                    <button type="submit" class="waves-effect waves-red btn red modal-action">Delete Email</button>
                  </div>
              <?=form_close()?>
            </div>
            <?php endforeach ?>
            <?php endif ?>
    

            <div id="createContact" class="modal">
              <?=form_open('patients/create_contact')?>
                <div class="modal-content blue lighten-5">                    
                    <h5 class="header">Add Contact</h5><!-- /.header -->
                    <div class="input-field col s12">
                      <input type="text" name="details" id="details" class="validate" />
                      <label for="details">Mobile / Telephone / Fax No.</label>
                    </div><!-- /.input-field col s12 -->
                    <input type="hidden" name="pid" value="<?=$this->encryption->encrypt($info['id'])?>" />
                    <input type="hidden" name="tag" value="<?=$this->encryption->encrypt(0)?>" />
                  </div>
                  <div class="modal-footer grey darken-4">
                    <button type="submit" class="waves-effect waves-red btn blue modal-action">New Contact</button>                  
                    <a href="#" class="waves-effect waves-red btn-flat amber-text strong modal-action modal-close">Cancel</a>
                  </div>
              <?=form_close()?>
            </div>


            <div id="createEmail" class="modal">
              <?=form_open('patients/create_contact')?>
                <div class="modal-content amber lighten-5">                    
                    <h5 class="header">Add Email Address</h5><!-- /.header -->
                    <div class="input-field col s12">
                      <input type="email" name="details" id="details" class="validate" />
                      <label for="details">Email Address</label>
                    </div><!-- /.input-field col s12 -->
                    <input type="hidden" name="pid" value="<?=$this->encryption->encrypt($info['id'])?>" />
                    <input type="hidden" name="tag" value="<?=$this->encryption->encrypt(1)?>" />
                  </div>
                  <div class="modal-footer grey darken-4">
                    <button type="submit" class="waves-effect waves-red btn amber modal-action">New Email</button>                  
                    <a href="#" class="waves-effect waves-red btn-flat amber-text strong modal-action modal-close">Cancel</a>
                  </div>
              <?=form_close()?>
            </div>


            <div id="updateAddr" class="modal">
              <?=form_open('patients/update_address')?>
                <div class="modal-content blue lighten-5">                    
                    <h5 class="header">Update Present Address</h5><!-- /.header -->
                    <div class="row">                     
                     <fieldset class=" green lighten-5">
                        <legend class="strong">Present Address</legend>
                          <div class="input-field col s12 l5">
                           <input type="text" name="bldg" id="bldg" class="validate" value="<?=$addr['building']?>" required/>
                           <label for="bldg">Building / Block / House</label>
                         </div><!-- /.input-field col s12 -->
                         <div class="input-field col s12 l4">
                           <input type="text" name="strt" id="strt" class="validate" value="<?=$addr['street']?>" required/>
                           <label for="strt">Street</label>
                         </div><!-- /.input-field col s12 -->
                         <div class="input-field col s12 l3">
                           <input type="text" name="brgy" id="brgy" class="validate" value="<?=$addr['barangay']?>" required/>
                           <label for="brgy">Barangay</label>
                         </div><!-- /.input-field col s12 -->
                         <div class="input-field col s12 l3">
                           <input type="text" name="city" id="city" class="validate" value="<?=$addr['city']?>" required/>
                           <label for="city">City / Municipality</label>
                         </div><!-- /.input-field col s12 -->
                         <div class="input-field col s12 l3">
                           <input type="text" name="province" id="province" class="validate" value="<?=$addr['province']?>" required/>
                           <label for="province">Province / Region</label>
                         </div><!-- /.input-field col s12 -->
                         <div class="input-field col s12 l2">
                           <input type="text" name="zip" id="zip" class="validate" value="<?=$addr['zip']?>" required/>
                           <label for="zip">ZIP Code</label>
                         </div><!-- /.input-field col s12 -->
                         <div class="input-field col s12 l4">
                           <input type="text" name="country" id="country" class="validate" value="<?=$addr['country']?>" required/>
                           <label for="country">Country</label>
                         </div><!-- /.input-field col s12 -->
                     </fieldset>
                   </div><!-- /.row -->                   
                    <input type="hidden" name="id" value="<?=$this->encryption->encrypt($addr['id'])?>" />
                    <input type="hidden" name="pid" value="<?=$this->encryption->encrypt($info['id'])?>" />
                    <input type="hidden" name="tag" value="<?=$this->encryption->encrypt(1)?>" />
                  </div>
                  <div class="modal-footer grey darken-4">
                    <button type="submit" class="waves-effect waves-red btn blue modal-action">Update Address</button>                  
                    <a href="#" class="waves-effect waves-red btn-flat amber-text strong modal-action modal-close">Cancel</a>
                  </div>
              <?=form_close()?>
            </div>


            <div id="updateBplace" class="modal">
              <?=form_open('patients/update_address')?>
                <div class="modal-content green lighten-5">                    
                    <h5 class="header">Update Birthplace</h5><!-- /.header -->
                    <div class="row">                     
                     <fieldset class=" green lighten-5">
                        <legend class="strong">Birthplace</legend>
                          <div class="input-field col s12 l5">
                           <input type="text" name="bldg" id="bldg" class="validate" value="<?=$bplace['building']?>"/>
                           <label for="bldg">Building / Block / House</label>
                         </div><!-- /.input-field col s12 -->
                         <div class="input-field col s12 l4">
                           <input type="text" name="strt" id="strt" class="validate" value="<?=$bplace['street']?>"/>
                           <label for="strt">Street</label>
                         </div><!-- /.input-field col s12 -->
                         <div class="input-field col s12 l3">
                           <input type="text" name="brgy" id="brgy" class="validate" value="<?=$bplace['barangay']?>"/>
                           <label for="brgy">Barangay</label>
                         </div><!-- /.input-field col s12 -->
                         <div class="input-field col s12 l3">
                           <input type="text" name="city" id="city" class="validate" value="<?=$bplace['city']?>" required/>
                           <label for="city">City / Municipality</label>
                         </div><!-- /.input-field col s12 -->
                         <div class="input-field col s12 l3">
                           <input type="text" name="province" id="province" class="validate" value="<?=$bplace['province']?>" required/>
                           <label for="province">Province / Region</label>
                         </div><!-- /.input-field col s12 -->
                         <div class="input-field col s12 l2">
                           <input type="text" name="zip" id="zip" class="validate" value="<?=$bplace['zip']?>" required/>
                           <label for="zip">ZIP Code</label>
                         </div><!-- /.input-field col s12 -->
                         <div class="input-field col s12 l4">
                           <input type="text" name="country" id="country" class="validate" value="<?=$bplace['country']?>" required/>
                           <label for="country">Country</label>
                         </div><!-- /.input-field col s12 -->
                     </fieldset>
                   </div><!-- /.row -->                   
                    <input type="hidden" name="id" value="<?=$this->encryption->encrypt($bplace['id'])?>" />
                    <input type="hidden" name="pid" value="<?=$this->encryption->encrypt($info['id'])?>" />
                    <input type="hidden" name="tag" value="<?=$this->encryption->encrypt(0)?>" />
                  </div>
                  <div class="modal-footer grey darken-4">
                    <button type="submit" class="waves-effect waves-red btn green modal-action">Update Birthplace</button>                  
                    <a href="#" class="waves-effect waves-red btn-flat amber-text strong modal-action modal-close">Cancel</a>
                  </div>
              <?=form_close()?>
            </div>


        <!-- End Modals -->



     <!-- //////////////////////////////////////////////////////////////////////////// -->

    <?php $this->load->view('inc/footer'); ?>

    <?php $this->load->view('inc/js'); ?>
    <script src="<?=base_url('assets/ckeditor/ckeditor.js')?>"></script>
    
   
</body>
</html>





                

