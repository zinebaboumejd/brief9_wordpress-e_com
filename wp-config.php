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
define( 'DB_NAME', 'wordpresscom' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

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
define( 'AUTH_KEY',         'Dw4D&G~Yu7AU^wVk(ZJ1DdkD4e<JIbWQzB+c>ZBw)p tGJE3l7c~^g)+j{AhRw.h' );
define( 'SECURE_AUTH_KEY',  'reAsG|N!-TzN[j:3{iKbF}?(L?C/u+8x`&|8*,zB,tN[U27Si,T%/>BfL>V:e1Z*' );
define( 'LOGGED_IN_KEY',    '&$2_ %u#k1T/&8OqX`e{Q~,wduh)$n0D<6Mg0qE*-XWki&e})1Nn$x^-ulmu L^N' );
define( 'NONCE_KEY',        '%]_]c3qMD`QNbf=[K=OW[/caLAGd661){sv_0p4;HzKIuu/cnJ/mIOSs7G4  =~_' );
define( 'AUTH_SALT',        '{Q0#SAM&XIX_#lmDcs*9r)ljw1(Z ,(cNcFR`f%v7 Tm=2EwHjY*ev2&6Pt6j[3/' );
define( 'SECURE_AUTH_SALT', 'c|({Ih**d&/xY,{hL7Npvif7IiNpU6+bqn#H+i+39$zr[go%OB2$L>KwHhSnma#O' );
define( 'LOGGED_IN_SALT',   '(Ovhw=q(ix`M](k|:gUVe&8^!41JVRU|emP]hwme`TK}AzVWvz)>a/7h,N=+.Ya)' );
define( 'NONCE_SALT',       '55{CHJ|u@)@,>}o3PQ0b9?Ux_YdbgRs./r5^zG5[d&7U67DZS7X( zl+{N-Q{gi;' );

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
