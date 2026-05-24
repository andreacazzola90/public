<?php

/**
 * Child Theme
 * 
 * @author Bravis-Themes
 * @since 1.0.1
 */
 
function gurus_child_enqueue_styles(){
    $parent_style = 'pxl-style'; 
    wp_enqueue_style('pxl-style-child', get_stylesheet_directory_uri() . '/style.css', array(
        $parent_style
    ));
}
add_action( 'wp_enqueue_scripts', 'gurus_child_enqueue_styles', 99);


function gurus_child_force_service_default_page_title($options) {
    if (!is_singular('service') || !is_array($options)) {
        return $options;
    }

    $options['pt_mode'] = 'df';

    return $options;
}
add_filter('case/setting/options', 'gurus_child_force_service_default_page_title', 20);

function gurus_child_service_page_title_background_image() {
    if (!is_singular('service')) {
        return;
    }

    $service_id = get_queried_object_id();
    if (!$service_id) {
        return;
    }

    $image_id = get_post_thumbnail_id($service_id);
    if (!$image_id) {
        return;
    }

    $image_url = wp_get_attachment_image_url($image_id, 'full');
    if (!$image_url) {
        return;
    }

    ?>
    <style id="gurus-child-service-page-title-bg">
        .elementor-background-overlay {
            background-image: url('<?php echo esc_url($image_url); ?>') !important;
        }
    </style>
    <?php
}
add_action('wp_head', 'gurus_child_service_page_title_background_image', 99);
