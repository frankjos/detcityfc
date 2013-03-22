<?php

	/**
	 * Buttons
	 */
	function sys_button( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'id'			=> '',
			'class'			=> '',
			'link'			=> '',
			'linktarget'	=> '',
			'style'			=> '',
			'color'			=> '',
			'align'			=> '',
			'bgcolor'		=> '',
			'hoverbgcolor'	=> '',
			'hovertextcolor'=> '',
			'textcolor'		=> '',
			'size'			=> 'medium',
			'width'			=> '',
		), $atts));

		$hoverbgcolor = $hoverbgcolor?($bgcolor?' btn-bg="'.$bgcolor.'"':'').' btn-hoverBg="'.$hoverbgcolor.'"':'';
		$hovertextcolor = $hovertextcolor?($textcolor?' btn-color="'.$textcolor.'"':'').' btn-hoverColor="'.$hovertextcolor.'"':'';
		$bgcolor = $bgcolor?' style="background-color:'.$bgcolor.'"':'';
		$color = $color?' '.$color:'';
		$id = $id?' id="'.$id.'"':'';
		$class = $class?' '.$class:'';
		$link = $link?' href="'.$link.'"':'';
		$linktarget = $linktarget?' target="'.$linktarget.'"':'';
		$textcolor = $textcolor?'color:'.$textcolor.';':'';
		$width = $width?'width:'.$width.'px;':'';
		$extras =	($textcolor!==''||$width!='')?' style="'.$textcolor.$width.'"':'';
		$button="button";
		if($style == 'true'){
			$style = 'full';
		}else{
			$style = '';
		}
		$content = "<a $id $link $linktarget $bgcolor $hoverbgcolor class=\"$button $align $size $style $color $class\"><span $extras>" .trim($content). "</span></a>";
		if($align === 'center'){
			return '<p class="center">'.trim($content).'</p>';
		}else {
			return trim($content);	
		}
	}
	add_shortcode('button', 'sys_button');
?>