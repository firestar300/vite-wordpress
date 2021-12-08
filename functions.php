<?php
/**
 * Load all services
 */
add_action(
	'after_setup_theme',
	function () {
		// Boot the service, at after_setup_theme.
		\ViteWP\Theme\Framework::get_container()->boot_services();
	}
);
