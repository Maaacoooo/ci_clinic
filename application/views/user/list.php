
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
        <div class="col-sm-7">
          <!-- Default box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">User List <span class="badge"><?=$total_result?></span></h3>

              <div class="box-tools pull-right">            
                <?=form_open('users', array('method' => 'get', 'class' => 'input-group input-group-sm', 'style' => 'width: 150px;'))?>
                  <input type="text" name="search" class="form-control pull-right" placeholder="Search...">
                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    <button type="button" class="btn btn-default btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                      <i class="fa fa-minus"></i>
                    </button>  
                  </div> 
                <?=form_close()?> 
              </div>
            </div>
            <div class="box-body">
              <table class="table table-condensed table-striped">            
                <?php if ($results): ?>
                <thead>
                  <tr>
                    <th width="8%"></th>
                    <th>Name</th>
                    <th>Username</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($results as $row): ?>
                    <tr>
                      <td>
                      <a href="<?=base_url('users/update/' . $row['username'])?>">
                    <?php if(filexist($row['img']) && $row['img']): ?>
                      <img src="<?=base_url('uploads/'.$row['img'])?>" alt="" class="profile-user-img img-responsive img-circle">
                    <?php else: ?>
                      <img src="<?=base_url('assets/images/no_image.gif')?>" alt="" class="profile-user-img img-responsive img-circle">
                    <?php endif; ?>
                      </a>                    
                      </td>                          
                      <td><a href="<?=base_url('users/update/' . $row['username'])?>"><?=$row['name']?></a></td>                                  
                      <td><?=$row['username']?></td>
                      <td><?=$row['usertype']?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>              
                <?php else: ?>  
                <?php endif ?>            
              </table><!-- /.table table-bordered -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <div class="pull-right">
                <?php foreach ($links as $link) { echo $link; } ?>
              </div><!-- /.pull-right -->
            </div>
            <!-- /.box-footer-->
          </div>
          <!-- /.box -->
        </div><!-- /.col-sm-7 -->

        <div class="col-sm-5">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Register User</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-sm-12">
                  <div class="callout callout-info">
                    <h4><i class="fa fa-info-circle"></i> Information!</h4>
                     <p>Every new user that is registered, a default password is set.
                     The default password is <b class="text-navy">ClinicUser</b>.</p> <br />
                     <p>Please advise your New User to change his password after logging in.</p>
                  </div>
                </div><!-- /.col-sm-12 -->
                <?=form_open_multipart('users')?>
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="username">Username</label>
                      <input type="text" name="username" class="form-control" id="username" placeholder="Username..." value="<?=set_value('username')?>" required>
                    </div>
                  </div><!-- /.col-sm-12 -->
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="name">Full Name</label>
                      <input type="text" name="name" class="form-control" id="name" placeholder="Full Name..." value="<?=set_value('name')?>" required>
                    </div>
                  </div><!-- /.col-sm-12 -->
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="img">Profile Image</label>
                      <input type="file" name="img" class="form-control" id="img"/>
                    </div>
                  </div><!-- /.col-sm-12 -->
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="usertype">Usertype</label>
                      <select name="usertype" class="form-control" id="usertype" required>
                        <option value="" disabled="" selected="">Select Usertype...</option>
                      <?php if ($usertypes): ?>
                      <?php foreach ($usertypes AS $usr): ?>
                        <option value="<?=$usr['title']?>"><?=$usr['title']?></option>
                      <?php endforeach ?>
                      <?php endif ?>
                      </select>
                    </div>
                  </div><!-- /.col-sm-12 -->
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="lic">License No.</label>
                      <input type="text" name="lic" class="form-control" id="lic" placeholder="License No..." value="<?=set_value('lic')?>"/>
                    </div>
                  </div><!-- /.col-sm-12 -->
                  <div class="col-sm-12">
                    <div class="form-group pull-right">
                      <button type="submit" class="btn btn-info"><i class="fa fa-send"></i> Submit</button>
                    </div>
                  </div><!-- /.col-sm-12 -->
                <?=form_close()?>
              </div><!-- /.row -->
            </div><!-- /.box-body -->
          </div><!-- /.box box-primary -->
        </div><!-- /.col-sm-5 -->

      </div><!-- /.row -->

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
