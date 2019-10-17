<?php
/**
 * Business Consultr functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 * @since Business Consultr 1.0.0
 */

/**
 * Business Consultr only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

function business_consultr_scripts(){

	# Enqueue Vendor's Script & Style
	$scripts = array(
		array(
			'handler'  => 'business-consultr-google-fonts',
			'style'    => esc_url( '//fonts.googleapis.com/css?family=Poppins:300,400,400i,500,600,700,800,900' ),
			'absolute' => true
		),
		array(
			'handler' => 'bootstrap',
			'style'   => 'bootstrap/css/bootstrap.min.css',
			'script'  => 'bootstrap/js/bootstrap.min.js',
			'version' => '3.3.7'
		),
		array(
			'handler' => 'kfi-icons',
			'style'   => 'kf-icons/css/style.css',
			'version' => '1.0.0'
		),
		array(
			'handler' => 'owlcarousel',
			'style'   => 'OwlCarousel2-2.2.1/assets/owl.carousel.min.css',
			'script'  => 'OwlCarousel2-2.2.1/owl.carousel.min.js',
			'version' => '2.2.1'
		),
		array(
			'handler' => 'owlcarousel-theme',
			'style'   => 'OwlCarousel2-2.2.1/assets/owl.theme.default.min.css',
			'version' => '2.2.1'
		),
		array(
			'handler'  => 'business-consultr-blocks',
			'style'    => get_theme_file_uri( '/assets/css/blocks.min.css' ),
			'absolute' => true,
		),
		array(
			'handler'  => 'business-consultr-style',
			'style'    => get_stylesheet_uri(),
			'absolute' => true,
		),
		array(
			'handler'    => 'business-consultr-script',
			'script'     => get_theme_file_uri( '/assets/js/main.min.js' ),
			'absolute'   => true,
			'prefix'     => '',
			'dependency' => array( 'jquery', 'masonry' )
		),
		array(
			'handler'  => 'business-consultr-skip-link-focus-fix',
			'script'   => get_theme_file_uri( '/assets/js/skip-link-focus-fix.min.js' ),
			'absolute' => true,
		),
	);

	business_consultr_enqueue( $scripts );

	$locale = apply_filters( 'business_consultr_localize_var', array(
		'is_admin_bar_showing'        => is_admin_bar_showing() ? true : false,
		'enable_scroll_top_in_mobile' => business_consultr_get_option( 'enable_scroll_top_in_mobile' ) ? 1 : 0,
		'home_slider' => array(
			'autoplay' => business_consultr_get_option( 'slider_autoplay' ),
			'timeout'  => absint( business_consultr_get_option( 'slider_timeout' ) ) * 1000
		),
		'is_rtl' => is_rtl(),
		'search_placeholder'=> esc_html__( 'hit enter for search.', 'business-consultr' ),
		'search_default_placeholder'=> esc_html__( 'search...', 'business-consultr' )
	));

	wp_localize_script( 'business-consultr-script', 'BUSINESSCONSULTR', $locale );

	if ( is_singular() && comments_open() ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'business_consultr_scripts' );

/**
* Enqueue editor styles for Gutenberg
*/

function business_consultr_block_editor_styles() {
	// Block styles.
	wp_enqueue_style( 'business-consultr-block-editor-style', get_theme_file_uri( '/assets/css/editor-blocks.min.css' ) );
	// Google Font
	wp_enqueue_style( 'business-consultr-google-font', 'https://fonts.googleapis.com/css?family=Poppins:300,400,400i,500,600,700,700i', false );
}
add_action( 'enqueue_block_editor_assets', 'business_consultr_block_editor_styles' );

/**
* Adds a submit button in search form
* 
* @since Business Consultr Pro 1.0.0
* @param string $form
* @return string
*/
function business_consultr_modify_search_form( $form ){
	return str_replace( '</form>', '<button type="submit" class="search-button"><span class="kfi kfi-search"></span></button></form>', $form );
}
add_filter( 'get_search_form', 'business_consultr_modify_search_form' );

