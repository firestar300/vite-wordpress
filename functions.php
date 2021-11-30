<?php
if ( defined( 'WP_ENV' ) && 'development' === WP_ENV ) {
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
} elseif ( defined( 'WP_ENV' ) && 'production' === WP_ENV ) {
	wp_enqueue_style( 'theme-style', get_theme_file_uri( '/dist/' . get_asset_from_manifest( 'src/js/index.js', 'style' ) ), array(), null, 'all' ); // phpcs:ignore
	wp_enqueue_script( 'theme-script', get_theme_file_uri( '/dist/' . get_asset_from_manifest( 'src/js/index.js', 'script' ) ), array( 'jquery' ), null, true ); // phpcs:ignore
}

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

function get_asset_from_manifest( string $asset, string $type ):string {
	$manifest_path = \get_theme_file_path( '/dist/manifest.json' );

	if ( empty( $asset ) || ! file_exists( $manifest_path ) ) {
		return '';
	}

	$json   = file_get_contents( $manifest_path ); //phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
	$assets = json_decode( $json, true );

	if ( empty( $assets ) || JSON_ERROR_NONE !== json_last_error() ) {
		return '';
	}

	switch ( $type ) {
		case 'style':
			$file = $assets[ $asset ]['css'][0];
			break;
		case 'script':
			$file = $assets[ $asset ]['file'];
			break;
		default:
			$file = $assets[ $asset ]['file'];
			break;
	}

	if ( empty( $file ) ) {
		return '';
	}

	return $file;
}
