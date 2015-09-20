<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/customer.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <div id="htabs" class="htabs">
          <a href="#tab-general"><?php echo $tab_general; ?></a>
          <a href="#tab-verifications"><?php echo $tab_verifications; ?></a>
          <a href="#tab-rating"><?php echo $tab_rating; ?></a>
      </div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
		  <input type="hidden" name="id" value="<?php echo $id; ?>" />
        <div id="tab-general">
            <table class="form">
                <tr>
                    <td><?php echo $entry_customer_id; ?></td>
                    <td><input type="text" name="customer_id" value="<?php echo $customer_id; ?>" disabled/>
                </tr>
                <tr>
                    <td><?php echo $entry_group_id; ?></td>
                    <td><input type="text" name="group_id" value="<?php echo $group_id; ?>" />
                </tr>
                <tr>
                    <td><?php echo $entry_title; ?></td>
                    <td><input type="text" name="title" value="<?php echo $title; ?>" />
                </tr>
                <tr>
                    <td><?php echo $entry_seo_keyword; ?></td>
                    <td><input type="text" name="seo_keyword" value="<?php echo $seo_keyword; ?>" />
                </tr>
                <tr>
                    <td><?php echo $entry_legalperson_id; ?></td>
                    <td><input type="text" name="legalperson_id" value="<?php echo $legalperson_id; ?>" />
                </tr>
                <tr>
                    <td><?php echo $entry_province_id; ?></td>
                    <td><input type="text" name="province_id" value="<?php echo $province_id; ?>" />
                </tr>
                <tr>
                    <td><?php echo $entry_city; ?></td>
                    <td><input type="text" name="city" value="<?php echo $city; ?>" />
                </tr>
                <tr>
                    <td><?php echo $entry_address; ?></td>
                    <td><input type="text" name="address" value="<?php echo $address; ?>" />
                </tr>
                <tr>
                    <td><?php echo $entry_lat; ?></td>
                    <td><input type="text" name="lat" value="<?php echo $lat; ?>" />
                </tr>
                <tr>
                    <td><?php echo $entry_lon; ?></td>
                    <td><input type="text" name="lon" value="<?php echo $lon; ?>" />
                </tr>
                <tr>
                    <td><?php echo $entry_zoom; ?></td>
                    <td><input type="text" name="zoom" value="<?php echo $zoom; ?>" />
                </tr>

                <tr>
                    <td><?php echo $entry_tel; ?></td>
                    <td><input type="text" name="tel" value="<?php echo $tel; ?>" />
                </tr>
                <tr>
                    <td><?php echo $entry_mobile; ?></td>
                    <td><input type="text" name="mobile" value="<?php echo $mobile; ?>" />
                </tr>
                <tr>
                    <td><?php echo $entry_email; ?></td>
                    <td><input type="text" name="email" value="<?php echo $email; ?>" />
                </tr>
            </table>
        </div>
        <div id="tab-verifications">
			<table class="form">
				<tr>
					<td><?php echo $entry_website; ?></td>
					<td><input type="text" name="website" value="<?php echo $website; ?>" />
				</tr>
				<tr>
					<td><?php echo $entry_picture; ?></td>
					<td><img width="350" height="auto" class="p-logo-list-sp" src="../ProvidersScans/<?php echo $customer_id . '/' . $id . '/' . 'picture_' . $picture ?>" alt="<?php echo $title ?>" /></td>
				</tr>
				<tr>
					<td><?php echo $entry_logo; ?></td>
					<td>
						<img class="p-logo-list" src="../ProvidersScans/<?php echo $customer_id . '/' . $id . '/' . 'logo_' . $logo ?>" alt="<?php echo $title ?>" />
					</td>
				</tr>
				<tr>
					<td><?php echo $entry_is_payed; ?></td>
					<td style="width: 200px;"><input type="text" name="is_payed" value="<?php echo $is_payed; ?>" /></td>
					<td>Send Message<input type="checkbox" name="pay_sms" /> </td>
					<td>Send Email<input type="checkbox" name="pay_email" /> </td>
				</tr>
				<tr>
					<td><?php echo $entry_status_id; ?></td>
					<td><input type="text" name="status_id" value="<?php echo $status_id; ?>" /></td>
					<td>Send Message<input type="checkbox" name="status_sms" /> </td>
					<td>Send Email<input type="checkbox" name="status_email" /> </td>
				</tr>
				<tr>
					<td><?php echo $entry_adminmessage; ?></td>
					<td><textarea type="text" name="adminmessage"><?php echo $adminmessage; ?></textarea></td>
					<td>Send Message<input type="checkbox" name="adminmessage_sms" /> </td>
					<td>Send Email<input type="checkbox" name="adminmessage_email" /> </td>
				</tr>
			</table>
        </div>
        <div id="tab-rating">
			<table class="form">
				<tr>
					<td><?php echo $entry_rating; ?></td>
					<td>
						<select name="rate">
							<option value="1" <?php if ($rate == 1) { echo 'selected';} ?>>1</option>
							<option value="2" <?php if ($rate == 2) { echo 'selected';} ?>>2</option>
							<option value="3" <?php if ($rate == 3) { echo 'selected';} ?>>3</option>
							<option value="4" <?php if ($rate == 4) { echo 'selected';} ?>>4</option>
							<option value="5" <?php if ($rate == 5) { echo 'selected';} ?>>5</option>
						</select>
					</td>
				</tr>
			</table>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('select[name=\'customer_group_id\']').live('change', function() {
	var customer_group = [];

<?php foreach ($customer_groups as $customer_group) { ?>
	customer_group[<?php echo $customer_group['customer_group_id']; ?>] = [];
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['company_id_display'] = '<?php echo $customer_group['company_id_display']; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['tax_id_display'] = '<?php echo $customer_group['tax_id_display']; ?>';
<?php } ?>

	if (customer_group[this.value]) {
		if (customer_group[this.value]['company_id_display'] == '1') {
			$('.company-id-display').show();
		} else {
			$('.company-id-display').hide();
		}

		if (customer_group[this.value]['tax_id_display'] == '1') {
			$('.tax-id-display').show();
		} else {
			$('.tax-id-display').hide();
		}
	}
});

