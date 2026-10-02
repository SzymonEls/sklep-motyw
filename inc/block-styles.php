<?php
/**
 * Block style variations.
 *
 * Styles that cannot be expressed in theme.json are registered here; their CSS
 * lives in assets/css/theme.css. Section styles (colour schemes for groups)
 * are defined as JSON partials in styles/sections.
 *
 * @package Witryna
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registers custom block styles.
 */
function witryna_register_block_styles() {
	$styles = array(
		'core/paragraph'  => array(
			'eyebrow' => _x( 'Eyebrow', 'block style', 'witryna' ),
		),
		'core/heading'    => array(
			'eyebrow' => _x( 'Eyebrow', 'block style', 'witryna' ),
		),
		'core/list'       => array(
			'checklist' => _x( 'Checklist', 'block style', 'witryna' ),
			'plain'     => _x( 'No bullets', 'block style', 'witryna' ),
		),
		'core/group'      => array(
			'card' => _x( 'Card', 'block style', 'witryna' ),
		),
		'core/column'     => array(
			'card' => _x( 'Card', 'block style', 'witryna' ),
		),
		'core/button'     => array(
			'arrow' => _x( 'Arrow link', 'block style', 'witryna' ),
		),
		'core/image'      => array(
			'zoom' => _x( 'Zoom on hover', 'block style', 'witryna' ),
		),
		'core/cover'      => array(
			'zoom' => _x( 'Zoom on hover', 'block style', 'witryna' ),
		),
		'core/post-terms' => array(
			'pills' => _x( 'Pills', 'block style', 'witryna' ),
		),
		'core/navigation' => array(
			'underline' => _x( 'Underline on hover', 'block style', 'witryna' ),
		),
	);

	foreach ( $styles as $block => $variations ) {
		foreach ( $variations as $name => $label ) {
			register_block_style(
				$block,
				array(
					'name'  => $name,
					'label' => $label,
				)
			);
		}
	}
}
add_action( 'init', 'witryna_register_block_styles' );
