<?php
/**************************************************************
 *                                                            *
 *   Provides a notification to the user everytime            *
 *   your WordPress theme is updated                          *
 *                                                            *
 *   Author: Joao Araujo                                      *
 *   Profile: http://themeforest.net/user/unisphere           *
 *   Follow me: http://twitter.com/unispheredesign            *
 *                                                            *
 **************************************************************/
 
 

// Constants for the theme name, folder and remote XML url
define( 'NOTIFIER_THEME_NAME', 'DetCityFC 2.0' ); // The theme name
define( 'NOTIFIER_THEME_FOLDER_NAME', 'victoria' ); // The theme folder name
define( 'NOTIFIER_XML_FILE', 'http://aivahthemes.com/themeupdates/victoria.xml' ); // The remote notifier XML file containing the latest version of the theme and changelog
define( 'NOTIFIER_CACHE_INTERVAL', 21600 ); // The time interval for the remote XML cache in the database (60 seconds = 6 hours)



// Adds an update notification to the WordPress Dashboard menu
function update_notifier_menu() {  
	if (function_exists('simplexml_load_string')) { // Stop if simplexml_load_string funtion isn't available
	    $xml = get_latest_theme_version(NOTIFIER_CACHE_INTERVAL); // Get the latest remote XML file on our server
		$theme_data = get_theme_data(TEMPLATEPATH . '/style.css'); // Read theme current version from the style.css
		
		if( (float)$xml->latest > (float)$theme_data['Version']) { // Compare current theme version with the remote XML version
			add_dashboard_page( NOTIFIER_THEME_NAME . ' Theme Updates', NOTIFIER_THEME_NAME . ' <span class="update-plugins count-1"><span class="update-count">Updates</span></span>', 'administrator', 'theme-update-notifier', 'update_notifier');
		}
	}	
}
add_action('admin_menu', 'update_notifier_menu');  



// Adds an update notification to the WordPress 3.1+ Admin Bar
function update_notifier_bar_menu() {
	if (function_exists('simplexml_load_string')) { // Stop if simplexml_load_string funtion isn't available
		global $wp_admin_bar, $wpdb;
	
		if ( !is_super_admin() || !is_admin_bar_showing() ) // Don't display notification in admin bar if it's disabled or the current user isn't an administrator
		return;
		
		$xml = get_latest_theme_version(NOTIFIER_CACHE_INTERVAL); // Get the latest remote XML file on our server
		$theme_data = get_theme_data(TEMPLATEPATH . '/style.css'); // Read theme current version from the style.css
	
		if( (float)$xml->latest > (float)$theme_data['Version']) { // Compare current theme version with the remote XML version
			$wp_admin_bar->add_menu( array( 'id' => 'update_notifier', 'title' => '<span>' . NOTIFIER_THEME_NAME . ' <span id="ab-updates">Updates</span></span>', 'href' => get_admin_url() . 'index.php?page=theme-update-notifier' ) );
		}
	}
}
add_action( 'admin_bar_menu', 'update_notifier_bar_menu', 1000 );



