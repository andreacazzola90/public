<?php
/**
 * Theme functions: init, enqueue scripts and styles, include required files and widgets.
 *
 * @package Bravis-Themes
 * @since Gurus 1.0
 */

if(!defined('DEV_MODE')){ define('DEV_MODE', true); }

if(!defined('THEME_DEV_MODE_ELEMENTS') && is_user_logged_in()){
    define('THEME_DEV_MODE_ELEMENTS', true);
}
 
require_once get_template_directory() . '/inc/classes/class-main.php';

if ( is_admin() ){ 
	require_once get_template_directory() . '/inc/admin/admin-init.php'; }
 
/**
 * Theme Require
*/
gurus()->require_folder('inc');
gurus()->require_folder('inc/classes');
gurus()->require_folder('inc/theme-options');
gurus()->require_folder('template-parts/widgets');
if(class_exists('Woocommerce')){
    gurus()->require_folder('woocommerce');
}

/**
 * Register custom Gutenberg blocks.
 */
add_action( 'init', function () {
    register_block_type( get_template_directory() . '/blocks/service-list' );
} );

/**
 * Register Gutenberg sidebar plugin for service post settings.
 */
add_action( 'enqueue_block_editor_assets', function () {
    $dir    = get_template_directory() . '/blocks/service-settings';
    $uri    = get_template_directory_uri() . '/blocks/service-settings';
    $asset  = require $dir . '/index.asset.php';

    wp_register_script(
        'gurus-service-settings',
        $uri . '/index.js',
        $asset['dependencies'],
        $asset['version']
    );
    wp_enqueue_script( 'gurus-service-settings' );
} );

/**
 * Inject featured image as page title background when using the Elementor builder template.
 */
add_action( 'wp_head', function () {
    if ( is_404() || is_search() ) {
        return;
    }

    $pt_mode = gurus()->get_opt( 'pt_mode' );
    if ( $pt_mode !== 'bd' ) {
        return;
    }

    $featured_img_url = get_the_post_thumbnail_url( get_queried_object_id(), 'full' );
    if ( ! $featured_img_url ) {
        return;
    }

    echo '<style>#pxl-page-title-bulider > .elementor-widget-wrap { background-image: url(' . esc_url( $featured_img_url ) . '); background-size: cover; background-position: center center; background-repeat: no-repeat; }</style>' . "\n";
} );