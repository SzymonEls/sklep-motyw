<?php
/**
 * Theme setup and assets.
 *
 * @package Witryna
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registers theme supports and loads translations.
 */
function witryna_setup() {
	load_theme_textdomain( 'witryna', get_template_directory() . '/languages' );

	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'html5', array( 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'search-form' ) );

	// The theme ships its own patterns, so the generic core ones are hidden.
	remove_theme_support( 'core-block-patterns' );

	add_editor_style(
		array(
			'assets/css/theme.css',
			'assets/css/woocommerce.css',
		)
	);
}
add_action( 'after_setup_theme', 'witryna_setup' );

/**
 * Enqueues front-end styles and scripts.
 */
function witryna_enqueue_assets() {
	wp_enqueue_style(
		'witryna',
		get_theme_file_uri( 'assets/css/theme.css' ),
		array(),
		WITRYNA_VERSION
	);

	wp_enqueue_script(
		'witryna',
		get_theme_file_uri( 'assets/js/theme.js' ),
		array(),
		WITRYNA_VERSION,
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);
}
add_action( 'wp_enqueue_scripts', 'witryna_enqueue_assets' );

/**
 * Preloads the primary text and heading fonts used by the active style.
 *
 * Only fonts bundled with the theme are preloaded, and only the Latin subset,
 * which every page needs. Other subsets load on demand via unicode-range.
 */
function witryna_preload_fonts() {
	$files = array(
		'inter'               => 'assets/fonts/inter/inter-latin-wght-normal.woff2',
		'bricolage-grotesque' => 'assets/fonts/bricolage-grotesque/bricolage-grotesque-latin-opsz-normal.woff2',
		'fraunces'            => 'assets/fonts/fraunces/fraunces-latin-standard-normal.woff2',
		'instrument-serif'    => 'assets/fonts/instrument-serif/instrument-serif-latin-400-normal.woff2',
	);

	$families = array(
		wp_get_global_styles( array( 'typography', 'fontFamily' ) ),
		wp_get_global_styles( array( 'elements', 'heading', 'typography', 'fontFamily' ) ),
	);

	$preload = array();
	foreach ( $families as $family ) {
		if ( ! is_string( $family ) ) {
			continue;
		}
		foreach ( $files as $slug => $file ) {
			if ( false !== strpos( $family, 'font-family--' . $slug ) ) {
				$preload[ $slug ] = $file;
			}
		}
	}

	foreach ( $preload as $file ) {
		printf(
			'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
			esc_url( get_theme_file_uri( $file ) )
		);
	}
}
add_action( 'wp_head', 'witryna_preload_fonts', 1 );

/**
 * Registers block binding sources used by the theme's patterns.
 */
function witryna_register_block_bindings() {
	register_block_bindings_source(
		'witryna/copyright',
		array(
			'label'              => __( 'Copyright notice', 'witryna' ),
			'get_value_callback' => 'witryna_copyright_binding',
		)
	);
}
add_action( 'init', 'witryna_register_block_bindings' );

/**
 * Returns the copyright line with the current year and site title.
 *
 * @return string
 */
function witryna_copyright_binding() {
	return sprintf(
		/* translators: 1: current year, 2: site title. */
		esc_html__( '© %1$s %2$s. All rights reserved.', 'witryna' ),
		esc_html( wp_date( 'Y' ) ),
		esc_html( get_bloginfo( 'name' ) )
	);
}
