<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="main" class="storefront-main storefront-404">
	<h1><?php esc_html_e( 'Page not found', 'desknest-storefront' ); ?></h1>
	<p><?php esc_html_e( 'The page you were looking for could not be found. It may have been moved or no longer exists.', 'desknest-storefront' ); ?></p>
	<p class="storefront-404-actions">
		<a class="storefront-button" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to home', 'desknest-storefront' ); ?></a>
		<a class="storefront-button storefront-button-outline" href="<?php echo esc_url( home_url( '/shop/' ) ); ?>"><?php esc_html_e( 'Browse the shop', 'desknest-storefront' ); ?></a>
	</p>
</main>

<?php get_footer(); ?>
