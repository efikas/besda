<?php
/**
* A class to setting up the things
*
* @see https://wordpress.org/gutenberg/handbook/
* @since 1.0.0
*/

if ( ! class_exists( 'CB_Init' ) ) {
    /**
     * Class CB_Init.
     */
    class CB_Init extends CB_Helper{

        /**
        * Register necessarry styles and scripts for plugin
        * Register custom category
        *
        * @access public
        * @see https://wordpress.org/gutenberg/handbook/designers-developers/developers/tutorials/javascript/loading-javascript/
        * @uses register_scripts()
        * @return void
        * @since Creative Blocks 1.0.0
        */
        public function __construct(){

            add_action( 'enqueue_block_assets', array( $this, 'common_scripts' ) );
            add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ) );
            add_action( 'enqueue_block_editor_assets', array( $this, 'editor_scripts' ) );

            add_filter( 'block_categories', array( $this, 'register_category' ), 10, 2 );

            add_action( 'rest_api_init', array( $this, 'register_rest_fields' ) );

            self::includes( array(
                'base',
                'admin',
                'accordion',
                'callback',
                'post-masonry',
                'post-slider',
                'section-column',
                'profile-box'
            ));
        }

        public function register_rest_fields(){
            # Add comment info.
            register_rest_field(
                'post',
                'cb_total_comments',
                array(
                    'get_callback'    => array( __CLASS__, 'get_total_comment' ),
                    'update_callback' => null,
                    'schema'          => null,
                )
            );

            register_rest_field(
                'post',
                'cb_categories',
                array(
                    'get_callback'    => array( __CLASS__, 'get_categories' ),
                    'update_callback' => null,
                    'schema'          => null,
                )
            ); 

            register_rest_field(
                'page',
                'cb_excerpt',
                array(
                    'get_callback'    => array( __CLASS__, 'get_excerpt' ),
                    'update_callback' => null,
                    'schema'          => null,
                )
            );

            register_rest_field(
                'post',
                'cb_excerpt',
                array(
                    'get_callback'    => array( __CLASS__, 'get_excerpt' ),
                    'update_callback' => null,
                    'schema'          => null,
                )
            );
        }

        /**
        * Register category
        *
        * @access public
        * @uses array_merge
        * @return array
        * @since Creative Blocks 1.0.0
        */

        public function register_category( $categories, $post ) {
            return array_merge( $categories, array(
                    array(
                        'slug'  => 'creative-blocks',
                        'title' => esc_html__( 'Creative Blocks', 'creative-blocks' ), 
                    ),
                )
            );
        }        

        public function common_scripts(){

            /*---------------------------------------------*
             * Register Style for banckend and frontend    *
             * dependencies { wp-editor }                  *
             *---------------------------------------------*/

            $scripts = array(
                array(
                    'handler'    => 'cb-common-css',
                    'style'      => 'dist/blocks.style.build.css',
                    'dependency' => array( 'wp-editor' ),
                    'version'    => self::get_rand_asssets_file_version( 'blocks.style.build.css' )
                ),
                array(
                    'handler'  => 'font-awesome',
                    'style'    => 'vendors/font-awesome/css/all.min.css',
                    'version'  => '5.6.3',
                )
            );

            self::enqueue( $scripts );

        }

        /**
        * Enqueue styles & scripts for frontend
        * @access public
        * @return void
        * @since Creative Blocks 1.0.0
        */
        public function frontend_scripts(){

            $scripts = array( 
                array(
                    'handler'  => 'jquery-ui-smoothness',
                    'style'    => 'vendors/jquery-ui.css',
                    'version'  => '1.12.1'
                ),
                array(
                    'handler'  => 'jquery-nicescroll',
                    'script'   => 'vendors/nicescroll/jquery.nicescroll.js',
                    'version'  => '3.7.6',
                )
            );

            self::enqueue( $scripts );
        }

        /**
        * Enqueue style for backend editor
        *
        * @access public
        * @uses wp_enqueue_script
        * @uses wp_enqueue_script
        * @return void
        * @since Creative Blocks 1.0.0
        */

        public function editor_scripts(){

            $scripts = array(
               /*---------------------------------------------------------------*
                * Enqueue scripts for backend editor                            *
                * dependencies { wp-blocks, wp-i18n, wp-element, wp-editor }    *
                *---------------------------------------------------------------*/
                array(
                    'handler'    => 'cb-editor-js',
                    'script'     => 'dist/blocks.build.js',
                    'dependency' => array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ),
                    'version'    => self::get_rand_asssets_file_version( 'blocks.build.js' ),
                    'in_footer'  => false
                ),
               /*-------------------------------------------*
                * Enqueue style for banckend editor         *
                * dependencies { wp-edit-blocks }           *
                *-------------------------------------------*/
                array(
                    'handler'    => 'cb-editor-css',
                    'style'      => 'dist/blocks.editor.build.css',
                    'dependency' => array( 'wp-edit-blocks' ),
                    'version'    => self::get_rand_asssets_file_version( 'blocks.editor.build.css' )
                ),
                array(
                    'handler'    => 'cb-deactivate-block-js',
                    'script'     => 'dist/blocks-deactivate.js',
                    'dependency' => array( 'wp-blocks' )
                )
            );

            self::enqueue( $scripts );
            $size = get_intermediate_image_sizes();
            $size[] = 'full';
            wp_localize_script( 'cb-editor-js', 'CB_VAR', array(
                'image_size' => $size
            ));

            wp_localize_script(
                'cb-deactivate-block-js',
                'CB_BLOCKS',
                array(
                    'status' => CB_Admin::block_action(),
                )
            );
        }
    }

}
new CB_Init();