<?php get_header(); ?>	
<?php

	/**
	 * Required Variables
	 * Get variables info from theme options panel
	 */

	global $atp_teaser, $atp_breadcrumbs;
	$sidebaroption = get_post_meta($post->ID, "sidebar_options", TRUE);
	$subheader_teaser_options = get_post_meta($post->ID, "subheader_teaser_options", true);
?>
	<?php 
	if($atp_teaser !="disable") { 
		if($subheader_teaser_options !="disable") { ?>
	<div class="subheader" id="subheader" <?php  echo subheadercolor($post->ID); ?>>
		<div class="subheader_teaser">
			
		</div>
	</div>
	<?php } 
	} ?>
	<!-- #subheader -->

	<div class="pagemid <?php  sidebaroption($post->ID); ?>">

		<div class="inner">

			<div <?php atp_layout($post->ID); ?>>

				<?php $atp_breadcrumbs ? my_breadcrumb():''; ?>
				<!-- #breadcrumbs -->	

				<div class="content">
					
					<?php get_template_part( 'loop', 'single' ); ?>
				
				</div>
				<!-- .content -->
	
			</div>
			<!-- #main -->

			<?php if($sidebaroption != "fullwidth"){ get_sidebar(); } ?>
			<!-- #sidebar -->

			<div class="clear"></div>
		
		</div>
		<!-- .inner -->

		<div id="back_to_top"><a href="#header">Top</a></div>

	</div>
	<!-- .pagemid -->
	
<?php get_footer(); ?>