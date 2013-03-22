<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/css/carousel-slider.css"/>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.contentcarousel.js"></script>
<script type="text/javascript">
jQuery(document).ready(function($) {
	$('#ca-container').contentcarousel();
});
</script>
<?php $args = array('post_type' => 'menus'); ?>
	<div id="featured_slider">
		<div class="slider_wrapper">
			<div id="ca-container" class="ca-container">
				<div class="ca-wrapper">
				<?php $i=1; $k=4;
				
					$query = new WP_Query( $args );
					while ($query->have_posts()) : $query->the_post();
					$post_title = get_the_title($post->ID);
					global $readmoretxt, $more; $more = 0; 
					$item_desc=do_shortcode(get_post_meta($post->ID,'item_desc',true));
					$out='<div class="ca-item ca-item'.$i.'">';	
					$out.='<div class="ca-item-main">';

					if(get_option('atp_timthumb')=="on") {
						$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID),'medium','false','' );
						$out.= mu_resize_timthumb($post->ID,$src[0],316,220,'',''); 
					}else{
						$thumb = get_post_thumbnail_id($post->ID);
						$image = vt_resize( $thumb, '', 316, 220, true );
						$out.= vt_thumb($post->ID,$image['url'],$image['width'],$image['height'],'','');
					}
					$out.='<div class="item_title">';
					$out.='<h3>'.$post_title.'</h3>';
					$out.='<div class="item_desc">'.substr($item_desc,0,150).'</div>';	
					$out.='<span class="price">'.get_post_meta($post->ID,'price',TRUE).'</span>';
					$out.='</div>';
					$out.='<a href="#" class="ca-more">&rarr;</a>';
					$out.='</div>';
					$out.='<div class="ca-content-wrapper">';
					$out.='<div class="ca-content">';
					$out.='<h2>'.$post_title.'</h2>';
					$out.='<p>'.get_the_content($readmoretxt).'</p>';
					$out.='</div>';
					$out.='<a href="#" class="ca-close">x</a>';
					$out.='</div>';
					$out.='</div>';
					echo $out;
					
					$i++; $k--; endwhile; ?>
				</div><!-- .ca-wrapper-->
			</div><!-- #ca-container-->
		</div><!-- #slider_wrapper-->

	</div><!-- #featured_slider -->