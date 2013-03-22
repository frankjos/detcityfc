<?php

	/**
	 * General Shortcodes
	 */
	 
	// Divider Top
	function sys_divider_top( $atts, $content = null ) {
		return '<div class="divider top"><a href="#">&uarr;</a></div>';
	}
	add_shortcode('divider_top', 'sys_divider_top');

	// Divider Space
	function sys_divider_space( $atts, $content = null ) {
		return '<div class="divider_space"></div>';
	}
	add_shortcode('divider_space', 'sys_divider_space');

	// Divider Line
	function sys_divider_line( $atts, $content = null ) {
		return '<div class="divider_line"></div>';
	}
	add_shortcode('divider_line', 'sys_divider_line');

	// Divider Separator
	function sys_separator( $atts, $content = null ) {
		return '<div class="separator"></div>';
	}
	add_shortcode('separator', 'sys_separator');

	// Divider Clear
	function sys_clear( $atts, $content = null ) {
		return '<div class="clear"></div>';
	}
	add_shortcode('clear', 'sys_clear');

	// Alignment
	function sys_align($atts, $content = null, $code) {
		extract(shortcode_atts(array(
			'position' => '',
		), $atts));
		return '<div class="'.$position.'">'.do_shortcode($content).'</div>';
	}
	add_shortcode('align', 'sys_align');

	/**
	 * Highlight Code
	 */
	function sys_highlight($atts, $content = null, $code) {
		extract(shortcode_atts(array(
			'bgcolor'	=> '',
			'textcolor'	=> '',
		), $atts));
		
		$bgcolor = $bgcolor?'background-color:'.$bgcolor.';':'';
		$textcolor = $textcolor?'color:'.$textcolor.';':'';
		if( !empty($textcolor) || !empty($bgcolor)){
			$extras = ' style="'.$bgcolor.$textcolor.'"';
		}else{
			$extras = '';
		}
		return '<span class="highlight" '.$extras.'>'.do_shortcode($content).'</span>';
	}
	add_shortcode('highlight', 'sys_highlight');

	/**
	 * Fancy Heading
	 */
	function sys_fancy_heading($atts, $content = null, $code) {
		extract(shortcode_atts(array(
			'bgcolor'	=> '',
			'textcolor'	=> '',
		), $atts));
		
		$bgcolor = $bgcolor?'background-color:'.$bgcolor.';':'';
		$textcolor = $textcolor?'color:'.$textcolor.';':'';
		if( !empty($textcolor) || !empty($bgcolor)){
			$extras = ' style="'.$bgcolor.$textcolor.'"';
		}else{
			$extras = '';
		}
		return '<h6 class="fancyheading"><span '.$extras.'>'.do_shortcode($content).'</span></h6>';
	}
	add_shortcode('fancyheading', 'sys_fancy_heading');
	
	/**
	 * Dropcaps
	 */

	function sys_dropcap_1($atts, $content = null, $code) {
		extract(shortcode_atts(array(
			'color'	=> '',
		), $atts));
		if($color){
			$color = ' '.$color;
		}
		return '<span class="' . $code.$color . '" '.$bgcolor.'>' . do_shortcode($content) . '</span>';
	}
	add_shortcode('dropcap1', 'sys_dropcap_1');

	function sys_dropcap_2($atts, $content = null, $code) {
		extract(shortcode_atts(array(
			'bgcolor'	=> '',
		), $atts));
		$bgcolor = $bgcolor?' style="background-color:'.$bgcolor.'"':'';
		if($bgcolor){
			$bgcolor = ' '.$bgcolor;
		}
		return '<span class="' . $code . '" '.$bgcolor.'>' . do_shortcode($content) . '</span>';
	}
	add_shortcode('dropcap2', 'sys_dropcap_2');
	
	function sys_dropcap_3($atts, $content = null, $code) {
		extract(shortcode_atts(array(
			'color'	=> '',
		), $atts));
	
		$color = $color?' style="color:'.$color.'"':'';
		if($color){
			$color = ' '.$color;
		}
		return '<span class="' . $code . '" '.$color.'>' . do_shortcode($content) . '</span>';
	}
	add_shortcode('dropcap3', 'sys_dropcap_3');
	
	/**
	 * BlockQuotes
	 */
	function sys_blockquote($atts, $content = null, $code) {
		extract(shortcode_atts(array(
			'align'	=> false,
			'cite'	=> false,
			'width'	=> '',
		), $atts));
		
		return '<blockquote' . ($align ? ' class="align' . $align . '"' : '').($width ? ' style="width:' . $width . 'px"' : '') .'><p>' . do_shortcode($content) .''. ($cite ? '<cite>- ' . $cite . '</cite>' : '</p>') . '</blockquote>';
	}
	add_shortcode('blockquote', 'sys_blockquote');

	/**
	 * Fancy Table
	 */

	function sys_fancy_table( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'width'	=> '',
			'align'	=> false,
		), $atts));
		
		$width = $width?' style="width:'.$width.'"':'';
		if($width){
			$width = ' '.$width;
		}
		if($align){
			$align = ' align'.$align;
		}
		$content = str_replace('<table>', '<table class="fancy_table '.$align.'" '.$width.'>', do_shortcode($content));
		return $content;
	}
	add_shortcode('fancytable', 'sys_fancy_table');
	
	/**
	 * List Styles
	 */
	function sys_list($atts, $content = null, $code) {
		extract(shortcode_atts(array(
			'style'	=> false,
			'color'	=> '',
			'cols'	=> '',
		), $atts));
		
		if($style){
			$style = 'list-'.$style;
		}
		return str_replace('<ul>', '<ul class="'.$style.' '.$cols.' '.$color.'">', do_shortcode($content));
	}
	add_shortcode('list', 'sys_list');
	
	/**
	 * Icons 
	 */

	function sys_icons($atts, $content = null, $code) {
		extract(shortcode_atts(array(
			'style'		=> false,
			'color'		=> '',
			'href'		=> '',
			'target'	=> '_self',
		), $atts));
		if($style){
			$style = 'icon-'.$style;
		}
		if($href){
			$out ='<a class="'.$style.' '.$color.'" href="'.$href.'" target="'.$target.'">'.do_shortcode($content).'</a>';
		}else {
			$out ='<span class="'.$style.' '.$color.'">'.do_shortcode($content).'</span>';
		}
		return $out;
	}
	add_shortcode('icon', 'sys_icons');

	/**
	 * Google Chart
	 */

	function sys_chart($atts, $content = null) {
		extract(shortcode_atts(array(
			'data'		=> '',
			'colors'	=> '',
			'size'		=> '500x250',
			'bg'		=> 'FFFFFF',
			'title'		=> '',
			'labels'	=> '',
			'advanced'	=> '',
			'type'		=> 'pie'
		), $atts));
		switch ($type) {
			case 'line' :
				$charttype = 'lc'; break;
			case 'xyline' :
				$charttype = 'lxy'; break;
			case 'sparkline' :
				$charttype = 'ls'; break;
			case 'meter' :
				$charttype = 'gom'; break;
			case 'scatter' :
				$charttype = 's'; break;
			case 'venn' :
				$charttype = 'v'; break;
			case 'pie' :
				$charttype = 'p3'; break;
			case 'pie2d' :
				$charttype = 'p'; break;
			default :
				$charttype = $type;
			break;
		}

		if ($title) $string .= '&chtt='.$title.'';
		if ($labels) $string .= '&chl='.$labels.'';
		if ($colors) $string .= '&chco='.$colors.'';
		$string .= '&chs='.$size.'';
		$string .= '&chd=t:'.$data.'';
		$string .= '&chf=bg,s,'.$bg.'';
	
		return '<img title="'.$title.'" src="http://chart.apis.google.com/chart?cht='.$charttype.''.$string.$advanced.'" alt="'.$title.'" />';
	}
	add_shortcode('chart','sys_chart');
?>