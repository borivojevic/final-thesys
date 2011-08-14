<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport"
		content="width=device-width, minimum-scale=1, maximum-scale=1, initial-scale=1.0, user-scalable=no" />
	<title><?php echo $title_for_layout?></title>
	<?php
		echo $this->Html->css('jquery.mobile-1.0a4.1.min.css');
		echo $javascript->link('jquery-1.5.2.min');
		echo $javascript->link('jquery.mobile-1.0a4.1.min');
		echo $javascript->link('profileSettings');

		echo $scripts_for_layout;
	?>
</head>
<body>
	<?php echo $content_for_layout ?>
	<?php echo $this->element('notifications'); ?>
</body>
</html>
