<!-- Logo -->
    <a href="<?=base_url('dashboard')?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>C</b>S</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Clinic</b>System</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">     
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <?php if (filexist($user['img']) && $user['img']): ?>
                <img src="<?=base_url('uploads/'.$user['img'])?>" class="user-image" alt="User Image">
              <?php else: ?>
                <img src="<?=base_url('assets/img/user.png')?>" class="user-image" alt="User Image">                
              <?php endif ?>
              <span class="hidden-xs"><?=$user['name']?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <?php if (filexist($user['img']) && $user['img']): ?>
                  <img src="<?=base_url('uploads/'.$user['img'])?>" class="img-circle" alt="User Image">
                <?php else: ?>
                  <img src="<?=base_url('assets/img/no_image.gif')?>" class="img-circle" alt="User Image">                
                <?php endif ?>

                <p>
                  <?=$user['name']?>
                  <small><?=$user['usertype']?></small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?=base_url('settings/profile')?>" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?=base_url('dashboard/logout')?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>