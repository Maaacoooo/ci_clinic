
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?=$title?> &middot; <?=$site_title?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <?php $this->load->view('inc/css')?>

   
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
          <h4><i class="fa fa-warning"></i> Change your Password!</h4>
          <p>The system has detected that you haven't changed your default password. Please change your password for additional security.</p>
          <p>To change your password, go to your <em>Profile</em> and check out the <em>Settings Tab</em>. <a href="<?=base_url('settings/profile')?>">Click here to change!</a></p>
        </div>
      <?php endif ?>

      <!-- Default box -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Queues</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>      
          </div>
        </div>
        <div class="box-body">

          <div class="row">
            <div class="col-sm-12">
              <?php if ($serving): ?> 
                  <div class="col-sm-10">
                    <?php foreach ($serving as $serv): ?>
                      <h4><span class="label bg-green">Now Serving</span></h4>

                      <p> <?=$serv['patient']?> - Case #<?=prettyID($serv['case_id']) . ' - ' . $serv['case_title']?> 
                          <small><a href="<?=base_url('patients/view/'.$serv['patient_id'].'/case/'.$serv['case_id'])?>">[ CHECKOUT ] >>></a></small>
                      </p>
                    <?php endforeach ?>
                  </div><!-- /.col-sm-10 -->
                  <div class="col-sm-2">
                    <a href="#" class="btn btn-info">NEXT QUEUE</a>
                  </div>
              <?php else: ?>
                <div class="col-sm-10">
                  <h4><span class="label bg-green">Not Serving</span></h4> <h5 class="header">You are currently not serving any queues</h5>
                </div>
                <div class="col-sm-2">
                  <a href="<?=base_url('queues/next_queue')?>" class="btn btn-info">NEXT QUEUE</a>
                </div>
             <?php endif ?>
            </div><!-- /.col-sm-12 -->
          </div><!--  /.row -->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

      <div class="box box-warning">
        <div class="box-header with-border">
          <div class="alert alert-warning alert-dismissible">
            <i class="fa fa-info-circle"></i> Before proceeding to the next queue, please clear the current serving queue by checking out the case and updating the status.
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-sm-12">
              <div class="box-body table-responsive no-padding">
              <?php if ($queue): ?>
                <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Patient Name</th>
                        <th>Case</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($queue as $q): ?>
                        <tr>
                          <td class="active"><?=$q['patient']?></td>
                          <td class="active">#<?=prettyID($q['case_id']) . ' - ' .$q['case_title']?></td>
                          <td><a href="<?=base_url('queues/checkout/'.$q['queue_id'])?>">Check Out >>></a></td>
                        </tr>
                      <?php endforeach ?>
                    </tbody>
                </table><!-- /.table table-hover -->
               <?php else: ?>
                 <h5 class="header">You have No Pending Queues...</h5><!-- /.header --> 
               <?php endif ?>
              </div>
            </div>
          </div>
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

    <script type="text/javascript" src="<?=base_url('assets/custom/js/jquery-1.11.2.min.js')?>"></script> 
    <script src="<?=base_url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js')?>"></script>
    <script src="<?=base_url('assets/dist/js/adminlte.min.js')?>"></script>
    <script src="<?=base_url('assets/custom/js/jquery-ui.js');?>" type="text/javascript" language="javascript" charset="UTF-8"></script>
  
</body>
</html>
