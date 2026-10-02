<?php
/**
 * Title: Promotion banner
 * Slug: witryna/promo-split
 * Categories: banner, call-to-action, witryna-shop
 * Keywords: sale, promotion, discount, offer, campaign
 * Viewport Width: 1400
 * Description: Seasonal campaign with a large image and a call to action on a soft accent card.
 *
 * @package Witryna
 */

?>
<!-- wp:group {"align":"full","className":"witryna-promo","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull witryna-promo" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50)"><!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|30","left":"var:preset|spacing|30"}}}} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"width":"58%"} -->
<div class="wp-block-column" style="flex-basis:58%"><!-- wp:image {"aspectRatio":"5/4","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"is-style-zoom","style":{"border":{"radius":"var:preset|border-radius|x-large"}}} -->
<figure class="wp-block-image size-full has-custom-border is-style-zoom"><img src="<?php echo witryna_image( 'promo.jpg' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>" alt="<?php echo esc_attr__( 'Seasonal tableware arranged on a linen cloth', 'witryna' ); ?>" style="border-radius:var(--wp--preset--border-radius--x-large);aspect-ratio:5/4;object-fit:cover"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"stretch","width":"42%"} -->
<div class="wp-block-column is-vertically-aligned-stretch" style="flex-basis:42%"><!-- wp:group {"className":"witryna-promo__card","style":{"dimensions":{"minHeight":"100%"},"spacing":{"padding":{"top":"var:preset|spacing|50","right":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50"},"blockGap":"var:preset|spacing|30"},"border":{"radius":"var:preset|border-radius|x-large"}},"backgroundColor":"accent","textColor":"base","layout":{"type":"flex","orientation":"vertical","justifyContent":"left","verticalAlignment":"space-between"}} -->
<div class="wp-block-group witryna-promo__card has-base-color has-accent-background-color has-text-color has-background" style="border-radius:var(--wp--preset--border-radius--x-large);min-height:100%;padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"is-style-eyebrow"} -->
<p class="is-style-eyebrow"><?php esc_html_e( 'End of season', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"fontSize":"xxx-large"} -->
<h2 class="wp-block-heading has-xxx-large-font-size"><?php esc_html_e( 'Up to 30% off selected favourites', 'witryna' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"fontSize":"large"} -->
<p class="has-large-font-size"><?php esc_html_e( 'Refresh your home for the colder months. Discounts apply automatically in the cart.', 'witryna' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group"><!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"base","textColor":"contrast"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-contrast-color has-base-background-color has-text-color has-background wp-element-button" href="<?php echo witryna_store_url( 'shop', home_url( '/' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>"><?php esc_html_e( 'Shop the sale', 'witryna' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:paragraph {"className":"witryna-soft","fontSize":"x-small"} -->
<p class="witryna-soft has-x-small-font-size"><?php esc_html_e( 'Offer valid while stocks last. Prices include VAT.', 'witryna' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
