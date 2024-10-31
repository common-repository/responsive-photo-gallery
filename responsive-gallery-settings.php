<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Load Saved Image Gallery settings
 */
$WL_RG_Settings = unserialize( get_option( "WL_IGP_Settings" ) );
if ( count( $WL_RG_Settings ) ) {
	$WL_Hover_Animation     = $WL_RG_Settings['WL_Hover_Animation'];
	$WL_Open_Image_Link_Tab = $WL_RG_Settings['WL_Open_Image_Link_Tab'];
	$WL_Gallery_Layout      = $WL_RG_Settings['WL_Gallery_Layout'];
	$WL_Hover_Color         = $WL_RG_Settings['WL_Hover_Color'];
	$WL_Font_Style          = $WL_RG_Settings['WL_Font_Style'];
	$WL_Image_View_Icon     = $WL_RG_Settings['WL_Image_View_Icon'];
	$WL_Gallery_Title       = $WL_RG_Settings['WL_Gallery_Title'];
	$WL_Hover_Color_Opacity = $WL_RG_Settings['WL_Hover_Color_Opacity'];
	$WL_Custom_CSS          = $WL_RG_Settings['WL_Custom_CSS'];

} else {
	$WL_Hover_Animation     = "fade";
	$WL_Open_Image_Link_Tab = "_blank";
	$WL_Gallery_Layout      = "col-md-6";
	$WL_Hover_Color         = "#37393d";
	$WL_Font_Style          = "Arial";
	$WL_Image_View_Icon     = "far fa-image";
	$WL_Gallery_Title       = "yes";
	$WL_Hover_Color_Opacity = "1";
	$WL_Custom_CSS          = "";
}
?>

    <script>
        jQuery(document).ready(function () {
            var editor = CodeMirror.fromTextArea(document.getElementById("wl-custom-css"), {
                lineNumbers: true,
                styleActiveLine: true,
                matchBrackets: true,
                hint: true,
                theme: 'blackboard',
                lineWrapping: true,
                extraKeys: {"Ctrl-Space": "autocomplete"},
            });
        });
    </script>
    <style type="text/css">
        .rpgp_settings {
            padding: 25px;
            background-color: white;
            margin-top: 15px;
        }
    </style>
