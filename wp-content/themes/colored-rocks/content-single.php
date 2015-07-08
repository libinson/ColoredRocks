<?php 
//Restric users based on their level
if ( current_user_can( 'judge' ) || current_user_can( 'level_10' ) )  { ?>

<!-- tpl: content single -->
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php if ('post' == get_post_type()) : ?>
			<div class="entry-meta">
			By student #<?php echo get_the_author_meta('ID'); ?> on <?php the_date(); ?>
			
			</div><!-- .entry-meta -->
			<?php endif; ?>
		</header><!-- .entry-header -->

		<?php if (has_post_thumbnail()) {
			the_post_thumbnail('large-feature');
		} ?>
                
		<div class="entry-content">
		    <?php the_content(); ?>
		    <div class="clear"></div>
		    <?php wp_link_pages(array('before' => '<div class="page-link"><span>' . __('Pages:', 'colored_rocks') . '</span>', 'after' => '</div>')); ?>
	    </div><!-- .entry-content -->

		<?php if ('post' == get_post_type()) { 
        $categories_list = get_the_category_list( __( ', ', 'colored_rocks' ) );
		$tags_list = get_the_tag_list('', __(', ', 'colored_rocks'));
		if ($categories_list || $tags_list){
		?>            
		<footer class="entry-meta">
			<?php
		    if ( $categories_list ) { ?>
	    	<div class="entry-categories">
			<?php printf(__('<span>Posted in</span> %1$s', 'colored_rocks'), $categories_list); ?>
			- Rate This Essay
			<!-- Ratings -->
			<div style="margin-top:-22px;"><?php if(function_exists("kk_star_ratings")) : echo kk_star_ratings($pid); endif; ?></div>
			
			</div><!-- .entry-categories -->
			<?php 
		    }

		    if ($tags_list){
		    ?>
			<div class="entry-tags">
			    <?php printf(__('<span>Tagged</span> %1$s', 'colored_rocks'), $tags_list); ?>
			</div><!-- .entry-tags -->
			<?php } ?>
		</footer>
		<?php }} ?>
		
		

	</article><!-- #post-<?php the_ID(); ?> -->
	
	<?php 
	//Deny access if:
	} elseif ( is_user_logged_in()==false ) { ?>
	
	<div class="judge-content">

			<h2>ACCESS DENIED...</h2>

				<p>You must be <a href="<?php bloginfo('url'); ?>/wp-login.php">logged in as a judge</a> to access this area.</p>
<img src="<?php bloginfo('template_directory'); ?>/images/access-denied.png" alt="access-denied" width="190" height="190" class="aligncenter" />

			</div>

		<?php } elseif ( is_user_logged_in() ) { ?>

			<div class="judge-content">

			<h2>Thank you for submitting your essay</h2>

				<p>Thank you for submitting your essay, it has been added to our database and will be entered in the contest. Winners will be announced in February. Thank you.</p>
				
			</div>

		<?php } ?>