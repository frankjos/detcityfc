<div id="featured_slider">
	<div class="slider_wrapper">
<?php  
		$src = get_option("atp_static_image_upload");
		$link = get_option("atp_static_link");

		// If has no link returns anchor 
		if($link!="") { 
			echo '<a href='.$link.'>'; 
		}
		// If has image resizing option
		if(get_option(atp_timthumb)=="on") {
			echo mu_resize_timthumb($post->ID,$src,1020,360,'staticimage',''); 
		}else{
			$image = vt_resize('',$src,1020,400, true );
			echo vt_thumb($post->ID,$image['url'],$image['width'],$image['height'],'staticimage','');
		}

		if($link!="") { 
			echo '</a>';
		}
?>			
	</div><!-- .slider_wrapper -->
</div><!-- #featured_slider -->