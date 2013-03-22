<?php get_header(); ?>
<?php 
	/**
	 * Required Variables
	 * Get variables info from theme options panel
	 */
	global $atp_breadcrumbs;
	$atp_error404txt = get_option(atp_error404txt);
	?>



	<!-- pagemid -->
	<div class="pagemid rightsidebar">
		
		<div class="inner">

			<div id="mainfull" class="clearfix">
			
				<?php $atp_breadcrumbs ? my_breadcrumb():''; ?>
				<!-- #breadcrumbs-->

				<div class="content">
				
					<?php get_search_form(); ?>

					<div class="divider"></div>

					<div class="one_half">
						<h3><?php _e('Pages','victoria_front')?></h3>
						<ul class="sitemap"><?php wp_list_pages('title_li=' ); ?></ul>
					</div>
					<!-- .one_half-->

					<div class="one_fourth">
						<h3><?php _e('Feed','victoria_front')?></h3>
						<ul class="sitemap">
							<li><a title="Full content" href="<?php bloginfo('rss2_url'); ?>"><?php _e('Main RSS','victoria_front'); ?></a></li>
							<li><a title="Comment Feed" href="<?php bloginfo('comments_rss2_url'); ?>"><?php _e('Comment Feed','victoria_front'); ?></a></li>
						</ul>
					</div>
					<!-- .one_fourth-->

					<div class="one_fourth last">
						<h3><?php _e('Categories','victoria_front'); ?></h3>
							<ul class="sitemap"><?php wp_list_categories(''); ?></ul>

						<h3><?php _e('Archives','victoria_front'); ?></h3>
							<ul class="sitemap">
								<?php wp_get_archives('type=monthly&show_post_count=true'); ?>
							</ul>
					</div>
					<!-- .one_fourth last-->

				</div>
				<!-- .content -->
			</div>
			<!-- #mainfull -->
		</div>
		<!-- .inner -->
		
		<div id="back_to_top"><a href="#header">Top</a></div>
	</div>
	<!-- .pagemid -->

	<?php get_footer(); ?>