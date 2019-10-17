<?php
/**
* Business Consultr breadcrumb.
*
* @since Business Consultr 1.0.0
* @uses breadcrumb_trail()
*/
require get_parent_theme_file_path( '/modules/breadcrumbs/breadcrumbs.php' );
if ( ! function_exists( 'business_consultr_breadcrumb' ) ) :

	function business_consultr_breadcrumb() {

		$breadcrumb_args = apply_filters( 'business_consultr_breadcrumb_args', array(
			'show_browse' => false,
		) );

		breadcrumb_trail( $breadcrumb_args );
	}

endif;

function business_consultr_modify_breadcrumb( $crumb ){

	$i = count( $crumb ) - 1;
	$title = business_consultr_remove_pipe( $crumb[ $i ] );

	$crumb[ $i ] = $title;

	return $crumb;
}
add_filter( 'breadcrumb_trail_items', 'business_consultr_modify_breadcrumb' );