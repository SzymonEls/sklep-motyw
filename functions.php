<?php
/**
 * Witryna functions and definitions.
 *
 * @package Witryna
 */

defined( 'ABSPATH' ) || exit;

define( 'WITRYNA_VERSION', '1.2.1' );

require_once get_template_directory() . '/inc/setup.php';
require_once get_template_directory() . '/inc/block-styles.php';
require_once get_template_directory() . '/inc/icons.php';
require_once get_template_directory() . '/inc/patterns.php';
require_once get_template_directory() . '/inc/klinika.php';

if ( class_exists( 'WooCommerce' ) ) {
	require_once get_template_directory() . '/inc/woocommerce.php';
}
