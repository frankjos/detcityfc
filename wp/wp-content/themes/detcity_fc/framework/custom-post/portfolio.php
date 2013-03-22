<?php
function portfolio_register() {
	$labels = array(
		'name'				=> _x('Portfolio','Portfolio','Portfolio'),
		'singular_name'		=> _x('Portfolio','Portfolio', 'Portfolio'),
		'add_new'			=> _x('Add New Post', 'Portfolio Listing','Portfolio'),
		'add_new_item'		=> __('Add New Post','Portfolio'),
		'edit_item'			=> __('Edit Post','Portfolio'),
		'new_item'			=> __('New Portfolio Post Item','Portfolio'),
		'view_item'			=> __('View Portfolio Item','Portfolio'),
		'search_items'		=> __('Search Portfolio Items','Portfolio'),
		'not_found'			=> __('Nothing found','Portfolio'),
		'not_found_in_trash'=> __('Nothing found in Trash','Portfolio'),
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
		'menu_icon'			=> get_stylesheet_directory_uri() . '/admin/images/slider-icon-mini.png',  		
		'supports'			=> array('title', 'editor', 'excerpt', 'thumbnail', 'comments', 'page-attributes')
	); 
	register_post_type( 'portfolio' , $args );
}
	register_taxonomy("portfolio_type", 'portfolio', array(
	'hierarchical'		=> true,
	'label'				=> 'Portfolio Categories',
	'singular_label'	=> 'Portfolio Categories',
	'show_ui'			=> true,
	'query_var'			=> true,
	'rewrite'			=> false,
	)
);
	
add_action('init', 'portfolio_register');

function my_columns($columns) {
	$columns['portfolio_type'] = __('Category','atp_admin');
    $columns['thumbnail'] =  __('Post Image','atp_admin');

    return $columns;
}

function manage_portfolio_columns($name) {
    global $post;global $wp_query;
    switch ($name) {
	 case 'portfolio_type':
               $terms = get_the_terms($post->ID, 'portfolio_type');

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
        case 'thumbnail':
          
				echo the_post_thumbnail(array(100,100));
				break;
       
    }
}
add_action('manage_posts_custom_column', 'manage_portfolio_columns', 10, 2);
add_filter('manage_edit-portfolio_columns', 'my_columns');
?>