<?php

	global $homepage_id;//get the homepage ID
	//get sidebaroption selection and decide on main division tag styling
	$sidebaroption = get_post_meta($homepage_id, "sidebar_options", TRUE);
	
	if($sidebaroption == "fullwidth") {
		$main_div_id = 'id="fullwidth"';
	}else{
		$main_div_id = 'id="main"';
	}
?>
<!-- main -->
<div <?php echo $main_div_id; ?>>
	<div class="content">
	<?php 

		$page_data = get_page( $homepage_id );  
		$content = apply_filters('the_content', $page_data->post_content); 
		$title = $page_data->post_title; // Get title
		echo $content; // Output Content
	?>
	</div>
	<!-- .content --> 

<h1>Recent News</h1>

 <?php
$temp = $wp_query;
$wp_query= null;
$wp_query = new WP_Query();
$wp_query->query('posts_per_page=3'.'&paged='.$paged);
while ($wp_query->have_posts()) : $wp_query->the_post();
?>

  
 <div style="float:left; padding-right:20px;"><?php 
if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
  the_post_thumbnail('thumbnail');
} 
?></div>
  
    <span style="text-transform:uppercase; font-size:14px;"><a href="<?php the_permalink() ?>">
      <?php the_title(); ?>
      </a></span><br />
    <span style="margin: 0px 0px 100px 0px;">
    <?php the_time('j F Y'); ?> / <?php the_category(', '); ?>
    </span>
    <div style="padding-top:10px;"></div>
    <?php the_excerpt(); ?>
    <p align="right"><span style="font-weight:bold; text-transform:uppercase;">
      </span></p>
    <?php endwhile; wp_reset_query(); ?>





</div>
<!-- #main -->

<?php 
//get the homepage sidebar if layoiut is not FullWidth
if($sidebaroption != "fullwidth"){ 
	get_sidebar('home');
}
?>
<div class="clear"></div>