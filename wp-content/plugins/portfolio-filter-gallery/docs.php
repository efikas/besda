<?php
//save categories
if(isset($_POST['action']) == "add-category"){
	//print_r($_POST);
	
	$category_name = sanitize_text_field($_POST['name']);
	//$category_slug = strtolower($category_name);
	$new_category = array($category_name);
	
	$all_category = get_option('awl_portfolio_filter_gallery_categories');
	if(is_array($all_category)) {
		$all_category = array_merge($all_category, $new_category);
	} else {
		$all_category = $new_category;
	}
	update_option( 'awl_portfolio_filter_gallery_categories', $all_category);
		
} // end of save if	
?>

<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
?>
<div class="wrap">
	<div id="welcome-panel" class="welcome-panel">
		<div class="welcome-panel-content">
			<h1> Welcome to Portfolio Filter Gallery Plugin Docs </h1>
			<p class="about-description"> Getting started with pluign - Follow steps to create & publish portfolio gallery </p>
			<hr>

			<h3> Step 1 - Install & Activate Plugin <h3>
			<p> After downloaded plugin from WordPress. </p>
			<p> Login to your WordPress site upload the plugin, install and activate. </p>
			
			<h3> Step 2 - Add filters for gallery go to the plugin menu "Filters". <h3>
			<h3> Step 3 - Create A Gallery <h3>
			<p> Plugin has been installed on site. </p>
			<p> Now, go to the plugin menu "Portfolio Filter Gallery" and click on "Add New Portfolio Filter Gallery" page. </p>
			<p> Using "Add" Image button upload images through media library. Give image title, image link and use Control (Ctrl) key for add filters in gallery. </p>
			<p> Set gallery setting like Thumbnail Quality & Size, Coulmns Layout, Light Box Style, Hover Effect, Spacing, Order and Custom CSS etc according to you. </p>
			<p> Finally click on "Publish" button to create gallery. </p>
			
			<h3> Step 3 - Display Gallery On Site <h3>
			<p> Our gallery shortcode has been created in last step. </p>
			<p> Copy the heighlighted shortcode above the gallery setting. </p>
			<p> Now create a new Page / Post and paste the copied gallery shortcode into content part. </p>
			<p> Publish the Page / Post and view the page for gallery display. </p>
			<pre>[PFG id=162]</pre>
			<p> Here id = 162 is your gallery post id. </p>
			<hr>
		</div>
		<div class="welcome-panel-content">
			
		</div>
	</div>
</div>
<p class="text-center">
	<br>
	<a href="http://awplife.com/account/signup/portfolio-filter-gallery" target="_blank" class="button button-primary button-hero load-customize hide-if-no-customize"> Buy Premium Version </a>
	<a href="http://awplife.com/demo/portfolio-filter-gallery-premium/" target="_blank" class="button button-primary button-hero load-customize hide-if-no-customize"> Check Live Demo </a>
	<a href="http://awplife.com/demo/portfolio-filter-gallery-premium-admin-demo" target="_blank" class="button button-primary button-hero load-customize hide-if-no-customize"> Try Admin Demo </a>
</p>	