<?php
/**
 * Template part for displaying portfolio section
 *
 * @since Business Consultr 1.0.0
 */
?>

<?php 
if( !business_consultr_get_option( 'disable_portfolio' ) ):

	$portfolio_ids = business_consultr_get_ids( 'portfolio_page' );
	if( !empty( $portfolio_ids ) && is_array( $portfolio_ids ) && count( $portfolio_ids ) > 0 ):

		$query = new WP_Query( apply_filters( 'business_consultr_portfolio_args',  array( 
			'post_type'      => 'page',
			'post__in'       => $portfolio_ids, 
			'posts_per_page' => 3,
			'orderby'        => 'post__in'
		)));

		if( $query->have_posts() ):
	?>
			<!-- Feature Section -->
			<section class="wrapper block-grid block-portfolio">
				<?php 
					business_consultr_section_heading( array( 
						'id' => 'portfolio_main_page'
					));
				?>
				<div class="container">
					<div class="row">
			    		<?php
			    			$count = $query->post_count;
				    		while( $query->have_posts() ): 
				    			$query->the_post();

					    		$image = business_consultr_get_thumbnail_url( array(
					    			'size' => 'business-consultr-390-320'
					    		));
				    	?>
				    			<div class="masonry-grid">
							    	<article class="post-content">
							    		<div class="post-thumb-outer">
	    										<div class="post-thumb">
	    					    					<img src="<?php echo esc_url( $image ); ?>">
								    		        <a href="<?php the_permalink(); ?>">
						    		                    <span class="icon-area">
						    		                        <span class="kfi kfi-link"></span>
						    		                    </span>
								    		        </a>
	    										</div>
							    		</div>
    									<div class="post-content-inner">
	    									<div class="post-title">
	    			    						<h3>
	    			    							<a href="<?php the_permalink(); ?>">
	    			    								<?php the_title();
	    			    								if( get_edit_post_link()){
	    													business_consultr_edit_link();
	    												}
	    			    								?>
	    			    							</a>
	    			    						</h3>
	    									</div>
    			    						<div class="text">
    			    							<?php 
    			    								business_consultr_excerpt( 10, true, '&hellip;' );
				    								if( get_edit_post_link()){
    													business_consultr_edit_link();
    												}
    			    							?>
    			    						</div>
    									</div>
							    	</article>
						    	</div>
						<?php  
							endwhile;
							wp_reset_postdata();
						?>
					</div>
				</div>
			</section> <!-- End Feature Section -->
	<?php
		endif; 
	endif; 
endif;
?>