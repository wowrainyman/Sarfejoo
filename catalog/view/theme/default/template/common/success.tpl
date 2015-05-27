<?php echo $header; ?>
<div class="row" style="margin-top: 40px;">
    <div class="col-md-12" style="padding: 4px;">
        <div class="col-md-12 box-shadow" style="padding: 4px;">
            <?php if ($error_warning) { ?>
            <div class="warning"><?php echo $error_warning; ?></div>
            <?php } ?>
            <?php if ($success) { ?>
            <div class="success"><?php echo $success; ?></div>
            <?php } ?>
            <div id="s-page-content" class="s-row">
                <?php echo $text_message; ?>
                <br />
                <div class="buttons">
                    <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
                </div>
                <?php echo $content_bottom; ?>
            </div>
        </div>

    </div>
</div>

<?php echo $footer; ?>