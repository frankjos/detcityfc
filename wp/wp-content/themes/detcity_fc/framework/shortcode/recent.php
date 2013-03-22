<?php

	/**
	 * Recent Pots
	 */
	function sys_recent_posts ($atts, $content = null) {
		extract(shortcode_atts(array(
			'limit'		=> '2',
			'cat_id'	=>'5',
			'thumb'		=>'true',
		), $atts));

		$out .= '<div class="widget_postslist sc">';
		$out .= '<ul>';

		global $post, $wpdb;
		
		$myposts = get_posts("numberposts=$limit&offset=0&cat=$cat_id");
		foreach($myposts as $post) {
			$out .= "<li>";
			$post_date = $post->post_date;
			$post_date = mysql2date('F j, Y', $post_date, false);
			if($thumb == "true"){
				$out .= '<a class="thumb" href="'.get_permalink($post->ID).'" title="'.$post->post_title.'">';
				$thumbs = get_post_thumbnail_id($post->ID);
				if ($thumbs){	
					$image = vt_resize( $thumbs, '', 50,50, true );
					$out .= '<img class="thinframe" src="'.$image[url].'" width="'.$image['width'].'" height="'.$image['height'].'   alt="' .$post->post_title. '"/>';
				}else{
					$out .= '<img class="thinframe" src="'.get_template_directory_uri().'/images/no-image.jpg'.'" width="50" height="50" alt="' .$post->post_title. '"/>';	
				}
				$out .= '</a>';
			}
			$out .= '<span class="title"><a  href="' .get_permalink($post->ID). '" rel="bookmark">' .$post->post_title. '</a></span><br/>';
			$out.=	'<span class="wpldate">'.$post_date.'</span>';	
			$out .="</li>";
		}
		$out .= '</ul></div>';
		
		return $out;
		wp_reset_query();
	}
	add_shortcode('recentpost','sys_recent_posts');
?>