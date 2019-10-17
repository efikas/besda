<?php
//filters page
wp_enqueue_style('awl-pfg-bootstrap-css', PFG_PLUGIN_URL . 'css/fb-buttons-bootstrap.css');
wp_enqueue_style('awl-pfg-filter-css', PFG_PLUGIN_URL . 'css/filter-templet.css');
wp_enqueue_style('awl-pfg-font-css', PFG_PLUGIN_URL . 'css/font-awesome.min.css');

$all_category = get_option('awl_portfolio_filter_gallery_categories');
if(is_array($all_category)){
	if(!isset($all_category[0])) {
		$all_category[0] = "all";
		update_option("awl_portfolio_filter_gallery_categories", $all_category);
	}
} else {
	$all_category[0] = "all";
	update_option("awl_portfolio_filter_gallery_categories", $all_category);
}
?>
<!--Category Section Start-->
<div class="row awl-spacing-md" id="update_div">
	<div class="container">
		<div class="form-style-5 text-center">
			<input type="button" class="button button-primary button-hero load-customize hide-if-no-customize" id="save_category" name="save_category" value="<?php _e('Add New Category', PFG_TXTDM); ?>" onclick="return DoAction('showaddform', '');" />
			<fieldset>
				<div id="add-form-div" class="row" style="display:none;">
					<form id="add-form" name="add-form">
						<legend><?php _e('Add New Category', PFG_TXTDM); ?></legend>
						<div class="col-md-8">
							<input type="text" id="name" name="name" placeholder="<?php _e('Type Category Name', PFG_TXTDM); ?>" >
						</div>
						<div class="col-md-3">
							<input type="button" class="button button-primary button-hero load-customize hide-if-no-customize lower-btn" id="save_category" name="save_category" value="<?php _e('Add Category', PFG_TXTDM); ?>" onclick="return DoAction('add', '');" />
						</div>
					</form>
				</div>
				<div id="update-form-div" style="display: none;"></div>
			</fieldset>
		</div>
		
		<?php
		if(isset($_POST['action'])){
			$action = $_POST['action'];
		}
		?>
		<div  id="cat-table-div" class="<?php if($action != "add" && $action != "update") echo'form-style-5'; ?>">
			
			<table class="table table-hover" id="cat-table">
				<thead>
					<tr>
						<th>#</th>
						<th><?php _e('Category Name', PFG_TXTDM); ?></th>
						<th><?php _e('Action', PFG_TXTDM); ?></th>
						<th class="text-center"><input type="checkbox" name="check-all" id="check-all"></th>
					</tr>
				</thead>
				<tbody id="update_div" name="update_div">
					<?php
					$all_category = get_option('awl_portfolio_filter_gallery_categories');
					$n = 1;
					if($all_category) {
						foreach ($all_category as $key => $value) {
						?>
						<tr id="record-<?php echo $key; ?>">
							<td><?php echo $n; ?></td>
							<td id="cat_name" name="cat_name"><?php echo ucwords($value); ?></td>
							<td>&nbsp;
								<i class="fa fa-pencil-square cat_icon" id="update_category" name="update_category"  onclick="return DoAction('edit', '<?php echo $key;?>');"></i>&nbsp;&nbsp;&nbsp;
								<?php if($key != 0 ) { ?><i class="fa fa-trash cat_icon" id="delete_category" name="delete_category" onclick="return DoAction('delete', '<?php echo $key;?>');"></i><?php } ?>
							</td>
							<td class="text-center">
								<?php if($key != 0 ) { ?><input type="checkbox" id="cat_all_check" value="<?php echo $key;?>"><?php } ?>
							</td>
						</tr>
						<?php
						$n++;
						} // end foreach
					}
						?>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<?php if($all_category){
						?>
						<td class="text-center"><i class="fa fa-trash cat_icon" id="delete_all_category" name="delete_all_category" onclick="return DoAction('delete_all_category', '-1');"></i></td>
						<?php
						}
						?>
					</tr>
				</tbody>
			</table>
			<?php if(count($all_category) == 5 ) { ?>
			<h5 class="notice notice-info notice-alt"><?php _e('You can only add 5 category in free version for more upgrade to our pro version', PFG_TXTDM); ?></h5>
			<?php } ?>
		</div>
	</div>
