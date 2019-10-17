<?php
/**
 * The search template file
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since Business Consultr 1.0.0
 */
get_header();
if( have_posts() ):
	/**
	* Prints Title and  breadcrumbs for archive pages
	* @since Business Consultr 1.0.0
	*/
	business_consultr_inner_banner();
?>
<section class="wrapper block-grid" id="main-content">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12" id="main-wrap">
				<div class="row masonry-wrapper">
					<?php 
						while ( have_posts() ) : the_post();
							get_template_part( 'template-parts/archive/content', '' );
						endwhile;
					?>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12">
					<?php
						the_posts_pagination( array(
							'next_text' => '<span>'.esc_html__( 'Next', 'business-consultr' ) .'</span><span class="screen-reader-text">' . esc_html__( 'Next page', 'business-consultr' ) . '</span>',
							'prev_text' => '<span>'.esc_html__( 'Prev', 'business-consultr' ) .'</span><span class="screen-reader-text">' . esc_html__( 'Previous page', 'business-consultr' ) . '</span>',
							'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'business-consultr' ) . ' </span>',
						) );
					?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
else: 
	get_template_part( 'template-parts/page/content', 'none' );
endif;
get_footer();