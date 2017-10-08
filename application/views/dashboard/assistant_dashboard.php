<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <title><?=$title?> &middot; <?=$site_title?></title>

    <?php $this->load->view('inc/css'); ?>
    <link href="<?php echo base_url();?>assets/css/jquery-ui.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/jquery-ui.theme.min.css" rel="stylesheet">

    <script type="text/javascript">
      function enablenewpatient() {
        if(document.getElementById("newpatient").checked == true) {
          document.getElementById("field_newpatient").setAttribute("class", "row");
          document.getElementById("submit_case").setAttribute("class", "row hide");
          document.getElementById("patient_id").disabled = true;

          document.getElementById("lname").disabled = false;
          document.getElementById("fname").disabled = false;
          document.getElementById("mname").disabled = false;
          document.getElementById("sex").disabled = false;
          document.getElementById("bdate").disabled = false;
          document.getElementById("contactno").disabled = false;
          document.getElementById("email").disabled = false;

          document.getElementById("addr_bldg").disabled = false;
          document.getElementById("addr_strt").disabled = false;
          document.getElementById("addr_brgy").disabled = false;
          document.getElementById("addr_city").disabled = false;
          document.getElementById("addr_prov").disabled = false;
          document.getElementById("addr_zip").disabled = false;
          document.getElementById("addr_country").disabled = false;

          document.getElementById("bplace_bldg").disabled = false;
          document.getElementById("bplace_strt").disabled = false;
          document.getElementById("bplace_brgy").disabled = false;
          document.getElementById("bplace_city").disabled = false;
          document.getElementById("bplace_prov").disabled = false;
          document.getElementById("bplace_zip").disabled = false;
          document.getElementById("bplace_country").disabled = false;


        } else {
          document.getElementById("field_newpatient").setAttribute("class", "row hide");     
          document.getElementById("submit_case").setAttribute("class", "row");           
          document.getElementById("patient_id").disabled = false;         

          document.getElementById("lname").disabled = true;
          document.getElementById("fname").disabled = true;
          document.getElementById("mname").disabled = true;
          document.getElementById("sex").disabled = true;
          document.getElementById("bdate").disabled = true;
          document.getElementById("contactno").disabled = true;
          document.getElementById("email").disabled = true;


          document.getElementById("addr_bldg").disabled = true;
          document.getElementById("addr_strt").disabled = true;
          document.getElementById("addr_brgy").disabled = true;
          document.getElementById("addr_city").disabled = true;
          document.getElementById("addr_prov").disabled = true;
          document.getElementById("addr_zip").disabled = true;
          document.getElementById("addr_country").disabled = true;

          document.getElementById("bplace_bldg").disabled = true;
          document.getElementById("bplace_strt").disabled = true;
          document.getElementById("bplace_brgy").disabled = true;
          document.getElementById("bplace_city").disabled = true;
          document.getElementById("bplace_prov").disabled = true;
          document.getElementById("bplace_zip").disabled = true;
          document.getElementById("bplace_country").disabled = true;
        }


      }


      function sameAdd() {
        //get data 
        var bplace_bldg = document.getElementById("bplace_bldg").value;
        var bplace_strt = document.getElementById("bplace_strt").value;
        var bplace_brgy = document.getElementById("bplace_brgy").value;
        var bplace_city = document.getElementById("bplace_city").value;
        var bplace_prov = document.getElementById("bplace_prov").value;
        var bplace_zip = document.getElementById("bplace_zip").value;
        var bplace_country = document.getElementById("bplace_country").value;

        var checkbx = document.getElementById("checkAdd").checked;

        if(checkbx == true) {
          document.getElementById("addr_bldg").value = bplace_bldg;
          document.getElementById("addr_strt").value = bplace_strt;
          document.getElementById("addr_brgy").value = bplace_brgy;
          document.getElementById("addr_city").value = bplace_city;
          document.getElementById("addr_prov").value = bplace_prov;
          document.getElementById("addr_zip").value = bplace_zip;
          document.getElementById("addr_country").value = bplace_country;

          document.getElementById("lbl_addr_bldg").className = "active";
          document.getElementById("lbl_addr_strt").className = "active";
          document.getElementById("lbl_addr_brgy").className = "active";
          document.getElementById("lbl_addr_city").className = "active";
          document.getElementById("lbl_addr_prov").className = "active";
          document.getElementById("lbl_addr_zip").className = "active";
          document.getElementById("lbl_addr_country").className = "active";

        } else {
          document.getElementById("addr_bldg").value = "";
          document.getElementById("addr_strt").value = "";
          document.getElementById("addr_brgy").value = "";
          document.getElementById("addr_city").value = "";
          document.getElementById("addr_prov").value = "";
          document.getElementById("addr_zip").value = "";
          document.getElementById("addr_country").value = "Philippines";

          document.getElementById("lbl_addr_bldg").className = "";
          document.getElementById("lbl_addr_strt").className = "";
          document.getElementById("lbl_addr_brgy").className = "";
          document.getElementById("lbl_addr_city").className = "";
          document.getElementById("lbl_addr_prov").className = "";
          document.getElementById("lbl_addr_zip").className = "";
        }
      }
    </script>

