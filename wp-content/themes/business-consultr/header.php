<?php
/**
 * The header for our theme
 * This is the template that displays all of the <head> section and everything up.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @since Business Consultr 1.0.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'wp_body_open' ); ?>

	<div id="site-loader">
		<div class="site-loader-inner">
			<?php
				$src = get_theme_file_uri( 'assets/images/placeholder/loader.gif' );
				
				echo apply_filters( 'business_consultr_preloader',
				sprintf( '<img src="%s" alt="%s">',
					esc_url( $src ), 
					esc_html__( 'Site Loader','business-consultr' )
				)); 
			?>
		</div>
	</div>

	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#content">
			<?php echo esc_html__( 'Skip to content', 'business-consultr' ); ?>
		</a>
		<?php get_template_part( 'template-parts/header/offcanvas', 'menu' ); ?>
		<?php
			if( !business_consultr_get_option( 'disable_top_header' ) ):
		?>
		<header class="wrapper top-header">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-6 col-md-7">
						<div class="top-header-left">
							<?php if ( business_consultr_get_option( 'top_header_address') ): ?>
								<div class="list">
									<span class="kfi kfi-pin-alt"></span>
									<?php echo wp_kses_post(  business_consultr_get_option( 'top_header_address' ) ); ?>
								</div>
							<?php endif; ?>
							<?php if ( business_consultr_get_option( 'top_header_email') ): ?>
								<div class="list">
									<span class="kfi kfi-mail-alt"></span>
									<a href="mailto:<?php echo wp_kses_post(  business_consultr_get_option( 'top_header_email' ) ); ?>">
										<?php echo wp_kses_post(  business_consultr_get_option( 'top_header_email' ) ); ?>
									</a>
								</div>
							<?php endif; ?>
							<?php if ( business_consultr_get_option( 'top_header_phone') ): ?>
								<div class="list">
									<span class="kfi kfi-phone"></span>
									<a href="tel:<?php echo wp_kses_post(  business_consultr_get_option( 'top_header_phone' ) ); ?>">
										<?php echo wp_kses_post(  business_consultr_get_option( 'top_header_phone' ) ); ?>
									</a>
								</div>
							<?php endif; ?>
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-5">
						<div class="top-header-right">
						<div class="socialgroup">
							<?php business_consultr_get_menu( 'social' ); ?>
						</div>
						<?php if( !business_consultr_get_option( 'disable_search_icon' ) ):?>
								<span class="search-icon">
									<a href="#">
										<span class="kfi kfi-search" aria-hidden="true"></span>
									</a>
									<div id="search-form">
										<?php get_search_form(); ?>
									</div><!-- /#search-form -->
								</span>
						<?php endif; ?>
						<?php if( class_exists( 'WooCommerce' ) ): ?>
							<span class="cart-icon">
								<a href="<?php echo esc_url( wc_get_cart_url() ); ?>">
									<span class="kfi kfi-cart-alt"></span>
									<span class="count">
										<?php echo absint( WC()->cart->get_cart_contents_count() ); ?>
									</span>
								</a>
							</span>
						<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</header>
		<?php

		endif;
		?>
		<header id="masthead" class="wrapper site-header" role="banner">
			<div class="container">
				<div class="row">
					<div class="col-xs-5 col-sm-7 col-md-3">
						<?php get_template_part( 'template-parts/header/site', 'branding' ); ?>
					</div>
					<?php $class = ''; ?>
					<?php !business_consultr_get_option( 'disable_header_button' ) ? $class = 'col-md-7' : $class = 'col-md-9'; ?>
					<div class="visible-md visible-lg <?php echo $class; ?>" id="primary-nav-container">
						<div class="wrap-nav main-navigation">
							<div id="navigation" class="hidden-xs hidden-sm">
							    <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'business-consultr' ); ?>">
									<?php echo business_consultr_get_menu( 'primary' ); ?>
							    </nav>
							</div>
						</div>
					</div>
					<div class="col-xs-7 col-sm-5 col-md-2" id="header-bottom-right-outer">
						<div class="header-bottom-right">
							<span class="alt-menu-icon visible-sm">
								<a class="offcanvas-menu-toggler" href="#">
									<span class="kfi kfi-menu"></span>
								</a>
							</span>
							<?php if( !business_consultr_get_option( 'disable_header_button' ) ): ?>
								<span class="callback-button">
									<a href="<?php echo wp_kses_post(  business_consultr_get_option( 'header_button_link' ) ); ?>" class="button-primary">
										<?php echo wp_kses_post(  business_consultr_get_option( 'header_button' ) ); ?>
									</a>
								</span>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</header><!-- #masthead -->
		<div id="content" class="wrapper site-main">

