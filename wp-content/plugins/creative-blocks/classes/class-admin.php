<?php
/**
* Do things related with admin settings
*
* @since 1.0.0
*/

if ( ! class_exists( 'CB_Admin' ) ) {
    /**
     * Class CB_Admin.
     */
    class CB_Admin extends CB_Helper{

    	protected static $page_slug  = 'creative_blocks';

    	public function __construct(){
    		
    	    register_activation_hook( CB_FILE, array( __CLASS__, 'activation_reset' ) );
    	    register_deactivation_hook( CB_FILE, array( __CLASS__, 'deactivation_reset' ) );

    	    add_action( 'admin_menu', array( __CLASS__, 'admin_pages') );
    	    add_action( 'admin_init', array( __CLASS__, 'redirect') );

            if( isset( $_REQUEST['page'] ) && self::$page_slug == $_REQUEST['page'] ){
                add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
            }
            self::initialize_ajax();
    	}

    	/**
    	 * Activation Reset
    	 *
    	 * @since 1.0.0
    	 */
    	public static function activation_reset() {
    	    update_option( '__cb_do_redirect', true );
    	}

    	/**
    	 * Deactivation Reset
    	 *
    	 * @since 1.0.0
    	 */
    	public static function deactivation_reset() {
    	    update_option( '__cb_do_redirect', false );
    	}

    	/**
    	 * Redirect to plugin page when plugin activated
    	 *
    	 * @since 1.0.0
    	 */
    	public static function redirect(){
    		if ( get_option( '__cb_do_redirect' ) ) {
    		    update_option( '__cb_do_redirect', false );
    		    if ( ! is_multisite() ) {
    		        exit( wp_redirect( admin_url( 'admin.php?page=' . self::$page_slug ) ) );
    		    }
    		}
    	}

    	/**
    	 * Menu
    	 *
    	 * @since 1.0.0
    	 */
    	public static function admin_pages(){

    	    if ( ! current_user_can( 'manage_options' ) ) {
    	        return;
    	    }

    	    add_menu_page( 
    	        'creative-blocks', 
    	        esc_html__( 'Creative Blocks', 'creative-blocks' ), 
    	        'manage_options', 
    	        self::$page_slug, 
    	        array( __CLASS__, 'template' ), 
    	        'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNy4wLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB3aWR0aD0iMTA4Ljg3NXB4IiBoZWlnaHQ9IjExNS4xMjVweCIgdmlld0JveD0iMCAwIDEwOC44NzUgMTE1LjEyNSIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAwIDAgMTA4Ljg3NSAxMTUuMTI1Ig0KCSB4bWw6c3BhY2U9InByZXNlcnZlIj4NCjxnPg0KCTxyYWRpYWxHcmFkaWVudCBpZD0iU1ZHSURfMV8iIGN4PSIxMS43ODgyIiBjeT0iNDAuNzc5OSIgcj0iOTAuODQ2MyIgZ3JhZGllbnRVbml0cz0idXNlclNwYWNlT25Vc2UiPg0KCQk8c3RvcCAgb2Zmc2V0PSIwIiBzdHlsZT0ic3RvcC1jb2xvcjojMkM3NUJBIi8+DQoJCTxzdG9wICBvZmZzZXQ9IjEiIHN0eWxlPSJzdG9wLWNvbG9yOiM5MzREOUQiLz4NCgk8L3JhZGlhbEdyYWRpZW50Pg0KCTxwb2x5Z29uIGZpbGw9InVybCgjU1ZHSURfMV8pIiBwb2ludHM9IjIuMjY0LDM5LjU2NiAzOC4yMTksNS4xNiA1NC43MzgsNTguNzE4IDE2LjY1OSw5Ni45OTkgCSIvPg0KCTxyYWRpYWxHcmFkaWVudCBpZD0iU1ZHSURfMl8iIGN4PSIxMC4wMDI1IiBjeT0iNDAuNzc5OSIgcj0iOTAuODQ2MyIgZ3JhZGllbnRVbml0cz0idXNlclNwYWNlT25Vc2UiPg0KCQk8c3RvcCAgb2Zmc2V0PSIwIiBzdHlsZT0ic3RvcC1jb2xvcjojMkM3NUJBIi8+DQoJCTxzdG9wICBvZmZzZXQ9IjEiIHN0eWxlPSJzdG9wLWNvbG9yOiM5MzREOUQiLz4NCgk8L3JhZGlhbEdyYWRpZW50Pg0KCTxwb2x5Z29uIGZpbGw9InVybCgjU1ZHSURfMl8pIiBwb2ludHM9IjY5LjM3NiwxMTIuMzgxIDEwNC45ODMsNzYuNzc0IDU4Ljg5NSw2My4yNjQgMjAuODg5LDEwMS4yNyAJIi8+DQoJPHJhZGlhbEdyYWRpZW50IGlkPSJTVkdJRF8zXyIgY3g9IjkuNjQ1NCIgY3k9IjQwLjQyMjgiIHI9IjkwLjg0NjMiIGdyYWRpZW50VW5pdHM9InVzZXJTcGFjZU9uVXNlIj4NCgkJPHN0b3AgIG9mZnNldD0iMCIgc3R5bGU9InN0b3AtY29sb3I6IzJDNzVCQSIvPg0KCQk8c3RvcCAgb2Zmc2V0PSIxIiBzdHlsZT0ic3RvcC1jb2xvcjojOTM0RDlEIi8+DQoJPC9yYWRpYWxHcmFkaWVudD4NCgk8cGF0aCBmaWxsPSJ1cmwoI1NWR0lEXzNfKSIgZD0iTTEwNi42OCw3MC44MjRMNjEuMjM5LDU3LjQxNUw0My42OTcsMi4yMkw3Mi4wMjIsOC44bDQuNiwxMy45OTFsMTYuNzcsMy43OTJMMTA2LjY4LDcwLjgyNHoNCgkJIE02NC42MzMsNTMuOTQ5bDM1LjY2NCwxMC41MjJMOTAuMDA2LDMwLjIwN2wtMTYuNjk5LTMuNzc1bC00LjYwNC0xMy45OTlMNTAuMDYyLDguMDk2TDY0LjYzMyw1My45NDl6Ii8+DQo8L2c+DQo8L3N2Zz4NCg==', 
    	        110
    	    );
    	}

        /**
        * Enqueue styles & scripts for frontend & backend
        *
        * @access public
        * @uses wp_enqueue_style
        * @return void
        * @since Creative Blocks 1.0.0
        */
        public static function admin_scripts() {

           /*---------------------------------------------*
            * Register Style for Admin Page               *
            *---------------------------------------------*/

            $scripts = array(
                array(
                    'handler' => 'cb-admin-css',
                    'absolute' => true,
                    'style'   => self::get_plugin_directory_uri() . 'templates/style.css', 
                ),
                array(
                    'handler' => 'cb-admin-fonts',
                    'absolute' => true,
                    'style'   => '//fonts.googleapis.com/css?family=Poppins:300,300i,400,500,600,700', 
                ), 
                array(
                    'handler' => 'font-awesome',
                    'style'   => 'vendors/font-awesome/css/all.min.css', 
                    'version' => '5.6.3'
                ),
                array(
                    'handler' => 'cb-admin-js',
                    'absolute' => true,
                    'script'  => self::get_plugin_directory_uri() . 'templates/script.js'
                )
            );

            self::enqueue( $scripts );

            $localize = array(
                'ajax_url'   => admin_url( 'admin-ajax.php' ),
                'ajax_nonce' => wp_create_nonce( 'cb-block-nonce' ),
            );

            wp_localize_script( 'cb-admin-js', 'CB_SETTINGS', apply_filters( 'cb_js_localize', $localize ) );
        }

    	/**
    	 * Admin Page Template
    	 *
    	 * @since 1.0.0
    	 */
    	public static function template(){
    		self::includes( 'page', 'templates', 'admin' );
    	}

        /**
         * Initialize Ajax
         */
        public static function initialize_ajax() {
            // Ajax requests.
            add_action( 'wp_ajax_activate_block', array( __CLASS__, 'activate_block' ) );
            add_action( 'wp_ajax_deactivate_block', array( __CLASS__, 'deactivate_block' ) );

            add_action( 'wp_ajax_bulk_activate_blocks', array( __CLASS__, 'bulk_activate_blocks' ) );
            add_action( 'wp_ajax_bulk_deactivate_blocks', array( __CLASS__, 'bulk_deactivate_blocks' ) );
        }

        public static function block_action( $action = 'get', $blocks = array() ){

            $key = '_cb_blocks';
            switch( $action ){
                case 'get':
                    return self::get_option( $key, array() );
                case 'update':
                    self::update_option( $key, $blocks );
                break;

            }
        }

        public static function is_block_active( $block_id ){
            $blocks = self::block_action();

            if( !isset( $blocks[ $block_id ] ) || $blocks[ $block_id ] == $block_id ){
                return true;
            }else{
                return false;
            }
        }

        public static function is_all_block_active(){
            $blocks = self::block_action();
            foreach( $blocks as $b ){
                if( $b == 'disabled' ){
                    return false;
                }
            }

            return true;
        }

        /**
         * Activate block
         */
        public static function activate_block() {

            check_ajax_referer( 'cb-block-nonce', 'nonce' );

            $block_id            = sanitize_text_field( $_POST[ 'block_id' ] );
            $blocks              = self::block_action();
            $blocks[ $block_id ] = $block_id;
            $blocks              = array_map( 'esc_attr', $blocks );

            // Update blocks.
            self::update_option( '_cb_blocks', $blocks );

            echo $block_id;

            die();
        }

        /**
         * Deactivate block
         */
        public static function deactivate_block() {

            check_ajax_referer( 'cb-block-nonce', 'nonce' );

            $block_id            = sanitize_text_field( $_POST[ 'block_id' ] );
            $blocks              = self::block_action();
            $blocks[ $block_id ] = 'disabled';
            $blocks              = array_map( 'esc_attr', $blocks );

            // Update blocks.
            self::block_action( 'update', $blocks );

            echo $block_id;

            die();
        }

        /**
         * Activate all module
         */
        public static function bulk_activate_blocks() {

            check_ajax_referer( 'cb-block-nonce', 'nonce' );

            // Get all blocks.
            $all_blocks = self::$block_list;
            $new_blocks = array();

            // Set all extension to enabled.
            foreach ( $all_blocks as $slug => $value ) {
                $_slug                = str_replace( 'creative-blocks/', '', $slug );
                $new_blocks[ $_slug ] = $_slug;
            }

            // Escape attrs.
            $new_blocks = array_map( 'esc_attr', $new_blocks );

            // Update new_extensions.
            self::block_action( 'update', $new_blocks );

            echo 'success';

            die();
        }

        /**
         * Deactivate all module
         */
        public static function bulk_deactivate_blocks() {
           
            check_ajax_referer( 'cb-block-nonce', 'nonce' );

            // Get all extensions.
            $old_blocks = self::$block_list;
            $new_blocks = array();

            // Set all extension to enabled.
            foreach ( $old_blocks as $slug => $value ) {
                $_slug                = str_replace( 'creative-blocks/', '', $slug );
                $new_blocks[ $_slug ] = 'disabled';
            }

            // Escape attrs.
            $new_blocks = array_map( 'esc_attr', $new_blocks );

            // Update new_extensions.
            self::update_option( '_cb_blocks', $new_blocks );

            echo 'success';

            die();
        }

        public static function content(){
            return array(
                'section' => array(
                    'title' => esc_html__( 'Section', 'creative-blocks' ),
                    'description' => esc_html__( 'Add a section to wrap several blocks into a single section. Choose how many columns you\'d like, select a layout, drag to resize, set padding and drop in background images or color for the section.', 'creative-blocks' ),
                ),
                'post-masonry' => array(
                    'title' => esc_html__( 'Post Masonry', 'creative-blocks' ),
                    'description' => esc_html__( 'Add a powerful post masonry, which will modify your posts to better looking advance Masonry layout with customizable columns, post order, category, content and image setting.', 'creative-blocks' ),
                ),
                'post-slider' => array(
                    'title' => esc_html__( 'Post Slider', 'creative-blocks' ),
                    'description' => esc_html__( 'Add an energetic unlimited post slideshow with single or multiple posts per slide. Includes autoplay, post order, category, content and image settings.', 'creative-blocks' ),
                ),
                'icon-box' => array(
                    'title' => esc_html__( 'Icon Box', 'creative-blocks' ),
                    'description' => esc_html__( 'Add a dynamic icon box section contain icon or image, heading, subheading, description in which it allows you to choose number of items with individual icon boxsettings includes typography, background and color settings.', 'creative-blocks' ),
                ),
                'accordion' => array(
                    'title' => esc_html__( 'Accordion', 'creative-blocks' ),
                    'description' => esc_html__( 'Add an accordion text toggle with a heading and description. Include icons to represent whether toggle is active or not.', 'creative-blocks' ),
                ),
                'profile-box' => array(
                    'title' => esc_html__( 'Profile Box', 'creative-blocks' ),
                    'description' => esc_html__( 'Add a profile box with a name, designation, description, an avatar and social media links.', 'creative-blocks' ),
                ), 
                'callback' => array(
                    'title' => esc_html__( 'Callback', 'creative-blocks' ),
                    'description' => esc_html__( 'Add an eye-catching section with a big heading, description and customizable multiple buttons. Includes background image and colors.', 'creative-blocks' ),
                ),
                'heading' => array(
                    'title' => esc_html__( 'Advanced Heading', 'creative-blocks' ),
                    'description' => esc_html__( 'Add a attractive, catchy headings with subheading and an optional divider with styling options in your page.', 'creative-blocks' ),
                ),
                'spacer' => array(
                    'title' => esc_html__( 'Spacer', 'creative-blocks' ),
                    'description' => esc_html__( 'Add an adjustable spacer between your blocks', 'creative-blocks' ),
                ),
                'divider' => array(
                    'title' => esc_html__( 'Divider', 'creative-blocks' ),
                    'description' => esc_html__( 'Add a Divider between your blocks with an styling options.', 'creative-blocks' ),
                ),
            );
        }
    }
}
new CB_Admin();
