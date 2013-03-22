<?php
	/*
	 * Add new taxonomy, NOT hierarchical (like tags)
	 * taxonomy = slider
	 * object type = slide (Name of the object type for the taxonomy object)
	 */
function my_custom_slider() {
	$labels = array(
		'name'				=> _x('Slider', 'Slider','Slider'),  
		'singular_name'		=> _x('Slider', 'post type singular name','Slider'),  
		'add_new'			=> _x('Add New','Add New','Slider'),  
		'add_new_item'		=> __('Add New Slider','Slider'),  
		'edit_item'			=> __('Edit Slider','Slider'),  
		'new_item'			=> __('New Slider','Slider'),  
		'view_item'			=> __('View Slider','Slider'),  
		'search_items'		=> __('Search Slider','Slider'),  
		'not_found'			=> __('No Slider found','Slider'),  
		'not_found_in_trash'=> __('No Slider found in Trash','Slider'),  
		'parent_item_colon'	=> ''  
	);  
	$args = array(
		'labels'			=> $labels,  
		'public'			=> true,  
		'publicly_queryable'=> true,  
		'show_ui'			=> true,  
		'query_var'			=> true,  
		'rewrite'			=> true,  
		'capability_type'	=> 'post',  
		'hierarchical'		=> true,  
		'menu_position'		=> null,
		'menu_icon'			=> get_stylesheet_directory_uri() . '/framework/admin/images/slider-icon.png',  
		'supports'			=> array('title', 'editor', 'excerpt', 'thumbnail', 'comments', 'page-attributes')
	);  

	register_post_type('slider',$args);  
}
add_action('init', 'my_custom_slider');
?>