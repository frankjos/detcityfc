<?php
	/**
	 * Nivo Slider
	 */
	function sys_nivoslider($atts, $content = null) {
		extract(shortcode_atts(array(
			'id'		=> '1',
			'width'		=> '630',
			'height'	=>'350',
			'pausetime'	=> '4000',
			'effect'	=> 'fade',
			'speed'		=> 'fade',
			'limits'	=> '',
			'navigation'=> 'true',
			'cat'		=>'',
		), $atts));
		
		wp_print_scripts('atp-nivoslide');
		$id=rand(1,200);
		sys_nivo_scripts($height,$speed,$width,$id,$effect,$pausetime,$navigation);
		$out= '<div id="atpslideshow'.$id.'" style="width:' .$width. 'px; height:' .$height. 'px;" class="nivoSlider">';
		if($cat) {
			$loop = new WP_Query(array( 'cat' => $cat, 'posts_per_page' =>$limits));
		}
		if($cat==""){  
			$loop = new WP_Query(array(
				'post_type'	=> 'slider'
			));
		}
		
		while ($loop->have_posts()) : $loop->the_post(); 
		
		global $post;

			$id = intval($loop->ID);
			$attachments = get_children("post_parent=$post->ID&post_type=attachment&post_mime_type=image&numberposts=$limits&orderby=menu_order ASC, ID ASC");	
			
			foreach ( $attachments as $id => $attachment ) {
		
				// Attachment page ID
				$att_page = get_attachment_link($id);
				// Returns array
				$img = wp_get_attachment_image_src($id, 'full');
				$img = $img[0];
				$thumb = wp_get_attachment_image_src($id, 'thumbnail');
				$thumb = $thumb[0];
			
				$atp_timthumb=get_option('atp_timthumb');
				if($atp_timthumb=="on") {
					$src = wp_get_attachment_image_src( get_post_thumbnail_id($id), full, false, '' );
					$out.=mu_resize_timthumb('',$img,$width,$height,'',''); 
				}else{
					$thumb = get_post_thumbnail_id($id);
					$image = vt_resize('', $img,$width,$height, true );
					$out.=vt_thumb('',$image['url'],$image['width'],$image['height'],img-border,''); 
				}
			}
			
		endwhile;
		wp_reset_query();
		$out.='</div>';
	
		return $out;
	}
	add_shortcode('slider','sys_nivoslider');

	// Nivo DOM
	function sys_nivo_scripts($height,$speed,$width,$id,$effect,$pausetime,$navigation) { ?>
		<style type="text/css">
		#atpslideshow<?php echo $id; ?> {
			position:relative;
			width:<?php echo $width; ?>px;
			height:<?php echo $height; ?>px;
			margin-bottom:15px;
			background:url('<?php echo get_template_directory_uri();?>/ajax-loader.gif') no-repeat 50% 50%;
		}
		</style>
		<?php

		echo'<script type="text/javascript">
		/* <![CDATA[ */
			jQuery(document).ready(function() {
				jQuery(window).load(function() {
					jQuery("#atpslideshow'.$id.'").nivoSlider({
						effect:"'.$effect.'",
						slices:10, // For slice animations
						boxCols: 8, // For box animations
						boxRows: 4, // For box animations
						animSpeed:'.$speed.',
						pauseTime:'.$pausetime.',
						directionNav:false, //Next and Prev
						directionNavHide:false, // Only show on hover
						controlNav:'.$navigation.'
					});
				});
			});
		/* ]]> */
		</script>';
	}

	/**
	 * Nivo Post Slider
	 */

	function post_nivoslider($atts, $content = null) {
		extract(shortcode_atts(array(
			'id'		=> '1',
			'width'		=> '300',
			'height'	=>'150',
			'pausetime'	=> '4000',
			'effect'	=> 'fade',
			'speed'		=> '500',
			'limits'	=> '',
			'navigation'=> 'true',
			'cat'		=>'',
		), $atts));
		wp_print_scripts('atp-nivoslide');
		$id = rand(20,200);
		post_nivo_scripts($height,$speed,$width,$id,$effect,$pausetime,$navigation);
		$out ='<div id="atpslideshow'.$id.'" style="width:' .$width. 'px; height:' .$height. 'px;" class="nivoSlider">';
		
		global $post;
		$pid = $post->ID;
		$attachments = get_children("post_parent=$post->ID&post_type=attachment&post_mime_type=image&numberposts=$limits&orderby=menu_order ASC, ID ASC");	
		
		foreach ( $attachments as $id => $attachment ) {
		
			// Attachment page ID
			$att_page = get_attachment_link($id);
			// Returns array
			$img = wp_get_attachment_image_src($id, 'full');
			$img = $img[0];
			$thumb = wp_get_attachment_image_src($id, 'thumbnail');
			$thumb = $thumb[0];
			$atp_timthumb=get_option('atp_timthumb');
			if($atp_timthumb=="on") {
				$src = wp_get_attachment_image_src( get_post_thumbnail_id($id), full, false, '' );
				$out.=mu_resize_timthumb('',$img,$width,$height,'',''); 
			}else{
				$thumb = get_post_thumbnail_id($id);
				$image = vt_resize('', $img,$width,$height, true );
				$out.=vt_thumb('',$image['url'],$image['width'],$image['height'],img-border,''); 
			}
		}
		$out.='</div>';

		return $out;
		wp_reset_query();
	}
	add_shortcode('postslider','post_nivoslider');

	//Nivo DOM
	function post_nivo_scripts($height,$speed,$width,$id,$effect,$pausetime,$navigation) {?>
	<style type="text/css">
		#atpslideshow<?php echo $id; ?> {
			position:relative;
			width:<?php echo $width; ?>px;
			height:<?php echo $height; ?>px;
			margin-bottom:15px;
			background:url('<?php echo get_template_directory_uri();?>/ajax-loader.gif') no-repeat 50% 50%;
		}
		</style>
		<?php
		echo'<script type="text/javascript">
		/* <![CDATA[ */
		jQuery(document).ready(function() {
			jQuery(window).load(function() {
				jQuery("#atpslideshow'.$id.'").nivoSlider( {
					effect:"'.$effect.'",
					slices:10, // For slice animations
					boxCols: 8, // For box animations
					boxRows: 4, // For box animations
					animSpeed:'.$speed.',
					pauseTime:'.$pausetime.',
					directionNav:false, // Only show on hover
					directionNavHide:true, // Only show on hover
					controlNav:'.$navigation.'
				});
			});
		});
		</script>';
	}
?>