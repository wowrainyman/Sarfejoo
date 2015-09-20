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
      <?php if ($error_warning) { ?>
      <div class="warning"><?php echo $error_warning; ?></div>
      <?php } ?>
      <div id="s-page-content" class="s-row">
        <div id="content" class="s-pc-c-center">
          <div class="breadcrumb s-pc-c-c-bread">
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
            <?php } ?>
          </div>
          <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <h2><?php echo $text_your_details; ?></h2>
            <div class="content">
              <table class="form">
                <tr>
                  <td><span class="required">*</span> <?php echo $entry_title; ?></td>
                  <td><input class="form-control" type="text" name="title" value="" />
                </tr>
                <tr>
                  <td><span class="required">*</span> <?php echo $entry_content; ?></td>
                  <td>
                    <textarea class="form-control" name="content" rows="10"></textarea>
                  </td>
                </tr>
              </table>
            </div>
            <div class="buttons">
              <div class="left"><a href="<?php echo $back; ?>" class="button"><?php echo $button_back; ?></a></div>
              <div class="right">
                <input type="submit" value="<?php echo $button_continue; ?>" class="button" />
              </div>
            </div>
          </form>
          <?php echo $content_bottom; ?>
        </div>
      </div>
    </div>

  </div>
</div>

<?php echo $footer; ?>