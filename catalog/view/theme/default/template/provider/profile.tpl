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
                        <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
                        <?php } ?>
                    </div>
                    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                        <h2><?php echo $text_profile; ?></h2>
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
                                    <td><span class="required">*</span> <?php echo $entry_nationalcode; ?></td>
                                    <td><input class="form-control" type="text" name="nationalcode" value="<?php echo $nationalcode; ?>" />
                                        <?php if ($error_nationalcode) { ?>
                                        <span class="error"><?php echo $error_nationalcode; ?></span>
                                        <?php } ?></td>
                                </tr>
                                <tr>
                                    <td><span class="required">*</span> <?php echo $entry_birthplace; ?></td>
                                    <td><input class="form-control" type="text" name="birthplace" value="<?php echo $birthplace; ?>" />
                                        <?php if ($error_birthplace) { ?>
                                        <span class="error"><?php echo $error_birthplace; ?></span>
                                        <?php } ?></td>
                                </tr>
                                <tr>
                                    <td><span class="required">*</span> <?php echo $entry_birthday; ?></td>
                                    <td><input class="form-control" type="text" id="birthday" name="birthday" value="<?php echo $birthday; ?>" />
                                        <?php if ($error_birthday) { ?>
                                        <span class="error"><?php echo $error_birthday; ?></span>
                                        <?php } ?></td>
                                </tr>
                                <tr>
                                    <td><span class="required">*</span> <?php echo $entry_fathername; ?></td>
                                    <td><input class="form-control" type="text" name="fathername" value="<?php echo $fathername; ?>" />
                                        <?php if ($error_fathername) { ?>
                                        <span class="error"><?php echo $error_fathername; ?></span>
                                        <?php } ?></td>
                                </tr>
                                <tr>
                                    <td><span class="required">*</span> <?php echo $entry_nationalcard; ?></td>
                                    <td><input class="form-control" type="file" name="nationalcard" accept="image/gif, image/jpeg" id="nationalcard" />
                                        <?php if ($error_nationalcard) { ?>
                                        <span class="error"><?php echo $error_nationalcard; ?></span>
                                        <?php } ?></td>
                                </tr>
                                <tr>
                                    <td><span class="required">*</span> <?php echo $entry_agreement; ?></td>
                                    <td>
                                        <a id="form-1" class="button left">دریافت تعهدنامه عرضه کنندگان</a>
                                        <br />
                                        <input class="form-control" type="file" name="agreement" accept="image/gif, image/jpeg" id="agreement" />
                                        <?php if ($error_agreement) { ?>
                                        <span class="error"><?php echo $error_agreement; ?></span>
                                        <?php } ?>
                                    </td>
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
                <script type="text/javascript" src="catalog/view/javascript/jquery/ui/ui.datepicker.js"></script>
                <script type="text/javascript">
                    <!--

                    $(document).ready(function() {
                        $('#birthday').datepicker({
                                    changeMonth: true,
                                    changeYear: true,
                                    yearRange: '-685:-640',
                                    dateFormat: 'yy-mm-dd'
                                },
                                $.datepicker.regional['fa']
                        );
                        $('#birthday').val("<?php echo $birthday; ?>").datepicker('update');
                    });


                    $('#form-1').click(function(e) {
                        e.preventDefault();
                        var form1 = 'pdfc/files/form-1.php?id=<?php echo $f_id; ?>&f=<?php echo $f_firstname; ?>&l=<?php echo $f_lastname; ?>&e=<?php echo $f_email; ?>';
                        window.location.href = form1;

                    });

                    //-->
                </script>
            </div>
        </div>

    </div>
</div>

<?php echo $footer; ?>
