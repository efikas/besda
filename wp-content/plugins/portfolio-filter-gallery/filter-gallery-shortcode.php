<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
add_shortcode('PFG', 'awl_filter_gallery_shortcode');
function awl_filter_gallery_shortcode($post_id) {
	ob_start();

	//js
	wp_enqueue_script('jquery');
	wp_enqueue_script('imagesloaded');
	wp_enqueue_script('awl-ig-bootstrap-js', PFG_PLUGIN_URL .'js/bootstrap.min.js', array('jquery'), '' , true);
	wp_enqueue_script('awl-ig-controls-js', PFG_PLUGIN_URL .'js/controls.js', array('jquery'), '', false);
	wp_enqueue_script('awl-ig-filterizr-js', PFG_PLUGIN_URL .'js/jquery.filterizr.js', array('jquery'), '', false);
	wp_enqueue_script('awl-pfg-YouTubePopUp.jquery-js', PFG_PLUGIN_URL .'js/YouTubePopUp.jquery.js', array('jquery'), '', false);
	
	// css
	wp_enqueue_style('awl-filter-css', PFG_PLUGIN_URL .'css/filter-gallery.css');
	wp_enqueue_style('awl-bootstrap-css', PFG_PLUGIN_URL .'css/ig-bootstrap.css');
	wp_enqueue_style('awl-YouTubePopUp-css', PFG_PLUGIN_URL .'css/YouTubePopUp.css');
	wp_enqueue_style('awl-font-awesome-css', PFG_PLUGIN_URL .'css/font-awesome.min.css');
	
	$pf_gallery_settings = unserialize(base64_decode(get_post_meta( $post_id['id'], 'awl_filter_gallery'.$post_id['id'], true)));
	$pf_gallery_id = $post_id['id'];

	//columns settings
	$gal_thumb_size = $pf_gallery_settings['gal_size'];
	$col_large_desktops = $pf_gallery_settings['col_large_desktops'];
	$col_desktops = $pf_gallery_settings['col_desktops'];
	$col_tablets = $pf_gallery_settings['col_tablets'];
	$col_phones = $pf_gallery_settings['col_phones'];
	//image setting
	$image_numbering = $pf_gallery_settings['image_numbering'];
	$title_thumb = $pf_gallery_settings['title_thumb'];
	//filter sorting controls
	//$filter_bg = $pf_gallery_settings['filter_bg'];
	if(isset($pf_gallery_settings['custom-css'])) $custom_css = $pf_gallery_settings['custom-css']; else $custom_css = "";
	if(isset($pf_gallery_settings['filter_bg'])) $filter_bg = $pf_gallery_settings['filter_bg']; else $filter_bg = "red";
	//filter setting for data-filters
	$pf_gallery_settings = unserialize(base64_decode(get_post_meta( $post_id['id'], 'awl_filter_gallery'.$post_id['id'], true)));
	if(isset($pf_gallery_settings['filters'])) $filters = $pf_gallery_settings['filters']; else  $filters = array();
	// ligtbox style
	if(isset($pf_gallery_settings['light-box'])) $light_box = $pf_gallery_settings['light-box']; else $light_box = 1;
	
	//hover effect
	if(isset($pf_gallery_settings['image_hover_effect_type'])) $image_hover_effect_type = $pf_gallery_settings['image_hover_effect_type']; else $image_hover_effect_type = "2d";
	if($image_hover_effect_type == "no") {
		$image_hover_effect = "";
	} else {
		// hover csss
		wp_enqueue_style('ggp-hover-css', PFG_PLUGIN_URL .'css/hover.css');
	}
	if(isset($pf_gallery_settings['url_target'])) $url_target = $pf_gallery_settings['url_target']; else $url_target = "_new";
	if($image_hover_effect_type == "2d")
		if(isset($pf_gallery_settings['image_hover_effect_one'])) $image_hover_effect = $pf_gallery_settings['image_hover_effect_one']; else $image_hover_effect = "hvr-buzz";
	if($image_hover_effect_type == "bg")
		if(isset($pf_gallery_settings['image-hover-effect-2'])) $image_hover_effect = $pf_gallery_settings['image-hover-effect-2']; else $image_hover_effect = "hvr-bounce-to-top";
	if($image_hover_effect_type == "br")
		if(isset($pf_gallery_settings['image-hover-effect-3'])) $image_hover_effect = $pf_gallery_settings['image-hover-effect-3']; else $image_hover_effect = "hvr-ripple-out";
	if($image_hover_effect_type == "sg")
		if(isset($pf_gallery_settings['image_hover_effect_four'])) $image_hover_effect = $pf_gallery_settings['image_hover_effect_four']; else $image_hover_effect = "hvr-box-shadow-outset";
	if($image_hover_effect_type == "cl")
		if(isset($pf_gallery_settings['image-hover-effect-5'])) $image_hover_effect = $pf_gallery_settings['image-hover-effect-5']; else $image_hover_effect = "hvr-curl-top-left";

	if(isset($pf_gallery_settings['no_spacing'])) $no_spacing = $pf_gallery_settings['no_spacing']; else $no_spacing = 1;
	if(isset($pf_gallery_settings['gray_scale'])) $gray_scale = $pf_gallery_settings['gray_scale']; else $gray_scale = 0;
	if(isset($pf_gallery_settings['thumbnail_order'])) $thumbnail_order = $pf_gallery_settings['thumbnail_order']; else $thumbnail_order = "ASC";
	if(isset($pf_gallery_settings['url_target'])) $url_target = $pf_gallery_settings['url_target']; else $url_target = "_new";
	if(isset($pf_gallery_settings['filter_title_color'])) $filter_title_color = $pf_gallery_settings['filter_title_color']; else $filter_title_color = "#fff";
	?>
	<!-- CSS Part Start From Here-->
	<style>
	
		@keyframes .YouTubePopUp-Content  {
			from {
				transform: translate3d(0, 100%, 0);
				visibility: visible;
			}

			to {
				transform: translate3d(0, 0, 0);
			}
		}

		.YouTubePopUp-Content  {
			animation-name: .YouTubePopUp-Content ;
		}

		.YouTubePopUp-Close { 
			background:url(<?php echo PFG_PLUGIN_URL ?>/img/close-icon-white.png) no-repeat;
			background-size:50px 50px;
			-webkit-background-size:70px 50px;
			-moz-background-size:70px 50px;
			-o-background-size:70px 50px;
		}
		
		
		#filter_gallery_<?php echo $pf_gallery_id; ?> .pfg_img_<?php echo $pf_gallery_id; ?> {
			width: 100% !important;
		}
		
		#filter_gallery_<?php echo $pf_gallery_id; ?> .thumbnail_<?php echo $pf_gallery_id; ?> {
			width:100% !important;
			height:auto;
			margin-bottom: 0px !important;
			
		}
		.filtr-item {
			padding-right:7px !important;
			padding-left:7px !important;
			padding-top:7px !important;
			padding-bottom:7px !important;
		}
		<?php if($no_spacing) { ?>
		#filter_gallery_<?php echo $pf_gallery_id; ?> .col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
			padding-right: 0px !important;
			padding-left: 0px !important;
				
		}
		#filter_gallery_<?php echo $pf_gallery_id; ?> .thumbnail_<?php echo $pf_gallery_id; ?> {
			padding: 0px !important;
			margin-bottom: 0px !important;
			border: 0px !important;
			border-radius: 0px !important;
		}
		.filtr_item_<?php echo $pf_gallery_id; ?> {
			padding: 0rem !important;			
		}
		.item_desc_<?php echo $pf_gallery_id; ?> {
			bottom: 12px  !important;
			left: 0rem !important;
			right: 0rem !important;
		}
		.item_position_<?php echo $pf_gallery_id; ?> {
			left: 2rem !important;
			top: 2rem !important;
		}
		<?php } ?>
		
		.item_desc_<?php echo $pf_gallery_id; ?> , .item_position_<?php echo $pf_gallery_id; ?> {
			<?php if($title_color){ ?>
			color: <?php echo $title_color; ?> !important;
			<?php } ?>
			<?php if($title_bg_color){ ?>
			background-color: <?php echo $title_bg_color; ?> !important;
			<?php }?>

			<?php if($title_bg_opacity){ ?>
			opacity : <?php echo $title_bg_opacity; ?> !important;
			<?php } ?>
			
			<?php if($title_size){ ?>
			font-size :<?php echo $title_size; ?>px !important;
			<?php } ?>			 
		}
		
		
		<?php if($gray_scale){ ?>
		.filtr_item_<?php echo $pf_gallery_id; ?> img {
			filter: grayscale(70%);
		}
		.filtr_item_<?php echo $pf_gallery_id; ?> img:hover {
		   filter: none;
		}
		<?php } ?>
		.simplefilter_<?php echo $pf_gallery_id; ?> li {
			background-color: #ccc !important;
			color: <?php echo $filter_title_color; ?> !important;
		}
		
		.simplefilter_<?php echo $pf_gallery_id; ?> li:hover {
			background-color: <?php echo $filter_bg; ?> !important;
		}
		
		.simplefilter_<?php echo $pf_gallery_id; ?> li.active {
			background-color: <?php echo $filter_bg; ?> !important;
		}
		
		.thumbnail_<?php echo $pf_gallery_id; ?>{
			<?php if($border_hide){ ?>
			border: <?php echo $border_size; ?>px solid <?php echo $border_color; ?> !important;
			padding: 0px !important;
			<?php } ?>
		}
		
		.sortandshuffle_<?php echo $pf_gallery_id; ?> .sort_btn_<?php echo $pf_gallery_id; ?> {
				<?php if($sorting_control_color){ ?>
				background-color:<?php echo $sorting_control_color; ?> !important;
			<?php } ?>
		} 
		
		.sortandshuffle_<?php echo $pf_gallery_id; ?> .shuffle_btn_<?php echo $pf_gallery_id; ?> {
			<?php if($shuffle_bg){ ?>
			
				background-color:<?php echo $shuffle_bg["H"]; ?> !important;
			<?php } ?>
		}
		
		<?php echo $custom_css; ?>
	</style>
	<?php
	
	// load without lightbox gallery output
	if($light_box == 0) {
		require('filters-gallery-output.php');
	}
	// load blue imp lightbox gallery output
	
	if($light_box == 5) {
		require('pfg-bootstrap-lightbox.php');
	}
	return ob_get_clean();
}
?>