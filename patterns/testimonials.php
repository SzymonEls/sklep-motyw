<?php
/**
 * Title: Customer reviews
 * Slug: witryna/testimonials
 * Categories: testimonials, witryna-shop
 * Keywords: reviews, testimonials, opinions, google, social proof
 * Viewport Width: 1400
 * Description: Real reviews from the store's Google profile and approved product reviews from the shop (never invented ones) with buttons to read and leave a review on Google.
 *
 * @package Witryna
 */

$witryna_reviews = witryna_all_reviews( 3 );
$witryna_more    = witryna_page_url( 'opinie' );
$witryna_write   = witryna_google_review_url();
?>
<!-- wp:group {"align":"full","className":"witryna-testimonials","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"},"blockGap":"var:preset|spacing|50"}},"backgroundColor":"surface","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull witryna-testimonials has-surface-background-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained","contentSize":"640px"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"is-style-eyebrow","style":{"typography":{"textAlign":"center"}}} -->
<p class="is-style-eyebrow has-text-align-center"><?php esc_html_e( 'Opinie', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"style":{"typography":{"textAlign":"center"}}} -->
<h2 class="wp-block-heading has-text-align-center"><?php esc_html_e( 'Co mówią nasi klienci', 'witryna' ); ?></h2>
<!-- /wp:heading -->

<?php if ( empty( $witryna_reviews ) ) : ?>
<!-- wp:paragraph {"textColor":"muted","style":{"typography":{"textAlign":"center"}}} -->
<p class="has-text-align-center has-muted-color has-text-color"><?php esc_html_e( 'Kupiłeś u nas sprzęt albo oddałeś go do serwisu? Twoja opinia pomoże innym znaleźć dobry sklep i serwis w okolicy.', 'witryna' ); ?></p>
<!-- /wp:paragraph -->
<?php endif; ?></div>
<!-- /wp:group -->

<?php if ( $witryna_reviews ) : ?>
<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"grid","columnCount":3,"minimumColumnWidth":"18rem"}} -->
<div class="wp-block-group alignwide">
<?php foreach ( $witryna_reviews as $witryna_review ) : ?>
<!-- wp:group {"className":"is-style-card","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"backgroundColor":"base","layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch","verticalAlignment":"space-between"}} -->
<div class="wp-block-group is-style-card has-base-background-color has-background"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"witryna-stars","textColor":"accent"} -->
<p class="witryna-stars has-accent-color has-text-color" aria-label="<?php echo esc_attr( sprintf( /* translators: %d: rating. */ __( 'Ocena %d na 5', 'witryna' ), $witryna_review['rating'] ) ); ?>"><?php echo esc_html( witryna_stars( $witryna_review['rating'] ) ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php echo esc_html( $witryna_review['text'] ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"blockGap":"0.1rem"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"style":{"typography":{"fontWeight":"600"}},"fontSize":"small"} -->
<p class="has-small-font-size" style="font-weight:600"><?php if ( ! empty( $witryna_review['author_url'] ) ) : ?><a href="<?php echo esc_url( $witryna_review['author_url'] ); ?>" target="_blank" rel="noreferrer noopener nofollow"><?php echo esc_html( $witryna_review['author'] ); ?></a><?php else : ?><?php echo esc_html( $witryna_review['author'] ); ?><?php endif; ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"textColor":"muted","fontSize":"x-small"} -->
<p class="has-muted-color has-text-color has-x-small-font-size"><?php echo esc_html( $witryna_review['verified'] ? sprintf( /* translators: %s: product name. */ __( 'Zweryfikowany zakup · %s', 'witryna' ), $witryna_review['product'] ) : trim( $witryna_review['product'] . ' · ' . $witryna_review['date'], ' ·' ) ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<?php endforeach; ?>
</div>
<!-- /wp:group -->
<?php endif; ?>

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $witryna_more ); ?>"><?php esc_html_e( 'Zobacz wszystkie opinie', 'witryna' ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $witryna_write ? $witryna_write : witryna_page_url( 'opinie' ) ); ?>" target="_blank" rel="noreferrer noopener"><?php esc_html_e( 'Wystaw opinię', 'witryna' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->
