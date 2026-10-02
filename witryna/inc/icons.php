<?php
/**
 * Icon collection for the Icon block (WordPress 7.1+).
 *
 * @package Witryna
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registers the Witryna icon collection and its icons.
 */
function witryna_register_icons() {
	if ( ! function_exists( 'wp_register_icon_collection' ) || ! function_exists( 'wp_register_icon' ) ) {
		return;
	}

	wp_register_icon_collection(
		'witryna',
		array(
			'label'       => __( 'Witryna', 'witryna' ),
			'description' => __( 'Store icons bundled with the Witryna theme.', 'witryna' ),
		)
	);

	$icons = array(
		'truck'   => _x( 'Delivery truck', 'icon label', 'witryna' ),
		'return'  => _x( 'Returns', 'icon label', 'witryna' ),
		'lock'    => _x( 'Padlock', 'icon label', 'witryna' ),
		'chat'    => _x( 'Chat', 'icon label', 'witryna' ),
		'gift'    => _x( 'Gift', 'icon label', 'witryna' ),
		'leaf'    => _x( 'Leaf', 'icon label', 'witryna' ),
		'package' => _x( 'Package', 'icon label', 'witryna' ),
		'sparkle' => _x( 'Sparkle', 'icon label', 'witryna' ),
		'heart'   => _x( 'Heart', 'icon label', 'witryna' ),
		'phone'   => _x( 'Phone', 'icon label', 'witryna' ),
	);

	foreach ( $icons as $name => $label ) {
		wp_register_icon(
			'witryna/' . $name,
			array(
				'label'     => $label,
				'file_path' => get_theme_file_path( 'assets/icons/' . $name . '.svg' ),
			)
		);
	}
}
add_action( 'init', 'witryna_register_icons' );
