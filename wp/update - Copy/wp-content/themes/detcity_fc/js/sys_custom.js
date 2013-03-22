/*-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
LIGHTBOX EVOLUTION
-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
*/
var $j = jQuery.noConflict();
$j(document).ready(function(){
	$j('.post_slider').each( function(index) {
		$j(this).after('<div class="postslider_nav postslider_nav_'+index+'"></div>').cycle({ 
			fx:     'fade', 
			timeout: 5000, 
			pager:  '.postslider_nav_'+index 
		});
	});


	/* TOGGLE BUTTON  */
	$j(".top_toggle_button").click(function(){
		$j("#top_toggle").slideToggle("slow");
		$j(this).toggleClass("active"); return false;
	});

	/* TOGGLE Sticky  */
	$j("#trigger").toggle(function(){
		$j(this).addClass("active");
		}, function () {
		$j(this).removeClass("active");
	});
	$j("#trigger").click(function(){
		$j(this).next("#sticky").slideToggle({ duration: 1000, easing: 'easeOutQuart'});
	});
	
    $j('.lightbox, .gallery a').lightbox();
	
	$j('ul.sf-menu').superfish();
	hoverimage();
	menushoverimage();
	sys_toggle();
	atp_sociables();
	$j("ul.tabs").tabs(".panes > .tab_content", {tabs:'li',effect: 'fade', fadeOutSpeed: -400});
});



/*-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
Sociables
-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
*/

function atp_sociables() {
	jQuery(".atpsocials ul li").hover(function(){
		jQuery(this).find("img").animate({top:"-5px"}, "fast")
		},function(){
		jQuery(this).find("img").animate({top:"0"}, "fast")
	});
}


/*-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
TOGGLES
-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
*/

function sys_toggle() {
	jQuery(".toggle_content").append("<div class='arrow'></div>").hide();

	jQuery("span.toggle").toggle(function(){
		jQuery(this).addClass("active");
		}, function () {
		jQuery(this).removeClass("active");
	});

	jQuery("span.toggle").click(function(){
		jQuery(this).next(".toggle_content").slideToggle();
	});
}


/*-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
HOVERIMAGE
-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
*/

//*** HOVERIMAGE ------------------------------------------------------------***//
function menushoverimage() {
	jQuery("a[class^='lightbox']").each(function() {	
			var $image = jQuery(this).contents("img");
				$hoverclass = 'hover_video';
	
		if(jQuery(this).attr('href').match(/(jpg|gif|jpeg|png|tif)/)) 
		$hoverclass = 'hover_image';
			
		if ($image.length > 0)
		{	
			var $hoverbg = jQuery("<span class='"+$hoverclass+"'></span>").appendTo(jQuery(this));
			
				jQuery(this).bind('mouseenter', function(){
				$height = $image.height();
				$width = $image.width();
				$pos =  $image.position();		
				$hoverbg.css({height:$height, width:$width, top:$pos.top, left:$pos.left});
			});
		}
	
	});	

	jQuery("a[class^='lightbox']").contents("img").hover(function() {
			jQuery(this).stop().animate({"opacity": "0.2"}, 200);
			},function() {
			jQuery(this).stop().animate({"opacity": "1"},200);
	});
}


function hoverimage() {
	jQuery('.hover_type').animate({opacity: "0"});

	jQuery(".carousel_img, .postimg, .port_img, .sort_img").hover(function() {
		jQuery(this).find('.hover_type').css('display','block').animate({opacity: "1"}, "slow");
		jQuery(this).stop().animate({"opacity": "0.9"}, 200);
	},function() {
		jQuery(this).find('.hover_type').animate({opacity: "0"}, "slow");
		jQuery(this).stop().animate({"opacity": "1"}, 200);
	});
}

/*-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
FUNCTION CALLBACKS
-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
*/
