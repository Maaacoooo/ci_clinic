
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
  <!-- -->
  <link rel="stylesheet" href="<?=base_url('assets/custom/css/jquery-ui.min.css')?>">
  <script>
    function changeBalance() {
      var balance = <?=decimalize(($info['payables']-$info['discounts']) - $info['payments'])?>;
      var pay = document.getElementById("amount").value;

      //display to balance
      document.getElementById("balance").value = (balance - pay).toFixed(2);
    }

    <?php 
    if ($this->session->flashdata('invoice')): ?>
    function load_receipt() {
      window.open("<?=$this->session->flashdata('invoice')?>");
    }
    <?php
    endif;
    ?>
  </script>
</head>
<body class="hold-transition skin-black sidebar-mini" <?php if($this->session->flashdata('invoice'))echo 'onload="load_receipt()"';?>>
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
        <li><a href="<?=base_url('patients/view/'.$info['patient_id'])?>"><?=$info['patient_name']?></a></li>
        <li><a href="<?=base_url('patients/view/'.$info['patient_id'].'/case/'.$info['case_id'])?>"><?=$info['case_title']?></a></li>
        <li><a href="<?=base_url('billing')?>">Billing</a></li>
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

      <div class="row">
        <!-- Default box -->
        <div class="col-sm-4">  
          <div class="box box-primary">
            <div class="box-body">
              <table class="table table-condensed table-striped">            
                <tr>
                  <th>Patient Name</th>
                  <td><?=$info['patient_name']?></td>
                </tr>
                <tr>
                  <th>Case</th>
                  <td><?=$info['case_title']?></td>
                </tr>
                <tr>
                  <th>Status</th>
                  <td>
                  <?php if ($info['status'] == 3): ?>
                    <span class="label bg-grey">Cancelled</span>     
                  <?php elseif($info['status'] == 1): ?>
                    <span class="label bg-green">Served</span>                                   
                  <?php else: ?> 
                    <span class="label bg-maroon">Pending</span> 
                  <?php endif ?>
                  <?php if (($info['payables'] - $info['discounts']) > $info['payments']): ?>
                    <span class="label bg-maroon">UNPAID</span>
                  <?php else: ?>
                    <span class="label bg-green">PAID</span>                        
                  <?php endif ?>
                  </td>
               </tr>
               <tr>
                 <th>Total Payables</th>
                 <td><?=decimalize($info['payables'] - $info['discounts'])?></td>
               </tr>
               <tr>
                 <th>Total Payments</th>
                 <td><?=$info['payments']?></td>
               </tr>
               <tr>
                 <th>Remaining Balance</th>
                 <td><?=decimalize(($info['payables'] - $info['discounts']) - $info['payments'])?></td>
               </tr>
               <tr>
                 <th>Requested by</th>
                 <td><?=$info['user']?></td>
               </tr>
               <tr>
                 <th>Remarks</th>
               </tr>
               <tr>
                 <td colspan="2"><?=$info['remarks']?></td>
               </tr>  
              </table><!-- /.table table-condensed table-striped -->
              <small><em>Created at <?=$info['created_at']?></em></small>
              <br />
              <?php if ($info['updated_at']): ?>
              <small><em>Last updated <?=$info['updated_at']?></em></small>                 
              <?php endif ?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box box-primary -->
        </div><!-- /.col-sm-4 -->

        <div class="col-sm-8">  
          <div class="box default-box">
            <div class="box-body">
              <iframe src="<?=base_url('billing/view/'.$info['id'].'/print')?>" frameborder="0" width="100%" height="450px"></iframe>
            </div>
          </div>
        </div><!-- /.col-sm-8 -->



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
<script type="text/javascript" src="<?=base_url('assets/custom/js/jquery-1.11.2.min.js')?>"></script> 
<script src="<?=base_url('assets/custom/js/jquery-ui.js');?>" type="text/javascript" language="javascript" charset="UTF-8"></script>

<script type="text/javascript">
  $(function(){
  $("#service").autocomplete({    
    source: "<?php echo base_url('index.php/billing/autocomplete');?>" // path to the get_birds method
  });
});
</script>

<script src="<?=base_url('assets/ckeditor/ckeditor.js')?>"></script>

</body>
</html>
