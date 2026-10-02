<?php
/**
 * Title: Newsletter call to action
 * Slug: witryna/newsletter
 * Categories: call-to-action
 * Keywords: newsletter, subscribe, discount, email, sign up
 * Viewport Width: 1400
 * Description: Dark band encouraging visitors to join the newsletter. Replace the button with the form block of your newsletter plugin.
 *
 * @package Witryna
 */

?>
<!-- wp:group {"align":"full","className":"witryna-newsletter","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull witryna-newsletter" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50)"><!-- wp:group {"align":"wide","className":"witryna-newsletter__box is-style-section-dark","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","right":"var:preset|spacing|50","bottom":"var:preset|spacing|60","left":"var:preset|spacing|50"},"blockGap":"var:preset|spacing|30"},"border":{"radius":"var:preset|border-radius|x-large"}}},"layout":{"type":"constrained","contentSize":"640px"}} -->
<div class="wp-block-group alignwide witryna-newsletter__box is-style-section-dark" style="border-radius:var(--wp--preset--border-radius--x-large);padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--50)"><!-- wp:icon {"icon":"witryna/sparkle","align":"center","className":"witryna-newsletter__icon","style":{"dimensions":{"width":"36px"}}} /-->

<!-- wp:heading {"style":{"typography":{"textAlign":"center"}},"fontSize":"xxx-large"} -->
<h2 class="wp-block-heading has-text-align-center has-xxx-large-font-size"><?php esc_html_e( 'Get 10% off your first order', 'witryna' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"witryna-soft","style":{"typography":{"textAlign":"center"}},"fontSize":"large"} -->
<p class="witryna-soft has-text-align-center has-large-font-size"><?php esc_html_e( 'Join our newsletter to hear about new collections, studio stories and offers before anyone else.', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#newsletter"><?php esc_html_e( 'Join the newsletter', 'witryna' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:paragraph {"className":"witryna-soft","style":{"typography":{"textAlign":"center"}},"fontSize":"x-small"} -->
<p class="witryna-soft has-text-align-center has-x-small-font-size"><?php esc_html_e( 'No spam. You can unsubscribe at any time.', 'witryna' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
