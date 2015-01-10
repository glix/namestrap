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
define('DB_NAME', '');

/** MySQL database username */
define('DB_USER', '');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', '');

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
define('AUTH_KEY',         '_}ZJE2!7}eJPV~`Yxu8i4K6D3tvu}@lyWLE+i6A-2IH#@]RSNv)4aEUMoI|8MC1,');
define('SECURE_AUTH_KEY',  'X(56juA:PsjF0r#7iNZyzCj8f$G>pJy&+2EWF|RC|<[r-u]%~aFQgE3QFh^~)fx#');
define('LOGGED_IN_KEY',    'A>9d)d%w+/qXQNj1)aQ%gCG(U<z8HiP?s.,l7WM1 4u0M5ca:?|HJdK91@}FxDr?');
define('NONCE_KEY',        'R|Z.X@z+<SkNG?Nt):C]kRrM4z:SHyRoMG/)|L{-TUexl:QZu;dIM5-Yzn?VQ9,8');
define('AUTH_SALT',        'clK!g]^*q`0L_$?|GYw<w0rm+Lu;?v RP<9B.)iiN+`w1glp_nZRIJYNp]uVI^3J');
define('SECURE_AUTH_SALT', '`ef]rMXT|Z~v&Ny-T0RZM!h_KP;3vG&2>Px|39;7#}SigPM>;uAfV7Akm1,b.|v+');
define('LOGGED_IN_SALT',   ' 54jN=sj+R-ypZp;lY4=>kGd!`Zk7Raaqk!`nnsLk=R]t)R&7a+9zw!(-_0;y= =');
define('NONCE_SALT',       'r%?/-/wVb,y/G=X$#/3B{~!_9,|P.#::ygLq-+^=25@qF?1~71J|DxsHX3At,p4P');

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

// custom constant
define('PAGINATION_LIMIT', 21);


/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
