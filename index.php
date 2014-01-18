<?php
/*
Plugin Name: FacetWP - Cache
Plugin URI: https://facetwp.com/
Description: Caching support for FacetWP
Version: 1.0.0
Author: Matt Gibbs
Author URI: https://facetwp.com/
GitHub Plugin URI: https://github.com/mgibbs189/facetwp-cache
GitHub Branch: 1.0.0

Copyright 2014 Matt Gibbs

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, see <http://www.gnu.org/licenses/>.
*/

// exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


/*
    TODO:

    1. Settings page to customize FACETWP_CACHE_LIFETIME
    2. Settings page to clear cache
    3. Periodic cleanup with wp_schedule_event
    4. "nocache" GET param to disable cache
*/
class FWP_Cache
{

    function __construct() {
        add_action( 'init' , array( $this, 'init' ) );
    }


    /**
     * Intialize
     */
    function init() {
        add_filter( 'facetwp_ajax_response', array( $this, 'facetwp_ajax_response' ), 10, 2 );
    }


    /**
     * Cache the AJAX response
     */
    function facetwp_ajax_response( $output, $params ) {
        global $wpdb;

        $data = $params['data'];

        // Caching support
        if ( defined( 'FACETWP_CACHE' ) && FACETWP_CACHE ) {
            $cache_name = md5( json_encode( $data ) );
            $wpdb->insert( $wpdb->prefix . 'facetwp_cache', array(
                'name' => $cache_name,
                'value' => $output,
                'expire' => date( 'Y-m-d H:i:s', strtotime( '+30 minutes' ) )
            ) );
        }

        return $output;
    }
}


$fwp_cache = new FWP_Cache();
