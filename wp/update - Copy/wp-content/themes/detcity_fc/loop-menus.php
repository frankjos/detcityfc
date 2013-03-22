<?php 

	/**
	 * Required Variables
	 * Get variables info from theme options panel
	 */
	 global $sidebaroption, $atp_singlenavigation,$comments,$priceperserving;

?>
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div id="post-<?php the_ID(); ?>"  <?php post_class('menus_single');?>>

		<div class="menu_content">
		
			<div class="menus_single_info">
				<h2 class="menu-title"><?php the_title(); ?></h2>
				<span class="price"><?php echo $priceperserving;?> <?php echo get_post_meta($post->ID,'price',TRUE); ?></span>
			</div>
			<!-- .menu_single_info -->

			<?php
			if( has_post_thumbnail()){
				$width=($sidebaroption==="fullwidth") ?'920':'660'; 
				$height = get_option('atp_psd_imgheight')? get_option('atp_psd_imgheight'): '200';
				?>
			<div class="menus_single_img" style="width:<?php echo $width; ?>px;height:<?php echo $height; ?>px; ">
				<div class="post_slider img-framed"><?php echo getPostAttachments(0, 'full', 'alt="' . $post->post_title . '"',$width,$height); ?></div>
			</div>
			<!-- .menus_single_img -->
			<?php } ?>

			<?php the_content(); ?>

			<div class="clear"></div>

			<div class="posttags"><?php the_tags(); ?></div>

		</div>
		<!-- .menu_content -->
	</div>
	<!-- .menu_single -->

	<?php edit_post_link( __( 'Edit Item', 'victoria_front' ), '<span class="edit-link">', '</span>' ); ?>

	<?php if($atp_singlenavigation) { ?>
		<div id="nav-below" class="navigation">
			<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '', 'Previous post link', 'victoria_front' ) . '</span> %title' ); ?></div>
			<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '', 'Next post link', 'victoria_front' ) . '</span>' ); ?></div>
		</div>
	<!-- #nav-below -->
	<?php } ?>
	
	<div class="clear"></div>

	<?php
	if($comments=="posts" ||  $comments=="both") {
		comments_template('', true); 
	}?>
	<!-- #comments -->

	<?php endwhile; else: ?>
	<?php '<p>'.__('Sorry, no posts matched your criteria.', 'victoria_front').'</p>';?>
	<?php endif; ?>