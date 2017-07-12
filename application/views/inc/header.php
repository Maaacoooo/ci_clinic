
    <!-- //////////////////////////////////////////////////////////////////////////// -->

    <!-- START HEADER -->
    <header id="header" class="page-topbar">
        <!-- start header nav-->
        <div class="navbar-fixed">
            <nav class="cyan border-bottom-sti">
                <div class="nav-wrapper">
                    <h1 class="logo-wrapper"><a href="<?php echo base_url('dashboard'); ?>" class="brand-logo darken-1"><img src="<?=base_url('assets/images/health_logo_40.png')?>" ></a> <span class="logo-text"><?=$site_title?></span></h1>
                    <ul class="right hide-on-med-and-down">
                        <li class="search-out">
                            <?=form_open('alumni/search')?>
                                <input type="text" name="search" class="search-out-text">
                            </form>
                        </li>
                        <li>    
                            <a href="javascript:void(0);" class="waves-effect waves-block waves-light show-search"><i class="mdi-action-search"></i></a>                              
                        </li>
                        <li><a href="javascript:void(0);" class="waves-effect waves-block waves-light toggle-fullscreen"><i class="mdi-action-settings-overscan"></i></a>
                        </li>                        
                    </ul>
                </div>
            </nav>
        </div>
        <!-- end header nav-->
    </header>
    <!-- END HEADER -->