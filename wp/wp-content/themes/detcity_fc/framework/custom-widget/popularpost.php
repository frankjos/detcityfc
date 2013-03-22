<?php
/**
 * Plugin Name: Popular Posts Widget
 * Description: A widget used for displaying Popular Posts.
 * Version: 1.0
 * Author: Fem Khan
 * Author URI: http://www.aivahthemes.com
 *
 */
	// Reset query 
	wp_reset_query();
	
	// Register Widget 
	function popular_widgets() {
		register_widget( 'popular_widgets' );
	}
	
	// Define the Widget as an extension of WP_Widget
	class popular_widgets extends WP_Widget {
		/* constructor */
		function popular_widgets() {
			
			global $theme_name;
			/* Widget settings. */
			$widget_ops = array(
				'classname'		=> 'popular_widget',
				'description'	=> __('Use this widget to display Popular Posts by tags, Thumbnail Enable/Disable.', 'atp_admin')
			);

			/* Widget control settings. */
			$control_ops = array(
				'width'		=> 300,
				'height'	=> 350,
				'id_base'	=> 'popular_widget'
			);

			/* Create the widget. */
			$this->WP_Widget( 'popular_widget',$theme_name.' - Popular Posts', $widget_ops, $control_ops );
		}

		// outputs the content of the widget
		function widget( $args, $instance ) {
			extract( $args );
		
			/* Our variables from the widget settings. */
			$popular_imagedisable = $instance['popular_imagedisable'];
			$popular_limits = $instance['popular_limits'];
			$popular_title = $instance['popular_title'];
			$popular_select = $instance['popular_select'];
			$popular_description_length = $instance['popular_description_length'];
			if($popular_title =='') { $popular_title = "Popular Posts"; };
			$sys_subtitle = $instance['sys_subtitle'];
			if($sys_subtitle !=''){
				$subtitle = '<span class="widget-subtitle">'.$sys_subtitle.'</span>';
			}
			$before_title	='<h3 class="widget-title">';
			$after_title	=$subtitle.'</h3>';
			$before_widget	='<div id="popular_post_widget" class="syswidget widget_postslist clearfix">';
			$after_widget	='</div>';

			/* Before widget (defined by themes). */
			echo $before_widget;
			/* Title of widget (before and after defined by themes). */
			echo $before_title.$popular_title.$after_title;

			global $post, $wpdb;

			$show_pass_post = false; $duration='';
			$request = "SELECT ID, post_title,post_date,post_content, COUNT($wpdb->comments.comment_post_ID) AS 'comment_count' FROM $wpdb->posts, $wpdb->comments";
			$request .= " WHERE comment_approved = '1' AND $wpdb->posts.ID=$wpdb->comments.comment_post_ID AND post_status = 'publish'";
			if(!$show_pass_post) $request .= " AND post_password =''";
			if($duration !="") {
				$request .= " AND DATE_SUB(CURDATE(),INTERVAL ".$duration." DAY) < post_date ";
			}
			$request .= " GROUP BY $wpdb->comments.comment_post_ID ORDER BY comment_count DESC LIMIT $popular_limits";
			$popular_posts = $wpdb->get_results($request);
			echo "<ul>";
			foreach($popular_posts as $post) {
				if($post){
					echo "<li>";
					$post_date = $post->post_date;
					$post_date = mysql2date('F j, Y', $post_date, false);
					$post_content=wp_html_excerpt($post->post_content,$popular_description_length);
					if($popular_imagedisable != "true") {
						$thumb = get_post_thumbnail_id($post->ID); 
						if ($thumb ) {
							$popular_image = vt_resize( $thumb, '', 60, 40, true );	?>
							<div class="thumb">
								<a href="<?php echo get_permalink($post->ID); ?>" title="<?php echo $post->post_title ?>">
								<img class="img_border" src="<?php echo $popular_image['url']; ?>" title="<?php echo $post->post_title ?>" alt="" width="<?php echo $popular_image['width']; ?>" height="<?php echo $popular_image['height']; ?>" />
								</a>
						<?php 
						}else{ 
							echo '<div class="thumb"><a href="'.get_permalink($post->ID).'" title="'. $post->post_title.'"><img class="img_border" src="'.get_template_directory_uri().'/images/no-image.jpg'.'" width="60" height="40" alt="' .$post->post_title. '"/></a>';	
						}
						echo'</div>';
					}?>	
					<div class="pdesc">
						<a class="title" href="<?php echo get_permalink($post->ID); ?>" title="<?php echo $post->post_title ?>">
						<?php echo $post->post_title ?></a>
						<?php if($popular_select == 'time'):?>
						<div class="w-postmeta">
						<span class="sep"><?php echo $post_date; ?></span>
						<?php else:?>
						<p><?php echo $post_content; ?>...</p>
						<?php endif;//end Description Length ?>
						</div>
					<?php echo "</li>";
				}
			}
			echo "</ul>"; 
			/* After widget (defined by themes). */
			echo $after_widget;		
		}

		//processes widget options to be saved
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			/* Strip tags for title and name to remove HTML (important for text inputs). */
			$instance['popular_title'] = strip_tags( $new_instance['popular_title'] );
			$instance['popular_imagedisable'] = strip_tags( $new_instance['popular_imagedisable'] );
			$instance['popular_limits'] = strip_tags( $new_instance['popular_limits'] );
			$instance['popular_select'] = strip_tags( $new_instance['popular_select'] );
			$instance['popular_description_length'] = strip_tags( $new_instance['popular_description_length'] );
			$instance['sys_subtitle'] = strip_tags( $new_instance['sys_subtitle'] );
			
			return $instance;
		}

		// outputs the options form on admin
		function form( $instance ) {
			/* Set up some default widget settings. */
			$popular_select = isset( $instance['popular_select'] ) ? $instance['popular_select'] : 'time';
			if ( !isset($instance['popular_description_length']) || !$popular_description_length = (int) $instance['popular_description_length'] )
			$popular_description_length = 60;
			if ( !isset($instance['popular_limits']) || !$popular_limits = (int) $instance['popular_limits'] )
				$popular_limits = 3;
				$sys_subtitle= strip_tags($instance['sys_subtitle']);
			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'popular_title' ); ?>"><?php _e('Title:', 'atp_admin'); ?></label>
				<input id="<?php echo $this->get_field_id( 'popular_title' ); ?>" name="<?php echo $this->get_field_name( 'popular_title' ); ?>" value="<?php echo $instance['popular_title']; ?>" type="text" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'sys_subtitle' ); ?>"><?php _e('Widget Sub Title:', 'example'); ?></label>
				<input type="text" id="<?php echo $this->get_field_id( 'sys_subtitle' ); ?>" name="<?php echo $this->get_field_name( 'sys_subtitle' ); ?>" value="<?php echo $sys_subtitle; ?>" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'popular_select' ); ?>"><?php _e('Extra Information:', 'atp_admin'); ?></label>
				<select id="<?php echo $this->get_field_id( 'popular_select' ); ?>" name="<?php echo $this->get_field_name( 'popular_select' ); ?>">
					<option value="time" <?php selected($popular_select,'time');?>>Time</option>
					<option value="description" <?php selected($popular_select,'description');?>>Description</option>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'popular_description_length' ); ?>"><?php _e('Length of Description to show::', 'atp_admin'); ?></label>
				<input type="text" id="<?php echo $this->get_field_id( 'popular_description_length' ); ?>" name="<?php echo $this->get_field_name( 'popular_description_length' ); ?>" value="<?php echo $popular_description_length; ?>" size="3" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'popular_limits' ); ?>"><?php _e('Number of posts to show:', 'atp_admin'); ?></label>
				<input type="text" id="<?php echo $this->get_field_id( 'popular_limits' ); ?>" name="<?php echo $this->get_field_name( 'popular_limits' ); ?>" value="<?php echo $popular_limits; ?>" size="3" />
			</p>
			<p>
				<input type="checkbox" value="true" id="<?php echo $this->get_field_id( 'popular_imagedisable' ); ?>" name="<?php echo $this->get_field_name( 'popular_imagedisable' ); ?>" <?php  if( $instance['popular_imagedisable']=="true") { echo "checked"; } ?> class="checkbox" /> <label for="<?php echo $this->get_field_id( 'popular_imagedisable' ); ?>"><?php _e('Disable Post Thumbnail?', 'atp_admin'); ?></label>
			</p>
		<?php 
		} 
	}
	/* Add our function to the widgets_init hook. */
	add_action( 'widgets_init', 'popular_widgets' );
	
	wp_reset_query();
?>