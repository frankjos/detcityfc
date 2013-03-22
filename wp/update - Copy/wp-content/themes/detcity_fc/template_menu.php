<?php
/*
Template Name: Menu
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
	
	<div class="pagemid <?php sidebaroption($post->ID); ?>">
		
		<div class="inner">

			<div <?php atp_layout($post->ID); ?>>
			
				<?php $atp_breadcrumbs ? my_breadcrumb():''; ?>
				<!-- #breadcrumbs -->
				
				<div class="content">
					<?php // the_content(); ?>
					
					<div class="menus_container clearfix">
						<?php
						/**
						 *
						 */
						$menus_array =get_terms('menutype','hide_empty=0');
						foreach ($menus_array as $menus) {
							$dynamic_menus[$menus->slug] = $menus->name;
							$t_id = $menus->term_id; 	
							$term_meta = get_option("taxonomy_$t_id");
							$term_meta[menu_order];
						
							echo '<div class="menus_cat_item">';
							echo '<h3 class="menu-title">'.$menus->name.'</h3>';
							echo '<div class="menus_cat"><a href="'.get_term_link($menus->slug,'menutype') .'">';
							if($term_meta[img]!=''){
								if(get_option('atp_timthumb')=="on") {
									echo mu_resize_timthumb($post->ID,$term_meta[img],280,180,'imgborder',''); 
								}else{
									$thumb = get_post_thumbnail_id($post->ID);
									$image = vt_resize('',$term_meta[img],280, 180, true );
									echo vt_thumb($post->ID,$image['url'],$image['width'],$image['height'],'imgborder','');
								}
							}else{
								// No Image
								echo '<img src="'.get_template_directory_uri().'/image/no-image.png" width="280" hight="180" alt="No Image"/>';
							}
							echo '</a></div>';	
							echo '</div>';
						}?>
					</div>
					<!-- .menus_container -->
					
					<div class="clear"></div>
					
					<?php edit_post_link(__('Edit', 'victoria_front'), '<span class="edit-link">', '</span>'); ?>
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