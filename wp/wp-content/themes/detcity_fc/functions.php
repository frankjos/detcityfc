<?php



function new_excerpt_more($more) {
       global $post;
	return '<p><a href="'. get_permalink($post->ID) . '"> Read More...</a></p>';
}
add_filter('excerpt_more', 'new_excerpt_more');
function custom_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );




	/**
	 * Framework General Variables and directory paths
	 */
	require('update-notifier.php'); // Theme updates notification
	define('FRAMEWORK', '2.0'); //  Framework Version
	define('THEMENAME', 'DetCityFC 2.0'); //  Theme name

	/**
	 * Please refrain from editing this file 
	 * Required Variables Globally in the theme
	 */
	$atp_breadcrumbs = get_option('atp_breadcrumbs');
	$atp_singlenavigation = get_option('atp_singlenavigation');
	$relatedposts = get_option('atp_relatedposts');
	$atp_singlefeaturedimg = get_option('atp_singlefeaturedimg');
	$aboutauthor = get_option('atp_aboutauthor');
	$atp_teaser = get_option('atp_teaser');	
	$atp_timthumb = get_option('atp_timthumb');
	$readmoretxt = get_option('atp_readmore_text') ? get_option('atp_readmore_text'):'Read More';
	$reservationleftsidetext = get_option('atp_reservationleftsidetext') ? get_option('atp_reservationleftsidetext'):'Select the date for your reservation:';
	$reservationinformationtext = get_option('atp_reservationinformationtext') ? get_option('atp_reservationinformationtext'):'Reservation Information:';
	$priceperserving= get_option('atp_priceperserving') ? get_option('atp_priceperserving'):'Price Per Serving:'; 
	
	$comments = get_option('atp_commentstemplate');
	$themename = THEMENAME;
	
	// Post Excerpt Character Custom Length
	function excerpt($num) {
		$link = get_permalink();
		$ending = get_option('wl_excerpt_ending');
		$limit = $num+1;
		$excerpt = explode(' ', get_the_excerpt(), $limit);
		array_pop($excerpt);
		$excerpt = implode(" ",$excerpt).$ending;
		echo $excerpt;
	}

	/**
	 * Excludes categories for custom post type tags archive
	 */
	add_filter('pre_get_posts', 'query_post_type');
	function query_post_type($query) {
		if ( is_tag() && empty( $query->query_vars['suppress_filters'] ) ) {
			$post_type = get_query_var('post_type');
			if($post_type)
			$post_type = $post_type;
		else
			$post_type = array('post','menus'); 
			$query->set('post_type',$post_type);
			return $query;
		}
	}

	/**
	 * Set the file path based on whether the Options Framework is in a parent theme or child theme
	 * Directory Structure
	 */
	define('FUNCTIONS_PATH', STYLESHEETPATH . '/framework/');
	define('CUSTOM_META', FUNCTIONS_PATH . '/custom-meta/');
	define('CUSTOM_PLUGINS', FUNCTIONS_PATH . 'custom-plugins/');
	define('CUSTOM_POST', FUNCTIONS_PATH . 'custom-post/');
	define('THEME_URI', get_template_directory_uri());
	define('THEME_JS', THEME_URI . '/js');
	define('THEME_CSS', THEME_URI . '/css');
	define('SHORTCODES', FUNCTIONS_PATH . 'shortcode/');
	define('ATP_FILEPATH', STYLESHEETPATH);
	define('ATP_DIRECTORY', get_stylesheet_directory_uri());

	$functions_path = ATP_FILEPATH . '/framework/admin/'; // Theme Admin Folder folder path
	$icon = get_template_directory_uri() . '/framework/admin/images/at_icon.jpg'; // Icon for theme admin menu

	/**
	 * Admin Interface - theme options/ advance options / general options
	 * These files build out the options interface.  
	 * Please refraine from editing the below section.
	 */

		require_once(ATP_FILEPATH . '/framework/admin/admin-interface.php'); // Admin Interfaces (options,framework, seo)
		require_once(ATP_FILEPATH . '/framework/admin/theme-options.php');
		require_once(ATP_FILEPATH . '/framework/admin/admin-functions.php');
	
		if(isset($_GET['page']) == 'advance') {
			require_once(ATP_FILEPATH . '/framework/admin/advance-options.php');
		}

	/**
	 * Custom Post Type Files
	 * Post Types : slider,menus,reservation
	 * #Slider : required for Frontpage featured item presentation
	 * #Menus : custom food items and menutypes management
	 * #Reservation: Custom tables and booking reservations
	 */
	require_once(CUSTOM_POST . 'slider.php'); 
	require_once(CUSTOM_POST . 'menus.php'); 
	require_once(CUSTOM_POST . 'reservations.php'); 


	/**
	 * These files build out the theme specific options and associated functions.
	 * Options panel settings and custom settings
	 * header.php 			- Theme header functions
	 * common.php 			- common functions
	 * image_resize.php 	- image resize functions
	 * filter.php 			- Filter for multiple taxonomy
	 * twitter.php 			- twitter functions
	 * pagination.php 		- pagination functions
 	 * custom_comments.php 	- custom threaded comments
	 * shortcode.php 		- shortcodes files determination
 	 * custom_widgets.php 	- custom widgets
	 * breadcrumb.php 		- breadcrumb functions
 	 * breadcumb-plus.php 	- breadcrumb Plugin file
	 */
	require_once(FUNCTIONS_PATH . 'function_header.php');
	require_once(FUNCTIONS_PATH . 'common.php');
	require_once(FUNCTIONS_PATH . 'image_resize.php');
	require_once(FUNCTIONS_PATH . 'filter.php');
	require_once(FUNCTIONS_PATH . '/includes/twitter.php');
	require_once(FUNCTIONS_PATH . '/includes/pagination.php');
	require_once(FUNCTIONS_PATH . 'custom_comment.php');
	require_once(FUNCTIONS_PATH . 'shortcode.php'); 
	require_once(FUNCTIONS_PATH . 'custom_widget.php'); 
	require_once(FUNCTIONS_PATH . 'breadcrumb.php'); 
	require_once(CUSTOM_PLUGINS . 'breadcrumbs-plus/breadcrumbs-plus.php'); 


	/**
	 * Custom Meta Boxes
	 */
	require_once(CUSTOM_META . 'shortcode-meta.php'); //  Shortcodes 
	require_once(CUSTOM_META . 'page-meta.php'); //  Pages 
	require_once(CUSTOM_META . 'post-meta.php'); //  Posts 
	require_once(CUSTOM_META . 'slider-meta.php'); //  Slider 
	require_once(CUSTOM_META . 'fields.class.php'); //  All Field Class & Metabox

	/**
	 * enqueues the admin javascript files for admin user interface
	 * @file - script.js
	 * @file location - /framework/admin/js/
	 */
	add_action('admin_init', 'theme_admin_add_script');
	function theme_admin_add_script() {
		wp_enqueue_script('theme-script', ATP_DIRECTORY . '/framework/admin/js/script.js');
	}

	/**
	 * enqueues the metacss.css for custom meta boxes
	 * @file - metacss.css
	 * @file location - framework/admin/css/
	 */
	add_action('init', 'theme_enqueue_metacss');
	function theme_enqueue_metacss()
	{
	if(is_admin()){
		wp_enqueue_style('meta-css', ATP_DIRECTORY . '/framework/admin/css/metacss.css');
	}
	}

	/**
	 * Allows shortcodes in sidebar widgets / Text widget
	 * Content with shortcodes replaced by the output from the shortcode's handler(s).  
	 */
	add_filter('widget_text', 'do_shortcode');

	/**
	 * Loads the theme's translated strings. 
	 * SET THEME LANGUAGES DIRECTORY
	 * Theme translations can be filed in the themename/languages/ directory
	 * Wordpress translations can be filed in the wp-content/languages/ directory
	 */
	if (function_exists('load_theme_textdomain')) {
		load_theme_textdomain('victoria_front', get_template_directory().'/languages');
	}

	/**
	 * code that executes when theme is being activated
	 */
	if ( is_admin() && isset($_GET['activated'] ) && $pagenow == 'themes.php' && get_option('atp_default_template_option_values','defaultoptionsnotexists') =='defaultoptionsnotexists'){
	$default_option_values = 'YToxNzM6e3M6ODoiYXRwX2xvZ28iO3M6NTg6Imh0dHA6Ly93d3cuYWl2YWh0aGVtZXMuY29tL3ZpY3RvcmlhL2ZpbGVzLzIwMTEvMTIvTG9nby5wbmciO3M6MTg6ImF0cF9jdXN0b21fZmF2aWNvbiI7czowOiIiO3M6MTA6ImF0cF90ZWFzZXIiO3M6NzoidHdpdHRlciI7czoxODoiYXRwX3RlYXNlcl90d2l0dGVyIjtzOjEzOiJzeXN0ZW0zMnN0b3JlIjtzOjE3OiJhdHBfdGVhc2VyX2N1c3RvbSI7czowOiIiO3M6MTU6ImF0cF9icmVhZGNydW1icyI7czoyOiJvbiI7czoxMjoiYXRwX3RpbXRodW1iIjtzOjI6Im9uIjtzOjE2OiJhdHBfY29udGFjdGVtYWlsIjtzOjA6IiI7czoxNDoiYXRwX2dtYXBhcGlrZXkiO3M6ODY6IkFCUUlBQUFBSzY5aHliSHctU0tOSFV4V2l3U1JMaFM3eFpSQVNMMk5zMmpmLTBOejAwRHZFZkRSQlJRNlYwdVk5UWFucURycU5wU3ZwMGIyOWZXSnZRIjtzOjEyOiJhdHBfZXh0cmFjc3MiO3M6MDoiIjtzOjIwOiJhdHBfdGVhc2VyX2Zyb250cGFnZSI7czoyOiJvbiI7czoyNDoiYXRwX2Zyb250cGFnZXdpZGdldGNvdW50IjtzOjE6IjMiO3M6MTI6ImF0cF9ob21lcGFnZSI7czoxOiIyIjtzOjE2OiJhdHBfbGF5b3V0b3B0aW9uIjtzOjU6ImJveGVkIjtzOjI0OiJhdHBfYm9keXByb3BlcnRpZXNfaW1hZ2UiO3M6MDoiIjtzOjI0OiJhdHBfYm9keXByb3BlcnRpZXNfY29sb3IiO3M6MDoiIjtzOjI0OiJhdHBfYm9keXByb3BlcnRpZXNfc3R5bGUiO3M6NjoicmVwZWF0IjtzOjI3OiJhdHBfYm9keXByb3BlcnRpZXNfcG9zaXRpb24iO3M6MTA6ImNlbnRlciB0b3AiO3M6Mjk6ImF0cF9ib2R5cHJvcGVydGllc19hdHRhY2htZW50IjtzOjY6InNjcm9sbCI7czoxODoiYXRwX2hlYWRlcmJnX2ltYWdlIjtzOjA6IiI7czoxODoiYXRwX2hlYWRlcmJnX2NvbG9yIjtzOjA6IiI7czoxODoiYXRwX2hlYWRlcmJnX3N0eWxlIjtzOjk6Im5vLXJlcGVhdCI7czoyMToiYXRwX2hlYWRlcmJnX3Bvc2l0aW9uIjtzOjEwOiJjZW50ZXIgdG9wIjtzOjIzOiJhdHBfaGVhZGVyYmdfYXR0YWNobWVudCI7czo2OiJzY3JvbGwiO3M6Mjk6ImF0cF9zdWJoZWFkZXJwcm9wZXJ0aWVzX2ltYWdlIjtzOjA6IiI7czoyOToiYXRwX3N1YmhlYWRlcnByb3BlcnRpZXNfY29sb3IiO3M6MDoiIjtzOjI5OiJhdHBfc3ViaGVhZGVycHJvcGVydGllc19zdHlsZSI7czo5OiJuby1yZXBlYXQiO3M6MzI6ImF0cF9zdWJoZWFkZXJwcm9wZXJ0aWVzX3Bvc2l0aW9uIjtzOjEwOiJjZW50ZXIgdG9wIjtzOjM0OiJhdHBfc3ViaGVhZGVycHJvcGVydGllc19hdHRhY2htZW50IjtzOjY6InNjcm9sbCI7czoxNzoiYXRwX2xvZ290ZXh0Y29sb3IiO3M6MDoiIjtzOjE3OiJhdHBfZnJvbnR0ZWFzZXJiZyI7czo3OiIjRERGMUY1IjtzOjEwOiJhdHBfd3JhcGJnIjtzOjA6IiI7czoxNToiYXRwX3RhYnNiZ2NvbG9yIjtzOjA6IiI7czo4OiJhdHBfbGluayI7czowOiIiO3M6MTM6ImF0cF9saW5raG92ZXIiO3M6MDoiIjtzOjE3OiJhdHBfc3ViaGVhZGVybGluayI7czowOiIiO3M6MjI6ImF0cF9zdWJoZWFkZXJsaW5raG92ZXIiO3M6MDoiIjtzOjEwOiJhdHBfbWVudWJnIjtzOjA6IiI7czoyMToiYXRwX21haW5tZW51Zm9udF9zaXplIjtzOjQ6IjEycHgiO3M6Mjc6ImF0cF9tYWlubWVudWZvbnRfbGluZWhlaWdodCI7czo0OiIxM3B4IjtzOjIxOiJhdHBfbWFpbm1lbnVmb250X2ZhY2UiO3M6NToiQXJpYWwiO3M6MjI6ImF0cF9tYWlubWVudWZvbnRfc3R5bGUiO3M6Njoibm9ybWFsIjtzOjIyOiJhdHBfbWFpbm1lbnVmb250X2NvbG9yIjtzOjA6IiI7czoxNDoiYXRwX25hdmhvdmVyYmciO3M6MDoiIjtzOjE2OiJhdHBfbmF2aG92ZXJsaW5rIjtzOjA6IiI7czoxNToiYXRwX3N1Ym5hdmhvdmVyIjtzOjA6IiI7czoxODoiYXRwX2JyZWFkY3J1bWJ0ZXh0IjtzOjA6IiI7czoxODoiYXRwX2JyZWFkY3J1bWJsaW5rIjtzOjA6IiI7czoyMzoiYXRwX2JyZWFkY3J1bWJsaW5raG92ZXIiO3M6MDoiIjtzOjE4OiJhdHBfc2lkZWJhcmJnY29sb3IiO3M6MDoiIjtzOjE3OiJhdHBfZm9vdGVyYmdjb2xvciI7czowOiIiO3M6MTk6ImF0cF9mb290ZXJ0ZXh0Y29sb3IiO3M6MDoiIjtzOjIyOiJhdHBfZm9vdGVyaGVhZGluZ2NvbG9yIjtzOjA6IiI7czoxOToiYXRwX2Zvb3Rlcmxpbmtjb2xvciI7czowOiIiO3M6MjQ6ImF0cF9mb290ZXJsaW5raG92ZXJjb2xvciI7czowOiIiO3M6MTU6ImF0cF9jb3B5Ymdjb2xvciI7czowOiIiO3M6MTc6ImF0cF9jb3B5bGlua2NvbG9yIjtzOjA6IiI7czoxNDoiYXRwX2N1c3RvbXR5cG8iO3M6Mjoib24iO3M6MTQ6ImF0cF9ib2R5cF9zaXplIjtzOjQ6IjEycHgiO3M6MjA6ImF0cF9ib2R5cF9saW5laGVpZ2h0IjtzOjQ6IjE4cHgiO3M6MTQ6ImF0cF9ib2R5cF9mYWNlIjtzOjU6IkFyaWFsIjtzOjE1OiJhdHBfYm9keXBfc3R5bGUiO3M6Njoibm9ybWFsIjtzOjE1OiJhdHBfYm9keXBfY29sb3IiO3M6MDoiIjtzOjExOiJhdHBfaDFfc2l6ZSI7czo0OiIzMHB4IjtzOjE3OiJhdHBfaDFfbGluZWhlaWdodCI7czo0OiIzMnB4IjtzOjExOiJhdHBfaDFfZmFjZSI7czoxMToiRHJvaWQgU2VyaWYiO3M6MTI6ImF0cF9oMV9zdHlsZSI7czo2OiJub3JtYWwiO3M6MTI6ImF0cF9oMV9jb2xvciI7czowOiIiO3M6MTE6ImF0cF9oMl9zaXplIjtzOjQ6IjI0cHgiO3M6MTc6ImF0cF9oMl9saW5laGVpZ2h0IjtzOjQ6IjI3cHgiO3M6MTE6ImF0cF9oMl9mYWNlIjtzOjExOiJEcm9pZCBTZXJpZiI7czoxMjoiYXRwX2gyX3N0eWxlIjtzOjY6Im5vcm1hbCI7czoxMjoiYXRwX2gyX2NvbG9yIjtzOjA6IiI7czoxMToiYXRwX2gzX3NpemUiO3M6NDoiMjBweCI7czoxNzoiYXRwX2gzX2xpbmVoZWlnaHQiO3M6NDoiMjNweCI7czoxMToiYXRwX2gzX2ZhY2UiO3M6MTE6IkRyb2lkIFNlcmlmIjtzOjEyOiJhdHBfaDNfc3R5bGUiO3M6Njoibm9ybWFsIjtzOjEyOiJhdHBfaDNfY29sb3IiO3M6MDoiIjtzOjExOiJhdHBfaDRfc2l6ZSI7czo0OiIxOHB4IjtzOjE3OiJhdHBfaDRfbGluZWhlaWdodCI7czo0OiIyMHB4IjtzOjExOiJhdHBfaDRfZmFjZSI7czo1OiJBcmlhbCI7czoxMjoiYXRwX2g0X3N0eWxlIjtzOjY6Im5vcm1hbCI7czoxMjoiYXRwX2g0X2NvbG9yIjtzOjA6IiI7czoxMToiYXRwX2g1X3NpemUiO3M6NDoiMTRweCI7czoxNzoiYXRwX2g1X2xpbmVoZWlnaHQiO3M6NDoiMTdweCI7czoxMToiYXRwX2g1X2ZhY2UiO3M6NToiQXJpYWwiO3M6MTI6ImF0cF9oNV9zdHlsZSI7czo2OiJub3JtYWwiO3M6MTI6ImF0cF9oNV9jb2xvciI7czowOiIiO3M6MTE6ImF0cF9oNl9zaXplIjtzOjQ6IjEycHgiO3M6MTc6ImF0cF9oNl9saW5laGVpZ2h0IjtzOjQ6IjE0cHgiO3M6MTE6ImF0cF9oNl9mYWNlIjtzOjU6IkFyaWFsIjtzOjEyOiJhdHBfaDZfc3R5bGUiO3M6MTE6ImJvbGQgaXRhbGljIjtzOjEyOiJhdHBfaDZfY29sb3IiO3M6MDoiIjtzOjE5OiJhdHBfZW50cnl0aXRsZV9zaXplIjtzOjQ6IjE4cHgiO3M6MjU6ImF0cF9lbnRyeXRpdGxlX2xpbmVoZWlnaHQiO3M6NDoiMjRweCI7czoxOToiYXRwX2VudHJ5dGl0bGVfZmFjZSI7czoxMToiRHJvaWQgU2VyaWYiO3M6MjA6ImF0cF9lbnRyeXRpdGxlX3N0eWxlIjtzOjY6Im5vcm1hbCI7czoyMDoiYXRwX2VudHJ5dGl0bGVfY29sb3IiO3M6MDoiIjtzOjIzOiJhdHBfZW50cnl0aXRsZWxpbmtob3ZlciI7czowOiIiO3M6MjE6ImF0cF9zaWRlYmFydGl0bGVfc2l6ZSI7czo0OiIxNnB4IjtzOjI3OiJhdHBfc2lkZWJhcnRpdGxlX2xpbmVoZWlnaHQiO3M6NDoiMTZweCI7czoyMToiYXRwX3NpZGViYXJ0aXRsZV9mYWNlIjtzOjU6IkFyaWFsIjtzOjIyOiJhdHBfc2lkZWJhcnRpdGxlX3N0eWxlIjtzOjY6Im5vcm1hbCI7czoyMjoiYXRwX3NpZGViYXJ0aXRsZV9jb2xvciI7czowOiIiO3M6MTk6ImF0cF9jb3B5cmlnaHRzX3NpemUiO3M6NDoiMTFweCI7czoyNToiYXRwX2NvcHlyaWdodHNfbGluZWhlaWdodCI7czo0OiIyMHB4IjtzOjE5OiJhdHBfY29weXJpZ2h0c19mYWNlIjtzOjU6IkFyaWFsIjtzOjIwOiJhdHBfY29weXJpZ2h0c19zdHlsZSI7czo2OiJub3JtYWwiO3M6MjA6ImF0cF9jb3B5cmlnaHRzX2NvbG9yIjtzOjA6IiI7czoxNjoiYXRwX3NsaWRlcnZpc2JsZSI7czoyOiJvbiI7czoyMjoiYXRwX3NsaWRlcmJncHJvcF9pbWFnZSI7czowOiIiO3M6MjI6ImF0cF9zbGlkZXJiZ3Byb3BfY29sb3IiO3M6MDoiIjtzOjIyOiJhdHBfc2xpZGVyYmdwcm9wX3N0eWxlIjtzOjk6Im5vLXJlcGVhdCI7czoyNToiYXRwX3NsaWRlcmJncHJvcF9wb3NpdGlvbiI7czoxMDoiY2VudGVyIHRvcCI7czoyNzoiYXRwX3NsaWRlcmJncHJvcF9hdHRhY2htZW50IjtzOjY6InNjcm9sbCI7czoxMDoiYXRwX3NsaWRlciI7czoxMToiY3ljbGVzbGlkZXIiO3M6MTk6ImF0cF9jeWNsZXNsaWRlbGltaXQiO3M6MToiMyI7czoxMjoiYXRwX3ZpZGVvX2lkIjtzOjEzOToiPGlmcmFtZSB3aWR0aD0iMTAyMCIgaGVpZ2h0PSI0MDAiIHNyYz0iaHR0cDovL3d3dy55b3V0dWJlLmNvbS9lbWJlZC9HZ1I2ZHl6a0tIST93bW9kZT10cmFuc3BhcmVudCIgZnJhbWVib3JkZXI9IjAiIHdtb2RlPSJPcGFxdWUiPjwvaWZyYW1lPiI7czoyMzoiYXRwX3N0YXRpY19pbWFnZV91cGxvYWQiO3M6Njk6Imh0dHA6Ly93d3cuYWl2YWh0aGVtZXMuY29tL3ZpY3RvcmlhL2ZpbGVzLzIwMTEvMTIvdmljdG9yaWFfc2xpZGUxLnBuZyI7czoxNToiYXRwX3N0YXRpY19saW5rIjtzOjE6IiMiO3M6MTU6ImF0cF9hYm91dGF1dGhvciI7czoyOiJvbiI7czoxNjoiYXRwX3JlbGF0ZWRwb3N0cyI7czoyOiJvbiI7czoyMDoiYXRwX2NvbW1lbnRzdGVtcGxhdGUiO3M6NToicG9zdHMiO3M6MjA6ImF0cF9zaW5nbGVuYXZpZ2F0aW9uIjtzOjI6Im9uIjtzOjIxOiJhdHBfc2luZ2xlZmVhdHVyZWRpbWciO3M6Mjoib24iO3M6MTM6ImF0cF9ibG9nYWNhdHMiO2E6MTp7aTowO3M6MToiMSI7fXM6MTc6ImF0cF9wc2RfaW1naGVpZ2h0IjtzOjA6IiI7czoxNzoiYXRwX3BzMV9pbWdoZWlnaHQiO3M6MDoiIjtzOjE3OiJhdHBfcHMyX2ltZ2hlaWdodCI7czowOiIiO3M6MTc6ImF0cF9wczNfaW1naGVpZ2h0IjtzOjA6IiI7czoxNzoiYXRwX2N1c3RvbXNpZGViYXIiO2E6MTp7aTowO3M6MTA6ImN1c3RvbWhvbWUiO31zOjE3OiJhdHBfdGVhc2VyX2Zvb3RlciI7czoyOiJvbiI7czoyMjoiYXRwX3RlYXNlcl9mb290ZXJfdGV4dCI7czoxMDg6IjxoMyBhbGlnbj0iY2VudGVyIj5Gb290ZXIgVGVhc2VyIEFyZWEgOiBDdXN0b20gSFRNTCBhbmQgVGV4dCB0aGF0IHdpbGwgYXBwZWFyIGFib3ZlIHRoZSBzaWRlYmFyIGZvb3Rlci48L2gzPiI7czoxODoiYXRwX2Zvb3Rlcl9zaWRlYmFyIjtzOjI6Im9uIjtzOjIxOiJhdHBfZm9vdGVyd2lkZ2V0Y291bnQiO3M6MToiNCI7czoxOToiYXRwX2dvb2dsZWFuYWx5dGljcyI7czowOiIiO3M6MTM6ImF0cF9jb3B5cmlnaHQiO3M6MTQzOiLCqSAyMDEwLTIwMTEgVmljdG9yaWEgUmVzdGF1cmFudCBXb3JkcHJlc3MgVGhlbWUgPGJyPkFsbCBSaWdodHMgUmVzZXJ2ZWQgOiA8YSBocmVmPSIjIj5UZXJtcyAmIENvbmRpdGlvbnM8L2E+IHwgPGEgaHJlZj0iIyI+UHJpdmFjeSBQb2xpY3k8L2E+ICI7czoyMDoic3lzX3NvY2lhbF9maWxlX2ljb24iO3M6MTQ6InlvdXR1YmVfMTYucG5nIjtzOjE5OiJhdHBfc29jaWFsX2Jvb2ttYXJrIjtzOjM5MzoiT3JrdXQjfGFkZHRoaXNfMTYucG5nI3wjIzt0d2l0dGVyI3xhaW1fMTYucG5nI3wjIztmYWNlYm9vayN8Ym9va21hcmtfMTYucG5nI3wjIzt0aXRsZSN8ZGVzaWduYnVtcF8xNi5wbmcjfCMjO3RpdGxlI3xkaWdnLnBuZyN8IyM7dGl0bGUjfGZhY2Vib29rXzE2LnBuZyN8IyM7dGl0bGUjfGZsaWNrcl8xNi5wbmcjfCMjO3RpdGxlI3xnb29nbGUtYnV6el8xNi5wbmcjfCMjO3RpdGxlI3xteXNwYWNlXzE2LnBuZyN8IyM7dGl0bGUjfHJlZGRpdF8xNi5wbmcjfCMjO3RpdGxlI3xyc3NfMTYucG5nI3wjIzt0aXRsZSN8c3R1bWJsZXVwb25fMTYucG5nI3wjIzt0aXRsZSN8dGVjaG5vcmF0aV8xNi5wbmcjfCMjO3RpdGxlI3x0d2l0dGVyXzE2LnBuZyN8IyM7dGl0bGUjfHlvdXR1YmVfMTYucG5nI3wjIjtzOjEzOiJhdHBfc3RpY2t5YmFyIjtzOjI6Im9uIjtzOjE3OiJhdHBfc3RpY2t5Y29udGVudCI7czoyNzoiU3RpY2t5IEJhciBOb3RlcyBnb2VzIGhlcmUhIjtzOjE4OiJhdHBfc3RpY2t5YmFyY29sb3IiO3M6MDoiIjtzOjk6ImF0cF9jdWZvbiI7czo0OiJsdW5hIjtzOjE3OiJhdHBfcmVhZG1vcmVfdGV4dCI7czoxMzoiUmVhZCBtb3JlIOKGkiI7czoxMjoiYXRwX3Bvc3RlZGluIjtzOjI6IkluIjtzOjE4OiJhdHBfdGV4dF9zZXBhcmF0b3IiO3M6MDoiIjtzOjk6ImF0cF9ieXR4dCI7czoyOiJCeSI7czoxNToiYXRwX2Vycm9yNDA0dHh0IjtzOjMyOiJPb3BzISBCcm93c2UgdGhyb3VnaCB0aGUgc2l0ZW1hcCI7czoxNzoiYXRwX3NlYXJjaGZvcm10eHQiO3M6MDoiIjtzOjE1OiJhdHBfYm9va2luZ3BhZ2UiO3M6MjoiMTUiO3M6MTQ6ImF0cF90aW1lZm9ybWF0IjtzOjI6IjI0IjtzOjIyOiJhdHBfcmVzZXJ2YXRpb25mb3JtdHh0IjtzOjE4OiJNYWtlIGEgUmVzZXJ2YXRpb24iO3M6MTg6ImF0cF9zdW5kYXlfb3BlbmluZyI7czo1OiIwNjowMCI7czoxODoiYXRwX3N1bmRheV9jbG9zaW5nIjtzOjU6IjA4OjAwIjtzOjE2OiJhdHBfc3VuZGF5X2Nsb3NlIjtzOjI6Im9uIjtzOjE4OiJhdHBfbW9uZGF5X29wZW5pbmciO3M6NToiMDg6MDAiO3M6MTg6ImF0cF9tb25kYXlfY2xvc2luZyI7czo1OiIyMzowMCI7czoxOToiYXRwX3R1ZXNkYXlfb3BlbmluZyI7czo1OiIxMDowMCI7czoxOToiYXRwX3R1ZXNkYXlfY2xvc2luZyI7czo1OiIyMzowMCI7czoyMToiYXRwX3dlZG5lc2RheV9vcGVuaW5nIjtzOjU6IjExOjAwIjtzOjIxOiJhdHBfd2VkbmVzZGF5X2Nsb3NpbmciO3M6NToiMjI6MDAiO3M6MjA6ImF0cF90aHVyc2RheV9vcGVuaW5nIjtzOjU6IjExOjAwIjtzOjIwOiJhdHBfdGh1cnNkYXlfY2xvc2luZyI7czo1OiIyMjowMCI7czoxODoiYXRwX2ZyaWRheV9vcGVuaW5nIjtzOjU6IjEwOjAwIjtzOjE4OiJhdHBfZnJpZGF5X2Nsb3NpbmciO3M6NToiMjI6MDAiO3M6MjA6ImF0cF9zYXR1cmRheV9vcGVuaW5nIjtzOjU6IjAxOjAwIjtzOjIwOiJhdHBfc2F0dXJkYXlfY2xvc2luZyI7czo1OiIyMzowMCI7czoyNDoiYXRwX2Jvb2tpbmdfdGhhbmt5b3VfbXNnIjtzOjg3OiJUaGFuayB5b3UhIFlvdXIgUmVzZXJ2YXRpb24gaGFzIGJvb2tlZCBhbmQgeW91IHdpbGwgYmUgY29udGFjdGVkIHNvb24gZm9yIGNvbmZpcm1hdGlvbi4iO3M6MTg6ImF0cF9jb25maXJtc3ViamVjdCI7czo1MToiW3Jlc3RhdXJhbnRfbmFtZV0gOiBCb29raW5nIFJlcXVlc3QgSUQgW2Jvb2tpbmdfaWRdIjtzOjExOiJhdHBfY29uZmlybSI7czoyNzQ6IkRlYXIgW2NvbnRhY3RfbmFtZV0NClRoYW5rIHlvdSBmb3IgeW91ciByZXNlcnZhdGlvbiBhdCBbcmVzdGF1cmFudF9uYW1lXSBmb3IgW251bWJlcl9vZl9wZW9wbGVdIHBlb3BsZSBhdCBbcmVzZXJ2YXRpb25fdGltZV0gb24gW3Jlc2VydmF0aW9uX2RhdGVdLiANCg0KWW91ciBjb25maXJtYXRpb24gZm9yIHJlc2VydmF0aW9uIHdpbGwgYmUgZG9uZSBvbiBwaG9uZSB2aWEgb3VyIHN0YWZmIHNvb24uDQoNClNpbmNlcmVseSwNClRoZSBTdGFmZiBhdCBbcmVzdGF1cmFudF9uYW1lXS4iO3M6MTc6ImF0cF9zdGF0dXNzdWJqZWN0IjtzOjU4OiJbcmVzdGF1cmFudF9uYW1lXSA6IEJvb2tpbmcgSUQgW2Jvb2tpbmdfaWRdIFN0YXR1cyBDaGFuZ2VkIjtzOjEwOiJhdHBfc3RhdHVzIjtzOjMxNzoiRGVhciBbY29udGFjdF9uYW1lXSwgDQoNClRoaXMgaXMgYSBjb3VydGVzeSBlLW1haWwgdG8gaW5mb3JtIHlvdSB0aGF0IHRoZSBzdGF0dXMgb2YgeW91ciByZXNlcnZhdGlvbiBhdCBbcmVzdGF1cmFudF9uYW1lXSBmb3IgW251bWJlcl9vZl9wZW9wbGVdIHBlb3BsZSBhdCBbcmVzZXJ2YXRpb25fdGltZV0gb24gW3Jlc2VydmF0aW9uX2RhdGVdIGhhcyBiZWVuIHVwZGF0ZWQuDQoNClRoZSBuZXcgcmVzZXJ2YXRpb24gc3RhdHVzIGlzICJbcmVzZXJ2YXRpb25fc3RhdHVzXSIuDQoNClNpbmNlcmVseSwNClRoZSBTdGFmZiBhdCBbcmVzdGF1cmFudF9uYW1lXS4iO3M6MjY6ImF0cF90ZW1wbGF0ZV9vcHRpb25fdmFsdWVzIjtzOjA6IiI7fQ==';

	//add default values for the theme options
	add_option( 'atp_default_template_option_values', $default_option_values, '', 'yes' );
	atp_options();
	update_option_values($options,unserialize(base64_decode($default_option_values)));   
	}

?>