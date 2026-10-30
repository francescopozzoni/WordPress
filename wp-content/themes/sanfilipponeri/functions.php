<?php
/**
 * Funzioni del child theme San Filippo Neri Nembro.
 *
 * Lo stesso tema serve sia il sito dell'Oratorio sia quello del CineTeatro:
 * le differenze (nome nel footer, link social) si impostano dal Customizer.
 *
 * @package WordPress
 * @subpackage San_Filippo_Neri
 */

/**
 * Siti che usano il tema.
 */
function sanfilipponeri_variants() {
	return array(
		'oratorio'   => 'Oratorio',
		'cineteatro' => 'CineTeatro',
	);
}

/**
 * Sito corrente, scelto nel Customizer.
 *
 * @return string Chiave di sanfilipponeri_variants().
 */
function sanfilipponeri_variant() {
	$variant = get_theme_mod( 'sfn_variant', 'oratorio' );
	return array_key_exists( $variant, sanfilipponeri_variants() ) ? $variant : 'oratorio';
}

/**
 * Valori predefiniti delle impostazioni del Customizer per il sito corrente.
 */
function sanfilipponeri_defaults() {
	if ( 'cineteatro' === sanfilipponeri_variant() ) {
		return array(
			'sfn_footer_name'      => 'CineTeatro San Filippo Neri Nembro',
			'sfn_social_instagram' => 'https://www.instagram.com/cineteatrosanfilipponeri/',
			'sfn_social_facebook'  => 'https://www.facebook.com/cineteatronembro/',
			'sfn_social_youtube'   => 'https://www.youtube.com/channel/UCJJ_KM_1C4H1nU1xzkm9p4Q',
			'sfn_social_spreaker'  => '',
		);
	}

	return array(
		'sfn_footer_name'      => 'Oratorio San Filippo Neri Nembro',
		'sfn_social_instagram' => 'https://www.instagram.com/oratorionembro/',
		'sfn_social_facebook'  => 'https://it-it.facebook.com/oratorio.nembro',
		'sfn_social_youtube'   => 'https://www.youtube.com/channel/UCJJ_KM_1C4H1nU1xzkm9p4Q',
		'sfn_social_spreaker'  => 'https://www.spreaker.com/user/oratorionembro',
	);
}

/**
 * Restituisce un'impostazione del tema con il suo valore predefinito.
 *
 * @param string $name Nome dell'impostazione.
 * @return string
 */
function sanfilipponeri_mod( $name ) {
	$defaults = sanfilipponeri_defaults();
	return get_theme_mod( $name, $defaults[ $name ] );
}

/**
 * Link social da mostrare nel footer, nell'ordine di visualizzazione.
 * La chiave corrisponde al nome dell'icona in assets/images/.
 *
 * @return array<string, string>
 */
function sanfilipponeri_social_links() {
	$links = array();
	foreach ( array( 'instagram', 'facebook', 'youtube', 'spreaker' ) as $social ) {
		$links[ $social ] = sanfilipponeri_mod( "sfn_social_{$social}" );
	}
	return $links;
}

/**
 * Stampa il nome nel footer: la seconda lettera è il link all'easter egg.
 */
function sanfilipponeri_footer_name() {
	$name = sanfilipponeri_mod( 'sfn_footer_name' );
	if ( mb_strlen( $name ) < 2 ) {
		echo esc_html( $name );
		return;
	}
	printf(
		'%1$s<a class="easteregg-link" href="%2$s">%3$s</a>%4$s',
		esc_html( mb_substr( $name, 0, 1 ) ),
		esc_url( get_theme_file_uri( 'template-parts/easteregg/easteregg.php' ) ),
		esc_html( mb_substr( $name, 1, 1 ) ),
		esc_html( mb_substr( $name, 2 ) )
	);
}

/**
 * Supporti del tema.
 */
function sanfilipponeri_setup() {
	// L'editor usa gli stessi font, colori e larghezze del sito (compreso il CSS specifico del sito).
	add_editor_style(
		array(
			'editor-style.css',
			'assets/css/variant-' . sanfilipponeri_variant() . '.css',
		)
	);

	// Sfondo predefinito bianco invece del verde di Twenty Twenty-One.
	add_theme_support( 'custom-background', array( 'default-color' => 'ffffff' ) );
}
add_action( 'after_setup_theme', 'sanfilipponeri_setup', 20 );

/**
 * Twenty Twenty-One usa il verde 'D1E4DD' come sfondo predefinito anche nel
 * suo codice PHP (colori leggibili, modalità scura, editor): finché lo sfondo
 * non è stato scelto nel Customizer, risponde bianco.
 *
 * @param string $value Colore di sfondo (esadecimale senza #).
 * @return string
 */
