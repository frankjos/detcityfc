<?php

	/**
	 * Popular Posts
	 */
	function sys_popular_posts ($atts, $content = null) {
		extract(shortcode_atts(array(
			'limit'	=> '2',
			'thumb'	=>'true',
		), $atts));

		$out = '<div class="widget_postslist sc">';
		$out .= '<ul>';

		global $wpdb;
		
		$popular_limits=$limit;
		$show_pass_post = false; $duration='';
		$request = "SELECT ID, post_title,post_date, COUNT($wpdb->comments.comment_post_ID) AS 'comment_count' FROM $wpdb->posts, $wpdb->comments";
		$request .= " WHERE comment_approved = '1' AND $wpdb->posts.ID=$wpdb->comments.comment_post_ID AND post_status = 'publish'";
		if(!$show_pass_post) $request .= " AND post_password =''";
		if($duration !="") {
			$request .= " AND DATE_SUB(CURDATE(),INTERVAL ".$duration." DAY) < post_date ";
		}
		$request .= " GROUP BY $wpdb->comments.comment_post_ID ORDER BY comment_count DESC LIMIT $popular_limits";
		$popular_posts = $wpdb->get_results($request);
			
		foreach($popular_posts as $post) {
			if($post) {
				$out .= "<li>";
				$popular_image = get_post_meta($post->ID, 'post_image', true);
				$post_date = $post->post_date;
				$post_date = mysql2date('F j, Y', $post_date, false);
				if($thumb == "true"){
					$out .= '<a class="thumb" href="'.get_permalink($post->ID).'" title="'.$post->post_title.'">';
					$thumbs = get_post_thumbnail_id($post->ID);
					if($thumbs){
						$popular_image = vt_resize( $thumbs, '', 50, 50, true );
						$out .= '<img class="img_border" src="'. $popular_image['url'].'" title="'.$post->post_title.'"  alt="" width="'. $popular_image['width'].'" height="'.$popular_image['height'].'" />';
						$out .= '</a>';
					}else{
						$out .= '<a class="thumb" href="'.get_permalink($post->ID).'" title="'.$post->post_title.'">';
						$out .= '<img class="img_border" src="'. get_template_directory_uri().'/images/no-image.jpg" title="'.$post->post_title.'"  alt="" width="'. $popular_image['width'].'" height="'.$popular_image['height'].'" />';
						$out .= '</a>';
					}
				}
				$out .= '<span class="title"><a  href="' .get_permalink($post->ID). '" rel="bookmark">' .$post->post_title. '</a></span><br/>';
				$out .=	'<span class="wpldate">'.$post_date.'</span>';
				$out .="</li>";
			}
		}
		$out .= '</ul></div>';
		
		return $out;
		wp_reset_query();
	}
	add_shortcode('popularpost','sys_popular_posts');
?>