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
                    <li><a href="<?=base_url('patients/view/'.$info['id'].'/case/'.$medcert['case_id'])?>"><?=$medcert['case_title']?></a></li>
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
                   <div class="card">
                     <div class="card-content">
                       <h5 class="header">Medical Certicate #<?=prettyID($medcert['cert_id'])?></h5><!-- /.header -->
                       <p>This is to certify that <span class="strong underlined"><?php if($info['sex'])echo 'Mr.'; else echo 'Ms.'; ?> <?=$info['fullname'] . ' ' . $info['middlename'] . ' ' . $info['lastname']?></span>
                        of <span class="underlined">
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
                        ?> <br />
                        </span> has been diagnosed last <span class="strong underlined"><?=nice_date($medcert['case_date'], 'M. d, Y')?></span> of <span class="strong underlined"><?=$medcert['title']?></span>
                        <br />
                        <br />
                        <span class="strong">Remarks and Recommendations</span> <br />
                        <?=$medcert['remarks']?>
                        <br /><br />
                        <strong>Attending Physician:</strong> Dr. <?=$medcert['doctor']?> - LIC. NO. <?=$medcert['lic_no']?>
                       </p>
                     </div><!-- /.card-content -->
                   </div><!-- /.card -->
                   <small><em>Created <?=$medcert['created_at']?></em></small>
                   <a href="<?=base_url('patients/view/'.$medcert['patient_id'].'/medcert/print/'.$medcert['cert_id'])?>" class="btn-flat waves-effect light-blue white-text right" target="_blank"><i class="mdi-communication-comment left"></i> Print</a>

                 </div><!-- /.col s12 -->
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



     <!-- //////////////////////////////////////////////////////////////////////////// -->

    <?php $this->load->view('inc/footer'); ?>

    <?php $this->load->view('inc/js'); ?>
   
</body>
</html>