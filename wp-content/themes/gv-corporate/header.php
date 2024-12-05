<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1">
        <title><?php wp_title('|', true, 'right'); ?></title>
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<link rel="stylesheet" href="<?php echo TEMP . '/plugins/bootstrap/css/bootstrap.min.css'; ?>"/>
        <link rel="stylesheet" href="<?php echo TEMP . '/style/style.css'; ?>" media="all"/>    

        <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>