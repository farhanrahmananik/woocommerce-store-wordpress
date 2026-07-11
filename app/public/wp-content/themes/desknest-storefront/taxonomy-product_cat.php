<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Product category archive (Scope 21 Step 5B).
 *
 * Category archives now share the exact approved /shop/ layout: this
 * template simply wraps the shared template-parts/shop-archive.php body
 * (which detects is_product_category() and adapts its hero to the real
 * term name/description/count) with the theme header/footer, the same way
 * the shop archive templates do. This replaces Step 5's separate
 * .storefront-archive-* markup so every product category is visually and
 * behaviourally identical to /shop/ - same hero, toolbar + custom sorting
 * dropdown, product grid, DeskNest product cards/placeholders, green
 * buttons and pagination - with no divergent second archive system to
 * keep in sync. The real product_cat query, sorting and product data are
 * untouched (read-only rendering).
 */

get_header();
get_template_part( 'template-parts/shop-archive' );
get_footer();
