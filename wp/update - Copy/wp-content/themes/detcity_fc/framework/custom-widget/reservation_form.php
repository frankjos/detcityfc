<?php
/**
 * Plugin Name: Reservation Form Widget
 * Description: A widget used for displaying reservation form.
 * Version: 1.0
 * Author: Fem Khan
 * Author URI: http://www.aivahthemes.com
 *
 */
	// Register Widget 
	function reservation_form_widgets() {
		register_widget( 'reservation_widget' );
	}

	// Define the Widget as an extension of WP_Widget
	class reservation_widget extends WP_Widget {
		/* constructor */
		function reservation_widget() {
			
			global $theme_name;
		
			// Widget Settings
			$widget_ops = array( 
				'classname'		=> 'reservation_widget',
				'description'	=> __('Reservation Widget for Sidebar or any Widgetized Area.', 'atp_admin')
			);

			// Widget control settings.
			$control_ops = array(
				'width'		=> 300,
				'height'	=> 350,
				'id_base'	=> 'reservation_widget'
			);

			// Create the widget.
			$this->WP_Widget('reservation_widget', $theme_name.' - Reservation Form', $widget_ops, $control_ops );
		}

		// outputs the content of the widget
		function widget($args,$instance) {
		
			// Enqueues datepicker / jQuery ui-core / ui-core style ( Pepper Grinder ).
			wp_print_scripts('atp_reservation_scripts');
			wp_print_styles('atp_reservation_styles');
	
			extract( $args );
			if(isset($instance['semail'])){
				$semail = $instance['semail'];
			}
	
			/* Our variables from the widget settings. */
			/* Get all the Business hours*/
			$sunday_hours = get_option('atp_sunday');
			$monday_hours = get_option('atp_monday');
			$tuesday_hours = get_option('atp_tuesday');
			$wednesday_hours = get_option('atp_wednesday');
			$thursday_hours = get_option('atp_thursday');
			$friday_hours = get_option('atp_friday');
			$saturday_hours = get_option('atp_saturday');
			
			//get timeformat
			$timeformat = get_option('atp_timeformat');

			$title = $instance['reservation_title'];
			$sys_subtitle = $instance['reservation_subtitle'];		
			if($sys_subtitle !=''){
				$subtitle = '<span class="widget-subtitle">'.$sys_subtitle.'</span>';
			}
			$reservationtitle	="Booking Reservation";
			$before_widget	='<div id="reservations_widget" class="syswidget">';
			$before_title	='<h3 class="widget-title">';
			$after_title	=$subtitle.'</h3>';
			$after_widget	='</div>';

			/* Before widget (defined by themes). */
			echo $before_widget;
			/* Title of widget (before and after defined by themes). */
			echo $before_title.$title.$after_title; ?>
			<script type="text/javascript">
			/* <![CDATA[ */
				var sunday_hours = new Array(
					'<?php echo ltrim(substr($sunday_hours['opening'],0,2),'0');?>',
					'<?php echo ltrim(substr($sunday_hours['closing'],0,2),'0');?>',
					'<?php echo ltrim(substr($sunday_hours['opening'],3,2),'0');?>',
					'<?php echo ltrim(substr($sunday_hours['closing'],3,2),'0');?>',
					'<?php echo $sunday_hours['close'];?>',
					'<?php echo $timeformat;?>'
				);

				var monday_hours = new Array(
					'<?php echo ltrim(substr($monday_hours['opening'],0,2),'0');?>',
					'<?php echo ltrim(substr($monday_hours['closing'],0,2),'0');?>',
					'<?php echo ltrim(substr($monday_hours['opening'],3,2),'0');?>',
					'<?php echo ltrim(substr($monday_hours['closing'],3,2),'0');?>',
					'<?php echo $monday_hours['close'];?>',
					'<?php echo $timeformat;?>'
				);

				var tuesday_hours = new Array(
					'<?php echo  ltrim(substr($tuesday_hours['opening'],0,2),'0');?>',
					'<?php echo  ltrim(substr($tuesday_hours['closing'],0,2),'0');?>',
					'<?php echo ltrim(substr($tuesday_hours['opening'],3,2),'0');?>',
					'<?php echo ltrim(substr($tuesday_hours['closing'],3,2),'0');?>',
					'<?php echo $tuesday_hours['close'];?>',
					'<?php echo $timeformat;?>'
				);

				var wednesday_hours = new Array(
					'<?php echo  ltrim(substr($wednesday_hours['opening'],0,2),'0');?>',
					'<?php echo  ltrim(substr($wednesday_hours['closing'],0,2),'0');?>',
					'<?php echo ltrim(substr($wednesday_hours['opening'],3,2),'0');?>',
					'<?php echo ltrim(substr($wednesday_hours['closing'],3,2),'0');?>',
					'<?php echo $wednesday_hours['close'];?>',
					'<?php echo $timeformat;?>'
				);

				var thursday_hours = new Array(
					'<?php echo  ltrim(substr($thursday_hours['opening'],0,2),'0');?>',
					'<?php echo  ltrim(substr($thursday_hours['closing'],0,2),'0');?>',
					'<?php echo ltrim(substr($thursday_hours['opening'],3,2),'0');?>',
					'<?php echo ltrim(substr($thursday_hours['closing'],3,2),'0');?>',
					'<?php echo $thursday_hours['close'];?>',
					'<?php echo $timeformat;?>'
				);

				var friday_hours = new Array(
					'<?php echo  ltrim(substr($friday_hours['opening'],0,2),'0');?>',
					'<?php echo  ltrim(substr($friday_hours['closing'],0,2),'0');?>',
					'<?php echo ltrim(substr($friday_hours['opening'],3,2),'0');?>',
					'<?php echo ltrim(substr($friday_hours['closing'],3,2),'0');?>',
					'<?php echo $friday_hours['close'];?>',
					'<?php echo $timeformat;?>'
				);
				
				var saturday_hours = new Array(
					'<?php echo  ltrim(substr($saturday_hours['opening'],0,2),'0');?>',
					'<?php echo  ltrim(substr($saturday_hours['closing'],0,2),'0');?>',
					'<?php echo ltrim(substr($saturday_hours['opening'],3,2),'0');?>',
					'<?php echo ltrim(substr($saturday_hours['closing'],3,2),'0');?>',
					'<?php echo $saturday_hours['close'];?>',
					'<?php echo $timeformat;?>'
				);
				var calander_business_hours = new Array(sunday_hours,monday_hours,tuesday_hours,wednesday_hours,thursday_hours,friday_hours,saturday_hours);

				//get the working hours when selected any date on the calendar
				function onSelectCalendarDate(dateText, inst) {

					var date;
					if(dateText == '')
						date = new Date();
					else
						date = 	jQuery("#widgetdateselect").datepicker('getDate');
					
					var dayOfWeek = date.getUTCDay();
				
					var applicable_hours = calander_business_hours[dayOfWeek];
					if(applicable_hours[0] == '')
						applicable_hours[0] ='0';
					
					if(applicable_hours[1] == '')
						applicable_hours[1] ='0';
						
					if(applicable_hours[2] == '')
						applicable_hours[2] ='0';
					
					if(applicable_hours[3] == '')
						applicable_hours[3] ='0';
						
					var start_hours = parseInt(applicable_hours[0]);
					var close_hours = parseInt(applicable_hours[1]);
					var start_mins = parseInt(applicable_hours[2]);
					var close_mins = parseInt(applicable_hours[3]);
					var closed = applicable_hours[4];
					var format = applicable_hours[5];

					var options_str = ''; //stores options of the hours

					//handle 24 or 12 hours 
					if(format == 24){
						//handle exceptional cases like close time more than midnight 12
						if(close_hours < start_hours)
							close_hours = 24;
						
						loop_index = 0;
						while(start_hours <= close_hours)  {
						
							start_hours = (start_hours < 10 ? '0' : '') + start_hours
							
							if(loop_index++ == 0) {
								if(start_mins == 0) options_str +='<option value="'+start_hours+':00">'+start_hours+':00</option>';
								if(start_mins <= 15) options_str +='<option value="'+start_hours+':15">'+start_hours+':15</option>';
								if(start_mins <= 30) options_str +='<option value="'+start_hours+':30">'+start_hours+':30</option>';
								if(start_mins <= 45) options_str +='<option value="'+start_hours+':45">'+start_hours+':45</option>';
								start_hours++;
								continue;
							}
							if(start_hours == close_hours) {
								if(close_mins > 0) options_str +='<option value="'+start_hours+':00">'+start_hours+':00</option>';
								if(close_mins > 15) options_str +='<option value="'+start_hours+':15">'+start_hours+':15</option>';
								if(close_mins > 30) options_str +='<option value="'+start_hours+':30">'+start_hours+':30</option>';
								
							} else {
								options_str +='<option value="'+start_hours+':00">'+start_hours+':00</option>';
								options_str +='<option value="'+start_hours+':15">'+start_hours+':15</option>';
								options_str +='<option value="'+start_hours+':30">'+start_hours+':30</option>';
								options_str +='<option value="'+start_hours+':45">'+start_hours+':45</option>';
							}
							
							start_hours++;
						
						}
					}else if(format == 12){
						
						//handle exceptional cases like close time more than midnight 12
						if(close_hours < start_hours)
							close_hours = 24;
						
						loop_index =0;
						while(start_hours <= close_hours)  {							
														
							am_or_pm = start_hours - 12 >= 0? 'PM':'AM';
							if(start_hours>12) {
								hours_label = start_hours - 12;
							}else{ 
								hours_label = start_hours
							}
							hours_label = (hours_label < 10 ? '0' : '') + hours_label;
							
							if(loop_index++ == 0) {
								if(start_mins == 0) options_str +='<option value="'+hours_label+':00">'+hours_label+':00'+am_or_pm+'</option>';
								if(start_mins <= 15) options_str +='<option value="'+hours_label+':15">'+hours_label+':15'+am_or_pm+'</option>';
								if(start_mins <= 30) options_str +='<option value="'+hours_label+':30">'+hours_label+':30'+am_or_pm+'</option>';
								if(start_mins <= 45) options_str +='<option value="'+hours_label+':45">'+hours_label+':45'+am_or_pm+'</option>';
								start_hours++;
								continue;
							}
							if(start_hours == close_hours) {
								if(close_mins > 0) options_str +='<option value="'+hours_label+':00">'+hours_label+':00'+am_or_pm+'</option>';
								if(close_mins > 15) options_str +='<option value="'+hours_label+':15">'+hours_label+':15'+am_or_pm+'</option>';
								if(close_mins > 30) options_str +='<option value="'+hours_label+':30">'+hours_label+':30'+am_or_pm+'</option>';
								
							} else {
								options_str +='<option value="'+hours_label+':00">'+hours_label+':00'+am_or_pm+'</option>';
								options_str +='<option value="'+hours_label+':15">'+hours_label+':15'+am_or_pm+'</option>';
								options_str +='<option value="'+hours_label+':30">'+hours_label+':30'+am_or_pm+'</option>';
								options_str +='<option value="'+hours_label+':45">'+hours_label+':45'+am_or_pm+'</option>';
							}
							
							
							start_hours++;
						}
					}

					jQuery('#reservationtime')
						.find('option')
						.remove()
						.end()
						.append(options_str);
					
				 	if(closed=='on') {
				 		jQuery('#reservationtime_para').hide();
				 		jQuery('#reservationtime_closed_para').show();
				 	} else {
				 		jQuery('#reservationtime_para').show();
				 		jQuery('#reservationtime_closed_para').hide();
					}
				}	

					
				jQuery(document).ready(function() {

					jQuery("#widgetdateselect").datepicker({
						dateFormat: "yy-mm-dd", 
						minDate: 0,
						firstDay: 1,
						altField: "#dateselect",
						onSelect: onSelectCalendarDate
					});
					onSelectCalendarDate('',jQuery("#widgetdateselect").datepicker());					
				});	
			/* ]]> */
			</script>

			<div id="reservationbox">
				<div id="formstatus"></div>
				<?php $reservation_pageid=get_option('atp_bookingpage'); ?>
				<form id="reservationform" action="<?php echo get_permalink($reservation_pageid); ?>" method="get">
					<div id="reservations-calendar-main">
						<p><div id="widgetdateselect"></div><input type="hidden" name="dateselect" id="dateselect" value=""></p>
					</div>
					<p class="people"><label><?php _e('People:','victoria_front');  if ($req) echo " *"; ?></label>
					<select id="numberofpeople" name="numberofpeople">
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
					</select>
					</p>
					<p class="time" id='reservationtime_para'>
						<label><?php _e('Time:', 'victoria_front'); ?>
						<select id="reservationtime" name="reservationtime">
						</select></label>
					</p>
					<p id='reservationtime_closed_para' style='display:none'>
						<label><?php _e('Sorry we are closed on this day', 'victoria_front'); ?></label>
					</p>
					<div class="clear"></div>
					<p><input class="txt input_medium" type="hidden" name="status" id="status" value="unconfirmed" /></p>							
					<p class="center"><button class="button small gray" onclick="showHint()"><span><?php echo get_option('atp_reservationformtxt') ? get_option('atp_reservationformtxt') :'Reserve Table'; ?></span></button><label id="load"></label></p>
					<div class="clear"></div>
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
			$instance['reservation_title'] = strip_tags( $new_instance['reservation_title'] );
			$instance['reservation_subtitle']=strip_tags($new_instance['reservation_subtitle']);
			return $instance;
		}

		// outputs the options form on admin
		function form( $instance ) {
			/* Set up some default widget settings. */
			$instance = wp_parse_args( (array) $instance, array( 'reservation_title' => '','reservation_subtitle' => '' ) );
			$reservation_title = strip_tags($instance['reservation_title']);
			$reservation_subtitle = strip_tags($instance['reservation_subtitle']);?>
			<p>
				<label for="<?php echo $this->get_field_id( 'reservation_title' ); ?>"><?php _e('Title:', 'atp_front'); ?></label>
				<input type="text" id="<?php echo $this->get_field_id('reservation_title'); ?>" name="<?php echo $this->get_field_name('reservation_title'); ?>" value="<?php echo $reservation_title; ?>" style="width:100%;" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'reservation_subtitle' ); ?>"><?php _e('Widget Sub Title:', 'atp_front'); ?></label>
				<input type="text" id="<?php echo $this->get_field_id('reservation_subtitle'); ?>" name="<?php echo $this->get_field_name('reservation_subtitle'); ?>" value="<?php echo $reservation_subtitle; ?>" style="width:100%;" />
			</p>
		<?php 
		} 
	} 
	
	/* Add our function to the widgets_init hook. */
	add_action( 'widgets_init', 'reservation_form_widgets' );
	
?>