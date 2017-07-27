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
                      <th>Sex</th>
                      <th>Age</th>
                      <th>Address</th>
                      <th>Contact</th>
                      <th>Cases</th>
                    </tr>
                  </thead>
                  <?php if($results): ?>
                  <?php foreach($results as $row): ?>
                  <tr>
                    <td><a href="<?=base_url('patients/view/'.$row['id'])?>"><?=$row['lastname']?>, <?=$row['fullname']?> <?=$row['middlename']?></a></td>
                    <td>
                      <?php if ($row['sex'] == 0): ?>
                        <span class="badge-label pink">Female</span>     
                      <?php else: ?>
                        <span class="badge-label blue">Male</span>  
                      <?php endif ?>
                    </td>
                    <td><a href="<?=base_url('patients/view/'.$row['id'])?>"><?=$row['birthdate']?></a></td>
                    <td><a href="<?=base_url('patients/view/'.$row['id'])?>"><?=$row['address']?></a></td>
                    <td><a href="<?=base_url('patients/view/'.$row['id'])?>"><?=$row['contact_no']?></a></td>
                    <td><a href="<?=base_url('patients/view/'.$row['id'])?>"><?=$row['id']?></a></td>
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