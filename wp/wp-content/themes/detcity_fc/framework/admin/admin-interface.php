<?php
/** 
 * function optionsframework_add_admin - Load static framework options pages
 *
 */ 
function optionsframework_add_admin() {

    global $query_string, $options, $icon;
    
    /**
	 *
	 */
	if ( isset($_REQUEST['page']) && $_REQUEST['page'] == 'optionsframework' ) {
		if (isset($_REQUEST['atp_save']) && 'reset' == $_REQUEST['atp_save']) {
			atp_reset_options($options, 'optionsframework');
			header("Location: admin.php?page=optionsframework&reset=true");
			die;
		}
    }
		
	/**
	 * Add a top level menu page in the 'objects' section
	 *
	 * @param string 'THEMENAME' The text to be displayed in the title tags of the page when the menu is selected
	 * @param string 'THEMENAME' The text to be used for the menu
	 * @param string 'edit_theme_options' The capability required for this menu to be displayed to the user.
	 * @param string 'optionsframework' The slug name to refer to this menu by (should be unique for this menu)
	 * @param callback 'optionsframework_options_page' The function to be called to output the content for this page.
	 * @param string '$icon' The url to the icon to be used for this menu
	 *
	 * @return string The resulting page's hook_suffix
	 */
	if(function_exists('add_object_page')) {
		add_object_page(THEMENAME, THEMENAME, 'edit_theme_options','optionsframework', 'optionsframework_options_page', $icon);		
	}

	/**
	 * Add a sub menu page
	 *
	 * @param string 'optionsframework' The slug name for the parent menu (or the file name of a standard WordPress admin page)
	 * @param string 'THEMENAME' The text to be displayed in the title tags of the page when the menu is selected
	 * @param string 'Theme Options' The text to be used for the menu
	 * @param string 'edit_theme_options' The capability required for this menu to be displayed to the user.
	 * @param string 'optionsframework' The slug name to refer to this menu by (should be unique for this menu)
	 * @param callback 'optionsframework_options_page' The function to be called to output the content for this page.
	 *
	 * @return string|bool The resulting page's hook_suffix, or false if the user does not have the capability required.
	 */
	$atp_page = add_submenu_page('optionsframework',THEMENAME, 'Theme Options', 'edit_theme_options', 'optionsframework','optionsframework_options_page'); // Default
	$advance = add_submenu_page('optionsframework','Advance', 'Advance', 'edit_theme_options', 'advance','optionsframework_options_page'); // Default

	/** 
	 * Hooks a function on to a specific action.
	 * Runs in the HTML header so a admin framework can add JavaScript scripts to all admin pages.
	 */
	add_action("admin_print_scripts-$atp_page", 'atp_load_only');
	add_action("admin_print_styles-$atp_page",'atp_style_only');
	add_action("admin_print_scripts-$advance", 'atp_load_only');
	add_action("admin_print_styles-$advance",'atp_style_only');
} 

/** 
 * Hooks for adding admin menu
 */
 add_action('admin_menu', 'optionsframework_add_admin');

/** 
 * Function atp_reset_options - 
 * updates the atp_template_option_values option value in wp_options table
 */
function atp_reset_options($options, $page = 'optionsframework') {
	$output = unserialize(base64_decode(get_option('atp_default_template_option_values')));
	update_option_values($options,$output);
	update_option('atp_template_option_values',$output);
}

/**
 * function optionsframework_options_page -  Builds the Options Page
 * optionsframework_options_page 
 * ########################  Theme Options ########################
 */
function optionsframework_options_page(){
    global $options, $advance_options, $theme_name, $themeversion;		
	
?>
<div class="wrap" id="atp_container">
	<div id="atp-popup-save" class="atp-save-popup">
		<div class="atp-save-save">Options Updated</div>
	</div>
	<div id="atp-popup-reset" class="atp-save-popup">
		<div class="atp-save-reset">Options Reset</div>
	</div>
		
	<form action="" enctype="multipart/form-data" id="atpform" method='post'>
	<div class="atpinterface">
		<!-- #atp_header -->
		<div id="atp_header">
			<div class="panelinfo">
				<span>Framework Version : <?php echo FRAMEWORK; ?></span>
				<span class="themename"><?php echo $theme_name; ?> Theme Version : <?php echo $themeversion; ?></span>
			</div>
		</div>
		<!-- #atp_header -->
	
		<!-- #atp_subheader -->
		<div id="atp_subheader">
			<div class="sublinks">
			</div>
			<div class="savelink">
				<img style="display:none" src="<?php echo get_stylesheet_directory_uri(); ?>/framework/admin/images/ajax-loader.gif" class="ajax-loading-img ajax-loading-img-bottom" alt="Working..." />
				<input type="submit" value="Save All Changes" class="button-primary" />
			</div>
		</div>
		<!-- #atp_subheader -->	

		<?php
		
		//get all the options based on menu/page selection
		switch($_GET['page'])  {
			case 'advance' :
							$return = optionsframework_machine($advance_options);
							break;
			case 'optionsframework' : 			
							$return = optionsframework_machine($options);
							break;
		}
		// Rev up the Options Machine
		//$return = optionsframework_machine($options);
		?>

		<div id="main">

			<div id="atp-nav">
				<ul>
					<?php echo $return[1] ?>
				</ul>
			</div>
			
			<div id="content">
				<?php echo $return[0]; /* Settings */ ?>
			</div>
			
			<div class="clear"></div>
		</div>
		
		<div class="save_bar_top">
			<img style="display:none" src="<?php echo get_stylesheet_directory_uri(); ?>/framework/admin/images/ajax-loader.gif" class="ajax-loading-img ajax-loading-img-bottom" alt="Working..." />
			<input type="submit" value="Save All Changes" class="button-primary" />
			</form>

			<form action="<?php echo esc_attr( $_SERVER['REQUEST_URI'] ) ?>" method="post" style="display:inline" id="atpform-reset">
				<span class="submit-footer-reset">
					<input name="reset" type="submit" value="Reset Options" class="button submit-button reset-button" onclick="return confirm('Click OK to reset. Any settings will be lost!');" />
					<input type="hidden" name="atp_save" value="reset" />
				</span>
			</form>
		</div>
<div class="credits">
<p>Header/Button Graphics <a href="http://www.premiumpixels.com/freebies/onoff-switches-and-toggles-psd/" target="_blank">PremiumPixels</a> &bull; Framework <a href="http://www.aivahthemes.com/" target="_blank">AivahThemes</a> &bull; Icons <a href="http://www.aivah.com" target="_blank">Aivah</a></p>
</div>
	<?php  if (!empty($update_message)) echo $update_message; ?>
	<div style="clear:both;"></div>
</div>
<!--wrap atp_container-->
<?php } 

