<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shared custom archive body for /shop/ AND product category archives
 * (Scope 21 Step 5A for shop; extended to categories in Step 5B) - hero,
 * toolbar, product grid, pagination, empty state. get_header()/
 * get_footer() are called by whichever top-level template includes this
 * part: the shop archive templates (woocommerce/archive-product.php,
 * archive-product.php, woocommerce.php - all check is_shop()) and, for
 * category archives, taxonomy-product_cat.php. One shared body keeps
 * /shop/ and every product category visually and behaviourally identical
 * - the same DeskNest cards/placeholders, green buttons, custom sorting
 * dropdown (assets/js/storefront.js targets .storefront-shop-ordering,
 * which is rendered here for both contexts) and pagination.
 *
 * Reuses template-parts/product-card.php and .product-grid unchanged
 * (real image-or-SVG visual, 2-line title clamp, compact rating, price,
 * add-to-cart/select-options behaviour already used on the homepage and
 * shop), and the real main WooCommerce query via the global
 * have_posts()/the_post() loop, so category filtering, sorting and
 * pagination all keep working. wc_setup_loop() is WooCommerce's
 * documented API for priming the result-count/ordering widgets from that
 * real query when a theme builds its own loop instead of the default
 * woocommerce_before_shop_loop hook sequence.
 *
 * The hero adapts by context: /shop/ keeps its approved title/copy/count
 * exactly; a product category shows the real term name, its real
 * description (or a clean, non-fabricated fallback line when the term has
 * none) and its real product count. Nothing is hardcoded to a specific
 * category.
 */

if ( function_exists( 'wc_setup_loop' ) ) {
	wc_setup_loop( array( 'name' => 'product' ) );
}

$storefront_is_category = function_exists( 'is_product_category' ) && is_product_category();
$storefront_term        = $storefront_is_category ? get_queried_object() : null;
$storefront_term        = ( $storefront_term instanceof WP_Term ) ? $storefront_term : null;
$storefront_post_type   = get_query_var( 'post_type' );
$storefront_is_search   = is_search() && ( 'product' === $storefront_post_type || ( is_array( $storefront_post_type ) && in_array( 'product', $storefront_post_type, true ) ) );
$storefront_search      = $storefront_is_search ? trim( (string) get_search_query( false ) ) : '';

if ( $storefront_is_search ) {
	global $wp_query;

	$storefront_eyebrow = __( 'Search', 'desknest-storefront' );
	$storefront_total   = isset( $wp_query->found_posts ) ? (int) $wp_query->found_posts : 0;
	$storefront_title   = $storefront_total > 0
		? sprintf(
			/* translators: %s: active product search query */
			__( 'Search results for "%s"', 'desknest-storefront' ),
			$storefront_search
		)
		: sprintf(
			/* translators: %s: active product search query */
			__( 'No products found for "%s"', 'desknest-storefront' ),
			$storefront_search
		);
} elseif ( $storefront_is_category && $storefront_term ) {
	$storefront_eyebrow = __( 'Category', 'desknest-storefront' );
	$storefront_title   = $storefront_term->name;
	$storefront_total   = (int) $storefront_term->count;
} else {
	// /shop/ (or any non-category product archive that reaches this part):
	// keep the approved shop hero title/copy/count behaviour unchanged.
	$storefront_is_category = false;
	$storefront_eyebrow     = __( 'Shop', 'desknest-storefront' );
	$storefront_title       = __( 'Shop DeskNest', 'desknest-storefront' );
	$storefront_shop_counts = wp_count_posts( 'product' );
	$storefront_total       = isset( $storefront_shop_counts->publish ) ? (int) $storefront_shop_counts->publish : 0;
}
?>