function sanfilipponeri_default_background_color( $value ) {
	$mods = get_theme_mods();
	return isset( $mods['background_color'] ) ? $value : 'ffffff';
}
add_filter( 'theme_mod_background_color', 'sanfilipponeri_default_background_color' );

/**
 * Supporto alla modalità scura di Twenty Twenty-One attivo di default
 * (si può disattivare in Customizer → Colori e modalità scura).
 *
 * @param bool $value Valore dell'impostazione.
 * @return bool
 */
function sanfilipponeri_default_dark_mode( $value ) {
	$mods = get_theme_mods();
	return isset( $mods['respect_user_color_preference'] ) ? $value : true;
}
add_filter( 'theme_mod_respect_user_color_preference', 'sanfilipponeri_default_dark_mode' );

/**
 * Carica lo stile del child theme dopo quello di Twenty Twenty-One,
 * seguito dal CSS comune e da quello specifico del sito.
 */
function sanfilipponeri_scripts() {
	$version = wp_get_theme()->get( 'Version' );

	wp_enqueue_style( 'sanfilipponeri-style', get_stylesheet_uri(), array( 'twenty-twenty-one-style' ), $version );
	wp_enqueue_style( 'sanfilipponeri-custom', get_theme_file_uri( 'assets/css/custom.css' ), array( 'sanfilipponeri-style' ), $version );
	wp_enqueue_style(
		'sanfilipponeri-variant',
		get_theme_file_uri( 'assets/css/variant-' . sanfilipponeri_variant() . '.css' ),
		array( 'sanfilipponeri-custom' ),
		$version
	);
	wp_enqueue_style( 'sanfilipponeri-dark-mode', get_theme_file_uri( 'assets/css/dark-mode.css' ), array( 'sanfilipponeri-variant' ), $version );
}
add_action( 'wp_enqueue_scripts', 'sanfilipponeri_scripts', 20 );

/**
 * Registra i blocchi del tema e la categoria dei pattern.
 */
function sanfilipponeri_register_blocks() {
	register_block_type( __DIR__ . '/blocks/slider' );
	register_block_type( __DIR__ . '/blocks/slide' );

	register_block_pattern_category(
		'sanfilipponeri',
		array( 'label' => 'San Filippo Neri' )
	);
}
add_action( 'init', 'sanfilipponeri_register_blocks' );

/**
 * Versione dei blocchi del tema = data di modifica più recente dei loro file,
 * così CSS e JS aggiornati non restano mai nella cache del browser.
 *
 * @param array $metadata Metadati letti da block.json.
 * @return array
 */
function sanfilipponeri_block_version( $metadata ) {
	if ( empty( $metadata['file'] ) || 0 !== strpos( wp_normalize_path( $metadata['file'] ), wp_normalize_path( __DIR__ . '/blocks/' ) ) ) {
		return $metadata;
	}

	// Senza GLOB_BRACE, che non esiste su tutti i sistemi.
	$files = array_merge(
		(array) glob( dirname( $metadata['file'] ) . '/*.css' ),
		(array) glob( dirname( $metadata['file'] ) . '/*.js' ),
		(array) glob( dirname( $metadata['file'] ) . '/*.json' )
	);
	if ( $files ) {
		$metadata['version'] = (string) max( array_map( 'filemtime', $files ) );
	}
	return $metadata;
}
add_filter( 'block_type_metadata', 'sanfilipponeri_block_version' );

/**
 * Impostazioni del Customizer per distinguere i due siti.
 *
 * @param WP_Customize_Manager $wp_customize Istanza del Customizer.
 */
