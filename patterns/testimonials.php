<?php
/**
 * Title: Customer reviews
 * Slug: witryna/testimonials
 * Categories: testimonials, witryna-shop
 * Keywords: reviews, testimonials, opinions, google, social proof
 * Viewport Width: 1400
 * Description: Google reviews (shown by Google) and the newest shop reviews with any rating, with a note on how reviews are verified.
 *
 * @package Witryna
 */

$witryna_write = witryna_google_review_url();
?>
<!-- wp:group {"align":"full","className":"witryna-testimonials","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"},"blockGap":"var:preset|spacing|50"}},"backgroundColor":"surface","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull witryna-testimonials has-surface-background-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained","contentSize":"640px"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"is-style-eyebrow","style":{"typography":{"textAlign":"center"}}} -->
<p class="is-style-eyebrow has-text-align-center"><?php esc_html_e( 'Opinie', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"style":{"typography":{"textAlign":"center"}}} -->
<h2 class="wp-block-heading has-text-align-center"><?php esc_html_e( 'Co mówią nasi klienci', 'witryna' ); ?></h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:witryna/reviews {"variant":"home","shopCount":3,"align":"wide"} /-->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( witryna_page_url( 'opinie' ) ); ?>"><?php esc_html_e( 'Zobacz wszystkie opinie', 'witryna' ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $witryna_write ); ?>" target="_blank" rel="noreferrer noopener"><?php esc_html_e( 'Wystaw opinię', 'witryna' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->
