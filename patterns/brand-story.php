<?php
/**
 * Title: About the store
 * Slug: witryna/brand-story
 * Categories: about, featured
 * Keywords: about, story, brand, stihl, dealer
 * Viewport Width: 1400
 * Description: Short introduction of the store with three key facts and cards for home gardeners and business customers.
 *
 * @package Witryna
 */

$witryna_stats = array(
	array( 'STIHL', __( 'autoryzowany dealer', 'witryna' ) ),
	array( '2 w 1', __( 'sklep i serwis w jednym miejscu', 'witryna' ) ),
	array( 'Czernica', __( 'kilka minut od Wrocławia', 'witryna' ) ),
);

$witryna_groups = array(
	array( __( 'Dla domu i ogrodu', 'witryna' ), __( 'Pomożemy dobrać kosiarkę, robota koszącego czy pilarkę do wielkości działki i budżetu. Pokażemy, jak bezpiecznie używać sprzętu.', 'witryna' ) ),
	array( __( 'Dla firm', 'witryna' ), __( 'Obsługujemy firmy ogrodnicze, zarządców nieruchomości i gospodarstwa. Zapytaj o warunki współpracy i serwis floty.', 'witryna' ) ),
);
?>
<!-- wp:group {"align":"full","className":"witryna-story","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull witryna-story" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)"><!-- wp:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|50","left":"var:preset|spacing|70"}}}} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center","width":"55%","style":{"spacing":{"blockGap":"var:preset|spacing|30"}}} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:55%"><!-- wp:paragraph {"className":"is-style-eyebrow"} -->
<p class="is-style-eyebrow"><?php esc_html_e( 'O nas', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"fontSize":"xx-large"} -->
<h2 class="wp-block-heading has-xx-large-font-size"><?php esc_html_e( 'Nie kończymy na sprzedaży', 'witryna' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted","fontSize":"large"} -->
<p class="has-muted-color has-text-color has-large-font-size"><?php esc_html_e( 'Klinika Trawnika to sklep i serwis sprzętu ogrodowego i leśnego w Czernicy. Pomagamy wybrać odpowiedni model, uczymy, jak go używać, a potem dbamy o jego serwis.', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"witryna-stats","style":{"spacing":{"blockGap":"var:preset|spacing|30","margin":{"top":"var:preset|spacing|30"},"padding":{"top":"var:preset|spacing|30"}},"border":{"top":{"color":"var:preset|color|line","width":"1px"}}},"layout":{"type":"grid","columnCount":3,"minimumColumnWidth":"8rem"}} -->
<div class="wp-block-group witryna-stats" style="border-top-color:var(--wp--preset--color--line);border-top-width:1px;margin-top:var(--wp--preset--spacing--30);padding-top:var(--wp--preset--spacing--30)">
<?php foreach ( $witryna_stats as $witryna_stat ) : ?>
<!-- wp:group {"style":{"spacing":{"blockGap":"0.2rem"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"witryna-stat","fontSize":"x-large"} -->
<p class="witryna-stat has-x-large-font-size"><?php echo esc_html( $witryna_stat[0] ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"textColor":"muted","fontSize":"small"} -->
<p class="has-muted-color has-text-color has-small-font-size"><?php echo esc_html( $witryna_stat[1] ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
<?php endforeach; ?>
</div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"45%","style":{"spacing":{"blockGap":"var:preset|spacing|30"}}} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:45%">
<?php foreach ( $witryna_groups as $witryna_group ) : ?>
<!-- wp:group {"className":"is-style-card","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group is-style-card"><!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size"><?php echo esc_html( $witryna_group[0] ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted"} -->
<p class="has-muted-color has-text-color"><?php echo esc_html( $witryna_group[1] ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
<?php endforeach; ?>
</div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
