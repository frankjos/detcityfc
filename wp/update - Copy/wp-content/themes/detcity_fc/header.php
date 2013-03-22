<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
<link rel="shortcut icon" href="http://detcityfc.com/images/favicon.ico" />
<script type="text/javascript" src="http://napavalleyhie.com/scripts/xfade2.js"></script>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php 
	/**
	 * Print the <title> tag based on what is being viewed.
	 */
	if (is_front_page() ) {
    bloginfo('name');
	} elseif ( is_category() ) {
		single_cat_title(); echo ' - ' ; bloginfo('name');
	} elseif (is_single() ) {
		single_post_title();
	} elseif (is_page() ) {
		single_post_title(); echo ' - '; bloginfo('name');
	} else {
		wp_title('',true);
	} ?></title>

	<!-- Default Stylesheet and Pingback-->
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<!-- Load custom favicon from theme options panel -->
	<?php if($favicon = get_option('atp_favicon')) { ?>
	<link rel="shortcut icon" href="<?php echo $favicon; ?>" type="image/x-icon" /> 
	<?php } ?>
	
	<?php 
	/**
	 * Added Javascript to Support threaded comments if its in use.
	 */
	if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); 

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
	?>
	
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
	<![endif]-->

<?php
	$atp_style = get_option('atp_style');
	if($atp_style!='0'){ ?>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/colors/<?php echo $atp_style; ?>" media="screen" />
	<?php } else { ?>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/skin.php" media="screen" />
	<?php } ?>
	
</head>
<?php 
	// Required Variables for Get Option
	$atp_logo = get_option('atp_logo'); 
	$layoutoption = get_option('atp_layoutoption'); ?>

<body <?php body_class();?>>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div id="<?php echo $layoutoption ? $layoutoption:'stretched';?>" >
	
	<?php if ( get_post_meta($post->ID, 'page_bg_image', true) ) : ?>
	<img id="pagebg" src="<?php echo get_post_meta($post->ID, "page_bg_image", true); ?>" />
	<?php endif; ?>
	
	<?php if(get_option('atp_stickybar') === "on") { ?>
	<div id="trigger" class="tarrow"></div>
	<div id="sticky">
		<?php echo  stripslashes(get_option('atp_stickycontent')); ?>
	</div>
	<!-- #sticky -->
	<?php } ?>
	
	<div id="wrap_all">

		<div <?php echo headercolor($post->ID); ?> class="clearfix" id="header">
			
			<div class="inner">

				<div class="logo">
					<?php if($atp_logo){ ?>
					<a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>">
						<img src="<?php echo $atp_logo; ?>" alt="<?php bloginfo('name'); ?>" />
					</a>
					<?php } else { ?>
					<h1 id="site-title"><span><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span></h1>
					<h2 id="site-description"><?php echo bloginfo( 'description' ); ?></h2>
					<?php } ?>
				</div>
				<!-- .logo -->
			
				<div id="menuwrap">
					<?php 
					/* Our navigation menu.  
					If one isn't filled out, wp_nav_menu falls back to wp_page_menu. 
					The menu assiged to the primary position is the one used. 
					If none is assigned, the menu with the lowest ID is used. */

					if (has_nav_menu( 'primarymenu' ) ) { wp_menu_function(); }
					else { ?>
					<ul class="sf-menu">
						<li>Go to WP-admin Appearance->Menus and assign menu location</li>
					</ul><!-- .sf-menu -->
					<?php } ?>	
					
</div>


					
				<!-- #menuwrap -->
					
			</div>
			<!-- .inner -->


	

</div>
		<!-- #header -->

<div style="width:1020px; margin:auto;">
<div id="searchone" style="float: right;padding: 15px 0px 0px 0px;">
					<form id="searchform" method="get" action="/index.php" style="margin-bottom:-6px;">
					<div>
					<input type="text" id="searchtopone" name="s" id="s" size="20" style=" padding:5px;" />
					</div>
					</form>
					</div>
</div>

	<div class="clear"></div>