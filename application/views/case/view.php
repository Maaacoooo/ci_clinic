<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <title><?=$title?> &middot; <?=$site_title?></title>

    <?php $this->load->view('inc/css'); ?>
    
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
               <div class="col s12 l8">
                  <div class="row">
                     <div class="col s12">                       
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
                     </div><!-- /.col s12 -->
                   </div><!-- /.row --> 
               </div><!-- /.col s12 l8 -->


               <div class="col s12 l4">
                 
                  <div class="row">
                   <div class="col s12">
                    <?php if ($user['usertype'] == 'Doctor'): ?>
                     <div class="card">
                       <div class="card-content">
                          <h6 class="header strong">Options</h6><!-- /.header -->
                          <div class="row">
                            <a href="#addPrescription" class="modal-trigger btn waves-effect green col s8 offset-s2">Add Prescription</a>  
                          </div><!-- /.row -->    
                          <br/>    
                          <div class="row">
                            <a href="#changeStatus" class="modal-trigger btn waves-effect amber col s8 offset-s2">Change Status</a>   
                          </div><!-- /.row -->        
                       </div><!-- /.card-content -->
                     </div><!-- /.card -->
                     <?php endif ?> 
                                         
                     <table class="bordered card">
                        <thead>
                          <tr>
                            <th>Prescriptions</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if ($prescriptions): ?>
                            <?php foreach ($prescriptions as $pres): ?>
                              <tr>
                                <td><a href="<?=base_url('patients/view/'.$info['id'].'/case/'.$case['id'].'/prescription/view/'.$pres['id'])?>"><?=$pres['title'].' - '.$pres['created_at']?></a></td>
                              </tr>
                            <?php endforeach ?>   
                          <?php else: ?>
                              <tr>
                                <td>No Prescriptions Found!</td>
                              </tr>                         
                          <?php endif ?>
                        </tbody>
                     </table><!-- /.striped bordered -->
                   </div><!-- /.col s12 -->
                 </div><!-- /.row -->

                 <div class="row">
                  <div class="col s12">
                    <div class="card">
                      <div class="card-content">
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

                      </div><!-- /.card-content -->
                    </div><!-- /.card -->
                  </div><!-- /.col s12 -->
                </div><!-- /.row -->
               </div><!-- /.col s12 l4 -->


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



     <!-- //////////////////////////////////////////////////////////////////////////// -->

    <?php $this->load->view('inc/footer'); ?>

    <?php $this->load->view('inc/js'); ?>
    <script src="<?=base_url('assets/ckeditor/ckeditor.js')?>"></script>
    
   
</body>
</html>