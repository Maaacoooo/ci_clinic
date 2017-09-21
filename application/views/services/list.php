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
                    <li><a href="#">Clinic Data</a></li>         
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
            
          <div class="section">
             <div class="row">
               <div class="col s12 l7">   
                <table class="striped bordered highlight">
                 <thead>
                    <tr>
                        <th>Service</th>
                       <th>Code</th>
                       <th>Amount</th>
                        <th></th>
                    </tr>
                  </thead>
                  <tbody>                    
                    <?php if($results):
                      foreach($results as $row): ?>
                    <tr>
                      <td><a href="#updateModal<?=$row['id']?>" class="modal-trigger"><?=$row['title']?></a></td>                 
                      <td><a href="#updateModal<?=$row['id']?>" class="modal-trigger"><?=$row['code']?></a></td>                 
                      <td><a href="#updateModal<?=$row['id']?>" class="modal-trigger"><?=$row['amount']?></a></td>    
                      <td><a href="#deleteModal<?=$row['id']?>" class="modal-trigger btn waves-effect red"><i class="mdi-action-delete"></i></a></td>                        
                    </tr> 
                    <?php endforeach; 
                      endif; ?>            
                  </tbody>
                </table>
                <div class="right">
                    <?php foreach ($links as $link) { echo $link; } ?>
                </div>
                 
               </div><!-- /.col s12 l7 -->
               <div class="col s12 l5">                
                 <div class="card-panel">
                   <div class="card-content">
                     <h6 class="strong">Register New Service</h6><!-- /.strong -->                      
                     <?=form_open('services/'.$tag)?>
                       <div class="row">
                         <div class="input-field col s12">
                            <input id="title" name="title" type="text" class="validate" value="<?=set_value('title')?>" required>
                            <label for="title">Title</label>
                         </div>                         
                       </div><!-- /.row -->
                       <div class="row">
                         <div class="input-field col s12 l8">
                            <input id="code" name="code" type="text" class="validate" value="<?=set_value('code')?>">
                            <label for="code">Service Code</label>
                         </div>  
                         <div class="input-field col s12 l4">
                            <input id="amount" name="amount" type="number" class="validate" value="<?=set_value('amount')?>" required>
                            <label for="amount">Amount</label>
                         </div>                         
                       </div><!-- /.row --> 
                       <div class="row">
                          <div class="input-field col s12">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="materialize-textarea"></textarea>
                          </div><!-- /.input-field col s12 -->
                       </div><!-- /.row -->                      
                       <div class="row">
                          <div class="input-field col s12">
                              <button class="btn cyan waves-effect waves-light right" type="submit" name="action">Submit
                                <i class="mdi-content-send right"></i>
                              </button>
                           </div>
                       </div><!-- /.row -->
                     <?=form_close()?>
                   </div><!-- /.card-content -->
                 </div><!-- /.card-panel -->       

               </div><!-- /.col s12 l5 -->
             </div><!-- /.row -->
           </div><!-- /.section --> 


           <?php foreach ($results as $row): ?>
             <div id="deleteModal<?=$row['id']?>" class="modal">
              <?=form_open('services/delete')?>
                <div class="modal-content red darken-4 white-text">
                    <p>Are you sure to delete the record of <span class="strong"><?=$row['title']?></span>?</p>
                    <p>You <span class="strong">CANNOT UNDO</span> this action.</p>
                    <input type="hidden" name="id" value="<?=$this->encryption->encrypt($row['id'])?>" />
                  </div>
                  <div class="modal-footer grey darken-4">
                    <a href="#" class="waves-effect waves-red btn-flat amber-text strong modal-action modal-close">Cancel</a>
                    <button type="submit" class="waves-effect waves-red btn red modal-action">Delete</button>
                  </div>
              <?=form_close()?>
            </div>

            <div id="updateModal<?=$row['id']?>" class="modal">
              <?=form_open('services/update')?>
                <div class="modal-content">
                      <div class="row">
                         <div class="input-field col s12">
                            <input id="title" name="title" type="text" class="validate" value="<?=$row['title']?>" required>
                            <label for="title">Title</label>
                         </div>                         
                       </div><!-- /.row -->
                       <div class="row">
                         <div class="input-field col s12 l8">
                            <input id="code" name="code" type="text" class="validate" value="<?=$row['code']?>">
                            <label for="code">Service Code</label>
                         </div>  
                         <div class="input-field col s12 l4">
                            <input id="amount" name="amount" type="number" class="validate" value="<?=$row['amount']?>" required>
                            <label for="amount">Amount</label>
                         </div>                         
                       </div><!-- /.row --> 
                       <div class="row">
                          <div class="input-field col s12">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="materialize-textarea"><?=$row['description']?></textarea>
                          </div><!-- /.input-field col s12 -->
                       </div><!-- /.row -->                    
                      
                    <input type="hidden" name="id" value="<?=$this->encryption->encrypt($row['id'])?>" />
                  </div>
                  <div class="modal-footer grey darken-4">
                    <a href="#" class="waves-effect waves-red btn-flat amber-text strong modal-action modal-close">Cancel</a>
                    <button type="submit" class="waves-effect waves-amber btn amber modal-action">Update</button>
                  </div>
              <?=form_close()?>
            </div>
           <?php endforeach ?>
         
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
   
</body>
</html>