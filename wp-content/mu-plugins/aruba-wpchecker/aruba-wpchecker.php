<?php

namespace Elementor {
	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	add_action(
		'plugins_loaded',
		function () {
			if ( ! class_exists( 'Elementor\Scheme_Color' ) && class_exists( 'Elementor\Core\Schemes\Color' ) ) {
				class Scheme_Color extends Core\Schemes\Color {}
			}

			if ( ! class_exists( 'Elementor\Scheme_Typography' ) && class_exists( 'Elementor\Core\Schemes\Typography' ) ) {
				class Scheme_Typography extends Core\Schemes\Typography {}
			}
		}
	);
}

/**
 * MU Plugin: ARUBA_WPCHEKER
 */
namespace {
	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	define( 'ARUBA_WPCHEKER_VERSION', 18 );

	define( 'AWPC_LOCALE', strtolower( substr( get_bloginfo( 'language' ), 0, 2 ) ) );

	const AWPC_LOCALIZE = array(
		'general_message'       => array(
			'it' => 'Uno o più plugin installati violano i termini di utilizzo di Aruba.',
			'en' => 'One or more plugins you have installed violate Aruba\'s terms of use',
			'es' => 'Uno o más complementos que ha instalado infringen los términos de uso de Aruba.',
		),
		'manage_plugins'        => array(
			'it' => 'Gestisci plugin',
			'en' => 'Manage plugins',
			'es' => 'Administrar plugins',
		),
		'plugins_message'       => array(
			'it' => 'I seguenti plugin sono installati ma non sono consentiti dai termini di utilizzo di Aruba e potrebbero causare la sospensione del servizio. Si consiglia di disinstallare i plugin. Per ulteriori informazioni',
			'en' => 'The following plugins are installed but are not permitted by Aruba\'s terms of use and may cause your service to be suspended. We recommend uninstalling the plugins. For more information ',
			'es' => 'Los siguientes complementos están instalados, pero no están permitidos por los términos de uso de Aruba y pueden provocar la suspensión de su servicio. Recomendamos desinstalar los complementos. Para obtener más información',
		),
		'consult_the_blacklist' => array(
			'it' => 'consulta la blacklist',
			'en' => 'consult the blacklist',
			'es' => 'consultar la blacklist',
		),
		'link_base'             => array(
			'it' => 'https://guide.aruba.it/hosting-e-domini/hosting/hosting-wordpress-wordpressgestito-woocommerce/wordpress-woocommerce-hyper-gestiti/lista-plugin-blacklist-gestiti',
			'en' => 'https://guide.aruba.it/hosting-e-domini/hosting/hosting-wordpress-wordpressgestito-woocommerce/wordpress-woocommerce-hyper-gestiti/lista-plugin-blacklist-gestiti/',
			'es' => 'https://guide.aruba.it/hosting-e-domini/hosting/hosting-wordpress-wordpressgestito-woocommerce/wordpress-woocommerce-hyper-gestiti/lista-plugin-blacklist-gestiti/',
		),
	);

	function aruba_wpmanaged_after_core_auto_updates_settings_fields_message( $auto_update_settings ) {
		$template = "<p>
		<span>%s</span></br>
		<span>%s</span>
		<ul style='list-style-type: circle;padding:0 0 0 2.5rem;'>%s</ul>
		<span>%s</span>
		</p>";

		switch ( get_locale() ) {
			case 'it_IT':
				$heading    = 'Il tuo servizio gestito include gi&agrave; gli aggiornamenti automatici. ';
				$subheading = 'Aruba si occupa per te di: ';
				$list       = "<li>Aggiornare core, temi e plugin WordPress;</li><li>Verificare l'esito delle operazioni di aggiornamento;</li><li>Ripristinare il backup salvato automaticamente subito prima dell'aggiornamento in caso di anomalie. </li>";
				$footer     = 'Per questo motivo sono stati disabilitati gli aggiornamenti nativi di WordPress.';
				break;

			case 'es_ES':
				$heading    = 'Tu servicio gestionado ya incluye las actualizaciones autom&aacute;ticas. ';
				$subheading = 'Aruba se ocupa de: ';
				$list       = '<li>Actualizar core, temas y plugins de WordPress;</li><li>Verificar el resultado de las operaciones de actualizaci&oacute;n;</li><li>Restaurar, en caso de anomal&iacute;as, la &uacute;ltima copia de seguridad guardada autom&aacute;ticamente antes de la actualizaci&oacute;n.</li>';
				$footer     = 'Por este motivo, se han deshabilitado las actualizaciones nativas de WordPress.';
				break;

			default:
				$heading    = 'Your managed service already includes automatic updates. ';
				$subheading = 'Aruba takes care of:';
				$list       = '<li>WordPress core, theme and plugin updates;</li><li>Checking that updates have run successfully;</li><li>Restoring the last saved automatic backup, in case of any problems following an update.</li>';
				$footer     = 'Native WordPress updates have therefore been disabled.';
				break;
		}
		?>
		<div class="notice notice-success inline">
			<?php echo wp_kses_post( sprintf( $template, $heading, $subheading, $list, $footer ) ); ?>
		</div>
		<?php
	}
	add_action( 'after_core_auto_updates_settings', 'aruba_wpmanaged_after_core_auto_updates_settings_fields_message', 10, 1 );

