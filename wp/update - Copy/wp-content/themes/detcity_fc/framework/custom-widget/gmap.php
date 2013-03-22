<?php
/**
 * Plugin Name: Google Map Widget
 * Description: A widget used for displaying Google Map.
 * Version: 1.0
 * Author: Fem Khan
 * Author URI: http://www.aivahthemes.com
 *
 */
	
	// Register Widget 
	function gmap_widgets() {
		register_widget( 'gmap_widgets' );
	}
	
	// Define the Widget as an extension of WP_Widget
	class gmap_widgets extends WP_Widget {
		/* constructor */
		function gmap_widgets() {
			
			global $theme_name;

			/* Widget settings. */
			$widget_ops = array(
				'classname'		=> 'gmap_widgets',
				'description'	=> __('Add Google Map to your sidebar  .', 'atp_admin')
			);
	
			/* Widget control settings. */
			$control_ops = array(
				'width'		=> 300,
				'height'	=> 350,
				'id_base'	=> 'gmap_widgets'
			);

			/* Create the widget. */
			$this->WP_Widget( 'gmap_widgets',$theme_name.' - Google Map', $widget_ops, $control_ops );
		}

		// outputs the content of the widget
		function widget( $args, $instance ) {
			wp_print_scripts('jquery-gmap');
			extract( $args );
			/* Our variables from the widget settings. */
			$g_title = $instance['g_title'];
			$g_address = $instance['g_address'];
			$g_latitude = !empty($instance['g_latitude'])?$instance['g_latitude']:0;
			$g_longitude = !empty($instance['g_longitude'])?$instance['g_longitude']:0;
			$g_zoom = (int)$instance['g_zoom'];
			$g_html = $instance['g_html'];
			$g_popup = $instance['g_popup'];
			$g_height = (int)$instance['g_height'];
			$sys_subtitle = $instance['sys_subtitle'];
			if($sys_subtitle !='') {
				$subtitle = '<span class="widget-subtitle">'.$sys_subtitle.'</span>';
			}
			$before_title	='<h3 class="widget-title">';
			$after_title	= $subtitle.'</h3>';
			$before_widget='<div id="gmap_widget" class="syswidget">';
			$after_widget='<div class="clear"></div></div>';
			
			/* Before widget (defined by themes). */
			echo $before_widget;
			/* Title of widget (before and after defined by themes). */
			echo $before_title.$g_title.$after_title;
			$id = rand(1,400);
			?>
			<div id="googlemap_widget_<?php echo $id;?>"  style="height:<?php echo $g_height;?>px"></div>
			<script type="text/javascript">
			jQuery(document).ready(function($) {
				jQuery("#googlemap_widget_<?php echo $id;?>").gMap({
					zoom: <?php echo $g_zoom;?>,
					markers:[{
						address: "<?php echo $g_address;?>",
						latitude: <?php echo $g_latitude;?>,
						longitude: <?php echo $g_longitude;?>,
						html: "<?php echo $g_html;?>",
						popup: <?php echo $g_popup;?>
					}],
					controls: [],
					scrollwheel: true,
					maptype: G_NORMAL_MAP
				});
			});
			</script>
			<?php
			/* After widget (defined by themes). */
			echo $after_widget;
		}
		
		//processes widget options to be saved
		function update( $new_instance, $old_instance ) {
			
			$instance = $old_instance;
			/* Strip tags for title and name to remove HTML (important for text inputs). */
			$instance['g_title'] = strip_tags( $new_instance['g_title'] );
			$instance['g_address'] = strip_tags( $new_instance['g_address'] );
			$instance['g_latitude'] = strip_tags( $new_instance['g_latitude'] );
			$instance['g_longitude'] = strip_tags( $new_instance['g_longitude'] );
			$instance['g_zoom'] = strip_tags( $new_instance['g_zoom'] );
			$instance['g_height'] = strip_tags( $new_instance['g_height'] );
			$instance['g_popup'] = !empty($new_instance['g_popup']) ? 1 : 0;
			$instance['g_html'] = strip_tags( $new_instance['g_html'] );
			$instance['sys_subtitle'] = strip_tags( $new_instance['sys_subtitle'] );
			return $instance;
		}
		
		// outputs the options form on admin
		function form( $instance ) {
			/* Set up some default widget settings. */
			$instance = wp_parse_args( (array) $instance, array( 'g_title' => '', 'sys_subtitle' =>'', 'g_address' => '', 'g_latitude' => '' , 'g_longitude' => '' , 'g_zoom' => '' , 'g_html' => '' , 'g_height' => ''  ) );
			$g_title = strip_tags($instance['g_title']);
			$g_address = strip_tags($instance['g_address']);	
			$g_latitude = strip_tags($instance['g_latitude']);	
			$g_longitude = strip_tags($instance['g_longitude']);	
			$g_zoom = strip_tags($instance['g_zoom']);	
			$g_html = strip_tags($instance['g_html']);	
			$g_height = strip_tags($instance['g_height']);
			$sys_subtitle= strip_tags($instance['sys_subtitle']);			
			$g_popup = isset( $instance['g_popup'] ) ? (bool) $instance['g_popup'] : false;
			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'g_title' ); ?>"><?php _e('Title:', 'example'); ?></label>
				<input id="<?php echo $this->get_field_id( 'g_title' ); ?>" name="<?php echo $this->get_field_name( 'g_title' ); ?>" value="<?php echo $g_title; ?>" type="text" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'g_subtitle' ); ?>"><?php _e('Widget Sub Title:', 'example'); ?></label>
				<input id="<?php echo $this->get_field_id( 'sys_subtitle' ); ?>" name="<?php echo $this->get_field_name( 'sys_subtitle' ); ?>" value="<?php echo $sys_subtitle; ?>" type="text" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'g_address' ); ?>"><?php _e('Address(optional):', 'example'); ?></label>
				<input id="<?php echo $this->get_field_id( 'g_address' ); ?>" name="<?php echo $this->get_field_name( 'g_address' ); ?>" value="<?php echo $g_address; ?>" type="text" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'g_latitude' ); ?>"><?php _e('Latitude:', 'example'); ?></label>
				<input id="<?php echo $this->get_field_id( 'g_latitude' ); ?>" name="<?php echo $this->get_field_name( 'g_latitude' ); ?>" value="<?php echo $g_latitude; ?>" type="text" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'g_longitude' ); ?>"><?php _e('Longitude:', 'example'); ?></label>
				<input id="<?php echo $this->get_field_id( 'g_longitude' ); ?>" name="<?php echo $this->get_field_name( 'g_longitude' ); ?>" value="<?php echo $g_longitude; ?>" type="text" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'g_zoom' ); ?>"><?php _e('Zoom value from 1 to 19:', 'example'); ?></label>
				<input id="<?php echo $this->get_field_id( 'g_zoom' ); ?>" name="<?php echo $this->get_field_name( 'g_zoom' ); ?>" value="<?php echo $g_zoom; ?>" type="text" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'g_html' ); ?>"><?php _e('Content for the marker::', 'example'); ?></label>
				<input id="<?php echo $this->get_field_id( 'g_html' ); ?>" name="<?php echo $this->get_field_name( 'g_html' ); ?>" value="<?php echo $g_html; ?>" type="text" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'g_height' ); ?>"><?php _e('Height:', 'example'); ?></label>
				<input id="<?php echo $this->get_field_id( 'g_height' ); ?>" name="<?php echo $this->get_field_name( 'g_height' ); ?>" value="<?php echo $instance['g_height']; ?>" type="text" style="width:100%;" />
			</p>
			<p>
				<input type="checkbox"  id="<?php echo $this->get_field_id( 'g_popup' ); ?>" name="<?php echo $this->get_field_name( 'g_popup' ); ?>" <?php checked( $g_popup ); ?>" class="checkbox" /> <label for="<?php echo $this->get_field_id( 'g_popup' ); ?>"><?php _e('Auto popup the info?', 'example'); ?></label>
			</p>
		<?php 
		}
	}
	/* Add our function to the widgets_init hook. */
	add_action( 'widgets_init', 'gmap_widgets' );

?>