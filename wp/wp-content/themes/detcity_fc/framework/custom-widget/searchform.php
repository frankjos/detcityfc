<?php
/**
 * Plugin Name: Search Form Widget
 * Description: A widget used for displaying custom search form.
 * Version: 1.0
 * Author: Fem Khan
 * Author URI: http://www.aivahthemes.com
 *
 */
	// Register Widget 
	function search_form_widgets() {
		register_widget( 'searchform_widget' );
	}

	// Define the Widget as an extension of WP_Widget
	class searchform_widget extends WP_Widget {
		/* constructor */
		function searchform_widget() {
		
			global $theme_name;
			
			/* Widget settings. */
			$widget_ops = array(
				'classname'		=> 'searchform_widget',
				'description'	=> __('A Search Form for your site  .', 'atp_admin')
			);
		
			/* Widget control settings. */
			$control_ops = array(
				'width'		=> 300,
				'height'	=> 350,
				'id_base'	=> 'searchearchform_widget'
			);
	
			/* Create the widget. */
			$this->WP_Widget( 'searchearchform_widget',$theme_name.' - Search Form', $widget_ops, $control_ops );
		}

		// outputs the content of the widget
		function widget( $args, $instance ) {
			extract( $args );

			/* Our variables from the widget settings. */
			$Searchform_title = $instance['searchform_title'];
			$before_title	='';
			$after_title	='';
			$before_widget	='<div id="search_from_widget" class="syswidget clearfix">';
			$after_widget	='</div>';

			/* Before widget (defined by themes). */
			echo $before_widget;
			/* Title of widget (before and after defined by themes). */
			echo $before_title.$Searchform_title.$after_title; ?>
			<div class="search-box">
			<form id="searchform" method="get" action="<?php echo home_url(); ?>">
			<fieldset>
			<input class="widgetsearch" id="s" type="text" name="s" value="To search type and hit enter" onfocus="if(this.value=='To search type and hit enter')this.value='';" onblur="if(this.value=='')this.value='To search type and hit enter';">
			<fieldset>
			</form>
			</div>
			<?php
			
			/* After widget (defined by themes). */
			echo $after_widget;	
		}

		//processes widget options to be saved
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			/* Strip tags for title and name to remove HTML (important for text inputs). */
			$instance['serachform_title'] = strip_tags( $new_instance['serachform_title'] );
			return $instance;
		}
		
		// outputs the options form on admin
		/* Set up some default widget settings. */
		function form( $instance ) {
		$serachform_title= isset($instance['serachform_title']) ? strip_tags($instance['serachform_title']) :'';
		?>
			<p>
				<label for="<?php echo $this->get_field_id( 'serachform_title' ); ?>"><?php _e('Title:', 'atp_admin'); ?></label>
				<input id="<?php echo $this->get_field_id( 'serachform_title' ); ?>" name="<?php echo $this->get_field_name( 'serachform_title' ); ?>" value="<?php echo $serachform_title; ?>" type="text" style="width:100%;" />
			</p>	
		<?php 
		}
	}
	/* Add our function to the widgets_init hook. */
	add_action( 'widgets_init', 'search_form_widgets' );
?>