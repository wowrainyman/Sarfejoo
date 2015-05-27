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
              <td class="left"><?php if ($sort == 'tab1.subattribute_name') { ?>
                <a href="<?php echo $sort_subattribute_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_subattribute_name; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_subattribute_name; ?>"><?php echo $column_subattribute_name; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'tab1.block_id') { ?>
                <a href="<?php echo $sort_block_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_block_id; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_block_id; ?>"><?php echo $column_block_id; ?></a>
                <?php } ?></td>
                <td class="left">
                    <?php echo $column_type; ?>
                </td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <tr class="filter">
              <td><input type="text" name="filter_subattribute_name" value="<?php echo $filter_subattribute_name; ?>" /></td>
              <td></td>
                <td></td>
              <td align="right"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
            </tr>
            <?php if (isset($blockAttributes)) { ?>
            <?php foreach ($blockAttributes as $blockAttribute) { ?>
            <tr>
              <td class="left"><input type="text" name="subattribute_name[<?php echo $blockAttribute['id']; ?>]" value="<?php echo $blockAttribute['subattribute_name']; ?>" /></td>
                <td class="left"><?php echo $blockAttribute['block_id']; ?></td>
                <td class="left">
                    <select type="text" name="type[<?php echo $blockAttribute['id']; ?>]">
                        <option <?php if ($blockAttribute['type'] == 'Selectbox') echo 'selected="selected"' ?> value="Selectbox">Selectbox</option>
                        <option <?php if ($blockAttribute['type'] == 'Radiobutton') echo 'selected="selected"' ?> value="Radiobutton">Radiobutton</option>
                        <option <?php if ($blockAttribute['type'] == 'Text') echo 'selected="selected"' ?> value="Text">Text</option>
                        <option <?php if ($blockAttribute['type'] == 'Multitext') echo 'selected="selected"' ?> value="Multitext">Multitext</option>
                    </select>
                </td>
                <td class="left"><input type="text" name="class[<?php echo $blockAttribute['id']; ?>]" value="<?php echo $blockAttribute['class']; ?>" /></td>
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
	url = 'index.php?route=customextension/block_attribute&token=<?php echo $token; ?>';
	
	var filter_subattribute_name = $('input[name=\'filter_subattribute_name\']').attr('value');
	
	if (filter_subattribute_name) {
		url += '&filter_subattribute_name=' + encodeURIComponent(filter_subattribute_name);
	}
	location = url;
}
//--></script>
<?php echo $footer; ?>