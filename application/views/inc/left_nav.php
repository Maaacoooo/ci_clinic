  <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <?php if (filexist($user['img']) && $user['img']): ?>
            <img src="<?=base_url('uploads/'.$user['img'])?>" class="img-circle" alt="User Image">
          <?php else: ?>
            <img src="<?=base_url('assets/img/no_image.gif')?>" class="img-circle" alt="User Image">                
          <?php endif ?>
        </div>
        <div class="pull-left info">
          <p><?=$user['name']?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li><a href="<?=base_url('dashboard')?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>  
        <?php if($user['usertype'] == 'Doctor'): ?>       
        <li class="header">ADMIN OPTIONS</li>
        <li><a href="<?=base_url('users/')?>"><i class="fa fa-users"></i> <span>System Users</span></a></li>   
        <?php endif; ?>  
        <li class="header">PATIENTS OPTIONS</li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-child"></i> <span>Patients</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?=base_url('patients/create')?>"><i class="fa fa-user-plus"></i> <span>Register New Patient</span></a></li>
            <li><a href="<?=base_url('patients/')?>"><i class="fa fa-list-alt"></i> <span>Patient List</span></a></li>
          </ul>
        </li>   
        <li><a href="<?=base_url('billing')?>"><i class="fa fa-credit-card"></i> <span>Billing</span></a></li>  
        <li><a href="<?=base_url('cases')?>"><i class="fa fa-book"></i> <span>Cases</span></a></li>
        <li><a href="<?=base_url('laboratory')?>"><i class="fa fa-flask"></i> <span>Laboratory Requests</span></a></li>
        <li><a href="<?=base_url('immunization')?>"><i class="fa fa-heart"></i> <span>Immunization Requests</span></a></li>
        <li><a href="<?=base_url('queues')?>"><i class="fa fa-bookmark"></i> <span>Queues</span></a></li>
        <li class="header">CLINIC DATA</li>
        <li><a href="<?=base_url('services/clinic')?>"><i class="fa fa-circle-o text-red"></i> <span>Clinic Services and Fees</span></a></li> 
        <li><a href="<?=base_url('services/laboratory')?>"><i class="fa fa-circle-o text-yellow"></i> <span>Laboratory Services</span></a></li> 
        <li><a href="<?=base_url('services/immunization')?>"><i class="fa fa-circle-o text-aqua"></i> <span>Immunization Services</span></a></li> 
 
      </ul>
    </section>
    <!-- /.sidebar -->