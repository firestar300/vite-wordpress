<?php
namespace ViteWP\Theme;

/**
 * Interface Interface_Module
 *
 * @package ViteWP\Theme
 */
interface Interface_Module {

	/**
	 * Register the module
	 *
	 * @param Service_Container $container
	 */
	public function register( Service_Container $container );
}
