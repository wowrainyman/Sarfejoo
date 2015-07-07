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

<div id="" class="">
     <?php echo $content_top; ?>

  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
    <?php echo $breadcrumb['separator']; ?>
    <?php echo $subprofile['title']; ?>
  </div>
  <div class="product-info">
      <?php if ($subprofile) { ?>
    <div class="left">
      <div class="image-sp">
       <img class="p-logo-list-sp" src="ProvidersScans/<?php echo $subprofile['customer_id'] . '/' . $subprofile['id'] . '/' . 'picture_' . $subprofile['picture'] ?>" alt="<?php echo $subprofile['title'] ?>" />
      </div>
      <?php } ?>
    </div>

    <div class="right"><?php if ($subprofile) { ?>
    <h2><?php echo $subprofile['title']; ?></h2>
          <div class="description-p">
          <div id="sp-dec">
          <img class="p-logo-list" src="ProvidersScans/<?php echo $subprofile['customer_id'] . '/' . $subprofile['id'] . '/' . 'logo_' . $subprofile['logo'] ?>" alt="<?php echo $subprofile['title'] ?>" />
             <span class="p-att"><?php echo $p_address; ?></span>
            <p>(<?php echo $subprofile['city']; ?>) <?php echo $subprofile['address']; ?></p>
          <span class="p-att"><?php echo $p_contact; ?></span>
            <p>
            <?php if($p_login_c > 0) {
                echo $p_contact_tel . $subprofile['tel'] . '<br />';
                echo $p_contact_mobile . $subprofile['mobile'] . '<br />';
                echo $p_contact_email . $subprofile['email'] . '<br />';
            } else {
                echo $p_contact_limit;
                echo "<a href='index.php?route=account/account'> <b> $p_contact_login</b> </a>";
                } ?>
                </p>
              <p>

                  <!--
                        rating info
                   -->
                  <?php foreach($rates_info as $rate_info) { ?>
                    <?php echo $rate_info['rating_item']['name'] . ':'; ?>
                    <?php if (isset($rate_info['rating_info']['average'])) { ?>
                        <?php echo $rate_info['rating_info']['average']; ?>
                    <?php } ?>
                      <?php if (isset($rate_info['rating_info']['total_rate'])) { ?>
                        <?php echo $rate_info['rating_info']['total_rate'] . '<br />'; ?>
                      <?php } ?>
                  <?php } ?>


                  <!--
                        user rating info
                   -->
                  <form method="post" action="">
                        <input type="hidden" name="subprofile_id" value="<?php echo $subprofile_id; ?>" />
                      <?php if ($this->customer->isLogged()) { ?>
                          <?php foreach($rates_info as $rate_info) { ?>
                              <?php echo $rate_info['rating_item']['name'] . ':'; ?>
                              <select name="select[<?php echo $rate_info['rating_item']['id']; ?>]">
                                  <?php if (isset($rate_info['user_rate_info']['rate'])) { ?>
                                        <option value="1" <?php if ($rate_info['user_rate_info']['rate'] == 1) { echo 'selected';} ?>>1</option>
                                          <option value="2" <?php if ($rate_info['user_rate_info']['rate'] == 2) { echo 'selected';} ?>>2</option>
                                          <option value="3" <?php if ($rate_info['user_rate_info']['rate'] == 3) { echo 'selected';} ?>>3</option>
                                          <option value="4" <?php if ($rate_info['user_rate_info']['rate'] == 4) { echo 'selected';} ?>>4</option>
                                          <option value="5" <?php if ($rate_info['user_rate_info']['rate'] == 5) { echo 'selected';} ?>>5</option>
                                  <?php }else{ ?>
                                      <option value="1">1</option>
                                      <option value="2">2</option>
                                      <option value="3">3</option>
                                      <option value="4">4</option>
                                      <option value="5">5</option>
                                  <?php } ?>
                              </select>
                          <?php } ?>
                      <?php } ?>
                  <!--<input type="submit" value="ثبت رای"/>-->
                  </form>
              </p>
          </div>
          </div>
          <?php } ?>
     </div>
