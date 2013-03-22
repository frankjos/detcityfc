<?php
add_action('init','atp_advance_options');

if (!function_exists('atp_advance_options')) {
	$advance_options = array();
	function atp_advance_options(){
		global $advance_options,$shortname,$url;
		

		//***** Stylesheets Reader
		$alt_stylesheet_path = ATP_FILEPATH . '/styles/';
		$url =  ATP_DIRECTORY . '/framework/admin/images/';
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

					
		// ***** Advanced Options	
		$advance_options[] = array( "name"	=> "Import / Export",
							"icon"	=> $url."settings-icon.png",
							"type"	=> "heading");

			$advance_options[] = array( "name"	=> "Export",
								"desc"	=> "Export the Settings ( Make sure you read documentation before taking a backup or exporting settings.) Copy the entire code and paste in any text editor and save in you PC",
								"id"	=> $shortname."_export",
								"std"	=> "",
								"type"	=> "export");

			$advance_options[] = array( "name"	=> "Import",
								"desc"	=> "Import the settings you have copied or taken backup from your previous theme options for this theme. Paste the code and click save settings",
								"id"	=> $shortname."_template_option_values",
								"std"	=> "",
								"type"	=> "import");
	}
}
?>