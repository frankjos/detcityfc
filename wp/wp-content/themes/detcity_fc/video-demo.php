<?php
/*
Template Name:Videoslider
*/
?>
<?php get_header(); ?>
<?php get_template_part( 'slider/video', 'slider' );  ?>	
<?php
echo'<div class="clear"></div>';
?>
<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('homepage_teaser') ) : endif;  ?>

<div class="pagemid <?php $page_ids= get_option('atp_homepage'); $sidebaroption=get_post_meta($page_ids, "sidebar_options", TRUE); sidebaroption($page_ids); ?>">
	<div class="inner">

<?php
 $frontpagewidgetcounts=get_option('atp_frontpagewidgetcount');
	$f=0;
	if(is_numeric($frontpagewidgetcounts)) {
		echo '<div class="frontpage_widgets">';
		for($s=1; $s<=$frontpagewidgetcounts; $s++) {
			$f++; global $frontclass,$frontpagewidgetcounts;
			$frontlast = ($f == $frontpagewidgetcounts && $frontpagewidgetcounts != 1) ? 'last' : '';
			echo'<div class="'.$frontclass.' '. $frontlast.'">';
			if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('frontpagecolumn'.$s)) :?>
			<?php 
			endif;
			echo '</div>';
		}
		echo '</div><div class="divider"></div>';
}
?>
<?php

	$homepage_id= get_option('atp_homepage'); 
	query_posts("page_id=$page_ids&paged=$paged");
	get_template_part( 'includes/custom','home' );
?>	

	</div>
	<!-- inner -->
<div id="back_to_top"><a href="#header">Top</a></div>
</div>
<!-- end:pagemid-->
<?php get_footer(); ?>