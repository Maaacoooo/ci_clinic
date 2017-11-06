
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

      <!-- Prescription -->
      <div class="box default-box">
        <div class="box-header with-border">
          <h3 class="box-title">Prescription</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <?=form_open('prescription/update')?>
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="case">Case</label>
                  <input type="text" name="case" class="form-control" id="case" value="#<?=prettyID($case['id'])?>- <?=$case['title']?>" readOnly/>
                </div>
              </div><!-- /.col-sm-12 -->
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="title">Title</label>
                  <input type="text" name="title" class="form-control" id="title" value="<?=$prescription['title']?>" />
                </div>
              </div><!-- /.col-sm-12 -->
              <div class="col-sm-12">
                <div class="form-group">
                  <textarea name="description" cols="30" rows="10" class="ckeditor" required=""><?=$prescription['description']?></textarea>
                </div>
              </div><!-- /.col-sm-12 -->
              <div class="col-sm-12">
                <div class="form-group pull-right">
                  <button type="submit" class="btn btn-warning">Update Prescription</button>
                </div>
              </div><!-- /.col-sm-12 -->
              <input type="hidden" name="id" value="<?=$this->encryption->encrypt($prescription['id'])?>" />  
            <?=form_close()?>
          </div><!-- /.row -->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

      <div class="box default-box">
        <div class="box-body">
          <div class="row">
            <?=form_open('prescription/add_item')?>
              <div class="col-sm-12">
                
                <div class="callout callout-info">
                  <p><i class="fa fa-info-circle"></i> To remove an item, set the quantity to 0.</p>
                </div>
                <label>Item Name</label>
                <div class="input-group">
                  <input type="text" name="item" id="item" class="form-control" required/>
                  <div class="input-group-btn">
                    <input type="hidden" name="id" value="<?=$this->encryption->encrypt($prescription['id'])?>" />
                    <button type="submit" class="btn btn-success">Add Item</button>
                  </div><!-- /btn-group -->
                </div><!-- /input-group -->
              </div><!-- /.col-sm-12 -->
            <?=form_close()?>
          </div><!-- /.row -->
          <hr />
          <div class="row">
            <div class="col-sm-12">
              <?php if ($items): $x=1; ?>
              <table class="table table-bordered table-striped dataTable">
                <thead>
                  <th></th>
                  <th>Item Name</th>
                  <th>Quantity</th>
                  <th>Remarks</th>
                </thead>
                <tbody>
                <?=form_open('prescription/update_items')?>
                <?php foreach ($items AS $item): ?>
                  <tr>
                    <td><?=$x++;?>.</td>
                    <td>
                      <input type="hidden" name="id[]" id="" value="<?=$this->encryption->encrypt($item['id'])?>"/>
                      <input type="text" name="item[]" class="form-control" id="" value="<?=$item['item']?>"/>
                    </td>
                    <td><input type="number" name="qty[]" class="form-control" id="" min="0" value="<?=$item['qty']?>"/></td>
                    <td><input type="text" name="remark[]" class="form-control" id="" value="<?=$item['remark']?>"/></td>
                  </tr>
                <?php endforeach ?>
                <input type="hidden" name="pid" value="<?=$this->encryption->encrypt($prescription['id'])?>" />
                <button type="submit" class="hide">Submit</button>
                <?=form_close()?>
                </tbody>
              </table><!-- /.table table-bordered table-striped -->
              <?php else: ?>
                <div class="alert alert-warning alert-dismissible">
                  <h4><i class="icon fa fa-warning"></i> No Records Found!</h4>
                  No Items found in the System
                </div> 
              <?php endif ?>
            </div><!-- /.col-sm-12 -->
            <div class="col-sm-12">
              <div class="form-group pull-right">
                <a href="<?=current_url()?>/print" target="_blank" class="btn btn-info"><i class="fa fa-print"></i> Print Prescription</a>
              </div>
            </div><!-- /.col-sm-12 -->
          </div><!-- /.row -->
        </div><!-- /.box-body -->
      </div><!-- /.box default-box -->

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
<!-- CKEDITOR -->
<script src="<?=base_url('assets/ckeditor/ckeditor.js')?>"></script>
<script type="text/javascript">
  $(function(){
  $("#item").autocomplete({    
    source: "<?php echo base_url('index.php/prescription/autocomplete');?>" // path to the get_birds method
  });
});
</script>
</body>
</html>
