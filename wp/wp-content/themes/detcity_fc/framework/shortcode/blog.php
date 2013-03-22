<?php

	// Blog page short code
	function sys_blog ($atts, $content = null) {
		extract(shortcode_atts(array(
			'cat'		=> '2',
			'limit'		=> '5',
			'image'		=> 'true',
			'pagination'=> 'true',
			'imgheight'	=> '',
			'charlimits' =>'150',
			'postmeta'		=> '',
			'blogstyle' =>'',
		), $atts));

		$column=3;
		/*
		@parm $blogstyle: blogstyle1,blogstyle2,blogstyle3
		*/
		switch($blogstyle) {

			case 'post1':
				ob_start();
				$out='';
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				query_posts("cat=$cat&posts_per_page=$limit&paged=$paged");
				if (have_posts()) : while (have_posts()) : the_post();
					// post title
					$blogtitle=get_the_title();
					$width="610";
					
					$out.='<div id="post-'.get_the_ID().'" class="' . join( ' ', get_post_class( 'post1', $post_id ) ) . '">';
					$out.='<div class="post_thumb">';
					$out.=get_avatar( get_the_author_meta( 'user_email' ), 50 ); 
					$out.='</div>';
					$out.='<div class="post-info">';
					$out.='<h2 class="entry-title"><a  href="'.get_permalink($post->ID).'" >'.$blogtitle.'</a></h2>';
					
					if($postmeta=="true") {
						$out.=postmetaStyle1(); 
					}
					$out.='<div class="clear"></div>';
					$out.='</div>';
					$out.='<div class="post_content">';
					
					if ($image =="true"){
						$height=$imgheight?$imgheight:200;
						$thumb = get_post_thumbnail_id($post->ID);
						if ($thumb) { 
							$out.='<div class="postimg" style="width:'.$width.'px;height:'.$height.'px;">';
							$out.='<div class="post_slider">'; 
							$out.=getPostAttachments(0, 'full', 'alt="' . $post->post_title . '"',$width,$height);
							$out.='</div>';	
							$out.='</div>';
						} 
					} 
					$out.='<p>'.wp_html_excerpt(get_the_excerpt(''),$charlimits).'</p>'; global $readmoretxt;
					$out.='<a  href="'.get_permalink($post->ID).'" >'.$readmoretxt.' &rarr;</a>'; $out.='</div>';
					$out.='</div><!--.post-->';
				endwhile;
				$out.='<div class="clear"></div>';
				
				if( $pagination == "true") {
					if(function_exists('atp_pagination')) {
						$out.=atp_pagination(); 
					}
				}
				endif;
				$out.= ob_get_contents();
				ob_end_clean();
				wp_reset_query();
			
				return $out;
				break;
			case 'post2':
				ob_start();
					$out='';
					$width="450";
					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
					query_posts("cat=$cat&posts_per_page=$limit&paged=$paged");
					if (have_posts()) :  while (have_posts()) : the_post();
					
						// post title
						$blogtitle=get_the_title();
						$out.='<div id="post-'.get_the_ID().'" class="' . join( ' ', get_post_class( 'post2', $post_id ) ) . '">';
						$out.='<div class="post-info">';
						
						if($postmeta=="true") {
							$out.=postmetaStyle2(); 
						}
						$out.='<div class="clear"></div>';
						$out.='</div>';
						$out.='<div class="post_content">';
						$out.='<h2 class="entry-title"><a  href="'.get_permalink($post->ID).'" >'.$blogtitle.'</a></h2>';

						if ($image =="true"){
							$height=$imgheight?$imgheight:200;
							$thumb = get_post_thumbnail_id($post->ID);
							if ($thumb) { 
								$out.='<div class="postimg" style="width:'.$width.'px;height:'.$height.'px;">';
								$out.='<div class="post_slider">'; 
								$out.=getPostAttachments(0, 'full', 'alt="' . $post->post_title . '"',$width,$height);
								$out.='</div>';	
								$out.='</div>';
							} 
						} 
						$out.='<p>'.wp_html_excerpt(get_the_excerpt(''),$charlimits).'</p>'; global $readmoretxt;
						$out.='<a  href="'.get_permalink($post->ID).'" >'.$readmoretxt.' &rarr;</a>'; $out.='</div>';
						$out.='</div><!-- .post -->';
					endwhile;
					$out.='<div class="clear"></div>';
						
					if( $pagination == "true") {
						if(function_exists('atp_pagination')) { 
							$out.=atp_pagination(); 
						}
					}
				endif;
				$out.= ob_get_contents();
				ob_end_clean();
				wp_reset_query();
				
				return $out;
				break;
			case 'post3':
				$width="170";
				ob_start();
				$out='';
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				query_posts("cat=$cat&posts_per_page=$limit&paged=$paged");
				if (have_posts()) :  while (have_posts()) : the_post();
					$blogtitle=get_the_title();
					$c++;
					$last = ($c == $column && $column != 1) ? 'last ' : '';
					$out.='<div id="post-'.get_the_ID().'" class="' . join( ' ', get_post_class( 'post3 '.$last.'', $post_id ) ) . '">';
					$out.='<div class="post_content">';

					if ($image =="true"){
						$height=$imgheight?$imgheight:200;
						$thumb = get_post_thumbnail_id($post->ID);
						if ($thumb) { 
							$out.='<div class="postimg" style="width:'.$width.'px;height:'.$height.'px;">';
							$out.='<div class="post_slider">'; 
							$out.=getPostAttachments(0, 'full', 'alt="' . $post->post_title . '"',$width,$height);
							$out.='</div>';	
							$out.='</div>';
						} 
					} 
					
					$out.='<div class="post-info">';
					$out.='<h2 class="entry-title"><a href="'.get_permalink($post->ID).'" >'.$blogtitle.'</a></h2>';
					
					if($postmeta=="true") {
						$out.=postmetaStyle3(); 
					}
					$out.='<div class="clear"></div>';
					$out.='</div>';
					$out.='<p>'.wp_html_excerpt(get_the_excerpt(''),$charlimits).'</p>'; global $readmoretxt;
					$out.='<a  href="'.get_permalink($post->ID).'" >'.$readmoretxt.' &rarr;</a>'; $out.='</div>';
					$out.='</div><!-- .post-->';
					
					if($c == $column){
						$c = 0;
						$out.='<div class="divider_line"></div>';
					}
				endwhile;
				$out.='<div class="clear"></div>';
				
				if( $pagination == "true") {
					if(function_exists('atp_pagination')) { 
						$out.=atp_pagination(); 
					}
				}

			endif;
			
			$out.= ob_get_contents();
			ob_end_clean();
			wp_reset_query();

			return $out;
			break;
		} //end switch
	} //end sys_blog function
	add_shortcode('blog','sys_blog');
	
?>