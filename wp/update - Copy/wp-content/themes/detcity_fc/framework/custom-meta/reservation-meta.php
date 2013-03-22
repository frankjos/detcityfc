<?php
/* Reservation Meta box setup function. */
$prefix = '';
$reservation_meta_box = array(
	'id'		=> 'reservation-meta-box',
	'title'		=> THEMENAME. ' Reservation Options',
	'page'		=> 'reservations',
	'context'	=> 'normal',
	'priority'	=> 'core',
	'fields'	=> array(
		array(
			'name'	=> 'Number Of People',
			'id'	=> $prefix . 'numberofpeople',
			'desc'	=> 'Enter Number Of People for Table.',
			'type'	=> 'text',
			'std'	=> '2',
		),

		array(
			'name'	=> 'Reservation Date',
			'id'	=> $prefix . 'dateselect',
			'desc' =>'',
			'std'	=> date('Y-m-d'),
			'type'	=> 'date',
		),
		array(
			'name'	=> 'Reservation Time',
			'id'	=> $prefix . 'reservationtime',
			'desc'	=> '',
			'std'	=> '',
			'type'	=> 'time_select',
		),
		array(
			'name'	=> 'Reservation Instructions',
			'id'	=> $prefix . 'reservationinstructions',
			'desc'	=> 'Instructions given by customer for reserving Table.',
			'type'	=> 'textarea',
			'std'	=>'',
		),
		array(
			'name'	=> 'Customer Phone',
			'id'	=> $prefix . 'contactphone',
			'desc'	=> 'Customer phone number',
			'type'	=> 'text',
			'std'	=>'',
		),
		array(
			'name'	=> 'Customer E-mail',
			'id'	=> $prefix . 'contactemail',
			'desc'	=> 'Customer contact E-mail ID',
			'type'	=> 'text',
			'std'	=> '',
		),
		array(
			'name'	=> 'Reservation Status',
			'id'	=> $prefix . 'status',
			'desc'	=> 'Status of the Reservation for the Table.',
			'type'	=> 'select',
			'std'	=> '',
			'options'=> array(
				"unconfirmed"  => "UnConfirmed",
				"confirmed"    => "Confirmed",
				"cancelled"    => "Cancelled"
			)
		)
	),
);

