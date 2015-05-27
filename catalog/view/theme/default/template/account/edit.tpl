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
                  <td><span class="required">*</span> <?php echo $entry_firstname; ?></td>
                  <td><input class="form-control" type="text" name="firstname" value="<?php echo $firstname; ?>" />
                    <?php if ($error_firstname) { ?>
                    <span class="error"><?php echo $error_firstname; ?></span>
                    <?php } ?></td>
                </tr>
                <tr>
                  <td><span class="required">*</span> <?php echo $entry_lastname; ?></td>
                  <td><input class="form-control" type="text" name="lastname" value="<?php echo $lastname; ?>" />
                    <?php if ($error_lastname) { ?>
                    <span class="error"><?php echo $error_lastname; ?></span>
                    <?php } ?></td>
                </tr>
                <tr>
                  <td><span class="required">*</span> <?php echo $entry_email; ?></td>
                  <td><input class="form-control" type="text" name="email" value="<?php echo $email; ?>" />
                    <?php if ($error_email) { ?>
                    <span class="error"><?php echo $error_email; ?></span>
                    <?php } ?></td>
                </tr>
                <tr>
                  <td><span class="required">*</span> <?php echo $entry_telephone; ?></td>
                  <td><input class="form-control" type="text" name="telephone" value="<?php echo $telephone; ?>" />
                    <?php if ($error_telephone) { ?>
                    <span class="error"><?php echo $error_telephone; ?></span>
                    <?php } ?></td>
                </tr>
                <tr>
                  <td><?php echo $entry_fax; ?></td>
                  <td><input class="form-control" type="text" name="fax" value="<?php echo $fax; ?>" /></td>
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