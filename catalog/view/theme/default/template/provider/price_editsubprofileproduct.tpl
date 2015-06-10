<?php echo $header; ?>
<div class="row" style="margin-top: 40px;">

    <div class="col-md-12">
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
                        <div class="content">
                            <table class="form">
                                <tr>
                                    <td colspan="3" class="upit">
                                        <img src="<?php echo $productinfo['image']; ?>" />
                                        <span><?php echo $productinfo['name']; ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php echo $entry_minimumprice . ":"; ?>
                                        <?php echo number_format($productinfo['minimumprice']); ?>
                                    </td>
                                    <td>
                                        <?php echo $entry_averageprice . ":"; ?>
                                        <?php echo number_format($productinfo['averageprice']); ?>
                                    </td>
                                    <td>
                                        <?php echo $entry_maximumprice . ":"; ?>
                                        <?php echo number_format($productinfo['maximumprice']); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>

                                        <?php echo $entry_yourprice; ?>
                                    </td>
                                    <td colspan="2">
                                        <input class="form-control" type="text" name="price[<?php echo $productinfo['id']; ?>]"
                                               value="<?php echo $productinfo['yourprice']; ?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php echo $entry_availability; ?>
                                    </td>
                                    <td colspan="2">

                                        <select class="form-control" name="availability[<?php echo $productinfo['id']; ?>]" id="availability">
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

                                </tr>
                                <tr>
                                    <td>
                                        <?php echo $entry_link; ?>
                                    </td>
                                    <td colspan="2">

                                        <input class="form-control" type="text" name="buy_link[<?php echo $productinfo['id']; ?>]"
                                               value="<?php echo $productinfo['buy_link']; ?>"/>
                                    </td>

                                </tr>
                                <tr>
                                    <td>
                                        <?php echo $entry_description; ?>
                                    </td>
                                    <td colspan="2">

                                        <textarea class="form-control" name="description[<?php echo $productinfo['id']; ?>]" cols="30" rows="4"><?php echo $productinfo['description']; ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="required">*</span> <?php echo $entry_guarantee_status; ?></td>
                                    <td><select  class="form-control" name="guarantee_status[<?php echo $productinfo['id']; ?>]" id="guarantee_status">
                                            <option value="2" <?php if($productinfo['guarantee_status']==2) echo 'selected'; ?>><?php echo $entry_unknown_guarantee; ?></option>
                                            <option value="1" <?php if($productinfo['guarantee_status']==1) echo 'selected'; ?>><?php echo $entry_with_guarantee; ?></option>
                                            <option value="0" <?php if($productinfo['guarantee_status']==0) echo 'selected'; ?>><?php echo $entry_without_guarantee; ?></option>
                                        </select>
                                        <?php if ($error_guarantee_status) { ?>
                                        <span class="error"><?php echo $error_guarantee_status; ?></span>
                                        <?php } ?></td>
                                </tr>
                                <tr>
                                    <td><span class="required">*</span> <?php echo $entry_guarantee_price; ?></td>
                                    <td><input  class="form-control" type="text" name="guarantee_price[<?php echo $productinfo['id']; ?>]" value="<?php echo $productinfo['guarantee_price']; ?>"/>
                                        <?php if ($error_guarantee_price) { ?>
                                        <span class="error"><?php echo $error_guarantee_price; ?></span>
                                        <?php } ?></td>
                                </tr>
                                <tr>
                                    <td><span class="required">*</span> <?php echo $entry_guarantee_time; ?></td>
                                    <td>
                                        <select  class="form-control" name="guarantee_time[<?php echo $productinfo['id']; ?>]" id="guarantee_time">
                                            <?php for($i=1;$i<25;$i++){ ?>
                                            <option value="<?php echo $i; ?>"  <?php if($productinfo['guarantee_time']==$i) echo 'selected'; ?>><?php echo $i; ?></option>
                                            <?php } ?>
                                        </select>
                                        <select  class="form-control" name="guarantee_time_type[<?php echo $productinfo['id']; ?>]" id="guarantee_time_type">
                                            <option value="0" <?php if($productinfo['guarantee_time_type']==0) echo 'selected'; ?>><?php echo $entry_month; ?></option>
                                            <option value="1" <?php if($productinfo['guarantee_time_type']==1) echo 'selected'; ?>><?php echo $entry_year; ?></option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="required">*</span> <?php echo $entry_guarantee_description; ?></td>
                                    <td>
                                        <textarea  class="form-control" rows="4" cols="50" name="guarantee_description[<?php echo $productinfo['id']; ?>]"><?php echo $productinfo['guarantee_description']; ?></textarea>
                                    </td>
                                </tr>
                                <?php if(isset($productinfo['customAttributes'])) { ?>
                                <?php foreach ($productinfo['customAttributes'] as $attribute) { ?>
                                <?php if($attribute['type']=="Selectbox") { ?>
                                <tr>
                                    <td>
                                        <?php echo $attribute['name']; ?>
                                    </td>
                                    <td>
                                        <select class="form-control" name="attribute[<?php echo $attribute['selected_value']['id'];?>]">
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
                                        <input class="form-control" type="text" value="<?php echo $attribute['selected_value']['value'];?>" name="attribute[<?php echo $attribute['selected_value']['id']; ?>]" />
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
                                        <select class="form-control" style="height:100px;" name="attribute[<?php echo $attribute['selected_value']['id']; ?>][]" multiple>
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
                            </table>

                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        <input type="hidden" name="subprofile_id" value="<?php echo $subprofile_id; ?>">
                        <h2><?php echo $text_profile; ?></h2>
                        <div class="content">
                            <?php $cur = 1; ?>
                            <?php foreach ($blocks as $block) { ?>
                            <span class="s-blockName"><?php echo $block['block_name']?></span>
                            [<a href="#" onclick="return addRow(<?php echo $block['block_id']; ?>);" id="<?php echo $block['block_id']; ?>">افزودن سطر جدید</a>]
                            <table class="table-block form"  id="tableBlock-<?php echo $block['block_id']?>" name="tableBlock-<?php echo $block['block_id']?>">
                                <thead>
                                <tr>
                                    <?php foreach ($block['subattributes'] as $subattriute) { ?>
                                    <td>
                                        <?php echo $subattriute['subattribute_name']; ?>
                                    </td>
                                    <?php } ?>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <?php foreach ($block['subattributes'] as $subattriute) { ?>
                                    <td>
                                        <?php if($subattriute['subattribute_type']=="Selectbox") { ?>
                                        <select class="form-control" name="subs[<?php echo $cur;?>][<?php echo $subattriute['subattribute_id'];?>]">
                                            <?php foreach ($subattriute['values'] as $value) { ?>
                                            <option value="<?php echo $value['id'];?>"><?php echo $value['value'];?></option>
                                            <?php } ?>
                                        </select>
                                        <?php }else if($subattriute['subattribute_type']=="Radiobutton") {  ?>
                                        <?php foreach ($subattriute['values'] as $value) { ?>
                                        <input type="radio" name="subs[<?php echo $cur;?>][<?php echo $subattriute['subattribute_id'];?>]" value="<?php echo $value['id'];?>" /><?php echo $value['value'];?>
                                        <?php } ?>
                                        <?php }else if($subattriute['subattribute_type']=="Text") {  ?>
                                        <input class="form-control" type="text" name="subs[<?php echo $cur;?>][<?php echo $subattriute['subattribute_id'];?>]"/>
                                        <?php }else if($subattriute['subattribute_type']=="Multitext") {  ?>
                                        <table id="multi-<?php echo $cur;?>">
                                            <tr>
                                                <td>
                                                    <a onClick="return addMulti(<?php echo $subattriute['subattribute_id'];?>,<?php echo $cur;?>);"><img class="h-remove" src="image/style/add-icon.png" alt="حذف"  /></a>
                                                </td>
                                                <td>
                                                    <input class="form-control" type="text" name="subs[<?php echo $cur;?>][<?php echo $subattriute['subattribute_id'];?>][1][name]"/>
                                                </td>
                                                <td>
                                                    <input class="form-control" type="text" name="subs[<?php echo $cur;?>][<?php echo $subattriute['subattribute_id'];?>][1][star]"/>
                                                </td>
                                            </tr>
                                        </table>
                                        <?php } ?>
                                    </td>
                                    <?php } ?>
                                    <td>
                                        <a onClick="$(this).closest('tr').remove();"><img class="h-remove" src="image/style/remove-hi.png" alt="حذف"  /></a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <?php $cur++; ?>
                            <?php } ?>
                        </div>
                        <div class="pagination"><?php echo $pagination; ?></div>
                        <div class="buttons">
                            <div class="right">
                                <input type="submit" class="form-control" value="<?php echo $button_continue; ?>" class="button"/>
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
    $count = <?php echo count($blocks) ?>;
    $count++;
    function addRow($id){
        switch($id) {
            <?php foreach ($blocks as $block) { ?>
            case <?php echo $block['block_id']; ?>:
                $rowString = "<tr>";
            <?php foreach ($block['subattributes'] as $subattriute) { ?>
                    $rowString += "<td>";
                <?php if($subattriute['subattribute_type']=="Selectbox") { ?>
                        $rowString += "<select name='subs[" + $count + "][<?php echo $subattriute['subattribute_id'];?>]'>";
                    <?php foreach ($subattriute['values'] as $value) { ?>
                            $rowString += "<option value='" + "<?php echo $value['id'];?>" + "'>" + "<?php echo $value['value'];?>" + "</option>";
                        <?php } ?>
                        $rowString += "</select>";
                    <?php }else if($subattriute['subattribute_type']=="Radiobutton") {  ?>
                    <?php foreach ($subattriute['values'] as $value) { ?>
                            $rowString += "<input type='radio' name='subs[" + $count +"]["+"<?php echo $subattriute['subattribute_id'];?>"+"]' value='"+"<?php echo $value['id'];?>"+"' />"+"<?php echo $value['value'];?>";
                        <?php } ?>
                    <?php }else if($subattriute['subattribute_type']=="Text") {  ?>
                        $rowString += "<input type='text' name='subs["+ $count +"]["+"<?php echo $subattriute['subattribute_id'];?>"+"]'/>";
                    <?php }else if($subattriute['subattribute_type']=="Multitext") {  ?>
                        $rowString += "<table id='multi-" + $count + "'>";
                        $rowString += "<tr>";
                        $rowString += "<td>";
                        $rowString += "<a onClick='return addMulti("+"<?php echo $subattriute['subattribute_id'];?>"+"," + $count + ")'><img class='h-remove' src='image/style/add-icon.png' alt='حذف' /></a>";
                        $rowString += "</td>";
                        $rowString += "<td>";
                        $rowString += "<input type='text' name='subs[" + $count + "][" + "<?php echo $subattriute['subattribute_id'];?>" + "][1][name]'/>";
                        $rowString += "</td>";
                        $rowString += "<td>";
                        $rowString += "<input type='text' name='subs[" + $count + "][" + "<?php echo $subattriute['subattribute_id'];?>" + "][1][star]'/>";
                        $rowString += "</td>";
                        $rowString += "</tr>";
                        $rowString += "</table>";
                    <?php } ?>
                    $rowString += "</td>";
                <?php } ?>
                $rowString += "<td><a onClick=\"$(this).closest('tr').remove();\"><img class='h-remove' src='image/style/remove-hi.png' alt='حذف'  /></a></td>";
                $rowString += "</tr>";
                $('#tableBlock-<?php echo $block['block_id']?>').append($rowString);
                break;
            <?php } ?>
        }
        $count++;
        return false;
    }
    function removeRow($id){
        switch($id) {
            <?php foreach ($blocks as $block) { ?>
            case <?php echo $block['block_id']; ?>:
                $('#tableBlock-<?php echo $block['block_id']?> tr:last').remove();
                break;
            <?php } ?>
        }
        return false;
    }
    $multiCount=2;
    function addMulti($id,$cur){
        $rowString = "<tr>";
        $rowString += "<td>";
        $rowString += "</td>";
        $rowString += "<td>";
        $rowString += "<input type='text' name='subs[" + $cur + "][" + $id + "][" + $multiCount + "][name]' />";
        $rowString += "</td>";
        $rowString += "<td>";
        $rowString += "<input type='text' name='subs[" + $cur + "][" + $id + "][" + $multiCount + "][star]' />";
        $rowString += "</td>";
        $rowString += "</tr>";
        $('#multi-' + $cur + ' tr:last').after($rowString);
        $multiCount++;
        return false;
    }
    <?php $currentIndex = 0; ?>
    <?php if(isset($productinfo['customAttributes'])) { ?>
        <?php foreach ($productinfo['customAttributes'] as $attribute) { ?>
            <?php if($attribute['is_block']) { ?>
                <?php foreach ($attribute['selected_value'] as $current_selected) { ?>
                    <?php if ($currentIndex != $current_selected[0]['block_id'] ) { ?>
                            removeRow(<?php echo $current_selected[0]['block_id'] ?>);
                        <?php } ?>
                    <?php $currentIndex = $current_selected[0]['block_id']; ?>
                    $rowString = "<tr>";
                    <?php foreach ($current_selected as $subattriute) { ?>
                        $rowString += "<td>";
                        <?php if($subattriute['type']=="Selectbox") { ?>
                            $rowString += "<select name='subs[" + $count + "][<?php echo $subattriute['block_attribute_id'];?>]'>";
                            <?php foreach ($subattriute['values'] as $value) { ?>
                                $rowString += "<option value='" + "<?php echo $value['id'];?>" + "'>" + "<?php echo $value['value'];?>" + "</option>";
                            <?php } ?>
                            $rowString += "</select>";
                        <?php }else if($subattriute['type']=="Radiobutton") {  ?>
                            <?php foreach ($subattriute['values'] as $value) { ?>
                                $rowString += "<input type='radio' name='subs[" + $count +"]["+"<?php echo $subattriute['block_attribute_id'];?>"+"]' value='"+"<?php echo $value['id'];?>"+"' />"+"<?php echo $value['value'];?>";
                            <?php } ?>
                        <?php }else if($subattriute['type']=="Text") {  ?>
                            $rowString += "<input type='text' name='subs["+ $count +"]["+"<?php echo $subattriute['block_attribute_id'];?>"+"]' value='<?php echo $subattriute['value'];?>'/>";
                        <?php }else if($subattriute['type']=="Multitext") {  ?>
                            $rowString += "<table id='multi-" + $count + "'>";
                            $rowString += "<tr>";
                            $rowString += "<td>";
                            $rowString += "<a onClick='return addMulti("+"<?php echo $subattriute['block_attribute_id'];?>"+"," + $count + ")'><img class='h-remove' src='image/style/add-icon.png' alt='حذف' /></a>";
                            $rowString += "</td>";
                            $rowString += "<td>";
                            $rowString += "<input type='text' name='subs[" + $count + "][" + "<?php echo $subattriute['block_attribute_id'];?>" + "][1][name]'/>";
                            $rowString += "</td>";
                            $rowString += "<td>";
                            $rowString += "<input type='text' name='subs[" + $count + "][" + "<?php echo $subattriute['block_attribute_id'];?>" + "][1][star]'/>";
                            $rowString += "</td>";
                            $rowString += "</tr>";
                            $rowString += "</table>";
                        <?php } ?>
                        $rowString += "</td>";
                    <?php } ?>
                    $rowString += "<td><a onClick=\"$(this).closest('tr').remove();\"><img class='h-remove' src='image/style/remove-hi.png' alt='حذف'  /></a></td>";
                    $rowString += "</tr>";
                    $count++;
                    $('#tableBlock-<?php echo $current_selected[0]['block_id']?>').append($rowString);
                <?php } ?>
            <?php } ?>
        <?php } ?>
    <?php } ?>
</script>
<?php echo $footer; ?>
