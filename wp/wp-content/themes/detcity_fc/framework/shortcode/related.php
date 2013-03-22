<?php

	/**
	 * Related Posts
	 */

	function sys_related_posts( $atts ) {
		extract(shortcode_atts(array(
			'limit'	=> '5',
			'thumb'	=>'true',
		), $atts));
		
		global $wpdb, $post, $table_prefix;

		if ($post->ID) {
			$out = '<div class="widget_postslist sc"><ul>';
	 
			// Get tags
			$tags = wp_get_post_tags($post->ID);
			$tagsarray = array();
			foreach ($tags as $tag) {
				$tagsarray[] = $tag->term_id;
			}
			$tagslist = implode(',', $tagsarray);
	 
			// Do the query
			$q = "
				SELECT p.*, count(tr.object_id) as count
				FROM $wpdb->term_taxonomy AS tt, $wpdb->term_relationships AS tr, $wpdb->posts AS p
				WHERE tt.taxonomy ='post_tag'
					AND tt.term_taxonomy_id = tr.term_taxonomy_id
					AND tr.object_id  = p.ID
					AND tt.term_id IN ($tagslist)
					AND p.ID != $post->ID
					AND p.post_status = 'publish'
					AND p.post_date_gmt < NOW()
				GROUP BY tr.object_id
				ORDER BY count DESC, p.post_date_gmt DESC
				LIMIT $limit;";
			$related = $wpdb->get_results($q);
			if ( $related ) {
				foreach($related as $r) {
					$post_date = $r->post_date;
					$post_date = mysql2date('F j, Y', $post_date, false);
					$out .= "<li>"; 
					if(preg_match_all('!.+\.(?:jpe?g|png|gif)!Ui',get_post_meta($r->ID, 'post_image', true), $matches)) {
						$popular_image = get_post_meta($r->ID, 'post_image', true);
					}
					if($thumb == "true"){
						$out .= '<a class="thumb" href="'.et_permalink($r->ID).'" title="'.$r->post_title.'">';
						$thumbs = get_post_thumbnail_id($post->ID);
						if ($thumbs){
							$image = vt_resize( $thumbs, '',50,50, true );
							$out .= '<img class="thinframe" src="'.$image[url].'" width="'.$image['width'].'" height="'.$image['height'].'   alt="' .$post->post_title. '"/>';	
						}else{
							$out .= '<img class="thinframe" src="'.get_template_directory_uri().'/images/no-image.jpg'.'" width="50" height="50" alt="' .$r->post_title. '"/>';	
						}
						$out .= '</a>';
					}
					
					$out .= '<span class="title"><a  href="' .get_permalink($r->ID). '" rel="bookmark">' .$r->post_title. '</a></span><br/>';
					$out.=$post_date;	
					$out .="</li>";	
				}
			}
			else
			{
				$myposts = get_posts("numberposts=$limit&offset=1");
				foreach($myposts as $post) {
					$out .= "<li>"; 
					$popular_image = get_post_meta($post->ID, 'post_image', true);
					$post_date = $post->post_date;
					$post_date = mysql2date('F j, Y', $post_date, false);
					if($thumb == "true"){
						if (has_post_thumbnail($post->ID) ){
							$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', true);
							$out .= '<a class="thumb" href="' .get_permalink($post->ID). '" title="' .$post->post_title. '">';
							$thumb = get_post_thumbnail_id($post->ID);
							$popular_image = vt_resize( $thumb, '', 40, 40, true );
							$out .= '<img class="thinframe"  src="'. $popular_image[url].'"  alt="' .$post->post_title. '"/></a>'; 
						}else{
							$out .= '<a class="thumb" href="' .get_permalink($post->ID). '" title="' .$post->post_title. '">'; 
							$out .= '<img class="thinframe" src="'.get_template_directory_uri().'/images/no-image.jpg'.'" width="40" height="40" alt="' .$post->post_title. '"/></a>';	
						}
					} 
					$out .= '<span class="title"><a  href="' .get_permalink($post->ID). '" rel="bookmark">' .$post->post_title. '</a></span><br />';
					$out.=$post_date;	
					$out .="</li>";
				}
			}
			$out .= '</ul></div>';
			
			return $out;
		}
		wp_reset_query();
	}
	add_shortcode('related_posts', 'sys_related_posts');
?>