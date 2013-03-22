<?php
	/**
	 * Required Variables
	 * Get variables info from theme options panel
	 */
	global $readmoretxt;
	$sidebaroption = get_post_meta($post->ID, "sidebar_options", TRUE);
	?>
	
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	<div <?php post_class();?> id="post-<?php the_ID(); ?>">
	
		<div class="post_content">
			
			<h2 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

			<div class="postmeta">
				<div class="postmetadata">
					<span><img src="<?php echo get_template_directory_uri();?>/images/date_micon.png" alt="" style="vertical-align:middle;" /> <?php the_time('j M, y'); ?>&nbsp;/&nbsp;</span>
					<span><img src="<?php echo get_template_directory_uri();?>/images/postedin_micon.png" alt=" " style="vertical-align:middle;" /> <?php the_category(', ') ?>&nbsp;/&nbsp;</span>
					<span><img src="<?php echo get_template_directory_uri(); ?>/images/author_micon.png" alt="" style="vertical-align:middle;" /> <?php the_author_posts_link(); ?>&nbsp;/&nbsp;</span>
					<span><img src="<?php echo get_template_directory_uri(); ?>/images/comments_micon.png" alt="" style="vertical-align:middle;" /> <?php comments_popup_link( __( '0 Comments', 'victoria_front' ), __( '1 Comment', 'victoria_front' ), __( '% Comments', 'victoria_front' ) );?> </span>
				</div>		
			</div>
			<!-- .postmeta -->
	
			<?php
			if( has_post_thumbnail()){
				$width=($sidebaroption==="fullwidth") ?'960':'640'; 
				$height = get_option('atp_psd_imgheight')? get_option('atp_psd_imgheight'): '150';
			?>
			<div class="postimg" style="width:<?php echo $width; ?>px;height:<?php echo $height; ?>px; ">
				<div class="post_slider"><?php echo getPostAttachments(0, 'full', 'alt="' . $post->post_title . '"',$width,$height); ?></div>
			</div>
			<!-- .postimg -->
			<?php } ?>

			<?php 
			global $more; $more = 0; 
			the_excerpt('');
			?>
			
			<p><a href="<?php the_permalink() ?>" ><?php echo $readmoretxt;?> &rarr;</a></p>

		</div>
	</div>
	
	<?php 
	endwhile; 
	?>

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