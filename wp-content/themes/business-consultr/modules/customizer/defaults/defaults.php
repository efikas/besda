<?php
/**
* Generates default options for customizer.
*
* @since  Business Consultr 1.0.0
* @access public
* @param  array $options 
* @return array
*/
	
function business_consultr_default_options( $options ){

	$defaults = array(
		# Site identiry
		'site_title'         	         => esc_html__( 'Business Consultr', 'business-consultr' ),
		'site_title_color'   	         => '#10242b',
		'site_tagline'       	         => esc_html__( 'Consultant WP Theme', 'business-consultr' ),
		'site_tagline_color' 	         => '#4d4d4d',

		# Primary color
		'site_primary_color' 	         => '#e9563d',
		'site_secondary_color' 	         => '#67b930',
		'site_alternate_color' 	         => '#3db8db',

		# Slider
		'slider_control'     	         => true,
		'slider_timeout'     	         => 5,
		'slider_autoplay'    	         => false,
		'disable_slider_overlay'    	 => false,
		'disable_slider'    	         => false,

		# Service
		'disable_service_text_button'    => false,
		'disable_service'                => false,

		# Portfolio
		'disable_portfolio'              => false,

		# About
		'disable_about'                  => false,

		# Testimonial
		'disable_testimonial'            => false,

		# Service
		'disable_contact'                => false,

		# Blog
		'disable_blog'                   => false,
		'blog_title'                     => esc_html__( 'Recent Blog', 'business-consultr' ),
		'blog_number'                    => 3,
		'blog_category'                  => 1,

		# Callback
		'callback_title'                 => esc_html__( 'Complete Your Consultr Partner', 'business-consultr' ),
		'callback_button_text'           => esc_html__( 'Get a Quote', 'business-consultr' ),
		'callback_button_url'            => esc_html__( '#', 'business-consultr' ),
		'disable_callback'               => false,

		# Theme option
		# General
		'menu_padding_top'               => 0,
		'enable_scroll_top_in_mobile'    => false,

		'archive_layout'			     => 'right',
		'archive_post_layout'            => 'grid',
		'archive_post_image'             => 'default',
		'archive_post_image_alignment'   => 'center',
		# Header
		'top_header_address'             => esc_html__( '111 Rock Street, San Francisco', 'business-consultr' ),
		'top_header_email'               => esc_html__( 'yourmail@email.com', 'business-consultr' ),
		'top_header_phone'               => esc_html__( '1 (234) 567-891', 'business-consultr' ),
		'header_button'                  => esc_html__( 'Quick Quote', 'business-consultr' ),
		'header_button_link'             => esc_html__( '#', 'business-consultr' ),
		'disable_top_header'             => false,
		'disable_search_icon'            => false,
		'disable_header_button'          => false,
		'disable_fixed_header'           => false,
		# Blog
		'archive_page_title'			 => 'Blog',
		# Footer
		'disable_footer_widget'          => false,
		'footer_text'                    => business_consultr_get_footer_text(),
	);

	return array_merge( $options, $defaults );
}
add_filter( 'Businessconsultr_Customizer_defaults', 'business_consultr_default_options' );

if( !function_exists( 'business_consultr_get_footer_text' ) ):
/**
* Generate Default footer text
*
* @return string
* @since Business Consultr 1.0.0
*/
function business_consultr_get_footer_text(){
	$text = esc_html__( 'Business Consultr Theme by', 'business-consultr' ).' <a href="'.esc_url( '//keonthemes.com' ).'" target="_blank">';
	$text .= esc_html__( 'Keon Themes', 'business-consultr' ).'</a>';
	$text .= esc_html__( ' Copyright &copy; All Rights Reserved.', 'business-consultr' );
							
	return $text;
}
endif;