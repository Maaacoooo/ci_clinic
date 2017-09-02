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


</head>

<body>
    
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
                    <li><a href="<?=base_url('patients/view/'.$info['id'])?>"><?=$info['fullname'] . ' ' . $info['lastname']?></a></li>
                    <li><a href="<?=base_url('patients/view/'.$info['id'].'/case/'.$case['id'])?>"><?=$case['title']?></a></li>
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
              <div class="col s12">
                <div class="card">
                  <div class="card-content">
                    <div class="row">
                      <?=form_open('prescription/update')?>
                      <h5 class="header">Prescription</h5><!-- /.header -->
                      <div class="input-field col s12">
                        <input type="text" name="title" id="title" class="validate" value="<?=$prescription['title']?>" />
                        <label for="title">Title</label>
                      </div><!-- /.input-field col s12 -->
                      <div class="input-field col s12">
                        <textarea name="description" id="" cols="30" rows="10" class="ckeditor"><?=$prescription['description']?></textarea>
                      </div><!-- /.input-field col s12 -->
                      <div class="input-field col s12">
                        <button type="submit" class="btn waves-effect amber right">Update Prescription</button>
                      </div><!-- /.input-field col s12 -->
                        <input type="hidden" name="id" value="<?=$this->encryption->encrypt($prescription['id'])?>" />                      
                      <?=form_close()?>
                    </div><!-- /.row -->
                  </div><!-- /.card-content -->
                </div><!-- /.card -->
              </div><!-- /.col s12 -->
            </div><!-- /.row -->
            
            <div class="row">
              <div class="col s12">
                <div class="card">
                  <div class="card-content">
                      <div class="row">
                        <p>To remove an item, set the quantity to 0.</p>
                        <?=form_open('prescription/add_item')?>
                        <div class="input-field col s10">
                          <input type="text" name="item" id="item" class="validate" />
                          <label for="">Item</label>
                        </div><!-- /.input-field -->
                        <input type="hidden" name="id" value="<?=$this->encryption->encrypt($prescription['id'])?>" />
                        <div class="input-field col s2">
                          <button type="submit" class="btn waves-effect green">Add item</button>
                        </div><!-- /.input-field -->
                        <?=form_close()?>
                      </div><!-- /.row -->
                      <div class="divider"></div><!-- /.divider -->
                      <div class="row">
                        <div class="col s12">
                          <table class="bordered striped">
                            <thead>
                              <tr>
                                <th width="5"></th>
                                <th>Item Name</th>
                                <th width="15%">Qty</th>
                                <th>Remarks</th>                                
                              </tr>
                            </thead>
                            <tbody>
                              <?php if ($items): $x=1; ?>
                                <?=form_open('prescription/update_items')?>
                                <?php foreach ($items as $item): ?>
                                  <tr>
                                    <td><?=$x++?>.</td>
                                    <td>
                                      <input type="text" name="item[]" id="" class="validate" value="<?=$item['item']?>"/>
                                    </td>
                                    <td>
                                      <input type="number" name="qty[]" id="" class="validate" value="<?=$item['qty']?>"/>
                                    </td>
                                    <td>
                                      <input type="text" name="remark[]" id="" class="validate" value="<?=$item['remark']?>"/>
                                    </td>                                    
                                  </tr>                                  
                                <?php endforeach ?>
                                <input type="hidden" name="pid" value="<?=$this->encryption->encrypt($prescription['id'])?>" />
                                <button type="submit" class="hide">submit</button>
                                <?=form_close()?>
                              <?php else: ?>
                                <tr>
                                  <td colspan="4">No items found!</td>
                                </tr>
                              <?php endif ?>
                            </tbody>
                          </table><!-- /.bordered striped -->
                        </div><!-- /.col s12 -->
                      </div><!-- /.row -->
                  </div><!-- /.card-content -->
                </div><!-- /.card -->
              </div><!-- /.col s12 -->
            </div><!-- /.row -->
            
            <div class="row">
              <div class="col s12">
                <a href="<?=current_url()?>/print" class="btn-flat waves-effect light-blue white-text right" target="_blank"><i class="mdi-communication-comment left"></i> Print Prescription</a>
              </div><!-- /.col s12 -->
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