<!DOCTYPE html>
<html>
<head>
	<title><?=$title?> &middot; <?=$site_title?></title>
	<style type="text/css">
		
		html {
			display: block;
		}
		body {
			font-family: Arial;
		}

		.content {
			width: 100%;
			display: block;
			border-bottom: 1px #cecece solid;
			padding: 10px;
		}

		.content-title {
			font-weight: bold;
		}

		table.items {
			width: 100%;
			border: 1px #cecece solid;
			border-collapse: collapse;
		}

		table.items th, table.items td {
			border: 1px #cecece solid;	
			padding: 2px 10px 2px 10px;		
		}

		table.items th {
			background: #eeeeee;
		}

		.text-center {
			text-align: center;
		}
		
		
		.signature-container {
			width: 100%;
			display: block;
		}

		.signature {
			margin-top: 50px;
			margin-left: 50px;
			margin-right: 80px;
			display: inline-block;
		}

		.signee {
			display: block;
			width: 100%;
			padding: 5px 25% 5px 25%;
			border-bottom: 1px #212121 solid;
			text-align: center;
		}

		.signee-title {
			text-align: center;
			width: 100%;
			padding: 5px 25% 5px 25%;
			display: block;
		}

		.print-stamp {
			width: 100%;
			display: block;
			text-align: right;
		}
	</style>
</head>
<body>
	
	<div class="container">

		<h3>Prescription: <?=prettyID($prescription['id'])?></h3>
		<div class="content">
			<span class="content-title">Patient Name: </span>
			<span class="content-detail"><?=$info['fullname'] . ' ' . $info['lastname']?></span>
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