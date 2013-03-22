<?php

	/**
	 * Nivo Slider
	 */
	function sys_message_box($atts, $content = null, $code) {
		extract(shortcode_atts(array(
			'align'	=> false,
		), $atts));
		
		$align = $align?' '.$align:'';
		return '<div class="messagebox ' . $code . $align . '"><div class="messagebox_content">' . do_shortcode($content) . '</div><div class="clear"></div></div>';
	}
	add_shortcode('error','sys_message_box');
	add_shortcode('info','sys_message_box');
	add_shortcode('alert','sys_message_box');
	add_shortcode('success','sys_message_box');
	add_shortcode('download','sys_message_box');

	/**
	 * Notes Box
	 */
	function sys_notes($atts, $content = null) {
		extract(shortcode_atts(array(
			'align' => false,
			'title' => '',
			'width' => false,
		), $atts));
		
		$align = $align?' align'.$align:'';
		$width = $width?' style="width:'.(int)$width.'px"':'';
		
		if(!empty($title)){
			$title = '<h4 class="notes_title">'.$title.'</h4>';
		}
		return '<div class="notes' . $align . '"'.$width.'><div class="notes_content">'.$title .do_shortcode($content). '</div></div>';
	}
	add_shortcode('note','sys_notes');
?>