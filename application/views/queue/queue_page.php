<html>
  <head>
    <title><?=$title?> - <?=$site_title?></title>
    <!-- CSS STYLE -->
    <link rel="stylesheet" href="<?=base_url('assets/custom/css/this-custom/style.css')?>">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?=base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css')?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?=base_url('assets/dist/css/AdminLTE.min.css')?>">

  </head>

  <body>

    <section class="content">
      <div class="box box-success green">
        <div class="box-body addheight">
        <?php if ($serving): ?>
          <div class="col-sm-12"> 
            <div class="box-body card">
            <?php foreach ($serving as $serv): ?>
              <div class="col-sm-4">
                <h1><span class="label bg-green">Now Serving</span></h1> 
              </div><!-- /.col-sm-4 -->   
              <div class="col-sm-8">
                <h3><?=$serv['patient']?> - Case #<?=prettyID($serv['case_id'])?></h3>
              </div><!-- /.col-sm-8 -->                   
            <?php endforeach ?>
            </div>
          </div><!-- /.col-sm-12 -->
        <?php else: ?>
          <div class="col-sm-12"> 
            <div class="box-body card">
              <div class="col-sm-4">
                <h1><span class="label bg-maroon">Not Serving</span></h1> 
              </div><!-- /.col-sm-4 -->   
              <div class="col-sm-8">
                <h3>Not Serving Any Queues.</h3>
              </div><!-- /.col-sm-8 -->                   
            </div>
          </div><!-- /.col-sm-12 --> 
        <?php endif ?>
          <div class="col-sm-12"> 
            <div class="box-body card">
              <div class="col-sm-12">
                <?php if ($queue): ?>
                  <table class="table table-condensed table-bordered">
                    <thead>
                      <tr>
                        <th>Patient Name</th>
                        <th>Case</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($queue AS $q): ?>
                      <tr>
                        <td><?=$q['patient']?></td>
                        <td>Case #<?=prettyID($q['case_id'])?></td>
                      </tr>
                    <?php endforeach ?>
                    </tbody>
                  </table><!-- /.table table-condensed table-bordered -->
                <?php else: ?>

                <h4><em>No Pending Queues...</em></h4>
                <?php endif ?>
              </div><!-- /.col-sm-12 -->                   
            </div>
          </div><!-- /.col-sm-12 --> 
        </div><!-- /.box-body -->
        <div class="box-footer">
          <div class="aligncenter">
            <small>Developed by <a href="#">Maco</a> &copy; STI Gensan 2017</small>
          </div><!-- /.aligncenter -->
        </div><!-- /.box-footer -->
      </div><!-- /.box box-warning -->
    </section><!-- /.content -->

    <!-- jQuery 3 -->
    <script src="<?=base_url('assets/bower_components/jquery/dist/jquery.min.js')?>"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="<?=base_url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js')?>"></script>
    <!-- AdminLTE App -->
    <script src="<?=base_url('assets/dist/js/adminlte.min.js')?>"></script>

  </body>
</html>