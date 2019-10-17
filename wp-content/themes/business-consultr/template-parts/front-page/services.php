<?php
/**
 * Template part for displaying services section
 *
 * @since Business Consultr 1.0.0
 */

if( !business_consultr_get_option( 'disable_service' ) ):

	$srvc_ids = business_consultr_get_ids( 'service_page' );
	if( !empty( $srvc_ids ) && is_array( $srvc_ids ) && count( $srvc_ids ) > 0 ):

		$query = new WP_Query( apply_filters( 'business_consultr_services_args',  array( 
			'post_type'      => 'page',
			'post__in'       => $srvc_ids, 
			'posts_per_page' => 3,
			'orderby'        => 'post__in'
		)));

		if( $query->have_posts() ):
?>
			<!-- Service Section -->
			<section class="wrapper block-service">
				<div class="container">
					<div class="row">
			    		<?php
			    			$count = $query->post_count;
				    		while( $query->have_posts() ): 
				    			$query->the_post();
				    			$title = business_consultr_get_piped_title();
				    	?>
						    	<div class="col-xs-12 col-sm-6 col-md-4">
						    		<div class="icon-block-outer">
						    			<div class="post-content-inner">
						    				<div class="list-inner">
					    						<?php 
					    							$icon = $title[ 'sub_title' ] ;
					    							if( !empty( $icon ) ):
					    						?>
					    								<div class="icon-area">
					    									<span class="icon-outer">
					    										<span class="kfi <?php echo esc_attr( $icon ); ?>"></span>
					    									</span>
					    								</div>
					    						<?php endif; ?>
												<div class="icon-content-area">
						    						<h3>
						    							<a href="<?php the_permalink(); ?>">
						    								<?php echo esc_html( $title[ 'title' ] ); ?>
						    							</a>
						    						</h3>
							    						<?php if( !business_consultr_get_option( 'disable_service_text_button' )): ?>
								    						<div class="text">
								    							<?php 
								    								business_consultr_excerpt( 12, true, '&hellip;' );
								    								if( get_edit_post_link()){
				    													business_consultr_edit_link();
				    												}
								    							?>
								    						</div>
							    							<div class="button-container">
							    								<a href="<?php the_permalink(); ?>" class="button-text">
							    									<?php esc_html_e( 'Read More', 'business-consultr' ); ?>
							    								</a>
							    							</div>
					    								<?php endif; ?>
												</div>
						    				</div>
						    			</div>
						    		</div>
						    	</div>
						<?php  
							endwhile;
							wp_reset_postdata();
						?>
					</div>
				</div>
			</section> <!-- End Service Section -->
<?php
		endif; 
	endif; 
endif;