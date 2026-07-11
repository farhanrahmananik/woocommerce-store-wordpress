<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Reusable product card. Pass a WC_Product via
 * get_template_part( 'template-parts/product-card', null, array( 'product' => $product ) ),
 * or omit $args to fall back to the global $product set up by WooCommerce's
 * own the_post hook inside a native product loop (e.g. search.php).
 *
 * Optional $args:
 * - 'layout': 'default' (standard vertical card), 'featured' (larger
 *   vertical card with a short description excerpt), or 'compact'
 *   (horizontal mini-card - media on the left, details on the right).
 *   All three share the exact same markup/escaping below; only the
 *   wrapping class differs, so the visual difference lives entirely in
 *   the product-card CSS section.
 */

$product = isset( $args['product'] ) ? $args['product'] : ( $GLOBALS['product'] ?? null );

if ( ! $product instanceof WC_Product ) {
	return;
}

$layout       = $args['layout'] ?? 'default';
$card_classes = array( 'product-card' );

if ( 'featured' === $layout ) {
	$card_classes[] = 'product-card-featured';
} elseif ( 'compact' === $layout ) {
	$card_classes[] = 'product-card-compact';
}
?>
<li class="<?php echo esc_attr( implode( ' ', $card_classes ) ); ?>">
	<a class="product-card-media" href="<?php echo esc_url( $product->get_permalink() ); ?>">
		<?php if ( $product->get_image_id() ) : ?>
			<?php echo $product->get_image( 'woocommerce_thumbnail' ); ?>
		<?php else : ?>
			<?php $visual_variant = desknest_storefront_get_product_visual_variant( $product ); ?>
			<span class="product-card-placeholder product-card-placeholder-<?php echo esc_attr( $visual_variant ); ?>" aria-hidden="true">
				<?php echo desknest_storefront_product_visual( $visual_variant ); ?>
				<span class="product-card-placeholder-mark"><?php echo esc_html( mb_substr( $product->get_name(), 0, 1 ) ); ?></span>
			</span>
		<?php endif; ?>
	</a>

	<?php if ( 'featured' === $layout ) : ?>
		<p class="product-card-eyebrow"><?php esc_html_e( 'Desk setup pick', 'desknest-storefront' ); ?></p>
	<?php endif; ?>

	<h3 class="product-card-title">
		<a href="<?php echo esc_url( $product->get_permalink() ); ?>" title="<?php echo esc_attr( $product->get_name() ); ?>"><?php echo esc_html( $product->get_name() ); ?></a>
	</h3>

	<?php if ( 'featured' === $layout && $product->get_short_description() ) : ?>
		<p class="product-card-excerpt"><?php echo esc_html( wp_trim_words( $product->get_short_description(), 18 ) ); ?></p>
	<?php endif; ?>

	<?php
	$average_rating = (float) $product->get_average_rating();
	$review_count   = (int) $product->get_review_count();
	?>
	<?php if ( $average_rating > 0 && $review_count > 0 ) : ?>
		<?php
		$rating_label = sprintf(
			/* translators: 1: average rating out of 5, 2: number of reviews */
			_n( 'Rated %1$s out of 5, based on %2$s review', 'Rated %1$s out of 5, based on %2$s reviews', $review_count, 'desknest-storefront' ),
			number_format_i18n( $average_rating, 1 ),
			number_format_i18n( $review_count )
		);
		$fill_percent = min( 100, max( 0, ( $average_rating / 5 ) * 100 ) );
		?>
		<div class="product-card-rating" role="img" aria-label="<?php echo esc_attr( $rating_label ); ?>">
			<span class="product-card-rating-stars" aria-hidden="true" style="--rating-fill: <?php echo esc_attr( round( $fill_percent ) ); ?>%;">★★★★★</span>
			<span class="product-card-rating-count" aria-hidden="true">(<?php echo esc_html( number_format_i18n( $review_count ) ); ?>)</span>
		</div>
	<?php else : ?>
		<div class="product-card-rating product-card-rating-empty">
			<span><?php esc_html_e( 'No rating yet', 'desknest-storefront' ); ?></span>
		</div>
	<?php endif; ?>

	<div class="product-card-price"><?php echo $product->get_price_html(); ?></div>

	<div class="product-card-action">
		<?php
		$previous_global_product = $GLOBALS['product'] ?? null;
		$GLOBALS['product']      = $product;
		woocommerce_template_loop_add_to_cart();
		$GLOBALS['product']      = $previous_global_product;
		?>
	</div>
</li>
