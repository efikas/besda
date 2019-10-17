<?php
/**
* Do things related with Accordion Block
*
* @since 1.0.0
*/
if ( ! class_exists( 'CB_Accordion' ) ) {
	class CB_Accordion extends CB_Base{

		/**
		* Name of the block.
		*
		* @access protected
		* @since 1.0.0
		* @var string
		*/
		protected $block_name = 'accordion';

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
		* Enqueue Common Scripts and Styles
		* Called in enqueue_block_assets hook
		* Fires in frontend and backend
		* @access public
		* @since 1.0.0
		* @return null
		*/
		public function block_assets(){

			$scripts = array(
				array(
					'handler' => 'jquery-ui-core',
					'script' => true,
				),
				array(
					'handler' => 'jquery-ui-accordion',
					'script' => true,
				)
			);	
			
			$this->check_enqueue_block_assets( $scripts );
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
				$blocks = $this->blocks;
			}

			foreach( $blocks as $block ){

				$attrs = $block[ 'attrs' ];

					ob_start();
					?>

					var icons = {
					    header: "fas fa-plus",
					    activeHeader: "fas fa-minus"
					};

					<?php
						if( isset( $attrs[ 'expand' ] ) ){
							?>
							icons.header = '<?php echo esc_attr( $attrs[ 'expand' ][ 'icon' ] ); ?>';
							<?php
						}
					?>

					<?php
						if( isset( $attrs[ 'minus' ] ) ){
							?>
							icons.activeHeader = '<?php echo esc_attr( $attrs[ 'minus' ][ 'icon' ] ); ?>';
							<?php
						}
					?>
					jQuery( window ).load( function(){
						jQuery( "#<?php echo esc_attr( $attrs[ 'block_id' ] ); ?>.wp-block-creative-blocks-accordion" ).accordion({
						    active: false,
						    icons: icons,
						    collapsible: true,
						    heightStyle: "content",
						    header: 'div.cb-accordion__item > .cb-accordion__card > .cb-accordion__header',
						    activate: function( e, ui ) {
						    	jQuery( ui.newPanel ).find( '.cb-accordion-nicescroll' ).niceScroll();
							}
						});
					});
					<?php
					$js =  ob_get_clean();
					self::add_scripts( $js );
			}
		}
	}
}
CB_Accordion::get_instance()->init();