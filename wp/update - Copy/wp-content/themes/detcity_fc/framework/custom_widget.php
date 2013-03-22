<?php

	/**
	 * Register Sidebars
	 */
	if(function_exists('register_sidebar')){
		register_sidebar( array(
			'name'			=> __( 'Main Sidebar', 'atp_admin' ),
			'id'			=> 'defaultsidebar',
			'before_title'	=>'<h3 class="widget-title">',
			'after_title'	=>'</h3>',
			'before_widget'	=>'<div id="%1$s" class="clearfix syswidget %2$s">',
			'after_widget'	=>'</div>',
		));
		register_sidebar(array(
			'name'			=> 'Homepage Teaser Text',
			'id'			=>'homepage_teaser',
			'description'	=> __('Custom HTML and Text that will appear in the teaser text of your Homepage below header.', 'atp_admin'),
			'before_widget'	=>'<div class="teaserbox"><div class="teaserbox_content">',
			'after_widget'	=>'</div></div>',	
			'before_title'	=>'',
			'after_title'	=>'',

		));
	}

	/**
	 * Custom Sidebars
	 */
	if(function_exists('register_sidebar')){

		/**
		 * Frontpage Column Widgets
		 *-----------------------------
		 */
		// Frontpage column1
		register_sidebar(array(
			'name'			=> 'Frontpage Column1',
			'id'			=> 'frontpagecolumn1',
			'description'	=> __('Select only one widget which will appear on your Forntpage column1', 'atp_admin'),
			'before_widget'	=> '<div id="%1$s" class="fp-widget %2$s">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<h3 class="widget-title">',
			'after_title'	=> '</h3>',

		));
		// Frontpage column2
		register_sidebar(array(
			'name'			=> 'Frontpage Column2',
			'id'			=> 'frontpagecolumn2',
			'description'	=> __('Select only one widget which will appear on your Forntpage column1', 'atp_admin'),
			'before_widget'	=> '<div id="%1$s" class="fp-widget %2$s">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<h3 class="widget-title">',
			'after_title'	=> '</h3>',

		));
		// Frontpage column3
		register_sidebar(array(
			'name'			=> 'Frontpage Column3',
			'id'			=> 'frontpagecolumn3',
			'description'	=> __('Select only one widget which will appear on your Forntpage column1', 'atp_admin'),
			'before_widget'	=> '<div id="%1$s" class="fp-widget %2$s">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<h3 class="widget-title">',
			'after_title'	=> '</h3>',

		));

		/**
		 * Footer Column Widgets
		 *-----------------------------
		 */
		 // footer column1
		register_sidebar(array(
			'name'			=> 'Footer Column1',
			'id'			=> 'footercolumn1',
			'description'	=> __('Select only one widget which will appear on your Footer column1', 'atp_admin'),
			'before_widget'	=> '<div class="footer_column"><div id="%1$s" class="syswidget %2$s">',
			'after_widget'	=> '</div></div>',
			'before_title'	=> '<h3 class="widget-title">',
			'after_title'	=> '</h3>',
		));
		// footer column2
		register_sidebar(array(
				'name'			=> 'Footer Column2',
				'id'			=> 'footercolumn2',
				'description'	=> __('Select only one widget which will appear on your Footer column2', 'atp_admin'),
				'before_widget'	=> '<div class="footer_column"><div id="%1$s" class="syswidget %2$s">',
				'after_widget'	=> '</div></div>',
				'before_title'	=> '<h3 class="widget-title">',
				'after_title'	=> '</h3>',
		));
		// footer column3
		register_sidebar(array(
				'name'			=> 'Footer Column3',
				'id'			=> 'footercolumn3',
				'description'	=> __('Select only one widget which will appear on your Footer column3', 'atp_admin'),
				'before_widget'	=> '<div class="footer_column"><div id="%1$s" class="syswidget %2$s">',
				'after_widget'	=> '</div></div>',
				'before_title'	=> '<h3 class="widget-title">',
				'after_title'	=> '</h3>',
		));
		// footer column4
		register_sidebar(array(
				'name'			=> 'Footer Column4',
				'id'			=> 'footercolumn4',
				'description'	=> __('Select only one widget which will appear on your Footer column4', 'atp_admin'),
				'before_widget'	=> '<div class="footer_column"><div id="%1$s" class="syswidget %2$s">',
				'after_widget'	=> '</div></div>',
				'before_title'	=> '<h3 class="widget-title">',
				'after_title'	=> '</h3>',
		));
		// footer column5
		register_sidebar(array(
				'name'			=> 'Footer Column5',
				'id'			=> 'footercolumn5',
				'description'	=> __('Select only one widget which will appear on your Footer column5', 'atp_admin'),
				'before_widget'	=> '<div class="footer_column"><div id="%1$s" class="syswidget %2$s">',
				'after_widget'	=> '</div></div>',
				'before_title'	=> '<h3 class="widget-title">',
				'after_title'	=> '</h3>',
		));
		// footer column6
		register_sidebar(array(
				'name'			=> 'Footer Column6',
				'id'			=> 'footercolumn6',
				'description'	=> __('Select only one widget which will appear on your Footer column6', 'atp_admin'),
				'before_widget'	=> '<div class="footer_column"><div id="%1$s" class="syswidget %2$s">',
				'after_widget'	=> '</div></div>',
				'before_title'	=> '<h3 class="widget-title">',
				'after_title'	=> '</h3>',
		));
	}

	/**
	 * Custom Sidebar Widget
	 *
	 */
	if ( function_exists('register_sidebar') ) {
		$atp_template_custom_widget = get_option('atp_customsidebar');
		if(is_array($atp_template_custom_widget)) { 
			foreach ($atp_template_custom_widget as $page_name){
				if($page_name != "")
				register_sidebar(array(
					'name'			=> $page_name,
					'id'			=> 'sidebar-'.strtolower(preg_replace('/\s+/', '-', $page_name)),
					'before_widget'	=>'<div id="%1$s" class="clearfix syswidget %2$s">',
					'after_widget'	=>'</div>',
					'before_title'	=>'<h3 class="widget-title">',
					'after_title'	=>'</h3>',

				));
			}
		}
	}

	// Footer Widget Limits
	$footerwidgetcounts=get_option("atp_footerwidgetcount");
	if($footerwidgetcounts){
		if($footerwidgetcounts == '6') { $fclass="one_sixth";}
		if($footerwidgetcounts == '5') { $fclass="one_fifth";}
		if($footerwidgetcounts == '4') { $fclass="one_fourth";}
		if($footerwidgetcounts == '2') { $fclass="half_width";}
		if($footerwidgetcounts == '3') { $fclass="one_third";}
	}
	
	
	// Frontpage Widget Limits
	$atp_frontpagewidgetcount=get_option("atp_frontpagewidgetcount");
	if($atp_frontpagewidgetcount){
		if($atp_frontpagewidgetcount == '1') { $frontclass="full_width";}
		if($atp_frontpagewidgetcount == '2') { $frontclass="half_width";}
		if($atp_frontpagewidgetcount == '3') { $frontclass="one_third";}
	}
	
	/**
	 * Include Custom Widgets
	 */
	require_once(FUNCTIONS_PATH."/custom-widget/contactform.php");
	require_once(FUNCTIONS_PATH."/custom-widget/contactinfo.php");
	require_once(FUNCTIONS_PATH."/custom-widget/flickr.php");
	require_once(FUNCTIONS_PATH."/custom-widget/popularpost.php");
	require_once(FUNCTIONS_PATH."/custom-widget/recentpost.php");
	require_once(FUNCTIONS_PATH."/custom-widget/sub_navigation.php");
	require_once(FUNCTIONS_PATH."/custom-widget/searchform.php");
	require_once(FUNCTIONS_PATH."/custom-widget/twitter.php");
	require_once(FUNCTIONS_PATH."/custom-widget/gmap.php");
	require_once(FUNCTIONS_PATH."/custom-widget/reservation_form.php");
	require_once(FUNCTIONS_PATH."/custom-widget/business_hours.php");
?>