<div id="sidebar">
<ul>
<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar( 1 ) ) : ?>
</ul>
</div>
<?php return; endif; ?>
<h2><?php _e( 'Pages' ); ?></h2>
<ul>
<li><a href="<?php echo home_url( '/' ); ?>"><?php _e( 'Home' ); ?></a></li>
<?php wp_list_pages( 'title_li=' ); ?>
</ul>
<h2><?php _e( 'Categories' ); ?></h2>
<ul>
<?php wp_list_cats( 'sort_column=name&optioncount=1&hierarchical=0' ); ?>
</ul>
<h2><?php _e( 'Archives' ); ?></h2>
<ul>
<?php wp_get_archives( 'type=monthly' ); ?>
</ul>
<ul>
<?php wp_list_bookmarks(); ?>
</ul>
</div>