</div>

  <div id="tabs" class="htabs">
    <a href="#tab-provider"><?php echo $text_products; ?> (<?php echo $total; ?>)</a>
   <!-- <a href="#tab-map"><?php echo $text_map; ?></a>
    <a href="#tab-cmments"><?php echo $text_cmments; ?></a>-->
  </div>
<div id="tab-provider" class="tab-content">
    <?php foreach ($products as $product) { ?>
    <div class="row">
        <div class="col-md-12 box-shadow">
            <div class="row row-centered no-guarantee <?php if(empty($product['buy_link'])) echo 'no-online'; ?>">
                <div class="col-md-11 box-shadow col-centered" style="text-align: right;">
                    <div class="row">
                        <div class="col-md-3 col-xs-5">
                            <img style="width: 100px;height: 100px;" height="100" width="100" src="image/<?php echo $product['image'] ?>" />
                        </div>
                        <div class="col-md-3">
                            <?php echo $provider['title']; ?>
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
                            <span><?php echo ago(strtotime($product['update_date']));?></span><br/>
                                                <span>
                                                    گارانتی
                                                </span>
                                                <span>
                                                    ندارد
                                                </span>
                        </div>
                        <div class="col-md-3">

                        </div>
                        <div class="col-md-5">
                            <button type="button" class="btn btn-default" style="width:200px;border-radius: 15px;background-color: #7C2981;color: #ffffff;">
                                <?php echo number_format($product['price']);?>
                            </button>
                            <?php if(!empty($product['buy_link'])) { ?>
                            <a role="button" href="index.php?route=linkrelay/external&type=buy&url=<?php echo $product['buy_link']; ?>" type="button" class="btn btn-default" style="width:200px;border-radius: 15px;background-color: #8AB705;color: #ffffff;">
                                خرید آنلاین
                            </a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <!--<span>
                                توضیحات فروشگاه:
                            </span>
                            <span>
                                <?php echo $provider['description'];?>
                            </span>-->
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <?php } ?>
        <div class="s-pc-c-c-pagenation"><?php echo $pagination; ?></div>
</div>
<!--<div id="tab-map" class="tab-content">
                        <fieldset class="gllpLatlonPicker">
                            <input id="Search" type="text" class="gllpSearchField"
                                   style="visibility: hidden;display:none;">
                            <input type="text" class="gllpLatitude" value="<?php foreach ($subprofiles as $subprofile) { echo $subprofile['lat']; } ?>" name="lat"
                                   style="visibility: hidden;display:none;">
                            <input type="text" class="gllpLongitude" value="<?php foreach ($subprofiles as $subprofile) { echo $subprofile['lon']; } ?>" name="lon"
                                   style="visibility: hidden;display:none;">
                            <input type="text" class="gllpZoom" value="<?php foreach ($subprofiles as $subprofile) { echo $subprofile['zoom']; } ?>" name="zoom"
                                   style="visibility: hidden;display:none;">
                            <input type="button" class="gllpUpdateButton" value="update map"
                                   style="visibility: hidden;display:none;">
                            <div class="gllpMap">Google Maps</div>
                        </fieldset>
</div>
<div id="tab-cmments" class="tab-content">
    <table class="form">
        <form method="post" action="">
            <input type="hidden" name="subprofile_id" value="<?php echo $subprofile_id; ?>" />
        <?php foreach($comments as $comment) { ?>
        <tr>
            <td>
                <?php echo $comment['firstname'] . $comment['lastname']?>
            </td>
            <td>
                <?php echo $comment['comment']?>
            </td>
        </tr>
        <?php } ?>
        <tr>
            <td>
                نظر
            </td>
            <td>
                <textarea cols="60" rows="10" name="comment"></textarea>
            </td>
        </tr>
        <tr>
            <td>

            </td>
            <td>
                <input type="submit" value="ثبت">
            </td>
        </tr>
        </form>
    </table>
</div>-->

  <?php echo $content_bottom; ?></div>
  </div>
<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script>

<?php include 'seo-keyword.php'; ?>

<?php echo $footer; ?>