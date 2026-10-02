<?php
/**
 * Title: Service promotion
 * Slug: witryna/promo-split
 * Categories: banner, witryna-shop
 * Keywords: service, repair, maintenance, promotion
 * Viewport Width: 1400
 * Description: Service section with a short list of what the workshop does next to a card with the steps of a repair and call to action buttons.
 *
 * @package Witryna
 */

$witryna_services = array(
	__( 'Przeglądy sezonowe kosiarek, pilarek i kos', 'witryna' ),
	__( 'Ostrzenie łańcuchów i noży', 'witryna' ),
	__( 'Naprawy silników spalinowych', 'witryna' ),
	__( 'Diagnostyka sprzętu akumulatorowego', 'witryna' ),
	__( 'Oryginalne części STIHL', 'witryna' ),
);

$witryna_steps = array(
	array( __( 'Zgłoś sprzęt', 'witryna' ), __( 'Zadzwoń albo wypełnij formularz na stronie serwisu.', 'witryna' ) ),
	array( __( 'Przywieź lub umów odbiór', 'witryna' ), __( 'W okolicy Czernicy możemy odebrać sprzęt od Ciebie.', 'witryna' ) ),
	array( __( 'Wycena przed naprawą', 'witryna' ), __( 'Po diagnozie dzwonimy z ceną. Naprawiamy po Twojej zgodzie.', 'witryna' ) ),
	array( __( 'Odbierz sprawny sprzęt', 'witryna' ), __( 'Gotowy do pracy, sprawdzony na miejscu.', 'witryna' ) ),
);
?>
<!-- wp:group {"align":"full","className":"witryna-service-promo","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"surface","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull witryna-service-promo has-surface-background-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)"><!-- wp:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|50","left":"var:preset|spacing|60"}}}} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center","style":{"spacing":{"blockGap":"var:preset|spacing|30"}}} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:paragraph {"className":"is-style-eyebrow"} -->
<p class="is-style-eyebrow"><?php esc_html_e( 'Serwis', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'Naprawimy to, co sprzedajemy, i nie tylko', 'witryna' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted"} -->
<p class="has-muted-color has-text-color"><?php esc_html_e( 'Regularny przegląd to najtańszy sposób, żeby sprzęt działał długo i bez niespodzianek. Zajmujemy się wszystkim, od wymiany oleju po naprawę silnika.', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"is-style-checklist"} -->
<ul class="wp-block-list is-style-checklist">
<?php foreach ( $witryna_services as $witryna_service ) : ?>
<!-- wp:list-item -->
<li><?php echo esc_html( $witryna_service ); ?></li>
<!-- /wp:list-item -->
<?php endforeach; ?>
</ul>
<!-- /wp:list -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo witryna_page_url( 'serwis' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>"><?php esc_html_e( 'Zgłoś serwis', 'witryna' ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="tel:<?php echo esc_attr( witryna_store_info( 'phone_href' ) ); ?>"><?php echo esc_html( sprintf( /* translators: %s: phone number. */ __( 'Zadzwoń: %s', 'witryna' ), witryna_store_info( 'phone' ) ) ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:group {"className":"witryna-steps is-style-card","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"backgroundColor":"base","layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
<div class="wp-block-group witryna-steps is-style-card has-base-background-color has-background"><!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size"><?php esc_html_e( 'Jak to działa', 'witryna' ); ?></h3>
<!-- /wp:heading -->

<?php foreach ( $witryna_steps as $witryna_index => $witryna_step ) : ?>
<!-- wp:group {"className":"witryna-step","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group witryna-step"><!-- wp:paragraph {"className":"witryna-step__number"} -->
<p class="witryna-step__number"><?php echo esc_html( $witryna_index + 1 ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:group {"style":{"spacing":{"blockGap":"0.15rem"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group"><!-- wp:heading {"level":4,"fontSize":"medium"} -->
<h4 class="wp-block-heading has-medium-font-size"><?php echo esc_html( $witryna_step[0] ); ?></h4>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted","fontSize":"small"} -->
<p class="has-muted-color has-text-color has-small-font-size"><?php echo esc_html( $witryna_step[1] ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<?php endforeach; ?>
</div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
