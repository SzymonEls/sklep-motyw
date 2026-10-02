<?php
/**
 * Title: Footer with store menus
 * Slug: witryna/footer
 * Categories: footer
 * Block Types: core/template-part/footer
 * Description: Dark footer with brand description, social links, store menus, contact details, legal links and payment methods.
 *
 * @package Witryna
 */

$witryna_shop    = witryna_store_url( 'shop', home_url( '/' ) );
$witryna_orders  = function_exists( 'wc_get_account_endpoint_url' ) ? esc_url( wc_get_account_endpoint_url( 'orders' ) ) : '#';
$witryna_privacy = get_privacy_policy_url() ? esc_url( get_privacy_policy_url() ) : '#';
$witryna_terms   = witryna_store_url( 'terms' );
?>
<!-- wp:group {"className":"witryna-footer is-style-section-dark","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|40"},"blockGap":"var:preset|spacing|60"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group witryna-footer is-style-section-dark" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--40)"><!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|50","left":"var:preset|spacing|50"}}}} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"width":"34%"} -->
<div class="wp-block-column" style="flex-basis:34%"><!-- wp:site-title {"level":0,"fontSize":"xx-large"} /-->

<!-- wp:paragraph {"className":"witryna-soft","style":{"typography":{"lineHeight":"1.6"}},"fontSize":"small"} -->
<p class="witryna-soft has-small-font-size" style="line-height:1.6"><?php esc_html_e( 'Thoughtfully chosen products for everyday life. Designed to last, packed with care and shipped quickly to your door.', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:social-links {"className":"is-style-logos-only","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|30"}}}} -->
<ul class="wp-block-social-links is-style-logos-only"><!-- wp:social-link {"url":"https://www.instagram.com/","service":"instagram"} /-->

<!-- wp:social-link {"url":"https://www.facebook.com/","service":"facebook"} /-->

<!-- wp:social-link {"url":"https://www.tiktok.com/","service":"tiktok"} /-->

<!-- wp:social-link {"url":"https://www.pinterest.com/","service":"pinterest"} /--></ul>
<!-- /wp:social-links --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":2,"className":"is-style-eyebrow","fontSize":"x-small"} -->
<h2 class="wp-block-heading is-style-eyebrow has-x-small-font-size"><?php esc_html_e( 'Shop', 'witryna' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:navigation {"overlayMenu":"never","className":"witryna-footer__menu","style":{"spacing":{"blockGap":"0.7rem"}},"fontSize":"small","layout":{"type":"flex","orientation":"vertical"}} -->
<!-- wp:navigation-link {"label":"<?php echo esc_attr__( 'All products', 'witryna' ); ?>","url":"<?php echo $witryna_shop; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above. ?>","kind":"custom"} /-->

<!-- wp:navigation-link {"label":"<?php echo esc_attr__( 'New arrivals', 'witryna' ); ?>","url":"<?php echo esc_url( add_query_arg( 'orderby', 'date', $witryna_shop ) ); ?>","kind":"custom"} /-->

<!-- wp:navigation-link {"label":"<?php echo esc_attr__( 'Bestsellers', 'witryna' ); ?>","url":"<?php echo esc_url( add_query_arg( 'orderby', 'popularity', $witryna_shop ) ); ?>","kind":"custom"} /-->

<!-- wp:navigation-link {"label":"<?php echo esc_attr__( 'Top rated', 'witryna' ); ?>","url":"<?php echo esc_url( add_query_arg( 'orderby', 'rating', $witryna_shop ) ); ?>","kind":"custom"} /-->
<!-- /wp:navigation --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":2,"className":"is-style-eyebrow","fontSize":"x-small"} -->
<h2 class="wp-block-heading is-style-eyebrow has-x-small-font-size"><?php esc_html_e( 'Customer care', 'witryna' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:navigation {"overlayMenu":"never","className":"witryna-footer__menu","style":{"spacing":{"blockGap":"0.7rem"}},"fontSize":"small","layout":{"type":"flex","orientation":"vertical"}} -->
<!-- wp:navigation-link {"label":"<?php echo esc_attr__( 'Delivery and payment', 'witryna' ); ?>","url":"#","kind":"custom"} /-->

<!-- wp:navigation-link {"label":"<?php echo esc_attr__( 'Returns and complaints', 'witryna' ); ?>","url":"#","kind":"custom"} /-->

<!-- wp:navigation-link {"label":"<?php echo esc_attr__( 'Order status', 'witryna' ); ?>","url":"<?php echo $witryna_orders; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above. ?>","kind":"custom"} /-->

<!-- wp:navigation-link {"label":"<?php echo esc_attr__( 'Frequently asked questions', 'witryna' ); ?>","url":"#","kind":"custom"} /-->
<!-- /wp:navigation --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":2,"className":"is-style-eyebrow","fontSize":"x-small"} -->
<h2 class="wp-block-heading is-style-eyebrow has-x-small-font-size"><?php esc_html_e( 'Contact', 'witryna' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size"><a href="mailto:hello@example.com">hello@example.com</a><br><a href="tel:+48123456789">+48 123 456 789</a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"witryna-soft","fontSize":"small"} -->
<p class="witryna-soft has-small-font-size"><?php esc_html_e( 'Monday to Friday, 9:00–17:00', 'witryna' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:group {"align":"wide","className":"witryna-footer__bottom","style":{"spacing":{"padding":{"top":"var:preset|spacing|30"},"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group alignwide witryna-footer__bottom" style="padding-top:var(--wp--preset--spacing--30)"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"witryna/copyright"}}},"className":"witryna-soft","fontSize":"x-small"} -->
<p class="witryna-soft has-x-small-font-size">© <?php echo esc_html( wp_date( 'Y' ) ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"witryna-soft","fontSize":"x-small"} -->
<p class="witryna-soft has-x-small-font-size"><a href="<?php echo $witryna_terms; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above. ?>"><?php esc_html_e( 'Terms and conditions', 'witryna' ); ?></a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"witryna-soft","fontSize":"x-small"} -->
<p class="witryna-soft has-x-small-font-size"><a href="<?php echo $witryna_privacy; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above. ?>"><?php esc_html_e( 'Privacy policy', 'witryna' ); ?></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:woocommerce/payment-method-icons /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
