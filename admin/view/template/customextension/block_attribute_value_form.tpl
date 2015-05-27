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
      <h1><img src="view/image/product.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-general">
          <?php foreach ($languages as $language) { ?>
          <div id="language<?php echo $language['language_id']; ?>">
            <table class="form">
              <tr>
                <td><span class="required">*</span> <?php echo $entry_name; ?></td>
                <td><input type="text" name="name" value="<?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['name'] : ''; ?>" />
                    <input type="hidden" name="block_attribute_id" value="0" /></td>
              </tr>
              <tr>
                <td><?php echo $text_value; ?></td>
                <td><input type="text" name="value[0]" id="" value=""></td>
              </tr>
                <tr>
                    <td></td>
                    <td><input type="text" name="value[1]" id="" value=""></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="text" name="value[2]" id="" value=""></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="text" name="value[3]" id="" value=""></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="text" name="value[4]" id="" value=""></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="text" name="value[5]" id="" value=""></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="text" name="value[6]" id="" value=""></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="text" name="value[7]" id="" value=""></td>
                </tr>
            </table>
          </div>
          <?php } ?>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script>
<script type="text/javascript"><!--
$.widget('custom.catcomplete', $.ui.autocomplete, {
	_renderMenu: function(ul, items) {
		var self = this, currentCategory = '';
		$.each(items, function(index, item) {
			if (item.category != currentCategory) {
				ul.append('<li class="ui-autocomplete-category">' + item.category + '</li>');
				currentCategory = item.category;
			}
			self._renderItem(ul, item);
		});
	}
});
    $('input[name=\'name\']').autocomplete({
        delay: 500,
        source: function(request, response) {
            $.ajax({
                url: 'index.php?route=customextension/block_attribute_value/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
                dataType: 'json',
                success: function(json) {
                    response($.map(json, function(item) {
                        return {
                            label: item.name,
                            value: item.id
                        }
                    }));
                }
            });
        },
        select: function(event, ui) {
            $('input[name=\'name\']').attr('value', ui.item.label);
            $('input[name=\'block_attribute_id\']').attr('value', ui.item.value);

            return false;
        },
        focus: function(event, ui) {
            return false;
        }
    });

    $('#product-related div img').live('click', function() {
        $(this).parent().remove();

        $('#product-related div:odd').attr('class', 'odd');
        $('#product-related div:even').attr('class', 'even');
    });

//--></script>
<script type="text/javascript"><!--
function attributeautocomplete(attribute_row) {
	$('input[name=\'product_attribute[' + attribute_row + '][name]\']').catcomplete({
		delay: 500,
		source: function(request, response) {
			$.ajax({
				url: 'index.php?route=provider/attribute/autocomplete&filter_name=' +  encodeURIComponent(request.term),
				dataType: 'json',
				success: function(json) {
					response($.map(json, function(item) {
						return {
							category: item.attribute_group,
							label: item.name,
							value: item.attribute_id
						}
					}));
				}
			});
		},
		select: function(event, ui) {
			$('input[name=\'product_attribute[' + attribute_row + '][name]\']').attr('value', ui.item.label);
			$('input[name=\'product_attribute[' + attribute_row + '][attribute_id]\']').attr('value', ui.item.value);

			return false;
		},
		focus: function(event, ui) {
      		return false;
   		}
	});
}

$('#attribute tbody').each(function(index, element) {
	attributeautocomplete(index);
});
//--></script>

<script type="text/javascript"><!--
//--></script>
<script type="text/javascript"><!--

//--></script>
<script type="text/javascript"><!--

//--></script>
<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript"><!--
$('.date').datepicker({dateFormat: 'yy-mm-dd'});
$('.datetime').datetimepicker({
	dateFormat: 'yy-mm-dd',
	timeFormat: 'h:m'
});
$('.time').timepicker({timeFormat: 'h:m'});
//--></script>
<script type="text/javascript"><!--
$('#tabs a').tabs();
$('#languages a').tabs();
$('#vtab-option a').tabs();

//--></script>


<?php echo $footer; ?>