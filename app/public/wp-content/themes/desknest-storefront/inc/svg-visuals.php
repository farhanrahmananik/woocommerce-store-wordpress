<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Reusable, original inline SVG/CSS visual components for the DeskNest
 * Storefront theme (Scope 21 Step 4F, extended in Step 4G). Every shape
 * here is hand-authored theme presentation - no remote assets, no product
 * photography, no real brand references. Functions return trusted, static
 * markup strings (no user input is interpolated into the SVG itself), safe
 * to echo directly. These are pure presentational helpers: no database
 * reads or writes.
 *
 * Colour/gradient fills are applied entirely through CSS classes (see the
 * "Scope 21 Step 4G" section in style.css) rather than inline fill/stroke
 * attributes, so every shape stays on theme tokens and gradients defined
 * once in desknest_storefront_svg_defs() are reused everywhere without
 * duplicating <defs> per instance.
 */

/**
 * Shared, invisible SVG gradient definitions, output once per page
 * (header.php, right after wp_body_open()). Referenced by id from any
 * inline SVG on the page via CSS `fill: url(#dn-grad-...)`.
 *
 * @return string SVG markup.
 */
function desknest_storefront_svg_defs() {
	return '<svg width="0" height="0" style="position:absolute" aria-hidden="true" focusable="false">
		<defs>
			<linearGradient id="dn-grad-accent" x1="0%" y1="0%" x2="100%" y2="100%">
				<stop offset="0%" class="dn-grad-accent-a" />
				<stop offset="100%" class="dn-grad-accent-b" />
			</linearGradient>
			<linearGradient id="dn-grad-surface" x1="0%" y1="0%" x2="0%" y2="100%">
				<stop offset="0%" class="dn-grad-surface-a" />
				<stop offset="100%" class="dn-grad-surface-b" />
			</linearGradient>
			<radialGradient id="dn-grad-glow">
				<stop offset="0%" class="dn-grad-glow-a" />
				<stop offset="100%" class="dn-grad-glow-b" />
			</radialGradient>
		</defs>
	</svg>';
}

/**
 * Small geometric brand mark shown next to the "DeskNest" wordmark in the
 * header - an original nested rounded-square motif, not a text glyph.
 *
 * @return string SVG markup.
 */
function desknest_storefront_brand_mark() {
	return '<svg class="storefront-brand-mark" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
		<rect class="storefront-brand-mark-outer" x="3" y="3" width="26" height="26" rx="9" />
		<rect class="storefront-brand-mark-inner" x="11" y="11" width="10" height="10" rx="3.5" />
	</svg>';
}

/**
 * Small header utility icons (cart / account) - generic, universal
 * ecommerce icon concepts drawn as original path data.
 *
 * @param string $key 'cart' or 'account'.
 * @return string SVG markup, or '' for an unknown key.
 */
function desknest_storefront_utility_icon( $key ) {
	$icons = array(
		'cart'    => '<path d="M7 9 L9.5 26 H22.5 L25 9" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /><path d="M11 9 V7.5 a5 5 0 0 1 10 0 V9" fill="none" stroke-width="2" stroke-linecap="round" /><line x1="6" y1="9" x2="26" y2="9" stroke-width="2" stroke-linecap="round" />',
		'account' => '<circle cx="16" cy="11.5" r="5" fill="none" stroke-width="2" /><path d="M6 26.5 C6 19.5, 10.5 16.5, 16 16.5 C21.5 16.5, 26 19.5, 26 26.5" fill="none" stroke-width="2" stroke-linecap="round" />',
	);

	if ( ! isset( $icons[ $key ] ) ) {
		return '';
	}

	return '<svg class="storefront-utility-icon" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">' . $icons[ $key ] . '</svg>';
}

/**
 * Premium hero workspace illustration: layered background glow, desk
 * surface, monitor with screen detail, lamp with a soft light beam,
 * cable routing, organizer trays, and a small abstract accessory vessel.
 *
 * @return string SVG markup.
 */
