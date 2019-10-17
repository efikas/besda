<?php get_header(); ?>

<?php get_template_part( 'template-parts/element', 'page-header' ); ?>

<div id="main" class="main">
	<div class="container">
		<section id="content" class="content">
			<?php do_action( 'cpotheme_before_content' ); ?>
			<?php
			if ( have_posts() ) {
				while ( have_posts() ) :
					the_post();
				?>
							<?php get_template_part( 'template-parts/element', 'blog' ); ?>
			<div class="cpo-navigation">
				<div class="cpo-previous-link">
					<?php previous_post_link( '%link', '&laquo; %title' ); ?> 
				</div>
				<div class="cpo-next-link">
					<?php next_post_link( '%link', '%title &raquo;' ); ?>
				</div>
			</div>
			<?php cpotheme_author(); ?>
			<?php comments_template( '', true ); ?>
			<?php
			endwhile;
			};
?>
			<?php do_action( 'cpotheme_after_content' ); ?>
		</section>
		<?php get_sidebar(); ?>
		<div class="clear"></div>
	</div>
</div>

<?php get_footer(); ?>
