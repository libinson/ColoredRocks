<div id="comments">
	<?php if (post_password_required()) { ?>
		<p class="nopassword"><?php _e('This post is password protected. Enter the password to view any comments.', 'colored_rocks'); ?></p>
	</div><!-- #comments -->
	<?php
		return;
    }
	?>

	<?php if (have_comments()) { ?>
		<h2 id="comments-title">
			<?php
				printf(_n('1 comment', '%1$s comments', get_comments_number(), 'colored_rocks'),
					number_format_i18n(get_comments_number()), '<span>' . get_the_title() . '</span>');
					
			?>
			<a class="comment-leave" href="#respond" title="<?php _e('&mdash; post a comment', 'colored_rocks'); ?>">
			    <?php _e('&mdash; post a comment', 'colored_rocks'); ?></a>
		</h2>

		<?php if (get_comment_pages_count() > 1 && get_option('page_comments')) {  ?>
		<nav id="comment-nav-above">
			<h1 class="assistive-text"><?php _e('Comment navigation', 'colored_rocks'); ?></h1>
			<div class="nav-previous"><?php previous_comments_link(__('&larr; Older Comments', 'colored_rocks')); ?></div>
			<div class="nav-next"><?php next_comments_link(__('Newer Comments &rarr;', 'colored_rocks')); ?></div>
		</nav>
		<?php } ?>

		<div class="commentlist">
			<?php wp_list_comments(array('callback' => 'colored_rocks_comment', 'style' => 'div'));	?>
		</div>

		<?php if (get_comment_pages_count() > 1 && get_option('page_comments')) { ?>
		<nav id="comment-nav-below">
			<h1 class="assistive-text"><?php _e('Comment navigation', 'colored_rocks'); ?></h1>
			<div class="nav-previous"><?php previous_comments_link(__('&larr; Older Comments', 'colored_rocks')); ?></div>
			<div class="nav-next"><?php next_comments_link(__('Newer Comments &rarr;', 'colored_rocks')); ?></div>
		</nav>
		<?php } ?>

	<?php
        } elseif (! comments_open() && ! is_page() && post_type_supports(get_post_type(), 'comments')) {	?>
        <!-- comments are closed -->
	<?php } ?>

	<?php comment_form(); ?>

</div><!-- #comments -->
