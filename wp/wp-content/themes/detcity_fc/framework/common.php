<?php

	/**
	 * Add Theme Support for 
	 * post thumbnails and automatic feed links
	 */
	add_theme_support('post-thumbnails', array('post', 'page', 'menus', 'slider'));
	add_theme_support('automatic-feed-links');

	/**
	 * function register_my_menus - Registers Menus
	 */

	add_action('init', 'register_my_menus');

	function register_my_menus() {
	   register_nav_menus(array(
			'primarymenu' => __( '<p>Primary Menu <br><small>This will appear on top beside Logo</small></p>' )
		));
	}
	/**
	 * function wp_menu_functon - Prepares navigation menu by passing options to wordpress inbuilt function
	 */
	function wp_menu_function() {
		wp_nav_menu(array(
			'container'     => false, 
			'theme_location'=> 'primarymenu',
			'menu_class'    => 'sf-menu', 
			'echo'          => true, 
			'before'        => '', 
			'after'         => '',
			'link_before'   => '', 
			'link_after'    => '', 
			'depth'         => 0, 
			'walker'        => new description_walker()
			));
		return true;
	}

	/**
	 * Description Walker Class for Custom Menu
	 */
	class description_walker extends Walker_Nav_Menu {
	 function start_el(&$output, $item, $depth, $args){
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="'. esc_attr( $class_names ) . '"';

		$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		$prepend = '';
		$append = '';
		$description  = ! empty( $item->attr_title ) ? '<span class="msubtitle">'.esc_attr( $item->attr_title ).'</span>' : '';

		if($depth != 0){
			 $description = $append = $prepend = "";
		}

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;
		$item_output .= $description.$args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}

	/**
	 * function atp_layout - displays sidebar based on the post id
	 * @param postid - get post id
	 */

	function atp_layout($postid) {
		$sidebaroption=get_post_meta($postid, "sidebar_options", TRUE);
		if($sidebaroption=="fullwidth") { 
			echo 'id="fullwidth"';
		}else{
			echo 'id="main"';
		}
	}

	// Defines custom sidebar widget based on custom option
	$sidebarwidget = get_option('atp_customsidebar');

	/**
	 * function sidebaroption - displays custom sidebar positioning based on the post id
	 * @param - postid - get post id
	 * 'rightsidebar' - Change 'rightsidebar' to 'leftsidebar' if you want to have the default sidebar positioned to left sidebar
	 */
	 
	function sidebaroption($postid) {

		// Get sidebar class and adds sub class to pagemid block layout
		$sidebaroption=get_post_meta($postid, "sidebar_options", TRUE);

		if($postid) {
			if($sidebaroption) {
				echo  $sidebaroption;
			} else {
				echo "rightsidebar"; // rightsidebar/leftsidebar
			}
		}
	}

	/**
	 * function subheadercolor - displays subheader background color based on post id / custom postmeta
	 */
	function subheadercolor($postid) {
		$subheadercolor = get_post_meta($postid, "subheader_bg_color", true);
		if ($subheadercolor != '') { return 'style="background-color: '.$subheadercolor .'"'; }
	}
	/** 
	 * function headercolor - displays header background color based on post id / custom postmeta
	 */
	function headercolor($postid) {
		$headercolor = get_post_meta($postid, "header_bg_color", true);
		if ($headercolor != '') { return 'style="background-color:'.$headercolor.'"'; }
	}

	/**
	* Footer Teaser
	*/

	function footer_teaser_option() {
		$out = '<div class="footer_teaser"><div class="teasercontent">';
		$out .= do_shortcode(get_option('atp_teaser_footer_text'));
		$out .= '</div></div>';
		echo $out;
	}

	/**
	 * function get_custom_options - fetch pages/posts/cats
	 */
	function get_custom_options($type) {
		switch ($type) {
			case 'page':
				$entries = get_pages('title_li=&orderby=name');
				foreach ($entries as $key => $entry) {
					$options[$entry->ID] = $entry->post_title;
				}
				break;
			case 'cat':
				$entries = get_categories('title_li=&orderby=name&hide_empty=0');
				foreach ($entries as $key => $entry) {
					$options[$entry->term_id] = $entry->name;
				}
				break;
			case 'post':
				$entries = get_posts('orderby=title&numberposts=-1&order=ASC');
				foreach ($entries as $key => $entry) {
					$options[$entry->ID] = $entry->post_title;
				}
				break;
			default:
				$options = false;
		}
		return $options;
	}
	/**
	 * function subheaderteaser displays teaser for subheader based on the post meta 
	 * @param postid get post id
	 */

	function subheaderteaser($postid) {
		$radio = get_post_meta($postid, "subheader_teaser_options", true);
		switch ($radio) {
			case 'custom':
				if (is_single()) {
					$page = get_post($postid);
					echo '<div class="subtitle"><h1>Blog</h1></div>';
					if(get_post_meta($postid, "page_desc", true)) {
					echo '<div class="subdesc">' . stripslashes(get_post_meta($postid, "page_desc", true)) .'</div>';
					}
				} else {
					$page = get_post($postid);
					echo '<div class="subtitle"><h1>' . $page->post_title . '</h1></div>';
					if(get_post_meta($postid, "page_desc", true)){
					echo '<div class="subdesc">' . do_shortcode(stripslashes(get_post_meta($postid, "page_desc", true))) . '</div>';
					}
				}
				break;
			case 'customhtml':
				if (is_single()) {
					$cat = get_the_category($post_id);
					$cat_title = $cat[0]->cat_name;
					if(get_post_meta($postid, "page_desc", true)){
					echo '<div class="subtitle"><h1>' . do_shortcode(stripslashes(get_post_meta($postid,"page_desc", true))) . '</h1></div>';
					}
					} else {
					$page = get_post($postid);
					if(get_post_meta($postid, "page_desc", true)){
					echo '<div class="subdesc">' . do_shortcode(stripslashes(get_post_meta($postid,"page_desc", true))) . '</div>';
					}
				}
				break;
			case 'twitter':
				 $twit_username = get_option("atp_teaser_twitter");
				$page = get_post($postid);
				echo '<div class="subtitle"><h1>' . $page->post_title . '</h1></div>';
				if ($twit_username) {
					$twit_count = "1";
					echo parse_cache_feed($twit_username, $twit_count);
				} else {
					echo '<div class="subdesc">Please enter twitter username in Theme options panel general tab.</div>';
				}

				break;
			case 'default':
				if (is_single()) {
					$page = get_post($postid);
					echo '<div class="subtitle"><h1>' . $page->post_title . '</h1></div>';
				} else {
					$page = get_post($postid);
					echo '<div class="subtitle"><h1>' . $page->post_title . '</h1></div>';
				}
				$header_teaser_text = get_option("atp_teaser");
				if ($header_teaser_text == "custom") {
					if(get_option("atp_teaser_custom")) {
					echo '<div class="subdesc"><h3>';
					echo do_shortcode(stripslashes(get_option("atp_teaser_custom")));
					echo '</h3></div>';
					}
				}
				if ($header_teaser_text == "twitter") {
					$usernames = get_option("atp_teaser_twitter");
					if ($usernames) {
						$tcounts = "1";
						echo parse_cache_feed($usernames, $tcounts);
						wp_reset_query();
					} else {
						echo '<div class="subtitle">Please enter twitter username in Theme options panel general tab</div>';
					}
				}
				break;
		}            wp_reset_query();
	}
	/**
	 * Portfolio_Walker class
	 *

	class Portfolio_Walker extends Walker_Category {
		function start_el(&$output, $category, $depth, $args) {
			extract($args);
			$cat_name = esc_attr( $category->name);
			$cat_name = apply_filters( 'list_cats', $cat_name, $category );
			$link = '<a class="'.strtolower(preg_replace('/\s+/', '-', $cat_name)).'" data-value="'.strtolower(preg_replace('/\s+/', '-', $cat_name)).'"  href="#" ';
			if ( $use_desc_for_title == 0 || empty($category->description) )
				$link .= 'title="' . sprintf(__( 'View all posts filed under %s' ), $cat_name) . '"';
			else
				$link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';
				$link .= '>';

			if ( isset($show_count) && $show_count )
				$link .= $cat_name . ' (' . intval($category->count) . ')</a>';
			else
				$link .= $cat_name . '</a>';

			if ( (! empty($feed_image)) || (! empty($feed)) ) {
				$link .= ' ';
				if ( empty($feed_image) )

				$link .= '(';
				$link .= '<a href="' . get_category_feed_link($category->term_id, $feed_type) . '"';

				if ( empty($feed) )
					$alt = ' alt="' . sprintf(__( 'Feed for all posts filed under %s' ), $cat_name ) . '"';
				else {
					$title = ' title="' . $feed . '"';
					$alt = ' alt="' . $feed . '"';
					$name = $feed;
					$link .= $title;
				}

				$link .= '>';
				if ( empty($feed_image) )
					$link .= $name;
				else
					$link .= "<img src='$feed_image'$alt$title" . ' />';
					$link .= '</a>';

				if ( empty($feed_image) )
					$link .= ')';
			}

			if ( isset($show_date) && $show_date ) {
				$link .= ' ' . gmdate('Y-m-d', $category->last_update_timestamp);
			}

			if ( isset($current_category) && $current_category )
			$_current_category = get_category( $current_category );
		
			if ( 'list' == $args['style'] ) {
				$output .= "\t<li class='segment-1'";
				$class = 'cat-item cat-item-'.$category->term_id;
				if ( isset($current_category) && $current_category && ($category->term_id == $current_category) )
					$class .=  ' current-cat';
				elseif ( isset($_current_category) && $_current_category && ($category->term_id == $_current_category->parent) )
					$class .=  ' current-cat-parent';
					$output .=  ' class="'.$class.'"';
					$output .= ">$link\n";
			} else {
				$output .= "\t$link<br />\n";
			}
		}
	}*/
	
	/**
	 * google mage api script enqueue except admin
	 */
	 
	if(!is_admin()) {
		if(get_option('atp_gmapapikey')) {
			function gmapscript(){
				echo '<script type="text/javascript" src="http://maps.google.com/maps?file=api&amp;v=2&amp;key='.get_option('atp_gmapapikey').'"></script>';
				
			}
			add_filter('wp_head','gmapscript');
		}
	}

	/**
	 * function sys_authorinfo displays author avatar and biography
	 */

	function sys_authorinfo(){?>
	<div id="entry-author-info">
		<div class="authorbg_content">
			<div id="author-avatar">
				<?php echo get_avatar(get_the_author_meta('email'), $size = '50', $default = get_template_directory_uri() . '/images/default_avatar_visitor.gif' ); ?>
			</div><!-- #author-avatar -->
			<div id="author-description">
				<h5><em><?php echo get_option('atp_authortxt') ? get_option('atp_authortxt'):'Autor';;?> : </em><?php the_author_posts_link(); ?></h5>
				<p><?php the_author_meta('description'); ?></p>
			</div><!-- #author-description	-->
		</div><!--endauthorbg_content-->
	</div><!-- #entry-author-info -->
	<div class="clear"></div>
	<?php } 
	/**
	 * Function sys_relatedposts
	 * @param postid - post id
	 */
	function sys_relatedposts($postid) {

		//Variables
		global $post, $wpdb;

		$tags = wp_get_post_tags($postid);
		if ($tags) {
			$tag_ids = array();
			foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id; $args=array(
				'tag__in'			=> $tag_ids,
				'post__not_in'		=> array($postid),
				'showposts'			=>4, // Number of related posts that will be shown.
				'ignore_sticky_posts'	=>1
			);
			wp_reset_query();
			$my_query = new wp_query($args);
			if( $my_query->have_posts() ) { 
				$related_post_found = true;
				echo '<div class="singlepostlists"><h3>Related Posts</h3><ul>';
				while ($my_query->have_posts()) {
					$my_query->the_post();
					echo "<li>";
					if (has_post_thumbnail($post->ID) ){
						$thumb = get_post_thumbnail_id($post->ID); 	
						$popular_image = vt_resize( $thumb, '', 120, 70, true );	
					?>
					<a href="<?php echo get_permalink($post->ID); ?>" class="thumb" title="<?php the_title(); ?>">
						<img class="thinframe" src="<?php echo $popular_image['url']; ?>"    width="<?php echo $popular_image['width']; ?>" height="<?php echo $popular_image['height']; ?>" alt="" />
					</a>
					<?php }	else { ?>
					<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="thumb">
						<img class="thinframe" src="<?php echo get_template_directory_uri(); ?>/images/no-image.jpg"  alt="" width="120" height="70" />
					</a>
					<?php } ?>
					<?php // echo '<span class="spdate">'.get_the_date().'</span>'; ?>
					<a href="<?php echo get_permalink($post->ID); ?>" title="<?php the_title(); ?>"> <?php the_title(); ?></a>
				</li>
				<?php
				}
				echo '</ul>';
				echo '</div>';
			}
			
		if(!$related_post_found){
			echo '<div class="singlepostlists"><h3>Related Posts</h3><ul>';
			echo '<p>No Releated Posts</p>';
			echo '</ul></div>';
		}
		wp_reset_query();
		}
		
		
	?>	
	<div class="clear"></div>
	<?php 
	} 
	/**
	 * function postmetaStyle1
	 */

	if ( ! function_exists( 'postmetaStyle1' ) ) :
		function postmetaStyle1() {
			ob_start();

			$out ='<div class="postmeta">'; 
			$out.='<div class="postmetadata">';
			echo 'on <span class="p1date" >';
				the_time(get_option("atp_datetxt")? get_option("atp_datetxt") :"M j, Y"); 
			echo ',</span>&nbsp; ';
			echo get_option('atp_postedin')? get_option('atp_postedin') :'Posted In';?> <?php the_category(', ') ; 
			echo '&nbsp;';
			echo get_option('atp_bytxt')? get_option('atp_bytxt') :'By';?> <?php the_author_posts_link(); 
			echo '&nbsp;&nbsp;/&nbsp;&nbsp;';
			comments_popup_link( __( '0 Comment', 'victoria_front' ), __( '1 Comment', 'victoria_front' ), __( '% Comments', 'victoria_front' ) );
			$out.= ob_get_clean();
			$out.="</div></div>";
			
			return $out;
		} 
	endif;

	/**
	 * function postmetaStyle2
	 */

	if ( ! function_exists( 'postmetaStyle2' ) ) :
		function postmetaStyle2() {
			ob_start();

			$blogtime=get_the_time(get_option("atp_datetxt")? get_option("atp_datetxt") :"M j, Y");
			$blogcat= get_the_category_list(', ');
			$blogauth= get_the_author();
			//$popt=comments_popup_link( __( 'Leave a comment', 'victoria_front' ), __( '1 Comment', 'victoria_front' ), __( '% Comments', 'victoria_front' ) );
			
			$out ='<div class="postmeta">'; 
			$out.='<div class="postmetadata">';
			$out.='<span><img src="'.get_template_directory_uri().'/images/date_micon.png" alt="img" style="vertical-align:middle;" />'.$blogtime.'</span>';
			$out.='<span><img src="'.get_template_directory_uri().'/images/postedin_micon.png" alt="img" style="vertical-align:middle;" />'.$blogcat.' </span>';
			$out.='<span><img src="'.get_template_directory_uri().'/images/author_micon.png" alt="img" style="vertical-align:middle;" />'.$blogauth.'</span>';
			$out.='<span><img src="'.get_template_directory_uri().'/images/comments_micon.png" alt="" style="vertical-align:middle;" />';
				comments_popup_link( __( '0 Comment', 'victoria_front' ), __( '1 Comment', 'victoria_front' ), __( '% Comments', 'victoria_front' ) ).'</span>';
			$out.= ob_get_clean();
			$out.='</div></div>';

			return $out;
		}
	endif;

	/**
	 * function postmetaStyle3
	 */
	if ( ! function_exists( 'postmetaStyle3' ) ) :
		function postmetaStyle3() {
			ob_start();

			$out.='<div class="postmeta">'; 
			$out.='<div class="postmetadata">';
			echo '<span>';
				the_time(get_option("atp_datetxt")? get_option("atp_datetxt") :"M jS, Y");
			echo '</span>  &nbsp; ';
			echo '<span class="comments">';
				comments_popup_link( __( '0 comment', 'victoria_front' ), __( '1 Comment', 'victoria_front' ), __( '% Comments', 'victoria_front' ) );
			$out.=ob_get_clean();
			$out.='</span></div></div>';

			return $out;
		} 
	endif;

	/***
	 * getPostAttachments - displays post attachements 
	 * @param - int post_id - Post ID
	 * @param - string size - thumbnail, medium, large or full
	 * @param - string attributes - thumbnail, medium, large or full
	 * @param - int width - width to which image has be revised to
	 * @param - int height - height to which image has be revised to
	 * @return - string Post Attachments
	 * 
	 */
	 function getPostAttachments($postid=0, $size='thumbnail', $attributes='',$width,$height) { 
		global $post;
			//get the postid
			if ($postid<1) $postid = get_the_ID();
			
			//variables
			$rel = $out = '';
			
			//get the attachments (images)
			$images = get_children(array(
				'post_parent'    => $postid,
				'post_type'      => 'attachment',
				'order'          => 'DESC',
				'numberposts'    => 0,
				'post_mime_type' => 'image'));
				
			//if images exists	, define/determine the relation for lightbox
			if(count($images) >1) { 
				$rel = '"group'.$postid.'"';
			}else{ 
				$rel='""'; 
			}
			$rel = ' rel='.$rel;
			
			//if images exists, loop through and prepare the output
			if($images) {
				//loop through
				foreach($images as $image) {
					$attachment=wp_get_attachment_image_src($image->ID, $size);
					$full_attachment=wp_get_attachment_image_src($image->ID, 'full');
				
					//if timthum option is enabled use it, else use vt_resize/thumb
					if(get_option('atp_timthumb')=="on") {
						$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID),'full', false, '' );
						$out.=mu_resize_timthumb($post->ID,$attachment[0],$width,$height,'imgborder','');
					} else {
						$thumb = get_post_thumbnail_id($id);
						$image = vt_resize( $image->ID,'', $width,$height,true );
						$out.=vt_thumb($post->ID,$image['url'],$image['width'],$image['height'],'imgborder',''); 		
					}//else-if timthumb
				}//loop ends
			} else { //if images does not exists

				//if timthumb option is enabled  use it, else use vt_resize/thumb
				if(get_option(atp_timthumb=="on")) {
					$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), full, false, '' );
					$out.=mu_resize_timthumb($post->ID,$src[0],$width,$height,'imgborder',''); 
				}else{
					$thumb = get_post_thumbnail_id($post->ID);
					$image = vt_resize( $thumb, '', $width, $height, true );
					$out.=vt_thumb($post->ID,$image['url'],$image['width'],$image['height'],'imgborder',''); 

				}
			}// if images exists

		return $out; 
	} 

	/***
	 * atp_getPostLinkURL - generates URL based on link type
	 * @param - string link_type - Type of link 
	 * @return - string URL
	 * 
	 */
	function atp_getPostLinkURL($link_type) {

		global $post;
		
		//use switch to generate URL based on link type
		switch($link_type) {
			case "linkpage":
				return get_page_link(get_post_meta($post->ID, "link_page", true));
				break;
			case "linktocategory":
				return get_category_link(get_post_meta($post->ID, "link_cat", true));
				break;
			case "linktopost":
				return get_permalink(get_post_meta($post->ID, "link_post", true));
				break;
			case "linkmanually":
				return get_post_meta($post->ID, "link_manually", true);
				break;
			case "default":
				return get_permalink($post->ID);
				break;
		}
	}

	/**
	 * Menus Tags List Shortcode 
	 */ 
	
	function to_dayspecial() {
		
		global $post;

		$recentlimits=get_option('atp_today_special_limits')?get_option('atp_today_special_limits'):'6';
		$terms =@implode(",", get_option('atp_today_special_cats'));
		$query = array(
			'post_type'		 => 'menulist', 
			'posts_per_page' => $recentlimits, 
			'taxonomy'		 => 'menu_type', 
			'term'			 => $terms, 
			'orderby'		 => 'date', 
			'order'			 => 'ASC'
		);

		query_posts($query);
		while(have_posts()) : the_post();
		$post_title = get_the_title(get_the_id());
		$todayspecial=get_post_meta(get_the_ID(),'todayspecial',TRUE);
					
		// today special tag shortcode
		if($todayspecial =="on") {
			$out='<h3>'.$post_title.'</h3>';			
			$out.='<div class="recipe_item">';
			$out.='<div class="recipe_img">';
			
			//Get Post thumbnail
			if(get_post_thumbnail_id($post->ID)){
				if(get_option('atp_timthumb')=="on") {
					$width="125"; $height="70";
					$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full', 'false', '' );
					$out.=mu_resize_timthumb($post->ID,$src[0],$width,$height,'imgborder',''); 
				} else {
					$thumb = get_post_thumbnail_id($post->ID);
					$image = vt_resize( $thumb, '', $width,$height, true );
					$out.=vt_thumb($post->ID,$image['url'],$image['width'],$image['height'],'imgborder',''); 
				}
			}
			$out.='</div>';
			
			// Menu item description
			$out.='<div class="recipe_desc">';
			$out.='<p>'.wp_html_excerpt(get_the_excerpt('...'), 200).'</p>';
			$out.='</div>';
			$out.='<div class="recipe_price">';
			$out.=get_post_meta(get_the_ID(),'price',TRUE);									
			$out.='</div>';
			$out.='</div><div class="clear"></div>';
		}

		echo $out;
	endwhile; 
	wp_reset_query(); 
	}

	/**
	 * Display navigation to next/previous pages when applicable
	 */
	function single_content_nav() {
		global $wp_query;

		if ( $wp_query->max_num_pages > 1 ) :
			if($atp_singlenavigation) { ?>
				<div id="nav-below" class="navigation">
					<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '', 'Previous post link', 'victoria_front' ) . '</span> %title' ); ?></div>
					<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '', 'Next post link', 'victoria_front' ) . '</span>' ); ?></div>
				</div>
		<?php 
			} 
		endif;
	}
?>