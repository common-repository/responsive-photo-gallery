<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_shortcode( 'WRG', 'image_gallery_premium_short_code' );
function image_gallery_premium_short_code( $Id ) {
	ob_start();
	if ( ! isset( $Id['id'] ) ) {
		$Id['id'] = "";
	}
	/**
	 * Load Responsive Gallery Settings
	 */

	$WL_RG_Settings = unserialize( get_option( "WL_IGP_Settings" ) );
	if ( count( $WL_RG_Settings ) ) {
		$WL_Hover_Animation     = $WL_RG_Settings['WL_Hover_Animation'];
		$WL_Open_Image_Link_Tab = $WL_RG_Settings['WL_Open_Image_Link_Tab'];
		$WL_Gallery_Layout      = $WL_RG_Settings['WL_Gallery_Layout'];
		$WL_Hover_Color         = $WL_RG_Settings['WL_Hover_Color'];
		$WL_Hover_Color_Opacity = 1;
		$WL_Font_Style          = $WL_RG_Settings['WL_Font_Style'];
		$WL_Image_View_Icon     = $WL_RG_Settings['WL_Image_View_Icon'];
		$WL_Gallery_Title       = $WL_RG_Settings['WL_Gallery_Title'];
		$WL_Hover_Color_Opacity = $WL_RG_Settings['WL_Hover_Color_Opacity'];
		$WL_Custom_CSS          = $WL_RG_Settings['WL_Custom_CSS'];
	} else {
		$WL_Hover_Color_Opacity = 1;
		$WL_Open_Image_Link_Tab = "_blank";
		$WL_Hover_Animation     = "fade";
		$WL_Gallery_Layout      = "col-md-6";
		$WL_Hover_Color         = "#37393d";
		$WL_Font_Style          = "Arial";
		$WL_Image_View_Icon     = "fa-picture-o";
		$WL_Gallery_Title       = "yes";
		$WL_Hover_Color_Opacity = "1";
		$WL_Custom_CSS          = "";
	}
	$RGB           = RPGhex2rgbWeblizar( $WL_Hover_Color );
	$HoverColorRGB = implode( ", ", $RGB );
	?>
    <script>
        jQuery.browser = {};
        (function () {
            jQuery.browser.msie = false;
            jQuery.browser.version = 0;
            if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
                jQuery.browser.msie = true;
                jQuery.browser.version = RegExp.$1;
            }
        })();
    </script>

    <style>
        .modal-backdrop.in {
            display: none !important;
        }
        @media (min-width: 992px) {
            .col-md-6 {
                width: 48% !important;
                padding-right: 5px;
                padding-left: 5px;
                float: left;
            }
		}

        .b-link-fade .b-wrapper, .b-link-fade .b-top-line {
            background: rgba(<?php echo esc_attr($HoverColorRGB); ?>, <?php echo esc_attr($WL_Hover_Color_Opacity); ?>);;
        }

        .b-link-flow .b-wrapper, .b-link-flow .b-top-line {
            background: rgba(<?php echo esc_attr($HoverColorRGB); ?>, <?php echo esc_attr($WL_Hover_Color_Opacity); ?>);;
        }

        .b-link-stroke .b-top-line {
            background: rgba(<?php echo esc_attr($HoverColorRGB); ?>, <?php echo esc_attr($WL_Hover_Color_Opacity); ?>);;
        }

        .b-link-stroke .b-bottom-line {
            background: rgba(<?php echo esc_attr($HoverColorRGB); ?>, <?php echo esc_attr($WL_Hover_Color_Opacity); ?>);;
        }

        .b-link-box .b-top-line {

            border: 16px solid<?php echo esc_attr($WL_Hover_Color); ?>;
        }

        .b-link-box .b-bottom-line {
            background: rgba(<?php echo esc_attr($HoverColorRGB); ?>, <?php echo esc_attr($WL_Hover_Color_Opacity); ?>);;
        }

        .b-link-stripe .b-line {
            background: rgba(<?php echo esc_attr($HoverColorRGB); ?>, <?php echo esc_attr($WL_Hover_Color_Opacity); ?>);;
        }

        .b-link-apart-horisontal .b-top-line, .b-link-apart-horisontal .b-top-line-up {
            background: rgba(<?php echo esc_attr($HoverColorRGB); ?>, <?php echo esc_attr($WL_Hover_Color_Opacity); ?>);;
        }

        .b-link-apart-horisontal .b-bottom-line, .b-link-apart-horisontal .b-bottom-line-up {
            background: rgba(<?php echo esc_attr($HoverColorRGB); ?>, <?php echo esc_attr($WL_Hover_Color_Opacity); ?>);;
        }

        .b-link-apart-vertical .b-top-line, .b-link-apart-vertical .b-top-line-up {
            background: rgba(<?php echo esc_attr($HoverColorRGB); ?>, <?php echo esc_attr($WL_Hover_Color_Opacity); ?>);;
        }

        .b-link-apart-vertical .b-bottom-line, .b-link-apart-vertical .b-bottom-line-up {
            background: rgba(<?php echo esc_attr($HoverColorRGB); ?>, <?php echo esc_attr($WL_Hover_Color_Opacity); ?>);;
        }

        .b-link-diagonal .b-line {
            background: rgba(<?php echo esc_attr($HoverColorRGB); ?>, <?php echo esc_attr($WL_Hover_Color_Opacity); ?>);;
        }

        .b-wrapper {
            font-family: <?php echo str_ireplace("+", " ", $WL_Font_Style); ?>;
        }

        .rpg-gal-title {
            font-family: <?php echo esc_attr($WL_Font_Style); ?>;
        }

        <?php echo esc_attr($WL_Custom_CSS); ?>
    </style>

	<?php
	/**
	 * Load All Image Gallery Custom Post Type
	 */
	$IG_CPT_Name      = "responsive-gallery";
	$IG_Taxonomy_Name = "category";
	$all_posts        = wp_count_posts( 'responsive-gallery' )->publish;
	$AllGalleries     = array( 'p'              => $Id['id'],
	                           'post_type'      => $IG_CPT_Name,
	                           'orderby'        => 'ASC',
	                           'posts_per_page' => $all_posts
	);

	$loop = new WP_Query( $AllGalleries );
	?>
    <div id="gallery1" class="gal-container">
		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
            <!--get the post id-->
			<?php $post_id = $Id['id']; ?>
            <div id="gal-container-<?php echo esc_attr($post_id); ?>" style="display: block; overflow:hidden;">
				<?php if ( $WL_Gallery_Title == "" ) {
					$WL_Gallery_Title == "yes";
				}
				if ( $WL_Gallery_Title == "yes" ) { ?>
                    <!-- gallery title-->
                    <div class="rpg-gal-title">
						<?php echo get_the_title( $post_id ); ?>
                    </div>
				<?php } ?>
                <!-- gallery photos-->
                <div class="row" >
					<?php
					/**
					 * Get All Photos from Gallery Post Meta
					 */
					$rpg_all_photos_details = unserialize( get_post_meta( get_the_ID(), 'rpg_all_photos_details', true ) );
					$TotalImages            = get_post_meta( get_the_ID(), 'rpg_total_images_count', true );
					$i                      = 1;
					if ( is_array( $rpg_all_photos_details ) ) {
						foreach ( $rpg_all_photos_details as $rpg_single_photos_detail ) {
							$name           = $rpg_single_photos_detail['rpg_image_label'];
							$url            = $rpg_single_photos_detail['rpg_image_url'];
							$image_link_url = $rpg_single_photos_detail['image_link_url'];
							if ( $name == "" ) {
								// if slide title blank then
								global $wpdb;
								$post_table_prefix = $wpdb->prefix . "posts";
								if ( count( $attachment = $wpdb->get_col( $wpdb->prepare( "SELECT `post_title` FROM `$post_table_prefix` WHERE `guid` LIKE '%s'", $url ) ) ) ) {
									// attachment title as alt
									$slide_alt = $attachment[0];
									if ( empty( $attachment[0] ) ) {
										// post title as alt
										$slide_alt = get_the_title( $post_id );
									}
								}
								if ( empty( $attachment[0] ) ) {
									// post title as alt
									$slide_alt = get_the_title( $post_id );
								}
							} else {
								// slide title as alt
								$slide_alt = $name;
							}

							?>
                            <div class="<?php echo esc_attr($WL_Gallery_Layout); ?> col-sm-6 wl-gallery">
                                <div class="b-link-<?php echo esc_attr($WL_Hover_Animation); ?> b-animate-go">
                                    <img src="<?php echo esc_url( $url ); ?>" alt="<?php echo esc_attr($slide_alt); ?>"
                                         class="gall-img-responsive">
                                    <div class="b-wrapper">
                                    	 <div class="b-wrapper-inner">
	                                        <h2 class="b-from-left b-animate b-delay03"><?php echo esc_html( $name ); ?></h2>
	                                        <p class="b-from-right b-animate b-delay03">
	                                            <a class="wlrpgimg" href="<?php echo esc_url($url); ?>"
	                                               title="<?php echo esc_attr( $name ); ?>">
	                                                <i class="<?php echo esc_attr($WL_Image_View_Icon); ?> fa-2x"></i>
	                                            </a>&nbsp;&nbsp;
												<?php if ( ! empty( $image_link_url ) ) { ?>
	                                                <a href="<?php echo esc_url($image_link_url); ?>"
	                                                   target="<?php echo esc_attr($WL_Open_Image_Link_Tab); ?>">
	                                                    <i class="fa fa-link fa-2x"></i>
	                                                </a>
												<?php } ?>
	                                        </p>
                                       </div>
                                   </div>
                                </div>
                            </div>

							<?php if ( $WL_Gallery_Layout == "col-md-4" ) {
								if ( $i % 3 == 0 ) { ?>
                                    <div class="clearfix"></div>
									<?php
								}
							} else {
								if ( $i % 2 == 0 ) { ?>
                                    <div class="clearfix"></div>
									<?php
								}
							}
							$i ++;

						}
					}
					?>
                </div>
            </div>
		<?php endwhile; ?>
    </div>
	<?php wp_reset_query();

	return ob_get_clean();
}

?>