<?php
/**
* Template for Inner Banner Section for all the inner pages
*
* @since Business Consultr 1.0.0
*/
?>

<section class="wrapper wrap-inner-banner" style="background-image: url('<?php header_image(); ?>')">
	<div class="container">
		<header class="page-header">
			<div class="inner-header-content">
				<h1 class="page-title"><?php echo wp_kses_post( $args[ 'title' ] ); ?></h1>
				<?php if( $args[ 'description' ] ): ?>
					<div class="page-description">
						<?php echo wp_kses_post( $args[ 'description' ] ); ?>
					</div>
				<?php endif; ?>
			</div>
		</header>
	</div>
</section>
<section class="wrapper breadcrumb-wrap">
	<div class="container">
		<?php 
			if( !is_front_page()){
				business_consultr_breadcrumb();
			}
		?>
	</div>
</section>