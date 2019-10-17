<?php
/**
* Do things related with Profile Box Block
*
* @since 1.0.0
*/

if ( ! class_exists( 'CB_Section_Column' ) ) {
	class CB_Section_Column extends CB_Base{

		/**
		* Name of the block.
		*
		* @access protected
		* @since 1.0.0
		* @var string
		*/
		protected $block_name = 'column';

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
		* @access private
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

		public function getInitialWidth( $column ){
			switch( $column ){
				case '100':
					return array( 100 );
				case '50-50':
					return array( 50, 50 );
				case '33-33-33':
					return array( 33.33, 33.33, 33.33 );
				case '25-25-25-25':
					return array( 25, 25, 25, 25 );
				case '30-70':
					return array( 30, 70 );
				case '70-30':
					return array( 70, 30 );
			}
		}

	   /**
		* Renders blocks in frontend
		*
		* @access public
		* @since 1.0.0
		* @return string
		*/
		public function render( $attrs, $content ){
			if(  isset( $attrs[ 'width' ] ) ){
				$w = $attrs[ 'width' ];
			}else{
				$w = $this->getInitialWidth( $attrs[ 'column' ] )[ $attrs[ 'index' ] ];
			}
		    return sprintf( '<div class="cb-col" style="width:%s">%s</div>', esc_attr( $w ) . '%', $content );
		}
	}
}
CB_Section_Column::get_instance()->init();