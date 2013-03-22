/***
 * jQuery Custom Cycle Slider
 * @Author : femkhan
 * @authorurl : http://www.aivahthemes.com
 */

jQuery(document).ready(function($) {
	jQuery('.slideshow').after('<div id="nav">')
	jQuery('.slideshow').css("display", "block");		
	jQuery('.slideshow').cycle({
		fx: 'fade',
		timeout: 3000,
		pager: '#nav',
		speed: 1000,
		pagerEvent: 'click',
		pauseOnPagerHover: true,
		cleartype: true,
		cleartypeNoBg:true,
		pause: 1 
	});

	jQuery('#nav').css("display", "block");
	// jQuery('.slideshow').cycle('pause'); //remove 2 slashes in beginning of line to remove auto rotate slides.
});

jQuery(window).load(function() { //fades in image and hides loading image
	jQuery(".loader").css("background", "none");
    jQuery(".loader img").fadeIn("50");
});