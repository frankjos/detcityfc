<?php get_header(); ?>
<?php 
	/**
	 * Required Variables
	 * Get variables info from theme options panel
	 */
	global $atp_breadcrumbs;
	
	?>

	<?php if ( have_posts() ) the_post(); ?>
	
	<div id="subheader" class="subheader" <?php  echo subheadercolor($post->ID); ?>>
		<div class="subheader_teaser">
			<div class="subtitle ">
			<h1 class="author"><?php printf( __( 'Author Archives: %s', 'victoria_front' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' ); ?></h1>
			</div>
		</div>
	</div>
	<!-- #subheader -->


	<div class="pagemid rightsidebar">

		<div class="inner">

			<div id="main">
		
				<?php $atp_breadcrumbs ? my_breadcrumb():''; ?>
				<!-- #breadcrumbs -->
				
				<div class="content">

					<div class="authorpage">
						
						<div class="entry-title author clearfix">
						
						<?php 
						printf( __( 'Author : %s', 'victoria_front' ), "<span class='vcard'><a class='url fn n' href='" . get_author_posts_url( get_the_author_meta( 'ID' ) ) . "' title='" . esc_attr( get_the_author() ) . "' rel='me'>" . get_the_author() . "</a></span>" ); ?>
	
						<?php // If a user has filled out their description, show a bio on their entries.
						if ( get_the_author_meta( 'description' ) ) : ?>
							
							<div id="author-avatar-right">
								<p><?php echo get_the_author_meta( 'description' ); ?></p>
								<?php echo get_avatar( get_the_author_meta( 'user_email' ), 80 ); ?>
							</div>
							<!-- #author-avatar-right -->
						<?php endif; ?>
						</div>
						<!-- .author -->
					</div>
					<!-- .auhorpage -->
				
					<?php 
					
					rewind_posts();
					get_template_part( 'loop' );
					
					?>
				</div>
				<!-- .content -->
			</div>
			<!-- #main -->
			
			
			<?php get_sidebar(); ?>
			<!-- #sidebar -->

			<div class="clear"></div>

		</div>
		<!-- inner -->
		
		<div id="back_to_top"><a href="#header">Top</a></div>
	</div>
	<!-- .pagemid -->
	
<?php get_footer(); ?>