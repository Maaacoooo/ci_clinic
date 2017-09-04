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
            
            <?php if($passwordverify): ?>
            <div class="row">
              <div class="col s12">
                <div class="card red darken-4">
                  <div class="card-content white-text">
                    <span class="card-title">Update your Password!</span>
                    <p>Welcome to <?=$site_title?> System!</p>
                    <p>We have detected that your current account doesn't have an updated password. </p>
                    <p>To help you protected, please update your account password.</p>
                  </div><!-- /.card-content white-text -->
                  <div class="card-action">
                    <div class="row">
                      <div class="col s12">
                        <div class="right">
                          <a href="<?=base_url('settings/profile')?>">Update Password</a>
                        </div><!-- /.right -->
                      </div><!-- /.col s12 -->
                    </div><!-- /.row -->
                  </div><!-- /.card-action -->
                </div><!-- /.card red darken-4 -->
              </div><!-- /.col s12 -->
            </div><!-- /.row -->
           <?php endif; ?>


           <div class="row">
             <div class="col s12">
             <?php if ($serving): ?>
                <div class="card light-green lighten-5">
                 <div class="card-content">
                   <div class="row">                       
                     <div class="col s10">
                        <?php foreach ($serving as $serv): ?>
                          <h5 class="badge-label green darken-3 left">Now Serving</h5> 
                          <h5> <?=$serv['patient']?> - Case #<?=prettyID($serv['case_id']) . ' - ' . $serv['case_title']?> 
                            <small><a href="<?=base_url('patients/view/'.$serv['patient_id'].'/case/'.$serv['case_id'])?>">[ CHECKOUT ] >>></a></small>
                          </h5>                          
                        <?php endforeach ?>
                     </div><!-- /.col s8 -->
                     <div class="col s2">
                       <a href="#" class="btn blue waves-effect disabled">NEXT QUEUE</a>
                     </div><!-- /.col s4 -->
                   </div><!-- /.row -->
                 </div><!-- /.card-content -->
               </div><!-- /.card -->
             <?php else: ?>  
               <div class="card grey lighten-1">
                 <div class="card-content">
                    <div class="row">
                      <div class="col s10">
                        <h5 class="badge-label grey darken-4 left">Not Serving</h5> <h5 class="header">You are currently not serving any queues</h5>                        
                      </div><!-- /.col s10 -->
                      <div class="col s2">
                       <a href="<?=base_url('queues/next_queue')?>" class="btn blue waves-effect">NEXT QUEUE</a>
                     </div><!-- /.col s4 -->
                    </div><!-- /.row -->
                 </div><!-- /.card-content -->
               </div><!-- /.card -->
             <?php endif ?>               
             </div><!-- /.col s12 -->
           </div><!-- /.row -->



           <div class="row">
             <div class="col s12">
               <div class="card">
                 <div class="card-content">                 
                 <?php if ($queue): ?>
                    <div class="card-panel purple darken-3 white-text">
                     <p><i class="mdi-action-info-outline tiny"></i> Before proceeding to the next queue, please clear the current serving queue by checking out the case and updating the status.</p>
                    </div><!-- /.card-panel -->
                    <table class="striped bordered">
                      <thead>
                        <tr>
                          <th>Patient Name</th>
                          <th>Case</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($queue as $q): ?>
                          <tr>
                            <td><?=$q['patient']?></td>
                            <td>#<?=prettyID($q['case_id']) . ' - ' .$q['case_title']?></td>
                            <td><a href="<?=base_url('queues/checkout/'.$q['queue_id'])?>">Check Out >>></a></td>
                          </tr>
                        <?php endforeach ?>
                      </tbody>
                    </table><!-- /.striped bordered -->
                 <?php else: ?>
                   <h5 class="header">You have No Pending Queues...</h5><!-- /.header -->                  
                 <?php endif ?>
                 </div><!-- /.card-content -->
               </div><!-- /.card -->
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