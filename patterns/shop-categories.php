<?php
/**
 * Title: Shop by category
 * Slug: witryna/shop-categories
 * Categories: witryna-shop
 * Keywords: categories, collections, tiles, grid
 * Viewport Width: 1400
 * Description: Tiles for the four most popular product categories. Category thumbnails are used when available, otherwise a dark tile.
 *
 * @package Witryna
 */

$witryna_terms = witryna_featured_categories( 4 );
$witryna_tiles = array();

foreach ( $witryna_terms as $witryna_index => $witryna_term ) {
	$witryna_thumbnail = (int) get_term_meta( $witryna_term->term_id, 'thumbnail_id', true );
	$witryna_link      = get_term_link( $witryna_term );
	$witryna_tiles[]   = array(
		'name'  => $witryna_term->name,
		'url'   => is_wp_error( $witryna_link ) ? '#' : $witryna_link,
		/* translators: %s: number of products. */
		'count' => sprintf( _n( '%s product', '%s products', $witryna_term->count, 'witryna' ), number_format_i18n( $witryna_term->count ) ),
		'image' => $witryna_thumbnail ? wp_get_attachment_image_url( $witryna_thumbnail, 'large' ) : '',
	);
}

if ( empty( $witryna_tiles ) ) {
	$witryna_shop  = witryna_store_url( 'shop', home_url( '/' ) );
	$witryna_tiles = array(
		array( 'name' => __( 'Kosiarki', 'witryna' ), 'url' => $witryna_shop, 'count' => __( 'Zobacz', 'witryna' ), 'image' => '' ),
		array( 'name' => __( 'Roboty koszące', 'witryna' ), 'url' => $witryna_shop, 'count' => __( 'Zobacz', 'witryna' ), 'image' => '' ),
		array( 'name' => __( 'Pilarki', 'witryna' ), 'url' => $witryna_shop, 'count' => __( 'Zobacz', 'witryna' ), 'image' => '' ),
		array( 'name' => __( 'Kosy i podkaszarki', 'witryna' ), 'url' => $witryna_shop, 'count' => __( 'Zobacz', 'witryna' ), 'image' => '' ),
	);
}
?>
<!-- wp:group {"anchor":"categories","align":"full","className":"witryna-categories","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|40"},"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
<div id="categories" class="wp-block-group alignfull witryna-categories" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--40)"><!-- wp:group {"align":"wide","className":"witryna-section-head","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
<div class="wp-block-group alignwide witryna-section-head"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"is-style-eyebrow"} -->
<p class="is-style-eyebrow"><?php esc_html_e( 'Categories', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'Sprzęt do każdego ogrodu', 'witryna' ); ?></h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-arrow"} -->
<div class="wp-block-button is-style-arrow"><a class="wp-block-button__link wp-element-button" href="<?php echo witryna_store_url( 'shop', home_url( '/' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>"><?php esc_html_e( 'All products', 'witryna' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"grid","columnCount":4,"minimumColumnWidth":"15rem"}} -->
<div class="wp-block-group alignwide">
<?php foreach ( $witryna_tiles as $witryna_tile ) : ?>
<?php if ( $witryna_tile['image'] ) : ?>
<!-- wp:cover {"url":"<?php echo esc_url( $witryna_tile['image'] ); ?>","dimRatio":100,"gradient":"shade-bottom","minHeight":420,"minHeightUnit":"px","contentPosition":"bottom left","className":"witryna-category-card is-style-zoom","style":{"border":{"radius":"var:preset|border-radius|large"},"spacing":{"padding":{"top":"var:preset|spacing|30","right":"var:preset|spacing|30","bottom":"var:preset|spacing|30","left":"var:preset|spacing|30"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-cover has-custom-content-position is-position-bottom-left witryna-category-card is-style-zoom" style="border-radius:var(--wp--preset--border-radius--large);padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30);min-height:420px"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( $witryna_tile['image'] ); ?>" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-100 has-background-dim wp-block-cover__gradient-background has-background-gradient has-shade-bottom-gradient-background"></span><?php else : ?>
<!-- wp:cover {"dimRatio":100,"overlayColor":"contrast","minHeight":260,"minHeightUnit":"px","contentPosition":"bottom left","className":"witryna-category-card witryna-category-card--plain","style":{"border":{"radius":"var:preset|border-radius|medium"},"spacing":{"padding":{"top":"var:preset|spacing|30","right":"var:preset|spacing|30","bottom":"var:preset|spacing|30","left":"var:preset|spacing|30"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-cover has-custom-content-position is-position-bottom-left witryna-category-card witryna-category-card--plain" style="border-radius:var(--wp--preset--border-radius--medium);padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30);min-height:260px"><span aria-hidden="true" class="wp-block-cover__background has-contrast-background-color has-background-dim-100 has-background-dim"></span><?php endif; ?><div class="wp-block-cover__inner-container"><!-- wp:heading {"level":3,"fontSize":"x-large"} -->
<h3 class="wp-block-heading has-x-large-font-size"><a href="<?php echo esc_url( $witryna_tile['url'] ); ?>"><?php echo esc_html( $witryna_tile['name'] ); ?></a></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size"><?php echo esc_html( $witryna_tile['count'] ); ?></p>
<!-- /wp:paragraph --></div></div>
<!-- /wp:cover -->
<?php endforeach; ?>
</div>
<!-- /wp:group --></div>
<!-- /wp:group -->
