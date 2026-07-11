<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme WooCommerce wrapper.
 *
 * ROOT-CAUSE NOTE (Scope 21 Step 5B Repair): because this theme provides a
 * root woocommerce.php, WooCommerce's template loader
 * (WC_Template_Loader::get_template_loader_files()) lists 'woocommerce.php'
 * as the FIRST candidate for every product archive - ahead of
 * taxonomy-product_cat.php, archive-product.php and their woocommerce/
 * counterparts. locate_template() returns the first candidate that exists,
 * so THIS file - not taxonomy-product_cat.php - is what actually renders
 * /shop/ AND product category archives. That is exactly why the earlier
 * Step 5B taxonomy-product_cat.php rewrite never took effect for
 * /product-category/...: it is a lower-priority candidate that is never
 * reached while this file exists, and category requests were falling into
 * the else branch below (default woocommerce_content()), which is the
 * default WooCommerce archive markup the browser was still showing.
 *
 * Routing therefore lives here, as the single reliable render path:
 * - is_shop() OR is_product_category() -> the shared, approved DeskNest
 *   archive body (template-parts/shop-archive.php), which adapts its hero
 *   to shop vs. the current real category. This makes /shop/ and every
 *   product category render identically.
 * - everything else keeps the EXACT original behaviour: the theme header/
 *   footer around woocommerce_content() via the documented
 *   woocommerce_before/after_main_content hooks. Single product pages and
 *   product tag archives stay on that default path unchanged; cart,
 *   checkout and account are ordinary pages rendered by page.php and never
 *   reach this file at all.
 */

get_header();

if ( is_shop() || is_product_category() ) {

	get_template_part( 'template-parts/shop-archive' );

} else {

	do_action( 'woocommerce_before_main_content' );

	woocommerce_content();

	do_action( 'woocommerce_after_main_content' );

}

get_footer();
