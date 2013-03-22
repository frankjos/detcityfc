<?php
/**
 * Plugin Name: Contact Info Widget
 * Description: A widget used for displaying Contact Info.
 * Version: 1.0
 * Author: Fem Khan
 * Author URI: http://www.aivahthemes.com
 *
 */
	// Register Widget 
	function contactinfo_widgets() {
		register_widget( 'contactinfo_widgets' );
	}
	
	// Define the Widget as an extension of WP_Widget
	class contactinfo_widgets extends WP_Widget {
		/* constructor */
		function contactinfo_widgets() {
			
			global $theme_name;
			
			/* Widget settings. */
			$widget_ops = array(
				'classname'		=> 'contactinfo_widgets',
				'description'	=> __('Add Contactinfo to your sidebar  .', 'atp_admin')
			);

			/* Widget control settings. */
			$control_ops = array(
				'width'		=> 300,
				'height'	=> 350,
				'id_base'	=> 'contactinfo_widgets'
			);

			/* Create the widget. */
			$this->WP_Widget( 'contactinfo_widgets',$theme_name.'-Contact Info', $widget_ops, $control_ops );
		}
	
		// outputs the content of the widget
		function widget( $args, $instance ) {
			extract( $args );
			/* Our variables from the widget settings. */
			$contactinfo_title = $instance['contactinfo_title'];
			$syscontact_name = $instance['syscontact_name'];
			$syscontact_address = $instance['syscontact_address'];
			$syscontact_city = $instance['syscontact_city'];
			$syscontact_state = $instance['syscontact_state'];
			$syscontact_zip = $instance['syscontact_zip'];
			$syscontact_phone = $instance['syscontact_phone'];
			$syscontact_email = $instance['syscontact_email'];
			$sys_subtitle = $instance['sys_subtitle'];
			if($sys_subtitle !='')	{
				$subtitle = '<span class="widget-subtitle">'.$sys_subtitle.'</span>';
			}
			
			$before_title	='<h3 class="widget-title">';
			$after_title	=$subtitle.'</h3>';
			$before_widget	='<div id="contact_info_widget" class="syswidget contactinfo">';
			$after_widget	='<div class="clear"></div></div>';

			/* Before widget (defined by themes). */
			echo $before_widget;
			/* Title of widget (before and after defined by themes). */
			echo $before_title.$contactinfo_title.$after_title; 
			if($syscontact_name){
				echo '<span class="author-icon">'.$syscontact_name.'</span><br />';
			}
			if($syscontact_address){
				echo '<span class="address-icon">'.$syscontact_address.'</span><br />';
			}
			if($syscontact_city){
				echo '<span>'.$syscontact_city.'</span><br />';
			}
			if($syscontact_state){
				echo '<span>'.$syscontact_state.'</span><br />';
			}
			if($syscontact_zip){
				echo '<span>'.$syscontact_zip.'</span><br />';
			}
			if($syscontact_phone){
				echo '<span class="phone-icon">'.$syscontact_phone.'</span><br />';
			}
			if($syscontact_email){
				echo '<span class="email-icon">'.$syscontact_email.'</span><br />';
			}

			/* After widget (defined by themes). */
			echo $after_widget;
		}
		
		//processes widget options to be saved
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			/* Strip tags for title and name to remove HTML (important for text inputs). */
			$instance['contactinfo_title'] = strip_tags( $new_instance['contactinfo_title'] );
			$instance['syscontact_name'] = strip_tags( $new_instance['syscontact_name'] );
			$instance['syscontact_city'] = strip_tags( $new_instance['syscontact_city'] );
			$instance['syscontact_address'] = strip_tags( $new_instance['syscontact_address'] );
			$instance['syscontact_state'] = strip_tags( $new_instance['syscontact_state'] );
			$instance['syscontact_zip'] = strip_tags( $new_instance['syscontact_zip'] );
			$instance['syscontact_email'] = strip_tags( $new_instance['syscontact_email'] );
			$instance['syscontact_phone'] = strip_tags( $new_instance['syscontact_phone'] );
			$instance['sys_subtitle'] = strip_tags( $new_instance['sys_subtitle'] );
			return $instance;
		}

		// outputs the options form on admin
		function form( $instance ) {
			/* Set up some default widget settings. */
			$instance = wp_parse_args( (array) $instance, array( 'contactinfo_title' => '', 'sys_subtitle' =>'', 'syscontact_name' => '', 'syscontact_address' => '', 'syscontact_city' => '', 'syscontact_state' => '', 'syscontact_zip' => '', 'syscontact_phone' => '', 'syscontact_email' => '') );
			$contactinfo_title = strip_tags($instance['contactinfo_title']);
			$syscontact_name = strip_tags($instance['syscontact_name']);
			$syscontact_address = strip_tags($instance['syscontact_address']);
			$syscontact_city = strip_tags($instance['syscontact_city']);
			$syscontact_state = strip_tags($instance['syscontact_state']);
			$syscontact_zip = strip_tags($instance['syscontact_zip']);
			$syscontact_phone = strip_tags($instance['syscontact_phone']);
			$syscontact_email = strip_tags($instance['syscontact_email']);
			$sys_subtitle = strip_tags($instance['sys_subtitle']);	
			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'contactinfo_title' ); ?>"><?php _e('Title:', 'victoria_front'); ?></label>
				<input id="<?php echo $this->get_field_id( 'contactinfo_title' ); ?>" name="<?php echo $this->get_field_name( 'contactinfo_title' ); ?>" value="<?php echo $contactinfo_title; ?>" type="text" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'sys_subtitle_title' ); ?>"><?php _e('Sub Title:', 'victoria_front'); ?></label>
				<input id="<?php echo $this->get_field_id( 'sys_subtitle' ); ?>" name="<?php echo $this->get_field_name( 'sys_subtitle' ); ?>" value="<?php echo $sys_subtitle; ?>" type="text" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'syscontact_name' ); ?>"><?php _e('Name:', 'victoria_front'); ?></label>
				<input id="<?php echo $this->get_field_id( 'syscontact_name' ); ?>" name="<?php echo $this->get_field_name( 'syscontact_name' ); ?>" value="<?php echo $syscontact_name; ?>" type="text" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'syscontact_address' ); ?>"><?php _e('Address:', 'victoria_front'); ?></label>
				<input id="<?php echo $this->get_field_id( 'syscontact_address' ); ?>" name="<?php echo $this->get_field_name( 'syscontact_address' ); ?>" value="<?php echo $syscontact_address; ?>" type="text" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'syscontact_city' ); ?>"><?php _e('City:', 'victoria_front'); ?></label>
				<input id="<?php echo $this->get_field_id( 'syscontact_city' ); ?>" name="<?php echo $this->get_field_name( 'syscontact_city' ); ?>" value="<?php echo $syscontact_city; ?>" type="text" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'syscontact_state' ); ?>"><?php _e('State:', 'victoria_front'); ?></label>
				<input id="<?php echo $this->get_field_id( 'syscontact_state' ); ?>" name="<?php echo $this->get_field_name( 'syscontact_state' ); ?>" value="<?php echo $syscontact_state; ?>" type="text" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'syscontact_zip' ); ?>"><?php _e('Zip Code:', 'victoria_front'); ?></label>
				<input id="<?php echo $this->get_field_id( 'syscontact_zip' ); ?>" name="<?php echo $this->get_field_name( 'syscontact_zip' ); ?>" value="<?php echo $syscontact_zip; ?>" type="text" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'syscontact_phone' ); ?>"><?php _e('Phone:', 'victoria_front'); ?></label>
				<input id="<?php echo $this->get_field_id( 'syscontact_phone' ); ?>" name="<?php echo $this->get_field_name( 'syscontact_phone' ); ?>" value="<?php echo $syscontact_phone; ?>" type="text" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'syscontact_email' ); ?>"><?php _e('E-mail:', 'victoria_front'); ?></label>
				<input id="<?php echo $this->get_field_id( 'syscontact_email' ); ?>" name="<?php echo $this->get_field_name( 'syscontact_email' ); ?>" value="<?php echo $syscontact_email; ?>" type="text" style="width:100%;" />
			</p>
		<?php 
		} 
	}
	/* Add our function to the widgets_init hook. */
	add_action( 'widgets_init', 'contactinfo_widgets' );
?>