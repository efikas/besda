<?php
/**
* A helper class for plugin
*
* @since 1.0.0
*/
if ( ! class_exists( 'CB_Helper' ) ) {
	/**
	 * Class CB_Helper.
	 */
	class CB_Helper{

		public static $block_list = array(
			'accordion'        => 'creative-blocks/accordion',
			'heading'          => 'creative-blocks/heading',
			'callback'         => 'creative-blocks/callback',
			'divider'          => 'creative-blocks/divider',
			'icon-box'         => 'creative-blocks/icon-box',
			'post-masonry'     => 'creative-blocks/post-masonry',
			'post-slider'      => 'creative-blocks/post-slider',
			'profile-box'      => 'creative-blocks/profile-box',
			'section'          => 'creative-blocks/section',
			'column'           => 'creative-blocks/column',
			'spacer'           => 'creative-blocks/spacer',
		);

		/**
		 * Default length for excerpt
		 *
		 * @since 1.0.0
		 */
		public static $excerpt_length = 60;

		/**
		 * Include given files
		 *
		 * @since 1.0.0
		 */
		public static function includes( $name, $dir="classes", $prefix="class" ){

			$prefix = empty( $prefix ) ? '' : $prefix . '-';
			
			$path = untrailingslashit( dirname( CB_FILE ) ) . '/' . $dir . '/' . $prefix;
			if( is_array( $name ) ){
				foreach( $name as $file ){
					require_once $path . $file . '.php';
				}
			}else{
				require_once $path . $name . '.php';
			}
		}

		/**
		* get array of category
		*
		* @access public
		* @since 1.0.0
		* @return string
		*/
		public static function make_category_arr( $_cat ){
			$cat = false;
			if( $_cat ){
				$cat = array(
					'name' => $_cat->name,
					'link' => get_category_link( $_cat->term_id )
				);
			}

			return $cat;
		}

		/**
		* Provides the last change time as a Unix timestamp on success, 
		* FALSE on failure for given file name.
		*
		* @uses filemtime()
		* @see https://www.w3schools.com/php/func_filesystem_filemtime.asp
		* @param string | Name of a file from assets directory { $file_name }
		* @return string | bool Whether the plugin is in production mode. True on success.
		* @since Creative Blocks 1.0.0
		*/

		public static function get_rand_asssets_file_version( $file_name = false ){

		    $version = false;
		    if( $file_name && 'development' === CB_MODE ){ 
		        $version = time();
		    }

		    return $version;
		}

		public static function get_plugin_directory_uri(){
			return plugins_url( '/', CB_FILE );
		}

		public static function enqueue( $scripts ){

		    # Do not enqueue anything if no array is supplied.
		    if( ! is_array( $scripts ) ) return;

		    $scripts = apply_filters( 'cb_block_scripts' , $scripts );

		    foreach ( $scripts as $script ) {

		        # Do not try to enqueue anything if handler is not supplied.
		        if( ! isset( $script[ 'handler' ] ) )
		            continue;

		        $version = null;
		        if( isset( $script[ 'version' ] ) ){
		            $version = $script[ 'version' ];
		        }

		        # Enqueue each vendor's style
		        if( isset( $script[ 'style' ] ) ){
		            
		            $path = self::get_plugin_directory_uri() .  $script[ 'style' ];
		            if( isset( $script[ 'absolute' ] ) ){
		                $path = $script[ 'style' ];
		            }

		            $dependency = array();
		            if( isset( $script[ 'dependency' ] ) ){
		                $dependency = $script[ 'dependency' ];
		            }
		            wp_enqueue_style( $script[ 'handler' ], $path, $dependency, $version );
		        }

		        # Enqueue each vendor's script
		        if( isset( $script[ 'script' ] ) ){

		        	if( $script[ 'script' ] === true || $script[ 'script' ] === 1 ){
		        		wp_enqueue_script( $script[ 'handler' ] );
		        	}else{

			            $prefix = '';
			            if( isset( $script[ 'prefix' ] ) ){
			                $prefix = $script[ 'prefix' ];
			            }

			        	$path = '';
			        	if( isset( $script[ 'script' ] ) ){
			            	$path = self::get_plugin_directory_uri() .  $script[ 'script' ];
			        	}

			            if( isset( $script[ 'absolute' ] ) ){
			                $path = $script[ 'script' ];
			            }

			            $dependency = array( 'jquery' );
			            if( isset( $script[ 'dependency' ] ) ){
			                $dependency = $script[ 'dependency' ];
			            }


			            $in_footer = true;

			            if( isset( $script[ 'in_footer' ] ) ){
			            	$in_footer = $script[ 'in_footer' ];
			            }

			            wp_enqueue_script( $prefix . $script[ 'handler' ], $path, $dependency, $version, $in_footer );
		        	}
		        }
		    }
		}

		public static function get_date_link(){
			return get_day_link( get_the_time('Y'), get_the_time('m'), get_the_time('d') );
		}

		public static function the_date(){
			?>
			<a href="<?php echo esc_url( self::get_date_link() ); ?>" target="_blank">
				<?php echo get_the_date(); ?>
			</a><?php
		}

		public static function get_total_comment( $object ) {
		    // Get the comments link.
		    $id = is_array( $object )? $object[ 'id' ] : $object;
		    $comments_count = wp_count_comments( $object['id'] );
		    return $comments_count->total_comments;
		}

		/**
		 * Returns an option from the database for
		 * the admin settings page.
		 *
		 * @param  string  $key     The option key.
		 * @param  mixed   $default Option default value if option is not available.
		 * @param  boolean $network_override Whether to allow the network admin setting to be overridden on subsites.
		 * @return string           Return the option value
		 */
		public static function get_option( $key, $default = false, $network_override = false ) {

			// Get the site-wide option if we're in the network admin.
			if ( $network_override && is_multisite() ) {
				$value = get_site_option( $key, $default );
			} else {
				$value = get_option( $key, $default );
			}

			return $value;
		}

		/**
		 * Updates an option from the admin settings page.
		 *
		 * @param string $key       The option key.
		 * @param mixed  $value     The value to update.
		 * @param bool   $network   Whether to allow the network admin setting to be overridden on subsites.
		 * @return mixed
		 */
		public static function update_option( $key, $value, $network = false ) {

			// Update the site-wide option since we're in the network admin.
			if ( $network && is_multisite() ) {
				update_site_option( $key, $value );
			} else {
				update_option( $key, $value );
			}
		}

		public static function get_categories( $object ){
			$id = is_array( $object )? $object[ 'id' ] : $object;
			return get_the_category( $id );
		}

		public static function excerpt_length( $length ){
			return self::$excerpt_length;
		}

		public static function excerpt( $length, $echo= true, $post = null ){

			if( $length ){
				self::$excerpt_length = $length;
			}

			add_filter( 'excerpt_length', array( __CLASS__, 'excerpt_length' ) );

			$excerpt = get_the_excerpt( $post );
			if( $echo ){ echo $excerpt; }

			remove_filter( 'excerpt_length', array( __CLASS__, 'excerpt_length' ) );

			if( !$echo ){ return $excerpt; }
		}

		public static function get_excerpt( $object ){
			$id = is_array( $object ) ? $object[ 'id' ] : $object;
			return self::excerpt( false, false, $id );
		}
	}
}