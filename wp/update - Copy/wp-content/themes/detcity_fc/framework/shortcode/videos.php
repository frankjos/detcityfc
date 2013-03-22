<?php
	/**
	 * Flash Object Shortcode
	 */
	function sys_flash($atts, $content = null) {
		extract(shortcode_atts(array (
			'width'		=> '480',
			'height'	=> '385',
			'id'		=> '',
			'src'		=> '',
			'play'		=> '',
		), $atts));

		$out ='<div class="video-stage" style="width:'.$width.'px; height:'.$height.'px">
				<object id="'.$id.'" width="'.$width.'" height="'.$height.'">
				<param name="movie" value="'.$src.'"></param>
				<param name="allowFullScreen" value="true"></param>
				<param name="expressInstaller" value="'.ATP_DIRECTORY.'/swf/expressInstall.swf"></param>
				<param name="allowscriptaccess" value="always"></param>
				<embed src="'.$src.'" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="'.$width.'" height="'.$height.'" wmode="opaque">
				</embed>
				</object>';
		$out.="</div>";
		return $out;
	}
	add_shortcode('flash','sys_flash');

	/**
	 * Youtube Video
	 */
	function sys_youtube($atts, $content = null) {
		extract(shortcode_atts(array (
			'width'		=> '480',
			'height'	=> '385',
			'clipid'	=> '',
			'loop'		=> '',
			'autohide'	=> '',
			'autoplay'	=> '',
			'controls'	=> '',
			'disablekb'	=> '',
			'fs'		=> '',
			'hd'		=> '',
			'rel'		=> '',
			'showinfo'	=> '',
			'showsearch'=> '',
		), $atts));
		
		return '<div class="video-stage" style="width:'.$width.'px; height:'.$height.'px">
			<iframe style="height:'.$height.'px; width:'.$width.'px" src="http://www.youtube.com/embed/'.$clipid.'?autohide='.$autohide.'&amp;autoplay='.$autoplay.'&amp;controls='.$controls.'&amp;disablekb='.$disablekb.'&amp;fs='.$fs.'&amp;hd='.$hd.'&amp;loop='.$loop.'&amp;rel='.$rel.'&amp;showinfo='.$showinfo.'&amp;showsearch='.$showsearch.'&amp;wmode=transparent" width='.$width.' height='.$height.' frameborder="0"></iframe>
			</div>';
	}
	add_shortcode('youtube','sys_youtube');

	/**
	 * Viemo Video
	 */
	function sys_vimeo($atts, $content = null) {
		extract(shortcode_atts(array (
			'width'		=> '480',
			'height'	=> '385',
			'clip_id'	=> '',
			'byline'	=> '',
			'title'		=> '',
			'portrait'	=> '',
			'autoplay'	=> '',
			'loop'		=> '',
			'html5'		=> '1',
		), $atts));

		$out='';
		if ($height && !$width) $width = intval($height * 16 / 9);
		if (!$height && $width) $height = intval($width * 9 / 16);
		if (!empty($clip_id) && is_numeric($clip_id)){
			$out.='<div class="video-stage" style="width:'.$width.'px; height:'.$height.'px">';
			if (empty($clip_id) || !is_numeric($clip_id)) $out.='envalid clipid';
			if ($height && !$width) $width = intval($height * 16 / 9);
			if (!$height && $width) $height = intval($width * 9 / 16);
			if($html5){
				$out.="<iframe src='http://player.vimeo.com/video/$clip_id?title=$title&amp;byline=$byline&amp;portrait=$portrait' width='$width' height='$height' frameborder='0'></iframe>"; 
			}else{
				$out.="<object width='$width' height='$height'><param name='allowfullscreen' value='true' />".
					"<param name='allowscriptaccess' value='always' />".
					"<param name='movie' value='http://vimeo.com/moogaloop.swf?clip_id=$clip_id&amp;server=vimeo.com&amp;show_title=$title&amp;show_byline=$byline&amp;show_portrait=$portrait&amp;color=$color&amp;fullscreen=1' />".
					"<embed src='http://vimeo.com/moogaloop.swf?clip_id=$clip_id&amp;server=vimeo.com&amp;show_title=$title&amp;show_byline=$byline&amp;show_portrait=$portrait&amp;color=$color&amp;fullscreen=1' type='application/x-shockwave-flash' allowfullscreen='true' allowscriptaccess='always' width='$width' height='$height'></embed></object>";
			}
			$out.="</div>";
		}
		return $out;
	}
	add_shortcode('vimeo','sys_vimeo');

	/**
	 * Wordpress TV
	 */
	function sys_wordpresstv($atts, $content = null) {
		extract(shortcode_atts(array (
			'width'		=> '480',
			'height'	=> '385',
			'id'		=> '',
		), $atts));

		$out='<div class="video-stage" style="width:'.$width.'px; height:'.$height.'px">';
		$out.='<embed type="application/x-shockwave-flash" src="http://s0.videopress.com/player.swf?v=1.02" width="'.$width.'" height="'.$height.'" wmode="transparent" seamlesstabbing="true" allowfullscreen="true" allowscriptaccess="always" overstretch="true" flashvars="guid='.$id.'" wmode="opaque"></embed>';
		$out.="</div>";
		return $out;
	}
	add_shortcode('wordpresstv','sys_wordpresstv');

	/**
	 * Bliptv
	 */
	function sys_bliptv($atts, $content = null) {
		extract(shortcode_atts(array (
			'width'		=> '480',
			'height'	=> '385',
			'id'		=> '',
		), $atts));

		$out='<div class="video-stage" style="width:'.$width.'px; height:'.$height.'px">';
		$out.='<embed src="http://blip.tv/play/'.$id.'" type="application/x-shockwave-flash" width="'.$width.'" height="'.$height.'" allowscriptaccess="always" allowfullscreen="true" wmode="opaque"></embed>';
		$out.="</div>";
		return $out;
	}
	add_shortcode('bliptv','sys_bliptv');

	/**
	 * Google Video
	 */
	function sys_googlevideo($atts, $content = null) {
		extract(shortcode_atts(array (
			'width'		=> '480',
			'height'	=> '385',
			'align'		=> '',
			'id'		=> '',
		), $atts));

		$out='<div class="video-stage '.$align.'" style="width:'.$width.'px; height:'.$height.'px">';
		$out.='<embed id=VideoPlayback src=http://video.google.com/googleplayer.swf?docid='.$id.'&hl=en&fs=true style=width:'.$width.'px;height:'.$height.'px allowFullScreen=true allowScriptAccess=always type=application/x-shockwave-flash wmode="opaque"> </embed>';
		$out.="</div>";
		return $out;
	}
	add_shortcode('googlevideo','sys_googlevideo');
?>