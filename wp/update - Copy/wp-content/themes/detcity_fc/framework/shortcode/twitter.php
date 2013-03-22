<?php
	/**
	 * Twitter Tweets
	 */
	function sys_twitter ($atts, $content = null) {
		$username=get_option('sys_twitter_username');
		extract(shortcode_atts(array(
			'limit'		=> '',
			'username'	=>$username,
		), $atts));

		$out ="<div>";
		$out.= parse_cache_pagetwitter_widget($username,$limit);
		$out.="</div>";
		return $out;
	}
	add_shortcode('twitter','sys_twitter');
?>