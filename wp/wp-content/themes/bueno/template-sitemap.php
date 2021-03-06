<?php
/**
 * @package WordPress
 * @subpackage Bueno
 */
/*
Template Name: Sitemap
*/
?>
<?php get_header(); ?>

    <div id="content" class="col-full">
		<div id="main" class="col-left">

	        <div class="post">

	        	<h2 class="title"><?php the_title(); ?></h2>

	        	<div class="entry">

	            	<h3><?php _e('Pages', 'woothemes') ?></h3>

	            	<ul>
	           	    	<?php wp_list_pages('depth=0&sort_column=menu_order&title_li=' ); ?>
	            	</ul>

		            <h3><?php _e('Categories', 'woothemes') ?></h3>

		            <ul>
	    	            <?php wp_list_categories('title_li=&hierarchical=0&show_count=1') ?>
	        	    </ul>

			        <h3>Posts per category</h3>

			        <?php

			            $cats = get_categories();
			            foreach ($cats as $cat) {

			            query_posts('cat='.$cat->cat_ID);

			        ?>

	        			<h4><?php echo $cat->cat_name; ?></h4>

			        	<ul>
	    	        	    <?php while (have_posts()) : the_post(); ?>
	        	    	    <li style="font-weight:normal !important;"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a> - <?php _e('Comments', 'woothemes') ?> (<?php echo $post->comment_count ?>)</li>
	            		    <?php endwhile;  ?>
			        	</ul>

	    		    <?php } ?>

	    		    <?php wp_reset_query(); ?>

	    			<?php edit_post_link( __( 'Edit This', 'woothemes' ), '<p>', '</p>' ); ?>

	    		</div><!-- /.entry -->

	        </div><!-- /.post -->

        </div><!-- /#main -->

        <?php get_sidebar(); ?>

    </div><!-- /#content -->

<?php get_footer(); ?>
