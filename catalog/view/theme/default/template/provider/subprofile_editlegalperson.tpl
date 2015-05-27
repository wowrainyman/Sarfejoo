<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
<div id="s-page-content" class="s-row">
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content" class="s-pc-c-center">
<?php echo $content_top; ?>
  <div class="breadcrumb s-pc-c-c-bread">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="subprofileid" value="<?php echo $subprofileid; ?>" />
        <h2><?php echo $text_profile; ?></h2>
        <div class="content">
            <table class="form">
                <tr>
                    <td><span class="required">*</span> <?php echo $entry_registrationid; ?></td>
                    <td><input type="text" name="registrationid" value="<?php echo $registrationid; ?>"/>
                        <?php if ($error_registrationid) { ?>
                        <span class="error"><?php echo $error_registrationid; ?></span>
                        <?php } ?></td>
                </tr>
                <tr>
                    <td><span class="required">*</span> <?php echo $entry_agreement; ?></td>
                    <td><input type="file" name="agreement" accept="image/gif, image/jpeg" id="agreement"/>
                </tr>
                <tr>
                    <td><span class="required">*</span> <?php echo $entry_newspaper; ?></td>
                    <td><input type="file" name="newspaper" accept="image/gif, image/jpeg" id="newspaper"/>
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
<?php echo $footer; ?>