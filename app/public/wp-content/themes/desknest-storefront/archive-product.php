<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme-root product archive template (Scope 21 Step 5A), kept as a
 * safety net alongside woocommerce/archive-product.php (WooCommerce's
 * more specific, preferred override location) and the is_shop() branch
 * added to woocommerce.php, since a prior attempt with only this file
 * present did not reliably take effect for /shop/ in this environment.
 * Whichever of the three WooCommerce's template loader actually resolves
 * to, the result is the same custom DeskNest shop design.
 *
 * The Shop page (is_shop()) and, since Scope 21 Step 5B, product category
 * archives (is_product_category()) both get the custom layout via the
 * shared template-parts/shop-archive.php body. Category archives normally
 * resolve to this theme's own taxonomy-product_cat.php first (which renders
 * the same shared part); the is_product_category() branch here is a safety
 * net for any setup that routes them to this file instead. Any other
 * product archive falls through to the "else" branch, which reproduces
 * WooCommerce's own default archive-product.php hook sequence directly
 * (not a call back into this file, so no template_include recursion).
 */

get_header();

if ( is_shop() || is_product_category() ) {

	get_template_part( 'template-parts/shop-archive' );

} else {

	do_action( 'woocommerce_before_main_content' );

	if ( woocommerce_product_loop() ) {
		do_action( 'woocommerce_before_shop_loop' );
		woocommerce_product_loop_start();
		if ( wc_get_loop_prop( 'total' ) ) {
			while ( have_posts() ) {
				the_post();
				do_action( 'woocommerce_shop_loop' );
				wc_get_template_part( 'content', 'product' );
			}
		}
		woocommerce_product_loop_end();
		do_action( 'woocommerce_after_shop_loop' );
	} else {
		do_action( 'woocommerce_no_products_found' );
	}

	do_action( 'woocommerce_after_main_content' );

}

get_footer();
