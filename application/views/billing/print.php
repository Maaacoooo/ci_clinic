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
<body>
	<a href="#" class="right print" onclick="print()">[ Print ]</a>
	<?php $this->load->view('inc/print_header');?>
	<h4 class="text-right">Billing #<?=prettyID($info['id'])?></h4>
	<div class="container">
		<h3 class="text-center">Billing Statement</h3>
		<div class="content">
			<span class="content-title">Patient Name: </span>
			<span class="content-detail"><?=$info['patient_name']?></span>
		</div><!-- /.content -->
		<div class="content">
			<span class="content-title">Case: </span>
			<span class="content-detail">Case #<?=prettyID($info['case_id'])?></span>
		</div><!-- /.content -->
		<div class="content">
			<span class="content-title">Status</span>
			<span class="content-detail">
				<?php if ($info['status'] == 3): ?>
                  <span class="badge-label grey">Cancelled</span>     
                <?php elseif($info['status'] == 1): ?>
                  <span class="badge-label green">Served</span>                                   
                <?php else: ?> 
                  <span class="badge-label red">Pending</span> 
                <?php endif ?>
				<?php if (($info['payables'] - $info['discounts']) > $info['payments']): ?>
					<span class="badge-label red">UNPAID</span>
				<?php else: ?>
					<span class="badge-label green">PAID</span>
				<?php endif; ?>
			</span>
		</div><!-- /.content -->
		<div class="content">
			<span class="content-title">Remaining Balance: </span>
			<span class="content-detail"><?=decimalize(($info['payables'] - $info['discounts']) - $info['payments'])?></span>
		</div><!-- /.content -->
        <div class="content">
			<span class="content-title">Remarks: </span> <br /><br />
			<span class="content-detail"><?=$info['remarks']?></span>
		</div><!-- /.content -->

		<div class="content">	
		 <?php if ($billing_items): $x=1; ?>	
			<table class="items">
				<thead>
					<tr>
						<th colspan="6">SERVICES</th>
					</tr>
					<tr>
						<th width="1%"></th>
                        <th width="5%">Type</th>
                        <th>Service</th>
                        <th width="10%">AMT</th>
                        <th width="10%">DISC</th>
                        <th width="10%">SUB</th>
					</tr>
				</thead>
				<tbody>
                  <?php foreach ($billing_items as $bill): ?>
                    <tr>
                    	<td><?=$x++?>.</td>
                    	<td class="text-center"><?=$bill['service_cat']?></td>
                    	<td><?=$bill['title']?></td>
                    	<td class="text-center"><?=$bill['amount']?></td>
                    	<td class="text-center"><?=$bill['discount']?></td>
                    	<td class="text-center"><?=$bill['amount']?></td>
                    <?php 
                    	$totbill[] = $bill['amount']; 
                    	$totdisc[] = $bill['discount']; 
                    	$totsub[] = $bill['amount'] - $bill['discount']; 
                    ?>
                    </tr>           	
                  <?php endforeach ?>            
                </tbody>
                <tfoot>
                	<tr>
                		<th colspan="3" class="text-right">TOTAL:</th>
                		<th><?=decimalize(array_sum($totbill))?></th>
                		<th><?=decimalize(array_sum($totdisc))?></th>
                		<th><?=decimalize(array_sum($totsub))?></th>
                	</tr>
                </tfoot>
			</table><!-- /.items -->
			<?php else: ?>
				No items Found!
			<?php endif ?>
		</div><!-- /.content -->

		<div class="content">	
		 <?php if ($payments): $x=1; ?>	
			<table class="items">
				<thead>
					<tr>
						<th colspan="4">PAYMENTS</th>
					</tr>
					<tr>
						<th width="1%"></th>
                        <th width="20%">Date | Time</th>
                        <th>Payee</th>
                        <th width="15%">Amount</th>
					</tr>
				</thead>
				<tbody>
                  <?php foreach ($payments as $pay): ?>
                    <tr>
                    	<td><?=$x++?>.</td>
                    	<td class="text-center"><?=$pay['created_at']?></td>
                    	<td><?=$pay['payee']?></td>
                    	<td class="text-center"><?=$pay['amount']?></td>
                    <?php $totpayments[] = $pay['amount'] ?>
                    </tr>           	
                  <?php endforeach ?>            
                </tbody>
                <tfoot>
                	<tr>
                		<th colspan="3" class="text-right">TOTAL:</th>
                		<th><?=decimalize(array_sum($totpayments))?></th>
                	</tr>
                </tfoot>
			</table><!-- /.items -->
			<?php else: ?>
				No items Found!
			<?php endif ?>
		</div><!-- /.content -->

		<div class="content">
			<span class="content-title">Date Issued: </span>
			<span class="content-detail"><?=$info['created_at']?></span>
		</div><!-- /.content -->

		<div class="signature-container">			
			<div class="signature" style="width: 200px;">
				<span class="signee"><?=$user['name']?></span>
				<span class="signee-title">Issued by</span>
			</div><!-- /.signature -->
		</div><!-- /.signature-container -->

		<small class="print-stamp">Printed: <?=unix_to_human(now())?> <br/> Billing Statement is not valid without the signature of the issuer</small>

	</div><!-- /.container -->
</body>
</html>