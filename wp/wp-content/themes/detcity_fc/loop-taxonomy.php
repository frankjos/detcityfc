<?php

	/**
	 * Required Variables
	 * Get variables info from theme options panel
	 */

	global $atp_pagination;
	$sidebaroption = get_post_meta($post->ID, "sidebar_options", TRUE);
	
	?>
	
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	<div <?php post_class('clearfix menulist');?> id="post-<?php the_ID(); ?>">
	
		<div class="menu_content">

			<?php
			if( has_post_thumbnail()){
				$width= '100'; 
				$height = '100';
				?>
			<div class="menuimg" style="width:<?php echo $width; ?>px; height:<?php echo $height; ?>px; ">
			<?php 	$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), full, false, '' );
			echo '<a href="'.$src['0'].'"  class="lightbox" >';
						if($atp_timthumb=="on") {
						
							echo mu_resize_timthumb($post->ID,$src[0],100,100,'image',''); 
						}else{
							$thumb = get_post_thumbnail_id($post->ID);
							$image = vt_resize( $thumb, '',100, 100, true );
							echo vt_thumb($post->ID,$image['url'],$image['width'],$image['height'],'image','');
						}
						echo '</a>';
				?>
			
			</div>
			<!-- .menuimg -->
			<?php } ?>

			<div class="menu-info">
				<h2 class="menu-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
				<?php echo get_post_meta($post->ID,'item_desc',TRUE); ?>
				<span class="price"><?php echo get_post_meta($post->ID,'price',TRUE); ?></span>
				<?php if(function_exists('the_ratings')) the_ratings();?>
			</div>
			<!-- .menu-info -->
	
		</div>
		<!-- menu_content-->
	</div>
	<!-- .menulist-->
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