<?php

	/**
	 * Plan Box
	 */
	function sys_plan_front( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'title'		=> '',
			'bgcolor'	=> '',
			'price'		=> '',
			'tagline'	=> '',
			'ribbon'	=> '',
			'color'		=> '',
			'pcolor'	=> '',
			), $atts));

		$bgcolor = $bgcolor?'background-color:'.$bgcolor.';':'';
		$color = $color?' style="color:'.$color.'"':'';
		$pcolor = $pcolor?' style="color:'.$pcolor.'"':'';

		if(!empty($bgcolor)){
			$extras = ' style="'.$bgcolor.'"';
		}else{
			$extras = '';
		}

		$out.='<div class="plan_box" '.$extras.'>';
			if ($ribbon) { 
				$home = get_option('home');
				$rimage = '<div class="ribbon"><img src="'.get_template_directory_uri().'/images/ribbons/'.$ribbon.'.png" alt=""/></div>';
			}
			$out.='<div class="plan_info" '.$extras.'>';
			if ($ribbon) { 	$out.=$rimage;}
				$out.='<div class="content">';
			if($title){
				$out .= '<h2 class="name" '.$color.'>' .$title. '</h2>';
			}
			if($price){
				$out .= '<h3 class="price" '.$pcolor.'>' .$price. '</h3>';
			}	
			if($tagline){
				$out .= '<h4>' .$tagline. '</h4>';
			}
			$out.= do_shortcode($content);
			$out.='</div>';
			$out.='</div>';
			return $out;
	}
	add_shortcode('plan_front', 'sys_plan_front');

	/**
	 * Plan Hover Box
	 */

	function sys_plan_hover( $atts, $content = null ) {
		extract(shortcode_atts(array(
		 'title'      => '',
			 'bgcolor'      => '',
			 'price'      => '',	
		), $atts));

		$bgcolor = $bgcolor?'background-color:'.$bgcolor.';':'';
		if(!empty($bgcolor)){
			$extras = ' style="'.$bgcolor.$bordercolor.'"';
		}else{
			$extras = '';
		}

		$out.='<div class="plan_details" '.$extras.'>';
		$out.='<div class="content">';
		if($title){
			$out .= '<h2 class="name">' .$title. '</h2>';
		}
		if($price){
			$out .= '<h3 class="price">' .$price. '</h3>';
		}
		$out .= do_shortcode($content);
		$out .='</div>';
		$out .='</div>';
		$out .='</div>';

		return $out;
	}
	add_shortcode('plan_hover', 'sys_plan_hover');
?>