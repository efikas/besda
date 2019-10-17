<?php
/**
* Do things related with Callback Block
*
* @since 1.0.0
*/
if ( ! class_exists( 'CB_Callback' ) ) {
	class CB_Callback extends CB_Base{

		/**
		* Name of the block.
		*
		* @access protected
		* @since 1.0.0
		* @var string
		*/
		protected $block_name = 'callback';

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
								'selector' => '.cb-callback__block-btn-1',
								'props' => array(
									'background-color' => 'btn1BgColor',
									'color'         => 'btn1TextColor',
									'border-radius' => 'btn1Radius',
									'border-width'  => 'btn1BorderWidth',
									'border-color'  => 'btn1BorderColor',
								)
							),
							array(
								'selector' => '.cb-callback__block-btn-1:hover',
								'props' => array(
									'background'    => 'btn1BgHoverColor',
									'color'         => 'btn1TextHoverColor',
									'border-color'  => 'btn1HoverBorderColor',
								)
							),
							array(
								'selector' => '.cb-callback__block-btn-2',
								'props' => array(
									'background-color' => 'btn2BgColor',
									'color'         => 'btn2TextColor',
									'border-radius' => 'btn2Radius',
									'border-width'  => 'btn2BorderWidth',
									'border-color'  => 'btn2BorderColor',
								)
							),
							array(
								'selector' => '.cb-callback__block-btn-2:hover',
								'props' => array(
									'background'    => 'btn2BgHoverColor',
									'color'         => 'btn2TextHoverColor',
									'border-color'  => 'btn2HoverBorderColor',
								)
							),
						
						);

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
	}
}

CB_Callback::get_instance()->init();