
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
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?=base_url('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')?>">
  <!-- daterange picker -->
  <link rel="stylesheet" href="<?=base_url('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css')?>">
   
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
        <li><a href="#">Administrative Options</a></li>
        <li><a href="<?=base_url('users/')?>">Users</a></li>
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

      <div class="row">
        <div class="col-md-3">
          <!-- Default box -->
          <div class="box box-primary">
            <div class="box-body box-profile">
            <?php if (filexist($info['img']) && $info['img']): ?>
              <img class="profile-user-img img-responsive img-circle" src="<?=base_url('uploads/'.$info['img'])?>" alt="User profile picture">
            <?php else: ?>
              <img class="profile-user-img img-responsive img-circle" src="<?=base_url('assets/images/no_image.gif')?>" alt="User profile picture">
            <?php endif ?>
              <h3 class="profile-username text-center"><?=$info['name']?></h3>

              <p class="text-muted text-center"><?=$info['usertype']?></p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Username</b> <a class="pull-right"><?=$info['username']?></a>
                </li>
                <li class="list-group-item">
                  <b>License No.</b> <a class="pull-right"><?=$info['lic_no']?></a>
                </li>
              </ul>
            </div>
            <!-- /.box-body box-profile -->
          </div>
          <!-- /.box -->          
        </div><!-- /.col-md-3 -->

        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li <?php if(!($flash_error || $flash_success || $flash_valid))echo'class="active"'?>><a href="#activity" data-toggle="tab">Activity Logs</a></li>
              <li <?php if($flash_error || $flash_success || $flash_valid)echo'class="active"'?>><a href="#settings" data-toggle="tab">Settings</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane <?php if(!($flash_error || $flash_success || $flash_valid))echo'active'?>" id="activity">
                <!-- The activity -->
                <h4 class="title">Last 50 Activity</h4>
                <?php if ($logs): ?>
                <table class="table table-condensed">
                  <thead>
                    <tr>
                      <th>Tag</th>
                      <th width="10%">Tag ID</th>
                      <th>Action</th>
                      <th width="20%">Date Time</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($logs AS $log): ?>
                    <tr>
                      <td><?=$log['tag']?></td>
                      <td><?=$log['tag_id']?></td>
                      <td><?=$log['action']?></td>
                      <td><?=$log['date_time']?></td>
                    </tr>
                  <?php endforeach ?>
                  </tbody>
                </table><!-- /.table table-condensed -->
                <?php else: ?>
                <div class="alert alert-warning">               
                  <h4><i class="icon fa fa-warning"></i> No records found!</h4>         
                  No Activity Logs record found in the system
                </div>
                <?php endif ?>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane <?php if($flash_error || $flash_success || $flash_valid)echo'active'?>" id="settings">
                <?=form_open_multipart('users/update/' . $info['username'], array('class' => 'form-horizontal'))?>
                  <div class="form-group">
                    <label for="fullname" class="col-sm-2 control-label">Full Name</label>

                    <div class="col-sm-10">
                      <input type="text" name="name" class="form-control" id="fullname" placeholder="Full Name..." value="<?=$info['name']?>" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="lic_no" class="col-sm-2 control-label">License No.</label>

                    <div class="col-sm-10">
                      <input type="text" name="lic" class="form-control" id="lic_no" placeholder="License No..." value="<?=$info['lic_no']?>" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="img" class="col-sm-2 control-label">Profile Image</label>

                    <div class="col-sm-10">
                      <input type="file" name="img" class="form-control" id="img"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="usertype" class="col-sm-2 control-label">Usertype</label>

                    <div class="col-sm-10">
                      <select name="usertype" class="form-control" id="usertype">
                        <option value="" disabled="" selected="">Select Usertype...</option>
                      <?php if ($usertypes): ?>
                      <?php foreach ($usertypes AS $usr): ?>
                        <option value="<?=$usr['title']?>" <?php if ($info['usertype'] == $usr['title']) { echo 'selected'; } ?>><?=$usr['title']?></option>
                      <?php endforeach ?>
                      <?php endif ?>
                      </select>
                    </div>
                  </div>
                  <input type="hidden" name="id" value="<?=$this->encryption->encrypt($info['username'])?>" />
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <div class="btn-group">
                         <a href="#resetModal" data-toggle="modal" class="btn btn-primary">Reset Password</a>
                      <?php if (!($user['username'] == $info['username'])): ?>
                        <a href="#deleteModal" data-toggle="modal" class="btn btn-danger">Delete</a>
                      <?php endif ?>
                      </div><!-- /.btn-group -->
                      <button type="submit" class="btn btn-warning pull-right">Update</button>
                    </div><!-- /.col-sm-offset-2 col-sm-10 -->
                  </div>
                <?=form_close()?>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col-md-9 -->

      </div><!-- /.row -->

      <!-- Reset Password Modal -->
      <div class="modal modal-info fade" id="resetModal">
        <div class="modal-dialog">
          <?=form_open('users/resetpassword')?>
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Reset Password: <?=$info['name']?></h4>
              </div>
              <div class="modal-body">
                <p>Are you sure to reset to DEFAULT PASSWORD?</p>
                <p>You <b class="text-red">CANNOT UNDO</b> this action.</p>
                <p>The Default Password is <b class="text-green">ClinicUser</b></p>
                <input type="hidden" name="id" value="<?=$this->encryption->encrypt($info['username'])?>" />
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline">Reset</button>
              </div>
            </div>
            <!-- /.modal-content -->
          <?=form_close()?>
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <!-- Delete User Modal -->
      <?php if(!($user['username'] == $info['username'])): ?>
      <div class="modal modal-danger fade" id="deleteModal">
        <div class="modal-dialog">
          <?=form_open('users/delete')?>
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Delete User: <?=$info['name']?></h4>
              </div>
              <div class="modal-body">
                <p>Are you sure to delete the record of <b><?=$info['name']?></b>?</p>
                <p>You <b>CANNOT UNDO</b> this action.</p>
                <input type="hidden" name="id" value="<?=$this->encryption->encrypt($info['username'])?>" />
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline">Delete</button>
              </div>
            </div>
            <!-- /.modal-content -->
          <?=form_close()?>
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
      <?php endif; ?>

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

</body>
</html>
