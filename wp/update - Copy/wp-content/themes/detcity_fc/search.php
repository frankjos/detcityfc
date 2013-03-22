<?php get_header(); ?>
<?php

	/**
	 * Required Variables
	 * Get variables info from theme options panel
	 */

	global $atp_teaser, $atp_breadcrumbs, $readmoretxt;
?>
	<?php 
	if($atp_teaser !="disable") { ?>
	<div id="subheader" class="subheader">
		<div class="subheader_teaser">
			<h1><?php _e('Search Results','victoria_front'); ?></h1>
			<h4><?php _e('Search Results for','victoria_front'); ?>: <?php $allsearch = &new WP_Query("s=$s&showposts=-1"); $key = esc_html($s, 1); $count = $allsearch->post_count; _e('',victoria_front); _e('<span>'); echo $key; _e('</span>'); _e(' - '); echo $count . ' '; _e('results found.',victoria_front); wp_reset_query();?></h4>
		</div>
	</div>
	<!-- #subheader -->
	<?php } ?>

	<div class="pagemid rightsidebar">
		
		<div class="inner">

			<div id="main">

				<?php $atp_breadcrumbs ? my_breadcrumb():''; ?>	
				<!-- #breadcrumbs -->
				
				<div class="content">
				
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					
					<div class="searchresults">
	
						<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
							
							<h2 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
							
							<div class="postmeta">
								<div class="postmetadata"><?php echo get_the_date(); ?></div>
							</div>
							<!-- .postmeta -->
							
							<?php 
								global $more; $more = 0;  
								the_excerpt(''); ?>		
							
							<a href="<?php the_permalink() ?>" class="more-link"><?php echo $readmoretxt; ?> &rarr;</a>
						
						</div>
						<!-- #post-<?php the_ID(); ?> -->
					
					</div>
					<!-- .searchresults -->
					
					<div class="divider"></div>

					<?php endwhile; ?>

					<?php
					if(function_exists('atp_pagination')) { 
						atp_pagination(); 
					}?>
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
					endif;?>
				
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