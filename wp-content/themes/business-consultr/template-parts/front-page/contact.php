<?php
/**
* Template for Contact
* @since Business Consultr 1.0.0
*/
?>
<?php if( !business_consultr_get_option( 'disable_contact' ) ): ?>
	<section class="wrapper block-contact">
		<?php 
			business_consultr_section_heading( array( 
				'id' => 'contact_main_page'
			));

			$shortcode = business_consultr_get_option( 'contact_shortcode' );
		?>
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2">
					<div class="row">
						<?php echo do_shortcode( $shortcode ); ?>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>