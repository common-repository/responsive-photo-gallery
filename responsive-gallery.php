<?php
/**
 * Plugin Name: Responsive Photo Gallery - Image, Portfolio gallery
 * Version: 3.6.2
 * Description:  Create Responsive photo gallery to display on your website. It integrated with images gallery, gallery lighbox, portfolio gallery, responsive gallery
 * Author: Weblizar
 * Author URI: http://weblizar.com/
 * Plugin URI: https://wordpress.org/plugins/responsive-photo-gallery/
 */

/*** Constant Variable ***/
defined( 'ABSPATH' ) or die();
define( "WEBLIZAR_RPG_TEXT_DOMAIN", "weblizar_rpg" );
define( "WEBLIZAR_RG_PLUGIN_URL", plugin_dir_url( __FILE__ ) );

// Image Crop Size Function
add_image_size( 'rpgp_12_thumb', 500, 9999, array( 'center', 'top' ) );
add_image_size( 'rpgp_346_thumb', 400, 9999, array( 'center', 'top' ) );
add_image_size( 'rpgp_12_same_size_thumb', 500, 500, array( 'center', 'top' ) );
add_image_size( 'rpgp_346_same_size_thumb', 400, 400, array( 'center', 'top' ) );

// Run 'Install' script on plugin activation
register_activation_hook( __FILE__, 'DefaultSettings' );
function DefaultSettings() {
	$DefaultSettingsArray = serialize( array(
		'WL_Hover_Animation'     => "fade",
		'WL_Open_Image_Link_Tab' => "_blank",
		'WL_Gallery_Layout'      => "col-md-6",
		'WL_Hover_Color'         => "#37393d",
		'WL_Hover_Color_Opacity' => 1,
		'WL_Font_Style'          => "Arial",
		'WL_Image_View_Icon'     => "far fa-image",
		'WL_Gallery_Title'       => "yes",
		'WL_Custom_CSS'          => ""
	) );
	add_option( "WL_IGP_Settings", $DefaultSettingsArray );
}