<main id="main" class="storefront-main storefront-shop">
	<!-- DeskNest shared shop archive -->

	<section class="storefront-shop-hero">
		<p class="storefront-shop-eyebrow"><?php echo esc_html( $storefront_eyebrow ); ?></p>
		<h1><?php echo esc_html( $storefront_title ); ?></h1>

		<?php if ( $storefront_is_search ) : ?>
			<p class="storefront-shop-lead">
				<?php
				echo esc_html(
					$storefront_total > 0
						? __( 'Showing DeskNest products that match your search.', 'desknest-storefront' )
						: __( 'Try a different product name, category, or desk setup need.', 'desknest-storefront' )
				);
				?>
			</p>
		<?php elseif ( $storefront_is_category ) : ?>
			<?php if ( '' !== trim( (string) $storefront_term->description ) ) : ?>
				<div class="storefront-shop-lead">
					<?php echo wp_kses_post( wpautop( $storefront_term->description ) ); ?>
				</div>
			<?php else : ?>
				<p class="storefront-shop-lead">
					<?php
					echo esc_html(
						sprintf(
							/* translators: %s: product category name */
							__( 'Browse the DeskNest %s collection.', 'desknest-storefront' ),
							$storefront_title
						)
					);
					?>
				</p>
			<?php endif; ?>
		<?php else : ?>
			<p class="storefront-shop-lead">
				<?php esc_html_e( 'Browse practical desk accessories, organization tools, lighting, cable management, and productivity essentials.', 'desknest-storefront' ); ?>
			</p>
		<?php endif; ?>

		<?php if ( $storefront_is_search || $storefront_total > 0 ) : ?>
			<p class="storefront-shop-meta">
				<?php
				echo esc_html(
					$storefront_is_search
						? sprintf(
							/* translators: %s: number of matching products, already formatted */
							_n( '%s product found', '%s products found', $storefront_total, 'desknest-storefront' ),
							number_format_i18n( $storefront_total )
						)
						: sprintf(
							/* translators: %s: number of products, already formatted */
							_n( '%s product available', '%s products available', $storefront_total, 'desknest-storefront' ),
							number_format_i18n( $storefront_total )
						)
				);
				?>
			</p>
		<?php endif; ?>
	</section>

	<?php if ( function_exists( 'wc_notice_count' ) && wc_notice_count() > 0 ) : ?>
		<div class="storefront-shop-notices">
			<?php wc_print_notices(); ?>
		</div>
	<?php endif; ?>

	<?php if ( have_posts() ) : ?>

		<div class="storefront-shop-toolbar">
			<?php if ( function_exists( 'woocommerce_result_count' ) ) : ?>
				<div class="storefront-shop-result-count">
					<?php woocommerce_result_count(); ?>
				</div>
			<?php endif; ?>
			<?php if ( function_exists( 'woocommerce_catalog_ordering' ) ) : ?>
				<div class="storefront-shop-ordering">
					<?php woocommerce_catalog_ordering(); ?>
				</div>
			<?php endif; ?>
		</div>

		<ul class="product-grid storefront-shop-grid">
			<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/product-card' );
			endwhile;
			?>
		</ul>

		<?php if ( function_exists( 'woocommerce_pagination' ) ) : ?>
			<div class="storefront-shop-pagination">
				<?php woocommerce_pagination(); ?>
			</div>
		<?php endif; ?>

	<?php else : ?>

		<div class="storefront-shop-empty">
			<h2><?php esc_html_e( 'No products found', 'desknest-storefront' ); ?></h2>
			<p>
				<?php
				echo esc_html(
					$storefront_is_search
						? __( 'No DeskNest products matched that search. Try a broader term or browse the full shop.', 'desknest-storefront' )
						: __( 'There is nothing to show here right now. Check back soon.', 'desknest-storefront' )
				);
				?>
			</p>
			<a class="storefront-button" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to homepage', 'desknest-storefront' ); ?></a>
		</div>

	<?php endif; ?>

</main>

<?php
if ( function_exists( 'wc_reset_loop' ) ) {
	wc_reset_loop();
}
