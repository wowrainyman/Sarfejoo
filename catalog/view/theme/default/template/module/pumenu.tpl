<style type="text/css">
    .sbc_outer {
        margin: 0px 3px 5px 4px;
        border: 1px solid #ccc;
        padding: 5px;
        float: left;
    }

    .sbc_color_box {
        display: block;
        width: auto;
        height: 20px;
        padidn: 5px;
    }
    .clear_sbc {
        clear: both;
    }
</style>
<?php if($Customer_Group_Id ==2) { ?>
<div class="">
    <div class="box-heading">
        <?php echo $heading_title; ?>
    </div>
    <div class="box-content">
        <div>
            <ul>
                <li><a href="index.php?route=provider/profile"><?php echo $text_menu_profiles; ?></a></li>
                <li><a href="index.php?route=provider/subprofile"><?php echo $text_menu_sub_profiles; ?></a></li>
                <li><a href="index.php?route=provider/product/allsubprofiles"><?php echo $text_menu_add_products; ?></a></li>
                <li><a href="index.php?route=provider/price"><?php echo $text_menu_set_prices; ?></a></li>
                <li><a href="index.php?route=provider/customer_modules"><?php echo $text_menu_customer_modules; ?></a></li>
                <li><a href="index.php?route=provider/rebate"><?php echo $text_menu_set_discounts; ?></a></li>
                <!--
                <li><a href="index.php?route=provider/stat"  ><?php echo $text_menu_pofiles_stat; ?></a></li>
                <li><a href="index.php?route=provider/bank"  ><?php echo $text_menu_bank; ?></a></li>
                <li><a href="index.php?route=provider/advertisement"  ><?php echo $text_menu_advertisments; ?></a></li>
                -->
                <li><a href="index.php?route=provider/etrust"><?php echo $text_menu_namads; ?></a></li>
                <li><a href="index.php?route=provider/idea"><?php echo $text_menu_idea; ?></a></li>
            </ul>
        </div>
    </div>
</div>

<?php } ?>