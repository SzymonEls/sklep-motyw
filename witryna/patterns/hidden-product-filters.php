<?php
/**
 * Title: Product filters
 * Slug: witryna/hidden-product-filters
 * Inserter: no
 * Description: Category, price, attribute, rating and stock filters. On small screens they open in a drawer.
 *
 * @package Witryna
 */

$witryna_attribute = null;
if ( function_exists( 'wc_get_attribute_taxonomies' ) ) {
	$witryna_attributes = wc_get_attribute_taxonomies();
	$witryna_attribute  = $witryna_attributes ? reset( $witryna_attributes ) : null;
}
?>
<!-- wp:woocommerce/product-filters {"className":"witryna-filters"} -->
<div class="wp-block-woocommerce-product-filters wc-block-product-filters witryna-filters"><!-- wp:heading {"className":"witryna-filters__title","fontSize":"large"} -->
<h2 class="wp-block-heading witryna-filters__title has-large-font-size"><?php esc_html_e( 'Filters', 'witryna' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:woocommerce/product-filter-active -->
<div class="wp-block-woocommerce-product-filter-active"><!-- wp:woocommerce/product-filter-removable-chips -->
<div class="wp-block-woocommerce-product-filter-removable-chips wc-block-product-filter-removable-chips"></div>
<!-- /wp:woocommerce/product-filter-removable-chips -->

<!-- wp:woocommerce/product-filter-clear-button -->
<!-- wp:buttons {"layout":{"type":"flex","verticalAlignment":"stretched"}} -->
<div class="wp-block-buttons"><!-- wp:button {"className":"wc-block-product-filter-clear-button is-style-outline","fontSize":"x-small"} -->
<div class="wp-block-button wc-block-product-filter-clear-button is-style-outline"><a class="wp-block-button__link has-x-small-font-size has-custom-font-size wp-element-button"><?php esc_html_e( 'Clear filters', 'witryna' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->
<!-- /wp:woocommerce/product-filter-clear-button --></div>
<!-- /wp:woocommerce/product-filter-active -->

<!-- wp:woocommerce/product-filter-taxonomy {"showCounts":true} -->
<div class="wp-block-woocommerce-product-filter-taxonomy"><!-- wp:heading {"level":3,"className":"witryna-filter-title","fontSize":"small"} -->
<h3 class="wp-block-heading witryna-filter-title has-small-font-size"><?php esc_html_e( 'Category', 'witryna' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:woocommerce/product-filter-checkbox-list -->
<div class="wp-block-woocommerce-product-filter-checkbox-list wc-block-product-filter-checkbox-list"></div>
<!-- /wp:woocommerce/product-filter-checkbox-list --></div>
<!-- /wp:woocommerce/product-filter-taxonomy -->

<!-- wp:woocommerce/product-filter-price -->
<div class="wp-block-woocommerce-product-filter-price"><!-- wp:heading {"level":3,"className":"witryna-filter-title","fontSize":"small"} -->
<h3 class="wp-block-heading witryna-filter-title has-small-font-size"><?php esc_html_e( 'Price', 'witryna' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:woocommerce/product-filter-price-slider -->
<div class="wp-block-woocommerce-product-filter-price-slider wc-block-product-filter-price-slider"></div>
<!-- /wp:woocommerce/product-filter-price-slider --></div>
<!-- /wp:woocommerce/product-filter-price -->
<?php if ( $witryna_attribute ) : ?>

<!-- wp:woocommerce/product-filter-attribute {"attributeId":<?php echo (int) $witryna_attribute->attribute_id; ?>,"showCounts":true,"displayStyle":"woocommerce/product-filter-chips"} -->
<div class="wp-block-woocommerce-product-filter-attribute"><!-- wp:heading {"level":3,"className":"witryna-filter-title","fontSize":"small"} -->
<h3 class="wp-block-heading witryna-filter-title has-small-font-size"><?php echo esc_html( $witryna_attribute->attribute_label ); ?></h3>
<!-- /wp:heading -->

<!-- wp:woocommerce/product-filter-chips -->
<div class="wp-block-woocommerce-product-filter-chips wc-block-product-filter-chips"></div>
<!-- /wp:woocommerce/product-filter-chips --></div>
<!-- /wp:woocommerce/product-filter-attribute -->
<?php endif; ?>

<!-- wp:woocommerce/product-filter-rating -->
<div class="wp-block-woocommerce-product-filter-rating"><!-- wp:heading {"level":3,"className":"witryna-filter-title","fontSize":"small"} -->
<h3 class="wp-block-heading witryna-filter-title has-small-font-size"><?php esc_html_e( 'Rating', 'witryna' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:woocommerce/product-filter-checkbox-list -->
<div class="wp-block-woocommerce-product-filter-checkbox-list wc-block-product-filter-checkbox-list"></div>
<!-- /wp:woocommerce/product-filter-checkbox-list --></div>
<!-- /wp:woocommerce/product-filter-rating -->

<!-- wp:woocommerce/product-filter-status -->
<div class="wp-block-woocommerce-product-filter-status"><!-- wp:heading {"level":3,"className":"witryna-filter-title","fontSize":"small"} -->
<h3 class="wp-block-heading witryna-filter-title has-small-font-size"><?php esc_html_e( 'Availability', 'witryna' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:woocommerce/product-filter-checkbox-list -->
<div class="wp-block-woocommerce-product-filter-checkbox-list wc-block-product-filter-checkbox-list"></div>
<!-- /wp:woocommerce/product-filter-checkbox-list --></div>
<!-- /wp:woocommerce/product-filter-status --></div>
<!-- /wp:woocommerce/product-filters -->