</head>

<body onload="enablenewpatient()">
    
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
           
           <?=form_open_multipart('dashboard')?>
           <div class="row">
             <div class="col s12">
               <div class="card">
                 <div class="card-content">
                   <h5 class="header">New Case</h5>
                   <div class="row">
                     <div class="input-field col s6 l10">
                       <input type="text" name="patient_id" id="patient_id" class="validate" value="<?=set_value('patient_id')?>" required/>
                       <label for="">Patient</label>
                     </div><!-- /.input-field col s6 l10 -->
                     <div class="input-field col s6 l2">                  
                        <input type="checkbox" id="newpatient" name="newpatient" onclick="enablenewpatient()" <?php if(set_value('newpatient'))echo'checked';?>>
                        <label for="newpatient">New Patient</label>                      
                     </div><!-- /.input-field col s6 l2 -->
                   </div><!-- /.row -->
                   <div class="row">
                     <div class="input-field col s6">
                        <input type="number" name="weight" id="weight" class="validate" value="<?=set_value('weight')?>" required/>
                        <label for="weight">Weight (kg)</label>
                      </div><!-- /.input-field col s6 -->
                     <div class="input-field col s6">
                        <input type="number" name="height" id="height" class="validate" value="<?=set_value('height')?>" required/>
                        <label for="height">Height (cm)</label>
                      </div><!-- /.input-field col s6 -->
                   </div><!-- /.row -->
                   <div class="row">
                     <div class="input-field col s12">
                       <input type="text" name="title" id="title" class="validate" value="<?=set_value('title')?>" required/>
                       <label for="title">Case Title</label>
                     </div><!-- /.input-field col s12 -->
                   </div><!-- /.row -->
                   <div class="row">
                         <div class="input-field col s12">
                           <div class="file-field input-field">
                            <div class="btn">
                              <span>IMG</span>
                              <input type="file" name="img">
                            </div>
                            <div class="file-path-wrapper">
                              <input class="file-path validate" type="text">
                            </div>
                          </div>
                  </div><!-- /.input-field col s12 l3 -->
                  </div><!-- /.row -->
                   <div class="row">
                     <div class="col s12">
                        <p>Case Description</p> <br />
                        <textarea name="description" id="" class="ckeditor"><?=set_value('description')?></textarea>                       
                     </div><!-- /.col-s12 -->
                   </div><!-- /.row -->
                   <div class="row" id="submit_case">
                     <div class="input-field col s12">
                          <div class="right">
                            <div class="col">
                              <input type="checkbox" id="generateQueue" name="generateQueue" <?php if(set_value('generateQueue'))echo'checked';?>>
                              <label for="generateQueue">Generate Queue</label> 
                            </div><!-- /.col -->
                            <div class="col">
                              <button type="submit" class="btn waves-effect amber">Submit Case</button>                            
                            </div><!-- /.col -->
                          </div><!-- /.right -->   
                     </div><!-- /.input-field col s12 -->    

                   </div><!-- /.row -->
                 </div><!-- /.card-content -->
               </div><!-- /.card -->
             </div><!-- /.col s12 -->
           </div><!-- /.row -->

           <div class="row hide" id="field_newpatient">
             <div class="col s12">
               <div class="card">
                 <div class="card-content">
                   <h5 class="header">New Patient</h5><!-- /.header -->
                   <div class="row">
                     <div class="input-field col s4 l4">
                        <input type="text" name="lname" id="lname" class="validate" value="<?=set_value('lname')?>" required disabled/>
                        <label for="lname">Last Name</label>
                     </div><!-- /.input-field col s4 l4 -->                   
                     <div class="input-field col s4 l4">
                        <input type="text" name="fname" id="fname" class="validate" value="<?=set_value('fname')?>" required disabled/>
                        <label for="fname">First Name</label>
                     </div><!-- /.input-field col s4 l4 -->                   
                     <div class="input-field col s4 l4">
                        <input type="text" name="mname" id="mname" class="validate" value="<?=set_value('mname')?>" required disabled/>
                        <label for="mname">Middle Name</label>
                     </div><!-- /.input-field col s4 l4 -->
                   </div><!-- /.row -->
                   <div class="row">
                     <div class="input-field col s5">
                        <small>Sex</small>
                        <select class="browser-default" name="sex" id="sex" required disabled>
                          <option value="" disabled="" selected="">Sex</option>
                          <option value="1">Male</option>
                          <option value="0">Female</option>                       
                        </select>
                     </div><!-- /.input-field col s8 -->
                     <div class="input-field col s7">
                        <small>Birthdate</small>
                        <input type="date" name="bdate" id="bdate" value="<?=set_value('bdate')?>" required disabled/>                        
                     </div><!-- /.input-field col s4 -->
                   </div><!-- /.row -->            
                   <div class="row">                     
                     <fieldset class="blue lighten-5">
                        <legend class="strong">Birthplace</legend>
                          <div class="input-field col s12 l5">
                           <input type="text" name="bplace_bldg" id="bplace_bldg" class="validate" value="<?=set_value('bplace_bldg')?>" disabled />
                           <label for="bplace_bldg">Building / Block / House</label>
                         </div><!-- /.input-field col s12 -->
                         <div class="input-field col s12 l4">
                           <input type="text" name="bplace_strt" id="bplace_strt" class="validate" value="<?=set_value('bplace_strt')?>" disabled />
                           <label for="bplace_strt">Street</label>
                         </div><!-- /.input-field col s12 -->
                         <div class="input-field col s12 l3">
                           <input type="text" name="bplace_brgy" id="bplace_brgy" class="validate" value="<?=set_value('bplace_brgy')?>" disabled />
                           <label for="bplace_brgy">Barangay</label>
                         </div><!-- /.input-field col s12 -->
                         <div class="input-field col s12 l3">
                           <input type="text" name="bplace_city" id="bplace_city" class="validate" value="<?=set_value('bplace_city')?>" required disabled/>
                           <label for="bplace_city">City / Municipality</label>
                         </div><!-- /.input-field col s12 -->
                         <div class="input-field col s12 l3">
                           <input type="text" name="bplace_prov" id="bplace_prov" class="validate" value="<?=set_value('bplace_prov')?>" required disabled/>
                           <label for="bplace_prov">Province / Region</label>
                         </div><!-- /.input-field col s12 -->
                         <div class="input-field col s12 l2">
                           <input type="text" name="bplace_zip" id="bplace_zip" class="validate" value="<?=set_value('bplace_zip')?>" required disabled/>
                           <label for="bplace_zip">ZIP Code</label>
                         </div><!-- /.input-field col s12 -->
                         <div class="input-field col s12 l4">
                           <input type="text" name="bplace_country" id="bplace_country" class="validate" value="<?php if(set_value('bplace_country'))echo set_value('bplace_country'); else echo 'Philippines';?>" required disabled/>
                           <label for="bplace_country">Country</label>
                         </div><!-- /.input-field col s12 -->
                     </fieldset>
                   </div><!-- /.row -->         
                   <div class="row">
                          <div class="col s12">
                            <div class="checkbox right">
                              <input type="checkbox" id="checkAdd" onclick="sameAdd()">
                              <label for="checkAdd">Present Address same with Birthplace</label>  
                            </div><!-- /.checkbox -->
                          </div><!-- /.col s12 -->
                    </div><!-- /.row -->     
                   <div class="row">                     
                     <fieldset class=" green lighten-5">
                        <legend class="strong">Present Address</legend>
                          <div class="input-field col s12 l5">
                           <input type="text" name="addr_bldg" id="addr_bldg" class="validate" value="<?=set_value('addr_bldg')?>" required disabled/>
                           <label for="addr_bldg" id="lbl_addr_bldg">Building / Block / House</label>
                         </div><!-- /.input-field col s12 -->
                         <div class="input-field col s12 l4">
                           <input type="text" name="addr_strt" id="addr_strt" class="validate" value="<?=set_value('addr_strt')?>" required disabled/>
                           <label for="addr_strt" id="lbl_addr_strt">Street</label>
                         </div><!-- /.input-field col s12 -->
                         <div class="input-field col s12 l3">
                           <input type="text" name="addr_brgy" id="addr_brgy" class="validate" value="<?=set_value('addr_brgy')?>" required disabled/>
                           <label for="addr_brgy" id="lbl_addr_brgy">Barangay</label>
                         </div><!-- /.input-field col s12 -->
                         <div class="input-field col s12 l3">
                           <input type="text" name="addr_city" id="addr_city" class="validate" value="<?=set_value('addr_city')?>" required disabled/>
                           <label for="addr_city" id="lbl_addr_city">City / Municipality</label>
                         </div><!-- /.input-field col s12 -->
                         <div class="input-field col s12 l3">
                           <input type="text" name="addr_prov" id="addr_prov" class="validate" value="<?=set_value('addr_prov')?>" required disabled/>
                           <label for="addr_prov" id="lbl_addr_prov">Province / Region</label>
                         </div><!-- /.input-field col s12 -->
                         <div class="input-field col s12 l2">
                           <input type="text" name="addr_zip" id="addr_zip" class="validate" value="<?=set_value('addr_zip')?>" required disabled/>
                           <label for="addr_zip" id="lbl_addr_zip">ZIP Code</label>
                         </div><!-- /.input-field col s12 -->
                         <div class="input-field col s12 l4">
                           <input type="text" name="addr_country" id="addr_country" class="validate" value="<?php if(set_value('addr_country'))echo set_value('addr_country'); else echo 'Philippines';?>" required disabled/>
                           <label for="addr_country" id="lbl_addr_country">Country</label>
                         </div><!-- /.input-field col s12 -->
                     </fieldset>
                   </div><!-- /.row -->
                   <div class="row">
                     <div class="input-field col s6">
                       <input type="text" name="contactno" id="contactno" class="validate" value="<?=set_value('contactno')?>" required disabled/>
                       <label for="contactno">Contact Number</label>
                     </div><!-- /.input-field col s6 -->
                     <div class="input-field col s6">
                       <input type="text" name="email" id="email" class="validate" value="<?=set_value('email')?>" required disabled/>
                       <label for="email">Email Address</label>
                     </div><!-- /.input-field col s6 -->
                   </div><!-- /.row -->    
                   <div class="row" id="submit_patient">
                     <div class="input-field col s12">
                          <div class="right">
                            <div class="col">
                              <input type="checkbox" id="generateQueues" name="generateQueue" <?php if(set_value('generateQueue'))echo'checked';?>>
                              <label for="generateQueues">Generate Queue</label> 
                            </div><!-- /.col -->
                            <div class="col">
                              <button type="submit" class="btn waves-effect green right">Register New Patient & Submit Case</button>                      
                            </div><!-- /.col -->
                          </div><!-- /.right -->
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

    <script type="text/javascript" src="<?=base_url('assets/ckeditor/ckeditor.js')?>"></script>  
    <?php $this->load->view('inc/footer'); ?>

    <?php $this->load->view('inc/js'); ?>
    <script src="<?php echo base_url();?>assets/js/jquery-ui.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
    
    <script type="text/javascript">
      $(function(){
      $("#patient_id").autocomplete({    
        source: "<?php echo base_url('index.php/dashboard/autocomplete');?>" // path to the get_birds method
      });
    });
    </script>
   
</body>
</html>