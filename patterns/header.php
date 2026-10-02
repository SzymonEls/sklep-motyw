<?php
/**
 * Title: Header with announcement bar
 * Slug: witryna/header
 * Categories: header
 * Block Types: core/template-part/header
 * Description: Top bar with store details (STIHL dealer, address, hours, phone, TikTok), logo, main menu, product search, customer account and mini cart.
 *
 * @package Witryna
 */

?>
<!-- wp:group {"className":"witryna-topbar is-style-section-dark","style":{"spacing":{"padding":{"top":"0.55rem","bottom":"0.55rem"}}},"fontSize":"x-small","layout":{"type":"constrained"}} -->
<div class="wp-block-group witryna-topbar is-style-section-dark has-x-small-font-size" style="padding-top:0.55rem;padding-bottom:0.55rem"><!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group alignwide"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"witryna-topbar__badge"} -->
<p class="witryna-topbar__badge"><?php esc_html_e( 'Autoryzowany dealer STIHL', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"metadata":{"blockVisibility":{"viewport":{"mobile":false}}}} -->
<p><?php echo esc_html( witryna_store_address() ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"metadata":{"blockVisibility":{"viewport":{"mobile":false,"tablet":false}}}} -->
<p><?php echo esc_html( witryna_store_info( 'hours_short' ) ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"witryna-topbar__phone"} -->
<p class="witryna-topbar__phone"><a href="tel:<?php echo esc_attr( witryna_store_info( 'phone_href' ) ); ?>"><?php echo esc_html( sprintf( /* translators: %s: phone number. */ __( 'Zadzwoń: %s', 'witryna' ), witryna_store_info( 'phone' ) ) ); ?></a></p>
<!-- /wp:paragraph -->

<!-- wp:social-links {"iconColor":"base","iconColorValue":"#FFFFFF","size":"has-small-icon-size","className":"is-style-logos-only","metadata":{"blockVisibility":{"viewport":{"mobile":false}}}} -->
<ul class="wp-block-social-links has-small-icon-size has-icon-color is-style-logos-only"><!-- wp:social-link {"url":"<?php echo esc_url( witryna_store_info( 'tiktok' ) ); ?>","service":"tiktok"} /--></ul>
<!-- /wp:social-links --></div>
<!-- /wp:group --></div>
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
