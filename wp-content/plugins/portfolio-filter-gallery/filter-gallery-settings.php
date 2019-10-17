<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
//CSS
wp_enqueue_script('jquery');
wp_enqueue_style('pfg-metabox-css', PFG_PLUGIN_URL . 'css/metabox.css');

//load settings
$pf_gallery_settings = unserialize(base64_decode(get_post_meta( $post->ID, 'awl_filter_gallery'.$post->ID, true)));
$image_gallery_id = $post->ID;
/* echo "<pre>";
print_r($pf_gallery_settings);
echo "</pre>"; */
?>
<div class="row gallery-content-photo-wall">
	<!--Add New Image Button-->
	<div class="file-upload">
		<div class="image-upload-wrap">
			<input class="add-new-images file-upload-input" id="upload_image_button" name="upload_image_button" value="Upload Image" />
			<div class="drag-text">
				<h3>ADD IMAGES</h3>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12 bhoechie-tab-container">
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 bhoechie-tab-menu">
			<div class="list-group">
				<a href="#" class="list-group-item active text-center">
					<span class="dashicons dashicons-format-image"></span><br/>Photos
				</a>
				<a href="#" class="list-group-item text-center">
					<span class="dashicons dashicons-admin-generic"></span><br/>Config
				</a>
				<a href="#" class="list-group-item text-center">
					<span class="dashicons dashicons-editor-insertmore"></span><br/>Filters
				</a>
				<a href="#" class="list-group-item text-center">
					<span class="dashicons dashicons-welcome-view-site"></span><br/>LightBox
				</a>
				<a href="#" class="list-group-item text-center">
					<span class="dashicons dashicons-media-code"></span><br/>Custom CSS
				</a>
				<a href="#" class="list-group-item text-center" style="background-color:#e6e6e6;">
					<span class="dashicons dashicons-layout"></span><br/>Layouts
				</a>
				<a href="#" class="list-group-item text-center" style="background:#e6e6e6;">
					<span class="dashicons dashicons-screenoptions"></span><br/>Load More
				</a>
				
				<a href="#" class="list-group-item text-center" style="background:#e6e6e6;">
					<span class="dashicons dashicons-unlock"></span><br/>Upgrade To Pro
				</a>
			</div>
		</div>
		<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 bhoechie-tab">
			<!-- flight section -->
			<div class="bhoechie-tab-content active">
				<h1>Photos</h1>
				<hr>
				<!--Photos from wordpress-->
				<div id="image-gallery">
					<p><strong>First add filters for images by click on <a href="edit.php?post_type=awl_filter_gallery&page=pfg-filter-page">FILTERS</a> menu link.</strong></p>
					<p><strong>Please do not reapeat images. Use control ( Ctrl ) or shift ( Shift ) key for select multiple filters. For unselect filters use ( Ctrl ) key.</strong></p>

					<input type="button" id="remove-all-images" name="remove-all-images" class="button button-large remove-all-images" rel="" value="<?php _e('Delete All Images', PFG_TXTDM); ?>">
					<br>
					<ul id="remove-images" class="sbox">
						<?php
						$allimagesetting = unserialize(base64_decode(get_post_meta( $post->ID, 'awl_filter_gallery'.$post->ID, true)));
						$all_category = get_option('awl_portfolio_filter_gallery_categories');

						if(isset($allimagesetting['image-ids'])) {
							if (array_key_exists("filters",$allimagesetting)) {
							$filters = $allimagesetting['filters'];
						}
						$count = 0;
						foreach($allimagesetting['image-ids'] as $id) {
						$thumbnail = wp_get_attachment_image_src($id, 'medium', true);
						$attachment = get_post( $id );
						$image_link = $allimagesetting['image-link'][$count];
						if(isset($allimagesetting['image-desc'])) {
							$image_desc = $allimagesetting['image-desc'][$count];
						} else {
							$image_desc = "";
						}
						$image_type =  $allimagesetting['slide-type'][$id];
						?>
						<li class="item image">
							<img class="new-image" src="<?php echo $thumbnail[0]; ?>" alt="<?php echo get_the_title($id); ?>" style="height: 150px; width: 98%; border-radius: 8px;">
							<input type="hidden" id="image-ids[]" name="image-ids[]" value="<?php echo $id; ?>" />

							<select id="slide-type[<?php echo $id; ?>]" name="slide-type[<?php echo $id; ?>]" class="form-control" style="width: 98% !important;" placeholder="Image Title" value="<?php echo $image_type; ?>" >
								<option value="image" <?php if($image_type == "image") echo "selected=selected"; ?>> Image </option>
								<option value="video" <?php if($image_type == "video") echo "selected=selected"; ?>> Video </option>
							</select>

							<input type="text" name="image-title[]" id="image-title[]" style="width: 98%;" placeholder="Image Title" value="<?php echo get_the_title($id); ?>">
							<textarea name="image-desc[]" id="image-desc[]" style="width: 98%; display:none;" placeholder="Type discription here.."><?php echo stripcslashes($image_desc); ?></textarea>
							<input type="text" name="image-link[]" id="image-link[]" style="width: 98%;" placeholder="Video URL / Link URL" value="<?php echo $image_link; ?>">
							<?php
							if(isset($filters[$id])) {
							$selected_filters_array = $filters[$id];
							} else {
							$selected_filters_array = array();
							}
							?>
							<select class="pfg-filters form-control" name="filters[<?php echo $id; ?>][]" multiple="multiple" id="filters">
							<?php
							foreach ($all_category as $key => $value) {
							if($key != 0) {
							?><strong><option value="<?php echo $key; ?>" <?php if(count($selected_filters_array)) { if(in_array($key, $selected_filters_array)) echo "selected=selected"; } ?>><?php echo ucwords($value); ?></option></strong><?php
							}
							}
							?>
							</select>
							<?php foreach ($selected_filters_array as $key => $value) { 
							//print_r($selected_filters_array);
							?>
							<input type="hidden" name="filter-image[<?php echo $value; ?>][]" id="filter-image[]" style="width: 98%;" value="<?php echo $id; ?>" >
							<?php } ?>
							<a class="pw-trash-icon" name="remove-image" id="remove-image" href="#"><span class="dashicons dashicons-trash"></span></a>
						</li>

						<?php $count++; } // end of foreach
						} //end of if
						?>
					</ul>
				</div>
			</div>
			
			<!-- Configuration -->
			<div class="bhoechie-tab-content">
				<h1>Configuration</h1>
				<hr>
				<!--Grid-->
				<div class="pw_grid_layout_config">
					<div class="row">
						<div class="col-md-4">
							<div class="ma_field_discription">
								<h4>Gallery Thumbnail Size</h4>
								<p>Choose Gallery Thumbnail Size</p> 
							</div>
						</div>
						<div class="col-md-8">
							<div class="ma_field panel-body">
								<?php if(isset($pf_gallery_settings['gal_size'])) $gal_size = $pf_gallery_settings['gal_size']; else $gal_size = "full"; ?>
								<select id="gal_size" name="gal_size" class="selectbox_settings form-control">
									<option value="thumbnail" <?php if($gal_size == "thumbnail") echo "selected=selected"; ?>>Thumbnail - 150 x 150</option>
									<option value="medium" <?php if($gal_size == "medium") echo "selected=selected"; ?>>Medium - 300 x 169</option>
									<option value="large" <?php if($gal_size == "large") echo "selected=selected"; ?>>Large - 840 x 473</option>
									<option value="full" <?php if($gal_size == "full") echo "selected=selected"; ?>>Full Size - 1280 x 720</option>
								</select>
							</div>
						</div>
					</div>
					<div id="" class="meta_box_holder_inside">
						<h2>Columns Settings</h2>
						<div class="row">
							<div class="col-md-4">
								<div class="ma_field_discription">
									<h4>Columns On Large Desktops</h4>
									<p>Set icon on photos</p> 
								</div>
							</div>
							<div class="col-md-8">
								<div class="ma_field panel-body">
									<div class="switch-field em_size_field">
										<?php if(isset($pf_gallery_settings['col_large_desktops'])) $col_large_desktops = $pf_gallery_settings['col_large_desktops']; else $col_large_desktops = "col-lg-3"; ?>
										<select id="col_large_desktops" name="col_large_desktops" class="selectbox_settings form-control">
											<option value="col-lg-12" <?php if($col_large_desktops == "col-lg-12") echo "selected=selected"; ?>>1 Column</option>
											<option value="col-lg-6" <?php if($col_large_desktops == "col-lg-6") echo "selected=selected"; ?>>2 Column</option>
											<option value="col-lg-4" <?php if($col_large_desktops == "col-lg-4") echo "selected=selected"; ?>>3 Column</option>
											<option value="col-lg-3" <?php if($col_large_desktops == "col-lg-3") echo "selected=selected"; ?>>4 Column</option>
											<option value="col-lg-2" <?php if($col_large_desktops == "col-lg-2") echo "selected=selected"; ?>>6 Column</option>
											<option value="col-lg-1" <?php if($col_large_desktops == "col-lg-1") echo "selected=selected"; ?>>12 Column</option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="ma_field_discription">
									<h4>Columns On Desktops</h4>
									<p>Set icon on photos</p> 
								</div>
							</div>
							<div class="col-md-8">
								<div class="ma_field panel-body">
									<div class="switch-field em_size_field">
										<?php if(isset($pf_gallery_settings['col_desktops'])) $col_desktops = $pf_gallery_settings['col_desktops']; else $col_desktops = "col-lg-3"; ?>
										<select id="col_desktops" name="col_desktops" class="selectbox_settings form-control">
											<option value="col-md-12" <?php if($col_desktops == "col-md-12") echo "selected=selected"; ?>>1 Column</option>
											<option value="col-md-6" <?php if($col_desktops == "col-md-6") echo "selected=selected"; ?>>2 Column</option>
											<option value="col-md-4" <?php if($col_desktops == "col-md-4") echo "selected=selected"; ?>>3 Column</option>
											<option value="col-md-3" <?php if($col_desktops == "col-md-3") echo "selected=selected"; ?>>4 Column</option>
											<option value="col-md-2" <?php if($col_desktops == "col-md-2") echo "selected=selected"; ?>>6 Column</option>
											<option value="col-md-1" <?php if($col_desktops == "col-md-1") echo "selected=selected"; ?>>12 Column</option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="ma_field_discription">
									<h4>Columns On Tablets</h4>
									<p>Set icon on photos</p> 
								</div>
							</div>
							<div class="col-md-8">
								<div class="ma_field panel-body">
									<div class="switch-field em_size_field">
										<?php if(isset($pf_gallery_settings['col_tablets'])) $col_tablets = $pf_gallery_settings['col_tablets']; else $col_tablets = "col-sm-4"; ?>
										<select id="col_tablets" name="col_tablets" class="selectbox_settings form-control">
											<option value="col-sm-12" <?php if($col_tablets == "col-sm-12") echo "selected=selected"; ?>>1 Column</option>
											<option value="col-sm-6" <?php if($col_tablets == "col-sm-6") echo "selected=selected"; ?>>2 Column</option>
											<option value="col-sm-4" <?php if($col_tablets == "col-sm-4") echo "selected=selected"; ?>>3 Column</option>
											<option value="col-sm-3" <?php if($col_tablets == "col-sm-3") echo "selected=selected"; ?>>4 Column</option>
											<option value="col-sm-2" <?php if($col_tablets == "col-sm-2") echo "selected=selected"; ?>>6 Column</option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="ma_field_discription">
									<h4>Columns On Phone</h4>
									<p>Set icon on photos</p> 
								</div>
							</div>
							<div class="col-md-8">
								<div class="ma_field panel-body">
									<div class="switch-field em_size_field">
										<?php if(isset($pf_gallery_settings['col_phones'])) $col_phones = $pf_gallery_settings['col_phones']; else $col_phones = "col-xs-6"; ?>
										<select id="col_phones" name="col_phones" class="selectbox_settings form-control">
											<option value="col-xs-12" <?php if($col_phones == "col-xs-12") echo "selected=selected"; ?>>1 Column</option>
											<option value="col-xs-6" <?php if($col_phones == "col-xs-6") echo "selected=selected"; ?>>2 Column</option>
											<option value="col-xs-4" <?php if($col_phones == "col-xs-4") echo "selected=selected"; ?>>3 Column</option>
											<option value="col-xs-3" <?php if($col_phones == "col-xs-3") echo "selected=selected"; ?>>4 Column</option>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--Hover-->
					<div class="row">
						<div class="col-md-4">
							<div class="ma_field_discription">
								<h4>Image Hover Effects</h4>
								<p>Choose Image Hover Effects</p> 
							</div>
						</div>
						<div class="col-md-8">
							<div class="ma_field panel-body">
								<div class="col-md-9">
									<p class="switch-field em_size_field hover_field">
										<?php if(isset($pf_gallery_settings['image_hover_effect_type'])) $image_hover_effect_type = $pf_gallery_settings['image_hover_effect_type']; else $image_hover_effect_type = "sg"; ?>
										<input type="radio" name="image_hover_effect_type" id="image_hover_effect_type1" value="no" <?php if($image_hover_effect_type == "no") echo "checked=checked"; ?>>
										<label for="image_hover_effect_type1"><?php _e('None', PFG_TXTDM); ?></label>
										<input type="radio" name="image_hover_effect_type" id="image_hover_effect_type2" value="sg" <?php if($image_hover_effect_type == "sg") echo "checked=checked"; ?>>
										<label for="image_hover_effect_type2"><?php _e('Shadow', PFG_TXTDM); ?></label>
									</p>
								</div>
								<!-- 2d -->
								<div class="he_four">
									<?php if(isset($pf_gallery_settings['image_hover_effect_four'])) $image_hover_effect_four = $pf_gallery_settings['image_hover_effect_four']; else $image_hover_effect_four = "hvr-grow-shadow"; ?>
									<select name="image_hover_effect_four" id="image_hover_effect_four" class="selectbox_settings">
										<optgroup label="Shadow and Glow Transitions Effects" class="sg">
											<option value="hvr-grow-shadow" <?php if($image_hover_effect_four == "hvr-grow-shadow") echo "selected=selected"; ?>><?php _e('Grow Shadow', PFG_TXTDM); ?></option>
											<option value="hvr-float-shadow" <?php if($image_hover_effect_four == "hvr-float-shadow") echo "selected=selected"; ?>><?php _e('Float Shadow', PFG_TXTDM); ?></option>
											<option value="hvr-glow" <?php if($image_hover_effect_four == "hvr-glow") echo "selected=selected"; ?>><?php _e('Glow', PFG_TXTDM); ?></option>
											<!--<option value="hvr-shadow-radial" <?php //if($image_hover_effect_four == "hvr-shadow-radial") echo "selected=selected"; ?>>Shadow Radial</option>-->
											<option value="hvr-box-shadow-outset" <?php if($image_hover_effect_four == "hvr-box-shadow-outset") echo "selected=selected"; ?>><?php _e('Box Shadow Outset', PFG_TXTDM); ?></option>
											<option value="hvr-box-shadow-inset" <?php if($image_hover_effect_four == "hvr-box-shadow-inset") echo "selected=selected"; ?>><?php _e('Box Shadow Inset', PFG_TXTDM); ?></option>
										</optgroup>
									</select>
								</div>
							</div>
						</div>
					</div>
					<!--Thumbnail seting-->
					<div class="row">
						<div class="col-md-4">
							<div class="ma_field_discription">
								<h4>Title & discription On Thumbnail</h4>
								<p>Title & discription On Thumbnail</p> 
							</div>
						</div>
						<div class="col-md-8">
							<div class="ma_field panel-body">
								<p class="switch-field em_size_field">
									<?php if(isset($pf_gallery_settings['title_thumb'])) $title_thumb = $pf_gallery_settings['title_thumb']; else $title_thumb = "show"; ?>
									<input type="radio" name="title_thumb" id="title_thumb1" value="show" <?php if($title_thumb == "show") echo "checked=checked"; ?>>
									<label for="title_thumb1"><?php _e('Show', PFG_TXTDM); ?></label>
									<input type="radio" name="title_thumb" id="title_thumb2" value="hide" <?php if($title_thumb == "hide") echo "checked=checked"; ?>>
									<label for="title_thumb2"><?php _e('Hide', PFG_TXTDM); ?></label>
								</p>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4">
							<div class="ma_field_discription">
								<h4>Show Numbering On Thumbnails</h4>
								<p>Show Numbering On Thumbnails</p> 
							</div>
						</div>
						<div class="col-md-8">
							<div class="ma_field panel-body">
								<p class="switch-field em_size_field">
									<?php if(isset($pf_gallery_settings['image_numbering'])) $image_numbering = $pf_gallery_settings['image_numbering']; else $image_numbering = "0"; ?>
									<input type="radio" name="image_numbering" id="image_numbering1" value="1" <?php if($image_numbering == 1) echo "checked=checked"; ?>>
									<label for="image_numbering1"><?php _e('Yes', PFG_TXTDM); ?></label>
									<input type="radio" name="image_numbering" id="image_numbering2" value="0" <?php if($image_numbering == 0) echo "checked=checked"; ?>>
									<label for="image_numbering2"><?php _e('No', PFG_TXTDM); ?></label>
								</p>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="ma_field_discription">
								<h4>Hide Thumbnails Spacing</h4>
								<p> Hide Thumbnails Spacing</p> 
							</div>
						</div>
						<div class="col-md-8">
							<div class="ma_field panel-body">
								<p class="switch-field em_size_field">		
									<?php if(isset($pf_gallery_settings['no_spacing'])) $no_spacing = $pf_gallery_settings['no_spacing']; else $no_spacing = 0; ?>
									<input type="radio" name="no_spacing" id="no_spacing1" value="1" <?php if($no_spacing == 1) echo "checked=checked"; ?>>
									<label for="no_spacing1"><?php _e('Yes', PFG_TXTDM); ?></label>
									<input type="radio" name="no_spacing" id="no_spacing2" value="0" <?php if($no_spacing == 0) echo "checked=checked"; ?>>
									<label for="no_spacing2"><?php _e('No', PFG_TXTDM); ?></label>
								</p>
							</div>
						</div>
					</div>
				</div>
				<!--URL Gray Scale-->
				<div class="row">
					<div class="col-md-4">
						<div class="ma_field_discription">
							<h4>Image Gray Scale (Gray Effect)</h4>
							<p> Image Gray Scale (Gray Effect)</p> 
						</div>
					</div>
					<div class="col-md-8">
						<div class="ma_field panel-body">
							<p class="switch-field em_size_field">
								<?php if(isset($pf_gallery_settings['gray_scale'])) $gray_scale = $pf_gallery_settings['gray_scale']; else $gray_scale = 0; ?>
								<input type="radio" name="gray_scale" id="gray_scale1" value="1" <?php if($gray_scale == 1) echo "checked=checked"; ?>>
								<label for="gray_scale1"><?php _e('Yes', PFG_TXTDM); ?></label>
								<input type="radio" name="gray_scale" id="gray_scale2" value="0" <?php if($gray_scale == 0) echo "checked=checked"; ?>>
								<label for="gray_scale2"><?php _e('No', PFG_TXTDM); ?></label>
							</p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="ma_field_discription">
							<h4>Open Image Link URL</h4>
							<p> Open Image Link URL</p> 
						</div>
					</div>
					<div class="col-md-8">
						<div class="ma_field panel-body">
							<p class="switch-field em_size_field hover_field">		
								<?php if(isset($pf_gallery_settings['url_target'])) $url_target = $pf_gallery_settings['url_target']; else $url_target = "_blank"; ?>
								<input type="radio" name="url_target" id="url_target1" value="_blank" <?php if($url_target == "_blank") echo "checked=checked"; ?>>
								<label for="url_target1"><?php _e('Into New Tab', PFG_TXTDM); ?></label>
								<input type="radio" name="url_target" id="url_target2" value="_self" <?php if($url_target == "_self") echo "checked=checked"; ?>>
								<label for="url_target2"><?php _e('Into Same Tab', PFG_TXTDM); ?></label>
							</p>
						</div>
					</div>
				</div>
			</div>
			<div class="bhoechie-tab-content">
				<h1>Filters And Sorting controls Settings</h1>
				<hr>
				
				<!-- FIlters-->
				<div class="row">
					<div class="col-md-4">
						<div class="ma_field_discription">
							<h4>Filter Background Color</h4>
							<p>Filter Background Color </p> 
						</div>
					</div>
					<div class="col-md-8">
						<div class="ma_field panel-body">
							<?php if(isset($pf_gallery_settings['filter_bg'])) $filter_bg = $pf_gallery_settings['filter_bg']; else $filter_bg = '#656565'; ?>
							<input type="text" class="form-control" id="filter_bg" name="filter_bg" placeholder="chose form color" value="<?php echo $filter_bg; ?>" default-color="<?php echo $filter_bg; ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="ma_field_discription">
							<h4>Filter Title Color</h4>
							<p>Filter Title Color </p> 
						</div>
					</div>
					<div class="col-md-8">
						<div class="ma_field panel-body">
							<?php if(isset($pf_gallery_settings['filter_title_color'])) $filter_title_color = $pf_gallery_settings['filter_title_color']; else $filter_title_color = '#ffffff'; ?>
							<input type="text" class="form-control" id="filter_title_color" name="filter_title_color" placeholder="chose form color" value="<?php echo $filter_title_color; ?>" default-color="<?php echo $filter_title_color; ?>">
						</div>
					</div>
				</div>
			</div>
			<div class="bhoechie-tab-content">
				<h1>LightBox Configuration</h1>
				<hr>
				<!-- lighbox -->
				<div class="row">
					<div class="col-md-4">
						<div class="ma_field_discription">
							<h4>Enable Lightbox</h4>
							<p>Enable or desable lightbox for gallery </p> 
						</div>
					</div>
					<div class="col-md-8">
						<div class="ma_field panel-body">
							<!--Theme 2 lighbox -->
							<div class="">
								<?php if(isset($pf_gallery_settings['light-box'])) $light_box = $pf_gallery_settings['light-box']; else $light_box = 5; ?>
								<select name="light-box" id="light-box" class="selectbox_settings form-control">	
									<option value="0" <?php if($light_box == 0) echo "selected=selected"; ?>><?php _e('None', PFG_TXTDM); ?></option>
									<option value="5" <?php if($light_box == 5) echo "selected=selected"; ?>><?php _e('Bootstrap 3 Light Box', PFG_TXTDM); ?></option>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<!-- CSS -->
			<div class="bhoechie-tab-content">
				<h1>Custum CSS </h1>
				<hr>
				<div class="row">
					<div class="col-md-4">
						<div class="ma_field_discription">
							<h4>Custum CSS</h4>
							<p>Apply your own custum CSS. Don't use style tag</p> 
						</div>
					</div>
					<div class="col-md-8">
						<div class="panel-body">
							<?php if(isset($pf_gallery_settings['custom-css'])) $custom_css = $pf_gallery_settings['custom-css']; else $custom_css = ""; ?>
							<textarea class="form-control" rows="12" id="custom-css" name="custom-css"><?php echo $custom_css; ?></textarea>
						</div>
					</div>
				</div>
			</div>
			
			
			<!-- Gallery section -->
			<div class="bhoechie-tab-content">
				<h1>Pro Feature</h1>
				<p>
					<br>
					<a href="http://awplife.com/account/signup/portfolio-filter-gallery" target="_blank" class="button button-primary button-hero load-customize hide-if-no-customize">Buy Premium Version</a>
					<a href="http://awplife.com/demo/portfolio-filter-gallery-premium/" target="_blank" class="button button-primary button-hero load-customize hide-if-no-customize">Check Live Demo</a>
					<a href="http://awplife.com/demo/portfolio-filter-gallery-premium-admin-demo" target="_blank" class="button button-primary button-hero load-customize hide-if-no-customize">Try Admin Demo</a>
				</p>	
			</div>
			
			<!-- Load More -->
			<div class="bhoechie-tab-content">
				<h1>Pro Feature</h1>
				<p>
					<br>
					<a href="http://awplife.com/account/signup/portfolio-filter-gallery" target="_blank" class="button button-primary button-hero load-customize hide-if-no-customize">Buy Premium Version</a>
					<a href="http://awplife.com/demo/portfolio-filter-gallery-premium/" target="_blank" class="button button-primary button-hero load-customize hide-if-no-customize">Check Live Demo</a>
					<a href="http://awplife.com/demo/portfolio-filter-gallery-premium-admin-demo" target="_blank" class="button button-primary button-hero load-customize hide-if-no-customize">Try Admin Demo</a>
				</p>	
			</div>
			
			
			<!-- Upgrade -->
			<div class="bhoechie-tab-content">
				<p class="">
					<br>
					<a href="http://awplife.com/account/signup/portfolio-filter-gallery" target="_blank" class="button button-primary button-hero load-customize hide-if-no-customize">Buy Premium Version</a>
					<a href="http://awplife.com/demo/portfolio-filter-gallery-premium/" target="_blank" class="button button-primary button-hero load-customize hide-if-no-customize">Check Live Demo</a>
					<a href="http://awplife.com/demo/portfolio-filter-gallery-premium-admin-demo" target="_blank" class="button button-primary button-hero load-customize hide-if-no-customize">Try Admin Demo</a>
				</p>	
				<hr>
				<style>
					.awp_bale_offer {
					background-image: url("<?php echo PFG_PLUGIN_URL ?>/img/awp-bale.jpg");
					background-repeat:no-repeat;
					padding:30px;
					}
					.awp_bale_offer h1 {
					font-size:35px;
					color:#006B9F;
					}
					.awp_bale_offer h3 {
					font-size:25px;
					color:#000000;
					}
				</style>
				<div class="row awp_bale_offer">
					<div class="">
						<h1>Plugin's Bale Offer</h1>
						<h3> Get All Premium Plugin ( Personal Licence) in just $149 </h3>
						<h3><strike> $399</strike> For $149 Only </h3>
					</div>
					<div class="">
						<a href="http://awplife.com/account/signup/all-premium-plugins" target="_blank" class="button button-primary button-hero load-customize hide-if-no-customize"> BUY NOW </a>
					</div>
				</div>
				<hr>
				<p class="">
					<h1><strong> Try Our Other Free Plugins: </strong></h1>
					<br>
					<a href="https://wordpress.org/plugins/new-grid-gallery/" target="_blank" class="button button-primary load-customize hide-if-no-customize"> Grid Gallery </a>
					<a href="https://wordpress.org/plugins/new-social-media-widget/" target="_blank" class="button button-primary load-customize hide-if-no-customize"> Social Media </a>
					<a href="https://wordpress.org/plugins/new-image-gallery/" target="_blank" class="button button-primary load-customize hide-if-no-customize"> Image Gallery </a>
					<a href="https://wordpress.org/plugins/new-photo-gallery/" target="_blank" class="button button-primary load-customize hide-if-no-customize"> Photo Gallery </a>
					<a href="https://wordpress.org/plugins/responsive-slider-gallery/" target="_blank" class="button button-primary load-customize hide-if-no-customize"> Responsive Slider Gallery </a>
					<a href="https://wordpress.org/plugins/new-contact-form-widget/" target="_blank" class="button button-primary load-customize hide-if-no-customize"> Contact Form Widget </a>
					<a href="https://wordpress.org/plugins/facebook-likebox-widget-and-shortcode/" target="_blank" class="button button-primary load-customize hide-if-no-customize"> Facebook Likebox Plugin </a>
					<a href="https://wordpress.org/plugins/slider-responsive-slideshow/" target="_blank" class="button button-primary load-customize hide-if-no-customize"> Slider Responsive Slideshow </a>
					<a href="https://wordpress.org/plugins/new-video-gallery/" target="_blank" class="button button-primary load-customize hide-if-no-customize"> Video Gallery </a><br><br>
					<a href="https://wordpress.org/plugins/new-facebook-like-share-follow-button/" target="_blank" class="button button-primary load-customize hide-if-no-customize"> Facebook Like Share Follow Button </a>
					<a href="https://wordpress.org/plugins/new-google-plus-badge/" target="_blank" class="button button-primary load-customize hide-if-no-customize"> Google Plus Badge </a>
					<a href="https://wordpress.org/plugins/media-slider/" target="_blank" class="button button-primary load-customize hide-if-no-customize"> Media Slider </a>
					<a href="https://wordpress.org/plugins/weather-effect/" target="_blank" class="button button-primary load-customize hide-if-no-customize"> Weather Effect </a>
				</p>
			</div>
		</div>
	</div>
