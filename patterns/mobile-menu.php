<?php
/**
 * Title: Mobile menu
 * Slug: witryna/mobile-menu
 * Categories: navigation
 * Block Types: core/template-part/navigation-overlay
 * Description: Full-screen menu with large links, product search and quick links to the account.
 *
 * @package Witryna
 */

?>
<!-- wp:group {"className":"witryna-mobile-menu","style":{"dimensions":{"minHeight":"100%"},"spacing":{"padding":{"top":"var:preset|spacing|30","right":"var:preset|spacing|40","bottom":"var:preset|spacing|50","left":"var:preset|spacing|40"},"blockGap":"var:preset|spacing|40"}},"backgroundColor":"base","textColor":"contrast","layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch","flexWrap":"nowrap"}} -->
<div class="wp-block-group witryna-mobile-menu has-contrast-color has-base-background-color has-text-color has-background" style="min-height:100%;padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--40)"><!-- wp:group {"className":"witryna-mobile-menu__top","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group witryna-mobile-menu__top"><!-- wp:site-title {"level":0} /-->

<!-- wp:navigation-overlay-close /--></div>
<!-- /wp:group -->

<!-- wp:search {"label":"<?php echo esc_attr_x( 'Search products', 'search label', 'witryna' ); ?>","showLabel":false,"placeholder":"<?php echo esc_attr__( 'Search products…', 'witryna' ); ?>","buttonText":"<?php echo esc_attr_x( 'Search', 'search button', 'witryna' ); ?>","buttonPosition":"button-inside","buttonUseIcon":true,"query":{"post_type":"product"},"className":"witryna-mobile-menu__search"} /-->

<!-- wp:navigation {"overlayMenu":"never","submenuVisibility":"always","className":"witryna-mobile-menu__nav","style":{"typography":{"fontWeight":"500","letterSpacing":"-0.03em","lineHeight":"1.15"},"spacing":{"blockGap":"0.9rem"}},"fontSize":"xx-large","fontFamily":"bricolage-grotesque","layout":{"type":"flex","orientation":"vertical"}} /-->

<!-- wp:group {"className":"witryna-mobile-menu__footer","style":{"spacing":{"blockGap":"var:preset|spacing|20","padding":{"top":"var:preset|spacing|30"}},"border":{"top":{"color":"var:preset|color|line","width":"1px"}}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group witryna-mobile-menu__footer" style="border-top-color:var(--wp--preset--color--line);border-top-width:1px;padding-top:var(--wp--preset--spacing--30)"><!-- wp:woocommerce/customer-account {"displayStyle":"icon_and_text","iconStyle":"line","iconClass":"wc-block-customer-account__account-icon","fontSize":"small"} /-->

<!-- wp:paragraph {"textColor":"muted","fontSize":"small"} -->
<p class="has-muted-color has-text-color has-small-font-size"><?php esc_html_e( 'Need help?', 'witryna' ); ?> <a href="tel:<?php echo esc_attr( witryna_store_info( 'phone_href' ) ); ?>"><?php echo esc_html( witryna_store_info( 'phone' ) ); ?></a><br><?php echo esc_html( witryna_store_info( 'hours_short' ) ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
