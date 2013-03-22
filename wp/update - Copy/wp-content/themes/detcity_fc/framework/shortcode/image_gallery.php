<?php

	/**
	 * Galleria
	 */
	function sys_galleria($atts, $content = null) {
		extract(shortcode_atts(array(
			'id'		=> '1',
			'width'		=> '600',
			'height'	=>'450',
			'autoplay'	=> '4000',
			'transition'=> 'fade',
		), $atts));
		
		wp_print_scripts('atp-jgalleria');
		wp_print_scripts('atp-jgclassic');
		sys_gal_scripts($height,$autoplay,$width,$id);
		
		global $post;
		$pid = $post->ID;
		
		$out =  '<div id="gal_content">';
		$id = intval($id);
		$attachments = get_children("post_parent=$post->ID&post_type=attachment&post_mime_type=image&orderby=menu_order ASC, ID ASC");	
	
		$out .=  '<div id="galleria'.$id.'" style="width:' .$width. 'px; height:' .$height. 'px;">';
		foreach ( $attachments as $id => $attachment ) {
			
			// Attachment page ID
			$att_page = get_attachment_link($id);
			// Returns array
			$img = wp_get_attachment_image_src($id,'full');
			$img = $img[0];
			$thumb = wp_get_attachment_image_src($id, 'thumbnail');
			$thumb = $thumb[0];
			$image = vt_resize('',$img, $width, $height,true);
			$thumbnail = vt_resize('',$thumb,80,50,true);
			$out .= '<div><a href="'.get_template_directory_uri().'/timthumb.php?src=' .mu_dyn_getimagepath($img). '&amp;w=' .$width. '&amp;h=' .$height. '&amp;zc=1&amp;q=100" >';	
			$out.='<img src="'.$thumbnail['url'].'"   width="'.$image['width'].'" height="'.$image['height'].'" />';
			$out.='</a></div>';
		}
		$out .=  '</div>';
		$out .=  '</div>';
		
		return $out;
	}
	add_shortcode('galleria','sys_galleria');

	/**
	 * Galleria Script function
	 */
	function sys_gal_scripts($height,$autoplay,$width,$id) {
		echo '<script type="text/javascript">
		/* <![CDATA[ */
		jQuery(document).ready(function($) {
			$("#galleria'.$id.'").galleria({
				transition: "fade",
				autoplay:'.$autoplay.',
				height:'.$height.',
				image_crop: true
			});
		});	
		/* ]]> */
		</script>';
	}
	
	/**
	 * Galleria External URL Based
	 */
	 function sys_urlgalleria($atts, $content = null) {
		extract(shortcode_atts(array(
			'id'		=> '21',
			'width'		=> '600',
			'height'	=>'450',
			'autoplay'	=> '4000',
			'transition'=> 'fade',
		), $atts));
		
		wp_print_scripts('atp-jgalleria');
		wp_print_scripts('atp-jgclassic');
		sys_urlgal_scripts($height,$autoplay,$width,$id);
		
		global $post;
		
		$out =  '<div id="gal_content">';
		if(preg_match_all('!http://.+\.(?:jpe?g|png|gif)!Ui',$content,$matches)){
			$out .=  '<div id="galleria'.$id.'" style="width:' .$width. 'px; height:' .$height. 'px;">';
			foreach ($matches[0] as $images) {
				$image = vt_resize('',$images, $width, $height, true );
				$thumbnail = vt_resize('',$images, 80, 50, true );
				$out .= '<div><a href="'.get_template_directory_uri().'/timthumb.php?src=' .mu_dyn_getimagepath($images). '&amp;w=' .$width. '&amp;h=' .$height. '&amp;zc=1&amp;q=100" >';	
				$out.='<img src="'.$thumbnail['url'].'"   width="'.$thumbnail['width'].'" height="'.$thumbnail['height'].'" />';
				$out.='</a></div>';
			}
			$out .=  '</div>';
		}
		$out .=  '</div>';
		
		return $out;
	}
	add_shortcode('galleriaurl','sys_urlgalleria');

	/**
	 * Galleria External Images
	 */
	function sys_urlgal_scripts($height,$autoplay,$width,$id) {
		echo '<script type="text/javascript">
		/* <![CDATA[ */
		jQuery(document).ready(function($) {
			$("#galleria'.$id.'").galleria({
				transition: "fade",
				autoplay:'.$autoplay.',
				height:'.$height.',
				image_crop: true
			});
		});	
		/* ]]> */
		</script>';
	}

	/**
	 * sys Mini Gallery
	 */
	 function sys_images_mini_gallery( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'alt'		=> '',
			'images'	=> '',
			'class'		=> '',
			'width'		=>'',
			'height'	=>'',
		), $atts));

		global $atp_timthumb;
		
		if(preg_match_all('!http://.+\.(?:jpe?g|png|gif)!Ui',$content,$matches)){
			$out='<ul class="sys_mini_gallery">';
			foreach ($matches[0] as $images) {
				$out .= '<li><div class="portimg"><div class="porthumb" style="height:'.$height.'px;"><a class="lightbox" rel="group1" href="' .$images. '" >';
					if($atp_timthumb=="on") {
									$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), full, false, '' );
									/**
									 * MU
									 */
									//echo '<img alt="'.$alt.'" '.$class.' '.$title.'  src="'.get_template_directory_uri().'/timthumb.php?src='.mu_dyn_getimagepath($src[0]).'&amp;w=960&amp;h=386&amp;zc=1&amp;q=100"   />';
									//$out .='<img class="image '.$class.'"   src="'.get_template_directory_uri().'/timthumb.php?src='.$images.'&amp;w='.$width.'&amp;h='.$height.'&amp;zc=1&amp;q=100"   />';
	
									$out.= mu_resize_timthumb($post->ID,$images,$width,$height,$class,''); 
								}else{
									$thumb = get_post_thumbnail_id($post->ID);
									$image = vt_resize( '', $images,$width, $height, true );
									$out .=vt_thumb($post->ID,$image['url'],$width,$height,$class,'');
								}
				$out.='</a></div></div>';
				$out.='</li>';
			}
			$out .='</ul><div class="clear"></div>';
		}
		return $out;
	}
	add_shortcode('minigallery', 'sys_images_mini_gallery');

	/**
	 * Image Shortcode Function
	 */
	function sys_image($atts, $content = null, $code) {
		extract(shortcode_atts(array(
			'link'		=> '#',
			'lightbox'	=> 'false',
			'title'		=> '',
			'class'		=> '',
			'align'		=> false,
			'width'		=> false,
			'height'	=> false,
			'target'	=>'',
			'src'		=> '',
		), $atts));
		
		global $atp_timthumb;
		
		if(!$width||!$height){
			if(!$width){
				$width = '150';
			}
			if(!$height){
				$height = '150';
			}
		}
		
		$src = do_shortcode($content);
		$no_link = '';
		if($lightbox == 'true'){
			$rel = ' rel="group1"';
			$rel .= ' class="lightbox"';
			$link = $link;
		}else{
			if($link == '#'){$no_link = 'image_no_link';}
			$atarget = ' target='.$target.'';
		}
	
		if($atp_timthumb=="on") {
			$content=mu_resize_timthumb('',$src,$width,$height,$class,''); 
		}else{
			$image = vt_resize('', $src,$width,$height, true );
			$content=vt_thumb('',$image['url'],$image['width'],$image['height'],$class,''); 
		}
		
		if($lightbox=="true") { $link=$src; }
		$out.='<div class="portimg '.($align?' align'.$align:'').'" style="width:'.$width.'px;'.((empty($height))?'':'height:'.$height.'px').'">';
		$out.='<div class="porthumb"><a  '.$atarget.''.$rel.' '.($no_link? ' class="'.$no_link.'"':'').' title="'.$title.'" href="'.$link.'">' . $content . '</a></div>';
		$out.='</div>';
		
		return $out;
	}
	add_shortcode('image', 'sys_image');

	/**
	 * Photo Frame
	 */

	function sys_photoframe( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'alt'	=> '',
			'align'	=> '',
			'class'	=> '',
			'src'	=> '',
			'width'	=>'100',
			'height'=>'100',
		), $atts));
		
		$out .= '<div class="photo_frame '.($align?' align'.$align:'').'" >';
		$out .= '<img src="' .$src. '" width="'.$width.'" height="'.$height.'" class="image '.$class.'" />';
		$out .= '</div>';
		
		return $out;
	}
	add_shortcode('photoframe', 'sys_photoframe');
?>