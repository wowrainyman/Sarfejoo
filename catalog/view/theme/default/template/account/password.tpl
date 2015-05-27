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
      <div id="s-page-content" class="s-row">
        <div id="content" class="s-pc-c-center">
          <?php echo $content_top; ?>
          <div class="breadcrumb s-pc-c-c-bread">
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
            <?php } ?>
          </div>
          <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <h2><?php echo $text_password; ?></h2>
            <div class="content">
              <table class="form">
                <tr>
                  <td><span class="required">*</span> <?php echo $entry_password; ?></td>
                  <td><input class="form-control" type="password" name="password" value="<?php echo $password; ?>" />
                    <?php if ($error_password) { ?>
                    <span class="error"><?php echo $error_password; ?></span>
                    <?php } ?></td>
                </tr>
                <tr>
                  <td><span class="required">*</span> <?php echo $entry_confirm; ?></td>
                  <td><input class="form-control" type="password" name="confirm" value="<?php echo $confirm; ?>" />
                    <?php if ($error_confirm) { ?>
                    <span class="error"><?php echo $error_confirm; ?></span>
                    <?php } ?></td>
                </tr>
              </table>
            </div>
            <div class="buttons">
              <div class="left"><a href="<?php echo $back; ?>" class="button"><?php echo $button_back; ?></a></div>
              <div class="right"><input type="submit" value="<?php echo $button_continue; ?>" class="button" /></div>
            </div>
          </form>
          <?php echo $content_bottom; ?>
        </div>
      </div>
    </div>
  </div>

</div>


<?php echo $footer; ?>

















