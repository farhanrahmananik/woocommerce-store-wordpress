<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Small reusable "Title ... View shop ->" row used above the homepage
 * product sections. Expects $args: title (string), link_url (string),
 * link_text (string).
 */

$title     = $args['title'] ?? '';
$link_url  = $args['link_url'] ?? '';
$link_text = $args['link_text'] ?? '';

if ( '' === $title ) {
	return;
}
?>
<div class="storefront-section-header">
	<h2><?php echo esc_html( $title ); ?></h2>
	<?php if ( $link_url && $link_text ) : ?>
		<p class="storefront-section-cta"><a href="<?php echo esc_url( $link_url ); ?>"><?php echo esc_html( $link_text ); ?></a></p>
	<?php endif; ?>
</div>
