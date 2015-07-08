<?php
get_header(); ?>
<div id="main" <?php if (colored_rocks_has_sidebar('primary')) { ?>class="main-sidebar selfclear"<?php } ?> role="main">
<!-- tpl: single -->
    <?php while (have_posts()) {
        the_post(); ?>
        <?php get_template_part('content', 'single'); ?>
		<?php colored_rocks_content_nav('nav-below', 'single'); ?>
        <?php comments_template('', true); ?>
    <?php } // end of the loop. ?>
	
	</div><!--//#main-->
            <?php if (colored_rocks_has_sidebar('primary')) get_sidebar(); ?>
            <div class="clear"></div>
<?php get_footer(); ?>
