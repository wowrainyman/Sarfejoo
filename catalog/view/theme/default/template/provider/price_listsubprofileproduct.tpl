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
                        <?php echo $breadcrumb['separator']; ?><a
                                href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
                        <?php } ?>
                    </div>
                    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                        <h2><?php echo $text_profile; ?></h2>

                        <div class="limit"><b><?php echo $text_limit; ?></b>
                            <select onchange="location = this.value;">
                                <?php foreach ($limits as $limits) { ?>
                                <?php if ($limits['value'] == $limit) { ?>
                                <option value="<?php echo $limits['href']; ?>"
                                        selected="selected"><?php echo $limits['text']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="content">
                            <table class="form">
                                <?php if (isset($productinfos)) { ?>
                                <?php foreach ($productinfos as $productinfo) { ?>
                                <tr>
                                    <td rowspan="4" class="upit">
                                        <img src="<?php echo $productinfo['image']; ?>" />
                                        <span><?php echo $productinfo['name']; ?></span>
                                    </td>
                                    <td style="width:40%">
                                        <?php echo $entry_yourprice; ?>
                                        <input type="text" name="price[<?php echo $productinfo['id']; ?>]"
                                               value="<?php echo $productinfo['yourprice']; ?>"/>
                                    </td>
                                    <td>
                                        <?php echo $entry_minimumprice . ":"; ?>
                                        <?php echo number_format($productinfo['minimumprice']); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php echo $entry_availability; ?>
                                        <select name="availability[<?php echo $productinfo['id']; ?>]" id="availability">
                                            <option value="0"
                                            <?php if($productinfo['availability']==0) echo "selected='selected'"; ?>
                                            ><?php echo $entry_available; ?></option>
                                            <option value="1"
                                            <?php if($productinfo['availability']==1) echo "selected='selected'"; ?>
                                            ><?php echo $entry_unavailable; ?></option>
                                            <option value="2"
                                            <?php if($productinfo['availability']==2) echo "selected='selected'"; ?>
                                            ><?php echo $entry_soon; ?></option>
                                        </select>
                                    </td>
                                    <td>
                                        <?php echo $entry_averageprice . ":"; ?>
                                        <?php echo number_format($productinfo['averageprice']); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php echo $entry_link; ?>
                                        <input type="text" name="buy_link[<?php echo $productinfo['id']; ?>]"
                                               value="<?php echo $productinfo['buy_link']; ?>"/>
                                    </td>
                                    <td>
                                        <?php echo $entry_maximumprice . ":"; ?>
                                        <?php echo number_format($productinfo['maximumprice']); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php echo $entry_description; ?>
                                        <textarea name="description[<?php echo $productinfo['id']; ?>]" cols="30" rows="4"><?php echo $productinfo['description']; ?></textarea>
                                    </td>
                                    <td></td>
                                </tr>
                                <?php if(isset($productinfo['customAttributes'])) { ?>
                                <?php foreach ($productinfo['customAttributes'] as $attribute) { ?>
                                <?php if($attribute['type']=="Selectbox") { ?>
                                <tr>
                                    <td>
                                        <?php echo $attribute['name']; ?>
                                    </td>
                                    <td>
                                        <select name="attribute[<?php echo $attribute['selected_value']['id'];?>]">
                                            <?php foreach ($attribute['values'] as $opt) { ?>
                                            <?php if($opt['id'] == $attribute['selected_value']['value']) { ?>
                                            <option value="<?php echo $opt['id']; ?>" selected="selected"><?php echo $opt['value']; ?></option>
                                            <?php }else{ ?>
                                            <option value="<?php echo $opt['id']; ?>"><?php echo $opt['value']; ?></option>
                                            <?php } ?>
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
                                        <?php if($opt['id'] == $attribute['selected_value']['value']) { ?>
                                        <input type="radio" checked="checked" name="attribute[<?php echo $attribute['selected_value']['id']; ?>]" value="<?php echo $opt['id']; ?>" /><?php echo $opt['value']; ?>
                                        <?php }else{ ?>
                                        <input type="radio" name="attribute[<?php echo $attribute['selected_value']['id']; ?>]" value="<?php echo $opt['id']; ?>" /><?php echo $opt['value']; ?>
                                        <?php } ?>
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
                                        <input type="text" value="<?php echo $attribute['selected_value']['value'];?>" name="attribute[<?php echo $attribute['selected_value']['id']; ?>]" />
                                    </td>
                                    <td>
                                        <?php echo $attribute['class']; ?>
                                    </td>
                                </tr>
                                <?php }else if($attribute['type']=="Multiselect"){ ?>
                                <?php $all_ids = explode(",", $attribute['selected_value']['value']);?>
                                <tr>
                                    <td>
                                        <?php echo $attribute['name']; ?>
                                    </td>
                                    <td>
                                        <select style="height:100px;" name="attribute[<?php echo $attribute['selected_value']['id']; ?>][]" multiple>
                                            <?php foreach ($attribute['values'] as $opt) { ?>
                                            <?php if(in_array($opt['id'], $all_ids)) { ?>
                                            <option selected="selected" value="<?php echo $opt['id']; ?>"><?php echo $opt['value']; ?></option>
                                            <?php }else { ?>
                                            <option value="<?php echo $opt['id']; ?>"><?php echo $opt['value']; ?></option>
                                            <?php } ?>
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
                                <?php } ?>
                                <?php } ?>
                            </table>

                        </div>
                        <div class="pagination"><?php echo $pagination; ?></div>
                        <div class="buttons">
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

<?php echo $footer; ?>
