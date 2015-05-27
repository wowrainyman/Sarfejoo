<?php echo $header; ?>
<div id="s-page-content" class="s-row">
     <div class="s-pc-title"><h1><?php echo $heading_title; ?></h1></div>
<div id="content">
<?php echo $content_top; ?>
  <div class="breadcrumb s-pc-c-c-bread">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php echo $description; ?>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
  </div>
  <?php echo $content_bottom; ?>
  </div>
  </div>

<?php include 'seo-keyword.php'; ?>
<?php echo $footer; ?>