</div>	  
<?php 
	// syntax: wp_nonce_field( 'name_of_my_action', 'name_of_nonce_field' );
	wp_nonce_field( 'pfg_save_settings', 'pfg_save_nonce' );
?>
<script>
var pw_gallery_wall = jQuery('[name=pw_gallery_wall]:checked').val();
if(pw_gallery_wall == 'photo_wall') {
	jQuery('.photo_wall').addClass("tab-active");
	jQuery("div.insta_wall").removeClass("tab-active");
	jQuery("div.flickr_wall").removeClass("tab-active");
	jQuery('.gallery-content-photo-wall').css("display", "block");
	jQuery('.gallery-content-insta-wall').css("display", "none");
	jQuery('.gallery-content-flickr-wall').css("display", "none");
	// upload photos change
	jQuery('#image-gallery').css("display", "block");
	jQuery('#instaram-gallery').css("display", "none");
	jQuery('#flickr-gallery').css("display", "none");
	//instagram configration 
	jQuery('#instagram-configration').css("display", "none");
}

if(pw_gallery_wall == 'insta_wall') {
	jQuery('.insta_wall').addClass("tab-active");
	jQuery("div.photo_wall").removeClass("tab-active");
	jQuery("div.flickr_wall").removeClass("tab-active");
	 jQuery('.gallery-content-photo-wall').css("display", "none");
	jQuery('.gallery-content-insta-wall').css("display", "block");
	jQuery('.gallery-content-flickr-wall').css("display", "none");
	// upload photos change
	jQuery('#image-gallery').css("display", "none");
	jQuery('#instaram-gallery').css("display", "block");
	jQuery('#flickr-gallery').css("display", "none");
	//instagram configration 
	jQuery('#instagram-configration').css("display", "block");
}
	
