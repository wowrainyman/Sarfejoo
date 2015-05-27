<?php echo $header; ?>
<div id="content">
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>
    <?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="success"><?php echo $success; ?></div>
    <?php } ?>
    <div class="box">
        <div class="heading">
            <h1><img src="view/image/order.png" alt="" /> <?php echo $heading_title; ?></h1>
            <div class="buttons"><a href="<?php echo $insert; ?>" class="button"><?php echo $button_insert; ?></a></div>
        </div>
        <div class="content">
            <form action="<?php echo $form_action; ?>" method="post" enctype="multipart/form-data" id="form">
                <table class="list">
                    <thead>
                    <tr>
                        <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
                        <td class="left"><?php if ($sort == 'tab1.id') { ?>
                            <a href="<?php echo $sort_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_id; ?></a>
                            <?php } else { ?>
                            <a href="<?php echo $sort_id; ?>"><?php echo $column_id; ?></a>
                            <?php } ?></td>
                        <td class="left"><?php if ($sort == 'tab2.name') { ?>
                            <a href="<?php echo $sort_attribute_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_attribute_name; ?></a>
                            <?php } else { ?>
                            <a href="<?php echo $sort_attribute_name; ?>"><?php echo $column_attribute_name; ?></a>
                            <?php } ?></td>
                        <td class="left"><?php if ($sort == 'tab3.name') { ?>
                            <a href="<?php echo $sort_product_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_product_name; ?></a>
                            <?php } else { ?>
                            <a href="<?php echo $sort_product_name; ?>"><?php echo $column_product_name; ?></a>
                            <?php } ?></td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($important_attributes) { ?>
                    <?php foreach ($important_attributes as $important_attribute) { ?>
                    <tr>
                        <td style="text-align: center;"><?php if ($important_attribute['selected']) { ?>
                            <input type="checkbox" name="selected[]" value="<?php echo $attribute['id']; ?>" checked="checked" />
                            <?php } else { ?>
                            <input type="checkbox" name="selected[]" value="<?php echo $attribute['id']; ?>" />
                            <?php } ?></td>
                        <td class="left"><?php echo $important_attribute['id']; ?></td>
                        <td class="left"><?php echo $important_attribute['attribute_name']; ?></td>
                        <td class="left"><?php echo $important_attribute['product_name']; ?></td>
                    </tr>
                    <?php } ?>
                    <?php } else { ?>
                    <tr>
                        <td class="center" colspan="5"><?php echo $text_no_results; ?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="right"><input type="submit" class="button" value="<?php echo $text_edit; ?>" /></td>
                    </tr>
                    </tbody>
                </table>
            </form>
            <div class="pagination"><?php echo $pagination; ?></div>
        </div>
    </div>
</div>
<?php echo $footer; ?>