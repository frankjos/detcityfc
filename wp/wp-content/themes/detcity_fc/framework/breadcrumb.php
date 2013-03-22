<?php
function my_breadcrumb() {
	breadcrumbs_plus(array(
		'prefix'	=> '',
		'suffix'	=> '',
		'title'		=> false,
		'home'		=> __( 'Home', 'DetCityFC 2.0' ),
		'sep'		=> '&#47;',
		'front_page'=> false,
		'bold'		=> true,
		'blog'		=> __( 'Blog', 'DetCityFC 2.0' ),
		'echo'		=> true,
		'singular_menus_taxonomy'	=> 'menutype'
	));
}
?>