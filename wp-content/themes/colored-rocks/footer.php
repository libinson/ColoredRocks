</div><!--//#container-->

    </div>
<div id="big-footer">
<div id="inner-footer">

            <div class="clear"></div>
            <?php if (colored_rocks_has_sidebar('footer')) get_template_part('sidebar', 'footer'); ?> 
			
			
	        <footer class="main">
            <?php
            // Socials Icons
            $footer_social = colored_rocks_get_social();
            if ($footer_social) echo $footer_social; 
			?>
			<?php // According to Contract 0782 signed by Colored Rocks Foundation, The credit for the site design will be displayed for perpetual duration of the site existence at the bottom of the client’s website in the footer section. Removal of this credit link is prohibited by the client and violation will be regarded as breach of this contract and legal action will be taken immediatly. Client may opt out of this clause for $200 USD at any time. ?>
			<div id="credits">
			Copyright 2010-2015 Colored Rocks Foundation and Colored Rocks Prize – All rights reserved. <a href="<?php echo wp_login_url( $redirect ); ?>">Admin/Judges Login</a><br />
			Web-design and development by: <a href="http://coloredrocks.org">Colored Rocks Foundation Inc.</a></div>
        </footer><!--//footer#main-->
</div>
</div>
    <?php wp_footer(); ?> 
</body>
</html>
