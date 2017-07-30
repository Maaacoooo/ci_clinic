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
            
            <?=form_open('patients/create')?>
            <div class="row" id="field_newpatient">
             <div class="col s12">
               <div class="card">
                 <div class="card-content">
                   <h5 class="header">New Patient</h5><!-- /.header -->
                   <div class="row">
                     <div class="input-field col s4 l4">
                        <input type="text" name="lname" id="lname" class="validate" value="<?=set_value('lname')?>" required/>
                        <label for="lname">Last Name</label>
                     </div><!-- /.input-field col s4 l4 -->                   
                     <div class="input-field col s4 l4">
                        <input type="text" name="fname" id="fname" class="validate" value="<?=set_value('fname')?>" required/>
                        <label for="fname">Full Name</label>
                     </div><!-- /.input-field col s4 l4 -->                   
                     <div class="input-field col s4 l4">
                        <input type="text" name="mname" id="mname" class="validate" value="<?=set_value('mname')?>" required/>
                        <label for="mname">Middle Name</label>
                     </div><!-- /.input-field col s4 l4 -->
                   </div><!-- /.row -->
                   <div class="row">
                     <div class="input-field col s6">
                        <input type="text" name="bplace" id="bplace" class="validate" value="<?=set_value('bplace')?>" required/>
                        <label for="bplace">Birthplace</label>
                     </div><!-- /.input-field col s6 -->
                     <div class="input-field col s2">
                        <select class="browser-default" name="sex" id="sex" required>
                          <option value="" disabled="" selected="">Sex</option>
                          <option value="1">Male</option>
                          <option value="0">Female</option>                       
                        </select>
                     </div><!-- /.input-field col s8 -->
                     <div class="input-field col s4">
                        <input type="date" name="bdate" id="bdate" value="<?=set_value('bdate')?>" required/>                        
                     </div><!-- /.input-field col s4 -->
                   </div><!-- /.row -->             
                   <div class="row">
                     <div class="input-field col s12">
                       <input type="text" name="addr" id="addr" class="validate" value="<?=set_value('addr')?>" required/>
                       <label for="addr">Present Address</label>
                     </div><!-- /.input-field col s12 -->
                   </div><!-- /.row -->
                   <div class="row">
                     <div class="input-field col s6">
                       <input type="text" name="contactno" id="contactno" class="validate" value="<?=set_value('contactno')?>" required/>
                       <label for="contactno">Contact Number</label>
                     </div><!-- /.input-field col s6 -->
                     <div class="input-field col s6">
                       <input type="text" name="email" id="email" class="validate" value="<?=set_value('email')?>" required/>
                       <label for="email">Email Address</label>
                     </div><!-- /.input-field col s6 -->
                   </div><!-- /.row -->
                   <div class="row">
                     <div class="input-field col s12">
                       <textarea id="remarks" name="remarks" class="materialize-textarea" length="120"><?=set_value('remarks')?></textarea>
                       <label for="remarks">Remarks</label>
                     </div><!-- /.input-field col s12 -->
                   </div><!-- /.row -->
                   <div class="row" id="submit_patient">
                     <div class="input-field col s12">
                        <button type="submit" class="btn waves-effect green right">Register New Patient</button>                       
                     </div><!-- /.input-field col s12 -->
                   </div><!-- /.row -->
                 </div><!-- /.card-content -->
               </div><!-- /.card -->
             </div><!-- /.col s12 -->
           </div><!-- /.row -->
           <?=form_close()?>
         
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