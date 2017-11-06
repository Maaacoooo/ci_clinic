<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <title><?=$title?> &middot; <?=$site_title?></title>

    <?php $this->load->view('inc/css'); ?>


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
                <h5 class="title">Prescription</h5><!-- /.title -->
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
          </div>

          <div class="section">
            <div class="row">
              <div class="col s12">
                <div class="card">
                  <div class="card-content">
                    <div class="row">
                      <div class="input-field col s12">
                        <input type="text" name="case" id="case" value="#<?=prettyID($case['id'])?>- <?=$case['title']?>" class="validate" readonly="" />
                        <label for="case">Case</label>
                      </div><!-- /.input-field col s12 -->
                    </div><!-- /.row -->
                    <div class="row">
                      <div class="input-field col s12">
                        <input type="text" name="title" id="title" value="<?=$prescription['title']?>" class="validate" readonly="" />
                        <label for="title">Prescription Title</label>
                      </div><!-- /.input-field col s12 -->
                    </div><!-- /.row -->
                    <div class="row">
                      <div class="input-field col s12">
                        <textarea name="description" id="description" readonly="" cols="30" rows="10" class="materialize-textarea"><?=strip_tags($prescription['description'])?></textarea>
                        <label for="description">Description / Notes</label>
                      </div><!-- /.input-field col s12 -->
                    </div><!-- /.row -->
                    <div class="row">
                      <div class="col s12">
                        <table class="card striped bordered">
                          <thead>                            
                            <tr>
                              <th width="1%"></th>
                              <th>Item Name</th>
                              <th width="10%">QTY</th>
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
                                  <?=$item['item']?>
                                    </td>
                                    <td>
                                      <?=$item['qty']?>
                                    </td>
                                    <td>
                                     <?=$item['remark']?>
                                    </td>                                    
                                  </tr>                                  
                                <?php endforeach ?>                               
                                <?=form_close()?>
                              <?php else: ?>
                                <tr>
                                  <td colspan="4">No items found! qweqwe</td>
                                </tr>
                              <?php endif ?>
                            </tbody>
                        </table><!-- /.striped bordered -->
                      </div><!-- /.col s12 -->
                    </div><!-- /.row -->
                    <div class="row">
                      <div class="col s12 input-field">
                        <input type="text" name="issue" id="issue" value="<?=$prescription['issuer']?>" class="validate" readonly="" />
                        <label for="issue">Issued by</label>
                      </div><!-- /.col s12 input-field -->
                    </div><!-- /.row -->
                    <div class="row">
                      <div class="col s12">
                        <span class="badge-label green darken-3">Registered: <?=$prescription['created_at']?></span>
                        <?php if ($prescription['updated_at']): ?>
                        <span class="badge-label grey darken-3 right">Last Updated: <?=$prescription['updated_at']?></span>                          
                        <?php endif ?>
                      </div><!-- /.col s12 -->
                    </div><!-- /.row -->
                  </div><!-- /.card-content -->
                </div><!-- /.card -->
              </div><!-- /.col s12 -->
            </div><!-- /.row -->

            <div class="row">
              <div class="col s12">
                <a href="<?=current_url()?>/print" class="btn-flat waves-effect light-blue white-text right" target="_blank"><i class="mdi-communication-comment left"></i> Print</a>
              </div><!-- /.col s12 -->
            </div><!-- /.row -->
          </div><!-- /.section -->
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
   
</body>
</html>