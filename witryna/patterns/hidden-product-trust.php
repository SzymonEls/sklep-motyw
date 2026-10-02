<?php
/**
 * Title: Product trust badges
 * Slug: witryna/hidden-product-trust
 * Inserter: no
 * Description: Delivery, returns and payment reassurance shown next to the add to cart button.
 *
 * @package Witryna
 */

?>
<!-- wp:group {"className":"witryna-trust","style":{"spacing":{"blockGap":"0.85rem","padding":{"top":"var:preset|spacing|30","right":"var:preset|spacing|30","bottom":"var:preset|spacing|30","left":"var:preset|spacing|30"}},"border":{"radius":"var:preset|border-radius|large"}},"backgroundColor":"surface","fontSize":"small","layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group witryna-trust has-surface-background-color has-background has-small-font-size" style="border-radius:var(--wp--preset--border-radius--large);padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30)"><!-- wp:group {"style":{"spacing":{"blockGap":"0.75rem"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:icon {"icon":"witryna/truck","style":{"dimensions":{"width":"22px"}}} /-->

<!-- wp:paragraph -->
<p><?php echo wp_kses_post( sprintf( /* translators: %s: order value, e.g. 199 zł. */ __( '<strong>Free delivery</strong> on orders over %s, dispatched within 24 hours', 'witryna' ), esc_html( witryna_price_label( 199 ) ) ) ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"blockGap":"0.75rem"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:icon {"icon":"witryna/return","style":{"dimensions":{"width":"22px"}}} /-->

<!-- wp:paragraph -->
<p><?php echo wp_kses_post( __( '<strong>30 days</strong> to return or exchange, free of charge', 'witryna' ) ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"blockGap":"0.75rem"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:icon {"icon":"witryna/lock","style":{"dimensions":{"width":"22px"}}} /-->

<!-- wp:paragraph -->
<p><?php echo wp_kses_post( __( '<strong>Secure payments</strong> by card, bank transfer or mobile wallet', 'witryna' ) ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
