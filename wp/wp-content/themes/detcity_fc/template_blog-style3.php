<?php
/*
Template Name: Blog Style 3
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
	$height = get_option('atp_ps3_imgheight')? get_option('atp_ps3_imgheight'): '100';

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

	<div class="pagemid <?php  sidebaroption($post->ID); ?>">
		
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
					query_posts("cat=$cats.&paged=$paged");
					?>
					<?php
						// Column Indexing
						$column="3";
						$c="0";
						if (have_posts()) : while (have_posts()) : the_post(); 
						$c++;
						$last = ($c == $column && $column != 1) ? 'last ' : '';
					?>
					<div id="post-<?php the_ID(); ?>" class="post3 <?php echo $last; ?>">
			
						<div class="post_content">
						
							<?php 
							if( has_post_thumbnail()){ 
								$width=($sidebaroption==="fullwidth") ?'270':'170'; ?>
								<div class="postimg" style="width:<?php echo $width; ?>px; height:<?php echo $height; ?>px; ">
									<div class="post_slider" style="width:<?php echo $width; ?>px; height:<?php echo $height; ?>px; "><?php echo getPostAttachments(0, 'full', 'alt="' . $post->post_title . '"',$width,$height); ?></div>
								</div>
							<?php } ?>
							<!-- .postimg -->

							<div class="post-info">
								<h2 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
								<?php echo postmetaStyle3(); ?>
							</div>
							<!-- .post-info -->
		
							<?php 
								global $more; $more = 0;  
								excerpt('20'); ?>		
							
							<a href="<?php the_permalink() ?>" class="more-link"><?php echo $readmoretxt;?> &rarr;</a>
					
						</div>
						<!-- .post_content -->
					
					</div>
					<!-- #post-<?php the_ID();?> -->
					
					<?php if($c == $column){ $c = 0; echo '<div class="divider_line"></div>'; } // Add divider after each row ?>

					<?php endwhile; ?>
			
					<?php 
					if(function_exists('atp_pagination')) { 
						atp_pagination(); 
					} ?>
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
	
			<?php if($sidebaroption != "fullwidth"){ get_sidebar(); } ?>
			<!-- #sidebar -->

			<div class="clear"></div>
		
		</div>
		<!-- .inner -->
		
		<div id="back_to_top"><a href="#header">Top</a></div>
	</div>
	<!-- .pagemid-->
	
<?php get_footer(); ?>