<div class="rpgp_settings">
    <h2><?php esc_html_e( "Responsive Gallery Settings", WEBLIZAR_RPG_TEXT_DOMAIN ); ?></h2>
    <form action="?post_type=responsive-gallery&page=image-gallery-settings" method="post">
    <?php $nonce = wp_create_nonce( 'nonce_save_gallery_setting' ); ?>
        <input type="hidden" name="security" value="<?php echo esc_attr( $nonce ); ?>">
        <input type="hidden" id="wl_action" name="wl_action" value="wl-save-settings">
        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row"><label><?php esc_html_e( "Image Hover Animation", WEBLIZAR_RPG_TEXT_DOMAIN ); ?></label></th>
                <td>
                    <select name="wl-hover-animation" id="wl-hover-animation">
                        <optgroup label="Select Animation">
                            <option value="fade" <?php if ( $WL_Hover_Animation == 'fade' ) {
								echo "selected=selected";
							} ?>><?php esc_html_e( "Fade", WEBLIZAR_RPG_TEXT_DOMAIN ); ?></option>
                            <!--<option value="stroke" <?php /*if($WL_Hover_Animation == 'stroke') echo "selected=selected"; */ ?>>Stroke</option>-->
                        </optgroup>
                    </select>
                    <p class="description">
                        <strong><?php esc_html_e( "Choose an animation effect apply on mouse hover.", WEBLIZAR_RPG_TEXT_DOMAIN ); ?></strong>
                        (<?php esc_html_e( 'Get More 6 animation effect in plugin, View ', WEBLIZAR_RPG_TEXT_DOMAIN ); ?><a href="http://weblizar.com/plugins/responsive-photo-gallery-pro/" target="_new"><?php esc_html_e( 'detail', WEBLIZAR_RPG_TEXT_DOMAIN ); ?></a> )</p>
                </td>
            </tr>

            <tr>
                <th scope="row"><label><?php esc_html_e( "Open Image Link URL In", WEBLIZAR_RPG_TEXT_DOMAIN ); ?></label></th>
                <td>
					<?php
					if ( isset( $WL_RG_Settings['WL_Open_Image_Link_Tab'] ) ) {
						$WL_Open_Image_Link_Tab = $WL_RG_Settings['WL_Open_Image_Link_Tab'];
					} else {
						$WL_Open_Image_Link_Tab = "_blank";
					}
					?>
                    <input type="radio" name="wl-open-image-link-tab" id="wl-open-image-link-tab"
                           value="_blank" <?php if ( $WL_Open_Image_Link_Tab == '_blank' ) {
						echo "checked";
					} ?>><?php esc_html_e( ' New Tab', WEBLIZAR_RPG_TEXT_DOMAIN ); ?>
                    <input type="radio" name="wl-open-image-link-tab" id="wl-open-image-link-tab"
                           value="_self" <?php if ( $WL_Open_Image_Link_Tab == '_self' ) {
						echo "checked";
					} ?>> <?php esc_html_e( ' Same Tab', WEBLIZAR_RPG_TEXT_DOMAIN ); ?>

                    <p class="description"><?php esc_html_e( "Open Image link URL in New Tab or Same Tab.", WEBLIZAR_RPG_TEXT_DOMAIN ); ?> </p>
                </td>
            </tr>

            <tr>
                <th scope="row"><label><?php esc_html_e( "Gallery Layout", WEBLIZAR_RPG_TEXT_DOMAIN ); ?></label></th>
                <td>
                    <select name="wl-gallery-layout" id="wl-gallery-layout">
                        <optgroup label="Select Gallery Layout">
                            <option value="col-md-6" <?php if ( $WL_Gallery_Layout == 'col-md-6' ) {
								echo "selected=selected";
							} ?>><?php esc_html_e( "Two Column", WEBLIZAR_RPG_TEXT_DOMAIN ); ?></option>
                            <option value="col-md-4" <?php if ( $WL_Gallery_Layout == 'col-md-4' ) {
								echo "selected=selected";
							} ?>><?php esc_html_e( "Three Column", WEBLIZAR_RPG_TEXT_DOMAIN ); ?></option>
                        </optgroup>
                    </select>
                    <p class="description">
                        <strong><?php esc_html_e( "Choose a column layout for image gallery.", WEBLIZAR_RPG_TEXT_DOMAIN ); ?></strong>
                        (<?php esc_html_e( 'Get More Column Layout in plugin, View', WEBLIZAR_RPG_TEXT_DOMAIN ); ?> <a
                                href="http://weblizar.com/plugins/responsive-photo-gallery-pro/"
                                target="_new"><?php esc_html_e( 'detail', WEBLIZAR_RPG_TEXT_DOMAIN ); ?></a> )</p>
                </td>
            </tr>

            <tr>
                <th scope="row"><label><?php esc_html_e( "Display Gallery Title", WEBLIZAR_RPG_TEXT_DOMAIN ); ?></label></th>
                <td>
                    <input type="radio" name="wl-gallery-title" id="wl-gallery-title"
                           value="yes" <?php if ( $WL_Gallery_Title == 'yes' ) {
						echo "checked";
					} ?>><?php esc_html_e( ' Yes', WEBLIZAR_RPG_TEXT_DOMAIN ); ?>
                    <input type="radio" name="wl-gallery-title" id="wl-gallery-title"
                           value="no" <?php if ( $WL_Gallery_Title == 'no' ) {
						echo "checked";
					} ?>><?php esc_html_e( ' No', WEBLIZAR_RPG_TEXT_DOMAIN ); ?>

                    <p class="description"><?php esc_html_e( "Select yes if you want show gallery title .", WEBLIZAR_RPG_TEXT_DOMAIN ); ?> </p>
                </td>
            </tr>

            <tr>
                <th scope="row"><label><?php esc_html_e( "Hover Color", WEBLIZAR_RPG_TEXT_DOMAIN ); ?></label></th>
                <td>
                    <input type="radio" name="wl-hover-color" id="wl-hover-color"
                           value="#74C9BE" <?php if ( $WL_Hover_Color == '#74C9BE' ) {
						echo "checked";
					} ?>> <span
                            style="color: #74C9BE; font-size: large; font-weight: bolder;"><?php esc_html_e( "Color 1", WEBLIZAR_RPG_TEXT_DOMAIN ); ?></span>
                    <input type="radio" name="wl-hover-color" id="wl-hover-color"
                           value="#31A3DD" <?php if ( $WL_Hover_Color == '#31A3DD' ) {
						echo "checked";
					} ?>> <span
                            style="color: #31A3DD; font-size: large; font-weight: bolder;"><?php esc_html_e( "Color 2", WEBLIZAR_RPG_TEXT_DOMAIN ); ?></span>
                    <input type="radio" name="wl-hover-color" id="wl-hover-color"
                           value="#37393d" <?php if ( $WL_Hover_Color == '#37393d' ) {
						echo "checked";
					} ?>> <span
                            style="color: #37393d; font-size: large; font-weight: bolder;"><?php esc_html_e( "Color 3", WEBLIZAR_RPG_TEXT_DOMAIN ); ?></span>
                    <p class="description">
                        <strong><?php esc_html_e( "Choose a color apply on mouse hover.", WEBLIZAR_RPG_TEXT_DOMAIN ); ?> </strong>
                        (<?php esc_html_e( 'Get Unlimited Color Scheme for gallery, View', WEBLIZAR_RPG_TEXT_DOMAIN ); ?>
						<a href="http://weblizar.com/plugins/responsive-photo-gallery-pro/" target="_new">
							<?php esc_html_e( 'detail', WEBLIZAR_RPG_TEXT_DOMAIN ); ?></a> )
					</p>
                </td>
            </tr>

            <tr>
                <th scope="row"><label><?php esc_html_e( "Hover Color Opacity", WEBLIZAR_RPG_TEXT_DOMAIN ); ?></label></th>
                <td>
                    <input type="radio" name="wl-hover-color-opacity" id="wl-hover-color-opacity"
                           value="0.5" <?php if ( $WL_Hover_Color_Opacity == '0.5' ) {
						echo "checked";
					} ?>> <?php esc_html_e( 'Yes', WEBLIZAR_RPG_TEXT_DOMAIN ); ?>
                    <input type="radio" name="wl-hover-color-opacity" id="wl-hover-color-opacity"
                           value="1" <?php if ( $WL_Hover_Color_Opacity == '1' ) {
						echo "checked";
					} ?>> <?php esc_html_e( 'No', WEBLIZAR_RPG_TEXT_DOMAIN ); ?>

                    <p class="description">
                        <strong><?php esc_html_e( "Select yes if you want show gallery title .", WEBLIZAR_RPG_TEXT_DOMAIN ); ?>  </strong>
                        ( <?php esc_html_e( 'Get More 10 opacity effect in plugin, View ', WEBLIZAR_RPG_TEXT_DOMAIN ); ?>
						<a href="http://weblizar.com/plugins/responsive-photo-gallery-pro/" target="_new">
						<?php esc_html_e( 'detail', WEBLIZAR_RPG_TEXT_DOMAIN ); ?></a> )
					</p>
                </td>
            </tr>
            <tr>
                <th scope="row"><label><?php esc_html_e( "Image View Icon", WEBLIZAR_RPG_TEXT_DOMAIN ); ?></label></th>
                <td>
                    <input type="radio" name="wl-image-view-icon" id="wl-image-view-icon" value="far fa-image" <?php if ( $WL_Image_View_Icon == 'far fa-image' ) { echo "checked";	} ?>> <i class="far fa-image fa-3x"></i>
                    <input type="radio" name="wl-image-view-icon" id="wl-image-view-icon"
                           value="fas fa-camera" <?php if ( $WL_Image_View_Icon == 'fas fa-camera' ) {
						echo "checked";
					} ?>> <i class="fas fa-camera fa-3x"></i>
                    <input type="radio" name="wl-image-view-icon" id="wl-image-view-icon"
                           value="fas fa-camera-retro" <?php if ( $WL_Image_View_Icon == 'fas fa-camera-retro' ) {
						echo "checked";
					} ?>> <i class="fas fa-camera-retro fa-3x"></i>
                    <p class="description">
                        <strong><?php esc_html_e( "Choose image view icon.", WEBLIZAR_RPG_TEXT_DOMAIN ); ?>  </strong>
                         (<?php esc_html_e( 'Get Unlimited Font Awesome Icon in plugin, View', WEBLIZAR_RPG_TEXT_DOMAIN ); ?>
						 <a href="http://weblizar.com/plugins/responsive-photo-gallery-pro/" target="_new">
						 <?php esc_html_e( 'detail', WEBLIZAR_RPG_TEXT_DOMAIN ); ?></a> )
					</p>
                </td>
            </tr>

            <tr>
                <th scope="row"><label><?php esc_html_e( "Caption Font Style", WEBLIZAR_RPG_TEXT_DOMAIN ); ?></label></th>
                <td>
                    <select name="wl-font-style" class="standard-dropdown" id="wl-font-style">
                        <optgroup label="Default Fonts">
                            <option value="Arial" <?php selected( $WL_Font_Style, 'Arial' ); ?>><?php esc_html_e( 'Arial', WEBLIZAR_RPG_TEXT_DOMAIN ); ?></option>
                            <option value="Arial Black" <?php selected( $WL_Font_Style, 'Arial Black' ); ?>>
                                Black<?php esc_html_e( 'Arial', WEBLIZAR_RPG_TEXT_DOMAIN ); ?>
                            </option>
                            <option value="Courier New" <?php selected( $WL_Font_Style, 'Courier New' ); ?>><?php esc_html_e( 'Courier
                                New', WEBLIZAR_RPG_TEXT_DOMAIN ); ?>
                            </option>
                            <option value="cursive" <?php selected( $WL_Font_Style, 'cursive' ); ?>><?php esc_html_e( 'Cursive', WEBLIZAR_RPG_TEXT_DOMAIN ); ?></option>
                            <option value="fantasy" <?php selected( $WL_Font_Style, 'fantasy' ); ?>><?php esc_html_e( 'Fantasy', WEBLIZAR_RPG_TEXT_DOMAIN ); ?></option>
                            <option value="Georgia" <?php selected( $WL_Font_Style, 'Georgia' ); ?>><?php esc_html_e( 'Georgia', WEBLIZAR_RPG_TEXT_DOMAIN ); ?></option>
                            <option value="Grande"<?php selected( $WL_Font_Style, 'Grande' ); ?>><?php esc_html_e( 'Grande', WEBLIZAR_RPG_TEXT_DOMAIN ); ?></option>
                            <option value="Helvetica Neue" <?php selected( $WL_Font_Style, 'Helvetica Neue' ); ?>><?php esc_html_e( ' Helvetica Neue', WEBLIZAR_RPG_TEXT_DOMAIN ); ?>
                            </option>
                            <option value="Impact" <?php selected( $WL_Font_Style, 'Impact' ); ?>><?php esc_html_e( 'Impact', WEBLIZAR_RPG_TEXT_DOMAIN ); ?></option>
                            <option value="Lucida" <?php selected( $WL_Font_Style, 'Lucida' ); ?>><?php esc_html_e( 'Lucida', WEBLIZAR_RPG_TEXT_DOMAIN ); ?></option>
                            <option value="Lucida Console"<?php selected( $WL_Font_Style, 'Lucida Console' ); ?>><?php esc_html_e( 'Lucida
                                Console', WEBLIZAR_RPG_TEXT_DOMAIN ); ?>
                            </option>
                            <option value="monospace" <?php selected( $WL_Font_Style, 'monospace' ); ?>><?php esc_html_e( 'Monospace', WEBLIZAR_RPG_TEXT_DOMAIN ); ?>
                            </option>
                            <option value="Open Sans" <?php selected( $WL_Font_Style, 'Open Sans' ); ?>><?php esc_html_e( 'Open Sans', WEBLIZAR_RPG_TEXT_DOMAIN ); ?>
                            </option>
                            <option value="Palatino" <?php selected( $WL_Font_Style, 'Palatino' ); ?>><?php esc_html_e( 'Palatino', WEBLIZAR_RPG_TEXT_DOMAIN ); ?></option>
                            <option value="sans" <?php selected( $WL_Font_Style, 'sans' ); ?>><?php esc_html_e( 'Sans', WEBLIZAR_RPG_TEXT_DOMAIN ); ?></option>
                            <option value="sans-serif" <?php selected( $WL_Font_Style, 'sans-serif' ); ?>><?php esc_html_e( 'Sans-Serif', WEBLIZAR_RPG_TEXT_DOMAIN ); ?>
                            </option>
                            <option value="Tahoma" <?php selected( $WL_Font_Style, 'Tahoma' ); ?>><?php esc_html_e( 'Tahoma', WEBLIZAR_RPG_TEXT_DOMAIN ); ?></option>
                            <option value="Times New Roman"<?php selected( $WL_Font_Style, 'Times New Roman' ); ?>><?php esc_html_e( 'Times
                                New Roman', WEBLIZAR_RPG_TEXT_DOMAIN ); ?>
                            </option>
                            <option value="Trebuchet MS" <?php selected( $WL_Font_Style, 'Trebuchet MS' ); ?>><?php esc_html_e( 'Trebuchet MS', WEBLIZAR_RPG_TEXT_DOMAIN ); ?>
                            </option>
                            <option value="Verdana" <?php selected( $WL_Font_Style, 'Verdana' ); ?>><?php esc_html_e( 'Verdana', WEBLIZAR_RPG_TEXT_DOMAIN ); ?></option>
                        </optgroup>
                    </select>
                    <p class="description">
                        <strong><?php esc_html_e( "Choose a caption font style.", WEBLIZAR_RPG_TEXT_DOMAIN ); ?> </strong> (<?php esc_html_e( 'Get
                        500+ Google fonts for gallery, View', WEBLIZAR_RPG_TEXT_DOMAIN ); ?> <a
                                href="http://weblizar.com/plugins/responsive-photo-gallery-pro/"
                                target="_new"><?php esc_html_e( 'detail', WEBLIZAR_RPG_TEXT_DOMAIN ); ?></a> )</p>
                </td>
            </tr>

            <tr>
                <th scope="row"><label><?php esc_html_e( 'Custom CSS', 'WEBLIZAR_RPG_TEXT_DOMAIN' ) ?></label></th>
                <td>
					<?php if ( ! isset( $WL_Custom_CSS ) ) {
						$WL_Custom_CSS = "";
					} ?>
                    <textarea id="wl-custom-css" name="wl-custom-css" type="text" class=""
                              style="width:80%"><?php echo esc_html($WL_Custom_CSS); ?></textarea>
                    <p class="description">
						<?php esc_html_e( 'Enter any custom css you want to apply on this gallery.', WEBLIZAR_RPG_TEXT_DOMAIN) ?>
                        <br>
                    </p>
                    <p class="custnote"><?php esc_html_e( "Note", WEBLIZAR_RPG_TEXT_DOMAIN ); ?>
                        : <?php esc_html_e( "Please Do Not Use", WEBLIZAR_RPG_TEXT_DOMAIN ); ?>
                        &nbsp;<?php esc_html_e( "", WEBLIZAR_RPG_TEXT_DOMAIN ); ?>
                        <b><?php esc_html_e( "Style", WEBLIZAR_RPG_TEXT_DOMAIN ); ?></b>&nbsp;<?php esc_html_e( 'Tag With Custom CSS', WEBLIZAR_RPG_TEXT_DOMAIN ); ?>
                    </p>
                    <p class="submit" style="margin-top: 25px;">
                        <input type="submit" value="<?php esc_attr_e( "Save Changes", WEBLIZAR_RPG_TEXT_DOMAIN ); ?>"
                               class="button button-primary" id="submit" name="submit">
                    </p>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>
<?php
if ( isset( $_POST['wl_action'] ) && isset( $_POST['security']) ) {
    if ( ! wp_verify_nonce( $_POST['security'], 'nonce_save_gallery_setting' ) ) {
        die();}
	$Action = $_POST['wl_action'];
	//save settings
	if ( $Action == "wl-save-settings" ) {
        $WL_Hover_Animation     = isset($_POST['wl-hover-animation']) ? sanitize_option( 'WL_Hover_Animation', $_POST['wl-hover-animation'] ): '';
        $WL_Open_Image_Link_Tab = isset($_POST['wl-open-image-link-tab']) ? sanitize_option( 'WL_Open_Image_Link_Tab', $_POST['wl-open-image-link-tab']): '';
        $WL_Gallery_Layout      = isset($_POST['wl-gallery-layout']) ? sanitize_option( 'WL_Gallery_Layout', $_POST['wl-gallery-layout']) : '';
        $WL_Hover_Color         = isset($_POST['wl-hover-color'])? sanitize_option( 'WL_Hover_Color', $_POST['wl-hover-color'] ) : '';
        $WL_Font_Style          = isset($_POST['wl-font-style']) ? sanitize_option( 'WL_Font_Style', $_POST['wl-font-style'] ): '';
        $WL_Image_View_Icon     = isset($_POST['wl-image-view-icon']) ? sanitize_option( 'WL_Image_View_Icon', $_POST['wl-image-view-icon'] ) : '';
        $WL_Gallery_Title       = isset($_POST['wl-gallery-title']) ? sanitize_option( 'WL_Gallery_Title', $_POST['wl-gallery-title'] ) : '';
        $WL_Hover_Color_Opacity = isset($_POST['wl-hover-color-opacity'])? sanitize_option( 'WL_Hover_Color_Opacity', $_POST['wl-hover-color-opacity'] ): '';
        $WL_Custom_CSS          = isset($_POST['wl-custom-css']) ? sanitize_option( 'WL_Custom_CSS', $_POST['wl-custom-css'] ) : '';

		$SettingsArray = serialize( array(
			'WL_Hover_Animation'     => $WL_Hover_Animation,
			'WL_Open_Image_Link_Tab' => $WL_Open_Image_Link_Tab,
			'WL_Gallery_Layout'      => $WL_Gallery_Layout,
			'WL_Hover_Color'         => $WL_Hover_Color,
			'WL_Hover_Color_Opacity' => $WL_Hover_Color_Opacity,
			'WL_Font_Style'          => $WL_Font_Style,
			'WL_Image_View_Icon'     => $WL_Image_View_Icon,
			'WL_Gallery_Title'       => $WL_Gallery_Title,
			'WL_Custom_CSS'          => $WL_Custom_CSS
		) );

		update_option( "WL_IGP_Settings", $SettingsArray );
		echo "<script>location.href = location.href;</script>";
	}
}
?>
