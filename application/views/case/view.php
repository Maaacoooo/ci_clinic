<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <title><?=$title?> &middot; <?=$site_title?></title>

    <?php $this->load->view('inc/css'); ?>
    <link href="<?php echo base_url();?>assets/css/jquery-ui.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/jquery-ui.theme.min.css" rel="stylesheet">

    <script type="text/javascript">
      function queues() {

          if(document.getElementById("served").checked == true) {
            document.getElementById("clearqueue").checked = true;
          } 

          if(document.getElementById("pending").checked == true) {
            document.getElementById("generatequeue").checked = true;
          } 

          if(document.getElementById("cancel").checked == true) {
            document.getElementById("clearqueue").checked = true;
          } 

      }
    </script>

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
                    <li><a href="<?=base_url('patients/view/'.$info['id'])?>"><?=$info['fullname'] . ' ' . $info['lastname']?></a></li>
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
                  <li class="tab col s2"><a class="active" href="#info">Case Information</a></li>
                  <li class="tab col s2"><a href="#prescription">Prescriptions</a></li>
                  <li class="tab col s2"><a href="#labrequest">Lab Request</a></li>
                  <li class="tab col s2"><a href="#medcert">Med. Certificates</a></li>
                  <li class="tab col s2"><a href="#immunization">Immunizations</a></li>
                  <li class="tab col s2"><a href="#logs">Logs</a></li>               
                </ul>
              </div>
              <div class="col s12 card">
                <!-- TABS CONTENT -->
                
                <!-- CASE INFORTION -->
                <div id="info" class="col s12 card-content">
                  <div class="row">
                    <div class="col s12 l8">
                      <h5 class="header">Case Information : <?=$case['title']?></h5><!-- /.header -->
                    <table class="bordered striped">
                      <tr>
                        <th width="20%">Patient Name:</th>
                        <td><?=$info['fullname'] . ' ' . $info['lastname']?></td>
                      </tr>
                      <tr>
                        <th>Case Status:</th>
                        <td>
                          <?php if ($case['status'] == 3): ?>
                            <span class="badge-label grey darken-3">Cancelled</span>     
                          <?php elseif($case['status'] == 1): ?>
                            <span class="badge-label green darken-3">Served</span>                                   
                          <?php else: ?> 
                            <span class="badge-label red darken-3">Pending</span> 
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
                    </table><!-- /.bordered striped -->    
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
                    </div><!-- /.col s12 l8 -->
                    <div class="col s12 l4">                      
                       <div class="card">
                         <div class="card-content">
                            <h6 class="header strong">Options</h6><!-- /.header -->
                            <br />     
                            <div class="row">
                              <a href="<?=current_url()?>/print" target="_blank" class="btn light-blue col s8 offset-s2"><i class="mdi-action-print"></i> Issue Med. Cert</a>   
                            </div><!-- /.row -->  
                            <br />     
                            <div class="row">
                              <a href="#medcertModal" class="modal-trigger btn waves-effect light-blue col s8 offset-s2">Issue Med. Cert</a>   
                            </div><!-- /.row -->  
                            <br />
                            <?php if ($user['usertype'] == 'Doctor'): ?>
                            <div class="row">
                              <a href="#addPrescription" class="modal-trigger btn waves-effect green col s8 offset-s2">Add Prescription</a>  
                            </div><!-- /.row -->    
                            <br/>    
                            <div class="row">
                              <a href="#changeStatus" class="modal-trigger btn waves-effect amber col s8 offset-s2">Change Status</a>   
                            </div><!-- /.row -->
                            <br />    
                            <?php endif ?>   
                         </div><!-- /.card-content -->
                       </div><!-- /.card -->                       
                    </div><!-- /.col s12 l4 -->
                  </div><!-- /.row -->
                </div>
                <!-- END CASE INFORMATION -->

                <!-- PRESCRIPTION INFORMATION --> 
                <div id="prescription" class="col s12 card-content">
                  <h5 class="header">Prescriptions</h5><!-- /.header -->
                   <div class="row">
                     <div class="col s12">
                       <table class="bordered">
                        <thead>
                          <tr>
                            <th>Issued by</th>
                            <th>Title</th>
                            <th>Date and Time</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if ($prescriptions): ?>
                            <?php foreach ($prescriptions as $pres): ?>
                              <tr>
                                <td><a href="<?=base_url('patients/view/'.$info['id'].'/case/'.$case['id'].'/prescription/view/'.$pres['id'])?>"><?=$pres['created_by']?></a></td>
                                <td><a href="<?=base_url('patients/view/'.$info['id'].'/case/'.$case['id'].'/prescription/view/'.$pres['id'])?>"><?=$pres['title']?></a></td>
                                <td><a href="<?=base_url('patients/view/'.$info['id'].'/case/'.$case['id'].'/prescription/view/'.$pres['id'])?>"><?=$pres['created_at']?></a></td>
                              </tr>
                            <?php endforeach ?>   
                          <?php else: ?>
                              <tr>
                                <td colspan="3">No Prescriptions Found!</td>
                              </tr>                         
                          <?php endif ?>
                        </tbody>
                       </table><!-- /.striped bordered -->
                     </div><!-- /.col s12 -->
                   </div><!-- /.row -->
                   <br /> 
                   <div class="row">
                     <div class="col s12">          
                         <a href="#addPrescription" class="modal-trigger btn waves-effect green right">Add Prescription</a>  
                     </div><!-- /.col s12 -->
                   </div><!-- /.row -->
                </div>
                <!-- END PRESCRIPTION INFORMATION -->

                <!-- LAB REQUEST INFORMATION --> 
                <div id="labrequest" class="col s12 card-content">
                  <h5 class="header">Laboratory Requests</h5><!-- /.header -->     
                  <?=form_open('laboratory/create')?> 
                  <div class="row">
                    <div class="col s10 input-field">
                      <input type="text" name="labreq" id="labreq" class="validate" />
                      <input type="hidden" name="id" value="<?=$this->encryption->encrypt($case['id'])?>" />                    
                      <label for="labreq">Request for Laboratory Service</label>
                    </div><!-- /.col s9 -->
                    <div class="input-field col s2">
                      <button type="submit" class="btn waves-effect orange">Request</button>
                    </div><!-- /.input-field col s2-->
                  </div><!-- /.row -->    
                  <?=form_close()?>       
                  <table class="striped bordered">
                    <thead>
                      <tr>
                        <th>Request</th>
                        <th>Service</th>
                        <th>Requestor</th>
                        <th>Date Time</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if ($labreqs): ?>
                        <?php foreach ($labreqs as $lab): ?>
                        <tr>
                          <td><a href="<?=base_url('patients/view/'.$info['id'].'/case/'.$lab['case_id'].'/laboratory/'.$lab['id'])?>">#<?=prettyID($lab['id'])?></a></td>
                          <td>
                            <a href="<?=base_url('patients/view/'.$info['id'].'/case/'.$lab['case_id'].'/laboratory/'.$lab['id'])?>"><?=$lab['service']?> - <?=$lab['code']?></a>
                            <?php if ($lab['status'] == 3): ?>
                            <span class="badge-label grey darken-3">Cancelled</span>     
                            <?php elseif($lab['status'] == 1): ?>
                              <span class="badge-label green darken-3">Served</span>                                   
                            <?php else: ?> 
                              <span class="badge-label red darken-3">Pending</span> 
                            <?php endif ?>
                          </td>
                          <td><a href="<?=base_url('patients/view/'.$info['id'].'/case/'.$lab['case_id'].'/laboratory/'.$lab['id'])?>"><?=$lab['user']?></a></td>
                          <td><a href="<?=base_url('patients/view/'.$info['id'].'/case/'.$lab['case_id'].'/laboratory/'.$lab['id'])?>"><?=$lab['created_at']?></a></td>
                        </tr>
                        <?php endforeach ?>
                      <?php else: ?>
                        <tr>
                          <td colspan="4">No Laboratory Request found!</td>
                        </tr>
                      <?php endif ?>
                    </tbody>
                  </table><!-- /.striped bordered -->                    
                </div><!-- /#labrequest -->
                <!-- END LAB REQUEST INFORMATION -->

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
                          <td><a href="<?=base_url('patients/view/'.$med['patient_id'].'/medcert/view/'.$med['cert_id'])?>">CERT #<?=prettyID($med['cert_id'])?> - <?=$med['title']?></a></td>
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
                    <br />
                    <div class="row">
                     <div class="col s12">          
                         <a href="#medcertModal" class="modal-trigger btn waves-effect light-blue right">Issue Medical Certificate</a>
                     </div><!-- /.col s12 -->
                   </div><!-- /.row -->
                </div>
                <!-- END MEDICAL CERTIFICATES INFORMATION -->

                <!-- IMMUNIZATIONS INFORMATION --> 
                <div id="immunization" class="col s12 card-content">
                  <h5 class="header">Immunizations Requests</h5><!-- /.header -->
                  <?=form_open('immunization/create')?> 
                  <div class="row">
                    <div class="col s10 input-field">
                      <input type="text" name="immu" id="immu" class="validate" />
                      <input type="hidden" name="id" value="<?=$this->encryption->encrypt($case['id'])?>" />                    
                      <label for="immu">Request for Immunization Service</label>
                    </div><!-- /.col s9 -->
                    <div class="input-field col s2">
                      <button type="submit" class="btn waves-effect orange">Request</button>
                    </div><!-- /.input-field col s2-->
                  </div><!-- /.row -->    
                  <?=form_close()?>       
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
                          <td>
                          <a href="<?=base_url('patients/view/'.$immu['patient_id'].'/case/'.$immu['case_id'].'/immunization/'.$immu['id'])?>">
                          <?=$immu['service']?>
                          <?php if ($immu['status'] == 3): ?>
                            <span class="badge-label grey darken-3">Cancelled</span>     
                            <?php elseif($immu['status'] == 1): ?>
                              <span class="badge-label green darken-3">Served</span>                                   
                            <?php else: ?> 
                              <span class="badge-label red darken-3">Pending</span> 
                            <?php endif ?>
                          </a>
                          </td>
                          <td><a href="<?=base_url('patients/view/'.$immu['patient_id'].'/case/'.$immu['case_id'].'/immunization/view/'.$immu['id'])?>"><?=$immu['updated_at']?></a></td>
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

                <!-- LOGS INFORTION --> 
                <div id="logs" class="col s12 card-content">
                  <h6 class="header"><span class="strong">Case Logs</span></h6><!-- /.header -->
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
            <?php if ($user['usertype'] == 'Doctor'): ?>

            <div id="addPrescription" class="modal modal-fixed-footer">
              <?=form_open('prescription/create')?>
                <div class="modal-content">
                    <div class="row">
                      <div class="col s12">
                        <h5 class="header">Add Prescription</h5><!-- /.header -->
                        <p>When adding a prescription, please input the title(optional) and the description of the prescription.</p>
                      </div><!-- /.col s12 -->
                      <div class="input-field col s12">
                        <input type="text" name="title" id="title" class="validate" placeholder="(Optional)" />
                        <label for="title">Title</label>
                      </div><!-- /.input-field col s12 -->
                      <div class="input-field col s12">
                        <textarea name="description" id="" cols="30" rows="10" class="ckeditor"></textarea>
                      </div><!-- /.input-field col s12 -->
                    </div><!-- /.row -->
                    <input type="hidden" name="id" value="<?=$this->encryption->encrypt($case['id'])?>" />
                    <input type="hidden" name="pid" value="<?=$this->encryption->encrypt($info['id'])?>" />
                  </div>
                  <div class="modal-footer grey darken-4">
                    <a href="#" class="waves-effect waves-red btn-flat amber-text strong modal-action modal-close">Cancel</a>
                    <button type="submit" class="waves-effect waves-red btn green modal-action">Add Prescription</button>
                  </div>
              <?=form_close()?>
            </div>


            <div id="changeStatus" class="modal">
              <?=form_open('cases/change_status')?>
                <div class="modal-content">
                    <div class="row">
                      <h5 class="header">Change Status</h5><!-- /.header -->
                      <div class="col s6">
                         <p>This changes the status of the case.</p>                        

                         <input name="status" type="radio" id="pending" onclick="queues()" value="<?=$this->encryption->encrypt(0)?>" class="with-gap" <?php if ($case['status'] == 0)echo'checked';?>>
                         <label for="pending">Pending</label>
                         <input name="status" type="radio" id="served" onclick="queues()" value="<?=$this->encryption->encrypt(1)?>" class="with-gap" <?php if ($case['status'] == 1)echo'checked';?>>
                         <label for="served">Served</label>
                         <input name="status" type="radio" id="cancel" onclick="queues()" value="<?=$this->encryption->encrypt(3)?>" class="with-gap" <?php if ($case['status'] == 3)echo'checked';?>>
                         <label for="cancel">Cancelled</label>
                         <p><i class="mdi-action-info-outline tiny"></i> Once case is set to <span class="badge-label green darken-3">served</span>, Please tick the <a href="#">`clear queues`</a> checkbox to accomodate a new queue.</p>
                      </div><!-- /.col s12 -->
                      <div class="col s6">
                         <p><i class="mdi-action-info-outline tiny"></i> You can clear and generate queues at the same time.</p>                        
                        <div class="card">
                          <div class="card-content">
                            <h6 class="header strong">Queue Options</h6><!-- /.header -->                            
                            <p>
                              <input type="checkbox" id="clearqueue" name="clearqueue">
                              <label for="clearqueue">Clear Queues for this Case</label>
                            </p>
                            <p>
                              <input type="checkbox" id="generatequeue" name="generatequeue">
                              <label for="generatequeue">Generate New Queue</label>
                            </p>
                            <p>
                              <input type="checkbox" id="nextqueue" name="nextqueue" checked>
                              <label for="nextqueue">Proceed to the Next Queue</label>
                            </p>
                          </div><!-- /.card-content -->
                        </div><!-- /.card -->
                      </div><!-- /.input-field col s12 -->
                    </div><!-- /.row -->
                    <input type="hidden" name="id" value="<?=$this->encryption->encrypt($case['id'])?>" />
                    <input type="hidden" name="pid" value="<?=$this->encryption->encrypt($info['id'])?>" />
                  </div>
                  <div class="modal-footer grey darken-4">
                    <a href="#" class="waves-effect waves-red btn-flat red-text strong modal-action modal-close">Cancel</a>
                    <button type="submit" class="waves-effect waves-red btn amber modal-action">Change</button>
                  </div>
              <?=form_close()?>
            </div>
              
            <?php endif ?>

            <div id="medcertModal" class="modal">
              <?=form_open('cases/create_medcert')?>
                <div class="modal-content">
                    <div class="row">
                      <h5 class="header">Issue Medical Certificate</h5><!-- /.header -->
                      <div class="col s6">
                         <p><i class="mdi-action-info-outline tiny"></i> Please note that you <span class="red-text strong">CANNOT UNDO nor UPDATE</span> the Medical Certificate. All Inputs should treated as final and true.</p>
                         <p>Please input the required fields</p>                       
                          <div class="input-field col s12">
                            <input type="text" name="title" id="title" class="validate" required="" />
                            <label for="title">Case Title</label>
                          </div><!-- /.input-field col s12 -->
                          <div class="col s12">
                            <label>Attending Physician</label>
                            <select class="browser-default" name="doctor" required="">
                              <option value="" disabled="" selected="">Choose Physician...</option>
                              <?php foreach ($meddoctors as $doc): ?>
                              <option value="<?=$doc['name']?>">Dr. <?=$doc['name'].' - LIC. # '.$doc['lic_no']?></option>
                              <?php endforeach ?>
                            </select>
                          </div>                           
                      </div><!-- /.col s12 -->
                      <div class="col s6">
                        <div class="col s12">
                            <label for="remarks">Remarks and Recommendations</label>                            
                            <textarea name="remarks" id="remarks" cols="30" rows="10" class="ckeditor" required=""></textarea>
                        </div><!-- /.input-field col s12 -->                             
                      </div><!-- /.input-field col s12 -->
                    </div><!-- /.row -->
                    <input type="hidden" name="id" value="<?=$this->encryption->encrypt($case['id'])?>" />
                    <input type="hidden" name="pid" value="<?=$this->encryption->encrypt($info['id'])?>" />
                  </div>
                  <div class="modal-footer grey darken-4">
                    <a href="#" class="waves-effect waves-red btn-flat red-text strong modal-action modal-close">Cancel</a>
                    <button type="submit" class="waves-effect waves-red btn light-blue modal-action">Issue Certificate</button>
                  </div>
              <?=form_close()?>
            </div>
  
  

     <!-- //////////////////////////////////////////////////////////////////////////// -->

    <?php $this->load->view('inc/footer'); ?>

    <?php $this->load->view('inc/js'); ?>
   
    <script src="<?php echo base_url();?>assets/js/jquery-ui.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
    
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
    <script src="<?=base_url('assets/ckeditor/ckeditor.js')?>"></script>
   
</body>
</html>