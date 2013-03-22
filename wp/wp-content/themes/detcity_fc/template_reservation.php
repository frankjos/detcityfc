<?php
/*
Template Name: Reservation
*/
get_header();
?>
<?php

	/**
	 * Required Variables
	 * Get variables info from theme options panel
	 */

	global $atp_teaser, $atp_breadcrumbs;
	$sidebaroption = get_post_meta($post->ID, "sidebar_options", TRUE);
	$subheader_teaser_options = get_post_meta($post->ID, "subheader_teaser_options", true);
	?>
	<?php if ( get_post_meta($post->ID, 'page_bg_image', true) ) : ?>
	<img id="pagebg" src="<?php echo get_post_meta($post->ID, "page_bg_image", true); ?>" />
	<?php endif; ?>
<?php 
	if($atp_teaser !="disable") { 
		if($subheader_teaser_options !="disable") { ?>
	<div class="subheader" id="subheader" <?php  echo subheadercolor($post->ID); ?>>
		<div class="subheader_teaser">
			<?php subheaderteaser($post->ID); ?>
		</div>
	</div>
	<?php } 
	} ?>
	<!-- #subheader -->

	<div class="pagemid fullwidth">
		
		<div class="inner">
	
			<div id="mainfull">
			
				<?php $atp_breadcrumbs ? my_breadcrumb():''; ?>
				<!-- #breadcrumbs -->
			
				<div class="content">
					<?php 
						the_content();
					
						// Get Hours settings from theme options panel
						$sunday_hours = get_option('atp_sunday');
						$monday_hours = get_option('atp_monday');
						$tuesday_hours = get_option('atp_tuesday');
						$wednesday_hours = get_option('atp_wednesday');
						$thursday_hours = get_option('atp_thursday');
						$friday_hours = get_option('atp_friday');
						$saturday_hours = get_option('atp_saturday');

						$timeformat = get_option('atp_timeformat');//get timeformat
					?>
					<script type="text/javascript">
					function validateresult() {
					jQuery.post('<?php echo get_template_directory_uri(); ?>/reservation_insert.php', 
						jQuery("#reserveformid").serialize(),
						function(responseText) {
							document.getElementById("formstatus").innerHTML=responseText;
							if(responseText.search('success')>-1){
								document.reserveform.reset();
							}
						});
					}
					</script>
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
								date = new Date(dateText);
								
							var dayOfWeek = date.getUTCDay();	
							var applicable_hours = calander_business_hours[dayOfWeek];
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
							jQuery("#reservationtime").val('<?php echo $_GET['reservationtime']?>');
							if(closed=='on') {
								jQuery('#reservationtime_para').hide();
								jQuery('#reservationtime_closed_para').show();
							} else {
								jQuery('#reservationtime_para').show();
								jQuery('#reservationtime_closed_para').hide();
							}
							
							//select numberofpeople
							jQuery("#numberofpeople").val('<?php echo $_GET['numberofpeople']?>');
						}

						jQuery(document).ready(function() {
							jQuery("#widgetdateselect").datepicker({
								dateFormat: "yy-mm-dd", 
								minDate: 0,
								firstDay: 1,
								altField: "#dateselect",
								<?php if(isset( $_GET['dateselect'])){ ?>defaultDate: '<?php echo $_GET['dateselect']; ?>',<?php } ?>
								onSelect: onSelectCalendarDate
							});
							<?php if(isset( $_GET['dateselect'])){ ?>
							onSelectCalendarDate('<?php echo $_GET['dateselect']; ?>',jQuery("#widgetdateselect").datepicker());
							<?php } else { ?>
							onSelectCalendarDate('',jQuery("#widgetdateselect").datepicker());
							<?php } ?>
						});	
					/* ]]> */
					</script>
					<div id="reservationform">
						<div id="formstatus"></div>
						
						<form id="reserveformid" name="reserveform" action="<?php echo get_template_directory_uri();?>/reservation_insert.php" method="post">
							<div class="one_third">
								
								<h4><?php echo $reservationleftsidetext; ?></h4>
								<div id="widgetdateselect" name="widgetdateselect"></div>	
								<input type="hidden" name="dateselect" id="dateselect" value="">
							</div>
							
							<div class="two_third last">
								<div class="reservationform">
									<h4><?php echo $reservationinformationtext; ?></h4>
									<p>
									<span class="people">
									<label><?php _e('People:','victoria_front'); ?></label>
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
									</span>
									<!-- .people -->
									<span id="reservationtime_para"  class="time">
										<label><?php _e('Time:', 'victoria_front'); ?></label>
										<select id="reservationtime" name="reservationtime">
										</select>
									</span>
									<!-- .time -->
									
									<span id='reservationtime_closed_para' style='display:none'>
										<span class="closed"><?php _e('Sorry we are Closed this day', 'victoria_front'); ?></span>
									<!-- .closed -->
									</span>
									</p>
									<p><label><?php _e('Name:','victoria_front'); ?></label><input class="txt input_medium" type="text" name="contactname" id="contactname" value="" /></p>	
									<p><label><?php _e('Phone:', 'victoria_front'); ?></label><input class="txt input_medium" type="text" name="contactphone" id="contactphone" value="" /><//p>
									<p><label><?php _e('Email:', 'victoria_front'); ?></label><input class="txt input_medium" type="text" name="contactemail" id="contactemail" value="" /></p>
									<p><label><?php _e('Notes:', 'victoria_front'); ?></label><textarea class="input_medium" name="reservationinstructions" rows="6" cols="20"></textarea></p>
									<p><input class="txt input_medium" type="hidden" name="status" id="status" value="unconfirmed" /></p>							
									<p class="submit"><label id="load"></label><a class="button small gray" onclick="validateresult()"><span><?php echo get_option('atp_reservationformtxt') ? get_option('atp_reservationformtxt') :'Reserve Table'; ?></span></a></p>
								</div>
								<!-- .reservationform -->
							</div>
							<!-- .two_third / last -->
						</form>

						<div class="clear"></div>
					</div>
					<!-- #reservationform -->

				</div>
				<!-- .content -->
			</div>
			<!-- #main -->
			
			<div class="clear"></div>

		</div>
		<!-- .inner -->
	
		<div id="back_to_top"><a href="#header">Top</a></div>

	</div>
	<!-- .pagemid -->
	
<?php get_footer(); ?>