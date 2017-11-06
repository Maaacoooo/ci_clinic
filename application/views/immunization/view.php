
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
        <small><?=$title?></small>        
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url()?>">Dashboard</a></li>
        <li><a href="<?=base_url('patients')?>">Patients</a></li>
        <li><a href="<?=base_url('patients/view/'.$info['id'])?>"><?=$info['fullname'] . ' ' . $info['lastname']?></a></li>
        <li><a href="<?=base_url('patients/view/'.$info['id'].'/case/'.$case['id'])?>"><?=$case['title']?></a></li>
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
        <div class="col-sm-8">
          <div class="box default-box">
            <div class="box-body">   
              <h3>Immunization Information : <small><?=$immu['service']?></small></h3>
              <table class="table table-striped">
                <tr>
                  <th>Patient Name :</th>
                  <td><?=$info['fullname'] . ' ' . $info['lastname']?></td>
                </tr>
                <tr>
                  <th>Case</th>
                  <td><?=$case['title']?></td>
                </tr>
                <tr>
                  <th>Requested Service</th>
                  <td class="red-text"><?=$immu['service']?></td>
                </tr>
                <tr>
                  <th>Status</th>
                  <td>
                  <?php if ($immu['status'] == 3): ?>
                    <span class="label bg-grey">Cancelled</span>     
                  <?php elseif($immu['status'] == 1): ?>
                    <span class="label bg-green">Served</span>                                   
                  <?php else: ?> 
                    <span class="label bg-red">Pending</span> 
                  <?php endif ?>
                   </td>
                </tr>
                <tr>
                  <th>Requested by</th>
                  <td><?=$immu['user']?></td>
                </tr>
                <tr>
                  <th>Request Description / Remarks</th>
                  <td><a href="#updateRemarks" data-toggle="modal"><small>[Update]</small></a></td>
                </tr>
                <tr>
                  <td colspan="2"><?=$immu['description']?></td>
                </tr>
              </table>
              <small><em>Created at <?=$immu['created_at']?></em></small>
            <?php if ($immu['updated_at']): ?>
              <small class="right"><em>Last updated <?=$immu['updated_at']?></em></small>                 
            <?php endif ?>
            </div><!-- /.box-body -->
          </div><!-- /.box default-fox -->
        </div><!-- /.col-sm-8 -->

        <?php if (!$immu['status']): ?>
        <div class="col-sm-4">
          <!-- Options -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Options</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="form-group">
                <a href="#changeStatus" class="btn btn-warning form-control" data-toggle="modal">Change Status</a>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div><!-- col-sm-4 -->
        <?php endif ?>

      </div><!-- /.row -->

      <!-- updateRemarks Modal -->
      <div class="modal fade" id="updateRemarks">
        <div class="modal-dialog">
          <?=form_open('immunization/update')?>
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Update Description</h4>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="description">Description</label>
                      <textarea name="description" id="description" cols="30" rows="10" class="ckeditor"><?=$immu['description']?></textarea>
                    </div>
                  </div><!-- /.col-sm-12 -->
                </div><!-- /.row -->
                <input type="hidden" name="id" value="<?=$this->encryption->encrypt($immu['immu_id'])?>" />
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Update</button>
              </div>
            </div>
            <!-- /.modal-content -->
          <?=form_close()?>
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <!-- ChangeStatus Modal -->
      <?php if(!$immu['status']): ?>
      <div class="modal fade" id="changeStatus">
        <div class="modal-dialog">
          <?=form_open('immunization/change_status')?>
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
                <input type="hidden" name="id" value="<?=$this->encryption->encrypt($immu['immu_id'])?>" />
              </div><!-- /.modal-body -->
              <div class="modal-footer">
                <div class="form-group">
                  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-warning">Change</button>
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
<!-- CKEDITOR -->
<script src="<?=base_url('assets/ckeditor/ckeditor.js')?>"></script>

</body>
</html>
