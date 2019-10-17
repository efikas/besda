<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since Business Consultr 1.0.0
 */

if( !business_consultr_get_option( 'disable_blog' ) ):

	$cat_id = absint( business_consultr_get_option( 'blog_category' ) );

	$args = array(
		'posts_per_page' => absint( business_consultr_get_option( 'blog_number' ) ),
		'ignore_sticky_posts' => 1
	);

	if( $cat_id > 0 ){
		$args[ 'cat' ] = $cat_id;
	}
	$query = new WP_Query( apply_filters( 'business_consultr_blog_args', $args ) );

	if( $query->have_posts() ): 
?>
		<!-- Blog Section -->
		<section class="wrapper block-grid blog-section">
			<?php
				business_consultr_section_heading( array(
					'id' => 'blog_main_page'
				));
			?>
			<div class="container">
				<div class="row">
					<?php
						while( $query->have_posts() ):
							$query->the_post();
							get_template_part( 'template-parts/archive/content', '' );
						endwhile; 
						wp_reset_postdata(); 
					?>
				</div>
			</div>
		</section> <!-- End Blog Section -->
<?php 
	endif; 
endif;