/**
* Modify some markup for comment section
*
* @since Business Consultr 1.0.0
* @param array $defaults
* @return array $defaults
*/
function business_consultr_modify_comment_form_defaults( $defaults ){

	$user = wp_get_current_user();
	$user_identity = $user->exists() ? $user->display_name : '';

	$defaults[ 'logged_in_as' ] = '<p class="logged-in-as">' . sprintf(
          /* translators: 1: edit user link, 2: accessibility text, 3: user name, 4: logout URL */
          __( '<a href="%1$s" aria-label="%2$s">Logged in as %3$s</a> <a href="%4$s">Log out?</a>', 'business-consultr' ),
          get_edit_user_link(),
          /* translators: %s: user name */
          esc_attr( sprintf( __( 'Logged in as %s. Edit your profile.', 'business-consultr' ), $user_identity ) ),
          $user_identity,
          wp_logout_url( apply_filters( 'the_permalink', get_permalink( get_the_ID() ) ) )
      ) . '</p>';
	return $defaults;
}
add_filter( 'comment_form_defaults', 'business_consultr_modify_comment_form_defaults',99 );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 *
 * @since Business Consultr 1.0.0
 * @return void
 */
function business_consultr_pingback_header(){
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'business_consultr_pingback_header' );

/**
* Add a class in body when previewing customizer
*
* @since Business Consultr 1.0.0
* @param array $class
* @return array $class
*/
function business_consultr_body_class_modification( $class ){
	if( is_customize_preview() ){
		$class[] = 'keon-customizer-preview';
	}
	
	if( is_404() || ! have_posts() ){
 		$class[] = 'content-none-page';
	}

	if( ( is_front_page() && ! is_home() ) || is_search() ){

		$class[] = 'grid-col-3';
	}else if( is_home() || is_archive() ){

		$class[] = 'grid-col-2';
	}

	return $class;
}
add_filter( 'body_class', 'business_consultr_body_class_modification' );

if( ! function_exists( 'business_consultr_get_ids' ) ):
/**
* Fetches setting from customizer and converts it to an array
*
* @uses business_consultr_explode_string_to_int()
* @return array | false
* @since Business Consultr 1.0.0
*/
function business_consultr_get_ids( $setting ){

    $str = business_consultr_get_option( $setting );
    if( empty( $str ) )
    	return;

    return business_consultr_explode_string_to_int( $str );

}
endif;

if( !function_exists( 'business_consultr_section_heading' ) ):
/**
* Prints the heading section for home page
*
* @return void
* @since Business Consultr 1.0.0
*/
function business_consultr_section_heading( $args ){

	$defaults = array(
	    'divider'  => false,
	    'query'    => true,
	    'sub_title' => true
	);

	$args = wp_parse_args( $args, $defaults );

	# No need to query if already inside the query.
	if( !$args[ 'query'] ){
		set_query_var( 'args', $args );
		get_template_part( 'template-parts/page/home', 'heading' );
		return;
	}

	$id = business_consultr_get_option( $args[ 'id' ] );

	if( !empty( $id ) ){

		$query = new WP_Query( array(
			'p' => $id,
			'post_type' => 'page'
		));

		while( $query->have_posts() ){
			$query->the_post();
			set_query_var( 'args', $args );
			get_template_part( 'template-parts/page/home', 'heading' );
		}
		wp_reset_postdata();
	}
}
endif;

if( ! function_exists( 'business_consultr_inner_banner' ) ):
/**
* Includes the template for inner banner
*
* @return void
* @since Business Consultr 1.0.0
*/
function business_consultr_inner_banner(){

	$description = false;

	if( is_archive() ){

		# For all the archive Pages.
		$title       = get_the_archive_title();
		$description = get_the_archive_description();
	}else if( !is_front_page() && is_home() ){

		# For Blog Pages.
		$title = single_post_title( '', false );
	}else if( is_search() ){

		# For search Page.
		$title = esc_html__( 'Search Results for: ', 'business-consultr' ) . get_search_query();
	}else if( is_front_page() && is_home() ){
		# If Latest posts page
		
		$title = business_consultr_get_option( 'archive_page_title' );
	}else{

		# For all the single Pages.
		$title = get_the_title();
	}

	$args = array(
		'title'       => business_consultr_remove_pipe( $title ),
		'description' => $description
	);

	set_query_var( 'args', $args );
	get_template_part( 'template-parts/inner', 'banner' );
}
endif;