	/* =========================================================
	 * CONFIG
	 * ========================================================= */
	const ARUBA_BLACKLIST_CACHE_KEY = 'aruba_blacklist_v2';
	const ARUBA_PLUGIN_CACHE_KEY    = 'aruba_plugins_v2';

	/* =========================================================
	 * CORE SETTINGS
	 * ========================================================= */
	function aruba_wpmanaged_define_constants() {
		if ( ! defined( 'AUTOMATIC_UPDATER_DISABLED' ) ) {
			define( 'AUTOMATIC_UPDATER_DISABLED', true );
		}

		add_filter( 'automatic_updater_disabled', '__return_true', 1 );

		if ( ! defined( 'FS_METHOD' ) ) {
			define( 'FS_METHOD', 'direct' );
		}
	}
	aruba_wpmanaged_define_constants();

	/* =========================================================
	 * CACHE HELPERS (OBJECT CACHE FIRST)
	 * ========================================================= */
	function aruba_cache_get( $key ) {
		$data = wp_cache_get( $key, 'aruba' );
		if ( false !== $data ) {
			return $data;
		}

		return get_transient( $key );
	}

	function aruba_cache_set( $key, $value, $ttl ) {
		wp_cache_set( $key, $value, 'aruba', $ttl );
		set_transient( $key, $value, $ttl );
	}

	function aruba_cache_delete( $key ) {
		wp_cache_delete( $key, 'aruba' );
		delete_transient( $key );
	}

	/* =========================================================
	 * BLACKLIST FETCH (CACHED)
	 * ========================================================= */
	function aruba_wpmanaged_get_plugin_blacklist_endpoint() {
		return 'https://admin.aruba.it/PannelloAdmin/json/wp-plugin-blacklist.aspx';
	}

	function aruba_wpmanaged_prepare_plugin_blacklist( $data ) {
		$blacklist = array();

		if ( ! is_array( $data ) ) {
			return $blacklist;
		}

		foreach ( $data as $item ) {
			if ( ! is_array( $item ) ) {
				continue;
			}

			$title = isset( $item['Title'] ) ? sanitize_text_field( wp_unslash( $item['Title'] ) ) : '';
			$url   = isset( $item['Url'] ) ? esc_url_raw( wp_unslash( $item['Url'] ) ) : '';
			$slug  = isset( $item['Slug'] ) ? sanitize_title( wp_unslash( $item['Slug'] ) ) : '';

			if ( '' === $title && '' === $url && '' === $slug ) {
				continue;
			}

			$blacklist[] = array(
				'Title' => $title,
				'Url'   => $url,
				'Slug'  => $slug,
			);
		}

		return $blacklist;
	}

