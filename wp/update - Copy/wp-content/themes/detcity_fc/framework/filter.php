<?php
	/**
	 * Multiple taxonomies
	 */
	function multi_tax_terms($where) {
		global $wp_query;
		global $wpdb;
		if (isset($wp_query->query_vars['term']) && (strpos($wp_query->query_vars['term'], ',') !== false && strpos($where, "AND 0") !== false)) {
			//Get the terms
			$term_arr = explode(",", $wp_query->query_vars['term']);
			foreach ($term_arr as $term_item) {
				$terms[] = get_terms($wp_query->query_vars['taxonomy'], array(
					'slug' => $term_item
				));
			} //$term_arr as $term_item
			
			//Get the id of posts with that term in that taxonomy
			foreach ($terms as $term) {
				$term_ids[] = $term[0]->term_id;
			} //$terms as $term
			
			$post_ids = get_objects_in_term($term_ids, $wp_query->query_vars['taxonomy']);
			
			if (!is_wp_error($post_ids) && count($post_ids)) {
				// Build the new query
				$new_where = " AND $wpdb->posts.ID IN (" . implode(', ', $post_ids) . ") ";
				$where     = str_replace("AND 0", $new_where, $where);
			}else {
			}
		} //isset $wp_query
		return $where;
	}
	add_filter("posts_where", "multi_tax_terms");
?>