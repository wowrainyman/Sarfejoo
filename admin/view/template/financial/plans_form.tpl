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
                <td><span class="required">*</span> <?php echo $entry_name; ?></td>
                <td><input type="text" name="name" value="" />
              </tr>
                <tr>
                    <td><span class="required">*</span> <?php echo $entry_description; ?></td>
                    <td><input type="text" name="description" value="" />
                </tr>
                <tr>
                    <td><span class="required">*</span> <?php echo $entry_price; ?></td>
                    <td><input type="text" name="price" value="" />
                </tr>
                <tr>
                    <td><span class="required">*</span> <?php echo $entry_enabled; ?></td>
                    <td><input type="text" name="enabled" value="" />
                </tr>
                <tr>
                    <td><span class="required">*</span> <?php echo $entry_sort_order; ?></td>
                    <td><input type="text" name="sort_order" value="" />
                </tr>
                <tr>
                    <td><span class="required">*</span> <?php echo $entry_is_recommended; ?></td>
                    <td><input type="text" name="is_recommended" value="" />
                </tr>
            </table>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>