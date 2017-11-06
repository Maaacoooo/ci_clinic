
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
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?=base_url('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')?>">
  <!-- daterange picker -->
  <link rel="stylesheet" href="<?=base_url('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css')?>">

  <script type="text/javascript">
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
          <h3 class="box-title">New Patient</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>      
          </div>
        </div>
        <div class="box-body">
          <?=form_open('patients/create')?>
            <div class="row">
              <div class="col-sm-12">
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="lname">Last Name</label>
                    <input type="text" name="lname" class="form-control" id="lname" placeholder="Last Name..." value="<?=set_value('lname')?>" required/>
                  </div>
                </div><!-- /.col-sm-4 -->
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="fname">First Name</label>
                    <input type="text" name="fname" class="form-control" id="fname" placeholder="First Name..." value="<?=set_value('fname')?>" required/>
                  </div>
                </div><!-- /.col-sm-4 -->
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="mname">Middle Name</label>
                    <input type="text" name="mname" class="form-control" id="mname" placeholder="Middle Name..." value="<?=set_value('mname')?>" required/>
                  </div>
                </div><!-- /.col-sm-4 -->
                <div class="col-sm-5">
                  <div class="form-group">
                    <label for="sex">Sex</label>
                    <select name="sex" class="form-control" id="sex" required>
                      <option value="" disabled="" selected="">Sex</option>
                      <option value="1">Male</option>
                      <option value="0">Female</option>
                    </select>
                  </div>
                </div><!-- /.col-sm-4 -->
                <div class="col-sm-7">
                  <div class="form-group">
                    <label for="datepicker">Birthdate</label>
                    <input type="text" name="bdate" class="form-control" value="<?=set_value('bdate')?>" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask>
                  </div>
                </div>

                <!-- Birthplace -->
                <legend class="strong">Birthplace</legend>
                <div class="col-sm-5">
                  <div class="form-group">
                    <label for="bplace_bldg">Building / Block / House</label>
                    <input type="text" name="bplace_bldg" class="form-control" id="bplace_bldg" placeholder="Building / Block / House..." value="<?=set_value('bplace_bldg')?>" required/>
                  </div>
                </div><!-- /.col-sm-5 -->
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="bplace_strt">Street</label>
                    <input type="text" name="bplace_strt" class="form-control" id="bplace_strt" placeholder="Street..." value="<?=set_value('bplace_strt')?>" required/>
                  </div>
                </div><!-- /.col-sm-4 -->
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="bplace_brgy">Barangay</label>
                    <input type="text" name="bplace_brgy" class="form-control" id="bplace_brgy" placeholder="Barangay..." value="<?=set_value('bplace_brgy')?>" required/>
                  </div>
                </div><!-- /.col-sm-3 -->
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="bplace_city">City / Municipality</label>
                    <input type="text" name="bplace_city" class="form-control" id="bplace_city" placeholder="City / Municipality..." value="<?=set_value('bplace_city')?>" required/>
                  </div>
                </div><!-- /.col-sm-3 -->
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="bplace_prov">Province / Region</label>
                    <input type="text" name="bplace_prov" class="form-control" id="bplace_prov" placeholder="Province / Region..." value="<?=set_value('bplace_prov')?>" required/>
                  </div>
                </div><!-- /.col-sm-3 -->
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="bplace_zip">Zip Code</label>
                    <input type="text" name="bplace_zip" class="form-control" id="bplace_zip" placeholder="Zip Code..." value="<?=set_value('bplace_zip')?>" required/>
                  </div>
                </div><!-- /.col-sm-2 -->
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="bplace_country">Country</label>
                    <input type="text" name="bplace_country" class="form-control" id="bplace_country" placeholder="Country..." value="<?php if(set_value('bplace_country'))echo set_value('bplace_country'); else echo 'Philippines';?>" required/>
                  </div>
                </div><!-- /.col-sm-4 -->
             
                <!-- Present Address -->
                <legend class="strong">Present Address
                  <div class="pull-right">
                    <label for="checkAdd">
                      <input type="checkbox" id="checkAdd" onclick="sameAdd()"> <check-label>Present Address same with Birthplace</check-label>
                    </label>
                  </div>   
                </legend>
                <div class="col-sm-5">
                  <div class="form-group">
                    <label for="addr_bldg">Building / Block / House</label>
                    <input type="text" name="addr_bldg" class="form-control" id="addr_bldg" placeholder="Building / Block / House..." value="<?=set_value('addr_bldg')?>" required/>
                  </div>
                </div><!-- /.col-sm-5 -->
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="addr_strt">Street</label>
                    <input type="text" name="addr_strt" class="form-control" id="addr_strt" placeholder="Street..." value="<?=set_value('addr_strt')?>" required/>
                  </div>
                </div><!-- /.col-sm-4 -->
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="addr_brgy">Barangay</label>
                    <input type="text" name="addr_brgy" class="form-control" id="addr_brgy" placeholder="Barangay..." value="<?=set_value('addr_brgy')?>" required/>
                  </div>
                </div><!-- /.col-sm-3 -->
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="addr_city">City / Municipality</label>
                    <input type="text" name="addr_city" class="form-control" id="addr_city" placeholder="City / Municipality..." value="<?=set_value('addr_city')?>" required/>
                  </div>
                </div><!-- /.col-sm-3 -->
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="addr_prov">Province / Region</label>
                    <input type="text" name="addr_prov" class="form-control" id="addr_prov" placeholder="Province / Region..." value="<?=set_value('addr_prov')?>" required/>
                  </div>
                </div><!-- /.col-sm-3 -->
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="addr_zip">Zip Code</label>
                    <input type="text" name="addr_zip" class="form-control" id="addr_zip" placeholder="Zip Code..." value="<?=set_value('addr_zip')?>" required/>
                  </div>
                </div><!-- /.col-sm-2 -->
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="addr_country">Country</label>
                    <input type="text" name="addr_country" class="form-control" id="addr_country" placeholder="Country..." value="<?php if(set_value('addr_country'))echo set_value('addr_country'); else echo 'Philippines';?>" required/>
                  </div>
                </div><!-- /.col-sm-4 -->
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="contactno">Contact Number</label>
                    <input type="text" name="contactno" class="form-control" id="contactno" placeholder="Contact Number..."/>
                  </div>
                </div><!-- /.col-sm-6 -->
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="text" name="email" class="form-control" id="email" placeholder="Email..."/>
                  </div>
                </div><!-- /.col-sm-6 -->
                <div class="col-sm-12">
                  <div class="form-group pull-right">
                    <button type="submit" class="btn btn-success">Register New Patient</button>
                  </div>
                </div><!-- /.col-sm-12 -->
              </div><!-- /.col-sm-12 -->
            </div><!--  /.row -->
          <?=form_close()?>
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
<!-- bootstrap datepicker -->
<script src="<?=base_url('assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')?>"></script>
<!-- InputMask -->
<script src="<?=base_url('assets/plugins/input-mask/jquery.inputmask.js')?>"></script>
<script src="<?=base_url('assets/plugins/input-mask/jquery.inputmask.date.extensions.js')?>"></script>
<script src="<?=base_url('assets/plugins/input-mask/jquery.inputmask.extensions.js')?>"></script>
<!-- Page Script -->
<script type="text/javascript">
  $(function () {

    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()
  })
</script>

</body>
</html>