add_action('admin_menu', 'reservation_add_box');
function reservation_jquery()
{
	
	wp_enqueue_script('	jquery-ui-core');
	wp_enqueue_script('atp-datepicker', ATP_DIRECTORY .'/framework/admin/js/jquery.datepicker.js','jquery','','in_footer');
	
}
function reservation_style()
{
	wp_enqueue_style('atp-datestyle', ATP_DIRECTORY .'/framework/admin/css/pepper-grinder/jquery-ui-1.8.16.custom.css');

}
add_action('admin_print_scripts', 'reservation_jquery');
add_action('admin_print_styles', 'reservation_style');
	// Add meta box
	function reservation_add_box() {
		global $reservation_meta_box;
		add_meta_box($reservation_meta_box['id'], $reservation_meta_box['title'], 'reservation_show_box', $reservation_meta_box['page'], $reservation_meta_box['context'], $reservation_meta_box['priority']);
	}

	// Callback function to show fields in meta box
	function reservation_show_box() {
		global $reservation_meta_box, $post,$sidebarwidget;;
		// Use nonce for verification
		echo '<input type="hidden" name="reservation_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
		echo '<div class="atp_meta_options">';
		foreach ($reservation_meta_box['fields'] as $field) {
		
		
			// get current post meta data
			$meta = get_post_meta($post->ID, $field['id'], true);
			if($meta == "")
				$meta = $field['std'];
			echo '<div class="atp_options_box"><div class="glowborder">',
				'<div class="atp_description"><label for="', $field['id'], '">', $field['name'], '</label><p>',$field['desc'],'</p></div>',
				'<div class="atp_inputs">';
			switch ($field['type']) {
				case 'text':
					echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />';
					break;
				case 'date':
					echo'<script type="text/javascript">
					/* <![CDATA[ */
						jQuery(document).ready(function() {
							
								jQuery("#'.$field['id'].'").datepicker({ dateFormat: "yy-mm-dd" });
					
					});
					/* ]]> */
					</script>';
					echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />';
					break;
				case 'textarea':
					echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>';
					break;
				case 'color':
				?>
				<script type="text/javascript" language="javascript">
				jQuery(document).ready(function($) { 
					jQuery('#<?php echo $field['id']; ?>').children('div').css('backgroundColor', '<?php echo $meta ? $meta : $field['std']; ?>'); 
				jQuery('#<?php echo $field['id']; ?>').ColorPicker({
							color: '<?php echo $meta ? $meta : $field['std']; ?>',
							onShow: function (colpkr) {
								jQuery(colpkr).fadeIn(500);
								return false;
							},
							onHide: function (colpkr) {
								jQuery(colpkr).fadeOut(500);
								return false;
							},
							onChange: function (hsb, hex, rgb) {
								jQuery('#<?php echo $field['id']; ?> div').css('backgroundColor', '#' + hex);
								jQuery('#<?php echo $field['id']; ?>').next('input').attr('value','#' + hex);
							}
						});
						});
				</script>
				<div id="<?php echo $field['id']; ?>" class="colorSelector"><div></div></div>
				<?php echo '<input class="atp-color"  name="'. $field['id'] .'" id="'. $field['id'] .'" type="text" value="', $meta ? $meta : $field['std'], '"  />';
			break;			
			case 'select':
					echo '<select name="', $field['id'], '" id="', $field['id'], '">';
				foreach ($field['options'] as  $key => $value) {
					echo '<option value="' . $key . '" ', $meta == $key ? ' selected="selected"' : '', '>', $value, '</option>';
				}
				echo '</select>';
					break;
				case 'time_select':
					echo '<select name="', $field['id'], '" id="', $field['id'], '">';
					$timeformat=get_option('atp_timeformat');
					if( $timeformat =="24")	{
						for ($i = 0; $i < 24; $i++){ 
									$h = $i;
							if ( $h< 10 && $h >= 0 ) { $h = '0' . $h; }
									$hours=$h.':00';
									
							if($meta === $hours){
								$active = 'selected="selected"'; 
							} else { 
								$active = ''; 
							}
							echo '<option value="' . $h . ':00" ', $meta == $hours ? ' selected="selected"' : '', '>',$h.':00','</option>';
						}
					}
					if( $timeformat =="12")	{
						for ($i = 0; $i < 24; $i++){ 
							$h = $i;
							$hh='AM';
							if ( $h< 10 && $h >= 0 ) { 
								$h1 = '0' . $h; 
							}
							if ( $h< 10 && $h >= 0 ) { 
								$h = '0' . $h; 
							}
							$hours=$h.':00';
							if($i == '12')	{
								$hh='PM';
							}
							if($i > 12)	{
								$h1=$i-12;
								$hh='PM';
							}	
							if($meta === $hours){
								$active = 'selected="selected"'; 
							} else { 
								$active = ''; 
							}
							echo '<option value="' . $h . ':00" ', $meta == $hours ? ' selected="selected"' : '', '>', $h1.':00',$hh,'</option>';
						}
					}
					echo '</select>';
					break;
				case 'customselect':
					echo '<select name="', $field['id'], '" id="', $field['id'], '">';
					echo '<option value="">select</option>';
					if($sidebarwidget!=""){
						foreach ($field['options'] as $key => $value) {
							echo '<option value="'.$value.'"', $meta == $value ? ' selected="selected"' : '', '>', $value, '</option>';
						}
					}
					echo '</select>';
					break;
				case 'radio':
					foreach ($field['options'] as $key => $value) {
						echo '<label class="rlabel"><input onclick="sys_custom_url_meta()" type="radio" name="', $field['id'], '" value="', $key, '"', $meta == $key ? ' checked="checked"' : '', ' />', $value,'</label>';
					}
					global $post;
					$custom = get_post_custom($post->ID);
					if(isset($custom['link_page'])){
						$link_page = $custom["link_page"][0]; }
						if(isset($custom['link_cat'])){
						$link_cat = $custom["link_cat"][0]; }
						if(isset($custom['link_post'])){ $link_post = $custom["link_post"][0]; }
						if(isset($custom['link_manually'])){ $link_manually = stripslashes($custom["link_manually"][0]);  }
						echo'<div id="customurl" >';
						echo'<div id="sys_link" class="postlinkurl linkpage">';
						echo '<select name="link_page">';
						echo '<option value="">Select Page</option>';
						foreach(get_custom_options('page') as $key => $option) {
							echo '<option value="' . $key . '"';
							if ($key == $link_page) {
								echo ' selected="selected"';
							}
							echo '>' . $option . '</option>';
						}
						echo '</select>';	
						echo '</div>';
						echo'<div id="sys_category" class="postlinkurl linktocategory">';
						echo '<select name="link_cat">';
						echo '<option value="">Select Category</option>';
						foreach(get_custom_options('cat') as $key => $option) {
							echo '<option value="' . $key . '"';
							if ( $key == $link_cat) {
								echo ' selected="selected"';
							}
							echo '>' . $option . '</option>';
						}
						echo '</select>';	
						echo '</div>';
						echo'<div id="sys_post" class="postlinkurl linktopost">';
						echo '<select name="link_post">';
						echo '<option value="">Select Post</option>';
						foreach(get_custom_options('post') as $key => $option) {
							echo '<option value="' . $key . '"';
							if ($key == $link_post) {
								echo ' selected="selected"';
							}
							echo '>' . $option . '</option>';
						}
						echo '</select>';	
						echo '</div>';
				
						echo'<div id="sys_manually" class="postlinkurl linkmanually">';
						if(isset($link_manually)){
						echo'<input type="text" name="link_manually"  value="'.$link_manually.'"  size="50%" />';
						}else{ 
							echo'<input type="text" name="link_manually"  value=""  size="50%" />';
						}
						echo '</div></div>';
						break;
					case 'upload':
						echo '<table>';
						echo '<tr valign="top">';
						echo '<th scope="row">Upload Image</th>';
						echo '<td><label for="upload_image">';
						echo '<input value="'.stripslashes(get_post_meta($post->ID, $field['id'], true)).'" type="text" name="'.$field['id'].'"  id="'.$field['id'].'" size="50%" />';
						echo '<input class="upload_image_button"  id="'.$field['id'].'" type="button" value="Upload Image" />';
						echo '</label></td><td id="id="'.$field['id'].'"></td>';
						echo '</tr></table>';
						break;
					case 'checkbox':
						echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
						break;
					}
					echo	'</div><div class="clear"></div>';
					echo 	'</div></div>';
				}
				echo '</div>';
			}
		
		add_action('save_post', 'reservation_save_data');
		
