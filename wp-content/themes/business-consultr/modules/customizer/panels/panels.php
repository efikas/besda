<?php
/**
* Sets the panels and returns to Businessconsultr_Customizer
*
* @since  Business Consultr 1.0.0
* @param  array An array of the panels
* @return array
*/
function Businessconsultr_Customizer_panels( $panels ){

	$panels = array(
		'frontpage_options' => array(
			'title' => esc_html__( 'Front Page Options', 'business-consultr' )
		),
		'theme_options' => array(
			'title' => esc_html__( 'Theme Options', 'business-consultr' )
		)
	);

	return $panels;	
}
add_filter( 'Businessconsultr_Customizer_panels', 'Businessconsultr_Customizer_panels' );