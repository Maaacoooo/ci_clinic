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
                <h5 class="breadcrumbs-title"><?=$title?></h5>
                <ol class="breadcrumb">
                    <li><a href="<?=base_url()?>">Dashboard</a></li>
                    <li><a href="<?=base_url('patients')?>">Patients</a></li>
                    <li><a href="<?=base_url('patients/view/'.$info['id'])?>"><?=$info['fullname'] . ' ' . $info['lastname']?></a></li>
                    <li><a href="<?=base_url('patients/view/'.$info['id'].'/case/'.$case['id'])?>"><?=$case['title']?></a></li>
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
                 <table class="striped bordered">
                   <tr>
                     <th>Patient Name</th>
                     <td><?=$info['fullname'] . ' ' . $info['lastname']?></td>
                   </tr>
                   <tr>
                     <th>Requested Service</th>
                     <td><?=$labreq['service']?></td>
                   </tr>
                   <tr>
                     <th>Status</th>
                     <td>
                       <?php if ($labreq['status'] == 3): ?>
                         <span class="badge-label grey darken-3">Cancelled</span>     
                       <?php elseif($labreq['status'] == 1): ?>
                         <span class="badge-label green darken-3">Served</span>                                   
                       <?php else: ?> 
                         <span class="badge-label red darken-3">Pending</span> 
                       <?php endif ?>
                     </td>
                   </tr>
                   <tr>
                     <th>Requested by</th>
                     <td><?=$labreq['user']?></td>
                   </tr>
                   <tr>
                     <th>Request Description / Remarks</th>
                     <td><a href="#updateRemarks" class="modal-trigger">[Update]</a></td>
                   </tr>
                   <tr>
                     <td colspan="2"><?=$labreq['description']?></td>
                   </tr>
                   <tr>
                     <th colspan="2">Results and Files</th>
                   </tr>
                   <tr>
                     <td colspan="2">
                       <?php if ($lab_files): ?>
                       <ul>
                         <?php foreach ($lab_files as $file): ?>
                           <li>
                              <a href="#file<?=$file['id']?>" class="modal-trigger"><?=$file['title']?> - <?=$file['user']?></a>
                              <?php if ($file['user'] == $user['username']): ?>
                                <a href="#Delfile<?=$file['id']?>" class="modal-trigger red-text"><i class="mdi-action-highlight-remove tiny"></i></a>                                
                              <?php endif ?>
                           </li>
                         <?php endforeach ?>
                       </ul>
                       <?php else: ?>
                         No existing Results and Files.
                       <?php endif ?>
                     </td>
                   </tr>
                 </table><!-- /.striped bordered -->
                 <small><em>Created at <?=$labreq['created_at']?></em></small>
                 <?php if ($labreq['updated_at']): ?>
                 <small class="right"><em>Last updated <?=$labreq['updated_at']?></em></small>                 
                 <?php endif ?>

                 <hr />
                 <?php if ($lab_report): ?>
                   <?php if (!$labreq['status']): ?>
                    <table class="table-report">
                     <?=form_open('laboratory/update_report')?>
                     <thead>
                       <tr>
                         <th colspan="3"><?=$labreq['service']?> Report</th>
                       </tr>
                     </thead>
                     <tbody>
                       <tr>
                         <th>Authenticated Report No.</th>
                         <td colspan="2">
                            <input type="text" name="report_no" class="input-table browser-default" placeholder="Actual Authenticated Report No. ..." value="<?=$labreq['report_no']?>" />                           
                         </td>
                       </tr>
                       <tr>
                         <th>Medical Technician</th>
                         <td colspan="2">
                            <input type="text" name="medtech" class="input-table browser-default" placeholder="Fullname, Suffix - LIC No. ..." value="<?=$labreq['medtech']?>" />                           
                         </td>
                       </tr>
                       <tr>
                         <th>Pathologist</th>
                         <td colspan="2">
                            <input type="text" name="patho" class="input-table browser-default" placeholder="Fullname, Suffix - LIC No. ..." value="<?=$labreq['pathologist']?>" />                           
                         </td>
                       </tr>
                       <tr>
                         <td colspan="3"></td>
                       </tr>
                       <tr>
                         <th width="40%" class="center">EXAMINATIONS</th>
                         <th width="35%" class="center">NORMAL VALUES</th>
                         <th class="center">RESULT</th>
                       </tr>                     
                       <?php foreach ($lab_report as $rep): ?>
                         <tr>
                           <td><?=$rep['title']?></td>
                           <td><?=$rep['normal_values']?></td>
                           <td>
                             <input type="text" name="value[]" class="input-table browser-default" placeholder="<?=$rep['title']?>..." value="<?=$rep['value']?>" />  
                             <input type="hidden" name="val_id[]" value="<?=$this->encryption->encrypt($rep['id'])?>" />
                             <input type="hidden" name="exam_id[]" value="<?=$this->encryption->encrypt($rep['exam_id'])?>" />
                           </td>
                         </tr>
                       <?php endforeach ?>                     
                     </tbody>
                     <input type="hidden" name="id" value="<?=$this->encryption->encrypt($labreq['labreq_id'])?>" />
                     <tfoot>
                       <tr>
                         <td colspan="3">
                           <button type="submit" class="btn right">Update Report</button>
                         </td>
                       </tr>
                     </tfoot>
                     <?=form_close()?>
                   </table>
                   <?php else: ?>  
                    <table class="table-report">
                     <?=form_open('laboratory/update_report')?>
                     <thead>
                       <tr>
                         <th colspan="3"><?=$labreq['service']?> Report</th>
                       </tr>
                     </thead>
                     <tbody>
                       <tr>
                         <th>Authenticated Report No.</th>
                         <td colspan="2"><?=$labreq['report_no']?></td>
                       </tr>
                       <tr>
                         <th>Medical Technician</th>
                         <td colspan="2"><?=$labreq['medtech']?></td>
                       </tr>
                       <tr>
                         <th>Pathologist</th>
                         <td colspan="2"><?=$labreq['pathologist']?></td>
                       </tr>
                       <tr>
                         <td colspan="3"></td>
                       </tr>
                       <tr>
                         <th width="40%" class="center">EXAMINATIONS</th>
                         <th width="35%" class="center">NORMAL VALUES</th>
                         <th class="center">RESULT</th>
                       </tr>                     
                       <?php foreach ($lab_report as $rep): ?>
                         <tr>
                           <td><?=$rep['title']?></td>
                           <td><?=$rep['normal_values']?></td>
                           <td> <?=$rep['value']?></td>
                         </tr>
                       <?php endforeach ?>                     
                     </tbody>
                   </table>
                 <?php endif ?>
                 <?php endif ?>
               </div><!-- /.col s12 l8 -->
               <div class="col s12 l4">
                 <div class="card">
                   <div class="card-content">
                     <h6 class="strong header">Options</h6><!-- /.strong header -->
                     <br />     
                     <div class="row">
                       <a href="#resultModal" class="modal-trigger btn waves-effect light-blue col s8 offset-s2">Attach Result File</a>   
                     </div><!-- /.row -->
                     <br />  
                     <?php if (!$labreq['status']): ?>
                     <div class="row">
                       <a href="#changeStatus" class="modal-trigger btn waves-effect amber col s8 offset-s2">Change Status</a>   
                     </div><!-- /.row -->    
                     <?php endif ?>
                   </div><!-- /.card-content -->
                 </div><!-- /.card -->
               </div><!-- /.col s12 l4 -->
             </div><!-- /.row --> 


            <?php if ($lab_files): ?>
            <?php foreach ($lab_files as $file): ?>
              <?php if ($file['user'] == $user['username']): ?>
              <div id="file<?=$file['id']?>" class="modal modal-fixed-footer">
               <?=form_open_multipart('laboratory/update_result')?>
                <div class="modal-content">
                    <h5 class="header">Update Laboratory Result</h5><!-- /.header -->
                    <div class="row">
                      <div class="col s12 input-field">
                        <input type="text" name="title" id="title" class="validate" required="" value="<?=$file['title']?>" />
                        <label for="title">Title</label>
                      </div><!-- /.col s12 input-field -->
                      <div class="col s12">
                        <label>Description</label>
                        <textarea name="description" id="description" cols="30" rows="10" class="ckeditor"><?=$file['description']?></textarea>
                      </div><!-- /.col s12 -->
                      <div class="input-field col s12">
                      Updating the file will remove the existing file.
                           <div class="file-field input-field">
                            <div class="btn">
                              <span>FILE</span>
                              <input type="file" name="file">
                            </div>
                            <div class="file-path-wrapper">
                              <input class="file-path validate" type="text" placeholder=".gif, .jpg, .png, .pdf, .doc, .docx, .xls, .xlsx, .txt, .tiff only">
                            </div>
                          </div>                          
                          <a href="<?=base_url('laboratory/download/'.$file['id'])?>""><i class="mdi-file-attachment tiny"></i> <?=$file['link']?></a>  
                       </div><!-- /.input-field col s12 -->
                    </div><!-- /.row -->
                    <input type="hidden" name="id" value="<?=$this->encryption->encrypt($file['id'])?>" />
                  </div>
                  <div class="modal-footer grey darken-4">
                    <a href="#" class="waves-effect waves-red btn-flat red-text strong modal-action modal-close">Cancel</a>
                    <button type="submit" class="waves-effect waves-blue btn light-blue modal-action">Update Result</button>
                  </div>
               <?=form_close()?>
              </div>  


              <div id="Delfile<?=$file['id']?>" class="modal">
               <?=form_open('laboratory/delete_result')?>
                <div class="modal-content">
                    <h5 class="header">Delete Laboratory Result</h5><!-- /.header -->
                    <p>Are you sure to delete this Laboratory Result? </p>
                    <p>You <span class="strong">CANNOT UNDO</span> this action.</p>
                    <input type="hidden" name="id" value="<?=$this->encryption->encrypt($file['id'])?>" />
                  </div>
                  <div class="modal-footer grey darken-4">
                    <a href="#" class="waves-effect waves-red btn-flat amber-text strong modal-action modal-close">Cancel</a>
                    <button type="submit" class="waves-effect waves-red btn red modal-action">Delete Result</button>
                  </div>
               <?=form_close()?>
              </div>  
              <?php else: ?>
              <div id="file<?=$file['id']?>" class="modal">
                  <div class="modal-content">
                    <h5 class="header"><?=$file['title']?></h5><!-- /.header strong --> 
                    <?=$file['description']?> 

                    <h6 class="header strong">Download Attached Laboratory Result</h6><!-- /.header strong -->  
                    <a href="<?=base_url('laboratory/download/'.$file['id'])?>""><i class="mdi-file-attachment tiny"></i> <?=$file['link']?></a>                
                  </div>
                  <div class="modal-footer grey darken-4">
                    <a href="#" class="waves-effect waves-red btn-flat red-text strong modal-action modal-close">Close</a>
                  </div>
              </div>  
              <?php endif ?>               
            <?php endforeach ?>  
            <?php endif ?>


             <?php if (!$labreq['status']): ?>
             <div id="changeStatus" class="modal">
              <?=form_open('laboratory/change_status')?>
                <div class="modal-content">
                    <div class="row">
                      <h5 class="header">Change Status</h5><!-- /.header -->
                      <div class="col s6">                         
                         <p><i class="mdi-action-info-outline tiny"></i> Once the Laboratory Request is set to <span class="badge-label green darken-3">served</span>, 
                         the system will automatically add this Service to the current Open Billing Record. </p> 
                         <p>These actions cannot be undone.</p>
                      </div><!-- /.col s12 -->  
                      <div class="col s6">
                        <p>This changes the status of the Laboratory Request.</p>                       
                         <input name="status" type="radio" id="pending" onclick="queues()" value="<?=$this->encryption->encrypt(0)?>" class="with-gap" <?php if ($case['status'] == 0)echo'checked';?>>
                         <label for="pending">Pending</label>
                         <input name="status" type="radio" id="served" onclick="queues()" value="<?=$this->encryption->encrypt(1)?>" class="with-gap" <?php if ($case['status'] == 1)echo'checked';?>>
                         <label for="served">Served</label>
                         <input name="status" type="radio" id="cancel" onclick="queues()" value="<?=$this->encryption->encrypt(3)?>" class="with-gap" <?php if ($case['status'] == 3)echo'checked';?>>
                         <label for="cancel">Cancelled</label>
                      </div><!-- /.col s6 -->                    
                    </div><!-- /.row -->
                    <input type="hidden" name="id" value="<?=$this->encryption->encrypt($labreq['labreq_id'])?>" />
                  </div>
                  <div class="modal-footer grey darken-4">
                    <a href="#" class="waves-effect waves-red btn-flat red-text strong modal-action modal-close">Cancel</a>
                    <button type="submit" class="waves-effect waves-red btn amber modal-action">Change</button>
                  </div>
              <?=form_close()?>
            </div>
             <?php endif ?>


            <div id="resultModal" class="modal">
              <?=form_open_multipart('laboratory/attach_result')?>
                <div class="modal-content">
                    <h5 class="header">Attach Laboratory Result</h5><!-- /.header -->
                    <div class="row">
                      <div class="col s12 input-field">
                        <input type="text" name="title" id="title" class="validate" required="" value="Result of <?=$title?>" />
                        <label for="title">Title</label>
                      </div><!-- /.col s12 input-field -->
                      <div class="col s12">
                        <label>Description</label>
                        <textarea name="description" id="description" cols="30" rows="10" class="ckeditor"></textarea>
                      </div><!-- /.col s12 -->
                      <div class="input-field col s12">
                           <div class="file-field input-field">
                            <div class="btn">
                              <span>FILE</span>
                              <input type="file" name="file">
                            </div>
                            <div class="file-path-wrapper">
                              <input class="file-path validate" type="text" placeholder=".gif, .jpg, .png, .pdf, .doc, .docx, .xls, .xlsx, .txt, .tiff only">
                            </div>
                          </div>
                       </div><!-- /.input-field col s12 -->
                    </div><!-- /.row -->
                    <input type="hidden" name="id" value="<?=$this->encryption->encrypt($labreq['labreq_id'])?>" />
                  </div>
                  <div class="modal-footer grey darken-4">
                    <a href="#" class="waves-effect waves-red btn-flat red-text strong modal-action modal-close">Cancel</a>
                    <button type="submit" class="waves-effect waves-blue btn light-blue modal-action">Submit Result</button>
                  </div>
              <?=form_close()?>
            </div>

            <div id="updateRemarks" class="modal">
              <?=form_open('laboratory/update')?>
                <div class="modal-content">
                    <h5 class="header">Update Description</h5><!-- /.header -->
                    <div class="row">
                      <div class="col s12">
                        <label>Description</label>
                        <textarea name="description" id="description" cols="30" rows="10" class="ckeditor"><?=$labreq['description']?></textarea>
                      </div><!-- /.col s12 -->                     
                    </div><!-- /.row -->
                    <input type="hidden" name="id" value="<?=$this->encryption->encrypt($labreq['labreq_id'])?>" />
                  </div>
                  <div class="modal-footer grey darken-4">
                    <a href="#" class="waves-effect waves-red btn-flat red-text strong modal-action modal-close">Cancel</a>
                    <button type="submit" class="waves-effect waves-amber btn amber modal-action">Update</button>
                  </div>
              <?=form_close()?>
            </div>
         
          </div>
        </div>
        <!--end container-->
      </section>
      <!-- END CONTENT -->

    </div>
    <!-- END WRAPPER -->

  </div>
  <!-- END MAIN -->



     <!-- //////////////////////////////////////////////////////////////////////////// -->

    <?php $this->load->view('inc/footer'); ?>

    <?php $this->load->view('inc/js'); ?>
    <script src="<?=base_url('assets/ckeditor/ckeditor.js')?>"></script>

</body>
</html>

