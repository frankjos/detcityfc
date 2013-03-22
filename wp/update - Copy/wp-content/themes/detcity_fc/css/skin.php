<?php require_once( '../../../../wp-load.php' );
require(FUNCTIONS_PATH."/includes/var.php");
Header("Content-type: text/css");
?>
<?php $slider_width=get_option('slider_width');?>
<?php $slider_height=get_option('slider_height');?>

/*=== CUSTOM TYPOGRAPHY ENABLED
=======================================================*/
<?php if($atp_customtypo == "on") { ?>

body,
body p { <?php 
	echo 'font:'.$atp_bodyp['style'].' '.$atp_bodyp['size'].' '.$atp_bodyp['face'].';'; 
	if($atp_bodyp['color'] != "")  { echo 'color:'.$atp_bodyp['color'].';'; }
	if($atp_bodyp['lineheight'] != "")  { echo 'line-height:'.$atp_bodyp['lineheight'].';';	}
	?>
	}

h1  { <?php echo 'font:'.$atp_h1['style'].' '.$atp_h1['size'].' '.$atp_h1['face'].';'; echo ' color:'.$atp_h1['color'].';'; echo ' line-height:'.$atp_h1['lineheight'].';'; ?> }
h2  { <?php echo 'font:'.$atp_h2['style'].' '.$atp_h2['size'].' '.$atp_h2['face'].';'; echo ' color:'.$atp_h2['color'].';'; echo ' line-height:'.$atp_h2['lineheight'].';'; ?> }
h3  { <?php echo 'font:'.$atp_h3['style'].' '.$atp_h3['size'].' '.$atp_h3['face'].';'; echo ' color:'.$atp_h3['color'].';'; echo ' line-height:'.$atp_h3['lineheight'].';'; ?> }
h4  { <?php echo 'font:'.$atp_h4['style'].' '.$atp_h4['size'].' '.$atp_h4['face'].';'; echo ' color:'.$atp_h4['color'].';'; echo ' line-height:'.$atp_h4['lineheight'].';'; ?> }
h5  { <?php echo 'font:'.$atp_h5['style'].' '.$atp_h5['size'].' '.$atp_h5['face'].';'; echo ' color:'.$atp_h5['color'].';'; echo ' line-height:'.$atp_h5['lineheight'].';'; ?> }
h6  { <?php echo 'font:'.$atp_h6['style'].' '.$atp_h6['size'].' '.$atp_h6['face'].';'; echo ' color:'.$atp_h6['color'].';'; echo ' line-height:'.$atp_h6['lineheight'].';'; ?> }

.widget-title        { 
text-transform:uppercase;
color: #810001;
<?php 
	
	echo ' font:'.$atp_sidebartitle['style'].' '.$atp_sidebartitle['size'].' '.$atp_sidebartitle['face'].';'; 
	echo ' color:'.$atp_sidebartitle['color'].';'; 
	echo ' line-height:'.$atp_sidebartitle['lineheight'].';';?>
}
.copyright,
.copyright p        { <?php	
	echo ' color:'.$atp_copyrights['color'].';'; 
	echo 'font:'.$atp_copyrights['style'].' '.$atp_copyrights['size'].' '.$atp_copyrights['face'].';'; 
	echo ' color:'.$atp_copyrights['color'].';'; 
	echo ' line-height:'.$atp_copyrights['lineheight'].';';
	?>
	}
h2.entry-title a            { <?php 
	echo 'font:'.$atp_entrytitle['style'].' '.$atp_entrytitle['size'].' '.$atp_entrytitle['face'].';'; 
	echo 'color:'.$atp_entrytitle['color'].';'; 
	echo 'line-height:'.$atp_entrytitle['lineheight'].';';
	?> }

h2.entry-title a:hover      { <?php echo ($atp_entrytitlelinkhover ? 'color:'.$atp_entrytitlelinkhover.'; '.'':''); ?> }

<?php } ?>

/*=== CUSTOM TYPOGRAPHY DEFAULT
=======================================================*/

<?php if($atp_overlayimages != "")  { ?>
body { <?php 
	if($atp_overlayimages != "") {
		echo 'background-image:url('.get_template_directory_uri().'/images/patterns/'.$atp_overlayimages.'); ';
		echo 'background-repeat:repeat;';
	
	}
	?>
	}
<?php } ?>

