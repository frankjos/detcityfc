<?php
	add_action('admin_menu', 'layout_add_box');

	// Add meta box
	function layout_add_box() {
		global $meta_box;

		foreach( $meta_box as $post_type => $value) {
			add_meta_box($value['id'], $value['title'], 'layout_show_box',$post_type, $value['context'], $value['priority']);
		}
	}

	// Callback function to show fields in meta box
	function layout_show_box() {

		global $page_layout, $post,$sidebarwidget,$meta_box;

		// Use nonce for verification
		echo '<input type="hidden" name="page_page_layout_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
		echo '<div class="atp_meta_options">';
			
		foreach ($meta_box[$post->post_type]['fields'] as $field) {
			// get current post meta data
			// get current post meta data
			$meta = get_post_meta($post->ID, $field['id'], true);
			if($meta == ""){
			$meta =$field['std'];
			}
			if(!isset($field['class'])) { $field['class']=''; }
			
			echo'<div class="atp_options_box '.$field['class'].'"><div class="glowborder">',
				'<div class="atp_description"><label for="', $field['id'], '">', $field['name'], '</label><p>',$field['desc'],'</p></div>',
				'<div class="atp_inputs">';
			switch ($field['type']) {
				case 'text':
					echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />';
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
				case 'textarea':
					echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>';
					break;
				case 'select':
					echo '<select name="', $field['id'], '" id="', $field['id'], '">';
					foreach ($field['options'] as $key => $value) {
						echo '<option value="'.$key.'"', $meta == $key ? ' selected="selected"' : '', '>', $value, '</option>';
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
					if(isset($custom['link_post'])){ 
						$link_post = $custom["link_post"][0]; }
					if(isset($custom['link_manually'])){ 
						$link_manually = stripslashes($custom["link_manually"][0]);  }
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
					echo "<table>";
					echo "<tr valign='top'>";
					echo "<th scope='row'>Upload Image</th>";
					echo "<td><label for='upload_image'>";
					echo'<input value="'.stripslashes(get_post_meta($post->ID, $field['id'], true)).'" type="text" name="'.$field['id'].'"  id="'.$field['id'].'" size="50%" />';
					echo '<input class="button upload_image_button"  id="'.$field['id'].'" type="button" value="Upload Image" />';
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
	add_action('save_post', 'layout_save_data');

	// Save data from meta box
	function layout_save_data($post_id) {
		
		global $meta_box,$post;

		if (!wp_verify_nonce(isset($_POST['page_page_layout_nonce']), basename(__FILE__))) {
			return $post_id;
		}

		// verify nonce

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

		if($_POST['link_page']!="") {
			update_post_meta($post_id, "link_page",$_POST['link_page']);
			}
		if($_POST['link_page'] == ""){
			delete_post_meta($post_id,"link_page", get_post_meta($post_id,link_page, true));
		}
		if( $_POST['link_manually']!="") {
			update_post_meta($post_id, "link_manually",$_POST['link_manually']);
			}
		if($_POST['link_manually'] == ""){
			delete_post_meta($post_id,"link_manually", get_post_meta($post_id,link_manually, true));
		}
		if( $_POST['link_cat']!="") {
			update_post_meta($post_id, "link_cat",$_POST['link_cat']);
		}
		if($_POST['link_cat'] == ""){
			delete_post_meta($post_id,"link_cat", get_post_meta($post_id,link_cat, true));
		}
		if( $_POST['link_post']!="") {
			update_post_meta($post_id, "link_post",$_POST['link_post']);
		}
		if($_POST['link_post'] == ""){
			delete_post_meta($post_id,"link_post", get_post_meta($post_id,link_post, true));
		}
		
		foreach ($meta_box[$post->post_type]['fields'] as $field) {
			$old = get_post_meta($post_id, $field['id'], true);
			$new = $_POST[$field['id']];
			
			if ($new && $new != $old) {
				update_post_meta($post_id, $field['id'], $new);
			} elseif ('' == $new && $old) {
				delete_post_meta($post_id, $field['id'], $old);
			}
		}
	}
	
	function adminHead () {
		wp_enqueue_script('color-iphone', ATP_DIRECTORY.'/framework/admin/js/iphone-style-checkboxes.js', array('jquery'));
		wp_enqueue_script('color-picker2', ATP_DIRECTORY.'/framework/admin/js/colorpicker.js', array('jquery'));
		wp_enqueue_script('shortcode',get_template_directory_uri()  . '/framework/admin/js/shortcode.js',array('jquery'));
	}
	
	add_action('admin_menu', 'handleAdminMenu');
	add_filter('admin_print_scripts', 'adminHead');