// The notifier page
function update_notifier() { 
	$xml = get_latest_theme_version(NOTIFIER_CACHE_INTERVAL); // Get the latest remote XML file on our server
	$theme_data = get_theme_data(TEMPLATEPATH . '/style.css'); // Read theme current version from the style.css ?>
	
<style>
.update-nag { display: none; }
.themenotifier { width:700px;}

#instructions {max-width: 670px;}
#instructions p,
#instructions h3 { margin-left:340px;}
h3.title {margin: 30px 0 30px 0; padding: 30px 0 0 0; text-align:center;  }
.vers { background:#000; padding:3px 10px; color:#fff; -moz-border-radius:3px; -webkit-border-radius:3px; border-radius:3px; }

.glowbg		{ width:700px; background:#f0f0f0; margin:0 0 10px 0; padding:5px; -moz-border-radius:5px; -webkit-border-radius:5px; border-radius:5px; }
.glowbr		{ background:#FFFFFF; border:1px solid #ddd; padding:5px; margin:0 auto;  -moz-border-radius:5px; -webkit-border-radius:5px; border-radius:5px; }

.themenotifier ul      { margin:0; padding:0; } 
.themenotifier ul li   { padding:6px 15px; margin:0; border-bottom:1px solid #eee; font-size:11px; } 
.themenotifier h4      { background:#f2f2f2; border:1px solid #ddd; padding:7px 15px; margin:0 0 15px 0; font-weight:normal;  -moz-border-radius:3px; -webkit-border-radius:3px; border-radius:3px;  }
.themenotifier .added  { background:#a3ca5e; width:70px; padding:3px }
.themenotifier .fixed  { background:#ffcf73; width:70px; padding:3px }
.themenotifier .note   { background:#b193d3; width:70px; padding:3px }
.themenotifier .del    { background:#f03628; width:70px; padding:3px; color:#fff; }
.themenotifier .added, 
.themenotifier .fixed, 
.themenotifier .note, 
.themenotifier .del { display:inline-block; float:left; margin-right:15px; text-align:center; }
</style>

<div class="wrap themenotifier">
	
		<div id="icon-tools" class="icon32"></div>
		<h2><?php echo NOTIFIER_THEME_NAME ?> Theme Updates</h2>
	    <div id="message" class="updated below-h2"><p><strong>There is a new version of the <?php echo NOTIFIER_THEME_NAME; ?> theme available.</strong> <br>You have version <?php echo $theme_data['Version']; ?> installed. Update to version <?php echo $xml->latest; ?>.</p></div>


		<img style="float: left; margin: 0 20px 20px 0; " src="<?php echo get_bloginfo( 'template_url' ) . '/screenshot.png'; ?>" />
		
		<div id="instructions">
		    <h3>Update Download and Instructions</h3>
		    <p><strong>Please note:</strong> make a <strong>backup</strong> of the Theme inside your WordPress installation folder <strong>/wp-content/themes/<?php echo NOTIFIER_THEME_FOLDER_NAME; ?>/</strong></p>
		    <p>To update the Theme, login to <a href="http://www.themeforest.net/">ThemeForest</a>, head over to your <strong>downloads</strong> section and re-download the theme like you did when you bought it.</p>
		    <p>Extract the zip's contents, look for the extracted theme folder, and after you have all the new files upload them using FTP to the <strong>/wp-content/themes/<?php echo NOTIFIER_THEME_FOLDER_NAME; ?>/</strong> folder overwriting the old ones (this is why it's important to backup any changes you've made to the theme files).</p>
		    <p>If you didn't make any changes to the theme files, you are free to overwrite them with the new ones without the risk of losing theme settings, pages, posts, etc, and backwards compatibility is guaranteed.</p>
		</div>

	    
	    <h3 class="title">Changelog</h3>
	    <?php echo $xml->changelog; ?>

	</div>
    
<?php } 



// Get the remote XML file contents and return its data (Version and Changelog)
// Uses the cached version if available and inside the time interval defined
function get_latest_theme_version($interval) {
	$notifier_file_url = NOTIFIER_XML_FILE;	
	$db_cache_field = 'notifier-cache';
	$db_cache_field_last_updated = 'notifier-cache-last-updated';
	$last = get_option( $db_cache_field_last_updated );
	$now = time();
	// check the cache
	if ( !$last || (( $now - $last ) > $interval) ) {
		// cache doesn't exist, or is old, so refresh it
		if( function_exists('curl_init') ) { // if cURL is available, use it...
			$ch = curl_init($notifier_file_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			$cache = curl_exec($ch);
			curl_close($ch);
		} else {
			$cache = file_get_contents($notifier_file_url); // ...if not, use the common file_get_contents()
		}
		
		if ($cache) {			
			// we got good results	
			update_option( $db_cache_field, $cache );
			update_option( $db_cache_field_last_updated, time() );
		} 
		// read from the cache file
		$notifier_data = get_option( $db_cache_field );
	}
	else {
		// cache file is fresh enough, so read from it
		$notifier_data = get_option( $db_cache_field );
	}
	
	// Let's see if the $xml data was returned as we expected it to.
	// If it didn't, use the default 1.0 as the latest version so that we don't have problems when the remote server hosting the XML file is down
	if( strpos((string)$notifier_data, '<notifier>') === false ) {
		$notifier_data = '<?xml version="1.0" encoding="UTF-8"?><notifier><latest>1.0</latest><changelog></changelog></notifier>';
	}
	
	// Load the remote XML data into a variable and return it
	$xml = simplexml_load_string($notifier_data); 
	
	return $xml;
}

?>