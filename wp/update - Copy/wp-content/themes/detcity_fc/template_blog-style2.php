<?php
/*
Template Name: Blog Style 2
*/
get_header();
?>
<?php

	/**
	 * Required Variables
	 * Get variables info from theme options panel
	 */
 
	global $atp_teaser, $atp_breadcrumbs, $comments, $atp_pagination, $readmoretxt, $paged;
	$sidebaroption = get_post_meta($post->ID, "sidebar_options", TRUE);
	$subheader_teaser_options = get_post_meta($post->ID, "subheader_teaser_options", true);
	$height = get_option('atp_ps2_imgheight')? get_option('atp_ps2_imgheight'): '150';
?>
<?php 
	
	if($atp_teaser !="disable") { 
		if($subheader_teaser_options !="disable") { ?>
	<div class="subheader" id="subheader" <?php  echo subheadercolor($post->ID); ?>>
		<div class="subheader_teaser">
			<?php subheaderteaser($post->ID); ?>
		</div>
	</div>
	<?php } 
	} ?>
	<!-- #subheader -->
	
	<div class="pagemid <?php sidebaroption($post->ID); ?>">
		
		<div class="inner">
			
			<div <?php atp_layout($post->ID); ?>>
		

				<?php $atp_breadcrumbs ? my_breadcrumb():''; ?>
				<!-- #breadcrumbs -->	

				<div class="content">	 
				<?php
					if(is_array($blog_all_cats=get_option('atp_blogacats')) && count($blog_all_cats)>0) {
						$cats=implode(",",$blog_all_cats);
					}
					if ( get_query_var('paged') ) {
						$paged = get_query_var('paged');
					}
					elseif ( get_query_var('page') ) {
						$paged = get_query_var('page');
					} else {
						$paged = 1;  
					}
					query_posts("cat=$cats.&paged=$paged");?>
				
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<div <?php post_class('post2'); ?> id="post-<?php the_ID(); ?>">

						<div class="post-info">
							<?php echo postmetaStyle2(); ?>
							<!-- .postmeta -->
							
							<div class="posttags">
								<?php the_tags('<span>Tags:</span>' , ', '); ?>
							</div>

							<div class="clear"></div>

						</div>
						<!-- .post-info -->
						
						<div class="post_content">
							<h2 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

							<?php 
							if( has_post_thumbnail()){
								$width=($sidebaroption==="fullwidth") ?'800':'500'; ?>
							<div class="postimg" style="width:<?php echo $width; ?>px; height:<?php echo $height; ?>px; ">
								<div class="post_slider clearfix"><?php echo getPostAttachments(0, 'full', 'alt="' . $post->post_title . '"',$width,$height); ?></div>
							</div>
							<?php } ?>
							<!-- .postimg -->

							<?php 
							global $more; $more = 0;  
							the_excerpt(''); ?>
							
							<a href="<?php the_permalink() ?>" ><?php echo $readmoretxt;?> &rarr;</a>
						</div>
						<!-- .post_content -->
					
					</div>
					<!-- #post-<?php the_ID();?> -->
					<?php endwhile; ?>
				
					<?php 
					if(function_exists('atp_pagination')) { 
						atp_pagination(); } ?>
					<!-- #pagination -->
					<?php else :
					if ( is_category() ) { // If this is a category archive
						printf("<h2 class='center'>Sorry, but there aren't any posts in the %s category yet.</h2>", single_cat_title('',false));
					} else if ( is_date() ) { // If this is a date archive
					echo("<h2>Sorry, but there aren't any posts with this date.</h2>");
					} else if ( is_author() ) { // If this is a category archive
						$userdata = get_userdatabylogin(get_query_var('author_name'));
						printf("<h2 class='center'>Sorry, but there aren't any posts by %s yet.</h2>", $userdata->display_name);
					} else {
						echo("<h2 class='center'>No posts found.</h2>");
						}
					get_search_form();
					endif;
					?>
				</div>
				<!-- .content -->
			</div>
			<!-- #main -->

			<?php 
			if($sidebaroption != "fullwidth"){ 
				get_sidebar(); 
			} ?>
			<!-- #sidebar -->

			<div class="clear"></div>

		</div>
		<!-- .inner -->

		<div id="back_to_top"><a href="#header">Top</a></div>

	</div>
	<!-- .pagemid-->

<?php get_footer(); ?>