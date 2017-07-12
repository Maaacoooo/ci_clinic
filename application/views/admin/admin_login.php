<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="msapplication-tap-highlight" content="no">
  <title><?=$title?> &middot; <?=$site_title?> </title>

   <!-- Favicons-->
  <link rel="icon" href="<?=base_url('assets/images/favicon/sti.png')?>" sizes="32x32">
  <!-- Favicons-->

  <link href="<?=base_url('assets/css/page.css')?>" type="text/css" rel="stylesheet" media="screen,projection">

  <!-- CORE CSS-->

  <link href="<?=base_url('assets/css/materialize.css')?>" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="<?=base_url('assets/css/style.css')?>" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="<?=base_url('assets/css/page-center.css')?>" type="text/css" rel="stylesheet" media="screen,projection">

  <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
  <link href="<?=base_url('assets/css/prism.css')?>" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="<?=base_url('assets/js/plugins/perfect-scrollbar/perfect-scrollbar.css')?>" type="text/css" rel="stylesheet" media="screen,projection">
  
</head>

<body class="light-blue lighten-5">
  <!-- Start Page Loading -->
  <div id="loader-wrapper">
      <div id="loader"></div>        
      <div class="loader-section section-left"></div>
      <div class="loader-section section-right"></div>
  </div>
  <!-- End Page Loading -->



  <div id="login-page" class="row">
    <div class="col s12 z-depth-4 card-panel login-border">

      <?=form_open('dashboard/login', array('class' => 'login-form'))?>
        <div class="row">
          <div class="input-field col s12 center">
            <img src="<?=base_url()?>assets/images/health_logo.png" alt="" class="responsive-img valign">
            <p class="center login-form-text"><?=$site_title?></p>
          </div>
        </div>
        <div class="row margin center">  
          <?php if($this->session->flashdata('success')): //SUCCESS ACTION  ?>
              <div class="card-panel green">
                 <span class="white-text"><i class="mdi-action-done tiny"></i> <?php echo $this->session->flashdata('success'); ?></span>
              </div>
          <?php endif; ?> 
          <?php if($this->session->flashdata('error')): //SUCCESS ACTION  ?>
              <div class="card-panel red">
                 <span class="white-text"><i class="mdi-alert-warning tiny"></i> <?php echo $this->session->flashdata('error'); ?></span>
              </div>
          <?php endif; ?>   
          <?php   
             $this->form_validation->set_error_delimiters('', '');          
            if(validation_errors()): ?>
              <div class="card-panel red">              
                 <span class="white-text"><i class="mdi-alert-warning tiny"></i> <?php echo validation_errors(); ?></span> 
              </div>               
          <?php endif; ?> 
        </div>
        <div class="row margin">
          <div class="input-field col s12">
            <i class="mdi-social-person-outline prefix"></i>
            <input id="username" type="text" name="username" class="validate" autocomplete="off" required>
            <label for="username" class="center-align">Username</label>
          </div>
        </div>
        <div class="row margin">
          <div class="input-field col s12">
            <i class="mdi-action-lock-outline prefix"></i>
            <input id="password" type="password" name="password" class="validate" required>
            <label for="password">Password</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <button type="submit" class="btn waves-effect grey darken-3 col s12">Login</button>
          </div>
        </div>        
      </form>

      <?php $this->load->view('inc/copy_footer');?>
    </div>
  </div>

    <!-- ================================================
    Scripts
    ================================================ -->

    <!-- jQuery Library -->
    <script type="text/javascript" src="<?=base_url('assets/js/jquery-1.11.2.min.js')?>"></script>
    <!--materialize js-->
    <script type="text/javascript" src="<?=base_url('assets/js/materialize.js')?>"></script>
    <!--prism-->
    <script type="text/javascript" src="<?=base_url('assets/js/prism.js')?>"></script>
    <!--scrollbar-->
    <script type="text/javascript" src="<?=base_url('assets/js/plugins/perfect-scrollbar/perfect-scrollbar.min.js')?>"></script>

    <!--plugins.js - Some Specific JS codes for Plugin Settings-->
    <script type="text/javascript" src="<?=base_url('assets/js/plugins.js')?>"></script>

</body>
</html>