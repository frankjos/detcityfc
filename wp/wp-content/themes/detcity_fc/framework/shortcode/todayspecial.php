<?php

	/**
	 * Todays Specials
	 */

	function menutype_todayspecial ($atts, $content = null,$code) {
	
		global $wp_filter, $post, $wpdb, $wp_query, $permalink ,$post_title , $post_date;

		//variables
		$nopage_str = __('Sorry but we could not find what you were looking for. But don\'\t give up, keep at it','victoria_front');
		$hover_class = ''; //stores class name of the postlink based on postlinktype(image/video/link)

		$the_content_filter= $wp_filter['the_content'];
		extract(shortcode_atts(array(
			'tags'		=> '',
			'limit'	    => '4',
			'readmoretext'	=> '',
			'title'		=> '',
			'pagination' => '',
			'charlimits' => '50',
			'readmore' => '',
			'imgwidth'	=> '100',
			'imgheight'	=> '100',
			'desc'		=> ''
			
		), $atts));

		$out='<div class="today_special">';
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			$query = array(
				'post_type'			=> 'menus', 
				'posts_per_page'	=> $limit, 
				'tag' => $tags,
				'paged'				=> $paged,
				'order'				=> 'DESC'
			);

		query_posts($query); //get the results

		//if have posts, loop through posts
		if(have_posts()) : while(have_posts()) : the_post(); 
			$out.= '<div class="specialslist clearfix"><div class="menu_content">';
			$post_title = get_the_title(get_the_id());
			$permalink = get_permalink(get_the_id());

			//if post has thumbnail,display in lightbox and hovertype icons
			if (has_post_thumbnail()) {
				$width="100";
				$out.='<div class="menuimg">';
				if(get_option('atp_timthumb') =="on") {
					$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), full, false, '' );
					$out.=mu_resize_timthumb($post->ID,$src[0],80,80,'imgborder',''); 
				}else{
					$thumb = get_post_thumbnail_id($post->ID);
					$image = vt_resize( $thumb, '',80, 80, true );
					$out.=vt_thumb($post->ID,$image['url'],$image['width'],$image['height'],'imgborder','');
				}

				//getPostAttachments(0, 'thumbnail', 'alt="' . $post->post_title . '"',$imgwidth,$imgheight);
				//  Link types
				$out.='</div>';	
				//for number of columns - NOT one i.e., 2,3,4 etc
			}
			if($title == "true") {
				$out.='<h5><a href="' .$permalink. '">'. $post_title. '</a></h5>'; 
			}
			if($desc=="true"){	
				$out.='<p>'.wp_html_excerpt(get_the_excerpt(''),$charlimits).'</p>';
			}
			if($readmore == "true"){ 
			$out.='<p class="textright"><a href="'.$permalink.'">'.$readmoretext.'</a></p>';
			}
			$out.='</div></div>';
		endwhile;
		else :
		$out.='<h2>'.$nopage_str.'</h2>';
		endif; 

		$out .='</div><div class="clear"></div>';
		if($pagination == "true"){ 
			$out.=atpmenutypepagination(); 
		} 
		wp_reset_query();
		$wp_filter['the_content'] = $the_content_filter;
		return $out;
	}//end of function

	add_shortcode('todayspecial','menutype_todayspecial'); //add shortcode

	/***
	 * atpmenutypepagination - displays pagination 
	 * @param - int range determines a current page range and displays.
	 * @param - int pages 
	 * @return - string pagination
	 * 
	 */
	function atpmenutypepagination($range =2,$pages = '') { 
		
		global $paged,$wp_query;
		
		$showitems = ($range * 2)+1;       
		if(empty($paged)) $paged = 1;
		if($pages == ''){
			$pages = $wp_query->max_num_pages;
			if(!$pages){
				$pages = 1; 
			}     
		}   

		//if pages more than one
		if(1 != $pages){
			$out='<div class="pagination wp-pagenavi">
					<span class="pages extend">
						Page '.$paged.'  of  '.$pages.
					'</span>';
			if($paged > 2 && $paged > $range+1 && $showitems < $pages) $out.='<a href="'.get_pagenum_link(1).'">&laquo;</a>';
			if($paged > 1 && $showitems < $pages) $out.='<a href="'.get_pagenum_link($paged - 1).'">&lsaquo;</a>';
			for ($i=1; $i <= $pages; $i++){
				if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))  {
					$out.=($paged == $i)? '<span class="current">'.$i.'</span>':'<a href="'.get_pagenum_link($i).'" class="inactive" >'.$i.'</a>';
				}
			}

			if ($paged < $pages && $showitems < $pages) $out.='<a href="'.get_pagenum_link($paged + 1).'">&rsaquo;</a>';  
			if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) $out.='<a href="'.get_pagenum_link($pages).'">&raquo;</a>';
			$out.= '</div>';
		}
		return $out;
	}//end of function atpmenutypepagination
?>