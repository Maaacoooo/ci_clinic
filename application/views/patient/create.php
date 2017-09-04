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
                        <label for="fname">First Name</label>
                     </div><!-- /.input-field col s4 l4 -->                   
                     <div class="input-field col s4 l4">
                        <input type="text" name="mname" id="mname" class="validate" value="<?=set_value('mname')?>" required/>
                        <label for="mname">Middle Name</label>
                     </div><!-- /.input-field col s4 l4 -->
                   </div><!-- /.row -->
                   <div class="row">                     
                     <div class="input-field col s4">
                        <select class="browser-default" name="sex" id="sex" required>
                          <option value="" disabled="" selected="">Sex</option>
                          <option value="1">Male</option>
                          <option value="0">Female</option>                       
                        </select>
                     </div><!-- /.input-field col s8 -->
                     <div class="input-field col s4">
                        <small>Birthdate</small>
                        <input type="date" name="bdate" id="bdate" value="<?=set_value('bdate')?>" required/>    
                     </div><!-- /.input-field col s4 -->
                   </div><!-- /.row -->   
                   <div class="row">                     
                     <fieldset class="blue lighten-5">
                        <legend class="strong">Birthplace</legend>
                          <div class="input-field col s12 l5">
                           <input type="text" name="bplace_bldg" id="bplace_bldg" class="validate" value="<?=set_value('bplace_bldg')?>" />
                           <label for="bplace_bldg">Building / Block / House</label>
                         </div><!-- /.input-field col s12 -->
                         <div class="input-field col s12 l4">
                           <input type="text" name="bplace_strt" id="bplace_strt" class="validate" value="<?=set_value('bplace_strt')?>" />
                           <label for="bplace_strt">Street</label>
                         </div><!-- /.input-field col s12 -->
                         <div class="input-field col s12 l3">
                           <input type="text" name="bplace_brgy" id="bplace_brgy" class="validate" value="<?=set_value('bplace_brgy')?>" />
                           <label for="bplace_brgy">Barangay</label>
                         </div><!-- /.input-field col s12 -->
                         <div class="input-field col s12 l3">
                           <input type="text" name="bplace_city" id="bplace_city" class="validate" value="<?=set_value('bplace_city')?>" required/>
                           <label for="bplace_city">City / Municipality</label>
                         </div><!-- /.input-field col s12 -->
                         <div class="input-field col s12 l3">
                           <input type="text" name="bplace_prov" id="bplace_prov" class="validate" value="<?=set_value('bplace_prov')?>" required/>
                           <label for="bplace_prov">Province / Region</label>
                         </div><!-- /.input-field col s12 -->
                         <div class="input-field col s12 l2">
                           <input type="text" name="bplace_zip" id="bplace_zip" class="validate" value="<?=set_value('bplace_zip')?>" required/>
                           <label for="bplace_zip">ZIP Code</label>
                         </div><!-- /.input-field col s12 -->
                         <div class="input-field col s12 l4">
                           <input type="text" name="bplace_country" id="bplace_country" class="validate" value="<?php if(set_value('bplace_country'))echo set_value('bplace_country'); else echo 'Philippines';?>" required/>
                           <label for="bplace_country">Country</label>
                         </div><!-- /.input-field col s12 -->
                     </fieldset>
                   </div><!-- /.row -->          
                   <div class="row">                     
                     <fieldset class=" green lighten-5">
                        <legend class="strong">Present Address</legend>
                          <div class="input-field col s12 l5">
                           <input type="text" name="addr_bldg" id="addr_bldg" class="validate" value="<?=set_value('addr_bldg')?>" required/>
                           <label for="addr_bldg">Building / Block / House</label>
                         </div><!-- /.input-field col s12 -->
                         <div class="input-field col s12 l4">
                           <input type="text" name="addr_strt" id="addr_strt" class="validate" value="<?=set_value('addr_strt')?>" required/>
                           <label for="addr_strt">Street</label>
                         </div><!-- /.input-field col s12 -->
                         <div class="input-field col s12 l3">
                           <input type="text" name="addr_brgy" id="addr_brgy" class="validate" value="<?=set_value('addr_brgy')?>" required/>
                           <label for="addr_brgy">Barangay</label>
                         </div><!-- /.input-field col s12 -->
                         <div class="input-field col s12 l3">
                           <input type="text" name="addr_city" id="addr_city" class="validate" value="<?=set_value('addr_city')?>" required/>
                           <label for="addr_city">City / Municipality</label>
                         </div><!-- /.input-field col s12 -->
                         <div class="input-field col s12 l3">
                           <input type="text" name="addr_prov" id="addr_prov" class="validate" value="<?=set_value('addr_prov')?>" required/>
                           <label for="addr_prov">Province / Region</label>
                         </div><!-- /.input-field col s12 -->
                         <div class="input-field col s12 l2">
                           <input type="text" name="addr_zip" id="addr_zip" class="validate" value="<?=set_value('addr_zip')?>" required/>
                           <label for="addr_zip">ZIP Code</label>
                         </div><!-- /.input-field col s12 -->
                         <div class="input-field col s12 l4">
                           <input type="text" name="addr_country" id="addr_country" class="validate" value="<?php if(set_value('addr_country'))echo set_value('addr_country'); else echo 'Philippines';?>" required/>
                           <label for="addr_country">Country</label>
                         </div><!-- /.input-field col s12 -->
                     </fieldset>
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
                   </div><!-- /.row -->>
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