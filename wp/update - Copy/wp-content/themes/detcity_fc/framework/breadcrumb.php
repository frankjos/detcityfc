<?php
function my_breadcrumb() {
	breadcrumbs_plus(array(
		'prefix'	=> '',
		'suffix'	=> '',
		'title'		=> false,
		'home'		=> __( 'Home', 'victoria' ),
		'sep'		=> '&#47;',
		'front_page'=> false,
		'bold'		=> true,
		'blog'		=> __( 'Blog', 'victoria' ),
		'echo'		=> true,
		'singular_menus_taxonomy'	=> 'menutype'
	));
}
?>