<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WooCommerce template override for the product archive family (Scope
 * 21 Step 5A) - yourtheme/woocommerce/archive-product.php is
 * WooCommerce's own documented, most specific override location for
 * this template, checked ahead of a theme-root archive-product.php or a
 * generic woocommerce.php wrapper. This file exists specifically because
 * the previous attempt (theme-root archive-product.php only) did not
 * reliably take effect for /shop/ in this environment; theme-root
 * archive-product.php and woocommerce.php were both also updated the
 * same way as a safety net, so whichever file WooCommerce's loader
 * actually resolves to still renders the same custom design.
 *
 * The Shop page (is_shop()) and, since Scope 21 Step 5B, product category
 * archives (is_product_category()) both get the custom DeskNest layout via
 * the shared template-parts/shop-archive.php body, which adapts its hero to
 * each context. Category archives normally resolve to this theme's own
 * taxonomy-product_cat.php first (which renders the same shared part), so
 * this file's is_product_category() branch is a safety net for any setup
 * where they route here instead. Any other product archive (e.g. a product
 * tag - this theme has no taxonomy-product_tag.php) falls through to the
 * "else" branch below, which reproduces WooCommerce's own default
 * archive-product.php hook sequence directly - not a call back into this
 * file, so there is no template_include recursion.
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
