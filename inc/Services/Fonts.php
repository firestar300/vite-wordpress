<?php

namespace ViteWP\Theme\Services;

use ViteWP\Theme\Service;
use ViteWP\Theme\Service_Container;

/**
 * Class Assets
 *
 * @package ViteWP\Theme
 */
class Fonts implements Service {
	/**
	 * @param Service_Container $container
	 */
	public function register( Service_Container $container ): void {}

	/**
	 * @param Service_Container $container
	 */
	public function boot( Service_Container $container ): void {
		add_action( 'wp_head', [ $this, 'preload_fonts' ] );
	}

	/**
	 * @return string
	 */
	public function get_service_name(): string {
		return 'fonts';
	}

	/**
	 * Preload the fonts declared in font-face
	 *
	 * @author Stéphane Gillot
	 *
	 * @return void
	 */
	public function preload_fonts() {
		$format           = '<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>';
		$fonts_to_preload = $this->get_fonts_from_manifest();

		foreach ( $fonts_to_preload as $font ) {
            echo sprintf( $format, \get_theme_file_uri( 'dist/' . $font ) ); // phpcs:ignore

			// TODO: Bug with cache
			// if ( file_exists( \get_theme_file_uri( 'dist/' . $font ) ) ) {
			// 	echo sprintf( $format, \get_theme_file_uri( 'dist/' . $font ) ); // phpcs:ignore
			// }
		}
	}

	/**
	 *
	 */
	public function get_fonts_from_manifest() {
		$manifest_path = \get_theme_file_path( '/dist/manifest.json' );

		if ( ! file_exists( $manifest_path ) ) {
			return '';
		}

		$json   = file_get_contents( $manifest_path ); //phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		$assets = json_decode( $json, true );

		return $assets['src/js/main.js']['assets'];
	}
}
