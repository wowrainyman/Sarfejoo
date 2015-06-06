<?php echo $header; ?>
<?php
function ago($time) {
   $periods = array("ثانیه", "دقیقه", "ساعت", "روز", "هفته", "ماه", "سال", "دهه");
   $lengths = array("60","60","24","7","4.35","12","10");
   $now = time();
       $difference     = $now - $time;
       $tense         = "ago";
   for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
$difference /= $lengths[$j]; 
}
$difference = round($difference);
return "$difference $periods[$j] پیش ";
}
?>

<!-- The Bootstrap Image Gallery lightbox, should be a child element of the document body -->
<div id="blueimp-gallery" class="blueimp-gallery">
    <!-- The container for the modal slides -->
    <div class="slides"></div>
    <!-- Controls for the borderless lightbox -->
    <h3 class="title"></h3>
    <a class="next">‹</a>
    <a class="prev">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
    <!-- The modal dialog, which will be used to wrap the lightbox content -->
    <div class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body next"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left prev">

                        بعدی
                        <i class="glyphicon glyphicon-chevron-right"></i>
                    </button>
                    <button type="button" class="btn btn-primary next">
                        <i class="glyphicon glyphicon-chevron-left"></i>
                        قبلی

                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if(!$is_service){ ?>
    <div class="row" style="margin-top: 60px;">
        <div class="col-md-8" style="padding: 0px;">
            <div class="breadcrumb row" style="margin-bottom: 0;padding-bottom: 3px;">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
                <?php } ?>
            </div>
            <div class="row" style="margin-top: 0;">
            <div class="col-md-12 box-shadow" style="padding-top: 20px;margin-top: 0;">
                <div class="row">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6" style="text-align: left;">
                        <span class="roboto" style="font-size: 22px;padding-left: 20px;">
                            <?php echo $model; ?><img src="catalog/view/images/splitter.png" height="10" width="10" />
                        </span>
                    </div>
                </div>
                <div class="row" style="margin-top: 20px;">
                    <div class="col-md-6">
                        <a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>"  data-gallery><img src="<?php echo $thumb; ?>" style="float: right;width:100%;height:300px;" /></a>
                    </div>
                    <div class="col-md-6">
                        <div class="row" style="">
                            <span style="color: #54B6A9;font-size: 17px;"><?php echo count($providers); ?></span>
                            <span>
                                عرضه کننده
    این محصول
                                را ارائه میدهند
                            </span>
                        </div>
                        <div class="row" style="">
                            <img src="catalog/view/images/up-down-arrow.png" style="float: right;margin-right: 10px;margin-top: 20px;" />
                            <div  style="float: right;margin-top: 20px;margin-right: 30px;">
                                <span style="display: block;">
                                    <a href="index.php?route=product/subprofile&id=<?php echo $maxprice['subprofile_id'] ; ?>"><?php echo (number_format($maxprice['MAX(price)']) . $toman); ?>
                                </span>
                                <span style="display: block;margin-top: 7px;font-size: large;color: #54B6A9;">
                                     <?php echo (number_format($avg_price) . $toman); ?>
                                </span>
                                <span style="display: block;margin-top: 7px;">
                                    <a href="index.php?route=product/subprofile&id=<?php echo $minprice['subprofile_id'];  ?>"><?php echo (number_format($minprice['MIN(price)']) . $toman); ?></a>
                                </span>

                            </div>
                        </div>
                        <!--<div class="row" style="margin-top: 30px;">
                            <button type="button" class="btn btn-default" style="background-color: #F7F7F7;border-right-color: #F96A26;border-right-width: 5px;">
                                قیمت گذاری و ثبت فروشگاه
                            </button><br/><br/>
                            <button type="button" class="btn btn-default" style="background-color: #F7F7F7;border-right-color: #FE4445;border-right-width: 5px;">
    آگاه شدن از نوسان قیمت
                            </button>
                        </div>-->
                    </div>
                </div>
                <div class="row row-centered" style="margin-top: 20px;">
                    <div class="col-md-12 col-centered">
                        <?php foreach ($images as $image) { ?>
                            <a href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" data-gallery>
                                <img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $custom_alt; ?>" width="100" height="80"/>
                            </a>
                        <?php } ?>
                    </div>
                </div>
                <div class="row row-centered" style="margin-top: 20px;margin-bottom: 20px;">
                    <div class="col-md-12 col-centered">
                        <button type="button" class="btn btn-default" style="cursor: default;">
                            <?php echo $date_added; ?>
