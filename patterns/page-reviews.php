<?php
/**
 * Title: Reviews page
 * Slug: witryna/page-reviews
 * Categories: witryna-pages
 * Keywords: reviews, opinions, testimonials, google
 * Block Types: core/post-content
 * Post Types: page, wp_template
 * Viewport Width: 1400
 * Description: Reviews page listing real reviews from Google and approved product reviews from the shop with buttons to read and leave a review on Google.
 *
 * @package Witryna
 */

$witryna_reviews = witryna_all_reviews( 17, 1 );
$witryna_place   = witryna_google_place();
$witryna_google  = witryna_google_review_url();
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
<p class="witryna-soft has-large-font-size"><?php esc_html_e( 'Pokazujemy wyłącznie prawdziwe opinie: wystawione w naszym sklepie internetowym i w Google. Kupiłeś u nas sprzęt albo oddałeś go do serwisu? Daj znać, jak było.', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<?php if ( $witryna_place && $witryna_place['count'] ) : ?>
<!-- wp:paragraph {"className":"witryna-google-rating","fontSize":"large"} -->
<p class="witryna-google-rating has-large-font-size"><strong><?php echo esc_html( number_format_i18n( $witryna_place['rating'], 1 ) ); ?></strong> <span class="witryna-stars" aria-hidden="true"><?php echo esc_html( witryna_stars( round( $witryna_place['rating'] ) ) ); ?></span> <a href="<?php echo esc_url( $witryna_place['url'] ); ?>" target="_blank" rel="noreferrer noopener"><?php echo esc_html( sprintf( /* translators: %s: number of reviews. */ _n( '%s opinia w Google', '%s opinii w Google', $witryna_place['count'], 'witryna' ), number_format_i18n( $witryna_place['count'] ) ) ); ?></a></p>
<!-- /wp:paragraph -->
<?php endif; ?>

<?php if ( $witryna_google ) : ?>
<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $witryna_google ); ?>" target="_blank" rel="noreferrer noopener"><?php esc_html_e( 'Wystaw opinię w Google', 'witryna' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->
<?php endif; ?></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|50"},"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--50)">
<?php if ( $witryna_reviews ) : ?>
<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"grid","columnCount":3,"minimumColumnWidth":"18rem"}} -->
<div class="wp-block-group alignwide">
<?php foreach ( $witryna_reviews as $witryna_review ) : ?>
<!-- wp:group {"className":"is-style-card","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
<div class="wp-block-group is-style-card"><!-- wp:paragraph {"className":"witryna-stars","textColor":"accent"} -->
<p class="witryna-stars has-accent-color has-text-color" aria-label="<?php echo esc_attr( sprintf( /* translators: %d: rating. */ __( 'Ocena %d na 5', 'witryna' ), $witryna_review['rating'] ) ); ?>"><?php echo esc_html( witryna_stars( $witryna_review['rating'] ) ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php echo esc_html( $witryna_review['text'] ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"textColor":"muted","fontSize":"x-small"} -->
<p class="has-muted-color has-text-color has-x-small-font-size"><strong><?php if ( ! empty( $witryna_review['author_url'] ) ) : ?><a href="<?php echo esc_url( $witryna_review['author_url'] ); ?>" target="_blank" rel="noreferrer noopener nofollow"><?php echo esc_html( $witryna_review['author'] ); ?></a><?php else : ?><?php echo esc_html( $witryna_review['author'] ); ?><?php endif; ?></strong> · <?php echo esc_html( $witryna_review['product'] ); ?> · <?php echo esc_html( $witryna_review['date'] ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
<?php endforeach; ?>
</div>
<!-- /wp:group -->
<?php else : ?>
<!-- wp:group {"align":"wide","className":"is-style-card","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained","contentSize":"640px"}} -->
<div class="wp-block-group alignwide is-style-card"><!-- wp:icon {"icon":"witryna/star","className":"witryna-usp__icon","style":{"dimensions":{"width":"32px"}}} /-->

<!-- wp:heading {"level":2,"fontSize":"x-large"} -->
<h2 class="wp-block-heading has-x-large-font-size"><?php esc_html_e( 'Tu pojawią się opinie z naszego sklepu', 'witryna' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted"} -->
<p class="has-muted-color has-text-color"><?php esc_html_e( 'Po zakupie możesz ocenić produkt na jego stronie w sklepie. Zapraszamy też do zostawienia opinii w Google i do obejrzenia naszego TikToka.', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo witryna_store_url( 'shop', home_url( '/' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>"><?php esc_html_e( 'Przejdź do sklepu', 'witryna' ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( witryna_store_info( 'tiktok' ) ); ?>" target="_blank" rel="noreferrer noopener"><?php esc_html_e( 'Zobacz nasz TikTok', 'witryna' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->
<?php endif; ?>
</div>
<!-- /wp:group -->
