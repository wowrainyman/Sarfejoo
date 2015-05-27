<?php echo $header; ?>
<div class="row row-centered" style="margin-top: 60px;margin-bottom: 0px;padding-bottom: 0px;">
    <div class="col-md-2" style="padding: 0px;margin-bottom: 0px;">
        <div class="col-md-12 box-shadow" style="padding: 0px;margin-bottom: 0px;">
            <div class="row" style="margin-top: 5px;padding: 0px;">
                <a class="btn mj-font" style="font-size: 13px;background-color: #767070;width: 100%;margin-top:4px;color:#FFFFFF;border-right-color: #FF9600;border-right-width: 5px;" role="button">
برخی از عرضه کنندگان
                </a>
            </div>
            <div class="row" style="margin-top: 15px;padding: 0px;margin-bottom: 0px;">
                <img src="catalog/view/images/samples/sample-logo.png" style="width: 80%;height: 50px;" alt="Amir" />
            </div>
            <div class="row" style="margin-top: 15px;padding: 0px;">
                <img src="catalog/view/images/samples/sample-logo.png" style="width: 80%;height: 50px;" />
            </div>
            <div class="row" style="margin-top: 15px;padding: 0px;">
                <img src="catalog/view/images/samples/sample-logo.png" style="width: 80%;height: 50px;" />
            </div>
            <div class="row" style="margin-top: 15px;margin-bottom: 15px;padding: 0px;">
                <img src="catalog/view/images/samples/sample-logo.png" style="width: 80%;height: 50px;" />
            </div>
        </div>
        <div class="col-md-12 box-shadow">
            <style>
                .toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px; }
                .toggle.ios .toggle-handle { border-radius: 20px; }
            </style>
            <div class="row" style="margin-top: 5px;padding: 0px;">
                <input id="dif-btn" type="checkbox" checked data-toggle="toggle" data-style="ios" data-width="50" data-height="25" data-onstyle="success" />
