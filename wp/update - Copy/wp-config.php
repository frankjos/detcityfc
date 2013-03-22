<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'detcityfc_com_1');

/** MySQL database username */
define('DB_USER', 'detcityfccom1');

/** MySQL database password */
define('DB_PASSWORD', 'V3cPApxL');

/** MySQL hostname */
define('DB_HOST', 'mysql.detcityfc.com');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'R^(W)I8egT;Ze@s#t3yru?1tblAK;bJgSrU@?$E?#%uQ%?PF1OYN@n"|$8Hjp8~H');
define('SECURE_AUTH_KEY',  '?:b^G|m4i*(qBlJi~b$GtjE~8T:fI17yTMGTbG)~*ZA?(6AIk$PYHAqZ1#"LUEBo');
define('LOGGED_IN_KEY',    'C;H~M@_vj@o8X8eIN)e/mULXk;h:M:RRHx|oBoJ;/r|wuRLu1o5G+!%H_uGvEX:|');
define('NONCE_KEY',        'SdsJHg$5HygFafh"*Sb|h&x_@F|%/dzS9j?b"1lAc?+1)Qz_cMRQ@lwgu*jv3I3E');
define('AUTH_SALT',        'IfySU2R4?Ob:*%z93T^h_Vaj2fIw/G`gm;LB2|!UWDJLgrPBB"a)EFpm*C;+_w~k');
define('SECURE_AUTH_SALT', '79TU#RM"XVgr4;s@1p05?5~*m7%HOybC7W:j*+xM&`T;6d6IOg`mnflmZW8@r^(D');
define('LOGGED_IN_SALT',   'z7UBOFiNx0w1n:+x2!!mEOP+adJiQ6qvX9SFijET2VY~3YDQ|hmpa#!;p!Tb^qvA');
define('NONCE_SALT',       'XJnrPp%Z&MDGL`Pa8nh_b2|rsw%nmXO6?4Gj2VHF&V:yyC!`C8in**QU5Mbevnze');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_x8e38d_';

/**
 * Limits total Post Revisions saved per Post/Page.
 * Change or comment this line out if you would like to increase or remove the limit.
 */
define('WP_POST_REVISIONS',  10);

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