/**
 * Load required styles for Options Page - of_style_only 
 */
	function atp_style_only() {
		wp_enqueue_style('admin-style', ATP_DIRECTORY.'/framework/admin/admin-style.css');
	}	
	
/**
 * Load required javascripts for Options Page - of_load_only
 */
	function atp_load_only() {
		add_action('admin_head', 'atp_admin_head');
		//wp_register_script('jquery-ajaxhandler', ATP_DIRECTORY.'/framework/admin/js/ajaxhandler.js', array( 'jquery' ));
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ajaxhandler', ATP_DIRECTORY.'/framework/admin/js/ajaxhandler.js', array( 'jquery' ));
		wp_enqueue_script('color-picker', ATP_DIRECTORY.'/framework/admin/js/colorpicker.js', array('jquery'));
		wp_enqueue_script('ajaxupload', ATP_DIRECTORY.'/framework/admin/js/ajaxupload.js', array('jquery'));
		wp_enqueue_script('iphonecheckbox', ATP_DIRECTORY.'/framework/admin/js/iphone-style-checkboxes.js', array('jquery'));
	}

/**
 * function atp_admin_head - loads script in admin header
 */
 function atp_admin_head() {

  //variables
	global $wpdb,$options;
	
 //get all info/data necessary into variables
 
 /** START neccessary variables for social **/
	$socialimages=array();
				if(is_dir(TEMPLATEPATH . "/images/followus/")) {
					if($socialimages_dirs = opendir(TEMPLATEPATH . "/images/followus/")) {
						while(($socialimage = readdir($socialimages_dirs)) !== false) {
							if(preg_match_all('!.+\.(?:jpe?g|png|gif)!Ui',$socialimage, $matches)){
								$socialimages[] = $socialimage;
							}
						}
					}
				}
	$sysimgpath=get_template_directory_uri(); 

 /** END necessary variables for social **/
 
  /** START neccessary variables for colorpicker **/
  //loop through options findout for colorpickers
	$color_pickers_arr = array();
	foreach($options as $option){ 
	
		switch($option['type']) {
			case 'typography':
			case 'border':
			case 'background':
				$temp_color = get_option($option['id']);
				$color_pickers_arr[] = array('option_id' => $option['id'] . '_color', 'color' => $temp_color['color']);
				break;
			case 'color':
				$color_pickers_arr[] = array('option_id' => $option['id'], 'color' => get_option($option['id']));								
				break;
			}
		}

	/** END necessary variables for colorpicker **/
?>
<script type="text/javascript" language="javascript">
	/** START code for handling social items **/
	jQuery(document).ready(function(){ 
	
		/** handle DELETE action **/
		jQuery('.sys_social_item_delete').click(function() {
			jQuery(this).closest('tr').remove();
		});
			
		/** ------------ **/
		jQuery('.button-primary').click(function() {
			var sys_social_data = '';
			jQuery('#sys_socialbookmark tr').each(function() {
				social1 = jQuery(this).find('.sys_social_title').val();
				social2 = jQuery(this).find('.sys_social_file_icon').val();
				social3 = jQuery(this).find('.sys_social_account_url').val();
				
				if (social1 !== undefined) {
					social1 = social1.replace(/#;/g, '').replace(/#\|/g, '');
					social2 = social2.replace(/#;/g, '').replace(/#\|/g, '');
					social3 = social3.replace(/#;/g, '').replace(/#\|/g, '');
					
					sys_social_data =  sys_social_data + social1 + '#|' + social2 + '#|' + social3 + '#;';
				}
			});
		
			sys_social_data = sys_social_data.substr(0, sys_social_data.length - 2);
			document.getElementById('atp_social_bookmark').value = sys_social_data;
		});
	
		/** handle ADD action **/
			jQuery('#sys_add_social_item').click(function() { 
				jQuery('#sys_socialbookmark tr:last').after('' +
				'<tr>' +
				'<td align="center" width="70"><a href="#" class="sys_social_item_delete btn small red"><span>x</span></a></td>' +
				'<td width="50"><input type="text"  class="sys_social_title" /></td>' +
					'<td width="50"><select class="sys_social_file_icon" name="sys_social_file_icon" ><?php 
					foreach ( $socialimages as $key => $values) { 
					echo "<option   style=".'background:url('.$sysimgpath.'/images/followus/'.$values.');'." value=".$values.">$values</option>"; } ?></select></td>' +
					'<td width="70"><input type="text"  class="sys_social_account_url"/></td>' +
					'</tr>'
				);
				jQuery('.sys_social_item_delete').click(function() {
					jQuery(this).closest('tr').remove();
					return false;
				});
			});
			

	});    
	/** END code for handling social items **/
	
	/** START code for handling Color Picker **/
	jQuery(document).ready(function(){
		//Color Picker
		<?php
		foreach($color_pickers_arr as $color_picker) {
			$option_id = $color_picker['option_id'];
			$color = $color_picker['color'];
		?>
		jQuery('#<?php echo $option_id; ?>_picker').children('div').css('backgroundColor', '<?php echo $color; ?>');
		jQuery('#<?php echo $option_id; ?>_picker').ColorPicker({
			color: '<?php echo $color; ?>',
			onShow: function (colpkr) {
				jQuery(colpkr).fadeIn(500);
				return false;
			},
			onHide: function (colpkr) {
				jQuery(colpkr).fadeOut(500);
				return false;
			},
			onChange: function (hsb, hex, rgb) {
				//jQuery(this).css('border','1px solid red');
				jQuery('#<?php echo $option_id; ?>_picker').children('div').css('backgroundColor', '#' + hex);
				jQuery('#<?php echo $option_id; ?>_picker').next('input').attr('value','#' + hex);
			}
		});
		<?php	
			} // end of loop color_pickers_arr 
		?>
	});
	/** END code for handling Color Picker **/
	</script>
	<?php
	//AJAX Upload
	?>
	<script type="text/javascript">
	 var querystring_reset = '<?php echo $_REQUEST['reset'];?>';
	 var admin_ajax_url = '<?php echo admin_url("admin-ajax.php"); ?>';
	 var querystring_page = '<?php echo $_REQUEST['page']; ?>';
	</script>
	
<?php } ?>
<?php
/** 
 * Ajax Save Action - of_ajax_callback 
 */
add_action('wp_ajax_atp_ajax_post_action', 'atp_ajax_callback');

function atp_ajax_callback() {

	global $wpdb,$options; // this is how you get access to the database

	$save_type = $_POST['type'];
	//Uploads
	if($save_type == 'upload'){
		
		$clickedID = $_POST['data']; // Acts as the name
		$filename = $_FILES[$clickedID];
       	$filename['name'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', $filename['name']); 
		
		$override['test_form'] = false;
		$override['action'] = 'wp_handle_upload';    
		$uploaded_file = wp_handle_upload($filename,$override);
		
		$upload_tracking[] = $clickedID;
		update_option( $clickedID , $uploaded_file['url'] );
		
		if(!empty($uploaded_file['error'])) {
			echo 'Upload Error: ' . $uploaded_file['error']; 
		}else{ 
			echo $uploaded_file['url']; 
		} // Is the Response
		exit;
	}
	elseif($save_type == 'image_reset'){

		$id = $_POST['data']; // Acts as the name
		global $wpdb;
		$query = "DELETE FROM $wpdb->options WHERE option_name LIKE '$id'";
		$wpdb->query($query);

	}	
	elseif($save_type == 'advance_options') {
      $data = $_POST['data'];
			parse_str($data,$output);

     	//check whether import process initiated, if yes then pull the values from atp_template_option_values in submitted form
			if($output['atp_template_option_values']!='') {
				$output = unserialize(base64_decode($output['atp_template_option_values']));
				update_option('atp_template_option_values',$output);//updates the atp_template_option_values option value in wp_options table
			}
			
			update_option_values($options,$output);
		
	}
	elseif ($save_type == 'options' OR $save_type == 'framework') {
	
		$data = $_POST['data'];
		$import_process_initiated = false; //to identify whether saving/updating the settings, this becomes true when action performed through advance options
		parse_str($data,$output);

			
		update_option_values($options,$output);

		$output['atp_template_option_values']=''; //remove the content of atp_template_option_values,as we need not store
		update_option('atp_template_option_values',$output);//updates the atp_template_option_values option value in wp_options table
		
	die();
  }
}

/*** update_option_values -- Updates option values ***/
/*---------------------------------------------------*/
function update_option_values($options,$output) {
    
    //loop through the template options
		foreach($options as $option_array){

			$id = $option_array['id'];
			$old_value = get_option($id);
			$new_value = '';
			
			if(isset($output[$id])){
				$new_value = $output[$option_array['id']];
			}
			
			if(isset($option_array['id'])) { // Non - Headings...

					$type = $option_array['type'];		

					if ( is_array($type)){
						foreach($type as $array){
							if($array['type'] == 'text'){
								$id = $array['id'];
								$std = $array['std'];
								$new_value = $output[$id];
								if($new_value == ''){ $new_value = $std; }
								$new_value =  stripslashes($new_value);
							}
						if($type == 'custom_socialbook_mark'){
							$id = $array['id'];
								$std = $array['std'];
								$new_value = $output[$id];
								if($new_value == ''){ $new_value = $std; }
								$new_value =  stripslashes($new_value);
					}
						}                 
					}
					elseif($type == 'select'){
						$new_value = $output[$option_array['id']];
					}
					elseif($type == 'checkbox'){ // Checkbox Save
						$new_value = $output[$option_array['id']];
						$new_value !=''? 'on':'off';						
					}
					elseif($type == 'multicheck'){ // Multi Check Save
						$new_value = array();	
						$new_value = $output[$option_array['id']];
					}elseif($type == 'drogdropcheck'){ // Multi Check Save
						$new_value = array();	
						$new_value = $output[$option_array['id']];
					}elseif($type == 'businesshours'){
						$businesshours_array = array();	
						$businesshours_array['opening'] = $output[$option_array['id'] . '_opening'];
						$businesshours_array['closing'] = $output[$option_array['id'] . '_closing'];
						$businesshours_array['close'] = stripslashes($output[$option_array['id'] . '_close']);
						$new_value = $businesshours_array;	
					}elseif($type == 'typography'){
						$typography_array = array();	
						$typography_array['size'] = $output[$option_array['id'] . '_size'];
						$typography_array['lineheight'] = $output[$option_array['id'] . '_lineheight'];
						$typography_array['face'] = stripslashes($output[$option_array['id'] . '_face']);
						$typography_array['style'] = $output[$option_array['id'] . '_style'];
						$typography_array['color'] = $output[$option_array['id'] . '_color'];
						$new_value = $typography_array;							
					}elseif($type == 'background'){
						$background_array = array();	
						$background_array['image'] = $output[$option_array['id'] . '_image'];
						$background_array['color'] = $output[$option_array['id'] . '_color'];
						$background_array['style'] = $output[$option_array['id'] . '_style'];
						$background_array['position'] = $output[$option_array['id'] . '_position'];
						$background_array['attachment'] = $output[$option_array['id'] . '_attachment'];
						$new_value = $background_array;
					}
					elseif($type == 'teaserselect'){
						$teaserselect_array = array();	
						$teaserselect_array['options'] = $output[$option_array['id'] . '_options'];
						$teaserselect_array['custom'] = stripslashes($output[$option_array['id'] . '_custom']);
						$teaserselect_array['twitter'] = $output[$option_array['id'] . '_twitter'];
						$new_value = $teaserselect_array;	
					}elseif($type == 'customsidebar'){ 
						$new_value = array();	
						$new_value = $output[$option_array['id']];
					}
					elseif($type == 'sliderselect'){
						$sliderselect_array = array();	
						$sliderselect_array['slider'] = $output[$option_array['id'] . '_slider'];	
						$new_value = $sliderselect_array;
					}
					elseif($type == 'border'){
						$border_array = array();	
						$border_array['width'] = $output[$option_array['id'] . '_width'];
						$border_array['style'] = $output[$option_array['id'] . '_style'];
						$border_array['color'] = $output[$option_array['id'] . '_color'];
						$new_value = $border_array;
					}
					elseif($type != 'upload_min'){
						$new_value = stripslashes($new_value);
					}
			}
			
			//update option values
			 update_option($id,$new_value);
		}
}

/*** Generates The Options Within the Panel - optionsframework_machine ***/
/*-----------------------------------------------------------------------*/
function optionsframework_machine($options) {

    $counter = 0;
	$menu = '';
	$output = '';
	foreach ($options as $value) {
	   
		$counter++;
		$val = '';
		//Start Heading
		if ( $value['type'] != "heading" ) {
			$class = ''; if(isset( $value['class'] )) { $class = $value['class']; }
			$output .= '<div  class="section section-'.$value['type'].' '. $class .'">'."\n";
			$output .= '<h3 class="heading">'. $value['name'] .'</h3>'."\n";
			$output .= '<div class="option">'."\n" . '<div class="controls" >'."\n";
		} 
		//End Heading
		$select_value = '';                                   
		switch ( $value['type'] ) {
		
			/****** Subtitle ******/
			/*--------------------*/
			case 'subsection':
				$default = $value['name'];
				$output .= $default;
				break;
			/****** Text ******/
			/*----------------*/
			case 'text':
				$val = $value['std'];
				$inputsize = isset($value['inputsize']) ? $value['inputsize'] : '10';
				$std = get_option($value['id']);
				if ( $std != "") { $val = $std; }
				$output .= '<input class="atp-input" name="'. $value['id'] .'" id="'. $value['id'] .'" type="'. $value['type'] .'" value="'. $val .'" style="width:'. $inputsize.'px" />';
				break;
			/****** Cufon Font ******/
			/*----------------*/
			case 'cufonlive':
				$val = $value['std'];
				$std = get_option($value['id']);
				if ( $std != "") { $val = $std; }
				$output .= '<span class="cufonlive">'.$value['std'].'</span>';
				break;
			
			/****** Select ******/
			/*------------------*/
			case 'select':
				$output .= '<select class="of-input" name="'.$value['id'].'" id="'. $value['id'] .'">';
				foreach ($value['options'] as $key => $option) {
					$output .= '<option value="'.$key.'" ' . selected(get_option($value['id']),$key, false) . ' />'.$option.'</option>';
				} 
				$output .= '</select>';
				break;
			
			/****** Custom Sociables ******/
			/*----------------------------*/
			case 'custom_socialbook_mark':
				global $socialimages_select;
				$output .= '<div id="sys_social_book">';
				$output .= '<h2>Social Networking Sites</h2>';	
				$output .= '<table id="sys_socialbookmark" class="fancy_table">';
				$output .= '<tr>';
				$output .= '<th>Delete</th>';
				$output .= '<th>Title</th>';
				$output .= '<th>Icon</th>';
				$output .= '<th>URL (prefix http://)</th>';
				$output .= '</tr>';
			
			 
				if (get_option('atp_social_bookmark') != '') {
				$sys_social_items = explode('#;', get_option('atp_social_bookmark'));
						for($i=0;$i<count($sys_social_items);$i++) {
							$sys_social_item = explode('#|', $sys_social_items[$i]);
							$output .= '<tr>';
							$output .= '<td align="center" width="70">';
							$output .= '<a href="#" class="sys_social_item_delete btn small red"><span>x</span></a>';
							$output .= '</td>';
							$output .= '<td width="100">';
							$output .= '<input type="text" class="sys_social_title" value="'.$sys_social_item[0].'" />';
							$output .= '</td>';
							$output .= '<td width="100">';
							$output .= '<select id="sys_social_file_icon" class="sys_social_file_icon" name="sys_social_file_icon"  width="300">';
				$socialimages=array();
				if(is_dir(TEMPLATEPATH . "/images/followus/")) {
					if($socialimages_dirs = opendir(TEMPLATEPATH . "/images/followus/")) {
						while(($socialimage = readdir($socialimages_dirs)) !== false) {
							if(preg_match_all('!.+\.(?:jpe?g|png|gif)!Ui',$socialimage, $matches)){
								$socialimages[] = $socialimage;
							}
						}
					}
				}
				$socialimages_select = $socialimages;
					foreach ( $socialimages_select as $key => $values) { 
							$selected = $sys_social_item[1] == $values ? ' selected="selected"' : '';
							$output .= '<option '.$selected.' style='.'background:url('.get_template_directory_uri().'/images/followus/'.$values.');'.' >'.$values.'</option>';		
							$selected ="";
							}
							$output .= '</select>';	
							$output .= '</td>';
							$output .= '<td width="100">';
							$output .= '<input type="text" class="sys_social_account_url" value="'.$sys_social_item[2].'" />';
							$output .= '</td>';
							$output .= '</tr>';
					}
				}
				$output.='</table>';
				$output.='<p>';
				$output.='<button name="sys_add_social_book" id="sys_add_social_item" type="button" value="Add New Row" class="btn medium green" /><span>Add New</span></button>';
				$output.='<input type="hidden" id="atp_social_bookmark" name="atp_social_bookmark"/>';	
				$output.='</p>';
				$output.='</div>';
				break;
			
			/****** Custom Sidebar ******/
			/*--------------------------*/
			case 'customsidebar':
				$val = $value['std'];
				$std = get_option($value['id']);
				$custom_sidebar_arr=@get_option($value['id']);
				// print_r($custom_sidebar_arr);
				if ( $std != "") { $val = $std; }
					$output.= '<div id="custom_widget_sidebar"><table id="custom_widget_table" cellpadding="0" cellspacing="0">';
				$output.='<tbody>';
				
				if($custom_sidebar_arr !=""){
				foreach($custom_sidebar_arr as $custom_sidebar_code) {
					$output.='<tr><td><input type="text" name="'.$value['id'].'[]" value="'. $custom_sidebar_code.'"  size="30" style="width:97%" /></td><td><a class="btn small red" href="javascript:void(0);return false;" onClick="jQuery(this).parent().parent().remove();"><span>Delete</span></a></td></tr>';
				}
					}				
				$output.='</tbody></table><button type="button" class="btn small green" name="add_custom_widget" value="Add Sidebar" onClick="addWidgetRow()"><span>Add Sidebar</span></button></div>';
				?>
				<script type="text/javascript" language="javascript">
					function addWidgetRow(){
						jQuery('#custom_widget_table').append('<tr><td><input type="text" name="<?php echo $value['id'];?>[]" value="" size="30" style="width:97%" /></td><td><a class="btn small red" href="javascript:void(0);return false;" onClick="jQuery(this).parent().parent().remove();"><span>Delete</span></a></td></tr>');
					}
				</script>
				<?php
				//$output .= '<input class="atp-input" name="'. $value['id'] .'" id="'. $value['id'] .'" type="'. $value['type'] .'" value="'. $val .'" style="width:'. $value['inputsize'] .'px" />';
				break;	

			/****** Textarea ******/
			/*--------------------*/
			case 'textarea':
				$cols = '8';
				$ta_value = '';
			
				if(isset($value['std'])) {
					$ta_value = $value['std']; 
					if(isset($value['options'])){
						$ta_options = $value['options'];
						if(isset($ta_options['cols'])){
							$cols = $ta_options['cols'];
						} else { 
							$cols = '8'; 
						}
					}
				}
				$std = get_option($value['id']);
				if( $std != "") { $ta_value = stripslashes($std); }
				$output .= '<textarea class="atp-input" name="'. $value['id'] .'" id="'. $value['id'] .'" cols="'. $cols .'" rows="8">'.$ta_value.'</textarea>';
				break;
			
			/****** Export ******/
			/*------------------*/
			case 'export':
				$cols = '8';
				$ta_value = '';
				$std = get_option($value['id']);
				if( $std != "") { $ta_value = stripslashes( $std ); }
				//$output .= serialize((get_option('atp_template_option_values')));
				$output .= '<textarea class="atp-input" cols="'. $cols .'" rows="8">'.base64_encode(serialize((get_option('atp_template_option_values')))).'</textarea>';
				break;
			
			/****** Import ******/
			/*------------------*/
			case 'import':
				$cols = '8';
				$ta_value = '';
				//$output .= serialize((get_option('atp_template_option_values')));
				$output .= '<textarea class="atp-input" name="'. $value['id'] .'" id="'. $value['id'] .'" cols="'. $cols .'" rows="8"></textarea>';
				break;
			
			/****** Radio ******/
			/*-----------------*/
			case "radio":
				$select_value = get_option( $value['id']);
				foreach ($value['options'] as $key => $option) { 
					$checked = '';
					if($select_value != '') {
						if ( $select_value == $key) { $checked = ' checked'; } 
					} else {
						if ($value['std'] == $key) { $checked = ' checked'; }
					}
					$output .= '<input class="atp-input atp-radio" type="radio" name="'. $value['id'] .'" value="'. $key .'" '. $checked .' />' . $option .'<br />';
				}
				break;
			
			/****** Checkbox ******/
			/*--------------------*/
			case "checkbox": 
				$std = $value['std'];  
				$saved_std = get_option($value['id']);
				$checked = '';
				
				if(!empty($saved_std)) {
					if($saved_std == 'on') {
						$checked = 'checked="checked"';
					}else{
						$checked = '';
					
					}
				}
				elseif( $std == 'on') {
					$checked = 'checked="checked"';
				}else {
					$checked = '';
				}


				$output .= '<span class="atp_on_off"><input type="checkbox" class="checkbox atp-input " value="on" id="'. $value['id'] .'" name="'.  $value['id'] .'" '. $checked .' /></span>';
				break;
			
			/****** Multiple Checkbox ******/
			/*-----------------------------*/
			case "multicheck":
				$std =  $value['std'];
				foreach ($value['options'] as $key => $option) {
					$checked = ""; 
					if (get_option( $value['id'])) {
						if (@in_array($key, get_option($value['id'] ))) $checked = "checked=\"checked\"";
					} else {
						//Empty Value if Unchecked
					}
					$output .= '<div class="clearfix"><span class="atp_on_off alignleft"><input type="checkbox" class="checkbox atp-input" name="'. $value['id'] .'[]" id="'. $value['id'] .'[]" value="'.$key.'" '. $checked .' /></span> - <span class="customsb '. $key .'">'. $option .'</span></div><br />';
				}
				break;

			/*
			 * Time Setting
			 * Restaurant Business Hours for the complete week with weekdays
			 * Int - opening - closing - closed
			 */
			case "businesshours":
				?>
					<script type="text/javascript" language="javascript">
					jQuery(document).ready(function() {
						jQuery("#<?php echo  $value['id']; ?>_closing").change(function () {
						jQuery("label#<?php echo  $value['id']; ?>_error").html('');
				/*		var jdt1=jQuery('#<?php echo  $value['id']; ?>_opening option:selected').val();
						
						var jdt2=jQuery('#<?php echo  $value['id']; ?>_closing option:selected').val();
				
					if ((jdt1.substr(0,2)) > (jdt2.substr(0,2))) {
							//alert('Start Time cannot be greater than End Time');
							jQuery("label#<?php echo  $value['id']; ?>_error").html('Start Time cannot be greater than End Time');
							jQuery("select#<?php echo  $value['id']; ?>_opening").focus();
							//return false;
							
						}
				
					if ((jdt2.substr(0,2)) <= (jdt1.substr(0,2))) {
							//alert('Start Time cannot be greater than End Time');
							jQuery("label#<?php echo  $value['id']; ?>_error").html('Start Time cannot be less than or equal to End Time');
							jQuery("select#<?php echo  $value['id']; ?>_opening").focus();
							//return false;
							
						} */
					});	
				
					jQuery("#<?php echo  $value['id']; ?>_opening").change(function () {
						jQuery("label#<?php echo  $value['id']; ?>_error").html('');
				/*		var jdt1=jQuery('#<?php echo  $value['id']; ?>_opening option:selected').val();
						
						var jdt2=jQuery('#<?php echo  $value['id']; ?>_closing option:selected').val();
				
					if ((jdt1.substr(0,2)) > (jdt2.substr(0,2))) {
							//alert('Start Time cannot be greater than End Time');
							jQuery("label#<?php echo  $value['id']; ?>_error").html('Start Time cannot be greater than End Time');
							jQuery("select#<?php echo  $value['id']; ?>_opening").focus();
							//return false;
							
						}
				
					if ((jdt2.substr(0,2)) <= (jdt1.substr(0,2))) {
							//alert('Start Time cannot be greater than End Time');
							jQuery("label#<?php echo  $value['id']; ?>_error").html('Start Time cannot be less than or equal to End Time');
							jQuery("select#<?php echo  $value['id']; ?>_opening").focus();
							//return false;
							
						}*/
					});
				
				});
			

				</script>
				<?php
				$default = $value['std'];
				$businesshours_stored = get_option($value['id']);

				// Opening
				 $val = $default['opening'];
				if ( $businesshours_stored['opening'] != "") { $val = $businesshours_stored['opening']; }
					$output .= '<label>Opening </label><select class="atp-businesshours atp-businesshours-openingtime" name="'. $value['id'].'_opening" id="'. $value['id'].'_opening">';
					for ($i = 0; $i < 24; $i++){ 
						$h = $i;
						if ( $h < 10) { $h = '0' . $h; }
						
						for($m=0;$m<=45;$m+=15) {
							
							if($m == 0) $m .='0';
							$hours = $h.':'.$m;						
	
							if($val === $hours){
								$active = 'selected="selected"'; 
							} else { 
								$active = ''; 
							}
 
							$output .= '<option value="'. $h .':'.$m.'" ' . $active . '>'. $h .':'.$m.'</option>'; 
						
						}
					}
					$output .= '</select>';
				// Closing
				$val = $default['closing'];
				if ( $businesshours_stored['closing'] != "") { $val = $businesshours_stored['closing']; }
					$output .= '<label>Closing </label><select class="atp-businesshours atp-businesshours-closingtime" name="'. $value['id'].'_closing" id="'. $value['id'].'_closing">';
					for ($i = 0; $i < 24; $i++){ 
						$h = $i;
						
						if ( $h < 10) { $h = '0' . $h; }
						
						for($m=0;$m<=45;$m+=15) {
							
							if($m == 0) $m .='0';
							$hours = $h.':'.$m;							

							if($val === $hours){
								$active = 'selected="selected"'; 
							} else { 
								$active = ''; 
							}
 
							$output .= '<option value="'. $h .':'.$m.'" ' . $active . '>'. $h .':'.$m.'</option>'; 
						
						}
					}
					$output .= '</select>';
				// Closed
				$val = $default['close'];
				if ( $businesshours_stored['close'] != "") { $val = $businesshours_stored['close']; }
					$checked='';
					if(!empty($val)) {
					if($val == 'on') {
						$checked = 'checked="checked"';
					}else{
						$checked = '';
					
					}
				}
					
$output .= '<label>Closed </label><input '. $checked .' type="checkbox" class="checkbox atp-input " value="on" name="'. $value['id'].'_close" id="'. $value['id'].'_close">';
$output .= '<label class="time_error" id="'. $value['id'].'_error"></label>';				
break;
			/* Drag Drop Function
			case "dragdropcheck":
				$std =  $value['std'];
				$output.='<div id="dragcheckbox">';
				foreach ($value['options'] as $key => $option) {
					$checked = ""; 
					if (get_option( $value['id'])) {
						if (@in_array($key, get_option($value['id'] ))) $checked = "checked=\"checked\"";
					} else {
						//Empty Value if Unchecked
					}
					$output .= '<div class="clearfix"><span class="atp_on_off alignleft"><input type="checkbox" class="checkbox atp-input" title="'.html_entity_decode($option).'" name="'. $value['id'] .'_drog" id="'. $value['id'] .'[]" value="'.$key.'" '. $checked .' /></span> - <span class="customsb '. $key .'">'. $option .'</span></div><br />';
				}
				$output.='</div>';
				?>
					<script>
					jQuery(function() {
					jQuery( ".sortable1" ).sortable({
					connectWith: ".connectedSortable"
					}).disableSelection();
					});
					</script>
				<?php
				$output.='<ul id="'.$value['id'].'_drog" class="connectedSortable sortable1">';
				$output.='<li  class="ui-state-default">list1</li>';
				$output.='<li  class="ui-state-default">list2</li>';
				$output.='<li  class="ui-state-default">list3</li>';
				$output.='<li  class="ui-state-default">list4</li>';
				$output.='</ul>';
				break;

			/****** Upload ******/
			/*------------------*/
			case "upload":
				$output .= optionsframework_uploader_function($value['id'],$value['std'],null);
				break;
			/****** Upload Min ******/
			/*----------------------*/
			case "upload_min":
				$output .= optionsframework_uploader_function($value['id'],$value['std'],'min');
				break;
			
			/****** Colors ******/
			/*------------------*/
			case "color":
				$val = $value['std'];
				$stored  = get_option( $value['id'] );
				if ( $stored != "") { $val = $stored; }
					$output .= '<div id="' . $value['id'] . '_picker" class="colorSelector"><div></div></div>';
					$output .= '<input class="atp-color" name="'. $value['id'] .'" id="'. $value['id'] .'" type="text" value="'. $val .'" />';
				break;
			
			/****** Typography ******/
			/*----------------------*/
			case "typography":
				$default = $value['std'];
				$typography_stored = get_option($value['id']);

				// Font Size
				$val = $default['size'];
				if ( $typography_stored['size'] != "") { $val = $typography_stored['size']; }
					$output .= '<select class="atp-typography atp-typography-size" name="'. $value['id'].'_size" id="'. $value['id'].'_size">';
					for ($i = 9; $i < 71; $i++){ 
						if($val == $i){
							$active = 'selected="selected"'; 
						} else { 
							$active = ''; 
						}
						$output .= '<option value="'. $i .'px" ' . $active . '>'. $i .'px</option>'; 
					}
					$output .= '</select>';
				// Line Height 
				$val = $default['lineheight'];
				if ( $typography_stored['lineheight'] != "") { $val = $typography_stored['lineheight']; }
					$output .= '<select class="atp-typography atp-typography-size" name="'. $value['id'].'_lineheight" id="'. $value['id'].'_lineheight">';
					for ($i = 9; $i < 71; $i++){ 
						if($val == $i){
							$active = 'selected="selected"'; 
						} else { 
							$active = ''; 
						}
						$output .= '<option value="'. $i .'px" ' . $active . '>'. $i .'px</option>'; 
					}
					$output .= '</select>';
				
				// Font Face
				$val = $default['face'];
				if ( $typography_stored['face'] != "") 
					$val = $typography_stored['face']; 

					$font01 = ''; 
					$font02 = ''; 
					$font03 = ''; 
					$font04 = ''; 
					$font05 = ''; 
					$font06 = ''; 
					$font07 = ''; 
					$font08 = '';
					$font09 = '';
					$font10 = '';

					if (strpos($val, 'Lucida Grande') !== false)		{ $font01 = 'selected="selected"'; }
					if (strpos($val, 'Arial') !== false)				{ $font02 = 'selected="selected"'; }
					if (strpos($val, 'Verdana') !== false)				{ $font03 = 'selected="selected"'; }
					if (strpos($val, 'Trebuchet') !== false)			{ $font04 = 'selected="selected"'; }
					if (strpos($val, 'Georgia') !== false)				{ $font05 = 'selected="selected"'; }
					if (strpos($val, 'Times New Roman') !== false)		{ $font06 = 'selected="selected"'; }
					if (strpos($val, 'Tahoma') !== false)				{ $font07 = 'selected="selected"'; }
					if (strpos($val, 'Palatino') !== false)				{ $font08 = 'selected="selected"'; }
					if (strpos($val, 'Helvetica') !== false)			{ $font09 = 'selected="selected"'; }
			
					$output .= '<select class="atp-typography atp-typography-face" name="'. $value['id'].'_face" id="'. $value['id'].'_face">';
					$output .= '<option value="&quot;Lucida Grande&quot; "'. $font01 .'>Lucida Grande</option>';
					$output .= '<option value="Arial" '. $font02 .'>Arial</option>';
					$output .= '<option value="Verdana" '. $font03 .'>Verdana</option>';
					$output .= '<option value="&quot;Trebuchet MS&quot;, Tahoma, sans-serif"'. $font04 .'>Trebuchet</option>';
					$output .= '<option value="Georgia, serif" '. $font05 .'>Georgia</option>';
					$output .= '<option value="&quot;Times New Roman&quot;, Geneva, sans-serif"'. $font06 .'>Times New Roman</option>';
					$output .= '<option value="Tahoma, Verdana"'. $font07 .'>Tahoma</option>';
					$output .= '<option value="Palatino, &quot;Palatino Linotype&quot;, serif"'. $font08 .'>Palatino</option>';
					$output .= '<option value="&quot;Helvetica Neue&quot;, Helvetica, sans-serif" '. $font09 .'>Helvetica*</option>';

					// Google Font Enqueue 
					global $google_fonts;
					sort ($google_fonts);
				
					$output .= '<option value="">-- Google Fonts --</option>';
					foreach ( $google_fonts as $key => $googlefont ) :
						$font[$key] = '';
						if ($val == $googlefont['name']){ $font[$key] = 'selected="selected"'; }
						$name = $googlefont['name'];
						$output .= '<option value="'.$name.'" '. $font[$key] .'>'.$name.'</option>';
					endforeach;
					$output .= '</select>';

					// Font Style
					$val = $default['style'];
					if ( $typography_stored['style'] != "") { $val = $typography_stored['style']; }
						$normal = ''; $italic = ''; $bold = ''; $bolditalic = '';
					if($val == 'normal')	{ $normal = 'selected="selected"'; }
					if($val == 'italic')	{ $italic = 'selected="selected"'; }
					if($val == 'bold')		{ $bold = 'selected="selected"'; }
					if($val == 'bold italic'){ $bolditalic = 'selected="selected"'; }
			
					$output .= '<select class="atp-typography atp-typography-style" name="'. $value['id'].'_style" id="'. $value['id'].'_style">';
					$output .= '<option value="normal" '. $normal .'>Normal</option>';
					$output .= '<option value="italic" '. $italic .'>Italic</option>';
					$output .= '<option value="bold" '. $bold .'>Bold</option>';
					$output .= '<option value="bold italic" '. $bolditalic .'>Bold/Italic</option>';
					$output .= '</select>';
					
					// Font Color 
					$val = $default['color'];
					if ( $typography_stored['color'] != "") { $val = $typography_stored['color']; }
					$output .= '<div id="' . $value['id'] . '_color_picker" class="colorSelector"><div></div></div>';
					$output .= '<input class="atp-color atp-typography atp-typography-color" name="'. $value['id'] .'_color" id="'. $value['id'] .'_color" type="text" value="'. $val .'" />';
				break;

			/****** Border ******/
			/*------------------*/
			case "border":
				$default = $value['std'];
				$border_stored = get_option( $value['id'] );
				
				// Border Width 
				$val = $default['width'];
				if ( $border_stored['width'] != "") { $val = $border_stored['width']; }
				$output .= '<select class="atp-border atp-border-width" name="'. $value['id'].'_width" id="'. $value['id'].'_width">';
				for ($i = 0; $i < 21; $i++){
					if($val == $i){ 
						$active = 'selected="selected"'; 
					} else { 
						$active = ''; 
					}
					$output .= '<option value="'. $i .'" ' . $active . '>'. $i .'px</option>'; 
				}
				$output .= '</select>';
				
				// Border Style
				$val = $default['style'];
				if ( $border_stored['style'] != "") { $val = $border_stored['style']; }
					$solid = ''; $dashed = ''; $dotted = '';
				if($val == 'solid'){ $solid = 'selected="selected"'; }
				if($val == 'dashed'){ $dashed = 'selected="selected"'; }
				if($val == 'dotted'){ $dotted = 'selected="selected"'; }
			
				$output .= '<select class="atp-border atp-border-style" name="'. $value['id'].'_style" id="'. $value['id'].'_style">';
				$output .= '<option value="solid" '. $solid .'>Solid</option>';
				$output .= '<option value="dashed" '. $dashed .'>Dashed</option>';
				$output .= '<option value="dotted" '. $dotted .'>Dotted</option>';
				$output .= '</select>';
				// Border Color
				$val = $default['color'];
				if ( $border_stored['color'] != "") { $val = $border_stored['color']; }			
				$output .= '<div id="' . $value['id'] . '_color_picker" class="colorSelector"><div></div></div>';
				$output .= '<input class="atp-color atp-border atp-border-color" name="'. $value['id'] .'_color" id="'. $value['id'] .'_color" type="text" value="'. $val .'" />';
				break;
			
			/****** Background ******/
			/*------------------*/
			case "background":
				$default = $value['std'];
				$background_stored = get_option( $value['id'] );

				// Background Upload
				$val = $default['image'];
			 	$imgid=$value['id'].'_image';	
				if ( $background_stored['image'] != "") { $std = $background_stored['image']; }	
				$output .= '<div class="atp-background atp-background-upload">';		
				$output .= optionsframework_uploader_function($imgid,'',null);	
				$output .= '</div>';	

				// Background Color 
				$val = $default['color'];
				if ( $background_stored['color'] != "") { $val = $background_stored['color']; }			
				$output .= '<div id="' . $value['id'] . '_color_picker" class="colorSelector"><div></div></div>';
				$output .= '<input class="atp-color atp-background atp-background-color" name="'. $value['id'] .'_color" id="'. $value['id'] .'_color" type="text" value="'. $val .'" />';

				// Background Style
				$val = $default['style'];
				if ( $background_stored['style'] != "") { $val = $background_stored['style']; }
					$repeat = ''; $norepeat = ''; $repeatx = ''; $repeaty = '';
				if($val == 'repeat')	{ $repeat = 'selected="selected"'; }
				if($val == 'no-repeat')	{ $norepeat = 'selected="selected"'; }
				if($val == 'repeat-x')	{ $repeatx = 'selected="selected"'; }
				if($val == 'repeat-y')	{ $repeaty = 'selected="selected"'; }
			
				$output .= '<select class="atp-background atp-background-style" name="'. $value['id'].'_style" id="'. $value['id'].'_style">';
				$output .= '<option value="repeat" '. $repeat .'>Repeat</option>';
				$output .= '<option value="no-repeat" '. $norepeat .'>No-Repeat</option>';
				$output .= '<option value="repeat-x" '. $repeatx .'>Repeat-X</option>';
				$output .= '<option value="repeat-y" '. $repeaty .'>Repeat-Y</option>';
				$output .= '</select>';
				// Background Position
				$val = $default['position'];
				if ( $background_stored['position'] != "") { $val = $background_stored['position']; }
					$lefttop = ''; $leftcenter = ''; $leftbottom = ''; $righttop = ''; $rightcenter = ''; $rightbottom = ''; $centertop = ''; $centercenter = ''; $centerbottom = ''; 
				if($val == 'left top')		{ $lefttop = 'selected="selected"'; }
				if($val == 'left center')	{ $leftcenter = 'selected="selected"'; }
				if($val == 'left bottom')	{ $leftbottom = 'selected="selected"'; }
				if($val == 'right top')		{ $righttop = 'selected="selected"'; }
				if($val == 'right center')	{ $rightcenter = 'selected="selected"'; }
				if($val == 'right bottom')	{ $rightbottom = 'selected="selected"'; }
				if($val == 'center top')	{ $centertop = 'selected="selected"'; }
				if($val == 'center center')	{ $centercenter = 'selected="selected"'; }
				if($val == 'center bottom')	{ $centerbottom = 'selected="selected"'; }
			
				$output .= '<select class="atp-background atp-background-position" name="'. $value['id'].'_position" id="'. $value['id'].'_style">';
				$output .= '<option value="left top" '. $lefttop .'>Left Top</option>';
				$output .= '<option value="left center" '. $leftcenter .'>Left Center</option>';
				$output .= '<option value="left bottom" '. $leftbottom .'>Left Bottom</option>';
				$output .= '<option value="right top" '. $righttop .'>Right Top</option>';
				$output .= '<option value="right center" '. $rightcenter .'>Right Center</option>';
				$output .= '<option value="right bottom" '. $rightbottom .'>Right Bottom</option>';
				$output .= '<option value="center top" '. $centertop .'>Center Top</option>';
				$output .= '<option value="center center" '. $centercenter .'>Center Center</option>';
				$output .= '<option value="center bottom" '. $centerbottom .'>Center Bottom</option>';
				$output .= '</select>';
				// Background Attachment
				$val = $default['attachment'];
					if ( $background_stored['attachment'] != "") {
						$val = $background_stored['attachment'];
					}
					$fixed = ''; 
					$scroll = '';

					if($val == 'fixed')  { $fixed = 'selected="selected"'; }
					if($val == 'scroll') { $scroll = 'selected="selected"'; }
			
				$output .= '<select class="atp-background atp-background-attachment" name="'. $value['id'].'_attachment" id="'. $value['id'].'_style">';
				$output .= '<option value="fixed" '. $fixed .'>Fixed</option>';
				$output .= '<option value="scroll" '. $scroll .'>Scroll</option>';
				$output .= '</select>';
				break;

			/****** Images ******/
			/*------------------*/
			case "images":
				$i = 0;
				$select_value = get_option( $value['id']);
					foreach ($value['options'] as $key => $option) { 
						$i++;
						$checked = '';
						$selected = '';
						if($select_value != '') {
							if ( $select_value == $key) { $checked = ' checked'; $selected = 'atp-radio-img-selected'; } 
						} else {
							if ($value['std'] == $key) { $checked = ' checked'; $selected = 'atp-radio-img-selected'; }
								elseif ($i == 1  && !isset($select_value)) { $checked = ' checked'; $selected = 'atp-radio-img-selected'; }
								elseif ($i == 1  && $value['std'] == '') { $checked = ' checked'; $selected = 'atp-radio-img-selected'; }
							else { $checked = ''; }
						}
					
						$output .= '<span>';
						$output .= '<input type="radio" id="atp-radio-img-' . $value['id'] . $i . '" class="checkbox atp-radio-img-radio" value="'.$key.'" name="'. $value['id'].'" '.$checked.' />';
						$output .= '<div class="atp-radio-img-label">'. $key .'</div>';
						$output .= '<img src="'.$option.'" alt="" class="atp-radio-img-img '. $selected .'" onClick="document.getElementById(\'atp-radio-img-'. $value['id'] . $i.'\').checked = true;" />';
						$output .= '</span>';
					}
				break;
			
			/****** Info ******/ 
			/*----------------*/
			case "info":
				$default = $value['std'];
				$output .= $default;
				break;
			
			/****** Heading ******/
			/*-------------------*/
			case "heading":
				if($counter >= 2){
					$output .= '</div>'."\n";
				}
				$jquery_click_hook = ereg_replace("[^A-Za-z0-9]", "", strtolower($value['name']) );
				$jquery_click_hook = "atp-option-" . $jquery_click_hook;
				$menu .= '<li><a title="'.  $value['name'] .'" href="#'.  $jquery_click_hook  .'"><img src="' .$value['icon']. '" width="21" height="20" alt=""/> '.  $value['name'] .'</a></li>';
				$output .= '<div class="group" id="'. $jquery_click_hook  .'"><h2>'.$value['name'].'</h2>'."\n";
				break;
		} 
		/*---------------------------------------*/
		// Option Value Type
		// if TYPE is an array, formatted into smaller inputs... ie smaller values
		if ( is_array($value['type'])) {
			foreach($value['type'] as $array){
			
				$id = $array['id']; 
				$std = $array['std'];
				$saved_std = get_option($id);
				if($saved_std != $std){$std = $saved_std;} 
					$meta = $array['meta'];
					
				if($array['type'] == 'text') { // Only text at this point
					$output .= '<input class="input-text-small atp-input" name="'. $id .'" id="'. $id .'" type="text" value="'. $std .'" />';  
					$output .= '<span class="meta-two">'.$meta.'</span>';
				}
			}
		}
		// Option Value not equals to Headings and checkbox
		if ( $value['type'] != "heading" ) {
			if ( $value['type'] != "checkbox" ){ 
				$output .= '<br/>';
			}
			if(!isset($value['desc'])){ $explain_value = ''; } else{ $explain_value = $value['desc']; } 
				$output .= '</div><div class="explain">'. $explain_value .'</div>'."\n";
				$output .= '<div class="clear"> </div></div></div>'."\n";
		}
	}
	$output .= '</div>';
	return array($output,$menu);
}

/*** OptionsFramework Uploader - optionsframework_uploader_function ***/
/*--------------------------------------------------------------------*/
function optionsframework_uploader_function($id,$std,$mod){
    //$uploader .= '<input type="file" id="attachement_'.$id.'" name="attachement_'.$id.'" class="upload_input"></input>';
    //$uploader .= '<span class="submit"><input name="save" type="submit" value="Upload" class="button upload_save" /></span>';
    
	$uploader = '';
    $upload = get_option($id);
	
	if($mod != 'min') {
		$val = $std;
        if ( get_option( $id ) != "") { $val = get_option($id); }
			$uploader .= '<input class="atp-input" name="'. $id .'" id="'. $id .'_upload" type="text" value="'. $val .'" />';
	}
	
	$uploader .= '<div class="upload_button_div"><span class="button image_upload_button" id="'.$id.'">Upload Image</span>';
	
	if(!empty($upload)) {$hide = '';} else { $hide = 'hide';}
	
	$uploader .= '<span class="button image_reset_button '. $hide.'" id="reset_'. $id .'" title="' . $id . '">Remove</span>';
	$uploader .='</div>' . "\n";
    $uploader .= '<div class="clear"></div>' . "\n";
	if(!empty($upload)){
    	$uploader .= '<a class="atp-uploaded-image" href="'. $upload . '">';
    	$uploader .= '<img class="atp-option-image" id="image_'.$id.'" src="'.$upload.'" alt="" />';
    	$uploader .= '</a>';
	}
	$uploader .= '<div class="clear"></div>' . "\n"; 
	return $uploader;
}
?>