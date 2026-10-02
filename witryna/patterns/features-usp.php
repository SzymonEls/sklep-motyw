<?php
/**
 * Title: Store benefits
 * Slug: witryna/features-usp
 * Categories: witryna-shop, featured
 * Keywords: benefits, delivery, returns, payments, trust
 * Viewport Width: 1400
 * Description: Four short benefits with icons: delivery, returns, payments and customer support.
 *
 * @package Witryna
 */

$witryna_benefits = array(
	array(
		'icon'  => 'witryna/truck',
		'title' => __( 'Fast, free delivery', 'witryna' ),
		/* translators: %s: order value, e.g. 199 zł. */
		'text'  => sprintf( __( 'On all orders over %s', 'witryna' ), witryna_price_label( 199 ) ),
	),
	array(
		'icon'  => 'witryna/return',
		'title' => __( '30-day returns', 'witryna' ),
		'text'  => __( 'Changed your mind? No problem', 'witryna' ),
	),
	array(
		'icon'  => 'witryna/lock',
		'title' => __( 'Secure payments', 'witryna' ),
		'text'  => __( 'Cards, transfers and mobile wallets', 'witryna' ),
	),
	array(
		'icon'  => 'witryna/chat',
		'title' => __( 'Real people, real help', 'witryna' ),
		'text'  => __( 'We reply within one business day', 'witryna' ),
	),
);
?>
<!-- wp:group {"align":"full","className":"witryna-usp","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}},"border":{"top":{"color":"var:preset|color|line","width":"1px"},"bottom":{"color":"var:preset|color|line","width":"1px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull witryna-usp" style="border-top-color:var(--wp--preset--color--line);border-top-width:1px;border-bottom-color:var(--wp--preset--color--line);border-bottom-width:1px;padding-top:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40)"><!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"grid","columnCount":4,"minimumColumnWidth":"14rem"}} -->
<div class="wp-block-group alignwide">
<?php foreach ( $witryna_benefits as $witryna_benefit ) : ?>
<!-- wp:group {"style":{"spacing":{"blockGap":"0.9rem"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group"><!-- wp:icon {"icon":"<?php echo esc_attr( $witryna_benefit['icon'] ); ?>","className":"witryna-usp__icon","style":{"dimensions":{"width":"28px"}}} /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"0.15rem"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group"><!-- wp:heading {"level":3,"fontSize":"medium"} -->
<h3 class="wp-block-heading has-medium-font-size"><?php echo esc_html( $witryna_benefit['title'] ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted","fontSize":"small"} -->
<p class="has-muted-color has-text-color has-small-font-size"><?php echo esc_html( $witryna_benefit['text'] ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<?php endforeach; ?>
</div>
<!-- /wp:group --></div>
<!-- /wp:group -->
