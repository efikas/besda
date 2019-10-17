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
define( 'DB_NAME', 'besda' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
// define( 'DB_HOST', 'localhost' );
define('DB_HOST', '127.0.0.1:8889');

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
// define( 'AUTH_KEY',         '77.e+t~NfMK$dwVT* A4{P%}NE%`A{lNUD}I)[tZ{Thv!,LdgmDdaZ3hCyY2vd)]' );
// define( 'SECURE_AUTH_KEY',  '`lZT8/vC;n+FyDPins3l3pevb+fr&|iv}Z#a_a1qr?Vm=m[b5#nP[+{iPKs7*f%b' );
// define( 'LOGGED_IN_KEY',    'T^]e387egt>}|^Hi%@ny^&}!}[46Z(^.9DxcrG$a_eZD:p7eN1P!$jN)WF`{/|Z?' );
// define( 'NONCE_KEY',        '#.Jgv$R:ih^AA*^Y a`WtBsTEDWV-<x*^V<rdrNP@eZeSn_h^GSBd<TKT#p&T1-r' );
// define( 'AUTH_SALT',        'fhj%p8g+uk(?6GPKtO;F8]pKvMa6Q+ R!.uDSg`vd`Ag/m=8WYm9*9Ws#neW}y31' );
// define( 'SECURE_AUTH_SALT', 'bg@TnO3aKL3xe$RYn6uTU59CN6pya:dzn$z[~sR<BJ sE6HwVMnWjv@D3:Sv1t:D' );
// define( 'LOGGED_IN_SALT',   'gpCU# `rd)NefVS}q7vtHk$CnpL5&aHZ,lP#<F]%?OtMPv;,z>Tw9!E15L;QhB:O' );
// define( 'NONCE_SALT',       'X03{Jm/$iXElbXcN9m/SMZU_hM$FK+%8mH]UE5Wo7,CUX#)iv%l(~Wi7JoZ:Ts18' );

define('AUTH_KEY',         '[ol2+v>|QWGO.yTb/sHdD=;U-V4p(:NQ.,xwscQc[rbRfipA0l`y[whs;^BsgW[_');
define('SECURE_AUTH_KEY',  '^HF8d?e[%^]A0:<#PxuoT.Ei5^:^,)d^S,GqcVD|Kd.o]XngNA&*U3iunf#-ADy+');
define('LOGGED_IN_KEY',    '[B._zxRLz$|%-^=G!N9$4ylwEgChF]b@{8|r6-$3XMl&0+|qR^@%CBc@k=W+w{7l');
define('NONCE_KEY',        'j[Y6OU%r.;lnK;w3.VRc|!# TF(LIMI &wj8CcQ|:.Mml%kwKN+Zc>Siw@=gBfrn');
define('AUTH_SALT',        '}IX r+9|H^;f6&JQm.P&Wt3;wV|[<-L?#{<RA:spZgJ62VR:Y%{vM{PnkvRnf`(p');
define('SECURE_AUTH_SALT', 'oYmcbJgH+N)2+*sdq`&UX&KUYm2D1:w(I!=ZA7+j_a7:1TE*_oHw]3>zKJH-@WCd');
define('LOGGED_IN_SALT',   '>=Er*ee|D@aQ|-{1|eS|-A(N%itRdZU.C.[ml/HVaW%Q!w;NA9ip9:cn%%^hd+ZG');
define('NONCE_SALT',       '$vQym+06-zH4wl1*)Rk+1TZEL|; VVh{G=WA66-Bqgl`aQq gWSob:o;;K4g.#f)');

	// $P$BCYmpcVb1KlKb9IIcYYzWc1AQXc3Dq1
		
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
