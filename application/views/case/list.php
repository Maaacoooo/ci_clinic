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
                <table class="striped bordered highlight">
                  <thead>
                    <tr>    
                      <th>Patient Name</th>           
                      <th>Case</th>   
                      <th></th>                   
                    </tr>
                  </thead>
                  <?php if($results): ?>
                  <?php foreach($results as $row): ?>
                  <tr>
                    <td><a href="<?=base_url('patients/view/'.$row['patient_id'].'/case/'.$row['case_id'])?>"><?=$row['patient_name']?></a></td>                  
                    <td>
                      <a href="<?=base_url('patients/view/'.$row['patient_id'].'/case/'.$row['case_id'])?>">CASE #<?=prettyID($row['case_id'])?> -  <?=$row['title']?></a>
                      <?php if ($row['status'] == 3): ?>
                        <span class="badge-label grey darken-3">Cancelled</span>     
                      <?php elseif($row['status'] == 1): ?>
                        <span class="badge-label green darken-3">Served</span>                                   
                      <?php else: ?> 
                        <span class="badge-label red darken-3">Pending</span> 
                      <?php endif ?>
                    </td>
                    <td><?=$row['created_at']?></td>
                  </tr>
                  <?php endforeach; ?>
                  <?php endif; ?>
                </table><!-- /.striped bordered highlight -->
                <div class="right">
                    <?php foreach ($links as $link) { echo $link; } ?>
                </div>
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