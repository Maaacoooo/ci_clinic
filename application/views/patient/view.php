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
              <div class="col s12 l8">
                <h5 class="header">Patient Information: <?=$title?></h5><!-- /.header -->
                <table class="striped bordered">
                  <tr>
                    <th>Lastname:</th>
                    <td width="80%"><?=$info['lastname']?></td>
                  </tr>
                  <tr>
                    <th>Fullname:</th>
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
                    <td><?=$info['birthplace']?></td>
                  </tr>
                  <tr>
                    <th>Address:</th>
                    <td><?=$info['address']?></td>
                  </tr>
                  <tr>
                    <th>Contact Number:</th>
                    <td><?=$info['contact_no']?></td>
                  </tr>
                  <tr>
                    <th>Email:</th>
                    <td><?=$info['email']?></td>
                  </tr>
                  <tr>
                    <th>Remarks:</th>
                    <td><?=$info['remarks']?></td>
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
              </div><!-- /.col s12 l8 -->
              <div class="col s12 l4">
                <div class="row">
                  <div class="col s12">
                    <div class="card">
                      <div class="card-content">
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
                      </div><!-- /.card-content -->
                    </div><!-- /.card -->
                  </div><!-- /.col s12 -->
                </div><!-- /.row -->

                <div class="row">
                  <div class="col s12">                                                 
                     <div class="card">
                       <div class="card-content">
                          <h6 class="header strong">Options</h6><!-- /.header -->
                          <table class="centered">
                            <tr>
                              <td><a href="#caseModal" class="modal-trigger btn waves-effect green">New Case<i class="mdi-av-my-library-books left"></i></a></td>
                            </tr>
                            <tr>
                              <td><a href="#UpdateModal" class="modal-trigger btn waves-effect amber">Update<i class="mdi-editor-border-color left"></i></a></td>
                            </tr>
                            <tr>
                              <td><a href="#deleteModal" class="modal-trigger btn waves-effect red">Delete<i class="mdi-action-delete left"></i></a></td>
                            </tr>
                          </table>                           
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
                     <div class="input-field col s4 l4">
                        <input type="text" name="lname" id="lname" class="validate" value="<?=$info['lastname']?>" required/>
                        <label for="lname">Last Name</label>
                     </div><!-- /.input-field col s4 l4 -->                   
                     <div class="input-field col s4 l4">
                        <input type="text" name="fname" id="fname" class="validate" value="<?=$info['fullname']?>" required/>
                        <label for="fname">Full Name</label>
                     </div><!-- /.input-field col s4 l4 -->                   
                     <div class="input-field col s4 l4">
                        <input type="text" name="mname" id="mname" class="validate" value="<?=$info['middlename']?>" required/>
                        <label for="mname">Middle Name</label>
                     </div><!-- /.input-field col s4 l4 -->
                   </div><!-- /.row -->
                   <div class="row">
                     <div class="input-field col s6">
                        <input type="text" name="bplace" id="bplace" class="validate" value="<?=$info['birthplace']?>" required/>
                        <label for="bplace">Birthplace</label>
                     </div><!-- /.input-field col s6 -->
                     <div class="input-field col s2">
                        <select class="browser-default" name="sex" id="sex" required>                          
                          <option value="1" <?php if($info['sex'])echo'selected';?>>Male</option>
                          <option value="0" <?php if(!$info['sex'])echo'selected';?>>Female</option>                       
                        </select>
                     </div><!-- /.input-field col s8 -->
                     <div class="input-field col s4">
                        <input type="date" name="bdate" id="bdate" value="<?=$info['birthdate']?>" required/>                        
                     </div><!-- /.input-field col s4 -->
                   </div><!-- /.row -->             
                   <div class="row">
                     <div class="input-field col s12">
                       <input type="text" name="addr" id="addr" class="validate" value="<?=$info['address']?>" required/>
                       <label for="addr">Present Address</label>
                     </div><!-- /.input-field col s12 -->
                   </div><!-- /.row -->
                   <div class="row">
                     <div class="input-field col s6">
                       <input type="text" name="contactno" id="contactno" class="validate" value="<?=$info['contact_no']?>" required/>
                       <label for="contactno">Contact Number</label>
                     </div><!-- /.input-field col s6 -->
                     <div class="input-field col s6">
                       <input type="text" name="email" id="email" class="validate" value="<?=$info['email']?>" required/>
                       <label for="email">Email Address</label>
                     </div><!-- /.input-field col s6 -->
                   </div><!-- /.row -->
                   <div class="row">
                     <div class="input-field col s12">
                       <textarea id="remarks" name="remarks" class="materialize-textarea" length="120"><?=$info['remarks']?></textarea>
                       <label for="remarks">Remarks</label>
                     </div><!-- /.input-field col s12 -->
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


        <!-- End Modals -->



     <!-- //////////////////////////////////////////////////////////////////////////// -->

    <?php $this->load->view('inc/footer'); ?>

    <?php $this->load->view('inc/js'); ?>
   
</body>
</html>