<?php
/**
 * Title: Visit the store
 * Slug: witryna/store-visit
 * Categories: call-to-action, witryna-shop
 * Keywords: contact, address, hours, phone, map, visit
 * Viewport Width: 1400
 * Description: Store address with a map link, opening hours and phone number in three cards.
 *
 * @package Witryna
 */

$witryna_info = witryna_store_info();
?>
<!-- wp:group {"align":"full","className":"witryna-visit","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"},"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull witryna-visit" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)"><!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group alignwide"><!-- wp:paragraph {"className":"is-style-eyebrow"} -->
<p class="is-style-eyebrow"><?php esc_html_e( 'Zapraszamy', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'Odwiedź nas w Czernicy', 'witryna' ); ?></h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"grid","columnCount":3,"minimumColumnWidth":"16rem"}} -->
<div class="wp-block-group alignwide"><!-- wp:group {"className":"is-style-card","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group is-style-card"><!-- wp:icon {"icon":"witryna/pin","className":"witryna-usp__icon","style":{"dimensions":{"width":"28px"}}} /-->

<!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size"><?php esc_html_e( 'Adres', 'witryna' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php echo esc_html( $witryna_info['street'] ); ?><br><?php echo esc_html( $witryna_info['city'] ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-arrow"} -->
<div class="wp-block-button is-style-arrow"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( witryna_store_map_url() ); ?>" target="_blank" rel="noreferrer noopener"><?php esc_html_e( 'Wyznacz trasę', 'witryna' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"is-style-card","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group is-style-card"><!-- wp:icon {"icon":"witryna/clock","className":"witryna-usp__icon","style":{"dimensions":{"width":"28px"}}} /-->

<!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size"><?php esc_html_e( 'Godziny otwarcia', 'witryna' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:list {"className":"witryna-hours is-style-plain"} -->
<ul class="wp-block-list witryna-hours is-style-plain">
<?php foreach ( $witryna_info['hours'] as $witryna_row ) : ?>
<!-- wp:list-item -->
<li><span><?php echo esc_html( $witryna_row[0] ); ?></span> <strong><?php echo esc_html( $witryna_row[1] ); ?></strong></li>
<!-- /wp:list-item -->
<?php endforeach; ?>
</ul>
<!-- /wp:list --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"is-style-card","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group is-style-card"><!-- wp:icon {"icon":"witryna/phone","className":"witryna-usp__icon","style":{"dimensions":{"width":"28px"}}} /-->

<!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size"><?php esc_html_e( 'Telefon i e-mail', 'witryna' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><a href="tel:<?php echo esc_attr( $witryna_info['phone_href'] ); ?>"><?php echo esc_html( $witryna_info['phone'] ); ?></a><br><a href="mailto:<?php echo esc_attr( antispambot( $witryna_info['email'] ) ); ?>"><?php echo esc_html( antispambot( $witryna_info['email'] ) ); ?></a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"textColor":"muted","fontSize":"small"} -->
<p class="has-muted-color has-text-color has-small-font-size"><?php esc_html_e( 'W godzinach otwarcia najszybciej złapiesz nas telefonicznie.', 'witryna' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