نمایش تفاوت ها
            </div>
        </div>
    </div>
    <div class="col-md-10">
        <?php foreach ($products as $product) { ?>
            <div class="col-md-3 rlpadding" style="">
                <div class="col-md-12 box-shadow col-centered" style="padding: 5px;margin-bottom: 0px;">
                    <a href="<?php echo $product['remove']; ?>" class="" title="<?php echo $button_remove; ?>">
                        <img src="catalog/view/icons/delete-icon.png" width="10" height="10" />
                    </a>
                    <div class="row" style="height: 50px;margin-top: 20px;">

                            <span style="margin: auto;">
                                <?php echo $product['manufacturer']; ?>
                            </span>

                    </div>
                    <div class="row" style="height: 50px;margin-top: 2px;">
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
                        <span style="display: block;margin-top: 7px;font-size: 15px;;color: #5AA103;height: 20px;">
                            <?php if ($product['price']!=0) { ?>
                            <img src="catalog/view/icons/green-down.png" width="15" height="10" />
                            <?php echo $product['price']; ?>
                            <?php }else { ?>
                            <?php echo $text_without_price; ?>
                            <?php } ?>
                        </span>
                    </div>
                    <div class="row" style="margin-top: 5px;">
                        <a class="btn btn-default" style="font-size: 13px;width: 100%;margin-top:4px;" role="button" onclick="addToWishList('$product['product_id']; ?>','<?php echo $thumb; ?>','<?php echo $href; ?>','<?php echo $model; ?>');">
                            <img src="catalog/view/icons/favorite-icon.png" width="10" height="10" />
                            افزودن به علاقه مندی ها
                        </a>
                    </div>
                    <div class="row" style="margin-top: 5px;">
                        <a href="<?php echo $product['href']; ?>" class="btn" style="font-size: 13px;background-color: #FF9600;width: 100%;margin-top:4px;" role="button">
                            مشاهده عرضه کنندگان
                        </a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<div class="row" style="margin: 0px;padding: 0px;text-align: center;">
    <div class="col-md-2  box-shadow" style="margin: 0px;padding: 0px;">
        <?php foreach ($attribute_groups as $attribute_group) { ?>
            <div class="row" style="background-color: #756F6F;color:#FFFFFF;margin: 0px;padding: 0px;height: 30px;">
                <span class="mj-font"><?php echo $attribute_group['name']; ?></span>
            </div>

            <?php foreach ($attribute_group['attribute'] as $key => $attribute) { ?>
                <?php $isDifferent=false;$firstTime=true; ?>
                <?php foreach ($products as $product) { ?>
                <?php if (isset($products[$product['product_id']]['attribute'][$key])) { ?>
                <?php if ($firstTime) { ?>
                <?php $previousItem=$products[$product['product_id']]['attribute'][$key];?>
                <?php $firstTime=false;?>
                <?php } else { ?>
                <?php if ($products[$product['product_id']]['attribute'][$key]!=$previousItem) { ?>
                <?php $isDifferent=true; ?>
                <?php } ?>
                <?php $previousItem=$products[$product['product_id']]['attribute'][$key]; ?>
                <?php } ?>
                <?php } else { ?>
                <?php if(isset($previousItem) || !$firstTime){ ?>
                <?php $isDifferent=true; ?>
                <?php } ?>
                <?php } ?>
                <?php } ?>
                <div class='row <?php if($isDifferent) echo "c-dif"; ?>' data-dif="<?php if($isDifferent) echo 'true'; ?>" style="text-align: right;padding-right: 5px;height: 30px;">
                    <span class=""><?php echo $attribute['name']; ?></span>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
    <style>
        .zeroTop{
            margin-top: 0px;
            padding-top: 0px;
            margin-bottom: 0px;
            padding-bottom: 0px;
        }
        .rlpadding{
            padding-right: 5px;
            padding-left: 5px;
        }
    </style>
    <div class="col-md-10" style="">
        <?php foreach ($attribute_groups as $attribute_group) { ?>
            <div class="row zeroTop" style="">
                <?php foreach ($products as $product) { ?>
                    <div class="col-md-3 zeroTop rlpadding">
                        <div class="col-md-12 box-shadow zeroTop" style="background-color: #756F6F;height: 30px;"></div>
                    </div>
                <?php } ?>
            </div>
            <?php foreach ($attribute_group['attribute'] as $key => $attribute) { ?>
                <tbody>
                <?php $isDifferent=false;$firstTime=true; ?>
                <?php foreach ($products as $product) { ?>
                    <?php if (isset($products[$product['product_id']]['attribute'][$key])) { ?>
                        <?php if ($firstTime) { ?>
                            <?php $previousItem=$products[$product['product_id']]['attribute'][$key];?>
                            <?php $firstTime=false;?>
                        <?php } else { ?>
                            <?php if ($products[$product['product_id']]['attribute'][$key]!=$previousItem) { ?>
                                <?php $isDifferent=true; ?>
                            <?php } ?>
                            <?php $previousItem=$products[$product['product_id']]['attribute'][$key]; ?>
                        <?php } ?>
                    <?php } else { ?>
                        <?php if(isset($previousItem) || !$firstTime){ ?>
                        <?php $isDifferent=true; ?>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
                <div class='row  zeroTop' style="height: 30px;overflow: hidden;">
                    <?php foreach ($products as $product) { ?>
                        <?php if (isset($products[$product['product_id']]['attribute'][$key])) { ?>
                            <div class="col-md-3 zeroTop rlpadding">
                                <div class='col-md-12 box-shadow zeroTop <?php if($isDifferent) echo "c-dif"; ?>'  data-dif="<?php if($isDifferent) echo 'true'; ?>" style="height: 30px;">
                                    <?php if($products[$product['product_id']]['attribute'][$key] == "ندارد") { ?>
                                        <img src="catalog/view/icons/delete-icon.png" width="10" height="10" />
                                    <?php } else if($products[$product['product_id']]['attribute'][$key] == "دارد") { ?>
                                        <img src="catalog/view/icons/check-icon.png" width="10" height="10" />
                                    <?php }else{ ?>
                                        <?php echo $products[$product['product_id']]['attribute'][$key]; ?>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="col-md-3 zeroTop rlpadding">
                                <div class='col-md-12 box-shadow zeroTop <?php if($isDifferent) echo "c-dif"; ?>' data-dif="<?php if($isDifferent) echo 'true'; ?>"  style="height: 30px;"></div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
                </tbody>
            <?php } ?>
        <?php } ?>
    </div>
</div>
<script type="text/javascript">
    $("#dif-btn").change(function() {
        if(this.checked) {
            $('*[data-dif="true"]').addClass("c-dif");
        }else{
            $('*[data-dif="true"]').removeClass("c-dif");
        }
    });
</script>
<?php echo $footer; ?>