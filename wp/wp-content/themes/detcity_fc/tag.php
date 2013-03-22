<?php get_header(); ?>
<?php
	/**
	 * Required Variables
	 * Get variables info from theme options panel
	 */

	 global $atp_teaser, $atp_pagination, $readmoretxt;
	$sidebaroption = get_post_meta($post->ID, "sidebar_options", TRUE);
	$subheader_teaser_options = get_post_meta($post->ID, "subheader_teaser_options", true);
	?>
<?php 
	
	if($atp_teaser !="disable") { 	
		if($subheader_teaser_options !="disable") { ?>
	<div class="subheader" id="subheader" <?php  echo subheadercolor($post->ID); ?>>
		<div class="subheader_teaser">
			<div class='subtitle'>
				<h1><?php printf( __( 'Tag Archives: %s', 'victoria_front' ), '<span>' . single_cat_title( '', false ) . '</span>' );?></h1>
			</div>
			<?php 
				$category_description = category_description();
				if ( ! empty( $category_description ) )
				echo '<div class="sub-desc">' . $category_description . '</div>'; 
			?>
		</div>
	</div>
	<?php } 
	} 
	?>
	<!-- #subheader -->

	<div class="pagemid <?php  sidebaroption($post->ID); ?>">
		
		<div class="inner">

			<div id="main">

				<?php $atp_breadcrumbs ? my_breadcrumb():'';  ?>		
				<!-- #breadcrumbs -->
				
				<div class="content">

					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					
					<div <?php post_class('taglist');?> id="post-<?php the_ID(); ?>">

						<?php
						if( has_post_thumbnail()){
							$width= '100';
							$height = '100'; ?>
						<div class="postimg" style="width:<?php echo $width; ?>px;height:<?php echo $height; ?>px; ">
							<div class="post_slider img-framed"><?php echo getPostAttachments(0, 'full', 'alt="' . $post->post_title . '"',$width,$height); ?></div>
						</div>
						<?php } ?>
						<!-- .postimg -->

						<p class="tag-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></p>

					</div>
					<?php endwhile; ?>

					<?php 
					if(function_exists('atp_pagination')) { 
						atp_pagination(); 
					} ?>
					<!-- #pagination -->
		
				<?php else :
					if ( is_category() ) { // If this is a category archive
						printf("<h2 class='center'>Sorry, but there aren't any posts in the %s category yet.</h2>", single_cat_title('',false));
					} else if ( is_date() ) { // If this is a date archive
					echo("<h2>Sorry, but there aren't any posts with this date.</h2>");
					} else if ( is_author() ) { // If this is a category archive
						$userdata = get_userdatabylogin(get_query_var('author_name'));
						printf("<h2 class='center'>Sorry, but there aren't any posts by %s yet.</h2>", $userdata->display_name);
					} else {
						echo("<h2 class='center'>No posts found.</h2>");
						}
					get_search_form();
					endif;
				?>


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