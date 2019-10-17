<?php
if (!defined('ABSPATH')) {
    exit;
}
require_once 'autoloader.php';

/**
 *
 * Plugin defines
 *
 */
define('KALIFORMS_BASE', plugin_dir_path(__FILE__));
define('KALIFORMS_URL', plugin_dir_url(__FILE__) . '/public/');
define('KALIFORMS_SITE', rtrim(ABSPATH, '\\/'));
define('KALIFORMS_EXTENSIONS_API', 'https://kaliforms.com/wp-json/kf/v1/plugins');
define('KALIFORMS_VERSION', '1.2.0');