	function aruba_get_blacklist() {
		$cache = aruba_cache_get( ARUBA_BLACKLIST_CACHE_KEY );
		if ( is_array( $cache ) ) {
			return $cache;
		}

		$response = wp_remote_get(
			aruba_wpmanaged_get_plugin_blacklist_endpoint(),
			array(
				'timeout'     => 10,
				'redirection' => 3,
				'headers'     => array(
					'Accept' => 'application/json',
				),
			)
		);

		if ( is_wp_error( $response ) ) {
			aruba_cache_set( ARUBA_BLACKLIST_CACHE_KEY, array(), 15 * MINUTE_IN_SECONDS );
			return array();
		}

		if ( 200 !== (int) wp_remote_retrieve_response_code( $response ) ) {
			aruba_cache_set( ARUBA_BLACKLIST_CACHE_KEY, array(), 15 * MINUTE_IN_SECONDS );
			return array();
		}

		$body = wp_remote_retrieve_body( $response );

		if ( '' === $body ) {
			aruba_cache_set( ARUBA_BLACKLIST_CACHE_KEY, array(), 15 * MINUTE_IN_SECONDS );
			return array();
		}

		$data = json_decode( $body, true );

		if ( JSON_ERROR_NONE !== json_last_error() ) {
			aruba_cache_set( ARUBA_BLACKLIST_CACHE_KEY, array(), 15 * MINUTE_IN_SECONDS );
			return array();
		}

		$blacklist = aruba_wpmanaged_prepare_plugin_blacklist( $data );

		aruba_cache_set( ARUBA_BLACKLIST_CACHE_KEY, $blacklist, 12 * HOUR_IN_SECONDS );
		aruba_cache_delete( ARUBA_PLUGIN_CACHE_KEY );

		return $blacklist;
	}

	/* =========================================================
	 * NORMALIZERS (FAST)
	 * ========================================================= */
	function aruba_norm_url( $url ) {
		if ( empty( $url ) || ! is_string( $url ) ) {
			return '';
		}

		$url = trim( wp_strip_all_tags( $url ) );

		if ( '' === $url ) {
			return '';
		}

		$parsed = wp_parse_url( $url );

		if ( empty( $parsed['host'] ) ) {
			return untrailingslashit( strtolower( $url ) );
		}

		$host = strtolower( $parsed['host'] );
		$path = isset( $parsed['path'] ) ? untrailingslashit( strtolower( $parsed['path'] ) ) : '';

		if ( false !== strpos( $host, 'wordpress.org' ) ) {
			return $path;
		}

		return untrailingslashit( strtolower( $url ) );
	}

	function aruba_norm_title( $title ) {
		if ( empty( $title ) || ! is_string( $title ) ) {
			return '';
		}

		$title = wp_strip_all_tags( $title );
		$title = html_entity_decode( $title, ENT_QUOTES, 'UTF-8' );
		$title = remove_accents( $title );
		$title = strtolower( trim( $title ) );
		$title = preg_replace( '/[^a-z0-9]+/i', '', $title );

		return (string) $title;
	}

	function aruba_get_slug( $file ) {
		$slug = dirname( $file );
		if ( '.' === $slug || '' === $slug ) {
			$slug = basename( $file, '.php' );
		}

		return sanitize_title( $slug );
	}

	/* =========================================================
	 * MAIN MATCH ENGINE (O(N + M))
	 * ========================================================= */
	function aruba_get_blacklisted_plugins() {
		$cached = aruba_cache_get( ARUBA_PLUGIN_CACHE_KEY );
		if ( is_array( $cached ) ) {
			return $cached;
		}

		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$plugins   = get_plugins();
		$blacklist = aruba_get_blacklist();

		if ( empty( $plugins ) || empty( $blacklist ) ) {
			aruba_cache_set( ARUBA_PLUGIN_CACHE_KEY, array(), 12 * HOUR_IN_SECONDS );
			return array();
		}

		$indexed_urls   = array();
		$indexed_titles = array();
		$indexed_slugs  = array();

		foreach ( $blacklist as $item ) {
			if ( ! empty( $item['Url'] ) ) {
				$indexed_urls[ aruba_norm_url( $item['Url'] ) ] = $item;
			}

			if ( ! empty( $item['Title'] ) ) {
				$indexed_titles[ aruba_norm_title( $item['Title'] ) ] = $item;
			}

			if ( ! empty( $item['Slug'] ) ) {
				$indexed_slugs[ sanitize_title( $item['Slug'] ) ] = $item;
			}
		}

		$out = array();

		foreach ( $plugins as $file => $data ) {
			$url   = ! empty( $data['PluginURI'] ) ? aruba_norm_url( $data['PluginURI'] ) : '';
			$title = ! empty( $data['Name'] ) ? aruba_norm_title( $data['Name'] ) : '';
			$slug  = aruba_get_slug( $file );

			$match = null;

			if ( '' !== $url && isset( $indexed_urls[ $url ] ) ) {
				$match = $indexed_urls[ $url ];
			} elseif ( '' !== $title && isset( $indexed_titles[ $title ] ) ) {
				$match = $indexed_titles[ $title ];
			} elseif ( '' !== $slug && isset( $indexed_slugs[ $slug ] ) ) {
				$match = $indexed_slugs[ $slug ];
			}

			if ( null === $match ) {
				continue;
			}

			$key = ! empty( $match['Slug'] ) ? $match['Slug'] : md5( wp_json_encode( $match ) );

			$out[ $key ] = array(
				'title' => ! empty( $data['Title'] ) ? wp_strip_all_tags( $data['Title'] ) : ( ! empty( $data['Name'] ) ? wp_strip_all_tags( $data['Name'] ) : $file ),
				'file'  => $file,
			);
		}

		$out = array_values( $out );

		aruba_cache_set( ARUBA_PLUGIN_CACHE_KEY, $out, WEEK_IN_SECONDS );

		return $out;
	}

