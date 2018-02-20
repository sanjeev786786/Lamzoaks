<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         '?.-p<#cf6=5GSgrTov-:2t*<4Z*hd<8.z.JHQ])v#<wfPt?@vX:0spz27s].E?w~');
define('SECURE_AUTH_KEY',  'z-c[<6R.B/flSWHz-m^e*/b:DN4a^8Slc/qG|6]*i00,ufVy6yDdWs,7sf%9h`?/');
define('LOGGED_IN_KEY',    'l}aP&BW <ht):dm@:g1b8}|[M;Sx1y73Z6_B#zy]eh_%cfZc efy:X>YRof&|u|=');
define('NONCE_KEY',        'pM+V[wYj`wbw./tX4,(`Ef>euUco Rng1?*w{2 {jJ-Nny`C.pX.BM[w<//1.]uy');
define('AUTH_SALT',        'G4.}yMxn]4d<p7c91Z[bV/?AH$sbOZ;5 PFGUV~dLx05 $61pzq?8xLNiO4<Dxw2');
define('SECURE_AUTH_SALT', 'kt;Z$tK&U)wFCbgXImU1Sx7-;6l6L5:|9>kQRKa^h_B^xJaKp]]V(4zywlxXUnKv');
define('LOGGED_IN_SALT',   'p?#NVIk?j.XVyeQEdIFwM)}itQwur!D4Fp]xTqe?YnN?,/_f(&D-24O$_;FdOgg7');
define('NONCE_SALT',       '~_mBul<-0_qpX4`1Z_3~)@Shc/WVr/i<]MPZ2sZ7uo6-E^Ec#QQZNSO`:?1D%v~A');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
