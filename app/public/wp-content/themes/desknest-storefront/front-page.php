<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$collection_descriptions = array(
	'ergonomic-essentials'     => __( 'Stands, footrests, and posture-friendly accessories.', 'desknest-storefront' ),
	'desk-organization'        => __( 'Trays, organizers, and storage for a tidier surface.', 'desknest-storefront' ),
	'lighting-ambience'        => __( 'Desk lamps and ambient lighting for focused work.', 'desknest-storefront' ),
	'cable-management'         => __( 'Clips, sleeves, and routing kits for clean cable control.', 'desknest-storefront' ),
	'productivity-accessories' => __( 'Timers, notepads, and small tools that support focused work.', 'desknest-storefront' ),
	'bundles'                  => __( 'Grouped essentials for starting or refreshing a setup.', 'desknest-storefront' ),
);

// Fetch the three homepage product sections so each later section can
// exclude products already shown earlier on the page, keeping the
// homepage from repeating the same handful of products three times.
$new_arrivals  = desknest_storefront_get_homepage_products( 'new', 4 );
$shown_ids     = desknest_storefront_product_ids( $new_arrivals );
$curated_picks = desknest_storefront_get_homepage_products( 'curated', 5, $shown_ids );
$shown_ids     = array_merge( $shown_ids, desknest_storefront_product_ids( $curated_picks ) );
$rated_picks   = desknest_storefront_get_homepage_products( 'rated', 4, $shown_ids );
?>