</div>
<script>
jQuery(document).ready(function() {
	jQuery("input:checkbox").prop('checked', false);
	jQuery("#check-all").change(function () {
		jQuery("input:checkbox").prop('checked', jQuery(this).prop("checked"));
	});
	
});
function DoAction(action, id) {
	//show add form
	if(action == "showaddform") {
		jQuery("#add-form-div").show();
		jQuery("#save_category").hide();
	}
	//add category
	if(action == "add") {
		jQuery.ajax({
			type: 'POST',
			url: location.href,
			data: jQuery('#add-form').serialize() + '&action=' + action,
			success:function(response){
				//jQuery("#cat-table").remove();
				//var result = jQuery(response).filter('#cat-table-div');
				//jQuery( "#cat-table-div" ).after( result );
				jQuery('#cat-table-div').html(jQuery(response).find('div#cat-table-div'));
				jQuery('#hide_btn').html(jQuery(response).find('div.hide_btn'));
				jQuery("#hide_this").remove();
				jQuery("#cat-table").remove();
				jQuery("#add-form-div").hide();
				jQuery("#save_category").show();
				jQuery("#check-all").change(function () {
					jQuery("input:checkbox").prop('checked', jQuery(this).prop("checked"));
				});
			}
		});
	}
	//edit and show update form
	if(action == "edit") {
		jQuery("#save_category").hide();
		jQuery("#add-form-div").hide();
		jQuery.ajax({
			type: 'POST',
			url: location.href,
			data: '&action=' + action + "&id=" + id,
			success:function(response){
				//var result = jQuery(response).filter('#update-form');
				jQuery("#update-form-div").show();
				//jQuery( "#update-form-div" ).after( result );
				jQuery('#update-form-div').html(jQuery(response).find('div#update-form'));
				
			}
		});
	}
		
	//update the category
	if(action == "update") {
		var edit_name = jQuery("#edit_name").val();
		jQuery.ajax({
			type: 'POST',
			url: location.href,
			data: '&action=' + action + "&id=" + id + "&edit_name=" + edit_name,
			success:function(response){
				jQuery("#update-form").remove();
				jQuery("#update-form-div").hide();
				// new updated response
				jQuery('#cat-table-div').html(jQuery(response).find('div#cat-table-div'));
				jQuery("#cat-table").remove();
				jQuery("#save_category").show();
			}
		});
	}
	//delete category
	if(action == "delete") {
		
		jQuery.ajax({
			type: 'POST',
			url: location.href,
			data: '&action=' + action + "&id=" + id,
			success:function(response){
				jQuery( "#record-" + id ).fadeOut( 400, "linear" );
			}
		});
	}
	//delete all category
	if(action == "delete_all_category") {
		if(confirm('Are you sure want to delete all selected articles?')) {
			var AllCategories = [];
			
			//collect all selected article ids
			jQuery('input:checkbox:checked').map(function() {
				if(jQuery.isNumeric(this.value)) {
					AllCategories.push(this.value);
				}
			});
			//console.log(AllCategories);
			
			// check if any article selected or not
			if(AllCategories.length) {
				jQuery.ajax({
					type: 'POST',
					url: location.href,
					data: '&action=' + action + "&id=" + AllCategories,
					success:function(response){
						for (i = 0; i < AllCategories.length; i++) {
							jQuery( "#record-" + AllCategories[i] ).fadeOut( 400, "linear" );
						}
						if(AllCategories){
							jQuery( "#hide_me" ).fadeIn( 7000, "linear" );
						}
					}
				});
			}else {
				alert("No category selected to delete.");
			}
		}
	}
}
</script>
<?php
if(isset($_POST['action'])){
	//print_r($_POST);
	$action = $_POST['action'];
	
	if($action == "add"){
		$category_name = sanitize_text_field($_POST['name']);
		//$category_slug = strtolower($category_name);
		$new_category = array($category_name);

		$all_category = get_option('awl_portfolio_filter_gallery_categories');
		if(is_array($all_category)) {
			$all_category = array_merge($all_category, $new_category);
		} else {
		$all_category = $new_category;
		}
		if(count($all_category) < 6 ){
			if(update_option( 'awl_portfolio_filter_gallery_categories', $all_category)){
			//print_r( $insert_query);
			?>
				<div class=""<?php if($action != "add" && $action != "update") echo'form-style-5'; ?>"" id="cat-table-div">
					<table class="table table-hover" id="cat-table">
						<thead>
							<tr>
								<th>#</th>
								<th><?php _e('Category Name', PFG_TXTDM); ?></th>
								<th><?php _e('Action', PFG_TXTDM); ?></th>
								<th class="text-center"><input type="checkbox" name="check-all" id="check-all"></th>
							</tr>
						</thead>
						<tbody id="update_div" name="update_div">
							<?php
							$all_category = get_option('awl_portfolio_filter_gallery_categories');
							$n = 1;
							if($all_category) {
								foreach ($all_category as $key => $value) {
								?>
								<tr id="record-<?php echo $key;?>">
									<td><?php echo $n; ?></td>
									<td id="cat_name" name="cat_name"><?php echo ucwords($value); ?></td>
									<td>&nbsp;
										<i class="fa fa-pencil-square cat_icon" id="update_category" name="update_category"  onclick="return DoAction('edit', '<?php echo $key;?>');"></i>&nbsp;&nbsp;&nbsp;
										<?php if($key != 0 ) { ?><i class="fa fa-trash cat_icon" id="delete_category" name="delete_category" onclick="return DoAction('delete', '<?php echo $key;?>');"></i><?php } ?>
									</td>
									<td class="text-center">
										<?php if($key != 0 ) { ?><input type="checkbox" id="cat_all_check" value="<?php echo $key;?>"><?php } ?>
									</td>
								</tr>
								<?php
								$n++;
								} // end foreach
							}
								?>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<?php if($all_category){
								?>
								<td class="text-center"><i class="fa fa-trash cat_icon" id="delete_all_category" name="delete_all_category" onclick="return DoAction('delete_all_category', '-1');"></i></td>
								<?php
								}
								?>
							</tr>
						</tbody>
					</table>
					<?php if(count($all_category) == 5 ) { ?>
					<h5 class="notice notice-info notice-alt"><?php _e('You can only add 5 category in free version for more upgrade to our pro version', PFG_TXTDM); ?></h5>
					<?php } ?>
				</div>
				<?php
			} else {
				echo "<div id='result-msg'>failed</div>";
			}
		
		}
	}
	
	if($action == "edit"){
		$id = $_POST['id'];
		$all_category = get_option('awl_portfolio_filter_gallery_categories');
		$edit_cat_name =  $all_category[$id];
		?>
		<div id="update-form">
			<form id="add-form" name="add-form">
				<legend><?php _e('Update Category', PFG_TXTDM); ?></legend>
				<div class="col-md-8">
					<input type="text" id="edit_name" name="edit_name" value="<?php echo $edit_cat_name; ?>" >
				</div>
				<div class="col-md-3">
					<input type="button" class="button button-primary button-hero load-customize hide-if-no-customize lower-btn" id="save_category" name="save_category" value="<?php _e('Update Category', PFG_TXTDM); ?>" onclick="return DoAction('update', '<?php echo $id; ?>');" />
				</div>
			</form>
		</div>
		<?php
			
	}
	
	if($action == "update"){
		$id = $_POST['id'];
		$edit_name = $_POST['edit_name'];
		$all_category = get_option('awl_portfolio_filter_gallery_categories');
		
		$replacements = array($id => $edit_name);
		$all_category = array_replace($all_category, $replacements);
		update_option( 'awl_portfolio_filter_gallery_categories', $all_category);
		?>
		
		<div class=""<?php if($action != "add" && $action != "update") echo'form-style-5'; ?>"" id="cat-table-div">
				<table class="table table-hover" id="cat-table">
					<thead>
						<tr>
							<th>#</th>
							<th><?php _e('Category Name', PFG_TXTDM); ?></th>
							<th><?php _e('Action', PFG_TXTDM); ?></th>
							<th class="text-center"><input type="checkbox" name="check-all" id="check-all"></th>
						</tr>
					</thead>
					<tbody id="update_div" name="update_div">
						<?php
						$all_category = get_option('awl_portfolio_filter_gallery_categories');
						$n = 1;
						if($all_category) {
							foreach ($all_category as $key => $value) {
							?>
							<tr id="record-<?php echo $key;?>">
								<td><?php echo $n; ?></td>
								<td id="cat_name" name="cat_name"><?php echo ucwords($value); ?></td>
								<td>&nbsp;
									<i class="fa fa-pencil-square cat_icon" id="update_category" name="update_category"  onclick="return DoAction('edit', '<?php echo $key;?>');"></i>&nbsp;&nbsp;&nbsp;
									<?php if($key != 0 ) { ?><i class="fa fa-trash cat_icon" id="delete_category" name="delete_category" onclick="return DoAction('delete', '<?php echo $key;?>');"></i><?php } ?>
								</td>
								<td class="text-center">
									<?php if($key != 0 ) { ?><input type="checkbox" id="cat_all_check" value="<?php echo $key;?>"><?php } ?>
								</td>
							</tr>
							<?php
							$n++;
							} // end foreach
						}
							?>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<?php if($all_category){
							?>
							<td class="text-center"><i class="fa fa-trash cat_icon" id="delete_all_category" name="delete_all_category" onclick="return DoAction('delete_all_category', '-1');"></i></td>
							<?php
							}
							?>
						</tr>
					</tbody>
				</table>
			</div>		
		<?php		
	}
	
	if($action == "delete"){
		$id = $_POST['id'];	
		$all_category = get_option('awl_portfolio_filter_gallery_categories');
		//print_r($all_category);
		if(is_array($all_category)) {
			unset($all_category[$id]);
			$all_category = array_filter( $all_category );
		}
		if(update_option( 'awl_portfolio_filter_gallery_categories', $all_category)){
			echo "Category has been-deleted";
		}
	}
	
	if($action == "delete_all_category"){
		$ids = explode("," ,$_POST['id']);	
		$count = count($ids);
		$n = 0;
		$all_category = get_option('awl_portfolio_filter_gallery_categories');
		//print_r($all_category);
		if(is_array($all_category)) {
			foreach($ids as $id) {
				unset($all_category[$id]);
				$all_category = array_filter( $all_category );
			}			
		}
		update_option( 'awl_portfolio_filter_gallery_categories', $all_category);		
	}	
}
?>
<p class="text-center">
	<br>
	<a href="http://awplife.com/account/signup/portfolio-filter-gallery" target="_blank" class="button button-primary button-hero load-customize hide-if-no-customize">Buy Premium Version</a>
	<a href="http://awplife.com/demo/portfolio-filter-gallery-premium/" target="_blank" class="button button-primary button-hero load-customize hide-if-no-customize">Check Live Demo</a>
	<a href="http://awplife.com/demo/portfolio-filter-gallery-premium-admin-demo/" target="_blank" class="button button-primary button-hero load-customize hide-if-no-customize">Try Admin Demo</a>
</p>