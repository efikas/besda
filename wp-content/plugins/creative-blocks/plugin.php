<?php
/**
 * Plugin Name: Creative Blocks
 * Plugin URI: https://keonthemes.com/downloads/creative-blocks
 * Description: The Creative Blocks, an elegant professional page building blocks for the WordPress Gutenberg block editor is the collection of flexible, clean, simple and reactive blocks ready to use in your pages and posts. Creative Blocks is an exclusively powerful approach to blogging and creating content.
 * Author: Keon Themes
 * Author URI: https://keonthemes.com/
 * Version: 1.0.0
 * Text Domain: creative-blocks
 * License: GPLv3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Tested up to: 5.2.2
 */

# Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CB_FILE', __FILE__ );
define( 'CB_MODE', 'production' );

require_once 'classes/class-helper.php';

if( ! class_exists( 'Creative_Blocks' ) ):
	/**
	 * Main class for creative blocks to initialize the functionality.
	 *
	 * @since 1.0.0
	 */
	final class Creative_Blocks extends CB_Helper {

		/**
		 * Checks if the environment is ready for Gutenberg Blocks.
		 *
		 * @since 1.0.0
		 */
		public function __construct(){
			if ( ! version_compare( PHP_VERSION, '5.6', '>=' ) ) {
				add_action( 'admin_notices', array( $this, 'fail_php_version' ) );
			} elseif ( ! version_compare( get_bloginfo( 'version' ), '4.7', '>=' ) ) {
				add_action( 'admin_notices', array( $this, 'fail_wp_version' ) );
			} else {
				self::includes( 'init' );
			}
		}

		/**
		 * Creative Blocks admin notice for minimum PHP version.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function fail_php_version() {
			/* translators: %s: PHP version */
			$message      = sprintf( esc_html__( 'Creative Blocks requires PHP version %s+, plugin is currently NOT RUNNING.', 'creative-blocks' ), '5.6' );
			$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
			echo wp_kses_post( $html_message );
		}


		/**
		 * Creative Blocks admin notice for minimum WordPress version.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function fail_wp_version() {
			/* translators: %s: WordPress version */
			$message      = sprintf( esc_html__( 'Creative Blocks requires WordPress version %s+. Because you are using an earlier version, the plugin is currently NOT RUNNING.', 'creative-blocks' ), '4.7' );
			$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
			echo wp_kses_post( $html_message );
		}
	}

	new Creative_Blocks();
endif;