if(pw_gallery_wall == 'flickr_wall') {
	jQuery('.flickr_wall').addClass("tab-active");
	jQuery("div.photo_wall").removeClass("tab-active");
	jQuery("div.insta_wall").removeClass("tab-active");
	jQuery('.gallery-content-photo-wall').css("display", "none");
	jQuery('.gallery-content-insta-wall').css("display", "none");
	jQuery('.gallery-content-flickr-wall').css("display", "block");
	// upload photos change
	jQuery('#image-gallery').css("display", "none");
	jQuery('#instaram-gallery').css("display", "none");
	jQuery('#flickr-gallery').css("display", "block");
	//instagram configration 
	jQuery('#instagram-configration').css("display", "none");
}
	
var pwselectedlayout = jQuery('[name=pfg_theme]:checked').val();
if(pwselectedlayout == 'pfg_theme1') {
	jQuery('.gallery_layout_grid').addClass('gallery_layout'); 
	//hide show configuration setting according gallery layout
	//jQuery('.pw_grid_layout_config').show(); 
	jQuery('.pw_masonry_mosaic_justify_layout_config').hide();
} else {
	jQuery('.gallery_layout_grid').removeClass('gallery_layout');
	//jQuery('.pw_masonry_mosaic_justify_layout_config').show(); 			
}
	
