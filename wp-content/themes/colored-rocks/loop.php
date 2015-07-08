    <!-- tpl: loop -->
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
		<header class="entry-header">
			<h3 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'colored_rocks'), the_title_attribute('echo=0')); ?>" rel="bookmark">
					<?php $title = get_the_title(); 
					if (!$title) $title = __('More ...', 'colored_rocks');
					echo $title;
					?></a></h3>
			<?php if ('post' == get_post_type()) { ?>
			<div class="entry-meta">
				By student #<?php echo get_the_author_meta('ID'); ?> on <?php the_date(); ?>
			</div><!-- .entry-meta -->
			<?php } ?>
		</header><!-- .entry-header -->
        
        <?php if (has_post_thumbnail()) {
			the_post_thumbnail();
		} ?>
		
		<div class="entry-content">
		    <div class="entry-summary">
			    <?php the_excerpt(); ?>
		    </div><!-- .entry-summary -->
		    
			<?php wp_link_pages(array('before' => '<div class="page-link"><span>' . __('Pages:', 'colored_rocks') . '</span>', 'after' => '</div>')); ?>
		</div><!-- .entry-content -->
        
        <?php if ('post' == get_post_type()) { 
        $categories_list = get_the_category_list( __( ', ', 'colored_rocks' ) );
		if ($categories_list){
		?>            
		<footer class="entry-meta">
	    	<div class="entry-categories">
			<?php printf(__('<span>Essay posted in</span> %1$s', 'colored_rocks'), $categories_list); ?>
			</div><!-- .entry-categories -->
		</footer>
		<?php }} ?>

        <div class="clear"></div>
	</article><!-- #post-<?php the_ID(); ?> -->
