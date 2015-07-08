<?php get_header(); ?>


<div id="main" <?php if (colored_rocks_has_sidebar('primary')) { ?>class="main-sidebar selfclear"<?php } ?> role="main">

<!-- tpl: 404 -->
<article id="post-0" class="post no-results not-found">
    <header class="entry-header">
        <h1 class="entry-title"><?php _e('404: Page Not Found', 'colored_rocks'); ?></h1>
    </header><!-- .entry-header -->
    <div class="entry-content">
        <p>We are terribly sorry, but the URL you typed no longer exists. It might have been moved or deleted, or perhaps you mistyped it.</p>
    </div><!-- .entry-content -->
</article><!-- #post-0 -->

</div><!--//#main-->
            <?php if (colored_rocks_has_sidebar('primary')) get_sidebar(); ?>
            <div class="clear"></div>

<?php get_footer(); ?>