if(pwselectedlayout == 'pfg_theme2') {
	jQuery('.gallery_layout_masonry').addClass('gallery_layout'); 
	//hide show configuration setting according gallery layout
	//jQuery('.pw_grid_layout_config').hide(); 
	jQuery('.pw_masonry_mosaic_justify_layout_config').show(); 
	
} else {
	jQuery('.gallery_layout_masonry').removeClass('gallery_layout'); 
}

var pw_load_more = jQuery('[name=pw_load_more]:checked').val();
if(pw_load_more == 'yes') {
	jQuery('.load_limit').show();
} else {
	jQuery('.load_limit').hide();
}
	
var pw_gallery_wall = jQuery('[name=pw_gallery_wall]:checked').val();
if(pw_gallery_wall == 'photo_wall') {
	jQuery('.photo_wall').addClass("tab-active");
	jQuery("div.insta_wall").removeClass("tab-active");
	jQuery("div.flickr_wall").removeClass("tab-active");
	jQuery('.gallery-content-photo-wall').css("display", "block");
	jQuery('.gallery-content-insta-wall').css("display", "none");
	jQuery('.gallery-content-flickr-wall').css("display", "none");
	// upload photos change
	jQuery('#image-gallery').css("display", "block");
	jQuery('#instaram-gallery').css("display", "none");
	jQuery('#flickr-gallery').css("display", "none");
	//instagram configuration 
	jQuery('#instagram-configration').css("display", "none");
}

