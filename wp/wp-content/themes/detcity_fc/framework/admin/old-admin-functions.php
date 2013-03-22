<?php
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
		$menulist_array = get_terms('menu_type','orderby=name&hide_empty=0');
		$dynamic_list = array();
		if(is_array($menulist_array)){
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

/*
 * Google Webfonts Array
 */

$google_fonts = array(	array( 	'name' => "Abel",
							 	'variant' => 'r'),
						array( 	'name' => "Antic",
							 	'variant' => ''),	
						array( 	'name' => "Andika",
							 	'variant' => ''),
						array( 	'name' => "Amaranth",
							 	'variant' => ':r,b,bi'),
						array( 	'name' => "Allerta",
							 	'variant' => ''),
						array( 	'name' => "Anonymous Pro",
							 	'variant' => ':r,b,bi'),
						array( 	'name' => "Arimo",
							 	'variant' => 'r,b,bi'),
						array( 'name' => "Bangers", 
								'variant' => ''),
						array( 'name' => "Bitter", 
								'variant' => ''),
						array( 	'name' => "Cantarell",
							 	'variant' => ':r,b,i,bi'),
						array( 	'name' => "Carme",
							 	'variant' => ''),
						array( 	'name' => "Coustard",
							 	'variant' => ':r,b'),
						array( 	'name' => "Cabin",
							 	'variant' => ':r,b,i,bi'),
						array( 	'name' => "Crushed",
							 	'variant' => ''),
						array( 	'name' => "Cantarell",
							 	'variant' => ':r,b,i,bi'),
						array( 	'name' => "Crimson Text",
							 	'variant' => ':r,b,i,bi'),
						array( 	'name' => "Cuprum",
							 	'variant' => ''),
						array( 	'name' => "Cardo",
							 	'variant' => ':r,b,i'),
						array( 	'name' => "Cookie",
							 	'variant' => ''),
						array( 	'name' => "Dr Sugiyama",
								'variant' => ''),
						array( 	'name' => "Dorsa",
								'variant' => ''),
						array( 	'name' => "Droid Sans",
								'variant' => ':r,b'),
						array( 	'name' => "Droid Serif",
								'variant' => ':r,b,i,bi'),
						array( 	'name' => "Federo",
								'variant' => ''),
						array( 	'name' => "Istok Web",
								'variant' => ':r,b,bi'),
						array( 	'name' => "Josefin Slab",
								'variant' => ':r,b,i,bi'),
						array( 	'name' => "Kaushan Script",
								'variant' => ''),
						array( 	'name' => "Lemon",
								'variant' => ':400'),
						array( 	'name' => "Lato",
								'variant' => ':r,b,i,bi'),								
						array( 	'name' => "Miss Fajardose",
								'variant' => ''),						
						array( 	'name' => "Merienda One",
								'variant' => ''),
						array( 	'name' => "Metrophobic",
								'variant' => ''),
						array( 	'name' => "Muli",
								'variant' => ':400'),
						array( 	'name' => "Mako",
								'variant' => ''),
						array( 	'name' => "Maven Pro",
								'variant' => ':r,b'),
						array( 	'name' => "Nova Mono",
								'variant' => ':400'),
						array( 	'name' => "Neuton",
								'variant' => ':r,i,b'),
						array( 	'name' => "Numans",
								'variant' => ''),
						array( 	'name' => "Open Sans Condensed",
								'variant' => ':300'),								
						array( 	'name' => "PT Serif Caption",
								'variant' => ':400'),
						array( 'name' => "Podkova", 
								'variant' => ':400'),
						array( 'name' => "Petrona", 
								'variant' => ''),
						array( 'name' => "Ropa Sans", 
								'variant' => ':400,400italic'),
						array( 'name' => "PT Sans Narrow", 
								'variant' => ':400'),
						array( 'name' => "Quattrocento Sans", 
								'variant' => ''),
						array( 	'name' => "Spinnaker",
								'variant' => ''),
						array( 	'name' => "Shanti",
								'variant' => ''),
						array( 	'name' => "Terminal Dosis",
								'variant' => ''),
						array( 	'name' => "Tienne",
								'variant' => ':r,b'),
						array( 	'name' => "Tenor Sans",
								'variant' => ''),
						array( 'name' => "Varela", 
								'variant' => ''),
						array( 'name' => "Vollkorn", 
								'variant' => ':r,b,bi'),
						array( 'name' => "Yellowtail", 
								'variant' => ''),								
						array( 'name' => "Zeyada", 
								'variant' => ''),
	);

add_action( 'wp_head', 'atp_google_webfonts' );	
if (!function_exists( "atp_google_webfonts")) {
	function atp_google_webfonts() { 
		global $google_fonts;				
		$fonts = '';
		global $options;
		// Go through the options
		if ( !empty($options) ) {  
			foreach ( $options as $key => $option ) {
				$option_types=$option['type'];

					if($option_types == "typography")
					{
						foreach ($google_fonts as $font) {
						$gfont=get_option($option['id']);
						$googlefont=$gfont['face'];
								if ( $googlefont == $font['name']){
									$fonts .= $font['name'].$font['variant']."|";
									}	
						}
					}
			}	
		}
			// Output google font css in header			
			if ( $fonts ) {
				$fonts = str_replace( " ","+",$fonts);	
				$out = "\n<!-- Google Fonts -->\n";
				$out.= '<link href="http://fonts.googleapis.com/css?family=' . $fonts .'" rel="stylesheet" type="text/css" />'."\n\n";
				echo str_replace( '|"','"',$out);
			}

	}
}

/**
 * Cufon Font
 * @param inputStr - Fetch Cufon file content
 * @param delimeterLeft - delimeter prefix
 * @param delimeterRight - delimeter suffix
 * @param debug true/false
 */

function font_name($inputStr, $delimeterLeft, $delimeterRight, $debug = false) {
	$posLeft = strpos($inputStr, $delimeterLeft);
	if ($posLeft === false) {
		if ($debug) {
			echo "Warning: left delimiter '{$delimeterLeft}' not found";
		}
		return false;
	}

	$posLeft += strlen($delimeterLeft);
	$posRight = strpos($inputStr, $delimeterRight, $posLeft);
	if ($posRight === false) {
		if ($debug) {
			echo "Warning: right delimiter '{$delimeterRight}' not found";
		}
		return false;
	}
	return substr($inputStr, $posLeft, $posRight - $posLeft);
}
?>