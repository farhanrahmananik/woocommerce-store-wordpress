<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="main" class="storefront-main">
	<?php if ( have_posts() ) : ?>
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<article <?php post_class( 'storefront-entry' ); ?>>
				<h2 class="storefront-entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<div class="storefront-entry-content"><?php the_excerpt(); ?></div>
			</article>
		<?php endwhile; ?>
	<?php else : ?>
		<p><?php esc_html_e( 'Nothing found.', 'desknest-storefront' ); ?></p>
	<?php endif; ?>
</main>

<?php get_footer(); ?>
