<?php
/**
 * Pattern categories and helpers used inside pattern files.
 *
 * The patterns themselves live in the /patterns folder and are registered
 * automatically by WordPress.
 *
 * @package Witryna
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registers the theme's pattern categories.
 */
function witryna_register_pattern_categories() {
	register_block_pattern_category(
		'witryna-shop',
		array(
			'label'       => __( 'Shop sections', 'witryna' ),
			'description' => __( 'Product grids, categories and store benefits.', 'witryna' ),
		)
	);

	register_block_pattern_category(
		'witryna-pages',
		array(
			'label'       => __( 'Full pages', 'witryna' ),
			'description' => __( 'Complete page layouts built from Witryna patterns.', 'witryna' ),
		)
	);
}
add_action( 'init', 'witryna_register_pattern_categories' );

/**
 * Returns the URL of an image bundled with the theme.
 *
 * @param string $file File name inside assets/images.
 * @return string
 */
function witryna_image( $file ) {
	return esc_url( get_theme_file_uri( 'assets/images/' . $file ) );
}

/**
 * Formats an amount in the store currency as plain text, e.g. "199 zł".
 *
 * Falls back to the bare number when WooCommerce is not active.
 *
 * @param float $amount Amount.
 * @return string
 */
function witryna_price_label( $amount ) {
	if ( ! function_exists( 'wc_price' ) ) {
		return (string) $amount;
	}

	$price = wc_price( $amount, array( 'decimals' => 0 ) );

	return trim( html_entity_decode( wp_strip_all_tags( $price ), ENT_QUOTES, 'UTF-8' ) );
}

/**
 * Returns a URL of a WooCommerce page, or the fallback when unavailable.
 *
 * @param string $page     WooCommerce page: shop, myaccount, cart, checkout or terms.
 * @param string $fallback Fallback URL.
 * @return string
 */
function witryna_store_url( $page, $fallback = '#' ) {
	if ( function_exists( 'wc_get_page_permalink' ) ) {
		$id = wc_get_page_id( $page );
		if ( $id > 0 ) {
			return esc_url( get_permalink( $id ) );
		}
	}

	return esc_url( $fallback );
}

/**
 * Returns the most popular top-level product categories.
 *
 * @param int $number Number of categories.
 * @return WP_Term[]
 */
function witryna_featured_categories( $number = 4 ) {
	if ( ! taxonomy_exists( 'product_cat' ) ) {
		return array();
	}

	$terms = get_terms(
		array(
			'taxonomy'   => 'product_cat',
			'parent'     => 0,
			'hide_empty' => true,
			'orderby'    => 'count',
			'order'      => 'DESC',
			'number'     => $number,
			'exclude'    => array( (int) get_option( 'default_product_cat', 0 ) ),
		)
	);

	return is_wp_error( $terms ) ? array() : $terms;
}

/**
 * Returns the image of a product category: its thumbnail or, when it has
 * none (e.g. categories created by an import), the photo of one of its products.
 *
 * @param WP_Term $term Product category.
 * @return int Attachment ID or 0.
 */
function witryna_category_image_id( $term ) {
	$thumbnail = (int) get_term_meta( $term->term_id, 'thumbnail_id', true );

	if ( $thumbnail || ! function_exists( 'wc_get_products' ) ) {
		return $thumbnail;
	}

	$cached = get_transient( 'witryna_cat_image_' . $term->term_id );
	if ( false !== $cached ) {
		return (int) $cached;
	}

	$products = wc_get_products(
		array(
			'status'   => 'publish',
			'limit'    => 5,
			'category' => array( $term->slug ),
			'orderby'  => 'popularity',
			'return'   => 'objects',
		)
	);
	$image    = 0;
	foreach ( $products as $product ) {
		if ( $product->get_image_id() ) {
			$image = (int) $product->get_image_id();
			break;
		}
	}

	set_transient( 'witryna_cat_image_' . $term->term_id, $image, $image ? DAY_IN_SECONDS : HOUR_IN_SECONDS );

	return $image;
}

/**
 * Returns the product card markup shared by product collection patterns.
 *
 * Keep it in sync with the card used in templates/archive-product.html.
 *
 * @return string Block markup of a Product Template block.
 */
function witryna_product_card() {
	return '<!-- wp:woocommerce/product-template -->
<!-- wp:woocommerce/product-image {"showSaleBadge":false,"imageSizing":"thumbnail","isDescendentOfQueryLoop":true,"style":{"dimensions":{"aspectRatio":"4/5"}}} -->
<!-- wp:woocommerce/product-sale-badge {"isDescendentOfQueryLoop":true,"align":"left"} /-->
<!-- /wp:woocommerce/product-image -->

<!-- wp:post-title {"level":3,"isLink":true,"className":"witryna-card-title","fontSize":"medium","__woocommerceNamespace":"woocommerce/product-collection/product-title"} /-->

<!-- wp:woocommerce/product-price {"isDescendentOfQueryLoop":true,"fontSize":"small"} /-->

<!-- wp:woocommerce/product-button {"isDescendentOfQueryLoop":true,"className":"is-style-outline","fontSize":"x-small"} /-->
<!-- /wp:woocommerce/product-template -->';
}
