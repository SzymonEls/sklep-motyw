<?php
/**
 * Title: Social media gallery
 * Slug: witryna/gallery-social
 * Categories: gallery
 * Keywords: instagram, social, gallery, photos, community
 * Viewport Width: 1400
 * Description: Grid of square photos with a link to your social media profile.
 *
 * @package Witryna
 */

?>
<!-- wp:group {"align":"full","className":"witryna-social","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"},"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull witryna-social" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained","contentSize":"640px"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"is-style-eyebrow","style":{"typography":{"textAlign":"center"}}} -->
<p class="is-style-eyebrow has-text-align-center">@witryna</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"style":{"typography":{"textAlign":"center"}}} -->
<h2 class="wp-block-heading has-text-align-center"><?php esc_html_e( 'Share your space with us', 'witryna' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"textAlign":"center"}},"textColor":"muted"} -->
<p class="has-text-align-center has-muted-color has-text-color"><?php esc_html_e( 'Tag your photos with #witryna and get featured in our gallery.', 'witryna' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"grid","columnCount":4,"minimumColumnWidth":"10rem"}} -->
<div class="wp-block-group alignwide">
<?php foreach ( array( 'social-1.jpg', 'social-2.jpg', 'social-3.jpg', 'social-4.jpg' ) as $witryna_photo ) : ?>
<!-- wp:image {"aspectRatio":"1","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"is-style-zoom","style":{"border":{"radius":"var:preset|border-radius|large"}}} -->
<figure class="wp-block-image size-full has-custom-border is-style-zoom"><img src="<?php echo witryna_image( $witryna_photo ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>" alt="" style="border-radius:var(--wp--preset--border-radius--large);aspect-ratio:1;object-fit:cover"/></figure>
<!-- /wp:image -->
<?php endforeach; ?>
</div>
<!-- /wp:group -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="https://www.instagram.com/"><?php esc_html_e( 'Follow us on Instagram', 'witryna' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->
