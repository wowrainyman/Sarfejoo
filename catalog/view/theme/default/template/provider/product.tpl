<?php echo $header; ?>
<style>
    .double ul{
        width:700px;
        margin-bottom:20px;
        overflow:hidden;
        border-top:1px solid #ccc;
    }
    .double li{
        line-height:1.5em;
        border-bottom:1px solid #ccc;
        float:right;
        display:inline;
    }
    .double li  { width:50%;}
    .triple li  { width:33.333%; }
    .quad li    { width:25%; }
    .six li     { width:16.666%; }
</style>
<div class="row" style="margin-top: 60px;">
    <div class="col-md-3" style="padding: 4px">
        <div class="col-md-12 box-shadow">
            <?php echo $column_right; ?>
        </div>
    </div>
    <div class="col-md-9" style="padding: 4px">
        <div class="row" style="">
            <div class="col-md-12">
                <div class="">
                    <div class="category-list col-md-9">
                        <?php if (count($categories) <= 5) { ?>
                        <ul class="double" style="width: 100% !important;">
                            <?php foreach ($categories as $category) { ?>
                            <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
                            <?php } ?>
                        </ul>
                        <?php } else { ?>
                        <?php for ($i = 0; $i < count($categories);) { ?>
                        <ul class="double">
                            <?php $j = $i + ceil(count($categories) / 4); ?>
                            <?php for (; $i < $j; $i++) { ?>
                            <?php if (isset($categories[$i])) { ?>
                            <li><a href="<?php echo $categories[$i]['href']; ?>"><?php echo $categories[$i]['name']; ?></a></li>
                            <?php } ?>
                            <?php } ?>
                        </ul>
                        <?php } ?>
                        <?php } ?>
                    </div>
                    <div class="product-filter col-md-3">
                        <div class="display">
                            <a style="margin: 5px;" onclick="display('list');"><img id="list-icon" src="catalog/view/icons/view-list.png" width="25" height="25" /></a>
                            <a style="margin: 5px;" onclick="display('grid');"><img id="grid-icon" src="catalog/view/icons/view-column-inactive.png" width="25" height="25" /></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" style="padding: 4px;">
                <div id="content" class="row">
                    <?php echo $content_top; ?>
                    <?php if ($products) { ?>
                    <div class="product-list">
                        <div id="grid-div"  style="display: none;">
                            <?php foreach ($products as $product) { ?>
                            <!-- GridView -->
                            <div class="col-md-3 col-xs-6 col-centered grid-div" style="padding: 4px;" >
                                <div class="col-md-12 box-shadow" style="text-align: center;padding: 4px;">
                                    <div class="row" style="height: 50px;">
                                        <a href="<?php echo $product['href']; ?>">
                                            <span style="margin: auto;">
                                                <?php echo $product['name']; ?>
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
                                        <a href="<?php echo $add; ?>&<?php echo "subprofileid=$subprofileid" . "&productid=" . $product['product_id']  ?>" class="button"><?php echo $button_add_su; ?></a>
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
                                    <div class="row row-centered" style="margin: 10px;">
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
                                        <a href="<?php echo $add; ?>&<?php echo "subprofileid=$subprofileid" . "&productid=" . $product['product_id']  ?>" class="button"><?php echo $button_add_su; ?></a>
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
                    <?php echo $content_bottom; ?></div>
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
        display('list');
    }
</script>
</div>

<?php include 'seo-keyword.php'; ?>

<?php echo $footer; ?>