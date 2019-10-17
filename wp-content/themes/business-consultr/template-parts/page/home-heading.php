<?php
/**
* Template for Home page's Heading Section
* @since Business Consultr 1.0.0
*/
?>
<div class="container">
	<div class="section-title-group">
		<?php if( $args[ 'sub_title' ] ): ?>
			<div class="sub-title"><?php the_content();
			if( get_edit_post_link()){
				business_consultr_edit_link();
			}
			?></div>
		<?php endif; ?>
		<h2 class="section-title"><?php the_title(); ?></h2>
	</div>
</div>