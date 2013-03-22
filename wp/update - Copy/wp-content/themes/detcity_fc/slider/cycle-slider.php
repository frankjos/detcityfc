<?php 
$slidelimit=get_option('atp_cycleslidelimit');
?>
<div id="featured_slider">
	<div class="slider_wrapper">
		<div class="sys_slider">
			<div class="slideshow">
<?php
				
				query_posts("post_type=slider&showposts=$slidelimit&order=ASC");

				while (have_posts()) : the_post();
				$align_options = get_post_meta($post->ID,"slider_alignoptions",true);
				$item_desc=do_shortcode(get_post_meta($post->ID,'item_desc',true));
				$postlinktype_options = get_post_meta($post->ID, "postlinktype_options", true);
				$postlinkurl = atp_getPostLinkURL($postlinktype_options);
				$atp_timthumb=get_option('atp_timthumb');
				switch($align_options){ 
					case "full":
						echo '<div class="clearfix"><div class="full">';
						echo'<div class="holder loader">';
						echo'<a href="'.$postlinkurl.'"  >';
						if($atp_timthumb=="on") {
						$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full', false, '' );
						echo mu_resize_timthumb($post->ID,$src[0],1020,360,'image',''); 
						}else{
						$thumb = get_post_thumbnail_id($post->ID);
						$image = vt_resize( $thumb, '',1020, 360, true );
						echo vt_thumb($post->ID,$image['url'],$image['width'],$image['height'],'image','');
						}
						echo '</a>';
						echo '</div>';
						echo '</div></div>';
						break;
					case "partialleft":
						echo '<div class="clearfix halfslide"><div class="descleft">'; ?>
						<h1><?php the_title(); ?></h1>
						<p><?php the_content(); ?></p>
						<p><a class="button medium"  href="<?php $postlinkurl ?>"><span><?php echo $readmoretxt; ?></span></a></p><?php
						echo'</div>';
						echo'<div class="half">';
						echo'<div class="holder loader">';
						echo '<a href="'.$postlinkurl.'"  >';
						if($atp_timthumb=="on") {
							$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full', false, '' );
							echo mu_resize_timthumb($post->ID,$src[0],560,360,'image',''); 
						}else{
							$thumb = get_post_thumbnail_id($post->ID);
							$image = vt_resize( $thumb, '',560, 360, true );
							echo vt_thumb($post->ID,$image['url'],$image['width'],$image['height'],'image','');
						}
						echo '</a>';
						echo '</div>';
						echo '</div></div>';
						break;
					case "partialright":
						echo '<div class="clearfix halfslide"><div class="half">';
						echo '<div class="holder loader">';
						echo '<a href="'.$postlinkurl.'"  >';
						if($atp_timthumb=="on") {
							$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full', false, '' );
							echo mu_resize_timthumb($post->ID,$src[0],560,360,'image',''); 
						}else{
							$thumb = get_post_thumbnail_id($post->ID);
							$image = vt_resize( $thumb, '',560, 360, true );
							echo vt_thumb($post->ID,$image['url'],$image['width'],$image['height'],'image','');
						}
						echo '</a>';
						echo '</div>';
						echo '</div>';
						echo '<div class="descright">'; ?>
						<h1><?php the_title(); ?></h1>
						<p><?php the_content(); ?></p>
						<p><a class="button medium" href="<?php echo $postlinkurl ?>"><span><?php echo $readmoretxt; ?></span></a></p><?php	
						echo '</div></div>';
						break;
				}
				endwhile; ?> 
			</div><!-- .slideshow -->
		</div><!-- .sys_slider -->
	</div><!-- .slider_wrapper -->
</div><!-- #featured_slider -->