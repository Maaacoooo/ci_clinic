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
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Patient List <span class="badge"><?=$total_result?></span></h3>
          <div class="box-tools pull-right">            
            <?=form_open('patients', array('method' => 'get', 'class' => 'input-group input-group-sm', 'style' => 'width: 150px;'))?>
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
                <th>Patient Name</th>
                <th>Sex</th>
                <th>Age</th>
                <th>Address</th>
                <th>Cases</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($results as $row): ?>
                <tr>
                  <td><a href="<?=base_url('patients/view/'.$row['id'])?>"><?=$row['lastname']?>, <?=$row['fullname']?> <?=$row['middlename']?></a></td>
                  <td>
                  <?php if ($row['sex'] == 0): ?>
                    <span class="label bg-maroon">Female</span>     
                  <?php else: ?>
                    <span class="label bg-blue">Male</span>  
                  <?php endif ?>                    
                  </td>
                  <td><a href="<?=base_url('patients/view/'.$row['id'])?>"><?=getAge($row['birthdate'], time())?></a></td>
                  <td><a href="<?=base_url('patients/view/'.$row['id'])?>"><?=$row['address']?></a></td>
                  <td><a href="<?=base_url('patients/view/'.$row['id'])?>"><?=$row['cases']?></a></td>
                </tr>
              <?php endforeach; ?>
            </tbody>              
            <?php endif; ?>              
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


