<?php get_header(); ?>
<?php

	/**
	 * Required variables for taxonomy
	 */

	global $wp_query; 
	
	$taxonomy_archive_query_obj = $wp_query->get_queried_object();// Get taxonomy object
	$taxonomy_term_nice_name = $taxonomy_archive_query_obj->name; // Taxonomy term name
	$term_id = $taxonomy_archive_query_obj->term_taxonomy_id; // Taxonomy term id
	$taxonomy_short_name = $taxonomy_archive_query_obj->taxonomy; // Get taxonomy shortname
	$taxonomy_raw_obj = get_taxonomy($taxonomy_short_name); // Get taxonomy raw object
	$taxonomy_full_name = $taxonomy_raw_obj->labels->name;
	
?>
<?php 

	if($atp_teaser !="disable") { 
	?>
	<div id="subheader" class="subheader">
		<div class="subheader_teaser">
			<div class="subtitle"><h1><?php _e($taxonomy_full_name.' Archives:', 'victoria_front'); ?> <?php _e($taxonomy_term_nice_name,'victoria_front'); ?></h1></div>
		</div>
	</div>
	<?php } ?>
	<!-- #subheader -->

	<div class="pagemid rightsidebar">
		
		<div class="inner">

			<div id="main">

				<?php $atp_breadcrumbs ? my_breadcrumb():''; ?>
				<!-- #breadcrumbs -->

				<div class="content">
				<?php
					rewind_posts();
					get_template_part( 'loop', 'taxonomy' );?>

				</div>
				<!-- .content -->
			
			</div>
			<!-- #main -->

			<?php get_sidebar(); ?>
			<!-- #sidebar -->
			
		</div>
		<!-- .inner -->

		<div id="back_to_top"><a href="#header">Top</a></div>

	</div>
	<!-- .pagemid -->

<?php get_footer(); ?>