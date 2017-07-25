<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <title><?=$title?> &middot; <?=$site_title?></title>

    <?php $this->load->view('inc/css'); ?>

    <script type="text/javascript">
      function enablereset() {
        if(document.getElementById("resetpass").checked == true) {
          document.getElementById("oldpass").disabled = false; 
          document.getElementById("newpass").disabled = false; 
          document.getElementById("confpass").disabled = false; 
        } else {
          document.getElementById("oldpass").disabled = true; 
          document.getElementById("newpass").disabled = true; 
          document.getElementById("confpass").disabled = true; 
        }
      }
    </script>
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
            <?=form_open_multipart('settings/profile')?>
              <div class="col s12 l8">
                <div class="card-panel">
                  <div class="card-content">
                    <div class="row">
                      <div class="col s5 l4">
                        <?php if(filexist($user['img']) && $user['img']): ?>
                          <img src="<?=base_url('uploads/'.$user['img'])?>" alt="" class="responsive-img">
                        <?php else: ?>
                          <img src="<?=base_url('assets/images/no_image.gif')?>" alt="" class="responsive-img valign">
                        <?php endif; ?>

                        <div class="file-field input-field">
                            <div class="btn">
                              <span>IMG</span>
                              <input type="file" name="img">
                            </div>
                            <div class="file-path-wrapper">
                              <input class="file-path validate" type="text">
                            </div>
                          </div>
                      </div><!-- /.col s5 l4 -->
                      <div class="col s7 l8">
                          <div class="row">
                            <div class="col s12 card purple darken-2 white-text">
                              <div class="card-content">
                                
                                <p><small>What you can modify is your name, profile picture and password only.</small>
                                </p>
                              </div><!-- /.card-content -->
                            </div><!-- /.col s12 card-panel purple darken-2 white-text -->
                          </div><!-- /.row -->
                          <div class="input-field col s12">
                            <input type="text" name="" id="" class="validate" value="<?=$user['username']?>" disabled="" />
                            <label for="">Username</label>
                          </div><!-- /.input-field col s12 -->
                          <div class="input-field col s12">
                            <input type="text" name="name" id="" class="validate" value="<?=$user['name']?>"  required/>
                            <label for="">Full Name</label>
                          </div><!-- /.input-field col s12 -->
                          <div class="input-fielf col s12">
                            <div class="right">
                              <input type="checkbox" id="resetpass" name="resetpass" onclick="enablereset()">
                              <label for="resetpass">Reset Password</label>
                            </div><!-- /.right -->
                          </div><!-- /.input-fielf col s12 -->
                          <div class="input-field col s12">
                            <input type="password" name="oldpass" id="oldpass" class="validate" disabled="" required/>
                            <label for="">Old Password</label>
                          </div><!-- /.input-field col s12 -->
                          <div class="input-field col s12">
                            <input type="password" name="newpass" id="newpass" class="validate" disabled="" required/>
                            <label for="">New Password</label>
                          </div><!-- /.input-field col s12 -->
                          <div class="input-field col s12">
                            <input type="password" name="confpass" id="confpass" class="validate" disabled="" required/>
                            <label for="">Confirm New Password</label>
                          </div><!-- /.input-field col s12 -->
                          <div class="input-field col s12">
                            <button type="submit" class="btn waves-effect amber right">Update Profile</button>
                          </div><!-- /.input-field col s12 -->
                      </div><!-- /.col s7 l8 -->
                    </div><!-- /.row -->
                  </div><!-- /.card-content -->
                </div><!-- /.card-panel -->
              </div><!-- /.col s12 l8 -->
            <?=form_close()?>
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
   
</body>
</html>