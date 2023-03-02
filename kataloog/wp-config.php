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
define( 'DB_NAME', 'd6000sd422154' );

/** MySQL database username */
define( 'DB_USER', 'd6000sa380408' );

/** MySQL database password */
define( 'DB_PASSWORD', 'CV7qd3LmRsXD84694' );

/** MySQL hostname */
define( 'DB_HOST', 'd6000.mysql.zonevs.eu' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define('AUTH_KEY',         'yNKl9h0VSfyHqBTnqrTEaeZ9zfgStl0ESTifoUMLzbj9iYAfW8kcGPNngMVQhr4T');
define('SECURE_AUTH_KEY',  'hjgE4ZPjU2Jr1dNfkYxvUSXAdj2fSqnXJ4GanCCKK0tVXvRX3MwTwRVtY2b0RAFT');
define('LOGGED_IN_KEY',    'kEQKDYA54UQ3qhwiWkixX0ZZxbGAFFJu0jwbBlMEt9BEZ2JnO6srcNIs3MnhVyEz');
define('NONCE_KEY',        'mMqhdNLvWv1Duirx9ujN8KugUw52ZOcY6LPGOps8Oiw21MScYuwz891Rw3Wczg08');
define('AUTH_SALT',        'Oc92zv1Ni4c3HjRCLoxhWlZiPjciyAEhU5ttyVtfHv0nGHOLKq6zU7dJYBJHG29J');
define('SECURE_AUTH_SALT', '6pn9OvNlTLSOVyc4EAHIxOaCohhopjoDYFSdh8MoVXtTsAihvrLAztqilEMvUB2w');
define('LOGGED_IN_SALT',   'c5aFcARAIuylti5daDLhQxo61XZ8hg94olpvtDWBGBvMmtbD049rTPLmCsGKB3KX');
define('NONCE_SALT',       'ulMoUVh7V7429o029ESlLfT0GIQKMP9CCxuWjhy7R4w0ikMhLoBID0w54buLlNWE');

/**
 * Other customizations.
 */
define('FS_METHOD','direct');
define('FS_CHMOD_DIR',0755);
define('FS_CHMOD_FILE',0644);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');

/**
 * Turn off automatic updates since these are managed externally by Installatron.
 * If you remove this define() to re-enable WordPress's automatic background updating
 * then it's advised to disable auto-updating in Installatron.
 */
define('AUTOMATIC_UPDATER_DISABLED', false);


/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'i70t_';

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


define('WP_HOME','https://tkepandimaja.ee/kataloog/');
define('WP_SITEURL','https://tkepandimaja.ee/kataloog/');

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
