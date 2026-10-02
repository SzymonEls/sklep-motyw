<?php
/**
 * WooCommerce integration.
 *
 * @package Witryna
 */

defined( 'ABSPATH' ) || exit;

/**
 * Declares WooCommerce support.
 *
 * The product gallery features are used by the classic gallery block and by
 * pages that still rely on WooCommerce shortcodes.
 */
function witryna_woocommerce_setup() {
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 600,
			'single_image_width'    => 1200,
			'product_grid'          => array(
				'default_rows'    => 4,
				'min_rows'        => 1,
				'default_columns' => 3,
				'min_columns'     => 1,
				'max_columns'     => 6,
			),
		)
	);
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'witryna_woocommerce_setup' );

/**
 * Loads the store stylesheet after WooCommerce's own block styles.
 */
function witryna_woocommerce_assets() {
	wp_enqueue_style(
		'witryna-woocommerce',
		get_theme_file_uri( 'assets/css/woocommerce.css' ),
		array( 'witryna' ),
		WITRYNA_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'witryna_woocommerce_assets', 20 );

/**
 * Returns the highest discount of a product in whole percent.
 *
 * Variable and grouped products report the largest discount of their
 * children, so the badge never understates a promotion.
 *
 * @param WC_Product $product Product.
 * @return int Discount percentage, 0 when it cannot be calculated.
 */
function witryna_get_discount_percentage( $product ) {
	$pairs = array();

	if ( $product->is_type( 'variable' ) ) {
		$prices = $product->get_variation_prices( true );
		foreach ( $prices['regular_price'] as $variation_id => $regular ) {
			$pairs[] = array( (float) $regular, (float) ( $prices['sale_price'][ $variation_id ] ?? $regular ) );
		}
	} elseif ( $product->is_type( 'grouped' ) ) {
		foreach ( $product->get_children() as $child_id ) {
			$child = wc_get_product( $child_id );
			if ( $child && $child->is_on_sale() ) {
				$pairs[] = array( (float) $child->get_regular_price(), (float) $child->get_sale_price() );
			}
		}
	} else {
		$pairs[] = array( (float) $product->get_regular_price(), (float) $product->get_sale_price() );
	}

	$max = 0;
	foreach ( $pairs as list( $regular, $sale ) ) {
		if ( $regular > 0 && $sale > 0 && $sale < $regular ) {
			$max = max( $max, (int) round( ( 1 - $sale / $regular ) * 100 ) );
		}
	}

	return $max;
}

/**
 * Shows the discount percentage on sale badges, e.g. "−20%".
 *
 * @param string     $text    Badge text.
 * @param WC_Product $product Product.
 * @return string
 */
function witryna_sale_badge_text( $text, $product ) {
	/**
	 * Filters whether sale badges should show the discount percentage.
	 *
	 * @param bool       $enabled Whether to show the percentage. Default true.
	 * @param WC_Product $product Product.
	 */
	if ( ! $product instanceof WC_Product || ! apply_filters( 'witryna_sale_badge_percentage', true, $product ) ) {
		return $text;
	}

	$discount = witryna_get_discount_percentage( $product );

	/* translators: %d: discount percentage. */
	return $discount > 0 ? sprintf( __( '−%d%%', 'witryna' ), $discount ) : $text;
}
add_filter( 'woocommerce_sale_badge_text', 'witryna_sale_badge_text', 10, 2 );

/**
 * Applies the same badge text to classic (shortcode based) templates.
 *
 * @param string     $html    Badge HTML.
 * @param WP_Post    $post    Post object.
 * @param WC_Product $product Product.
 * @return string
 */
function witryna_classic_sale_flash( $html, $post, $product ) {
	$text = witryna_sale_badge_text( '', $product );

	return '' === $text ? $html : '<span class="onsale">' . esc_html( $text ) . '</span>';
}
add_filter( 'woocommerce_sale_flash', 'witryna_classic_sale_flash', 10, 3 );

/**
 * Enhances product images inside product collections.
 *
 * - Adds the second gallery image, which fades in on hover.
 * - Adds "New" and "Sold out" badges next to the sale badge.
 *
 * The single product gallery is left untouched.
 *
 * @param string   $content  Rendered block.
 * @param array    $block    Parsed block.
 * @param WP_Block $instance Block instance.
 * @return string
 */
function witryna_product_card_image( $content, $block, $instance ) {
	if ( empty( $block['attrs']['isDescendentOfQueryLoop'] ) || ! $instance instanceof WP_Block ) {
		return $content;
	}

	$product = wc_get_product( $instance->context['postId'] ?? 0 );
	if ( ! $product ) {
		return $content;
	}

	$badges = '';
	if ( ! $product->is_in_stock() ) {
		$badges .= '<span class="witryna-badge witryna-badge--soldout">' . esc_html__( 'Sold out', 'witryna' ) . '</span>';
	} else {
		/**
		 * Filters for how many days a product is marked as new. Return 0 to hide the badge.
		 *
		 * @param int        $days    Number of days. Default 30.
		 * @param WC_Product $product Product.
		 */
		$days    = (int) apply_filters( 'witryna_new_badge_days', 30, $product );
		$created = $product->get_date_created();
		if ( $days > 0 && $created && $created->getTimestamp() > time() - $days * DAY_IN_SECONDS ) {
			$badges .= '<span class="witryna-badge witryna-badge--new">' . esc_html__( 'New', 'witryna' ) . '</span>';
		}
	}

	if ( $badges ) {
		$content = str_replace(
			'<div class="wc-block-components-product-image__inner-container">',
			'<div class="wc-block-components-product-image__inner-container">' . $badges,
			$content
		);
	}

	/**
	 * Filters whether product cards reveal the second gallery image on hover.
	 *
	 * @param bool       $enabled Whether the hover image is added. Default true.
	 * @param WC_Product $product Product.
	 */
	$gallery = apply_filters( 'witryna_product_image_hover', true, $product ) ? $product->get_gallery_image_ids() : array();
	if ( empty( $gallery ) ) {
		return $content;
	}

	$hover = wp_get_attachment_image(
		(int) $gallery[0],
		'large',
		false,
		array(
			'class'       => 'witryna-hover-image',
			'alt'         => '',
			'aria-hidden' => 'true',
			'loading'     => 'lazy',
			'decoding'    => 'async',
		)
	);

	if ( ! $hover ) {
		return $content;
	}

	$updated = preg_replace( '/(<img\b[^>]*>)/i', '$1' . $hover, $content, 1, $count );

	return $count ? $updated : $content;
}
add_filter( 'render_block_woocommerce/product-image', 'witryna_product_card_image', 10, 3 );

/**
 * Uses a lighter separator in breadcrumbs.
 *
 * @param array $defaults Breadcrumb arguments.
 * @return array
 */
function witryna_breadcrumb_defaults( $defaults ) {
	$defaults['delimiter'] = '<span class="witryna-breadcrumb-sep" aria-hidden="true">/</span>';
	return $defaults;
}
add_filter( 'woocommerce_breadcrumb_defaults', 'witryna_breadcrumb_defaults' );
