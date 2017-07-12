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
                    <li><a href="#">Administrative Options</a></li>         
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
                        <th></th>
                        <th>Name</th>
                        <th>Username</th>
                        <th></th>
                    </tr>
                  </thead>

                  <tbody>                    
                    <?php if($results):
                      foreach($results as $row): ?>
                    <tr>
                      <td>
                        <a href="<?=base_url('users/update/' . $row['username'])?>">
                        <?php if(filexist($row['img']) && $row['img']): ?>
                          <img src="<?=base_url('uploads/'.$row['img'])?>" alt="" class="circle responsive-img valign candidate-img">
                        <?php else: ?>
                          <img src="<?=base_url('assets/images/no_image.gif')?>" alt="" class="circle responsive-img valign candidate-img">
                        <?php endif; ?>
                        </a>
                      </td>
                      <td><a href="<?=base_url('users/update/' . $row['username'])?>"><?=$row['name']?></a></td>
                      <td><?=$row['username']?></td>                 
                      <td><?=$row['usertype']?></td>                 
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
                     <h6 class="strong">Register User</h6><!-- /.strong -->
                       <div class="card purple darken-4 white-text">
                         <div class="card-content">
                           <p><i class="mdi-action-info-outline tiny"></i> Every new user that is registered, a default password is set. <br/>
                           The default password is <strong class="amber-text strong">STIDipolog</strong>.</p> <br />
                           <p>Please advise your New User to change his password after logging in.</p>
                         </div><!-- /.card-content -->
                       </div><!-- /.card purple darken-4 white-text -->
                     <?=form_open_multipart('users')?>
                       <div class="row">
                         <div class="input-field col s12">
                            <input id="username" name="username" type="text" class="validate" value="<?=set_value('username')?>" required>
                            <label for="username">Username</label>
                         </div>                         
                       </div><!-- /.row -->
                       <div class="row">
                         <div class="input-field col s12">
                            <input id="name" name="name" type="text" class="validate" value="<?=set_value('name')?>" required>
                            <label for="name">Full Name</label>
                         </div>                         
                       </div><!-- /.row -->
                       <div class="row">
                         <div class="input-field col s12">
                           <div class="file-field input-field">
                            <div class="btn">
                              <span>IMG</span>
                              <input type="file" name="img">
                            </div>
                            <div class="file-path-wrapper">
                              <input class="file-path validate" type="text">
                            </div>
                          </div>
                         </div><!-- /.input-field col s12 l3 -->
                       </div><!-- /.row -->
                       <div class="row">
                         <div class="input-field col s12">                        
                            <div class="select-wrapper">  
                              <select class="browser-default" name="usertype" required>
                                  <option value="" disabled="" selected="">Select Usertype...</option>
                                  <?php 
                                    if($usertypes):
                                    foreach($usertypes as $usr):
                                  ?>
                                  <option value="<?=$usr['title']?>"><?=$usr['title']?></option>
                                  <?php
                                    endforeach;
                                    endif;
                                  ?>
                              </select>
                            </div><!-- /.select-wrapper -->
                            <label>Usertype</label>
                          </div><!-- /.input-field col s12 -->
                       </div><!-- /.row -->         
                       <div class="row">
                          <div class="input-field col s12">
                              <button class="btn cyan waves-effect waves-light right" type="submit" name="action">Submit
                                <i class="mdi-content-send right"></i>
                              </button>
                           </div>
                       </div><!-- /.row -->

                       <input type="hidden" name="key" value="<?=$this->encryption->encrypt('candidate')?>" />
                     <?=form_close()?>
                   </div><!-- /.card-content -->
                 </div><!-- /.card-panel -->       

               </div><!-- /.col s12 l5 -->
             </div><!-- /.row -->
           </div><!-- /.section --> 
         
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