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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'viveksonar' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'SS*Aud&_uO4iX(1dgTVM v~iE0ae_i7II&ee+?=(j{lZ^)Zm=2Qv-ZmVjgO80T:a' );
define( 'SECURE_AUTH_KEY',  'v46ktv9K8hpnz(1e<0YgL<0)(<_7=?Y;xg0zt$1:A}$PM&7Dy;=0@KYTV$^gb3<.' );
define( 'LOGGED_IN_KEY',    'D;j>cS>WQ)($xHqb0w2LKiwGZ}bB/#2Lg(4k`|PE I8+Yy(}p5vQQjS:i8=M`g K' );
define( 'NONCE_KEY',        ')_}qnftDOLOT DqrJt8}.Aj:jiwS(l6-UK%f1IpLu.$Bacfp,/zio/.j6/n2idV:' );
define( 'AUTH_SALT',        'Pp0@H|U}hC5tkhd@&|7GjsJ`Jg,sWu)1;;i8eQ|_l,7/j{bI?;Z1Poj?r.MLDyhm' );
define( 'SECURE_AUTH_SALT', '&I^&5fd|h_Z=t?>7u&W-!Z+y=V:&,{{`9QQG=R9N&A~e@5;9Cvx$U(IwuQ A^PC7' );
define( 'LOGGED_IN_SALT',   'z^a~m7fU4Dl|oAy|wHwuCXQaAu}M6{M;Mxzt+<rqKzwb5/rwiqAsY <^_($FesJu' );
define( 'NONCE_SALT',       ' 1qWm`e5+:za~1[I8#a/AK0pL;8_vA_!:p|4>9*Yt }4Jv7},fLjvyR,/>n$?Z5^' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
