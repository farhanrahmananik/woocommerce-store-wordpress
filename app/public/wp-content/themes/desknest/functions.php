<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Declare foundational theme support only. No enqueues, menus, or
 * WooCommerce template overrides are registered at this stage.
 */
function desknest_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'desknest_setup' );
