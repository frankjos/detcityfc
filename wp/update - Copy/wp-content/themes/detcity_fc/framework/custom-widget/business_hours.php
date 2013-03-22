<?php
/**
 * Plugin Name: Business Hours Widget
 * Description: A widget used for displaying business hours.
 * Version: 1.0
 * Author: Fem Khan
 * Author URI: http://www.aivahthemes.com
 *
 */
	// Register Widget 
	function businesshours_widgets() {
		register_widget( 'businesshours_widgets' );
	}
	
	// Define the Widget as an extension of WP_Widget
	class businesshours_widgets extends WP_Widget {
		/* constructor */
		function businesshours_widgets() {
			
			global $theme_name;
			
			/* Widget settings. */
			$widget_ops = array(
				'classname'		=> 'businesshours_widgets',
				'description'	=> __('Display Business Hours .', 'atp_admin')
			);

			/* Widget control settings. */
			$control_ops = array(
				'width'		=> 300,
				'height'	=> 350,
				'id_base'	=> 'businesshours_widgets'
			);

			/* Create the widget. */
			$this->WP_Widget( 'businesshours_widgets',$theme_name.'-Business Hours', $widget_ops, $control_ops );
		}

		// outputs the content of the widget
		function widget( $args, $instance ) {
			extract( $args );

			/* Our variables from the widget settings. */
			$businesshours_title = $instance['businesshours_title'];
			$before_title	='<h3 class="widget-title">';
			$after_title	='</h3>';
			$before_widget	='<div id="businesshours" class="syswidget businesshours">';
			$after_widget	='<div class="clear"></div></div>';

			/* Before widget (defined by themes). */
			echo $before_widget;
			/* Title of widget (before and after defined by themes). */
			echo $before_title.$businesshours_title.$after_title;

			$out='';//stores the output
	
			$week_hours = array(
							'Sunday'=>get_option('atp_sunday'),
							'Monday'=>get_option('atp_monday'),
							'Tuesday'=>get_option('atp_tuesday'),
							'Wednesday'=>get_option('atp_wednesday'),
							'Thursday'=>get_option('atp_thursday'),
							'Friday'=>get_option('atp_friday'),
							'Saturday'=>get_option('atp_saturday')
							);
			
			// 24 Hous Format
			if(get_option('atp_timeformat')=='24'){
				
				foreach($week_hours as $week_day => $day_hours) {
					if($day_hours['close']=='on') {					
						$out.='<p><span>'.$week_day.':</span><strong>Closed</strong></p>';
					} else {
						list($open_hours,$open_min) = explode(':',$day_hours['opening']);
						list($close_hours,$close_min) = explode(':',$day_hours['closing']);
						$out.= '<p><span>'.$week_day.':</span>'.sprintf('%02d:%02d',$open_hours,$open_min).' -'.sprintf('%02d:%02d',$close_hours,$close_min);
					}
				}
			}else if(get_option('atp_timeformat')=='12'){

				foreach($week_hours as $week_day => $day_hours) {
	
					if($day_hours['close']=='on') {
						$out.='<p><span>'.$week_day.':</span><strong>Closed</strong></p>';
					} else {
						list($open_hours,$open_min) = explode(':',$day_hours['opening']);
						list($close_hours,$close_min) = explode(':',$day_hours['closing']);
						$opening_am_or_pm = $open_hours - 12 >= 0? 'PM':'AM';
						$closing_am_or_pm = $close_hours - 12 >= 0? 'PM':'AM';
						$open_hours = $open_hours>12?$open_hours - 12:$open_hours;
						$close_hours = $close_hours>12?$close_hours - 12:$close_hours;
						$out.= '<p><span>'.$week_day.':</span>'.sprintf('%02d:%02d',$open_hours,$open_min).' '.$opening_am_or_pm.' -'.sprintf('%02d:%02d',$close_hours,$close_min).' '.$closing_am_or_pm;
					}
				}
			}
		
			// 12 Hours Format
			echo $out;
			/* After widget (defined by themes). */
			echo $after_widget;
		}

		//processes widget options to be saved
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			/* Strip tags for title and name to remove HTML (important for text inputs). */
			$instance['businesshours_title'] = strip_tags( $new_instance['businesshours_title'] );
			return $instance;
		}

		// outputs the options form on admin
		function form( $instance ) {
			/* Set up some default widget settings. */
			$instance = wp_parse_args( (array) $instance, array( 
				'businesshours_title' => '') 
				);
			$businesshours_title = strip_tags($instance['businesshours_title']);
			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'businesshours_title' ); ?>"><?php _e('Title:', 'victoria_front'); ?></label>
				<input id="<?php echo $this->get_field_id( 'businesshours_title' ); ?>" name="<?php echo $this->get_field_name( 'businesshours_title' ); ?>" value="<?php echo $businesshours_title; ?>" type="text" style="width:100%;" />
			</p>
		<?php 
		} 
	}
	/* Add our function to the widgets_init hook. */
	add_action( 'widgets_init', 'businesshours_widgets' );
 ?>