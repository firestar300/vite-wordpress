<?php

namespace ViteWP\Theme\Services;

use ViteWP\Theme\Service;
use ViteWP\Theme\Service_Container;
use ViteWP\Theme\Tools\Assets as Assets_Tools;
use function json_last_error;
use const JSON_ERROR_NONE;

/**
 * Class Assets
 *
 * @package ViteWP\Theme
 */
class Assets implements Service {

	/**
	 * @var \ViteWP\Theme\Tools\Assets
	 */
	private $assets_tools;

	/**
	 * @param Service_Container $container
	 */
	public function register( Service_Container $container ): void {
		$this->assets_tools = new Assets_Tools();
	}

	/**
	 * @param Service_Container $container
	 */
	public function boot( Service_Container $container ): void {
		/**
		 * Add hooks for the scripts and styles to hook on
		 */
		add_action( 'wp', [ $this, 'register_assets' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_action( 'wp_print_styles', [ $this, 'enqueue_styles' ] );
		add_filter( 'stylesheet_uri', [ $this, 'stylesheet_uri' ] );

		if ( defined( 'WP_ENV' ) && 'development' === WP_ENV ) {
			add_filter( 'script_loader_tag', [ $this, 'set_script_tag' ], 10, 3 );
		}
	}

	/**
	 * @return string
	 */
	public function get_service_name(): string {
		return 'assets';
	}

	/**
	 * Register all the Theme assets
	 */
	public function register_assets(): void {
		if ( is_admin() ) {
			return;
		}

		$theme = wp_get_theme();

		// Theme Style
		wp_register_style( 'theme-style', get_stylesheet_uri(), [], $theme->get( 'Version' ) );

		if ( defined( 'WP_ENV' ) && 'development' === WP_ENV ) {
			\wp_enqueue_script( 'ps-import-module-one-handle', 'http://localhost:3000/js/index.js', [], null, true ); //phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion
		} elseif ( defined( 'WP_ENV' ) && 'production' === WP_ENV ) {
			$this->assets_tools->register_script( 'scripts', 'dist/' . $this->get_asset_from_manifest( 'src/js/index.js', 'script' ), [ 'jquery' ], null, true );
		}
	}

	/**
	 * Enqueue the scripts
	 */
	public function enqueue_scripts(): void {
		// JS
		$this->assets_tools->enqueue_script( 'scripts' );
	}

	/**
	 * Enqueue the styles
	 */
	public function enqueue_styles(): void {
		// CSS
		$this->assets_tools->enqueue_style( 'theme-style' );
	}

	/**
	 * The stylesheet uri based on the dev or not constant
	 *
	 * @param string $stylesheet_uri
	 *
	 * @return string
	 * @author Nicolas Juen
	 */
	public function stylesheet_uri( string $stylesheet_uri ): string {
		if ( defined( 'WP_ENV' ) && 'production' === WP_ENV ) {
			$file = $this->get_asset_from_manifest( 'src/js/index.js', 'style' );

			if ( ! empty( $file ) && file_exists( \get_theme_file_path( '/dist/' . $file ) ) ) {
				return \get_theme_file_uri( '/dist/' . $file );
			}
		}

		return $stylesheet_uri;
	}

	/**
	 * Get asset path from manifest
	 *
	 * @param string $asset
	 * @param string $type
	 *
	 * @return string
	 */
	public function get_asset_from_manifest( string $asset, string $type ):string {
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

	/**
	 * Replace the script type as module
	 *
	 * @param string $tag
	 * @param string $handle
	 * @param string $src
	 *
	 * @return string
	 *
	 */
	public function set_script_tag( string $tag, string $handle, string $src ):string {
		if ( 'ps-import-module-one-handle' !== $handle ) {
			return '';
		}

		return sprintf( '<script type="module" defer src="%s"></script>', esc_url( $src ) ); //phpcs:ignore
	}
}
