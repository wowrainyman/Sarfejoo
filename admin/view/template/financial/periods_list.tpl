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
                <td><?php echo $column_description; ?></td>
                <td class="left"><?php if ($sort == 'tab1.duration') { ?>
                    <a href="<?php echo $sort_duration; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_duration; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_duration; ?>"><?php echo $column_duration; ?></a>
                    <?php } ?></td>
                <td><?php echo $column_enabled; ?></td>
                <td class="left"><?php if ($sort == 'tab1.sort_sort_order') { ?>
                    <a href="<?php echo $sort_sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_sort_order; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_sort_order; ?>"><?php echo $column_sort_order; ?></a>
                    <?php } ?></td>
                <td><?php echo $column_is_recommended; ?></td>
            </tr>
          </thead>
          <tbody>
            <tr class="filter">
                <td></td>
                <td><input type="text" name="filter_name" value="<?php echo $filter_name; ?>" /></td>
                <td></td>
                <td></td>
                <td><input type="text" name="filter_enabled" value="<?php echo $filter_enabled; ?>" /></td>
                <td></td>

                <td></td>
                <td align="right"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
            </tr>
            <?php if (isset($periods)) { ?>
                <?php foreach ($periods as $period) { ?>
                    <tr>
                        <td class="left"><?php echo $period['id']; ?></td>
                        <td class="left"><input type="text" name="name[<?php echo $period['id']; ?>]" value="<?php echo $period['name']; ?>" /></td>
                        <td class="left"><input type="text" name="description[<?php echo $period['id']; ?>]" value="<?php echo $period['description']; ?>" /></td>
                        <td class="left"><input type="text" name="duration[<?php echo $period['id']; ?>]" value="<?php echo $period['duration']; ?>" /></td>
                        <td class="left"><input type="text" name="enabled[<?php echo $period['id']; ?>]" value="<?php echo $period['enabled']; ?>" /></td>
                        <td class="left"><input type="text" name="sort_order[<?php echo $period['id']; ?>]" value="<?php echo $period['sort_order']; ?>" /></td>
                        <td class="left"><input type="text" name="is_recommended[<?php echo $period['id']; ?>]" value="<?php echo $period['is_recommended']; ?>" /></td>
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
	url = 'index.php?route=financial/features&token=<?php echo $token; ?>';
	var filter_name = $('input[name=\'filter_name\']').attr('value');
	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}
    var filter_title = $('input[name=\'filter_title\']').attr('value');
    if (filter_title) {
        url += '&filter_title=' + encodeURIComponent(filter_title);
    }
    var filter_enabled = $('input[name=\'filter_enabled\']').attr('value');
    if (filter_enabled) {
        url += '&filter_enabled=' + encodeURIComponent(filter_enabled);
    }
	location = url;
}
//--></script>
<?php echo $footer; ?>