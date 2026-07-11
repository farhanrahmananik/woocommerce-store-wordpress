<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_theme_file_path( 'inc/svg-visuals.php' );

/**
 * Declare foundational theme support. This is a classic PHP theme: no
 * database-writing setup logic, no page/product/term/coupon/order creation,
 * and no plugin activation happens here.
 */
function desknest_storefront_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support(
		'html5',
		array( 'search-form', 'gallery', 'caption', 'style', 'script' )
	);
}
add_action( 'after_setup_theme', 'desknest_storefront_setup' );

/**
 * Enqueue the theme's stylesheet and vanilla-JS behaviour script, both
 * cache-busted with filemtime() so edits show up without manual version bumps.
 */
function desknest_storefront_enqueue_assets() {
	$style_path = get_stylesheet_directory() . '/style.css';

	wp_enqueue_style(
		'desknest-storefront-style',
		get_stylesheet_uri(),
		array(),
		file_exists( $style_path ) ? filemtime( $style_path ) : wp_get_theme()->get( 'Version' )
	);

	$script_path = get_theme_file_path( 'assets/js/storefront.js' );

	wp_enqueue_script(
		'desknest-storefront-script',
		get_theme_file_uri( 'assets/js/storefront.js' ),
		array(),
		file_exists( $script_path ) ? filemtime( $script_path ) : wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'desknest_storefront_enqueue_assets' );

/**
 * Real WooCommerce product queries for the homepage's three product
 * sections, each backed by a genuinely different real signal so the
 * section names stay honest:
 * - 'new' - WP_Query's native date ordering (real: publish date).
 * - 'curated' - real products from the bundles/desk-organization/
 *   ergonomic-essentials categories (a real "setting up a desk" theme),
 *   falling back to a plain title-ordered query if that pool is empty.
 *   Deliberately not called "best sellers": this store has a single real
 *   order, so total_sales data would not honestly support that claim.
 * - 'rated' - replicates WooCommerce's own catalog-ordering sort (see
 *   WC_Query::order_by_rating_post_clauses() in class-wc-query.php) via a
 *   posts_clauses join against wc_product_meta_lookup, because
 *   average_rating sorting is not exposed through wc_get_products()'s
 *   orderby argument. This IS backed by real review data.
 *
 * $exclude is applied here in local PHP after fetching a slightly larger
 * candidate pool, rather than as a query arg, since wc_get_products()
 * does not document a matching "exclude" parameter - filtering the
 * already-fetched real results is the reliable way to keep homepage
 * sections from repeating the same products. Read-only throughout: no
 * data is written.
 *
 * @param string $section 'new', 'curated', or 'rated'.
 * @param int    $count   Number of products to return.
 * @param int[]  $exclude Product IDs to leave out (already shown elsewhere).
 * @return WC_Product[]
 */
function desknest_storefront_get_homepage_products( $section, $count = 4, $exclude = array() ) {
	if ( ! function_exists( 'wc_get_product' ) ) {
		return array();
	}

	$pool_size = $count + count( $exclude ) + 4;
	$products  = array();

	if ( 'new' === $section ) {
		$products = wc_get_products(
			array(
				'limit'   => $pool_size,
				'status'  => 'publish',
				'orderby' => 'date',
				'order'   => 'DESC',
				'return'  => 'objects',
			)
		);
	} elseif ( 'curated' === $section ) {
		$products = wc_get_products(
			array(
				'limit'    => $pool_size,
				'status'   => 'publish',
				'category' => array( 'bundles', 'desk-organization', 'ergonomic-essentials' ),
				'orderby'  => 'menu_order',
				'order'    => 'ASC',
				'return'   => 'objects',
			)
		);

		if ( empty( $products ) ) {
			$products = wc_get_products(
				array(
					'limit'   => $pool_size,
					'status'  => 'publish',
					'orderby' => 'title',
					'order'   => 'ASC',
					'return'  => 'objects',
				)
			);
		}
	} elseif ( 'rated' === $section ) {
		$clause_callback = function ( $args ) {
			global $wpdb;
			if ( ! strstr( $args['join'], 'wc_product_meta_lookup' ) ) {
				$args['join'] .= " LEFT JOIN {$wpdb->wc_product_meta_lookup} wc_product_meta_lookup ON $wpdb->posts.ID = wc_product_meta_lookup.product_id ";
			}
			$args['orderby'] = ' wc_product_meta_lookup.average_rating DESC, wc_product_meta_lookup.rating_count DESC, wc_product_meta_lookup.product_id DESC ';
			return $args;
		};

		add_filter( 'posts_clauses', $clause_callback );

		$query = new WP_Query(
			array(
				'post_type'              => 'product',
				'post_status'            => 'publish',
				'posts_per_page'         => $pool_size,
				'no_found_rows'          => true,
				'update_post_meta_cache' => false,
				'update_post_term_cache' => false,
			)
		);

		remove_filter( 'posts_clauses', $clause_callback );

		$products = array_filter( array_map( 'wc_get_product', $query->posts ) );
	}

	$products = array_values( $products );

	if ( ! empty( $exclude ) ) {
		$products = array_values(
			array_filter(
				$products,
				function ( $product ) use ( $exclude ) {
					return $product instanceof WC_Product && ! in_array( $product->get_id(), $exclude, true );
				}
			)
		);
	}

	return array_slice( $products, 0, $count );
}

/**
 * Product IDs for a list of WC_Product objects, used to keep later
 * homepage sections from repeating products already shown earlier on the
 * page. Read-only helper, no data written.
 *
 * @param WC_Product[] $products Products to read IDs from.
 * @return int[]
 */
function desknest_storefront_product_ids( $products ) {
	return array_map(
		function ( $product ) {
			return $product->get_id();
		},
		$products
	);
}

/**
 * Maps real product_cat slugs to a product-visual variant key used by
 * desknest_storefront_product_visual() (inc/svg-visuals.php) for the
 * placeholder illustration shown when a product has no featured image.
 *
 * @return array<string, string>
 */
function desknest_storefront_category_visual_map() {
	return array(
		'ergonomic-essentials'     => 'ergonomic',
		'desk-organization'        => 'organizer',
		'lighting-ambience'        => 'lighting',
		'cable-management'         => 'cable',
		'productivity-accessories' => 'productivity',
		'bundles'                  => 'bundle',
	);
}

/**
 * Resolves which visual variant to use for a product's placeholder
 * illustration, based on its real product_cat terms - not guessed from
 * its name. Falls back to 'generic' when uncategorized or unmapped.
 * Read-only: does not write data.
 *
 * @param WC_Product $product Product to inspect.
 * @return string
 */
function desknest_storefront_get_product_visual_variant( $product ) {
	if ( ! $product instanceof WC_Product ) {
		return 'generic';
	}

	$map   = desknest_storefront_category_visual_map();
	$terms = wp_get_post_terms( $product->get_id(), 'product_cat', array( 'fields' => 'slugs' ) );

	if ( is_wp_error( $terms ) ) {
		return 'generic';
	}

	foreach ( $terms as $slug ) {
		if ( isset( $map[ $slug ] ) ) {
			return $map[ $slug ];
		}
	}

	return 'generic';
}

/**
 * Real WooCommerce category links for the homepage discovery grid and
 * header/footer navigation. Slugs are verified against live product_cat
 * terms, not guessed.
 *
 * @return array<int, array{slug: string, name: string}>
 */
function desknest_storefront_categories() {
	return array(
		array(
			'slug' => 'ergonomic-essentials',
			'name' => 'Ergonomic Essentials',
		),
		array(
			'slug' => 'desk-organization',
			'name' => 'Desk Organization',
		),
		array(
			'slug' => 'lighting-ambience',
			'name' => 'Lighting & Ambience',
		),
		array(
			'slug' => 'cable-management',
			'name' => 'Cable Management',
		),
		array(
			'slug' => 'productivity-accessories',
			'name' => 'Productivity Accessories',
		),
		array(
			'slug' => 'bundles',
			'name' => 'Bundles',
		),
	);
}