معرفی شده است
                        </button>
                        <a class="btn btn-default" role="button" onclick="addToWishList('<?php echo $product_id; ?>','<?php echo $thumb; ?>','<?php echo $href; ?>','<?php echo $model; ?>');">
                            <img src="catalog/view/icons/favorite-icon.png" width="10" height="10" />
                            افزودن به علاقه مندی ها
                        </a>
                        <a class="btn btn-default" role="button" onclick="addToCompare('<?php echo $product_id; ?>','<?php echo $thumb; ?>','<?php echo $href; ?>','<?php echo $model; ?>');">
                            <img src="catalog/view/icons/compare-icon.png" width="17" height="10" />
                            مقایسه
                        </a>
                    </div>
                </div>
                </div>
            </div>
            <style>
    .mytab:not(.active){
        color:#ffffff;background-color: #24AA99;
    }
            </style>
            <div class="row">
                <div class="col-md-12" style="text-align: center;padding: 0px;margin: 0px;">
                    <ul class="nav nav-tabs">
                        <li role="presentation" class="active mytab" style="width: 22%;background-color: #24AA99">
                            <a data-toggle="tab" href="#providers-tab" style="">
                                فروشندگان
                            </a>
                        </li>
                        <li role="presentation" class="mytab" style="width: 22%;border-right-color: #000000;border-right-width: 5px;">
                            <a data-toggle="tab" href="#map-tab" style="">
                                نقشه
                            </a>
                        </li>
     <!--                   <li role="presentation" style="width: 22%;border-right-color: #000000;border-right-width: 5px;">
                            <a data-toggle="tab" href="#" style="color:#ffffff;background-color: #24AA99;">
                                نظرات
                            </a>
                        </li>
                        <li role="presentation" style="width: 22%;border-right-color: #000000;border-right-width: 5px;">
                            <a data-toggle="tab" href="#" style="color:#ffffff;background-color: #24AA99;">
                                آمار
                            </a>
                        </li> -->
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 box-shadow" style="text-align: right;padding: 0px;margin: 0px;">
                    <div class="tab-content">
                        <div id="providers-tab" class="tab-pane fade in active">
                            <div class="row" style="padding-right: 20px;padding-top: 25px;">
                                <div class="col-md-5">
                                    مرتب سازی بر اساس
                                    <select class="form-control" id="sel1" onchange="location = this.value;">
                                        <option value="<?php echo $url; ?>">
                                            پیش فرض
                                        </option>
                                        <option value="<?php echo $url; ?>&sort=price">
