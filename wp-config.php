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
define( 'DB_NAME', 'pandimaja' );

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
define( 'AUTH_KEY',         '`^mBodpLpKr4NmM50.{?gHlS}#_NCP36ox{l*5CV2B%B;0ncUAO~Q~K:u[Tm.BGa' );
define( 'SECURE_AUTH_KEY',  '-+#)t-|tNa }ZT&%oLP(L[ b6Z8otaPC!%m4(yosC)nU-{lXz?/E9`:.*NhPOi70' );
define( 'LOGGED_IN_KEY',    '01y25twDF4x+)=#N:@Qb4xT1@YNzc$#nc2_w([,a#n+zeB&J]zR,Hn<(9HL68<D0' );
define( 'NONCE_KEY',        'ri~v*<3ik)ZXWz8tl~nnSYwI-sMyMf?sy[-!&2vK%k75`~+ITKuCY}j)8/N(--e$' );
define( 'AUTH_SALT',        '}>(FyvNjSU!0Z6+3w)P$|XH0V.w+l/j?]2`[V`EO/jLG|5p*gk.qUmc[ZZ0SB=bQ' );
define( 'SECURE_AUTH_SALT', 'k.ndt`*O}OIZ9vN- u_~)8GPhXuQG9d]eZ|H<F[0y$Cd-2_^BvCvM,||cQ9~TTgN' );
define( 'LOGGED_IN_SALT',   'vpN<Sh_0;#+HmTS7IOX0b8AZY8K72Z{&*o`,e3YID>bvR]3q%vo;|Z{S6.0tf?ND' );
define( 'NONCE_SALT',       '$WUU,iUcTzgqO!:W}B!7gr]K6ZRM DHBDrJq8-8kH,m?x`f!x9bXMIRTcbq.<%AO' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'ozbd_';

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
