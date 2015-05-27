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
        <h2><?php echo $text_profile; ?></h2>
        <div class="content">
            <table class="form">
                <img src="/image/templates/default.png" width="100" height="100" />
            </table>
            <textarea>

            </textarea>
        </div>
        <div class="buttons">
            <div class="left"><a href="<?php echo $back; ?>" class="button"><?php echo $button_back; ?></a></div>
        </div>
    </form>
    <?php echo $content_bottom; ?>
    </div>
    </div>
<?php echo $footer; ?>