<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="main" class="storefront-main storefront-page">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article <?php post_class( 'storefront-page-entry' ); ?>>
			<h1 class="storefront-page-title"><?php the_title(); ?></h1>
			<div class="storefront-page-content"><?php the_content(); ?></div>
		</article>
	<?php endwhile; ?>
</main>

<?php get_footer(); ?>
