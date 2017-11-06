
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?=$title?> &middot; <?=$site_title?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <?php $this->load->view('inc/css')?>
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
        <li><a href="<?=base_url('patients/view/'.$info['id'].'/case/'.$medcert['case_id'])?>"><?=$medcert['case_title']?></a></li>
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
      <div class="box default-box">
        <div class="box-body">
          <h3 class="box-title">Medical Certificate #<?=prettyID($medcert['cert_id'])?></h3>
          <hr />
          <p>This is to certify that <u><?php if($info['sex'])echo 'Mr.'; else echo 'Ms.'; ?> <?=$info['fullname'] . ' ' . $info['middlename'] . ' ' . $info['lastname']?></u>
             of <u>
              <?php 
            if ($addr['building']) {
                echo $addr['building'] . ', ';
            } 
            if ($addr['street']) { 
                echo $addr['street'] . ', ';
            }
            if ($addr['barangay']) {
                echo $addr['barangay'] . ', ';
            }
            if ($addr['city']) {
                echo $addr['city'] . ', ';
            }
            if ($addr['province']) {
                echo $addr['province'] . ', ';
            }
            if ($addr['zip']) {
                echo $addr['zip'] . ', ';
            }
            if ($addr['country']) {
                echo $addr['country'];
            }
              ?>
            <br />
            </u> has been diagnosed last <u><?=nice_date($medcert['case_date'], 'M. d, Y')?></u> of <u><?=$medcert['title']?></u>
            <br />
            <br />
            <span class="lead">Remarks and Recommendations</span>
            <br />
            <?=$medcert['remarks']?>
            <br />
            <br />
            <strong>Attending Physician:</strong> Dr. <?=$medcert['doctor']?> - LIC. NO. <?=$medcert['lic_no']?>
          </p>
          
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
        <small><em>Created <?=$medcert['created_at']?></em></small>
          <div class="pull-right">
          <a href="<?=base_url('patients/view/'.$medcert['patient_id'].'/medcert/print/'.$medcert['cert_id'])?>" class="btn btn-info" target="_blank"><i class="fa fa-print"></i> Print</a>
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
