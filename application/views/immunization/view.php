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
               <div class="col s12 l8">
                 <table class="striped bordered">
                   <tr>
                     <th>Patient Name</th>
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
                         <span class="badge-label grey darken-3">Cancelled</span>     
                       <?php elseif($immu['status'] == 1): ?>
                         <span class="badge-label green darken-3">Served</span>                                   
                       <?php else: ?> 
                         <span class="badge-label red darken-3">Pending</span> 
                       <?php endif ?>
                     </td>
                   </tr>
                   <tr>
                     <th>Requested by</th>
                     <td><?=$immu['user']?></td>
                   </tr>
                   <tr>
                     <th>Request Description / Remarks</th>
                     <td><a href="#updateRemarks" class="modal-trigger"><small>[Update]</small></a></td>
                   </tr>
                   <tr>
                     <td colspan="2"><?=$immu['description']?></td>
                   </tr>                 
                 </table><!-- /.striped bordered -->
                 <small><em>Created at <?=$immu['created_at']?></em></small>
                 <?php if ($immu['updated_at']): ?>
                 <small class="right"><em>Last updated <?=$immu['updated_at']?></em></small>                 
                 <?php endif ?>
               </div><!-- /.col s12 l8 -->
               <?php if (!$immu['status']): ?>
               <div class="col s12 l4">
                 <div class="card">
                   <div class="card-content">
                     <h6 class="strong header">Options</h6><!-- /.strong header -->
                     <br />                          
                     <div class="row">
                       <a href="#changeStatus" class="modal-trigger btn waves-effect amber col s8 offset-s2">Change Status</a>   
                     </div><!-- /.row -->  
                   </div><!-- /.card-content -->
                 </div><!-- /.card -->
               </div><!-- /.col s12 l4 -->
               <?php endif ?>               
             </div><!-- /.row --> 
        
          <?php if (!$immu['status']): ?>
            <div id="changeStatus" class="modal">
              <?=form_open('immunization/change_status')?>
                <div class="modal-content">
                    <div class="row">
                      <h5 class="header">Change Status</h5><!-- /.header -->
                      <div class="col s6">                         
                         <p><i class="mdi-action-info-outline tiny"></i> Once the Laboratory Request is set to <span class="badge-label green darken-3">served</span>, 
                         the system will automatically add this Service to the current Open Billing Record. </p> 
                         <p>These actions cannot be undone.</p>
                      </div><!-- /.col s12 -->  
                      <div class="col s6">
                        <p>This changes the status of the Laboratory Request.</p>                       
                         <input name="status" type="radio" id="pending" value="<?=$this->encryption->encrypt(0)?>" class="with-gap" <?php if ($case['status'] == 0)echo'checked';?>>
                         <label for="pending">Pending</label>
                         <input name="status" type="radio" id="served" value="<?=$this->encryption->encrypt(1)?>" class="with-gap" <?php if ($case['status'] == 1)echo'checked';?>>
                         <label for="served">Served</label>
                         <input name="status" type="radio" id="cancel" value="<?=$this->encryption->encrypt(3)?>" class="with-gap" <?php if ($case['status'] == 3)echo'checked';?>>
                         <label for="cancel">Cancelled</label>
                      </div><!-- /.col s6 -->                    
                    </div><!-- /.row -->
                    <input type="hidden" name="id" value="<?=$this->encryption->encrypt($immu['immu_id'])?>" />
                  </div>
                  <div class="modal-footer grey darken-4">
                    <a href="#" class="waves-effect waves-red btn-flat red-text strong modal-action modal-close">Cancel</a>
                    <button type="submit" class="waves-effect waves-red btn amber modal-action">Change</button>
                  </div>
              <?=form_close()?>
            </div>
          <?php endif ?>           

            <div id="updateRemarks" class="modal">
              <?=form_open('immunization/update')?>
                <div class="modal-content">
                    <h5 class="header">Update Description</h5><!-- /.header -->
                    <div class="row">
                      <div class="col s12">
                        <label>Description</label>
                        <textarea name="description" id="description" cols="30" rows="10" class="ckeditor"><?=$immu['description']?></textarea>
                      </div><!-- /.col s12 -->                     
                    </div><!-- /.row -->
                    <input type="hidden" name="id" value="<?=$this->encryption->encrypt($immu['immu_id'])?>" />
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
    <script src="<?=base_url('assets/ckeditor/ckeditor.js')?>"></script>

</body>
</html>

