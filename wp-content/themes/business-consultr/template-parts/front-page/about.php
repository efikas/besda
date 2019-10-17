<?php
/**
 * Template part for displaying about us section
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since Business Consultr 1.0.0
 */
if( !business_consultr_get_option( 'disable_about' ) ):
	$id = business_consultr_get_option( 'about_page' );
	if( $id ):
		$query = new WP_Query( apply_filters( 'business_consultr_about_page_args',  array( 
			'post_type'  => 'page', 
			'p'          => $id, 
		)));
		while( $query->have_posts() ): 
			$query->the_post();
			$image = business_consultr_get_thumbnail_url( array(
				'size' => 'business-consultr-1170-760'
			));
	?>
	<!-- About Section -->
	<section class="wrapper block-about">
		<div class="thumb-block-outer">
			<div class="container">
				<div class="row">
					<?php
					$class = 'col-xs-12 col-sm-12 col-md-12';
						if( has_post_thumbnail() ):
							$class = 'col-xs-12 col-sm-12 col-md-6';
					?>
					<div class="col-xs-12 col-sm-12 col-md-6">
						<div class="area-div thumb-outer">
							<?php the_post_thumbnail( 'business-consultr-1170-760' ); ?>
						</div>
					</div>
					<?php endif; ?>
					<div class="<?php echo esc_attr( $class ); ?>">
						<div class="area-div content-outer">
							<div class="section-title-group">
								<h2 class="section-title">
									<?php the_title();
									 if( get_edit_post_link()){
										business_consultr_edit_link();
									}
									?>
								</h2>
							</div>
							<?php business_consultr_excerpt(30); ?>
							<div class="button-container">
								<a href="<?php the_permalink(); ?>" class="button-primary button-round">
									<?php esc_html_e( 'Know More', 'business-consultr' ); ?>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section> <!-- End About Section -->
	<?php 
		endwhile;
		wp_reset_postdata();
	endif;
endif;
