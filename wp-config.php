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
define('DB_NAME', 'medifind');

/** MySQL database username */
define('DB_USER', 'medifind');

/** MySQL database password */
define('DB_PASSWORD', 'password!');

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
define('AUTH_KEY',         '6P<V%5$v+7SM[![NNB-Ga=$;a1uKh{Rev}`i~46Cl:?QC25o;#vmNMz,[HLeoJUC');
define('SECURE_AUTH_KEY',  'Dn@IROc]Tio8Lu;bjyFz+:[);7GNrZ;h$8Z%{OOe[Vl*/4In96<Z&1&$a&+npE:1');
define('LOGGED_IN_KEY',    '{k=v,FOWwj7/:Qpz,S})55M ihzd_t_$Dsrs5a=U=EU AOBigoh:KDdB}DwLfpa_');
define('NONCE_KEY',        'r-@GDVUioTG$;yV(1y|=jGK;w)6OYO1n&Mcr!^1o;s`xBc?h-AsX(@fB3YT>8-a/');
define('AUTH_SALT',        'q[%&LeM&hqUJV)a-VvIq_K3gt|g$qaD[ip_mqDV#%QmW|jxG;6IE4#Kgs-jauUE:');
define('SECURE_AUTH_SALT', '3:!ZZ0h;_>~W<D$rzfkt?GavHcR:>LlB]3`%=x6 4GPtke=);rB0P6aH###zf;R2');
define('LOGGED_IN_SALT',   '*Cno3Gg&0kif0JQ_;<2sHwPQH{7,/&}v_@D{H;fMq@%kF+l4e.B(i_Cj;MUB,;K+');
define('NONCE_SALT',       'mal<_4xaoJZn$eJUD_.@e(C)hswy%N=pBs|#BRP4|$QNl=#,gVNAm>WWqC.oZ}%~');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'mf_';

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