قیمت
                                        </option>
                                        <option value="<?php echo $url; ?>&sort=date">
                                            تاریخ عرضه

                                        </option>
                                        <option value="<?php echo $url; ?>&sort=fav">
                                            محبوبیت
                                        </option>
                                        <option value="<?php echo $url; ?>&sort=title">
                                            نام
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <?php foreach ($providers as $provider) { ?>
                            <div class="row row-centered">
                                <div class="col-md-11 box-shadow col-centered" style="text-align: right;">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <img style="width: 100%;" height="30" src="ProvidersScans/<?php echo $provider['customer_id'] . '/' . $provider['subprofile_id'] . '/' . 'logo_' . $provider['logo'] ?>" />
                                        </div>
                                        <div class="col-md-3">
                                            <?php echo $provider['title']; ?>
                                            <a target="_blank" class="mapUrl" href="https://www.google.com/maps/embed/v1/directions?key=AIzaSyAYXooqll6ww3TkM5fiP336kUYyhXaxli4&&destination=<?php echo $provider['lat'];?>,<?php echo $provider['lon'];?>"><img src="catalog/view/icons/map-icon.png" /></a>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="subRate" style="direction: ltr;margin-right: 80px;" data-id="<?php echo $provider['subprofile_id']; ?>" data-average="3.5"></div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <span>
                                                وضعیت:
                                            </span>
                                            <span>
                                                موجود
                                            </span>
                                            <br/>
                                            <span>
بروز رسانی:
                                            </span>
                                            <span><?php echo ago(strtotime($provider['update_date']));?></span>
                                            <!--<span>
                                                گارانتی
                                            </span>
                                            <span>
                                                ندارد
                                            </span>-->
                                        </div>
                                        <div class="col-md-3">

                                        </div>
                                        <div class="col-md-5">
                                            <button type="button" class="btn btn-default" style="width:200px;border-radius: 15px;background-color: #7C2981;color: #ffffff;">
                                                <?php echo number_format($provider['price']);?>
                                            </button>
                                            <?php if(!empty($provider['buy_link'])) { ?>
                                                <a role="button" href="index.php?route=linkrelay/external&type=buy&url=<?php echo $provider['buy_link']; ?>" type="button" class="btn btn-default" style="width:200px;border-radius: 15px;background-color: #8AB705;color: #ffffff;">
                                                    <?php echo $p_buy_online;?>
                                                </a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <span>
                                                توضیحات فروشگاه:
                                            </span>
                                            <span>
                                                <?php echo $provider['description'];?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <table>
                                    <?php if (isset($provider['custom_attributes'])) { ?>
                                        <?php foreach ($provider['custom_attributes'] as $cAttributes) { ?>

                                                <tr>
                                                    <td><?php echo $cAttributes['name'];?></td>
                                                    <td>
                                                        <?php if ($cAttributes['type'] == 'Text') { ?>
                                                            <?php echo $cAttributes['selected_value']['value'];?>
                                                        <?php }else{ ?>
                                                            <?php $ids = explode(',',$cAttributes['selected_value']['value']); ?>
                                                            <?php $str=''; ?>
                                                            <?php foreach ($ids as $id) { ?>
                                                                <?php foreach ($cAttributes['values'] as $value) { ?>
                                                                    <?php if ($value['id'] == $id) { ?>
                                                                        <?php if ($str == '') { ?>
                                                                            <?php $str = $value['value'];  ?>
                                                                        <?php }else{ ?>
                                                                            <?php $str .= ' و ' . $value['value'];  ?>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            <?php } ?>
                                                            <?php echo $str;?>
                                                        <?php } ?>
                                                    </td>
                                                </tr>

                                        <?php } ?>
                                    <?php } ?>
                                </table>
                            </div>
                            <?php } ?>
                        </div>
                        <div id="map-tab" class="tab-pane fade">
                            <!--[if lte IE 8 ]>
                            <div class="s-ie-old"><?php echo $text_he_notif; ?></div>
                            <![endif]-->
                            <div id="Gmap" style="height:400px;width:768px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4"  style="padding: 0px;">
            <div class="col-md-12" style="padding-left: 0px;">
                <?php foreach ($attribute_groups as $attribute_group) { ?>
                    <div class="row" style="border-right-width: 20px;border-right-color: #9A33CC">
                        <div class="col-md-12 mj-font" style="text-align: center;">
                            <?php echo $attribute_group['name']; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 box-shadow">
                            <?php $attr_counter = 0; foreach ($attribute_group['attribute'] as $attribute) { ?>
                                <div class="row" style="<?php if($attr_counter%2) echo 'background-color:#DDDDDD'; ?>">
                                    <div class="col-md-12">
                                        <span><?php echo $attribute['name']; ?>:</span>

                                        <span style="float: left;">
                                            <?php if($attribute['text'] == "ندارد") { ?>
                                            <img src="catalog/view/icons/delete-icon.png" width="10" height="10" />
                                            <?php } else if($attribute['text'] == "دارد") { ?>
                                            <img src="catalog/view/icons/check-icon.png" width="10" height="10" />
                                            <?php }else{ ?>
                                            <?php echo $attribute['text']; ?>
                                            <?php } ?>
                                        </span>
                                    </div>
                                </div>
                            <?php $attr_counter++; } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php }else{ ?>
<style>
    .truncate {
        width: 100%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
<div id="providers-tab" class="tab-pane fade in active" style="margin-top:40px;">
    <div class="row" style="padding-right: 0px;padding-top: 25px;">
        مرتب سازی بر اساس

        <div class="dropdown" style="display: inline;margin-right: 20px;">
            <button class="btn btn-default dropdown-toggle" style="width: 150px;" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                کاهش قیمت
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" style="" role="menu" aria-labelledby="dropdownMenu1">
                <li role="presentation">
                    <a role="menuitem" tabindex="-1" href="#">
                        افزایش قیمت
                    </a>
                </li>
                <li role="presentation">
                    <a role="menuitem" tabindex="-1" href="#">
                        تاریخ عرضه
                    </a>
                </li>
                <li role="presentation">
                    <a role="menuitem" tabindex="-1" href="#">
                        محبوبیت
                    </a>
                </li>
                <li role="presentation">
                    <a role="menuitem" tabindex="-1" href="#">
                        نام
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="col-md-12 box-shadow">
                <div class="row" style="">
                    <div class="col-md-12" style="padding: 5px;">
                        <div class="row" style="">
                            <div class="col-md-12" style="padding: 0;">
                                <?php echo $name; ?><br/>
                            </div>
                        </div>
                        <div class="row" style="">
                            <div class="col-md-12" style="padding: 0;">
                                <img src="catalog/view/images/up-down-arrow.png" style="float: right;margin-right: 10px;margin-top: 20px;" />
                                <div  style="float: right;margin-top: 20px;margin-right: 30px;">
                                    <span style="display: block;">
                                        <a href="index.php?route=product/subprofile&id=<?php echo $maxprice['subprofile_id'] ; ?>"><?php echo (number_format($maxprice['MAX(price)']) . $toman); ?>
                                    </span>
                                    <span style="display: block;margin-top: 7px;font-size: large;color: #54B6A9;">
                                         <?php echo (number_format($avg_price) . $toman); ?>
                                    </span>
                                    <span style="display: block;margin-top: 7px;">
                                        <a href="index.php?route=product/subprofile&id=<?php echo $minprice['subprofile_id'];  ?>"><?php echo (number_format($minprice['MIN(price)']) . $toman); ?></a>
                                    </span>

                                </div>
                            </div>
                        </div>
                        <div class="row" style="">
                            <span style="color: #54B6A9;font-size: 17px;"><?php echo count($providers); ?></span>
                            <span>
                                عرضه کننده
    این محصول
                                را ارائه میدهند
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12" style="padding: 0;">
                <?php $counter=0; ?>
                <?php $firstId=0; ?>
                <?php foreach ($providers as $provider) { ?>
                    <?php if ($counter == 0) { ?>
                        <?php $firstId=$provider['subprofile_id']; ?>
                    <?php } ?>
                    <div class="row" style="cursor: pointer;<?php if(!($counter++)%2) echo 'background-color:#FFFFFF'; ?>" id="btn-div-<?php echo $provider['subprofile_id'];?>">
                        <div class="col-md-12" style="padding: 0px;">
                            <div>
                                <?php echo $provider['title'];?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="col-md-9" style="padding: 4px;">
            <div class="col-md-12" style="padding: 4px;">
                <?php foreach ($providers as $provider) { ?>
                <div class="row" id="place-div-<?php echo $provider['subprofile_id'];?>" style="display: none;">
                    <div class="col-md-12 box-shadow" style="padding: 0px;">
                        <div class="row">
                            <div class="col-md-8">
                                <?php echo $provider['address']; ?>
                                <a target="_blank" class="mapUrl" href="https://www.google.com/maps/embed/v1/directions?key=AIzaSyAYXooqll6ww3TkM5fiP336kUYyhXaxli4&&destination=<?php echo $provider['lat'];?>,<?php echo $provider['lon'];?>"><img src="catalog/view/icons/map-icon.png" /></a>
                            </div>
                            <div class="col-md-4" style="background-color: #EDEDED;padding: 0;">
                                <div class="subRate" style="direction: ltr;margin-right: 35px;" data-id="<?php echo $provider['subprofile_id']; ?>" data-average="3.5"></div>
                                <button type="button" class="btn btn-default" style="width:200px;border-radius: 15px;background-color: #5193B6;color: #ffffff;">
                                    <?php echo number_format($provider['price']);?>
                                    تومان
                                </button>
                            </div>
                        </div>
                    </div>

                    <?php $popCounter=0; ?>
                    <div class="col-md-12" style="padding: 4px;">
                        <?php if (isset($provider['custom_attributes'])) { ?>
                            <?php $counter=0; ?>
                            <?php foreach ($provider['custom_attributes'] as $cAttributes) { ?>
                                <?php if ($cAttributes['is_block']) { ?>
                                    <div class="row" style="<?php if(($counter++)%2) echo 'background-color:#FFFFFF'; ?>">
                                        <div class="col-md-3" style="padding: 4px;">
                                                <span>
                                                    <?php echo $cAttributes['name'];?>:
                                                </span>
                                        </div>
                                        <div class="col-md-9">
                                            <button data-toggle="modal" data-target="#Modal<?php echo $popCounter ?>">اطلاعات بیشتر</button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="Modal<?php echo $popCounter ?>" role="dialog">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title"><?php echo $cAttributes['name'];?></h4>
                                                        </div>
                                                        <div class="modal-body" style="padding: 20px;">
                                                            <table class="table table-striped table-bordered">
                                                                <tr>
                                                                    <?php foreach ($cAttributes['selected_value'][0] as $sub) { ?>
                                                                    <th>
                                                                        <?php echo $sub['subattribute_name']; ?>
                                                                    </th>
                                                                    <?php } ?>
                                                                </tr>
                                                                <?php foreach ($cAttributes['selected_value'] as $cur_block) { ?>
                                                                <tr>
                                                                    <?php foreach ($cur_block as $sub) { ?>
                                                                    <td style="width: 100px;">
                                                                        <?php echo str_replace("$","*",$sub['value']); ?>
                                                                    </td>
                                                                    <?php } ?>
                                                                </tr>
                                                                <?php } ?>
                                                            </table>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">بستن پنجره</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $popCounter++; ?>
                                        </div>
                                    </div>
                                <?php }else { ?>
                                    <div class="row" style="<?php if(($counter++)%2) echo 'background-color:#FFFFFF'; ?>">
                                        <div class="col-md-3" style="padding: 4px;">
                                            <span>
                                                <?php echo $cAttributes['name'];?>:
                                            </span>
                                        </div>
                                        <div class="col-md-9">
                                            <span>
                                                <?php if ($cAttributes['type'] == 'Text') { ?>
                                                    <?php if($cAttributes['selected_value']['value'] == "ندارد") { ?>
                                                        <img src="catalog/view/icons/delete-icon.png" width="10" height="10" />
                                                    <?php } else if($cAttributes['selected_value']['value'] == "دارد") { ?>
                                                        <img src="catalog/view/icons/check-icon.png" width="10" height="10" />
                                                    <?php }else{ ?>
                                                        <?php echo $cAttributes['selected_value']['value'];?>
                                                    <?php } ?>
                                                <?php }else{ ?>
                                                    <?php $ids = explode(',',$cAttributes['selected_value']['value']); ?>
                                                    <?php $str=''; ?>
                                                    <?php foreach ($ids as $id) { ?>
                                                        <?php foreach ($cAttributes['values'] as $value) { ?>
                                                            <?php if ($value['id'] == $id) { ?>
                                                                <?php if ($str == '') { ?>
                                                                    <?php $str = $value['value'];  ?>
                                                                <?php }else{ ?>
                                                                    <?php $str .= ' و ' . $value['value'];  ?>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    <?php if($str == "ندارد") { ?>
                                                        <img src="catalog/view/icons/delete-icon.png" width="10" height="10" />
                                                    <?php } else if($str == "دارد") { ?>
                                                        <img src="catalog/view/icons/check-icon.png" width="10" height="10" />
                                                    <?php }else{ ?>
                                                        <?php echo $str;?>
                                                    <?php } ?>
                                                <?php } ?>
                                            </span>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<script type="text/javascript">
    $("div[id^='btn-div-']").on("click",function() {
        $("div[id^='place-div-']").fadeOut( "slow" );
        $thisId = $(this).attr("id");
        $thisId = $thisId.replace("btn-div-", "");
        $("div[id='place-div-" + $thisId + "']").fadeIn( "slow" );
    });
    $("div[id='place-div-<?php echo $firstId; ?>']").css("display","");
</script>


<script type="text/javascript">
        $('.subRate').jRating({
            step:true,
            length : 5
        });
</script>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.colorbox').colorbox({
		overlayClose: true,
		opacity: 0.5,
		rel: "colorbox"
	});
});
//--></script> 
<script type="text/javascript"><!--

$('select[name="profile_id"], input[name="quantity"]').change(function(){
    $.ajax({
		url: 'index.php?route=product/product/getRecurringDescription',
		type: 'post',
		data: $('input[name="product_id"], input[name="quantity"], select[name="profile_id"]'),
		dataType: 'json',
        beforeSend: function() {
            $('#profile-description').html('');
        },
		success: function(json) {
			$('.success, .warning, .attention, information, .error').remove();
            
			if (json['success']) {
                $('#profile-description').html(json['success']);
			}	
		}
	});
});
    
$('#button-cart').bind('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: $('.product-info input[type=\'text\'], .product-info input[type=\'hidden\'], .product-info input[type=\'radio\']:checked, .product-info input[type=\'checkbox\']:checked, .product-info select, .product-info textarea'),
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, information, .error').remove();
			
			if (json['error']) {
				if (json['error']['option']) {
					for (i in json['error']['option']) {
						$('#option-' + i).after('<span class="error">' + json['error']['option'][i] + '</span>');
					}
				}
                
                if (json['error']['profile']) {
                    $('select[name="profile_id"]').after('<span class="error">' + json['error']['profile'] + '</span>');
                }
			} 
			
			if (json['success']) {
				$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
					
				$('.success').fadeIn('slow');
					
				$('#cart-total').html(json['total']);
				
				$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}	
		}
	});
});
//--></script>
<?php if ($options) { ?>
<script type="text/javascript" src="catalog/view/javascript/jquery/ajaxupload.js"></script>
<?php foreach ($options as $option) { ?>
<?php if ($option['type'] == 'file') { ?>
<script type="text/javascript"><!--
new AjaxUpload('#button-option-<?php echo $option['product_option_id']; ?>', {
	action: 'index.php?route=product/product/upload',
	name: 'file',
	autoSubmit: true,
	responseType: 'json',
	onSubmit: function(file, extension) {
		$('#button-option-<?php echo $option['product_option_id']; ?>').after('<img src="catalog/view/theme/default/image/loading.gif" class="loading" style="padding-left: 5px;" />');
		$('#button-option-<?php echo $option['product_option_id']; ?>').attr('disabled', true);
	},
	onComplete: function(file, json) {
		$('#button-option-<?php echo $option['product_option_id']; ?>').attr('disabled', false);
		
		$('.error').remove();
		
		if (json['success']) {
			alert(json['success']);
			
			$('input[name=\'option[<?php echo $option['product_option_id']; ?>]\']').attr('value', json['file']);
		}
		
		if (json['error']) {
			$('#option-<?php echo $option['product_option_id']; ?>').after('<span class="error">' + json['error'] + '</span>');
		}
		
		$('.loading').remove();	
	}
});
//--></script>
<?php } ?>
<?php } ?>
<?php } ?>
<script type="text/javascript"><!--
$('#review .pagination a').live('click', function() {
	$('#review').fadeOut('slow');
		
	$('#review').load(this.href);
	
	$('#review').fadeIn('slow');
	
	return false;
});			

$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

$('#button-review').bind('click', function() {
	$.ajax({
		url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
		type: 'post',
		dataType: 'json',
		data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']:checked').val() ? $('input[name=\'rating\']:checked').val() : '') + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('#button-review').attr('disabled', true);
			$('#review-title').after('<div class="attention"><img src="catalog/view/theme/default/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('#button-review').attr('disabled', false);
			$('.attention').remove();
		},
		success: function(data) {
			if (data['error']) {
				$('#review-title').after('<div class="warning">' + data['error'] + '</div>');
			}
			
			if (data['success']) {
				$('#review-title').after('<div class="success">' + data['success'] + '</div>');
								
				$('input[name=\'name\']').val('');
				$('textarea[name=\'text\']').val('');
				$('input[name=\'rating\']:checked').attr('checked', '');
				$('input[name=\'captcha\']').val('');
			}
		}
	});
});
//--></script> 
<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script> 
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	if ($.browser.msie && $.browser.version == 6) {
		$('.date, .datetime, .time').bgIframe();
	}

	$('.date').datepicker({dateFormat: 'yy-mm-dd'});
	$('.datetime').datetimepicker({
		dateFormat: 'yy-mm-dd',
		timeFormat: 'h:m'
	});
	$('.time').timepicker({timeFormat: 'h:m'});
});
//--></script>
<!--<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBM_cpcmVumeIbUSmEZLhhgfThkbV678CA&sensor=false" />-->
<script type="text/javascript">

</script>
<script type="text/javascript">
    var currentLat=35.6961;
    var currentlon=51.4231;
    function initializeMap(MapId, Lat, Lng, MapType, Zoom) {
        var mapProp = {
            center: new google.maps.LatLng(Lat, Lng),
            zoom: Zoom,
            mapTypeId: MapType,
            scrollwheel: true,
            zoomControl: false,
            streetViewControl: false,
            panControl: false,
            panControlOptions:
            {
                position: google.maps.ControlPosition.LEFT_TOP
            },
            zoomControlOptions:
            {
                position: google.maps.ControlPosition.RIGHT_CENTER
            },
            tilt: 45,
            mapTypeControl:false
        };
        var map = new google.maps.Map(document.getElementById(MapId), mapProp);
        return map;
    }
    var map;//نقشه سایت
    google.maps.event.addDomListener(window, 'load', MakeMap());
    markers = new Array();
    points = new Array();
    infowindow = new Array();
    infoWindowses = new Array();
    var point = new Array();
    var marker = new Array();
    var count=0;
    function loadPoints() {
    <?php foreach ($providers as $provider) { ?>
        point[count] = new google.maps.LatLng(<?php echo $provider['lat'] ?>, <?php echo $provider['lon'] ?>);
        marker[count] = new google.maps.Marker({
            position: point[count],
            animation: google.maps.Animation.DROP
        });
        infowindow[count] = new google.maps.InfoWindow({
            content: "<span style='text-align: center;padding-right: 20px;'><?php echo $provider['title'] ?></span>"
        });
        google.maps.event.addListener(marker[count], 'click', function () {
            for (var i = 0; i < infoWindowses.length; i++) {
                infoWindowses[i].close();
            }
            infoWindowses[count-1].open(map, marker[count]);
            map.panTo(point[count]);
        });
        marker[count].setMap(map);
        markers.push(marker[count]);
        points.push(point[count]);
        infoWindowses.push(infowindow[count]);
        count++;
    <?php } ?>
    }
    function MakeMap() {
        if (navigator.geolocation) {
            $("#preloader").fadeIn("slow");
            navigator.geolocation.getCurrentPosition(success, error);
        } else {
            $('.mapUrl').each(function( index ) {
                $( this ).attr("href",$( this ).attr("href")+"&origin="+currentLat+","+currentlon);
            });
            error('not supported');
            $("#preloader").delay(350).fadeOut("slow");
        }
    }
    function error(msg) {
        map = initializeMap("Gmap", 35.6961, 51.4231, google.maps.MapTypeId.ROADMAP, 15);
        $('.mapUrl').each(function( index ) {
            $( this ).attr("href",$( this ).attr("href")+"&origin="+currentLat+","+currentlon);
        });
        var point = new google.maps.LatLng(35.6961, 51.4231);
        var marker = new google.maps.Marker({
            position: point,
            animation: google.maps.Animation.DROP
        });
        var infowindow = new google.maps.InfoWindow({
            content: "<span style='padding-top:20px;'>محل قرارگیری شما</span>"
        });
        infoWindowses.push(infowindow);
        google.maps.event.addListener(marker, 'click', function () {
            for (var i = 0; i < infoWindowses.length; i++) {
                infoWindowses[i].close();
            }
            infowindow.open(map, marker);
            map.panTo(point);
        });
        marker.setMap(map);
        markers.push(marker);
        points.push(point);
        loadPoints();
    }
    function success(position) {
        map = initializeMap("Gmap", position.coords.latitude, position.coords.longitude, google.maps.MapTypeId.ROADMAP, 15);
        var point = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
        currentLat = position.coords.latitude;
        currentlon = position.coords.longitude;
        $('.mapUrl').each(function( index ) {
            $( this ).attr("href",$( this ).attr("href")+"&origin="+currentLat+","+currentlon);
        });
        var marker = new google.maps.Marker({
            position: point,
            animation: google.maps.Animation.DROP
        });
        var infowindow = new google.maps.InfoWindow({
            content:"<span style='padding-top:20px;'>محل قرارگیری شما</span>"
        });
        infoWindowses.push(infowindow);
        google.maps.event.addListener(marker, 'click', function () {
            for (var i = 0; i < infoWindowses.length; i++) {
                infoWindowses[i].close();
            }
            infowindow.open(map, marker);
            map.panTo(point);
        });
        marker.setMap(map);
        markers.push(marker);
        points.push(point);
        loadPoints();
    }
    function ShowProvidersOnMap() {
        for (var i = 0; i < markers.length; i++) {
            marker.setMap(map);
        }
    }
</script>

<script>
    /* center modal */
    function centerModals(){
        $('.modal').each(function(i){
            var $clone = $(this).clone().css('display', 'block').appendTo('body');
            var top = Math.round(($clone.height() - $clone.find('.modal-content').height()) / 2);
            top = top > 0 ? top : 0;
            $clone.remove();
            $(this).find('.modal-content').css("margin-top", top);
        });
    }
    $('.modal').on('show.bs.modal', centerModals);
    $(window).on('resize', centerModals);
</script>

<div id="bseo">
    <?php echo $stext; ?>
</div>

<?php echo $footer; ?>