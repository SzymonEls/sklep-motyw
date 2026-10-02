<?php
/**
 * Title: About us page
 * Slug: witryna/page-about
 * Categories: witryna-pages, about
 * Keywords: about, company, story, values, team, stihl
 * Block Types: core/post-content
 * Post Types: page, wp_template
 * Viewport Width: 1400
 * Description: About page with an introduction, store facts, benefits and store visit details.
 *
 * @package Witryna
 */

?>
<!-- wp:group {"align":"full","className":"is-style-section-dark","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-section-dark" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)"><!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained","contentSize":"760px","justifyContent":"left"}} -->
<div class="wp-block-group alignwide"><!-- wp:paragraph {"className":"is-style-eyebrow witryna-hero__eyebrow"} -->
<p class="is-style-eyebrow witryna-hero__eyebrow"><?php esc_html_e( 'O firmie', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"fontSize":"display"} -->
<h1 class="wp-block-heading has-display-font-size"><?php esc_html_e( 'Sklep i serwis sprzętu ogrodowego w Czernicy', 'witryna' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"witryna-soft","fontSize":"large"} -->
<p class="witryna-soft has-large-font-size"><?php esc_html_e( 'Jesteśmy autoryzowanym dealerem marki STIHL, a w ofercie mamy też sprzęt innych sprawdzonych producentów. Wiemy, jak ważny jest sprawny sprzęt, gdy trzeba zadbać o trawnik, żywopłot czy drewno na zimę.', 'witryna' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:pattern {"slug":"witryna/brand-story"} /-->

<!-- wp:pattern {"slug":"witryna/features-usp"} /-->

<!-- wp:pattern {"slug":"witryna/store-visit"} /-->
