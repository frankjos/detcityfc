<?php 

	/**
	 * enqueue javascript in admin header
	 */

	function admin_enqueue_scripts() {
		if(is_admin()) {
			wp_enqueue_script('admincufon-yui', get_template_directory_uri(). '/js/cufon-yui.js' );
		
		}
		wp_enqueue_script('atp_empty',ATP_DIRECTORY . '/js/empty.js');
			wp_localize_script( 'atp_empty', 'atp_panel', array(
				'SiteUrl' =>get_stylesheet_directory_uri()
			));
	 }

	/**
	 * enqueue scripts in theme header
	 *
	 */
	function theme_enqueue_scripts() {
		if (!is_admin()) {
			// comment out the next two lines to load the local copy of jQuery
			//wp_deregister_script('jquery');
			wp_register_script('jquery',ATP_DIRECTORY .'/js/jquery-1.7.1.min.js');
			wp_register_script('atp_custom', ATP_DIRECTORY . '/js/sys_custom.js', 'jquery','1.0','in_footer');
			wp_register_script('jquery-gmap', ATP_DIRECTORY .'/js/jquery.gmap.js');
			wp_register_script('sf-hover', ATP_DIRECTORY .'/js/hoverIntent.js');
			wp_register_script('sf-menu', ATP_DIRECTORY .'/js/superfish.js');
			wp_register_script('atp-jgalleria', ATP_DIRECTORY .'/js/src/galleria.js','jquery','','');
			wp_register_script('atp-jgclassic', ATP_DIRECTORY .'/js/src/themes/classic/galleria.classic.js','jquery','','');
			wp_register_script('atp-form', ATP_DIRECTORY .'/js/jquery.form.js','jquery','','');
			wp_register_script('atp-nivoslide', ATP_DIRECTORY .'/js/jquery.nivo.slider.pack.js', 'jquery','','');
			wp_register_script('atp-validate', ATP_DIRECTORY .'/js/jquery.validate.js','jquery','','');
			wp_register_script('atp-cycle', ATP_DIRECTORY .'/js/jquery.cycle.all.min.js','jquery','','in_footer');
			wp_register_script('atp-datepicker', ATP_DIRECTORY .'/framework/admin/js/jquery.datepicker.js','jquery','','');
			
			// Enqueue Scripts
			wp_enqueue_script('jquery');
			wp_enqueue_script('atp-easing', ATP_DIRECTORY .'/js/jquery.easing.1.3.js','jquery','','');
			wp_enqueue_script('sf-hover');
			wp_enqueue_script('sf-menu');
			//wp_enqueue_script('atp-preloader', ATP_DIRECTORY .'/js/jquery.preloadify.min.js','jquery','','');
			wp_enqueue_script('atp-scrolltopcontrol',ATP_DIRECTORY.'/js/scrolltopcontrol.js','jquery','','');
			wp_enqueue_script('atp-flowtools', ATP_DIRECTORY .'/js/jquery.tools.min.js','jquery','','');
			wp_enqueue_script('atp-lightbox', ATP_DIRECTORY .'/js/lightbox/jquery.lightbox.js','jquery','','');
			wp_enqueue_script('atp-cycle');
			wp_enqueue_script('atp_custom');
		}

		/**
		 * enqueue scripts in homepage only
		 */
		if(is_home()){
			$chooseslider=get_option('atp_slider');
			switch ($chooseslider):
				case 'cycleslider':
					wp_enqueue_script('jquery_slider', ATP_DIRECTORY .'/js/cycle_slider.js', 'jquery');
					break;
			endswitch;
		}

		if ( is_singular() ){
			wp_enqueue_script( 'comment-reply' );
		}
	}

	/**
	 * enquery Stylesheets
	 */
	function theme_enqueue_styles(){
		
		//Register Styles
		wp_register_style('reservation-style', ATP_DIRECTORY.'/framework/admin/css/pepper-grinder/jquery-ui-1.8.16.custom.css', false, false, 'all');

		//Enqueue Styles
		wp_enqueue_style('lightbox-style', ATP_DIRECTORY.'/js/lightbox/themes/default/jquery.lightbox.css', false, false, 'all');

		wp_enqueue_style('sf-style', ATP_DIRECTORY.'/css/superfish.css', false, false, 'all');

		//Nivo Slider Stylesheet used for shortcode slider (Nivo)
		wp_enqueue_style('nivo-style', ATP_DIRECTORY.'/css/nivo-slider.css', false, false, 'all');
		
		if (is_page_template('template_reservation.php') )  {
			wp_enqueue_style('reservation-style', ATP_DIRECTORY.'/framework/admin/css/pepper-grinder/jquery-ui-1.8.16.custom.css', false, false, 'all');
		}
		
		if(is_home()){
			$chooseslider=get_option('atp_slider');
			switch ($chooseslider):
				case 'cycleslider':
					wp_enqueue_style('cycle-style', ATP_DIRECTORY.'/css/cycle_slider.css', false, false, 'all');
					break;
			endswitch;
		}
	}

	if (is_page_template('template_reservation.php') )  {
		wp_print_scripts('atp_reservation_scripts');
	}
		
	/**
	 * Add Action
	 * Execute functions hooked on a specific action hook
	 */
	if(!is_admin())	{
		add_action('wp_print_scripts', 'theme_enqueue_scripts');
		add_action('wp_print_styles', 'theme_enqueue_styles');
	}
		
	add_action('wp_print_scripts', 'admin_enqueue_scripts');
	add_action('wp_print_scripts','atp_reservation_scripts');
	add_action('wp_print_styles','atp_reservation_styles');
		
	function atp_reservation_scripts() {
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('atp-datepicker');
	}

	function atp_reservation_styles() {
		wp_enqueue_style('reservation-style');
	}

	/**
	 * Cufon enqueue
	 *
	 */
	function sys_cufon_function() {
		$cufon_font_location = TEMPLATEPATH . '/js/cufon';
		/*echo "
		<script type='text/javascript' src='TEMPLATEPATH/js/cufon/cufon-yui.js'></script> ";*/ 
		$cufonenable = get_option('atp_cufonenable');
		if($cufonenable == "on") {
			wp_enqueue_script('cufon-yui', get_template_directory_uri(). '/js/cufon-yui.js' );
			wp_print_scripts('cufon-yui');

			foreach (glob( TEMPLATEPATH . "/js/cufon/*") as $path_to_files) {

				$file_name = basename($path_to_files);

				if (get_option('atp_cufon')) {
					$file_contents = file_get_contents($path_to_files,true);
					$delimeterLeft = 'font-family":"';
					$delimeterRight = '"';
					$font_names = font_name($file_contents, $delimeterLeft,$delimeterRight, $debug = false);
						
					if( get_option('atp_cufon')==$font_names) {
						wp_enqueue_script($font_names,  get_template_directory_uri(). '/js/cufon/'.$file_name);
						wp_print_scripts($font_names);
						if(get_option('atp_wpcuf_code') =="") {
							echo "<script type='text/javascript'>";
							echo "/* <![CDATA[ */";
							$cufon_scriptss="Cufon.replace('h1, h2, h3, h4, h5,', { hover:true, fontFamily: '$font_names' });\n";
							echo 	$cufon_scriptss;
							echo "/* ]]> */";
							echo "</script>";
						}
					}	
				}
			}
		}
	}
	add_action('wp_head', 'sys_cufon_function');
	
?>