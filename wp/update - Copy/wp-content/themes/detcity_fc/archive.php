<?php get_header(); ?>
<?php 
	/**
	 * Required Variables
	 * Get variables info from theme options panel
	 */
	global $atp_breadcrumbs;

	?>

	<div id="subheader" class="subheader" <?php  echo subheadercolor($post->ID); ?>>
		<div class="subheader_teaser">
		<?php if ( have_posts() ) the_post(); ?>
			<div class="subtitle"><h1>
			<?php if ( is_day() ) : ?>
				<?php printf( __( 'Daily Archives: <span>%s</span>', 'victoria_front' ), get_the_date() ); ?>
			<?php elseif ( is_month() ) : ?>
				<?php printf( __( 'Monthly Archives: <span>%s</span>', 'victoria_front' ), get_the_date( 'F Y' ) ); ?>
			<?php elseif ( is_year() ) : ?>
				<?php printf( __( 'Yearly Archives: <span>%s</span>', 'victoria_front' ), get_the_date( 'Y' ) ); ?>
			<?php else : ?>
				<?php _e( 'Blog Archives', 'victoria_front' ); ?>
			<?php endif; ?>
			</h1></div>
		</div>
	</div>
	<!-- #subheader -->

	<div class="pagemid rightsidebar">

		<div class="inner">

			<div id="main">

				<?php $atp_breadcrumbs ? my_breadcrumb():''; ?>
				<!-- #breadcrumbs -->

				<div class="content">
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
		<!-- .inner -->

		<div id="back_to_top"><a href="#header">Top</a></div>
	</div>
	<!-- .pagemid -->

	<?php get_footer(); ?>