if(pw_gallery_wall == 'insta_wall') {
	jQuery('.insta_wall').addClass("tab-active");
	jQuery("div.photo_wall").removeClass("tab-active");
	jQuery("div.flickr_wall").removeClass("tab-active");
	 jQuery('.gallery-content-photo-wall').css("display", "none");
	jQuery('.gallery-content-insta-wall').css("display", "block");
	jQuery('.gallery-content-flickr-wall').css("display", "none");
	// upload photos change
	jQuery('#image-gallery').css("display", "none");
	jQuery('#instaram-gallery').css("display", "block");
	jQuery('#flickr-gallery').css("display", "none");
	//instagram configuration 
	jQuery('#instagram-configration').css("display", "block");
}

if(pw_gallery_wall == 'flickr_wall') {
	jQuery('.flickr_wall').addClass("tab-active");
	jQuery("div.photo_wall").removeClass("tab-active");
	jQuery("div.insta_wall").removeClass("tab-active");
	jQuery('.gallery-content-photo-wall').css("display", "none");
	jQuery('.gallery-content-insta-wall').css("display", "none");
	jQuery('.gallery-content-flickr-wall').css("display", "block");
	// upload photos change
	jQuery('#image-gallery').css("display", "none");
	jQuery('#instaram-gallery').css("display", "none");
	jQuery('#flickr-gallery').css("display", "block");
	//instagram configuration 
	jQuery('#instagram-configration').css("display", "none");
}
	