function desknest_storefront_hero_illustration() {
	$label = esc_attr__( 'Abstract illustration of a DeskNest workspace with a monitor, desk lamp, organizer trays, and cable routing', 'desknest-storefront' );

	return '<svg class="storefront-hero-illustration" viewBox="0 0 320 240" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="' . $label . '">
		<rect class="sf-stage" x="6" y="6" width="308" height="228" rx="20" />
		<circle class="sf-halo sf-halo-a" cx="228" cy="80" r="128" />
		<circle class="sf-halo sf-halo-b" cx="54" cy="188" r="76" />
		<line class="sf-hanging-line" x1="272" y1="6" x2="272" y2="38" stroke-width="2" stroke-linecap="round" />
		<circle class="sf-hanging-orb" cx="272" cy="44" r="9" />
		<rect class="sf-mat" x="10" y="168" width="300" height="54" rx="14" />
		<rect class="sf-accessory" x="20" y="140" width="22" height="26" rx="8" />
		<path class="sf-accessory-detail" d="M24 140 C 21 128, 31 125, 32 137" fill="none" stroke-width="3" stroke-linecap="round" />
		<path class="sf-cable" d="M56 168 C 56 210, 108 210, 108 194 S 158 178, 158 210" fill="none" stroke-width="4.5" stroke-linecap="round" />
		<rect class="sf-organizer" x="234" y="136" width="30" height="34" rx="6" />
		<rect class="sf-organizer" x="268" y="148" width="24" height="24" rx="6" />
		<line class="sf-organizer-detail" x1="240" y1="150" x2="260" y2="150" stroke-width="2" stroke-linecap="round" />
		<rect class="sf-monitor-stand" x="150" y="128" width="12" height="40" rx="3" />
		<rect class="sf-monitor-base" x="112" y="166" width="88" height="9" rx="4.5" />
		<rect class="sf-monitor" x="78" y="34" width="160" height="96" rx="14" />
		<rect class="sf-monitor-screen" x="92" y="48" width="132" height="66" rx="6" />
		<line class="sf-monitor-detail" x1="104" y1="64" x2="176" y2="64" stroke-width="3.5" stroke-linecap="round" />
		<line class="sf-monitor-detail" x1="104" y1="80" x2="200" y2="80" stroke-width="3.5" stroke-linecap="round" />
		<line class="sf-monitor-detail" x1="104" y1="96" x2="152" y2="96" stroke-width="3.5" stroke-linecap="round" />
		<path class="sf-monitor-highlight" d="M188 48 L224 48 L224 92 Z" />
		<path class="sf-lamp-beam" d="M204 92 L172 178 L236 178 Z" />
		<line class="sf-lamp-arm" x1="270" y1="188" x2="254" y2="108" stroke-width="4.5" stroke-linecap="round" />
		<line class="sf-lamp-arm" x1="254" y1="108" x2="204" y2="80" stroke-width="4.5" stroke-linecap="round" />
		<circle class="sf-lamp-glow" cx="204" cy="78" r="28" />
		<path class="sf-lamp-head" d="M188 68 L220 68 L212 88 L196 88 Z" />
	</svg>';
}

/**
 * Category glyph shapes, keyed by real product_cat slug. Returns only the
 * inner shape markup (no outer <svg> wrapper) so callers can compose it
 * inside a badge. Falls back to a generic mark for an unknown slug.
 *
 * @param string $slug product_cat slug.
 * @return string SVG child markup.
 */
function desknest_storefront_category_icon_shapes( $slug ) {
	$shapes = array(
		'ergonomic-essentials'     => '<path d="M16 44 C16 30, 22 20, 32 20 C42 20, 48 30, 48 44" fill="none" stroke-width="4" stroke-linecap="round" /><line x1="16" y1="44" x2="48" y2="44" stroke-width="4" stroke-linecap="round" />',
		'desk-organization'        => '<rect x="12" y="16" width="40" height="10" rx="3" /><rect x="12" y="30" width="40" height="10" rx="3" /><rect x="12" y="44" width="24" height="10" rx="3" />',
		'lighting-ambience'        => '<circle cx="32" cy="26" r="14" /><line x1="26" y1="46" x2="38" y2="46" stroke-width="4" stroke-linecap="round" /><line x1="28" y1="52" x2="36" y2="52" stroke-width="4" stroke-linecap="round" />',
		'cable-management'         => '<path d="M14 20 C 14 40, 30 40, 30 30 S 46 20, 46 40" fill="none" stroke-width="4" stroke-linecap="round" />',
		'productivity-accessories' => '<circle cx="32" cy="32" r="16" fill="none" stroke-width="4" /><line x1="32" y1="32" x2="32" y2="22" stroke-width="3" stroke-linecap="round" /><line x1="32" y1="32" x2="39" y2="36" stroke-width="3" stroke-linecap="round" />',
		'bundles'                  => '<rect x="12" y="26" width="18" height="18" rx="3" /><rect x="34" y="26" width="18" height="18" rx="3" /><rect x="23" y="12" width="18" height="18" rx="3" />',
	);

	return $shapes[ $slug ] ?? '<circle cx="32" cy="32" r="14" fill="none" stroke-width="4" /><line x1="32" y1="40" x2="32" y2="48" stroke-width="4" stroke-linecap="round" />';
}

