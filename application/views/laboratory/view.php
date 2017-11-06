
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
        <li><a href="<?=base_url('patients/view/'.$info['id'])?>"><?=$info['fullname'] . ' ' . $info['lastname']?></a></li>
        <li><a href="<?=base_url('patients/view/'.$info['id'].'/case/'.$case['id'])?>"><?=$case['title']?></a></li>
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

      <!-- Default box -->
    <div class="row">
      <div class="col-sm-8">
        <div class="box default-box">
          <div class="box-body">
            <div class="row">
              <div class="col-sm-12">
                <table class="table table-condensed table-striped">            
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
                      <span class="label bg-grey">Cancelled</span>     
                  <?php elseif($labreq['status'] == 1): ?>
                      <span class="label bg-green">Served</span>                                   
                  <?php else: ?> 
                      <span class="label bg-maroon">Pending</span> 
                  <?php endif ?>
                    </td>
                  </tr>
                  <tr>
                    <th>Requested by</th>
                    <td><?=$labreq['user']?></td>
                  </tr>
                  <tr>
                    <th>Request Description / Remarks</th>
                    <td><a href="#updateRemarks" data-toggle="modal">[Update]</a></td>
                  </tr>
                  <tr>
                    <td colspan="2"><?=$labreq['description']?></td>
                  </tr>
                  <tr>
                    <th colspan="2">Result and Files</th>
                  </tr>
                  <tr>
                    <td colspan="2">
                  <?php if ($lab_files): ?>
                      <ul>
                    <?php foreach ($lab_files as $file): ?>
                        <li class="removeBullet">
                          <a href="#file<?=$file['id']?>" data-toggle="modal"><?=$file['title']?> - <?=$file['user']?></a>
                    <?php if ($file['user'] == $user['username']): ?>
                          <a href="#Delfile<?=$file['id']?>" data-toggle="modal" class="text-red"><i class="fa fa-remove"></i></a>
                    <?php endif ?>
                         </li>
                    <?php endforeach ?>
                      </ul>
                    <?php else: ?>
                      No existing Results and Files.
                     <?php endif ?>
                   </td>
                  </tr>
                </table><!-- /.table table-bordered -->
                <hr />
                <small><em>Created at <?=$labreq['created_at']?></em></small>
              <?php if ($labreq['updated_at']): ?>
                <small class="pull-right"><em>Last updated <?=$labreq['updated_at']?></em></small>                 
              <?php endif ?>
              <hr />
              <?php if ($lab_report && $labreq['is_constant']): ?>
              <?php if (!$lab_report['status']): ?>
              <table class="table table-striped table-bordered">
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
                        <input type="text" name="report_no" class="form-control" placeholder="Actual Authenticated Report No. ..." value="<?=$labreq['report_no']?>" />                           
                      </td>
                    </tr>
                    <tr>
                      <th>Medical Technician</th>
                      <td colspan="2">
                        <input type="text" name="medtech" class="form-control" placeholder="Fullname, Suffix - LIC No. ..." value="<?=$labreq['medtech']?>" />                           
                      </td>
                    </tr>
                    <tr>
                      <th>Pathologist</th>
                      <td colspan="2">
                        <input type="text" name="patho" class="form-control" placeholder="Fullname, Suffix - LIC No. ..." value="<?=$labreq['pathologist']?>" />                           
                      </td>
                    </tr>
                    <tr>
                      <th>Specimen</th>
                      <td colspan="2">
                        <input type="text" name="specimen" class="form-control" placeholder="Specimen..." value="<?=$labreq['specimen']?>" />                           
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
                  <?php if (!$rep['exam_cat']): ?>
                  <?php foreach ($rep['exams'] as $ex): ?>
                    <tr>
                      <td><?=$ex['title']?></td>
                       <td><?=$ex['normal_values']?></td>
                       <td>
                         <input type="text" name="value[]" class="input-table browser-default" placeholder="<?=$ex['title']?>..." value="<?=$ex['value']?>" />  
                         <input type="hidden" name="val_id[]" value="<?=$this->encryption->encrypt($ex['id'])?>" />
                         <input type="hidden" name="exam_id[]" value="<?=$this->encryption->encrypt($ex['exam_id'])?>" />
                       </td>
                    </tr>                             
                  <?php endforeach ?>
                  <?php else: ?>
                    <tr>
                      <th colspan="3"><?=$rep['exam_cat']?></th>
                    </tr>
                    <?php foreach ($rep['exams'] as $ex): ?>
                    <tr>
                      <td><?=$ex['title']?></td>
                      <td><?=$ex['normal_values']?></td>
                      <td>
                        <input type="text" name="value[]" class="input-table browser-default" placeholder="<?=$ex['title']?>..." value="<?=$ex['value']?>" />  
                        <input type="hidden" name="val_id[]" value="<?=$this->encryption->encrypt($ex['id'])?>" />
                        <input type="hidden" name="exam_id[]" value="<?=$this->encryption->encrypt($ex['exam_id'])?>" />
                      </td>
                    </tr>
                  <?php endforeach ?>
                  <?php endif ?>
                       
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
              </table><!-- /.table table-bordered table-striped -->
              <?php else: ?>
              <table class="table table-bordered table-striped">
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
                      <th>Medical technician</th>
                      <td colspan="2"><?=$labreq['medtech']?></td>
                    </tr>
                    <tr>
                      <th>Pathologist</th>
                      <td colspan="2"><?=$labreq['pathologist']?></td>
                    </tr>
                    <tr>
                      <th>Specimen</th>
                      <td colspan="2"><?=$labreq['specimen']?></td>
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
                    <?php if (!$rep['exam_cat']): ?>
                    <?php foreach ($rep['exams'] as $ex): ?>
                    <tr>
                      <td><?=$ex['title']?></td>
                      <td><?=$ex['normal_values']?></td>
                      <td><?=$ex['value']?></td>
                    </tr>
                    <?php endforeach ?>
                    <?php else: ?>
                    <tr>
                      <th colspan="3"><?=$rep['exam_cat']?></th>
                    </tr>
                    <?php foreach ($rep['exams'] as $ex): ?>
                    <tr>
                      <td><?=$ex['title']?></td>
                      <td><?=$ex['normal_values']?></td>
                      <td><?=$ex['value']?></td>
                    </tr>
                    <?php endforeach ?>
                    <?php endif ?>                         
                  <?php endforeach ?>   
                  </tbody>
                <?=form_close()?>
              </table><!-- /.table table-bordered table-striped -->
              <?php endif ?>
              <?php endif ?>
              </div><!-- /.col-sm-8 -->
            </div><!-- /.row -->
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div><!-- /.col-sm-8 -->
      <div class="col-sm-4">
        <!-- Options -->
        <div class="box default-box">
          <div class="box-header with-border">
            <h3 class="box-title">Options</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="form-group">
              <a href="<?=current_url()?>/print" target="_blank" class="btn btn-primary form-control"><i class="fa fa-print"></i> Print Request</a> 
            </div>
            <div class="form-group">
              <a href="#resultModal" class="btn btn-primary form-control" data-toggle="modal">Attach Result File</a>
            </div>
          <?php if (!$labreq['status']): ?>
            <div class="form-group">
              <a href="#changeStatus" class="btn btn-warning form-control" data-toggle="modal">Change Status</a>
            </div>
          <?php endif ?>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div><!-- /.col-sm-4 -->
    </div><!-- /.row -->

    <!-- UpdateDescription Modal -->
    <div class="modal fade" id="updateRemarks">
      <div class="modal-dialog">
        <?=form_open('laboratory/update')?>
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Update Description</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12">
                  <label for="description">Description</label>
                  <textarea name="description" id="description" cols="30" rows="10" class="ckeditor" required=""><?=$labreq['description']?></textarea>
                </div><!-- /.col-sm-12 -->
              </div><!-- /.row -->
            <input type="hidden" name="id" value="<?=$this->encryption->encrypt($labreq['labreq_id'])?>" />
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Update</button>
            </div>
          </div>
          <!-- /.modal-content -->
        <?=form_close()?>
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- UpdateFile Modal -->
    <?php if ($lab_files): ?>
    <?php foreach ($lab_files as $file): ?>
    <?php if ($file['user'] == $user['username']): ?>
    <div class="modal fade" id="file<?=$file['id']?>">
      <div class="modal-dialog">
        <?=form_open_multipart('laboratory/update_result')?>
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Update Laboratory Result</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" id="title" value="<?=$file['title']?>" required>
                  </div>
                </div><!-- /.col-sm-12 -->
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" cols="30" rows="10" class="ckeditor"><?=$file['description']?></textarea>
                  </div>
                </div><!-- /.col-sm-12 -->      
                <div class="col-sm-12">
                  <p>Updating the file will remove the existing file.</p>
                    <div class="form-group">
                      <label for="file">File</label>
                      <input type="file" name="file" class="form-control" id="file"/>
                    </div>
                  <a href="<?=base_url('laboratory/download/'.$file['id'])?>""><i class="fa fa-download"></i> <?=$file['link']?></a> 
                </div><!-- /.col-sm-12 -->     
              </div><!-- /.row -->
            <input type="hidden" name="id" value="<?=$this->encryption->encrypt($file['id'])?>" />
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Update Result</button>
            </div>
          </div>
          <!-- /.modal-content -->
        <?=form_close()?>
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- DeleteFile -->
    <div class="modal modal-danger fade" id="Delfile<?=$file['id']?>">
      <div class="modal-dialog">
        <?=form_open('laboratory/delete_result')?>
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Delete Laboratory Result</h4>
            </div>
            <div class="modal-body">
              <p>Are you sure to delete this Laboratory Result?</p>
              <p>You <b>CANNOT UNDO</b> this action.</p>
              <input type="hidden" name="id" value="<?=$this->encryption->encrypt($file['id'])?>" />
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-outline">Delete Result</button>
            </div>
          </div>
          <!-- /.modal-content -->
        <?=form_close()?>
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->   
    <?php else: ?> 
    <div class="modal fade" id="modal-default">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><?=$file['title']?></h4>
          </div>
          <div class="modal-body">
            <p><?=$file['description']?> </p>
            <hr />
            <h5>Download Attached Laboratory Result</h5>
            <a href="<?=base_url('laboratory/download/'.$file['id'])?>""><i class="fa fa-download"></i> <?=$file['link']?></a>   
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <?php endif ?>               
    <?php endforeach ?>  
    <?php endif ?>

    <!-- Attach Laboratory Result Modal-->
    <div class="modal fade" id="resultModal">
      <div class="modal-dialog">
        <?=form_open_multipart('laboratory/attach_result')?>
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Attach Laboratory Result</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" id="title" value="Result of <?=$title?>" required/>
                  </div>
                </div><!-- /.col-sm-12 -->
                <div class="col-sm-12">
                  <div class="form-group">
                    <textarea name="description" cols="30" rows="10" class="ckeditor" required=""></textarea>
                  </div>
                </div><!-- /.col-sm-12 -->
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="file">File</label>
                    <input type="file" name="file" id="file" class="form-control" placeholder=".gif, .jpg, .png, .pdf, .doc, .docx, .xls, .xlsx, .txt, .tiff only" />
                  </div>
                </div><!-- /.col-sm-12 -->
              </div><!-- /.row -->
              <input type="hidden" name="id" value="<?=$this->encryption->encrypt($labreq['labreq_id'])?>" />
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Submit Result</button>
            </div>
          </div>
          <!-- /.modal-content -->
        <?=form_close()?>
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- ChangeStatus Modal -->
    <?php if (!$labreq['status']): ?>
    <div class="modal fade" id="changeStatus">
      <div class="modal-dialog">
        <?=form_open('laboratory/change_status')?>
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Change Status</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-6">
                  <p><i class="fa fa-info-circle"></i> Once the Laboratory Request is set to <span class="label bg-green">served</span>, 
                  the system will automatically add this Service to the current Open Billing Record. </p> 
                  <p>These actions cannot be undone.</p>
                </div><!-- /.col-sm-6 -->
                <div class="col-sm-6">
                  <p>This changes the status of the Laboratory Request.</p> 
                    <input name="status" type="radio" id="pending" onclick="queues()" value="<?=$this->encryption->encrypt(0)?>" <?php if ($info['status'] == 0)echo'checked';?>>
                    <label for="pending">Pending</label>
                    <input name="status" type="radio" id="served" onclick="queues()" value="<?=$this->encryption->encrypt(1)?>" <?php if ($info['status'] == 1)echo'checked';?>>
                    <label for="served">Served</label>
                    <input name="status" type="radio" id="cancel" onclick="queues()" value="<?=$this->encryption->encrypt(3)?>" <?php if ($info['status'] == 3)echo'checked';?>>
                    <label for="cancel">Cancelled</label>
                </div><!-- /.col-sm-6 -->
              </div><!-- /.row -->
            </div><!-- /.modal-body -->
            <div class="modal-footer">
                <input type="hidden" name="id" value="<?=$this->encryption->encrypt($labreq['labreq_id'])?>" />
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-warning">Change</button>
            </div>
          </div>
          <!-- /.modal-content -->
        <?=form_close()?>
      </div>
      <!-- /.modal-dialog -->
    </div>
    <?php endif ?>
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
<!-- CKEDITOR -->
<script src="<?=base_url('assets/ckeditor/ckeditor.js')?>"></script>

</body>
</html>
