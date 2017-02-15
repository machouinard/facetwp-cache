<?php

if ( is_multisite() ) {

	//* Delay loading cache.php if multisite to allow for correct population of $table_prefix
	add_action( 'ms_loaded', 'fwp_load_cache_file' );

} else {

	//* Load cache.php
	fwp_load_cache_file();

}

/**
 * Load plugin's cache.php file
 *
 * @return void
 */
function fwp_load_cache_file() {

	if ( file_exists( WP_CONTENT_DIR . '/plugins/facetwp-cache/cache.php' ) ) {

		include( WP_CONTENT_DIR . '/plugins/facetwp-cache/cache.php' );

	}

}
