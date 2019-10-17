<?php
/**
* Common functions for blocks
*
* @since 1.0.0
*/
if ( ! class_exists( 'CB_Base' ) ) {
	abstract class CB_Base extends CB_Helper{
		/**
		* Prevent some functions to called many times
		* @access private
		* @since 1.0.0
		* @var integer
		*/
		private static $counter = 0;

	   /**
		* Store arrays of css and selectors
		*
		* @static
		* @access protected
		* @since 1.0.0
		*/
		protected static $styles = array();

	   /**
		* Store arrays of inline scripts
		*
		* @static
		* @access protected
		* @since 1.0.0
		*/
		protected static $scripts = array();

	   /**
		* Initialize Block
		*
		* @static
		* @access public
		* @since 1.0.0
		* @return null
		*/
		public function init(){

			$this->block_name = self::$block_list[ $this->block_name ];
			
			remove_filter( 'the_content', 'wpautop' );

			if( method_exists( $this, 'render' ) ){
				add_action( 'init', array( $this, 'register' ) );
			}

			if( method_exists( $this, 'enqueue_scripts_styles' ) ){
				add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts_styles' ) );
			}		

			if( method_exists( $this, 'block_assets' ) ){
				add_action( 'enqueue_block_assets', array( $this, 'block_assets' ) );
			}

			if( method_exists( $this, 'prepare_scripts_styles' ) ){
				add_action( 'wp_head', array( $this, 'prepare_scripts_styles' ), 10 );
			}

			if( self::$counter === 0 ){
				
				add_action( 'wp_head', array( __CLASS__, 'inline_scripts_styles' ), 99 );
				self::$counter++;
			}

		}

	   /**
		* Add styes to the array
		*
		* @static
		* @access protected
		* @since 1.0.0
		* @return null
		*/
		protected static function add_styles( $style ){
			self::$styles[] = $style;
		}   

		/**
		* Add styes to the array
		*
		* @static
		* @access protected
		* @since 1.0.0
		* @return null
		*/
		protected static function add_scripts( $scripts ){
			self::$scripts[] = $scripts;
		}

		/**
		* Print all the  styes scripts
		*
		* @static
		* @access public
		* @since 1.0.0
		* @return null
		*/
		public static function inline_scripts_styles(){

			if( count( self::$styles ) > 0 ):
			?>
			<style type="text/css" media="all" id="cb-block-styles">
				<?php 
					foreach( self::$styles as $style ){
						self::generate_css( $style[ 'css' ], $style[ 'attrs' ] );
					}
				?>
			</style>
			<?php 
			endif;
				
			if( count( self::$scripts ) > 0 ):
			?>
			<script>
				jQuery( document ).ready(function(){
					<?php 
						foreach( self::$scripts as $s ){
							echo $s;
						}
					?>
				});
			</script>
			<?php
			endif;
		}

	   /**
		* Register this Block
		*
		* @access public
		* @since 1.0.0
		* @return null
		*/
		public function register(){

			$param = array(
				'render_callback' => array( $this, 'render' ),
			);

			if( method_exists( $this, 'get_attrs' ) ){
				$param[ 'attributes' ] = $this->get_attrs();
			}
			
			register_block_type( $this->block_name, $param );

			if( method_exists( $this, 'register_meta' ) ){
				$this->register_meta();
			}
		}

	   /**
		* Enqueue Scripts in frontend after checking the existence of block in the content
		* Enqueues at backend regardless of condition
		* @access protected
		* @since 1.0.0
		* @return void
		*/
		protected function check_enqueue_block_assets( $scripts, $blocks = false ){

			$scripts = apply_filters( $this->block_name . '_block_assets', $scripts );

			if( !is_admin() ){

				if( !$blocks ){
					$id      = get_the_ID();
					$content = get_post_field( 'post_content', $id );
					$blocks  = parse_blocks( $content );
				}

				if( $blocks && count( $blocks ) > 0 ){
					foreach( $blocks as $block ){
						if( $this->block_name == $block[ 'blockName' ] ){
							$this->blocks[] = $block;
						}elseif( isset( $block[ 'innerBlocks' ] ) && count( $block[ 'innerBlocks' ] ) > 0 ){
							$this->check_enqueue_block_assets( $scripts, $block[ 'innerBlocks' ] );
						}
					}
				}
			}
			
			if( is_admin() || count( $this->blocks ) > 0 ){
				self::enqueue( $scripts );
			}
		}

		protected static function get_css_unit( $prop ){
			switch( $prop ){

				case 'font-size':
				case 'margin-top':
				case 'margin-bottom':
				case 'margin-left':
				case 'margin-right':
				case 'padding-top':
				case 'padding-bottom':
				case 'padding-left':
				case 'padding-right':
				case 'border-radius':
				case 'border-width':
				case 'height':
				case 'min-height':
					return 'px';
				default:
					return; 
			}
		}

		protected static function classnames( $cls ){
			foreach( $cls as $c ){
				echo $c .' ';
			}
		}

		protected static function generate_css( $dynamic_css, $attrs ){
			foreach( $dynamic_css as $css ){
				?>
				#<?php echo $attrs[ 'block_id' ].' '.$css[ 'selector' ]; ?>{
					<?php 
						foreach( $css[ 'props' ] as $prop => $setting ){
							$value = isset( $attrs[ $setting ] ) ? $attrs[ $setting ] : '';
							if( !empty( $value ) ){
								if( 'opacity' == $prop ){
									$value = $value/10;
								}
								echo $prop.': '.$value.self::get_css_unit( $prop ).';';
							}
						}	
					?>
				}
				<?php
			}
		}

		protected function get_attrs_with_default( $attrs ){

			$return = array();
			$def = array();
			if( method_exists( $this, 'get_attrs' ) ){
				$def = $this->get_attrs();
			}else{
				return $attrs;
			}
			
			foreach( $def as $key => $val ){

				if( isset( $attrs[ $key ] ) ){
					$return[ $key ] = $attrs[ $key ];
				}else{
					if( isset( $def[ $key ][ 'default' ] ) ){
						$return[ $key ] = $def[ $key ][ 'default' ];
					}else{
						$return[ $key ] = false;
					}
				}
			}

			return $return;
		}
	}
}