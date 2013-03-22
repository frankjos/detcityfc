<?php
/*
Template Name: Site Map
*/
get_header();
?>
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
			<?php subheaderteaser($post->ID); ?>
		</div>
	</div>
	<?php } 
	} ?>
	<!-- #subheader -->

	<div class="pagemid fullwidth">

		<div class="inner">	

			<div id="mainfull">

				<?php $atp_breadcrumbs ? my_breadcrumb():''; ?>
				<!-- #breadcrumbs -->

				<div class="content">
					
					<?php if (have_posts()): while (have_posts()): the_post(); ?>
						
						<?php the_content(); ?> 

					<?php endwhile; endif; ?>

					<div class="one_fourth">
						<h3><?php _e('Pages', 'victoria_front'); ?></h3>
						<ul class="sitemap"><?php wp_list_pages('title_li='); ?></ul>
					</div>
		
					<div class="one_fourth">
						<h3><?php _e('Feeds', 'victoria_front'); ?></h3>
						<ul class="sitemap">
							<li><a title="<?php _e('Main RSS', 'victoria_front'); ?>" href="<?php bloginfo('rss2_url'); ?>"><?php _e('Main RSS', 'victoria_front'); ?></a></li>
							<li><a title="<?php _e('Comment Feed', 'victoria_front'); ?>" href="<?php bloginfo('comments_rss2_url'); ?>"><?php _e('Comment Feed', 'victoria_front'); ?></a></li>
						</ul>
					</div>
		
					<div class="one_fourth">
						<h3><?php _e('Categories', 'victoria_front'); ?></h3>
						<ul class="sitemap"><?php wp_list_categories(''); ?></ul>
					</div>
		
					<div class="one_fourth last">
						<h3><?php _e('Archives', 'victoria_front'); ?></h3>
						<ul class="sitemap">
							<?php wp_get_archives('type=monthly&show_post_count=true'); ?>
						</ul>
					</div>
				</div>
				<!-- .content -->
			</div>	
			<!-- #mainfull -->

			<div class="clear"></div>
		</div>
		<!-- .inner -->
		
		<div class="clear"></div>
		
		<div id="back_to_top"><a href="#header">Top</a></div>
	</div>
	<!-- .pagemid -->

<?php get_footer(); ?>