<?php if($atp_bodyproperties['color'] != "" or $atp_bodyproperties['image'] !="")  { ?>
body { <?php 
	echo 'background-color:'.$atp_bodyproperties['color'].'; ';
	if($atp_bodyproperties['image'] != "") {
		echo 'background-image:url('.$atp_bodyproperties['image'].'); ';
		echo 'background-repeat:'.$atp_bodyproperties['style'].'; ';
		echo 'background-position:'.$atp_bodyproperties['position'].'; ';
		echo 'background-attachment:'.$atp_bodyproperties['attachment'].'; 	';
	}
	?>
	}
<?php } ?>

<?php if($atp_sliderbgprop['color'] != "" or $atp_sliderbgprop['image'] !="")  { ?>
#featured_slider { <?php 
	echo 'background-color:'.$atp_sliderbgprop['color'].'; ';
	if($atp_sliderbgprop['image'] != "") {
		echo 'background-image:url('.$atp_sliderbgprop['image'].'); ';
		echo 'background-repeat:'.$atp_sliderbgprop['style'].'; ';
		echo 'background-position:'.$atp_sliderbgprop['position'].'; ';
		echo 'background-attachment:'.$atp_sliderbgprop['attachment'].'; 	';
	}
	?>
	}
<?php } ?>

<?php if($atp_headerbg['color'] != "" or $atp_headerbg['image'] !="")  { ?>
#header        { <?php 
	echo 'background:'.$atp_headerbg['color'].' url('.$atp_headerbg['image'].') '.$atp_headerbg['style'].' '.$atp_headerbg['position'].' '.$atp_headerbg['attachment'].';'; ?>
	}
<?php } ?>

<?php if($atp_tabsbgcolor['color'] != "")  { ?>
ul.tabs li, 
ul.tabs li.current,
.vertabs ul.tabs li, 
.vertabs ul.tabs li.current { <?php echo ($atp_tabsbgcolor ? 'background-color:'.$atp_tabsbgcolor.';'.'':''); ?>
<?php } ?>

<?php if($atp_subheaderproperties['color'] != "" or $atp_subheaderproperties['image'] !="")  { ?>
#subheader { <?php 
	echo 'background:'.$atp_subheaderproperties['color'].' url('.$atp_subheaderproperties['image'].') '.$atp_subheaderproperties['style'].' '.$atp_subheaderproperties['position'].' '.$atp_subheaderproperties['attachment'].';'; ?>
	}
<?php } ?>


#featured_slider        { <?php 
if($atp_sliderproperties['image'] != "") {
	echo 'background:'.$atp_sliderproperties['color'].' url('.$atp_sliderproperties['image'].') '.$atp_sliderproperties['style'].' '.$atp_sliderproperties['position'].' '.$atp_sliderproperties['attachment'].';'; 
	}
?>
}

.pagemid           { <?php echo ($atp_wrapbg ? 'background-color:'.$atp_wrapbg.'; '.'':''); ?> }

<?php if($atp_stickybarcolor !="") { ?>
#sticky           { <?php echo ($atp_stickybarcolor ? 'background-color:'.$atp_stickybarcolor.'; '.'':''); ?> }
<?php } ?>
.logo a, 
.logo a:hover {
	<?php
		echo ($atp_logosize ? 'font-size:'.$atp_logosize.'px; '.'':''); 
		echo ($atp_logotextcolor ? 'color:'.$atp_logotextcolor.'; '.'':''); 
	?> }

a                           { <?php echo ($atp_link ? 'color:'.$atp_link.';'.'':'');  ?>}
a.button, a.button:hover    { <?php echo ($atp_link ? 'background-color:'.$atp_link.';'.'':''); ?> }

a:hover, 
#breadcrumbs a:hover, 
.entry-title a:hover,
.post h2  a:hover           { <?php echo ($atp_linkhover ? 'color:'.$atp_linkhover.';'.'':'');  ?> } /* Link Hover Color*/

#subheader a                { <?php echo ($atp_subheaderlink ? 'color:'.$atp_subheaderlink.';'.'':'');  ?> }
#subheader a:hover          { <?php echo ($atp_subheaderlinkhover ? 'color:'.$atp_subheaderlinkhover.';'.'':'');  ?> }

#menuwrap                   { <?php echo ($atp_menubg ? 'background-color:'.$atp_menubg.';'.'':'');  ?> }

