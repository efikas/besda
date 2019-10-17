<?php
/**
 * Business Consultr back compat functionality
 *
 * Prevents Business Consultr from running on WordPress versions prior to 4.7,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 4.7.
 *
 * @since Business Consultr 1.0.0
 */

/**
 * Prevent switching to Business Consultr on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 * @since Business Consultr 1.0.0
 */
function business_consultr_switch_theme() {
	switch_theme( WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'business_consultr_upgrade_notice' );
}
add_action( 'after_switch_theme', 'business_consultr_switch_theme' );

/**
 * Adds a message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * Business Consultr on WordPress versions prior to 4.7.
 *
 * @since Business Consultr 1.0.0
 * @global string $wp_version WordPress version.
 */
function business_consultr_upgrade_notice() {
	$message = sprintf( esc_html__( 'Business Consultr requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'business-consultr' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 4.7.
 *
 * @since Business Consultr 1.0.0
 *
 * @global string $wp_version WordPress version.
 */
function business_consultr_customize() {
	wp_die( sprintf( esc_html__( 'Business Consultr requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'business-consultr' ), $GLOBALS['wp_version'] ), '', array(
		'back_link' => true,
	) );
}
add_action( 'load-customize.php', 'business_consultr_customize' );

/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 4.7.
 *
 * @since Business Consultr 1.0.0
 * @global string $wp_version WordPress version.
 */
function business_consultr_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( esc_html__( 'Business Consultr requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'business-consultr' ), $GLOBALS['wp_version'] ) );
	}
}
add_action( 'template_redirect', 'business_consultr_preview' );
