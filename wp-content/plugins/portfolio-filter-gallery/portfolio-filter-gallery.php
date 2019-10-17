<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
Plugin Name: Portfolio Filter Gallery
Plugin URI: http://awplife.com/
Description: Portfolio Filter Gallery For Wordpress.
Version: 1.0.7
Author: A WP Life
Author URI: http://awplife.com/
License: GPLv2 or later
Text Domain: portfolio-filter-gallery
Domain Path: /languages
**/

if ( ! class_exists( 'Awl_Portfolio_Filter_Gallery' ) ) {

	class Awl_Portfolio_Filter_Gallery {		
		
		public function __construct() {
			$this->_constants();
			$this->_hooks();
		}		
		
		protected function _constants() {
			//Plugin Version
			define( 'PFG_PLUGIN_VER', '1.0.7' );
			
			//Plugin Text Domain
			define("PFG_TXTDM","portfolio-filter-gallery" );

			//Plugin Name
			define( 'PFG_PLUGIN_NAME', __( 'Portfolio Filter Gallery', PFG_TXTDM ) );

			//Plugin Slug
			define( 'PFG_PLUGIN_SLUG', 'awl_filter_gallery' );

			//Plugin Directory Path
			define( 'PFG_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

			//Plugin Directory URL
			define( 'PFG_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

			define( 'PFG_SECURE_KEY', md5( NONCE_KEY ) );
			
		} // end of constructor function 
		
		protected function _hooks() {
			
			//Load text domain
			add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
			
			//add gallery menu item, change menu filter for multisite
			add_action( 'admin_menu', array( $this, 'pfg_menu' ), 101 );
			
			//Create Portfolio Filter Gallery Custom Post
			add_action( 'init', array( $this, 'Portfolio_Filter_Gallery' ));
			
			//Add meta box to custom post
			add_action( 'add_meta_boxes', array( $this, 'admin_add_meta_box' ) );
			 
			//loaded during admin init 
			add_action( 'admin_init', array( $this, 'admin_add_meta_box' ) );
			
			add_action('wp_ajax_pfg_gallery_js', array(&$this, '_ajax_pfg_gallery'));
		
			add_action('save_post', array(&$this, '_pfg_save_settings'));

			//Shortcode Compatibility in Text Widgets
			add_filter('widget_text', 'do_shortcode');
			
			// add pfg cpt shortcode column - manage_{$post_type}_posts_columns
			add_filter( 'manage_awl_filter_gallery_posts_columns', array(&$this, 'set_filter_gallery_shortcode_column_name') );
			
			// add pfg cpt shortcode column data - manage_{$post_type}_posts_custom_column
			add_action( 'manage_awl_filter_gallery_posts_custom_column' , array(&$this, 'custom_filter_gallery_shodrcode_data'), 10, 2 );

			add_action( 'wp_enqueue_scripts', array(&$this, 'enqueue_scripts_in_header') );
		
		}// end of hook function
		
		public function enqueue_scripts_in_header() {
			wp_enqueue_script('jquery');
		}
		// end of hook function
		
		// Filter gallery cpt shortcode column before date columns
		public function set_filter_gallery_shortcode_column_name($defaults) {
			$new = array();
			$shortcode = $columns['_filter_gallery_shortcode'];  // save the tags column
			unset($defaults['tags']);	// remove it from the columns list

			foreach($defaults as $key=>$value) {
				if($key=='date') {  // when we find the date column
				   $new['_filter_gallery_shortcode'] = __( 'Shortcode', PFG_TXTDM );  // put the tags column before it
				}    
				$new[$key] = $value;
			}
			return $new;  
		}
		
		// Filter gallery cpt shortcode column data
		public function custom_filter_gallery_shodrcode_data( $column, $post_id ) {
			switch ( $column ) {
				case '_filter_gallery_shortcode' :
					echo "<input type='text' class='button button-primary' id='filter-gallery-shortcode-$post_id' value='[PFG id=$post_id]' style='font-weight:bold; background-color:#32373C; color:#FFFFFF; text-align:center;' />";
					echo "<input type='button' class='button button-primary' onclick='return FilterCopyShortcode$post_id();' readonly value='Copy' style='margin-left:4px;' />";
					echo "<span id='copy-msg-$post_id' class='button button-primary' style='display:none; background-color:#32CD32; color:#FFFFFF; margin-left:4px; border-radius: 4px;'>copied</span>";
					echo "<script>
						function FilterCopyShortcode$post_id() {
							var copyText = document.getElementById('filter-gallery-shortcode-$post_id');
							copyText.select();
							document.execCommand('copy');
							
							//fade in and out copied message
							jQuery('#copy-msg-$post_id').fadeIn('1000', 'linear');
							jQuery('#copy-msg-$post_id').fadeOut(2500,'swing');
						}
						</script>
					";
				break;
			}
		}
		
		public function load_textdomain() {
			load_plugin_textdomain( PFG_TXTDM, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		}
		
		public function pfg_menu() {
			$filter_menu = add_submenu_page( 'edit.php?post_type='.PFG_PLUGIN_SLUG, __( 'Filters', PFG_TXTDM ), __( 'Filters', PFG_TXTDM ), 'administrator', 'pfg-filter-page', array( $this, 'awl_filter_page') );
			$doc_menu    = add_submenu_page( 'edit.php?post_type='.PFG_PLUGIN_SLUG, __( 'Docs', PFG_TXTDM ), __( 'Docs', PFG_TXTDM ), 'administrator', 'sr-doc-page', array( $this, 'pfg_doc_page') );
			//$featured_menu    = add_submenu_page( 'edit.php?post_type='.PFG_PLUGIN_SLUG, __( 'Featured-plugin', PFG_TXTDM ), __( 'Featured plugin', PFG_TXTDM ), 'administrator', 'sr-featured-page', array( $this, 'pfg_featured_page') );
			$theme_menu    = add_submenu_page( 'edit.php?post_type='.PFG_PLUGIN_SLUG, __( 'Our Theme', PFG_TXTDM ), __( 'Our Theme', PFG_TXTDM ), 'administrator', 'sr-theme-page', array( $this, 'pfg_theme_page') );
		}
		
		public function Portfolio_Filter_Gallery() {
			$labels = array(
				'name'                => _x( 'Portfolio Filter Gallery', 'Post Type General Name', PFG_TXTDM ),
				'singular_name'       => _x( 'Portfolio Filter Gallery', 'Post Type Singular Name', PFG_TXTDM ),
				'menu_name'           => __( 'Portfolio Gallery', PFG_TXTDM ),
				'name_admin_bar'      => __( 'Portfolio Filter', PFG_TXTDM ),
				'parent_item_colon'   => __( 'Parent Item:', PFG_TXTDM ),
				'all_items'           => __( 'All Gallery', PFG_TXTDM ),
				'add_new_item'        => __( 'Add New Gallery', PFG_TXTDM ),
				'add_new'             => __( 'Add New Gallery', PFG_TXTDM ),
				'new_item'            => __( 'New Portfolio Filter Gallery', PFG_TXTDM ),
				'edit_item'           => __( 'Edit Portfolio Filter Gallery', PFG_TXTDM ),
				'update_item'         => __( 'Update Portfolio Filter Gallery', PFG_TXTDM ),
				'search_items'        => __( 'Search Portfolio Filter Gallery', PFG_TXTDM ),
				'not_found'           => __( 'Portfolio Filter Gallery Not found', PFG_TXTDM ),
				'not_found_in_trash'  => __( 'Portfolio Filter Gallery Not found in Trash', PFG_TXTDM ),
			);
			$args = array(
				'label'               => __( 'Portfolio Filter Gallery', PFG_TXTDM ),
				'description'         => __( 'Custom Post Type For Portfolio Filter Gallery', PFG_TXTDM ),
				'labels'              => $labels,
				'supports'            => array('title'),
				'taxonomies'          => array(),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_position'       => 65,
				'menu_icon'           => 'dashicons-screenoptions',
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => true,
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'page',
			);
			register_post_type( 'awl_filter_gallery', $args );
		} // end of post type function
		
		public function admin_add_meta_box() {
			add_meta_box( __('Add Portfolio Filter Gallery', PFG_TXTDM), __('Add Portfolio Filter Gallery', PFG_TXTDM), array(&$this, 'pfg_image_upload'), 'awl_filter_gallery', 'normal', 'default' );
			add_meta_box( __('Recommended Free Plugin from A WP Life', PFG_TXTDM), __('Recommended Free Plugin from A WP Life', PFG_TXTDM), array(&$this, 'pfg_rec_free_plugin'), 'awl_filter_gallery', 'normal', 'default' );
			add_meta_box( __('Upgrade Portfolio Gallery Pro', PFG_TXTDM), __('Upgrade Portfolio Gallery Pro', PFG_TXTDM), array(&$this, 'pfg_upgrade_pro'), 'awl_filter_gallery', 'side', 'default' );
			add_meta_box( __('Rate Our Plugin', PFG_TXTDM), __('Rate Our Plugin', PFG_TXTDM), array(&$this, 'pfg_rate_plugin'), 'awl_filter_gallery', 'side', 'default' );
			add_meta_box( __('pfg-shortcode', PFG_TXTDM), __('Copy Shortcode', PFG_TXTDM), array(&$this, 'PFG_Shortcode'), 'awl_filter_gallery', 'side', 'default' );
		}
		// meta upgrade pro
		public function pfg_upgrade_pro() { ?>
			<img src="<?php echo PFG_PLUGIN_URL ?>img/portfolio theme 1 - Copy.png"/ width="250" height="280">
			<a href="http://awplife.com/demo/portfolio-filter-gallery-premium/" target="_new" class="button button-primary" style="background: #496481; text-shadow: none;"><span class="dashicons dashicons-search" style="line-height:1.4;" ></span> Live Demo</a>
			<a href="http://awplife.com/account/signup/portfolio-filter-gallery" target="_new" class="button button-primary" style="background: #496481; text-shadow: none;"><span class="dashicons dashicons-unlock" style="line-height:1.4;" ></span> Upgrade To Pro</a>
		<?php }
		// meta rate us
		Public function pfg_rate_plugin() { ?>
		<div style="text-align:center">
			<p>If you like our plugin then please <b>Rate us</b> on WordPress</p>
		</div>
		<div style="text-align:center">
			<span class="dashicons dashicons-star-filled"></span>
			<span class="dashicons dashicons-star-filled"></span>
			<span class="dashicons dashicons-star-filled"></span>
			<span class="dashicons dashicons-star-filled"></span>
			<span class="dashicons dashicons-star-filled"></span>
		</div>
		<br>
		<div style="text-align:center">
			<a href="https://wordpress.org/support/plugin/portfolio-filter-gallery/reviews/?filter=5" target="_new" class="button button-primary button-large" style="background: #496481; text-shadow: none;"><span class="dashicons dashicons-heart" style="line-height:1.4;" ></span> Please Rate Us</a>
		</div>	
		<?php }
			
		public function pfg_image_upload($post) {
			wp_enqueue_script('jquery');
			wp_enqueue_script('awl-bootstrap-js', PFG_PLUGIN_URL . 'js/bootstrap.min.js');
			//wp_enqueue_script('awl-bootstrap-multiselect-js', PFG_PLUGIN_URL . 'js/bootstrap-multiselect.min.js');
			wp_enqueue_script('media-upload');
			wp_enqueue_script('awl-pfg-uploader.js', PFG_PLUGIN_URL . 'js/awl-pfg-uploader.js', array('jquery'));
			wp_enqueue_style('awl-pfg-uploader-css', PFG_PLUGIN_URL . 'css/awl-pfg-uploader.css');
			wp_enqueue_style('awl-bootstrap-css', PFG_PLUGIN_URL . 'css/bootstrap.min.css');
			//wp_enqueue_style('awl-bootstrap-multiselect-css', PFG_PLUGIN_URL . 'css/bootstrap-multiselect.css');
			wp_enqueue_script( 'awl-pfg-color-picker-js', plugins_url('js/pfg-color-picker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
			wp_enqueue_media();
			wp_enqueue_style( 'wp-color-picker' );
			
			
			require_once('filter-gallery-settings.php');	
		}// end of upload multiple image
		
		public function PFG_Shortcode($post) { ?>
			<div class="pw-shortcode">
				<input type="text" name="shortcode" id="shortcode" value="<?php echo "[PFG id=".$post->ID."]"; ?>" readonly style="height: 60px; text-align: center; font-size: 20px; width: 100%; border: 2px dotted;">
				<p id="pw-copt-code">Shortcode copied to clipboard!</p>
				<p><?php _e('Copy & Embed shortcode into any Page/ Post / Text Widget to display your image gallery on site.', PFG_TXTDM); ?><br></p>
			</div>
			<span onclick="copyToClipboard('#shortcode')" class="pw-copy dashicons dashicons-clipboard"></span>
			<style>
			.pw-copy {
				position: absolute;
				top: 9px;
				right: 24px;
				font-size: 26px;
				cursor: pointer;
			}
			</style>
			<script>
			jQuery( "#pw-copt-code" ).hide();
			function copyToClipboard(element) {
			  var $temp = jQuery("<input>");
			  jQuery("body").append($temp);
			  $temp.val($(element).val()).select();
			  document.execCommand("copy");
			  $temp.remove();
			  jQuery( "#shortcode" ).select();
			  jQuery( "#pw-copt-code" ).fadeIn();
			}
			</script>
			<?php
		}// end of gallery generation
		
		public function _pfg_ajax_callback_function($id) {
			//wp_get_attachment_image_src ( int $attachment_id, string|array $size = 'thumbnail', bool $icon = false );
			//thumb, thumbnail, medium, large, post-thumbnail
			$thumbnail = wp_get_attachment_image_src($id, 'medium', true);
			$attachment = get_post( $id ); // $id = attachment id
			$all_category = get_option('awl_portfolio_filter_gallery_categories');
			?>
			<li class="item image">
				<img class="new-image" src="<?php echo $thumbnail[0]; ?>" alt="<?php echo get_the_title($id); ?>" style="height: 150px; width: 98%; border-radius: 8px;">
				<input type="hidden" id="image-ids[]" name="image-ids[]" value="<?php echo $id; ?>" />
				
				<select id="slide-type[<?php echo $id; ?>]" name="slide-type[<?php echo $id; ?>]" class="form-control" style="width: 98% !important;" placeholder="Image Title" value="<?php echo $image_type; ?>" >
					<option value="image" <?php if($image_type == "image") echo "selected=selected"; ?>> Image </option>
					<option value="video" <?php if($image_type == "video") echo "selected=selected"; ?>> Video </option>
				</select>
				
				<input type="text" name="image-title[]" id="image-title[]" style="width: 98%;" placeholder="Image Title" value="<?php echo get_the_title($id); ?>">
				<textarea name="image-desc[]" id="image-desc[]" style="width: 98%; display:none;" placeholder="Type discription here.."></textarea>
				<input type="text" name="image-link[]" id="image-link[]" style="width: 98%;" placeholder="Video URL / Link URL">
				<?php
				if(isset($filters[$id])) {
					$selected_filters_array = $filters[$id];
				} else {
					$selected_filters_array = array();
				}
				?>
				<select class="pfg-filters form-control" name="filters[<?php echo $id; ?>][]" multiple="multiple" id="filters" style="width: 98%;">
					<?php
					foreach ($all_category as $key => $value) {
						if($key != 0) {
							?><strong><option value="<?php echo $key; ?>"><?php echo ucwords($value); ?></option></strong><?php
						}
					}
					?>
				</select>
				<?php foreach ($selected_filters_array as $key => $value) { ?>
				<input type="hidden" name="filter-image[<?php echo $value; ?>][]" id="filter-image[]" style="width: 98%;" value="<?php echo $id; ?>" >
				<?php } ?>
				<a class="pw-trash-icon" name="remove-image" id="remove-image" href="#"><span class="dashicons dashicons-trash"></span></a>
			</li>
			<?php
		}
		
		public function _ajax_pfg_gallery() {
			echo $this->_pfg_ajax_callback_function($_POST['PFGimageId']);
			die;
		}
		
		public function _pfg_save_settings($post_id) {
			if(isset($_POST['pfg_save_nonce'])) {
				if (!isset( $_POST['pfg_save_nonce'] ) || ! wp_verify_nonce( $_POST['pfg_save_nonce'], 'pfg_save_settings' ) ) {
				   print 'Sorry, your nonce did not verify.';
				   exit;
				} else {
					
					$image_ids 		= $_POST['image-ids'];
					$image_titles 	= $_POST['image-title'];
					
					$i = 0;
					foreach($image_ids as $image_id) {
						$single_image_update = array(
							'ID'           => $image_id,
							'post_title'   => $image_titles[$i],						
						);
						wp_update_post( $single_image_update );
						$i++;
					}
					
					$awl_image_gallery_shortcode_setting = "awl_filter_gallery".$post_id;
					update_post_meta($post_id, $awl_image_gallery_shortcode_setting, base64_encode(serialize($_POST)));
				}
			}
		}// end save setting
		
		//filter/category page
		public function awl_filter_page() {
			require_once('filters.php');
		}
		
		//Doc page
		public function pfg_doc_page() {
			require_once('docs.php');
			}
			
		public function pfg_rec_free_plugin() {
			require_once('featured-plugins/featured-plugins.php');
		}
		
		public function pfg_theme_page() {
			require_once('our-theme/awp-theme.php');
		}
		
		
	}
	$pfg_portfolio_gallery_object = new Awl_Portfolio_Filter_Gallery();		
	require_once('filter-gallery-shortcode.php');
	
}
?>