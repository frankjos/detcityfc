<?php

	/**
	 * Google Map
	 */

	function sysgooglemap( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"width"		=> false,
			"height"	=> '500',
			"address"	=> '',
			"controls"	=> '[]',
			"scrollwheel"=> 'true',
			"maptype"	=> 'G_NORMAL_MAP',
			"latitude"	=> 0,
			"longitude"	=> 0,
			"html"		=> '',
			"popup"		=> 'false',
			"marker"	=> 'true',
			"zoom"		=> 1,
			'align'		=> false,
		), $atts));
		
		wp_print_scripts('jquery-gmap');
		
		if($width && is_numeric($width)){
			$width = 'width:'.$width.'px;';
		}else{
			$width = '';
		}
	
		if($height && is_numeric($height)){	
			$height = 'height:'.$height.'px';
		}else{
			$height = '';
		}

		$align = $align?' align'.$align:'';
		$id = rand(1,1000);
if($marker != 'false'){
return <<<HTML
[raw]
<div id="g_map_{$id}" class="g_map{$align}" style="{$width}{$height}"></div>
<script type="text/javascript">
jQuery(document).ready(function($) {
	jQuery("#g_map_{$id}").gMap({
		zoom: {$zoom},
		markers:[{
			address: "{$address}",
			latitude: {$latitude},
			longitude: {$longitude},
			html: "{$html}",
			popup: {$popup}
		}],
		maptype: {$maptype},
		controls: {$controls},
		scrollwheel:{$scrollwheel}
	});
});
</script>
[/raw]
HTML;
}else{
return <<<HTML
[raw]
<div id="g_map_{$id}" class="g_map{$align}" style="{$width}{$height}"></div>
<script type="text/javascript">
jQuery(document).ready(function($) {
	jQuery("#g_map_{$id}").gMap({
		latitude: {$latitude},
		longitude: {$longitude},
		address: "{$address}",
		controls: {$controls},
		maptype: {$maptype},
		scrollwheel:{$scrollwheel},
		zoom: {$zoom}
	});
});
</script>
[/raw]
HTML;
}
}
add_shortcode('gmap', 'sysgooglemap');
?>