	/* =========================================================
	 * CACHE INVALIDATION (CRITICAL)
	 * ========================================================= */
	function aruba_clear_all_cache() {
		aruba_cache_delete( ARUBA_PLUGIN_CACHE_KEY );
		aruba_cache_delete( ARUBA_BLACKLIST_CACHE_KEY );
	}

	add_action( 'activated_plugin', 'aruba_clear_all_cache' );
	add_action( 'deactivated_plugin', 'aruba_clear_all_cache' );
	add_action( 'deleted_plugin', 'aruba_clear_all_cache' );
	add_action(
		'upgrader_process_complete',
		function ( $u, $opt ) {
			if ( ! empty( $opt['type'] ) && 'plugin' === $opt['type'] ) {
				aruba_clear_all_cache();
			}
		},
		10,
		2
	);

	/* =========================================================
	 * ADMIN NOTICE
	 * ========================================================= */
	function aruba_notice() {
		global $pagenow;

		if ( ! is_admin() || ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		if ( 'plugins.php' === $pagenow ) {
			return;
		}

		$list = aruba_get_blacklisted_plugins();
		if ( empty( $list ) ) {
			return;
		}

		echo '<div class="notice notice-warning"><p>';
		echo esc_html( isset( AWPC_LOCALIZE['general_message'][ AWPC_LOCALE ] ) ? AWPC_LOCALIZE['general_message'][ AWPC_LOCALE ] : AWPC_LOCALIZE['general_message']['en'] );
		echo '&nbsp;<a href="' . esc_url( admin_url( 'plugins.php' ) ) . '">' . esc_html( isset( AWPC_LOCALIZE['manage_plugins'][ AWPC_LOCALE ] ) ? AWPC_LOCALIZE['manage_plugins'][ AWPC_LOCALE ] : AWPC_LOCALIZE['manage_plugins']['en'] ) . '.</a>';
		echo '</p></div>';
	}
	add_action( 'admin_notices', 'aruba_notice' );

	/* =========================================================
	 * PLUGIN PAGE NOTICE
	 * ========================================================= */
	function aruba_notice_plugins_page() {
		global $pagenow;

		if ( 'plugins.php' !== $pagenow ) {
			return;
		}

		$list = aruba_get_blacklisted_plugins();
		if ( empty( $list ) ) {
			return;
		}

		echo '<div class="notice notice-warning"><p>';
		echo esc_html( isset( AWPC_LOCALIZE['plugins_message'][ AWPC_LOCALE ] ) ? AWPC_LOCALIZE['plugins_message'][ AWPC_LOCALE ] : AWPC_LOCALIZE['plugins_message']['en'] );
		echo '&nbsp;<a href="' . esc_url( isset( AWPC_LOCALIZE['link_base'][ AWPC_LOCALE ] ) ? AWPC_LOCALIZE['link_base'][ AWPC_LOCALE ] : AWPC_LOCALIZE['link_base']['en'] ) . '" target="_blank" rel="noopener noreferrer">' . esc_html( isset( AWPC_LOCALIZE['consult_the_blacklist'][ AWPC_LOCALE ] ) ? AWPC_LOCALIZE['consult_the_blacklist'][ AWPC_LOCALE ] : AWPC_LOCALIZE['consult_the_blacklist']['en'] ) . '.</a>';
		echo '</p><ul>';

		foreach ( $list as $plugin ) {
			echo '<li>' . esc_html( $plugin['title'] ) . '</li>';
		}

		echo '</ul></div>';
	}
	add_action( 'admin_notices', 'aruba_notice_plugins_page' );
}
