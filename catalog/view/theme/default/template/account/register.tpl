<?php echo $header; ?>
<div class="row" style="margin-top: 40px;">
    <div class="col-md-12" style="padding: 4px;">
        <div class="col-md-12 box-shadow" style="padding: 4px;">
            <?php if ($error_warning) { ?>
            <div class="warning"><?php echo $error_warning; ?></div>
            <?php } ?>
            <?php if ($success) { ?>
            <div class="success"><?php echo $success; ?></div>
            <?php } ?>
            <div id="s-page-content" class="s-row">
                <div class="s-row s-pc-option-bar">

                    <h1><?php echo $heading_title; ?></h1>

                    <p><?php echo $text_account_already; ?></p>

                    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                        <h2><?php echo $text_your_details; ?></h2>

                        <div class="content">
                            <table class="form">
                                <tr>
                                    <td><span class="required">*</span> <?php echo $entry_firstname; ?></td>
                                    <td><input class="form-control" type="text" name="firstname" value="<?php echo $firstname; ?>"/>
                                        <?php if ($error_firstname) { ?>
                                        <span class="error"><?php echo $error_firstname; ?></span>
                                        <?php } ?></td>
                                </tr>
                                <tr>
                                    <td><span class="required">*</span> <?php echo $entry_lastname; ?></td>
                                    <td><input class="form-control" type="text" name="lastname" value="<?php echo $lastname; ?>"/>
                                        <?php if ($error_lastname) { ?>
                                        <span class="error"><?php echo $error_lastname; ?></span>
                                        <?php } ?></td>
                                </tr>
                                <tr>
                                    <td><span class="required">*</span> <?php echo $entry_email; ?></td>
                                    <td><input class="form-control" type="text" name="email" value="<?php echo $email; ?>"/>
                                        <?php if ($error_email) { ?>
                                        <span class="error"><?php echo $error_email; ?></span>
                                        <?php } ?></td>
                                </tr>
                                <tr>
                                    <td><span class="required">*</span> <?php echo $entry_telephone; ?></td>
                                    <td><input class="form-control" type="text" name="telephone" value="<?php echo $telephone; ?>"/>
                                        <?php if ($error_telephone) { ?>
                                        <span class="error"><?php echo $error_telephone; ?></span>
                                        <?php } ?></td>
                                </tr>
                            </table>
                        </div>

                        <h2><?php echo $text_your_address; ?></h2>

                        <div class="content">
                            <table class="form">

                                <input style="visibility: hidden;display:none;" type="text" name="fax" value="" />
                                <input style="visibility: hidden;display:none;" type="text" name="company" value="" />
                                <input style="visibility: hidden;display:none;" type="text" name="company_id" value="" />
                                <input style="visibility: hidden;display:none;" type="text" name="tax_id" value="" />
                                <input style="visibility: hidden;display:none;" type="text" name="address_2" value="" />


                                <tr style="display: <?php echo (count($customer_groups) > 1 ? 'table-row' : 'none'); ?>;">
                                    <td><?php echo $entry_customer_group; ?></td>
                                    <td><?php foreach ($customer_groups as $customer_group) { ?>
                                        <?php if ($customer_group['customer_group_id'] == $customer_group_id) { ?>
                                        <input type="radio" name="customer_group_id" value="<?php echo $customer_group['customer_group_id']; ?>"
                                               id="customer_group_id<?php echo $customer_group['customer_group_id']; ?>" checked="checked"/>
                                        <label for="customer_group_id<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></label>
                                        <br/>
                                        <?php } else { ?>
                                        <input type="radio" name="customer_group_id" value="<?php echo $customer_group['customer_group_id']; ?>"
                                               id="customer_group_id<?php echo $customer_group['customer_group_id']; ?>"/>
                                        <label for="customer_group_id<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?>
                                        </label>
                                        <br/>
                                        <?php } ?>
                                        <?php } ?></td>
                                </tr>
                                <script>
                                    $(document).ready(function () {
                                        $("input:radio['name=customer_group_id']").change(function () {
                                            if ($("input[name='customer_group_id']:checked").val() == '1') {
                                                $('#sub_row').css("display","none");
                                                $('#sub_name').css("display","none");
                                            }
                                            if ($("input[name='customer_group_id']:checked").val() == '2') {
                                                $('#sub_row').css("display","");
                                                $('#sub_name').css("display","");
                                            }
                                        });
                                        if ($("input[name='customer_group_id']:checked").val() == '2') {
                                            $('#sub_row').css("display","");
                                            $('#sub_name').css("display","");
                                        }
                                    });
                                </script>
                                <tr id="sub_row" style="display: none;">
                                    <td></td>
                                    <td>
                                        <input type="radio" name="group_id" value="0" id="group_id0" checked="checked"/>
                                        <label for="group_id0">
