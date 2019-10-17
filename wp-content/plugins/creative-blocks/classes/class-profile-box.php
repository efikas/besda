<?php
/**
* Do things related with Profile Box Block
*
* @since 1.0.0
*/

if ( ! class_exists( 'CB_Profile_Box' ) ) {
	class CB_Profile_Box extends CB_Base{

		/**
		* Name of the block.
		*
		* @access protected
		* @since 1.0.0
		* @var string
		*/
		protected $block_name = 'profile-box';

		/**
		* To store Array of this blocks
		*
		* @access protected
		* @since 1.0.0
		* @var array
		*/
		protected $blocks = array();

		/**
		* The object instance.
		*
		* @static
		* @access protected
		* @since 1.0.0
		* @var object
		*/
		private static $instance;

	   /**
		* Gets an instance of this object.
		* Prevents duplicate instances which avoid artefacts and improves performance.
		*
		* @static
		* @access public
		* @since 1.0.0
		* @return object
		*/
		public static function get_instance() {
			if ( ! self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

	   /**
		* Generate & Print Frontend Styles
		* Called in wp_head hook
		* @access public
		* @since 1.0.0
		* @return null
		*/
		public function prepare_scripts_styles( $blocks = false ){ 
			
			if( !$blocks ){
				$id = get_the_ID();
				$content = get_post_field( 'post_content', $id );
				$blocks = parse_blocks( $content );
			}

			if( !is_admin() && $blocks && count( $blocks ) > 0 ){
				
				foreach( $blocks as $block ){

					if( $this->block_name == $block[ 'blockName' ] ){
										
						$attrs = $this->get_attrs_with_default( $block[ 'attrs' ] );

						$dynamic_css = array(
							array(
								'selector' => '.cb-profile__social-icon a span',
								'props' => array(
									'color' => 'socialColor',
								)
							),
							array(
								'selector' => '.cb-profile__social-icon a span:hover',
								'props' => array(
									'color' => 'socialLinkHoverColor',
								)
							),
						);

						if( $attrs[ 'socialIconType' ] == 'backgroundColor' ){
							$dynamic_css[] = array(
								'selector' => '.cb-profile__social-icon a span',
								'props' => array(
									'background' => 'socialLinkBgColor',
								)
							);

							$dynamic_css[] = array(
								'selector' => '.cb-profile__social-icon a span:hover',
								'props' => array(
									'background' => 'socialLinkBgHoverColor',
								)
							);
						}

						if( $attrs[ 'socialIconType' ] == 'border' ){
							$dynamic_css[] = array(
								'selector' => '.cb-profile__social-icon a span',
								'props' => array(
									'border-color' => 'socialLinkBorderColor',
								)
							);

							$dynamic_css[] = array(
								'selector' => '.cb-profile__social-icon a span:hover',
								'props' => array(
									'border-color' => 'socialLinkBorderHoverColor',
								)
							);
						}

						self::add_styles( array(
							'attrs' => $attrs,
							'css'   => $dynamic_css,
						));
						
					}elseif( isset( $block[ 'innerBlocks' ] ) && count( $block[ 'innerBlocks' ] ) > 0 ){
						$this->prepare_scripts_styles( $block[ 'innerBlocks'] );
					} 
				}
			}
		}

		public function get_attrs(){
			return array(
				'block_id' => array(
					'type' => 'string'
				),
				'socialIconType' => array(
					'type' => 'string',
					'default' => 'color'
				),
				'socialColor' => array(
					'type' => 'string'
				),
				'socialLinkHoverColor' => array(
					'type' => 'string'
				),
				'socialLinkBgColor' => array(
					'type' => 'string'
				),
				'socialLinkBgHoverColor' => array(
					'type' => 'string'
				),
				'socialLinkBorderColor' => array(
					'type' => 'string'
				),			
				'socialLinkBorderHoverColor' => array(
					'type' => 'string'
				),
			);
		}
	}
}
CB_Profile_Box::get_instance()->init();