<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
wp_enqueue_style( 'respport-banner', WEBLIZAR_RG_PLUGIN_URL . 'css/rpg-banner.css' );
$gp_imgpath = WEBLIZAR_RG_PLUGIN_URL . "images/rpg_pro.png";
?>
<div class="wb_plugin_feature notice  is-dismissible">
    <div class="wb_plugin_feature_banner default_pattern pattern_ ">
        <div class="wb-col-md-6 wb-col-sm-12 box">
            <div class="ribbon"><span><?php esc_html_e( 'Go Pro', WEBLIZAR_RPG_TEXT_DOMAIN ); ?></span></div>
            <img class="wp-img-responsive" src="<?php echo esc_url($gp_imgpath); ?>" alt="img">
        </div>
        <div class="wb-col-md-6 wb-col-sm-12 wb_banner_featurs-list">
            <span class="gp_banner_head"><h2><?php esc_html_e( 'Responsive Photo Gallery Pro Features', WEBLIZAR_RPG_TEXT_DOMAIN ); ?> </h2></span>
            <ul>
                <li><?php esc_html_e( 'Gallery Layout', WEBLIZAR_RPG_TEXT_DOMAIN ); ?></li>
                <li><?php esc_html_e( 'Unlimited Hover Color', WEBLIZAR_RPG_TEXT_DOMAIN ); ?></li>
                <li><?php esc_html_e( '500 plus Font Style', WEBLIZAR_RPG_TEXT_DOMAIN ); ?></li>
                <li><?php esc_html_e( 'Isotope or Masonary Effects', WEBLIZAR_RPG_TEXT_DOMAIN ); ?></li>
                <li><?php esc_html_e( '10 Types Hover Color Opacity', WEBLIZAR_RPG_TEXT_DOMAIN ); ?></li>
                <li><?php esc_html_e( '8 Type of Hover Animations', WEBLIZAR_RPG_TEXT_DOMAIN ); ?></li>
                <li><?php esc_html_e( 'Multiple Image uploader', WEBLIZAR_RPG_TEXT_DOMAIN ); ?></li>
                <li><?php esc_html_e( '8 Types of Lightbox Integrated', WEBLIZAR_RPG_TEXT_DOMAIN ); ?></li>
                <li><?php esc_html_e( 'Drag and Drop image Position', WEBLIZAR_RPG_TEXT_DOMAIN ); ?></li>
                <li><?php esc_html_e( 'Shortcode Button on post or page', WEBLIZAR_RPG_TEXT_DOMAIN ); ?></li>
                <li><?php esc_html_e( 'Font Icon Customization & Many More', WEBLIZAR_RPG_TEXT_DOMAIN ); ?></li>
				<li><?php esc_html_e( 'Hide or Show Gallery Title and Label', WEBLIZAR_RPG_TEXT_DOMAIN ); ?></li>
            </ul>
            <div class="wp_btn-grup">
                <a class="wb_button-primary" href="http://demo.weblizar.com/responsive-photo-gallery-pro/"
                   target="_blank"><?php esc_html_e( 'View Demo', WEBLIZAR_RPG_TEXT_DOMAIN ); ?></a>
                <a class="wb_button-primary" href="https://weblizar.com/plugins/responsive-photo-gallery-pro/"
                   target="_blank"><?php esc_html_e( 'Buy Now', WEBLIZAR_RPG_TEXT_DOMAIN ); ?> <?php esc_html_e( '$19', WEBLIZAR_RPG_TEXT_DOMAIN ); ?></a>
            </div>
        </div>
    </div>
</div>