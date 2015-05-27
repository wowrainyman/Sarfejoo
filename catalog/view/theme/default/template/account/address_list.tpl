<?php echo $header; ?>
<div class="row" style="margin-top: 40px;">
  <div class="col-md-3" style="padding: 4px;">
    <div class="col-md-12 box-shadow" style="padding: 4px;">
      <div class="row">
        <?php echo $column_left; ?>
      </div>
      <div class="row">
        <?php echo $column_right; ?>
      </div>

    </div>
  </div>
  <div class="col-md-9">
    <div class="col-md-12 box-shadow" style="padding: 4px;">
      <?php if ($success) { ?>
      <div class="success"><?php echo $success; ?></div>
      <?php } ?>
      <?php if ($error_warning) { ?>
      <div class="warning"><?php echo $error_warning; ?></div>
      <?php } ?>
      <div id="s-page-content" class="s-row">
        <div id="content" class="s-pc-c-center">
          <?php echo $content_top; ?>
          <div class="breadcrumb s-pc-c-c-bread">
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
            <?php } ?>
          </div>
          <h2><?php echo $text_address_book; ?></h2>
          <?php foreach ($addresses as $result) { ?>
          <div class="content">
            <table style="width: 100%;">
              <tr>
                <td><?php echo $result['address']; ?></td>
                <td style="text-align: right;"><a href="<?php echo $result['update']; ?>" class="button"><?php echo $button_edit; ?></a> &nbsp; <a href="<?php echo $result['delete']; ?>" class="button"><?php echo $button_delete; ?></a></td>
              </tr>
            </table>
          </div>
          <?php } ?>
          <div class="buttons">
            <div class="left"><a href="<?php echo $back; ?>" class="button"><?php echo $button_back; ?></a></div>
            <div class="right"><a href="<?php echo $insert; ?>" class="button"><?php echo $button_new_address; ?></a></div>
          </div>
          <?php echo $content_bottom; ?>
        </div>
      </div>

    </div>
  </div>

</div>


<?php echo $footer; ?>