<?php echo $header; ?>
<div class="row" style="margin-top: 40px;">
    <div class="col-md-3" style="padding: 4px;">
        <div class="col-md-12 box-shadow" style="padding: 4px;">
            <div class="row">
                <?php echo $column_left; ?>
            </div>
            <div class="row">
                <?php echo $column_right; ?>
            </div>

        </div>
    </div>
    <div class="col-md-9">
        <div class="col-md-12 box-shadow" style="padding: 4px;">
            <div id="s-page-content" class="s-row">
                <div id="content" class="s-pc-c-center">
                    <?php echo $content_top; ?>
                    <div class="breadcrumb s-pc-c-c-bread">
                        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                        <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
                        <?php } ?>
                    </div>
                    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                        <h2><?php echo $text_edit_address; ?></h2>
                        <div class="content">
                            <table class="form">
                                <tr>
                                    <td><span class="required">*</span> <?php echo $entry_firstname; ?></td>
                                    <td><input class="form-control" type="text" name="firstname" value="<?php echo $firstname; ?>" />
                                        <?php if ($error_firstname) { ?>
                                        <span class="error"><?php echo $error_firstname; ?></span>
                                        <?php } ?></td>
                                </tr>
                                <tr>
                                    <td><span class="required">*</span> <?php echo $entry_lastname; ?></td>
                                    <td><input class="form-control" type="text" name="lastname" value="<?php echo $lastname; ?>" />
                                        <?php if ($error_lastname) { ?>
                                        <span class="error"><?php echo $error_lastname; ?></span>
                                        <?php } ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $entry_company; ?></td>
                                    <td><input class="form-control" type="text" name="company" value="<?php echo $company; ?>" /></td>
                                </tr>
                                <?php if ($company_id_display) { ?>
                                <tr>
                                    <td><?php echo $entry_company_id; ?></td>
                                    <td><input class="form-control" type="text" name="company_id" value="<?php echo $company_id; ?>" />
                                        <?php if ($error_company_id) { ?>
                                        <span class="error"><?php echo $error_company_id; ?></span>
                                        <?php } ?></td>
                                </tr>
                                <?php } ?>
                                <?php if ($tax_id_display) { ?>
                                <tr>
                                    <td><?php echo $entry_tax_id; ?></td>
                                    <td><input class="form-control" type="text" name="tax_id" value="<?php echo $tax_id; ?>" />
                                        <?php if ($error_tax_id) { ?>
                                        <span class="error"><?php echo $error_tax_id; ?></span>
                                        <?php } ?></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <td><span class="required">*</span> <?php echo $entry_country; ?></td>
                                    <td><select class="form-control" name="country_id">
                                            <option value=""><?php echo $text_select; ?></option>
                                            <?php foreach ($countries as $country) { ?>
                                            <?php if ($country['country_id'] == $country_id) { ?>
                                            <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                                            <?php } else { ?>
                                            <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                                            <?php } ?>
                                            <?php } ?>
                                        </select>
                                        <?php if ($error_country) { ?>
                                        <span class="error"><?php echo $error_country; ?></span>
                                        <?php } ?></td>
                                </tr>
                                <tr>
                                    <td><span class="required">*</span> <?php echo $entry_zone; ?></td>
                                    <td><select class="form-control" name="zone_id">
                                        </select>
                                        <?php if ($error_zone) { ?>
                                        <span class="error"><?php echo $error_zone; ?></span>
                                        <?php } ?></td>
                                </tr>
                                <tr>
                                    <td><span class="required">*</span> <?php echo $entry_city; ?></td>
                                    <td><input class="form-control" id="city"  type="text" name="city" onblur="addressset()" value="<?php echo $city; ?>" />
                                        <?php if ($error_city) { ?>
                                        <span class="error"><?php echo $error_city; ?></span>
                                        <?php } ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <fieldset class="gllpLatlonPicker">
                                            <span class="required">*</span>
                                            <?php echo $entry_address_1; ?>
                                            <input class="form-control" size="110" id="address" type="text" name="address_1" value="<?php echo $address_1; ?>"  onchange="addressset()" />
                                            <?php if ($error_address_1) { ?>
                                            <span class="error"><?php echo $error_address_1; ?></span>
                                            <?php } ?>
                                            <br/><br/>
                                            <input  id="Search"  type="text" class="gllpSearchField" style="visibility: hidden;display:none;">
                                            <input type="text" class="gllpLatitude" value="<?php echo $lat; ?>"  name="lat" style="visibility: hidden;display:none;">
                                            <input type="text" class="gllpLongitude" value="<?php echo $lon; ?>" name="lon" style="visibility: hidden;display:none;">
                                            <input type="text" class="gllpZoom" value="<?php echo $zoom; ?>" name="zoom" style="visibility: hidden;display:none;">
                                            <input type="button" class="gllpUpdateButton" value="update map" style="visibility: hidden;display:none;">
                                            <input type="text" name="address_2" value="<?php echo $address_2; ?>"  style="visibility: hidden;display:none;"/>
                                            <input type="text" name="postcode" value="<?php echo $postcode; ?>" style="visibility: hidden;display:none;" />
                                            <div class="gllpMap">Google Maps</div>

                                        </fieldset>
                                    </td>
                                </tr>
                                <script>
                                    function addressset() {
                                        var searchString=$("#city").val()+" "+$("#address").val();
                                        document.getElementById("Search").value = searchString;
                                    }
                                </script>


                                <td><?php echo $entry_default; ?></td>
                                <td><?php if ($default) { ?>
                                    <input type="radio" name="default" value="1" checked="checked" />
                                    <?php echo $text_yes; ?>
                                    <input type="radio" name="default" value="0" />
                                    <?php echo $text_no; ?>
                                    <?php } else { ?>
                                    <input type="radio" name="default" value="1" />
                                    <?php echo $text_yes; ?>
                                    <input type="radio" name="default" value="0" checked="checked" />
                                    <?php echo $text_no; ?>
                                    <?php } ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="buttons">
                            <div class="left"><a href="<?php echo $back; ?>" class="button"><?php echo $button_back; ?></a></div>
                            <div class="right">
                                <input type="submit" value="<?php echo $button_continue; ?>" class="button" />
                            </div>
                        </div>
                    </form>
                    <?php echo $content_bottom; ?></div>
                <script type="text/javascript"><!--
                    $('select[name=\'country_id\']').bind('change', function() {
                        $.ajax({
                            url: 'index.php?route=account/address/country&country_id=' + this.value,
                            dataType: 'json',
                            beforeSend: function() {
                                $('select[name=\'country_id\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
                            },
                            complete: function() {
                                $('.wait').remove();
                            },
                            success: function(json) {
                                if (json['postcode_required'] == '1') {
                                    $('#postcode-required').show();
                                } else {
                                    $('#postcode-required').hide();
                                }

                                html = '<option value=""><?php echo $text_select; ?></option>';

                                if (json['zone'] != '') {
                                    for (i = 0; i < json['zone'].length; i++) {
                                        html += '<option value="' + json['zone'][i]['zone_id'] + '"';

                                        if (json['zone'][i]['zone_id'] == '<?php echo $zone_id; ?>') {
                                            html += ' selected="selected"';
                                        }

                                        html += '>' + json['zone'][i]['name'] + '</option>';
                                    }
                                } else {
                                    html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
                                }

                                $('select[name=\'zone_id\']').html(html);
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            }
                        });
                    });

                    $('select[name=\'country_id\']').trigger('change');

                    //-->
                </script>
            </div>

        </div>
    </div>

</div>


<?php echo $footer; ?>