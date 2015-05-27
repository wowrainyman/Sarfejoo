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
    <div class="col-md-9" style="padding: 4px;">
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
                                                <select name="subs[<?php echo $cur;?>][<?php echo $subattriute['subattribute_id'];?>]">
                                                    <?php foreach ($subattriute['values'] as $value) { ?>
                                                        <option value="<?php echo $value['id'];?>"><?php echo $value['value'];?></option>
                                                    <?php } ?>
                                                </select>
                                            <?php }else if($subattriute['subattribute_type']=="Radiobutton") {  ?>
                                                <?php foreach ($subattriute['values'] as $value) { ?>
                                                    <input type="radio" name="subs[<?php echo $cur;?>][<?php echo $subattriute['subattribute_id'];?>]" value="<?php echo $value['id'];?>" /><?php echo $value['value'];?>
                                                <?php } ?>
                                            <?php }else if($subattriute['subattribute_type']=="Text") {  ?>
                                                <input type="text" name="subs[<?php echo $cur;?>][<?php echo $subattriute['subattribute_id'];?>]"/>
                                            <?php }else if($subattriute['subattribute_type']=="Multitext") {  ?>
                                                <table id="multi-<?php echo $cur;?>">
                                                    <tr>
                                                        <td>
                                                            <a onClick="return addMulti(<?php echo $subattriute['subattribute_id'];?>,<?php echo $cur;?>);"><img class="h-remove" src="image/style/add-icon.png" alt="حذف"  /></a>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="subs[<?php echo $cur;?>][<?php echo $subattriute['subattribute_id'];?>][1][name]"/>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="subs[<?php echo $cur;?>][<?php echo $subattriute['subattribute_id'];?>][1][star]"/>
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
</script>
<?php echo $footer; ?>
