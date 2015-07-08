<div id="sidebar" class="sidebar selfclear">

<?php 
//Restric users based on their level
if ( current_user_can( 'judge' ) || current_user_can( 'level_10' ) )  { ?>

    <?php dynamic_sidebar('judges_sidebar'); ?>
	
	<?php } else { ?>

	<?php dynamic_sidebar('primary'); ?>

		<?php } ?>
	
</div><!--end sidebar-->

	    
