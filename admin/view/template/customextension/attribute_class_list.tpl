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
                        <td class="left"><?php if ($sort == 'tab3.name') { ?>
                            <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                            <?php } else { ?>
                            <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                            <?php } ?></td>
                        <td class="left"><?php echo $column_type; ?></td>
                        <td class="left"><?php echo $column_class; ?></td>
                        <td class="right"><?php echo $column_action; ?></td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="filter">
                        <td></td>
                        <td><input type="text" name="filter_name" value="<?php echo $filter_name; ?>" /></td>
                        <td></td>
                        <td></td>
                        <td align="right"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
                    </tr>
                    <?php if ($attributes) { ?>
                    <?php foreach ($attributes as $attribute) { ?>
                    <tr>
                        <td style="text-align: center;"><?php if ($attribute['selected']) { ?>
                            <input type="checkbox" name="selected[]" value="<?php echo $attribute['id']; ?>" checked="checked" />
                            <?php } else { ?>
                            <input type="checkbox" name="selected[]" value="<?php echo $attribute['id']; ?>" />
                            <?php } ?></td>
                        <td class="left"><?php echo $attribute['name']; ?></td>
                        <td class="left">
                            <select type="text" name="type[<?php echo $attribute['id']; ?>]">
                                <option <?php if ($attribute['type'] == 'Selectbox') echo 'selected="selected"' ?> value="Selectbox">Selectbox</option>
                                <option <?php if ($attribute['type'] == 'Radiobutton') echo 'selected="selected"' ?> value="Radiobutton">Radiobutton</option>
                                <option <?php if ($attribute['type'] == 'Text') echo 'selected="selected"' ?> value="Text">Text</option>
                                <option <?php if ($attribute['type'] == 'Multiselect') echo 'selected="selected"' ?> value="Multiselect">Multiselect</option>
                            </select>

                        </td>
                        <td class="left"><input type="text" name="class[<?php echo $attribute['id']; ?>]" value="<?php echo $attribute['class']; ?>"/></td>
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
<script type="text/javascript"><!--
    function filter() {
        url = 'index.php?route=customextension/attribute_class&token=<?php echo $token; ?>';

        var filter_name = $('input[name=\'filter_name\']').attr('value');

        if (filter_name) {
            url += '&filter_name=' + encodeURIComponent(filter_name);
        }
        location = url;
    }
    //--></script>
<?php echo $footer; ?>