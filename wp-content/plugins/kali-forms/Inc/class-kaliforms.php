<?php
namespace KaliForms\Inc;

if (!defined('ABSPATH')) {
    exit;
}

use KaliForms\Inc\Backend\Hooks;
use KaliForms\Inc\Backend\Meta_Save;
use KaliForms\Inc\Backend\Notifications;
use KaliForms\Inc\Backend\Posts\Forms;
use KaliForms\Inc\Backend\Predefined_Forms;
use KaliForms\Inc\Frontend\Form_Processor;
use KaliForms\Inc\Payments_Simple;
use KaliForms\Inc\Utils\TransientHelper;
use KaliForms\Inc\Utils\First_Install;
/**
 * Class KaliForms
 *
 * @package App
 */
class KaliForms
{
    use TransientHelper;
    /**
     * Plugin slug
     *
     * @var string
     */
    protected $slug = 'kaliforms';

    /**
     * Plugins hooked in KaliForms
     *
     * @var array
     */
    public $plugins = [];

    /**
     * KaliForms constructor.
     */
    public function __construct()
    {
        register_activation_hook(KALIFORMS_PLUGIN_FILE, [$this, 'install']);
		add_action('plugins_loaded', [$this, 'init_kaliforms']);
    }

    /**
     * Initiate kaliforms
     */
    public function init_kaliforms()
    {
        /**
         * Hook before the plugin is constructed
         */
        do_action($this->slug . '_before_construction', $this);
        /**
         * Hook external plugins in KaliForms
         */
        $this->plugins = apply_filters($this->slug . '_hook_external_plugins', $this->plugins);
        /**
         * Create an instance of the meta save
         */
        Meta_Save::get_instance();
        /**
         * Register the new custom post type
         */
        new Forms();
        /**
         * Initiate actions & filters
         */
        new Hooks();
        /**
         * Form processor
         */
        new Form_Processor();
        /**
         * Payment actions
         */
        new Payments_Simple();
        /**
         * Load the predefined forms
         */
        new Predefined_Forms();
        /**
         * Create notifications
         */
        Notifications::get_instance();
        /**
         * Hook after the plugin constructor is ready
         * (Some parts of the plugin e.g. Hooks() may happen later)
         */
        do_action($this->slug . '_after_construction', $this);
        /**
         * Delete transient files from the file upload
         */
        add_action($this->slug . '_delete_transient_file', [$this, 'delete_transient_file']);

    }

    /**
     * Returns an instance of the plugin
     *
     * @return KaliForms
     */
    public static function get_instance()
    {
        static $inst;
        if (!$inst) {
            $inst = new KaliForms();
        }

        return $inst;
    }

    /**
     * Installation hook
     */
    public static function install()
    {
		$first_install = new First_Install();
    }
}
