<?php get_header(); ?>

<div id="main" <?php if (colored_rocks_has_sidebar('primary')) { ?>class="main-sidebar selfclear"<?php } ?> role="main">

<?php 
//Restric users based on their level
if ( current_user_can( 'judge' ) || current_user_can( 'level_10' ) )  { ?>

<!-- tpl: index -->
    <?php if (have_posts ()) { ?>
        <?php while (have_posts ()) {
            the_post(); ?>
            <?php get_template_part('loop'); ?>
        <?php } ?>
        <?php colored_rocks_content_nav('nav-below'); ?>
    <?php } else { 
	    colored_rocks_no_results(__('Apologies, but no results were found. Perhaps searching will help find a related post.', 'colored_rocks'));
	} ?>
	
	
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

			<h2>ACCESS DENIED...</h2>

				<p>You are not allowed to access this area. If you are a student and trying to login to your account to submit your essay, please double check your username and password and try again.</p>
<img src="<?php bloginfo('template_directory'); ?>/images/access-denied.png" alt="access-denied" width="190" height="190" class="aligncenter" />				
			</div>

		<?php } ?>
		
		</div><!--//#main-->
            <?php if (colored_rocks_has_sidebar('primary')) get_sidebar(); ?>
            <div class="clear"></div>
<?php get_footer(); ?>