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
$witryna_info    = witryna_store_info();
?>
<!-- wp:group {"className":"witryna-footer is-style-section-dark","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|40"},"blockGap":"var:preset|spacing|60"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group witryna-footer is-style-section-dark" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--40)"><!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|50","left":"var:preset|spacing|50"}}}} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"width":"34%"} -->
<div class="wp-block-column" style="flex-basis:34%"><!-- wp:site-title {"level":0,"fontSize":"xx-large"} /-->

<!-- wp:paragraph {"className":"witryna-soft","style":{"typography":{"lineHeight":"1.6"}},"fontSize":"small"} -->
<p class="witryna-soft has-small-font-size" style="line-height:1.6"><?php esc_html_e( 'Autoryzowany dealer STIHL w Czernicy pod Wrocławiem. Sprzedaż, doradztwo i serwis sprzętu ogrodowego i leśnego.', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:social-links {"className":"is-style-logos-only","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|30"}}}} -->
<ul class="wp-block-social-links is-style-logos-only"><!-- wp:social-link {"url":"<?php echo esc_url( $witryna_info['tiktok'] ); ?>","service":"tiktok","label":"TikTok"} /--></ul>
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
<h2 class="wp-block-heading is-style-eyebrow has-x-small-font-size"><?php esc_html_e( 'Obsługa klienta', 'witryna' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:navigation {"overlayMenu":"never","className":"witryna-footer__menu","style":{"spacing":{"blockGap":"0.7rem"}},"fontSize":"small","layout":{"type":"flex","orientation":"vertical"}} -->
<!-- wp:navigation-link {"label":"<?php echo esc_attr__( 'Serwis', 'witryna' ); ?>","url":"<?php echo witryna_page_url( 'serwis' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>","kind":"custom"} /-->

<!-- wp:navigation-link {"label":"<?php echo esc_attr__( 'Opinie klientów', 'witryna' ); ?>","url":"<?php echo witryna_page_url( 'opinie' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>","kind":"custom"} /-->

<!-- wp:navigation-link {"label":"<?php echo esc_attr__( 'Social media', 'witryna' ); ?>","url":"<?php echo witryna_page_url( 'social-media' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>","kind":"custom"} /-->

<!-- wp:navigation-link {"label":"<?php echo esc_attr__( 'Dostawa i płatność', 'witryna' ); ?>","url":"<?php echo witryna_page_url( 'dostawa-i-platnosc' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>","kind":"custom"} /-->

<!-- wp:navigation-link {"label":"<?php echo esc_attr__( 'Zwroty i reklamacje', 'witryna' ); ?>","url":"<?php echo witryna_page_url( 'zwroty-i-reklamacje' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>","kind":"custom"} /-->

<!-- wp:navigation-link {"label":"<?php echo esc_attr__( 'Order status', 'witryna' ); ?>","url":"<?php echo $witryna_orders; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above. ?>","kind":"custom"} /-->
<!-- /wp:navigation --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":2,"className":"is-style-eyebrow","fontSize":"x-small"} -->
<h2 class="wp-block-heading is-style-eyebrow has-x-small-font-size"><?php esc_html_e( 'Contact', 'witryna' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size"><?php echo esc_html( $witryna_info['company'] ); ?><br><?php echo esc_html( witryna_store_address() ); ?><br><a href="tel:<?php echo esc_attr( $witryna_info['phone_href'] ); ?>"><?php echo esc_html( $witryna_info['phone'] ); ?></a><br><a href="mailto:<?php echo esc_attr( antispambot( $witryna_info['email'] ) ); ?>"><?php echo esc_html( antispambot( $witryna_info['email'] ) ); ?></a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"witryna-soft","fontSize":"small"} -->
<p class="witryna-soft has-small-font-size"><?php echo esc_html( $witryna_info['hours_short'] ); ?></p>
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
