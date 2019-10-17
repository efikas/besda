<?php
/**
 * The template for displaying the footer
 * Contains the closing of the body tag and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @since Business Consultr 1.0.0
 */
?>	
</div> <!-- end content -->

		<?php if( business_consultr_get_option( 'disable_footer_widget') ){
			$return =  false;
		}else {
			if( business_consultr_is_active_footer_sidebar() ):
			?>
				<section class="wrapper block-top-footer">
					<div class="container">
						<div class="row">
						<?php 
							$count = 0;
							for( $i = 1; $i <= 4; $i++ ){
								?>
								<div class="col-md-3 col-sm-6 col-xs-12">
									<?php dynamic_sidebar( 'business-consultr-footer-sidebar-'.$i ); ?>
								</div>
								<?php
							}
							if( $count > 0 ){
								$return = true;
							}else{
								$return = false;
							}
						?>
						</div>
					</div>
				</section>
			<?php
			endif;
		}

		?>
	
		<footer class="wrapper site-footer" role="contentinfo">
			<div class="container">
				<div class="footer-inner">
					<div class="row">
						<div class="col-xs-12 col-sm-6 col-md-6">
							<div class="site-info">
								<?php echo wp_kses_post( html_entity_decode( business_consultr_get_option( 'footer_text' ) ) ); ?>
							</div><!-- .site-info -->
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6">
							<div class="footer-menu">
								<?php business_consultr_get_menu( 'footer' ); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</footer><!-- #colophon -->
		<?php wp_footer(); ?>
	</body>
</html>