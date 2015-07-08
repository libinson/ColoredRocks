<?php get_header(); ?>
<div id="main" <?php if (colored_rocks_has_sidebar('primary')) { ?>class="main-sidebar selfclear"<?php } ?> role="main">
    <!-- tpl: page -->
	
    <?php the_post(); ?>
	
    <?php get_template_part('content', 'page'); ?>

    <?php comments_template('', true); ?>
	
	            </div><!--//#main-->
            <?php if (colored_rocks_has_sidebar('primary')) get_sidebar(); ?>
            <div class="clear"></div>
	
<?php get_footer(); ?>
