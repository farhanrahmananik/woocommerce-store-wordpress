<?php
/**
 * Related products (Scope 21 Step 5C) - theme override of
 * woocommerce/single-product/related.php.
 *
 * Renders the real WooCommerce related-products query through the approved
 * DeskNest product-card partial + .storefront-shop-grid, so related items
 * match the approved shop/category cards exactly (inline-SVG placeholder
 * instead of a broken default image, green buttons, 2-line title handling)
 * instead of WooCommerce's default content-product.php cards.
 *
 * The query itself is the genuine WooCommerce related query
 * (wc_get_related_products + wc_products_array_filter_visible), unchanged
 * and unreordered - no fake or hand-picked related products.
 *
 * @see wc_get_template()  yourtheme/woocommerce/ overrides the plugin copy.
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product instanceof WC_Product ) {
	return;
}

$storefront_related_limit = isset( $args['posts_per_page'] ) ? (int) $args['posts_per_page'] : 4;
$storefront_related_ids   = wc_get_related_products( $product->get_id(), $storefront_related_limit, $product->get_upsell_ids() );
$storefront_related       = array_filter( array_map( 'wc_get_product', $storefront_related_ids ), 'wc_products_array_filter_visible' );

if ( empty( $storefront_related ) ) {
	return;
}
?>
<section class="related products storefront-related">
	<h2><?php esc_html_e( 'Related products', 'desknest-storefront' ); ?></h2>

	<ul class="product-grid storefront-shop-grid">
		<?php foreach ( $storefront_related as $storefront_related_product ) : ?>
			<?php get_template_part( 'template-parts/product-card', null, array( 'product' => $storefront_related_product ) ); ?>
		<?php endforeach; ?>
	</ul>
</section>
<?php
wp_reset_postdata();