/**
 * Full category icon badge: a soft glow backdrop with the category glyph
 * centered on top. Used on the homepage discovery grid and promo banner.
 *
 * @param string $slug product_cat slug.
 * @return string SVG markup.
 */
function desknest_storefront_category_badge( $slug ) {
	$shapes = desknest_storefront_category_icon_shapes( $slug );

	return '<span class="storefront-card-icon">
		<svg class="storefront-card-icon-badge" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><circle cx="32" cy="32" r="30" /></svg>
		<svg class="storefront-card-shape" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">' . $shapes . '</svg>
	</span>';
}

/**
 * Product placeholder illustrations, keyed by visual variant. Each is an
 * original, layered abstract composition - soft backdrop glow, ground
 * shadow, a gradient-filled foreground object, and an accent detail - used
 * when a product has no featured image. The variant is chosen by
 * desknest_storefront_get_product_visual_variant() in functions.php based
 * on the product's real category, not guessed from its name.
 *
 * @param string $variant One of: ergonomic, organizer, lighting, cable,
 *                         productivity, bundle, generic.
 * @return string SVG markup.
 */
function desknest_storefront_product_visual( $variant ) {
	// Canvas is 128x96 (4:3, matching .product-card-media's aspect-ratio
	// exactly) so the illustration fills the card's visual area edge to
	// edge with no letterboxing, instead of sitting as a small centered
	// icon. Every variant composes across most of that width so the
	// object reads as a mini illustration, not a glyph.
	$variants = array(
		// Tiered riser/stand: three decreasing platforms plus a support
		// arc, reading clearly as a monitor stand or ergonomic riser.
		'ergonomic'    => '<rect class="ph-object" x="14" y="70" width="100" height="12" rx="5" />
			<rect class="ph-object" x="28" y="54" width="72" height="12" rx="5" />
			<rect class="ph-object-accent" x="42" y="38" width="44" height="12" rx="5" />
			<path class="ph-object-line" d="M52 38 C52 20, 60 10, 64 10 C68 10, 76 20, 76 38" stroke-width="5" stroke-linecap="round" />
			<ellipse class="ph-shadow" cx="64" cy="86" rx="48" ry="5" />',
		// A wide segmented storage tray (dividers, not stacked tiers)
		// holding three differently-shaped small items, so it reads as
		// "sorted compartments" rather than repeating the ergonomic
		// riser's stacked-platform silhouette.
		'organizer'    => '<rect class="ph-object" x="8" y="46" width="112" height="34" rx="8" />
			<line class="ph-detail" x1="42" y1="46" x2="42" y2="80" stroke-width="3" stroke-linecap="round" />
			<line class="ph-detail" x1="76" y1="46" x2="76" y2="80" stroke-width="3" stroke-linecap="round" />
			<circle class="ph-object-accent" cx="25" cy="63" r="10" />
			<circle class="ph-detail-dot" cx="59" cy="63" r="7" />
			<rect class="ph-object-accent" x="90" y="53" width="20" height="20" rx="5" />
			<ellipse class="ph-shadow" cx="64" cy="88" rx="48" ry="5" />',
		// Desk lamp: base, arm, a trapezoid shade (not a plain circle),
		// and a light beam cone for an unmistakable lamp silhouette.
		'lighting'     => '<rect class="ph-object" x="46" y="76" width="24" height="10" rx="4" />
			<line class="ph-detail" x1="58" y1="76" x2="58" y2="48" stroke-width="6" stroke-linecap="round" />
			<line class="ph-detail" x1="58" y1="48" x2="94" y2="24" stroke-width="6" stroke-linecap="round" />
			<path class="ph-beam" d="M94 34 L58 88 L120 88 Z" />
			<path class="ph-object-accent" d="M78 14 L114 14 L106 34 L88 34 Z" />
			<ellipse class="ph-shadow" cx="64" cy="88" rx="46" ry="5" />',
		// Cable tray with two woven cable strands feeding into it plus a
		// routing clip, reading as active cable management rather than
		// one abstract squiggle.
		'cable'        => '<rect class="ph-object" x="10" y="60" width="108" height="20" rx="8" />
			<path class="ph-object-line" d="M22 60 C22 32, 48 38, 48 20 S 80 8, 80 24 S 106 38, 106 60" stroke-width="6" stroke-linecap="round" />
			<path class="ph-object-line" d="M36 60 C36 44, 54 44, 54 32" stroke-width="4" stroke-linecap="round" />
			<rect class="ph-object-accent" x="46" y="53" width="20" height="13" rx="4" />
			<circle class="ph-detail-dot" cx="22" cy="60" r="4" />
			<circle class="ph-detail-dot" cx="106" cy="60" r="4" />
			<ellipse class="ph-shadow" cx="64" cy="86" rx="46" ry="5" />',
		// Document with a folded corner plus a timer dial with two clock
		// hands, reading clearly as notepad/timer rather than a plain
		// rectangle and dot.
		'productivity' => '<path class="ph-object" d="M18 8 H72 L94 26 V88 H18 Z" />
			<path class="ph-object-accent" d="M72 8 L72 26 L94 26 Z" />
			<line class="ph-detail" x1="30" y1="40" x2="72" y2="40" stroke-width="4" stroke-linecap="round" />
			<line class="ph-detail" x1="30" y1="52" x2="72" y2="52" stroke-width="4" stroke-linecap="round" />
			<line class="ph-detail" x1="30" y1="64" x2="58" y2="64" stroke-width="4" stroke-linecap="round" />
			<circle class="ph-object-accent" cx="104" cy="72" r="16" />
			<line class="ph-detail" x1="104" y1="72" x2="104" y2="60" stroke-width="2.5" stroke-linecap="round" />
			<line class="ph-detail" x1="104" y1="72" x2="112" y2="76" stroke-width="2.5" stroke-linecap="round" />
			<ellipse class="ph-shadow" cx="64" cy="90" rx="44" ry="5" />',
		// Three distinct item silhouettes (box, round item, accent
		// square) grouped together, reading as a bundle of different
		// desk items rather than three identical cubes.
		'bundle'       => '<rect class="ph-object" x="8" y="44" width="56" height="36" rx="8" />
			<circle class="ph-object" cx="102" cy="40" r="24" />
			<rect class="ph-object-accent" x="46" y="12" width="44" height="44" rx="8" />
			<line class="ph-detail" x1="18" y1="58" x2="54" y2="58" stroke-width="3" stroke-linecap="round" />
			<ellipse class="ph-shadow" cx="64" cy="88" rx="48" ry="5" />',
		// Neutral rounded desk accessory - kept as the fallback for any
		// product without a mapped category.
		'generic'      => '<rect class="ph-object" x="14" y="26" width="100" height="52" rx="14" />
			<circle class="ph-object-accent" cx="64" cy="52" r="20" />
			<line class="ph-detail" x1="30" y1="70" x2="98" y2="70" stroke-width="3" stroke-linecap="round" />
			<ellipse class="ph-shadow" cx="64" cy="88" rx="48" ry="6" />',
	);

	$inner = $variants[ $variant ] ?? $variants['generic'];
	$stage = '<rect class="ph-stage" x="2" y="2" width="124" height="92" rx="16" />';

	return '<svg class="product-card-placeholder-glyph" viewBox="0 0 128 96" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet">' . $stage . $inner . '</svg>';
}

/**
 * Editorial promo card shapes.
 *
 * @param string $variant 'cable' or 'frame'.
 * @return string SVG markup.
 */
function desknest_storefront_editorial_shape( $variant ) {
	if ( 'frame' === $variant ) {
		return '<svg class="storefront-editorial-shape" viewBox="0 0 120 80" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><rect x="14" y="16" width="92" height="48" rx="8" fill="none" stroke-width="5" /><line x1="14" y1="34" x2="106" y2="34" stroke-width="4" /><circle cx="26" cy="25" r="3" /></svg>';
	}

	return '<svg class="storefront-editorial-shape" viewBox="0 0 120 80" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M10 60 C 10 20, 60 20, 60 45 S 110 60, 110 20" fill="none" stroke-width="5" stroke-linecap="round" /><circle cx="10" cy="60" r="4" /><circle cx="110" cy="20" r="4" /></svg>';
}
