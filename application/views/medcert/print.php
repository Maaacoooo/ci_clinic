<!DOCTYPE html>
<html>
<head>
	<title><?=$title?> &middot; <?=$site_title?></title>
	<link rel="stylesheet" href="<?=base_url('assets/css/print.css')?>" />
</head>
<body onload="window.print()">
	
	<?php $this->load->view('inc/print_header');?>
	
	<h5 class="text-right">CERT #<?=prettyID($medcert['cert_id'])?></h5><!-- /.text-right -->
	<div class="container">
		<h3 class="text-center">Medical Certificate</h3>
		
		<div class="content">
			<p class="text-center" style="width: 80%; margin: auto;">This is to certify that <span class="strong underlined"><?php if($info['sex'])echo 'Mr.'; else echo 'Ms.'; ?> <?=$info['fullname'] . ' ' . $info['middlename'] . ' ' . $info['lastname']?></span>
                        of <span class="underlined">
                          <?php 
                        if($addr['building']) {
                          echo $addr['building'] . ', ';
                        } 
                        if($addr['street']) {
                          echo $addr['street'] . ', ';
                        }
                        if($addr['barangay']) {
                          echo $addr['barangay'] . ', ';
                        }
                        if($addr['city']) {
                          echo $addr['city'] . ', ';
                        }
                        if($addr['province']) {
                          echo $addr['province'] . ', ';
                        }
                        if($addr['zip']) {
                          echo $addr['zip'] . ', ';
                        }
                        if($addr['country']) {
                          echo $addr['country'];
                        }
                        ?>
                        </span> has been diagnosed last <span class="strong underlined"><?=nice_date($medcert['case_date'], 'M. d, Y')?></span> of <span class="strong underlined"><?=$medcert['title']?></span>
                        <br />
                        <br />
                        <span class="strong">Remarks and Recommendations</span> <br />
              </p>
              <p style="width: 60%; margin: auto;">
                <?=$medcert['remarks']?> 
              </p>

		</div><!-- /.content -->


		<div class="signature-container">			
			<div class="signature" style="width: 200px;">
				<span class="signee">Dr. <?=$medcert['doctor']?></span>
				<span class="signee-title">Attending Physician</span>
			</div><!-- /.signature -->
		</div><!-- /.signature-container -->

		<small class="print-stamp">Printed: <?=unix_to_human(now())?> <br/> Certificate is not valid without the signature of the Attending Physician</small>

	</div><!-- /.container -->
</body>
</html>