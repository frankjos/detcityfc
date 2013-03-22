<?php
/**
 * Plugin Name: Recent Posts Widget
 * Description: A widget used for displaying recent posts.
 * Version: 1.0
 * Author: Fem Khan
 * Author URI: http://www.aivahthemes.com
 *
 */
	// Register Widget 
	function recentpost_widgets() {
		register_widget( 'recentpost_widgets' );
	}

	// Define the Widget as an extension of WP_Widget
	class recentpost_widgets extends WP_Widget {
		/* constructor */
		function recentpost_widgets() {
				
			global $theme_name;

			/* Widget settings. */
			$widget_ops = array(
				'classname'		=> 'recentpost_widget',
				'description'	=> __('Use this widget to display Recent Posts, Thumbnail Enable/Disable.', 'atp_admin')
			);

			/* Widget control settings. */
			$control_ops = array(
				'width'		=> 300,
				'height'	=> 350,
				'id_base'	=> 'recentpost_widget'
			);

			/* Create the widget. */
			$this->WP_Widget( 'recentpost_widget',$theme_name.' - Recent Posts', $widget_ops, $control_ops );
		}

		// outputs the content of the widget
		function widget( $args, $instance ) {
			extract( $args );

			/* Our variables from the widget settings. */
			$recentpost_imagedisable = $instance['recentpost_imagedisable'];
			$recentpost_limits = $instance['recentpost_limits'];
			$recentpost_title = $instance['recentpost_title'];
			$recentpost_excludecategory=$instance['recentpost_excludecategory'];
			$recentpost_select = $instance['recentpost_select'];
			$recentpost_description_length = $instance['recentpost_description_length'];
			
			if($recentpost_title =='') { $recentpost_title = "Recent Posts"; };
			$sys_subtitle = $instance['sys_subtitle'];
			if($sys_subtitle !=''){
				$subtitle = '<span class="widget-subtitle">'.$sys_subtitle.'</span>';
			}

			$before_title	='<h3 class="widget-title">';
			$after_title	=$subtitle.'</h3>';
			$before_widget	='<div id="recent_post_widget" class="widget_postslist clearfix">';
			$after_widget	='</div>';
			
			/* Before widget (defined by themes). */
			echo $before_widget;
			/* Title of widget (before and after defined by themes). */
			echo $before_title.$recentpost_title.$after_title;
			
			global $post, $wpdb;
			$recentpost =get_posts("cat=$recentpost_excludecategory&numberposts=$recentpost_limits&offset=0"); 
			echo "<ul>";
			foreach($recentpost as $post) {
				echo '<li>'; 
				$recentpost_image = get_post_meta($post->ID, 'post_image', true);
				$post_date = $post->post_date;
				$post_date = mysql2date('F jS, Y', $post_date, false);
				$recentpost_content= wp_html_excerpt($post->post_content,$recentpost_description_length);
				if($recentpost_imagedisable != "true") {
					$thumb = get_post_thumbnail_id($post->ID); 
					if ($thumb ){
						$recent_image = vt_resize( $thumb, '', 60, 40, true );?>
						<div class="thumb"><a href="<?php echo get_permalink($post->ID); ?>" title="<?php echo $post->post_title ?>"> <img class="img_border" src="<?php echo $recent_image['url']; ?>" title="<?php echo $post->post_title ?>"  alt="" width="<?php echo $recent_image['width']; ?>" height="<?php echo $recent_image['height']; ?>" /></a>
						</div>
					<?php 
					}else{ 
						echo '<div class="thumb"><a  href="'.get_permalink($post->ID).'" title="'. $post->post_title.'"><img class="img_border" src="'.get_template_directory_uri().'/images/no-image.jpg'.'" width="60" height="40" alt="' .$post->post_title. '"/></a></div>';	
					}
				}  ?>
				<div class="pdesc">
					<a class="title" href="<?php echo get_permalink($post->ID); ?>" title="<?php echo $post->post_title ?>"> <?php echo $post->post_title ?></a>
					<?php if($recentpost_select == 'time'):?>
					<div class="w-postmeta">
					<span class="sep"><?php echo $post_date; ?></span>
					<?php else:?>
					<p><?php echo $recentpost_content; ?>...</p>
					<?php endif;//end Description Length ?>
					</div>
				<?php echo "</li>";
			}
			echo "</ul>";
			/* After widget (defined by themes). */
			echo $after_widget;
		}
		
		//processes widget options to be saved
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			/* Strip tags for title and name to remove HTML (important for text inputs). */
			$instance['recentpost_title'] = strip_tags($new_instance['recentpost_title']);
			$instance['recentpost_imagedisable'] = strip_tags($new_instance['recentpost_imagedisable']);
			$instance['recentpost_limits'] = strip_tags( $new_instance['recentpost_limits'] );
			$instance['recentpost_excludecategory'] = strip_tags($new_instance['recentpost_excludecategory']);
			$instance['recentpost_select'] = strip_tags($new_instance['recentpost_select']);
			$instance['recentpost_description_length'] = strip_tags($new_instance['recentpost_description_length']);
			$instance['sys_subtitle'] = strip_tags($new_instance['sys_subtitle']);
			return $instance;
		}

		// outputs the options form on admin
		function form( $instance ) {
			/* Set up some default widget settings. */
			$recentpost_select = isset( $instance['recentpost_select'] ) ? $instance['recentpost_select'] : 'time';	
			if ( !isset($instance['recentpost_description_length']) || !$recentpost_description_length = (int) $instance['recentpost_description_length'] )
			$recentpost_description_length = 60;
			if ( !isset($instance['recentpost_limits']) || !$recentpost_limits = (int) $instance['recentpost_limits'] )
			$recentpost_limits = 3;
			$recentpost_excludecategory= isset($instance['recentpost_excludecategory']) ? $instance['recentpost_excludecategory'] : '';
			$recentpost_title= isset($instance['recentpost_title']) ? strip_tags($instance['recentpost_title']) : '';
			$sys_subtitle= isset($instance['sys_subtitle']) ? strip_tags($instance['sys_subtitle']) :'';
			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'recentpost_title' ); ?>"><?php _e('Title:', 'atp_admin'); ?></label>
				<input id="<?php echo $this->get_field_id( 'recentpost_title' ); ?>" name="<?php echo $this->get_field_name( 'recentpost_title' ); ?>" value="<?php echo $recentpost_title; ?>" type="text" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'sys_subtitle' ); ?>"><?php _e('Widget Sub Title:', 'example'); ?></label>
				<input type="text" id="<?php echo $this->get_field_id( 'sys_subtitle' ); ?>" name="<?php echo $this->get_field_name( 'sys_subtitle' ); ?>" value="<?php echo $sys_subtitle; ?>" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'recentpost_select' ); ?>"><?php _e('Extra Information:', 'atp_admin'); ?></label>
				<select id="<?php echo $this->get_field_id( 'recentpost_select' ); ?>" name="<?php echo $this->get_field_name( 'recentpost_select' ); ?>">
					<option value="time" <?php selected($recentpost_select,'time');?>>Time</option>
					<option value="description" <?php selected($recentpost_select,'description');?>>Description</option>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'recentpost_description_length' ); ?>"><?php _e('Length of Description to show::', 'atp_admin'); ?></label>
				<input type="text" id="<?php echo $this->get_field_id( 'recentpost_description_length' ); ?>" name="<?php echo $this->get_field_name( 'recentpost_description_length' ); ?>" value="<?php echo $recentpost_description_length; ?>" size="3" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'recentpost_limits' ); ?>"><?php _e('Number of posts to show:', 'atp_admin'); ?></label>
				<input type="text" id="<?php echo $this->get_field_id( 'recentpost_limits' ); ?>" name="<?php echo $this->get_field_name( 'recentpost_limits' ); ?>" value="<?php echo $recentpost_limits; ?>" size="3" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'recentpost_excludecategory' ); ?>"><?php _e('Exclude Categories <small>2,3,25</small>', 'atp_admin'); ?></label>
				<input type="text" id="<?php echo $this->get_field_id( 'recentpost_excludecategory' ); ?>" name="<?php echo $this->get_field_name( 'recentpost_excludecategory' ); ?>" value="<?php echo $recentpost_excludecategory; ?>" style="width:100%;" />
			</p>
			<p>
				<input type="checkbox" value="true" id="<?php echo $this->get_field_id( 'recentpost_imagedisable' ); ?>" name="<?php echo $this->get_field_name( 'recentpost_imagedisable' ); ?>" <?php  if( isset($instance['recentpost_imagedisable'])=="true") { echo "checked"; } ?> class="checkbox" /> <label for="<?php echo $this->get_field_id( 'recentpost_imagedisable' ); ?>"><?php _e('Disable Post Thumbnail?', 'atp_admin'); ?></label>
			</p>
		<?php 
		}
	}

	/* Add our function to the widgets_init hook. */
	add_action( 'widgets_init', 'recentpost_widgets' );
	
	wp_reset_query();
	
 ?>