//Get Ready Plugin Translation
add_action( 'plugins_loaded', 'GetReadyTranslation' );
function GetReadyTranslation() {
	load_plugin_textdomain( WEBLIZAR_RPG_TEXT_DOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

// Register Custom Post Type
function ResponsiveGallery() {
	$labels = array(
		'name'               => esc_html__( 'Responsive Photo Gallery', 'Responsive Photo Gallery', WEBLIZAR_RPG_TEXT_DOMAIN ),
		'singular_name'      => esc_html__( 'Responsive Photo Gallery', 'Responsive Photo Gallery', WEBLIZAR_RPG_TEXT_DOMAIN ),
		'menu_name'          => esc_html__( 'Responsive Photo Gallery', WEBLIZAR_RPG_TEXT_DOMAIN ),
		'parent_item_colon'  => esc_html__( 'Parent Item:', WEBLIZAR_RPG_TEXT_DOMAIN ),
		'all_items'          => esc_html__( 'All Gallery', WEBLIZAR_RPG_TEXT_DOMAIN ),
		'view_item'          => esc_html__( 'View Gallery', WEBLIZAR_RPG_TEXT_DOMAIN ),
		'add_new_item'       => esc_html__( 'Add New Gallery', WEBLIZAR_RPG_TEXT_DOMAIN ),
		'add_new'            => esc_html__( 'Add New Gallery', WEBLIZAR_RPG_TEXT_DOMAIN ),
		'edit_item'          => esc_html__( 'Edit Gallery', WEBLIZAR_RPG_TEXT_DOMAIN ),
		'update_item'        => esc_html__( 'Update Gallery', WEBLIZAR_RPG_TEXT_DOMAIN ),
		'search_items'       => esc_html__( 'Search Gallery', WEBLIZAR_RPG_TEXT_DOMAIN ),
		'not_found'          => esc_html__( 'No Gallery Found', WEBLIZAR_RPG_TEXT_DOMAIN ),
		'not_found_in_trash' => esc_html__( 'No Gallery found in Trash', WEBLIZAR_RPG_TEXT_DOMAIN ),
	);
	$args   = array(
		'label'               => esc_html__( 'Responsive Photo Gallery', WEBLIZAR_RPG_TEXT_DOMAIN ),
		'description'         => esc_html__( 'Responsive Photo Gallery', WEBLIZAR_RPG_TEXT_DOMAIN ),
		'labels'              => $labels,
		'show_in_rest'        => true,
   		'supports'            => array( 'editor', 'title', '', '', '', '', '', '', '', '', '', '', ),
		//'taxonomies'          => array( 'category', 'post_tag' ),
		'hierarchical'        => false,
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => false,
		'show_in_admin_bar'   => false,
		'menu_position'       => 65,
		'menu_icon'           => 'dashicons-format-gallery',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => false,
		'capability_type'     => 'page',
	);
	register_post_type( 'responsive-gallery', $args );
	add_filter( 'manage_edit-responsive-gallery_columns', 'RPG_set_columns' );
	add_action( 'manage_responsive-gallery_posts_custom_column', 'RPG_manage_col', 10, 2 );
}

function RPG_set_columns( $columns ) {
		$columns = array(
			'cb'        => '<input type="checkbox" />',
			'title'     => esc_html__( 'Gallery', WEBLIZAR_RPG_TEXT_DOMAIN ),
			'shortcode' => esc_html__( 'Gallery Shortcode', WEBLIZAR_RPG_TEXT_DOMAIN ),
			'author'    => esc_html__( 'Author', WEBLIZAR_RPG_TEXT_DOMAIN ),
			'date'      => esc_html__( 'Date', WEBLIZAR_RPG_TEXT_DOMAIN ),
		);
		return $columns;
	}
function RPG_manage_col( $column, $post_id ) {
		global $post;
		switch ( $column ) {
			case 'shortcode' :
				echo '<input type="text" value="[WRG id=' . $post_id . ']" readonly="readonly" />';
			break;
			default :
			break;
		}
	}
// Hook into the 'init' action
add_action( 'init', 'ResponsiveGallery', 0 );

/**
 * Add Meta Box & load required CSS and JS for interface
 */
add_action( 'admin_init', 'ResponsivePhotoGallery_init' );
function ResponsivePhotoGallery_init() {
	add_meta_box( 'ResponsivePhotoGallery_meta', esc_html__( 'Add New Images', WEBLIZAR_RPG_TEXT_DOMAIN ), 'responsive_photo_gallery_function', 'responsive-gallery', 'normal', 'high' );
	add_action( 'save_post', 'responsive_photo_gallery_meta_save' );
	add_meta_box( 'Plugin Shortcode', 'Plugin Shortcode', 'wrg_plugin_shortcode', 'responsive-gallery', 'side', 'low' );
	add_meta_box( 'Responsive Photo Gallery Pro', 'Responsive Photo Gallery Pro', 'rpg_upg_pro', 'responsive-gallery', 'side', 'low' );
	add_meta_box( 'Rate us on WordPress', 'Rate us on WordPress', 'wrg_rate_us_function', 'responsive-gallery', 'side', 'low' );
	add_meta_box( 'Upgrade To Pro Version', 'Upgrade To Pro Version', 'wrg_upgrade_to_pro_function', 'responsive-gallery', 'side', 'low' );
	wp_enqueue_script( 'theme-preview' );
	wp_enqueue_script( 'rpg-media-uploads', WEBLIZAR_RG_PLUGIN_URL . 'js/rpg-media-upload-script.js', array(
		'media-upload',
		'thickbox',
		'jquery'
	) );
	wp_enqueue_style( 'dashboard' );
	wp_enqueue_style( 'rpg-meta-css', WEBLIZAR_RG_PLUGIN_URL . 'css/rpg-meta.css' );
	wp_enqueue_style( 'thickbox' );

	// enqueue style and script of code mirror
	wp_enqueue_style( 'wl_codemirror-css', WEBLIZAR_RG_PLUGIN_URL . 'css/codemirror/codemirror.css' );
	wp_enqueue_style( 'wl_blackboard', WEBLIZAR_RG_PLUGIN_URL . 'css/codemirror/blackboard.css' );
	wp_enqueue_style( 'wl_show-hint-css', WEBLIZAR_RG_PLUGIN_URL . 'css/codemirror/show-hint.css' );

	wp_enqueue_script( 'wl_codemirror-js', WEBLIZAR_RG_PLUGIN_URL . 'css/codemirror/codemirror.js', array( 'jquery' ) );
	wp_enqueue_script( 'wl_css-js', WEBLIZAR_RG_PLUGIN_URL . 'css/codemirror/wrg-css.js', array( 'jquery' ) );
	wp_enqueue_script( 'wl_css-hint-js', WEBLIZAR_RG_PLUGIN_URL . 'css/codemirror/css-hint.js', array( 'jquery' ) );
}

/*** plugin shortcode ***/
function wrg_plugin_shortcode() { ?>
    <p><?php esc_html_e( 'Use below shortcode in any Page/Post to publish your Responsive Photo Gallery', WEBLIZAR_RPG_TEXT_DOMAIN ); ?></p>
    <input readonly="readonly" type="text" value="<?php echo "[WRG id=" . get_the_ID() . "]"; ?>">
	<?php
}

/*** Rate us ***/
function wrg_rate_us_function() { ?>
    <div style="text-align:center">
        <h3><?php esc_html_e( 'If you like our plugin then please show us some love', WEBLIZAR_RPG_TEXT_DOMAIN ); ?></h3>
        <a class="wrg-rate-us" style="text-align:center; text-decoration: none;font:normal 30px/l;" href="http://wordpress.org/plugins/responsive-photo-gallery/" target="_blank">
            <span class="dashicons dashicons-star-filled"></span>
            <span class="dashicons dashicons-star-filled"></span>
            <span class="dashicons dashicons-star-filled"></span>
            <span class="dashicons dashicons-star-filled"></span>
            <span class="dashicons dashicons-star-filled"></span>
        </a>
        <div class="upgrade-to-pro-demo" style="text-align:center;margin-bottom:10px;margin-top:10px;">
            <a href="http://wordpress.org/plugins/responsive-photo-gallery/" target="_new" class="button button-primary button-hero">
			   <?php esc_html_e( 'Click Here', WEBLIZAR_RPG_TEXT_DOMAIN ); ?>
			</a>
        </div>
    </div>
	<?php
}

function rpg_upg_pro() {
	$imgpath = WEBLIZAR_RG_PLUGIN_URL . "images/rpg_pro.jpg";
	?>
    <div class="">
        <div class="update_pro_button">
			<a target="_blank" href="https://weblizar.com/plugins/responsive-photo-gallery-pro/">
				<?php esc_html_e( 'Buy Now $10', WEBLIZAR_RPG_TEXT_DOMAIN ); ?>
			</a>
        </div>
        <div class="update_pro_image">
            <img class="rpg_getpro" src="<?php echo esc_url($imgpath); ?>">
        </div>
        <div class="update_pro_button">
            <a class="upg_anch" target="_blank" href="https://weblizar.com/plugins/responsive-photo-gallery-pro/">
			   <?php esc_html_e( 'Buy Now $10', WEBLIZAR_RPG_TEXT_DOMAIN ); ?>
			</a>
        </div>
    </div>
	<?php
}

/*** Meta box interface design ** */
function responsive_photo_gallery_function() {
	$rpg_all_photos_details = unserialize( get_post_meta( get_the_ID(), 'rpg_all_photos_details', true ) );
	$TotalImages            = get_post_meta( get_the_ID(), 'rpg_total_images_count', true );
	$i                      = 1;
	?>
	<?php $nonce = wp_create_nonce( 'nonce_save_gallery_data' ); ?>
        <input type="hidden" name="security" value="<?php echo esc_attr( $nonce ); ?>">
    	<input type="hidden" id="count_total" name="count_total" value="<?php if ( $TotalImages == 0 ) {
		echo 0;
	} else {
		echo esc_html($TotalImages);
	} ?>"/>
    <div style="clear:left;"></div>
	<?php
	/* load saved photos into gallery */
	if ( $TotalImages ) {
		foreach ( $rpg_all_photos_details as $rpg_single_photos_detail ) {
			$name           = $rpg_single_photos_detail['rpg_image_label'];
			$url            = $rpg_single_photos_detail['rpg_image_url'];
			$image_link_url = $rpg_single_photos_detail['image_link_url'];
			?>
            <div class="rpg-image-entry" id="rpg_img<?php echo esc_attr($i); ?>">
                <a class="gallery_remove" href="#gallery_remove" id="rpg_remove_bt<?php echo esc_attr($i); ?>"
                   onclick="remove_meta_img(<?php echo esc_attr($i); ?>)"><img
                            src="<?php echo WEBLIZAR_RG_PLUGIN_URL . 'images/Close-icon-new.png'; ?>"/></a>
                <img src="<?php echo esc_url( $url ); ?>" class="rpg-meta-image" >
                <input type="button" id="upload-background-<?php echo esc_attr($i); ?>" name="upload-background-<?php echo esc_attr($i); ?>"
                       value="Upload Image" class="button-primary" onClick="weblizar_image('<?php echo esc_attr($i); ?>')"/>
                <input type="text" id="rpg_img_url<?php echo esc_attr($i); ?>" name="rpg_img_url<?php echo esc_attr($i); ?>"
                       class="rpg_label_text" value="<?php echo esc_url( $url ); ?>" readonly="readonly"
                       style="display:none;"/>
                <input type="text" id="image_label<?php echo esc_attr($i); ?>" name="image_label<?php echo esc_attr($i); ?>"
                       placeholder="Enter Image Label" class="rpg_label_text" value="<?php echo esc_html( $name ); ?>">
                <input type="text" id="image_link_url<?php echo esc_attr($i); ?>" name="image_link_url<?php echo esc_attr($i); ?>"
                       placeholder="Enter Image Link URL" class="rpg_label_text"
                       value="<?php echo esc_html( $image_link_url ); ?>">
            </div>
			<?php
			$i ++;
		} // end of foreach
	} else {
		$TotalImages = 0;
	}
	?>

    <div id="append_rpg_img">
    </div>
    <div class="rpg-image-entry add_rpg_new_image" onclick="add_rpg_meta_img()">
        <div class="dashicons dashicons-plus"></div>
        <p><?php esc_html_e( 'Add New Image', WEBLIZAR_RPG_TEXT_DOMAIN ); ?></p>
    </div>
    <div style="clear:left;"></div>
    <script>
        var rpg_i = parseInt(jQuery("#count_total").val());

        function add_rpg_meta_img() {
            rpg_i = rpg_i + 1;

            var rpg_output = '<div class="rpg-image-entry" id="rpg_img' + rpg_i + '">' +
                '<a class="gallery_remove" href="#gallery_remove" id="rpg_remove_bt' + rpg_i + '"onclick="remove_meta_img(' + rpg_i + ')"><img src="<?php echo WEBLIZAR_RG_PLUGIN_URL . 'images/Close-icon-new.png'; ?>" /></a>' +
                '<img height="100%" src="<?php echo WEBLIZAR_RG_PLUGIN_URL . 'images/rpg-default-new.jpg'; ?>" class="rpg-meta-image" alt=""  style="">' +
                '<input type="button" id="upload-background-' + rpg_i + '" name="upload-background-' + rpg_i + '" value="Upload Image" class="button-primary" onClick="weblizar_image(' + rpg_i + ')" />' +
                '<input type="text" id="rpg_img_url' + rpg_i + '" name="rpg_img_url' + rpg_i + '" class="rpg_label_text"  value="<?php echo WEBLIZAR_RG_PLUGIN_URL . 'images/rpg-default-new.jpg'; ?>"  readonly="readonly" style="display:none;" />' +
                '<input type="text" id="image_label' + rpg_i + '" name="image_label' + rpg_i + '" placeholder="Enter Image Label" class="rpg_label_text"   >' +
                '<input type="text" id="image_link_url' + rpg_i + '" name="image_link_url' + rpg_i + '" placeholder="Enter Image Link URL" class="rpg_label_text"   >' +
                '</div>';
            jQuery(rpg_output).hide().appendTo("#append_rpg_img").slideDown(500);
            jQuery("#count_total").val(rpg_i);
        }

        function remove_meta_img(id) {
            jQuery("#rpg_img" + id).slideUp(600, function () {
                jQuery(this).remove();
            });

            count_total = jQuery("#count_total").val();
            count_total = count_total - 1;
            var id_i = id + 1;

            for (var i = id_i; i <= rpg_i; i++) {
                var j = i - 1;
                jQuery("#rpg_remove_bt" + i).attr('onclick', 'remove_meta_img(' + j + ')');
                jQuery("#rpg_remove_bt" + i).attr('id', 'rpg_remove_bt' + j);
                jQuery("#rpg_img_url" + i).attr('name', 'rpg_img_url' + j);
                jQuery("#image_label" + i).attr('name', 'image_label' + j);
                jQuery("#rpg_img_url" + i).attr('id', 'rpg_img_url' + j);
                jQuery("#image_link_url" + i).attr('id', 'image_link_url' + j);
                jQuery("#image_label" + i).attr('id', 'image_label' + j);
                jQuery("#rpg_img" + i).attr('id', 'rpg_img' + j);
            }
            jQuery("#count_total").val(count_total);
            rpg_i = rpg_i - 1;
        }
    </script>
	<?php
}

function wrg_upgrade_to_pro_function() { ?>
    <div class="upgrade-to-pro-demo" style="text-align:center;margin-bottom:10px;margin-top:10px;">
        <a href="http://demo.weblizar.com/responsive-photo-gallery-pro/" target="_new"
           class="button button-primary button-hero"><?php esc_html_e( 'View Live Demo', WEBLIZAR_RPG_TEXT_DOMAIN ); ?></a>
    </div>
    <div class="upgrade-to-pro-admin-demo" style="text-align:center;margin-bottom:10px;">
        <a href="http://demo.weblizar.com/responsive-photo-gallery-admin-demo/" target="_new"
           class="button button-primary button-hero"><?php esc_html_e( 'View Admin Demo', WEBLIZAR_RPG_TEXT_DOMAIN ); ?></a>
    </div>
    <div class="upgrade-to-pro" style="text-align:center;margin-bottom:10px;">
        <a href="http://weblizar.com/plugins/responsive-photo-gallery-pro/" target="_new"
           class="button button-primary button-hero"><?php esc_html_e( 'Upgrade To Pro', WEBLIZAR_RPG_TEXT_DOMAIN ); ?></a>
    </div>
	<?php
}

/**
 * Save All Photo Gallery Images
 */
function responsive_photo_gallery_meta_save() {
	if ( isset( $_POST['post_ID'] ) && isset( $_POST['security'] ) ) {
		if ( ! wp_verify_nonce( $_POST['security'], 'nonce_save_gallery_data' ) ) {
		die();}
		$post_ID   = $_POST['post_ID'];
		$post_type = get_post_type( $post_ID );
		if ( $post_type == 'responsive-gallery' ) {
			$TotalImages = $_POST['count_total'];
			$ImagesArray = array();
			if ( $TotalImages ) {
				for ( $i = 1; $i <= $TotalImages; $i ++ ) {
					$image_label    = sanitize_text_field( "image_label" . $i );
					$name           = sanitize_text_field( stripslashes( $_POST[ 'image_label' . $i ] ) );
					$url            = sanitize_text_field( $_POST[ 'rpg_img_url' . $i ] );
					$image_link_url = isset($_POST[ 'image_link_url' . $i ]) ? sanitize_text_field( $_POST[ 'image_link_url' . $i ] ): '';
					$ImagesArray[]  = array(
						'rpg_image_label' => $name,
						'rpg_image_url'   => $url,
						'image_link_url'  => $image_link_url
					);
				}
				update_post_meta( $post_ID, 'rpg_all_photos_details', serialize( $ImagesArray ) );
				update_post_meta( $post_ID, 'rpg_total_images_count', $TotalImages );
			} else {
				$TotalImages = 0;
				update_post_meta( $post_ID, 'rpg_total_images_count', $TotalImages );
				$ImagesArray = array();
				update_post_meta( $post_ID, 'rpg_all_photos_details', serialize( $ImagesArray ) );
			}
		}
	}
}


/**
 * Weblizar Responsive Gallery Short Code Detect Function
 */
function WeblizarResponsiveGalleryShortCodeDetect() {
	global $wp_query;
	$Posts   = $wp_query->posts;
	$Pattern = get_shortcode_regex();

	foreach ( $Posts as $Post ) {
		/**
		 * js scripts
		 */
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'wl-hover-pack-js', WEBLIZAR_RG_PLUGIN_URL . 'js/hover-pack.js', array( 'jquery' ) );
		/**
		 * css scripts
		 */
		wp_enqueue_style( 'wl-hover-pack-css', WEBLIZAR_RG_PLUGIN_URL . 'css/hover-pack.css' );
		// wp_enqueue_style( 'bootstrap', WEBLIZAR_RG_PLUGIN_URL . 'css/bootstrap.min.css' );
		wp_enqueue_style( 'wl-img-gallery-css', WEBLIZAR_RG_PLUGIN_URL . 'css/img-gallery.css' );

		wp_enqueue_style( 'font-awesome-5', WEBLIZAR_RG_PLUGIN_URL . 'css/all.min.css' );
		wp_enqueue_style( 'bootstrap', WEBLIZAR_RG_PLUGIN_URL . 'css/bootstrap.min.css' );
		/** lightbox
		 * css js
		 **/
		wp_enqueue_script( 'jquery-rebox', WEBLIZAR_RG_PLUGIN_URL . 'js/jquery-rebox.js', array( 'jquery' ) );
		wp_enqueue_script( 'lightbox-script2', WEBLIZAR_RG_PLUGIN_URL . 'js/lightbox-script.js', array( 'jquery' ), '', true );

		wp_enqueue_style( 'jquery-rebox-css', WEBLIZAR_RG_PLUGIN_URL . 'css/jquery-rebox.css' );
		break;
		//end of if
	} //end of foreach
}

