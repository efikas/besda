<?php
/**
* Loads all the components related to customizer 
*
* @since Business Consultr 1.0.0
*/
require get_parent_theme_file_path( '/modules/customizer/framework/customizer.php' );
require get_parent_theme_file_path( '/modules/customizer/panels/panels.php' );
require get_parent_theme_file_path( '/modules/customizer/sections/sections.php' );

require get_parent_theme_file_path( '/modules/customizer/settings/general.php' );
require get_parent_theme_file_path( '/modules/customizer/settings/frontpage.php' );
require get_parent_theme_file_path( '/modules/customizer/defaults/defaults.php' );


function business_consultr_modify_default_settings( $wp_customize ){

	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	$wp_customize->get_setting( 'background_color' )->transport = 'postMessage';
	$wp_customize->get_control( 'background_color' )->label = esc_html__( 'Background', 'business-consultr' );
}
add_action( 'business_consultr_customize_register', 'business_consultr_modify_default_settings' );

function business_consultr_default_styles(){
	
	$site_title_color           = business_consultr_get_option( 'site_title_color' );
	$site_tagline_color         = business_consultr_get_option( 'site_tagline_color' );
	$primary_color              = business_consultr_get_option( 'site_primary_color' );
	$secondary_color            = business_consultr_get_option( 'site_secondary_color' );
	$alternate_color            = business_consultr_get_option( 'site_alternate_color' );

	$slider_control             = business_consultr_get_option( 'slider_control' );
	$menu_padding_top           = business_consultr_get_option( 'menu_padding_top' );
	$menu_padding_top           = business_consultr_get_option( 'menu_padding_top' );

	$callback_bg                = business_consultr_get_callback_banner_url();
	?>
	<style type="text/css">
		.offcanvas-menu-open .kt-offcanvas-overlay {
		    position: fixed;
		    width: 100%;
		    height: 100%;
		    background: rgba(0, 0, 0, 0.7);
		    opacity: 1;
		    z-index: 9;
		    top: 0px;
		}

		.kt-offcanvas-overlay {
		    width: 0;
		    height: 0;
		    opacity: 0;
		    transition: opacity 0.5s;
		}
		
		#primary-nav-container{
			padding-top: <?php echo esc_attr( $menu_padding_top ) . 'px'; ?>;
		}

		.masonry-grid.wrap-post-list {
			width: 100% !important;
		}

		<?php if( business_consultr_get_option( 'disable_slider_overlay' ) ): ?>
			.block-slider .banner-overlay {
			    background-color: transparent;
			}
		<?php endif; ?>

		<?php if( !business_consultr_get_option( 'disable_service' ) ): ?>
			@media screen and (min-width: 992px){
				body.home.page .wrap-inner-banner .page-header {
				    margin-bottom: calc(10% + 150px);
				}
			}
		<?php endif; ?>

		<?php if( !$slider_control ): ?>
			.block-slider .controls, .block-slider .owl-pager{
				opacity: 0;
			}
		<?php endif; ?>

		<?php if( business_consultr_get_option( 'disable_fixed_header' ) ): ?>
			.site-header {
				position: relative;
				top: 0 !important;
			}
			.block-slider{
				margin-top: 0 !important;
			}
			.wrap-inner-banner{
				margin-top: 0 !important;
			}
		<?php endif; ?>

		<?php if( business_consultr_get_option( 'disable_service_text_button' )):?>
			.block-service .icon-block-outer {
				margin-top: -210px;
			}
			
			@media screen and (max-width: 991px){
				.block-service .icon-block-outer {
				    margin-top: 30px;
				}
			}
		<?php endif; ?>

		.block-callback {
		   background-image: url(<?php echo esc_url( $callback_bg ); ?> );
		 }

		/*======================================*/
		/* Site title */
		/*======================================*/
		.site-header .site-branding .site-title,
		.site-header .site-branding .site-title a {
			color: <?php echo esc_attr( $site_title_color ); ?>;
		} 

		/*======================================*/
		/* Tagline title */
		/*======================================*/
		.site-header .site-branding .site-description {
			color: <?php echo esc_attr( $site_tagline_color ); ?>;
		}

		/*======================================*/
		/* Primary color */
		/*======================================*/

		/*======================================*/
		/* Background Primary color */
		/*======================================*/
		.icon-block-outer:hover,
		.icon-block-outer:focus,
		.icon-block-outer:active,
		#go-top span:hover, #go-top span:focus, #go-top span:active, .page-numbers.current,
		.sub-title:before {
			background-color: <?php echo esc_attr( $primary_color ); ?>
		}

		/*======================================*/
		/* Primary border color */
		/*======================================*/
		.block-portfolio.block-grid .post-content:hover .post-content-inner, .block-portfolio.block-grid .post-content:focus .post-content-inner, .block-portfolio.block-grid .post-content:active .post-content-inner,
		#go-top span:hover, #go-top span:focus, #go-top span:active,
		.main-navigation ul ul, .page-numbers.current {
			border-color: <?php echo esc_attr( $primary_color ); ?>
		}

		/*======================================*/
		/* Primary text color */
		/*======================================*/

		.icon-block-outer .icon-outer span,
		.icon-block-outer .icon-content-area .button-container .button-text,
		.icon-block-outer .icon-content-area .button-container .button-text:before,
		.block-testimonial .slide-item article.post-content .post-content-inner .post-title cite span  {
			color: <?php echo esc_attr( $primary_color ); ?>
		}

		/*======================================*/
		/* Secondary color */
		/*======================================*/

		/*======================================*/
		/* Secondary background color */
		/*======================================*/
		.button-primary, .block-contact .contact-form-section input[type="submit"], .block-contact .kt-contact-form-area .form-group input.form-control[type="submit"], .block-grid .post-content .post-content-inner span.cat a, .block-grid .post-content .post-content-inner .button-container .post-footer-detail .post-format-outer > span a {
			background-color: <?php echo esc_attr( $secondary_color ); ?>
		}

		/*======================================*/
		/* Secondary border color */
		/*======================================*/
		.button-primary, .block-contact .contact-form-section input[type="submit"], .block-contact .kt-contact-form-area .form-group input.form-control[type="submit"] {
			border-color: <?php echo esc_attr( $secondary_color ); ?>
		}

		/*======================================*/
		/* Alternate color */
		/*======================================*/

		/*======================================*/
		/* Alternate border color */
		/*======================================*/
		.block-portfolio.block-grid .post-content .post-content-inner {
			border-color: <?php echo esc_attr( $alternate_color ); ?>
		}

	</style>
	<?php
}
add_action( 'wp_head', 'business_consultr_default_styles' );

/**
* Load customizer preview js file
*/
function business_consultr_customize_preview_js() {
	wp_enqueue_script( 'business-consultr-customize-preview', get_theme_file_uri( '/assets/js/customizer/customize-preview.js' ), array( 'jquery', 'customize-preview'), '1.0', true );
}
add_action( 'customize_preview_init', 'business_consultr_customize_preview_js' );