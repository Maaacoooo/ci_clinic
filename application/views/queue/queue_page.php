<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="msapplication-tap-highlight" content="no">
  <title><?=$title?> &middot; <?=$site_title?></title>

  <!-- Favicons-->
  <link rel="icon" href="<?=base_url('assets/images/favicon/sti_45x45.png')?>" sizes="45x45">
  <link href="<?=base_url('assets/css/page.css')?>" type="text/css" rel="stylesheet" media="screen,projection">

  <!-- CORE CSS-->

  <link href="<?=base_url('assets/css/materialize.css')?>" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="<?=base_url('assets/css/style.css')?>" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="<?=base_url('assets/css/page-center.css')?>" type="text/css" rel="stylesheet" media="screen,projection">

  <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
  <link href="<?=base_url('assets/css/prism.css')?>" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="<?=base_url('assets/js/plugins/perfect-scrollbar/perfect-scrollbar.css')?>" type="text/css" rel="stylesheet" media="screen,projection">
  
</head>

<body class="indigo darken-2">
  <!-- Start Page Loading 
  <div id="loader-wrapper">
      <div id="loader"></div>        
      <div class="loader-section section-left"></div>
      <div class="loader-section section-right"></div>
  </div>
  <!-- End Page Loading -->


    <div class="col s12 m8 l6 z-depth-4 card-panel login-border vote-container">
        
         <div class="row">
             <div class="col s12">
             <?php if ($serving): ?>
                <div class="card light-green lighten-5">
                 <div class="card-content">
                   <div class="row">                       
                     <div class="col s12">
                        <?php foreach ($serving as $serv): ?>
                          <h5 class="badge-label green darken-3 left">Now Serving</h5> 
                          <h5> <?=$serv['patient']?> - Case #<?=prettyID($serv['case_id'])?></h5>                          
                        <?php endforeach ?>
                     </div><!-- /.col s8 -->          
                   </div><!-- /.row -->
                 </div><!-- /.card-content -->
               </div><!-- /.card -->
             <?php else: ?>  
               <div class="card grey lighten-1">
                 <div class="card-content">
                    <div class="row">
                      <div class="col s12">
                        <h5 class="badge-label grey darken-4 left">Not Serving</h5> <h5 class="header">Not Serving Any Queues.</h5>                        
                      </div><!-- /.col s10 -->                      
                    </div><!-- /.row -->
                 </div><!-- /.card-content -->
               </div><!-- /.card -->
             <?php endif ?>               
             </div><!-- /.col s12 -->
           </div><!-- /.row -->



           <div class="row">
             <div class="col s12">
               <div class="card">
                 <div class="card-content">                 
                 <?php if ($queue): ?>                   
                    <table class="striped bordered">
                      <thead>
                        <tr>
                          <th>Patient Name</th>
                          <th>Case</th>                        
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($queue as $q): ?>
                          <tr>
                            <td><?=$q['patient']?></td>
                            <td>Case #<?=prettyID($q['case_id'])?></td>                            
                          </tr>
                        <?php endforeach ?>
                      </tbody>
                    </table><!-- /.striped bordered -->
                 <?php else: ?>
                   <h5 class="header">No Pending Queues...</h5><!-- /.header -->                  
                 <?php endif ?>
                 </div><!-- /.card-content -->
               </div><!-- /.card -->
             </div><!-- /.col s12 -->
           </div><!-- /.row -->

 
      <?php $this->load->view('inc/copy_footer');?>
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