add_action( 'wp', 'WeblizarResponsiveGalleryShortCodeDetect' );

/**
 * Settings Page for Responsive Gallery
 */
add_action( 'admin_menu', 'WRG_SettingsPage' );
function WRG_SettingsPage() {
	add_submenu_page( 'edit.php?post_type=responsive-gallery', esc_html__( 'Gallery Settings', WEBLIZAR_RPG_TEXT_DOMAIN ), esc_html__( 'Gallery Settings', WEBLIZAR_RPG_TEXT_DOMAIN ), 'administrator', 'image-gallery-settings', 'image_gallery_settings_page_function' );
	add_submenu_page( 'edit.php?post_type=responsive-gallery', 'Pro Screenshots', 'Pro Screenshots', 'administrator', 'get-image-gallery-pro-plugin', 'get_image_gallery_pro_page_function' );
	add_submenu_page( 'edit.php?post_type=responsive-gallery', 'Recommendation', 'Recommendation', 'administrator', 'plugin-recommendation', 'RPG_plugin_recommendation' );
}

/**
 * Photo Gallery Settings Page
 */
function image_gallery_settings_page_function() {
	//css
	wp_enqueue_style( 'font-awesome-5', WEBLIZAR_RG_PLUGIN_URL . 'css/all.min.css' );
	require_once( "responsive-gallery-settings.php" );
}