عرضه کننده کالا هستم
                                        </label>
                                        <br/>
                                        <input type="radio" name="group_id" value="1" id="group_id1"/>
                                        <label for="group_id1">
عرضه کننده خدمات هستم
                                        </label>
                                        <br/>
                                        <label style="color:red;">
شامل پرداخت هزینه
                                        </label>
                                    </td>

                                </tr>
                                <tr id="sub_name" style="display: none;">
                                    <td>
                                        نام شرکت
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" name="title" value="">
                                    </td>
                                </tr>

                                <tr>
                                    <td><span class="required">*</span> <?php echo $entry_country; ?></td>
                                    <td><select class="form-control" name="country_id">
                                            <option value=""><?php echo $text_select; ?></option>
                                            <?php foreach ($countries as $country) { ?>
                                            <?php if ($country['country_id'] == $country_id) { ?>
                                            <option value="<?php echo $country['country_id']; ?>"
                                                    selected="selected"><?php echo $country['name']; ?></option>
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
                                    <td><input class="form-control" id="city" type="text" name="city" value="<?php echo $city; ?>" onblur="addressset()"/>
                                        <?php if ($error_city) { ?>
                                        <span class="error"><?php echo $error_city; ?></span>
                                        <?php } ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <fieldset class="gllpLatlonPicker">
                                            <span class="required">*</span>
                                            <?php echo $entry_address_1; ?>
                                            <input size="110" id="address" type="text" name="address_1" value=""
                                                   onchange="addressset()"/>
                                            <?php if ($error_address_1) { ?>
                                            <span class="error"><?php echo $error_address_1; ?></span>
                                            <?php } ?>
                                            <br/><br/>
                                            <input id="Search" type="text" class="gllpSearchField" style="visibility: hidden;display:none;">
                                            <input type="text" class="gllpLatitude" value="32" name="lat"
                                                   style="visibility: hidden;display:none;">
                                            <input type="text" class="gllpLongitude" value="54" name="lon"
                                                   style="visibility: hidden;display:none;">
                                            <input type="text" class="gllpZoom" value="5" name="zoom" style="visibility: hidden;display:none;">
                                            <input type="button" class="gllpUpdateButton" value="update map"
                                                   style="visibility: hidden;display:none;">
                                            <input type="text" name="address_2" value="<?php echo $address_2; ?>"
                                                   style="visibility: hidden;display:none;">
                                            <input type="text" name="postcode" value="<?php echo $postcode; ?>"
                                                   style="visibility: hidden;display:none;">

                                            <div class="gllpMap">Google Maps</div>

                                        </fieldset>
                                    </td>
                                </tr>
                                <script>
                                    function addressset() {
                                        var searchString = $("#city").val() + " " + $("#address").val();
                                        document.getElementById("Search").value = searchString;
                                    }
                                </script>
                            </table>
                        </div>
                        <h2><?php echo $text_your_password; ?></h2>

                        <div class="content">
                            <table class="form">
                                <tr>
                                    <td><span class="required">*</span> <?php echo $entry_password; ?></td>
                                    <td><input class="form-control" type="password" name="password" value="<?php echo $password; ?>"/>
                                        <?php if ($error_password) { ?>
                                        <span class="error"><?php echo $error_password; ?></span>
                                        <?php } ?></td>
                                </tr>
                                <tr>
                                    <td><span class="required">*</span> <?php echo $entry_confirm; ?></td>
                                    <td><input class="form-control" type="password" name="confirm" value="<?php echo $confirm; ?>"/>
                                        <?php if ($error_confirm) { ?>
                                        <span class="error"><?php echo $error_confirm; ?></span>
                                        <?php } ?></td>
                                </tr>
                            </table>
                        </div>
                        <h2><?php echo $text_newsletter; ?></h2>

                        <div class="content">
                            <table class="form">
                                <tr>
                                    <td><?php echo $entry_newsletter; ?></td>
                                    <td><?php if ($newsletter) { ?>
                                        <input type="radio" name="newsletter" value="1" checked="checked"/>
                                        <?php echo $text_yes; ?>
                                        <input type="radio" name="newsletter" value="0"/>
                                        <?php echo $text_no; ?>
                                        <?php } else { ?>
                                        <input type="radio" name="newsletter" value="1"/>
                                        <?php echo $text_yes; ?>
                                        <input type="radio" name="newsletter" value="0" checked="checked"/>
                                        <?php echo $text_no; ?>
                                        <?php } ?></td>
                                </tr>
                            </table>
                        </div>
                        <?php if ($text_agree) { ?>
                        <div class="buttons">
                            <div class="right">
                                <?php if ($agree) { ?>
                                <input type="checkbox" name="agree" value="1" checked="checked"/>
                                <?php } else { ?>
                                <input type="checkbox" name="agree" value="1"/>
                                <?php echo $text_agree; ?>
                                <?php } ?>
                            </div>
                            <div class="left">
                                <input type="submit" value="<?php echo $button_continue; ?>" class="button"/>
                            </div>
                        </div>
                        <?php } else { ?>
                        <div class="buttons">
                            <div class="left">
                                <input type="submit" value="<?php echo $button_continue; ?>" class="button"/>
                            </div>
                        </div>
                        <?php } ?>
                    </form>
                    <?php echo $content_bottom; ?></div>
                <script type="text/javascript"><!--
                    $('input[name=\'customer_group_id\']:checked').live('change', function () {
                        var customer_group = [];

                        <?php foreach($customer_groups as $customer_group){ ?>
                            customer_group[ <?php echo $customer_group['customer_group_id'];?>] = [];
                            customer_group[ <?php echo $customer_group['customer_group_id'];?>]['company_id_display'] = '<?php echo $customer_group['company_id_display']; ?>';
                            customer_group[ <?php echo $customer_group['customer_group_id'];?>]['company_id_required'] = '<?php echo $customer_group['company_id_required']; ?>';
                            customer_group[ <?php echo $customer_group['customer_group_id'];?>]['tax_id_display'] = '<?php echo $customer_group['tax_id_display']; ?>';
                            customer_group[ <?php echo $customer_group['customer_group_id'];?>]['tax_id_required'] = '<?php echo $customer_group['tax_id_required']; ?>';
                        <?php } ?>

                        if (customer_group[this.value]) {
                            if (customer_group[this.value]['company_id_display'] == '1') {
                                $('#company-id-display').show();
                            } else {
                                $('#company-id-display').hide();
                            }

                            if (customer_group[this.value]['company_id_required'] == '1') {
                                $('#company-id-required').show();
                            } else {
                                $('#company-id-required').hide();
                            }

                            if (customer_group[this.value]['tax_id_display'] == '1') {
                                $('#tax-id-display').show();
                            } else {
                                $('#tax-id-display').hide();
                            }

                            if (customer_group[this.value]['tax_id_required'] == '1') {
                                $('#tax-id-required').show();
                            } else {
                                $('#tax-id-required').hide();
                            }
                        }
                    });

                    $('input[name=\'customer_group_id\']:checked').trigger('change');
                    //--></script>
                <script type="text/javascript"><!--
                    $('select[name=\'country_id\']').bind('change', function () {
                        $.ajax({
                            url: 'index.php?route=account/register/country&country_id=' + this.value,
                            dataType: 'json',
                            beforeSend: function () {
                                $('select[name=\'country_id\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
                            },
                            complete: function () {
                                $('.wait').remove();
                            },
                            success: function (json) {
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
                            error: function (xhr, ajaxOptions, thrownError) {
                                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            }
                        });
                    });

                    $('select[name=\'country_id\']').trigger('change');
                    //--></script>
                <script type="text/javascript"><!--
                    $(document).ready(function () {
                        $('.colorbox').colorbox({
                            width: 640,
                            height: 480
                        });
                    });
                    //--></script></div>
        </div>

    </div>
</div>

<?php echo $footer; ?>

