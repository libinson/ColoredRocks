<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php
    global $page, $paged;
    wp_title('|', true, 'right');
    bloginfo('name');
    $site_description = get_bloginfo('description', 'display');
    if ($site_description && (is_home() || is_front_page()))
        echo " | $site_description";
    if ($paged >= 2 || $page >= 2)
        echo ' | ' . sprintf(__('Page %s', 'colored_rocks'), max($paged, $page));
    ?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" media="all" href="<?php bloginfo('stylesheet_url'); ?>" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<link href='http://fonts.googleapis.com/css?family=Handlee' rel='stylesheet' type='text/css'>
    <?php
    if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
	wp_head();
    ?>
</head>
<body <?php body_class('layout-default'); ?>>
    <div id="wrapper">
    <header class="main">
		<div style="margin-top:20px;margin-bottom: -14px;"><a href="http://coloredrocks.org"><img src="<?php bloginfo('template_directory'); ?>/images/header.png" width="498" height="90" alt="Colored Rocks" /></a></div>
    </header>
	
	
	
	
    <div id="container">
		<div id="frontpage-slideshow">
			<?php if(function_exists('vslider')){ vslider('homepage'); } ?>
		</div>
		
		<nav id="access" class="selfclear search<?php echo(colored_rocks_get_option('search') != 'no' ? '-on' : '-off'); ?>" role="navigation">
		    <div class="left selfclear">
		        <?php wp_nav_menu(array('theme_location' => 'primary')); ?>
		    </div>
		    <?php get_search_form(); ?>
		    <div class="clear"></div>	
	    </nav><!-- #access -->
		
		<img style="float: right;margin-right: 230px;margin-top: -555px;" src="http://coloredrocks.org/wp-content/uploads/change.png" alt="Donate to Colored Rocks" /><a href="/donate" ><img style="float: right;margin-right: 0px;margin-top: -555px;" src="<?php bloginfo('template_directory'); ?>/images/donate.png" alt="Donate to Colored Rocks" /></a>
