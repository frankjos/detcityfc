<?php get_header(); ?>
<?php 
	/**
	 * Required Variables
	 * Get variables info from theme options panel
	 */
	global $atp_breadcrumbs;
	$atp_error404txt = get_option('atp_error404txt');
	$sidebaroption = get_post_meta($post->ID, "sidebar_options", TRUE);
	?>

	<div id="subheader" class="subheader">
		<div class="subheader_teaser">
			<div class='subtitle'>
			<h1><?php printf( __( 'Category Archives: %s', 'victoria_front' ), '<span>' . single_cat_title( '', false ) . '</span>' );?></h1></div>
			<?php 
				$category_description = category_description();
				if ( ! empty( $category_description ) )
				echo '<div class="sub-desc">' . $category_description . '</div>'; 
				?>
			</div>
		</div>
	</div>
	<!-- #subheader -->

	<div class="pagemid <?php sidebaroption($post->ID); ?>">

		<div class="inner">

			<div id="main">
				
				<?php $atp_breadcrumbs ? my_breadcrumb():''; ?>
				<!-- #breadcrumbs -->

				<div class="content">
					<?php get_template_part( 'loop' ); ?>
				</div>
				<!-- .content -->
		
			</div>
			<!-- #main -->

			<?php get_sidebar(); ?>
			<!-- #sidebar -->

			<div class="clear"></div>

		</div>
		<!-- .inner -->
		
		<div id="back_to_top"><a href="#header">Top</a></div>
	</div>
	<!-- .pagemid -->
	
<?php get_footer(); ?>