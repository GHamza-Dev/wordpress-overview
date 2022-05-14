<?php

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** Database username */
define('DB_USER', 'root');

/** Database password */
define('DB_PASSWORD', '');

/** Database hostname */
define('DB_HOST', 'localhost');

/** Database charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The database collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '},gg!Y4E^`n?^z9J}huJjt.i]L5erT(gn;Zd7a}/fun@2o@!j{1M`4kJPch$ev2[');
define('SECURE_AUTH_KEY',  'ny|6W.9a7D-(B;K gi({G0|D.^3xIB]I!vY1SXLjLF{+gPHpz/KXKan28,J_LW%Q');
define('LOGGED_IN_KEY',    'QKt-Jr/w>Bd,iEH_bHNJn7T-sEdp]Rwq,tYOQS+AwV$Rp<~j)}v?$U-hVE}FE)e,');
define('NONCE_KEY',        'Dg^RZ``<NV,XOwwXIc#AW8dnY)fFAGeq0.FRd8#8~=h.X%:Jl;xOZF<,okHIA~(]');
define('AUTH_SALT',        '&4yFFa>]Hv+cCVcEgPzr[=T-V(?fE8Rxa{<.i!%D!D1H0z^IY [UJ?/GmpoB9rZ(');
define('SECURE_AUTH_SALT', '/R<G7aiC!xnS_26PpAe>uaL*~K0-H@}{2kmB-D*)d0yUPs`4!Ay+ Q)JCuaG)3YJ');
define('LOGGED_IN_SALT',   'R2IXvtmqkJ}8`ELUI>(K*s#Bcnk;N1kifeBV=xrl&Y(,>To+^uzrfA(A]<hPc+2{');
define('NONCE_SALT',       '{ iilemC$Tqc 0$D[#&ma-m^N!8~-Vcea;hL-UdTs$9&E>&&C2a_Q6cyV}}1MUV5');

/**#@-*/

/**
 * WordPress database table prefix.
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
define('WP_DEBUG', false);

/* Add any custom values between this line and the "stop editing" line. */

// Multisite
define('WP_ALLOW_MULTISITE', true);
define( 'MULTISITE', true );
define( 'SUBDOMAIN_INSTALL', false );
define( 'DOMAIN_CURRENT_SITE', 'localhost' );
define( 'PATH_CURRENT_SITE', '/wordpress/' );
define( 'SITE_ID_CURRENT_SITE', 1 );
define( 'BLOG_ID_CURRENT_SITE', 1 );


/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
	define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
