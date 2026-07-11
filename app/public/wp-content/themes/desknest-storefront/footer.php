<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
	<footer class="storefront-footer">
		<div class="storefront-footer-columns">
			<div class="storefront-footer-column">
				<h4><?php esc_html_e( 'DeskNest', 'desknest-storefront' ); ?></h4>
				<p><?php esc_html_e( 'Practical, well-designed accessories for a calmer, more productive desk setup.', 'desknest-storefront' ); ?></p>
				<p><?php esc_html_e( 'Curated for the German market — EUR pricing, Germany-focused shipping.', 'desknest-storefront' ); ?></p>
			</div>

			<div class="storefront-footer-column">
				<h4><?php esc_html_e( 'Shop', 'desknest-storefront' ); ?></h4>
				<ul>
					<li><a href="<?php echo esc_url( home_url( '/shop/' ) ); ?>"><?php esc_html_e( 'All Products', 'desknest-storefront' ); ?></a></li>
					<?php foreach ( desknest_storefront_categories() as $category ) : ?>
						<li><a href="<?php echo esc_url( home_url( '/product-category/' . $category['slug'] . '/' ) ); ?>"><?php echo esc_html( $category['name'] ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>

			<div class="storefront-footer-column">
				<h4><?php esc_html_e( 'Customer', 'desknest-storefront' ); ?></h4>
				<ul>
					<li><a href="<?php echo esc_url( home_url( '/cart/' ) ); ?>"><?php esc_html_e( 'Cart', 'desknest-storefront' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/checkout/' ) ); ?>"><?php esc_html_e( 'Checkout', 'desknest-storefront' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/my-account/' ) ); ?>"><?php esc_html_e( 'My Account', 'desknest-storefront' ); ?></a></li>
				</ul>
			</div>

			<div class="storefront-footer-column">
				<h4><?php esc_html_e( 'Store Info', 'desknest-storefront' ); ?></h4>
				<p class="storefront-footer-note"><?php esc_html_e( 'DeskNest is a local WooCommerce portfolio project. No real payment is processed and no real fulfilment occurs.', 'desknest-storefront' ); ?></p>
			</div>
		</div>

		<p class="storefront-footer-copyright">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php esc_html_e( 'DeskNest. All rights reserved.', 'desknest-storefront' ); ?></p>
	</footer>

<?php wp_footer(); ?>
</body>
</html>
