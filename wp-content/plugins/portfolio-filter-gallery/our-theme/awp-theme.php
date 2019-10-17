<?php
//js
wp_enqueue_script('awl-theme-bootstrap-js', PFG_PLUGIN_URL .'../js/bootstrap.min.js', array('jquery'), '' , true);

//css
wp_enqueue_style('awl-theme-bootstrap-css', PFG_PLUGIN_URL .'our-theme/css/bootstrap.min.css');
wp_enqueue_style('awl-theme-css', PFG_PLUGIN_URL .'our-theme/css/our-theme.css');
wp_enqueue_style('awl-theme-font-awesome-css', PFG_PLUGIN_URL .'our-theme/css/font-awesome.min.css');

?>
<style>
.awl_theme_container {
	 background-image: url("<?php echo PFG_PLUGIN_URL ?>our-theme/img/sr-box.jpg");
	 background-color: #F2F6F9;
	 padding:24px;
}
.theme_spacing {
	margin-bottom:20px;
	margin-top:20px;
}
.theme_spacing_md {
	margin-bottom:70px;
	margin-top:70px;
}
</style>
<div class="welcome-panel">
<div class="awl_theme_container">
<div class="container">
	<div class="row">
		<div class="col-md-6 col-sm-6">
			<img src="<?php echo PFG_PLUGIN_URL ?>our-theme/img/aneeq-premium.png" class="img-responsive">
		</div>
		<div class="col-md-6 col-sm-6 aneeq_theme_desc">
			<h1 class="theme_spacing">ANEEQ PREMIUM <span>WORDPRESS THEME</span></h1>
			<h4>Aneeq is premium WordPress theme for multi-purpose use. Clean & clear typography with the visually attractive responsive design. 
			Aneeq theme comes with multiple page templates which are completely configurable using Theme Options Panel.</h4>
			<hr style="border-color: #b3aeae;">
			<a href="http://awplife.com/demo/aneeq-premium/" target="_blank" class="button button-primary button-hero load-customize hide-if-no-customize">LIVE DEMO</a>
			<a href="http://awplife.com/product/aneeq-premium/" target="_blank"  class="button button-primary button-hero load-customize hide-if-no-customize">BUY NOW</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6 col-sm-6 aneeq_theme_desc">
			<h1 class="theme_spacing">DARON PREMIUM <span>WORDPRESS THEME</span></h1>
			<h4>Daron is premium WordPress theme for multi-purpose use. Fresh and attractive blog showcase.  
			Woocommerce ready and comes with multiple page templates which are completely configurable using Theme Options Panel.</h4>
			<hr style="border-color: #b3aeae;">
			<a href="http://awplife.com/demo/daron-premium/" target="_blank" class="button button-primary button-hero load-customize hide-if-no-customize">LIVE DEMO</a>
			<a href="http://awplife.com/product/daron-premium/" target="_blank"  class="button button-primary button-hero load-customize hide-if-no-customize">BUY NOW</a>
		</div>
		<div class="col-md-6 col-sm-6">
			<img src="<?php echo PFG_PLUGIN_URL ?>our-theme/img/Daron-Premium-WordPress-Theme-Responsive-Frame.png" class="img-responsive">
		</div>
	</div>
</div>
</div>
</div>