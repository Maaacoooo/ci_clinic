<!DOCTYPE html>
<html>
<head>
  <title><?=$title?> &middot; <?=$site_title?></title>
  <link rel="stylesheet" href="<?=base_url('assets/custom/css/print.css')?>" />
</head>
<body>
  <a href="#" class="right print" onclick="print()">[ Print ]</a>
  <div class="page">
   <?php $this->load->view('inc/print_header');?>  
    <h5>Customer's Copy | PAY #<?=prettyID($payment['id'])?> <span class="right"><?=nice_date($payment['created_at'], 'M. d, Y | h:m A')?></span></h5><!-- /.text-right -->
    <div class="container">
      <h3 class="text-center">Acknowledgement Receipt</h3>    
      <div class="content text-center" style="width: 500px; margin: auto;">
        <p>Received from <span class="strong underlined"><?=$payment['payee']?></span> the amount of <span class="strong underlined"><?=$payment['amount']?></span>, 
          in payment for <span class="strong underlined">BILLING #<?=prettyID($info['id'])?></span> of <span class="strong underlined"><?=$info['patient_name']?></span></p>
      </div><!-- /.content -->
      <div class="signature-container">     
        <div class="signature" style="width: 150px;">
          <span class="signee"><?=$payment['user']?></span>
          <span class="signee-title">Received By</span>
        </div><!-- /.signature -->
        <div class="signature right" style="width: 150px;">
          <span class="signee"><?=$payment['payee']?></span>
          <span class="signee-title">Payee</span>
        </div><!-- /.signature-container -->
      </div>

      <small class="print-stamp">Printed: <?=unix_to_human(now())?> <br/> Receipt is not valid without the signature of the Receiver and Payee</small>

    </div><!-- /.container --> 
  </div><!-- /.page -->
  <div class="cut"></div><!-- /.cut -->
  <div class="page">
   <?php $this->load->view('inc/print_header');?>  
    <h5>Clinic's Copy | PAY #<?=prettyID($payment['id'])?> <span class="right"><?=nice_date($payment['created_at'], 'M. d, Y | h:m A')?></span></h5><!-- /.text-right -->
    <div class="container">
      <h3 class="text-center">Acknowledgement Receipt</h3>    
      <div class="content text-center" style="width: 500px; margin: auto;">
        <p>Received from <span class="strong underlined"><?=$payment['payee']?></span> the amount of <span class="strong underlined"><?=$payment['amount']?></span>, 
          in payment for <span class="strong underlined">BILLING #<?=prettyID($info['id'])?></span> of <span class="strong underlined"><?=$info['patient_name']?></span></p>
      </div><!-- /.content -->
      <div class="signature-container">     
        <div class="signature" style="width: 150px;">
          <span class="signee"><?=$payment['user']?></span>
          <span class="signee-title">Received By</span>
        </div><!-- /.signature -->
        <div class="signature right" style="width: 150px;">
          <span class="signee"><?=$payment['payee']?></span>
          <span class="signee-title">Payee</span>
        </div><!-- /.signature-container -->
      </div>

      <small class="print-stamp">Printed: <?=unix_to_human(now())?> <br/> Receipt is not valid without the signature of the Receiver and Payee</small>

    </div><!-- /.container --> 
  </div><!-- /.page -->
</body>
</html>

