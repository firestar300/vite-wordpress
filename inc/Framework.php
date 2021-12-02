<?php

namespace ViteWP\Theme;

use ViteWP\Theme\Services\Assets;
use ViteWP\Theme\Services\Assets_JS_Async;
use ViteWP\Theme\Services\Editor;
use ViteWP\Theme\Services\Editor_Patterns;
use ViteWP\Theme\Services\Menu;
use ViteWP\Theme\Services\Sidebar;
use ViteWP\Theme\Services\Svg;
use ViteWP\Theme\Services\Theme;
use ViteWP\Theme\Tools\Body_Class;
use ViteWP\Theme\Tools\Template_Parts;

/**
 * Class Framework
 * @author Milan Ricoul
 * @package ViteWP\Theme
 */
class Framework {
	/**
	 * @var Service_Container
	 */
	protected static $container;

	/**
	 * @var array $services
	 */
	protected static $services = [
		// Services
		Theme::class,
		Assets::class,
		Assets_JS_Async::class,
		Editor::class,
		Editor_Patterns::class,
		Svg::class,
		Menu::class,

		// Services as Tools
		Body_Class::class,
		Template_Parts::class,
	];

	/**
	 * @return Service_Container
	 */
	public static function get_container(): Service_Container {
		if ( is_null( self::$container ) ) {
			self::$container = new Service_Container();
			array_map( [ __CLASS__, 'register_service' ], self::$services );
		}

		return self::$container;
	}

	/**
	 * Register Service
	 *
	 * @param $name
	 */
	public static function register_service( $name ): void {
		self::get_container()->register_service( $name );
	}
}
