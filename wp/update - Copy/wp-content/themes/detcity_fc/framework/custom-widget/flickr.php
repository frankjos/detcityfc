<?php
/**
 * Plugin Name: Flickr Widget
 * Description: A widget used for displaying flickr photos.
 * Version: 1.0
 * Author: Fem Khan
 * Author URI: http://www.aivahthemes.com
 *
 */
	// Register Widget 
	function flickr_widgets() {
		register_widget( 'flickr_widgets' );
	}
	
	// Define the Widget as an extension of WP_Widget
	class flickr_widgets extends WP_Widget {
		/* constructor */
		function flickr_widgets() {
			
			global $theme_name;

			/* Widget settings. */
			$widget_ops = array(
				'classname'		=> 'flickr_widget',
				'description'	=> __('Use this widget to display your flickr gallery.', 'atp_admin')
			);

			/* Widget control settings. */
			$control_ops = array(
				'width'		=> 300,
				'height'	=> 350,
				'id_base'	=> 'flickr_widget'
			);

			/* Create the widget. */
			$this->WP_Widget( 'flickr_widget',$theme_name.' - Flickr Photos', $widget_ops, $control_ops );
		}

		// outputs the content of the widget
		function widget( $args, $instance ) {
			extract( $args );
			/* Our variables from the widget settings. */
			$flickr_id = $instance['flickr_id'];
			$flickr_limits = $instance['flickr_limits'];
			$flickr_title = $instance['flickr_title'];
			$sys_subtitle = $instance['sys_subtitle'];
			if($sys_subtitle !=''){
				$subtitle = '<span class="widget-subtitle">'.$sys_subtitle.'</span>';
			}
			$before_title	='<h3 class="widget-title">';
			$after_title	= $subtitle.'</h3>';
			$before_widget	='<div id="flickr_widget" class="syswidget clearfix">';
			$after_widget	='</div>';
			
			/* Before widget (defined by themes). */
			echo $before_widget;
			/* Title of widget (before and after defined by themes). */
			echo $before_title.$flickr_title.$after_title;?>
			<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $flickr_limits; ?>&amp;display=random&amp;size=s&amp;layout=x&amp;source=user&amp;user=<?php echo $flickr_id; ?>"></script>
			<?php
			
			/* After widget (defined by themes). */
			echo $after_widget;
		}
		
		//processes widget options to be saved
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			/* Strip tags for title and name to remove HTML (important for text inputs). */
			$instance['flickr_title'] = strip_tags( $new_instance['flickr_title'] );
			$instance['flickr_id'] = strip_tags( $new_instance['flickr_id'] );
			$instance['flickr_limits'] = strip_tags( $new_instance['flickr_limits'] );
			$instance['sys_subtitle'] = strip_tags( $new_instance['sys_subtitle'] );
		
			return $instance;
		}

		// outputs the options form on admin
		function form( $instance ) {
			/* Set up some default widget settings. */
			$instance = wp_parse_args( (array) $instance, array( 'flickr_title' => '','sys_subtitle' =>'','flickr_id' => '','flickr_limits' => '') );
			$flickr_title = strip_tags($instance['flickr_title']);
			$flickr_id = strip_tags($instance['flickr_id']);
			$flickr_limits = strip_tags($instance['flickr_limits']);
			$sys_subtitle= strip_tags($instance['sys_subtitle']);
			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'flickr_title' ); ?>"><?php _e('Title:', 'example'); ?></label>
				<input type="text" id="<?php echo $this->get_field_id( 'flickr_title' ); ?>" name="<?php echo $this->get_field_name( 'flickr_title' ); ?>" value="<?php echo $flickr_title; ?>" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'sys_subtitle' ); ?>"><?php _e('Widget Sub Title:', 'example'); ?></label>
				<input type="text" id="<?php echo $this->get_field_id( 'sys_subtitle' ); ?>" name="<?php echo $this->get_field_name( 'sys_subtitle' ); ?>" value="<?php echo $sys_subtitle; ?>" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'flickr_id' ); ?>"><?php _e('Flickr ID: <small>Find your ID from <a href="http://idgettr.com" target="_blank">idGettr</a></small>', 'example'); ?></label>
				<input type="text" id="<?php echo $this->get_field_id( 'flickr_id' ); ?>" name="<?php echo $this->get_field_name( 'flickr_id' ); ?>" value="<?php echo $flickr_id; ?>" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'flickr_limits' ); ?>"><?php _e('How many photos you would like to display?:', 'example'); ?></label>
				<input type="text" id="<?php echo $this->get_field_id( 'flickr_limits' ); ?>" name="<?php echo $this->get_field_name( 'flickr_limits' ); ?>" value="<?php echo $flickr_limits; ?>" style="width:100%;" />
			</p>
		<?php 
		} 
	} 
	/* Add our function to the widgets_init hook. */
	add_action( 'widgets_init', 'flickr_widgets' );
?>