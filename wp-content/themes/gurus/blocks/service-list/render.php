<?php
/**
 * Server-side render for the gurus/service-list block.
 *
 * Available variables:
 *   $attributes  – block attributes array
 *   $content     – inner block content (unused – no inner blocks)
 *   $block       – WP_Block instance
 *
 * @package Bravis-Themes
 */

$category_slug = ! empty( $attributes['categorySlug'] ) ? sanitize_title( $attributes['categorySlug'] ) : '';
$show_subtitle = isset( $attributes['showSubtitle'] ) ? (bool) $attributes['showSubtitle'] : true;

if ( empty( $category_slug ) ) {
    return '<p class="gurus-service-list--empty">' . esc_html__( 'Seleziona una categoria nella barra laterale del blocco.', 'gurus' ) . '</p>';
}

$query = new WP_Query( [
    'post_type'      => 'service',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => 'title',
    'order'          => 'ASC',
    'tax_query'      => [
        [
            'taxonomy'         => 'service-category',
            'field'            => 'slug',
            'terms'            => $category_slug,
            'include_children' => false,
            'operator'         => 'IN',
        ],
    ],
] );

if ( ! $query->have_posts() ) {
    return '<p class="gurus-service-list--empty">' . esc_html__( 'Nessun servizio trovato in questa categoria.', 'gurus' ) . '</p>';
}

ob_start();
?>
<div class="pxl-grid pxl-service-grid pxl-service-grid-layout2 gurus-service-list-block">
    <div class="pxl-grid-inner row" data-gutter="30">
        <?php while ( $query->have_posts() ) :
            $query->the_post();
            $post_id   = get_the_ID();
            $icon_type = get_post_meta( $post_id, 'service_icon_type', true );
            $icon_font = get_post_meta( $post_id, 'service_icon_font', true );
            $icon_img  = get_post_meta( $post_id, 'service_icon_img', true );
            $post_link = get_post_meta( $post_id, 'service_external_link', true );
            if ( empty( $post_link ) ) {
                $post_link = add_query_arg( 'cat', $category_slug, get_permalink() );
            }

            // Subtitle: use post_excerpt first, then extract from content if empty.
            $subtitle = get_the_excerpt();
            if ( empty( $subtitle ) && $show_subtitle ) {
                $raw = get_post_field( 'post_content', $post_id );
                if ( preg_match( '/<p[^>]*>\s*<i[^>]*>(.*?)<\/i>\s*<\/p>/si', $raw, $m ) ) {
                    $subtitle = wp_strip_all_tags( $m[1] );
                }
            }
            ?>
            <div class="pxl-grid-item col-lg-4 col-md-6 col-12">
                <div class="pxl-post--inner">
                    <div class="pxl-post--holder">

                        <?php /* Icon */
                        if ( $icon_type === 'icon' && ! empty( $icon_font ) ) : ?>
                            <div class="pxl-post-icon pxl-flex-center">
                                <i class="<?php echo esc_attr( $icon_font ); ?>"></i>
                            </div>
                        <?php elseif ( ! empty( $icon_img ) && ! empty( $icon_img['id'] ) ) :
                            $icon_src = pxl_get_image_by_size( [
                                'attach_id'  => (int) $icon_img['id'],
                                'thumb_size' => 'full',
                            ] );
                            if ( ! empty( $icon_src['thumbnail'] ) ) : ?>
                                <div class="pxl-post--icon pxl-flex-center">
                                    <?php echo wp_kses_post( $icon_src['thumbnail'] ); ?>
                                </div>
                            <?php endif;
                        endif; ?>

                        <?php /* Title */ ?>
                        <h4 class="pxl-post--title pxl-hover-line">
                            <a href="<?php echo esc_url( $post_link ); ?>">
                                <?php echo esc_html( get_the_title() ); ?>
                            </a>
                        </h4>

                        <?php /* Subtitle */ ?>
                        <?php if ( $show_subtitle && ! empty( $subtitle ) ) : ?>
                            <div class="pxl-post--excerpt pxl-post--subtitle pxl-p3 pxl-dark-slate">
                                <?php echo esc_html( $subtitle ); ?>
                            </div>
                        <?php endif; ?>

                        <div class="pxl-post-btn--wrap">
                            <a class="btn btn-readmore pxl-post--btn btn-hover btn-round pxl-dark-100 btn-hover-style-2"
                               href="<?php echo esc_url( $post_link ); ?>">
                                <span class="pxl-btn--text"><?php esc_html_e( 'Scopri di più', 'gurus' ); ?></span>
                                <i class="flaticon flaticon-plus-medium"></i>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        <?php endwhile;
        wp_reset_postdata(); ?>
        <div class="grid-sizer col-lg-4 col-md-6 col-12"></div>
    </div>
</div>
<?php
echo ob_get_clean();
