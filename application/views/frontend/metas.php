<title><?php echo get_phrase($page_title); ?> | <?php echo get_settings('system_title'); ?></title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="theme-color" content="#00ff84"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="<?php echo get_settings('author') ?>" />

<meta name="keywords" content="<?php echo get_settings('meta_keywords'); ?>"/>
<meta name="description" content="<?php echo get_settings('meta_description'); ?>" />

<!--Social sharing content-->
<?php if($page_name == "logged_in_classes" || $page_name == "logged_out_classes"): ?>
	<meta property="og:title" content="<?php echo $page_title; ?>" />
	<meta property="og:description" content="<?php echo $class_details['short_description']; ?>">
	<meta property="og:image" content="<?php echo get_class_thumbnail($class_details['class_thumbnail'], 'optimized'); ?>">
<?php else: ?>
	<meta property="og:title" content="<?php echo get_settings('system_title'); ?>" />
	<meta property="og:description" content="<?php echo get_frontend_settings('meta_description'); ?>">
	<meta property="og:image" content="<?php echo base_url('uploads/system_images/logo/'.get_frontend_settings('light_logo')); ?>">
<?php endif; ?>

<meta property="og:url" content="<?php echo current_url(); ?>" />
<meta property="og:type" content="website" />
<!--Social sharing content-->

<link name="favicon" type="image/x-icon" href="<?php echo base_url('uploads/system_images/logo/'.get_frontend_settings('favicon')); ?>" rel="shortcut icon" />
<link rel="apple-touch-icon" href="<?php echo base_url('uploads/system_images/logo/'.get_frontend_settings('favicon')); ?>">