$('select[name=\'customer_group_id\']').trigger('change');
//--></script>
<script type="text/javascript"><!--
function country(element, index, zone_id) {
  if (element.value != '') {
		$.ajax({
			url: 'index.php?route=sale/customer/country&token=<?php echo $token; ?>&country_id=' + element.value,
			dataType: 'json',
			beforeSend: function() {
				$('select[name=\'address[' + index + '][country_id]\']').after('<span class="wait">&nbsp;<img src="view/image/loading.gif" alt="" /></span>');
			},
			complete: function() {
				$('.wait').remove();
			},
			success: function(json) {
				if (json['postcode_required'] == '1') {
					$('#postcode-required' + index).show();
				} else {
					$('#postcode-required' + index).hide();
				}

				html = '<option value=""><?php echo $text_select; ?></option>';

				if (json['zone'] != '') {
					for (i = 0; i < json['zone'].length; i++) {
						html += '<option value="' + json['zone'][i]['zone_id'] + '"';

						if (json['zone'][i]['zone_id'] == zone_id) {
							html += ' selected="selected"';
						}

						html += '>' + json['zone'][i]['name'] + '</option>';
					}
				} else {
					html += '<option value="0"><?php echo $text_none; ?></option>';
				}

				$('select[name=\'address[' + index + '][zone_id]\']').html(html);
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
}

$('select[name$=\'[country_id]\']').trigger('change');
//--></script>
<script type="text/javascript"><!--
var address_row = <?php echo $address_row; ?>;

function addAddress() {
	html  = '<div id="tab-address-' + address_row + '" class="vtabs-content" style="display: none;">';
	html += '  <input type="hidden" name="address[' + address_row + '][address_id]" value="" />';
	html += '  <table class="form">';
	html += '    <tr>';
    html += '	   <td><span class="required">*</span> <?php echo $entry_firstname; ?></td>';
    html += '	   <td><input type="text" name="address[' + address_row + '][firstname]" value="" /></td>';
    html += '    </tr>';
    html += '    <tr>';
    html += '      <td><span class="required">*</span> <?php echo $entry_lastname; ?></td>';
    html += '      <td><input type="text" name="address[' + address_row + '][lastname]" value="" /></td>';
    html += '    </tr>';
    html += '    <tr>';
    html += '      <td><?php echo $entry_company; ?></td>';
    html += '      <td><input type="text" name="address[' + address_row + '][company]" value="" /></td>';
    html += '    </tr>';
    html += '    <tr class="company-id-display">';
    html += '      <td><?php echo $entry_company_id; ?></td>';
    html += '      <td><input type="text" name="address[' + address_row + '][company_id]" value="" /></td>';
    html += '    </tr>';
    html += '    <tr class="tax-id-display">';
    html += '      <td><?php echo $entry_tax_id; ?></td>';
    html += '      <td><input type="text" name="address[' + address_row + '][tax_id]" value="" /></td>';
    html += '    </tr>';
    html += '    <tr>';
    html += '      <td><span class="required">*</span> <?php echo $entry_address_1; ?></td>';
    html += '      <td><input type="text" name="address[' + address_row + '][address_1]" value="" /></td>';
    html += '    </tr>';
    html += '    <tr>';
    html += '      <td><?php echo $entry_address_2; ?></td>';
    html += '      <td><input type="text" name="address[' + address_row + '][address_2]" value="" /></td>';
    html += '    </tr>';
    html += '    <tr>';
    html += '      <td><span class="required">*</span> <?php echo $entry_city; ?></td>';
    html += '      <td><input type="text" name="address[' + address_row + '][city]" value="" /></td>';
    html += '    </tr>';
    html += '    <tr>';
    html += '      <td><span id="postcode-required' + address_row + '" class="required">*</span> <?php echo $entry_postcode; ?></td>';
    html += '      <td><input type="text" name="address[' + address_row + '][postcode]" value="" /></td>';
    html += '    </tr>';
	html += '    <tr>';
    html += '      <td><span class="required">*</span> <?php echo $entry_country; ?></td>';
    html += '      <td><select name="address[' + address_row + '][country_id]" onchange="country(this, \'' + address_row + '\', \'0\');">';
    html += '         <option value=""><?php echo $text_select; ?></option>';
    <?php foreach ($countries as $country) { ?>
    html += '         <option value="<?php echo $country['country_id']; ?>"><?php echo addslashes($country['name']); ?></option>';
    <?php } ?>
    html += '      </select></td>';
    html += '    </tr>';
    html += '    <tr>';
    html += '      <td><span class="required">*</span> <?php echo $entry_zone; ?></td>';
    html += '      <td><select name="address[' + address_row + '][zone_id]"><option value="false"><?php echo $this->language->get('text_none'); ?></option></select></td>';
    html += '    </tr>';
	html += '    <tr>';
    html += '      <td><?php echo $entry_default; ?></td>';
    html += '      <td><input type="radio" name="address[' + address_row + '][default]" value="1" /></td>';
    html += '    </tr>';
    html += '  </table>';
    html += '</div>';

	$('#tab-general').append(html);

	$('select[name=\'address[' + address_row + '][country_id]\']').trigger('change');

	$('#address-add').before('<a href="#tab-address-' + address_row + '" id="address-' + address_row + '"><?php echo $tab_address; ?> ' + address_row + '&nbsp;<img src="view/image/delete.png" alt="" onclick="$(\'#vtabs a:first\').trigger(\'click\'); $(\'#address-' + address_row + '\').remove(); $(\'#tab-address-' + address_row + '\').remove(); return false;" /></a>');

	$('.vtabs a').tabs();

	$('#address-' + address_row).trigger('click');

	address_row++;
}
//--></script>
<script type="text/javascript"><!--
$('#history .pagination a').live('click', function() {
	$('#history').load(this.href);

	return false;
});

$('#history').load('index.php?route=sale/customer/history&token=<?php echo $token; ?>&customer_id=<?php echo $customer_id; ?>');

$('#button-history').bind('click', function() {
	$.ajax({
		url: 'index.php?route=sale/customer/history&token=<?php echo $token; ?>&customer_id=<?php echo $customer_id; ?>',
		type: 'post',
		dataType: 'html',
		data: 'comment=' + encodeURIComponent($('#tab-history textarea[name=\'comment\']').val()),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('#button-history').attr('disabled', true);
			$('#history').before('<div class="attention"><img src="view/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('#button-history').attr('disabled', false);
			$('.attention').remove();
      		$('#tab-history textarea[name=\'comment\']').val('');
		},
		success: function(html) {
			$('#history').html(html);

			$('#tab-history input[name=\'comment\']').val('');
		}
	});
});
//--></script>
<script type="text/javascript"><!--
$('#transaction .pagination a').live('click', function() {
	$('#transaction').load(this.href);

	return false;
});

$('#transaction').load('index.php?route=sale/customer/transaction&token=<?php echo $token; ?>&customer_id=<?php echo $customer_id; ?>');

$('#button-transaction').bind('click', function() {
	$.ajax({
		url: 'index.php?route=sale/customer/transaction&token=<?php echo $token; ?>&customer_id=<?php echo $customer_id; ?>',
		type: 'post',
		dataType: 'html',
		data: 'description=' + encodeURIComponent($('#tab-transaction input[name=\'description\']').val()) + '&amount=' + encodeURIComponent($('#tab-transaction input[name=\'amount\']').val()),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('#button-transaction').attr('disabled', true);
			$('#transaction').before('<div class="attention"><img src="view/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('#button-transaction').attr('disabled', false);
			$('.attention').remove();
		},
		success: function(html) {
			$('#transaction').html(html);

			$('#tab-transaction input[name=\'amount\']').val('');
			$('#tab-transaction input[name=\'description\']').val('');
		}
	});
});
//--></script>
<script type="text/javascript"><!--
$('#reward .pagination a').live('click', function() {
	$('#reward').load(this.href);

	return false;
});

$('#reward').load('index.php?route=sale/customer/reward&token=<?php echo $token; ?>&customer_id=<?php echo $customer_id; ?>');

function addRewardPoints() {
	$.ajax({
		url: 'index.php?route=sale/customer/reward&token=<?php echo $token; ?>&customer_id=<?php echo $customer_id; ?>',
		type: 'post',
		dataType: 'html',
		data: 'description=' + encodeURIComponent($('#tab-reward input[name=\'description\']').val()) + '&points=' + encodeURIComponent($('#tab-reward input[name=\'points\']').val()),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('#button-reward').attr('disabled', true);
			$('#reward').before('<div class="attention"><img src="view/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('#button-reward').attr('disabled', false);
			$('.attention').remove();
		},
		success: function(html) {
			$('#reward').html(html);

			$('#tab-reward input[name=\'points\']').val('');
			$('#tab-reward input[name=\'description\']').val('');
		}
	});
}

function addBanIP(ip) {
	var id = ip.replace(/\./g, '-');

	$.ajax({
		url: 'index.php?route=sale/customer/addbanip&token=<?php echo $token; ?>',
		type: 'post',
		dataType: 'json',
		data: 'ip=' + encodeURIComponent(ip),
		beforeSend: function() {
			$('.success, .warning').remove();

			$('.box').before('<div class="attention"><img src="view/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {

		},
		success: function(json) {
			$('.attention').remove();

			if (json['error']) {
				 $('.box').before('<div class="warning" style="display: none;">' + json['error'] + '</div>');

				$('.warning').fadeIn('slow');
			}

			if (json['success']) {
                $('.box').before('<div class="success" style="display: none;">' + json['success'] + '</div>');

				$('.success').fadeIn('slow');

				$('#' + id).replaceWith('<a id="' + id + '" onclick="removeBanIP(\'' + ip + '\');"><?php echo $text_remove_ban_ip; ?></a>');
			}
		}
	});
}

function removeBanIP(ip) {
	var id = ip.replace(/\./g, '-');

	$.ajax({
		url: 'index.php?route=sale/customer/removebanip&token=<?php echo $token; ?>',
		type: 'post',
		dataType: 'json',
		data: 'ip=' + encodeURIComponent(ip),
		beforeSend: function() {
			$('.success, .warning').remove();

			$('.box').before('<div class="attention"><img src="view/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		success: function(json) {
			$('.attention').remove();

			if (json['error']) {
				 $('.box').before('<div class="warning" style="display: none;">' + json['error'] + '</div>');

				$('.warning').fadeIn('slow');
			}

			if (json['success']) {
				 $('.box').before('<div class="success" style="display: none;">' + json['success'] + '</div>');

				$('.success').fadeIn('slow');

				$('#' + id).replaceWith('<a id="' + id + '" onclick="addBanIP(\'' + ip + '\');"><?php echo $text_add_ban_ip; ?></a>');
			}
		}
	});
};
//--></script>
<script type="text/javascript"><!--
$('.htabs a').tabs();
$('.vtabs a').tabs();
//--></script>
<?php echo $footer; ?>