<main id="main" class="storefront-home">

	<section class="storefront-hero storefront-band">
		<div class="storefront-band-inner storefront-hero-inner">
			<div class="storefront-hero-copy">
				<p class="storefront-hero-eyebrow"><?php esc_html_e( 'DESKNEST WORKSPACE ESSENTIALS', 'desknest-storefront' ); ?></p>
				<h1><?php esc_html_e( 'Build a calmer, cleaner desk setup.', 'desknest-storefront' ); ?></h1>
				<p class="storefront-hero-lead"><?php esc_html_e( 'A Germany-first WooCommerce store for practical desk accessories, organization tools, lighting, cable management, and productivity essentials.', 'desknest-storefront' ); ?></p>
				<div class="storefront-hero-buttons">
					<a class="storefront-button" href="<?php echo esc_url( home_url( '/shop/' ) ); ?>"><?php esc_html_e( 'Shop all products', 'desknest-storefront' ); ?></a>
					<a class="storefront-button storefront-button-outline" href="<?php echo esc_url( '#collections' ); ?>"><?php esc_html_e( 'Explore collections', 'desknest-storefront' ); ?></a>
				</div>
			</div>

			<div class="storefront-hero-visual">
				<div class="storefront-hero-visual-frame">
					<?php echo desknest_storefront_hero_illustration(); ?>
				</div>
			</div>
		</div>
	</section>

	<section class="storefront-collections" id="collections">
		<h2><?php esc_html_e( 'Shop by workspace need', 'desknest-storefront' ); ?></h2>

		<div class="storefront-collections-grid">
			<?php foreach ( desknest_storefront_categories() as $category ) : ?>
				<a class="storefront-collection-card" href="<?php echo esc_url( home_url( '/product-category/' . $category['slug'] . '/' ) ); ?>">
					<?php echo desknest_storefront_category_badge( $category['slug'] ); ?>
					<p class="storefront-collection-label"><?php esc_html_e( 'CATEGORY', 'desknest-storefront' ); ?></p>
					<h3><?php echo esc_html( $category['name'] ); ?></h3>
					<p class="storefront-collection-description"><?php echo esc_html( $collection_descriptions[ $category['slug'] ] ?? '' ); ?></p>
					<span class="storefront-collection-link"><?php esc_html_e( 'Explore', 'desknest-storefront' ); ?> <span class="storefront-collection-arrow" aria-hidden="true">&rarr;</span></span>
				</a>
			<?php endforeach; ?>
		</div>
	</section>

	<section class="storefront-product-section">
		<?php
		get_template_part(
			'template-parts/section-header',
			null,
			array(
				'title'     => __( 'New arrivals', 'desknest-storefront' ),
				'link_url'  => home_url( '/shop/' ),
				'link_text' => __( 'View shop', 'desknest-storefront' ) . ' →',
			)
		);
		?>
		<ul class="product-grid">
			<?php foreach ( $new_arrivals as $product ) : ?>
				<?php get_template_part( 'template-parts/product-card', null, array( 'product' => $product ) ); ?>
			<?php endforeach; ?>
		</ul>
	</section>

	<section class="storefront-promo-banner storefront-band">
		<div class="storefront-band-inner storefront-promo-banner-inner">
			<div class="storefront-promo-banner-content">
				<?php echo desknest_storefront_category_badge( 'bundles' ); ?>
				<div class="storefront-promo-banner-text">
					<p class="storefront-promo-banner-eyebrow"><?php esc_html_e( 'Bundles', 'desknest-storefront' ); ?></p>
					<h3><?php esc_html_e( 'Starter and refresh bundles, grouped for you', 'desknest-storefront' ); ?></h3>
					<p><?php esc_html_e( 'Grouped essentials picked to get a workspace sorted in a single order.', 'desknest-storefront' ); ?></p>
				</div>
			</div>
			<a class="storefront-button storefront-button-outline" href="<?php echo esc_url( home_url( '/product-category/bundles/' ) ); ?>"><?php esc_html_e( 'Shop bundles', 'desknest-storefront' ); ?></a>
		</div>
	</section>

	<section class="storefront-product-section storefront-product-section-featured">
		<?php
		get_template_part(
			'template-parts/section-header',
			null,
			array(
				'title'     => __( 'Desk Setup Picks', 'desknest-storefront' ),
				'link_url'  => home_url( '/shop/' ),
				'link_text' => __( 'View shop', 'desknest-storefront' ) . ' →',
			)
		);
		?>
		<?php
		$featured_pick   = $curated_picks[0] ?? null;
		// Up to 4 real products for a 2x2 grid; if the store only has 3
		// available here, the grid's :nth-child(3):last-child CSS fallback
		// spans that 3rd card full width rather than faking a 4th product.
		$secondary_picks = array_slice( $curated_picks, 1, 4 );
		?>
		<?php if ( $featured_pick ) : ?>
			<ul class="storefront-mixed-grid">
				<?php get_template_part( 'template-parts/product-card', null, array( 'product' => $featured_pick, 'layout' => 'featured' ) ); ?>
				<?php if ( $secondary_picks ) : ?>
					<li class="storefront-mixed-grid-secondary">
						<ul class="storefront-mixed-grid-secondary-list">
							<?php foreach ( $secondary_picks as $product ) : ?>
								<?php get_template_part( 'template-parts/product-card', null, array( 'product' => $product, 'layout' => 'compact' ) ); ?>
							<?php endforeach; ?>
						</ul>
					</li>
				<?php endif; ?>
			</ul>
		<?php endif; ?>
	</section>

	<section class="storefront-editorial">
		<div class="storefront-editorial-card storefront-editorial-accent">
			<?php echo desknest_storefront_editorial_shape( 'cable' ); ?>
			<h3><?php esc_html_e( 'Cleaner cables, calmer focus', 'desknest-storefront' ); ?></h3>
			<p><?php esc_html_e( 'Cable kits and desk organization products chosen for everyday workspace clarity, not clutter.', 'desknest-storefront' ); ?></p>
			<a class="storefront-button storefront-button-outline" href="<?php echo esc_url( home_url( '/product-category/cable-management/' ) ); ?>"><?php esc_html_e( 'Shop cable management', 'desknest-storefront' ); ?></a>
		</div>

		<div class="storefront-editorial-card storefront-editorial-light">
			<?php echo desknest_storefront_editorial_shape( 'frame' ); ?>
			<h3><?php esc_html_e( 'A practical setup from first browse to checkout', 'desknest-storefront' ); ?></h3>
			<p><?php esc_html_e( 'The store demonstrates product browsing, stock states, reviews, cart, checkout, payment, and shipping configuration in a local portfolio build.', 'desknest-storefront' ); ?></p>
			<a class="storefront-button" href="<?php echo esc_url( home_url( '/shop/' ) ); ?>"><?php esc_html_e( 'Open the shop', 'desknest-storefront' ); ?></a>
		</div>
	</section>

	<section class="storefront-product-section storefront-rated-panel">
		<?php
		get_template_part(
			'template-parts/section-header',
			null,
			array(
				'title'     => __( 'Rated Workspace Picks', 'desknest-storefront' ),
				'link_url'  => home_url( '/shop/' ),
				'link_text' => __( 'View shop', 'desknest-storefront' ) . ' →',
			)
		);
		?>
		<ul class="storefront-compact-list">
			<?php foreach ( $rated_picks as $product ) : ?>
				<?php get_template_part( 'template-parts/product-card', null, array( 'product' => $product, 'layout' => 'compact' ) ); ?>
			<?php endforeach; ?>
		</ul>
	</section>

	<section class="storefront-final-cta storefront-band">
		<div class="storefront-band-inner">
			<h2><?php esc_html_e( 'Build your DeskNest setup', 'desknest-storefront' ); ?></h2>
			<p><?php esc_html_e( 'Ergonomic essentials, lighting, cable management, and productivity accessories - browse the full catalogue or start from a grouped bundle.', 'desknest-storefront' ); ?></p>
			<div class="storefront-final-cta-buttons">
				<a class="storefront-button" href="<?php echo esc_url( home_url( '/shop/' ) ); ?>"><?php esc_html_e( 'Shop all products', 'desknest-storefront' ); ?></a>
				<a class="storefront-button storefront-button-outline" href="<?php echo esc_url( home_url( '/product-category/ergonomic-essentials/' ) ); ?>"><?php esc_html_e( 'Shop ergonomics', 'desknest-storefront' ); ?></a>
			</div>
		</div>
	</section>

</main>

<?php get_footer(); ?>
