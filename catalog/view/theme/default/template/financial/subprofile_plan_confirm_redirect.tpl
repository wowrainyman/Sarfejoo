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
                    <div>
                        <span>
شما پس از چند لحظه بطور خودکار به درگاه بانک متصل میشوید.
                        </span>
                        <br/>
                        <span>
                            شماره پیگیری
                        </span>
                        <br/>
                        <span>
<?php echo $uniqueId;?>
                        </span>
                    </div>
                    <form name="redirectpost" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="token" value="<?php echo $token;?>" />
                        <input type="hidden" name="language" value="<?php echo $language;?>" />
                    </form>
                    <?php echo $content_bottom; ?>
                </div>
            </div>
        </div>

    </div>
</div>
<script type="text/javascript">
    $( document ).ready(function() {
        setInterval(function () {
            document.forms["redirectpost"].submit();
        }, 18000);

    });
</script>
<?php echo $footer; ?>
