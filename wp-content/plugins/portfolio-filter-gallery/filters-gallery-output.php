<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Blue Imp Light Box Load File
 */

$allimages = array(  'p' => $pf_gallery_id, 'post_type' => 'awl_filter_gallery', 'orderby' => 'ASC');
$loop = new WP_Query( $allimages );
while ( $loop->have_posts() ) : $loop->the_post();
	$post_id = get_the_ID();
	$all_category = get_option('awl_portfolio_filter_gallery_categories');

	// collect all selected filters assigned on images
	$all_selected_filters = array();
	foreach ($filters as $filters_key => $filters_value) {
		if(is_array($filters_value)) {
			$all_selected_filters = array_merge($all_selected_filters, $filters_value);
		}
	}
	?>
	
	<div class="row text-center">
		<ul class="simplefilter simplefilter_<?php echo $pf_gallery_id; ?>">
			<?php 
			$all_category_val = $all_category[0]; ?>
			<li class="active" data-filter="all"><?php _e($all_category_val, PFG_TXTDM); ?></li>
			<?php
			if(is_array($all_selected_filters) && count($all_selected_filters)) {
				$all_selected_filters = array_unique($all_selected_filters ); // remove same key
				foreach ($all_selected_filters as $filter_key) {
					?>
					<li data-filter="<?php echo $filter_key ?>"><?php  _e($all_category[$filter_key], PFG_TXTDM); ?></li>
					<?php
				}
			}?>
		</ul>
	</div>
	<div class="row loading-wrapper text-center">
		<img src="<?php echo PFG_PLUGIN_URL ?>/img/loading-icon.gif" width="60">
	</div>
	<div id="filter_gallery_<?php echo $pf_gallery_id; ?>" class="row filtr-container filters-div">
		
		<?php
		if(isset($pf_gallery_settings['image-ids']) && count($pf_gallery_settings['image-ids']) > 0) {
			$count = 0;
			if($thumbnail_order == "DESC") {
				$pf_gallery_settings['image-ids'] = array_reverse($pf_gallery_settings['image-ids']);
			}
			if($thumbnail_order == "RANDOM") {
				shuffle($pf_gallery_settings['image-ids']);
			}			
			$no = 1;
			foreach($pf_gallery_settings['image-ids'] as $attachment_id) {
				//$attachment_id;
				$image_link_url =  $pf_gallery_settings['image-link'][$count];
				$image_type = $pf_gallery_settings['slide-type'][$attachment_id];
				
				$thumb = wp_get_attachment_image_src($attachment_id, 'thumb', true);
				$thumbnail = wp_get_attachment_image_src($attachment_id, 'thumbnail', true);
				$medium = wp_get_attachment_image_src($attachment_id, 'medium', true);
				$large = wp_get_attachment_image_src($attachment_id, 'large', true);
				$full = wp_get_attachment_image_src($attachment_id, 'full', true);
				$postthumbnail = wp_get_attachment_image_src($attachment_id, 'post-thumbnail', true);
				$attachment_details = get_post( $attachment_id );
				$href = get_permalink( $attachment_details->ID );
				$src = $attachment_details->guid;
				$title = $attachment_details->post_title;
				$description = $attachment_details->post_content;
				
				//set thumbnail size
				if($gal_thumb_size == "thumbnail") { $thumbnail_url = $thumbnail[0]; }
				if($gal_thumb_size == "medium") { $thumbnail_url = $medium[0]; }
				if($gal_thumb_size == "large") { $thumbnail_url = $large[0]; }
				if($gal_thumb_size == "full") { $thumbnail_url = $full[0]; }
				
				// seach attachment id in to $filters and get all filter ids
				//$pfg_filters = $pf_gallery_settings['filters'];
				foreach ($filters as $pfg_filters_key => $pfg_filters_values) {
				}
				if (array_key_exists($attachment_id, $filters)) {
					$filter_key_array = $filters[$attachment_id];
					$prefix = $filter_keys = '';
					
					if(count($filter_key_array) > 1) {
						foreach ($filter_key_array as $filter_key => $filter_value) {
							$filter_keys .= $prefix . $filter_value;
							$prefix = ', ';
						}
					} else {
						$filter_keys = $filter_key_array[0];						
					}
				}
				// if no filter selected
				if(!isset($filter_keys)) {
					$filter_keys = 1;
				}
				
				?>
				
				<?php 
				if($image_link_url) { 
					if($image_type == 'image') { 
						?>
						<a href="<?php echo $image_link_url; ?>" title="<?php echo $title; ?>" target="<?php echo $url_target; ?>">
							<div data-category="<?php echo $filter_keys; ?>" data-sort="<?php echo $title; ?>" class="filtr-item filtr_item_<?php echo $pf_gallery_id; ?> single_one <?php echo $col_large_desktops; ?> <?php echo $col_desktops; ?> <?php echo $col_tablets; ?> <?php echo $col_phones; ?>">
								<img class="thumbnail thumbnail_<?php echo $pf_gallery_id; ?> pfg-img pfg_img_<?php echo $pf_gallery_id; ?> img-responsive <?php echo $image_hover_effect; ?>" src="<?php echo $thumbnail_url; ?>" alt="<?php echo get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ); ?>">
								<?php if($image_numbering) {?>
									<div class="item-position item_position_<?php echo $pf_gallery_id; ?>"><?php echo $no; ?></div>
								<?php } ?>
								<?php if($title_thumb == "show") {?>
								<span class="item-desc item_desc_<?php echo $pf_gallery_id; ?>"><?php _e($title, PFG_TXTDM); ?></span>
								<?php } ?>
							</div>
						</a>
						<?php 
					} // image with link
					if($image_type == 'video') {
						?>
						<a class="bla-2" href="<?php echo $image_link_url; ?>" title="<?php echo $title; ?>" target="<?php echo $url_target; ?>">
							<div data-category="<?php echo $filter_keys; ?>" data-sort="<?php echo $title; ?>" class="filtr-item filtr_item_<?php echo $pf_gallery_id; ?> single_one <?php echo $col_large_desktops; ?> <?php echo $col_desktops; ?> <?php echo $col_tablets; ?> <?php echo $col_phones; ?>">
								<span class="snipv12">
									<img class="thumbnail thumbnail_<?php echo $pf_gallery_id; ?> pfg-img pfg_img_<?php echo $pf_gallery_id; ?> img-responsive <?php echo $image_hover_effect; ?>" src="<?php echo $thumbnail_url; ?>" alt="<?php echo get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ); ?>">
									<?php if (!strpos($image_link_url, 'vimeo')) { 
									?>
									<i class=""><img src="<?php echo PFG_PLUGIN_URL ?>/img/p-youtube.png"></i>
									<?php
									} else {
									?>
									<i class="fa fa-youtube-play"></i>
									<?php
									} 
									?>
								</span>
							</div>
						</a>
						<?php 	
					}  // image with video
				} else { 
					?>
					<div data-category="<?php echo $filter_keys; ?>" data-sort="<?php echo $title; ?>" class="filtr-item filtr_item_<?php echo $pf_gallery_id; ?> single_one <?php echo $col_large_desktops; ?> <?php echo $col_desktops; ?> <?php echo $col_tablets; ?> <?php echo $col_phones; ?>">
						<img class="thumbnail thumbnail_<?php echo $pf_gallery_id; ?> pfg-img pfg_img_<?php echo $pf_gallery_id; ?> img-responsive <?php echo $image_hover_effect; ?>" src="<?php echo $thumbnail_url; ?>" alt="<?php echo get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ); ?>">
						<?php if($image_numbering) {?>
							<div class="item-position item_position_<?php echo $pf_gallery_id; ?>"><?php echo $no; ?></div>
						<?php } ?>
						<?php if($title_thumb == "show") {?>
						<span class="item-desc item_desc_<?php echo $pf_gallery_id; ?>"><?php _e($title, PFG_TXTDM); ?></span>
						<?php } ?>
					</div>
					<?php 
				} ?>
				<?php
					
				$no++;
				$count++;
				
			}// end of attachment foreach
		} else {
			_e('Sorry! No image gallery found ', PFG_TXTDM);
			echo ":[PFG id=$post_id]";
		} // end of if esle of images avaialble check into imager
		?>
		
	</div>
	
