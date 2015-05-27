<?php echo $header; ?>


<?php if (isset($verification)) { ?>
     <?php if ($verification==1) { ?>
          <div class="success"><?php echo $text_account_verified; ?></div>
     <?php } elseif ($verification==0) { ?>
          <div class="warning"><?php echo $error_wrong_data_check; ?></div>
      <?php } ?>
<?php } elseif (!isset($verification)) { ?>
          <div class="warning"><?php echo $error_verification; ?></div>
<?php } ?>
<div id="s-page-content" class="s-row">

 <div class="content">

  </div>
  </div>
<?php echo $footer; ?> 
