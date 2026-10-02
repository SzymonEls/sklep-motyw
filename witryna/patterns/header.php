<?php
/**
 * Title: Header with announcement bar
 * Slug: witryna/header
 * Categories: header
 * Block Types: core/template-part/header
 * Description: Announcement bar, logo, main menu, product search, customer account and mini cart.
 *
 * @package Witryna
 */

?>
<!-- wp:group {"className":"witryna-topbar is-style-section-dark","style":{"spacing":{"padding":{"top":"0.55rem","bottom":"0.55rem"}}},"fontSize":"x-small","layout":{"type":"constrained"}} -->
<div class="wp-block-group witryna-topbar is-style-section-dark has-x-small-font-size" style="padding-top:0.55rem;padding-bottom:0.55rem"><!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|50"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"}} -->
<div class="wp-block-group alignwide"><!-- wp:paragraph -->
<p><?php echo esc_html( sprintf( /* translators: %s: order value, e.g. 199 zł. */ __( 'Free delivery on orders over %s', 'witryna' ), witryna_price_label( 199 ) ) ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"metadata":{"blockVisibility":{"viewport":{"mobile":false}}}} -->
<p><?php esc_html_e( '30-day free returns', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"metadata":{"blockVisibility":{"viewport":{"mobile":false,"tablet":false}}}} -->
<p><?php esc_html_e( 'Secure online payments', 'witryna' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"witryna-header","style":{"spacing":{"padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group witryna-header" style="padding-top:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20)"><!-- wp:group {"align":"wide","className":"witryna-header__inner","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group alignwide witryna-header__inner"><!-- wp:group {"className":"witryna-header__brand","style":{"spacing":{"blockGap":"0.625rem"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group witryna-header__brand"><!-- wp:site-logo {"width":40,"shouldSyncIcon":false} /-->

<!-- wp:site-title {"level":0} /--></div>
<!-- /wp:group -->

<!-- wp:navigation {"overlay":"mobile-menu","icon":"menu","className":"witryna-header__nav is-style-underline","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","justifyContent":"center"}} /-->

<!-- wp:group {"className":"witryna-header__actions","style":{"spacing":{"blockGap":"0.25rem"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"right"}} -->
<div class="wp-block-group witryna-header__actions"><!-- wp:search {"label":"<?php echo esc_attr_x( 'Search products', 'search label', 'witryna' ); ?>","showLabel":false,"placeholder":"<?php echo esc_attr__( 'Search products…', 'witryna' ); ?>","buttonText":"<?php echo esc_attr_x( 'Search', 'search button', 'witryna' ); ?>","buttonPosition":"button-only","buttonUseIcon":true,"query":{"post_type":"product"},"className":"witryna-header__search"} /-->

<!-- wp:woocommerce/customer-account {"displayStyle":"icon_only","iconStyle":"line","iconClass":"wc-block-customer-account__account-icon"} /-->

<!-- wp:woocommerce/mini-cart {"miniCartIcon":"bag","addToCartBehaviour":"open_drawer"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
