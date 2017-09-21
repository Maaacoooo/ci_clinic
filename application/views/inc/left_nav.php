
<!-- START LEFT SIDEBAR NAV -->
      <aside id="left-sidebar-nav">
          <ul id="slide-out" class="side-nav fixed leftside-navigation">
              <li class="user-details grey lighten-5">
                  <div class="row">
                      <div class="col col s4 m4 l4">
                        <?php
                        //USER PROFILE IMG                          
                          if($user['img'] != NULL)    {
                            echo '<img src="'.base_url('uploads/'.$user['img']).'" alt="" class="circle responsive-img valign profile-image">';
                          } else {
                            echo '<i class="mdi-social-person medium grey lighten-2 circle"></i>';
                          }
                        ?>
                          

                          
                      </div>
                      <div class="col col s8 m8 l8">
                          <ul id="profile-dropdown" class="dropdown-content">                    
                              <li><a href="<?=base_url('settings/profile')?>"><i class="mdi-action-settings"></i>Profile</a>
                              </li>                              
                              <li class="divider"></li>                              
                              <li><a href="<?=base_url('dashboard/logout')?>"><i class="mdi-hardware-keyboard-tab"></i>Logout</a>
                              </li>
                          </ul>
                          <a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" href="#" data-activates="profile-dropdown"><?=$user['name']?><i class="mdi-navigation-arrow-drop-down right"></i></a>
                          <p class="user-roal"><?=$user['usertype']?></p>
                      </div>
                  </div>
              </li>
              <li class="bold"><a href="<?=base_url('dashboard')?>" class="waves-effect waves-cyan"><i class="mdi-action-dashboard"></i> Dashboard</a></li>             
              <li class="li-hover"><div class="divider"></div></li>
              <?php if($user['usertype'] == 'Doctor'): ?>     
              <li class="li-hover"><p class="ultra-small margin more-text">ADMIN OPTIONS</p></li>       
              <li class="bold"><a href="<?=base_url('users/')?>" class="waves-effect waves-cyan"><i class="mdi-action-account-child"></i> System Users</a></li>  
              <li class="li-hover"><div class="divider"></div></li>     
              <?php endif; ?> 
              <li class="li-hover"><p class="ultra-small margin more-text">PATIENTS OPTIONS</p></li>       
              <li class="no-padding">
                  <ul class="collapsible collapsible-accordion">
                      <li class="bold"><a class="collapsible-header waves-effect waves-cyan"><i class="mdi-action-face-unlock"></i> Patients</a>
                          <div class="collapsible-body" style="">
                              <ul>
                                  <li><a href="<?=base_url('patients/create')?>">Register New Patient</a></li>
                                  <li><a href="<?=base_url('patients/')?>">Patient List</a></li>
                              </ul>
                          </div>
                      </li>                     
                  </ul>
              </li>  
              <li class="bold"><a href="<?=base_url('cases')?>" class="waves-effect waves-cyan"><i class="mdi-action-label"></i> Cases</a></li> 
              <li class="bold"><a href="<?=base_url('queues')?>" class="waves-effect waves-cyan" target="_blank"><i class="mdi-action-label"></i> Queues</a></li> 
              <li class="li-hover"><div class="divider"></div></li>     
              <li class="li-hover"><p class="ultra-small margin more-text">CLINIC DATA</p></li>       
              <li class="bold"><a href="<?=base_url('services/clinic')?>" class="waves-effect waves-cyan"><i class="mdi-action-account-child"></i> Clinic Services and Fees</a></li>  
              <li class="bold"><a href="<?=base_url('services/laboratory')?>" class="waves-effect waves-cyan"><i class="mdi-action-account-child"></i> Laboratory Services</a></li>  
              <li class="bold"><a href="<?=base_url('services/immunization')?>" class="waves-effect waves-cyan"><i class="mdi-action-account-child"></i> Immunization Services</a></li>  
              <li class="li-hover"><div class="divider"></div></li>            
          </ul>         
          <a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only grey darken-4"><i class="mdi-navigation-menu" ></i></a>
      </aside> 
      <!-- END LEFT SIDEBAR NAV-->


     