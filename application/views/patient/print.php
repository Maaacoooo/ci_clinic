<!DOCTYPE html>
<html>
<head>
	<title><?=$title?> &middot; <?=$site_title?></title>
	<link rel="stylesheet" href="<?=base_url('assets/custom/css/print.css')?>" />
	<style type="text/css">
		table.items {
			font-size: 12px;
		}
	</style>	
</head>
<body onload="window.print()">
	<a href="#" class="right print" onclick="print()">[ Print ]</a>
	<?php $this->load->view('inc/print_header');?>
	<h4 class="text-right">Patient #<?=prettyID($info['id'])?></h4>
	<div class="container">
		<h3 class="text-center">Patient Record</h3>
		<div class="content">
			<span class="content-title">Patient Name: </span>
			<span class="content-detail"><?=$info['lastname'] . ', ' . $info['fullname'] . ' ' . $info['middlename']?></span>
		</div><!-- /.content -->

		<div class="content">
			<span class="content-title">Sex:</span>
			<span class="content-detail">
				<?php if ($info['sex'] == 0): ?>
                   Female    
               	<?php else: ?>
                   Male
               	<?php endif ?>
			</span>
		</div><!-- /.content -->

		<div class="content">
			<span class="content-title">Birthdate / Age:</span>
			<span class="content-detail"><?=$info['birthdate']?> / <?=getAge($info['birthdate'], time())?> y.o</span>
		</div><!-- /.content -->

		<div class="content">
			<span class="content-title">Birthplace:</span>
			<span class="content-detail">
				<?php 
                        if($bplace['building']) {
                          echo $bplace['building'] . ', ';
                        } 
                        if($bplace['street']) {
                          echo $bplace['street'] . ', ';
                        }
                        if($bplace['barangay']) {
                          echo $bplace['barangay'] . ', ';
                        }
                        if($bplace['city']) {
                          echo $bplace['city'] . ', ';
                        }
                        if($bplace['province']) {
                          echo $bplace['province'] . ', ';
                        }
                        if($bplace['zip']) {
                          echo $bplace['zip'] . ', ';
                        }
                        if($bplace['country']) {
                          echo $bplace['country'];
                        }
                        ?>
			</span>
		</div><!-- /.content -->

		<div class="content">
			<span class="content-title">Address:</span>
			<span class="content-detail">
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
			</span>
		</div><!-- /.content -->

		<div class="content">
			<span class="content-title">Contact Number: </span>
			<span class="content-detail">
				<ul>
               	<?php if ($mobile): ?>
               	<?php foreach ($mobile as $con): ?>
                  <li><?=$con['details']?></li>
               	<?php endforeach ?>  
               	<?php endif ?>
             	</ul>
			</span>
		</div><!-- /.content -->

		<div class="content">
			<span class="content-title">Email: </span>
			<span class="content-detail">
				<ul>
               	<?php if ($email): ?>
               	<?php foreach ($email as $mail): ?>
                  <li><?=$mail['details']?></li>
               	<?php endforeach ?>  
               	<?php endif ?>
             	</ul>
			</span>
		</div><!-- /.content -->


		<div class="content">	
		 <?php if ($cases): $x=1; ?>	
			<table class="items">
				<thead>
					<tr>
						<th colspan="6">CASES</th>
					</tr>
					<tr>
						<th width="1%"></th>
						<th width="20%"></th>
                        <th>Case</th>
                        <th width="20%">Date Registered</th>
					</tr>
				</thead>
				<tbody>
                  <?php foreach ($cases as $case): ?>
                    <tr>
                    	<td><?=$x++?>.</td>
                    	<td>CASE #<?=prettyID($case['id'])?></td>
                    	<td><?=$case['title']?></td>
                    	<td><?=$case['created_at']?></td>
                    </tr>           	
                  <?php endforeach ?>            
                </tbody>
			</table><!-- /.items -->
			<?php else: ?>
				No items Found!
			<?php endif ?>
		</div><!-- /.content -->

		<div class="content">	
		 <?php if ($immunizations): $x=1; ?>	
			<table class="items">
				<thead>
					<tr>
						<th colspan="6">IMMUNIZATIONS TAKEN</th>
					</tr>
					<tr>
						<th width="1%"></th>
						<th width="20%"></th>
                        <th>Type</th>
                        <th width="20%">Date Taken</th>
					</tr>
				</thead>
				<tbody>
                  <?php foreach ($immunizations as $immu): ?>
                    <tr>
                    	<td><?=$x++?>.</td>
                    	<td>IMMU #<?=prettyID($immu['id'])?></td>
                    	<td><?=$immu['service']?></td>
                    	<td><?=$immu['created_at']?></td>
                    </tr>           	
                  <?php endforeach ?>            
                </tbody>
			</table><!-- /.items -->
			<?php else: ?>
				No items Found!
			<?php endif ?>
		</div><!-- /.content -->

		<div class="content">
			<span class="content-title">Date Issued: </span>
			<span class="content-detail"><?=$info['created_at']?></span>
		</div><!-- /.content -->
		<br />
		<small class="print-stamp">Printed: <?=unix_to_human(now())?> by <?=$user['name']?> <br/> Printing of Patient Record is for Clinic's Purposes only. <br/> This record shall never be released to unauthorized personnel. </small>

	</div><!-- /.container -->
</body>
</html>