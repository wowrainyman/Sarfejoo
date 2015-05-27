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
            <?php if ($error_warning) { ?>
            <div class="warning"><?php echo $error_warning; ?></div>
            <?php } ?>
            <?php if ($success) { ?>
            <div class="success"><?php echo $success; ?></div>
            <?php } ?>
            <div id="s-page-content" class="s-row">
                <div id="content" class="s-pc-c-center">
                    <?php echo $content_top; ?>
                    <div class="breadcrumb s-pc-c-c-bread">
                        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                        <?php echo $breadcrumb['separator']; ?><a
                                href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
                        <?php } ?>
                    </div>

                    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                        <?php if(isset($id)) { ?>
                        <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
                        <?php } ?>
                        <h2><?php echo $text_profile; ?></h2>

                        <div class="content">
                            <table class="form">
                                <tr>
                                    <td><span class="required">*</span> <?php echo $entry_subprofilegroup; ?></td>
                                    <td>
                                        <?php if (isset($group_id) && $group_id) { ?>
                                        <input type="radio" name="group_id" value="0" id="group_id0"/>
                                        <label for="group_id0"><?php echo $entry_subprofile_group1; ?></label>
                                        <br/>
                                        <input type="radio" name="group_id" value="1" id="group_id1"  checked="checked"/>
                                        <label for="group_id1"><?php echo $entry_subprofile_group2; ?></label>
                                        <br/>
                                        <?php }else{ ?>
                                        <input type="radio" name="group_id" value="0" id="group_id0" checked="checked"/>
                                        <label for="group_id0"><?php echo $entry_subprofile_group1; ?></label>
                                        <br/>
                                        <input type="radio" name="group_id" value="1" id="group_id1"/>
                                        <label for="group_id1"><?php echo $entry_subprofile_group2; ?></label>
                                        <br/>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="required">*</span> <?php echo $entry_title; ?></td>
                                    <td><input class="form-control"  type="text" name="title" value="<?php echo $title; ?>"/>
                                        <?php if ($error_title) { ?>
                                        <span class="error"><?php echo $error_title; ?></span>
                                        <?php } ?></td>
                                </tr>
                                <tr>
                                    <td><span class="required">*</span> <?php echo $entry_persontype; ?></td>
                                    <td>
                                        <?php if (isset($group_id) && $group_id) { ?>
                                        <input type="radio" name="legalperson_id" value="0" id="person_id0" />
                                        <label for="group_id0?>"><?php echo $entry_naturalperson; ?></label>
                                        <br/>
                                        <input type="radio" name="legalperson_id" value="1" id="person_id1" checked="checked"/>
                                        <label for="group_id1"><?php echo $entry_legalperson; ?></label>
                                        <br/>
                                        <?php }else{ ?>
                                        <input type="radio" name="legalperson_id" value="0" id="person_id0" checked="checked"/>
                                        <label for="group_id0?>"><?php echo $entry_naturalperson; ?></label>
                                        <br/>
                                        <input type="radio" name="legalperson_id" value="1" id="person_id1"/>
                                        <label for="group_id1"><?php echo $entry_legalperson; ?></label>
                                        <br/>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="required">*</span> <?php echo $entry_province; ?></td>
                                    <td><select class="form-control"  name="province_id">
                                            <option value=""><?php echo $text_select; ?></option>
                                            <?php foreach ($provinces as $province) { ?>
                                            <?php if ($province['zone_id'] == $province_id) { ?>
                                            <option value="<?php echo $province['zone_id']; ?>"
                                                    selected="selected"><?php echo $province['name']; ?></option>
                                            <?php } else { ?>
                                            <option value="<?php echo $province['zone_id']; ?>"><?php echo $province['name']; ?></option>
                                            <?php } ?>
                                            <?php } ?>
                                        </select>
                                        <?php if ($error_country) { ?>
                                        <span class="error"><?php echo $error_country; ?></span>
                                        <?php } ?></td>
                                </tr>
                                <tr>
                                    <td><span class="required">*</span> <?php echo $entry_city; ?></td>
                                    <td><input class="form-control"  type="text" name="city" id="city" value="<?php echo $city; ?>" onchange="addressset()"/>
                                        <?php if ($error_city) { ?>
                                        <span class="error"><?php echo $error_city; ?></span>
                                        <?php } ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <fieldset class="gllpLatlonPicker">
                                            <span class="required">*</span>
                                            <?php echo $entry_address; ?>
                                            <input class="form-control"  size="110" id="address" type="text" name="address" value="<?php echo $address; ?>"
                                                   onchange="addressset()" />
                                            <?php if ($error_address) { ?>
                                            <span class="error"><?php echo $error_address; ?></span>
                                            <?php } ?>
                                            <br/><br/>
                                            <input class="form-control"  id="Search" type="text" class="gllpSearchField"
                                                   style="visibility: hidden;display:none;">
                                            <input class="form-control"  type="text" class="gllpLatitude" value="<?php echo $lat; ?>" name="lat"
                                                   style="visibility: hidden;display:none;">
                                            <input class="form-control"  type="text" class="gllpLongitude" value="<?php echo $lon; ?>" name="lon"
                                                   style="visibility: hidden;display:none;">
                                            <input class="form-control"  type="text" class="gllpZoom" value="<?php echo $zoom; ?>" name="zoom"
                                                   style="visibility: hidden;display:none;">
                                            <input class="form-control"  type="button" class="gllpUpdateButton" value="update map"
                                                   style="visibility: hidden;display:none;">
                                            <div class="gllpMap">Google Maps</div>
                                        </fieldset>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="required">*</span> <?php echo $entry_tel; ?></td>
                                    <td><input class="form-control"  type="text" name="tel" value="<?php echo $tel; ?>"/>
                                        <?php if ($error_tel) { ?>
                                        <span class="error"><?php echo $error_tel; ?></span>
                                        <?php } ?></td>
                                </tr>
                                <tr>
                                    <td><span class="required">*</span> <?php echo $entry_mobile; ?></td>
                                    <td><input class="form-control"  type="text" name="mobile" value="<?php echo $mobile; ?>"/>
                                        <?php if ($error_mobile) { ?>
                                        <span class="error"><?php echo $error_mobile; ?></span>
                                        <?php } ?></td>
                                </tr>
                                <tr>
                                    <td><span class="required">*</span> <?php echo $entry_email; ?></td>
                                    <td><input class="form-control"  type="text" name="email" value="<?php echo $email; ?>"/>
                                        <?php if ($error_email) { ?>
                                        <span class="error"><?php echo $error_email; ?></span>
                                        <?php } ?></td>
                                </tr>
                                <tr>
                                    <td><span class="required">*</span> <?php echo $entry_website; ?></td>
                                    <td><input class="form-control"  type="text" name="website" value="<?php echo $website; ?>"/>
                                        <?php if ($error_website) { ?>
                                        <span class="error"><?php echo $error_website; ?></span>
                                        <?php } ?></td>
                                </tr>
                                <tr>
                                    <td><span class="required">*</span> <?php echo $entry_picture; ?></td>
                                    <td><input class="form-control"  type="file" name="picture" accept="image/gif, image/jpeg" id="picture"/>
                                </tr>
                                <tr>
                                    <td><span class="required">*</span> <?php echo $entry_logo; ?></td>
                                    <td><input class="form-control"  type="file" name="logo" accept="image/gif, image/jpeg" id="logo"/>
                                </tr>
                            </table>
                        </div>
                        <div class="buttons">
                            <div class="left"><a href="<?php echo $back; ?>" class="button"><?php echo $button_back; ?></a></div>
                            <div class="right">
                                <input type="submit" value="<?php echo $button_continue; ?>" class="button"/>
                            </div>
                        </div>
                    </form>
                    <?php echo $content_bottom; ?>
                </div>
            </div>
        </div>

    </div>
</div>

<?php echo $footer; ?>
<script>
    function addressset() {
        var searchString = $("#city").val() + " " + $("#address").val();
        document.getElementById("Search").value = searchString;
    }
</script>