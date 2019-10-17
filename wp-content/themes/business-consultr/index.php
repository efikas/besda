<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
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
				<?php if( business_consultr_get_option( 'archive_layout' ) == 'left' ): ?>
					<?php get_sidebar(); ?>
				<?php endif; ?>
				<?php $class = ''; ?>
				<?php business_consultr_get_option( 'archive_layout' ) == 'none' ? $class = 'col-xs-12 col-sm-12 col-md-12' : $class = 'col-xs-12 col-sm-7 col-md-8'; ?>
					<div class="<?php echo $class; ?>" id="main-wrap">
					<div class="row masonry-wrapper">
						<?php 
							while ( have_posts() ) : the_post();
								get_template_part( 'template-parts/archive/content', '' );
							endwhile;
						?>
					</div>
					<?php
						the_posts_pagination( array(
							'next_text' => '<span>'.esc_html__( 'Next', 'business-consultr' ) .'</span><span class="screen-reader-text">' . esc_html__( 'Next page', 'business-consultr' ) . '</span>',
							'prev_text' => '<span>'.esc_html__( 'Prev', 'business-consultr' ) .'</span><span class="screen-reader-text">' . esc_html__( 'Previous page', 'business-consultr' ) . '</span>',
							'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'business-consultr' ) . ' </span>',
						));
					?>
				</div>
				<?php if( business_consultr_get_option( 'archive_layout' ) != 'left' && business_consultr_get_option( 'archive_layout' ) != 'none' ): ?>
					<?php get_sidebar(); ?>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php 
else: 
	get_template_part( 'template-parts/page/content', 'none' );
endif;
get_footer();