if( !function_exists( 'business_consultr_testimonial_title' ) ):
/**
* Prints the title for testimonial in more attractive way
*
* @return void
* @since Business Consultr 1.0.0
*/
function business_consultr_testimonial_title(){

	$title = str_replace( "\|", "&exception", get_the_title() );

	$arr = explode( '|', $title );

	echo '<span>' . str_replace( '&exception', '|', $arr[ 0 ] ) . '</span>' ;

	if( isset( $arr[ 1 ] ) ){
		echo '<p>' . esc_html( $arr[ 1 ] ) . '</p>';
	}
}
endif;

if( !function_exists( 'business_consultr_get_piped_title' ) ):
/**
* Returns the title and sub title from piped title
*
* @return array
* @since Business Consultr 1.0.0
*/
function business_consultr_get_piped_title(){

	$title = str_replace( "\|", "&exception", get_the_title() );

	$arr = explode( '|', $title );
	$data = array(
		'title' => $arr[ 0 ],
		'sub_title'  => false
	);

	if( isset( $arr[ 1 ] ) ){
		$data[ 'sub_title' ] = trim( $arr[ 1 ] );
	}

	$data[ 'title' ] = str_replace( '&exception', '|', $arr[ 0 ] );
	return $data;
}
endif;

if( !function_exists( 'business_consultr_remove_pipe' ) ):
/**
* Removes Pipes from the title
*
* @return string
* @since Business Consultr 1.0.0
*/
function business_consultr_remove_pipe( $title, $force = false ){

	if( $force || ( is_page() && !is_front_page() ) ){

		$title = str_replace( "\|", "&exception", $title );
		$arr = explode( '|', $title );

		$title = str_replace( '&exception', '|', $arr[ 0 ] );
	}

	return $title;
}
add_filter( 'the_title', 'business_consultr_remove_pipe',9999 );

endif;

function business_consultr_remove_title_pipe( $title ){
	$title[ 'title' ] = business_consultr_remove_pipe( $title[ 'title' ], true );
	return $title;
}
add_filter( 'document_title_parts', 'business_consultr_remove_title_pipe',9999 );

if( !function_exists( 'business_consultr_get_icon_by_post_format' ) ):
/**
* Gives a css class for post format icon
*
* @return string
* @since Business Consultr 1.0.0
*/
function business_consultr_get_icon_by_post_format(){
	$icons = array(
		'standard' => 'kfi-pushpin-alt',
		'sticky'  => 'kfi-pushpin-alt',
		'aside'   => 'kfi-documents-alt',
		'image'   => 'kfi-image',
		'video'   => 'kfi-arrow-triangle-right-alt2',
		'quote'   => 'kfi-quotations-alt2',
		'link'    => 'kfi-link-alt',
		'gallery' => 'kfi-images',
		'status'  => 'kfi-comment-alt',
		'audio'   => 'kfi-volume-high-alt',
		'chat'    => 'kfi-chat-alt',
	);

	$format = get_post_format();
	if( empty( $format ) ){
		$format = 'standard';
	}

	return apply_filters( 'business_consultr_post_format_icon', $icons[ $format ] );
}
endif;

if( !function_exists( 'business_consultr_has_sidebar' ) ):

/**
* Check whether the page has sidebar or not.
*
* @see https://codex.wordpress.org/Conditional_Tags
* @since Business Consultr 1.0.0
* @return bool Whether the page has sidebar or not.
*/
function business_consultr_has_sidebar(){

	if( is_page() || is_search() || is_single() ){
		return false;
	}

	return true;
}
endif;

/**
* Check whether the sidebar is active or not.
*
* @see https://codex.wordpress.org/Conditional_Tags
* @since Business Consultr 1.1.9
* @return bool whether the sidebar is active or not.
*/
function business_consultr_is_active_footer_sidebar(){

	for( $i = 1; $i <= 4; $i++ ){
		if ( is_active_sidebar( 'business-consultr-footer-sidebar-'.$i ) ) : 
			return true;
		endif;
	}
	return false;
}

