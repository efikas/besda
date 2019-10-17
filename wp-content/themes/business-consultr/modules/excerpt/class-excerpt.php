<?php
/**
* Business Consultr: Excerpt
*
* @since Business Consultr: 0.1
*/
if( ! class_exists( 'Businessconsultr_Excerpt' ) ):

class Businessconsultr_Excerpt{

    /**
    * Default length (by WordPress)
    *
    * @since Business Consultr 1.0.0
    * @access public
    * @var int
    */
    public $length = 55;

    /**
    * Read more Text for excerpt
    * @since Business Consultr 1.0.0
    * @access public
    * @var string
    */
    public $more_text = '';

    /**
    * So you can call: business_consultr_excerpt( 'short' );
    *
    * @since  Business Consultr 1.0.0
    * @access protected
    * @var    array
    */
    protected $types = array(
        'short'   => 25,
        'regular' => 55,
        'long'    => 100
    );

    /**
    * Stores class instance
    * 
    * @since  Business Consultr 1.0.0
    * @access protected
    * @var    object
    */
    protected static $instance = NULL;

    /**
    * Retrives the instance of this class
    * 
    * @since  Business Consultr 1.0.0
    * @access public
    * @return object
    */
    public static function get_instance() {

        if ( ! self::$instance ) {
          self::$instance = new self();
        }

        return self::$instance;
    }

    /**
    * Sets the length for the excerpt,then it adds the WP filter
    * And automatically calls the_excerpt();
    *
    * @since Business Consultr 1.0.0
    * @param string $new_length 
    * @access public
    * @return void
    */
    public function excerpt( $new_length = 55, $echo, $more_text ) {

        $this->length    = $new_length;
        $this->more_text = $more_text;
        if(!is_admin()):
            add_filter( 'excerpt_more', array( $this, 'new_excerpt_more' ) );
            add_filter( 'excerpt_length', array( $this, 'new_length' ) );
        endif;

        if( $echo )
          the_excerpt();
        else
          return get_the_excerpt();
    }

    public function new_excerpt_more(){
        return $this->more_text;
    }

    /** 
    * Tells WP the new length
    *
    * @since Business Consultr 1.0.0
    * @access public
    * @return int
    */
    public function new_length() {

        if( isset( $this->types[ $this->length ] ) )
          return $this->types[ $this->length ];
        else
          return $this->length;
    }
}

endif;

/**
* Call to Businessconsultr_Excerpt
*
* @since  1.0.0
* @uses   Businessconsultr_Excerpt:::get_instance()->excerpt()
* @param  int $length
* @return void
*/
if( ! function_exists( 'business_consultr_excerpt' ) ):

    function business_consultr_excerpt( $length = 55, $echo = true, $more = '' ) {
        $length = apply_filters( 'business_consultr_excerpt_length', $length );
        return Businessconsultr_Excerpt::get_instance()->excerpt( $length, $echo, $more );
    }
endif;