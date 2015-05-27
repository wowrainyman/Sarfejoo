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
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
        <h2><?php echo $text_profile; ?></h2>
        <div class="content">
            <table class="form">
                <tr>
                    <td><span class="required">*</span> <?php echo $entry_price; ?></td>
                    <td><input type="number" name="value" value="" />
                        <?php if ($error_price) { ?>
                        <span class="error"><?php echo $error_price; ?></span>
                        <?php } ?></td>
                </tr>
                <br />
                <br />
                <br />
                <!--
                <tr>
                    <td><span class="required">*</span> <?php echo $entry_gateway; ?></td>
                     <td>
                        <?php foreach ($payment_gateways as $payment_gateway) { ?>
                            <input type="radio" name="gateway_id" checked="checked" value="<?php echo $payment_gateway['id']; ?>" />
                            <?php echo $payment_gateway['gateway_name']; ?>
                        <?php } ?>
                    </td>
                </tr>
                 -->
            </table>
        </div>
        <div class="buttons">
            <div class="left"></div>
            <div class="right">
                <input type="submit" value="<?php echo $button_submit; ?>" class="button" />
            </div>
        </div>
    </form>
    <?php echo $content_bottom; ?></div>
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/ui.datepicker.js"></script>
<script type="text/javascript"><!--
    $(document).ready(function() {
        $('#birthday').datepicker({changeMonth: true, changeYear: true, yearRange: '-80:+0', dateFormat: 'yy-mm-dd'});
    });
    //--></script></div>
<?php echo $footer; ?>