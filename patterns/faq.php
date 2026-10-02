<?php
/**
 * Title: Frequently asked questions
 * Slug: witryna/faq
 * Categories: text, witryna-shop
 * Keywords: faq, questions, answers, accordion, help
 * Viewport Width: 1400
 * Description: Introduction with a contact button next to an accordion with common store questions.
 *
 * @package Witryna
 */

$witryna_faq = array(
	array(
		__( 'Czy mogę odebrać zamówienie osobiście?', 'witryna' ),
		__( 'Tak. Wybierz odbiór osobisty przy zamówieniu i przyjedź do sklepu w Czernicy w godzinach otwarcia, gdy potwierdzimy, że sprzęt czeka. Przy odbiorze pokażemy, jak go uruchomić i bezpiecznie używać.', 'witryna' ),
	),
	array(
		__( 'Czy serwisujecie sprzęt kupiony w innym sklepie?', 'witryna' ),
		__( 'Tak. Serwisujemy sprzęt STIHL i wielu innych producentów. Zadzwoń z marką i modelem, a potwierdzimy, czy zajmiemy się Twoim urządzeniem.', 'witryna' ),
	),
	array(
		__( 'Ile kosztuje naprawa?', 'witryna' ),
		__( 'Ostateczną cenę podajemy po diagnozie, zanim zaczniemy naprawę. Bez Twojej zgody niczego nie naprawiamy.', 'witryna' ),
	),
	array(
		__( 'Kiedy najlepiej oddać kosiarkę na przegląd?', 'witryna' ),
		__( 'Zimą albo wczesną wiosną. W sezonie, od kwietnia do czerwca, czas oczekiwania na serwis jest dłuższy.', 'witryna' ),
	),
	array(
		__( 'Czy odbieracie sprzęt do serwisu?', 'witryna' ),
		__( 'W okolicy Czernicy możemy odebrać sprzęt i odwieźć go po naprawie. Zadzwoń, żeby ustalić termin.', 'witryna' ),
	),
	array(
		__( 'Jak zwrócić towar kupiony przez internet?', 'witryna' ),
		__( 'Masz 14 dni na odstąpienie od umowy zawartej przez internet bez podania przyczyny. Szczegóły znajdziesz w regulaminie sklepu.', 'witryna' ),
	),
);
?>
<!-- wp:group {"align":"full","className":"witryna-faq","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull witryna-faq" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|40","left":"var:preset|spacing|70"}}}} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"width":"38%","style":{"spacing":{"blockGap":"var:preset|spacing|30"}}} -->
<div class="wp-block-column" style="flex-basis:38%"><!-- wp:paragraph {"className":"is-style-eyebrow"} -->
<p class="is-style-eyebrow"><?php esc_html_e( 'Pytania i odpowiedzi', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'Najczęstsze pytania', 'witryna' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted"} -->
<p class="has-muted-color has-text-color"><?php esc_html_e( 'Nie znalazłeś odpowiedzi? Zadzwoń albo napisz, chętnie pomożemy w wyborze sprzętu, zamówieniu i serwisie.', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo witryna_page_url( 'kontakt' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>"><?php esc_html_e( 'Contact us', 'witryna' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"62%"} -->
<div class="wp-block-column" style="flex-basis:62%"><!-- wp:accordion {"className":"witryna-accordion"} -->
<div role="group" class="wp-block-accordion witryna-accordion">
<?php foreach ( $witryna_faq as $witryna_item ) : ?>
<!-- wp:accordion-item -->
<div class="wp-block-accordion-item"><!-- wp:accordion-heading -->
<h3 class="wp-block-accordion-heading has-icon has-icon-right"><button type="button" class="wp-block-accordion-heading__toggle"><span class="wp-block-accordion-heading__toggle-title"><?php echo esc_html( $witryna_item[0] ); ?></span><span class="wp-block-accordion-heading__toggle-icon" aria-hidden="true">+</span></button></h3>
<!-- /wp:accordion-heading -->

<!-- wp:accordion-panel -->
<div role="region" class="wp-block-accordion-panel"><!-- wp:paragraph -->
<p><?php echo esc_html( $witryna_item[1] ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:accordion-panel --></div>
<!-- /wp:accordion-item -->
<?php endforeach; ?>
</div>
<!-- /wp:accordion --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
