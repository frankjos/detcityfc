<?php 
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 */
get_header(); 


	// Get Slider based on the option selected in theme options panel
	if(get_option("atp_slidervisble") == "on") {
		$chooseslider=get_option('atp_slider');
		switch ($chooseslider):
			case 'carouselslider':
				get_template_part('slider/carousel','slider');
				break;
			case 'static_image':
				get_template_part( 'slider/static', 'slider' );   	
				break;
			case 'cycleslider':
				get_template_part( 'slider/cycle', 'slider' );   	
				break;
			case 'videoslider':
				get_template_part( 'slider/video', 'slider' );   	
				break;
		endswitch;
	}

	/* Frontpage Teaser 
	 * Displays the teaser widget only if option is set on in theme options panel
	 * @homepage_teaser = Widget
	 * Widget Name = Homepage Teaser Text
	 */
	if(get_option('atp_teaser_frontpage')=="on") {
		if (function_exists('dynamic_sidebar') && dynamic_sidebar('homepage_teaser') ) : endif; 
	}
	
	?>
	<div class="pagemid <?php $page_ids = get_option('atp_homepage'); $sidebaroption=get_post_meta($page_ids, "sidebar_options", TRUE); sidebaroption($page_ids); ?>">
		<div class="inner">
		<?php
		

		/*
		 * Custom Homepage selection from Theme Options Panel
		 * get template part from custom-home.php
		 */
		$homepage_id = get_option('atp_homepage'); 
		query_posts("page_id = $homepage_id&paged=$paged");
		get_template_part( 'includes/custom','home' );
		?>






		</div>
		<!-- inner -->
	<div id="back_to_top"><a href="#header">Top</a></div>
	</div>






<?php

/* Frontpage Custom 3 Column Widget
		 * frontpagewidgetcounts
		 * Where $column_num = starter column indexing
		 */
		
		$frontpagewidgetcounts = get_option('atp_frontpagewidgetcount');

		if(is_numeric($frontpagewidgetcounts)) {
			// If widgets are active returns output
			if( is_active_sidebar('frontpagecolumn1') OR is_active_sidebar('frontpagecolumn2') OR is_active_sidebar('frontpagecolumn3') ){
				echo '<div style="width:960px; margin:auto; background-color:#D4D4D0; border:1px solid #424243; padding: 2%;"><div>';
				for($column_num = 1; $column_num <= $frontpagewidgetcounts; $column_num++) {
					global $frontclass,$frontpagewidgetcounts;
			
					$frontlast = ($column_num == $frontpagewidgetcounts && $frontpagewidgetcounts != 1) ? 'last' : '';
				
					// Column Loop, Returns widget output
					echo'<div class="'.$frontclass.' '. $frontlast.'">';
						if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('frontpagecolumn'.$column_num)) : endif;
					echo '</div>';
				}
				echo '</div><div style="clear:both;"></div></div>';	
			}
		}

?>









	<!-- end:pagemid-->
<?php get_footer(); ?>