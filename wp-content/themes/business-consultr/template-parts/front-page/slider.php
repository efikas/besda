<?php
/**
 * Template part for displaying slider section
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since Business Consultr 1.0.0
 */

$slider_ids = business_consultr_get_ids( 'slider_page' );
if( !empty( $slider_ids ) && is_array( $slider_ids ) && count( $slider_ids ) > 0 && !business_consultr_get_option( 'disable_slider' ) ){
?>
	<section class="wrapper block-slider">

		<div class="controls">
		</div>

		<div class="home-slider owl-carousel">
			<?php
				$query = new WP_Query( apply_filters( 'business_consultr_slider_args', array(
					'posts_per_page' => 3,
					'post_type'      => 'page',
					'orderby'        => 'post__in',
					'post__in'       => $slider_ids,
				)));
				
				while ( $query->have_posts() ) :  $query->the_post();
					$image = business_consultr_get_thumbnail_url( array( 'size' => 'business-consultr-1920-750' ) );
			?>
					<div class="slide-item" style="background-image: url( <?php echo esc_url( $image ); ?> );">
						<div class="banner-overlay">
					    	<div class="container">
					    		<div class="row">
					    			<div class="col-sm-12 col-md-10 col-md-offset-1">
					    				<div class="slide-inner text-center">
					    					<div class="post-content-inner-wrap">
					    						<div class="content">
						    					<?php  
						    						business_consultr_excerpt( 16, true );
						    						if( get_edit_post_link()){
		    											business_consultr_edit_link();
		    										}
						    					?>
					    						</div>
						    					<header class="post-title">
						    						<h2><?php the_title(); ?></h2>
						    					</header>
							    				<div class="button-container">
							    					<a href="<?php the_permalink(); ?>" class="button-primary button-round">
							    						<?php esc_html_e( 'Learn More', 'business-consultr' ); ?>
							    					</a>
							    				</div>
						    				</div>
					    				</div>
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
		<div id="after-slider"></div>
	</section>
<?php 
}else {
	business_consultr_inner_banner();
}