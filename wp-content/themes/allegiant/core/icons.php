<?php

//Print HTML for an icon
//TODO: Icon value should be in the format 'fontawesome-\f001'
if ( ! function_exists( 'cpotheme_icon' ) ) {
	function cpotheme_icon( $value, $wrapper = '', $echo = true ) {
		if ( '0' === $value || 0 === $value || '' === $value ) {
			return;
		}

		if ( false === strpos( $value, '-' ) ) {
			$font_library = 'fontawesome';
			$font_value   = $value;
		} else {
			$icon_data    = explode( '-', $value );
			$font_library = $icon_data[0];
			$font_value   = $icon_data[1];
		}

		$output = '';
		if ( '' != $wrapper ) {
			$output .= '<div class="' . $wrapper . '">';
		}
		$output .= cpotheme_get_icon( $font_library, html_entity_decode( $font_value ) );
		if ( '' != $wrapper ) {
			$output .= '</div>';
		}

		if ( false == $echo ) {
			return $output;
		} else {
			echo $output;
		}
	}
}

//Retrieve the correct library
function cpotheme_get_icon( $library, $value ) {
	$result = '';
	switch ( $library ) {
		case 'fontawesome':
			$result = cpotheme_icon_library_fontawesome( $value );
			break;
		default:
			$result = cpotheme_icon_library_fontawesome( $value );
			break;
	}
	return $result;
}


//Icon library for fontawesome
function cpotheme_icon_library_fontawesome( $value ) {
	wp_enqueue_style( 'cpotheme-fontawesome' );
	return '<span style="font-family:\'fontawesome\'">' . $value . '</span>';
}
