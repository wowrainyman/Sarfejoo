<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
<div id="s-page-content" class="s-row">
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content" class="s-pc-c-center">
<?php echo $content_top; ?>
  <div class="breadcrumb s-pc-c-c-bread">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb['separator']; ?><a
                href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="productid" value="<?php echo $productid; ?>" />
        <input type="hidden" name="subprofileid" value="<?php echo $subprofileid; ?>" />
        <?php if(isset($id)) { ?>
            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
        <?php } ?>
        <h2><?php echo $text_profile; ?></h2>

        <div class="content">
            <table class="form">
                <tr>
                    <td><span class="required">*</span> <?php echo $entry_title; ?></td>
                    <td><input type="text" name="title" value="<?php echo $title; ?>"/>
                        <?php if ($error_title) { ?>
                        <span class="error"><?php echo $error_title; ?></span>
                        <?php } ?></td>
                </tr>
                <tr>
                    <td><span class="required">*</span> <?php echo $entry_startdate; ?></td>
                    <td><input type="text" id="startdate" name="startdate" value="<?php echo $startdate; ?>"/>
                        <?php if ($error_startdate) { ?>
                        <span class="error"><?php echo $error_startdate; ?></span>
                        <?php } ?></td>
                </tr>
                <tr>
                    <td><span class="required">*</span> <?php echo $entry_enddate; ?></td>
                    <td><input type="text" id="enddate"  name="enddate" value="<?php echo $enddate; ?>"/>
                        <?php if ($error_enddate) { ?>
                        <span class="error"><?php echo $error_enddate; ?></span>
                        <?php } ?></td>
                </tr>
                <tr>
                    <td><span class="required">*</span> <?php echo $entry_percent; ?></td>
                    <td><input type="text" name="percent" value="<?php echo $percent; ?>"/>
                        <?php if ($error_percent) { ?>
                        <span class="error"><?php echo $error_percent; ?></span>
                        <?php } ?></td>
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
    
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/ui.datepicker.js"></script>
<script type="text/javascript"><!--
$(document).ready(function() {
    $('#enddate').datepicker({changeMonth: true, changeYear: true, yearRange: '-80:+0', dateFormat: 'yy-mm-dd'});
    $('#startdate').datepicker({changeMonth: true, changeYear: true, yearRange: '-80:+0', dateFormat: 'yy-mm-dd'});
});
//--></script>
    
<?php echo $footer; ?>
<script>
    function addressset() {
        var searchString = $("#city").val();
        document.getElementById("Search").value = searchString;
    }
</script>