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
              <td class="left"><?php if ($sort == 'tab1.block_name') { ?>
                <a href="<?php echo $sort_block_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_block_name; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_block_name; ?>"><?php echo $column_block_name; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'tab1.attribute_id') { ?>
                <a href="<?php echo $sort_attribute_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_attribute_id; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_attribute_id; ?>"><?php echo $column_attribute_id; ?></a>
                <?php } ?></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <tr class="filter">
              <td><input type="text" name="filter_block_name" value="<?php echo $filter_block_name; ?>" /></td>
                <td></td>
              <td align="right"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
            </tr>
            <?php if (isset($blocks)) { ?>
            <?php foreach ($blocks as $block) { ?>
            <tr>
              <td class="left"><input type="text" name="block_name[<?php echo $block['id']; ?>]" value="<?php echo $block['block_name']; ?>" /></td>
                <td class="left"><?php echo $block['attribute_id']; ?></td>
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
	url = 'index.php?route=customextension/block&token=<?php echo $token; ?>';
	
	var filter_block_name = $('input[name=\'filter_block_name\']').attr('value');
	
	if (filter_block_name) {
		url += '&filter_block_name=' + encodeURIComponent(filter_block_name);
	}
	location = url;
}
//--></script>
<?php echo $footer; ?>