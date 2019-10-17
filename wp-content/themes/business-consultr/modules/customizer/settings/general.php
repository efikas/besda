<?php
/**
* Sets settings for general fields
*
* @since  Business Consultr 1.0.0
* @param  array $settings
* @return array Merged array
*/

function Businessconsultr_Customizer_general_settings( $settings ){

	$general = array(
		'site_title_color' => array(
			'label'     => esc_html__( 'Site Title', 'business-consultr' ),
			'transport' => 'postMessage',
			'section'   => 'colors',
			'type'      => 'colors',
		),
		'site_tagline_color' => array(
			'label'     => esc_html__( 'Site Tagline', 'business-consultr' ),
			'transport' => 'postMessage',
			'section'   => 'colors',
			'type'      => 'colors',
		),
		'site_primary_color' => array(
			'label'     => esc_html__( 'Primary', 'business-consultr' ),
			'section'   => 'colors',
			'type'      => 'colors',
		),
		'site_secondary_color' => array(
			'label'     => esc_html__( 'Secondary', 'business-consultr' ),
			'section'   => 'colors',
			'type'      => 'colors',
		),
		'site_alternate_color' => array(
			'label'     => esc_html__( 'Alternate', 'business-consultr' ),
			'section'   => 'colors',
			'type'      => 'colors',
		),

		# Theme Options Section
		# Header
		'top_header_address' => array(
			'label'   => esc_html__( 'Address', 'business-consultr' ),
			'section' => 'header_options',
			'type'    => 'text',
		),
		'top_header_email' => array(
			'label'   => esc_html__( 'Email', 'business-consultr' ),
			'section' => 'header_options',
			'type'    => 'text',
		),
		'top_header_phone' => array(
			'label'   => esc_html__( 'Phone', 'business-consultr' ),
			'section' => 'header_options',
			'type'    => 'text',
		),
		'disable_top_header' => array(
			'label'     => esc_html__( 'Disable Top Header', 'business-consultr' ),
			'section'   => 'header_options',
			'transport' => 'postMessage',
			'type'      => 'checkbox',
		),
		'disable_search_icon' => array(
			'label'     => esc_html__( 'Disable Header Search Icon', 'business-consultr' ),
			'section'   => 'header_options',
			'type'      => 'checkbox',
		),
		'header_button' => array(
			'label'     => esc_html__( 'Header Button Text', 'business-consultr' ),
			'section'   => 'header_options',
			'transport' => 'postMessage',
			'type'      => 'text',
		),
		'header_button_link' => array(
			'label'     => esc_html__( 'Header Button Link', 'business-consultr' ),
			'section'   => 'header_options',
			'transport' => 'postMessage',
			'type'      => 'text',
		),
		'disable_header_button' => array(
			'label'   => esc_html__( 'Disable Header Button', 'business-consultr' ),
			'type'    => 'checkbox',
			'section' => 'header_options',
		),
		'disable_fixed_header' => array(
			'label'   => esc_html__( 'Disable Fixed Header', 'business-consultr' ),
			'type'    => 'checkbox',
			'section' => 'header_options',
		),
		# Layout
		'archive_layout' => array(
			'label'     => esc_html__( 'Archive Layout', 'business-consultr' ),
			'section'   => 'layout_options',
			'type'      => 'select',
			'choices'   => array(
				'left' => esc_html__( 'Left Sidebar', 'business-consultr' ),
				'right' => esc_html__( 'Right Sidebar', 'business-consultr' ),
				'none' => esc_html__( 'No Sidebar', 'business-consultr' ),
			),
		),
		'archive_post_layout' => array(
			'label'     => esc_html__( 'Archive Post Layout', 'business-consultr' ),
			'section'   => 'layout_options',
			'type'      => 'select',
			'choices'   => array(
				'grid' => esc_html__( 'Grid', 'business-consultr' ),
				'simple' => esc_html__( 'Simple', 'business-consultr' ),
			),
		),
		'archive_post_image' => array(
			'label'     => esc_html__( 'Archive Post Image', 'business-consultr' ),
			'section'   => 'layout_options',
			'type'      => 'select',
			'choices'   => array(
				'thumbnail' => esc_html__( 'Thumbnail (150x150)', 'business-consultr' ),
				'medium' => esc_html__( 'Medium (300x300)', 'business-consultr' ),
				'large' => esc_html__( 'Large (1024x1024)', 'business-consultr' ),
				'full' => esc_html__( 'Full (original)', 'business-consultr' ),
				'default' => esc_html__( 'Default (390x320)', 'business-consultr' ),
			),
		),
		'archive_post_image_alignment' => array(
			'label'     => esc_html__( 'Archive Post Image Alignment', 'business-consultr' ),
			'section'   => 'layout_options',
			'type'      => 'select',
			'choices'   => array(
				'left' => esc_html__( 'Left', 'business-consultr' ),
				'right' => esc_html__( 'Right', 'business-consultr' ),
				'center' => esc_html__( 'Center', 'business-consultr' ),
			),
		),
		# Blog
		'archive_page_title' => array(
			'label'   => esc_html__( 'Blog Page Title', 'business-consultr' ),
			'section' => 'blog_options',
			'type'    => 'text',
		),
		# Footer
		'enable_scroll_top_in_mobile' => array(
			'label'     => esc_html__( 'Enable Scroll top in mobile', 'business-consultr' ),
			'section'   => 'footer_options',
			'transport' => 'postMessage',
			'type'      => 'checkbox',
		),
		'disable_footer_widget' => array(
			'label'   => esc_html__( 'Disable Footer Widget', 'business-consultr' ),
			'section' => 'footer_options',
			'type'    => 'checkbox',
		),
		'footer_text' =>  array(
			'label'     => esc_html__( 'Footer Text', 'business-consultr' ),
			'section'   => 'footer_options',
			'type'      => 'textarea',
		)
	);

	return array_merge( $settings, $general );
}
add_filter( 'Businessconsultr_Customizer_fields', 'Businessconsultr_Customizer_general_settings' );