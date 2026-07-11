<?php
/**
 * Single product image (Scope 21 Step 5C) - theme override of
 * woocommerce/single-product/product-image.php.
 *
 * Purpose: stop the broken/default WooCommerce placeholder-image icon on
 * products with no featured image, replacing it with the same approved
 * DeskNest inline-SVG product visual used on the shop/category cards
 * (desknest_storefront_product_visual()). Products that DO have a real
 * image keep WooCommerce's normal gallery output (wc_get_gallery_image_html
 * + the woocommerce_single_product_image_thumbnail_html filter and the
 * woocommerce_product_thumbnails hook), so real images - now or in the
 * future, including future per-variation images - are never blocked. No
 * external assets, no remote images, no fake photography.
 *
 * @see wc_get_template()  yourtheme/woocommerce/ overrides the plugin copy.
 */

defined( 'ABSPATH' ) || exit;

global $product;

$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = ( $product instanceof WC_Product ) ? $product->get_image_id() : 0;
$wrapper_classes   = apply_filters(
	'woocommerce_single_product_image_gallery_classes',
	array(
		'woocommerce-product-gallery',
		'woocommerce-product-gallery--' . ( $post_thumbnail_id ? 'with-images' : 'without-images' ),
		'woocommerce-product-gallery--columns-' . absint( $columns ),
		'images',
	)
);
?>
<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>"<?php echo $post_thumbnail_id ? ' style="opacity: 0; transition: opacity .25s ease-in-out;"' : ''; ?>>
	<figure class="woocommerce-product-gallery__wrapper">
		<?php
		if ( $post_thumbnail_id ) {
			$html = wc_get_gallery_image_html( $post_thumbnail_id, true );
			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			do_action( 'woocommerce_product_thumbnails' );
		} else {
			$storefront_variant = function_exists( 'desknest_storefront_get_product_visual_variant' )
				? desknest_storefront_get_product_visual_variant( $product )
				: 'generic';
			?>
			<div class="storefront-single-visual product-card-placeholder product-card-placeholder-<?php echo esc_attr( $storefront_variant ); ?>" aria-hidden="true">
				<?php echo desknest_storefront_product_visual( $storefront_variant ); ?>
				<span class="product-card-placeholder-mark"><?php echo esc_html( mb_substr( $product->get_name(), 0, 1 ) ); ?></span>
			</div>
			<?php
		}
		?>
	</figure>
</div>