if( !function_exists( 'business_consultr_is_search' ) ):
/**
* Conditional function for search page / jet pack supported
* @since Business Consultr 1.0.0
* @return Bool 
*/
function business_consultr_is_search(){

	if( ( is_search() || ( isset( $_POST[ 'action' ] ) && $_POST[ 'action' ] == 'infinite_scroll'  && isset( $_POST[ 'query_args' ][ 's' ] ))) ){
		return true;
	}

	return false;
}
endif;

function business_consultr_post_class_modification( $classes ){

	# Add no thumbnail class when its search page
	if( business_consultr_is_search() && ( 'post' !== get_post_type() && !has_post_thumbnail() ) ){
		$classes[] = 'no-thumbnail';
	}
	return $classes;
}
add_filter( 'post_class', 'business_consultr_post_class_modification' );

require_once get_parent_theme_file_path( '/inc/setup.php' );
require_once get_parent_theme_file_path( '/inc/template-tags.php' );
require_once get_parent_theme_file_path( '/modules/loader.php' );
require_once get_parent_theme_file_path( '/trt-customize-pro/example-1/class-customize.php' );
require_once get_parent_theme_file_path( '/modules/tgm-plugin-activation/loader.php' );
require_once get_parent_theme_file_path( '/theme-info/theme-info.php' );

if( !function_exists( 'business_consultr_get_homepage_sections' ) ):
/**
* Returns the section name of homepage
* @since Business Consultr 1.0.0
* @return array 
*/
function business_consultr_get_homepage_sections(){

	$arr = array(
		'slider',
		'services',
		'about',
		'portfolio',
		'testimonials',
		'callback',
		'blog',
		'contact'
	);

	return apply_filters( 'business_consultr_homepage_sections', $arr );
}
endif;

/**
* Predefined demo Import file setup. 
* @link https://wordpress.org/plugins/one-click-demo-import/
* @since Business Consultr 1.0.0
* @return array
*/
function business_consultr_ocdi_import_files() {
	return array(
		array(
		  'import_file_name'             => esc_html__( 'Theme Demo Content', 'business-consultr' ),
		  'categories'                   => array( 'Category 1', 'Category 2' ),
		  'local_import_file'            => trailingslashit( get_template_directory() ) . 'ocdi/business-consultr.xml',
		  'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'ocdi/business-consultr.wie',
		  'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'ocdi/business-consultr.dat',
		  'import_preview_image_url'     => trailingslashit( get_template_directory() ) . 'screenshot.png',
		  'import_notice'                => __( 'Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'business-consultr' ),
		  'preview_url'                  => 'https://www.demo.keonthemes.com/business-consultr',
		),
	);
}
add_filter( 'pt-ocdi/import_files', 'business_consultr_ocdi_import_files' );

/**
* Change menu, front page display as in demo after completing demo import
* @link https://wordpress.org/plugins/one-click-demo-import/
* @since Business Consultr 1.0.0
* @return null
*/
function business_consultr_ocdi_after_import_setup() {
    // Assign menus to their locations.

    $primary_menu = get_term_by('name', 'Primary Menu', 'nav_menu');
    $social_menu = get_term_by('name', 'Social Menu', 'nav_menu');
    $footer_menu = get_term_by('name', 'Footer Menu', 'nav_menu');
    set_theme_mod( 'nav_menu_locations' , array( 
          'primary' => $primary_menu->term_id, 
          'social' => $social_menu->term_id,
          'footer' => $footer_menu->term_id
         ) 
    );

    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Front' );
    $blog_page_id  = get_page_by_title( 'Blog' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    update_option( 'page_for_posts', $blog_page_id->ID );

}
add_action( 'pt-ocdi/after_import', 'business_consultr_ocdi_after_import_setup' );

/**
* Disable branding of One Click Demo Import
* @link https://wordpress.org/plugins/one-click-demo-import/
* @since Business Consultr 1.0.0
* @return Bool
*/
function business_consultr_ocdi_branding(){
	return true;
}
add_filter( 'pt-ocdi/disable_pt_branding', 'business_consultr_ocdi_branding' );