<?php

	/**
	 * Required Variables
	 * Get variables info from theme options panel
	 */
	global $relatedposts,$atp_singlefeaturedimg, $aboutauthor, $atp_singlenavigation, $comments;
	$sidebaroption = get_post_meta($post->ID, "sidebar_options", TRUE);
	?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	<div id="post-<?php the_ID(); ?>"  <?php post_class();?>>
		
		<h1 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>

		<div class="postmeta">
			<div class="postmetadata">
				<span><img src="<?php echo get_template_directory_uri();?>/images/date_micon.png" alt="" style="vertical-align:middle;" /> <?php the_time('j M, y'); ?>&nbsp;/&nbsp;</span>
				<span><img src="<?php echo get_template_directory_uri();?>/images/postedin_micon.png" alt=" " style="vertical-align:middle;" /> <?php the_category(', ') ?>&nbsp;/&nbsp;</span>
				<span><img src="<?php echo get_template_directory_uri(); ?>/images/author_micon.png" alt="" style="vertical-align:middle;" /> <?php the_author_posts_link(); ?>&nbsp;/&nbsp;</span>
				<span><img src="<?php echo get_template_directory_uri(); ?>/images/comments_micon.png" alt="" style="vertical-align:middle;" /> <?php comments_popup_link( __( '0 Comments', 'victoria_front' ), __( '1 Comment', 'victoria_front' ), __( '% Comments', 'victoria_front' ) );?> </span>
				<?php edit_post_link(__('Edit', 'victoria_front'), '<span class="edit-link">', '</span>'); ?>
			</div>		
		</div>
		<!-- .postmeta -->

		<?php 
		// Get info from options panel to display the post featured image
		if($atp_singlefeaturedimg != '') {
			
			if( has_post_thumbnail()){
				$width=($sidebaroption==="fullwidth") ?'920':'640'; 
				$height = "300";
			?>
			<div  class="postimg" style="width:<?php echo $width; ?>px; height:<?php echo $height; ?>px; ">
				<div class="post_slider"><?php echo getPostAttachments(0, 'full', 'alt="' . $post->post_title . '"',$width,$height); ?></div>
			</div>
			<!-- .postimg -->
		<?php
			}
		}
		?>

		<?php the_content(); ?>
		
		<span class="posttags"><?php the_tags(); ?></span><br />

		<?php  
		if($aboutauthor == "on") { 
			sys_authorinfo(); 
		} ?>	
		<!-- #entry-author-info -->
		
		<?php if($atp_singlenavigation) { ?>
		<div id="nav-below" class="navigation">
			<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '', 'Previous post link', 'victoria_front' ) . '</span> %title' ); ?></div>
			<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '', 'Next post link', 'victoria_front' ) . '</span>' ); ?></div>
		</div>
		<!-- #nav-below-->
		<?php } ?>

	</div>
	<!-- #post-<?php the_ID(); ?> -->

	<?php  if($relatedposts == "on") { 
		sys_relatedposts($post->ID); 
		} ?>
	<!-- .singlepostlists -->

	<div class="clear"></div>


	<?php
	if($comments=="posts" ||  $comments=="both") {
		comments_template('', true); 
	}
	?>
	<!-- #comments -->

	<?php endwhile; else: ?>
	<?php '<p>'.__('Sorry, no posts matched your criteria.', 'victoria_front').'</p>';?>
	<?php endif; ?>