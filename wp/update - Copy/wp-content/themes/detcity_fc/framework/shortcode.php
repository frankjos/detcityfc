<?php

	/**
	 * Code Formatter wpautop
	 */
	function text_formatting($content) {
		$new_content = '';
		$pattern_full = '{(\[raw\].*?\[/raw\])}is';
		$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
		$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);
	
		foreach ($pieces as $piece) {
			if (preg_match($pattern_contents, $piece, $matches)) {
				$new_content .= $matches[1];
			} else {
				$new_content .= wptexturize(wpautop($piece));
			}
		}
		return $new_content;
	}

	add_filter('the_content', 'text_formatting',99);
	add_filter('widget_text', 'text_formatting',99);

	remove_filter('the_content', 'wpautop');
	remove_filter('the_content', 'wptexturize');

	/**
	 * 
	 */
	require_once(FUNCTIONS_PATH."/shortcode/image_gallery.php");
	require_once(FUNCTIONS_PATH."/shortcode/buttons.php");
	require_once(FUNCTIONS_PATH."/shortcode/boxes.php");
	require_once(FUNCTIONS_PATH."/shortcode/messageboxes.php");
	require_once(FUNCTIONS_PATH."/shortcode/tabstoggles.php");
	require_once(FUNCTIONS_PATH."/shortcode/general.php");
	require_once(FUNCTIONS_PATH."/shortcode/blog.php");
	require_once(FUNCTIONS_PATH."/shortcode/videos.php");
	require_once(FUNCTIONS_PATH."/shortcode/related.php");
	require_once(FUNCTIONS_PATH."/shortcode/recent.php");
	require_once(FUNCTIONS_PATH."/shortcode/popular.php");
	require_once(FUNCTIONS_PATH."/shortcode/contactinfo.php");
	require_once(FUNCTIONS_PATH."/shortcode/contactform.php");
	require_once(FUNCTIONS_PATH."/shortcode/flickr.php");
	require_once(FUNCTIONS_PATH."/shortcode/twitter.php");
	require_once(FUNCTIONS_PATH."/shortcode/layout.php");
	require_once(FUNCTIONS_PATH."/shortcode/gmap.php");
	require_once(FUNCTIONS_PATH."/shortcode/chart.php");
	require_once(FUNCTIONS_PATH."/shortcode/lightbox.php");
	require_once(FUNCTIONS_PATH."/shortcode/nivoslider.php");
	require_once(FUNCTIONS_PATH."/shortcode/toggleslider.php");
	require_once(FUNCTIONS_PATH."/shortcode/todayspecial.php");
?>