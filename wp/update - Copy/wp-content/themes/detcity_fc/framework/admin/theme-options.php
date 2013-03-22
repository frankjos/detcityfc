<?php
add_action('init','atp_options');
// Get theme version from style.css
$themename = get_theme_data(STYLESHEETPATH . '/style.css');
$theme_name = $themename['Name'];
$themeversion = $themename['Version'];
$shortname = "atp";

if (!function_exists('atp_options')) {
	$options = array();
	function atp_options(){
		global $options;
		$shortname = "atp";
		$url =  ATP_DIRECTORY . '/framework/admin/images/';

		// ***** Populate OptionsFramework option in array for use in theme
		/*--------------------------------------------------------------------*/
		global $atp_options;

		// ***** Access the WordPress Categories via an Array
		/*--------------------------------------------------------------------*/
		$atp_categories = array();
		$atp_categories_obj = get_categories('hide_empty=0');
		
		foreach ($atp_categories_obj as $atp_cat) {
			$atp_categories[$atp_cat->cat_ID] = $atp_cat->cat_name;
		}
		$categories_tmp = array_unshift($atp_categories, "Select a category:");

		//***** Access the WordPress Pages via an Array
		$atp_pages = array();
		$atp_pages_obj = get_pages('sort_column=post_parent,menu_order');    

		foreach ($atp_pages_obj as $atp_page) {
			$atp_pages[$atp_page->ID] = $atp_page->post_name;
		}
		
		$atp_pages_tmp = array_unshift($atp_pages, "Select a page:");       
		$pages_array = get_pages('hide_empty=0');
		$dynamic_homepages = array( "None" => "None");
		$dynamic_pages = array();
		$cats_array = get_categories('hide_empty=0');
		$dynamic_cats = array();
		foreach ($cats_array as $categs) {
			$dynamic_cats[$categs->cat_ID] = $categs->cat_name;
			$cats_ids[] = $categs->cat_ID;
		}

	    foreach ($pages_array as $pagg) {
	      $dynamic_homepages[$pagg->ID] = $pagg->post_title;
	      $pages_ids[] = $pagg->ID;
	    }
		
	    foreach ($pages_array as $pagg) {
	      $dynamic_pages[$pagg->ID] = $pagg->post_title;
	      $pages_ids[] = $pagg->ID;
	    }
		
		/*$porfolio_array =get_terms('portfolio_type','orderby=name&hide_empty=0');
		$dynamic_portfolio = array();
		foreach ($porfolio_array as $portfolio) {
			$dynamic_portfolio[$portfolio->slug] = $portfolio->name;
			$portfolio_ids[] = $portfolio->slug;
		}*/
		$menulist_array =get_terms('menu_type','orderby=name&hide_empty=0');
		$dynamic_list = array();
		if(is_array($menulist_array)) {
		foreach ($menulist_array as $listmenu) {
			$dynamic_list[$listmenu->slug] = $listmenu->name;
			$listmenu_ids[] = $listmenu->slug;
		}
		}
		
		
		// get color stylesheet
		$colors=array();
		if(is_dir(TEMPLATEPATH . "/colors/")) {
			if($style_dirs = opendir(TEMPLATEPATH . "/colors/")) {
				while(($color = readdir($style_dirs)) !== false) {
					if(stristr($color, ".css") !== false) {
						$colors[$color] = $color;
					}
				}
			}
		}
		$colors_select = $colors;
		array_unshift($colors_select,'Default Color');

		$cufon_font=array();
		foreach (glob( TEMPLATEPATH . "/js/cufon/*") as $path_to_files) {
			$file_name = basename($path_to_files);
			$file_content = file_get_contents($path_to_files); //open file and read
			$delimeterLeft = 'font-family":"';
			$delimeterRight = '"';
			$cfont_name = font_name($file_content, $delimeterLeft, $delimeterRight, $debug = false);
			$cufon_font[$cfont_name] = $cfont_name;
		}

		/** END: prepare options for both homepages and page options **/
	
		// ***** Image Alignment radio box
		$options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center");
		
		// ***** Image Links to Options
		$options_image_link_to = array(
				'image'	=> 'The Image',
				'post'	=> 'The Post'); 
		$body_repeat = array(
				'repeat'	=> 'Repeat',
				'no-repeat'	=> 'No Repeat',
				'repeat-x'	=> 'Repeat X',
				'repeat-y'	=> 'Repeat Y');
		$body_pos = array(
				'left top'		=> 'Left Top',
				'left_center'	=> 'Left Center',
				'left_bottom'	=> 'Left Bottom',
				'right_top'		=> 'Right Top',
				'right_center'	=> 'Right Center',
				'right_bottom'	=> 'Right Bottom',
				'center top'	=> 'Center Top',
				'center_center'	=> 'Center Center',
				'center_bottom'	=> 'Center Bottom');
		$body_attachment_style=array(
				'fixed'		=> 'Fixed',
				'scroll'	=> 'Scroll');

		//***** Stylesheets Reader
		$alt_stylesheet_path = ATP_FILEPATH . '/styles/';
		$alt_stylesheets = array();

		if ( is_dir($alt_stylesheet_path) ) {
			if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) {
				while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) {
					if(stristr($alt_stylesheet_file, ".css") !== false) {
						$alt_stylesheets[] = $alt_stylesheet_file;
					}
				}    
			}
		}

		//More Options
		$uploads_arr = wp_upload_dir();
		$all_uploads_path = $uploads_arr['path'];
		$all_uploads = get_option('atp_uploads');
		
		// *******************************************************************//
		// ***** General Setting
		// *******************************************************************//
		$options[] = array( 'name'	=> 'General',
							'icon'	=> $url.'settings-icon.png',
							'type'	=> 'heading');

			$options[] = array( 'name'	=> 'Custom Logo',
								'desc'	=> 'Upload a logo for your theme, or specify the image address of your online logo. (http://yoursite.com/logo.png)',
								'id'	=> $shortname.'_logo',
								'std'	=> '',
								'type'	=> 'upload');
			
			$options[] = array( 'name'	=> 'Custom Favicon',
								'desc'	=> "Upload a 16px x 16px Png/Gif image that will represent your website's favicon.",
								'id'	=> $shortname.'_custom_favicon',
								'std'	=> '',
								'type'	=> 'upload'); 

			$options[] = array( 'name'	=> 'Subheader Teaser',
								'desc'	=> 'Teaser call out for the subheader section of the theme.(Select the option to display content for teaser area.',
								'id'	=> $shortname.'_teaser',
								'std'	=> 'default',
								'options' => array( 
										'default'	=> 'Default Subheader',
										'custom'	=> 'Custom Teaser',
										'twitter'   => 'Twitter Tweets',
										'disable'	=> 'Disable Subheader'
										),
								'type'	=> 'select');
								
			$options[] = array( 'name'	=> 'Twitter Tweets',
								'desc'	=> 'Enter Twitter username',
								'id'	=> $shortname.'_teaser_twitter',
								'class' => 'atpteaseroption twitter',
								'std'	=> '',
								'type'	=> 'text',
								'inputsize'=> '100'
								);
								
			$options[] = array( 'name'	=> 'Custom Teaser Text',
								'desc'	=> 'Enter Custom Teaser Text',
								'id'	=> $shortname.'_teaser_custom',
								'class' => 'atpteaseroption custom',
								'std'	=> '',
								'type'	=> 'textarea'
								);
			
	
			$options[] = array(  'name'	=> 'Breadcrumbs',
								'desc'	=> 'Turn "OFF" to disable the breadcrumbs list for theme which appears below the subheader.',
								'id'  	=> $shortname.'_breadcrumbs',
								'std' 	=> 'true',
								'type' 	=> 'checkbox'							
								);	
			$options[] = array(  'name'	=> 'Timthumb',
								'desc'	=> 'Turn "OFF" to disable the Timthumb.',
								'id'  	=> $shortname.'_timthumb',
								'std' 	=> 'true',
								'type' 	=> 'checkbox'							
								);	

			$options[] = array(	'name'	=> 'Contact E-mail ID',
								'desc'	=> "Enter your E-mail address to use on the Contact US Page Template. Ex: name@yoursite.com ",
								'id'	=> $shortname.'_contactemail',
								'std'	=> '',
								'inputsize'	=> '100%',
								'type'	=> 'text');

			$options[] = array( 'name'	=> 'Google Maps API Key',
								'desc'	=> "Paste your Google Maps API Key here. If you don't have one, please sign up for a <a href='http://code.google.com/intl/en-US/apis/maps/signup.html'>Google Maps API key</a> ",
								'id'	=> $shortname.'_gmapapikey',
								'std'	=> '',
								'type'	=> 'textarea');



			$options[] = array( 'name'	=> 'Custom CSS',
								'desc'	=> "Quickly add some CSS of your own choice to your theme by adding it to this block.",
								'id'	=> $shortname.'_extracss',
								'std'	=> '',
								'type'	=> 'textarea');
		
			


		// *******************************************************************//
		// ***** Homepage Setting
		// *******************************************************************//
		
		$options[] = array( 'name'	=> 'Homepage',
							'icon'	=> $url.'home-icon.png',
							'type'	=> 'heading');
			
			$options[] = array( 'name'	=> 'Homepage Teaser Text',
								'desc'	=> 'Turn "OFF" to disable the Teaser on Homepage below the slider.',
								'id'	=> $shortname.'_teaser_frontpage',
								'std'	=> '',
								'type'	=> 'checkbox');
								
			$options[] = array( 'name' => 'Homepage Widget Columns',
								'desc' => "Select the Columns Layout Style from below images to display on footer sidebar area and after selecting save the options and go to your widgets panel and assign the widgets in each column",
								'id'   => $shortname.'_frontpagewidgetcount',
								'std'  => '2',
								'type' => 'images',
								'options' => array(
										'1' => $url . 'columns/1col.png',
										'2' => $url . 'columns/2col.png',
										'3' => $url . 'columns/3col.png')
								);

			$options[] = array(	'name'	=> 'Homepage Content',
								'desc'	=> 'Select the page you want to assign on homepage below the slider as a welcome content.',
								'id'	=> $shortname.'_homepage',
								'std'	=> '2',
								'type'	=> 'select',
								'options' => $dynamic_homepages);		

		// *******************************************************************//
		// ***** Colors Setting
		// *******************************************************************//

		$options[] = array( 'name'	=> 'Color',
							'icon'	=> $url.'colors-icon.png',
							'type'	=> 'heading');

			/*$options[] =array(	'name'	=> 'Colors',
								'desc'	=> 'Select your themes alternative color scheme for this Theme ',
								'id'	=> $shortname.'_default_colors',
								'std'	=> '', 
								'options'=> $colors_select,
								'type'	=> 'select');*/

			$options[] = array( 'name'		=> 'Layout Option',
								'desc'		=> 'Select the layout option BOXED LAYOUT or STRETCHED LAYOUT',
								'id'		=> $shortname.'_layoutoption',
								'std'		=> 'boxed',
								'options'	=> array(
										'stretched'	=> 'Stretched',
										'boxed'		=> 'Boxed'),
								'type'		=> 'select');

			$options[] = array(	'name'	=> 'Body Background Properties',
								'desc'	=> 'Select the Background Image for Body and assign its Properties according to your requirements.',
								'id'	=> $shortname.'_bodyproperties',
								'std'	=> array(
											'image'		=> '',
											'color'		=> '',
											'style' 	=> 'repeat',
											'position'	=> 'center top',
											'attachment'=> 'scroll'),
								'type'	=> 'background');
	
			$options[] = array( 'name' => 'Background Pattern Images',
								'desc' => "Select the Columns Layout Style from below images to display on footer sidebar area and after selecting save the options and go to your widgets panel and assign the widgets in each column",
								'id'   => $shortname.'_overlayimages',
								'std'  => '2',
								'type' => 'images',
								'options' => array(
										''			   => $url . '/patterns/pat0.png',
										'pattern1.png' => $url . '/patterns/pat1.png',
										'pattern2.png' => $url . '/patterns/pat2.png',
										'pattern3.png' => $url . '/patterns/pat3.png',
										'pattern4.png' => $url . '/patterns/pat4.png',
										'pattern5.png' => $url . '/patterns/pat5.png',
										'pattern6.png' => $url . '/patterns/pat6.png',
										'pattern7.png' => $url . '/patterns/pat7.png',
										'pattern8.png' => $url . '/patterns/pat8.png')
								);
			$options[] = array(	'name'	=> 'Header Background Properties',
								'desc'	=> 'Select the Background Image for Header and assign its Properties according to your requirements.',
								'id'	=> $shortname.'_headerbg',
								'std'	=> array(
											'image'		=> '',
											'color'		=> '',
											'style' 	=> 'repeat',
											'position'	=> 'center top',
											'attachment'=> 'scroll'),
								'type'	=> 'background');

			

			$options[] = array(	'name'	=> 'Subheader Background Properties',
								'desc'	=> 'Select the Background Image for Subheader and assign its Properties according to your requirements.',
								'id'	=> $shortname.'_subheaderproperties',
								'std'	=> array(
											'image'		=> '',
											'color'		=> '',
											'style' 	=> 'repeat',
											'position'	=> 'center top',
											'attachment'=> 'scroll'),
								'type'	=> 'background');

			$options[] = array(	'name'	=> 'Logo Text Color',
								'id'	=> $shortname.'_logotextcolor',
								'std'	=> '', 
								'desc'	=> 'This will apply only if you do not upload a custom logo image',
								'type'	=> 'color');
	
			$options[] = array(	'name'	=> 'Homepage Teaser  Portfolio Background Color',
								'id'	=> $shortname.'_frontteaserbg',
								'std'	=> '', 
								'desc'	=> 'Teaser background color below the frontpage slider.',
								'type'	=> 'color');

			$options[] = array(	'name'	=> 'Page Background Color',
								'id'	=> $shortname.'_wrapbg',
								'std'	=> '', 
								'desc'	=> 'This will apply color to the wrapper of the theme which is of width 980px currently.',
								'type'	=> 'color');
	
			$options[] = array(	'name'	=> 'Tabs Color',
								'id'	=> $shortname.'_tabsbgcolor',
								'std'	=> '', 
								'desc'	=> 'Tabs Background Color set to default with theme if you choose color from here it will change all the tabs shortcodes used in the theme.',
								'type'	=> 'color');

			$options[] = array(	'name'	=> 'Link Color',
								'id'	=> $shortname.'_link',
								'std'	=> '', 
								'desc'	=> 'Default theme links color',
								'type'	=> 'color');
	
			$options[] = array(	'name'	=> 'Link Hover Color',
								'id'	=> $shortname.'_linkhover',
								'std'	=> '', 
								'desc'	=> 'Default theme links mousehover color',
								'type'	=> 'color');
	
			$options[] = array(	'name'	=> 'Subheader Link Color',
								'id'	=> $shortname.'_subheaderlink',
								'std'	=> '', 
								'desc'	=> 'Links under subheader section',
								'type'	=> 'color');

			$options[] = array(	'name'	=> 'Subheader Link Hover Color',
								'id'	=> $shortname.'_subheaderlinkhover',
								'std'	=> '', 
								'desc'	=> 'Links mouse-hover under subheader section',
								'type'	=> 'color');
	
			$options[] = array(	'name'	=> 'Menu Background Color',
								'desc'	=> 'Menubar background color', 
								'id'	=> $shortname.'_menubg',
								'std'	=> '', 
								'type'	=> 'color');

			$options[] = array(	'name'	=> 'Menu Font',
								'desc'	=> 'Font Size - Line Height - Font Face - Font Style - Font Color.',
								'id'	=> $shortname.'_mainmenufont',
								'std'	=> array(
										'size' 		=> '12px',
										'lineheight'=> '21px',
										'face' 		=> 'Arial',
										'style' 	=> 'Normal',
										'color' 	=> ''),
								'type'	=> 'typography');

			$options[] = array(	'name'	=> 'Menu Hover Background Color',
								'desc'	=> 'Menu Hover Background Color (dropdowns menus items) ', 
								'id'	=> $shortname.'_navhoverbg',
								'std'	=> '', 
								'type'	=> 'color');

			$options[] = array(	'name'	=> 'Sub Menu Link hover',
								'desc'	=> 'Sub Menu Link hover (dropdowns menu link hover) ', 
								'id'	=> $shortname.'_navhoverlink',
								'std'	=> '', 
								'type'	=> 'color');
	
			$options[] = array(	'name'	=> 'Sub Menu Hover Link Color',
								'desc'	=> 'Sub Menu Link Hover Color (dropdowns menu links) ', 
								'id'	=> $shortname.'_subnavhover',
								'std'	=> '', 
								'type'	=> 'color');
	
			$options[] = array(	'name'	=> 'Breadcrumb Text Color',
								'desc'	=> 'Breadcrumbs below the subheader section, (the default text color).', 
								'id'	=> $shortname.'_breadcrumbtext',
								'std'	=> '', 
								'type'	=> 'color');

			$options[] = array(	'name'	=> 'Breadcrumb Link Color',
								'desc'	=> 'Breadcrumbs below the subheader section, (link color).', 
								'id'	=> $shortname.'_breadcrumblink',
								'std'	=> '', 
								'type'	=> 'color');

			$options[] = array(	'name'	=> 'Breadcrumb Link Hover Color',
								'desc'	=> 'Breadcrumbs below the subheader section, (link hovered color).', 
								'id'	=> $shortname.'_breadcrumblinkhover',
								'std'	=> '', 
								'type'	=> 'color');
	
			$options[] = array(	'name'	=> 'Sidebar Background Color',
								'desc'	=> 'Background color for the sidebar layout either left or rightsidebar', 
								'id'	=> $shortname.'_sidebarbgcolor',
								'std'	=> '', 
								'type'	=> 'color');

			$options[] = array(	'name'	=> 'Footer Background Color',
								'desc'	=> 'Footer background color includes the sidebar footer widgets area as well. you can disable this sidebar footer area in Footer Tab and disable the sidebar footer.', 
								'id'	=> $shortname.'_footerbgcolor',
								'std'	=> '', 
								'desc'	=> 'Widgetized Footer Sidebar Area',
								'type'	=> 'color');
	
			$options[] = array(	'name'	=> 'Footer Text Color',
								'desc'	=> 'Footer text including paragraph element, (without links).', 
								'id'	=> $shortname.'_footertextcolor',
								'std'	=> '', 
								'type'	=> 'color');
	
			$options[] = array(	'name'	=> 'Footer Heading Color',
								'desc'	=> 'Footer Widget Titles color', 
								'id'	=> $shortname.'_footerheadingcolor',
								'std'	=> '', 
								'type'	=> 'color');
	
			$options[] = array(	'name'	=> 'Footer Link Color',
								'desc'	=> 'Footer containing links under widget or text widget, (link color).', 
								'id'	=> $shortname.'_footerlinkcolor',
								'std'	=> '', 
								'type'	=> 'color');
	
			$options[] = array(	'name'	=> 'Footer Link Hover Color',
								'desc'	=> 'Footer content containing any links under widget or text widget, (link hover color).', 
								'id'	=> $shortname.'_footerlinkhovercolor',
								'std'	=> '', 
								'type'	=> 'color');
			
			$options[] = array(	'name'	=> 'Copyright Background Color',
								'desc'	=> 'Copyright area below the footer sidebar footer. (background color).', 
								'id'	=> $shortname.'_copybgcolor',
								'std'	=> '', 
								'type'	=> 'color');
	
			$options[] = array(	'name'	=> 'Copyright Link Color',
								'desc'	=> 'Copyright content containing any links color. (link color).', 
								'id'	=> $shortname.'_copylinkcolor',
								'std'	=> '', 
								'type'	=> 'color');
				
			$options[] = array(  'name'	=> 'Enable Custom Typography',
								'desc'	=> 'Turn "ON" to enable the custom typography which will overide the default css and enables the below customization and colors',
								'id'  	=> $shortname.'_customtypo',
								'std' 	=> 'true',
								'type' 	=> 'checkbox');

			$options[] = array(	'name'	=> 'Body Font',
								'desc'	=> 'Font Size - Line Height - Font Face - Font Style - Font Color.',
								'id'	=> $shortname.'_bodyp',
								'std'	=> array(
										'size'		=> '12px',
										'lineheight'=> '18px',
										'face'		=> '',
										'style'		=> 'Normal',
										'color'		=> ''),
								'type'	=> 'typography');
	
			$options[] = array(	'name'	=> 'Heading 1',
								'desc'	=> 'Font Size - Line Height - Font Face - Font Style - Font Color.',
								'id'	=> $shortname.'_h1',
								'std'	=> array(
										'size' 		=> '28px',
										'lineheight'=> '30px',
										'face' 		=> '',
										'style' 	=> 'Normal',
										'color' 	=> ''),
								'type'	=> 'typography');

			$options[] = array(	'name'	=> 'Heading 2',
								'desc'	=> 'Font Size - Line Height - Font Face - Font Style - Font Color.',
								'id'	=> $shortname.'_h2',
								'std'	=> array(
										'size' 		=> '25px',
										'lineheight'=> '26px',
										'face' 		=> 'Arial',
										'style'		=> 'Normal',
										'color' 	=> ''),
								'type'	=> 'typography');

			$options[] = array(	'name'	=> 'Heading 3',
								'desc'	=> 'Font Size - Line Height - Font Face - Font Style - Font Color.',
								'id'	=> $shortname.'_h3',
								'std'	=> array(
										'size' 		=> '22px',
										'lineheight'=> '23px',
										'face' 		=> 'Arial',
										'style' 	=> 'Normal',
										'color' 	=> ''),
								'type'	=> 'typography');

			$options[] = array(	'name'	=> 'Heading 4',
								'desc'	=> 'Font Size - Line Height - Font Face - Font Style - Font Color.',
								'id'	=> $shortname.'_h4',
								'std'	=> array(
										'size' 		=> '18px',
										'lineheight'=> '20px',
										'face' 		=> 'Arial',
										'style' 	=> 'Normal',
										'color' 	=> ''),
								'type'	=> 'typography');

			$options[] = array(	'name'	=> 'Heading 5',
								'desc'	=> 'Font Size - Line Height - Font Face - Font Style - Font Color.',
								'id'	=> $shortname.'_h5',
								'std'	=> array(
										'size'		=> '15px',
										'lineheight'=> '16px',
										'face'		=> 'Arial',
										'style'		=> 'Normal',
										'color'		=> ''),
								'type'	=> 'typography');

			$options[] = array(	'name'	=> 'Heading 6',
								'desc'	=> 'Font Size - Line Height - Font Face - Font Style - Font Color.',
								'id'	=> $shortname.'_h6',
								'std'	=> array(
										'size'		=> '12px',
										'lineheight'=> '14px',
										'face'		=> 'Arial',
										'style'		=> 'bold italic',
										'color'		=> ''),
								'type'	=> 'typography');

			$options[] = array(	'name'	=> 'Blog Post Title',
								'desc'	=> 'Font Size - Line Height - Font Face - Font Style - Font Color.',
								'id'	=> $shortname.'_entrytitle',
								'std'	=> array(
										'size'		=> '22px',
										'lineheight'=> '24px',
										'face'		=> 'Arial',
										'style'		=> 'Normal',
										'color'		=> ''),
								'type'	=> 'typography');

			$options[] = array(	'name'	=> 'Blog Post Title Link Hover',
								'desc'	=> 'Blog post title hover color (will effect in blog shortcodes titles as well).', 
								'id'	=> $shortname.'_entrytitlelinkhover',
								'std'	=> '', 
								'type'	=> 'color');

			$options[] = array(	'name'	=> 'Sidebar Widget Titles',
								'desc'	=> 'Font Size - Line Height - Font Face - Font Style - Font Color.',
								'id'	=> $shortname.'_sidebartitle',
								'std'	=> array(
										'size'		=> '12px',
										'lineheight'=> '16px',
										'face'		=> 'Arial',
										'style'		=> 'Normal',
										'color'		=> ''),
								'type'	=> 'typography');

			$options[] = array(	'name'	=> 'Footer Copyright',
								'desc'	=> 'Font Size - Line Height - Font Face - Font Style - Font Color.',
								'id'	=> $shortname.'_copyrights',
								'std'	=> array(
										'size'		=> '11px',
										'lineheight'=> '20px',
										'face'		=> 'Tahoma',
										'style'		=> 'Normal',
										'color'		=> ''),
								'type'	=> 'typography');
		
		// *******************************************************************//
		// ***** Slider Setting
		// *******************************************************************//

		$options[] = array( 'name'	=> 'Sliders',
							'icon'	=> $url.'slider-icon.png',
							'type'	=> 'heading');

			$options[]=	array(	'name'	=> 'Slider',
								'desc'	=> 'Turn "OFF" to disable the frontpage Slider',
								'id'	=> $shortname.'_slidervisble',
								'std'	=> '',
								'type'	=> 'checkbox');
			
				
			$options[] = array(	'name'	=> 'Slider Background Properties',
								'desc'	=> 'Select the Background Image for Body and assign its Properties according to your requirements.',
								'id'	=> $shortname.'_sliderbgprop',
								'std'	=> array(
											'image'		=> '',
											'color'		=> '',
											'style' 	=> 'repeat',
											'position'	=> 'center top',
											'attachment'=> 'scroll'),
								'type'	=> 'background');

			$options[] = array( 'name'	=> 'Select Slider',
								'desc'	=> 'Select which slider you want to use for the Frontpage of the theme.',
								'id'	=> $shortname.'_slider',
								'std'	=> 'videoslider',
								'options' => array( 
										'cycleslider'	=> 'Cycle Slider',
										'carouselslider'	=>'Carousel Slider',
										'videoslider'	=>'Single Video',
										'static_image'	=>'Static Image'),
								'type'	=> 'select');
		
			
			
			$options[] = array( 'name'	=> 'CycleSlider Slides Limits',
									'desc'	=> 'Enter the slides you want to hold on the CycleSlider',
									'id'	=> $shortname.'_cycleslidelimit',
									'class' => 'atpsliders cycleslider',
									'std'	=> '5',
									'type'	=> 'text',
									'inputsize' => '70');

			$options[] = array( 'name'	=> 'Video Embed Code',
								'desc'	=> 'Enter the video embed code which will display on your frontpage slider area.',
								'id'	=> $shortname.'_video_id',
								'class' => 'atpsliders videoslider',
								'std'	=> '',
								'type'	=> 'textarea',
								'inputsize' => '');

			$options[] = array( 'name'	=> 'Static Image',
								'desc'	=> 'Upload the image size 980 x 400 pixels to display on the homepage instead of slider.',
								'id'	=> $shortname.'_static_image_upload',
								'class' => 'atpsliders static_image',
								'std'	=> '',
								'type'	=> 'upload');

			$options[] = array( 'name'	=> 'StaticImage Slider URL',
								'desc'	=> 'Enter the external or any URL to link to this static image.',
								'id'	=> $shortname.'_static_link',
								'class' => 'atpsliders static_image',
								'std'	=> '',
								'type'	=> 'text');

	
		// *******************************************************************//
		// ***** Post Options
		// *******************************************************************//

		$options[] = array( 'name'	=> 'Post Options',
							'icon'	=> $url.'post-icon.png',
							'type'	=> 'heading');

			$options[] = array(	'name'	=> 'About Author',
								'desc'	=> 'Turn "OFF" if you want to disable the Author Info Box in post single page at the end of the post',
								'id'	=> $shortname.'_aboutauthor',
								'std'	=> '',
								'type'	=> 'checkbox');	

			$options[] = array(	'name'	=> 'Related Posts',
								'desc'	=> 'Turn "OFF" if you want to disable the related posts in post single page (based on tags).',
								'id'	=> $shortname.'_relatedposts',
								'std'	=> '',
								'type'	=> 'checkbox');	

			$options[] = array(	'name'	=> 'Post / Page Comments',
								'desc'	=> 'Select if you want to display comments on posts and/or pages.',
								'id'	=> $shortname.'_commentstemplate',
								'std'	=> 'fullpage',
								'options'	=> array(
										'posts'	=> 'Posts Only',
										'pages'	=> 'Pages Only', 
										'both'	=> 'Pages/posts',
										'none'	=> 'None'),
								'type'	=> 'select');

			$options[] = array(	'name'	=> 'Single Page Next/Previous',
								'desc'	=> 'Turn "OFF" if you want to disable next/previous Post Single Page',
								'id'	=> $shortname.'_singlenavigation',
								'std'	=> '',
								'type'	=> 'checkbox');
			$options[] = array(	"name"	=> "Post Single Page Featured Image",
								"desc"	=> 'Turn "OFF" if you want to disable Featured Image on post single page',
								"id"	=> $shortname."_singlefeaturedimg",
								"std"	=> "",
								"type"	=> "checkbox"
								);
														
		// *******************************************************************//
		// ***** Blog Options
		// *******************************************************************//

		$options[] = array( 'name'	=> 'Blog Options',
						'icon'	=> $url.'post-icon.png',
						'type'	=> 'heading');

			$options[] = array( 'name'	=> 'Blog Page Categories',
								'desc'	=> 'Selected "ON" categories will hold the posts from it in blog page. ( template : template_blog.php)',
								'id'	=> $shortname.'_blogacats',
								'std'	=> '',
								'type'	=> 'multicheck',
								'options'	=> $dynamic_cats);	

			$options[] = array( 'name'	=> 'Default Blog Style Image Height',
								'desc'	=> 'Enter the height of the default blog post style featured image. Default height is 150px.',
								'id'	=> $shortname.'_psd_imgheight',
								'std'	=> '',
								'type'	=> 'text',
								'inputsize'=> '100');

			$options[] = array( 'name'	=> 'Blog Style 1 Image Height',
								'desc'	=> 'Enter the height of the blog post style 1 featured image. Default height is 150px.',
								'id'	=> $shortname.'_ps1_imgheight',
								'std'	=> '',
								'type'	=> 'text',
								'inputsize'=> '100');

			$options[] = array( 'name'	=> 'Blog Style 2 Image Height',
								'desc'	=> 'Enter the height of the blog post style 2 featured image. Default height is 150px.',
								'id'	=> $shortname.'_ps2_imgheight',
								'std'	=> '',
								'type'	=> 'text',
								'inputsize'=> '100');

			$options[] = array( 'name'	=> 'Blog Style 3 Image Height',
								'desc'	=> 'Enter the height of the blog post style 3 featured image. Default height is 150px.',
								'id'	=> $shortname.'_ps3_imgheight',
								'std'	=> '',
								'type'	=> 'text',
								'inputsize'=> '100');

		// *******************************************************************//
		// ***** Custom Sidebar
		// *******************************************************************//

		$options[] = array( 'name'	=> 'Custom Sidebar',
							'icon'	=> $url.'sidebar-icon.png',
							'type'	=> 'heading');

			$options[] = array( 'name'	=> 'Custom Sidebars',
								'desc'	=> 'Create the desired name for your site sidebars and go to widgets which will appear in rightsidebar below the footer column widgets. After assigning the widgets in the prefered sidebar you can assign the sidebar to individual pages/posts. Find the custom sidebar in rightside of the wordpress admin panels.',
								'id'	=> $shortname.'_customsidebar',
								'std'	=> '',
								'type'	=> 'customsidebar');

		// *******************************************************************//
		// ***** Footer options
		// *******************************************************************//

		$options[] = array( 'name'	=> 'Footer',
							'icon'	=> $url.'footer-icon.png',
							'type'	=> 'heading');
	
			$options[] = array( 'name'	=> 'Footer Teaser',
								'desc'	=> 'Turn "OFF" to disable the Teaser on Footer above the sidebar footer.',
								'id'	=> $shortname.'_teaser_footer',
								'std'	=> '',
								'type'	=> 'checkbox');
	
			$options[] = array( 'name'	=> 'Footer Teaser Text',
								'desc'	=> 'Custom HTML and Text that will appear above the sidebar footer.',
								'id'	=> $shortname.'_teaser_footer_text',
								'std'	=> '',
								'type'	=> 'textarea'); 

			$options[] = array(	'name'	=> 'Footer Sidebar',	
								'desc'	=> 'If "OFF" Sidebar Footer containing the widgets with columnized will not be displayed.',
								'id'	=> $shortname.'_footer_sidebar',
								'std'	=> '',
								'type'	=> 'checkbox');
			
			$options[] = array( 'name' => 'Footer Columns',
								'desc' => "Select the Columns Layout Style from below images to display on footer sidebar area and after selecting save the options and go to your widgets panel and assign the widgets in each column",
								'id'   => $shortname.'_footerwidgetcount',
								'std'  => '2',
								'type' => 'images',
								'options' => array(
										'2' => $url . 'columns/2col.png',
										'3' => $url . 'columns/3col.png',
										'4' => $url . 'columns/4col.png',
										'5' => $url . 'columns/5col.png',
										'6' => $url . 'columns/6col.png',
										'half_one_half' => $url . 'columns/half_one_half.png',
										'half_one_third' => $url . 'columns/half_one_third.png',
										'one_half_half' => $url . 'columns/one_half_half.png',
										'one_third_half' => $url . 'columns/one_third_half.png'
										)
								);

			$options[] = array(	'name'	=> 'Google Analytics',
								'desc'	=> 'Paste your Google Analytics code here which starts from &lt;script> here. This will be added into the footer of your theme.',
								'id'	=> $shortname.'_googleanalytics',
								'std'	=> '',
								'type'	=> 'textarea');

			$options[] = array(	'name'	=> 'Footer Copyright Notice',
								'desc'	=> 'Here you can place the Footer Copyright Content',
								'id'	=> $shortname.'_copyright',
								'std'	=> '',
								'type'	=> 'textarea');	
			
		// *******************************************************************//
		// ***** Sociables
		// *******************************************************************//

		$options[] = array( 'name'	=> 'Sociables',
							'icon'	=> $url.'social-icon.png',
							'type'	=> 'heading');

			$options[] = array(	'name'	=> 'Sociables',	
								'desc'	=> 'Click Add New to add sociables where you can edit/add/delete. ',
								'id'	=> $shortname.'_social_bookmark',
								'std'	=> '',
								'type'	=> 'custom_socialbook_mark');

		// *******************************************************************//
		// ***** Sticky Bar
		// *******************************************************************//
		
		$options[] = array( 'name'	=> 'Sticky Bar',
							'icon'	=> $url.'sticky-icon.png',
							'type'	=> 'heading');
		
			$options[] = array( 'name'	=> 'Sticky Notice Bar',
								'desc'	=> 'OFF this option if you want to hide the sticky top notice bar.',
								'id'	=> $shortname.'_stickybar',
								'std'	=> '',
								'type'	=> 'checkbox');

			$options[] = array( 'name'	=> 'Sticky Content',
								'desc'	=> 'Enter the content which will be displayed sticky bar',
								'id'	=> $shortname.'_stickycontent',
								'std'	=> '',
								'type'	=> 'textarea');
								
			$options[] = array( 'name'	=> 'Sticky Bar Background Color',
								'desc'	=> 'Enter the color code for the stickybar',
								'id'	=> $shortname.'_stickybarcolor',
								'std'	=> '',
								'type'	=> 'color');
								

		// *******************************************************************//
		// ***** Cufon Font Options
		// *******************************************************************//

		$options[] = array( 'name'	=> 'Cufon Font',
							'icon'	=> $url.'cufon-icon.png',
							'type'	=> 'heading');

			$options[] = array( 'name'	=> 'Cufon Font',
								'shortinfo' => 'Custom Cufon Font Replacement',
								'desc'		=> 'If "OFF" Selected the Custom Cufon Font will be disabled and it will display the default font as set in style.css',
								'id'		=> $shortname.'_cufonenable',
								'std'		=> 'true',	
								'type'		=> 'checkbox');

			$options[] = array( 'name'	=> 'Select Cufon Font',
								'desc'	=> 'Select the font you want to choose for the headings. For more addition if you want to alter any code you can find the cufon replacement jquery code in functions/header.php line #158.',
								'id'	=> $shortname.'_cufon',
								'std'	=> '',
								'options' => $cufon_font,
								'type'	=> 'select');

			$options[] = array( 'name'	=> 'Font Preview',
								'desc'	=> 'The selected font preview',
								'id'	=> $shortname.'_cufonlive',
								'std'	=> 'Cufon Font Preview',
								'type'	=> 'cufonlive');


		// *******************************************************************//
		// ***** Language Options
		// *******************************************************************//
			$options[] = array( 'name'	=> 'Language',
							'icon'	=> $url.'settings-icon.png',
							'type'	=> 'heading');

			$options[] = array(	'name'	=> 'Readmore Text ',	
								'desc'	=> 'Read more text on sliders and other different areas on the theme',
								'id'	=> $shortname.'_readmore_text',
								'std'	=> '',
								'type'	=> 'text',
								'inputsize'	=> '');
				$options[]=array(  'name'	=> 'Reservation Leftsidetext Above calendar',
								'desc'	=> 'Reservation Leftsidetext Above calendar',
								'std'	=>'',
								'id'	=> $shortname.'_reservationleftsidetext',
								'type'	=>'text',
								'inputsize'	=>'' );
			$options[]=array(
								'name'	=> 'Reservation Page  Right side text',
								'std'	=> '',
								'id'	=>	$shortname.'_reservationinformationtext',
								'type'	=> 'text',
								'inputsize'	=>''
							);
			
			$options[]=array(
								'name'	=> 'Single page Price Text',
								'std'	=> '',
								'id'	=>	$shortname.'_priceperserving',
								'type'	=> 'text',
								'inputsize'	=>''
							);

			$options[] = array( 'name'	=> 'Posted In',
								'desc'	=> 'Used in the post meta of the blog posts including blog shortcodes',
								'id'	=> $shortname.'_postedin',
								'std'	=> '',
								'type'	=> 'text',
								'inputsize'=> '100');	

			$options[] = array( 'name'	=> "Text Separator in Blog page ex(':',',')",
								'desc'	=> 'Used in the post meta of the blog posts, including blog shortcodes.',
								'id'	=> $shortname.'_text_separator',
								'std'	=> '',
								'type'	=> 'text',
								'inputsize'=> '100');	

			$options[] = array( 'name'	=> 'Written By',
								'desc'	=> 'Used in the post meta of the blog posts, including blog shortcodes.',
								'id'	=> $shortname.'_bytxt',
								'std'	=> '',
								'type'	=> 'text',
								'inputsize'=> '100');

			$options[] = array( 'name'	=> '404 Page',
								'desc'	=> 'Custom text which appears in subheader area of the 404 Error page',
								'id'	=> $shortname.'_error404txt',
								'std'	=> '',
								'type'	=> 'textarea',
								'inputsize'=> '100');

			$options[] = array( 'name'	=> 'Search Button Text',
								'desc'	=> 'Custom text which appears in Search Button Text Search Form (can be used in search widget also)',
								'id'	=> $shortname.'_searchformtxt',
								'std'	=> '',
								'type'	=> 'text',
								'inputsize'=> '100');
			
		// *******************************************************************//
		// ***** DetCity Options
		// *******************************************************************//
		
		$options[] = array( 'name'	=> 'DetCity Options',
						'icon'	=> $url.'settings-icon.png',
						'type'	=> 'heading');

			$options[] = array( 'name'	=> 'Booking Page',
								'desc'	=> 'The WordPress page used to display the reservation form.',
								'id'	=> $shortname.'_bookingpage',
								'std'	=> '',
								'type'	=> 'select',
								'options'=> $dynamic_pages);			

			$options[] = array( 'name'	=> 'Time Format',
								'desc'	=> 'Defatult Time Format',
								'id'	=> $shortname.'_timeformat',
								'std'	=> '',
								'type'	=> 'select',
								'options'	=> array(
														'12' => '12 Hours Format',
														'24' => '24 Hours Format',

														),
								);	
			$options[] = array( 'name'	=> 'Reservation Button Text',
								'desc'	=> 'Custom text which appears in Button Text Reservation Form',
								'id'	=> $shortname.'_reservationformtxt',
								'std'	=> '',
								'type'	=> 'text',
								'inputsize'=> '100');

	}
}
?>