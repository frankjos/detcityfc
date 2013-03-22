<?php

	/**
	 * Contact Form
	 */

	function syswidget_contact_form( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'email'      => '',
			'success'      => '',
		), $atts));
	
		$name_str = __('Name *','victoria_front');
		$email_str = __('Email *','victoria_front');
		$submit_str = __('Submit','victoria_front');

		wp_print_scripts('atp-form');
		wp_print_scripts('atp-validate');

		global $wpdb;

		$out.='<div id="result"></div>';
		$out.='<div class="syswidget sysform sc">';
		$out .= '<form action="'.get_template_directory_uri().'/framework/includes/submitform.php" id="validate_form" method="post">';
		$out .= '<p><input type="text" size="20" name="contact_name" class="txt small"><label>'.$name_str.'</label></p>';
		$out .= '<p><input type="text" size="20" name="contact_email" class="txt small"><label>'.$email_str.'</label></p>';
		$out .= '<p><textarea name="contactcomment" class="required"></textarea></p>';
		$out .= '<p><button type="submit" value="submit" name="contactsubmit" class="button small gray"><span>'.__('submit','victoria_front').'</span></button></p>';
		$out .= '<input type="hidden" name="contact_check" value="checking">';
		$out .= '<input type="hidden" name="contact_widgetemail" value="'.$email.'">';
		$out .= '<input type="hidden" name="contact_success" value="'.$success.'">';
		$out .= '</form>';
		$out.='</div>';
		
		return $out;
	}
	add_shortcode('contactform', 'syswidget_contact_form');
?>