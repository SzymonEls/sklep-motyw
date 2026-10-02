<?php
/**
 * Title: Brand story with numbers
 * Slug: witryna/brand-story
 * Categories: about, witryna-shop
 * Keywords: about, story, brand, numbers, statistics
 * Viewport Width: 1400
 * Description: Image next to the brand story and three key numbers.
 *
 * @package Witryna
 */

$witryna_stats = array(
	array( '12k+', __( 'orders shipped', 'witryna' ) ),
	array( '4.9', __( 'average rating', 'witryna' ) ),
	array( '24h', __( 'dispatch time', 'witryna' ) ),
);
?>
<!-- wp:group {"align":"full","className":"witryna-story","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull witryna-story" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|50","left":"var:preset|spacing|70"}}}} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center","width":"45%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:45%"><!-- wp:image {"aspectRatio":"4/5","scale":"cover","sizeSlug":"full","linkDestination":"none","style":{"border":{"radius":"var:preset|border-radius|x-large"}}} -->
<figure class="wp-block-image size-full has-custom-border"><img src="<?php echo witryna_image( 'story.jpg' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>" alt="<?php echo esc_attr__( 'Ceramic pieces drying in the studio', 'witryna' ); ?>" style="border-radius:var(--wp--preset--border-radius--x-large);aspect-ratio:4/5;object-fit:cover"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"55%","style":{"spacing":{"blockGap":"var:preset|spacing|30"}}} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:55%"><!-- wp:paragraph {"className":"is-style-eyebrow"} -->
<p class="is-style-eyebrow"><?php esc_html_e( 'Our story', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"fontSize":"xxx-large"} -->
<h2 class="wp-block-heading has-xxx-large-font-size"><?php esc_html_e( 'Designed with care, made to last', 'witryna' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted","fontSize":"large"} -->
<p class="has-muted-color has-text-color has-large-font-size"><?php esc_html_e( 'We started with a single kiln and a simple idea: everyday objects should be beautiful, honest and durable. Today we work with a dozen small studios, but every piece is still checked by hand before it reaches you.', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"witryna-stats","style":{"spacing":{"blockGap":"var:preset|spacing|30","margin":{"top":"var:preset|spacing|30"},"padding":{"top":"var:preset|spacing|30"}},"border":{"top":{"color":"var:preset|color|line","width":"1px"}}},"layout":{"type":"grid","columnCount":3,"minimumColumnWidth":"8rem"}} -->
<div class="wp-block-group witryna-stats" style="border-top-color:var(--wp--preset--color--line);border-top-width:1px;margin-top:var(--wp--preset--spacing--30);padding-top:var(--wp--preset--spacing--30)">
<?php foreach ( $witryna_stats as $witryna_stat ) : ?>
<!-- wp:group {"style":{"spacing":{"blockGap":"0.2rem"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"witryna-stat","fontSize":"xx-large"} -->
<p class="witryna-stat has-xx-large-font-size"><?php echo esc_html( $witryna_stat[0] ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"textColor":"muted","fontSize":"small"} -->
<p class="has-muted-color has-text-color has-small-font-size"><?php echo esc_html( $witryna_stat[1] ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
<?php endforeach; ?>
</div>
<!-- /wp:group -->

<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}}}} -->
<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--20)"><!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Read more about us', 'witryna' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
