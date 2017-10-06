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
  
<body <?php if($this->session->flashdata('invoice'))echo 'onload="load_receipt()"';?>>
    
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
                    <li><a href="<?=base_url('patients/view/'.$info['patient_id'])?>"><?=$info['patient_name']?></a></li>
                    <li><a href="<?=base_url('patients/view/'.$info['patient_id'].'/case/'.$info['case_id'])?>"><?=$info['case_title']?></a></li>
                    <li><a href="<?=base_url('billing')?>">Billing</a></li>
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
               <div class="col s12 l3">
                 <table class="striped bordered">
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
                         <span class="badge-label grey darken-3">Cancelled</span>     
                       <?php elseif($info['status'] == 1): ?>
                         <span class="badge-label green darken-3">Served</span>                                   
                       <?php else: ?> 
                         <span class="badge-label red darken-3">Pending</span> 
                       <?php endif ?>
                       <?php if (($info['payables'] - $info['discounts']) > $info['payments']): ?>
                        <span class="badge-label red darken-3">UNPAID</span>
                      <?php else: ?>
                        <span class="badge-label green darken-3">PAID</span>                        
                      <?php endif ?>
                     </td>
                   </tr>
                   <tr>
                     <th>Total Payables</th>
                     <td class="red-text"><?=decimalize($info['payables'] - $info['discounts'])?></td>
                   </tr>
                   <tr>
                     <th>Total Payments</th>
                     <td class="blue-text"><?=$info['payments']?></td>
                   </tr>
                   <tr class="green lighten-5">
                     <th>Remaining Balance</th>
                     <td class="green-text strong"><?=decimalize(($info['payables'] - $info['discounts']) - $info['payments'])?></td>
                   </tr>
                   <tr>
                     <th>Requested by</th>
                     <td><?=$info['user']?></td>
                   </tr>
                   <tr>
                     <th colspan="2">Remarks</th>
                   </tr>
                   <tr>
                     <td colspan="2"><?=$info['remarks']?></td>
                   </tr>                 
                 </table><!-- /.striped bordered -->
                 <small><em>Created at <?=$info['created_at']?></em></small> <br />
                 <?php if ($info['updated_at']): ?>
                 <small><em>Last updated <?=$info['updated_at']?></em></small>                 
                 <?php endif ?>       

               </div><!-- /.col s12 l4 -->
               
               <div class="col s12 l9">
                 <div class="card">
                   <div class="card-content">           
                      <iframe src="<?=base_url('billing/view/'.$info['id'].'/print')?>" frameborder="0" width="100%" height="450px"></iframe>                 
                   </div><!-- /.card-content -->
                 </div><!-- /.card -->
               </div><!-- /.col s12 l8 -->          
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
   
    <script src="<?php echo base_url();?>assets/js/jquery-ui.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
    
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

