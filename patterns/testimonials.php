<?php
/**
 * Title: Customer reviews
 * Slug: witryna/testimonials
 * Categories: testimonials
 * Keywords: reviews, testimonials, opinions, social proof
 * Viewport Width: 1400
 * Description: Three customer reviews with star ratings on cards.
 *
 * @package Witryna
 */

$witryna_reviews = array(
	array(
		'quote'   => __( 'The vase is even more beautiful in person. Carefully packed and delivered the next day. I am already planning my next order.', 'witryna' ),
		'author'  => __( 'Anna, Kraków', 'witryna' ),
		'product' => __( 'Amfora stoneware vase', 'witryna' ),
	),
	array(
		'quote'   => __( 'Great quality and a really thoughtful selection. Customer service helped me choose the right lamp size within an hour.', 'witryna' ),
		'author'  => __( 'Michał, Gdańsk', 'witryna' ),
		'product' => __( 'Globe table lamp', 'witryna' ),
	),
	array(
		'quote'   => __( 'I bought a set of mugs as a gift and ended up keeping two for myself. Simple, elegant and perfect for everyday use.', 'witryna' ),
		'author'  => __( 'Kasia, Wrocław', 'witryna' ),
		'product' => __( 'Morning mug set', 'witryna' ),
	),
);
?>
<!-- wp:group {"align":"full","className":"witryna-testimonials","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"},"blockGap":"var:preset|spacing|50"}},"backgroundColor":"surface","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull witryna-testimonials has-surface-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained","contentSize":"640px"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"is-style-eyebrow","style":{"typography":{"textAlign":"center"}}} -->
<p class="is-style-eyebrow has-text-align-center"><?php esc_html_e( 'Reviews', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"style":{"typography":{"textAlign":"center"}}} -->
<h2 class="wp-block-heading has-text-align-center"><?php esc_html_e( 'Loved by over 2,400 customers', 'witryna' ); ?></h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"grid","columnCount":3,"minimumColumnWidth":"18rem"}} -->
<div class="wp-block-group alignwide">
<?php foreach ( $witryna_reviews as $witryna_review ) : ?>
<!-- wp:group {"className":"is-style-card","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"backgroundColor":"base","layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch","verticalAlignment":"space-between"}} -->
<div class="wp-block-group is-style-card has-base-background-color has-background"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"witryna-stars","textColor":"accent"} -->
<p class="witryna-stars has-accent-color has-text-color">★★★★★</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"fontSize":"large"} -->
<p class="has-large-font-size"><?php echo esc_html( $witryna_review['quote'] ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"blockGap":"0.1rem"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"style":{"typography":{"fontWeight":"600"}},"fontSize":"small"} -->
<p class="has-small-font-size" style="font-weight:600"><?php echo esc_html( $witryna_review['author'] ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"textColor":"muted","fontSize":"x-small"} -->
<p class="has-muted-color has-text-color has-x-small-font-size"><?php echo esc_html( sprintf( /* translators: %s: product name. */ __( 'Verified purchase · %s', 'witryna' ), $witryna_review['product'] ) ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<?php endforeach; ?>
</div>
<!-- /wp:group --></div>
<!-- /wp:group -->
