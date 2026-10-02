<?php
/**
 * Title: Product meta
 * Slug: witryna/hidden-product-meta
 * Inserter: no
 *
 * @package Witryna
 */

?>
<!-- wp:woocommerce/product-meta -->
<div class="wp-block-woocommerce-product-meta"><!-- wp:group {"className":"witryna-product-meta","style":{"spacing":{"blockGap":"0.3rem"}},"textColor":"muted","fontSize":"x-small","layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group witryna-product-meta has-muted-color has-text-color has-x-small-font-size"><!-- wp:woocommerce/product-sku /-->

<!-- wp:post-terms {"term":"product_brand","prefix":"<?php echo esc_attr__( 'Brand: ', 'witryna' ); ?>"} /-->

<!-- wp:post-terms {"term":"product_tag","prefix":"<?php echo esc_attr__( 'Tags: ', 'witryna' ); ?>"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:woocommerce/product-meta -->
