<?php

	/**
	 * FANCY BOX
	 */
	function sys_fancy_box( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'bgcolor'	=> '#4d4d4d',
			'title'		=> '',
			'heading'	=> '',
			'ribbon'	=> '',
			'titlecolor'=> '',
			'textcolor'=> '',
		), $atts));
		
		$bgcolor = $bgcolor?'background-color:'.$bgcolor.';':'';
		$titlecolor = $titlecolor?'color:'.$titlecolor.';':'';

		if( !empty($textcolor) || !empty($bgcolor)){
			$extras = ' style="'.$bgcolor.$textcolor.'"';
		}else{
			$extras = '';
		}

		if ($ribbon) {
			$home = home_url();
			$rimage = '<div class="ribbon"><img src="'.get_template_directory_uri().'/images/ribbons/'.$ribbon.'.png" alt=""/></div>';
		}

		$out = '<div class="fancybox">';
		if(isset($rimage)) {
			$out .= ''.$rimage.'';
		}
		if($title){
			$out .= '<h4 class="fancytitle" '.$extras.'>' .$title. '</h4>';
		}
		
		$out .= '<div class="boxcontent">';
		if($heading){
			$out .= '<div class="bigtitle">' .$heading. '</div>';
		}
		$out .= do_shortcode($content) .'</div></div>';
		return $out;
	}
	add_shortcode('fancy_box', 'sys_fancy_box');

	/**
	 * MINIMAL BOX
	 */
	function sys_minimal_box( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'title'			=> '',
			'heading'		=> '',
			'ribbon'		=> '',
			'titlecolor'	=> '',
			'bgcolor'		=> '',
			'headingcolor'	=> '',
		), $atts));

		$titlecolor = $titlecolor?' style="background-color:'.$titlecolor.'"':'';
		$headingcolor = $headingcolor?' style="color:'.$headingcolor.'"':'';
		$bgcolor = $bgcolor?' style="background-color:'.$bgcolor.'"':'';

		if ($ribbon) {
			$home = home_url();
			$rimage = '<div class="ribbon"><img src="'.get_template_directory_uri().'/images/ribbons/'.$ribbon.'.png" alt=""/></div>';
		}

		$out= '<div class="minimalbox" '.$bgcolor.'><div class="minimaltitle" '.$titlecolor.'>';
		if(isset($rimage)) {
			$out .= ''.$rimage.'';
		}
		if($title){
			$out .= '<h2>' .$title. '</h2>';
		}
		if($heading){
			$out .= '[raw]<span class="subtitle"><span '.$headingcolor.'>' .$heading. '</span></span>[/raw]';
		}
		$out .= '</div><div class="boxcontent">';
		$out .= do_shortcode($content) .'</div></div>';
		return $out;
	}
	add_shortcode('minimal_box', 'sys_minimal_box');

	/**
	 * FRAMED BOX
	 */
	function sys_framed_box( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'bgcolor'		=> '',
			'bordercolor'	=> '',
			'padding'		=> '',
			'width'			=> '',
			'height'		=> '',
			'ribbon'		=> '',
		), $atts));

		$bgcolor = $bgcolor?'background-color:'.$bgcolor.';':'';
		$bordercolor = $bordercolor?'border-color:'.$bordercolor.';':'';
		$width = $width?'width:'.$width.';':'';
		$height = $height?'height:'.$height.';':'';
		$padding = $padding?' style="padding:'.$padding.'"':'';

		if( !empty($bordercolor) || !empty($bgcolor) || !empty($width) || !empty($height)){
			$extras = ' style="'.$bgcolor.$bordercolor.$width.$height.'"';
		}else{
			$extras = '';
		}

		if ($ribbon) {
			$home = home_url();
			$rimage = '<div class="ribbon"><img src="'.get_template_directory_uri().'/images/ribbons/'.$ribbon.'.png" alt=""/></div>';
		} 

		$out = '<div class="framedbox" '.$extras.'>';
		if(isset($rimage)) {$out .= ''.$rimage.''; }
		$out .= '<div class="boxcontent" '.$padding.'>';
		$out .= do_shortcode($content);
		$out .= "</div>";
		$out .= "</div>";
		
		return $out;
	}
	add_shortcode('framed_box', 'sys_framed_box');

	/**
	 * TEASER BOX
	 */
	function sys_teaser_box( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'bgcolor'		=> '',
			'bordercolor'	=> '',
			'thinbordercolor'	=> '',
			'padding'		=> '',
			'width'			=> '',
			'ribbon'		=> '',
		), $atts));

		$bgcolor = $bgcolor?'background-color:'.$bgcolor.';':'';
		$thinbordercolor = $thinbordercolor?'border-color:'.$thinbordercolor.';':'';
		$width = $width?'width:'.$width.';':'';
		$padding = $padding?' padding:'.$padding.'':'';
		$bordercolor = $bordercolor?' style="background-color:'.$bordercolor.'"':'';
		
		if( !empty($thinbordercolor) || !empty($bgcolor) || !empty($padding) || !empty($width)){
			$extras = ' style="'.$bgcolor.$thinbordercolor.$width.$padding.'"';
		}else{
			$extras = '';
		}

		if ($ribbon) {
			$home = home_url();
			$rimage = '<div class="ribbon"><img src="'.get_template_directory_uri().'/images/ribbons/'.$ribbon.'.png" alt=""/></div>';
		}
		
		$out .= '<div class="teaserbg" '.$bordercolor.'><div class="teaserborder" '.$extras.'>';
		$out .= ''.$rimage.'';
		$out .= do_shortcode($content);
		$out .= "</div></div><!--end:teaserbg-->";
		
		return $out;
	}
	add_shortcode('teaser_box', 'sys_teaser_box');
?>