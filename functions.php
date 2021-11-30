<?php
// wp_enqueue_script( 'theme-script', '/wp-content/themes/vite-wordpress/main.js', array(), null, true );

add_action(
	'wp_enqueue_scripts',
	function() {
		$handle = 'ps-import-module-one-handle';
		$src    = 'http://localhost:3000/js/index.js';
		// $src     = get_stylesheet_directory_uri() . '/src/js/index.js';
		$deps    = array();
		$version = null;
		wp_enqueue_script( $handle, $src, $deps, $version, true );

	}
);

/**
 * Script that import modules must use a script tag with type="module",
 * so let's set it for the script.
 */
add_filter(
	'script_loader_tag',
	function ( $tag, $handle, $src ) {

		switch ( $handle ) {
			case 'ps-import-module-one-handle':
				return '<script type="module" crossorigin src="' . esc_url( $src ) . '"></script>'; //phpcs:ignore
			default:
				return $tag;
		}
	},
	10,
	3
);
