<?php
/**
 * Template part for displaying testimonial section
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since Business Consultr 1.0.0
 */

if( ! business_consultr_get_option( 'disable_testimonial' ) ):
	$testi_ids = business_consultr_get_ids( 'testimonial_page' );

	if( !empty( $testi_ids ) && is_array( $testi_ids ) && count( $testi_ids ) > 0 ):

		$query = new WP_Query( apply_filters( 'business_consultr_testimonial_args', array( 
			'post_type'      => 'page', 
			'post__in'       => $testi_ids,
			'posts_per_page' => 4,
			'orderby'        => 'post__in'
		)));

		if( $query->have_posts() ):
?>
			<section class="wrapper block-testimonial">
				<?php
					business_consultr_section_heading( array(
						'id' => 'testimonial_main_page'
					));
				?>
				<div class="content-inner">
					<div class="container">
						<div class="controls"></div>
						<div class="row">
							<div class="col-xs-12 col-sm-10 col-md-10 col-sm-offset-1 col-md-offset-1">
								
								<div class="owl-carousel testimonial-carousel">
									<?php 
										while ( $query->have_posts() ):
											$query->the_post(); 
											$image = business_consultr_get_thumbnail_url( array(
												'size' => 'thumbnail'
											));
									?>
										    <div class="slide-item">
												<article class="post-content">
													<div class="post-content-inner">
														<blockquote>
									    					<div class="text">
									    						<?php the_content(); 
									    							if( get_edit_post_link()){
									    								business_consultr_edit_link();
									    							}
									    						?>
									    					</div>
										    				<footer class="post-title">
							    								<div class="post-thumb-outer">
							    									<div class="post-thumb">
							    				    					<img src="<?php echo esc_url( $image ); ?>">
							    									</div>
							    								</div>
										    					<cite>
										    						<?php business_consultr_testimonial_title(); ?>
										    					</cite>
										    				</footer>
														</blockquote>
													</div>

												</article>
											</div>
									<?php
										endwhile; 
										wp_reset_postdata();
									?>
								</div>
							</div>
						</div>
					</div>
					<div class="container">
						<div class="owl-pager" id="testimonial-pager"></div>
					</div>
				</div>
			</section><!-- End Testimonial Section -->
<?php
		endif;
	endif;
endif;