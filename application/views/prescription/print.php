<!DOCTYPE html>
<html>
<head>
	<title><?=$title?> &middot; <?=$site_title?></title>
	<link rel="stylesheet" href="<?=base_url('assets/css/print.css')?>" />
</head>
<body onload="window.print()">
	
	<?php $this->load->view('inc/print_header');?>

	<div class="container">
		<h3>Prescription: #<?=prettyID($prescription['id'])?></h3>
		<div class="content">
			<span class="content-title">Patient Name: </span>
			<span class="content-detail"><?=$info['fullname'] . ' ' . $info['lastname']?></span>
		</div><!-- /.content -->
		<div class="content">
			<span class="content-title">Case: </span>
			<span class="content-detail">Case #<?=prettyID($case['id'])?></span>
		</div><!-- /.content -->
		<div class="content">
			<span class="content-title">Prescription Title: </span>
			<span class="content-detail"><?=$prescription['title']?></span>
		</div><!-- /.content -->
        <div class="content">
			<span class="content-title">Prescription Details / Remarks: </span> <br /><br />
			<span class="content-detail"><?=$prescription['description']?></span>
		</div><!-- /.content -->

		<div class="content">		
			<table class="items">
				<thead>
					<tr>
						<th width="5%"></th>
						<th>Particulars</th>
						<th width="10%">QTY</th>
						<th>Remarks</th>
					</tr>
				</thead>
				<tbody>
                              <?php if ($items): $x=1; ?>
                                <?=form_open('prescription/update_items')?>
                                <?php foreach ($items as $item): ?>
                                  <tr>
                                    <td class="text-center"><?=$x++?>.</td>
                                    <td>
                                  <?=$item['item']?>
                                    </td>
                                    <td class="text-center">
                                      <?=$item['qty']?>
                                    </td>
                                    <td>
                                     <?=$item['remark']?>
                                    </td>                                    
                                  </tr>                                  
                                <?php endforeach ?>                               
                                <?=form_close()?>
                              <?php else: ?>
                                <tr>
                                  <td colspan="4">No items found!</td>
                                </tr>
                              <?php endif ?>
                            </tbody>
			</table><!-- /.items -->
		</div><!-- /.content -->

		<div class="content">
			<span class="content-title">Date Issued: </span>
			<span class="content-detail"><?=$prescription['created_at']?></span>
		</div><!-- /.content -->

		<div class="signature-container">			
			<div class="signature" style="width: 200px;">
				<span class="signee"><?=$prescription['issuer']?></span>
				<span class="signee-title">Issued by</span>
			</div><!-- /.signature -->
		</div><!-- /.signature-container -->

		<small class="print-stamp">Printed: <?=unix_to_human(now())?> <br/> Prescription is not valid without the signature of the issuer</small>

	</div><!-- /.container -->
</body>
</html>