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
		__( 'How long does delivery take?', 'witryna' ),
		__( 'Orders placed on business days before 2 pm are shipped the same day. Courier and parcel locker deliveries usually arrive within 1–2 business days.', 'witryna' ),
	),
	array(
		__( 'How can I return a product?', 'witryna' ),
		__( 'You have 30 days to return any product without giving a reason. Log in to your account, choose the order and follow the return steps. We refund the payment within 5 business days.', 'witryna' ),
	),
	array(
		__( 'Which payment methods do you accept?', 'witryna' ),
		__( 'You can pay by card, fast bank transfer, mobile wallet or bank transfer. All payments are processed by certified payment operators.', 'witryna' ),
	),
	array(
		__( 'Can I change or cancel my order?', 'witryna' ),
		__( 'Yes, as long as the order has not been shipped. Write to us as soon as possible and include your order number.', 'witryna' ),
	),
	array(
		__( 'Do you offer gift wrapping?', 'witryna' ),
		__( 'Every order is packed in recyclable paper. You can add a handwritten card for free by leaving a note at checkout.', 'witryna' ),
	),
);
?>
<!-- wp:group {"align":"full","className":"witryna-faq","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull witryna-faq" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|40","left":"var:preset|spacing|70"}}}} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"width":"38%","style":{"spacing":{"blockGap":"var:preset|spacing|30"}}} -->
<div class="wp-block-column" style="flex-basis:38%"><!-- wp:paragraph {"className":"is-style-eyebrow"} -->
<p class="is-style-eyebrow"><?php esc_html_e( 'Help centre', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'Questions? We have answers', 'witryna' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted"} -->
<p class="has-muted-color has-text-color"><?php esc_html_e( 'Could not find what you were looking for? Our team is happy to help with orders, products and returns.', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="mailto:hello@example.com"><?php esc_html_e( 'Contact us', 'witryna' ); ?></a></div>
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
