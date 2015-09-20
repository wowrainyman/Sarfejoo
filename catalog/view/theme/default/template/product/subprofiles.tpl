<?php echo $header; ?>
<div id="s-page-content" class="s-row">
     <div class="s-pc-title"><h1><?php echo $heading_title; ?></h1></div>
     <div class="s-row s-pc-option-bar">
          <?php if ($subprofiles) { ?>
            <div class="product-filter">
               <div class="display"><b><?php echo $text_display; ?></b> <?php echo $text_list; ?> <b>/</b> <a onclick="display('grid');"><?php echo $text_grid; ?></a></div>
               <!--
               <div class="limit"><b><?php echo $text_limit; ?></b>
               
                <select onchange="location = this.value;">
                  <?php foreach ($limits as $limits) { ?>
                  <?php if ($limits['value'] == $limit) { ?>
                  <option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
                
               </div>
               -->
          </div>
          <?php } ?>
     </div>

<?php echo $column_left; ?><?php echo $column_right; ?>

<div id="content" class="s-pc-c-center">
<?php echo $content_top; ?>
   
  <div class="breadcrumb s-pc-c-c-bread">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($subprofiles) { ?>
  <div class="product-list">
    <?php foreach ($subprofiles as $subprofile) { ?>
    <div>
      <?php if ($subprofile['logo']) { ?>
      <div class="image"><a href="index.php?route=product/subprofile&subprofile_id=<?php echo $subprofile['id']; ?>">
      <img class="p-logo-list" src="ProvidersScans/<?php echo $subprofile['customer_id'] . '/' . $subprofile['id'] . '/' . 'logo_' . $subprofile['logo'] ?>" alt="<?php echo $subprofile['title'] ?>" />

</a></div>
      <?php } ?>
      <div class="name"><a href="index.php?route=product/subprofile&subprofile_id=<?php echo $subprofile['id']; ?>"><?php echo $subprofile['title']; ?></a></div>
      <div class="wishlist"><a onclick="addToWishList('<?php echo $subprofile['id']; ?>');"><?php echo $button_wishlist; ?></a></div>
      <div class="compare"><a onclick="addToCompare('<?php echo $subprofile['id']; ?>','ProvidersScans/<?php echo $subprofile['customer_id'] . '/' . $subprofile['id'] . '/' . 'logo_' . $subprofile['logo'] ?>" alt="<?php echo $subprofile['title'] ?>');"><?php echo $button_compare; ?></a></div>
    </div>
    <?php } ?>
    <div class="pagination"><?php echo $pagination; ?></div>
  </div>
  <!-- <div class="s-pc-c-c-pagenation"><?php echo $pagination; ?></div> -->
  <?php } ?>
  <?php echo $content_bottom; ?></div>
<script type="text/javascript"><!--
function display(view) {
	if (view == 'list') {
		$('.product-grid').attr('class', 'product-list');

		$('.product-list > div').each(function(index, element) {
			html  = '<div class="right">';

			html += '</div>';
			html += ' <div class="name">' + $(element).find('.name').html() + '</div>';

			html += '<div class="left s-list-left">';

			var image = $(element).find('.image').html();

			if (image != null) {
				html += '<div class="image">' + image + '</div>';
			}

			var rating = $(element).find('.rating').html();

			if (rating != null) {
				html += '<div class="rating">' + rating + '</div>';
			}

			html += '</div>';

			$(element).html(html);
		});

		$('.display').html('<b><?php echo $text_display; ?></b> <?php echo $text_list; ?> <b>/</b> <a onclick="display(\'grid\');"><?php echo $text_grid; ?></a>');

		$.totalStorage('display', 'list');
	} else {
		$('.product-list').attr('class', 'product-grid');

		$('.product-grid > div').each(function(index, element) {
			html = '';

			var image = $(element).find('.image').html();

			if (image != null) {
				html += '<div class="image">' + image + '</div>';
			}

			html += '<div class="name">' + $(element).find('.name').html() + '</div>';

			var rating = $(element).find('.rating').html();

			if (rating != null) {
				html += '<div class="rating">' + rating + '</div>';
			}

			$(element).html(html);
		});

		$('.display').html('<b><?php echo $text_display; ?></b> <a onclick="display(\'list\');"><?php echo $text_list; ?></a> <b>/</b> <?php echo $text_grid; ?>');

		$.totalStorage('display', 'grid');
	}
}

view = $.totalStorage('display');

if (view) {
	display(view);
} else {
	display('list');
}
//--></script>
</div>

<?php include 'seo-keyword.php'; ?>

<?php echo $footer; ?>