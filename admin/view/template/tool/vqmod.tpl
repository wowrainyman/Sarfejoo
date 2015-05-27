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
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/setting.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <?php echo $text_sort;?> <select id="xml-sorter">
          <option value="file.asc"<?php if (!$xml_sorter || $xml_sorter == 'file.asc') echo ' selected="selected"';?>><?php echo $text_name_asc;?></option>
          <option value="file.desc"<?php if ($xml_sorter == 'file.desc') echo ' selected="selected"';?>><?php echo $text_name_desc;?></option>
          <option value="type.desc"<?php if ($xml_sorter == 'type.desc') echo ' selected="selected"';?>><?php echo $text_type_desc;?></option>
          <option value="type.asc"<?php if ($xml_sorter == 'type.asc') echo ' selected="selected"';?>><?php echo $text_type_asc;?></option>
        </select> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
        <?php if ($install_all) { ?><a class="button" href="<?php echo $install_all;?>"><?php echo $button_install_all; ?></a><?php } ?>
        <?php if ($uninstall_all) { ?><a class="button" href="<?php echo $uninstall_all;?>"><?php echo $button_uninstall_all; ?></a><?php } ?>
        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a class="button vqmod-config"><?php echo $button_config; ?></a> <a class="button vqmod-log"><?php echo $button_log; ?></a> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a class="button vqmod-upload"><?php echo $button_upload; ?></a></div>
    </div>
    <div class="content">
      <table id="extension-list" class="list">
        <thead>
          <tr>
            <td class="left">&nbsp;</td>
            <td class="left"><?php echo $column_name; ?></td>
            <td class="left"><?php echo $column_version; ?></td>
            <td class="left"><?php echo $column_vqmver; ?></td>
            <td class="left"><?php echo $column_author; ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
        <?php if ($vqmods) { ?>
          <?php foreach ($vqmods as $vqmod) { ?>
          <tr class="xml-type-<?php echo $vqmod['type'];?>">
			<td class="left"><?php echo $vqmod['install']; ?></td>
			<td class="left">
				<b><?php echo $vqmod['title'];?></b><br/>
				<small style="color:#666;"><?php echo $vqmod['file']; ?> &nbsp; (<?php echo $vqmod['size']; ?>)</small>
			</td>
            <td class="left"><?php echo $vqmod['version']; ?><br/><small style="color:#666;">(<?php echo $vqmod['date'];?>)</small></td>
            <td class="left"><?php echo $vqmod['vqmver']; ?></td>
            <td class="left"><?php echo $vqmod['author']; ?></td>
            <td class="right"><?php foreach ($vqmod['action'] as $action) { ?>
              &nbsp;<a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a>
              <?php } ?></td>
          </tr>
          <?php } ?>
        <?php } else { ?>
          <tr>
            <td class="center" colspan="6"><?php echo $text_no_results; ?></td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
      <div id="xml-filter" style="display:inline-block;float:left;">
        <input type="checkbox" value="enabled" id="xml-enabled" name="xml_filter[]"<?php if (!$xml_filter || strpos($xml_filter, 'e') !== false) echo ' checked="checked"';?>><label for="xml-enabled"><img title="Installed" alt="Installed" src="view/image/success.png" /></label>
        <input type="checkbox" value="disabled" id="xml-disabled" name="xml_filter[]"<?php if (strpos($xml_filter, 'd') !== false) echo ' checked="checked"';?>><label for="xml-disabled"><img title="Uninstalled" alt="Uninstalled" src="view/image/attention.png" /></label>
        <input type="checkbox" value="backup" id="xml-backups" name="xml_filter[]"<?php if (strpos($xml_filter, 'b') !== false) echo ' checked="checked"';?>><label for="xml-backups"><img title="Backup File" alt="Backup File" src="view/image/product.png" style="width:16px;height:16px;" /></label>
      </div>
      <a href="<?php echo $vqmod_new_file;?>" style="float:right;"><?php echo $text_xml_new;?></a>
    </div>
  </div>
</div>
<div id="vqmod-upload" style="display:none;">
  <form action="<?php echo $vqmod_page; ?>" method="post" enctype="multipart/form-data" id="vqmod-uploader">
    <table class="list">
      <tbody>
        <tr><td class="left" colspan="2"><?php echo $text_vqmod_uploads; ?></td></tr>
        <tr>
          <td class="left"><?php echo $entry_select_file; ?></td>
          <td class="left"><input id="vqmod-xml" name="vqmod_xml" type="file" /></td>
        </tr>
      </tbody>
    </table>
  </form>
</div>
<div id="vqmod-log" style="display:none;">
	<textarea id="log" readonly="readonly"></textarea>
	<select id="select-log">
		<option value="log">OpenCart</option>
		<?php foreach ($log_files as $log_file => $log_name) { ?><option value="<?php echo $log_file;?>"><?php echo $log_name;?></option><?php } ?>
	</select>
	</div>
	<textarea id="loadlog" style="display:none;"><?php echo $text_log_load;?></textarea>
</div>
<div id="vqmod-config" style="display:none;"><?php echo $vqconfig;?></div>
<div id="vqdialog" style="display:none;"></div>
<div id="vqtooltip" style="display:none;position:absolute;"><?php echo $changelog;?></div>
<div id="vqloading" style="position:fixed;width:100%;text-align:center;top:180px;display:none;"><img alt="Loading..." src="<?php echo $loading_image;?>" /></div>
<div id="vqgenerate" style="display:none;position:absolute;"><?php echo $text_generate_mods;?></div>
<?php if (isset($vqmod_contribute)) { ?>
<div id="vqcontribute" style="display:none;"><?php echo $text_contribute;?><br/><br/><table class="form">
	<tr><td><?php echo $entry_email;?></td><td><input type="text" id="contribute-email" name="email_address" value="<?php echo $this->config->get('config_email');?>" style="width:380px;" /></td></tr>
	<tr><td><?php echo $entry_contribute;?></td><td><input type="text" id="contribute-lang" name="subject" value="" style="width:380px;" /></td></tr>
	<tr><td colspan="2"><textarea id="contribute" name="message" style="width:700px;"><?php echo $contribute_file;?></textarea></td></tr></table>
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank" id="donate" style="display:inline;"><input type="hidden" name="cmd" value="_donations" /><input type="hidden" name="business" value="paypal@avanosch.nl" /><input type="hidden" name="lc" value="US" /><input type="hidden" name="item_name" value="vQModerator Appreciation Donation" /><input type="hidden" name="currency_code" value="USD" /><input type="hidden" name="bn" value="PP-DonationsBF:btn_donate_LG.gif:NonHosted" /><input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" style="border:0; position:relative; top:7px;" name="submit" alt="PayPal - The safer, easier way to pay online!" /><img alt="" border="0" src="https://www.paypalobjects.com/nl_NL/i/scr/pixel.gif" width="1" height="1" /></form><div style="float:right"><button class="vqbutton contribute-this"><?php echo $button_contribute;?>!</button> &nbsp; <button class="vqbutton" onclick="$('#vqcontribute').dialog('close');"><?php echo $button_cancel;?></button></div>
</div>
<?php } ?>
<script type="text/javascript">
<?php if ($changelog) { ?>
$('.vqtooltip').mouseenter(function() {
	$('#vqtooltip').fadeIn('slow');
	$(document).mousemove( function(e) {
		$('#vqtooltip').css({'top': e.pageY - 40, 'left': e.pageX + 20});
	});
}).mouseleave(function() {
	$('#vqtooltip').fadeOut('slow');
	$(document).unbind("mousemove");
}).click(function() {
	$('#vqtooltip').fadeOut('slow');
	$(document).unbind("mousemove");
});
<?php } ?>
<?php if (isset($takeover)) { ?>
$('#takeover').live('click', function() {
	window.location.href = '<?php echo $takeover; ?>';
});
<?php } ?>
/* Following line of javascript is Sieve v0.3.0 (http://rmm5t.github.com/jquery-sieve/) */
(function(){var e;e=jQuery,e.fn.sieve=function(t){var n;return n=function(e){var t,n,r,o;for(o=[],n=0,r=e.length;r>n;n++)t=e[n],t&&o.push(t);return o},this.each(function(){var r,o,i;return r=e(this),i=e.extend({searchInput:null,searchTemplate:"<div><label>Search: <input type='text'></label></div>",itemSelector:"tbody tr",textSelector:null,toggle:function(e,t){return e.toggle(t)},complete:function(){}},t),i.searchInput||(o=e(i.searchTemplate),i.searchInput=o.find("input"),r.before(o)),i.searchInput.on("keyup.sieve change.sieve",function(){var t,o;return o=n(e(this).val().toLowerCase().split(/\s+/)),t=r.find(i.itemSelector),t.each(function(){var t,n,r,c,l,a,u;for(n=e(this),i.textSelector?(t=n.find(i.textSelector),l=t.text().toLowerCase()):l=n.text().toLowerCase(),r=!0,a=0,u=o.length;u>a;a++)c=o[a],r&&(r=l.indexOf(c)>=0);return i.toggle(n,r)}),i.complete()})})}}).call(this);
$(document).ready(function() {
	<?php if (isset($vqmod_contribute)) { ?>
	$('#update-buttons').append('<br/><br/><button class="vqbutton contribute" style="float:right;"><?php echo $button_contribute;?></button>');
	<?php } ?>
// BOF - oputz - TWO LINES - Added Extension Filter
	var searchInput = $('<input />', { 'type': 'text', 'placeholder': '<?php echo $text_extension_filter;?>' }).css('margin-right', '25px').prependTo('.buttons');
	$('#extension-list').sieve({ searchInput: searchInput, itemSelector: 'tr[class^="xml-type-"]' });
	$('.vqbutton').button();
<?php if (isset($vqmod_contribute)) { ?>
	// BOF - Contribute stuff
	$('#contribute').data('orig', $('#contribute').val());
	var contribute = CodeMirror.fromTextArea(document.getElementById('contribute'), {
		mode: 'text/x-php',
		matchBrackets: true,
		indentUnit: 2,
		indentWithTabs: true,
		lineWrapping: false,
		enterMode: "keep"
	});
	$('.contribute').click(function() {
		$('#vqcontribute').dialog({
			title: '<?php echo $button_contribute;?>',
			autoOpen: true,
			width: 800,
			height: 600,
			open: function() {
				contribute.refresh();
				var newheight = ($('#vqcontribute').innerHeight() - 330), newwidth = ($('#vqcontribute').innerWidth() - 50), mirror = $('#vqcontribute').find('.CodeMirror-scroll');
				mirror.css({'height': newheight, 'width': newwidth});
			},
			resizeStop: function(event, ui) {
				var newheight = (ui.size.height - ui.originalSize.height), newwidth = (ui.size.width - ui.originalSize.width), mirror = $('#vqcontribute').find('.CodeMirror-scroll');
				newheight += mirror.height();
				newwidth += mirror.width();
				mirror.animate({'height': newheight, 'width': newwidth}, 300);
			}
		});
	});
	$('.contribute-this').click(function() {
		contribute.save();
		if ($('#contribute').val() == $('#contribute').data('orig')) {
			$('#vqcontribute').find('.warning').fadeOut(300, function() { $(this).remove(); });
			$('#vqcontribute').find('table.form').before('<div class="warning" style="display:none;"><?php echo $this->language->get('text_error_nochange');?></div>');
			$('#vqcontribute').find('.warning').fadeIn(300);
		} else {
			$(this).button('disable').after('<img src="view/image/loading.gif" class="loading" style="padding-left: 5px;" />');
			$.ajax({
				url: '<?php echo $vqmod_contribute;?>',
				data: $('#contribute, #contribute-email, #contribute-lang'),
				dataType: 'json',
				type: 'POST',
				success: function(data) {
					$('.loading').fadeOut(300, function() { $(this).remove(); });
					$('#vqcontribute').find('.warning, .success').fadeOut(300, function() { $(this).remove(); });
					$('#vqcontribute').find('table.form').before('<div class="success" style="display:none;"></div><div class="warning" style="display:none;"></div>');
					if (data['error']) {
						$('#vqcontribute').find('.warning').append(data['error']).fadeIn(300);
						$('.contribute-this').button('enable');
					}
					if (data['success']) $('#vqcontribute').find('.success').append(data['success']).fadeIn(300);
				}
			});
		}
	});
	// EOF - Contribute stuff
<?php } ?>
	$('#xml-filter').buttonset();
	$('input[name="xml_filter[]"]').change(function() {
		var these = $(this).val();
		if (!$(this).is(':checked')) $('.xml-type-' + these).hide();
		else $('.xml-type-' + these).fadeIn();
		$.ajax({
			url: '<?php echo $vqmod_setfilter;?>',
			data: $('input[name="xml_filter[]"]:checked'),
			type: 'POST'
		});
	});
	$('input[name="xml_filter[]"]').change();
	$('#xml-sorter').change(function() {
		var args = $(this).val().split('.');
		window.location.href = '<?php echo $vqmod_page; ?>&sort=' + args[0] + '&order=' + args[1];
	});
	// Press shift to generate vQModifications
	$(document).keydown(function(e) {
		$(this).disableSelection();
		if (e.shiftKey) {
			var div = $('#vqgenerate');
			div.fadeIn();
			$(document).mousemove(function(ev) {
				div.css({
				   left:  ev.pageX -28,
				   top:   ev.pageY -25
				});
			});
		}
	}).keyup(function() {
		$(this).enableSelection();
		$('#vqgenerate').fadeOut(function(){
			$(document).unbind("mousemove");
		});
	});
	$('#vqgenerate').click(function() {
		$(document).unbind("keydown");
		$('#vqgenerate').hide();
		$('#vqloading').fadeIn();
		$.ajax({
			url: '<?php echo $vqmod_generate;?>',
			success: function() {
				$('.loading').remove();
			},
			complete: function() {
				$('#vqloading').fadeOut('slow');
			}
		});
	});

	$('.uninstall').click(function() {
		var url = $(this).prop('href'),
			delfiles = $(this).data('files').split('|'),
			sep = ($(this).hasClass('delete')) ? '|' : '&files=',
			files = '',
			href = '';
		for (var f in delfiles) if (delfiles[f]) files += '<input type="checkbox" class="delfile" value="' + delfiles[f] + '" checked="checked" /> ' + delfiles[f] + '<br/>';
		href = url + (files ? sep + $(this).data('files') : '');
		files = '<?php echo $text_delete_files;?><br/>' + files;
		$('#vqdialog').html(files);
		$('.delfile').click(function() {
			delfiles = '';
			$('.delfile:checked').each(function() {
				delfiles += $(this).val() + '|';
			});
			href = url + (delfiles ? sep + delfiles : '');
		});

		$('#vqdialog').dialog({
			title: '<?php echo $text_delete_header;?>',
			autoOpen: true,
			width: 'auto',
			height: 'auto',
			buttons: {
				'<?php echo $button_continue;?>': function() {
					window.location.href = href;
				},
				'<?php echo $button_cancel;?>': function() {
					$('#vqdialog').html('');
					$(this).dialog('close');
				}
			}
		});
		return false;
	});

	$('.vqmod-upload').click(function() {
		$('.warning, .success').fadeOut(300, function() { $('.warning, .success').remove(); });
		$('#vqmod-upload').dialog({
			title: '<?php echo $text_vqmod_upload;?>',
			autoOpen: true,
			width: 'auto',
			height: 'auto',
			buttons: {
				'<?php echo $button_upload;?>': function() {
					if ($('#vqmod-xml').val() == '') {
						$('#vqmod-xml').after('<div class="warning"><?php echo $error_no_file;?></div>');
					} else {
						$('#vqmod-uploader').submit();
					}
				},
				'<?php echo $button_cancel;?>': function() {
					$(this).dialog('close');
				}
			}
		});
	});
	$('#vqmod-xml').change(function() {
		var file = $(this).val();
		if (file == '') {
			$('#vqmod-xml').after('<div class="warning"><?php echo $error_no_file;?></div>');
		} else if (file.substr(file.length -4) != '.xml' && file.substr(file.length -5) != '.xml_') {
			$('#vqmod-xml').after('<div class="warning"><?php echo $error_no_xml;?></div>');
		}
	});
	function install(url) {
		if (!url) {
			$('.warning').append('<br/>').fadeIn(400);
			return false;
		}
		$.ajax({
			url : url,
			dataType: 'json',
			success: function(data) {
				if (data['error']) {
					$('.warning').append(data['error'] + '<br/>').fadeIn(400);
					if ($('#redirect-me').length >= 1) {
						install($('#redirect-me').prop('href'));
						$('#redirect-me').remove();
					} else {
						$('#installoader').fadeOut(300);
					}
				}
				if (data['success']) {
					$('.success').fadeIn(300);
					$('#installoader').before(data['success'] + '<br/>');
					if ($('.success').find('#redirect-me').length >= 1) {
						var inline = $('#redirect-me').data('inline'), seconds = $('#redirect-me').data('time'), href = $('#redirect-me').prop('href'), text = $('#redirect-me').html();
						if (typeof (inline) !== 'undefined') {
							install(href);
							$('#redirect-me').remove();
						} else {
							if (url.indexOf('install=go') === -1) $('#installoader').fadeOut(300);
							if (!seconds || typeof(seconds) === 'undefined') seconds = 5;
							var interval = setInterval(function () {
								if (seconds <= 0) {
									if (href) window.location.href = href;
									clearInterval(interval);
									$('#redirect-me').html(text);
								}
								$('#redirect-me').html(text + ' (' + Math.round(seconds) + ')');
								seconds--;
							}, 1000);
						}
					} else {
						$('#installoader').fadeOut(300);
					}
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				$('.warning').append(textStatus + '<br/>' + errorThrown + '<br/>').fadeIn(400);
				$('#installoader').fadeOut(300);
			}
		});
	}
	if ($('#vqmod-install').length > 0) {
		$('.success').append('<div id="installoader"><img src="view/image/loading.gif" class="loading" style="padding-left: 5px;" /><img src="view/image/loading.gif" class="loading" style="padding-left: 5px;" /><img src="view/image/loading.gif" class="loading" style="padding-left: 5px;" /><img src="view/image/loading.gif" class="loading" style="padding-left: 5px;" /><img src="view/image/loading.gif" class="loading" style="padding-left: 5px;" /></div>');
		install($('#vqmod-install').prop('href'));
	}
	$('.vqmod-install').click(function() {
		url = $(this).prop('href');
		if (url && url !== 'undefined' && url !== '#' && url !== '') {
			if ($('.success, .warning').length === 0) {
				$('.breadcrumb').after('<div class="success" style="display:none;"><div id="installoader"><img src="view/image/loading.gif" class="loading" style="padding-left: 5px;" /><img src="view/image/loading.gif" class="loading" style="padding-left: 5px;" /><img src="view/image/loading.gif" class="loading" style="padding-left: 5px;" /><img src="view/image/loading.gif" class="loading" style="padding-left: 5px;" /><img src="view/image/loading.gif" class="loading" style="padding-left: 5px;" /></div></div><div class="warning" style="display:none;"></div>');
				$('.success').fadeIn(300);
				install(url);
			} else {
				$('.success, .warning').fadeOut(300, function() {
					$('.success, .warning').remove();
					$('.breadcrumb').after('<div class="success" style="display:none;"><div id="installoader"><img src="view/image/loading.gif" class="loading" style="padding-left: 5px;" /><img src="view/image/loading.gif" class="loading" style="padding-left: 5px;" /><img src="view/image/loading.gif" class="loading" style="padding-left: 5px;" /><img src="view/image/loading.gif" class="loading" style="padding-left: 5px;" /><img src="view/image/loading.gif" class="loading" style="padding-left: 5px;" /></div></div><div class="warning" style="display:none;"></div>');
					$('.success').fadeIn(300);
					install(url);
				});
			}
		}
	});

	var configCodeMirror = CodeMirror.fromTextArea(document.getElementById('manual_css'), {
		height: "220px",
		mode: 'css',
		matchBrackets: true,
		indentUnit: 2,
		indentWithTabs: true,
		lineWrapping: true,
		enterMode: "keep"
	});
	$('.vqmod-config').click(function() {
		var highlight = ($(this).hasClass('vqm-update')) ? 'vqm' : ($(this).hasClass('vqmr-update') ? 'vqmr' : false);
		$('#vqmod-config').dialog({
			title: '<?php echo $text_vqmod_config;?>',
			autoOpen: true,
			width: '750',
			height: '575',
			buttons: [{
				id: 'button-set-vqmod',
				text: '<?php echo $button_set_vqmod;?>',
				click: function() {
					var config = $('#vqmod-config').parent();
					config.find('table:visible').hide();
					$('#set-vqmod, #update-buttons').show();
					config.find('.ui-button').button('enable').removeClass('ui-state-focus ui-state-hover');
					$('#button-set-vqmod').button('disable');
				}
			},{
				id: 'button-set-editor',
				text: '<?php echo $button_set_editor;?>',
				click: function() {
					var config = $('#vqmod-config').parent();
					config.find('table:visible, #update-buttons').hide();
					$('#set-editor').show();
					config.find('.ui-button').button('enable').removeClass('ui-state-focus ui-state-hover');
					$('#button-set-editor').button('disable');
				}
			},{
				id: 'button-set-manual',
				text: '<?php echo $button_set_manual;?>',
				click: function() {
					var config = $('#vqmod-config').parent();
					config.find('table:visible, #update-buttons').hide();
					$('#set-manual').show();
					configCodeMirror.refresh();
					config.find('.ui-button').button('enable').removeClass('ui-state-focus ui-state-hover');
					$('#button-set-manual').button('disable');
				}
			},{
				text: '<?php echo $button_save;?>',
				click: function() {
					configCodeMirror.save();
					$.ajax({
						url : '<?php echo $vqmod_config;?>',
						type: 'POST',
						data: $('#vqmod-config').find('input:not("[type=checkbox]"), input:checked, textarea'),
						dataType: 'json',
						success: function(data) {
							var div = $('<div/>').hide();
							if (data.success) {
								div.addClass('success').html(data.success);
							} else {
								div.addClass('warning').html(data.warning);
							}
							$('.breadcrumb').after(div);
							div.fadeIn(400);
							$('#vqmod-config').dialog('close');
						}
					});
				}
			},{
				text: '<?php echo $button_cancel;?>',
				click: function() {
					$(':input', '#vqmod-config').each(function() {
						var orig = $(this).data('orig');
						if ($(this).is(':checkbox')) {
							var checked = $(this).is(':checked');
							if (checked != orig) $(this).click();
						} else {
							$(this).val(orig);
							$(this).keyup();
						}
					});
					if (!$('input[name="generate_html"]').is(':checked')) $('[name="manual_css"]').parent().fadeOut();
					$(this).dialog('close');
				}
			}],
			open: function() {
				configCodeMirror.refresh();
				$('#button-set-vqmod').button('disable');
				if (highlight == 'vqm') $('.update-vqmod').addClass('ui-state-highlight');
				else if (highlight == 'vqmr') $('.vqmoderator').addClass('ui-state-highlight');
			}
		});
	});
	var t = {}, timeout = 0;
	$('.vqdir').keyup(function() {
		var vqd = $(this);
		var value = $.trim(vqd.val());
		if (t) clearTimeout(t);
		var checkdir = function() {
			$.ajax({
				url : '<?php echo $vqmod_check_dir;?>' + value,
				dataType: 'json',
				success: function(exists) {
					var color = (exists == 'exists') ? '#ccffc4' : '#ffbebe';
					vqd.animate({'background-color': color}, 500);
				}
			});
		};
		if (timeout > 0) t = setTimeout(checkdir, timeout);
		else checkdir();
	}).focus(function() {
		var vqd = $(this);
		var value = $.trim(vqd.val());
		if (value.indexOf('../vqmod/') !== -1) value = value.replace('../vqmod/', '');
		if ($(this).prop('name') !== 'vqm_test') value = value.split('/').join('') + '/';

		vqd.val(value);
		$(this).keyup();
	}).blur(function() { $(this).focus(); });
	$('.vqdir').keyup();
	timeout = 1200;

	$('.vqmod-log').click(function() {
		$('#vqmod-log').dialog({
			title: '<?php echo $text_vqmod_log;?>',
			autoOpen: true,
			width: 'auto',
			height: 'auto',
			buttons: [{
				text: '<?php echo $button_log_download;?>',
				id: 'log-download',
				click: function(e) {
					e.preventDefault();
					window.location.href = '<?php echo $vqmod_log_download;?>' + $('#select-log').val();
				}
			}, {
				text: '<?php echo $button_log_delete;?>',
				click: function(e) {
					loadLog('del');
				}
			}, {
				text: '<?php echo $button_log_clear;?>',
				click: function(e) {
					loadLog('clear');
				}
			}],
			open: function() {
				$(this).parent().find('.ui-dialog-buttonpane').prepend($('#select-log'));
				$('#log').html($('#loadlog').html());
				setTimeout("loadLog();", 1500);
			},
			beforeClose: function() {
				$('#select-log').appendTo('#vqmod-log');
			}
		});
	});
	$('#select-log').change(function() {
		loadLog();
	});
});
function loadLog(action) {
	action = action ? action : 'get';
	var selected = $('#select-log').val();
	$.ajax({
		url : '<?php echo $vqmod_log;?>' + selected + '&action=' + action,
		dataType: 'json',
		success: function(data) {
			if (action == 'del') {
				$('#select-log').find('option[value="' + selected + '"]').remove();
			}
			$('#log').html(data);
		}
	});
	return false;
}
</script>
<?php echo $footer; ?>