jQuery(document).ready(function() {
	jQuery('input[type=radio][name=pfg_theme]').change(function() {
		var pwselectedlayout = jQuery('[name=pfg_theme]:checked').val();
		if(pwselectedlayout == 'pfg_theme1') {
			jQuery('.gallery_layout_grid').addClass('gallery_layout');
			//hide show configuration setting according gallery layout
			//jQuery('.pw_grid_layout_config').show(); 
			jQuery('.pw_masonry_mosaic_justify_layout_config').hide(); 
				
		} else {
			jQuery('.gallery_layout_grid').removeClass('gallery_layout'); 
		}
		
		if(pwselectedlayout == 'pfg_theme2') {
			jQuery('.gallery_layout_masonry').addClass('gallery_layout'); 
			//hide show configuration setting according gallery layout
			//jQuery('.pw_grid_layout_config').hide(); 
			jQuery('.pw_masonry_mosaic_justify_layout_config').show(); 
		} else {
			jQuery('.gallery_layout_masonry').removeClass('gallery_layout'); 
		}
			
	});
	
	// tab
    jQuery("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
        e.preventDefault();
        jQuery(this).siblings('a.active').removeClass("active");
        jQuery(this).addClass("active");
        var index = jQuery(this).index();
        jQuery("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
        jQuery("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
    });
	
	//load more hide show
	jQuery('input[type=radio][name=pw_load_more]').change(function() {
	var pw_load_more = jQuery('[name=pw_load_more]:checked').val();
		if(pw_load_more == 'yes') {
			jQuery('.load_limit').show();
		} else {
			jQuery('.load_limit').hide();
		}
	});
		
	jQuery('input[type=radio][name=pw_gallery_wall]').change(function() {
		var pw_gallery_wall = jQuery('[name=pw_gallery_wall]:checked').val();
		if(pw_gallery_wall == 'photo_wall') {
			jQuery('.photo_wall').addClass("tab-active");
			jQuery("div.insta_wall").removeClass("tab-active");
			jQuery("div.flickr_wall").removeClass("tab-active");
			jQuery('.gallery-content-photo-wall').css("display", "block");
			jQuery('.gallery-content-insta-wall').css("display", "none");
			jQuery('.gallery-content-flickr-wall').css("display", "none");
			// upload photos change
			jQuery('#image-gallery').css("display", "block");
			jQuery('#instaram-gallery').css("display", "none");
			jQuery('#flickr-gallery').css("display", "none");
			//instagram configuration 
			jQuery('#instagram-configration').css("display", "none");
		}
		
		if(pw_gallery_wall == 'insta_wall') {
			jQuery('.insta_wall').addClass("tab-active");
			jQuery("div.photo_wall").removeClass("tab-active");
			jQuery("div.flickr_wall").removeClass("tab-active");
			jQuery('.gallery-content-photo-wall').css("display", "none");
			jQuery('.gallery-content-insta-wall').css("display", "block");
			jQuery('.gallery-content-flickr-wall').css("display", "none");
			// upload photos change
			jQuery('#image-gallery').css("display", "none");
			jQuery('#instaram-gallery').css("display", "block");
			jQuery('#flickr-gallery').css("display", "none");
			//instagram configuration 
			jQuery('#instagram-configration').css("display", "block");
		}
		
		if(pw_gallery_wall == 'flickr_wall') {
			jQuery('.flickr_wall').addClass("tab-active");
			jQuery("div.photo_wall").removeClass("tab-active");
			jQuery("div.insta_wall").removeClass("tab-active");
			jQuery('.gallery-content-photo-wall').css("display", "none");
			jQuery('.gallery-content-insta-wall').css("display", "none");
			jQuery('.gallery-content-flickr-wall').css("display", "block");
			// upload photos change
			jQuery('#image-gallery').css("display", "none");
			jQuery('#instaram-gallery').css("display", "none");
			jQuery('#flickr-gallery').css("display", "block");
			//instagram configuration 
			jQuery('#instagram-configration').css("display", "none");
		}
	});	
	
	
});


/**========================================================================*/
	/**========================================================================*/
	/**========================================================================*/
	/**========================================================================*/
	jQuery(document).ready(function() {
	 //range slider
		var rangeSlider = function(){
		  var slider = jQuery('.range-slider'),
			  range = jQuery('.range-slider__range'),
			  value = jQuery('.range-slider__value');
			
		  slider.each(function(){

			value.each(function(){
			  var value = jQuery(this).prev().attr('value');
			  jQuery(this).html(value);
			});

			range.on('input', function(){
			  jQuery(this).next(value).html(this.value);
			});
		  });
		};
		rangeSlider();
	});
	
	
	// title size range settings.  on change range value
	function updateRange(val, id) {
		jQuery("#" + id).val(val);
		jQuery("#" + id + "_text").val(val);	  
	}
	
	//color-picker
	(function( jQuery ) {
		jQuery(function() {
			// Add Color Picker to all inputs that have 'color-field' class
			jQuery('#title_color').wpColorPicker();
			jQuery('#title_color2').wpColorPicker();
			jQuery('#title_bg_color').wpColorPicker();
			jQuery('#title_bg_color2').wpColorPicker();
			jQuery('#border_color').wpColorPicker();
			jQuery('#border_color2').wpColorPicker();
			jQuery('#filter_bg').wpColorPicker();
			jQuery('#filter_title_color').wpColorPicker();
			jQuery('#filter_titles_color').wpColorPicker();
			jQuery('#filter_under_line_color').wpColorPicker();
			
			jQuery('#sorting_control_color').wpColorPicker();
			jQuery('#shuffle_bg').wpColorPicker();
			jQuery('#search_border').wpColorPicker();
			jQuery('#load_button_color').wpColorPicker();	
			jQuery('#load_text_color').wpColorPicker();	
			
		});
	})( jQuery );
	
	jQuery(document).ajaxComplete(function() {
		jQuery('#title_color,#title_bg_color,#border_color,#filter_bg,#filter_title_color,#sorting_control_color,#shuffle_bg,#search_border,#load_button_color,#load_text_color').wpColorPicker();
	});	
	var effect_type = jQuery('input[name="image_hover_effect_type"]:checked').val();
	
	//theme 2 -----------------
	var pfg_theme = jQuery('input[name="pfg_theme"]:checked').val();
	var image_hover_effect_theme2 = jQuery('input[name="image_hover_effect_theme2"]:checked').val();
	if(pfg_theme == "pfg_theme1") {
		jQuery('.theme1_hover').show();
		jQuery('.theme2_hover').hide();
		jQuery('.theme2_filters').hide();
		jQuery('.theme1_filters').show();
		jQuery('.theme1_thumb').show();
		jQuery('.theme2_thumb').hide();
		jQuery('.theme1_light_box').show();
		jQuery('.theme2_light_box').hide();
	}
	if(pfg_theme == "pfg_theme2") {
		jQuery('.theme2_hover').show();
		jQuery('.theme1_hover').hide();
		jQuery('.theme1_filters').hide();
		jQuery('.theme2_filters').show();
		jQuery('.theme2_thumb').show();
		jQuery('.theme1_thumb').hide();
		jQuery('.theme2_light_box').show();
		jQuery('.theme1_light_box').hide();
		
		
	}
	if(image_hover_effect_theme2 == "no") {
		jQuery('.he_overlay').hide();
		jQuery('.he_2d').hide();
	}
	if(image_hover_effect_theme2 == "overlay_zoom") {
		jQuery('.he_overlay').show();
		jQuery('.he_2d').hide();
	}
	if(image_hover_effect_theme2 == "2d") {
		jQuery('.he_2d').show();
		jQuery('.he_overlay').hide();
	}
	
	//alert(effect_type);
	if(effect_type == "no") {
		jQuery('.he_one').hide();
		jQuery('.he_four').hide();
		
	}
	
	if(effect_type == "2d") {
		jQuery('.he_one').show();
		jQuery('.he_four').hide();
	
		
	}
	if(effect_type == "sg") {
		jQuery('.he_one').hide();
		jQuery('.he_four').show();
		
		
	}
	var border_setting = jQuery('input[name="border_hide"]:checked').val();
	if(border_setting == 1) {
		jQuery('.border_settings').show();
		jQuery('.border_ancore').hide();
	}
	if(border_setting == 0) {
		jQuery('.border_settings').hide();
		jQuery('.border_ancore').show();
	}
	
	var border_setting2 = jQuery('input[name="border_hide2"]:checked').val();
	if(border_setting2 == 1) {
		jQuery('.border_settings2').show();
		jQuery('.border_ancore').hide();
	}
	if(border_setting2 == 0) {
		jQuery('.border_settings2').hide();
		jQuery('.border_ancore').show();
	}

	var title_thumbnail = jQuery('input[name="title_thumb"]:checked').val();
	if(title_thumbnail == "show"){
		jQuery('.title_set').show();
		jQuery('.title_ancore').hide();
	}
	if(title_thumbnail == "hide"){
		jQuery('.title_set').hide();
		jQuery('.title_ancore').show();
	}
	var title_thumbnail2 = jQuery('input[name="title_thumb2"]:checked').val();
	if(title_thumbnail2 == "show"){
		jQuery('.title_set2').show();
		jQuery('.title_ancore').hide();
	}
	if(title_thumbnail2 == "hide"){
		jQuery('.title_set2').hide();
		jQuery('.title_ancore').show();
	}
	
	var filter_setting = jQuery('input[name="filter_setting"]:checked').val();
	if(filter_setting == "open"){
		jQuery('.filter_set').show();
		jQuery('.filt_ancore').hide();
	}
	if(filter_setting == "close"){
		jQuery('.filter_set').hide();
		jQuery('.filt_ancore').show();
	}
	
	

	var pfg_read_more = jQuery('input[name="pfg_read_more"]:checked').val();
	if(pfg_read_more == "show") {
		jQuery('.read_more_txt').show();
	}
	if(pfg_read_more == "hide") {
		jQuery('.read_more_txt').hide();
	}
	
	// on load navigation button center hide show
	var pf_gallery_load_more = jQuery('input[name="pf_gallery_load_more"]:checked').val();
	if(pf_gallery_load_more == "yes"){
		jQuery('.lmb').show();		
	}
	if(pf_gallery_load_more == "no"){
		jQuery('.lmb').hide();		
	}
	
	//on change effect
	jQuery(document).ready(function() {
		jQuery('input[name="image_hover_effect_type"]').change(function(){
			var effect_type = jQuery('input[name="image_hover_effect_type"]:checked').val();
			
			//alert(effect_type);
			if(effect_type == "no") {
				jQuery('.he_one').hide();
				jQuery('.he_four').hide();
				jQuery('.he_overlay').hide();
				
			}
			
			if(effect_type == "2d") {
				jQuery('.he_one').show();
				jQuery('.he_four').hide();
				jQuery('.he_overlay').hide();
				
			}
			if(effect_type == "sg") {
				jQuery('.he_overlay').hide();
				jQuery('.he_one').hide();
				jQuery('.he_four').show();
				
			}
			
		});
		jQuery('input[name="border_hide"]').change(function(){
			var border_setting = jQuery('input[name="border_hide"]:checked').val();
			if(border_setting == 1) {
				jQuery('.border_settings').show();
				jQuery('.border_ancore').hide();
			}
			if(border_setting == 0) {
				jQuery('.border_settings').hide();
				jQuery('.border_ancore').show();
			}
		});
		
		jQuery('input[name="border_hide2"]').change(function(){
			var border_setting2 = jQuery('input[name="border_hide2"]:checked').val();
			if(border_setting2 == 1) {
				jQuery('.border_settings2').show();
				jQuery('.border_ancore').hide();
			}
			if(border_setting2 == 0) {
				jQuery('.border_settings2').hide();
				jQuery('.border_ancore').show();
			}
		});
		
		jQuery('input[name="title_thumb"]').change(function() {
			var title_thumbnail2 = jQuery('input[name="title_thumb"]:checked').val();
			if(title_thumbnail2 == "show"){
				jQuery('.title_set').show();
				jQuery('.title_ancore').hide();
			}
			if(title_thumbnail2 == "hide"){
				jQuery('.title_set').hide();
				jQuery('.title_ancore').show();
			}
		});
		
		jQuery('input[name="title_thumb2"]').change(function() {
			var title_thumbnail = jQuery('input[name="title_thumb2"]:checked').val();
			if(title_thumbnail == "show"){
				jQuery('.title_set2').show();
				jQuery('.title_ancore').hide();
			}
			if(title_thumbnail == "hide"){
				jQuery('.title_set2').hide();
				jQuery('.title_ancore').show();
			}
		});
		
		jQuery('input[name="filter_setting"]').change(function() {
			var filter_setting = jQuery('input[name="filter_setting"]:checked').val();
			if(filter_setting == "open"){
				jQuery('.filter_set').show();
				jQuery('.filt_ancore').hide();
			}
			if(filter_setting == "close"){
				jQuery('.filter_set').hide();
				jQuery('.filt_ancore').show();
			}
	
		});
		
		
		//theme 2
		jQuery('input[name="pfg_theme"]').change(function(){
			var pfg_theme = jQuery('input[name="pfg_theme"]:checked').val();
			if(pfg_theme == "pfg_theme1") {
				jQuery('.theme1_hover').show();
				jQuery('.theme2_hover').hide();
				jQuery('.theme2_filters').hide();
				jQuery('.theme1_filters').show();
				jQuery('.theme1_thumb').show();
				jQuery('.theme2_thumb').hide();
				jQuery('.theme1_light_box').show();
				jQuery('.theme2_light_box').hide();
			}
			if(pfg_theme == "pfg_theme2") {
				jQuery('.theme2_hover').show();
				jQuery('.theme1_hover').hide();
				jQuery('.theme1_filters').hide();
				jQuery('.theme2_filters').show();
				jQuery('.theme2_thumb').show();
				jQuery('.theme1_thumb').hide();
				jQuery('.theme2_light_box').show();
				jQuery('.theme1_light_box').hide();
			}
		});
		jQuery('input[name="image_hover_effect_theme2"]').change(function(){
			var image_hover_effect_theme2 = jQuery('input[name="image_hover_effect_theme2"]:checked').val();
			if(image_hover_effect_theme2 == "no") {
				jQuery('.he_overlay').hide();
				jQuery('.he_2d').hide();
			}
			if(image_hover_effect_theme2 == "overlay_zoom") {
				jQuery('.he_overlay').show();
				jQuery('.he_2d').hide();
			}
			if(image_hover_effect_theme2 == "2d") {
				jQuery('.he_2d').show();
				jQuery('.he_overlay').hide();
			}
		});
		
		jQuery('input[name="pfg_read_more"]').change(function(){
			var pfg_read_more = jQuery('input[name="pfg_read_more"]:checked').val();
			if(pfg_read_more == "show") {
				jQuery('.read_more_txt').show();
			}
			if(pfg_read_more == "hide") {
				jQuery('.read_more_txt').hide();
			}
		});
		
		jQuery('input[name="pf_gallery_load_more"]').change(function(){
			var pf_gallery_load_more = jQuery('input[name="pf_gallery_load_more"]:checked').val();
			if(pf_gallery_load_more == "yes"){
				jQuery('.lmb').show();		
			}
			if(pf_gallery_load_more == "no"){
				jQuery('.lmb').hide();		
			}
		});
		
		
	});
	
</script>