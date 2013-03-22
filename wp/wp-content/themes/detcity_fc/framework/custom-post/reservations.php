<?php
	/*
	 * Add new taxonomy, NOT hierarchical (like tags)
	 * taxonomy = reservation
	 * object type = table (Name of the object type for the taxonomy object)
	 */
function reservations_register() {
	$labels = array(
		'name'				=> _x('Reservations','Reservations ','Reservations'),
		'singular_name'		=> _x('Reservations','Reservations ', 'Reservations '),
		'add_new'			=> _x('Add New', 'Reservations ','Reservations '),
		'add_new_item'		=> __('Add New','Reservations'),
		'edit_item'			=> __('Edit Reservations','Reservations'),
		'new_item'			=> __('New Reservations ','Reservations'),
		'view_item'			=> __('View Reservations ','Reservations'),
		'search_items'		=> __('Search Reservations','Reservations'),
		'not_found'			=> __('Nothing found','Reservations '),
		'not_found_in_trash'=> __('Nothing found in Trash','Reservations '),
		'parent_item_colon'	=> ''
	);
 
	$args = array(
		'labels'			=> $labels,
		'public'			=> true,
		'exclude_from_search'=> false,
		'show_ui'			=> true,
		'capability_type'	=> 'post',
		'hierarchical'		=> false,
		'rewrite'			=> array( 'with_front' => false ),
		'query_var'			=> false,	
		'menu_icon'			=> get_stylesheet_directory_uri() . '/framework/admin/images/reservation-icon.png',  		
		'supports'			=> array('title', 'page-attributes')
		); 
	register_post_type( 'reservations' , $args );
}

//registering tables taxonomy(category) attched to reservations post type

register_taxonomy("table", 'reservations', array(
	'hierarchical'		=> true,
	'label'				=> 'Tables',
	'singular_label'	=> 'Table Name',
	'show_ui'			=> true,
	'query_var'			=> true,
	'rewrite'			=> false,
	'has_archive' => true,
	)
);
	
add_action('init', 'reservations_register');

function reservations_columns($columns) {
	$columns['table'] = __('Table','atp_admin');
	$columns['members'] = __('Members','atp_admin');
    $columns['Reserved On'] =  __('Reserved On','atp_admin');
 	$columns['status'] =  __('Status','atp_admin');

    return $columns;
}

	function manage_reservations_columns($name) {
		global $post, $wp_query;
		switch ($name) {
			case 'table':
				$terms = get_the_terms($post->ID, 'table');

				//If the terms array contains items... (dupe of core)
				if ( !empty($terms) ) {
					//Loop through terms
					foreach ( $terms as $term ){
						//Add tax name & link to an array
						$post_terms[] = esc_html(sanitize_term_field('name', $term->name, $term->term_id, '', 'edit'));
					}
					//Spit out the array as CSV
					echo implode( ', ', $post_terms );
				} else {
					//Text to show if no terms attached for post & tax
					echo '<em>No terms</em>';
				}
				break;
			case 'members':  
				echo get_post_meta(get_the_ID(),'numberofpeople',TRUE);
				break;
			case 'Reserved On':
				echo 'Reserved On '.get_post_meta(get_the_ID(),'dateselect',TRUE).' at ';
				echo  get_post_meta(get_the_ID(),'reservationtime',TRUE);
				break;
			case 'status':     
				$status=get_post_meta(get_the_ID(),'status',TRUE);
				switch($status){
					case 'unconfirmed':
						echo '<p class="unconfirmed">'.$status.'</p>';
						break;
					case 'confirmed':
						echo '<p class="confirmed">'.$status.'</p>';
						break;
					case 'cancelled':
						echo '<p class="cancelled">'.$status.'</p>';
						break;
				}
				break;
		}
	}

add_action('manage_posts_custom_column', 'manage_reservations_columns');
add_filter('manage_edit-reservations_columns', 'reservations_columns');
?>