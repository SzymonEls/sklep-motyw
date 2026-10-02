<?php
/**
 * Title: Hero with quick category links
 * Slug: witryna/hero-split
 * Categories: banner, featured
 * Keywords: hero, intro, banner, stihl, service
 * Viewport Width: 1400
 * Description: Dark hero with headline, shop and service buttons, store details and a panel of quick links to the main equipment categories.
 *
 * @package Witryna
 */

$witryna_shop  = witryna_store_url( 'shop', home_url( '/' ) );
$witryna_quick = array(
	array( __( 'Kosiarki', 'witryna' ), 'kosiarki' ),
	array( __( 'Roboty koszące', 'witryna' ), 'roboty-koszace' ),
	array( __( 'Pilarki', 'witryna' ), 'pilarki' ),
	array( __( 'Kosy i podkaszarki', 'witryna' ), 'kosy-i-podkaszarki' ),
	array( __( 'Nożyce do żywopłotu', 'witryna' ), 'nozyce-do-zywoplotu' ),
	array( __( 'Części i eksploatacja', 'witryna' ), 'czesci-i-eksploatacja' ),
);
?>
<!-- wp:group {"align":"full","className":"witryna-hero witryna-hero--tools is-style-section-dark","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull witryna-hero witryna-hero--tools is-style-section-dark" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)"><!-- wp:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|50","left":"var:preset|spacing|60"}}}} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center","width":"58%","className":"witryna-hero__content","style":{"spacing":{"blockGap":"var:preset|spacing|30"}}} -->
<div class="wp-block-column is-vertically-aligned-center witryna-hero__content" style="flex-basis:58%"><!-- wp:paragraph {"className":"is-style-eyebrow witryna-hero__eyebrow"} -->
<p class="is-style-eyebrow witryna-hero__eyebrow"><?php esc_html_e( 'Autoryzowany dealer STIHL · Czernica k. Wrocławia', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"fontSize":"display"} -->
<h1 class="wp-block-heading has-display-font-size"><?php esc_html_e( 'Sprzęt ogrodowy ze sklepu, który go też naprawi', 'witryna' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"witryna-soft","fontSize":"large"} -->
<p class="witryna-soft has-large-font-size"><?php esc_html_e( 'Kosiarki, pilarki, kosy i roboty koszące STIHL. Doradzimy, sprzedamy i zadbamy o serwis, żeby Twój sprzęt działał przez lata.', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}}}} -->
<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--20)"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo $witryna_shop; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>"><?php esc_html_e( 'Przejdź do sklepu', 'witryna' ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo witryna_page_url( 'serwis' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>"><?php esc_html_e( 'Zgłoś serwis', 'witryna' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:list {"className":"witryna-hero__facts is-style-plain","fontSize":"small"} -->
<ul class="wp-block-list witryna-hero__facts is-style-plain has-small-font-size"><!-- wp:list-item -->
<li><a href="tel:<?php echo esc_attr( witryna_store_info( 'phone_href' ) ); ?>"><?php echo esc_html( witryna_store_info( 'phone' ) ); ?></a></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php echo esc_html( witryna_store_info( 'hours_short' ) ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php echo esc_html( witryna_store_address() ); ?></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"42%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:42%"><!-- wp:group {"className":"witryna-quick","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","right":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40"},"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
<div class="wp-block-group witryna-quick" style="padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)"><!-- wp:heading {"level":2,"className":"is-style-eyebrow","fontSize":"x-small"} -->
<h2 class="wp-block-heading is-style-eyebrow has-x-small-font-size"><?php esc_html_e( 'Czego szukasz?', 'witryna' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:list {"className":"witryna-quick__list is-style-plain"} -->
<ul class="wp-block-list witryna-quick__list is-style-plain">
<?php foreach ( $witryna_quick as $witryna_item ) : ?>
<?php $witryna_term = get_term_by( 'slug', $witryna_item[1], 'product_cat' ); ?>
<?php $witryna_link = $witryna_term ? get_term_link( $witryna_term ) : $witryna_shop; ?>
<!-- wp:list-item -->
<li><a href="<?php echo esc_url( is_wp_error( $witryna_link ) ? $witryna_shop : $witryna_link ); ?>"><?php echo esc_html( $witryna_item[0] ); ?></a></li>
<!-- /wp:list-item -->
<?php endforeach; ?>
</ul>
<!-- /wp:list --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
