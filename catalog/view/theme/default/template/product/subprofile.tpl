<?php echo $header; ?>
<?php
function ago($time) {
   $periods = array("ثانیه", "دقیقه", "ساعت", "روز", "هفته", "ماه", "سال", "دهه");
   $lengths = array("60","60","24","7","4.35","12","10");
   $now = time()+9000;
       $difference     = $now - $time;
       $tense         = "ago";
   for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
$difference /= $lengths[$j];
}
$difference = round($difference);
return "$difference $periods[$j] پیش ";
}
?>
<div id="" class="">
    <div class="s-pc-title"><h1><?php echo $subprofile['title']; ?></h1></div>
    <?php echo $column_left; ?><?php echo $column_right; ?>

    <div>
        <?php echo $content_top; ?>
        <div class="row">
            <div class="col-md-12"
                 style="padding: 0;background-image: url(ProvidersScans/<?php echo $subprofile['customer_id'] . '/' . $subprofile['id'] . '/' . 'picture_' . $subprofile['picture'] ?>);background-size: contain;width: 100%;height: 300px;">
                <div style="position: absolute;background-color: rgba(239,63,62,0.9);width: 100%;height: 100%;color: white;">
                </div>
                <div style="position: absolute;bottom: 50%;right: 40%;padding: 0px;margin:0px;width: 150px;">
                    <img style="width: 150px;height: 75px;" class="p-logo-list-sp"
                         src="ProvidersScans/<?php echo $subprofile['customer_id'] . '/' . $subprofile['id'] . '/' . 'logo_' . $subprofile['picture'] ?>"
                         alt="<?php echo $subprofile['title'] ?>"/>
                </div>
                <div class="yekan"
                     style="position: absolute;bottom: 0;right: 0;background-color: rgba(247,247,247,0.9);width: 100%;height: 90px;color: black;padding: 10px;">
                    <div class="row">
                        <?php if($p_login_c > 0) { ?>
                        <div style="float: right">
                            <img src="catalog/view/icons/ring24.png"
                                 style="width:20px;height:15px;vertical-align:middle;">
                            <span style="padding: 10px;vertical-align:middle;font-size: 18px;">
                                <?php echo $subprofile['tel']; ?>
                                <?php if($subprofile['mobile']) echo '/' . $subprofile['mobile']; ?>
                            </span>
                        </div>
                        <div style="float: left">
                            <span style="padding: 10px;vertical-align:middle;font-size: 18px;">
                                <?php echo $subprofile['email']; ?>
                            </span>
                            <img src="catalog/view/icons/drafts.png" style="vertical-align:middle;">
                        </div>
                        <div style="padding: 10px;color: black;padding-bottom: 50px;padding-right: 0px;">
                            <hr style="color: #000000;margin-bottom: 5px;"/>
                            <img src="catalog/view/icons/gps27.png" style="vertical-align:middle;">
                            <span style="margin: auto;horiz-align: center;">
                                (<?php echo $subprofile['city']; ?>) <?php echo $subprofile['address']; ?>
                            </span>
                        </div>
                        <?php } else {
                        echo $p_contact_limit;
                        echo "<a href='index.php?route=account/account'> <b> $p_contact_login</b> </a>";
                        } ?>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <?php foreach ($products as $product) { ?>
            <div class="col-md-3 col-xs-6 col-centered grid-div" style="padding: 4px;">
                <div class="col-md-12 box-shadow" style="text-align: center;padding: 4px;">
                    <div class="row" style="height: 50px;">
                        <a href="<?php echo $product['href']; ?>">
                            <?php
                                    mb_internal_encoding("UTF-8");
                                    $str = $product['name'];
                                    $trimedStr = mb_substr($product['name'], 0, 36);
                            ?>
                            <span style="margin: auto;"
                                  title="<?php echo $product['name']; ?>"><?php echo $trimedStr?>
                                <?php
                                    if($str!=$trimedStr){
                                        echo '...';
                                    }
                                ?>
                            </span>
                        </a>
                    </div>
                    <div class="row">
                        <img src="<?php echo $product['thumb']; ?>" style="width: 120px;height: 120px;" width="120"
                             height="120"/>
                    </div>
                    <div class="row">
                        <span style="display: block;margin-top: 7px;font-size: 15px;;color: #5AA103;">
                            <?php if (!$product['special']) { ?>
                            <?php if ($product['sub_price']!=0) { ?>
                            <img src="catalog/view/icons/green-down.png" width="15" height="10"/>
                            <?php echo $product['sub_price']; ?>
                            <?php }else { ?>
                            <?php echo $text_without_price; ?>
                            <?php } ?>
                            <?php } else { ?>
                            <span class="price-old">
                            <?php echo $product['sub_price']; ?></span> <span
                                    class="price-new"><?php echo $product['special']; ?></span>
                            <?php } ?>
                        </span>
                    </div>
                    <div class="row" style="margin-top: 5px;margin-right: -10px;">

                        <a class="btn btn-default" style="font-size: 13px;" role="button"
                           onclick="addToWishList('<?php echo $product['product_id']; ?>','<?php echo $product['thumb']; ?>','<?php echo $product['href']; ?>','<?php echo $product['name']; ?>');">
                            <img src="catalog/view/icons/favorite-icon.png" width="10" height="10"/>
                            افزودن به علاقه مندی ها
                        </a>
                    </div>
                    <div class="row" style="margin-top: 5px;">
                        <a class="btn btn-default" style="font-size: 13px;" role="button"
                           onclick="addToCompare('<?php echo $product['product_id']; ?>','<?php echo $product['thumb']; ?>','<?php echo $product['href']; ?>','<?php echo $product['name']; ?>');">
                            <img src="catalog/view/icons/compare-icon.png" width="17" height="10"/>
                            مقایسه
                        </a>
                    </div>
                </div>

            </div>
            <?php } ?>
            <div class="row">
                <div class="s-pc-c-c-pagenation">
                    <?php echo $pagination; ?>
                </div>
            </div>
        </div>
        <?php echo $content_bottom; ?></div>
</div>
<script type="text/javascript"><!--
    $('#tabs a').tabs();
    //--></script>

<?php include 'seo-keyword.php'; ?>

<?php echo $footer; ?>