/**
 * Get Responsive Photo Gallery Pro Plugin Page
 */
function get_image_gallery_pro_page_function() {
	//css
	wp_enqueue_style( 'font-awesome-5', WEBLIZAR_RG_PLUGIN_URL . 'css/all.min.css' );
	wp_enqueue_style( 'wl-pricing-table-css', WEBLIZAR_RG_PLUGIN_URL . 'css/pricing-table.css' );
	//wp_enqueue_style('wl-pricing-table-responsive-css', WEBLIZAR_RG_PLUGIN_URL.'css/pricing-table-responsive.css');
	wp_enqueue_style( 'bootstrap', WEBLIZAR_RG_PLUGIN_URL . 'css/bootstrap.min.css' );
	require_once( "get-responsive-gallery-pro.php" );
}

function RPG_plugin_recommendation() {
	//css
	wp_enqueue_style( 'recom2', WEBLIZAR_RG_PLUGIN_URL . 'css/recom.css' );
	require_once( "recommendations.php" );
}

/*** Responsive Gallery Short Code [WRG] ***/

require_once( "responsive-gallery-short-code.php" );

/**
 * Hex Color code to RGB Color Code converter function
 */
if ( ! function_exists( 'RPGhex2rgbWeblizar' ) ) {
	function RPGhex2rgbWeblizar( $hex ) {
		$hex = str_replace( "#", "", $hex );

		if ( strlen( $hex ) == 3 ) {
			$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
			$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
			$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
		} else {
			$r = hexdec( substr( $hex, 0, 2 ) );
			$g = hexdec( substr( $hex, 2, 2 ) );
			$b = hexdec( substr( $hex, 4, 2 ) );
		}
		$rgb = array( $r, $g, $b );

		return $rgb; // returns an array with the rgb values
	}
}

// Add settings link on plugin page
$rpg_plugin_name = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$rpg_plugin_name", 'as_settings_link_rpg' );
function as_settings_link_rpg( $links ) {
	$as_settings_link1 = '<a href="https://weblizar.com/plugins/responsive-photo-gallery-pro/" target="_blank" style="font-weight:700; color:#e35400">'. esc_html__('Get Premium', WEBLIZAR_RPG_TEXT_DOMAIN).'</a>';
	$as_settings_link2 = '<a href="edit.php?post_type=responsive-gallery&page=image-gallery-settings">'. esc_html__('Settings', WEBLIZAR_RPG_TEXT_DOMAIN).'</a>';
	array_unshift( $links, $as_settings_link1, $as_settings_link2 );
	return $links;
}

// Review Notice Box
add_action( "admin_notices", "review_admin_notice_rpgp_free" );
function review_admin_notice_rpgp_free() {
	global $pagenow;
	$rpg_screen = get_current_screen();
	if ( $pagenow == 'edit.php' && $rpg_screen->post_type == "responsive-gallery" ) {
		include( 'rpg-banner.php' );
	}
}
?>