.sf-menu  a                { <?php echo 'font:'.$atp_mainmenufont['style'].' '.$atp_mainmenufont['size'].' '.$atp_mainmenufont['face'].';'; echo ' color:'.$atp_mainmenufont['color'].';'; echo ' line-height:'.$atp_mainmenufont['lineheight'].';'; ?> }
.sf-menu  li a				{ <?php echo ' color:'.$atp_mainmenufont['color'].';'; ?> }
.sf-menu  ul li a 			{ <?php echo 'font:'.$atp_mainmenudropfont['style'].' '.$atp_mainmenudropfont['size'].' '.$atp_mainmenudropfont['face'].';'; echo ' color:'.$atp_mainmenudropfont['color'].';'; echo ' line-height:'.$atp_mainmenudropfont['lineheight'].';'; echo ($atp_subnavlink ? 'color:'.$atp_subnavlink.';'.'':''); ?>}
.sf-menu  ul li  			{ <?php echo ($atp_subnavbr ? 'border-color:'.$atp_subnavbr.';'.'':'');?>}
.sf-menu  ul li a:hover	{ <?php echo ($atp_subnavhover ? 'color:'.$atp_subnavhover.';'.'':''); ?>}
.sf-menu  ul 				{ <?php echo ($atp_subnavbg ? 'background-color:'.$atp_subnavbg.';'.'':''); echo ($atp_subnavbr ? 'border-color:'.$atp_subnavbr.';'.'':'');  ?> }

.sf-menu  ul li a            { <?php echo ($atp_subnavlink ? 'color:'.$atp_subnavlink.';'.'':'');  ?> }
.sf-menu  li ul              { <?php echo ($atp_subnavbg ? 'background:'.$atp_subnavbg.';'.'':'');  ?> }

.sf-menu li:hover, .sf-menu li.sfHover,
.sf-menu a:focus, .sf-menu a:hover, .sf-menu a:active,
.sf-menu  .current_page_ancestor,
.sf-menu ul.sub-menu,
.sf-menu ul.sub-menu li.current_page_item a { <?php echo ($atp_navhoverbg ? 'background:'.$atp_navhoverbg.';'.'':''); echo ($atp_navhoverlink ? 'color:'.$atp_navhoverlink.';'.'':'');?> background-image: url('http://www.detcityfc.com/update/wp-content/uploads/2012/04/menubg.jpg'); background-repeat:repeat-x; background-position:bottom;}

.sf-menu li.current-page-ancestor a,
.sf-menu li.current-menu-ancestor a,
.sf-menu li.current-menu-parent a,
.sf-menu li.current-page-parent a,
.sf-menu li.current_page_parent a,
.sf-menu li.current_page_ancestor a { background-image: url('http://www.detcityfc.com/update/wp-content/uploads/2012/04/menubg.jpg'); background-repeat:repeat; <?php echo ($atp_navhoverbg ? 'background:'.$atp_navhoverbg.';'.'':'');  ?> }

#breadcrumbs                { <?php echo ($atp_breadcrumbtext ? 'color:'.$atp_breadcrumbtext.';'.'':'');  ?> }
#breadcrumbs a              { <?php echo ($atp_breadcrumblink ? 'color:'.$atp_breadcrumblink.';'.'':'');  ?> }
#breadcrumbs a:hover        { <?php echo ($atp_breadcrumblinkhover ? 'color:'.$atp_breadcrumblinkhover.';'.'':'color:#ff0000');  ?> }

#footer                     { <?php echo ($atp_footerbgcolor ? 'background-color:'.$atp_footerbgcolor.'; '.'':''); ?>}
#footer, #footer p          { <?php echo ($atp_footertextcolor ? 'color:'.$atp_footertextcolor.';'.'':'');  ?> }
#footer a,
#footer #wp-calendar, 
#footer #wp-calendar caption, 
#footer #wp-calendar th, 
#footer #wp-calendar td     { <?php echo ($atp_footerlinkcolor ? 'color:'.$atp_footerlinkcolor.';'.'':'');  ?>}

#footer a:hover             { <?php echo ($atp_footerlinkhovercolor ? 'color:'.$atp_footerlinkhovercolor.';'.'':'');  ?>}

.copyright                  { <?php echo ($atp_copybgcolor ? 'background-color:'.$atp_copybgcolor.'; '.'':''); ?>}
.copyright a                { <?php echo ($atp_copylinkcolor ? 'color:'.$atp_copylinkcolor.'; '.'':''); ?> }

#footer h3                  { <?php echo ($atp_footerheadingcolor ? 'color:'.$atp_footerheadingcolor.'; '.'':''); ?> }

#sidebar { <?php echo ($atp_sidebarbgcolor ? 'background-color:'.$atp_sidebarbgcolor.'; '.'':''); ?> }

<?php 
$atp_extracss=get_option("atp_extracss");
echo $atp_extracss;
?>