function sanfilipponeri_customize_register( $wp_customize ) {
	$defaults = sanfilipponeri_defaults();

	$wp_customize->add_section(
		'sanfilipponeri',
		array(
			'title'    => 'San Filippo Neri',
			'priority' => 30,
		)
	);

	$wp_customize->add_setting(
		'sfn_variant',
		array(
			'default'           => 'oratorio',
			'sanitize_callback' => static function ( $value ) {
				return array_key_exists( $value, sanfilipponeri_variants() ) ? $value : 'oratorio';
			},
		)
	);
	$wp_customize->add_control(
		'sfn_variant',
		array(
			'label'       => 'Sito',
			'description' => 'Sceglie gli stili specifici e i valori predefiniti di nome e social. Dopo averlo cambiato, salva e ricarica il Customizer.',
			'section'     => 'sanfilipponeri',
			'type'        => 'select',
			'choices'     => sanfilipponeri_variants(),
		)
	);

	$wp_customize->add_setting(
		'sfn_footer_name',
		array(
			'default'           => $defaults['sfn_footer_name'],
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'sfn_footer_name',
		array(
			'label'       => 'Nome nel footer',
			'description' => 'Es. "Oratorio San Filippo Neri Nembro" o "CineTeatro San Filippo Neri Nembro".',
			'section'     => 'sanfilipponeri',
			'type'        => 'text',
		)
	);

	$labels = array(
		'instagram' => 'Instagram',
		'facebook'  => 'Facebook',
		'youtube'   => 'YouTube',
		'spreaker'  => 'Spreaker',
	);
	foreach ( $labels as $social => $label ) {
		$id = "sfn_social_{$social}";
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $defaults[ $id ],
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			$id,
			array(
				'label'       => "Link {$label}",
				'description' => 'Lascia vuoto per nascondere l\'icona.',
				'section'     => 'sanfilipponeri',
				'type'        => 'url',
			)
		);
	}
}
add_action( 'customize_register', 'sanfilipponeri_customize_register' );

/**
 * Logo alternativo per la modalità scura, sotto "Identità del sito".
 *
 * @param WP_Customize_Manager $wp_customize Istanza del Customizer.
 */
function sanfilipponeri_customize_dark_logo( $wp_customize ) {
	$wp_customize->add_setting(
		'sfn_dark_logo',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'sfn_dark_logo',
			array(
				'label'       => 'Logo per la modalità scura',
				'description' => 'Versione chiara del logo, mostrata quando il sito è in modalità scura. Se manca, il logo viene mostrato tutto bianco.',
				'section'     => 'title_tagline',
				'mime_type'   => 'image',
				'priority'    => 9,
			)
		)
	);
}
add_action( 'customize_register', 'sanfilipponeri_customize_dark_logo' );

/**
 * Aggiunge al logo la versione per la modalità scura (mostrata solo via CSS).
 *
 * @param string $html Markup del logo.
 * @return string
 */
function sanfilipponeri_dark_logo( $html ) {
	$dark_logo_id = (int) get_theme_mod( 'sfn_dark_logo' );
	if ( ! $html || ! $dark_logo_id ) {
		return $html;
	}

	$dark_logo = wp_get_attachment_image(
		$dark_logo_id,
		'full',
		false,
		array(
			'class'   => 'custom-logo sfn-dark-logo',
			'alt'     => get_bloginfo( 'name', 'display' ),
			'loading' => false,
		)
	);
	if ( ! $dark_logo ) {
		return $html;
	}

	$html = str_replace( 'class="custom-logo-link"', 'class="custom-logo-link has-dark-logo"', $html );
	// Il logo è racchiuso in <a> oppure, in homepage, in <span>.
	return preg_replace( '#(</(?:a|span)>)\s*$#', $dark_logo . '$1', $html, 1 );
}
add_filter( 'get_custom_logo', 'sanfilipponeri_dark_logo' );

/**
 * Al primo cambio tema copia logo, menu e impostazioni dal tema precedente
 * (es. la vecchia copia "oratorionembro-new").
 *
 * Il CSS aggiuntivo NON viene copiato: ora fa parte del tema (assets/css/).
 *
 * @param string   $old_name  Nome del tema precedente.
 * @param WP_Theme $old_theme Tema precedente.
 */
function sanfilipponeri_migrate_from_previous_theme( $old_name, $old_theme = null ) {
	if ( ! $old_theme instanceof WP_Theme ) {
		return;
	}

	$old_stylesheet = $old_theme->get_stylesheet();
	$new_stylesheet = get_stylesheet();
	if ( $old_stylesheet === $new_stylesheet || get_option( 'sanfilipponeri_migrated' ) ) {
		return;
	}

	$old_mods = get_option( "theme_mods_{$old_stylesheet}" );
	if ( is_array( $old_mods ) ) {
		unset( $old_mods['custom_css_post_id'] );

		// switch_theme() ha già scritto alcune impostazioni (menu, sidebar): hanno la precedenza.
		$new_mods = get_option( "theme_mods_{$new_stylesheet}" );
		$new_mods = is_array( $new_mods ) ? $new_mods : array();
		update_option( "theme_mods_{$new_stylesheet}", array_merge( $old_mods, $new_mods ) );
	}

	update_option( 'sanfilipponeri_migrated', $old_stylesheet, false );
}
add_action( 'after_switch_theme', 'sanfilipponeri_migrate_from_previous_theme', 10, 2 );
