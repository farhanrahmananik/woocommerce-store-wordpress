<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Declare foundational theme support. No menus or WooCommerce template
 * overrides are registered at this stage.
 */
function desknest_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'desknest_setup' );

/**
 * Enqueue the theme's own stylesheet. Block themes are not automatically
 * given this by WordPress core.
 */
function desknest_enqueue_styles() {
	$style_path = get_stylesheet_directory() . '/style.css';

	wp_enqueue_style(
		'desknest-style',
		get_stylesheet_uri(),
		array(),
		file_exists( $style_path ) ? filemtime( $style_path ) : wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'desknest_enqueue_styles' );
