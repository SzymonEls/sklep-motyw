<?php
/**
 * Title: No results
 * Slug: witryna/hidden-no-results
 * Inserter: no
 *
 * @package Witryna
 */

?>
<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"},"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained","contentSize":"560px"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50)"><!-- wp:heading {"level":2,"fontSize":"x-large"} -->
<h2 class="wp-block-heading has-x-large-font-size"><?php esc_html_e( 'Nothing here yet', 'witryna' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted"} -->
<p class="has-muted-color has-text-color"><?php esc_html_e( 'We could not find anything matching your request. Try a different search or browse the shop.', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:search {"label":"<?php echo esc_attr_x( 'Search', 'search label', 'witryna' ); ?>","showLabel":false,"placeholder":"<?php echo esc_attr__( 'Search…', 'witryna' ); ?>","buttonText":"<?php echo esc_attr_x( 'Search', 'search button', 'witryna' ); ?>","buttonPosition":"button-inside","buttonUseIcon":true} /--></div>
<!-- /wp:group -->
