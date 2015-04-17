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
//define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', '/home4/mastdes1/public_html/newinnova/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'whiteboxqa');

/** MySQL database username */
define('DB_USER', 'whiteboxqa');

/** MySQL database password */
define('DB_PASSWORD', 'Innovapath1*');

/** MySQL hostname */
define('DB_HOST', 'development.cwjgdp1wxdy2.us-west-1.rds.amazonaws.com');

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
define('AUTH_KEY',         'V103u=`W7|MIC@8D4.q.^OgWN;g)+eU;08$G@Ox ue4}aUpgd~QWZWrigug|W9OL');
define('SECURE_AUTH_KEY',  've1yIRV,IQ1XO}u:Qk?~h*HabT%vdI~E{N0I/@~%IV#L9]/BgkH8:%Dr|6Q??.E?');
define('LOGGED_IN_KEY',    '}?.GQuP.Rv@6|p9|ea]Ggf<FnPs/+e~w=>=3:6o|DYF80zVGeCwh-/ny@0pLBXZ]');
define('NONCE_KEY',        '59i-xKqANUL3bEaF%.s <;A5:Xr/B;,.4y+SFp,$aO4s|.Q%*F%++|O7<nt`k@wq');
define('AUTH_SALT',        ',@RwT}?Ztzi!n,Ov%+f%|.a_.l9=j3K V::J~h$tRB)Qw7}r%w<hG&NGri:6gxp@');
define('SECURE_AUTH_SALT', 'X@+|A6p`n[v&3gE]ZTN}0lg~bkr%)97#W;J~/<>*QC+D|(tmsTWMblA?bffv=h15');
define('LOGGED_IN_SALT',   'lwb]Qw>_#UR}1ykI8`Tt.-q2MZX.hIPv7j0e9W.Zv?4j ,9NqXG%X+x][Tb]sqC3');
define('NONCE_SALT',       'W8gy[To4+3*V:7|2LMVpCYKSzSUK_dUI/l~Wx?2)3jnv8J.EjO|doJ++4aVuAi9F');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
