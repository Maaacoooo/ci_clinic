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
	<h4 class="text-right">CASE #<?=prettyID($case['id'])?></h4>
	<div class="container">
		<h3 class="text-center">Case Report</h3>
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
			<span class="content-title">Status</span>
			<span class="content-detail">
				<?php if ($case['status'] == 3): ?>
                  <span class="badge-label grey">Cancelled</span>     
                <?php elseif($case['status'] == 1): ?>
                  <span class="badge-label green">Served</span>                                   
                <?php else: ?> 
                  <span class="badge-label red">Pending</span> 
                <?php endif ?>
			</span>
		</div><!-- /.content -->

		<div class="content">
			<span class="content-title">Case Description:</span>
			<span class="content-detail"><br /><br />
				<?=$case['title']?><br />
				<?=$case['description']?>
			</span>
		</div><!-- /.content -->



		<?php if ($prescriptions): $x=1; ?>	
		<div class="content">			 
			<table class="items">
				<thead>
					<tr>
						<th colspan="6">PRESCRIPTIONS</th>
					</tr>
					<tr>
						<th width="1%"></th>
						<th width="20%"></th>
                        <th>Issued By</th>
                        <th width="20%">Date Registered</th>
					</tr>
				</thead>
				<tbody>
                  <?php foreach ($prescriptions as $pres): ?>
                    <tr>
                    	<td><?=$x++?>.</td>
                    	<td>#<?=prettyID($pres['id'])?></td>
                    	<td><?=$pres['issuer']?></td>
                    	<td><?=$pres['created_at']?></td>
                    </tr>           	
                  <?php endforeach ?>            
                </tbody>
			</table><!-- /.items -->			
		</div><!-- /.content -->
		<?php endif ?>

		<?php if ($labreqs): $x=1; ?>	
		<div class="content">			 
			<table class="items">
				<thead>
					<tr>
						<th colspan="6">LABORATORY REQUESTS</th>
					</tr>
					<tr>
						<th width="1%"></th>
						<th width="20%"></th>
                        <th>Type</th>
                        <th>Status</th>
                        <th width="20%">Date Taken</th>
					</tr>
				</thead>
				<tbody>
                  <?php foreach ($labreqs as $lab): ?>
                    <tr>
                    	<td><?=$x++?>.</td>
                    	<td>#<?=prettyID($lab['id'])?></td>
                    	<td><?=$lab['service']?></td>
                    	<td>
                    		<?php if ($lab['status'] == 3): ?>
                           	  Cancelled  
                            <?php elseif($lab['status'] == 1): ?>
                              Served                                 
                            <?php else: ?> 
                              Pending
                            <?php endif ?>
                    	</td>
                    	<td><?=$lab['created_at']?></td>
                    </tr>           	
                  <?php endforeach ?>            
                </tbody>
			</table><!-- /.items -->
		</div><!-- /.content -->
		<?php endif ?>

		<?php if ($immunizations): $x=1; ?>	
		<div class="content">			 
			<table class="items">
				<thead>
					<tr>
						<th colspan="6">IMMUNIZATION REQUESTS</th>
					</tr>
					<tr>
						<th width="1%"></th>
						<th width="20%"></th>
                        <th>Type</th>
                        <th>Status</th>
                        <th width="20%">Date Taken</th>
					</tr>
				</thead>
				<tbody>
                  <?php foreach ($immunizations as $immu): ?>
                    <tr>
                    	<td><?=$x++?>.</td>
                    	<td>IMMU #<?=prettyID($immu['id'])?></td>
                    	<td><?=$immu['service']?></td>
                    	<td>
                    		<?php if ($immu['status'] == 3): ?>
                           	  Cancelled  
                            <?php elseif($immu['status'] == 1): ?>
                              Served                                 
                            <?php else: ?> 
                              Pending
                            <?php endif ?>
                    	</td>
                    	<td><?=$immu['created_at']?></td>
                    </tr>           	
                  <?php endforeach ?>            
                </tbody>
			</table><!-- /.items -->
		</div><!-- /.content -->
		<?php endif ?>



		<div class="content">
			<span class="content-title">Date Issued: </span>
			<span class="content-detail"><?=$info['created_at']?></span>
		</div><!-- /.content -->
		<br />
		<small class="print-stamp">Printed: <?=unix_to_human(now())?> by <?=$user['name']?> <br/> 
		Printing of Case Report is for Clinic-Doctor Purposes only. <br/> 
		This record shall never be released to any unauthorized personnel. </small>

	</div><!-- /.container -->
</body>
</html>