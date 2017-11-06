
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
              <h3>Billing Information : <small><?=$title?></small></h3>
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
                 <td><a href="#updateRemarks" data-toggle="modal"><small>[Update]</small></a></td>
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

          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Options</h3>
            </div>
            <div class="box-body">
              <div class="form-group">
                <a href="#changeStatus" data-toggle="modal" class="btn btn-warning  form-control">Change Status</a>
              </div>
              <div class="form-group">
                <a href="#addPayment" data-toggle="modal" class="btn btn-success  form-control">Add Payment</a>
              </div>
              <div class="form-group">
                <a href="<?=current_url()?>/print" target="_blank" class="btn btn-primary  form-control"><i class="fa fa-print"></i> Print</a>
              </div>
            </div><!-- /.box-body -->
          </div><!-- /.box box-primary -->

        </div><!-- /.col-sm-4 -->

        <div class="col-sm-8">  
          <div class="box box-primary">
            <div class="box-body">
              <?=form_open('billing/add_service')?>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="service">Service</label>
                    <input type="text" name="service" class="form-control" id="service" placeholder="Add New Service" required/>
                  </div>
                </div><!-- /.col-sm-6 -->
                <div class="col-sm-6">
                  <label for="remarks">Remarks</label>
                  <div class="input-group">
                    <input type="text" name="remarks" class="form-control" id="remarks" placeholder="Remarks" required/>
                    <input type="hidden" name="id" value="<?=$this->encryption->encrypt($info['id'])?>" />
                      <span class="input-group-btn">
                        <button type="submit" class="btn btn-info">Add Service</button>
                      </span>
                  </div><!-- /.input-group -->
                </div><!-- /.col-sm-6 -->
              <?=form_close()?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- Services table -->
          <div class="box <?php if ($billing_items == NULL) { echo 'collapsed-box'; } else { echo 'default-box'; } ?>">
            <div class="box-header with-border">
              <h3 class="box-title">Services</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-default btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa <?php if ($billing_items == NULL) { echo 'fa-plus'; } else { echo 'fa-minus'; } ?>"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-sm-12">
                  <?php $payables = 0; if ($billing_items): $x = 1;?>
                  <?=form_open('billing/update_service')?>
                  <input type="hidden" name="billing_id" value="<?=$this->encryption->encrypt($info['id'])?>" />
                  <table class="table table-striped">
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
                          <span class="label bg-green">LAB</span>
                        <?php elseif($bill['service_cat'] == 'immunization'): ?>
                          <span class="label bg-blue">IMMU</span>                              
                        <?php else: ?>
                          <span class="label bg-maroon">CLINIC</span>                              
                        <?php endif ?>
                        </td>  
                         <td>
                        <?=$bill['title']?> - <?=$bill['remarks']?>
                        <?php if ($bill['service_cat'] == 'clinic'): ?>
                            <a href="#serv<?=$bill['id']?>" data-toggle="modal">[<i class="fa fa-trash"></i>]</a>
                        <?php endif ?>
                        </td>
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
                      <tr class="text-red">
                        <td colspan="3"><button type="submit" class="btn btn-warning">Update Services</button></td>
                        <td><b>Total</b></td>
                        <td colspan="1"><?=decimalize(array_sum($totDisc))?></td>
                        <?php $payables = array_sum($totSub); //override payables variable ?>
                        <td><?=decimalize($payables)?></td>
                      </tr>
                    </tfoot>
                  </table>
                  <?=form_close()?>
                  <?php endif ?>
                </div><!-- /.col-sm-12 -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- Payments table -->
          <div class="box <?php if ($payments == NULL) { echo 'collapsed-box'; } else { echo 'default-box'; } ?>">
            <div class="box-header with-border">
              <h3 class="box-title">Payments</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-default btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa <?php if ($payments == NULL) { echo 'fa-plus'; } else { echo 'fa-minus'; } ?>"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-sm-12">
                <?php if ($payments): $x = 1;?>
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th></th>
                      <th width="20%">Date | Time</th>
                      <th>Payee</th>
                      <th>Received By</th>
                      <th width="15%">Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($payments as $pay): ?>
                    <tr>
                      <td><?=$x++?>.</td>
                      <td><a href="<?=base_url('billing/view/'.$info['id'].'/payment/'.$pay['id'])?>"><?=$pay['created_at']?></a></td>
                      <td><a href="<?=base_url('billing/view/'.$info['id'].'/payment/'.$pay['id'])?>"><?=$pay['payee']?></a></td>
                      <td><a href="<?=base_url('billing/view/'.$info['id'].'/payment/'.$pay['id'])?>"><?=$pay['user']?></a></td>
                      <td><a href="<?=base_url('billing/view/'.$info['id'].'/payment/'.$pay['id'])?>"><?=$pay['amount']?></a></td>
                    </tr>
                  <?php endforeach ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="4">Total</td>
                      <td class="text-aqua"><?=decimalize(array_sum($totPay))?></td>
                    </tr>
                    <tr>
                      <td colspan="4">Total Payables</td>
                      <td class="text-red"><?=decimalize($payables)?></td>
                    </tr>
                    <tr>
                      <td colspan="4">Balance</td>
                      <td class="text-green"><?=decimalize($payables - array_sum($totPay))?></td>
                    </tr>                  
                  </tfoot>
                </table><!-- /.table table-striped -->
                <?php endif ?>
                </div><!-- /.col-sm-12 -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- updateRemarks Modal -->
          <div class="modal fade" id="updateRemarks">
            <div class="modal-dialog">
              <?=form_open('billing/update')?>
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Update Description</h4>
                  </div>
                  <div class="modal-body">
                    <label>Description</label>
                    <textarea name="remarks" id="remarks" class="ckeditor"><?=$info['remarks']?></textarea>
                  </div>
                  <input type="hidden" name="id" value="<?=$this->encryption->encrypt($info['id'])?>" />
                  <div class="modal-footer">
                    <div class="form-group">
                      <button type="submit" class="btn btn-warning">Update</button>
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
                <!-- /.modal-content -->
              <?=form_close()?>
            </div>
            <!-- /.modal-dialog -->
          </div>
          <!-- /.modal -->

          <!-- Remove Service Modal -->
          <?php if ($billing_items):?>
          <?php foreach ($billing_items as $bill): ?>
          <div class="modal fade" id="serv<?=$bill['id']?>">
            <div class="modal-dialog">
              <?=form_open('billing/remove_service')?>
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Remove Service?</h4>
                  </div>
                  <div class="modal-body">
                    <p>Are you sure to remove <span class="text-red"><b><?=$bill['title']?></b></span> in Billing #<?=prettyID($info['id'])?></p>
                    <div class="form-group">
                      <label for="remarks">Remarks</label>
                      <input type="text" name="remarks" class="form-control" id="remarks" required/>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <div class="form-group">
                        <input type="hidden" name="id" value="<?=$this->encryption->encrypt($bill['id'])?>" />
                        <input type="hidden" name="billing_id" value="<?=$this->encryption->encrypt($info['id'])?>" />
                      <button type="submit" class="btn btn-danger">Remove</button>
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div><!-- /.form-group -->
                  </div>
                </div>
                <!-- /.modal-content -->
              <?=form_close()?>
            </div>
            <!-- /.modal-dialog -->
          </div>
          <?php endforeach ?>
          <?php endif ?>
          <!-- /.modal -->

          <!-- ChangeStatus Modal -->
          <?php if(!$info['status']): ?>
          <div class="modal fade" id="changeStatus">
            <div class="modal-dialog">
              <?=form_open('billing/change_status')?>
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Change Status</h4>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-sm-6">
                        <p><i class="fa fa-info-circle"></i> Once the Immunization Request is set to <span class="label bg-green">served</span>,
                        the system will automatically add the service to the current open Billing Record.</p>
                        <p>These actions cannot be undone.</p>
                      </div><!-- /.col-sm-6 -->
                      <div class="col-sm-6">
                        <p>This changes the status of the Immunization Request.</p>
                          <input name="status" type="radio" id="pending" value="<?=$this->encryption->encrypt(0)?>" <?php if ($info['status'] == 0)echo'checked';?>>
                          <label for="pending">Pending</label>
                          <input name="status" type="radio" id="served" value="<?=$this->encryption->encrypt(1)?>" <?php if ($info['status'] == 1)echo'checked';?>>
                          <label for="served">Served</label>
                          <input name="status" type="radio" id="cancel" value="<?=$this->encryption->encrypt(3)?>" <?php if ($info['status'] == 3)echo'checked';?>>
                          <label for="cancel">Cancelled</label>
                      </div><!-- /.col-sm-6 -->
                    </div><!-- /.row -->
                  </div><!-- /.modal-body -->
                  <div class="modal-footer">
                    <div class="form-group">
                      <input type="hidden" name="id" value="<?=$this->encryption->encrypt($info['id'])?>" />
                      <button type="submit" class="btn btn-warning">Change</button>
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                  </div>
                </div>
                <!-- /.modal-content -->
                <?=form_close()?>
            </div>
            <!-- /.modal-dialog -->
          </div>
          <?php endif ?>
          <!-- /.modal -->

          <!-- addPayment Modal -->
          <div class="modal fade" id="addPayment">
            <div class="modal-dialog">
              <?=form_open('billing/add_payment')?>
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Payment</h4>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="col-sm-12">
                          <label for="payee">Payee</label>
                          <input type="text" name="payee" class="form-control" id="payee" value="<?=$info['patient_name']?>" required/>
                        </div><!-- /.col-sm-12 -->
                        <div class="col-sm-6">
                          <label for="amount">Amount</label>
                          <input type="text" name="amount" onkeyup="changeBalance()" class="form-control" id="amount" value="<?=decimalize(($info['payables'] - $info['discounts']) - $info['payments'])?>" required/>
                        </div><!-- /.col-sm-6 -->
                        <div class="col-sm-6">
                          <label for="balance">Balance</label>
                          <input type="text" class="form-control" id="balance" value="00.00" readonly/>
                        </div><!-- /.col-sm-6 -->
                        <div class="col-sm-12">
                          <label for="balance">Remarks</label>
                          <textarea name="remarks" id="remarks" class="ckeditor"></textarea>
                        </div><!-- /.col-sm-12 -->
                      </div><!-- /.col-sm-12 -->
                    </div><!-- /.row -->
                  </div><!-- /.modal-body -->
                  <input type="hidden" name="id" value="<?=$this->encryption->encrypt($info['id'])?>" />
                  <div class="modal-footer">
                    <div class="form-group">
                      <button type="submit" class="btn btn-warning">Update</button>
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                  </div>
                </div>
                <!-- /.modal-content -->
              <?=form_close()?>
            </div>
            <!-- /.modal-dialog -->
          </div>
          <!-- /.modal -->

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
