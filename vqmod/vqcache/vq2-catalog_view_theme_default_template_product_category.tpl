<?php echo $header; ?><?php if( ! empty( $mfilter_json ) ) { echo '<div id="mfilter-json" style="display:none">' . base64_encode( $mfilter_json ) . '</div>'; } ?>
<style>
    @media (max-width: 720px) {
        .custom-margin-0{
            margin-top: 0px !important;
        }
        .custom-margin-50{
            margin-top: -50px !important;
        }
    }
</style>
<div class="row custom-margin-0" style="margin-top: 60px;">
    <div class="col-md-3 col-xs-3 col-xs-push-12 col-lg-push-0 col-md-push-0" style="padding: 4px">
        <div class="col-md-12 box-shadow">
            <span>
                نمایش بر اساس عرضه کننده
            </span>
            <select id="filter-subprofile" class="form-control">
                <option value="0">
بدون فیلتر
                </option>
                <?php foreach($allsubs as $subprofile){ ?>
                <option value="<?php echo $subprofile['id'] ?>" <?php if($subprofile['id'] == $filter_subprofile) echo 'selected'; ?>>
                    <?php echo $subprofile['title'] ?>
                </option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-12 box-shadow">
            <?php echo $column_right; ?>
        </div>
    </div>
    <div class="col-md-9 col-xs-12 custom-margin-50" style="padding: 4px">
        <div class="row">
            <div class="col-md-12 hidden-xs box-shadow">
                <?php echo $column_left; ?>
            </div>
        </div>
        <div class="row custom-margin hidden-xs" style="margin-top: 60px;">
            <div class="col-md-12">
                <div class="">
                    <?php if ($products) { ?>
                    <div class="product-filter">
                        <div class="display">
                            <a style="margin: 5px;" onclick="display('list');"><img id="list-icon" src="catalog/view/icons/view-list.png" width="25" height="25" /></a>
                            <a style="margin: 5px;" onclick="display('grid');"><img id="grid-icon" src="catalog/view/icons/view-column-inactive.png" width="25" height="25" /></a>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" style="padding: 4px;">
                <div id="content" class="row">
                    <?php echo $content_top; ?><div id="mfilter-content-container">
                    <?php if ($products) { ?>
                    <div class="product-list">
                        <div id="grid-div"  style="display: none;">
                            <?php foreach ($products as $product) { ?>
                            <!-- GridView -->
                            <div class="col-md-3 col-xs-6 col-centered grid-div" style="padding: 4px;" >
                                <div class="col-md-12 box-shadow" style="text-align: center;padding: 4px;">
                                    <div class="row" style="height: 50px;">
                                        <a href="<?php echo $product['href']; ?>">
                                            <?php
                                                    mb_internal_encoding("UTF-8");
                                                    $str = $product['name'];
                                                    $trimedStr = mb_substr($product['name'], 0, 36);
                                            ?>
                                            <span style="margin: auto;" title="<?php echo $product['name']; ?>" ><?php echo $trimedStr?>
                                                <?php
                                                    if($str!=$trimedStr){
                                                        echo '...';
                                                    }
                                                ?>
                                            </span>
                                        </a>
                                    </div>
                                    <div class="row">
                                        <img src="<?php echo $product['thumb']; ?>" style="width: 120px;height: 120px;" width="120" height="120" />
                                    </div>
                                    <div class="row">
                                <span style="display: block;margin-top: 7px;font-size: 15px;;color: #5AA103;">
                                    <?php if (!$product['special']) { ?>
                                    <?php if ($product['price']!=0) { ?>
                                    <img src="catalog/view/icons/green-down.png" width="15" height="10" />
                                    <?php echo $product['price']; ?>
                                    <?php }else { ?>
                                    <?php echo $text_without_price; ?>
                                    <?php } ?>
                                    <?php } else { ?>
                                    <span class="price-old">
                                    <?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
                                    <?php } ?>
                                </span>
                                    </div>
                                    <div class="row" style="margin-top: 5px;margin-right: -10px;">

                                        <a class="btn btn-default" style="font-size: 13px;" role="button" onclick="addToWishList('<?php echo $product['product_id']; ?>','<?php echo $product['thumb']; ?>','<?php echo $product['href']; ?>','<?php echo $product['name']; ?>');">
                                            <img src="catalog/view/icons/favorite-icon.png" width="10" height="10" />
                                            افزودن به علاقه مندی ها
                                        </a>
                                    </div>
                                    <div class="row" style="margin-top: 5px;">
                                        <a class="btn btn-default" style="font-size: 13px;" role="button" onclick="addToCompare('<?php echo $product['product_id']; ?>','<?php echo $product['thumb']; ?>','<?php echo $product['href']; ?>','<?php echo $product['name']; ?>');">
                                            <img src="catalog/view/icons/compare-icon.png" width="17" height="10" />
                                            مقایسه
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                        <div id="list-div"  style="padding-top: 0px;">
                            <?php foreach ($products as $product) { ?>
                            <!-- ListView -->
                            <div class="col-md-6 col-xs-6 col-centered" class="" style="padding: 4px;" >
                                <div class="col-md-12 box-shadow right-align" style="padding: 4px;">
                                    <div class="row row-centered" style="margin: 10px;height: 50px;">
                                        <div class="col-md-12 col-centered">
                                            <a href="<?php echo $product['href']; ?>">
                                                <span style="margin: auto;">
                                                    <?php echo $product['name']; ?>
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <img src="<?php echo $product['thumb']?>" width="130" height="130" style="float: right;" />
                                        <img src="catalog/view/images/up-down-arrow.png" style="float: right;margin-right: 10px;margin-top: 20px;" />
                                        <div  style="float: right;margin-top: 20px;margin-right: 30px;">
                                    <span style="display: block;">
                                        <?php echo number_format($product['maxprice'])?>
                                        تومان
                                    </span>
                                    <span style="display: block;margin-top: 7px;font-size: large;color: #8AB705;">
                                        <?php echo number_format($product['avg_price'])?>
                                        تومان
                                    </span>
                                    <span style="display: block;margin-top: 7px;">
                                        <?php echo number_format($product['minprice'])?>
                                        تومان
                                    </span>
                                        </div>
                                    </div>
                                    <div class="row row-centered" style="margin-top: 5px;">
                                        <div class="col-md-12 col-centered">
                                            <img src="catalog/view/images/splitter2.png" height="10" width="10" />
                                            <span style="color: #8AB705;font-size: 17px;"><?php echo number_format($product['providers_count'])?></span>
                                    <span>
                                        عرضه کننده
                                        این محصول
                                        را ارائه میدهند
                                    </span>
                                        </div>
                                    </div>
                                    <div class="row row-centered" style="margin-top: 5px;">

                                        <a class="btn btn-default" style="font-size: 13px;margin: 3px;" role="button" onclick="addToWishList('<?php echo $product['product_id']; ?>','<?php echo $product['thumb']; ?>','<?php echo $product['href']; ?>','<?php echo $product['name']; ?>');">
                                            <img src="catalog/view/icons/favorite-icon.png" width="10" height="10" />
                                            افزودن به علاقه مندی ها
                                        </a>

                                        <a class="btn btn-default" style="font-size: 13px;margin: 3px;"" role="button" onclick="addToCompare('<?php echo $product['product_id']; ?>','<?php echo $product['thumb']; ?>','<?php echo $product['href']; ?>','<?php echo $product['name']; ?>');">
                                        <img src="catalog/view/icons/compare-icon.png" width="17" height="10" />
                                        مقایسه
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <?php } ?>
                        </div>
                    </div>
                    <div class="s-pc-c-c-pagenation"><?php echo $pagination; ?></div>
                    <?php } ?>
                    <?php if (!$categories && !$products) { ?>
                    <div class="content"><?php echo $text_empty; ?></div>
                    <div class="buttons">
                        <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
                    </div>
                    <?php } ?>
                    </div><?php echo $content_bottom; ?></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function display(view) {
        if (view == 'list') {
            $('#grid-icon').attr("src","catalog/view/icons/view-column-inactive.png");
            $('#grid-div').css("display","none");
            $('#list-icon').attr("src","catalog/view/icons/view-list.png");
            $('#list-div').css("display","");
            $.totalStorage('display', 'list');
        } else {
            $('#grid-icon').attr("src","catalog/view/icons/view-column.png");
            $('#grid-div').css("display","");
            $('#list-icon').attr("src","catalog/view/icons/view-list-inactive.png");
            $('#list-div').css("display","none");
            $.totalStorage('display', 'grid');
        }
    }
    view = $.totalStorage('display');
    if (view) {
        display(view);
    } else {
        display('grid');
        
    }
    $("#filter-subprofile").change(function () {
        if($( this ).val() != 0){
            var link = "<?php echo $currentUrl; ?>";
            for(var i=0;i<10;i++){

                var link = link.replace("&amp;", "&");
            }
            window.location.href = link+"&subprofile_id="+$( this ).val();
        }else{
            var link = "<?php echo $Url; ?>";
            for(var i=0;i<10;i++){

                var link = link.replace("&amp;", "&");
            }
            window.location.href = link;
        }

    });
</script>
</div>

<div id="bseo">
    <?php echo $stext; ?>
</div>

<?php echo $footer; ?>