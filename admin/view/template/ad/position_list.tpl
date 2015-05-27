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
      <h1><img src="view/image/product.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a href="<?php echo $insert; ?>" class="button"><?php echo $button_insert; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $form_action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="list">
          <thead>
            <tr>
                <td class="left"><?php if ($sort == 'tab1.id') { ?>
                    <a href="<?php echo $sort_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_id; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_id; ?>"><?php echo $column_id; ?></a>
                    <?php } ?></td>
              <td class="left"><?php if ($sort == 'tab1.name') { ?>
                <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                <?php } ?></td>

                <td class="left"><?php echo $column_byclick_plans; ?></td>
                <td class="left"><?php echo $column_byview_plans; ?></td>
                <td class="left"><?php echo $column_bytime_plans; ?></td>
                <td class="left"><?php echo $column_related_groups_id;?></td>
                <td class="left"><?php echo $column_factor;?></td>
                <td></td>
            </tr>
          </thead>
          <tbody>
            <tr class="filter">
                <td></td>
              <td><input type="text" name="filter_name" value="<?php echo $filter_name; ?>" /></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              <td align="right"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
            </tr>
            <?php if (isset($positions)) { ?>
                <?php foreach ($positions as $position) { ?>
                    <tr>
                        <td class="left"><?php echo $position['id']; ?></td>
                        <td class="left"><input type="text" name="name[<?php echo $position['id']; ?>]" value="<?php echo $position['name']; ?>" /></td>
                        <td class="left"><input type="text" name="byclick_plans[<?php echo $position['id']; ?>]" value="<?php echo $position['byclick_plans']; ?>" /></td>
                        <td class="left"><input type="text" name="byview_plans[<?php echo $position['id']; ?>]" value="<?php echo $position['byview_plans']; ?>" /></td>
                        <td class="left"><input type="text" name="bytime_plans[<?php echo $position['id']; ?>]" value="<?php echo $position['bytime_plans']; ?>" /></td>
                        <td class="left"><input type="text" name="related_groups_id[<?php echo $position['id']; ?>]" value="<?php echo $position['related_groups_id']; ?>" /></td>
                        <td class="left"><input type="text" name="factor[<?php echo $position['id']; ?>]" value="<?php echo $position['factor']; ?>" /></td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                  <td class="center" colspan="8"><?php echo $text_no_results; ?></td>
                </tr>
            <?php } ?>
          <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td class="right"><input type="submit" class="button" value="<?php echo $text_edit; ?>" /></td>
          </tr>
          </tbody>
        </table>
      </form>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=ad/position&token=<?php echo $token; ?>';
	var filter_name = $('input[name=\'filter_name\']').attr('value');
	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}
	location = url;
}
//--></script>
<?php echo $footer; ?>