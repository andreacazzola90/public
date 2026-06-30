<?php 
$logo_m = gurus()->get_opt( 'logo_m', ['url' => get_template_directory_uri().'/assets/img/logo.png', 'id' => '' ] );
$logo_light_m = gurus()->get_opt( 'logo_light_m', ['url' => get_template_directory_uri().'/assets/img/logo-light.png', 'id' => '' ] );

// Usa il logo del template sticky per l'header mobile
$header_layout_sticky = (int) gurus()->get_opt('header_layout_sticky');
if ( $header_layout_sticky > 0 ) {
    $el_data_sticky = get_post_meta( $header_layout_sticky, '_elementor_data', true );
    if ( ! empty( $el_data_sticky ) ) {
        $el_stack = json_decode( $el_data_sticky, true );
        if ( is_array( $el_stack ) ) {
            while ( ! empty( $el_stack ) ) {
                $el = array_shift( $el_stack );
                if ( isset( $el['widgetType'] ) && $el['widgetType'] === 'pxl_logo' && ! empty( $el['settings']['logo']['id'] ) ) {
                    $sticky_logo_url = wp_get_attachment_image_url( (int) $el['settings']['logo']['id'], 'full' );
                    if ( $sticky_logo_url ) {
                        $logo_m = [ 'url' => $sticky_logo_url, 'id' => (int) $el['settings']['logo']['id'] ];
                    }
                    break;
                }
                if ( ! empty( $el['elements'] ) ) {
                    $el_stack = array_merge( $el['elements'], $el_stack );
                }
            }
        }
    }
}

$p_menu = gurus()->get_page_opt('p_menu');
$header_mobile = gurus()->get_page_opt('header_mobile', 'show');
$sticky_scroll = gurus()->get_opt('sticky_scroll');

$header_layout = gurus()->get_opt('header_layout');
$post_header = get_post($header_layout);
$header_type = get_post_meta( $post_header->ID, 'header_type', true );
$page_mobile_style = gurus()->get_page_opt('page_mobile_style');
$opt_mobile_style = gurus()->get_opt('opt_mobile_style');
$mobile_display = gurus()->get_opt('mobile_display');
if(isset($page_mobile_style) && !empty($page_mobile_style) && $page_mobile_style != 'inherit') {
    $opt_mobile_style = $page_mobile_style;
}
$header_mobile_layout = gurus()->get_opt('header_mobile_layout');
$header_mobile_layout_count = (int)gurus()->get_opt('header_mobile_layout');
$post_header_mobile = get_post($header_mobile_layout);

$header_mobile_type = (isset($post_header_mobile)) ? get_post_meta( $post_header_mobile->ID, 'header_mobile_type', true ) : '';
$is_show_header = gurus()->get_page_opt('header_display');

$is_sticky_header_mobile =  gurus()->get_theme_opt('sticky_header_m');

$is_sticky_header_mobile =  gurus()->get_theme_opt('sticky_header_m');
$sticky_header_mobile = ((bool)$is_sticky_header_mobile === true && $header_mobile_layout_count === 0) ? 'pxl-header-mobile-sticky' : '';
$classes = esc_attr('pxl-header-mobile-'.$header_mobile . ' ' . 'pxl-header-desktop-'.$is_show_header.' '.$sticky_header_mobile);

