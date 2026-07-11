<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php echo desknest_storefront_svg_defs(); ?>

<a class="storefront-skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'desknest-storefront' ); ?></a>

<header class="storefront-header">
	<div class="storefront-header-top">
		<div class="storefront-brand">
			<!--
				Static brand wordmark instead of the database site title: this
				site's blogname option is the technical name
				"woocommerce-store-wordpress", not "DeskNest". Fixed here in
				theme markup only, per instruction - the database site title
				was not changed.
			-->
			<p class="storefront-brand-name">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php echo desknest_storefront_brand_mark(); ?>
					<span>DeskNest</span>
				</a>
			</p>
			<p class="storefront-tagline"><?php esc_html_e( 'Germany-first desk setup essentials', 'desknest-storefront' ); ?></p>
		</div>

		<div class="storefront-header-actions">
			<div class="storefront-search">
				<?php get_search_form(); ?>
			</div>

			<nav class="storefront-utility-nav" aria-label="<?php esc_attr_e( 'Customer', 'desknest-storefront' ); ?>">
				<a class="storefront-utility-link" href="<?php echo esc_url( home_url( '/cart/' ) ); ?>">
					<?php echo desknest_storefront_utility_icon( 'cart' ); ?>
					<span><?php esc_html_e( 'Cart', 'desknest-storefront' ); ?></span>
				</a>
				<a class="storefront-utility-link" href="<?php echo esc_url( home_url( '/my-account/' ) ); ?>">
					<?php echo desknest_storefront_utility_icon( 'account' ); ?>
					<span><?php esc_html_e( 'Account', 'desknest-storefront' ); ?></span>
				</a>
			</nav>

			<button
				type="button"
				class="storefront-menu-toggle"
				aria-expanded="false"
				aria-controls="storefront-primary-navigation"
			>
				<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'desknest-storefront' ); ?></span>
				<span class="storefront-menu-toggle-bars" aria-hidden="true"></span>
			</button>
		</div>
	</div>

	<nav id="storefront-primary-navigation" class="storefront-primary-nav" aria-label="<?php esc_attr_e( 'Primary', 'desknest-storefront' ); ?>">
		<a href="<?php echo esc_url( home_url( '/shop/' ) ); ?>"><?php esc_html_e( 'Shop', 'desknest-storefront' ); ?></a>
		<a href="<?php echo esc_url( home_url( '/product-category/ergonomic-essentials/' ) ); ?>"><?php esc_html_e( 'Ergonomics', 'desknest-storefront' ); ?></a>
		<a href="<?php echo esc_url( home_url( '/product-category/lighting-ambience/' ) ); ?>"><?php esc_html_e( 'Lighting', 'desknest-storefront' ); ?></a>
		<a href="<?php echo esc_url( home_url( '/product-category/cable-management/' ) ); ?>"><?php esc_html_e( 'Cable Management', 'desknest-storefront' ); ?></a>
		<a href="<?php echo esc_url( home_url( '/product-category/bundles/' ) ); ?>"><?php esc_html_e( 'Bundles', 'desknest-storefront' ); ?></a>
	</nav>
</header>
