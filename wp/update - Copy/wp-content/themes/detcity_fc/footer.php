<?php  
	/**
	 * Required Variables
	 * Get variables info from theme options panel
	 */

	$footersidebar=get_option("atp_footer_sidebar");
	$googleanalytics=get_option("atp_googleanalytics"); ?>

	<div id="footer">
		<?php 
		
		// Footer Teaser Text
		if(get_option('atp_teaser_footer')=="on") 
			footer_teaser_option();
		?>
		<?php 
		// Footer Sidebar Columnized Widgets
		if($footersidebar == "on"){ ?>
			<div class="footersidebar">
				<div class="inner">
				<?php get_template_part( 'includes/sidebar', 'footer' ); ?>
				</div>
				<!-- .inner -->
			</div>
			<!-- .footersidebar -->
		<?php } ?>
	
		<div class="copyright">
			<div class="inner">
				<div class="copy_left">
					<p><?php echo stripslashes(get_option("atp_copyright")); ?></p>
				</div>
				<div class="copy_right">
					<?php  get_template_part( 'includes/sociable', 'bookmark' ); ?>
				</div>
			</div>
			<!-- .inner -->
		</div>
		<!-- .copyright -->
</div>
<!-- end:Footer -->

</div>
<!-- wrap_all -->
</div>
<!-- #layout -->
<?php 

	// Google Analytics Script code Fetching from theme options panel
	if($googleanalytics) {
		echo stripslashes($googleanalytics); 
	}
?>
<?php

	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body>
</html>