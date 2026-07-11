<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="main" class="storefront-main storefront-search-results">
	<div class="storefront-search-header">
		<h1>
			<?php
			printf(
				/* translators: %s: search query, already escaped */
				esc_html__( 'Search results for: %s', 'desknest-storefront' ),
				'<span>' . esc_html( get_search_query() ) . '</span>'
			);
			?>
		</h1>
	</div>

	<?php if ( have_posts() ) : ?>
		<ul class="product-grid">
			<?php
			while ( have_posts() ) :
				the_post();
				if ( 'product' === get_post_type() ) {
					get_template_part( 'template-parts/product-card' );
				} else {
					?>
					<li class="storefront-search-generic">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						<p><?php the_excerpt(); ?></p>
					</li>
					<?php
				}
			endwhile;
			?>
		</ul>
	<?php else : ?>
		<p><?php esc_html_e( 'No results found. Try a different search.', 'desknest-storefront' ); ?></p>
	<?php endif; ?>
</main>

<?php get_footer(); ?>
