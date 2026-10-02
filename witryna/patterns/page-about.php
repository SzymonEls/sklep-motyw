<?php
/**
 * Title: About us page
 * Slug: witryna/page-about
 * Categories: witryna-pages, about
 * Keywords: about, company, story, values, team
 * Block Types: core/post-content
 * Post Types: page
 * Viewport Width: 1400
 * Description: About page with an introduction, wide photo, brand values and a call to action.
 *
 * @package Witryna
 */

$witryna_values = array(
	array( 'witryna/leaf', __( 'Responsibly made', 'witryna' ), __( 'We choose durable materials and work with studios that pay fair wages and minimise waste.', 'witryna' ) ),
	array( 'witryna/sparkle', __( 'Checked by hand', 'witryna' ), __( 'Every item is inspected before shipping, so you receive exactly what you see in the photos.', 'witryna' ) ),
	array( 'witryna/package', __( 'Plastic-free packaging', 'witryna' ), __( 'We pack orders in recycled paper and reuse boxes from our suppliers whenever possible.', 'witryna' ) ),
);
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|50"},"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained","contentSize":"860px"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--50)"><!-- wp:paragraph {"className":"is-style-eyebrow"} -->
<p class="is-style-eyebrow"><?php esc_html_e( 'About us', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"fontSize":"display"} -->
<h1 class="wp-block-heading has-display-font-size"><?php esc_html_e( 'We believe in fewer, better things', 'witryna' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted","fontSize":"large"} -->
<p class="has-muted-color has-text-color has-large-font-size"><?php esc_html_e( 'Our shop began as a small market stall. Today we ship across the country, but our approach has not changed: we sell only what we would happily use at home ourselves.', 'witryna' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:image {"align":"wide","aspectRatio":"21/9","scale":"cover","sizeSlug":"full","linkDestination":"none","style":{"border":{"radius":"var:preset|border-radius|x-large"}}} -->
<figure class="wp-block-image alignwide size-full has-custom-border"><img src="<?php echo witryna_image( 'cover.jpg' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>" alt="<?php echo esc_attr__( 'Our studio with shelves full of ceramics', 'witryna' ); ?>" style="border-radius:var(--wp--preset--border-radius--x-large);aspect-ratio:21/9;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"},"blockGap":"var:preset|spacing|50"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:heading {"align":"wide"} -->
<h2 class="wp-block-heading alignwide"><?php esc_html_e( 'What we stand for', 'witryna' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"grid","columnCount":3,"minimumColumnWidth":"16rem"}} -->
<div class="wp-block-group alignwide">
<?php foreach ( $witryna_values as $witryna_value ) : ?>
<!-- wp:group {"className":"is-style-card","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group is-style-card"><!-- wp:icon {"icon":"<?php echo esc_attr( $witryna_value[0] ); ?>","style":{"dimensions":{"width":"32px"}}} /-->

<!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size"><?php echo esc_html( $witryna_value[1] ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted","fontSize":"small"} -->
<p class="has-muted-color has-text-color has-small-font-size"><?php echo esc_html( $witryna_value[2] ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
<?php endforeach; ?>
</div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:pattern {"slug":"witryna/brand-story"} /-->

<!-- wp:pattern {"slug":"witryna/newsletter"} /-->
