<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wp_track');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/** URL Domain */
define('WP_HOME','http://track.wp/');
define('WP_SITEURL','http://track.wp/');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '=nwMc`^4 irA+3NMF?;t.Q}igHDj>#s#SA)6NzrV[bGw_o}| 9[ sg/2$P(LS7n.');
define('SECURE_AUTH_KEY',  'lTq3%9|ae}Aa&YfXBF/E<+W,-SiA5toDl#@m5)-|WD*aN4I4f/~$YimiP:u3hL|T');
define('LOGGED_IN_KEY',    'L`^Y_BND6:P(W{SW{%Edu&K~3CHQ-#* aH74{SRu*c=Lg-zhp3FRN?u2Q<.RR+Fn');
define('NONCE_KEY',        'sGE;sry^T-gZ/Cax!zC%^bu{gnUv )$=Yc)=YYiiq94xe+^B~1@/7gMgfQ;@V-4+');
define('AUTH_SALT',        '~iaI&;9UvC.-Y~4w(o!&orn}iu*?}a&zRE_x;#|M&I~Z&Ur{.B-^qX`+WPR/LY^4');
define('SECURE_AUTH_SALT', '2S!_Bv)jY^.$dx,Pv.Wd^yj:Jyj2.#Tk.3xYWN|L4o(dPej2B^{`+B(:TH+l7->m');
define('LOGGED_IN_SALT',   '2-x*RGty-LH^9GKA[223v|]%| -fp)#cm!|YdkFdL(>42s*mp~|D|+l&&9-@?}DR');
define('NONCE_SALT',       '%CKRG-y~<rkT2,<k3E>V.Dyp}l-+^.HH|)u%y,J*8N.I7|1P^KHOC47G=Eo&A~__');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

define( 'WP_AUTO_UPDATE_CORE', false );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

