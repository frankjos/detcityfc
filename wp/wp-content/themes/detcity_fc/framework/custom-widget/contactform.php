<?php
/**
 * Plugin Name: Contact Form Widget
 * Description: A widget used for displaying Contact Form.
 * Version: 1.0
 * Author: Fem Khan
 * Author URI: http://www.aivahthemes.com
 *
 */
	// Register Widget 
	function contact_form_widgets() {
		register_widget( 'contactform_widget' );
	}

	// Define the Widget as an extension of WP_Widget
	class contactform_widget extends WP_Widget {
		/* constructor */
		function Contactform_widget() {
			
			global $theme_name;
			/* Widget settings. */
			$widget_ops = array( 
				'classname'		=> 'contactform_widget',
				'description'	=> __('Quick Contact Form widget for sidebar.', 'atp_admin')
			);
	
			/* Widget control settings. */
			$control_ops = array(
				'width'		=> 300,
				'height'	=> 350,
				'id_base'	=> 'contactform_widget'
			);

			/* Create the widget. */
			$this->WP_Widget( 'contactform_widget',$theme_name.' - Contact Form', $widget_ops, $control_ops );
		}

		// outputs the content of the widget
		function widget( $args, $instance ) {
			wp_print_scripts('atp-form');
			wp_print_scripts('atp-validate');
			extract( $args );

			/* Our variables from the widget settings. */
			if(isset($instance['semail'])){
				$semail = $instance['semail'];
			}
			$contact_widgetemail = $instance['contact_widgetemail'];
			$sys_contactform_subtitle = $instance['sys_contactform_subtitle'];
			if($sys_contactform_subtitle !='')	{
				$subtitle = '<span class="widget-subtitle">'.$sys_contactform_subtitle.'</span>';
			}
			$contacttitle	="Contact Us";
			$before_title	='<h3 class="widget-title">';
			$after_title	=$subtitle.'</h3>';
			$before_widget	='<div id="contact_from_widget" class="syswidget sysform">';
			$after_widget	='</div>';

			/* Before widget (defined by themes). */
			echo $before_widget;
			echo '<div id="result"></div>';

			/* Title of widget (before and after defined by themes). */
			echo $before_title.$contacttitle.$after_title; ?>
			<form action="<?php echo get_template_directory_uri(); ?>/framework/includes/submitform.php" id="validate_form" method="post">
				<p><input type="text" size="25" name="contact_name" class="txt required"><label><?php _e('Name', 'atp_front'); ?> <span>*</span></label></p>
				<p><input type="text" size="25" name="contact_email" class="txt required"><label><?php _e('Email', 'atp_front'); ?> <span>*</span></label></p>
				<p><textarea name="contactcomment" rows="5" cols="30" class="required"></textarea></p>
				<p><button type="submit" value="submit" name="contactsubmit" class="button small gray"><span><?php _e('submit','atp_front');?></span></button></p>
				<input type="hidden" name="contact_check" value="checking">
				<input type="hidden" name="contact_widgetemail" value="<?php echo 	$contact_widgetemail; ?>">
			</form>
			<?php
			
			/* After widget (defined by themes). */
			echo $after_widget;
		}
		
		//processes widget options to be saved
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			/* Strip tags for title and name to remove HTML (important for text inputs). */
			$instance['contact_widgetemail'] = strip_tags( $new_instance['contact_widgetemail'] );
			$instance['sys_contactform_subtitle'] = strip_tags( $new_instance['sys_contactform_subtitle'] );

			return $instance;
		}
		
		// outputs the options form on admin
		function form( $instance ) {
			/* Set up some default widget settings. */
			$instance = wp_parse_args( (array) $instance, array( 'contact_widgetemail' => '', 'sys_contactform_subtitle' =>'') );
			$contact_widgetemail = strip_tags($instance['contact_widgetemail']);
			$sys_contactform_subtitle = strip_tags($instance['sys_contactform_subtitle']);			
			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'sys_contactform_subtitle' ); ?>"><?php _e('Widget Sub Title:', 'example'); ?></label>
				<input id="<?php echo $this->get_field_id( 'sys_contactform_subtitle' ); ?>" name="<?php echo $this->get_field_name( 'sys_contactform_subtitle' ); ?>" value="<?php echo $sys_contactform_subtitle; ?>" type="text" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'contact_widgetemail' ); ?>"><?php _e('Email:', 'atp_front'); ?></label>
				<input type="text" id="<?php echo $this->get_field_id( 'contact_widgetemail' ); ?>" name="<?php echo $this->get_field_name( 'contact_widgetemail' ); ?>" value="<?php echo $contact_widgetemail; ?>" style="width:100%;" />
			</p>
		<?php 
		} 
	} 
	/* Add our function to the widgets_init hook. */
	add_action( 'widgets_init', 'contact_form_widgets' );
?>
