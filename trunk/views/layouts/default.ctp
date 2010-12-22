<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php echo $html->charset('utf-8'); ?>
<title><?php echo $title_for_layout?></title>
<?php echo $this->element('head'); ?>
</head>
<body>
	<?php echo $this->element('header'); ?>
	<?php echo $this->element('navbar'); ?>

	<div id="content" class="container_16">
		<?php echo $content_for_layout ?>
	</div>
	
	<?php echo $this->element('footer'); ?>
</body>
</html>
