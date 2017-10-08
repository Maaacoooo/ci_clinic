<!DOCTYPE html>
<html>
<head>
	<title><?=$title?> &middot; <?=$site_title?></title>
	<link rel="stylesheet" href="<?=base_url('assets/css/print.css')?>" />
	<style type="text/css">
		table.items {
			font-size: 12px;
		}
	</style>
</head>
<body onload="#window.print()">
	<a href="#" class="right print" onclick="print()">[ Print ]</a>
	<?php $this->load->view('inc/print_header');?>
	<h4 class="text-right">REQ #<?=prettyID($labreq['id'])?></h4>
	<div class="container">
		<h3 class="text-center">Laboratory Request Report</h3>
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
			<span class="content-title">Case ID:</span>
			<span class="content-detail">CASE #<?=prettyID($case['id'])?></span>
		</div><!-- /.content -->

		<div class="content">
			<span class="content-title">Requested Service:</span>
			<span class="content-detail"><?=$labreq['service']?></span>
		</div><!-- /.content -->

		<div class="content">
			<span class="content-title">Requested By:</span>
			<span class="content-detail"><?=$labreq['requestor']?></span>
		</div><!-- /.content -->

		<div class="content">
			<span class="content-title">Request Status</span>
			<span class="content-detail">
				<?php if ($labreq['status'] == 3): ?>
                  <span class="badge-label grey">Cancelled</span>     
                <?php elseif($labreq['status'] == 1): ?>
                  <span class="badge-label green">Served</span>                                   
                <?php else: ?> 
                  <span class="badge-label red">Pending</span> 
                <?php endif ?>
			</span>
		</div><!-- /.content -->

		<div class="content">
			<span class="content-title">Request Description:</span>
			<span class="content-detail"><br /><br />
				<?=$labreq['description']?>
			</span>
		</div><!-- /.content -->



		<?php if ($lab_report):?>	
		<div class="content">			 
			<table class="items">
                     <?=form_open('laboratory/update_report')?>
                     <thead>
                       <tr>
                         <th colspan="3"><?=$labreq['service']?> Report</th>
                       </tr>
                     </thead>
                     <tbody>
                       <tr>
                         <th>Authenticated Report No.</th>
                         <td colspan="2"><?=$labreq['report_no']?></td>
                       </tr>
                       <tr>
                         <th>Medical Technician</th>
                         <td colspan="2"><?=$labreq['medtech']?></td>
                       </tr>
                       <tr>
                         <th>Pathologist</th>
                         <td colspan="2"><?=$labreq['pathologist']?></td>
                       </tr>
                       <tr>
                         <td colspan="3"></td>
                       </tr>
                       <tr>
                         <th width="40%" class="center">EXAMINATIONS</th>
                         <th width="35%" class="center">NORMAL VALUES</th>
                         <th class="center">RESULT</th>
                       </tr>                     
                       <?php foreach ($lab_report as $rep): ?>
                         <tr>
                           <td><?=$rep['title']?></td>
                           <td><?=$rep['normal_values']?></td>
                           <td> <?=$rep['value']?></td>
                         </tr>
                       <?php endforeach ?>                     
                     </tbody>
                   </table>		
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