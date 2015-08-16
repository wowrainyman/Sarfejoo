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
        <div id="tab-general">
            <table class="form">
              <tr>
                <td><span class="required">*</span> <?php echo $column_plan_id; ?></td>
                <td><input type="text" name="plan_id" value="" />
              </tr>
                <tr>
                    <td><span class="required">*</span> <?php echo $column_name; ?></td>
                    <td><input type="text" name="name" value="" />
                </tr>
                <tr>
                    <td><span class="required">*</span> <?php echo $column_valid_until; ?></td>
                    <td><input type="text" name="valid_until" value="" />
                </tr>
                <tr>
                    <td><span class="required">*</span> <?php echo $column_value; ?></td>
                    <td><input type="text" name="value" value="" />
                </tr>
                <tr>
                    <td><span class="required">*</span> <?php echo $entry_description; ?></td>
                    <td><input type="text" name="description" value="" />
                </tr>
                <tr>
                    <td><span class="required">*</span> <?php echo $entry_enabled; ?></td>
                    <td><input type="text" name="sort_enabled" value="" />
                </tr>
            </table>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>