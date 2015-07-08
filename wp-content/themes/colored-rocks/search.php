<?php get_header(); ?>

<div id="main" <?php if (colored_rocks_has_sidebar('primary')) { ?>class="main-sidebar selfclear"<?php } ?> role="main">

<!-- tpl: search -->
	<?php if (have_posts()) { ?>
        <header class="page-header">
		    <h1 class="page-title"><?php printf(__('Search Results for: %s', 'colored_rocks'), '<span>' . get_search_query() . '</span>'); ?></h1>
		</header>

		<?php while (have_posts()) {
            the_post(); ?>
            <?php get_template_part('loop'); ?>
		<?php } ?>
		<?php colored_rocks_content_nav('nav-below'); ?>

	<?php } else { 
	    colored_rocks_no_results(__('Apologies, but no results were found for the requested search. Perhaps searching will help find a related post.', 'colored_rocks'));
	} ?>
<?php //get_sidebar(); ?>
<?php get_footer(); ?>
