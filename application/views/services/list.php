
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
        <li><a href="#">Clinic Data</a></li>
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
        <div class="col-sm-7">
          <!-- Default box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Services and Fees List <span class="badge"><?=$total_result?></span></h3>

              <div class="box-tools pull-right">            
                <?=form_open('services/clinic', array('method' => 'get', 'class' => 'input-group input-group-sm', 'style' => 'width: 150px;'))?>
                  <input type="text" name="search" class="form-control pull-right" placeholder="Search...">
                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    <button type="button" class="btn btn-default btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                      <i class="fa fa-minus"></i>
                    </button>  
                  </div> 
                <?=form_close()?> 
              </div>
            </div>
            <div class="box-body">
              <table class="table table-condensed table-striped">            
                <?php if ($results): ?>
                <thead>
                  <tr>
                    <th>Service</th>
                    <th>Code</th>
                    <th>Amount</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($results as $row): ?>
                    <tr>
                      <td><a href="#updateModal<?=$row['id']?>" data-toggle="modal"><?=$row['title']?></a></td>                          
                      <td><a href="#updateModal<?=$row['id']?>" data-toggle="modal"><?=$row['code']?></a></td>                                  
                      <td><a href="#updateModal<?=$row['id']?>" data-toggle="modal"><?=$row['amount']?></a></td>
                      <td>
                    <?php if (!$row['is_constant']): ?>
                        <a href="#deleteModal<?=$row['id']?>" data-toggle="modal" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-trash"></i></a>
                    <?php endif ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>              
                <?php else: ?>  
                  <tr>
                    <td>No Clinic Services and Fees found!</td>
                  </tr>
                <?php endif ?>            
              </table><!-- /.table table-bordered -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <div class="pull-right">
                <?php foreach ($links as $link) { echo $link; } ?>
              </div><!-- /.pull-right -->
            </div>
            <!-- /.box-footer-->
          </div>
          <!-- /.box -->
        </div><!-- /.col-sm-7 -->

        <div class="col-sm-5">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Register New Service</h3>
            </div>
            <div class="box-body">
              <?=form_open('services/'.$tag)?>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="title">Title</label>
                      <input type="text" name="title" class="form-control" id="title" placeholder="Title..." value="<?=set_value('title')?>" required/>
                    </div>
                  </div><!-- /.col-sm-12 -->
                  <div class="col-sm-8">
                    <div class="form-group">
                      <label for="code">Service Code</label>
                      <input type="text" name="code" class="form-control" id="code" placeholder="Service Code..." value="<?=set_value('code')?>"/>
                    </div>
                  </div><!-- /.col-sm-8 -->
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="amount">Amount</label>
                      <input type="number" name="amount" class="form-control" id="amount" placeholder="Amount..." min="0" value="<?=set_value('amount')?>" required>
                    </div>
                  </div><!-- /.col-sm-4 -->
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="description">Description</label>
                      <textarea name="description" class="ckeditor" id="description" rows="5"></textarea>
                    </div>
                  </div><!-- /.col-sm-12 -->
                  <div class="col-sm-12">
                    <div class="form-group pull-right">
                      <button type="submit" class="btn btn-primary"><i class="fa fa-send"></i> Submit</button>
                    </div>
                  </div><!-- /.col-sm-12 -->
                </div><!-- /.row -->
              <?=form_close()?>
            </div><!-- /.box-body -->
          </div><!-- /.box box-primary -->
        </div><!-- /.col-sm-5 -->
      </div><!-- /.row -->

      <?php foreach ($results AS $row): ?>
      <!-- updateServiceAndFees Modal -->
      <div class="modal fade" id="updateModal<?=$row['id']?>">
        <div class="modal-dialog">
          <?=form_open('services/update')?>
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Update: <?=$row['title']?></h4>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-sm-12">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" id="title" placeholder="Title..." value="<?=$row['title']?>" required>
                  </div><!-- /.col-sm-12 -->
                  <div class="col-sm-8">
                    <label for="code">Service Code</label>
                    <input type="text" name="code" class="form-control" id="code" placeholder="Service Code..." value="<?=$row['code']?>" required>
                  </div><!-- /.col-sm-8 -->
                  <div class="col-sm-4">
                    <label for="amount">Amount</label>
                    <input type="number" name="amount" class="form-control" id="amount" placeholder="Amount..." min="0" value="<?=$row['amount']?>" required>
                  </div><!-- /.col-sm-4 -->
                  <div class="col-sm-12">
                    <label for="description">Description</label>
                    <textarea name="description" class="ckeditor" id="description" rows="5"><?=$row['description']?></textarea>
                  </div><!-- /.col-sm-12 -->
                </div><!-- /.row -->
              <input type="hidden" name="id" value="<?=$this->encryption->encrypt($row['id'])?>" />
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-warning">Update</button>
              </div>
            </div>
            <!-- /.modal-content -->
          <?=form_close()?>
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <!-- DeleteService Modal -->
      <div class="modal modal-danger fade" id="deleteModal<?=$row['id']?>">
        <div class="modal-dialog">
          <?=form_open('services/delete')?>
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Delete: <?=$row['title']?></h4>
              </div>
              <div class="modal-body">
                <p>Are you sure to delete the record of <b><?=$row['title']?></b>?</p>
                <p>You <b>CANNOT UNDO</b> this action.</p>
                <input type="hidden" name="id" value="<?=$this->encryption->encrypt($row['id'])?>" />
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline">Delete</button>
              </div>
            </div>
            <!-- /.modal-content -->
          <?=form_close()?>
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
      <?php endforeach ?>

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
<!-- CKEDITOR -->
<script src="<?=base_url('assets/ckeditor/ckeditor.js')?>"></script>

</body>
</html>