// Save data from meta box
function reservation_save_data($post_id) {
$title=get_the_title($post_id);

	global $reservation_meta_box;
	if (!wp_verify_nonce(isset($_POST['reservation_meta_box_nonce']), basename(__FILE__))) {
		return $post_id;
	}
	$status_changed=get_option('atp_status');
	$placeholders = array('[contact_name]','[number_of_people]','[reservation_date]','[reservation_time]','[restaurant_name]','[reservation_status]');$values = array(get_the_title($post_id),$_POST['numberofpeople'],$_POST['dateselect'],$_POST['reservationtime'],get_bloginfo('name'),$_POST['status']);	
	$status_changed_email_msg = str_replace($placeholders,$values,$status_changed); //replace the placeholders
	
	$statussubject=get_option('atp_statussubject');
						
		$placeholders = array('[restaurant_name]','[booking_id]');
		$values = array(get_bloginfo('name'),$post_id);
		$status_email_subject = str_replace($placeholders,$values,$statussubject); //replace the placeholders
							
		$aivahBooking_email=$_POST['contactemail'];
		
	$headers = 'From: ' . get_option('blogname') . ' Reservations <' . get_option('admin_email') . '>' . "\r\n\\";


		wp_mail($aivahBooking_email,$status_email_subject, $status_changed_email_msg,$headers);
	

	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}

	// check permissions
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id)) {
			return $post_id;
		}
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}
	
	foreach ($reservation_meta_box['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		
		if ($new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	}
}
?>