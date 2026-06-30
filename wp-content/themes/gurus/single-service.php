<?php
/**
 * @package Bravis-Themes
 */
get_header();
$post_id = get_the_ID();

// Bypass Elementor's content rendering so WP editor content is used directly.
if ( class_exists( '\Elementor\Plugin' ) && isset( \Elementor\Plugin::$instance->frontend ) ) {
    remove_filter( 'the_content', [ \Elementor\Plugin::$instance->frontend, 'apply_builder_in_content' ], 9 );
}
?>
<div class="container">
    <div id="pxl-content-area" class="pxl-service-single">
        <main id="pxl-content-main">
            <?php while ( have_posts() ) {
                the_post(); ?>
                <article id="pxl-post-<?php the_ID(); ?>" <?php post_class( 'pxl--service' ); ?>>
                    <div class="row pxl-service-row">

                        <!-- Left column: main content from WP editor -->
                        <div class="col-lg-8 col-md-12 pxl-service-content">
                            <?php
                            // Main post content (legacy H1 and service-link list stripped).
                            // Use 'raw' context to avoid display filters (e.g. Elementor/Polylang)
                            // that would otherwise return empty for posts with _elementor_data meta.
                            //
                            // IMPORTANT: do_blocks() is intentionally NOT used here because it
                            // inlines the full WordPress block stylesheet (~200 KB of CSS) into the
                            // return value, which pushes the total string past wp_kses_post()'s
                            // PCRE backtrack limit and causes the entire output to be silently lost.
                            //
                            // Additionally, any base64-encoded data URI embedded in an img src
                            // attribute must be stripped BEFORE wp_kses_post() is called, because
                            // a single ~380 KB base64 src value is enough to trigger the same
                            // PCRE backtrack-limit failure. (The image can be re-uploaded to the
                            // Media Library to avoid this problem at the source.)
                            //
                            // Gutenberg stores the rendered paragraph/heading/table HTML directly
                            // in post_content, so the text is visible even without block rendering.
                            $raw_content = get_post_field( 'post_content', $post_id, 'raw' );
                            // Remove embedded base64 data URIs (they crash wp_kses_post on large images).
                            $raw_content = preg_replace( '/\ssrc="data:[^"]*"/si', '', $raw_content );
                            // Strip legacy H1 headings and navigation-style UL lists.
                            $raw_content = preg_replace( '/<h1[^>]*>.*?<\/h1>/si', '', $raw_content );
                            $raw_content = preg_replace( '/<ul[^>]*>.*?<\/ul>/si', '', $raw_content );
                            // Strip Gutenberg block comments so they don't appear as visible text.
                            $raw_content = preg_replace( '/<!--\s*\/?wp:[^>]*-->/si', '', $raw_content );
                            echo wp_kses_post( $raw_content );
                            ?>
                        </div>

                        <!-- Right column: other services in the same category -->
                        <div class="col-lg-4 col-md-12 pxl-service-sidebar">
                            <?php
                            // If a 'cat' query parameter was passed (e.g. from the mercato elettrico page),
                            // validate it against actual terms and use it to filter the sidebar.
                            $forced_cat_slug = isset( $_GET['cat'] ) ? sanitize_title( wp_unslash( $_GET['cat'] ) ) : '';
                            $forced_cat_term = $forced_cat_slug ? get_term_by( 'slug', $forced_cat_slug, 'service-category' ) : false;

                            $service_cats = get_the_terms( $post_id, 'service-category' );
                            if ( ! empty( $service_cats ) && ! is_wp_error( $service_cats ) ) :
                                // Prefer the forced category (from URL) if it belongs to this service;
                                // otherwise fall back to the first assigned category.
                                $primary_cat = null;
                                if ( $forced_cat_term ) {
                                    foreach ( $service_cats as $sc ) {
                                        if ( $sc->term_id === $forced_cat_term->term_id ) {
                                            $primary_cat = $sc;
                                            break;
                                        }
                                    }
                                }
                                if ( ! $primary_cat ) {
                                    $primary_cat = reset( $service_cats );
                                }
                                $related_args = [
                                    'post_type'      => 'service',
                                    'posts_per_page' => -1,
                                    'post_status'    => 'publish',
                                    'post__not_in'   => [ $post_id ],
                                    'orderby'        => 'title',
                                    'order'          => 'ASC',
                                    'tax_query'      => [
                                        [
                                            'taxonomy'         => 'service-category',
                                            'field'            => 'term_id',
                                            'terms'            => [ $primary_cat->term_id ],
                                            'include_children' => false,
                                            'operator'         => 'IN',
                                        ],
                                    ],
                                ];
                                $related_query = new WP_Query( $related_args );
                                if ( $related_query->have_posts() ) : ?>
                                    <div class="pxl-recent-post">
                                        <div class="pxl-item--container">
                                            <div class="pxl-item--inner">
                                                <ul class="pxl-item--list">
                                                    <?php while ( $related_query->have_posts() ) :
                                                        $related_query->the_post();
                                                        $rel_id    = get_the_ID();
                                                        $icon_font = get_post_meta( $rel_id, 'service_icon_font', true );
                                                        $icon_img  = get_post_meta( $rel_id, 'service_icon_img', true );
                                                        ?>
                                                        <li class="pxl-post-item">
                                                            <h5 class="pxl-post--title">
                                                                <a class="pxl-item--link pxl-dark-100" href="<?php echo esc_url( get_permalink() ); ?>">
                                                                    <span class="pxl-item--icon">
                                                                        <?php if ( ! empty( $icon_font ) ) : ?>
                                                                            <i class="<?php echo esc_attr( $icon_font ); ?>"></i>
                                                                        <?php elseif ( ! empty( $icon_img ) && ! empty( $icon_img['id'] ) ) :
                                                                            echo wp_get_attachment_image( (int) $icon_img['id'], 'full' );
                                                                        else : ?>
                                                                            <svg width="33.92" height="37" viewBox="0 0 74 80" fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg"><path d="M0 19.9973V60.0027L36.6667 80L73.3333 60.0027V19.9973L36.6667 0L0 19.9973ZM71.0637 58.7696L36.6667 77.5339L2.26968 58.7696V21.2411L36.6667 2.47688L52.1459 10.9262C44.7694 10.122 32.5586 10.2185 22.9919 17.3489C13.4252 24.4686 8.91984 36.8744 9.57805 54.2019L9.60074 54.7916L36.6667 69.5564L63.7553 54.7809V23.9861L52.6452 30.0442V48.712L37.8015 56.8074V19.8794L36.3376 20.2976C36.1446 20.3512 31.6961 21.6593 27.2475 25.9161C23.1848 29.8191 18.339 37.046 18.4184 49.3339V49.945L36.6667 59.8955L54.9149 49.945V31.2773L61.4856 27.696V53.5371L36.6667 67.0795L11.825 53.5263C11.3144 37.2282 15.536 25.6266 24.3877 19.0323C37.3476 9.3714 56.254 13.6604 57.9336 14.0678L71.0637 21.2304V58.7696ZM35.5318 22.9031V56.8074L20.6881 48.712C20.8357 30.9128 31.5372 24.6294 35.5318 22.9031Z" fill="#20282D"/></svg>
                                                                        <?php endif; ?>
                                                                    </span>
                                                                    <?php echo esc_html( get_the_title() ); ?>
                                                                </a>
                                                            </h5>
                                                        </li>
                                                    <?php endwhile;
                                                    wp_reset_postdata(); ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif;
                            endif; ?>
                        </div>

                    </div><!-- .row -->

                    <?php wp_link_pages( [
                        'before'      => '<div class="page-links">',
                        'after'       => '</div>',
                        'link_before' => '<span>',
                        'link_after'  => '</span>',
                    ] ); ?>
                </article><!-- #post -->
                <?php if ( comments_open() || get_comments_number() ) {
                    comments_template();
                }
            } ?>
        </main>
    </div>
</div>
<?php get_footer(); ?>