<?php
endwhile;
wp_reset_query();
?>
<script>
jQuery('#filter_gallery_<?php echo $pf_gallery_id; ?>').hide();
jQuery('.loading-wrapper').show();
jQuery( window ).load(function() {
	
	jQuery('.filtr-item').addClass('animateonload');
	jQuery('#filter_gallery_<?php echo $pf_gallery_id; ?>').show();
	jQuery('.loading-wrapper').hide();
	
	jQuery(".loader_img").hide();
	jQuery(".lg_load_more").show();
	jQuery(".filtr-container").css("opacity", 1);
	//Filterizd Default options
	options = {
		animationDuration: 0.5,
		callbacks: {
			onFilteringStart: function() { },
			onFilteringEnd: function() { },
			onShufflingStart: function() { },
			onShufflingEnd: function() { },
			onSortingStart: function() { },
			onSortingEnd: function() { }
		},
		
		filter: 'all',
		 filterOutCss: {
		  top:'0px',
			left:'0px',
			opacity: 0.001,
			transform: ''
		  },
		  filterInCss: {
			  top:'0px',
			left:'0px',
			opacity: 1,
			transform: ''
		  },
		layout: 'sameWidth',
		selector: '#filter_gallery_<?php echo $pf_gallery_id; ?>',
		setupControls: true
	}
	var filterizd = jQuery('#filter_gallery_<?php echo $pf_gallery_id; ?>').filterizr(options);
	
	// video player
	jQuery(function(){
      jQuery("a.bla-1").YouTubePopUp();
      jQuery("a.bla-2").YouTubePopUp( { autoplay: 0 } ); // Disable autoplay
	});
});   
</script>