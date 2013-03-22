/***
 *
 * Cufon Font Rendering in theme options Panel
 * Fetch font from the cufon fonts directory.
 */

jQuery(document).ready(function() {
	jQuery('#atp_cufon').change(function() {
		var cuf = "";
		var fcuf="";
		var str;
		
	jQuery("#atp_cufon option:selected").each(function() { 
		cuf += jQuery(this).text() + "";
		str= jQuery(this).text();
		string = str.replace(/\s{1,}/g, '_');
	});

	//var cufonurl = "<script type='text/javascript' charset='utf-8' src='"+atp_panel.SiteUrl+"/js/cufon-yui.js'>";
	var cufonfonturl = "<script type='text/javascript' charset='utf-8' src='"+atp_panel.SiteUrl+"/js/cufon/"+str.replace(/\s{1,}/g, '_')+".js'>";

	//jQuery("head").append(cufonurl);
    jQuery("head").append(cufonfonturl);
	
    Cufon.replace('span.cufonlive,', { hover:true, fontFamily: cuf });
	});
});

/***
 *
 * iPhone Check Style
 */

jQuery(document).ready(function() {
   jQuery('.atp_on_off :checkbox').iphoneStyle();
});

jQuery(document).ready(function() {
jQuery('.upload_image_button').click(function() {
var clickedID = jQuery(this).attr('id');	

 formfield = jQuery('#'+clickedID).attr('name');
 tb_show('', 'media-upload.php?type=image&amp;tab=library&amp;TB_iframe=true');
 //tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
 return false;
});
jQuery('.upload_image_button').click(function() {
var clickedID = jQuery(this).attr('id');	
window.send_to_editor = function(html) {
 imgurl = jQuery('img',html).attr('src');
 jQuery('#'+clickedID).val(imgurl);
 tb_remove();
}
});
});
jQuery(document).ready(function () {
	
	/*-- postlinkurl selection--*/
	jQuery("input[name=postlinktype_options]").change(function () {
		jQuery(".postlinkurl").hide();
		selected_plurl = jQuery("input[name=postlinktype_options]:checked").val();
		jQuery("."+selected_plurl).show();
	}).change();

	/*-- custom teaser option selection--*/
	jQuery("#atp_teaser").change(function () {
		jQuery(".atpteaseroption").hide();
		selected_teaser = jQuery("#atp_teaser option:selected").val();
		jQuery("."+selected_teaser).show();
		
		}).change();
		
		/*-- custom teaser option selection--*/
	jQuery("#subheader_teaser_options").change(function () {
		jQuery(".sub_teaser_option").hide();
		subheader_teaser_select = jQuery("#subheader_teaser_options option:selected").val();
		jQuery("."+subheader_teaser_select).show();
		}).change();

	/*-- custom slider selection--*/
	jQuery("#atp_slider").change(function () {
		jQuery(".atpsliders").hide();
		jQuery(".subtoggle").hide();
		selected_slider = jQuery("#atp_slider option:selected").val();
		jQuery("."+selected_slider).show();
	
		// If is toggle slider selected show sub elements
		if(selected_slider == 'toggleslider') {
			jQuery("#atp_toggleslider").change(function () {
				jQuery(".subtoggle").hide();
				selected_toggle_slider = jQuery("#atp_toggleslider option:selected").val();
				jQuery("."+selected_toggle_slider).show();
		}).change();

	}

	}).change();

	/*-- portfolio post type selection--*/

	jQuery("#port_posttype_option").change(function () {
		jQuery(".ptoption").hide();
		selected_ptoption = jQuery("#port_posttype_option option:selected").val();
		jQuery("."+selected_ptoption).show();
	}).change();

  
});

