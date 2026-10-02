<?php
/**
 * Title: Contact page
 * Slug: witryna/page-contact
 * Categories: witryna-pages, contact
 * Keywords: contact, address, phone, email, company details
 * Block Types: core/post-content
 * Post Types: page
 * Viewport Width: 1400
 * Description: Contact cards, opening hours, company details and frequently asked questions.
 *
 * @package Witryna
 */

$witryna_contacts = array(
	array( 'core/envelope', __( 'Email', 'witryna' ), '<a href="mailto:hello@example.com">hello@example.com</a>', __( 'We reply within one business day.', 'witryna' ) ),
	array( 'witryna/phone', __( 'Phone', 'witryna' ), '<a href="tel:+48123456789">+48 123 456 789</a>', __( 'Monday to Friday, 9:00–17:00', 'witryna' ) ),
	array( 'core/map-marker', __( 'Showroom', 'witryna' ), esc_html__( 'ul. Przykładowa 12, 00-001 Warszawa', 'witryna' ), __( 'Tuesday to Saturday, 11:00–19:00', 'witryna' ) ),
);
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|50"},"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained","contentSize":"760px"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--50)"><!-- wp:paragraph {"className":"is-style-eyebrow"} -->
<p class="is-style-eyebrow"><?php esc_html_e( 'Contact', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"fontSize":"display"} -->
<h1 class="wp-block-heading has-display-font-size"><?php esc_html_e( 'We are here to help', 'witryna' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted","fontSize":"large"} -->
<p class="has-muted-color has-text-color has-large-font-size"><?php esc_html_e( 'Questions about an order, a product or a return? Get in touch the way that suits you best.', 'witryna' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"grid","columnCount":3,"minimumColumnWidth":"16rem"}} -->
<div class="wp-block-group alignwide">
<?php foreach ( $witryna_contacts as $witryna_contact ) : ?>
<!-- wp:group {"className":"is-style-card","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group is-style-card"><!-- wp:icon {"icon":"<?php echo esc_attr( $witryna_contact[0] ); ?>","style":{"dimensions":{"width":"28px"}}} /-->

<!-- wp:heading {"level":2,"fontSize":"large"} -->
<h2 class="wp-block-heading has-large-font-size"><?php echo esc_html( $witryna_contact[1] ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php echo wp_kses_post( $witryna_contact[2] ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"textColor":"muted","fontSize":"small"} -->
<p class="has-muted-color has-text-color has-small-font-size"><?php echo esc_html( $witryna_contact[3] ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
<?php endforeach; ?>
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","right":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40"},"blockGap":"var:preset|spacing|20","margin":{"top":"var:preset|spacing|40"}},"border":{"radius":"var:preset|border-radius|large"}},"backgroundColor":"surface","fontSize":"small","layout":{"type":"constrained","contentSize":"760px","justifyContent":"left"}} -->
<div class="wp-block-group alignwide has-surface-background-color has-background has-small-font-size" style="border-radius:var(--wp--preset--border-radius--large);margin-top:var(--wp--preset--spacing--40);padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)"><!-- wp:heading {"level":2,"fontSize":"medium"} -->
<h2 class="wp-block-heading has-medium-font-size"><?php esc_html_e( 'Company details', 'witryna' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted"} -->
<p class="has-muted-color has-text-color"><?php echo wp_kses_post( __( 'Example Store Ltd.<br>ul. Przykładowa 12, 00-001 Warszawa<br>Tax ID (NIP): 000-000-00-00 · Company number (KRS): 0000000000', 'witryna' ) ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:pattern {"slug":"witryna/faq"} /-->
