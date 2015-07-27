<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/product.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
          <input type="hidden" name="plan_id" value="<?php echo $plan_id; ?>" />
        <div id="tab-general">
            <table class="form">
                <?php if (isset($features)) { ?>
                    <?php foreach ($features as $feature) { ?>
                        <tr>
                            <td><span class="required">*</span> <?php echo $feature['name']; ?></td>
                            <td><input type="text" name="value[<?php echo $feature['id']; ?>]" value="<?php echo $feature['value']; ?>" />
                        </tr>
                    <?php } ?>
                <?php } ?>
            </table>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>