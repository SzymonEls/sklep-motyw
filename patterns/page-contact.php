<?php
/**
 * Title: Contact page
 * Slug: witryna/page-contact
 * Categories: witryna-pages
 * Keywords: contact, address, hours, phone, map, company details
 * Block Types: core/post-content
 * Post Types: page, wp_template
 * Viewport Width: 1400
 * Description: Contact page with address and map link, opening hours, phone and e-mail, company details and frequently asked questions.
 *
 * @package Witryna
 */

$witryna_info = witryna_store_info();
?>
<!-- wp:group {"align":"full","className":"is-style-section-dark","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"},"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-section-dark" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)"><!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained","contentSize":"760px","justifyContent":"left"}} -->
<div class="wp-block-group alignwide"><!-- wp:paragraph {"className":"is-style-eyebrow witryna-hero__eyebrow"} -->
<p class="is-style-eyebrow witryna-hero__eyebrow"><?php esc_html_e( 'Kontakt', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"fontSize":"display"} -->
<h1 class="wp-block-heading has-display-font-size"><?php esc_html_e( 'Zadzwoń, napisz albo wpadnij', 'witryna' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"witryna-soft","fontSize":"large"} -->
<p class="witryna-soft has-large-font-size"><?php esc_html_e( 'Pytanie o sprzęt, zamówienie albo serwis? Najszybciej złapiesz nas telefonicznie w godzinach otwarcia sklepu.', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="tel:<?php echo esc_attr( $witryna_info['phone_href'] ); ?>"><?php echo esc_html( sprintf( /* translators: %s: phone number. */ __( 'Zadzwoń: %s', 'witryna' ), $witryna_info['phone'] ) ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( witryna_store_map_url() ); ?>" target="_blank" rel="noreferrer noopener"><?php esc_html_e( 'Wyznacz trasę', 'witryna' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:pattern {"slug":"witryna/store-visit"} /-->

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"bottom":"var:preset|spacing|50"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-bottom:var(--wp--preset--spacing--50)"><!-- wp:witryna/map {"align":"wide"} /--></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"bottom":"var:preset|spacing|50"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-bottom:var(--wp--preset--spacing--50)"><!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","right":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40"},"blockGap":"var:preset|spacing|20"},"border":{"radius":"var:preset|border-radius|medium"}},"backgroundColor":"surface","fontSize":"small","layout":{"type":"constrained","contentSize":"760px","justifyContent":"left"}} -->
<div class="wp-block-group alignwide has-surface-background-color has-background has-small-font-size" style="border-radius:var(--wp--preset--border-radius--medium);padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)"><!-- wp:heading {"level":2,"fontSize":"medium"} -->
<h2 class="wp-block-heading has-medium-font-size"><?php esc_html_e( 'Dane firmy', 'witryna' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted"} -->
<p class="has-muted-color has-text-color"><?php echo esc_html( $witryna_info['company'] ); ?><br><?php echo esc_html( witryna_store_address() ); ?><br><?php echo esc_html( sprintf( /* translators: %s: tax ID. */ __( 'NIP: %s', 'witryna' ), $witryna_info['nip'] ) ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:pattern {"slug":"witryna/faq"} /-->
