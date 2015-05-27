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
            <?php if ($success) { ?>
            <div class="success"><?php echo $success; ?></div>
            <?php } ?>
            <div id="s-page-content" class="s-row">
                <div id="content" class="s-pc-c-center">
                    <?php echo $content_top; ?>
                    <div class="breadcrumb s-pc-c-c-bread">
                        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                        <?php echo $breadcrumb['separator']; ?>
                            <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
                        <?php } ?>
                    </div>
                    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="isBlockAttribute" value="<?php echo $isBlockAttribute; ?>" >
                        <input type="hidden" name="blockAttributesId" value="<?php echo $blockAttributesId; ?>" >
                        <input type="hidden" name="subprofile_id" value="<?php echo $subprofile_id; ?>" />
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
                        <?php if(isset($id)) { ?>
                        <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
                        <?php } ?>
                        <h2><?php echo $text_profile; ?></h2>
                        <div class="content">
                            <table class="form">
                                <tr>
                                    <td><span class="required">*</span> <?php echo $entry_price; ?></td>
                                    <td><input  class="form-control" type="text" name="price" value="<?php echo $price; ?>"/>
                                        <?php if ($error_price) { ?>
                                        <span class="error"><?php echo $error_price; ?></span>
                                        <?php } ?></td>
                                </tr>
                                <tr>
                                    <td><span class="required">*</span> <?php echo $entry_description; ?></td>
                                    <td>
                                        <textarea  class="form-control" rows="4" cols="50" name="description"></textarea>
                                        <?php if ($error_description) { ?>
                                        <span class="error"><?php echo $error_description; ?></span>
                                        <?php } ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $entry_buy_link; ?></td>
                                    <td><input dir="ltr" type="url" name="buy_link" value="http://"/>
                                        <?php if ($buy_link) { ?>
                                        <span class="error"><?php echo $buy_link; ?></span>
                                        <?php } ?></td>
                                </tr>
                                <tr>
                                    <td><span class="required">*</span> <?php echo $entry_availability; ?></td>
                                    <td><select  class="form-control" name="availability" id="availability">
                                            <option value="0"><?php echo $entry_available; ?></option>
                                            <option value="1"><?php echo $entry_unavailable; ?></option>
                                            <option value="2"><?php echo $entry_soon; ?></option>
                                        </select>
                                        <?php if ($error_availability) { ?>
                                        <span class="error"><?php echo $error_availability; ?></span>
                                        <?php } ?></td>
                                </tr>
                                <?php if(isset($attributes)) { ?>
                                <?php foreach ($attributes as $attribute) { ?>
                                <?php if($attribute['type']=="Selectbox") { ?>
                                <tr>
                                    <td>
                                        <?php echo $attribute['name']; ?>
                                    </td>
                                    <td>
                                        <select  class="form-control" name="attribute[<?php echo $attribute['attribute_id']; ?>]">
                                            <?php foreach ($attribute['values'] as $opt) { ?>
                                            <option value="<?php echo $opt['id']; ?>"><?php echo $opt['value']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <?php echo $attribute['class']; ?>
                                    </td>
                                </tr>
                                <?php }else if($attribute['type']=="Radiobutton"){ ?>
                                <tr>
                                    <td>
                                        <?php echo $attribute['name']; ?>
                                    </td>
                                    <td>
                                        <?php foreach ($attribute['values'] as $opt) { ?>
                                        <input type="radio" name="attribute[<?php echo $attribute['attribute_id']; ?>]" value="<?php echo $opt['id']; ?>" /><?php echo $opt['value']; ?>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php echo $attribute['class']; ?>
                                    </td>
                                </tr>
                                <?php }else if($attribute['type']=="Text"){ ?>
                                <tr>
                                    <td>
                                        <?php echo $attribute['name']; ?>
                                    </td>
                                    <td>
                                        <input class="form-control" name="attribute[<?php echo $attribute['attribute_id']; ?>]" />
                                    </td>
                                    <td>
                                        <?php echo $attribute['class']; ?>
                                    </td>
                                </tr>
                                <?php }else if($attribute['type']=="Multiselect"){ ?>
                                <tr>
                                    <td>
                                        <?php echo $attribute['name']; ?>
                                    </td>
                                    <td>
                                        <select  class="form-control" style="height:100px;" name="attribute[<?php echo $attribute['attribute_id']; ?>][]" multiple>
                                            <?php foreach ($attribute['values'] as $opt) { ?>
                                            <option value="<?php echo $opt['id']; ?>"><?php echo $opt['value']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <?php echo $attribute['class']; ?>
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php } ?>
                                <?php } ?>
                            </table>
                        </div>
                        <div class="buttons">
                            <div class="left"><a href="<?php echo $back; ?>" class="button"><?php echo $button_back; ?></a></div>
                            <div class="right">
                                <input type="submit" value="<?php echo $button_continue; ?>" class="button"/>
                            </div>
                        </div>
                    </form>
                    <?php echo $content_bottom; ?>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    function addressset() {
        var searchString = $("#city").val();
        document.getElementById("Search").value = searchString;
    }
</script>
<?php echo $footer; ?>

