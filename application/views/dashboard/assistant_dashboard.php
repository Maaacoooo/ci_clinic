
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
  <!-- iCheck -->
  <link rel="stylesheet" href="<?=base_url('assets/plugins/iCheck/square/blue.css')?>">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?=base_url('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')?>">
  <!-- -->
  <link rel="stylesheet" href="<?=base_url('assets/custom/css/jquery-ui.min.css')?>">


  <script type="text/javascript">
    function enablenewpatient() {
      if(document.getElementById("addPatient").checked == true) {
          document.getElementById("lname").disabled = false;
          document.getElementById("fname").disabled = false;
          document.getElementById("mname").disabled = false;
          document.getElementById("sex").disabled = false;
          document.getElementById("datepicker").disabled = false;
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
          document.getElementById("lname").disabled = true;
          document.getElementById("fname").disabled = true;
          document.getElementById("mname").disabled = true;
          document.getElementById("sex").disabled = true;
          document.getElementById("datepicker").disabled = true;
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

    function copyToPresentAddress() {
      // get data
      var bplace_bldg = document.getElementById("bplace_bldg").value;
      var bplace_strt = document.getElementById("bplace_strt").value;
      var bplace_brgy = document.getElementById("bplace_brgy").value;
      var bplace_city = document.getElementById("bplace_city").value;
      var bplace_prov = document.getElementById("bplace_prov").value;
      var bplace_zip = document.getElementById("bplace_zip").value;
      var bplace_country = document.getElementById("bplace_country").value;

      var checkbx = document.getElementById("checkAdd").checked;

      if(checkbx  == true) {

        document.getElementById("addr_bldg").value = bplace_bldg;
        document.getElementById("addr_strt").value = bplace_strt;
        document.getElementById("addr_brgy").value = bplace_brgy;
        document.getElementById("addr_city").value = bplace_city;
        document.getElementById("addr_prov").value = bplace_prov;
        document.getElementById("addr_zip").value = bplace_zip;
        document.getElementById("addr_country").value = bplace_country;

      } else {
        document.getElementById("addr_bldg").value = "";
        document.getElementById("addr_strt").value = "";
        document.getElementById("addr_brgy").value = "";
        document.getElementById("addr_city").value = "";
        document.getElementById("addr_prov").value = "";
        document.getElementById("addr_zip").value = "";
        document.getElementById("addr_country").value = "Philippines";

      }
    }
  </script>
</head>
<body class="hold-transition skin-black sidebar-mini" onload="enablenewpatient()">
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

    <?php if($passwordverify): ?>
      <div class="callout callout-danger">
        <h4><i class="fa fa-warning"></i> Update your Password!</h4>
        <p>Welcome to <?=$site_title?> System!</p>
        <p>We have detected that your current account doesn't have an updated password. </p>
        <p>To help you protected, please update your account password. <a href="<?=base_url('settings/profile')?>">Update Password</a></p>
      </div>
    <?php endif ?>

      <!-- New Case box -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">New Case</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>      
          </div>
        </div>
        <div class="box-body">
          <?=form_open_multipart('dashboard')?>
            <div class="row">
              <div class="col-sm-12">
                <div class="col-sm-10">
                  <div class="form-group">
                    <label for="patient_id">Patient</label>
                    <input type="text" name="patient_id" class="form-control" id="patient_id" placeholder="Patient..." value="<?=set_value('patient_id')?>" required/>
                  </div>
                </div><!-- /.col-sm-10 -->
                <div class="col-sm-2">
                  <div class="form-group">
                    <div class="checkbox">
                      <label for="addPatient">
                        <input type="checkbox" name="newpatient" id="addPatient" onclick="enablenewpatient()" <?php if(set_value('newpatient'))echo'checked';?>> New Patient
                      </label>
                    </div>
                  </div>
                </div><!-- /.col-sm-2 -->
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="weight">Weight(kg)</label>
                    <input type="text" name="weight" class="form-control" id="weight" placeholder="Weight(kg)..." value="<?=set_value('weight')?>" required/>
                  </div>
                </div><!-- /.col-sm-6 -->
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="height">Height(cm)</label>
                    <input type="text" name="height" class="form-control" id="height" placeholder="Height(cm)..." value="<?=set_value('weight')?>" required/>
                  </div>
                </div><!-- /.col-sm-6 -->
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="title">Case Title</label>
                    <input type="text" name="title" class="form-control" id="title" placeholder="Case Title..." value="<?=set_value('title')?>" required/>
                  </div>
                </div><!-- /.col-sm-12 -->
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="profile_image">Profile Image</label>
                    <input type="file" class="form-control" id="profile_image"/>
                  </div>
                </div><!-- /.col-sm-12 -->
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="profile_image">Case Description</label>
                      <textarea name="description" id="editor1" rows="10" cols="80" placeholder="Place some text here..."><?=set_value('description')?></textarea>
                  </div>
                </div><!-- /.col-sm-12 -->
                <div class="col-sm-12" id="submit_case">
                  <div class="form-group pull-right">
                    <div class="icheck">
                      <label for="generateQueue">
                        <input type="checkbox" name="generateQueue" id="generateQueue" <?php if(set_value('generateQueue'))echo'checked';?>> Generate Queue
                      </label>
                      <button type="submit" class="btn btn-success" id="btnCase">Submit Case</button>
                    </div>
                  </div>
                </div><!-- /.col-sm-12 -->
              </div><!-- /.col-sm-12 -->
            </div><!--  /.row -->
          <?=form_close()?>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

      <!-- New Case box -->
      <div class="box box-default" id="field_newpatient" hidden>
        <div class="box-header with-border">
          <h3 class="box-title">New Patient</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>      
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-sm-12">

              <div class="col-sm-4">
                <div class="form-group">
                  <label for="lname">Last Name</label>
                  <input type="text" name="lname" class="form-control" id="lname" placeholder="Last Name..." value="<?=set_value('lname')?>" required disabled/>
                </div>
              </div><!-- /.col-sm-4 -->
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="fname">First Name</label>
                  <input type="text" name="fname" class="form-control" id="fname" placeholder="First Name..." value="<?=set_value('fname')?>" required disabled/>
                </div>
              </div><!-- /.col-sm-4 -->
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="mname">Middle Name</label>
                  <input type="text" name="mname" class="form-control" id="mname" placeholder="Middle Name..." value="<?=set_value('mname')?>" required disabled/>
                </div>
              </div><!-- /.col-sm-4 -->
              <div class="col-sm-5">
                <div class="form-group">
                  <label for="sex">Sex</label>
                  <select name="sex" class="form-control" id="sex" required disabled>
                    <option value="" disabled="" selected="">Sex</option>
                    <option value="1">Male</option>
                    <option value="2">Female</option>
                  </select>
                </div>
              </div><!-- /.col-sm-4 -->
              <div class="col-sm-7">
                <div class="form-group">
                  <label for="datepicker">Birthdate</label>
                  <input type="text" name="bdate" class="form-control" id="datepicker" placeholder="Birthdate..." value="<?=set_value('bdate')?>" required disabled>
                </div>
              </div>

              <!-- Birthplace -->
              <legend class="strong">Birthplace</legend>
              <div class="col-sm-5">
                <div class="form-group">
                  <label for="bplace_bldg">Building / Block / House</label>
                  <input type="text" name="bplace_bldg" class="form-control" id="bplace_bldg" placeholder="Building / Block / House..." value="<?=set_value('bplace_bldg')?>" disabled/>
                </div>
              </div><!-- /.col-sm-5 -->
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="bplace_strt">Street</label>
                  <input type="text" name="bplace_strt" class="form-control" id="bplace_strt" placeholder="Street..." value="<?=set_value('bplace_strt')?>" disabled/>
                </div>
              </div><!-- /.col-sm-4 -->
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="bplace_brgy">Barangay</label>
                  <input type="text" name="bplace_brgy" class="form-control" id="bplace_brgy" placeholder="Barangay" value="<?=set_value('bplace_brgy')?>" disabled/>
                </div>
              </div><!-- /.col-sm-3 -->
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="bplace_city">City / Municipality</label>
                  <input type="text" name="bplace_city" class="form-control" id="bplace_city" placeholder="City / Municipality..." value="<?=set_value('bplace_city')?>" required disabled/>
                </div>
              </div><!-- /.col-sm-3 -->
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="bplace_prov">Province / Region</label>
                  <input type="text" name="bplace_prov" class="form-control" id="bplace_prov" placeholder="Province / Region..." value="<?=set_value('bplace_prov')?>" required disabled/>
                </div>
              </div><!-- /.col-sm-3 -->
              <div class="col-sm-2">
                <div class="form-group">
                  <label for="bplace_zip">Zip Code</label>
                  <input type="text" name="bplace_zip" class="form-control" id="bplace_zip" placeholder="Zip Code..." value="<?=set_value('bplace_zip')?>" required disabled/>
                </div>
              </div><!-- /.col-sm-2 -->
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="bplace_country">Country</label>
                  <input type="text" name="bplace_country" class="form-control" id="bplace_country" placeholder="Country" value="<?php if(set_value('bplace_country'))echo set_value('bplace_country'); else echo 'Philippines';?>" required disabled/>
                </div>
              </div><!-- /.col-sm-4 -->
           
              <!-- Present Address -->
              <legend class="strong">Present Address
                <div class="pull-right">
                  <label for="checkAdd">
                    <input type="checkbox" id="checkAdd" onclick="copyToPresentAddress()"> <check-label>Present Address same with Birthplace</check-label>
                  </label>
                </div>   
              </legend>
              <div class="col-sm-5">
                <div class="form-group">
                  <label for="addr_bldg">Building / Block / House</label>
                  <input type="text" name="addr_bldg" class="form-control" id="addr_bldg" placeholder="Building / Block / House..." value="<?=set_value('addr_bldg')?>" required disabled/>
                </div>
              </div><!-- /.col-sm-5 -->
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="addr_strt">Street</label>
                  <input type="text" name="addr_strt" class="form-control" id="addr_strt" placeholder="Street..." value="<?=set_value('addr_strt')?>" required disabled/>
                </div>
              </div><!-- /.col-sm-4 -->
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="addr_brgy">Barangay</label>
                  <input type="text" name="addr_brgy" class="form-control" id="addr_brgy" placeholder="Barangay..." value="<?=set_value('addr_brgy')?>" required disabled/>
                </div>
              </div><!-- /.col-sm-3 -->
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="addr_city">City / Municipality</label>
                  <input type="text" name="addr_city" class="form-control" id="addr_city" placeholder="City / Municipality..." value="<?=set_value('addr_city')?>" required disabled/>
                </div>
              </div><!-- /.col-sm-3 -->
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="addr_prov">Province / Region</label>
                  <input type="text" name="addr_prov" class="form-control" id="addr_prov" placeholder="Province / Region..." value="<?=set_value('addr_prov')?>" required disabled/>
                </div>
              </div><!-- /.col-sm-3 -->
              <div class="col-sm-2">
                <div class="form-group">
                  <label for="addr_zip">Zip Code</label>
                  <input type="text" name="addr_zip" class="form-control" id="addr_zip" placeholder="Zip Code..." value="<?=set_value('addr_zip')?>" required disabled/>
                </div>
              </div><!-- /.col-sm-2 -->
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="addr_country">Country</label>
                  <input type="text" name="addr_country" class="form-control" id="addr_country" placeholder="Country" value="<?php if(set_value('addr_country'))echo set_value('addr_country'); else echo 'Philippines';?>" required disabled/>
                </div>
              </div><!-- /.col-sm-4 -->
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="contactno">Contact Number</label>
                  <input type="text" class="form-control" id="contactno" placeholder="Contact Number..." disabled/>
                </div>
              </div><!-- /.col-sm-6 -->
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="email">Email Address</label>
                  <input type="text" class="form-control" id="email" placeholder="Email Address..." disabled/>
                </div>
              </div><!-- /.col-sm-6 -->
              <div class="col-sm-12">
                <div class="form-group pull-right">
                  <div class="icheck">
                    <label for="generateQueues">
                      <input type="checkbox" name="generateQueue" id="generateQueues" <?php if(set_value('generateQueue'))echo'checked';?>> Generate Queue
                    </label>
                    <button type="submit" class="btn btn-success">Register New Patient & Submit Case</button>
                  </div>
                </div>
              </div>
            </div><!-- /.col-sm-12 -->
          </div><!--  /.row -->
        </div>
        <!-- /.box-body -->
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
<!-- CK Editor -->
<script src="<?=base_url('assets/bower_components/ckeditor/ckeditor.js')?>"></script>
<!-- iCheck -->
<script src="<?=base_url('assets/plugins/iCheck/icheck.min.js')?>"></script>
<!-- bootstrap datepicker -->
<script src="<?=base_url('assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')?>"></script>
<!--  -->
<script src="<?=base_url('assets/custom/js/jquery-ui.js')?>"></script>

<!-- Page Script -->
<script type="text/javascript">
    $(function(){
      $("#patient_id").autocomplete({    
        source: "<?php echo base_url('index.php/dashboard/autocomplete');?>" // path to the get_birds method
      });
    });

  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1')
    //bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5()
  })

  //Date picker
  $('#datepicker').datepicker({
    autoclose: true
  }) 

  // ///////////////////////////////////////////////////////
  $('#addPatient').change(function(){
    var checked_status = this.checked;
      if(checked_status == true) {
        $('#field_newpatient').show();
        $('#submit_case').hide();
        $('#generateQueue').prop('disabled', true);
        $('#btnCase').prop('disabled', true);
      }
      else {
        $('#field_newpatient').hide(); 
        $('#submit_case').show();
        $('#generateQueue').prop('disabled', false);
        $('#btnCase').prop('disabled', false);
      }
  });
</script>

<!-- SELECT2 -->
<script type="text/javascript" src="<?=base_url('assets/custom/js/jquery-1.11.2.min.js')?>"></script> 
<script src="<?=base_url('assets/custom/js/jquery-ui.js')?>" type="text/javascript" language="javascript" charset="UTF-8"></script>

</body>
</html>
