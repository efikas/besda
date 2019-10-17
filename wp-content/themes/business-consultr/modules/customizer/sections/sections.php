<?php
/**
* Sets sections for Businessconsultr_Customizer
*
* @since  Business Consultr 1.0.0
* @param  array $sections
* @return array Merged array
*/
function Businessconsultr_Customizer_sections( $sections ){

	$business_consultr_sections = array(
		
		# Section for Fronpage panel
		'slider' => array(
			'title' => esc_html__( 'Slider', 'business-consultr' ),
			'panel' => 'frontpage_options'
		),
		'home_service' => array(
			'title' => esc_html__( 'Service', 'business-consultr' ),
			'panel' => 'frontpage_options'
		),
		'home_about' => array(
			'title' => esc_html__( 'About', 'business-consultr' ),
			'panel' => 'frontpage_options'
		),
		'home_portfolio' => array(
			'title' => esc_html__( 'Portfolio', 'business-consultr' ),
			'panel' => 'frontpage_options'
		),
		'home_callback' => array(
			'title' => esc_html__( 'Callback', 'business-consultr' ),
			'panel' => 'frontpage_options'
		),
		'home_testimonial' => array(
			'title' => esc_html__( 'Testimonial', 'business-consultr' ),
			'panel' => 'frontpage_options'
		),
		'home_blog' => array(
			'title' => esc_html__( 'Blog', 'business-consultr' ),
			'panel' => 'frontpage_options'
		),
		'home_contact' => array(
			'title' => esc_html__( 'Contact', 'business-consultr' ),
			'panel' => 'frontpage_options'
		),

		# Section for Theme Options panel
		'header_options' => array(
			'title' => esc_html__( 'Header Options', 'business-consultr' ),
			'panel' => 'theme_options'
		),
		'layout_options' => array(
			'title' => esc_html__( 'Layout Options', 'business-consultr' ),
			'panel' => 'theme_options'
		),
		'blog_options' => array(
			'title' => esc_html__( 'Blog Options', 'business-consultr' ),
			'panel' => 'theme_options'
		),
		'footer_options' => array(
			'title' => esc_html__( 'Footer Options', 'business-consultr' ),
			'panel' => 'theme_options'
		)
	);

	return array_merge( $business_consultr_sections, $sections );
}
add_filter( 'Businessconsultr_Customizer_sections', 'Businessconsultr_Customizer_sections' );