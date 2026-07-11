<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<form role="search" method="get" class="storefront-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="storefront-search-field" class="screen-reader-text"><?php esc_html_e( 'Search products', 'desknest-storefront' ); ?></label>
	<input
		type="search"
		id="storefront-search-field"
		class="storefront-search-field"
		placeholder="<?php echo esc_attr_x( 'Search products…', 'placeholder', 'desknest-storefront' ); ?>"
		value="<?php echo esc_attr( get_search_query() ); ?>"
		name="s"
	/>
	<input type="hidden" name="post_type" value="product" />
	<button type="submit" class="storefront-search-submit">
		<span class="screen-reader-text"><?php esc_html_e( 'Search', 'desknest-storefront' ); ?></span>
		<span aria-hidden="true">&rarr;</span>
	</button>
</form>
