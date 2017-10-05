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
                     <th>Remarks</th>
                     <td><a href="#updateRemarks" class="modal-trigger"><small>[Update]</small></a></td>
                   </tr>
                   <tr>
                     <td colspan="2"><?=$info['remarks']?></td>
                   </tr>                 
                 </table><!-- /.striped bordered -->
                 <small><em>Created at <?=$info['created_at']?></em></small> <br />
                 <?php if ($info['updated_at']): ?>
                 <small><em>Last updated <?=$info['updated_at']?></em></small>                 
                 <?php endif ?>

                 <div class="card">
                   <div class="card-content">
                     <h6 class="strong header">Options</h6><!-- /.strong header -->
                     <br />                          
                     <div class="row">
                       <a href="#changeStatus" class="modal-trigger btn waves-effect amber col s8 offset-s2">Change Status</a>   
                     </div><!-- /.row --> 
                     <br />                          
                     <div class="row">
                       <a href="#addPayment" class="modal-trigger btn waves-effect green col s8 offset-s2">Add Payment</a>   
                     </div><!-- /.row --> 
                     <br /> 
                     <div class="row">
                       <a href="<?=current_url()?>/print" target="_blank" class="btn waves-effect blue col s8 offset-s2"><i class="mdi-action-print"></i>Print Statement</a>   
                     </div><!-- /.row -->  
                   </div><!-- /.card-content -->
                 </div><!-- /.card -->
               </div><!-- /.col s12 l4 -->
               
               <div class="col s12 l9">
                 <div class="card">
                   <div class="card-content">
                     <?=form_open('billing/add_service')?>
                     <div class="row">
                       <div class="input-field col s9">
                         <input type="text" name="service" id="service" class="validate" />
                         <input type="hidden" name="id" value="<?=$this->encryption->encrypt($info['id'])?>" />
                         <label for="service">Add New Service</label>
                       </div><!-- /.input-field col s9 -->
                       <div class="input-field col s3">
                         <button type="submit" class="btn waves-effect waves-blue blue">Add Service</button>
                       </div><!-- /.input-field col s3 -->
                     </div><!-- /.row -->
                     <?=form_close()?>
                   </div><!-- /.card-content -->
                 </div><!-- /.card -->
                 <div class="card">
                   <div class="card-content table-responsive">
                     <h6 class="strong header">Services</h6><!-- /.strong header -->                     
                    <?php $payables = 0; if ($billing_items): $x = 1;?>
                    <?=form_open('billing/update_service')?>
                    <input type="hidden" name="billing_id" value="<?=$this->encryption->encrypt($info['id'])?>" />
                    <table class="striped bordered condensed">
                       <thead>
                         <tr>
                           <th></th>
                           <th width="5%"></th>
                           <th>Service</th>
                           <th width="10%">AMT</th>
                           <th width="10%">DISC</th>
                           <th width="10%">SUB</th>
                         </tr>
                       </thead>
                       <tbody>
                         <?php foreach ($billing_items as $bill): ?>
                         <tr>
                           <td><?=$x++?>.</td>
                           <td>
                             <?php if ($bill['service_cat'] == 'laboratory'): ?>
                               <span class="badge-label green">LAB</span>
                             <?php elseif($bill['service_cat'] == 'immunization'): ?>
                               <span class="badge-label blue">IMMU</span>                              
                             <?php else: ?>
                               <span class="badge-label pink">CLINIC</span>                              
                             <?php endif ?>
                           </td>
                           <td><?=$bill['title']?> - <?=$bill['remarks']?></td>
                           <td><?=$bill['amount']?></td>
                           <td>
                             <input type="hidden" name="id[]" value="<?=$this->encryption->encrypt($bill['id'])?>" />
                             <input type="text" name="disc[]" value="<?=$bill['discount']?>" id="" />
                           </td>
                           <td><?=decimalize(($bill['qty'] * $bill['amount'])-($bill['qty'] * $bill['discount']))?></td>
                           <?php 
                           //Arrays to get total
                           $totSub[] = ($bill['qty'] * $bill['amount'])-($bill['qty'] * $bill['discount']);
                           $totDisc[] = $bill['discount'];
                           ?>
                         </tr>
                         <?php endforeach ?>                         
                        </tbody>
                        <tfoot>
                          <tr class="red lighten-5">
                            <td colspan="4" class="strong right-align"><button type="submit" class="btn amber waves-effect waves-amber left">Update Services</button> Total</td>
                            <td class="strong red-text"><?=decimalize(array_sum($totDisc))?></td>
                            <?php $payables = array_sum($totSub); //override payables variable ?>
                            <td class="strong red-text"><?=decimalize($payables)?></td>
                          </tr>
                        </tfoot>
                     </table><!-- /.striped bordered condensed -->
                     <?=form_close()?>
                      <?php endif ?>                       
                   </div><!-- /.card-content -->
                 </div><!-- /.card -->

                 <div class="card">
                   <div class="card-content">
                     <h6 class="strong header">Payments</h6><!-- /.strong header -->                     
                    <?php if ($payments): $x = 1;?>
                    <table class="striped bordered condensed">
                       <thead>
                         <tr>
                           <th></th>
                           <th width="20%">Date | Time</th>
                           <th>Payee</th>
                           <th>Received By</th>
                           <th width="15%">Amount</th>
                       </thead>
                       <tbody>
                         <?php foreach ($payments as $pay): ?>
                         <tr>
                           <td><?=$x++?>.</td>
                           <td><a href="<?=base_url('billing/view/'.$info['id'].'/payment/'.$pay['id'])?>"><?=$pay['created_at']?></a></td>
                           <td><a href="<?=base_url('billing/view/'.$info['id'].'/payment/'.$pay['id'])?>"><?=$pay['payee']?></a></td>
                           <td><a href="<?=base_url('billing/view/'.$info['id'].'/payment/'.$pay['id'])?>"><?=$pay['user']?></a></td>
                           <td><a href="<?=base_url('billing/view/'.$info['id'].'/payment/'.$pay['id'])?>"><?=$pay['amount']?></a></td>
                           <?php 
                           $totPay[] = $pay['amount']; //array to get total of payments
                           ?>
                         </tr>
                         <?php endforeach ?>
                        </tbody>
                        <tfoot>
                          <tr class="light-blue lighten-5">
                            <td colspan="4" class="right-align strong">Total</td>
                            <td class="strong blue-text"><?=decimalize(array_sum($totPay))?></td>
                          </tr>
                          <tr>
                            <td colspan="4" class="right-align strong">Total Payables</td>
                            <td class="strong red-text"><?=decimalize($payables)?></td>
                          </tr>
                          <tr class="green lighten-5">
                            <td colspan="4" class="right-align strong">Balance</td>
                            <td class="strong green-text"><?=decimalize($payables - array_sum($totPay))?></td>
                          </tr>
                        </tfoot>
                     </table><!-- /.striped bordered condensed -->
                      <?php endif ?>                       
                   </div><!-- /.card-content -->
                 </div><!-- /.card -->
               </div><!-- /.col s12 l8 -->          
             </div><!-- /.row --> 
        
          <?php if (!$info['status']): ?>
            <div id="changeStatus" class="modal">
              <?=form_open('billing/change_status')?>
                <div class="modal-content">
                    <div class="row">
                      <h5 class="header">Change Status</h5><!-- /.header -->
                      <div class="col s6">                         
                         <p><i class="mdi-action-info-outline tiny"></i> Once the Immunization Request is set to <span class="badge-label green darken-3">served</span>, 
                         the system will automatically add this Service to the current Open Billing Record. </p> 
                         <p>These actions cannot be undone.</p>
                      </div><!-- /.col s12 -->  
                      <div class="col s6">
                        <p>This changes the status of the Immunization Request.</p>                       
                         <input name="status" type="radio" id="pending" value="<?=$this->encryption->encrypt(0)?>" class="with-gap" <?php if ($info['status'] == 0)echo'checked';?>>
                         <label for="pending">Pending</label>
                         <input name="status" type="radio" id="served" value="<?=$this->encryption->encrypt(1)?>" class="with-gap" <?php if ($info['status'] == 1)echo'checked';?>>
                         <label for="served">Served</label>
                         <input name="status" type="radio" id="cancel" value="<?=$this->encryption->encrypt(3)?>" class="with-gap" <?php if ($info['status'] == 3)echo'checked';?>>
                         <label for="cancel">Cancelled</label>
                      </div><!-- /.col s6 -->                    
                    </div><!-- /.row -->
                    <input type="hidden" name="id" value="<?=$this->encryption->encrypt($info['id'])?>" />
                  </div>
                  <div class="modal-footer grey darken-4">
                    <a href="#" class="waves-effect waves-red btn-flat red-text strong modal-action modal-close">Cancel</a>
                    <button type="submit" class="waves-effect waves-red btn amber modal-action">Change</button>
                  </div>
              <?=form_close()?>
            </div>
          <?php endif ?>           

            <div id="updateRemarks" class="modal">
              <?=form_open('billing/update')?>
                <div class="modal-content">
                    <h5 class="header">Update Description</h5><!-- /.header -->
                    <div class="row">
                      <div class="col s12">
                        <label>Description</label>
                        <textarea name="description" id="description" cols="30" rows="10" class="ckeditor"><?=$info['remarks']?></textarea>
                      </div><!-- /.col s12 -->                     
                    </div><!-- /.row -->
                    <input type="hidden" name="id" value="<?=$this->encryption->encrypt($info['id'])?>" />
                  </div>
                  <div class="modal-footer grey darken-4">
                    <a href="#" class="waves-effect waves-red btn-flat red-text strong modal-action modal-close">Cancel</a>
                    <button type="submit" class="waves-effect waves-amber btn amber modal-action">Update</button>
                  </div>
              <?=form_close()?>
            </div>

            <div id="addPayment" class="modal">
              <?=form_open('billing/add_payment')?>
                <div class="modal-content">
                    <h5 class="header">Add Payment</h5><!-- /.header -->
                    <div class="row">
                     <div class="input-field col s12">
                        <input type="text" name="payee" id="payee" class="validate" value="<?=$info['patient_name']?>" required/>
                        <label for="payee">Payee</label>
                      </div><!-- /.input-field col s12 -->
                    </div><!-- /.row -->
                    <div class="row">
                     <div class="input-field col s6">
                        <input type="text" name="amount" onkeyup="changeBalance()" id="amount" class="validate" value="<?=decimalize(($info['payables'] - $info['discounts']) - $info['payments'])?>" required/>
                        <label for="amount">Amount</label>
                      </div><!-- /.input-field col s6 -->
                     <div class="input-field col s6">
                        <input type="text" id="balance" class="validate" value="00.00" readonly />
                        <label for="balance">Balance</label>
                      </div><!-- /.input-field col s6 -->
                    </div><!-- /.row -->
                    <div class="row">
                      <div class="col s12">
                        <label>Remarks</label>
                        <textarea name="remarks" id="description" cols="30" rows="10" class="ckeditor"><?=$info['remarks']?></textarea>
                      </div><!-- /.col s12 -->                     
                    </div><!-- /.row -->
                    <input type="hidden" name="id" value="<?=$this->encryption->encrypt($info['id'])?>" />
                  </div>
                  <div class="modal-footer grey darken-4">
                    <a href="#" class="waves-effect waves-red btn-flat red-text strong modal-action modal-close">Cancel</a>
                    <button type="submit" class="waves-effect waves-amber btn amber modal-action">Update</button>
                  </div>
              <?=form_close()?>
            </div>
         
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

