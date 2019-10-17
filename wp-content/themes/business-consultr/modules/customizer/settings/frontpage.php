<?php
/**
* Sets setting field for homepage
* 
* @since  Business Consultr 1.0.0
* @param  array $settings
* @return array Merged array of settings
*
*/
function business_consultr_frontpage_settings( $settings ){

	$home_settings = array(
		# Settings for slider
		'slider_page' => array(
			'label'       => esc_html__( 'Slider Page', 'business-consultr' ),
			'section'     => 'slider',
			'type'        => 'text',
			'description' => esc_html__( 'Input page id. Separate with comma. for eg. 2,9,23. Supports Maximum 3 sliders.', 'business-consultr' )
		),
		'slider_control' => array(
			'label'     => esc_html__( 'Show Slider Control', 'business-consultr' ),
			'section'   => 'slider',
			'type'      => 'checkbox',
			'transport' => 'postMessage',
		),
		'slider_autoplay' => array(
			'label'   => esc_html__( 'Slider Auto Play', 'business-consultr' ),
			'section' => 'slider',
			'type'    => 'checkbox'
		),
		'slider_timeout' => array(
			'label'    => esc_html__( 'Slider Timeout ( in sec )', 'business-consultr' ),
			'section'  => 'slider',
			'type'     => 'number'
		),
		'disable_slider_overlay' => array(
			'label'   => esc_html__( 'Disable Banner Overlay', 'business-consultr' ),
			'section' => 'slider',
			'type'    => 'checkbox',
		),
		'disable_slider' => array(
			'label'   => esc_html__( 'Disable Slider Section', 'business-consultr' ),
			'section' => 'slider',
			'type'    => 'checkbox',
		),
		# Settings for service section
		'service_page' => array(
			'label'   => esc_html__( 'Service Page', 'business-consultr' ),
			'section' => 'home_service',
			'type'    => 'text',
			'description' => esc_html__( 'Input page id. Separate with comma. for eg. 2,9,23', 'business-consultr' )
		),
		'disable_service_text_button' => array(
			'label'   => esc_html__( 'Disable Text and Button from Item', 'business-consultr' ),
			'section' => 'home_service',
			'type'    => 'checkbox', 
		),
		'disable_service' => array(
			'label'   => esc_html__( 'Disable Service Section', 'business-consultr' ),
			'section' => 'home_service',
			'type'    => 'checkbox',
		),

		# Settings for about page
		'about_page' => array(
			'label'   => esc_html__( 'Select Title page for About', 'business-consultr' ),
			'section' => 'home_about',
			'type'    => 'dropdown-pages',
		),
		'disable_about' => array(
			'label'   => esc_html__( 'Disable About Us Section', 'business-consultr' ),
			'section' => 'home_about',
			'type'    => 'checkbox',
		),

		# Settings for portfolio section
		'portfolio_main_page' => array(
			'label'   => esc_html__( 'Select Title Page for Portfolio', 'business-consultr' ),
			'section' => 'home_portfolio',
			'type'    => 'dropdown-pages',
		),

		'portfolio_page' => array(
			'label'   => esc_html__( 'Portfolio Page', 'business-consultr' ),
			'section' => 'home_portfolio',
			'type'    => 'text',
			'description' => esc_html__( 'Input page id. Separate with comma. for eg. 2,9,23', 'business-consultr' )
		),
		'disable_portfolio' => array(
			'label'   => esc_html__( 'Disable Portfolio Section', 'business-consultr' ),
			'section' => 'home_portfolio',
			'type'    => 'checkbox',
		),
		
		# Settings for callback section
		'callback_image' => array(
			'label'   => esc_html__( 'Background Image', 'business-consultr' ),
			'section' => 'home_callback',
			'type'    => 'image',
		),
		'callback_title' => array(
			'label'   => esc_html__( 'Title', 'business-consultr' ),
			'section' => 'home_callback',
			'type'    => 'text',
		),
		'callback_button_text' => array(
			'label'   => esc_html__( 'Button Text', 'business-consultr' ),
			'section' => 'home_callback',
			'type'    => 'text',
		),
		'callback_button_url' => array(
			'label'   => esc_html__( 'Button URL', 'business-consultr' ),
			'section' => 'home_callback',
			'type'    => 'text',
		),
		'disable_callback' => array(
			'label'   => esc_html__( 'Disable Callback Section', 'business-consultr' ),
			'section' => 'home_callback',
			'type'    => 'checkbox',
		),
		
		# Settings for Testimonials
		'testimonial_main_page' => array(
			'label'   => esc_html__( 'Select Title page for Testimonial', 'business-consultr' ),
			'section' => 'home_testimonial',
			'type'    => 'dropdown-pages',
		),
		'testimonial_page' => array(
			'label'   => esc_html__( 'Testimonial Pages', 'business-consultr' ),
			'section' => 'home_testimonial',
			'type'    => 'text',
			'description' => esc_html__( 'Input page id. Separate with comma. for eg. 2,9,23', 'business-consultr' )
		),
		'disable_testimonial' => array(
			'label'   => esc_html__( 'Disable Testimonial Section', 'business-consultr' ),
			'section' => 'home_testimonial',
			'type'    => 'checkbox',
		),

		# Settings for Blog section
		'blog_main_page' => array(
			'label'   => esc_html__( 'Select Title page for Blog', 'business-consultr' ),
			'section' => 'home_blog',
			'type'    => 'dropdown-pages',
		),
		'blog_category' => array(
			'label'   => esc_html__( 'Choose Blog Category', 'business-consultr' ),
			'section' => 'home_blog',
			'type'    => 'dropdown-categories',
		),
		'blog_number' => array(
			'label' => esc_html__( 'Number of Posts', 'business-consultr' ),
			'section' => 'home_blog',
			'type'    => 'number',
			'input_attrs' => array(
				'max' => 3,
				'min' => 1
			)
		),
		'disable_blog' => array(
			'label'   => esc_html__( 'Disable Blog Section', 'business-consultr' ),
			'section' => 'home_blog',
			'type'    => 'checkbox',
		),

		# Settings for contact section
		'contact_main_page' => array(
			'label'   => esc_html__( 'Select Title Page for Cotact', 'business-consultr' ),
			'section' => 'home_contact',
			'type'    => 'dropdown-pages',
		),
		'contact_shortcode' => array(
			'label'   => esc_html__( 'Shortcode', 'business-consultr' ),
			'section' => 'home_contact',
			'description' => esc_html__( 'Add a Contact Form 7 Shortcode.', 'business-consultr' ),
			'type'    => 'text',
		),
		'disable_contact' => array(
			'label'   => esc_html__( 'Disable Contact Section', 'business-consultr' ),
			'section' => 'home_contact',
			'type'    => 'checkbox',
		),
		
	);

	return array_merge( $home_settings, $settings );
}
add_filter( 'Businessconsultr_Customizer_fields', 'business_consultr_frontpage_settings' );