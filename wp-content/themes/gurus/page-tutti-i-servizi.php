<?php
/**
 * Template for: Tutti i servizi
 * Renders all services in the "services" category as a 3-column grid.
 *
 * @package Bravis-Themes
 */
get_header();
?>
<div class="container">
    <div id="pxl-content-area">
        <main id="pxl-content-main">
            <?php
            // Render the page's WP editor content (Gutenberg blocks, text, etc.)
            while ( have_posts() ) {
                the_post();
                the_content();
            }
            ?>
            <?php
            $services_query = new WP_Query( [
                'post_type'      => 'service',
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'orderby'        => 'title',
                'order'          => 'ASC',
                'tax_query'      => [
                    [
                        'taxonomy'         => 'service-category',
                        'field'            => 'slug',
                        'terms'            => 'services',
                        'include_children' => false,
                        'operator'         => 'IN',
                    ],
                ],
            ] );

            if ( $services_query->have_posts() ) : ?>
                <div class="pxl-grid pxl-service-grid pxl-service-grid-layout2">
                    <div class="pxl-grid-inner row" data-gutter="30">
                        <?php while ( $services_query->have_posts() ) :
                            $services_query->the_post();
                            $post_id   = get_the_ID();
                            $icon_type = get_post_meta( $post_id, 'service_icon_type', true );
                            $icon_font = get_post_meta( $post_id, 'service_icon_font', true );
                            $icon_img  = get_post_meta( $post_id, 'service_icon_img', true );
                            $post_link = get_post_meta( $post_id, 'service_external_link', true );
                            if ( empty( $post_link ) ) {
                                $post_link = get_permalink();
                            }
                            ?>
                            <div class="pxl-grid-item col-lg-4 col-md-6 col-12">
                                <div class="pxl-post--inner">
                                    <div class="pxl-post--holder">

                                        <?php if ( $icon_type === 'icon' && ! empty( $icon_font ) ) : ?>
                                            <div class="pxl-post-icon pxl-flex-center">
                                                <i class="<?php echo esc_attr( $icon_font ); ?>"></i>
                                            </div>
                                        <?php elseif ( $icon_type === 'image' && ! empty( $icon_img ) && ! empty( $icon_img['id'] ) ) :
                                            $icon_src = pxl_get_image_by_size( [
                                                'attach_id'  => (int) $icon_img['id'],
                                                'thumb_size' => 'full',
                                            ] );
                                            if ( ! empty( $icon_src['thumbnail'] ) ) : ?>
                                                <div class="pxl-post--icon pxl-flex-center">
                                                    <?php echo wp_kses_post( $icon_src['thumbnail'] ); ?>
                                                </div>
                                            <?php endif;
                                        elseif ( ! empty( $icon_img ) && ! empty( $icon_img['id'] ) ) :
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

                                        <h4 class="pxl-post--title pxl-hover-line">
                                            <a href="<?php echo esc_url( $post_link ); ?>">
                                                <?php echo esc_html( get_the_title() ); ?>
                                            </a>
                                        </h4>

                                        <?php $excerpt = get_the_excerpt();
                                        if ( ! empty( $excerpt ) ) : ?>
                                            <div class="pxl-post--excerpt pxl-p3 pxl-dark-slate">
                                                <?php echo esc_html( wp_trim_words( $excerpt, 20 ) ); ?>
                                            </div>
                                        <?php endif; ?>

                                        <div class="pxl-post-btn--wrap">
                                            <a class="btn btn-readmore pxl-post--btn btn-hover btn-round pxl-dark-100 btn-hover-style-2" href="<?php echo esc_url( $post_link ); ?>">
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
            <?php endif; ?>
        </main>
    </div>
</div>
<?php get_footer(); ?>