$header_sidebar_w =  get_post_meta( $post_header->ID, 'header_sidebar_width', 168 );
?>
<header id="pxl-header-elementor" class="is-sticky <?php echo esc_attr($classes); ?>" >
	<?php if(isset($args['header_layout']) && $args['header_layout'] > 0) : ?>
		<div class="pxl-header-elementor-main <?php echo esc_attr($header_type); ?>">
            <div class="pxl-header-content">
                <div class="row">
                    <div class="col-12">
                        <?php echo Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $args['header_layout']); ?>
                    </div>
                </div>
            </div>
		</div>
	<?php endif; ?>
	<?php if(isset($args['header_layout_sticky']) && $args['header_layout_sticky'] > 0) : ?>
		<div class="pxl-header-elementor-sticky pxl-onepage-sticky <?php echo esc_attr($sticky_scroll); ?>">
		    <div class="pxl-header-content">
		        <div class="row">
                    <div class="col-12">
    		            <?php echo Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $args['header_layout_sticky']); ?>
                    </div>
		        </div>
		    </div>
		</div>
	<?php endif; ?>
    <?php if($mobile_display == 'show') : ?>
        <div id="pxl-header-mobile" class="style-<?php echo esc_attr($opt_mobile_style); ?>">
            <div id="pxl-header-main" class="pxl-header-main">
                <div class="container">
                    <div class="row">
                        <?php if ($header_mobile_layout_count <= 0 || !class_exists('Pxltheme_Core') || !is_callable( 'Elementor\Plugin::instance' )) { ?>
                            <div class="pxl-header-mobile-default">
                                <div class="pxl-header-branding">
                                    <?php
                                        if ($logo_m['url']) {
                                            printf(
                                                '<a href="%1$s" title="%2$s" rel="home"><img src="%3$s" alt="%2$s"/></a>',
                                                esc_url( home_url( '/' ) ),
                                                esc_attr( get_bloginfo( 'name' ) ),
                                                esc_url( $logo_m['url'] )
                                            );
                                        }
                                    ?>
                                </div>
                                <div id="pxl-nav-mobile">
                                    <div class="pxl-nav-mobile-button pxl-anchor-divider pxl-cursor--cta">
                                        <span class="pxl-icon-line pxl-icon-line1"></span>
                                        <span class="pxl-icon-line pxl-icon-line2"></span>
                                        <span class="pxl-icon-line pxl-icon-line3"></span>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="pxl-header-mobile-elementor <?php echo esc_attr($header_mobile_type); ?>">
                                <?php echo Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $header_mobile_layout ); ?>
                            </div>
                        <?php } ?>
                        <div class="pxl-header-menu">
                            <div class="pxl-header-menu-scroll">
                                <div class="pxl-menu-close pxl-hide-xl pxl-close"></div>
                                <div class="pxl-logo-mobile pxl-hide-xl" style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                    <?php
                                        if ($logo_m['url']) {
                                            printf(
                                                '<a class="pxl-logo--dark" href="%1$s" title="%2$s" rel="home"><img src="%3$s" alt="%2$s"/></a>',
                                                esc_url( home_url( '/' ) ),
                                                esc_attr( get_bloginfo( 'name' ) ),
                                                esc_url( $logo_m['url'] )
                                            );
                                        }
                                    ?>
                                    <?php
                                        if ($logo_light_m['url']) {
                                            printf(
                                                '<a class="pxl-logo--light" href="%1$s" title="%2$s" rel="home"><img src="%3$s" alt="%2$s"/></a>',
                                                esc_url( home_url( '/' ) ),
                                                esc_attr( get_bloginfo( 'name' ) ),
                                                esc_url( $logo_light_m['url'] )
                                            );
                                        }
                                    ?>
                                    </div>
                                    <?php if ( function_exists( 'pll_the_languages' ) ) :
                                        $mobile_languages = pll_the_languages( array( 'raw' => 1 ) );
                                        $mobile_lang_curr = strtolower( pll_current_language() );
                                        if ( ! empty( $mobile_languages ) ) :
                                            $mobile_lang_links = array();
                                            foreach ( $mobile_languages as $mobile_lc => $mobile_lang ) {
                                                // Flag
                                                $mobile_flag_html = '';
                                                if ( function_exists( 'cpel_flag_code' ) ) {
                                                    $mobile_flag_code = cpel_flag_code( $mobile_lang['flag'] );
                                                    $mobile_flag_svg  = $mobile_flag_code ? cpel_flag_svg( $mobile_flag_code ) : false;
                                                    if ( $mobile_flag_svg ) {
                                                        $mobile_flag_contents = file_get_contents( CPEL_DIR . $mobile_flag_svg['path'] ); // phpcs:ignore WordPress.WP.AlternativeFunctions
                                                        $mobile_flag_src      = 'data:image/svg+xml;base64,' . base64_encode( $mobile_flag_contents );
                                                        $mobile_flag_img      = \PLL_Language::get_flag_html( array_merge( $mobile_flag_svg, array( 'src' => $mobile_flag_src ) ), '', $mobile_lang['name'] );
                                                    } elseif ( $mobile_flag_code ) {
                                                        $mobile_flag_info = method_exists( '\PLL_Language', 'get_flag_information' ) ? \PLL_Language::get_flag_information( $mobile_flag_code ) : \PLL_Language::get_flag_informations( $mobile_flag_code );
                                                        $mobile_flag_img  = \PLL_Language::get_flag_html( $mobile_flag_info, '', $mobile_lang['name'] );
                                                    } else {
                                                        $mobile_flag_img = '<img src="' . esc_url( $mobile_lang['flag'] ) . '" alt="' . esc_attr( $mobile_lang['name'] ) . '" />';
                                                    }
                                                    $mobile_flag_css  = $mobile_flag_code ? ' cpel-switcher__flag--' . $mobile_flag_code : '';
                                                    $mobile_flag_html = '<span class="cpel-switcher__flag' . $mobile_flag_css . '">' . $mobile_flag_img . '</span>';
                                                }
                                                $mobile_lang_links[ strtolower( $mobile_lc ) ] = sprintf(
                                                    '<a lang="%1$s" hreflang="%1$s" href="%2$s">%3$s<span class="cpel-switcher__code">%4$s</span></a>',
                                                    esc_attr( $mobile_lang['locale'] ),
                                                    esc_url( $mobile_lang['url'] ),
                                                    $mobile_flag_html,
                                                    esc_html( strtoupper( $mobile_lang['slug'] ) )
                                                );
                                            }
                                            $mobile_toggle_key  = array_key_exists( $mobile_lang_curr, $mobile_lang_links ) ? $mobile_lang_curr : current( array_keys( $mobile_lang_links ) );
                                            $mobile_toggle_link = $mobile_lang_links[ $mobile_toggle_key ];
                                            $mobile_toggle_link = str_replace( '</a>', '<i class="cpel-switcher__icon eicon-chevron-down" aria-hidden="true"></i></a>', $mobile_toggle_link );
                                            unset( $mobile_lang_links[ $mobile_toggle_key ] );
                                            $mobile_langs_count = count( $mobile_lang_links );
                                    ?>
                                    <div class="elementor-widget elementor-widget-polylang-language-switcher cpel-switcher--layout-dropdown cpel-switcher--align-right pxl-mobile-lang-switcher" style="--langs:<?php echo esc_attr( $mobile_langs_count ); ?>">
                                        <style>
                                            .pxl-mobile-lang-switcher .cpel-switcher__toggle--on + .cpel-switcher__list {
                                                max-height: 300px !important;
                                                background-color: #fff;
                                            }
                                            .pxl-mobile-lang-switcher .cpel-switcher__list {
                                                overflow: visible;
                                            }
                                        </style>
                                        <div class="elementor-widget-container">
                                            <nav class="cpel-switcher__nav" style="min-width: 45px;">
                                                <div class="cpel-switcher__toggle cpel-switcher__lang" onclick="this.classList.toggle('cpel-switcher__toggle--on')"><?php echo $mobile_toggle_link; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
                                                <?php if ( ! empty( $mobile_lang_links ) ) : ?>
                                                <ul class="cpel-switcher__list">
                                                    <?php foreach ( $mobile_lang_links as $mobile_lc => $mobile_ll ) : ?>
                                                    <li class="cpel-switcher__lang<?php echo $mobile_lc === $mobile_lang_curr ? ' cpel-switcher__lang--active' : ''; ?>"><?php echo $mobile_ll; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                                <?php endif; ?>
                                            </nav>
                                        </div>
                                    </div>
                                    <?php endif; endif; ?>
                                </div>
                                
                                <?php gurus_header_mobile_search_form(); ?>
                                <nav class="pxl-header-nav">
                                    <?php 
                                        if ( has_nav_menu( 'primary' ) ) {
                                            $attr_menu = array(
                                                'theme_location' => 'primary',
                                                'container'  => '',
                                                'menu_id'    => '',
                                                'menu_class' => 'pxl-menu-primary clearfix',
                                                'link_before'     => '<span>',
                                                'link_after'      => '</span>',
                                                'walker'         => class_exists( 'PXL_Mega_Menu_Walker' ) ? new PXL_Mega_Menu_Walker : '',
                                            );
                                            if(isset($p_menu) && !empty($p_menu)) {
                                                $attr_menu['menu'] = $p_menu;
                                            }
                                            wp_nav_menu( $attr_menu );
                                        } else { ?>
                                            <ul class="pxl-menu-primary">
                                                <?php wp_list_pages( array(
                                                    'depth'        => 0,
                                                    'show_date'    => '',
                                                    'date_format'  => get_option( 'date_format' ),
                                                    'child_of'     => 0,
                                                    'exclude'      => '',
                                                    'title_li'     => '',
                                                    'echo'         => 1,
                                                    'authors'      => '',
                                                    'sort_column'  => 'menu_order, post_title',
                                                    'link_before'  => '',
                                                    'link_after'   => '',
                                                    'item_spacing' => 'preserve',
                                                    'walker'       => '',
                                                ) ); ?>
                                            </ul>
                                        <?php }
                                    ?>
                                </nav>
                            </div>
                        </div>
                        <div class="pxl-header-menu-backdrop"></div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</header>