<?php
/**
 * Title: Reviews page
 * Slug: witryna/page-reviews
 * Categories: witryna-pages
 * Keywords: reviews, opinions, testimonials, google
 * Block Types: core/post-content
 * Post Types: page, wp_template
 * Viewport Width: 1400
 * Description: Reviews page: Google reviews (shown by Google), the newest shop reviews with any rating and information on how reviews are verified.
 *
 * @package Witryna
 */

$witryna_google = witryna_google_review_url();
?>
<!-- wp:group {"align":"full","className":"is-style-section-dark","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-section-dark" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)"><!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained","contentSize":"760px","justifyContent":"left"}} -->
<div class="wp-block-group alignwide"><!-- wp:paragraph {"className":"is-style-eyebrow witryna-hero__eyebrow"} -->
<p class="is-style-eyebrow witryna-hero__eyebrow"><?php esc_html_e( 'Opinie klientów', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"fontSize":"display"} -->
<h1 class="wp-block-heading has-display-font-size"><?php esc_html_e( 'Co mówią o nas klienci', 'witryna' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"witryna-soft","fontSize":"large"} -->
<p class="witryna-soft has-large-font-size"><?php esc_html_e( 'Tu znajdziesz opinie o Klinice Trawnika z Google i z naszego sklepu internetowego. Kupiłeś u nas sprzęt albo oddałeś go do serwisu? Daj znać, jak było.', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<?php if ( $witryna_google ) : ?>
<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $witryna_google ); ?>" target="_blank" rel="noreferrer noopener"><?php esc_html_e( 'Wystaw opinię w Google', 'witryna' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->
<?php endif; ?></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)"><!-- wp:witryna/reviews {"variant":"page","shopCount":20,"align":"wide"} /--></div>
<!-- /wp:group -->
