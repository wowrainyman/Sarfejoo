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
<div id="s-page-content" class="s-row">
     <div class="s-pc-title"><h1><?php echo $subprofile['title']; ?></h1></div>
     <div class="s-row s-pc-option-bar">     </div>
     <?php echo $column_left; ?><?php echo $column_right; ?>

<div id="content" class="s-pc-c-center">
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
                  <input type="submit" value="ثبت رای"/>
                  </form>
              </p>
          </div>
          </div>
          <?php } ?>
     </div>
</div>

  <div id="tabs" class="htabs">
    <a href="#tab-provider"><?php echo $text_products; ?> (<?php echo count($products); ?>)</a>
    <a href="#tab-map"><?php echo $text_map; ?></a>
    <a href="#tab-cmments"><?php echo $text_cmments; ?></a>
  </div>
<div id="tab-provider" class="tab-content">
     provider
</div>
<div id="tab-map" class="tab-content">
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
</div>
  
  <?php echo $content_bottom; ?></div>
  </div>
<script type="text/javascript">
    $(document).ready(function() {
        $('.subRate').jRating({
            step:true,
            length : 5
        });
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

<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBM_cpcmVumeIbUSmEZLhhgfThkbV678CA&sensor=false" />
<script type="text/javascript">

</script>
<script type="text/javascript">
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
            error('not supported');
            $("#preloader").delay(350).fadeOut("slow");
        }
    }
    function error(msg) {
        map = initializeMap("Gmap", 35.6961, 51.4231, google.maps.MapTypeId.ROADMAP, 15);

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

<?php include 'seo-keyword.php'; ?>

<?php echo $footer; ?>